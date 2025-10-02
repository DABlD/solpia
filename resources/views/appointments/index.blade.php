<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Appointments</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}">

        <style>
            .main-header, .content-wrapper{
                margin-left: 0px !important;
            }

            #table td, #table th{
                text-align: center;
            }

            .i-error{
                outline: none;
                border-color: red;
                box-shadow: 0 0 10px red;
            }

            /* Navbar / main header */
            .main-header.navbar {
              background: #4d729f !important;
              box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            }
            .main-header .nav-link, 
            .main-header .navbar-nav img {
              color: #fff !important;
            }
            .main-header .nav-link:hover {
              color: #f1f1f1 !important;
            }

            /* Card */
            .card {
              border-radius: 12px;
              border: none;
              box-shadow: 0 3px 8px rgba(0,0,0,0.05);
            }

            /* Card header */
            .card-header {
              background: #f7fbfb;          /* very light healthcare teal tone */
              border-bottom: 2px solid #4d729f;
              border-radius: 12px 12px 0 0;
              padding: 1rem 1.25rem;
            }
            .card-header h3 {
              font-size: 1.1rem;
              margin: 0;
              color: #333;
            }
            .card-header b {
              color: #4ac0c0;
            }

            /* Card body */
            .card-body {
              background-color: #fff;
              border-radius: 0 0 12px 12px;
              padding-left: 10px;
              padding-right: 10px;
            }

            @media (min-width: 768px) {
                .navbar-nav {
                    margin: revert !important;
                }
            }

            .select2-container{
                z-index: 1060;
            }
        </style>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="margin-bottom: 0px !important;">
                <ul class="navbar-nav" style="width: 100%;">
                    <img src="{{ asset($logo ?? "images/logo.png") }}" alt="LOGO" height="40">

                    <span style="font-family: 'Poppins', sans-serif; color: #f8f9fa; margin-left: 10px; font-size: 20px; font-weight: bold;">
                        Appointment System
                    </span>
                </ul>
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
                            <section class="col-md-10 col-md-offset-1">
                                <div class="card">

                                    <div class="card-header d-flex align-items-center">
                                        <div class="pull-right">
                                            <a class="btn btn-default btn-xs" data-toggle="tooltip" title="Create Appointment" onClick="create()">
                                                <span class="fa fa-plus fa-sm"> Create Appointment</span>
                                            </a>
                                        </div>

                                        <br>
                                    </div>

                                    <div class="card-body">
                                        <br>
                                        <table class="table table-bordered table-beautiful" id="table">
                                            <thead>
                                              <tr>
                                                <th>#</th>
                                                <th>Rank</th>
                                                <th>Name</th>
                                                <th>Purpose of Visit</th>
                                                <th>Person to Visit</th>
                                                <th>Availability</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Waiting time</th>
                                                <th>Status</th>
                                                <th style="width: 200px;">Action</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>    

                </section>
            </div>
        </div>

        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/moment.js') }}"></script>
        <script src="{{ asset('js/adminlte.min.js') }}"></script>
        <script src="{{ asset('js/swal.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
        <script src="{{ asset('js/datatables.js') }}"></script>
        <script src="{{ asset('js/select2.min.js') }}"></script>
        <script src="{{ asset('js/flatpickr.js') }}"></script>

        <script>
            var fRank = "%%";
            var fP2V = "%%";

            var table = $('#table').DataTable({
                serverSide: true,
                pageLength: 10,
                ajax: {
                    url: "{{ route('appointment.get') }}",
                    dataType: "json",
                    data: f => {
                        f.fRank = fRank;
                        f.fP2V = fP2V;
                        f.load = ['user'];
                    }
                },
                columns: [
                    { data: 'id'},
                    { data: 'rank'},
                    { data: 'name'},
                    { data: 'purpose_of_visit'},
                    { data: 'user.fname'},
                    { data: 'availability'},
                    { data: 'created_at'},
                    { data: 'created_at'},
                    { data: 'created_at'},
                    { data: 'status'},
                    { data: 'actions'}
                ],
                columnDefs: [
                    {
                        targets: 4,
                        render: (a, b, row) =>{
                            return `${row.user.gender == "Male" ? "Mr." : "Ms."} ${row.user.fname} ${row.user.lname}`;
                        }
                    },
                    {
                        targets: 5,
                        render: availability =>{
                            let colors = {
                                "Available": "green",
                                "Out of office": "gray",
                                "In a meeting": "orange",
                                "Doing dispatch": "orange",
                                "Conducting debriefing": "orange"
                            };

                            return `<span style="color: ${colors[availability]}">${availability}</span>`;
                        }
                    },
                    {
                        targets: 6,
                        render: date =>{
                            return moment(date).format('MMM DD, YYYY');
                        }
                    },
                    {
                        targets: 7,
                        render: date =>{
                            return moment(date).format('hh:mm A');
                        }
                    },
                    {
                        targets: 8,
                        render: (date, b, row) =>{
                            let duration = moment.duration(moment().diff(moment(date)));

                            let hours   = Math.floor(duration.asHours());  // total hours, not just 0–23
                            let minutes = duration.minutes();
                            let seconds = duration.seconds();

                            return `<span class="${row.status == "Waiting" ? "running_time" : ""}">
                                ${String(hours).padStart(2, "0") + ":" + String(minutes).padStart(2, "0") + ":" + String(seconds).padStart(2, "0")}
                            </span>`;
                        }
                    },
                    {
                        targets: 9,
                        render: status =>{
                            let style = {
                                Rejected: "color: red;",
                                Attended: "color: green;",
                                Waiting: ""
                            };

                            return `<span style="${style[status]}">${status}</span>`;
                        }
                    },
                    {
                        targets: [0,1,2,3,4,5,6,7,8,9,10],
                        className: 'text-center'
                    }
                ],
                drawCallback: function(){
                    $('#table tbody').append('<div class="preloader"></div>');
                    // MUST NOT BE INTERCHANGED t-i
                    $('[data-toggle="tooltip"]').tooltip();
                    // initializeActions();
                },
                order: [ [0, 'desc'] ],
            });

            setInterval(function () {
                $('.running_time').each((a,e) => {
                    let [h, m, s] = e.innerText.split(":").map(Number);

                    s++;
                    if (s >= 60) { s = 0; m++; }
                    if (m >= 60) { m = 0; h++; }

                    e.innerText = String(h).padStart(2,"0") + ":" + String(m).padStart(2,"0") + ":" + String(s).padStart(2,"0");
                });
            }, 1000);

            table.on('draw', () => {
                setTimeout(() => {
                    $('.preloader').fadeOut();
                    if(swal.isVisible()){
                        swal.close();
                    }
                }, 800);
            });

            {{-- $('#status').on('change', e => {
                fStatus = e.target.value;
                $('#table').DataTable().ajax.reload();
            }); --}}

            function create(){
                swal({
                    title: "Create Appointment",
                    width: '500px',
                    html: `
                        <hr>
                        <div class="row iRow">
                            <div class="col-md-4 iLabel">
                                Rank
                            </div>
                            <div class="col-md-8 iInput">
                                <select name="rank" class="form-control">
                                    <option value="">Select Rank</option>
                                    @foreach($ranks as $rank)
                                        <option value="{{ $rank->abbr }}">{{ $rank->name }} ({{ $rank->abbr }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div></br>

                        ${input("name", "Name", null, 4,8)}

                        <div class="row iRow">
                            <div class="col-md-4 iLabel">
                                Purpose of visit
                            </div>
                            <div class="col-md-8 iInput">
                                <select name="purpose_of_visit" class="form-control">
                                    <option value="">Purpose of visit</option>
                                    <option value="Report">Report</option>
                                    <option value="New Applicant">New Applicant</option>
                                    <option value="Follow-up">Follow-up</option>
                                    <option value="Leave Pay">Leave Pay</option>
                                    <option value="Debriefing">Debriefing</option>
                                    <option value="Dispatch">Dispatch</option>
                                    <option value="Training">Training</option>
                                    <option value="Medical">Medical</option>
                                    <option value="Sea Service">Sea Service</option>
                                    <option value="Visit">Visit</option>
                                </select>
                            </div>
                        </div></br>

                        <div class="row iRow">
                            <div class="col-md-4 iLabel">
                                
                            </div>
                            <div class="col-md-8 iInput">
                                <select id="staff_department" class="form-control">
                                    <option value="">Select Department</option>
                                    <option value="FLEET-B">Fleet B</option>
                                    <option value="FLEET-C">Fleet C</option>
                                    <option value="FLEET-D">Fleet D</option>
                                    <option value="TOEI">TOEI</option>
                                    <option value="FISHING">Fishing</option>
                                    <option value="Processing">Processing</option>
                                    <option value="Training">Training</option>
                                    <option value="Accounting">Accounting</option>
                                    <option value="Recruitment-Officer">Recruitment</option>
                                </select>
                            </div>
                        </div></br>

                        <div class="row iRow">
                            <div class="col-md-4 iLabel">
                                Person to visit
                            </div>
                            <div class="col-md-8 iInput">
                                <select name="person_to_visit" class="form-control">
                                    <option value="">Select Staff</option>
                                    @foreach($users as $user)
                                        <option class="staff_option {{ str_replace(' ', '-', $user->role) }} {{ str_replace(' ', '-', $user->fleet) }}" value="{{ $user->id }}">
                                            {{ $user->gender == "Male" ? "Mr." : "Ms." }} {{ ucwords(strtolower($user->fname . ' ' . $user->lname)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div></br>

                        <br>

                        ${input("assigned_vessel", "Assigned Vessel", null, 4,8)}

                        ${input("remarks", "Remarks/Notes", null, 4,8)}
                    `,
                    onOpen: () => {
                        {{-- $('[name="rank"], [name="person_to_visit"]').select2(); --}}
                        $('[name="rank"]').select2();
                        $('[name="purpose_of_visit"]').select2({tags:true});

                        $('#staff_department').on('change', e => {
                            $('.staff_option').hide();
                            $(`.${e.target.value}`).show();
                            {{-- $('[name="person_to_visit"]').select2('destroy').select2(); --}}
                        });
                    },
                    preConfirm: () => {
                        swal.showLoading();
                        return new Promise(resolve => {
                            setTimeout(() => {
                                if($('[name="rank"]').val() == "" || $('[name="name"]').val() == "" || $('[name="person_to_visit"]').val() == "" || $('[name="purpose_of_visit"]').val() == ""){
                                    swal.showValidationError('Rank, Name, Purpose, and Person to visit is required');
                                }
                            resolve()}, 500);
                        });
                    },
                }).then(result => {
                    if(result.value){
                        $.ajax({
                            url: "{{ route("appointment.store") }}",
                            type: "POST",
                            data: {
                                rank: $('[name="rank"]').val(),
                                name: $('[name="name"]').val(),
                                person_to_visit: $('[name="person_to_visit"]').val(),
                                purpose_of_visit: $('[name="purpose_of_visit"]').val(),
                                assigned_vessel: $('[name="assigned_vessel"]').val(),
                                remarks: $('[name="remarks"]').val(),
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: result => {
                                ss("Successfully created appointment");
                                reload();
                            }
                        })
                    }
                })
            }

            function view(id){
                $.ajax({
                    url: "{{ route('appointment.get') }}",
                    data: {
                        where: ["id", id]
                    },
                    success: result => {
                        let appointment = JSON.parse(result)[0];

                        swal({
                            title: "Appointment Details",
                            width: '500px',
                            html: `
                                <hr>

                                ${input("rank", "Rank", appointment.rank, 4,8, null, 'disabled')}
                                ${input("name", "Name", appointment.name, 4,8, null, 'disabled')}
                                ${input("purpose_of_visit", "Purpose of visit", appointment.purpose_of_visit, 4,8, null, 'disabled')}
                                ${input("person_to_visit", "Person to visit", appointment.person_to_visit, 4,8, null, 'disabled')}
                                ${input("assigned_vessel", "Assigned Vessel", appointment.assigned_vessel, 4,8, null, 'disabled')}
                                ${input("created_at", "Created On", moment(appointment.created_at).format('MMM DD, YYYY hh:mm A'), 4,8, null, 'disabled')}

                                <br>

                                ${input("remarks", "Remarks/Notes", appointment.remarks, 4,8)}
                            `,
                            confirmButtonText: "Update",
                            showCancelButton: true
                        }).then(result => {
                            if(result.value){
                                $.ajax({
                                    url: "{{ route("appointment.update") }}",
                                    type: "POST",
                                    data: {
                                        id: appointment.id,
                                        rank: $('[name="rank"]').val(),
                                        name: $('[name="name"]').val(),
                                        person_to_visit: $('[name="person_to_visit"]').val(),
                                        purpose_of_visit: $('[name="purpose_of_visit"]').val(),
                                        assigned_vessel: $('[name="assigned_vessel"]').val(),
                                        remarks: $('[name="remarks"]').val(),
                                        _token: $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: result => {
                                        ss("Successfully updated appointment");
                                        reload();
                                    }
                                })
                            }
                        })
                    }
                })
            }

            function reject(id){
                sc("Confirmation", "Are you sure you want to REJECT?", result => {
                    if(result.value){
                        swal.showLoading();
                        update({
                            url: "{{ route('appointment.update') }}",
                            data: {
                                id: id,
                                status: "Rejected",
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            message: "Success"
                        }, () => {
                            reload();
                        })
                    }
                });
            }

            function attend(id){
                sc("Confirmation", "Are you sure you want to attend to crew?", result => {
                    if(result.value){
                        swal.showLoading();
                        update({
                            url: "{{ route('appointment.update') }}",
                            data: {
                                id: id,
                                status: "Attended",
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            message: "Success"
                        }, () => {
                            reload();
                        })
                    }
                });
            }

            $(document).ready(() => {
            })

            function checkNotif(){
                $.ajax({
                    url: "{{ route('appointment.get') }}",
                    data: {
                        where: ["person_to_visit", {{ auth()->user()->id }}],
                        where2: ["read", 0],
                        read: true
                    },
                    success: result => {
                        result = JSON.parse(result);

                        if(result.length){
                            notif(result.length);
                        }
                    }
                })
            }
            checkNotif();

            setInterval(function () {
                checkNotif();
            }, 30000);

            function notif(length){
                if (Notification.permission === "granted") {
                  showNotification();
                } else if (Notification.permission !== "denied") {
                  Notification.requestPermission().then(permission => {
                    if (permission === "granted") {
                      showNotification();
                    }
                  });
                }

                function showNotification() {
                  new Notification("Appointment Alert!", {
                    body: `You have ${length} new appointment`,
                    icon: "images/logo_old.png" // optional
                  });
                }
            }
        </script>
    </body>
</html>