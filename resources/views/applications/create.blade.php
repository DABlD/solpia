@extends('layouts.app')
@section('content')

<div class="scroller">
    <span class="fa fa-arrow-down fa-2x arrow"></span>
</div>

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					@include('applications.includes.toolbar')
				</div>

				<div class="box-body">
					<form method="POST" action="{{ !isset($edit) ? route('applications.store') : route('applications.update') }}" id="createForm" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- PERSONAL DATA --}}
                        <h2><strong>Personal Data</strong></h2>
                        <hr>
                        @include('applications.includes.personal_data')
                        
                        {{-- EDUCATIONAL BACKGROUND --}}
                        <h2><strong>Educational Background</strong></h2>
                        <hr>
                        @include('applications.includes.educational_background')
                        <span class="ebCount fd-count">0</span>
                        <a class="btn btn-success" onclick="addEB()">
                            <span class="fa fa-plus"></span>
                        </a>
                        
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
                        @include('applications.includes.sea_service')
                        <span class="ssCount fd-count">0</span>
                        <a class="btn btn-success" onclick="addSS()">
                            <span class="fa fa-plus"></span>
                        </a>

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
        .scroller{
            background-color: #00c0ef;
            position: fixed;
            width: 50px;
            height: 50px;
            z-index: 1000;
            border-radius: 50%;
            bottom: 30px;
            right: 50px;
            text-align: center;
            line-height: 45px;
        }

        .scroller .fa{
            color: white;
            vertical-align: middle;
        }

        .fd-count{
            margin-right: 10px;
        }

        .fd-count:not(:first-child){
            margin-left: 20px;
        }
        .select2-selection--multiple .select2-selection__choice{
            color: #444 !important;
        }

        #EB .row, #FD .row, #docu .row, #sea-services .row{
            position: relative;
        }

        .fa-times{
            top: -5px;
            right: 10px;
            color: #dd4b39;
            z-index: 999;
            position: absolute;
            transition: all .2s ease-in-out;
        }

        .fa-times:hover{
            color: #f13f28;
            transform: scale(1.3);
        }

        form input:not([type='email']){
            text-transform: uppercase;
        }

        ::placeholder{
            text-transform: none;
        };
    </style>
@endpush

