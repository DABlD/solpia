@php
    $input = function($col, $id, $name, $additional = null, $type = "text"){
        echo "
            <div class='col-md-$col'>
                <div class='form-group'>
                    <label for='$id'>$name</label>
                    <input type='$type' class='form-control' id='$id' placeholder='Enter $name' $additional>
                </div>
            </div>
        ";
    }
@endphp

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Application Form | SOLPIA</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="{{ asset('online/fonts/fontawesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('online/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('online/css/temposdusmus-bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('online/css/icheck-boostrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('online/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('online/css/overlayScrollbar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('online/css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('online/css/sweetalert2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('online/css/flatpickr.min.css') }}">

        <style>
            .main-header, .content-wrapper{
                margin-left: 0px !important;
            }

            #table td, #table th{
                text-align: center;
            }

            .row-head{
                background-color: #E7E8D1;
                height: 40px;
            }

            hr{
                width: 100%;
            }
        </style>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <div class="preloader"></div>

            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <ul class="navbar-nav">
                    <img src="{{ asset("images/logo.png") }}" alt="LOGO" height="45">
                    <li class="nav-item">
                        <a class="nav-link" role="button">
                            <b><h3>SOLPIA MARINE</h3></b>
                        </a>
                    </li>
                </ul>

                {{-- <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" role="button" href="{{ url('/') }}">
                            <i class="fa-solid fa-right-from-bracket">
                                Exit
                            </i>
                        </a>
                    </li>
                </ul> --}}
            </nav>

            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                {{-- <h1 class="m-0">Personal Medical Record</h1> --}}
                            </div>
                            <div class="col-sm-6">
                                <!-- <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                    <li class="breadcrumb-item active">List</li>
                                </ol> -->
                            </div>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <section class="col-lg-8 offset-lg-2">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title" style="text-align: center; float: unset; font-size: 25px;">
                                            <b>Online Application Form</b>
                                        </h3>
                                    </div>

                                    <div class="card-body">
                                        {{-- START --}}

                                        <div class="row row-head">
                                            <div class="col-md-12" style="text-align: left;">
                                                <b style="font-size: 1.5rem; text-decoration: underline;">
                                                    Personal Information
                                                </b>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            {{ $input(4, 'fname', 'First Name') }}
                                            {{ $input(4, 'mname', 'Middle Name') }}
                                            {{ $input(4, 'lname', 'Last Name') }}
                                            {{ $input(4, 'birthday', 'Birthday') }}
                                            {{ $input(4, 'place_of_birth', 'Place of Birth') }}
                                            {{ $input(4, 'religion', 'Religion') }}

                                            {{ $input(3, 'height', 'Height (cm)') }}
                                            {{ $input(3, 'weight', 'Weight (kg)') }}
                                            {{ $input(3, 'blood_type', 'Blood Type') }}
                                            {{ $input(3, 'civil_status', 'Civil Status') }}

                                            {{ $input(12, 'address', 'Metro Manila Address') }}
                                            {{ $input(12, 'provincial_address', 'Provincial Address') }}

                                            {{ $input(6, 'contact', 'Contact Number') }}
                                            {{ $input(6, 'provincial_contact', 'Provincial Contact Number') }}
                                        </div>

                                        <div class="row row-head">
                                            <div class="col-md-12" style="text-align: left;">
                                                <b style="font-size: 1.5rem; text-decoration: underline;">
                                                    Travel Documents
                                                </b>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class='col-md-3' style="margin: auto; text-align: center;">
                                                <h3>
                                                    <b>Passport</b>
                                                </h3>
                                            </div>

                                            {{ $input(3, 'p_number', 'Number') }}
                                            {{ $input(3, 'p_issue_date', 'Issue Date') }}
                                            {{ $input(3, 'p_expiry_date', 'Expiry Date') }}

                                            <div class='col-md-3' style="margin: auto; text-align: center;">
                                                <h3>
                                                    <b>Seaman's Book</b>
                                                </h3>
                                            </div>

                                            {{ $input(3, 'sb_number', 'Number') }}
                                            {{ $input(3, 'sb_issue_date', 'Issue Date') }}
                                            {{ $input(3, 'sb_expiry_date', 'Expiry Date') }}

                                            <div class='col-md-3' style="margin: auto; text-align: center;">
                                                <h3>
                                                    <b>License</b>
                                                </h3>
                                            </div>

                                            {{ $input(3, 'l_number', 'Number') }}
                                            {{ $input(3, 'l_issue_date', 'Issue Date') }}
                                            {{ $input(3, 'l_expiry_date', 'Expiry Date') }}

                                            <div class='col-md-3' style="margin: auto; text-align: center;">
                                                <h3>
                                                    <b>GOC</b>
                                                </h3>
                                            </div>

                                            {{ $input(3, 'g_number', 'Number') }}
                                            {{ $input(3, 'g_issue_date', 'Issue Date') }}
                                            {{ $input(3, 'g_expiry_date', 'Expiry Date') }}

                                            <div class='col-md-3' style="margin: auto; text-align: center;">
                                                <h3>
                                                    <b>Ratings COP</b>
                                                </h3>
                                            </div>

                                            {{ $input(3, 'cop_number', 'Number') }}
                                            {{ $input(3, 'cop_issue_date', 'Issue Date') }}
                                            {{ $input(3, 'cop_expiry_date', 'Expiry Date') }}

                                            <div class='col-md-3' style="margin: auto; text-align: center;">
                                                <h3>
                                                    <b>US Visa</b>
                                                </h3>
                                            </div>

                                            {{ $input(3, 'usv_number', 'Number') }}
                                            {{ $input(3, 'usv_issue_date', 'Issue Date') }}
                                            {{ $input(3, 'usv_expiry_date', 'Expiry Date') }}
                                        </div>

                                        <div class="row row-head">
                                            <div class="col-md-12" style="text-align: left;">
                                                <b style="font-size: 1.5rem; text-decoration: underline;">
                                                    Sea Service
                                                </b>

                                                <div class="float-right" style="margin-top: 5px;">
                                                    <a class="btn btn-success btn-sm" data-toggle="tooltip" title="Add" onclick="addSS()">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row ssrows">
                                        </div>

                                        <div class="row row-head">
                                            <div class="col-md-12" style="text-align: left;">
                                                <b style="font-size: 1.5rem; text-decoration: underline;">
                                                    Educational Background
                                                </b>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class='col-md-3' style="margin: auto; text-align: center;">
                                                <h3>
                                                    <b>Elementary</b>
                                                </h3>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="row">
                                                    {{ $input(4, 'eb-e-course', 'Course') }}
                                                    {{ $input(4, 'eb-e-year', 'Year') }}
                                                    {{ $input(4, 'eb-e-school', 'School') }}
                                                </div>

                                                <div class="row">
                                                    {{ $input(12, 'eb-e-address', 'Address') }}                                                    
                                                </div>
                                            </div>

                                            <hr>
                                        </div>

                                        <div class="row">
                                            <div class='col-md-3' style="margin: auto; text-align: center;">
                                                <h3>
                                                    <b>High School</b>
                                                </h3>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="row">
                                                    {{ $input(4, 'eb-hs-course', 'Course') }}
                                                    {{ $input(4, 'eb-hs-year', 'Year') }}
                                                    {{ $input(4, 'eb-hs-school', 'School') }}
                                                </div>

                                                <div class="row">
                                                    {{ $input(12, 'eb-hs-address', 'Address') }}                                                    
                                                </div>
                                            </div>

                                            <hr>
                                        </div>

                                        <div class="row">
                                            <div class='col-md-3' style="margin: auto; text-align: center;">
                                                <h3>
                                                    <b>College</b>
                                                </h3>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="row">
                                                    {{ $input(4, 'eb-c-course', 'Course') }}
                                                    {{ $input(4, 'eb-c-year', 'Year') }}
                                                    {{ $input(4, 'eb-c-school', 'School') }}
                                                </div>

                                                <div class="row">
                                                    {{ $input(12, 'eb-c-address', 'Address') }}                                                    
                                                </div>
                                            </div>

                                            <hr>
                                        </div>

                                        {{-- END --}}
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                </section>
            </div>
        </div>

        <script src="{{ asset('online/js/jquery.min.js') }}"></script>
        <script src="{{ asset('online/js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('online/js/bootstrap-bundle.min.js') }}"></script>
        <script src="{{ asset('online/js/moment.min.js') }}"></script>
        <script src="{{ asset('online/js/temposdusmus-bootstrap.min.js') }}"></script>
        <script src="{{ asset('online/js/overlayScrollbar.min.js') }}"></script>
        <script src="{{ asset('online/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('online/js/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('online/js/custom.js') }}"></script>

        <script>
            $(document).ready(() => {
            })

            function addSS(){
                let ctr = $('.ss').length;

                let rows = [
                    ['Vessel Name', 'vname'],
                    ['Rank', 'rank'],
                    ['Vessel Type', 'vtype'],
                    ['Gross Tonnage', 'grt'],
                    // ['Flag', 'flag'],
                    ['Trade Route', 'trade'],
                    ['Salary', 'salary'],
                    ['Manning Agent', 'manning'],
                    ['Principal', 'principal'],
                    ['Crew Nationality', 'nationality'],
                    ['Sign On', 'son'],
                    ['Sign Off', 'soff'],
                    ['Remarks', 'remarks'],
                ];

                let string = "";
                rows.forEach(row => {
                    string += `
                        <div class='col-md-2'>
                            <div class='form-group'>
                                <label for='${row[1]}'>${row[0]}</label>
                                <input type='text' class='form-control ss-${row[1]}' placeholder='Enter ${row[0]}'>
                            </div>
                        </div>
                    `;
                });

                $('.ssrows').append(string + "<hr>");
            }
        </script>
    </body>
</html>