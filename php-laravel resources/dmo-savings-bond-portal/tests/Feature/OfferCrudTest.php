<?php

namespace Tests\Feature;

use Tests\TestCase;

use DMO\SavingsBond\Models\Offer;
use Hasob\FoundationCore\Models\Organization;

use Illuminate\Foundation\Testing\RefreshDatabase;

class OfferCrudTest extends TestCase
{
    /**
     * Test that an Offer record can be created.
     *
     * @return void
     */
    public function test_can_create_offer()
    {
        $organization = Organization::first();

        $offerData = [
            'organization_id' => $organization->id,
            'status' => 'open',
            'offer_title' => 'FGN Savings Bond 2024',
            'price_per_unit' => 1000.00,
            'max_units_per_investor' => 50,
            'interest_rate_pct' => 12.50,
            'offer_start_date' => '2024-01-01 00:00:00',
            'offer_end_date' => '2024-03-31 00:00:00',
            'offer_settlement_date' => '2024-04-15 00:00:00',
            'offer_maturity_date' => '2026-04-15 00:00:00',
            'tenor_years' => 2,
        ];

        $offer = Offer::create($offerData);

        $this->assertNotNull($offer);
        $this->assertNotNull($offer->id);
        $this->assertEquals('FGN Savings Bond 2024', $offer->offer_title);
        $this->assertEquals('open', $offer->status);
        $this->assertEquals($organization->id, $offer->organization_id);
        $this->assertDatabaseHas('sb_offers', [
            'offer_title' => 'FGN Savings Bond 2024',
            'status' => 'open',
        ]);
    }

    /**
     * Test that Offer records can be retrieved.
     *
     * @return void
     */
    public function test_can_retrieve_offers()
    {
        $organization = Organization::first();

        // Create multiple offers
        Offer::create([
            'organization_id' => $organization->id,
            'status' => 'open',
            'offer_title' => 'Bond Offer A',
            'price_per_unit' => 1000.00,
            'max_units_per_investor' => 50,
            'interest_rate_pct' => 10.00,
            'offer_start_date' => '2024-01-01 00:00:00',
            'offer_end_date' => '2024-06-30 00:00:00',
            'offer_settlement_date' => '2024-07-15 00:00:00',
            'offer_maturity_date' => '2027-07-15 00:00:00',
            'tenor_years' => 3,
        ]);

        Offer::create([
            'organization_id' => $organization->id,
            'status' => 'closed',
            'offer_title' => 'Bond Offer B',
            'price_per_unit' => 2000.00,
            'max_units_per_investor' => 100,
            'interest_rate_pct' => 15.00,
            'offer_start_date' => '2024-02-01 00:00:00',
            'offer_end_date' => '2024-08-31 00:00:00',
            'offer_settlement_date' => '2024-09-15 00:00:00',
            'offer_maturity_date' => '2029-09-15 00:00:00',
            'tenor_years' => 5,
        ]);

        // Retrieve all offers
        $offers = Offer::all();
        $this->assertGreaterThanOrEqual(2, $offers->count());

        // Retrieve single offer by id
        $offerA = Offer::where('offer_title', 'Bond Offer A')->first();
        $this->assertNotNull($offerA);
        $this->assertEquals('Bond Offer A', $offerA->offer_title);
        $this->assertEquals('open', $offerA->status);

        // Retrieve by conditions
        $closedOffers = Offer::where('status', 'closed')->get();
        $this->assertEquals(1, $closedOffers->count());
        $this->assertEquals('Bond Offer B', $closedOffers->first()->offer_title);
    }

    /**
     * Test that an Offer record can be updated.
     *
     * @return void
     */
    public function test_can_update_offer()
    {
        $organization = Organization::first();

        $offer = Offer::create([
            'organization_id' => $organization->id,
            'status' => 'open',
            'offer_title' => 'Original Bond Title',
            'price_per_unit' => 1000.00,
            'max_units_per_investor' => 50,
            'interest_rate_pct' => 10.00,
            'offer_start_date' => '2024-01-01 00:00:00',
            'offer_end_date' => '2024-06-30 00:00:00',
            'offer_settlement_date' => '2024-07-15 00:00:00',
            'offer_maturity_date' => '2027-07-15 00:00:00',
            'tenor_years' => 3,
        ]);

        // Update the offer
        $offer->offer_title = 'Updated Bond Title';
        $offer->status = 'closed';
        $offer->price_per_unit = 1500.00;
        $offer->interest_rate_pct = 14.50;
        $offer->save();

        // Refresh from database
        $updatedOffer = Offer::find($offer->id);

        $this->assertEquals('Updated Bond Title', $updatedOffer->offer_title);
        $this->assertEquals('closed', $updatedOffer->status);
        $this->assertEquals(1500.00, $updatedOffer->price_per_unit);
        $this->assertEquals(14.50, $updatedOffer->interest_rate_pct);
        $this->assertDatabaseHas('sb_offers', [
            'id' => $offer->id,
            'offer_title' => 'Updated Bond Title',
            'status' => 'closed',
        ]);
    }

    /**
     * Test that an Offer record can be soft deleted and restored.
     *
     * @return void
     */
    public function test_can_delete_offer()
    {
        $organization = Organization::first();

        $offer = Offer::create([
            'organization_id' => $organization->id,
            'status' => 'open',
            'offer_title' => 'Bond To Delete',
            'price_per_unit' => 1000.00,
            'max_units_per_investor' => 50,
            'interest_rate_pct' => 10.00,
            'offer_start_date' => '2024-01-01 00:00:00',
            'offer_end_date' => '2024-06-30 00:00:00',
            'offer_settlement_date' => '2024-07-15 00:00:00',
            'offer_maturity_date' => '2027-07-15 00:00:00',
            'tenor_years' => 3,
        ]);

        $offerId = $offer->id;

        // Soft delete the offer
        $offer->delete();

        // Should not appear in normal queries
        $this->assertNull(Offer::find($offerId));

        // Should still exist in DB with soft delete
        $this->assertDatabaseHas('sb_offers', ['id' => $offerId]);

        // Should be retrievable with trashed
        $trashedOffer = Offer::withTrashed()->find($offerId);
        $this->assertNotNull($trashedOffer);
        $this->assertNotNull($trashedOffer->deleted_at);

        // Restore the offer
        $trashedOffer->restore();
        $restoredOffer = Offer::find($offerId);
        $this->assertNotNull($restoredOffer);
        $this->assertNull($restoredOffer->deleted_at);
    }
}
