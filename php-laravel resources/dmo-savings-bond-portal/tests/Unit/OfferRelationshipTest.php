<?php

namespace Tests\Unit;

use Tests\TestCase;

use DMO\SavingsBond\Models\Offer;
use DMO\SavingsBond\Models\Subscription;
use DMO\SavingsBond\Models\Bid;
use Hasob\FoundationCore\Models\Organization;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferRelationshipTest extends TestCase
{
    /**
     * Test that the Offer model has a subscriptions() hasMany relationship.
     *
     * @return void
     */
    public function test_offer_has_many_subscriptions()
    {
        $organization = Organization::first();

        $offer = Offer::create([
            'organization_id' => $organization->id,
            'status' => 'open',
            'offer_title' => 'Test Bond Offer',
            'price_per_unit' => 1000.00,
            'max_units_per_investor' => 50,
            'interest_rate_pct' => 10.00,
            'offer_start_date' => '2024-01-01 00:00:00',
            'offer_end_date' => '2024-06-30 00:00:00',
            'offer_settlement_date' => '2024-07-15 00:00:00',
            'offer_maturity_date' => '2027-07-15 00:00:00',
            'tenor_years' => 3,
        ]);

        // Assert that the relationship method exists and returns HasMany
        $this->assertInstanceOf(HasMany::class, $offer->subscriptions());

        // Assert that the returned collection is initially empty
        $this->assertCount(0, $offer->subscriptions);
    }

    /**
     * Test that the Offer model has a bids() hasMany relationship.
     *
     * @return void
     */
    public function test_offer_has_many_bids()
    {
        $organization = Organization::first();

        $offer = Offer::create([
            'organization_id' => $organization->id,
            'status' => 'open',
            'offer_title' => 'Test Bond Offer',
            'price_per_unit' => 1000.00,
            'max_units_per_investor' => 50,
            'interest_rate_pct' => 10.00,
            'offer_start_date' => '2024-01-01 00:00:00',
            'offer_end_date' => '2024-06-30 00:00:00',
            'offer_settlement_date' => '2024-07-15 00:00:00',
            'offer_maturity_date' => '2027-07-15 00:00:00',
            'tenor_years' => 3,
        ]);

        // Assert that the relationship method exists and returns HasMany
        $this->assertInstanceOf(HasMany::class, $offer->bids());

        // Assert that the returned collection is initially empty
        $this->assertCount(0, $offer->bids);
    }

    /**
     * Test that the Offer model has an organization() belongsTo relationship.
     *
     * @return void
     */
    public function test_offer_belongs_to_organization()
    {
        $organization = Organization::first();

        $offer = Offer::create([
            'organization_id' => $organization->id,
            'status' => 'open',
            'offer_title' => 'Test Bond Offer',
            'price_per_unit' => 1000.00,
            'max_units_per_investor' => 50,
            'interest_rate_pct' => 10.00,
            'offer_start_date' => '2024-01-01 00:00:00',
            'offer_end_date' => '2024-06-30 00:00:00',
            'offer_settlement_date' => '2024-07-15 00:00:00',
            'offer_maturity_date' => '2027-07-15 00:00:00',
            'tenor_years' => 3,
        ]);

        // Assert that the relationship method exists and returns BelongsTo
        $this->assertInstanceOf(BelongsTo::class, $offer->organization());

        // Assert that the related organization is correct
        $relatedOrg = $offer->organization;
        $this->assertNotNull($relatedOrg);
        $this->assertEquals($organization->id, $relatedOrg->id);
    }
}
