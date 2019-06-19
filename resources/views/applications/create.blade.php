@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					@include('applications.includes.toolbar')
				</div>

				<div class="box-body">
					<form method="POST" action="{{ route('applications.store') }}" id="createForm" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- PERSONAL DATA --}}
                        <h2><strong>Personal Data</strong></h2>
                        <hr>
                        @include('applications.includes.personal_data')
                        
                        {{-- EDUCATIONAL BACKGROUND --}}
                        <h2><strong>Educational Background</strong></h2>
                        <hr>
                        <span class="ebCount fd-count">0</span>
                        <a class="btn btn-success" onclick="addEB()">
                            <span class="fa fa-plus"></span>
                        </a>
                        @include('applications.includes.educational_background')
                        
                        {{-- FAMILY DATA --}}
                        <h2><strong>Family Data</strong></h2>
                        <hr>
                        @include('applications.includes.family_data')

                        {{-- DOCUMENTS --}}
                        <h2><strong>Documents</strong></h2>
                        <hr>
                        @include('applications.includes.documents')
                        
                        {{-- SEA SERVICE --}}
                        <h2><strong>Sea Service</strong></h2>
                        <hr>
                        <span class="ssCount fd-count">0</span>
                        <a class="btn btn-success" onclick="addSS()">
                            <span class="fa fa-plus"></span>
                        </a>
                        @include('applications.includes.sea_service')

                        <div class="form-group row mb-0">
                            <div class="col-md-2 col-md-offset-10">
                                <a class="btn btn-primary submit pull-right">Register</a>
                            </div>
                        </div>

                    </form>
				</div>

				<div class="box-footer clearfix">
				</div>

			</div>
		</section>
	</div>

</section>
@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

    <style>
        .fd-count{
            margin-right: 10px;
        }

        .fd-count:not(:first-child){
            margin-left: 20px;
        }
    </style>
@endpush

