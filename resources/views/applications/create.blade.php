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
                    <div class="pull-left">
                        <h5 style="color: red;"><b>NOTE: Disregard any apostrophe in encoding as this will cause problem in saving the information during compression.</b></h5>
                    </div>

                    @include('applications.includes.toolbar')
                </div>

                <div class="box-body">
                    <form method="POST" action="{{ !isset($edit) ? route('applications.store') : route('applications.update', ['id' => $applicant->user->id]) }}" id="createForm" enctype="multipart/form-data">
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
                                <a class="btn btn-primary submit pull-right">Save</a>
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

        /*form input:not([type='email']){
            text-transform: uppercase;
        }*/

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
        @if(isset($edit))
            swal({
                title: 'Loading Data...',
                allowOutsideClick: false,
                allowEscapeKey: false,
            });
            swal.showLoading();
        @endif
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
                    scrollIndex = 1;
                    $('html, body').animate({
                        scrollTop: $($('[id$="Error"]:visible')[0]).offset().top - 100
                    }, 1000);
                }
            }, 1500)
        });

        function compressAndSubmit(){
            // Compress FD
            let inputs = $('#FD input');
            let fd = [];

            for(let i = 0; i < inputs.length; i+=12){
                let tempFd = {};

                if($(inputs[i]).is("[data-type]")){
                    tempFd.id = inputs[i].value;
                }
                else{
                    i -= 1;
                }

                if(!checkIfVisible(inputs[i+11])){
                    continue;
                }

                tempFd.type         = inputs[i+1].value;
                tempFd.lname        = inputs[i+2].value.toUpperCase();
                tempFd.fname        = inputs[i+3].value.toUpperCase();
                tempFd.mname        = inputs[i+4].value.toUpperCase();
                tempFd.suffix       = inputs[i+5].value.toUpperCase();
                tempFd.birthday     = inputs[i+6].value;
                tempFd.age          = inputs[i+8].value;
                tempFd.occupation   = inputs[i+9].value.toUpperCase();
                tempFd.email        = inputs[i+10].value;
                tempFd.address      = inputs[i+11].value.toUpperCase();
                fd.push(tempFd);
            }


            $('#createForm').append(`
                <input type="hidden" name="fd" value='${JSON.stringify(fd)}'>
            `);

            // COMPRESS SS
            inputs = $('#sea-services input, #sea-services select');
            let ss = [];

            for(let i = 0; i < inputs.length; i+= 19){
                let tempSS = {};

                if($(inputs[i]).is("[data-type]")){
                    tempSS.id = inputs[i].value;
                }
                else{
                    i -= 1;
                }

                if(!checkIfVisible(inputs[i+18])){
                    continue;
                }

				tempSS.imo      		= inputs[i+1].value;
                tempSS.vessel_name      = inputs[i+2].value.toUpperCase();
                tempSS.rank             = inputs[i+3].value;
                tempSS.vessel_type      = inputs[i+4].value.toUpperCase();
                tempSS.gross_tonnage    = inputs[i+5].value;
                tempSS.engine_type      = inputs[i+6].value.toUpperCase();
                tempSS.bhp_kw           = inputs[i+7].value;
                tempSS.flag             = inputs[i+8].value.toUpperCase();
                tempSS.trade            = inputs[i+9].value.toUpperCase();
                tempSS.previous_salary  = inputs[i+10].value;
                tempSS.manning_agent    = inputs[i+11].value.toUpperCase();
                tempSS.principal        = inputs[i+12].value.toUpperCase();
                tempSS.crew_nationality = inputs[i+13].value.toUpperCase();
                tempSS.sign_on          = inputs[i+14].value;
                tempSS.sign_off         = inputs[i+16].value;
                tempSS.remarks          = inputs[i+18].value.toUpperCase();
                tempSS.total_months     =  moment(new Date(tempSS.sign_off)).diff(new Date(tempSS.sign_on), 'months', true);;
                ss.push(tempSS);
            }

            $('#createForm').append(`
                <input type="hidden" name="ss" value='${JSON.stringify(ss)}'>
            `);

            // Compress EB
            inputs = $('#EB input, #EB select');
            let eb = [];

            for(let i = 0; i < inputs.length; i+=7){
                let tempEb = {};

                if($(inputs[i]).is("[data-type]")){
                    tempEb.id = inputs[i].value;
                }
                else{
                    i -= 1;
                }

                if(!checkIfVisible(inputs[i+6])){
                    continue;
                }

                tempEb.type         = inputs[i+1].value;
                tempEb.course       = inputs[i+2].value.toUpperCase();
                tempEb.year         = inputs[i+3].value + '-' + inputs[i+4].value;
                tempEb.school       = inputs[i+5].value.toUpperCase();
                tempEb.address      = inputs[i+6].value.toUpperCase();
                eb.push(tempEb);
            }

            $('#createForm').append(`
                <input type="hidden" name="eb" value='${JSON.stringify(eb)}'>
            `);

            // Compress Documents

            // DOCUMENT ID
            inputs = $('#docu .ID input, #docu .ID select');
            let docu_id = [];

            for(let i = 0; i < inputs.length; i+=8){

                let tempID = {};

                if($(inputs[i]).is("[data-type]")){
                    tempID.id = inputs[i].value;
                }
                else{
                    i -= 1;
                }

                if(!checkIfVisible(inputs[i+6])){
                    continue;
                }

                tempID.type             = inputs[i+1].value.toUpperCase();
                tempID.issuer           = inputs[i+2].value.toUpperCase();
                tempID.number           = inputs[i+3].value;
                tempID.issue_date       = inputs[i+4].value;
                tempID.expiry_date      = inputs[i+6].value;
                docu_id.push(tempID);
            }

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

                for(let i = 0; i < inputs.length; i+=7){

                    let tempFlag = {};

                    if($(inputs[i]).is("[data-type]")){
                        tempFlag.id = inputs[i].value;
                    }
                    else{
                        i -= 1;
                    }

                    if(!checkIfVisible($(inputs[i+5]))){
                        continue;
                    }

                    tempFlag.country    = country.value;
                    tempFlag.rank       = rank;
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

                // for(let i = 0; i < inputs.length; i+=7){
                //     if(!checkIfVisible($(inputs[i]).parent().parent().parent())){
                //         continue;
                //     }
                //     let tempFlag = {};
                //     tempFlag.country    = country.value.toUpperCase();
                //     tempFlag.rank       = rank;
                //     tempFlag.id         = inputs[i].value.toUpperCase();
                //     tempFlag.type       = inputs[i+1].value;
                //     tempFlag.number     = inputs[i+2].value;
                //     tempFlag.issue_date = inputs[i+3].value;
                //     tempFlag.expiry_date= inputs[i+5].value;
                //     // FOR REMOVING ' in "SHIP'S COOK ENDORSEMENT"
                //     if(tempFlag.type == "SHIP'S COOK ENDORSEMENT"){
                //         tempFlag.type = "SHIP COOK ENDORSEMENT";
                //     }
                //     docu_flag.push(tempFlag);
                // }
            });

            $('#createForm').append(`
                <input type="hidden" name="docu_flag" value='${JSON.stringify(docu_flag)}'>
            `);

            // License/Certificates
            inputs = $('#docu .lc input, #docu .lc select');
            let docu_lc = [];

            for(let i = 0; i < inputs.length; i+=10){

                let tempLc = {};

                if($(inputs[i]).is("[data-type]")){
                    tempLc.id = inputs[i].value;
                }
                else{
                    i -= 1;
                }

                if(!checkIfVisible(inputs[i+8])){
                    continue;
                }

                tempLc.type         = inputs[i+1].value.toUpperCase();
                tempLc.rank         = rank;
                tempLc.issuer       = inputs[i+2].value.toUpperCase();
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

            $('#createForm').append(`
                <input type="hidden" name="docu_lc" value='${JSON.stringify(docu_lc)}'>
            `);

            // MedCert
            inputs = $('#docu .MedCert input, #docu .MedCert select');
            let docu_med_cert = [];

            for(let i = 0; i < inputs.length; i+= 9){

                let tempMedCert = {};

                if($(inputs[i]).is("[data-type]")){
                    tempMedCert.id = inputs[i].value;
                }
                else{
                    i -= 1;
                }

                if(!checkIfVisible(inputs[i+7])){
                    continue;
                }

                tempMedCert.type        = inputs[i+1].value.toUpperCase();
                tempMedCert.clinic      = inputs[i+2].value.toUpperCase();
                tempMedCert.issuer      = inputs[i+3].value.toUpperCase();
                tempMedCert.number      = inputs[i+4].value;
                tempMedCert.issue_date  = inputs[i+5].value;
                tempMedCert.expiry_date = inputs[i+7].value;
                docu_med_cert.push(tempMedCert);
            }

            $('#createForm').append(`
                <input type="hidden" name="docu_med_cert" value='${JSON.stringify(docu_med_cert)}'>
            `);

            // Med
            inputs = $('#docu .Med input, #docu .Med select');
            let docu_med = [];

            for(let i = 0; i < inputs.length; i+=5){
                
                let tempMed = {};

                if($(inputs[i]).is("[data-type]")){
                    tempMed.id = inputs[i].value;
                }
                else{
                    i -= 1;
                }

                if(!checkIfVisible(inputs[i+4])){
                    continue;
                }

                tempMed.type            = inputs[i+1].value.toUpperCase();
                tempMed.with_mv         = inputs[i+2].value;
                tempMed.year            = inputs[i+3].value;
                tempMed.case_remarks    = inputs[i+4].value;
                docu_med.push(tempMed);
            }

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
            return $(element).parent().is(':visible');
        }
    </script>

    @if(isset($edit))
        @include('applications.includes.populate_data')
    @endif
@endpush