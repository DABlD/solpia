@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="fname">First Name</label>
                                <input type="text" class="form-control" name="fname" placeholder="Enter First Name" autofocus>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mname">Middle Name</label>
                                <input type="text" class="form-control" name="mname" placeholder="Enter Middle Name">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="lname">Last Name</label>
                                <input type="text" class="form-control" name="lname" placeholder="Enter Last Name">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Enter Address">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter Email">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="contact">Contact Number</label>
                                <input type="text" class="form-control" name="contact" placeholder="Enter Contact Number">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="birthday">Birthday</label>
                                <input type="email" class="form-control" name="birthday" placeholder="Select Birthday">
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
                                <input type="password" class="form-control" name="password" placeholder="Enter Password">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-2 offset-md-10">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
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
@endpush

@push('after-scripts')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>

    <script>
        $('[name="birthday"]').flatpickr({
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d',
            maxDate: moment().format('YYYY-MM-DD')
        });
    </script>
@endpush