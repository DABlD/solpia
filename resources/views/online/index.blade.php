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
        <link rel="stylesheet" href="{{ asset('online/css/select2.min.css') }}">

        <style>
            .main-header, .content-wrapper{
                margin-left: 0px !important;
            }

            .main-header{
                background-color: #009cd5;
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
                            <b><h3 style="color: black; font-family: roboto;">SOLPIA MARINE</h3></b>
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

                                        <div class="row">
                                            <div class='col-md-4'>
                                                <div class='form-group'>
                                                    <label for='rank-applied'>Rank Applied</label>

                                                    <select id="rank-applied" class="form-control">
                                                        <option></option>
                                                        @foreach($categories as $category => $ranks)
                                                            <optgroup label="{{ $category }}"></optgroup>
                                                            @foreach($ranks as $rank)
                                                                <option value="{{ $rank->name }}" data-category="{{ $rank->category }}">
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                                    {{ $rank->name }} ({{ $rank->abbr }})
                                                                </option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

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

                                        <div class="row row-head">
                                            <div class="col-md-12" style="text-align: left;">
                                                <b style="font-size: 1.5rem; text-decoration: underline;">
                                                    Family Information
                                                </b>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class='col-md-3' style="margin: auto; text-align: center;">
                                                <h3>
                                                    <b>Father</b>
                                                </h3>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="row">
                                                    {{ $input(4, 'fd-f-fname', 'First Name') }}
                                                    {{ $input(4, 'fd-f-mname', 'Middle Name') }}
                                                    {{ $input(4, 'fd-f-lname', 'Last Name') }}
                                                    {{ $input(4, 'fd-f-birthday', 'Birthday') }}
                                                    {{ $input(4, 'fd-f-contact', 'Contact (Email, Tel, Mobile, etc.)') }}
                                                    {{ $input(4, 'fd-f-occupation', 'Occupation') }}
                                                </div>

                                                <div class="row">
                                                    {{ $input(12, 'fd-f-address', 'Address') }}
                                                </div>
                                            </div>

                                            <hr>
                                        </div>

                                        <div class="row">
                                            <div class='col-md-3' style="margin: auto; text-align: center;">
                                                <h3>
                                                    <b>Mother</b>
                                                </h3>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="row">
                                                    {{ $input(4, 'fd-m-fname', 'First Name') }}
                                                    {{ $input(4, 'fd-m-mname', 'Middle Name') }}
                                                    {{ $input(4, 'fd-m-lname', 'Last Name') }}
                                                    {{ $input(4, 'fd-m-birthday', 'Birthday') }}
                                                    {{ $input(4, 'fd-m-contact', 'Contact (Email, Tel, Mobile, etc.)') }}
                                                    {{ $input(4, 'fd-m-occupation', 'Occupation') }}
                                                </div>

                                                <div class="row">
                                                    {{ $input(12, 'fd-m-address', 'Address') }}
                                                </div>
                                            </div>

                                            <hr>
                                        </div>

                                        <div class="row">
                                            <div class='col-md-3' style="margin: auto; text-align: center;">
                                                <h3>
                                                    <b>Spouse</b>
                                                </h3>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="row">
                                                    {{ $input(4, 'fd-s-fname', 'First Name') }}
                                                    {{ $input(4, 'fd-s-mname', 'Middle Name') }}
                                                    {{ $input(4, 'fd-s-lname', 'Last Name') }}
                                                    {{ $input(4, 'fd-s-birthday', 'Birthday') }}
                                                    {{ $input(4, 'fd-s-contact', 'Contact (Email, Tel, Mobile, etc.)') }}
                                                    {{ $input(4, 'fd-s-occupation', 'Occupation') }}
                                                </div>

                                                <div class="row">
                                                    {{ $input(12, 'fd-s-address', 'Address') }}
                                                </div>
                                            </div>

                                            <hr>
                                        </div>

                                        <div class="row">
                                            <div class='col-md-3' style="margin: auto; text-align: center;">
                                                <h3>
                                                    <b>Children/s</b>
                                                </h3>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="row">
                                                    {{ $input(4, 'fd-c1-fname', 'First Name') }}
                                                    {{ $input(4, 'fd-c1-mname', 'Middle Name') }}
                                                    {{ $input(4, 'fd-c1-lname', 'Last Name') }}
                                                    {{ $input(4, 'fd-c1-birthday', 'Birthday') }}
                                                    {{ $input(4, 'fd-c1-contact', 'Contact (Email, Tel, Mobile, etc.)') }}
                                                    {{ $input(4, 'fd-c1-occupation', 'Occupation') }}
                                                </div>

                                                <div class="row">
                                                    {{ $input(12, 'fd-c1-address', 'Address') }}
                                                </div>
                                            </div>

                                            <hr>

                                            <div class='col-md-3' style="margin: auto; text-align: center;"><h3><b></b></h3></div>

                                            <div class="col-md-9">
                                                <div class="row">
                                                    {{ $input(4, 'fd-c2-fname', 'First Name') }}
                                                    {{ $input(4, 'fd-c2-mname', 'Middle Name') }}
                                                    {{ $input(4, 'fd-c2-lname', 'Last Name') }}
                                                    {{ $input(4, 'fd-c2-birthday', 'Birthday') }}
                                                    {{ $input(4, 'fd-c2-contact', 'Contact (Email, Tel, Mobile, etc.)') }}
                                                    {{ $input(4, 'fd-c2-occupation', 'Occupation') }}
                                                </div>

                                                <div class="row">
                                                    {{ $input(12, 'fd-c2-address', 'Address') }}
                                                </div>
                                            </div>

                                            <hr>

                                            <div class='col-md-3' style="margin: auto; text-align: center;"><h3><b></b></h3></div>

                                            <div class="col-md-9">
                                                <div class="row">
                                                    {{ $input(4, 'fd-c3-fname', 'First Name') }}
                                                    {{ $input(4, 'fd-c3-mname', 'Middle Name') }}
                                                    {{ $input(4, 'fd-c3-lname', 'Last Name') }}
                                                    {{ $input(4, 'fd-c3-birthday', 'Birthday') }}
                                                    {{ $input(4, 'fd-c3-contact', 'Contact (Email, Tel, Mobile, etc.)') }}
                                                    {{ $input(4, 'fd-c3-occupation', 'Occupation') }}
                                                </div>

                                                <div class="row">
                                                    {{ $input(12, 'fd-c3-address', 'Address') }}
                                                </div>
                                            </div>

                                            <hr>

                                            <div class='col-md-3' style="margin: auto; text-align: center;"><h3><b></b></h3></div>

                                            <div class="col-md-9">
                                                <div class="row">
                                                    {{ $input(4, 'fd-c4-fname', 'First Name') }}
                                                    {{ $input(4, 'fd-c4-mname', 'Middle Name') }}
                                                    {{ $input(4, 'fd-c4-lname', 'Last Name') }}
                                                    {{ $input(4, 'fd-c4-birthday', 'Birthday') }}
                                                    {{ $input(4, 'fd-c4-contact', 'Contact (Email, Tel, Mobile, etc.)') }}
                                                    {{ $input(4, 'fd-c4-occupation', 'Occupation') }}
                                                </div>

                                                <div class="row">
                                                    {{ $input(12, 'fd-c4-address', 'Address') }}
                                                </div>
                                            </div>

                                            <hr>
                                        </div>

                                        <div class="row">
                                            <div class='col-md-3' style="margin: auto; text-align: center;">
                                                <h3>
                                                    <b>Beneficiary/s</b>
                                                </h3>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="row">
                                                    {{ $input(4, 'fd-b1-fname', 'First Name') }}
                                                    {{ $input(4, 'fd-b1-mname', 'Middle Name') }}
                                                    {{ $input(4, 'fd-b1-lname', 'Last Name') }}
                                                    {{ $input(4, 'fd-b1-birthday', 'Birthday') }}
                                                    {{ $input(4, 'fd-b1-contact', 'Contact (Email, Tel, Mobile, etc.)') }}
                                                    {{ $input(4, 'fd-b1-occupation', 'Occupation') }}
                                                </div>

                                                <div class="row">
                                                    {{ $input(12, 'fd-b1-address', 'Address') }}
                                                </div>
                                            </div>

                                            <hr>

                                            <div class='col-md-3' style="margin: auto; text-align: center;"><h3><b></b></h3></div>

                                            <div class="col-md-9">
                                                <div class="row">
                                                    {{ $input(4, 'fd-b2-fname', 'First Name') }}
                                                    {{ $input(4, 'fd-b2-mname', 'Middle Name') }}
                                                    {{ $input(4, 'fd-b2-lname', 'Last Name') }}
                                                    {{ $input(4, 'fd-b2-birthday', 'Birthday') }}
                                                    {{ $input(4, 'fd-b2-contact', 'Contact (Email, Tel, Mobile, etc.)') }}
                                                    {{ $input(4, 'fd-b2-occupation', 'Occupation') }}
                                                </div>

                                                <div class="row">
                                                    {{ $input(12, 'fd-b2-address', 'Address') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row row-head">
                                            <div class="col-md-12" style="text-align: left;">
                                                <b style="font-size: 1.5rem; text-decoration: underline;">
                                                    Company Required Information
                                                </b>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            {{ $input(3, 'tin', 'TIN') }}
                                            {{ $input(3, 'sss', 'SSS') }}
                                            {{ $input(3, 'clothes_size', 'Coverall Size') }}
                                            {{ $input(3, 'shoe_size', 'Shoe Size') }}
                                            {{ $input(3, 'waist', 'Waist (Inch)') }}
                                            {{ $input(3, 'sid', 'SID') }}
                                            {{ $input(3, 'EREG', 'E-REG') }}
                                            {{ $input(3, 'PARKA', 'PARKA') }}
                                        </div>

                                        <div class="row row-head">
                                            <div class="col-md-12" style="text-align: left; margin: auto;">
                                                <h6 style="font-weight: bold;">
                                                    Kindly provide the following information starting from the most recent vessel.
                                                </h6>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row deck">
                                            {{ $input(2, 'dc-vname1', 'Vessel Name') }}
                                            {{ $input(2, 'dc-vtype1', 'Type of Cargo') }}
                                            {{ $input(2, 'dc-lport1', 'Loading Port') }}
                                            {{ $input(2, 'dc-dport1', 'Discharging Port') }}
                                            {{ $input(2, 'dc-smanager1', 'Ship Manager') }}
                                            {{ $input(2, 'dc-charterer1', 'Charterer') }}

                                            <hr>
                                        </div>

                                        <div class="row deck">
                                            {{ $input(2, 'dc-vname2', 'Vessel Name') }}
                                            {{ $input(2, 'dc-vtype2', 'Type of Cargo') }}
                                            {{ $input(2, 'dc-lport2', 'Loading Port') }}
                                            {{ $input(2, 'dc-dport2', 'Discharging Port') }}
                                            {{ $input(2, 'dc-smanager2', 'Ship Manager') }}
                                            {{ $input(2, 'dc-charterer2', 'Charterer') }}

                                            <hr>
                                        </div>

                                        <div class="row deck">
                                            {{ $input(2, 'dc-vname3', 'Vessel Name') }}
                                            {{ $input(2, 'dc-vtype3', 'Type of Cargo') }}
                                            {{ $input(2, 'dc-lport3', 'Loading Port') }}
                                            {{ $input(2, 'dc-dport3', 'Discharging Port') }}
                                            {{ $input(2, 'dc-smanager3', 'Ship Manager') }}
                                            {{ $input(2, 'dc-charterer3', 'Charterer') }}

                                            <hr>
                                        </div>

                                        <div class="row deck">
                                            {{ $input(2, 'dc-vname4', 'Vessel Name') }}
                                            {{ $input(2, 'dc-vtype4', 'Type of Cargo') }}
                                            {{ $input(2, 'dc-lport4', 'Loading Port') }}
                                            {{ $input(2, 'dc-dport4', 'Discharging Port') }}
                                            {{ $input(2, 'dc-smanager4', 'Ship Manager') }}
                                            {{ $input(2, 'dc-charterer4', 'Charterer') }}

                                            <hr>
                                        </div>

                                        <div class="row deck">
                                            {{ $input(2, 'dc-vname5', 'Vessel Name') }}
                                            {{ $input(2, 'dc-vtype5', 'Type of Cargo') }}
                                            {{ $input(2, 'dc-lport5', 'Loading Port') }}
                                            {{ $input(2, 'dc-dport5', 'Discharging Port') }}
                                            {{ $input(2, 'dc-smanager5', 'Ship Manager') }}
                                            {{ $input(2, 'dc-charterer5', 'Charterer') }}

                                            <hr>
                                        </div>

                                        <div class="row engine">
                                            {{ $input(4, 'ec-vname1', 'Vessel Name') }}
                                            {{ $input(4, 'ec-engine1', 'Main Engine Type & Maker') }}
                                            {{ $input(4, 'ec-auengine1', 'Auxiliary Engine / Generator') }}
                                            {{ $input(4, 'ec-ballast', 'Ballast Water Management System') }}
                                            {{ $input(4, 'ec-smanager1', 'Ship Manager') }}
                                            {{ $input(4, 'ec-charterer1', 'Charterer') }}

                                            <hr>
                                        </div>

                                        <div class="row engine">
                                            {{ $input(4, 'ec-vname2', 'Vessel Name') }}
                                            {{ $input(4, 'ec-engine2', 'Main Engine Type & Maker') }}
                                            {{ $input(4, 'ec-auengine2', 'Auxiliary Engine / Generator') }}
                                            {{ $input(4, 'ec-ballas2', 'Ballast Water Management System') }}
                                            {{ $input(4, 'ec-smanager2', 'Ship Manager') }}
                                            {{ $input(4, 'ec-charterer2', 'Charterer') }}

                                            <hr>
                                        </div>

                                        <div class="row engine">
                                            {{ $input(4, 'ec-vname3', 'Vessel Name') }}
                                            {{ $input(4, 'ec-engine3', 'Main Engine Type & Maker') }}
                                            {{ $input(4, 'ec-auengine3', 'Auxiliary Engine / Generator') }}
                                            {{ $input(4, 'ec-ballas3', 'Ballast Water Management System') }}
                                            {{ $input(4, 'ec-smanager3', 'Ship Manager') }}
                                            {{ $input(4, 'ec-charterer3', 'Charterer') }}

                                            <hr>
                                        </div>

                                        <div class="row engine">
                                            {{ $input(4, 'ec-vname4', 'Vessel Name') }}
                                            {{ $input(4, 'ec-engine4', 'Main Engine Type & Maker') }}
                                            {{ $input(4, 'ec-auengine4', 'Auxiliary Engine / Generator') }}
                                            {{ $input(4, 'ec-ballas4', 'Ballast Water Management System') }}
                                            {{ $input(4, 'ec-smanager4', 'Ship Manager') }}
                                            {{ $input(4, 'ec-charterer4', 'Charterer') }}

                                            <hr>
                                        </div>

                                        <div class="row engine">
                                            {{ $input(4, 'ec-vname5', 'Vessel Name') }}
                                            {{ $input(4, 'ec-engine5', 'Main Engine Type & Maker') }}
                                            {{ $input(4, 'ec-auengine5', 'Auxiliary Engine / Generator') }}
                                            {{ $input(4, 'ec-ballas5', 'Ballast Water Management System') }}
                                            {{ $input(4, 'ec-smanager5', 'Ship Manager') }}
                                            {{ $input(4, 'ec-charterer5', 'Charterer') }}

                                            <hr>
                                        </div>

                                        <div class="row row-head">
                                            <div class="col-md-12" style="text-align: left; margin: auto;">
                                                <h6 style="font-weight: bold;">
                                                    Contact Person/s for background check: Starting from the most recent manning agent.
                                                </h6>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="row">
                                            {{ $input(3, 'bc-manning1', 'Manning Agent') }}
                                            {{ $input(3, 'bc-name1', 'Contact Person') }}
                                            {{ $input(3, 'bc-designation1', 'Designation') }}
                                            {{ $input(3, 'bc-contact1', 'Contact Number') }}

                                            <hr>
                                        </div>

                                        <div class="row">
                                            {{ $input(3, 'bc-manning2', 'Manning Agent') }}
                                            {{ $input(3, 'bc-name2', 'Contact Person') }}
                                            {{ $input(3, 'bc-designation2', 'Designation') }}
                                            {{ $input(3, 'bc-contact2', 'Contact Number') }}

                                            <hr>
                                        </div>

                                        <div class="row">
                                            {{ $input(3, 'bc-manning3', 'Manning Agent') }}
                                            {{ $input(3, 'bc-name3', 'Contact Person') }}
                                            {{ $input(3, 'bc-designation3', 'Designation') }}
                                            {{ $input(3, 'bc-contact3', 'Contact Number') }}

                                            <hr>
                                        </div>

                                        <div class="row">
                                            {{ $input(3, 'bc-manning4', 'Manning Agent') }}
                                            {{ $input(3, 'bc-name4', 'Contact Person') }}
                                            {{ $input(3, 'bc-designation4', 'Designation') }}
                                            {{ $input(3, 'bc-contact4', 'Contact Number') }}

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
        <script src="{{ asset('online/js/select2.min.js') }}"></script>

        <script>
            $(document).ready(() => {
                $('#rank-applied').select2({placeholder: "Select Rank"});

                $('#rank-applied').on('change', e => {
                    $('.deck').show();
                    $('.engine').show();

                    let category = $(e.target).find('option:selected').data('category');

                    console.log(category);

                    if(!category.includes("DECK")){
                        $('.deck').hide();
                    }
                    if(!category.includes("ENGINE")){
                        $('.engine').hide();
                    }
                });
            });

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