@push('before-scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <script>
        $('[name="birthday"]').flatpickr({
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d',
            maxDate: moment().format('YYYY-MM-DD')
        });
    </script>
@endpush

@push('after-scripts')

    <script>
        // $('html, body').animate({
        //     scrollTop: $(".SpouseCount").offset().top - 50
        // }, 2000);
        $('#rank').change(() => {
            $('.docu-country').each((index, country) => {
                $(country).trigger('change');
            });
        })

        function fill(){
            let config = {
                altInput: true,
                altFormat: 'F j, Y',
                dateFormat: 'Y-m-d',
                maxDate: moment().format('YYYY-MM-DD')
            };

            $('[name="birthday"]').flatpickr(config).setDate('1997-11-12', true);
            $('[name="fd-birthday1"]').flatpickr(config).setDate('1968-03-23', true);
            $('[name="fd-birthday2"]').flatpickr(config).setDate('1961-10-16', true);
            fillSS();
        }

        function fillSS(){
            addSS();

            $('[name="vessel_name1"]').select2('open');

            setTimeout(() => {
                $('[name="vessel_name1"]').val('M/V DK INITIO').trigger('change');
                $('[name="rank1"]').val('DECK CADET').trigger('change');
                $('#sea-services input')[6].value = "30000";
                $('#sea-services input')[9].value = "Filipino";

                $('[name="sign_on1"]').flatpickr().setDate('2019-02-01', true);
                $('[name="sign_off1"]').flatpickr().setDate('2019-02-28', true);

                $('#sea-services input')[12].value = "Charterer 1";
                $('#sea-services input')[13].value = "Cargo 1, Cargo 2";
                $('#sea-services input')[14].value = "So so";
            }, 2000);

            setTimeout(() => {
                addSS();
    
                $('[name="vessel_name2"]').select2('open');
    
                $('[name="vessel_name2"]').val('M/T SM NAVIGATOR').trigger('change');
                $('[name="rank2"]').val('ABLE SEAMAN').trigger('change');
                $('#sea-services input')[21].value = "25000";
                $('#sea-services input')[24].value = "Filipino";

                $('[name="sign_on2"]').flatpickr().setDate('2019-03-01', true);
                $('[name="sign_off2"]').flatpickr().setDate('2019-03-30', true);

                $('#sea-services input')[27].value = "Charterer 2";
                $('#sea-services input')[28].value = "Cargo 3, Cargo 4";
                $('#sea-services input')[29].value = "Not So so";

                $('[name="vessel_name2"]').select2('close');
            }, 2000);

            fillEB();
        }

        function fillEB(){
            addEB();
            addEB();
            addEB();
            $('#EB .form-control')[0].value = "Elementary";
            $('#EB .form-control')[2].value = "2003";
            $('#EB .form-control')[3].value = "2009";
            $('#EB .form-control')[4].value = "HRSDC";
            $('#EB .form-control')[5].value = "Dasmarinas, Cavite";

            $('#EB .form-control')[6].value = "High School";
            $('#EB .form-control')[8].value = "2009";
            $('#EB .form-control')[9].value = "2013";
            $('#EB .form-control')[10].value = "UPHSD";
            $('#EB .form-control')[11].value = "Bacoor, Cavite";

            $('#EB .form-control')[12].value = "College";
            $('#EB .form-control')[13].value = "BSITWMA";
            $('#EB .form-control')[14].value = "2013";
            $('#EB .form-control')[15].value = "2019";
            $('#EB .form-control')[16].value = "FEU-IT";
            $('#EB .form-control')[17].value = "Sampaloc, Manila";
        }

        asd = () => {
            window.scrollTo(0,document.body.scrollHeight);
        }

        let bool;

        // VALIDATE ON SUBMIT
        $('.submit').click(() => {
            let inputs = $('.aeigh:not(".input")');

            swal('Validating');
            swal.showLoading();
            
            $.each(inputs, (index, input) => {
                let temp = $(input);
                let error = $('#' + temp.attr('name') + 'Error');
                bool = false;

                if(input.value == ""){
                    showError(input, temp, error, 'This field is required');
                }
                else if(input.type == 'email'){
                    $.ajax({
                        url: '{{ url('validate') }}',
                        data: {
                            email: input.value,
                            rules: 'email|unique:users'
                        },
                        success: result => {
                            result = JSON.parse(result);
                            if(typeof result[temp.attr('name')] != 'undefined'){
                                showError(input, temp, error, result[temp.attr('name')][0]);
                            }
                        }
                    });
                }
                else if(temp.attr('name') == 'contact'){
                    if(!/^[0-9]*$/.test(input.value)){
                        showError(input, temp, error, 'Invalid Contact Number');
                    }
                }

                !bool? clearError(input, temp, error) : '';
            });

            // IF THERE IS NO ERROR. SUBMIT.
            setTimeout(() => {
                // swal.close();
                // !$('.is-invalid').is(':visible')? $('#createForm').submit() : '';
                !$('.is-invalid').is(':visible')? compressAndSubmit() : swal.close();
            }, 1000)
        });

        function z(){
            let config = {
                altInput: true,
                altFormat: 'F j, Y',
                dateFormat: 'Y-m-d',
                maxDate: moment().format('YYYY-MM-DD')
            };

            addFD('Spouse');
            addFD('Beneficiary');

            $('[name="fd-name3"]').val('Airene Mendoza');
            $('[name="fd-birthday3"]').flatpickr(config).setDate('1999-07-26', true);
            $('[name="fd-email3"]').val("airenemendoza@gmail.com");
            $('[name="fd-address3"]').val("Malate, Manila");

            $('[name="fd-name4"]').val('Random');
            $('[name="fd-birthday4"]').flatpickr(config).setDate('1999-06-01', true);
            $('[name="fd-address4"]').val("Somewhere");
            // asd();
            fill();
        }

        function compressAndSubmit(){
            // Compress FD
            let inputs = $('#FD input');
            let fd = [];

            for(let i = 0; i < inputs.length; i+=8){
                let tempFd = {};
                tempFd.type         = inputs[i].value;
                tempFd.name         = inputs[i+1].value;
                tempFd.birthday     = inputs[i+2].value;
                tempFd.age          = inputs[i+4].value;
                tempFd.occupation   = inputs[i+5].value;
                tempFd.email      = inputs[i+6].value;
                tempFd.address      = inputs[i+7].value;
                fd.push(tempFd);

                // REMOVE THOSE ELEMENTS
                for(let j = i; j < 8; j++){
                    inputs[j].remove();
                }
            }

            $('#createForm').append(`
                <input type="hidden" name="fd" value='${JSON.stringify(fd)}'>
            `);

            // COMPRESS SS
            inputs = $('#sea-services input, #sea-services select');
            let ss = [];
            for(let i = 0; i < inputs.length; i+= 17){
                let tempSS = {};
                tempSS.vessel_name      = inputs[i].value;
                tempSS.rank             = inputs[i+1].value;
                tempSS.vessel_type      = inputs[i+2].value;
                tempSS.gross_tonnage    = inputs[i+3].value;
                tempSS.engine_type      = inputs[i+4].value;
                tempSS.bhp_kw           = inputs[i+5].value;
                tempSS.flag             = inputs[i+6].value;
                tempSS.trade            = inputs[i+7].value;
                tempSS.previous_salary  = inputs[i+8].value;
                tempSS.manning_agent    = inputs[i+9].value;
                tempSS.principal        = inputs[i+10].value;
                tempSS.crew_nationality = inputs[i+11].value;
                tempSS.sign_on          = inputs[i+12].value;
                tempSS.sign_off         = inputs[i+13].value;
                tempSS.charterer        = inputs[i+14].value;
                tempSS.cargoes          = inputs[i+15].value;
                tempSS.remarks          = inputs[i+16].value;
                tempSS.total_months     =  moment(new Date(tempSS.sign_off)).diff(new Date(tempSS.sign_on), 'months', true);;
                ss.push(tempSS);

                for(let j = i; j < 17; j++){
                    inputs[j].remove();
                }
            }

            $('#createForm').append(`
                <input type="hidden" name="ss" value='${JSON.stringify(ss)}'>
            `);

            // Compress EB
            inputs = $('#EB .form-control');
            let eb = [];

            for(let i = 0; i < inputs.length; i+=6){
                let tempEb = {};
                tempEb.type         = inputs[i].value;
                tempEb.course       = inputs[i+1].value;
                tempEb.year         = inputs[i+2].value + '-' + inputs[i+3].value;
                tempEb.school     = inputs[i+4].value;
                tempEb.address   = inputs[i+5].value;
                eb.push(tempEb);

                // REMOVE THOSE ELEMENTS
                for(let j = i; j < 6; j++){
                    inputs[j].remove();
                }
            }

            $('#createForm').append(`
                <input type="hidden" name="eb" value='${JSON.stringify(eb)}'>
            `);

            // Compress Documents

            // DOCUMENT ID
            inputs = $('#docu .ID input, #docu .ID select');
            let docu_id = [];

            for(let i = 0; i < inputs.length; i+=7){
                let tempID = {};
                tempID.type             = inputs[i].value;
                tempID.issuer           = inputs[i+1].value;
                tempID.number           = inputs[i+2].value;
                tempID.issue_date       = inputs[i+3].value;
                tempID.expiry_date      = inputs[i+5].value;
                docu_id.push(tempID);

                // REMOVE THOSE ELEMENTS
                for(let j = i; j < 7; j++){
                    inputs[j].remove();
                }
            }

            $('#createForm').append(`
                <input type="hidden" name="docu_id" value='${JSON.stringify(docu_id)}'>
            `);

            // DOCUMENT FLAG
            inputs = $('#docu .Flag input, #docu .Flag select');
            let docu_flag = [];

            for(let i = 0; i < inputs.length; i+=8){
                let tempFlag = {};
                tempFlag.country    = inputs[i].value;
                tempFlag.booklet_no = inputs[i+1].value;
                tempFlag.license_no = inputs[i+2].value;
                tempFlag.goc        = inputs[i+3].value;
                tempFlag.sso        = inputs[i+4].value;
                tempFlag.sdsd       = inputs[i+5].value;
                tempFlag.issue_date = inputs[i+6].value;
                tempFlag.expiry_date= inputs[i+7].value;
                docu_flag.push(tempFlag);

                // REMOVE THOSE ELEMENTS
                for(let j = i; j < 8; j++){
                    inputs[j].remove();
                }
            }

            $('#createForm').append(`
                <input type="hidden" name="docu_flag" value='${JSON.stringify(docu_flag)}'>
            `);

            // License/Certificates/Contracts
            inputs = $('#docu .lc input, #docu .lc select');
            let docu_lc = [];

            for(let i = 0; i < inputs.length; i+=7){
                let tempLc = {};
                tempLc.type         = inputs[i].value
                tempLc.issuer       = inputs[i+1].value;
                tempLc.no           = inputs[i+2].value;
                tempLc.issue_date   = inputs[i+3].value;
                tempLc.expiry_date  = inputs[i+5].value;
                docu_lc.push(tempLc);

                // REMOVE THOSE ELEMENTS
                for(let j = i; j < 7; j++){
                    inputs[j].remove();
                }
            }

            $('#createForm').append(`
                <input type="hidden" name="docu_lc" value='${JSON.stringify(docu_lc)}'>
            `);

            swal.close();
            $('#createForm').submit();
        }

        function showError(input, temp, error, message){
            // await new Promise(resolve => setTimeout(resolve, 1000));

            bool = true;

            if(input.type != 'hidden'){
                temp.addClass('is-invalid');
            }
            else{
                temp.addClass('is-invalid');
                temp.next().addClass('is-invalid');
            }

            // DISPLAY ERROR MESSAGE
            error.text(message);
            error.parent().removeClass('hidden');
        }

        function clearError(input, temp, error){
            // await new Promise(resolve => setTimeout(resolve, 1000));

            if($(input).hasClass('is-invalid')){
                if(input.type != 'hidden'){
                    temp.removeClass('is-invalid');
                }
                else{
                    temp.removeClass('is-invalid');
                    temp.next().removeClass('is-invalid');
                }

                // REMOVE ERROR MESSAGE IF VISIBLE
                if(error.parent().is(':visible')){
                    error.parent().addClass('hidden');
                }
            }
        }

        $('[name="avatar"]').on('change', () => {
            if(!$('#preview').is(':visible'))
            {
                $('#preview').fadeIn();
            }

            var fr = new FileReader();
            fr.readAsDataURL(document.getElementsByName("avatar")[0].files[0]);

            fr.onload = function (e) {
                document.getElementById("preview").src = e.target.result;
            };
        });
    </script>
@endpush