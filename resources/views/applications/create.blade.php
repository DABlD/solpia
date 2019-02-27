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