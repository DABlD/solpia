@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					@include('users.includes.toolbar')
				</div>

				<div class="box-body">
					<form method="POST" action="{{ route('users.store') }}" id="createForm">
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
                                <input type="text" class="form-control aeigh" name="mname" placeholder="Enter Middle Name">
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
                                <input type="text" class="form-control aeigh" name="address" placeholder="Enter Address">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="addressError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control aeigh" name="email" placeholder="Enter Email">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="emailError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="contact">Contact Number</label>
                                <input type="text" class="form-control aeigh" name="contact" placeholder="Enter Contact Number">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="contactError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="birthday">Birthday</label>
                                <input type="text" class="form-control aeigh" name="birthday" placeholder="Select Birthday">
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
                                <label for="role">Role</label>
                                <br>
                                <select name="role" class="form-control aeigh">
                                	<option></option>
                                	@foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="roleError"></strong>
                                </span>
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
@endpush

@push('before-scripts')
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <script>
        $('[name="birthday"]').flatpickr({
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d',
            maxDate: moment().format('YYYY-MM-DD')
        });

        $('[name=role]').select2({
        	placeholder: 'Select Role'
        });
    </script>
@endpush

@push('after-scripts')

    <script>
        let bool;

        // VALIDATE ON SUBMIT
        $('.submit').click(() => {
            let inputs = $('.aeigh:not(".input")');
            
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

                swal('Validating');
                swal.showLoading();
                setTimeout(() => {
                    !bool? clearError(input, temp, error) : '';
                    swal.close();
                }, 1000);
            });

            // IF THERE IS NO ERROR. SUBMIT.
            setTimeout(() => {
                !$('.is-invalid').is(':visible')? $('#createForm').submit() : '';
            }, 1000)
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