@push('before-scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
@endpush

@push('after-scripts')

    <script>
        // $('html, body').animate({
        //     scrollTop: $(".SpouseCount").offset().top - 50
        // }, 2000);
        var scrollIndex = 0;
        var scrollDivs = ['#createForm', '#FD', '.Flag', '#sea-services', '.box-footer'];

        $('.arrow').on('click', e => {
            if($(e.target).hasClass('fa-arrow-down')){
                scrollIndex += 1;
            }
            else{
                scrollIndex -= 1;
            }

            if(scrollIndex == 4){
                $(e.target).removeClass('fa-arrow-down');
                $(e.target).addClass('fa-arrow-up');
            }
            else if(scrollIndex == 0){
                $(e.target).removeClass('fa-arrow-up');
                $(e.target).addClass('fa-arrow-down');
            }

            $('html, body').animate({
                scrollTop: $(scrollDivs[scrollIndex]).offset().top - 150
            }, 500);
        });

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

                $('#sea-services input')[12].value = "So so";
            }, 2000);

            setTimeout(() => {
                addSS();
    
                $('[name="vessel_name2"]').select2('open');
    
                $('[name="vessel_name2"]').val('M/T SM NAVIGATOR').trigger('change');
                $('[name="rank2"]').val('ABLE SEAMAN').trigger('change');
                $('#sea-services input')[19].value = "25000";
                $('#sea-services input')[22].value = "Filipino";

                $('[name="sign_on2"]').flatpickr().setDate('2019-03-01', true);
                $('[name="sign_off2"]').flatpickr().setDate('2019-03-30', true);

                $('#sea-services input')[25].value = "Not So so";

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
                    @if(!isset($edit))
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
                    @else
                        $.ajax({
                            url: '{{ route('validate.update') }}',
                            data: {
                                email: input.value,
                                column: 'email',
                                table: 'users',
                                id: '{{ $applicant->user->id }}'
                            },
                            success: result => {
                                result = JSON.parse(result);
                                if(typeof result[temp.attr('name')] != 'undefined'){
                                    showError(input, temp, error, result[temp.attr('name')][0]);
                                }
                            }
                        });
                    @endif
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
                if(!$('.is-invalid').is(':visible')){
                    compressAndSubmit();
                }
                else{
                    swal.close();
                    $('html, body').animate({
                        scrollTop: $($('[id$="Error"]:visible')[0]).offset().top - 100
                    }, 1000);
                }
            }, 1500)
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

            @if(!isset($edit))
                for(let i = 0; i < inputs.length; i+=11){
                    if(!checkIfVisible(inputs[i])){
                        continue;
                    }

                    let tempFd = {};
                    tempFd.type         = inputs[i].value;
                    tempFd.lname        = inputs[i+1].value;
                    tempFd.fname        = inputs[i+2].value;
                    tempFd.mname        = inputs[i+3].value;
                    tempFd.suffix       = inputs[i+4].value;
                    tempFd.birthday     = inputs[i+5].value;
                    tempFd.age          = inputs[i+7].value;
                    tempFd.occupation   = inputs[i+8].value;
                    tempFd.email        = inputs[i+9].value;
                    tempFd.address      = inputs[i+10].value;
                    fd.push(tempFd);
                }
            @else
                for(let i = 0; i < inputs.length; i+=12){
                    if(!checkIfVisible(inputs[i])){
                        continue;
                    }

                    let tempFd = {};
                    tempFd.id           = inputs[i].value;
                    tempFd.type         = inputs[i+1].value;
                    tempFd.lname        = inputs[i+2].value;
                    tempFd.fname        = inputs[i+3].value;
                    tempFd.mname        = inputs[i+4].value;
                    tempFd.suffix       = inputs[i+5].value;
                    tempFd.birthday     = inputs[i+6].value;
                    tempFd.age          = inputs[i+8].value;
                    tempFd.occupation   = inputs[i+9].value;
                    tempFd.email        = inputs[i+10].value;
                    tempFd.address      = inputs[i+11].value;
                    fd.push(tempFd);
                }
            @endif

            $('#createForm').append(`
                <input type="hidden" name="fd" value='${JSON.stringify(fd)}'>
            `);

            // COMPRESS SS
            inputs = $('#sea-services input, #sea-services select');
            let ss = [];
            @if(!isset($edit))
                for(let i = 0; i < inputs.length; i+= 17){
                    if(!checkIfVisible(inputs[i])){
                        continue;
                    }

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
                    tempSS.sign_off         = inputs[i+14].value;
                    tempSS.remarks          = inputs[i+16].value;
                    tempSS.total_months     =  moment(new Date(tempSS.sign_off)).diff(new Date(tempSS.sign_on), 'months', true);;
                    ss.push(tempSS);
                }
            @else
                for(let i = 0; i < inputs.length; i+= 18){
                    if(!checkIfVisible(inputs[i])){
                        continue;
                    }

                    let tempSS = {};
                    tempSS.id               = inputs[i].value;
                    tempSS.vessel_name      = inputs[i+1].value;
                    tempSS.rank             = inputs[i+2].value;
                    tempSS.vessel_type      = inputs[i+3].value;
                    tempSS.gross_tonnage    = inputs[i+4].value;
                    tempSS.engine_type      = inputs[i+5].value;
                    tempSS.bhp_kw           = inputs[i+6].value;
                    tempSS.flag             = inputs[i+7].value;
                    tempSS.trade            = inputs[i+8].value;
                    tempSS.previous_salary  = inputs[i+9].value;
                    tempSS.manning_agent    = inputs[i+10].value;
                    tempSS.principal        = inputs[i+11].value;
                    tempSS.crew_nationality = inputs[i+12].value;
                    tempSS.sign_on          = inputs[i+13].value;
                    tempSS.sign_off         = inputs[i+15].value;
                    tempSS.remarks          = inputs[i+17].value;
                    tempSS.total_months     =  moment(new Date(tempSS.sign_off)).diff(new Date(tempSS.sign_on), 'months', true);;
                    ss.push(tempSS);
                }
            @endif

            $('#createForm').append(`
                <input type="hidden" name="ss" value='${JSON.stringify(ss)}'>
            `);

            // Compress EB
            inputs = $('#EB input, #EB select');
            let eb = [];

            @if(!isset($edit))
                for(let i = 0; i < inputs.length; i+=6){
                    if(!checkIfVisible(inputs[i])){
                        continue;
                    }

                    let tempEb = {};
                    tempEb.type         = inputs[i].value;
                    tempEb.course       = inputs[i+1].value;
                    tempEb.year         = inputs[i+2].value + '-' + inputs[i+3].value;
                    tempEb.school       = inputs[i+4].value;
                    tempEb.address      = inputs[i+5].value;
                    eb.push(tempEb);
                }
            @else
                for(let i = 0; i < inputs.length; i+=7){
                    if(!checkIfVisible(inputs[i])){
                        continue;
                    }

                    let tempEb = {};
                    tempEb.id           = inputs[i].value;
                    tempEb.type         = inputs[i+1].value;
                    tempEb.course       = inputs[i+2].value;
                    tempEb.year         = inputs[i+3].value + '-' + inputs[i+4].value;
                    tempEb.school       = inputs[i+5].value;
                    tempEb.address      = inputs[i+6].value;
                    eb.push(tempEb);
                }
            @endif

            $('#createForm').append(`
                <input type="hidden" name="eb" value='${JSON.stringify(eb)}'>
            `);

            // Compress Documents

            // DOCUMENT ID
            inputs = $('#docu .ID input, #docu .ID select');
            let docu_id = [];
            @if(!isset($edit))
                for(let i = 0; i < inputs.length; i+=7){
                    if(!checkIfVisible(inputs[i])){
                        continue;
                    }

                    let tempID = {};
                    tempID.type             = inputs[i].value;
                    tempID.issuer           = inputs[i+1].value;
                    tempID.number           = inputs[i+2].value;
                    tempID.issue_date       = inputs[i+3].value;
                    tempID.expiry_date      = inputs[i+5].value;
                    docu_id.push(tempID);
                }
            @else
                for(let i = 0; i < inputs.length; i+=8){
                    if(!checkIfVisible(inputs[i])){
                        continue;
                    }

                    let tempID = {};
                    tempID.id               = inputs[i].value;
                    tempID.type             = inputs[i+1].value;
                    tempID.issuer           = inputs[i+2].value;
                    tempID.number           = inputs[i+3].value;
                    tempID.issue_date       = inputs[i+4].value;
                    tempID.expiry_date      = inputs[i+6].value;
                    docu_id.push(tempID);
                }
            @endif

            $('#createForm').append(`
                <input type="hidden" name="docu_id" value='${JSON.stringify(docu_id)}'>
            `);

            // DOCUMENT FLAG
            // inputs = $('#docu .Flag input, #docu .Flag select');
            countries = $('.docu-country');
            let rank = $('#rank').val();
            let docu_flag = [];

            countries.each((index, country) => {
                inputs = $(`.flag${$(country).data('fdcount')}-documents input`);

                @if(!isset($edit))
                    for(let i = 0; i < inputs.length; i+=6){
                        if(!checkIfVisible($(inputs[i]).parent().parent().parent())){
                            continue;
                        }

                        let tempFlag = {};
                        tempFlag.country    = country.value;
                        tempFlag.rank       = rank;
                        tempFlag.type       = inputs[i].value;
                        tempFlag.number     = inputs[i+1].value;
                        tempFlag.issue_date = inputs[i+2].value;
                        tempFlag.expiry_date= inputs[i+4].value;

                        // FOR REMOVING ' in "SHIP'S COOK ENDORSEMENT"
                        if(tempFlag.type == "SHIP'S COOK ENDORSEMENT"){
                            tempFlag.type = "SHIP COOK ENDORSEMENT";
                        }
                        docu_flag.push(tempFlag);
                    }
                @else
                    for(let i = 0; i < inputs.length; i+=7){
                        if(!checkIfVisible($(inputs[i]).parent().parent().parent())){
                            continue;
                        }

                        let tempFlag = {};
                        tempFlag.country    = country.value;
                        tempFlag.rank       = rank;
                        tempFlag.id         = inputs[i].value;
                        tempFlag.type       = inputs[i+1].value;
                        tempFlag.number     = inputs[i+2].value;
                        tempFlag.issue_date = inputs[i+3].value;
                        tempFlag.expiry_date= inputs[i+5].value;

                        // FOR REMOVING ' in "SHIP'S COOK ENDORSEMENT"
                        if(tempFlag.type == "SHIP'S COOK ENDORSEMENT"){
                            tempFlag.type = "SHIP COOK ENDORSEMENT";
                        }
                        docu_flag.push(tempFlag);
                    }
                @endif
            });

            $('#createForm').append(`
                <input type="hidden" name="docu_flag" value='${JSON.stringify(docu_flag)}'>
            `);

            // License/Certificates
            inputs = $('#docu .lc input, #docu .lc select');
            let docu_lc = [];

            @if(!isset($edit))
                for(let i = 0; i < inputs.length; i+=9){
                    if(!checkIfVisible(inputs[i])){
                        continue;
                    }

                    let tempLc = {};
                    tempLc.type         = inputs[i].value
                    tempLc.rank         = rank;
                    tempLc.issuer       = inputs[i+1].value;
                    tempLc.regulation   = $(inputs[i+2]).val();
                    tempLc.no           = inputs[i+4].value;
                    tempLc.issue_date   = inputs[i+5].value;
                    tempLc.expiry_date  = inputs[i+7].value;

                    // FOR REMOVING ' in "SAFETY OFFICER'S TRAINING COURSE"
                    if(tempLc.type == "SAFETY OFFICER'S TRAINING COURSE"){
                        tempLc.type = "SAFETY OFFICER TRAINING COURSE";
                    }
                    docu_lc.push(tempLc);
                }
            @else
                for(let i = 0; i < inputs.length; i+=10){
                    if(!checkIfVisible(inputs[i])){
                        continue;
                    }

                    let tempLc = {};
                    tempLc.id           = inputs[i].value
                    tempLc.type         = inputs[i+1].value
                    tempLc.rank         = rank;
                    tempLc.issuer       = inputs[i+2].value;
                    tempLc.regulation   = $(inputs[i+3]).val();
                    tempLc.no           = inputs[i+5].value;
                    tempLc.issue_date   = inputs[i+6].value;
                    tempLc.expiry_date  = inputs[i+8].value;

                    // FOR REMOVING ' in "SAFETY OFFICER'S TRAINING COURSE"
                    if(tempLc.type == "SAFETY OFFICER'S TRAINING COURSE"){
                        tempLc.type = "SAFETY OFFICER TRAINING COURSE";
                    }
                    docu_lc.push(tempLc);
                }
            @endif

            $('#createForm').append(`
                <input type="hidden" name="docu_lc" value='${JSON.stringify(docu_lc)}'>
            `);

            // MedCert
            inputs = $('#docu .MedCert input, #docu .MedCert select');
            let docu_med_cert = [];

            @if(!isset($edit))
                for(let i = 0; i < inputs.length; i+= 7){
                    if(!checkIfVisible(inputs[i])){
                        continue;
                    }

                    let tempMedCert = {};
                    tempMedCert.type        = inputs[i].value;
                    tempMedCert.clinic      = inputs[i+1].value;
                    tempMedCert.number      = inputs[i+2].value;
                    tempMedCert.issue_date  = inputs[i+3].value;
                    tempMedCert.expiry_date  = inputs[i+5].value;
                    docu_med_cert.push(tempMedCert);
                }
            @else
                for(let i = 0; i < inputs.length; i+= 8){
                    if(!checkIfVisible(inputs[i])){
                        continue;
                    }

                    let tempMedCert = {};
                    tempMedCert.id          = inputs[i].value;
                    tempMedCert.type        = inputs[i+1].value;
                    tempMedCert.clinic      = inputs[i+2].value;
                    tempMedCert.number      = inputs[i+3].value;
                    tempMedCert.issue_date  = inputs[i+4].value;
                    tempMedCert.expiry_date = inputs[i+6].value;
                    docu_med_cert.push(tempMedCert);
                }
            @endif

            $('#createForm').append(`
                <input type="hidden" name="docu_med_cert" value='${JSON.stringify(docu_med_cert)}'>
            `);

            // Med
            inputs = $('#docu .Med input, #docu .Med select');
            let docu_med = [];

            @if(!isset($edit))
                for(let i = 0; i < inputs.length; i+=4){
                    if(!checkIfVisible(inputs[i])){
                        continue;
                    }
                    
                    let tempMed = {};
                    tempMed.type            = inputs[i].value;
                    tempMed.with_mv         = inputs[i+1].value;
                    tempMed.year            = inputs[i+2].value;
                    tempMed.case_remarks    = inputs[i+3].value;
                    docu_med.push(tempMed);
                }
            @else
                for(let i = 0; i < inputs.length; i+=5){
                    if(!checkIfVisible(inputs[i])){
                        continue;
                    }
                    
                    let tempMed = {};
                    tempMed.id              = inputs[i].value;
                    tempMed.type            = inputs[i+1].value;
                    tempMed.with_mv         = inputs[i+2].value;
                    tempMed.year            = inputs[i+3].value;
                    tempMed.case_remarks    = inputs[i+4].value;
                    docu_med.push(tempMed);
                }
            @endif

            $('#createForm').append(`
                <input type="hidden" name="docu_med" value='${JSON.stringify(docu_med)}'>
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

        function deleteRow(e, type) {
            $(e).parent().next().addClass('hidden');
            $(e).parent().addClass('hidden');
            $(`.${type}Count`)[0].innerText -= 1;
        };

        function checkIfVisible(element){
            return $(element).parent().parent().find('.fa-times').is(':visible');
        }
    </script>

    @if(isset($edit))
        @include('applications.includes.populate_data')
    @endif
@endpush