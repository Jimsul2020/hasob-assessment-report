@extends('layouts.app')

@section('app_css')
@stop

@section('title_postfix')
Offer Details
@stop

@section('page_title')
Offer Details
@stop

@section('page_title_subtext')
    <a class="ml-10 mb-10" href="{{ route('sb.offers.index') }}" style="font-size:11px;color:blue;">
        <i class="fa fa-angle-double-left"></i> Back to Offer List
    </a>
@stop

@section('page_title_buttons')
    <a data-toggle="tooltip" 
        title="Edit" 
        data-val='{{$offer->id}}' 
        class="btn btn-warning btn-edit-mdl-offer-modal" href="#">
        <i class="bx bxs-edit"></i> Edit
    </a>

    <a data-toggle="tooltip" 
        title="Delete" 
        data-val='{{$offer->id}}' 
        class="btn btn-danger btn-delete-mdl-offer-modal" href="#">
        <i class="bx bxs-trash-alt"></i> Delete
    </a>
@stop


@section('content')
    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            <div class="card-title d-flex align-items-center">
                <div>
                    <i class="bx bxs-offer me-1 font-22 text-primary"></i>
                </div>
                <h5 class="mb-0 text-primary">{{ $offer->offer_title }}</h5>
                <div class="ms-auto">
                    <span class="badge {{ $offer->status == 'open' ? 'bg-success' : ($offer->status == 'closed' ? 'bg-danger' : 'bg-warning') }}">
                        {{ ucfirst($offer->status) }}
                    </span>
                </div>
            </div>
            <hr />
            
            @include('dmo-savings-bond-module::pages.offers.show_fields')
            
        </div>
    </div>

    {{-- Related Subscriptions --}}
    <div class="card border-top border-0 border-4 border-info mt-3">
        <div class="card-body">
            <div class="card-title d-flex align-items-center">
                <div>
                    <i class="bx bxs-receipt me-1 font-22 text-info"></i>
                </div>
                <h5 class="mb-0 text-info">Subscriptions</h5>
            </div>
            <hr />

            @if(isset($offer) && $offer->subscriptions && $offer->subscriptions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Investor</th>
                                <th>Email</th>
                                <th>Units Requested</th>
                                <th>Price Per Unit</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offer->subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->first_name }} {{ $subscription->middle_name }} {{ $subscription->last_name }}</td>
                                <td>{{ $subscription->investor_email }}</td>
                                <td>{{ number_format($subscription->units_requested) }}</td>
                                <td>₦{{ number_format($subscription->price_per_unit, 2) }}</td>
                                <td>₦{{ number_format($subscription->total_price, 2) }}</td>
                                <td>
                                    <span class="badge {{ $subscription->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($subscription->status) }}
                                    </span>
                                </td>
                                <td>{{ $subscription->created_at ? \Carbon\Carbon::parse($subscription->created_at)->format('d M Y') : 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">No subscriptions found for this offer.</p>
            @endif
        </div>
    </div>

    {{-- Related Bids --}}
    <div class="card border-top border-0 border-4 border-warning mt-3">
        <div class="card-body">
            <div class="card-title d-flex align-items-center">
                <div>
                    <i class="bx bxs-bar-chart-alt-2 me-1 font-22 text-warning"></i>
                </div>
                <h5 class="mb-0 text-warning">Bids</h5>
            </div>
            <hr />

            @if(isset($offer) && $offer->bids && $offer->bids->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Bid ID</th>
                                <th>Units Requested</th>
                                <th>Price Per Unit</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offer->bids as $bid)
                            <tr>
                                <td>{{ $bid->id }}</td>
                                <td>{{ number_format($bid->units_requested) }}</td>
                                <td>₦{{ number_format($bid->price_per_unit, 2) }}</td>
                                <td>₦{{ number_format($bid->total_price, 2) }}</td>
                                <td>
                                    <span class="badge {{ $bid->status == 'accepted' ? 'bg-success' : ($bid->status == 'pending' ? 'bg-warning' : 'bg-secondary') }}">
                                        {{ ucfirst($bid->status) }}
                                    </span>
                                </td>
                                <td>{{ $bid->created_at ? \Carbon\Carbon::parse($bid->created_at)->format('d M Y') : 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">No bids found for this offer.</p>
            @endif
        </div>
    </div>

    @include('dmo-savings-bond-module::pages.offers.modal')
@stop

@section('side-panel')
<div class="card radius-5 border-top border-0 border-4 border-primary">
    <div class="card-body">
        <div><h5 class="card-title">Offer Summary</h5></div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between">
                <span>Price Per Unit</span>
                <strong>₦{{ number_format($offer->price_per_unit, 2) }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Interest Rate</span>
                <strong>{{ $offer->interest_rate_pct }}%</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Max Units</span>
                <strong>{{ number_format($offer->max_units_per_investor) }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Tenor</span>
                <strong>{{ $offer->tenor_years }} {{ $offer->tenor_years == 1 ? 'Year' : 'Years' }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Subscriptions</span>
                <strong>{{ $offer->subscriptions ? $offer->subscriptions->count() : 0 }}</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Bids</span>
                <strong>{{ $offer->bids ? $offer->bids->count() : 0 }}</strong>
            </li>
        </ul>
    </div>
</div>
@stop

@push('page_scripts')
@endpush