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
					<form method="POST" action="{{ route('applications.store') }}" id="createForm">
                        @csrf

                        <input type="hidden" name="role" value="Applicant">
                        
                        <h2><strong>Personal Data</strong></h2>
                        <hr>

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
                            <div class="form-group col-md-6">
                                <label for="birthday">Date of birth</label>
                                <input type="text" class="form-control aeigh" name="birthday" placeholder="Select Birthday">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="birthdayError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="birth_place">Place of birth</label>
                                <input type="text" class="form-control aeigh" name="birth_place" placeholder="Enter Place of Birth">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="birth_placeError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="religion">Religion</label>
                                <input type="text" class="form-control aeigh" name="religion" placeholder="Enter Religion">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="religionError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="address">Address</label>
                                <input type="text" class="form-control aeigh" name="address" placeholder="Enter Address">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="addressError"></strong>
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
                                <label for="email">Email</label>
                                <input type="email" class="form-control aeigh" name="email" placeholder="Enter Email">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="emailError"></strong>
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
                                <label for="age">Age</label>
                                <input type="number" class="form-control aeigh" name="age" placeholder="Enter Age">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="ageError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="waistline">Waistline(inch)</label>
                                <input type="number" class="form-control aeigh" name="waistline" placeholder="Enter Waistline">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="waistlineError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="shoe_size">Shoe Size(cm)</label>
                                <input type="number" class="form-control aeigh" name="shoe_size" placeholder="Enter Shoe Size">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="shoe_sizeError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="height">Height(cm)</label>
                                <input type="number" class="form-control aeigh" name="height" placeholder="Enter Height">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="heightError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="weight">Weight(kg)</label>
                                <input type="number" class="form-control aeigh" name="weight" placeholder="Enter Weight">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="weightError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="bmi">BMI</label>
                                <input type="number" class="form-control aeigh" name="bmi" placeholder="Enter BMI">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="bmiError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="blood_type">Blood Type</label>
                                <select name="blood_type" class="form-control aeigh">
                                    <option readonly selected value="">Select Blood Type</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="blood_typeError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="civil_status">Civil Status</label>
                                <select name="civil_status" class="form-control aeigh">
                                    <option readonly selected value="">Select Civil Status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Divorced">Divorced</option>
                                </select>
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="civil_statusError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="tin">TIN No.</label>
                                <input type="number" class="form-control aeigh" name="tin" placeholder="Enter TIN No.">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="tinError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="sss">SSS No.</label>
                                <input type="number" class="form-control aeigh" name="sss" placeholder="Enter SSS No.">
                                <span class="invalid-feedback hidden" role="alert">
                                    <strong id="sssError"></strong>
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
                else if(temp.attr('name') == 'contact'){
                    if(!/^[0-9]*$/.test(input.value)){
                        showError(input, temp, error, 'Invalid Contact Number');
                    }
                }

                !bool? clearError(input, temp, error) : '';
            });

            // IF THERE IS NO ERROR. SUBMIT.
            setTimeout(() => {
                swal.close();
                !$('.is-invalid').is(':visible')? $('#createForm').submit() : '';
            }, 1000)
        });

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
    </script>
@endpush