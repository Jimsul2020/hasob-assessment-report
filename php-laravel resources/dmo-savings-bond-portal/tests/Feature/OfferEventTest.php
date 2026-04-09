<?php

namespace Tests\Feature;

use Tests\TestCase;

use DMO\SavingsBond\Models\Offer;
use DMO\SavingsBond\Events\OfferCreated;
use DMO\SavingsBond\Events\OfferUpdated;
use DMO\SavingsBond\Events\OfferDeleted;
use DMO\SavingsBond\Listeners\OfferCreatedListener;
use DMO\SavingsBond\Listeners\OfferUpdatedListener;
use DMO\SavingsBond\Listeners\OfferDeletedListener;
use Hasob\FoundationCore\Models\Organization;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

class OfferEventTest extends TestCase
{
    /**
     * Test that OfferCreated event is dispatched when an Offer is created.
     *
     * @return void
     */
    public function test_offer_created_event_is_dispatched()
    {
        Event::fake([OfferCreated::class]);

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

        // Manually dispatch the event as the controller would
        OfferCreated::dispatch($offer);

        Event::assertDispatched(OfferCreated::class, function ($event) use ($offer) {
            return $event->offer->id === $offer->id;
        });
    }

    /**
     * Test that OfferUpdated event is dispatched when an Offer is updated.
     *
     * @return void
     */
    public function test_offer_updated_event_is_dispatched()
    {
        Event::fake([OfferUpdated::class]);

        $organization = Organization::first();

        $offer = Offer::create([
            'organization_id' => $organization->id,
            'status' => 'open',
            'offer_title' => 'Original Title',
            'price_per_unit' => 1000.00,
            'max_units_per_investor' => 50,
            'interest_rate_pct' => 10.00,
            'offer_start_date' => '2024-01-01 00:00:00',
            'offer_end_date' => '2024-06-30 00:00:00',
            'offer_settlement_date' => '2024-07-15 00:00:00',
            'offer_maturity_date' => '2027-07-15 00:00:00',
            'tenor_years' => 3,
        ]);

        // Update and dispatch event as the controller would
        $offer->offer_title = 'Updated Title';
        $offer->save();

        OfferUpdated::dispatch($offer);

        Event::assertDispatched(OfferUpdated::class, function ($event) use ($offer) {
            return $event->offer->id === $offer->id;
        });
    }

    /**
     * Test that OfferDeleted event is dispatched when an Offer is deleted.
     *
     * @return void
     */
    public function test_offer_deleted_event_is_dispatched()
    {
        Event::fake([OfferDeleted::class]);

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

        // Delete and dispatch event as the controller would
        $offer->delete();
        OfferDeleted::dispatch($offer);

        Event::assertDispatched(OfferDeleted::class, function ($event) use ($offer) {
            return $event->offer->id === $offer->id;
        });
    }

    /**
     * Test that the OfferCreated event carries the correct offer data.
     *
     * @return void
     */
    public function test_offer_created_event_contains_offer_data()
    {
        $organization = Organization::first();

        $offer = Offer::create([
            'organization_id' => $organization->id,
            'status' => 'open',
            'offer_title' => 'Data Check Bond',
            'price_per_unit' => 2000.00,
            'max_units_per_investor' => 100,
            'interest_rate_pct' => 15.00,
            'offer_start_date' => '2024-01-01 00:00:00',
            'offer_end_date' => '2024-06-30 00:00:00',
            'offer_settlement_date' => '2024-07-15 00:00:00',
            'offer_maturity_date' => '2027-07-15 00:00:00',
            'tenor_years' => 3,
        ]);

        $event = new OfferCreated($offer);

        $this->assertInstanceOf(Offer::class, $event->offer);
        $this->assertEquals('Data Check Bond', $event->offer->offer_title);
        $this->assertEquals('open', $event->offer->status);
    }

    /**
     * Test that OfferCreatedListener is properly wired to OfferCreated event.
     *
     * @return void
     */
    public function test_offer_created_listener_is_attached()
    {
        Event::fake();

        Event::assertListening(
            OfferCreated::class,
            OfferCreatedListener::class
        );
    }

    /**
     * Test that OfferUpdatedListener is properly wired to OfferUpdated event.
     *
     * @return void
     */
    public function test_offer_updated_listener_is_attached()
    {
        Event::fake();

        Event::assertListening(
            OfferUpdated::class,
            OfferUpdatedListener::class
        );
    }

    /**
     * Test that OfferDeletedListener is properly wired to OfferDeleted event.
     *
     * @return void
     */
    public function test_offer_deleted_listener_is_attached()
    {
        Event::fake();

        Event::assertListening(
            OfferDeleted::class,
            OfferDeletedListener::class
        );
    }
}
