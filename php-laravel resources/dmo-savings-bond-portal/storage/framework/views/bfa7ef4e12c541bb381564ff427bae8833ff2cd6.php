<div class="card shadow-sm border mb-4 rounded" style="transition: all 0.3s ease; border-color: #e9ecef;">
    <div class="card-body p-4">
        <?php
            $detail_page_url = route('sb.offers.show', $data_item->id);

            // Badge color logic
            $statusColor = 'secondary';
            if ($data_item->status == 'open') {
                $statusColor = 'success';
            } elseif ($data_item->status == 'closed') {
                $statusColor = 'danger';
            } elseif ($data_item->status == 'pending') {
                $statusColor = 'warning';
            }
        ?>

        <!-- Header: Title and Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <div>
                <div class="d-flex align-items-center">
                    <h4 class="card-title fw-bold text-primary mb-0" style="font-size: 1.25rem;">
                        <a href='<?php echo e($detail_page_url); ?>' class="text-decoration-none"><?php echo e($data_item->offer_title); ?></a>
                    </h4>
                    <span class="badge bg-<?php echo e($statusColor); ?> ms-3 px-3 py-1"
                        style="font-size: 0.8rem; letter-spacing: 0.5px;">
                        <?php echo e(ucfirst($data_item->status)); ?>

                    </span>
                </div>
                <p class="text-muted mb-0 mt-1" style="font-size: 0.85rem;">
                    Created <?php echo e(\Carbon\Carbon::parse($data_item->created_at)->format('l, jS M Y')); ?>

                    (<?php echo \Carbon\Carbon::parse($data_item->created_at)->diffForHumans(); ?>)
                </p>
            </div>

            <!-- Action buttons -->
            <div class="d-flex">
                <a data-toggle="tooltip" title="View" data-val='<?php echo e($data_item->id); ?>'
                    class="btn btn-outline-primary btn-sm btn-show-mdl-offer-modal d-flex align-items-center justify-content-center me-2"
                    href="#" style="width: 36px; height: 36px; border-radius: 50%;">
                    <i class="bx bxs-show fs-5"></i>
                </a>
                <a data-toggle="tooltip" title="Edit" data-val='<?php echo e($data_item->id); ?>'
                    class="btn btn-outline-warning btn-sm btn-edit-mdl-offer-modal d-flex align-items-center justify-content-center me-2"
                    href="#" style="width: 36px; height: 36px; border-radius: 50%;">
                    <i class="bx bxs-edit fs-5"></i>
                </a>
                <a data-toggle="tooltip" title="Delete" data-val='<?php echo e($data_item->id); ?>'
                    class="btn btn-outline-danger btn-sm btn-delete-mdl-offer-modal d-flex align-items-center justify-content-center"
                    href="#" style="width: 36px; height: 36px; border-radius: 50%;">
                    <i class="bx bxs-trash-alt fs-5"></i>
                </a>
            </div>
        </div>

        <!-- Key Financials Grid -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="p-3 bg-light rounded h-100 text-center" style="border: 1px solid #f0f0f0;">
                    <div class="text-muted mb-1 d-flex justify-content-center align-items-center"
                        style="font-size: 0.8rem; font-weight: 600;">
                        <i class="bx bx-purchase-tag me-1 text-primary"></i>Price Per Unit
                    </div>
                    <h5 class="mb-0 fw-bold text-dark">₦<?php echo e(number_format($data_item->price_per_unit, 2)); ?></h5>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 bg-light rounded h-100 text-center" style="border: 1px solid #f0f0f0;">
                    <div class="text-muted mb-1 d-flex justify-content-center align-items-center"
                        style="font-size: 0.8rem; font-weight: 600;">
                        <i class="bx bx-trending-up me-1 text-success"></i>Interest Rate
                    </div>
                    <h5 class="mb-0 fw-bold text-dark"><?php echo e($data_item->interest_rate_pct); ?>%</h5>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 bg-light rounded h-100 text-center" style="border: 1px solid #f0f0f0;">
                    <div class="text-muted mb-1 d-flex justify-content-center align-items-center"
                        style="font-size: 0.8rem; font-weight: 600;">
                        <i class="bx bx-hash me-1 text-info"></i>Max Units
                    </div>
                    <h5 class="mb-0 fw-bold text-dark"><?php echo e(number_format($data_item->max_units_per_investor)); ?></h5>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 bg-light rounded h-100 text-center" style="border: 1px solid #f0f0f0;">
                    <div class="text-muted mb-1 d-flex justify-content-center align-items-center"
                        style="font-size: 0.8rem; font-weight: 600;">
                        <i class="bx bx-time-five me-1 text-warning"></i>Tenor
                    </div>
                    <h5 class="mb-0 fw-bold text-dark"><?php echo e($data_item->tenor_years); ?>

                        <?php echo e($data_item->tenor_years == 1 ? 'Year' : 'Years'); ?></h5>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3 bg-light rounded h-100 text-center" style="border: 1px solid #f0f0f0;">
                    <div class="text-muted mb-1 d-flex justify-content-center align-items-center"
                        style="font-size: 0.8rem; font-weight: 600;">
                        <i class="bx bx-time-five me-1 text-warning"></i>Duration
                    </div>
                    <h5 class="mb-0 fw-bold text-dark"><?php echo e($data_item->duration); ?></h5>
                </div>
            </div>
        </div>

        <!-- Timeline Section -->
        <div class="p-3 rounded" style="background-color: #f8f9fa;">
            <div class="row text-center text-md-start g-3 align-items-center">
                <div class="col-6 col-md-3">
                    <small class="text-muted d-block mb-1 text-uppercase"
                        style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Start Date</small>
                    <span class="text-dark d-flex align-items-center justify-content-center justify-content-md-start"
                        style="font-weight: 500; font-size: 0.9rem;">
                        <i class="bx text-success bx-calendar me-2 fs-5"></i>
                        <?php echo e($data_item->offer_start_date ? \Carbon\Carbon::parse($data_item->offer_start_date)->format('d M Y') : 'N/A'); ?>

                    </span>
                </div>
                <div class="col-6 col-md-3 border-start" style="border-color: #e9ecef !important;">
                    <small class="text-muted d-block mb-1 text-uppercase"
                        style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">End Date</small>
                    <span class="text-dark d-flex align-items-center justify-content-center justify-content-md-start"
                        style="font-weight: 500; font-size: 0.9rem;">
                        <i class="bx text-danger bx-calendar-x me-2 fs-5"></i>
                        <?php echo e($data_item->offer_end_date ? \Carbon\Carbon::parse($data_item->offer_end_date)->format('d M Y') : 'N/A'); ?>

                    </span>
                </div>
                <div class="col-6 col-md-3 border-start" style="border-color: #e9ecef !important;">
                    <small class="text-muted d-block mb-1 text-uppercase"
                        style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Settlement</small>
                    <span class="text-dark d-flex align-items-center justify-content-center justify-content-md-start"
                        style="font-weight: 500; font-size: 0.9rem;">
                        <i class="bx text-primary bx-calendar-check me-2 fs-5"></i>
                        <?php echo e($data_item->offer_settlement_date ? \Carbon\Carbon::parse($data_item->offer_settlement_date)->format('d M Y') : 'N/A'); ?>

                    </span>
                </div>
                <div class="col-6 col-md-3 border-start" style="border-color: #e9ecef !important;">
                    <small class="text-muted d-block mb-1 text-uppercase"
                        style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Maturity</small>
                    <span class="text-dark d-flex align-items-center justify-content-center justify-content-md-start"
                        style="font-weight: 500; font-size: 0.9rem;">
                        <i class="bx text-warning bx-calendar-star me-2 fs-5"></i>
                        <?php echo e($data_item->offer_maturity_date ? \Carbon\Carbon::parse($data_item->offer_maturity_date)->format('d M Y') : 'N/A'); ?>

                    </span>
                </div>
            </div>
        </div>

    </div>
</div>
<?php /**PATH C:\Users\EliteBook 830 G6\Desktop\Projects\Backend-assessment-test\php-laravel resources\dmo-savings-bond-module\src/../resources/views/pages/offers/card_view_item.blade.php ENDPATH**/ ?>