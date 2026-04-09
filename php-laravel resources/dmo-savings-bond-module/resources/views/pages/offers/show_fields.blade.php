<!-- Offer Title & Status Header -->
<div class="d-flex align-items-center mb-3">
    <div class="flex-grow-1">
        <h5 class="mb-0 text-primary" id="spn_offer_offer_title">
            @if (isset($offer->offer_title) && empty($offer->offer_title)==false)
                {!! $offer->offer_title !!}
            @else
                N/A
            @endif
        </h5>
    </div>
    <div class="ms-2">
        <span id="spn_offer_status" class="badge bg-{{ isset($offer->status) && $offer->status == 'open' ? 'success' : (isset($offer->status) && $offer->status == 'closed' ? 'danger' : 'warning') }} px-3 py-2" style="font-size: 0.85rem;">
            @if (isset($offer->status) && empty($offer->status)==false)
                {{ ucfirst($offer->status) }}
            @else
                N/A
            @endif
        </span>
    </div>
</div>

<hr class="mt-0 mb-3">

<!-- Financial Details -->
<h6 class="text-primary mb-3 border-bottom pb-2">
    <i class="bx bx-money me-1"></i>Financial Details
</h6>
<div class="row mb-3">
    <div class="col-md-4 mb-2">
        <div class="border rounded p-3 h-100 text-center bg-light">
            <small class="text-muted d-block mb-1">Price Per Unit</small>
            <h5 class="mb-0 text-dark" id="spn_offer_price_per_unit">
                @if (isset($offer->price_per_unit) && empty($offer->price_per_unit)==false)
                    ₦{{ number_format($offer->price_per_unit, 2) }}
                @else
                    N/A
                @endif
            </h5>
        </div>
    </div>
    <div class="col-md-4 mb-2">
        <div class="border rounded p-3 h-100 text-center bg-light">
            <small class="text-muted d-block mb-1">Interest Rate</small>
            <h5 class="mb-0 text-dark" id="spn_offer_interest_rate_pct">
                @if (isset($offer->interest_rate_pct) && empty($offer->interest_rate_pct)==false)
                    {{ $offer->interest_rate_pct }}%
                @else
                    N/A
                @endif
            </h5>
        </div>
    </div>
    <div class="col-md-4 mb-2">
        <div class="border rounded p-3 h-100 text-center bg-light">
            <small class="text-muted d-block mb-1">Max Units Per Investor</small>
            <h5 class="mb-0 text-dark" id="spn_offer_max_units_per_investor">
                @if (isset($offer->max_units_per_investor) && empty($offer->max_units_per_investor)==false)
                    {{ number_format($offer->max_units_per_investor) }}
                @else
                    N/A
                @endif
            </h5>
        </div>
    </div>
</div>

<!-- Offer Timeline -->
<h6 class="text-primary mb-3 border-bottom pb-2">
    <i class="bx bx-calendar me-1"></i>Offer Timeline
</h6>
<div class="row mb-3">
    <div class="col-md-6 mb-2">
        <div class="border rounded p-3 h-100 bg-light">
            <div class="d-flex align-items-center mb-1">
                <i class="bx bx-calendar text-success me-2"></i>
                <small class="text-muted">Start Date</small>
            </div>
            <strong id="spn_offer_offer_start_date">
                @if (isset($offer->offer_start_date) && empty($offer->offer_start_date)==false)
                    {{ \Carbon\Carbon::parse($offer->offer_start_date)->format('d M Y') }}
                @else
                    N/A
                @endif
            </strong>
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <div class="border rounded p-3 h-100 bg-light">
            <div class="d-flex align-items-center mb-1">
                <i class="bx bx-calendar text-danger me-2"></i>
                <small class="text-muted">End Date</small>
            </div>
            <strong id="spn_offer_offer_end_date">
                @if (isset($offer->offer_end_date) && empty($offer->offer_end_date)==false)
                    {{ \Carbon\Carbon::parse($offer->offer_end_date)->format('d M Y') }}
                @else
                    N/A
                @endif
            </strong>
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <div class="border rounded p-3 h-100 bg-light">
            <div class="d-flex align-items-center mb-1">
                <i class="bx bx-calendar-check text-info me-2"></i>
                <small class="text-muted">Settlement Date</small>
            </div>
            <strong id="spn_offer_offer_settlement_date">
                @if (isset($offer->offer_settlement_date) && empty($offer->offer_settlement_date)==false)
                    {{ \Carbon\Carbon::parse($offer->offer_settlement_date)->format('d M Y') }}
                @else
                    N/A
                @endif
            </strong>
        </div>
    </div>
    <div class="col-md-6 mb-2">
        <div class="border rounded p-3 h-100 bg-light">
            <div class="d-flex align-items-center mb-1">
                <i class="bx bx-calendar-star text-warning me-2"></i>
                <small class="text-muted">Maturity Date</small>
            </div>
            <strong id="spn_offer_offer_maturity_date">
                @if (isset($offer->offer_maturity_date) && empty($offer->offer_maturity_date)==false)
                    {{ \Carbon\Carbon::parse($offer->offer_maturity_date)->format('d M Y') }}
                @else
                    N/A
                @endif
            </strong>
        </div>
    </div>
</div>

<!-- Tenor -->
<div class="row mb-2">
    <div class="col-md-6">
        <div class="border rounded p-3 bg-light">
            <div class="d-flex align-items-center mb-1">
                <i class="bx bx-time text-primary me-2"></i>
                <small class="text-muted">Tenor</small>
            </div>
            <strong id="spn_offer_tenor_years">
                @if (isset($offer->tenor_years) && empty($offer->tenor_years)==false)
                    {{ $offer->tenor_years }} {{ $offer->tenor_years == 1 ? 'Year' : 'Years' }}
                @else
                    N/A
                @endif
            </strong>
        </div>
    </div>
</div>
