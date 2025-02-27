@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
				</div>

                <div class="table-responsive">
    				<div class="box-body">
    					<table class="table table-hover table-bordered" id="table" style="width: 100%;">
    						<thead>
    							<tr>
    								<th>#</th>
    								<th>Status</th>
                                    <th>Rank</th>
    								<th>Last Name</th>
    								<th>First Name</th>
    								<th>Age</th>
    								<th>Contact</th>
                                    <th>Last Vessel</th>
                                    <th>Last Sign Off</th>
    								<th>Fleet</th>
                                    <th>Remarks</th>
                                    <th>Actions</th>
                                    <th>HIDDEN</th>
    							</tr>
    						</thead>
    					</table>
    				</div>
                </div>

				<div class="box-footer clearfix">
				</div>

			</div>
		</section>
	</div>

    {{-- PHOTO VIEWER --}}
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="pswp__bg"></div>

        <div class="pswp__scroll-wrap">
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>

            <div class="pswp__ui pswp__ui--hidden">

                <div class="pswp__top-bar">

                    <div class="pswp__counter"></div>

                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                    <button class="pswp__button pswp__button--share" title="Share"></button>
                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                          <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                          </div>
                        </div>
                    </div>
                </div>

                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div> 
                </div>

                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                </button>

                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                </button>

                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

@push('after-styles')
	<link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}">

    {{-- PHOTO VIWER --}}
    <link rel="stylesheet" href="{{ asset('css/photoswipe.css') }}">
    <link rel="stylesheet" href="{{ asset('css/photoswipe-default-skin.css') }}">

	<style>
		#table img{
			width: 60px;
			height: 60px;
		}

		.w50{
			width: 60px !important;
		}

        .w100{
            width: 150px;
            padding: 3px 3px 3px 3px !important;
        }

        [data-status="Lined-Up"]{
            color: orange;
        }

        [data-status="On Board"]{
            color: green;
        }

        .select2-selection__choice{
            background-color: #f76c6b !important;
        }

        .select2-selection__choice__remove{
            color: black !important;
        }

        .clabel{
            text-align: right;
        }

        .clabel2{
            text-align: right;
        }

        .col-md-7 .select2{
            margin-top: 8px;
        }

        #table .btn{
            margin-bottom: 3px !important;
        }

        .swal2-content .col-md-6 h4{
            text-align: left;
        }

        .file-buttons{
            text-align: right;
        }

        .form-group{
            text-align: left;
        }

        .puwy{
            margin-top: 20px !important;
        }

        .tab-pane .col-md-1{
            padding-left: 0px;
            padding-right: 10px;
        }

        .tab-pane .col-md-2{
            padding-left: 0px;
            padding-right: 10px;
        }

        .tab-pane .col-md-3{
            padding-left: 0px;
            padding-right: 10px;
        }

        .tab-pane .col-md-6{
            padding-left: 0px;
            padding-right: 10px;
        }

        .tab-pane .col-md-8{
            padding-left: 0px;
            padding-right: 10px;
        }

        .tab-pane h3{
            margin-left: -20px;
        }

        .checkbox input{
            position: inherit !important;
        }

        .rlu{
            background-color: #f76c6b;
            border-color: #f76c6b;
        }

        table .btn{
            width: 39.22px;
        }

        .box-body{
            margin: 0px 0px 0px 10px !important;
        }

        th{
            text-align: center;
        }

        .tss{
            font-size: 9px;
        }

        .tss2{
            font-size: 14px;
        }

        .tss2 td{
            vertical-align: middle !important;
        }

        .modal thead tr, .tss thead tr{
            background-color: #ffddcc !important;
        }

        .modal thead tr, .tss2 thead tr{
            background-color: #ffddcc !important;
        }

        .custom-striped tr:nth-child(4n+3), .custom-striped tr:nth-child(4n+4) {
            background-color: #fdeee6;
        }

        .custom-striped td{
            padding-top: 1px !important;
            padding-bottom: 1px !important;
        }
	</style>
@endpush

@push('before-scripts')
	<script src="{{ asset('js/datatables.js') }}"></script>
	<script src="{{ asset('js/moment.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/checklist.js') }}"></script>

    {{-- PHOTOVIEWER --}}
    <script src="{{ asset('js/photoswipe.js') }}"></script>
    <script src="{{ asset('js/photoswipe-ui-default.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>
@endpush

