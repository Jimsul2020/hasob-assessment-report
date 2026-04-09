

<div class="modal fade" id="mdl-offer-modal" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 id="lbl-offer-modal-title" class="modal-title">Offer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="div-offer-modal-error" class="alert alert-danger" role="alert"></div>
                <form class="form-horizontal" id="frm-offer-modal" role="form" method="POST" enctype="multipart/form-data" action="">
                    <div class="row">
                        <div class="col-lg-12 ma-10">
                            
                            @csrf
                            
                            <div class="offline-flag"><span class="offline-offers">You are currently offline</span></div>

                            <div id="spinner-offers" class="spinner-border text-primary" role="status"> 
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <input type="hidden" id="txt-offer-primary-id" value="0" />
                            <div id="div-show-txt-offer-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">                            
                                    @include('dmo-savings-bond-module::pages.offers.show_fields')
                                    </div>
                                </div>
                            </div>
                            <div id="div-edit-txt-offer-primary-id">
                                <div class="row">
                                    <div class="col-lg-10 ma-10">
                                    @include('dmo-savings-bond-module::pages.offers.fields')
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

        
            <div class="modal-footer" id="div-save-mdl-offer-modal">
                <button type="button" class="btn btn-primary" id="btn-save-mdl-offer-modal" value="add">Save</button>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.offline-offers').hide();

    // Helper: convert datetime string (e.g. "2024-01-01 00:00:00") to YYYY-MM-DD for date inputs
    function formatDateForInput(dateStr) {
        if (!dateStr) return '';
        return dateStr.substring(0, 10);
    }

    // Helper: format date string to readable format (e.g. "01 Jan 2024")
    function formatDateReadable(dateStr) {
        if (!dateStr) return 'N/A';
        var d = new Date(dateStr);
        if (isNaN(d.getTime())) return dateStr;
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var day = ('0' + d.getDate()).slice(-2);
        return day + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
    }

    // Helper: format number as currency
    function formatCurrency(val) {
        if (!val && val !== 0) return 'N/A';
        return '₦' + parseFloat(val).toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

    //Show Modal for New Entry
    $(document).on('click', ".btn-new-mdl-offer-modal", function(e) {
        $('#div-offer-modal-error').hide();
        $('#lbl-offer-modal-title').text('New Offer');
        $('#mdl-offer-modal').modal('show');
        $('#frm-offer-modal').trigger("reset");
        $('#txt-offer-primary-id').val(0);

        $('#div-show-txt-offer-primary-id').hide();
        $('#div-edit-txt-offer-primary-id').show();

        $("#spinner-offers").hide();
        $("#div-save-mdl-offer-modal").show();
    });

    //Show Modal for View
    $(document).on('click', ".btn-show-mdl-offer-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-offers').fadeIn(300);
            return;
        }else{
            $('.offline-offers').fadeOut(300);
        }

        $('#div-offer-modal-error').hide();
        $('#lbl-offer-modal-title').text('View Offer');
        $('#mdl-offer-modal').modal('show');
        $('#frm-offer-modal').trigger("reset");

        $("#spinner-offers").show();
        $("#div-save-mdl-offer-modal").hide();

        $('#div-show-txt-offer-primary-id').show();
        $('#div-edit-txt-offer-primary-id').hide();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('sb-api.offers.show','') }}/"+itemId).done(function( response ) {
			
			$('#txt-offer-primary-id').val(response.data.id);

            // Status badge
            var status = response.data.status || 'N/A';
            var badgeClass = status == 'open' ? 'bg-success' : (status == 'closed' ? 'bg-danger' : 'bg-warning');
            $('#spn_offer_status').html(status.charAt(0).toUpperCase() + status.slice(1));
            $('#spn_offer_status').removeClass('bg-success bg-danger bg-warning').addClass(badgeClass);

            $('#spn_offer_offer_title').html(response.data.offer_title || 'N/A');
            $('#spn_offer_price_per_unit').html(formatCurrency(response.data.price_per_unit));
            $('#spn_offer_max_units_per_investor').html(response.data.max_units_per_investor ? parseInt(response.data.max_units_per_investor).toLocaleString() : 'N/A');
            $('#spn_offer_interest_rate_pct').html(response.data.interest_rate_pct ? response.data.interest_rate_pct + '%' : 'N/A');
            $('#spn_offer_offer_start_date').html(formatDateReadable(response.data.offer_start_date));
            $('#spn_offer_offer_end_date').html(formatDateReadable(response.data.offer_end_date));
            $('#spn_offer_offer_settlement_date').html(formatDateReadable(response.data.offer_settlement_date));
            $('#spn_offer_offer_maturity_date').html(formatDateReadable(response.data.offer_maturity_date));
            $('#spn_offer_tenor_years').html(response.data.tenor_years ? response.data.tenor_years + (response.data.tenor_years == 1 ? ' Year' : ' Years') : 'N/A');

            $("#spinner-offers").hide();
        });
    });

    //Show Modal for Edit
    $(document).on('click', ".btn-edit-mdl-offer-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        $('#div-offer-modal-error').hide();
        $('#lbl-offer-modal-title').text('Edit Offer');
        $('#mdl-offer-modal').modal('show');
        $('#frm-offer-modal').trigger("reset");

        $("#spinner-offers").show();
        $("#div-save-mdl-offer-modal").show();

        $('#div-show-txt-offer-primary-id').hide();
        $('#div-edit-txt-offer-primary-id').show();
        let itemId = $(this).attr('data-val');

        $.get( "{{ route('sb-api.offers.show','') }}/"+itemId).done(function( response ) {     

			$('#txt-offer-primary-id').val(response.data.id);
            $('#status').val(response.data.status);
            $('#offer_title').val(response.data.offer_title);
            $('#price_per_unit').val(response.data.price_per_unit);
            $('#max_units_per_investor').val(response.data.max_units_per_investor);
            $('#interest_rate_pct').val(response.data.interest_rate_pct);
            $('#offer_start_date').val(formatDateForInput(response.data.offer_start_date));
            $('#offer_end_date').val(formatDateForInput(response.data.offer_end_date));
            $('#offer_settlement_date').val(formatDateForInput(response.data.offer_settlement_date));
            $('#offer_maturity_date').val(formatDateForInput(response.data.offer_maturity_date));
            $('#tenor_years').val(response.data.tenor_years);

            $("#spinner-offers").hide();
        });
    });

    //Delete action
    $(document).on('click', ".btn-delete-mdl-offer-modal", function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});

        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-offers').fadeIn(300);
            return;
        }else{
            $('.offline-offers').fadeOut(300);
        }

        let itemId = $(this).attr('data-val');
        swal({
                title: "Are you sure you want to delete this Offer?",
                text: "You will not be able to recover this Offer if deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {

                    let endPointUrl = "{{ route('sb-api.offers.destroy','') }}/"+itemId;

                    let formData = new FormData();
                    formData.append('_token', $('input[name="_token"]').val());
                    formData.append('_method', 'DELETE');
                    
                    $.ajax({
                        url:endPointUrl,
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData:false,
                        contentType: false,
                        dataType: 'json',
                        success: function(result){
                            if(result.errors){
                                console.log(result.errors)
                                swal("Error", "Oops an error occurred. Please try again.", "error");
                            }else{
                                swal({
                                        title: "Deleted",
                                        text: "Offer deleted successfully",
                                        type: "success",
                                        confirmButtonClass: "btn-success",
                                        confirmButtonText: "OK",
                                        closeOnConfirm: false
                                    },function(){
                                        location.reload(true);
                                });
                            }
                        },
                    });
                }
            });

    });

    //Save details
    $('#btn-save-mdl-offer-modal').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});


        //check for internet status 
        if (!window.navigator.onLine) {
            $('.offline-offers').fadeIn(300);
            return;
        }else{
            $('.offline-offers').fadeOut(300);
        }

        $("#spinner-offers").show();
        $("#div-save-mdl-offer-modal").attr('disabled', true);

        let actionType = "POST";
        let endPointUrl = "{{ route('sb-api.offers.store') }}";
        let primaryId = $('#txt-offer-primary-id').val();
        
        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());

        if (primaryId != "0"){
            actionType = "PUT";
            endPointUrl = "{{ route('sb-api.offers.update','') }}/"+primaryId;
            formData.append('id', primaryId);
        }
        
        formData.append('_method', actionType);
        @if (isset($organization) && $organization!=null)
            formData.append('organization_id', '{{$organization->id}}');
        @endif
        formData.append('status', $('#status').val());
		formData.append('offer_title', $('#offer_title').val());
		formData.append('price_per_unit', $('#price_per_unit').val());
		formData.append('max_units_per_investor', $('#max_units_per_investor').val());
		formData.append('interest_rate_pct', $('#interest_rate_pct').val());
		formData.append('offer_start_date', $('#offer_start_date').val());
		formData.append('offer_end_date', $('#offer_end_date').val());
		formData.append('offer_settlement_date', $('#offer_settlement_date').val());
		formData.append('offer_maturity_date', $('#offer_maturity_date').val());
		formData.append('tenor_years', $('#tenor_years').val());


        $.ajax({
            url:endPointUrl,
            type: "POST",
            data: formData,
            cache: false,
            processData:false,
            contentType: false,
            dataType: 'json',
            success: function(result){
                if(result.errors){
					$('#div-offer-modal-error').html('');
					$('#div-offer-modal-error').show();
                    
                    $.each(result.errors, function(key, value){
                        $('#div-offer-modal-error').append('<li class="">'+value+'</li>');
                    });
                }else{
                    $('#div-offer-modal-error').hide();
                    window.setTimeout( function(){

                        $('#div-offer-modal-error').hide();

                        swal({
                                title: "Saved",
                                text: "Offer saved successfully",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                closeOnConfirm: false
                            },function(){
                                location.reload(true);
                        });

                    },20);
                }

                $("#spinner-offers").hide();
                $("#div-save-mdl-offer-modal").attr('disabled', false);
                
            }, error: function(data){
                console.log(data);
                if (data.status === 422 && data.responseJSON && data.responseJSON.errors) {
                    $('#div-offer-modal-error').html('');
                    $('#div-offer-modal-error').show();
                    $.each(data.responseJSON.errors, function(key, value){
                        $('#div-offer-modal-error').append('<li>'+value[0]+'</li>');
                    });
                } else {
                    swal("Error", "Oops an error occurred. Please try again.", "error");
                }

                $("#spinner-offers").hide();
                $("#div-save-mdl-offer-modal").attr('disabled', false);

            }
        });
    });

});
</script>
@endpush
