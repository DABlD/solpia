@extends('layouts.auth')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="fname">First Name</label>
                                <input type="text" class="form-control aeigh" name="fname" placeholder="Enter First Name" autofocus>
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="fnameError"></strong>
                                </span>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mname">Middle Name</label>
                                <input type="text" class="form-control" name="mname" placeholder="Enter Middle Name">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="mnameError"></strong>
                                </span>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="lname">Last Name</label>
                                <input type="text" class="form-control aeigh" name="lname" placeholder="Enter Last Name">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="lnameError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Enter Address">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="addressError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="username">Username</label>
                                <input type="text" class="form-control aeigh" name="username" placeholder="Enter Username">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="usernameError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter Email">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="emailError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="contact">Contact Number</label>
                                <input type="text" class="form-control" name="contact" placeholder="Enter Contact Number">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="contactError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="birthday">Birthday</label>
                                <input type="text" class="form-control" name="birthday" placeholder="Select Birthday">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="birthdayError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="gender">Gender</label>
                                <br>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="Male" checked> Male
                                </label>
                                &nbsp; &nbsp;
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="Female"> Female
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input type="password" class="form-control aeigh" name="password" placeholder="Enter Password">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="passwordError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control aeigh" name="confirm_password" placeholder="Confirm Password">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="confirm_passwordError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4 align-right">
                                <a class="btn btn-success submit">Register</a>
                                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}">

    <style>
        .btn.btn-primary{
            color: white !important;
        }
    </style>
@endpush

@push('before-scripts')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/swal.js') }}"></script>

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
                else if(temp.attr('name') == 'username'){
                    $.ajax({
                        url: '{{ url('validate') }}',
                        data: {
                            username: input.value,
                            rules: 'unique:users'
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
                else if(temp.attr('name') == 'confirm_password'){
                    if(input.value != $('[name="password"]').val()){
                        showError(input, temp, error, 'Password do not match');

                        input2 = $('[name="password"]')[0];
                        temp2 = $(input2);
                        error2 = $('#' + temp2.attr('name') + 'Error');

                        showError(input2, temp2, error2, 'Password do not match');
                    }
                    else if(input.value.length < 6){
                        showError(input, temp, error, 'Password must be at least 6 characters');

                        input2 = $('[name="password"]')[0];
                        temp2 = $(input2);
                        error2 = $('#' + temp2.attr('name') + 'Error');

                        showError(input2, temp2, error2, 'Password must be at least 6 characters');
                    }

                }
                
                !bool? clearError(input, temp, error) : '';
            });

            // IF THERE IS NO ERROR. SUBMIT.
            setTimeout(() => {
                // swal.close();
                // !$('.is-invalid').is(':visible')? $('#createForm').submit() : '';
                if(!$('.is-invalid').is(':visible')){
                    $('#registerForm').submit();
                }
                else{
                    swal.close();
                    $('html, body').animate({
                        scrollTop: $($('[id$="Error"]:visible')[0]).offset().top - 100
                    }, 1000);
                }
            }, 1500)
        });

        async function showError(input, temp, error, message){
            await new Promise(resolve => setTimeout(resolve, 1000));

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
    </script>
@endpush

@push('after-styles')
    <style>
        body{
            background-image: url('images/bg.jpg');
            background-size: cover;
            height: 100vh;
        }

        .btn-success{
            color: white !important;
        }

        .navbar-laravel{
            background-color: rgba(255, 255, 255, 0);
            border-color: rgba(255, 255, 255, 0);
            box-shadow: none;
        }

        .navbar-brand{
            font-size: 30px;
        }

        .navbar-brand b{
            color: #f0f1f2;
        }

        .navbar-brand b span{
            text-decoration: underline;
        }

        .container{
            max-width: 900px;
        }

        .navbar .container{
            max-width: 90%;
        }

        img{
            width: 130px;
            height: 130px;
            margin-right: 20px;
        }

        .card{
            background-color: rgba(255,255,255,0.3);
            box-shadow: 0px 3px 6px rgba(0,0,0,0.2);
            border-color: #d0d0d0;
            border: 1px solid rgba(0,0,0,.125);
            border-radius: .25rem;
        }

        .align-right{
            text-align: right;
        }

        .form-group label{
            font-family: Nunito,sans-serif;
        }

        .form-group b{
            font-size: 16px;
        }

        label{
            font-weight: 900;
        }
    </style>
@endpush