@push('after-scripts')
	<script>
        var fFname = "";
        var fLname = "";
        var fRanks = [];
        var remark = "withdraw";
        var fMin_age = null;
        var fMax_age = null;
        
        // var size = "%%";
        // var owner = "%%";
        // var engine = "%%";
        var fStatus = "%%";
        var fUsv = "";
        var fFleet = "%%";

        // INIT DATA FROM SESSION
        fRanks = "{{ session('fRanks') }}";
        fMin_age = "{{ session('fMin_age') }}";
        fMax_age = "{{ session('fMax_age') }}";
        fFname = "{{ session('fFname') }}";
        fLname = "{{ session('fLname') }}";
        fStatus = "{{ session('fStatus') ?? "%%" }}";
        fFleet = "{{ session('fFleet') ?? "%%" }}";

        swal({
            title: 'Loading',
            timer: 1500
        });
        swal.showLoading();
		var table = $('#table').DataTable({
            serverSide: true,
            tabIndex: -1,
            ajax: {
                url: '{{ route('datatables.applications') }}',
                type: 'post',
                data: f => {
                    f.filters = getFilters();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'pas', name: 'pas' },
                { data: 'rank', name: 'rank' },
                { data: 'user.lname', name: 'user.lname' },
                { data: 'user.fname', name: 'user.fname' },
                { data: 'age', name: 'age' },
                { 
                    data: 'user.contact',
                    name: 'user.contact',
                    visible: false
                },
                { data: 'last_vessel.vessel_name', name: 'last_vessel.vessel_name' },
                { data: 'last_vessel.sign_off', name: 'last_vessel.sign_off' },
                { data: 'user.fleet', name: 'user.fleet' },
                { data: 'remarks', name: 'remarks' },
                { data: 'actions', name: 'actions' },
                { data: 'hidden', name: 'hidden', visible: false },
            ],
            columnDefs: [
                {
                    targets: 1,
                    render: function(status, display, row){
                        if(status == "Lined-Up" || status == "On Board"){
                            status += `<br><b data-status="${status}">${(row.pro_app.vessel) ? row.pro_app.vessel.name : "-"}</b>`;
                        }

                        return status;
                    },
                },
                {
                    targets: 0,
                    render: function(id, display, data){
                        return id;
                    },
                },
                {
                    targets: 3,
                    render: function(row){
                        return row;
                    },
                },
                {
                    targets: 8,
                    render: function(last_disembark){
                        return last_disembark ? moment(last_disembark).format('MMM DD, YYYY') : "-";
                    },
                },
                {
                    targets: 11,
                    render: function (a, b, data){
                        return `
                            <a class="btn btn-success btn-search" data-toggle="tooltip" title="View Info" data-id="${data.id}">
                                <span class="fa fa-search" data-id="${data.id}"></span>
                            </a>
                        `;
                    }
                },
                {
                    targets: 10,
                    width: 85,
                    render: function(remarks, display, data){
                        remarks = remarks;
                        let selected = "";

                        remarks.forEach(remark => {
                            selected += `
                                <option value="${remark}" selected>${remark}</option>
                            `;
                        });

                        return `
                            <select id="table-select-${data.id}" data-id="${data.id}" multiple disabled>
                                ${selected}
                            </select>
                        `;
                    },
                },
            ],
            drawCallback: function(){
                $('#table tbody').append('<div class="preloader"></div>');
                // MUST NOT BE INTERCHANGED t-i
                $('#table select').select2({
                    tags: true,
                    class: 'table-select'
                });

                $('[id^=table-select] + .select2-container').css('width', '100%');
                $('[id^=table-select] + .select2-container .select2-selection').css('border', 'none');

                tooltip();
            	initializeActions();
            },
            order: [],
            @if(session('search'))
                search: {
                    search: "{{ session('search') }}"
                }
            @endif
            // order: [ [0, 'desc'] ],
        });
        
        $('#table_filter input').unbind();
        $('#table_filter input').bind('keyup.DT', e => {
            if(e.which == 13){
                swal('Searching...');
                swal.showLoading();

                table.search($(e.target).val()).draw();
            }
        });

        table.on('draw', () => {
        	setTimeout(() => {
        		$('.preloader').fadeOut();
                if(swal.isVisible()){
                    swal.close();
                }
        	}, 800);
        });

        function getFilters(){
            return {
                fRanks: fRanks,
                fMin_age: fMin_age,
                fMax_age: fMax_age,
                fFname: fFname,
                fLname: fLname,
                // size: size,
                // owner: owner,
                // engine: engine,
                remark: remark,
                fStatus: fStatus,
                fFleet: fFleet
            };
        }

        // MUST BE HERE BECAUSE IF INSIDE INITIALIZE, INCREMENT/DECREMENT WILL STACK
        let tabCtr = 1;
        window.addEventListener("keydown", function (event) {
            if(!$('#infoTabs').is(':visible')){
                const key = event.key;

                if((key == "V" || key == "v") && event.altKey){
                    $(`tbody tr:nth-child(${tabCtr})`).find('.btn-search').click();
                }   
                else if((key == "E" || key == "e") && event.altKey){
                    $(`tbody tr:nth-child(${tabCtr})`).find('.btn-primary').click();
                }
                else if(key == "ArrowUp"){
                    tabCtr--;
                    $(`tbody tr`).removeClass('selected');
                    $(`tbody tr:nth-child(${tabCtr})`).addClass('selected');
                }
                else if(key == "ArrowDown"){
                    tabCtr++;
                    $(`tbody tr`).removeClass('selected');
                    $(`tbody tr:nth-child(${tabCtr})`).addClass('selected');
                }
                else if(key == "ArrowRight"){
                    tabCtr = 1;
                    $('#table_next').click();
                }
                else if(key == "ArrowLeft"){
                    tabCtr = 1;
                    $('#table_previous').click();
                }
            }
        }, true);

        function initializeActions(){
            $(`tbody tr:first-child`).addClass('selected');

            window.addEventListener("keydown", function (event) {
                if(!$('#infoTabs').is(':visible')){
                    const key = event.key;
                }
            }, true);

            $('[data-original-title="View Files"]').on('click', application => {
                let id = $(application.target).data('id');
                swal('Loading Files');
                swal.showLoading('Loading Files');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('applications.getFiles') }}',
                    data:{id: id},
                    dataType: 'json',
                    success: result => {
                        setTimeout(() => {
                            showFiles(id, result[1], result[0]);
                        }, 500);
                    }
                })
            });

            $('[data-original-title="View Info"]').on('click', application => {
                let id = $(application.target).data('id');

                $.ajax({
                    url: '{{ route('applications.getAllInfo') }}',
                    data: {id: id},
                    success: applicant => {
                        applicant = JSON.parse(applicant);
                        swal({
                            width: '90%',
                            animation: false,
                            position: 'top',
                            html: `
                                <ul class="nav nav-pills" role="tablist" id="infoTabs">
                                    <li role="presentation" class="active">
                                        <a href=".pinfo" role="tab" data-toggle="pill"><u>P</u>ersonal Info</a>
                                    </li>
                                    <li role="presentation">
                                        <a href=".ids" role="tab" data-toggle="pill"><u>T</u>ravel Documents</a>
                                    </li>
                                    <li role="presentation">
                                        <a href=".flags" role="tab" data-toggle="pill"><u>F</u>lag Documents</a>
                                    </li>
                                    <li role="presentation">
                                        <a href=".l_cs" role="tab" data-toggle="pill"><u>N</u>ational Documents</a>
                                    </li>
                                    <li role="presentation">
                                        <a href=".med_certs" role="tab" data-toggle="pill"><u>M</u>edical Certificates</a>
                                    </li>
                                    <li role="presentation">
                                        <a href=".meds" role="tab" data-toggle="pill">Medical <u>H</u>istory</a>
                                    </li>
                                    <li role="presentation">
                                        <a href=".ss" role="tab" data-toggle="pill"><u>S</u>ea Services</a>
                                    </li>
                                    <li role="presentation">
                                        <a href=".eval" role="tab" data-toggle="pill">E<u>v</u>aluations</a>
                                    </li>
                                </ul>
                                <br><br>

                                <div class="tab-content">
                                  <div role="tabpanel" class="tab-pane fade in pinfo active">a</div>
                                  <div role="tabpanel" class="tab-pane fade ids">c</div>
                                  <div role="tabpanel" class="tab-pane fade flags">c</div>
                                  <div role="tabpanel" class="tab-pane fade l_cs">c</div>
                                  <div role="tabpanel" class="tab-pane fade med_certs">d</div>
                                  <div role="tabpanel" class="tab-pane fade meds">d</div>
                                  <div role="tabpanel" class="tab-pane fade ss">d</div>
                                  <div role="tabpanel" class="tab-pane fade eval reco">d</div>
                                </div>
                            `,
                            onOpen: () => {
                                fillTab1(applicant);
                                fillTab3(applicant);
                                fillTab4(applicant);
                                fillTab5(applicant);
                                fillTab6(applicant);
                                fillTab7(applicant);
                                fillTab8(applicant);
                                fillTab10(applicant);
                            }
                        }).then(() => {
                            $('[type="search"]:first').focus();
                        });
                    }
                })
                 
            });

            window.addEventListener("keydown", function (event) {
                if($('#infoTabs').is(':visible')){
                    const key = event.key;

                    if(key == "P" || key == "p"){
                        $('[href=".pinfo"]').click();
                    }
                    else if(key == "T" || key == "t"){
                        $('[href=".ids"]').click();
                    }
                    else if(key == "F" || key == "f"){
                        $('[href=".flags"]').click();
                    }
                    else if(key == "N" || key == "n"){
                        $('[href=".l_cs"]').click();
                    }
                    else if(key == "M" || key == "m"){
                        $('[href=".med_certs"]').click();
                    }
                    else if(key == "H" || key == "h"){
                        $('[href=".meds"]').click();
                    }
                    else if(key == "S" || key == "s"){
                        $('[href=".ss"]').click();
                    }
                    else if(key == "V" || key == "v"){
                        $('[href=".eval"]').click();
                    }
                }
            }, true);
            $('[type="search"]:first').focus();
	    }

        // CREW INFO
        function fillTab1(applicant){
            let ebs = Object.entries(applicant.educational_background);
            let ebString = ``;

            ebs.forEach(eb => {
                eb = eb[1];
                ebString += `
                    <tr>
                        <td>${eb.type}</td>
                        <td>${eb.course}</td>
                        <td>${eb.year}</td>
                        <td>${eb.school}</td>
                        <td>${eb.address}</td>
                    </tr>
                `;
            });

            let fds = Object.entries(applicant.family_data);
            let fdString = ``;

            fds.forEach(fd => {
                fd = fd[1];
                fdString += `
                    <tr>
                        <td>${fd.type}</td>
                        <td>${fd.fname} ${fd.lname}</td>
                        <td>${fd.birthday ? moment(fd.birthday).format("MMM DD, YYYY") : "-"}</td>
                        <td>${fd.birthday ? moment().diff(fd.birthday, 'years') : "-"}</td>
                        <td>${fd.occupation}</td>
                        <td>${fd.email}</td>
                        <td>${fd.address}</td>
                    </tr>
                `;
            });

            let string = `
                <div class="box box-success" style="font-size: 15px;">
                    <div class="box-body">

                        <div class="row">
                            <br>
                            <div class="col-md-2" style="text-align: center;">
                                <img src="${applicant.user.avatar}" width="200px;" height="200px;">
                                <br>
                                Date Uploaded: ${moment().subtract(6, 'days').format('MMM DD, YYYY')}
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="fname">First Name</label>
                                    <input type="text" class="form-control" id="fname" value="${applicant.user.fname}" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="mname">Middle Name</label>
                                    <input type="text" class="form-control" id="mname" value="${applicant.user.mname}" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="lname">Last Name</label>
                                    <input type="text" class="form-control" id="lname" value="${applicant.user.lname}" readonly>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="suffix">Suffix</label>
                                    <input type="text" class="form-control" id="suffix" value="${applicant.user.suffix ?? "---"}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="birthday">Birth Date</label>
                                    <input type="text" class="form-control" id="birthday" value="${moment(applicant.user.birthday).format('MMM DD, YYYY')}" readonly>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="age">Age</label>
                                    <input type="text" class="form-control" id="age" value="${moment().diff(moment(applicant.user.birthday), 'years')}" readonly>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="birth_place">Birth Place</label>
                                    <input type="text" class="form-control" id="birth_place" value="${applicant.birth_place ?? "---"}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="religion">Religion</label>
                                    <input type="text" class="form-control" id="religion" value="${applicant.religion ?? "---"}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" value="${applicant.user.address ?? "---"}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="contact">Contact Number</label>
                                    <input type="text" class="form-control" id="contact" value="${applicant.user.contact ?? "---"}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="provincial_address">Provincial Address</label>
                                    <input type="text" class="form-control" id="provincial_address" value="${applicant.provincial_address ?? "---"}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="provincial_contact">Provincial Contact Number</label>
                                    <input type="text" class="form-control" id="provincial_contact" value="${applicant.provincial_contact ?? "---"}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" value="${applicant.user.email ?? "---"}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2" style="text-align: left;">
                                <label for="gender">Gender</label>
                                </br>

                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="male" ${applicant.user.gender == "Male" ? "Checked" : ""}> Male
                                </label>
                                &nbsp; &nbsp;
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="female" ${applicant.user.gender == "Female" ? "Checked" : ""}> Female
                                </label>
                                <br>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="waistline">Waistline (inch)</label>
                                    <input type="text" class="form-control" id="waistline" value="${applicant.waistline ?? "---"}" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="shoe_size">Shoe Size (cm)</label>
                                    <input type="text" class="form-control" id="shoe_size" value="${applicant.shoe_size ?? "---"}" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="clothes_size">Clothes Size (cm)</label>
                                    <input type="text" class="form-control" id="clothes_size" value="${applicant.clothes_size ?? "---"}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="height">Height (cm)</label>
                                    <input type="text" class="form-control" id="height" value="${applicant.height ?? "---"}" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Weight">Weight (kg)</label>
                                    <input type="text" class="form-control" id="Weight" value="${applicant.weight ?? "---"}" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="bmi">BMI</label>
                                    <input type="text" class="form-control" id="bmi" value="${Math.round( (applicant.weight / ((applicant.height / 100) * (applicant.height / 100))) * 10 ) / 10}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="blood_type">Blood Type</label>
                                    <input type="text" class="form-control" id="blood_type" value="${applicant.blood_type ?? "---"}" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="civil_status">Civil Status</label>
                                    <input type="text" class="form-control" id="civil_status" value="${applicant.civil_status ?? "---"}" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="eye_color">Eye Color</label>
                                    <input type="text" class="form-control" id="eye_color" value="${applicant.eye_color ?? "---"}" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="tin">TIN</label>
                                    <input type="text" class="form-control" id="tin" value="${applicant.tin ?? "---"}" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="sss">SSS</label>
                                    <input type="text" class="form-control" id="sss" value="${applicant.sss ?? "---"}" readonly>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h2 style="text-align: left; font-weight: bold;">
                            Educational Background
                        </h2>

                        <div class="row">
                            <div class='col-md-12'>
                                <table class="table table-bordered tss2 table-striped">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Course</th>
                                            <th>Year</th>
                                            <th>School</th>
                                            <th>Address</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        ${ebString != "" ? ebString : "<tr><td colspan='5'>No Recorded Educational Background</td></tr>"}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <hr>
                        <h2 style="text-align: left; font-weight: bold;">
                            Family Data
                        </h2>

                        <div class="row">
                            <div class='col-md-12'>
                                <table class="table table-bordered tss2 table-striped">
                                    <thead>
                                        <tr>
                                            <th>Relation</th>
                                            <th>Name</th>
                                            <th>Birthday</th>
                                            <th>Age</th>
                                            <th>Occupation</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        ${fdString != "" ? fdString : "<tr><td colspan='7'>No Recorded Family Data</td></tr>"}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            $('.pinfo').html(string);
        }

        function fillTab3(applicant){
            let ids = Object.entries(applicant.document_id);
            let temp = ``;

            ids.forEach(id => {
                id = id[1];
                file = "";

                if(id.file){
                    try{
                        id.file = JSON.parse(id.file);
                        id.file = id.file[0];
                    }
                    catch(error){
                        id.file = id.file;
                    }

                    file = `
                        <a class="btn btn-success" data-toggle="tooltip" title="View" onClick="viewFile('${id.id}', ${applicant.id},  'ids')">
                            <span class="fa fa-search">
                        </span></a>
                        `;
                }

                temp += `
                    <tr>
                        <td>${id.type}</td>
                        <td>${id.issuer ?? "-"}</td>
                        <td>${id.number ?? "-"}</td>
                        <td>${id.issue_date != null ? moment(id.issue_date).format("MMM DD, YYYY") : "-"}</td>
                        <td>${id.expiry_date != null ? moment(id.expiry_date).format("MMM DD, YYYY") : "-"}</td>
                        <td>${file}</td>
                    </tr>
                `;
            });

            $('.ids').html(`
                <div class="row">
                    <div class='col-md-12'>
                        <table class="table table-bordered tss2 table-striped">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Issuer</th>
                                    <th>No</th>
                                    <th>Issue Date</th>
                                    <th>Expiry Date</th>
                                    <th style="width: 195px;">File</th>
                                </tr>
                            </thead>

                            <tbody>
                                ${temp != "" ? temp : "<tr><td colspan='6'>No Recorded Travel Documents</td></tr>"}
                            </tbody>
                        </table>
                    </div>
                </div>
            `);
        }

        function fillTab4(applicant){
            let flags = Object.entries(applicant.document_flag);
            let temp = ``;

            flags.forEach(flag => {
                flag = flag[1];
                file = "";

                if(flag.file){
                    try{
                        flag.file = JSON.parse(flag.file);
                        flag.file = flag.file[0];
                    }
                    catch(error){
                        flag.file = flag.file;
                    }

                    file = `
                        <a class="btn btn-success" data-toggle="tooltip" title="View" onClick="viewFile('${flag.id}', ${applicant.id}, 'flags')">
                            <span class="fa fa-search">
                        </span></a>
                        `;
                }

                temp += `
                    <tr>
                        <td>${flag.type}</td>
                        <td>${flag.country ?? "-"}</td>
                        <td>${flag.number ?? "-"}</td>
                        <td>${flag.issue_date != null ? moment(flag.issue_date).format("MMM DD, YYYY") : "-"}</td>
                        <td>${flag.expiry_date != null ? moment(flag.expiry_date).format("MMM DD, YYYY") : "-"}</td>
                        <td>${file}</td>
                    </tr>
                `;
            });

            $('.flags').html(`
                <div class="row">
                    <div class='col-md-12'>
                        <table class="table table-bordered tss2 table-striped">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Country</th>
                                    <th>No</th>
                                    <th>Issue Date</th>
                                    <th>Expiry Date</th>
                                    <th style="width: 195px;">File</th>
                                </tr>
                            </thead>

                            <tbody>
                                ${temp != "" ? temp : "<tr><td colspan='6'>No Recorded Flag Documents</td></tr>"}
                            </tbody>
                        </table>
                    </div>
                </div>
            `);
        }

        function fillTab5(applicant){
            let lcs = Object.entries(applicant.document_lc);
            let temp = ``;

            lcs.forEach(lc => {
                lc = lc[1];
                file = "";

                if(lc.file){
                    try{
                        lc.file = JSON.parse(lc.file);
                        lc.file = lc.file[0];
                    }
                    catch(error){
                        lc.file = lc.file;
                    }

                    file = `
                        <a class="btn btn-success" data-toggle="tooltip" title="View" onClick="viewFile('${lc.id}', ${applicant.id}, 'l_cs')">
                            <span class="fa fa-search">
                        </span></a>
                        `;
                }

                temp += `
                    <tr>
                        <td>${lc.type}</td>
                        <td>${lc.issuer ?? "-"}</td>
                        <td>${lc.no ?? "-"}</td>
                        <td>${lc.issue_date != null ? moment(lc.issue_date).format("MMM DD, YYYY") : "-"}</td>
                        <td>${lc.expiry_date != null ? moment(lc.expiry_date).format("MMM DD, YYYY") : "-"}</td>
                        <td>${lc.regulation != "[]" ? JSON.parse(lc.regulation) : "-"}</td>
                        <td>${file}</td>
                    </tr>
                `;
            });

            $('.l_cs').html(`
                <div class="row">
                    <div class='col-md-12'>
                        <table class="table table-bordered tss2 table-striped">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Issuer</th>
                                    <th>No</th>
                                    <th>Issue Date</th>
                                    <th>Expiry Date</th>
                                    <th>Regulation</th>
                                    <th style="width: 195px;">File</th>
                                </tr>
                            </thead>

                            <tbody>
                                ${temp != "" ? temp : "<tr><td colspan='6'>No Recorded National Documents</td></tr>"}
                            </tbody>
                        </table>
                    </div>
                </div>
            `);
        }

        function fillTab6(applicant){
            let medCerts = applicant.document_med_cert.sort(function(a,b){
              return new Date(b.created_at) - new Date(a.created_at);
            });

            let tempMcs = Object.entries(applicant.document_med_cert);
            let temp = ``;

            let mcs = [];
            let order = ["MEDICAL CERTIFICATE", "FLAG MEDICAL", "DRUG AND ALCOHOL TEST", "YELLOW FEVER", "POLIO VACCINE (IPV)", "POLIO", "COVID"];

            order.forEach(type => {
                let bool = false;
                tempMcs.forEach((mc, index) => {
                    if(mc[1].type == type){
                        mcs.push(mc);
                        tempMcs.splice(index, 1);
                        bool = true;
                    }
                    else if(mc[1].type == "COVID"){
                        if(mc[1].type.contains("COVID")){
                            mcs.push(mc);
                            tempMcs.splice(index, 1);
                            bool = true;
                        }
                    }
                });
            });

            mcs = mcs.concat(tempMcs);

            mcs.forEach(mc => {
                mc = mc[1];
                file = "";

                if(mc.file){
                    try{
                        mc.file = JSON.parse(mc.file);
                        mc.file = mc.file[0];
                    }
                    catch(error){
                        mc.file = mc.file;
                    }

                    file = `
                        <a class="btn btn-success" data-toggle="tooltip" title="View" onClick="viewFile('${mc.id}', ${applicant.id}, 'med_certs')">
                            <span class="fa fa-search">
                        </span></a>
                        `;
                }

                temp += `
                    <tr>
                        <td>${mc.type}</td>
                        <td>${mc.number ?? "-"}</td>
                        <td>${mc.clinic ?? "-"}</td>
                        <td>${mc.issue_date != null ? moment(mc.issue_date).format("MMM DD, YYYY") : "-"}</td>
                        <td>${mc.expiry_date != null ? moment(mc.expiry_date).format("MMM DD, YYYY") : "-"}</td>
                        <td>${file}</td>
                    </tr>
                `;
            });

            $('.med_certs').html(`
                <div class="row">
                    <div class='col-md-12'>
                        <table class="table table-bordered tss2 table-striped">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Number</th>
                                    <th>Clinic/Hospital</th>
                                    <th>Issue Date</th>
                                    <th>Expiry Date</th>
                                    <th style="width: 195px;">File</th>
                                </tr>
                            </thead>

                            <tbody>
                                ${temp != "" ? temp : "<tr><td colspan='6'>No Recorded Medical Certificates</td></tr>"}
                            </tbody>
                        </table>
                    </div>
                </div>
            `);
        }

        function fillTab7(applicant){
            let mhs = Object.entries(applicant.document_med);
            let temp = "";

            mhs.forEach(mh => {
                mh = mh[1];
                file = "";

                if(mh.file){
                    try{
                        mh.file = JSON.parse(mh.file);
                        mh.file = mh.file[0];
                    }
                    catch(error){
                        mh.file = mh.file;
                    }

                    file = `
                        <a class="btn btn-success" data-toggle="tooltip" title="View" onClick="viewFile('${mh.id}', ${applicant.id}, 'meds')">
                            <span class="fa fa-search">
                        </span></a>
                        `;
                }

                temp += `
                    <tr>
                        <td>${mh.type}</td>
                        <td>${mh.with_mv == "Yes" ? mh.with_mv : '-'}</td>
                        <td>${mh.year ?? "-"}</td>
                        <td>${mh.case_remarks ?? "-"}</td>
                        <td>${file}</td>
                    </tr>
                `;
            });

            $('.meds').html(`
                <div class="row">
                    <div class='col-md-12'>
                        <table class="table table-bordered tss2 table-striped">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>With Medication?</th>
                                    <th>Year</th>
                                    <th>Remarks</th>
                                    <th style="width: 195px;">File</th>
                                </tr>
                            </thead>

                            <tbody>
                                ${temp != "" ? temp : "<tr><td colspan='6'>No Recorded Medical History</td></tr>"}
                            </tbody>
                        </table>
                    </div>
                </div>
            `);
        }

        function fillTab8(applicant){
            let sss = Object.entries(applicant.sea_service);

            if(applicant.lup){
                $.ajax({
                    url: "{{ route('vessels.get2') }}",
                    data: {
                        cols: "*",
                        where: ["id", applicant.pro_app.vessel_id]
                    },
                    success: vessel => {
                        vessel = JSON.parse(vessel)[0];

                        $.ajax({
                            url: "{{ route('applications.getRanks') }}",
                            success: categories => {
                                categories = JSON.parse(categories);
                                let cRrank = null;

                                Object.entries(categories).forEach(category => {
                                    let ranks = category[0];
                                    
                                    categories[ranks].forEach(rank => {
                                        if(rank.id == applicant.pro_app.rank_id){
                                            cRrank = rank.name;
                                        }
                                    });
                                });

                                let temp = {
                                    vessel_name: vessel.name,
                                    rank: cRrank,
                                    vessel_type: vessel.type,
                                    gross_tonnage: vessel.gross_tonnage,
                                    engine_type: vessel.engine,
                                    flag: vessel.flag,
                                    trade: vessel.trade,
                                    manning_agent: vessel.manning_agent,
                                    principal: "",
                                    sign_on: applicant.lup.joining_date,
                                    smc: vessel.smc,
                                    remarks: "On Board",
                                    file: null
                                };

                                sss = [["0", temp]].concat(sss);
                                forFillTab8(sss);
                            }
                        })
                    }
                })
            }
            else{
                forFillTab8(sss);
            }
        }

        function forFillTab8(sss){
            let temp = ``;

            sss.forEach((ss, i) => {
                ss = ss[1];

                let actions = "";
                if(ss.file){
                    actions += `
                        <a class="btn btn-success" data-toggle="tooltip" title="View" href="${ss.file}" target="_blank">
                            <span class="fa fa-search"></span>
                        </a>
                    `;
                }

                temp += `
                    <tr>
                        <td>${i+1}</td>
                        <td>${ss.vessel_name}</td>
                        <td>${ss.rank}</td>
                        <td>${ss.vessel_type}</td>
                        <td>${ss.gross_tonnage}</td>
                        <td>${ss.engine_type}</td>
                        <td>${ss.flag}</td>
                        <td>${ss.trade}</td>
                        <td>${ss.manning_agent}</td>
                        <td>${ss.principal}</td>
                        <td>${ss.sign_on != null ? moment(ss.sign_on).format("MMM DD, YYYY") : "---"}</td>
                        <td>${ss.sign_off != null ? moment(ss.sign_off).format("MMM DD, YYYY") : "---"}</td>
                        <td>${moment(ss.sign_off).diff(moment(ss.sign_on), 'months')}</td>
                        <td>${ss.remarks}</td>
                        <td>${actions}</td>
                    </tr>
                `;
            });

            let string = `
                <div class="box box-success" style="font-size: 15px;">
                    <div class="box-body">
                        <table class="table table-bordered table-striped tss">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Rank</th>
                                    <th>Type</th>
                                    <th>GRT</th>
                                    <th>Engine</th>
                                    <th>Flag</th>
                                    <th>Trade</th>
                                    <th>Manning</th>
                                    <th>Principal</th>
                                    <th>On</th>
                                    <th>Off</th>
                                    <th>MOB</th>
                                    <th>Remarks</th>
                                    <th>Files</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${temp != "" ? temp : `<tr><td colspan="16">No Recorded Sea Service</td></tr>`}
                            </tbody>
                        </table>
                    </div>
                </div>
            `;

            $('.ss').html(string);
        }

        function fillTab10(applicant){
            let evalss = applicant.evaluation;
            let temp = ``;
            let temp1 = ``;
            let temp2 = ``;
            let temp3 = ``;

            evalss.forEach(evals => {
                file = "";

                if(evals.file){
                    try{
                        evals.file = JSON.parse(evals.file);
                        evals.file = evals.file[0];
                    }
                    catch(error){
                        evals.file = evals.file;
                    }

                    let type = evals.type == "Evaluation" ? "eval" : evals.type == "Recommendation" ? "reco" : "comment";

                    file = `
                        <a class="btn btn-success puwy" data-toggle="tooltip" title="View" onClick="viewFile('${evals.id}', ${applicant.id}, 'eval')">
                            <span class="fa fa-search">
                        </span></a>
                        `;
                }

                temp = `
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="vessel">Vessel</label>
                                <input type="text" class="form-control" id="vessel" value="${evals.vessel}" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="text" class="form-control" id="date" value="${toDate(evals.date)}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <input type="text" class="form-control" id="remark" value="${evals.value}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                ${file}
                            </div>
                        </div>
                    </div>
                `;

                if(evals.type == "Evaluation"){
                    temp1 += temp;
                }
                else if(evals.type == "Recommendation"){
                    temp2 += temp;
                }
            })

            let string1 = `
                <div class="box box-success" style="font-size: 15px;">
                    <div class="box-body">
                        <h3 style="text-align: left;"><b>Evaluations</b></h3>
                        ${temp1 != "" ? temp1 : '<h2><b>No Evaluation</b></h2>'}
                        <h3 style="text-align: left;"><b>Recommendations</b></h3>
                        ${temp2 != "" ? temp2 : '<h2><b>No Recommendation</b></h2>'}
                    </div>
                </div>
            `;

            $('.eval').html(string1);
        }

        function viewFile(id, aId, type){
            let imageFormats = ['JPEG', 'JPG', 'PNG', 'GIF'];
            
            $.ajax({
                type: 'POST',
                url: '{{ route('applications.getFiles') }}',
                data: {id: id, type: type},
                allowEscapeKey: false,
                success: files => {
                    let isPDF = (files.includes(".pdf") || files.includes(".PDF")) ? 1 : 0;

                    try{
                        files = JSON.parse(JSON.parse(files).file);
                    }catch(e){
                        files = [JSON.parse(files).file];
                    }

                    if(isPDF){
                        window.open(`files/${aId}/${files[0]}`);
                    }
                    else{
                        images = [];
                        files.forEach((file, i) => {
                            let img = new Image();
                            img.src = `files/${aId}/${file}`;
                            img.onload = () => {
                                images.push({
                                    src: img.src,
                                    w: img.width,
                                    h: img.height,
                                });

                                if(i+1 == files.length){
                                    let gallery = new PhotoSwipe(
                                        $('.pswp')[0], 
                                        PhotoSwipeUI_Default, 
                                        images, 
                                        {
                                            allowPanToNext: true,
                                            escKey: true,
                                            arrowKeys: true,
                                            closeOnScroll: false,
                                            tapToClose: false,
                                            maxSpreadZoom: 6
                                        }
                                    );

                                    gallery.init();
                                }
                            };
                        });
                    }
                }
            })
        }

        function reloadTab(id, aId, type){
            console.log(id, aId, type);
            $(`[data-id="${aId}"].btn-search`).click();
            setTimeout(() => {
                $(`[href='.${type}']`).click();
            }, 1000)
        }

        function showFiles(id, name, files){
            swal({
                title: name + "'s Files",
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                cancelButtonText: 'Exit',
                confirmButtonText: 'Upload Files',
                width: '500px',
                allowOutsideClick: false,
                allowEscapeKey: false,
                html: `
                    <hr style="margin: 5px 0px 5px 0px;" />
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation" class="active">
                            <a href=".idFiles" role="tab" data-toggle="pill">ID</a>
                        </li>
                        <li role="presentation">
                            <a href=".certificateFiles" role="tab" data-toggle="pill">Certificate</a>
                        </li>
                        <li role="presentation">
                            <a href=".medicalFiles" role="tab" data-toggle="pill">Medical</a>
                        </li>
                        <li role="presentation">
                            <a href=".principalFiles" role="tab" data-toggle="pill">Principal</a>
                        </li>
                        <li role="presentation">
                            <a href=".evaluationFiles" role="tab" data-toggle="pill">Evaluation</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in idFiles active"><h3>NO FILES</h3></div>
                        <div role="tabpanel" class="tab-pane fade certificateFiles"><h3>NO FILES</h3></div>
                        <div role="tabpanel" class="tab-pane fade medicalFiles"><h3>NO FILES</h3></div>
                        <div role="tabpanel" class="tab-pane fade principalFiles"><h3>NO FILES</h3></div>
                        <div role="tabpanel" class="tab-pane fade evaluationFiles"><h3>NO FILES</h3></div>
                    </div>
                `,
                onOpen: () => {
                    swal.showLoading();

                    let items = [];
                    let imageFormats = ['JPEG', 'JPG', 'PNG', 'GIF'];
                    let string = [];

                    let total = 0;

                    Object.keys(files).forEach((key, aub) => {
                        string[key] = "<br>";

                        let length = files[key].length;

                        total += length;
                        let temp = [];

                        files[key].forEach((file, index) => {
                            // GET IMAGE DIMENSIONS
                            if(imageFormats.includes(file.name.split('.').pop().toUpperCase())){
                                let img = new Image();
                                img.onload = () => {
                                    items.push({
                                        src: `files/${name}/${file.name}`,
                                        w: img.width,
                                        h: img.height,
                                        i: index
                                    });

                                    data = `data-link="files/${name}/${file.name}" data-index="${items.length}"`;

                                    temp[index] = `
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4>${index + 1}.) ${file.name}</h4>
                                            </div>
                                            <div class="col-md-6 file-buttons">
                                                <a class="btn btn-info preview" ${data} target="_blank">
                                                    <span class="fa fa-search" ${data}}></span>
                                                </a>&nbsp;
                                                <a class="btn btn-success" href="files/${name}/${file.name}" download>
                                                    <span class="fa fa-download"></span>
                                                </a>&nbsp;
                                                <a class="btn btn-danger delete" data-id="${id}" data-name="${name}" data-filename="${file.name}">
                                                    <span class="fa fa-trash" data-id="${id}" data-name="${name}" data-filename="${file.name}"></span>
                                                </a>
                                            </div>
                                        </div>
                                    `;

                                    if((index + 1) == files[key].length && Object.keys(files).length == (aub + 1)){
                                        setTimeout(() => {
                                            $('.preview').on('click', e => {
                                                let file = $(e.target);
                                                
                                                if(imageFormats.includes(file.data('link').split('.').pop().toUpperCase())){
                                                    let gallery = new PhotoSwipe($('.pswp')[0], PhotoSwipeUI_Default, items, {
                                                        index: file.data('index') - 1,
                                                        allowPanToNext: true,
                                                        escKey: true,
                                                        arrowKeys: true
                                                    });

                                                    gallery.init();
                                                }
                                            });

                                            $('.delete').on('click', e => {
                                                let temp = $(e.target);
                                                let data = [
                                                    $('[role="presentation"].active [role="tab"]')[0].innerText,
                                                    id,
                                                    name,
                                                    files
                                                ];
                                                deleteFile(temp.data('id'), temp.data('name'), temp.data('filename'), data);
                                            });
                                        }, (total * 200));
                                    }
                                }
                                img.src = `files/${name}/${file.name}`;
                            }
                            else{
                                data = `data-link="files/${name}/${file.name}" data-index="${items.length}"`;

                                temp[index] = `
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>${index + 1}.) ${file.name}</h4>
                                        </div>
                                        <div class="col-md-6 file-buttons">
                                            <a class="btn btn-success" href="files/${name}/${file.name}" download>
                                                <span class="fa fa-download"></span>
                                            </a>&nbsp;
                                            <a class="btn btn-danger delete" data-id="${id}" data-name="${name}" data-filename="${file.name}">
                                                    <span class="fa fa-trash" data-id="${id}" data-name="${name}" data-filename="${file.name}"></span>
                                            </a>
                                        </div>
                                    </div>
                                `;
                            }
                        });
                        
                        setTimeout(() => {
                            temp.forEach(tempString => {
                                string[key] += tempString;
                            });

                            $(`.${key.toLowerCase()}Files`).html(string[key]);
                            $('.swal2-content .tab-content .first-row').css('text-align', 'left');
                            $('.swal2-content .tab-content .file-buttons').css('text-align', 'right');
                        }, (total * 200));
                    });

                    setTimeout(() => {
                        swal.hideLoading();
                    }, total * 200);
                }
            }).then(result2 => {
                if(result2.value){
                    let data = [
                        $('[role="presentation"].active [role="tab"]')[0].innerText,
                        id,
                        name,
                        files
                    ];

                    uploadFile(id, name, $('[role="presentation"].active [role="tab"]')[0].innerText, data);
                }
            });
        }

        function reShowFiles(data){
            showFiles(data[1], data[2], data[3]);
            $(`[href=".${data[0].toLowerCase()}Files"]`).tab('show');
        }

        function as(aId){
            $.ajax({
                url: '{{ route('applications.get2') }}',
                data:{
                    where: ['applicants.id', aId],
                    cols: ['pa.seniority']
                },
                success: result => {
                    result = JSON.parse(result)[0];
                    swal({
                        title: 'Seniority Level',
                        input: 'range',
                        inputAttributes: {
                            min: 1,
                            max: 10,
                            step: 1
                        },
                        inputValue: result.seniority,
                        confirmButtonText: 'Update',
                        showCancelButton: true,
                        cancelButtonColor: '#f76c6b',
                        cancelButtonText: 'Exit'
                    }).then(result => {
                        if(result.value){
                            $.ajax({
                                url: '{{ route('applications.updateProApp') }}',
                                data: {
                                    col: 'applicant_id',
                                    val: aId,
                                    update: {seniority: result.value},
                                },
                                success: result => {
                                    console.log(result, 'update seniority');
                                    swalNotification(
                                        'success', 
                                        'Success', 
                                        "Successfully updated crew seniority", 
                                        timer = null).then(() => {
                                            table.ajax.reload(null, false);
                                        });
                                }
                            });
                        }
                    })
                }
            })
        }

        // FILTER
        function filter(){
            swal({
                width: "650px",
                confirmButtonText: 'Apply Filter',
                showCancelButton: true,
                cancelButtonColor: errorColor,
                cancelButtonText: 'Reset Filter',
                showCloseButton: true,
                html:`
                    <div class="row iRow">
                        <div class="col-md-6">
                            ${input("fname", "Fname", fFname, 4,8)}
                        </div>
                        <div class="col-md-6">
                            ${input("lname", "Lname", fLname, 4,8)}
                        </div>
                    </div>

                    <br>
                    <div class="row iRow">
                        <div class="col-md-6">
                            ${input("min_age", "Min Age", fMin_age, 4,8, 'number', 'min="20" max="60"')}
                        </div>
                        <div class="col-md-6">
                            ${input("max_age", "Max Age", fMax_age, 4,8, 'number', 'min="20" max="60"')}
                        </div>
                    </div>

                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Ranks
                        </div>
                        <div class="col-md-10 iInput">
                            <select name="ranks" class="form-control" data-placeholder="Select Ranks">
                            </select>
                        </div>
                    </div></br>

                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Status
                        </div>
                        <div class="col-md-4 iInput">
                            <select name="status" class="form-control">
                                <option value="%%">All</option>
                                <option value="Vacation">Vacation</option>
                                <option value="Lined-Up">Lined-Up</option>
                                <option value="On Board">On Board</option>
                            </select>
                        </div>
                    </div></br>

                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Fleet
                        </div>
                        <div class="col-md-4 iInput">
                            <select name="fFleet" class="form-control">
                                <option value="%%">All</option>
                                <option value="FLEET B">FLEET B</option>
                                <option value="FLEET C">FLEET C</option>
                                <option value="FLEET D">FLEET D</option>
                                <option value="FISHING">FISHING</option>
                                <option value="TOEI">TOEI</option>
                            </select>
                        </div>
                    </div></br>

                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            US VISA
                        </div>
                        <div class="col-md-10 iInput">
                            <div class="col-md-12 iInput">
                                ${checkbox("usv", "REQUIRED")}
                            </div>
                        </div>
                    </div></br>
                `,
                onOpen: () => {
                    $('.iInput .iInput').css('text-align', 'left');

                    // let temp = [];
                    // fExp.forEach(exp => {
                    //     let temp2 = $(`[name="exp"][value="${exp}"]`);
                    //     if(!temp2.length){
                    //         temp.push(exp);
                    //         $(`[name="other_exp"]`).append(`
                    //             <option value="${exp}">${exp}</option>
                    //         `);
                    //     }
                    // });

                    // $('[name="other_exp"]').select2({
                    //     tags: true,
                    //     multiple: true,
                    //     closeOnSelect: false,
                    //     scrollAfterSelect: false,
                    // })
                    // .on('select2:selecting', e => {
                    //     $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop());
                    // })
                    // .on('select2:select', e => {
                    //     $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop'));
                    //     $('.select2-search__field').val("");
                    //     $('.select2-container--open .select2-search__field').click();
                    // });
                    // $('[name="other_exp"]').val(temp).trigger("change");

                    if(fUsv){
                        $(`[name="usv"]`).click();
                    }

                    $.ajax({
                        url: "{{ route('rank.get') }}",
                        data: {
                            select: ["id", "abbr"],
                        },
                        success: result => {
                            result = JSON.parse(result);
                            ranks = [];
                            rankString = "";

                            result.forEach(rank => {
                                ranks.push(rank.abbr);
                                rankString += `
                                    <option value="${rank.id}">${rank.abbr}</option>
                                `;
                            });

                            $('[name="ranks"]').append(rankString);
                            $('[name="ranks"]').select2({
                                tags: true,
                                multiple: true,
                                closeOnSelect: false,
                                scrollAfterSelect: false,
                            })
                            .on('select2:selecting', e => {
                                $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop());
                            })
                            .on('select2:select', e => {
                                $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop'));
                                $('.select2-search__field').val("");
                                $('.select2-container--open .select2-search__field').click();
                            });

                            $('[name="ranks"]').val(fRanks).trigger("change");
                        }
                    });
                }
            }).then(result => {
                if(result.value){
                    fFname = $("[name='fname']").val();
                    fLname = $("[name='lname']").val();
                    fMin_age = $("[name='min_age']").val();
                    fMax_age = $("[name='max_age']").val();
                    fRanks = $("[name='ranks']").val();
                    fStatus = $("[name='status']").val();
                    fFleet = $("[name='fFleet']").val();
                    fUsv = $("[name='usv']:checked").val();
                    // fRemarks = $("[name='remarks']").val();

                    // let temp = [];
                    // $('[name="exp"]:checked').each((i, e) => {
                    //     temp.push(e.value);
                    // });

                    // fExp = temp.concat($('[name="other_exp"]').val());
                    // fBool = true;

                    reload();
                    // $('[type="search"]').val(fName);
                }
                else if(result.dismiss == "cancel"){
                    fFname = "";
                    fLname = "";
                    fRanks = [];
                    fMin_age = null;
                    fMax_age = null;
                    fStatus = "";
                    fUsv = "";
                    fStatus = "%%";
                    fFleet = "%%";
                    
                    filter();
                }
            });
        }
	</script>
@endpush