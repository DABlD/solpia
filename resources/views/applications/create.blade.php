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
                        
                        <h2><strong>Personal Data</strong></h2>
                        <hr>
                        @include('applications.includes.personal_data')

                        <h2><strong>Family Data</strong></h2>
                        <span class="SpouseCount fd-count">0</span>
                        <a class="btn btn-success" onclick="addFD('Spouse')">
                            <span class="fa fa-plus"></span>
                            Spouse
                        </a>
                        <span class="SonCount fd-count">0</span>
                        <a class="btn btn-success" onclick="addFD('Son')">
                            <span class="fa fa-plus"></span>
                            Son
                        </a>
                        <span class="DaughterCount fd-count">0</span>
                        <a class="btn btn-success" onclick="addFD('Daughter')">
                            <span class="fa fa-plus"></span>
                            Daughter
                        </a>
                        <span class="BeneficiaryCount fd-count">0</span>
                        <a class="btn btn-success" onclick="addFD('Beneficiary')">
                            <span class="fa fa-plus"></span>
                            Beneficiary
                        </a>
                        <hr>
                        @include('applications.includes.family_data')
                        
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
        function fill(){
            $('[name="birthday"]').flatpickr().setDate('1997-11-12', true);
            $('[name="fd-birthday1"]').flatpickr().setDate('1967-03-23', true);
            $('[name="fd-birthday2"]').flatpickr().setDate('1961-10-16', true);
            fillSS();
        }

        function fillSS(){
            $('#sea-services input')[0].value = "Vessel 1";
            $('#sea-services input')[1].value = "Rank 1";
            $('#sea-services input')[2].value = "Type 1";
            $('#sea-services input')[3].value = "10 Tons";
            $('#sea-services input')[4].value = "Engine 1";
            $('#sea-services input')[5].value = "30";
            $('#sea-services input')[6].value = "Philippines";
            $('#sea-services input')[7].value = "Antartic";
            $('#sea-services input')[8].value = "30000";
            $('#sea-services input')[9].value = "Agent 1";
            $('#sea-services input')[10].value = "Principal 1";
            $('#sea-services input')[11].value = "Filipino";

            $('[name="sign_on1"]').flatpickr().setDate('2019-02-01', true);
            $('[name="sign_off1"]').flatpickr().setDate('2019-02-28', true);

            $('#sea-services input')[14].value = "Charterer 1";
            $('#sea-services input')[15].value = "Cargo 1, Cargo 2";
            $('#sea-services input')[16].value = "So so";

            if($('#sea-services input').length > 19){
                $('#sea-services input')[0+17].value = "Vessel 2";
                $('#sea-services input')[1+17].value = "Rank 2";
                $('#sea-services input')[2+17].value = "Type 2";
                $('#sea-services input')[3+17].value = "14 Tons";
                $('#sea-services input')[4+17].value = "Engine 2";
                $('#sea-services input')[5+17].value = "40";
                $('#sea-services input')[6+17].value = "Philippines";
                $('#sea-services input')[7+17].value = "Atlantic";
                $('#sea-services input')[8+17].value = "40000";
                $('#sea-services input')[9+17].value = "Agent 2";
                $('#sea-services input')[10+17].value = "Principal 2";
                $('#sea-services input')[11+17].value = "Filipino";
                $('[name="sign_on2"]').flatpickr().setDate('2019-01-01', true);
                $('[name="sign_off2"]').flatpickr().setDate('2019-02-28', true);
                $('#sea-services input')[14+17].value = "Charterer 2";
                $('#sea-services input')[15+17].value = "Cargo 3, Cargo 4";
                $('#sea-services input')[16+17].value = "Not so so";
            }
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

        function compressAndSubmit(){
            // Compress FD
            let inputs = $('#FD input');
            let fd = [];

            for(let i = 0; i < inputs.length; i+=6){
                let tempFd = {};
                tempFd.type         = inputs[i].value;
                tempFd.name         = inputs[i+1].value;
                tempFd.age          = inputs[i+2].value;
                tempFd.birthday     = inputs[i+3].value;
                tempFd.occupation   = inputs[i+4].value;
                tempFd.address      = inputs[i+5].value;
                fd.push(tempFd);

                // REMOVE THOSE ELEMENTS
                inputs[i].remove();
                inputs[i+1].remove();
                inputs[i+2].remove();
                inputs[i+3].remove();
                inputs[i+4].remove();
                inputs[i+5].remove();
            }

            $('#createForm').append(`
                <input type="hidden" name="fd" value='${JSON.stringify(fd)}'>
            `);

            // COMPRESS SS
            inputs = $('#sea-services input');
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

                inputs[i].remove();
                inputs[i+1].remove();
                inputs[i+2].remove();
                inputs[i+3].remove();
                inputs[i+4].remove();
                inputs[i+5].remove();
                inputs[i+6].remove();
                inputs[i+7].remove();
                inputs[i+8].remove();
                inputs[i+9].remove();
                inputs[i+10].remove();
                inputs[i+11].remove();
                inputs[i+12].remove();
                inputs[i+13].remove();
                inputs[i+14].remove();
                inputs[i+15].remove();
                inputs[i+16].remove();

                $('#createForm').append(`
                    <input type="hidden" name="ss" value='${JSON.stringify(ss)}'>
                `);
            }

            swal.close();
            $('#createForm').submit()
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