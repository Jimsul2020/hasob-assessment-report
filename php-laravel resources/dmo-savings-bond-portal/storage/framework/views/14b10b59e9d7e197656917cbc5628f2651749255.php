<div class="row mb-3">
    <!-- Offer Title Field -->
    <div id="div-offer_title" class="col-md-8">
        <label for="offer_title" class="form-label">Offer Title <span class="text-danger">*</span></label>
        <?php echo Form::text('offer_title', null, ['id'=>'offer_title', 'class' => 'form-control', 'placeholder' => 'e.g. FGN Savings Bond March 2026']); ?>

    </div>

    <!-- Status Field -->
    <div id="div-status" class="col-md-4">
        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
        <?php echo Form::select('status', ['open' => 'Open', 'closed' => 'Closed', 'pending' => 'Pending'], null, ['id'=>'status', 'class' => 'form-select']); ?>

    </div>
</div>

<h6 class="text-primary mt-4 mb-3 border-bottom pb-2">Financial Details</h6>
<div class="row mb-3">
    <!-- Price Per Unit Field -->
    <div id="div-price_per_unit" class="col-md-4">
        <label for="price_per_unit" class="form-label">Price Per Unit</label>
        <div class="input-group">
            <span class="input-group-text">₦</span>
            <?php echo Form::number('price_per_unit', null, ['id'=>'price_per_unit', 'class' => 'form-control', 'min' => 0, 'step' => '0.01']); ?>

        </div>
    </div>

    <!-- Interest Rate Pct Field -->
    <div id="div-interest_rate_pct" class="col-md-4">
        <label for="interest_rate_pct" class="form-label">Interest Rate</label>
        <div class="input-group">
            <?php echo Form::number('interest_rate_pct', null, ['id'=>'interest_rate_pct', 'class' => 'form-control', 'min' => 0, 'max' => 100, 'step' => '0.01']); ?>

            <span class="input-group-text">%</span>
        </div>
    </div>

    <!-- Max Units Per Investor Field -->
    <div id="div-max_units_per_investor" class="col-md-4">
        <label for="max_units_per_investor" class="form-label">Max Units</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-hash"></i></span>
            <?php echo Form::number('max_units_per_investor', null, ['id'=>'max_units_per_investor', 'class' => 'form-control', 'min' => 1]); ?>

        </div>
    </div>
</div>

<h6 class="text-primary mt-4 mb-3 border-bottom pb-2">Offer Timeline</h6>
<div class="row mb-3">
    <!-- Offer Start Date Field -->
    <div id="div-offer_start_date" class="col-md-6 mb-3">
        <label for="offer_start_date" class="form-label">Start Date</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
            <?php echo Form::date('offer_start_date', null, ['id'=>'offer_start_date', 'class' => 'form-control']); ?>

        </div>
    </div>

    <!-- Offer End Date Field -->
    <div id="div-offer_end_date" class="col-md-6 mb-3">
        <label for="offer_end_date" class="form-label">End Date</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
            <?php echo Form::date('offer_end_date', null, ['id'=>'offer_end_date', 'class' => 'form-control']); ?>

        </div>
    </div>

    <!-- Offer Settlement Date Field -->
    <div id="div-offer_settlement_date" class="col-md-4">
        <label for="offer_settlement_date" class="form-label">Settlement Date</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-calendar-check"></i></span>
            <?php echo Form::date('offer_settlement_date', null, ['id'=>'offer_settlement_date', 'class' => 'form-control']); ?>

        </div>
    </div>

    <!-- Offer Maturity Date Field -->
    <div id="div-offer_maturity_date" class="col-md-4">
        <label for="offer_maturity_date" class="form-label">Maturity Date</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-calendar-star"></i></span>
            <?php echo Form::date('offer_maturity_date', null, ['id'=>'offer_maturity_date', 'class' => 'form-control']); ?>

        </div>
    </div>

    <!-- Tenor Years Field -->
    <div id="div-tenor_years" class="col-md-4">
        <label for="tenor_years" class="form-label">Tenor (Years)</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-time"></i></span>
            <?php echo Form::number('tenor_years', null, ['id'=>'tenor_years', 'class' => 'form-control', 'min' => 1]); ?>

        </div>
    </div>
</div><?php /**PATH C:\Users\EliteBook 830 G6\Desktop\Projects\Backend-assessment-test\php-laravel resources\dmo-savings-bond-module\src/../resources/views/pages/offers/fields.blade.php ENDPATH**/ ?>