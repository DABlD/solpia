@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					@include('applications.includes.toolbar')
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
                                    @if(auth()->user()->fleet == null || in_array(auth()->user()->id, [5716, 4580]))
    								    <th>Fleet</th>
                                    @endif
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

        .modal thead tr, .tss thead tr{
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
        // var remark = "%%";
        var fMin_age = null;
        var fMax_age = null;
        
        // var size = "%%";
        // var owner = "%%";
        // var engine = "%%";
        var fStatus = "%%";
        var fUsv = "";

        // INIT DATA FROM SESSION
        fRanks = "{{ session('fRanks') }}";
        fMin_age = "{{ session('fMin_age') }}";
        fMax_age = "{{ session('fMax_age') }}";
        fFname = "{{ session('fFname') }}";
        fLname = "{{ session('fLname') }}";
        fStatus = "{{ session('fStatus') ?? "%%" }}";
        $('#table_filter input[type="search"]').val("{{ session('search') }}");

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
                    @if(in_array(auth()->user()->id, [5901, 5958]) || auth()->user()->role == "Training")
                        visible: false
                    @endif
                },
                { data: 'last_vessel.vessel_name', name: 'last_vessel.vessel_name' },
                { data: 'last_vessel.sign_off', name: 'last_vessel.sign_off' },
                @if(auth()->user()->fleet == null || in_array(auth()->user()->id, [5716, 4580]))
                    { data: 'user.fleet', name: 'user.fleet' },
                @endif
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
                @if(auth()->user()->fleet == null || in_array(auth()->user()->id, [5716, 4580]))
                    {
                        targets: 11,
                        className: "w100"
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
                                <select id="table-select-${data.id}" data-id="${data.id}" multiple>
                                    ${selected}
                                </select>
                            `;
                        },
                    },
                @else
                    {
                        targets: 10,
                        className: "w100"
                    },
                    {
                        targets: 9,
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
                                <select id="table-select-${data.id}" data-id="${data.id}" multiple>
                                    ${selected}
                                </select>
                            `;
                        },
                    },
                @endif
            ],
            drawCallback: function(){
                $('#table tbody').append('<div class="preloader"></div>');
                // MUST NOT BE INTERCHANGED t-i
                $('#table select').select2({
                    tags: true,
                    class: 'table-select',
                    disabled: {{ !in_array(auth()->user()->role, ['Admin', 'Crewing Manager', 'Crewing Officer']) ? 'true' : 'false' }},
                });

                $('[id^=table-select] + .select2-container').css('width', '100%');
                $('[id^=table-select] + .select2-container .select2-selection').css('border', 'none');

                $('[id^=table-select]').on('change', e => {
                    let input = $(e.target);
                    let id = input.data('id');
                    $.ajax({
                        type: "POST",
                        url: "{{ route('applications.updateData') }}",
                        data: {
                            id: id,
                            remarks: JSON.stringify(input.val())
                        },
                    });
                });

                // DISABLE SHOWING OF SELECTION OPTIONS WHEN UNSELECTING
                $("[id^=table-select]").on("select2:unselect", function (evt) {
                  if (!evt.params.originalEvent) {
                    return;
                  }

                  evt.params.originalEvent.stopPropagation();
                });

                tooltip();
            	initializeActions();
            },
            order: [],
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
                // remark: remark,
                fStatus: fStatus
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

	    	$('[data-original-title="Export"]').on('click', application => {
                swal({
                    title: 'Select Export Type',
                    input: 'select',
                    inputOptions: {
                        Biodata:                        'Biodata',
                        WalangLagay:                    'Walang Lagay',
                        X17_HistoryCheck:               'History Check',
                        SeaServiceCertificate:          'Certificate of Sea Service',
                        X01_BorrowDocuments:            'Borrow Documents',
                        X04_USVE:                       'US Visa Endorsement Form',
                        X07_SeaServiceRequestForm:      'Request for Sea Service Certificate',
                        X05_Clearance:                  'Clearance',
                        Y05_ClearanceAffidavit:         'Clearance - Affidavit',
                        X09_InitialDocumentChecklist:   'Document Checklist (Initial)',
                        DocumentChecklist:              'Document Checklist (Final)',
                        DocumentChecklistHmm:           'Document Checklist (HMM)',
                        X18_EvaluationSheet:            'Evaluation Sheet - POSSM',
                        X30_POSSMSeaService:            'Sea Service - POSSM',
                        X34_DocumentDeficiencyNotice:   'Document Deficiency Notice'
                    },
                    showCancelButton: true,
                    cancelButtonColor: '#f76c6b'
                }).then(result => {
                    if(result.value){
                        application = $(application.target);
                        if(result.value == 'Biodata'){
                            exportBiodata(application);
                        }
                        else if(result.value == "WalangLagay"){
                            walangLagay(application, result);
                        }
                        else if(result.value == "SeaServiceCertificate"){
                            swal({
                                html: `
                                    <select id="por">
                                        <option value="">Enter purpose of request</option>
                                        <option value="COC/COP Application">COC/COP Application</option>
                                        <option value="Loan">Loan</option>
                                        <option value="Personal">Personal</option>
                                    </select>
                                    <br><br>`,
                                onOpen: () => {
                                    $('#por').select2({
                                        width: '100%',
                                        tags: true
                                    });

                                    $('#por').on('select2:open', () => {
                                        $('.swal2-container').css('z-index', 1000);
                                    })
                                },
                                preConfirm: () => {
                                    swal.showLoading();
                                    return new Promise(resolve => {
                                        setTimeout(() => {
                                            if($('#por').val() == ""){
                                                swal.showValidationError('Reason is required');
                                            }
                                        resolve()}, 500);
                                    });
                                },
                            }).then(result => {
                                if(result.value){
                                    let type = "SeaServiceCertificate";
                                    window.location.href = `{{ route('applications.exportDocument') }}/${application.data('id')}/${type}?` + $.param({data: {reason: $('#por').val()}});
                                }
                            })
                        }
                        else if(result.value == "DocumentChecklist"){
                            let type = "DocumentChecklist";
                            let fleet = "{{ auth()->user()->fleet }}";

                            @if(auth()->user()->role == "Admin" || auth()->user()->fleet == null)
                                swal({
                                    title: 'Select Fleet',
                                    input: 'select',
                                    inputOptions: {
                                        'FLEET A' : 'FLEET A',
                                        'FLEET B' : 'FLEET B',
                                        'FLEET C' : 'FLEET C',
                                        'FLEET D' : 'FLEET D',
                                        'FLEET E' : 'FLEET E',
                                        'TOEI' : 'TOEI',
                                        'FISHING' : 'FISHING',
                                    },
                                    showCancelButton: true,
                                    cancelButtonColor: '#f76c6b'
                                }).then(result => {
                                    if(result.value){
                                        fleet = result.value;
                                        edc(type, fleet, application);
                                    }
                                });
                            @else
                                edc(type, fleet, application);
                            @endif
                        }
                        else if(result.value == "X07_SeaServiceRequestForm"){
                            swal({
                                html: `
                                    <select id="por">
                                        <option value="">Enter purpose of request</option>
                                        <option value="COC/COP Application">COC/COP Application</option>
                                        <option value="Loan">Loan</option>
                                        <option value="Personal">Personal</option>
                                    </select>
                                    <br><br>`,
                                onOpen: () => {
                                    $('#por').select2({
                                        width: '100%',
                                        tags: true
                                    });

                                    $('#por').on('select2:open', () => {
                                        $('.swal2-container').css('z-index', 1000);
                                    })
                                },
                                preConfirm: () => {
                                    swal.showLoading();
                                    return new Promise(resolve => {
                                        setTimeout(() => {
                                            if($('#por').val() == ""){
                                                swal.showValidationError('Reason is required');
                                            }
                                        resolve()}, 500);
                                    });
                                },
                            }).then(result2 => {
                                if(result2.value){
                                    let type = result.value;
                                    let data = {
                                        status: application.data('status2'),
                                        reason: $('#por').val(),
                                        rank: 1
                                    };
                                    window.location.href = `{{ route('applications.exportDocument') }}/${application.data('id')}/${type}?` + $.param({data});
                                }
                            })
                        }
                        else if(result.value == "X01_BorrowDocuments"){
                            FBBD(application.data('id'), result.value);
                        }
                        else if(result.value == "X04_USVE"){
                            USVE(application.data('id'), result.value);
                        }
                        else if(result.value == "Y05_ClearanceAffidavit"){
                            let data = {};
                                data.id = application.data('id');
                                data.exportType = "pdf";

                            window.location.href = `{{ route('applications.exportDocument') }}/${data.id}/${result.value}?` + $.param(data);
                        }
                        else if(result.value == "X18_EvaluationSheet"){
                            x18_ES(application, result.value);
                        }
                        else{
                            window.location.href = `{{ route('applications.exportDocument') }}/${application.data('id')}/${result.value}`;
                        }
                    }
                })
	    	});

            function walangLagay(application, result){
                let data = {};
                if($(application).data('status2') == "Vacation"){
                    let savedVessels = {};
                    let savedVesselsString = "";

                    swal({
                        title: 'Enter Details',
                        html: '',
                        onOpen: () => {
                            swal.showLoading();

                            $.ajax({
                                url: '{{ route('vessels.getAll') }}',
                                dataType: 'json',
                                success: vessels => {
                                    vessels.forEach(vessel => {
                                        if(savedVessels[vessel.name] == undefined){
                                            savedVessels[vessel.name] = vessel;
                                            savedVesselsString += `
                                                <option value="${vessel.name}">${vessel.name}</option>
                                            `;
                                        }
                                    });

                                    $('#swal2-content').html(`
                                        <div class="row">
                                            <div class="col-md-5">
                                                <h4 class="clabel">Vessel Name</h4>
                                            </div>
                                            <div class="col-md-7">
                                                <select id="vessel" class="swal2-input">
                                                    <option></option>
                                                    ${savedVesselsString}
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-5">
                                                <h4 class="clabel">Rank</h4>
                                            </div>
                                            <div class="col-md-7">
                                                <select id="rank" class="swal2-input">
                                                    <option></option>
                                                    @foreach($categories as $category => $ranks)
                                                        <optgroup label="{{ $category }}"></optgroup>
                                                        @foreach($ranks as $rank)
                                                            <option value="{{ $rank->name }}">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                                {{ $rank->name }} ({{ $rank->abbr }})
                                                            </option>
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <br>
                                    `);
                                }
                            }).then(() => {
                                $("#vessel").select2({
                                    placeholder: 'Select Vessel'
                                });

                                $("#rank").select2({
                                    placeholder: 'Select Rank'
                                });

                                $('#vessel, #rank').on('select2:open', () => {
                                    $('.select2-container').css('z-index', 1060);
                                });

                                $('#swal2-content').show();
                                $('.select2-container').css('width', '100%');
                                swal.hideLoading();
                            });
                        },
                        width: '400px',
                        showCancelButton: true,
                        cancelButtonColor: '#f76c6b',
                    }).then(result2 => {
                        if(result2.value){
                            data.vessel = $('#vessel').val();
                            data.rank = $('#rank').val();

                            window.location.href = `{{ route('applications.exportDocument') }}/${application.data('id')}/${result.value}?` + $.param(data);
                        }
                    })
                }
                else{
                    window.location.href = `{{ route('applications.exportDocument') }}/${application.data('id')}/${result.value}?` + $.param(data);
                }
            }

            function x18_ES(application, type){
                swal({
                    html: `
                        <select id="vid" class="form-control">
                            <option value="">Select Vessel</option>
                        </select>
                        <br><br>
                        <select id="rid" class="form-control">
                            <option value="">Select Rank</option>
                        </select>
                        <br>
                    `,
                    preConfirm: () => {
                        swal.showLoading();
                        return new Promise(resolve => {
                            setTimeout(() => {
                                let a = $('#vid').val();
                                let b = $('#rid').val();

                                if(a == "" || b == ""){
                                    swal.showValidationError('All fields is required');
                                }
                            resolve()}, 800);
                        });
                    },
                    onOpen: () => {
                        $.ajax({
                            url: '{{ route('vessels.get2') }}',
                            data: {
                                cols: ['id', 'name'],
                                where: ['status', 'ACTIVE'],
                                whereIn: ['fleet', ['FLEET B']]
                            },
                            success: result => {
                                result = JSON.parse(result);
                                
                                let vesselString = "";
                                result.forEach(vessel => {
                                    vesselString += `
                                        <option value="${vessel.id}">${vessel.name}</option>
                                    `;
                                })

                                $('#vid').append(vesselString);

                                $.ajax({
                                    url: '{{ route('rank.get') }}',
                                    data: {
                                        select: ['id', 'name', 'abbr'],
                                    },
                                    success: result => {
                                        result = JSON.parse(result);
                                        
                                        let rankString = "";
                                        result.forEach(rank => {
                                            rankString += `
                                                <option value="${rank.id}">${rank.name} (${rank.abbr})</option>
                                            `;
                                        })

                                        $('#rid').append(rankString);
                                        $('#vid, #rid').select2();
                                    }
                                });
                            }
                        });
                    }
                }).then(result => {
                    if(result.value){
                        let rid = $('#rid').val();
                        let vid = $('#vid').val();

                        let data = {};
                            data.id = application.data('id');
                            data.rid = rid;
                            data.vid = vid;

                        window.location.href = `{{ route('applications.exportDocument') }}/${data.id}/${type}?` + $.param(data);
                    }
                });
            }

            function USVE(id, type){
                $.ajax({
                    url: '{{ route('applications.get2') }}',
                    data: {
                        where: ['applicants.id', id],
                        cols: ['mob', 'eld']
                    },
                    success: result => {
                        let pro_app = JSON.parse(result)[0];
                        let vessel = "";

                        if(pro_app.eld == null){
                            vessel = `
                                <br><br>
                                <input type="string" id="eld" placeholder="Expected Sign-on Date (optional)" class="form-control">
                                <br>
                                <input type="number" min="0" id="mob" placeholder="Months on board (optional)" class="form-control">
                            `;
                        }

                        swal({
                            title: 'Charge to: ',
                            html: `
                                <div style="text-align: left;">
                                    <label class="radio-inline" style="font-size: 16px;">
                                        <input type="radio" name="chargeTo" value="1" checked> Seafarer
                                    </label>
                                    <br>
                                    <label class="radio-inline" style="font-size: 16px;">
                                        <input type="radio" name="chargeTo"} value="0"> SMI
                                    </label>
                                    ${vessel}
                                </div>
                            `,
                            showCancelButton: true,
                            cancelButtonColor: '#f76c6b',
                            onOpen: () => {
                                let string = "";

                                $('#eld').flatpickr({
                                    altInput: true,
                                    altFormat: 'F j, Y',
                                    dateFormat: 'Y-m-d',
                                })
                            }
                        }).then(result => {
                            if(result.value){
                                let data = {
                                    status: 'Lined-Up',
                                    eld: $('#eld').val(),
                                    mob: $('#mob').val(),
                                    chargeTo: $('[name="chargeTo"]:checked').val()
                                }

                                window.location.href = `{{ route('applications.exportDocument') }}/${id}/${type}?` + $.param({data});
                            }
                        });
                    }
                })
            }

            function FBBD(id, type){
                swal({
                    title: 'Fill all details',
                    html: `
                        <div class="row">
                            <div class="col-md-5">
                                <h4 class="clabel">REF NO.</h4>
                            </div>
                            <div class="col-md-7">
                                <input type="text" id="ref" class="swal2-input" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <h4 class="clabel">PURPOSE</h4>
                            </div>
                            <div class="col-md-7">
                                <input type="text" id="purpose" class="swal2-input" />
                            </div>
                        </div>
                    `,
                    showCancelButton: true,
                    cancelButtonColor: '#f76c6b',
                    preConfirm: () => {
                        swal.showLoading();
                        return new Promise(resolve => {
                            setTimeout(() => {
                                let a = $('#ref').val();
                                let b = $('#purpose').val();

                                if(a == "" || b == ""){
                                    swal.showValidationError('All fields is required');
                                }
                            resolve()}, 800);
                        });
                    },
                }).then(result => {
                    if(result.value){
                        let temp = [
                            'Passport', "Seaman's Book", 'Maritime Crew Visa', 'BT', "PSCRB", "AFF", "MECA", "MEFA", 'SDSD', 'COC', 'COE'
                        ];
                        let docString = "";
                        let docs = [];

                        temp.forEach((value, index) => {
                            docString += `  
                                <div class="row">
                                    <div class="col-md-4" style="text-align: right;">
                                        <input type="checkbox" class="crew-checklist" value="${value}"/>
                                    </div>
                                    <div class="col-md-8" style="text-align: left;">
                                        <label for="">
                                            ${value}
                                        </label>
                                    </div>
                                </div>
                            `;
                        });

                        let data = {};
                        data.data2 = {};
                        data.data2.ref = $('#ref').val();
                        data.data2.purpose = $('#purpose').val();

                        swal({
                            title: 'Select Documents to Borrow',
                            html: '<br><br>' + docString,
                            showCancelButton: true,
                            cancelButtonColor: '#f76c6b',
                            onOpen: () => {
                                $('#swal2-content input[type=checkbox]').css({
                                    'zoom': '1.7',
                                    'margin': '1px 0 0'
                                });
                            },
                            preConfirm: () => {
                                swal.showLoading();
                                return new Promise(resolve => {
                                    setTimeout(() => {
                                        let temp2 = $(".crew-checklist:checked");
                                        
                                        temp2.each((index, value) => {
                                            docs.push($(value).val());
                                        });
                                    resolve()}, 500);
                                });
                            },
                        }).then(result => {
                            if(result.value){
                                data.data2.docs = docs;
                                window.location.href = `{{ route('applications.exportDocument') }}/${id}/${type}?` + $.param(data);
                            }
                        })
                    }
                })
            }

            function edc(type, fleet, application){
                if(application.data('status2') == "Vacation"){
                    swal({
                        title: 'Enter Details',
                        html: `
                            <select id="rank">
                                <option value=""></option>
                            </select>
                            <br>
                            <br>
                            <select id="type">
                            </select>
                            <br>
                        `,
                        allowOutsideClick: false,
                        showCancelButton: true,
                        cancelButtonColor: '#f76c6b',
                        onOpen: () => {
                            $('#rank').append(`
                                @foreach($categories as $category => $ranks)
                                    <optgroup label="{{ $category }}"></optgroup>
                                    @foreach($ranks as $rank)
                                        <option value="{{ $rank->id }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ $rank->name }} ({{ $rank->abbr }})
                                        </option>
                                    @endforeach
                                @endforeach
                            `);

                            $('#type').append(getChecklist(fleet));
                            $('#rank').select2({
                                placeholder: 'Select Rank',
                                width: '100%',
                            });
                            $('#type').select2({
                                width: '100%',
                            });

                            $('#rank, #type').on('select2:open', function (e) {
                                $('.select2-dropdown--below').css('z-index', 1060);
                            });
                        },
                    }).then(result => {
                        let data = {
                            rank: $('#rank').val(),
                            status: status,
                            type: $('#type').val(),
                            fleet: fleet
                        }

                        if(result.value){
                            window.location.href = `{{ route('applications.exportDocument') }}/${application.data('id')}/${type}?` + $.param({data});
                        }
                    });
                }
                else{
                    swal({
                        title: 'Select Type',
                        html: `
                            <select id="type">
                            </select>
                            <br>
                        `,
                        allowOutsideClick: false,
                        showCancelButton: true,
                        cancelButtonColor: '#f76c6b',
                        onOpen: () => {
                            $('#type').append(getChecklist(fleet));
                            $('#type').select2({
                                width: '100%',
                            });

                            $('#rank, #type').on('select2:open', function (e) {
                                $('.select2-dropdown--below').css('z-index', 1060);
                            });
                        },
                    }).then(result => {
                        let data = {
                            type: $('#type').val(),
                            status: status,
                            fleet: fleet
                        }

                        if(result.value){
                            window.location.href = `{{ route('applications.exportDocument') }}/${application.data('id')}/${type}?` + $.param({data});
                        }
                    });
                }
            }

            $('[data-original-title="Edit Application"]').on('click', application => {
                window.location.href = 'applications/edit/' + $(application.target).data('id');
            });

            $('[data-original-title="Go to Principal"]').on('click', application => {
                let e = $(application.target);

                $.ajax({
                    url: `{{ route('applications.goToPrincipal') }}/${$(application.target).data('id')}`,
                    data: {
                        principal: e.data('principal')
                    },
                    success: result => {
                        swal({
                            type: 'success',
                            title: 'success',
                            timer: 800,
                            showConfirmButton: false
                        })
                    }
                })
            });

            $('[data-original-title="Line-Up"]').on('click', application => {
                let id = $(application.target).data('id');
                let status = $(application.target).data('status');
                let aRank, aVessel, aPrincipal;

                if(status == "Lined-Up"){
                    swal({
                        type: 'info',
                        title: 'This crew is already Lined-Up',
                        text: 'Choose action',
                        confirmButtonText: 'Change Line-Up',
                        cancelButtonText: 'Remove Line-Up',
                        showCancelButton: true,
                        cancelButtonColor: '#f76c6b',
                        allowOutsideClick: false,
                    }).then(result => {
                        if(result.dismiss == 'cancel'){
                            swal({
                                type: 'warning',
                                title: 'Confirmation',
                                text: "Are you sure you want to remove the crew's Line-Up?",
                                showCancelButton: true,
                                cancelButtonColor: '#f76c6b',
                                allowOutsideClick: false,
                            }).then(result => {
                                if(result.value){
                                    swal.showLoading();
                                    $.ajax({
                                        url: '{{ route('lineUp.remove') }}',
                                        data: {id: id},
                                        success: result => {
                                            setTimeout(() => {
                                                if(result){
                                                    swal({
                                                        type: 'success',
                                                        title: 'Line-Up successfully removed',
                                                        timer: 800,
                                                        showConfirmButton: false
                                                    }).then(() => {
                                                        table.ajax.reload(null, false);
                                                    });
                                                }
                                                else{
                                                    swal({
                                                        type: 'error',
                                                        title: 'Try Again',
                                                        timer: 800,
                                                        showConfirmButton: false
                                                    });
                                                }
                                            }, 500);
                                        }
                                    })
                                }
                            })
                            return;
                        }
                        else if(result.value){
                            selectRank();
                        }
                    });
                }
                else{
                    selectRank();
                }


                function selectRank(){
                    swal({
                        title: 'Select Rank',
                        input: 'select',
                        allowOutsideClick: false,
                        showCancelButton: true,
                        cancelButtonColor: '#f76c6b',
                        onOpen: () => {
                            $('.swal2-select').append(`
                                <option></option>
                                @foreach($categories as $category => $ranks)
                                    <optgroup label="{{ $category }}"></optgroup>
                                    @foreach($ranks as $rank)
                                        <option value="{{ $rank->id }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ $rank->name }} ({{ $rank->abbr }})
                                        </option>
                                    @endforeach
                                @endforeach
                            `);

                            $('.swal2-select').select2({
                                placeholder: 'Select Rank',
                                width: '100%',
                            });

                            $('.swal2-select').on('select2:open', function (e) {
                                $('.select2-dropdown--below').css('z-index', 1060);
                            });
                        },
                    }).then(rank => {
                        if(rank.value){
                            aRank = rank.value;
                            selectVessel();
                        }
                    });
                }

                // function selectPrincipal(){
                //     swal({
                //         title: 'Select Principal',
                //         input: 'select',
                //         inputOptions: {
                //             '' : '',
                //             @foreach($principals as $principal)
                //                 @if($principal->fleet == auth()->user()->fleet || auth()->user()->role == "Admin")
                //                     '{{ $principal->id }}': '{{ $principal->name }}',
                //                 @endif
                //             @endforeach
                //         },
                //         allowOutsideClick: false,
                //         showCancelButton: true,
                //         cancelButtonColor: '#f76c6b',
                //         onOpen: () => {
                //             $('.swal2-select').select2({
                //                 placeholder: 'Select Principal',
                //                 width: '100%',
                //             });

                //             $('.swal2-select').on('select2:open', function (e) {
                //                 $('.select2-dropdown--below').css('z-index', 1060);
                //             });
                //         },
                //     }).then(principal => {
                //         if(principal.value){
                //             aPrincipal = principal.value;
                //             selectVessel();
                //         }
                //     });
                // }

                function selectVessel(){
                    let vessels = [];
                    aPrincipal = [];

                    swal('Loading Vessels');
                    swal.showLoading();

                    $.ajax({
                        url: '{{ route('vessels.get2') }}',
                        data:{
                            @if(auth()->user()->fleet != "")
                                where: ['fleet', '{{ auth()->user()->fleet }}'],
                            @endif
                            cols: ['id', 'name', 'principal_id', 'status']
                        },
                        dataType: 'json',
                        success: result => {
                            result.forEach(a => {
                                // aPrincipal
                                if(a.status == "ACTIVE"){
                                    vessels[a.id] = a.name;
                                    aPrincipal[a.id] = a.principal_id;
                                }
                            });

                            setTimeout(() => {
                                showSelectVessel();
                            }, 500);
                        }
                    });

                    function showSelectVessel(){
                        swal({
                            title: 'Select Vessel',
                            html: `
                                <select id="vessel">
                                    <option value=""></option>
                                </select>
                                <br><br>
                                <input type="string" id="eld" placeholder="Expected Sign-on Date (optional)" class="form-control">
                                <br>
                                <input type="number" min="0" id="mob" placeholder="Months on board (optional)" class="form-control">
                            `,
                            allowOutsideClick: false,
                            showCancelButton: true,
                            cancelButtonColor: '#f76c6b',
                            onOpen: () => {
                                let string = "";

                                vessels.forEach((name, id) => {
                                    string += `<option value="${id}">${name}</option>`;
                                });

                                $('#eld').flatpickr({
                                    altInput: true,
                                    altFormat: 'F j, Y',
                                    dateFormat: 'Y-m-d',
                                })

                                $('#vessel').append(string);

                                $('#vessel').select2({
                                    placeholder: 'Select Vessel',
                                    width: '100%',
                                });

                                $('#vessel').on('select2:open', function (e) {
                                    $('.select2-dropdown--below').css('z-index', 1060);
                                });
                            },
                        }).then(result => {
                            if(result.value){
                                swal.showLoading();
                                let vid = $('#vessel').val();

                                $.ajax({
                                    url: '{{ route('applications.lineUp') }}',
                                    data: {
                                        applicant_id: id,
                                        rank_id: aRank,
                                        principal_id: aPrincipal[vid],
                                        vessel_id: vid,
                                        mob: $('#mob').val(),
                                        eld: $('#eld').val()
                                    },
                                    success: result => {
                                        setTimeout(() => {
                                            if(result){
                                                swal({
                                                    type: 'success',
                                                    title: 'Applicant Successfully Lined-Up to Principal',
                                                    timer: 800,
                                                    showConfirmButton: false
                                                }).then(() => {
                                                    table.ajax.reload(null, false);
                                                });
                                            }
                                            else{
                                                swal({
                                                    type: 'error',
                                                    title: 'Try Again',
                                                    timer: 800,
                                                    showConfirmButton: false
                                                });
                                            }
                                        }, 500);
                                    }
                                })
                            }
                        });
                    }
                }
            });

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

            $('[data-original-title="Delete Applicant"]').on('click', application => {
                let id = $(application.target).data('id');

                swal({
                    type: 'warning',
                    title: 'Are you sure you want to delete this applicant?',
                    text: "His data will still be stored in the database but you will not be able to interact with it.",
                    showCancelButton: true,
                    cancelButtonColor: '#f76c6b',
                    allowOutsideClick: false,
                    width: '80vh'
                }).then(result => {
                    if(result.value){
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('applications.updateData') }}',
                            data:{
                                id: id,
                                deleted_at: moment().format("YYYY-MM-DD hh:mm:ss")
                            },
                            success: result => {
                                console.log(result);
                                if(result){
                                    swalNotification('success', 'Application Successfully Deleted');
                                    table.ajax.reload(null, false);
                                }
                            }
                        })
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
                            html: `
                                <ul class="nav nav-pills" role="tablist" id="infoTabs">
                                    <li role="presentation" class="active">
                                        <a href=".pinfo" role="tab" data-toggle="pill"><u>P</u>ersonal Info</a>
                                    </li>
                                    <li role="presentation">
                                        <a href=".educbg" role="tab" data-toggle="pill"><u>E</u>ducational Background</a>
                                    </li>
                                    <li role="presentation">
                                        <a href=".family" role="tab" data-toggle="pill">Famil<u>y</u> Data</a>
                                    </li>
                                    <li role="presentation">
                                        <a href=".ids" role="tab" data-toggle="pill">Document <u>I</u>D</a>
                                    </li>
                                    <li role="presentation">
                                        <a href=".flags" role="tab" data-toggle="pill"><u>F</u>lag Documents</a>
                                    </li>
                                    <li role="presentation">
                                        <a href=".l_cs" role="tab" data-toggle="pill"><u>D</u>ocuments</a>
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
                                  <div role="tabpanel" class="tab-pane fade educbg">b</div>
                                  <div role="tabpanel" class="tab-pane fade family">b</div>
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
                                fillTab2(applicant);
                                fillTab3(applicant);
                                fillTab4(applicant);
                                fillTab5(applicant);
                                fillTab6(applicant);
                                fillTab7(applicant);
                                fillTab8(applicant);
                                fillTab9(applicant); //FAMILY SUPPOSED TO BE 3
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
                    else if(key == "E" || key == "e"){
                        $('[href=".educbg"]').click();
                    }
                    else if(key == "I" || key == "i"){
                        $('[href=".ids"]').click();
                    }
                    else if(key == "F" || key == "f"){
                        $('[href=".flags"]').click();
                    }
                    else if(key == "D" || key == "d"){
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
                    else if(key == "Y" || key == "y"){
                        $('[href=".family"]').click();
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
            let string = `
                <div class="box box-success" style="font-size: 15px;">
                    <div class="box-body">

                        <div class="row">
                        <br>
                            <div class="col-md-2">
                                <img src="${applicant.user.avatar}" width="200px;" height="200px;">
                            </div>
                            <br>
                        </div>

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


                    </div>
                </div>
            `;

            $('.pinfo').html(string);
        }

        function fillTab2(applicant){
            let ebs = Object.entries(applicant.educational_background);
            let temp = ``;

            ebs.forEach(eb => {
                eb = eb[1];
                temp += `
                    <h3 style="text-align: left;"><b>${eb.type}</b></h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="course">Course</label>
                                <input type="text" class="form-control" id="course" value="${eb.course ?? "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="text" class="form-control" id="year" value="${eb.year ?? "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="school">School</label>
                                <input type="text" class="form-control" id="school" value="${eb.school ?? "---"}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" value="${eb.address ?? "---"}" readonly>
                            </div>
                        </div>
                    </div>
                `;
            })

            let string = `
                <div class="box box-success" style="font-size: 15px;">
                    <div class="box-body">
                        ${temp != "" ? temp : '<h2><b>No Recorded Educational Background</b></h2>'}
                    </div>
                </div>
            `;

            $('.educbg').html(string);
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
                        <a class="btn btn-success puwy" data-toggle="tooltip" title="View" onClick="viewFile('${id.id}', ${applicant.id},  'ids')">
                            <span class="fa fa-search">
                        </span></a>
                        <a class="btn btn-primary puwy" data-toggle="tooltip" title="Download" href="files/${applicant.id}/${id.file}" download>
                            <span class="fa fa-download">
                        </span></a>
                        <a class="btn btn-danger puwy" data-toggle="tooltip" title="Delete"  onClick="deleteFile(${id.id}, ${applicant.id}, 'ids')">
                            <span class="fa fa-times">
                        </span></a>`;
                }

                file += `
                    <a class="btn btn-info puwy" data-toggle="tooltip" title="Upload New File" onClick="uploadFile(${id.id}, ${applicant.id}, 'ids')">
                        <span class="fa fa-upload">
                    </span></a>
                `;

                temp += `
                    <h3 style="text-align: left;"><b>${id.type}</b></h3>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="issuer">Issuer</label>
                                <input type="text" class="form-control" id="issuer" value="${id.issuer ?? "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="number">Number</label>
                                <input type="text" class="form-control" id="number" value="${id.number ?? "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="issue_date">Issue Date</label>
                                <input type="text" class="form-control" id="issue_date" value="${id.issue_date != null ? moment(id.issue_date).format("MMM DD, YYYY") : "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="text" class="form-control" id="expiry_date" value="${id.expiry_date != null ? moment(id.expiry_date).format("MMM DD, YYYY") : "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                ${file}
                            </div>
                        </div>
                    </div>
                `;
            });

            let string = `
                <div class="box box-success" style="font-size: 15px;">
                    <div class="box-body">
                        ${temp != "" ? temp : '<h2><b>No Recorded Flag Documents</b></h2>'}
                    </div>
                </div>
            `;

            $('.ids').html(string);
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
                        <a class="btn btn-success puwy" data-toggle="tooltip" title="View" onClick="viewFile('${flag.id}', ${applicant.id}, 'flags')">
                            <span class="fa fa-search">
                        </span></a>
                        <a class="btn btn-primary puwy" data-toggle="tooltip" title="Download" href="files/${applicant.id}/${flag.file}" download>
                            <span class="fa fa-download">
                        </span></a>
                        <a class="btn btn-danger puwy" data-toggle="tooltip" title="Delete"  onClick="deleteFile(${flag.id}, ${applicant.ifile}', 'flags')">
                            <span class="fa fa-times">
                        </span></a>`;
                }

                file += `
                    <a class="btn btn-info puwy" data-toggle="tooltip" title="Upload New File" onClick="uploadFile(${flag.id}, ${applicant.id}, 'flags')">
                        <span class="fa fa-upload">
                    </span></a>
                `;

                temp += `
                    <h3 style="text-align: left;"><b>${flag.type}</b></h3>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="country" value="${flag.country ?? "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="number">Number</label>
                                <input type="text" class="form-control" id="number" value="${flag.number ?? "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="issue_date">Issue Date</label>
                                <input type="text" class="form-control" id="issue_date" value="${flag.issue_date != null ? moment(flag.issue_date).format("MMM DD, YYYY") : "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="text" class="form-control" id="expiry_date" value="${flag.expiry_date != null ? moment(flag.expiry_date).format("MMM DD, YYYY") : "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                ${file}
                            </div>
                        </div>
                    </div>
                `;
            });

            let string = `
                <div class="box box-success" style="font-size: 15px;">
                    <div class="box-body">
                        ${temp != "" ? temp : '<h2><b>No Recorded Flag Documents</b></h2>'}
                    </div>
                </div>
            `;

            $('.flags').html(string);
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
                        <a class="btn btn-success puwy" data-toggle="tooltip" title="View" onClick="viewFile('${lc.id}', ${applicant.id}, 'l_cs')">
                            <span class="fa fa-search">
                        </span></a>
                        <a class="btn btn-primary puwy" data-toggle="tooltip" title="Download" href="files/${applicant.id}/${lc.file}" download>
                            <span class="fa fa-download">
                        </span></a>
                        <a class="btn btn-danger puwy" data-toggle="tooltip" title="Delete"  onClick="deleteFile(${lc.id}, ${applicant.id}, 'l_cs')">
                            <span class="fa fa-times">
                        </span></a>`;
                }

                file += `
                    <a class="btn btn-info puwy" data-toggle="tooltip" title="Upload New File" onClick="uploadFile(${lc.id}, ${applicant.id}, 'l_cs')">
                        <span class="fa fa-upload">
                    </span></a>
                `;

                temp += `
                    <h3 style="text-align: left;"><b>${lc.type}</b></h3>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="issuer">Issuer</label>
                                <input type="text" class="form-control" id="issuer" value="${lc.issuer ?? "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="no">Number</label>
                                <input type="text" class="form-control" id="no" value="${lc.no ?? "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="issue_date">Issue Date</label>
                                <input type="text" class="form-control" id="issue_date" value="${lc.issue_date != null ? moment(lc.issue_date).format("MMM DD, YYYY") : "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="text" class="form-control" id="expiry_date" value="${lc.expiry_date != null ? moment(lc.expiry_date).format("MMM DD, YYYY") : "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="regulation">Regulation</label>
                                <input type="text" class="form-control" id="regulation" value="${lc.regulation != "[]" ? JSON.parse(lc.regulation) : "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                ${file}
                            </div>
                        </div>
                    </div>
                `;
            });

            let string = `
                <div class="box box-success" style="font-size: 15px;">
                    <div class="box-body">
                        ${temp != "" ? temp : '<h2><b>No Recorded Licenses</b></h2>'}
                    </div>
                </div>
            `;

            $('.l_cs').html(string);
        }

        function fillTab6(applicant){
            let mcs = Object.entries(applicant.document_med_cert);
            let temp = ``;

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
                        <a class="btn btn-success puwy" data-toggle="tooltip" title="View" onClick="viewFile('${mc.id}', ${applicant.id}, 'med_certs')">
                            <span class="fa fa-search">
                        </span></a>
                        <a class="btn btn-primary puwy" data-toggle="tooltip" title="Download" href="files/${applicant.id}/${mc.file}" download>
                            <span class="fa fa-download">
                        </span></a>
                        <a class="btn btn-danger puwy" data-toggle="tooltip" title="Delete"  onClick="deleteFile(${mc.id}, ${applicant.id}, 'med_certs')">
                            <span class="fa fa-times">
                        </span></a>`;
                }

                file += `
                    <a class="btn btn-info puwy" data-toggle="tooltip" title="Upload New File" onClick="uploadFile(${mc.id}, ${applicant.id}, 'med_certs')">
                        <span class="fa fa-upload">
                    </span></a>
                `;

                temp += `
                    <h3 style="text-align: left;"><b>${mc.type}</b></h3>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="number">Number</label>
                                <input type="text" class="form-control" id="number" value="${mc.number ?? "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="clinic">Clinic/Hospital</label>
                                <input type="text" class="form-control" id="clinic" value="${mc.clinic ?? "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="issue_date">Issue Date</label>
                                <input type="text" class="form-control" id="issue_date" value="${mc.issue_date != null ? moment(mc.issue_date).format("MMM DD, YYYY") : "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="text" class="form-control" id="expiry_date" value="${mc.expiry_date != null ? moment(mc.expiry_date).format("MMM DD, YYYY") : "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                ${file}
                            </div>
                        </div>
                    </div>
                `;
            });

            let string = `
                <div class="box box-success" style="font-size: 15px;">
                    <div class="box-body">
                        ${temp != "" ? temp : '<h2><b>No Recorded Medical Certificate</b></h2>'}
                    </div>
                </div>
            `;

            $('.med_certs').html(string);
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
                        <a class="btn btn-success puwy" data-toggle="tooltip" title="View" onClick="viewFile('${mh.id}', ${applicant.id}, 'meds')">
                            <span class="fa fa-search">
                        </span></a>
                        <a class="btn btn-primary puwy" data-toggle="tooltip" title="Download" href="files/${applicant.id}/${mh.file}" download>
                            <span class="fa fa-download">
                        </span></a>
                        <a class="btn btn-danger puwy" data-toggle="tooltip" title="Delete"  onClick="deleteFile(${mh.id}, ${applicant.id}, 'meds')">
                            <span class="fa fa-times">
                        </span></a>`;
                }

                file += `
                    <a class="btn btn-info puwy" data-toggle="tooltip" title="Upload New File" onClick="uploadFile(${mh.id}, ${applicant.id}, 'meds')">
                        <span class="fa fa-upload">
                    </span></a>
                `;

                temp += `
                    <h3 style="text-align: left;"><b>${mh.type}</b></h3>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="with_mv">With Medication/Vaccine</label>
                                <input type="text" class="form-control" id="with_mv" value="${mh.with_mv == "Yes" ? mh.with_mv : '---'}" readonly>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="text" class="form-control" id="year" value="${mh.year ?? "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="case_remarks">Remarks</label>
                                <input type="text" class="form-control" id="case_remarks" value="${mh.case_remarks ?? "---"}" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                ${file}
                            </div>
                        </div>
                    </div>
                `;
            });

            let string = `
                <div class="box box-success" style="font-size: 15px;">
                    <div class="box-body">
                        ${temp != "" ? temp : "<h2><b>NO RECORDED HISTORY</b></h2>"}
                    </div>
                </div>
            `;

            $('.meds').html(string);
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
                                    remarks: "On Board"
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

        function fillTab9(applicant){
            let fds = Object.entries(applicant.family_data);
            let temp = ``;

            fds.forEach(fd => {
                fd = fd[1];
                temp += `
                    <h3 style="text-align: left;"><b>${fd.type}</b></h3>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" value="${fd.fname ?? "-"} ${fd.lname ?? "-"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="birthday">birthday</label>
                                <input type="text" class="form-control" id="birthday" value="${fd.birthday ? moment(fd.birthday).format('MMM DD, YYYY') : "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="year">Age</label>
                                <input type="text" class="form-control" id="age" value="${fd.birthday ? moment().diff(fd.birthday, 'years') : fd.age ?? "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="occupation">Occupation</label>
                                <input type="text" class="form-control" id="occupation" value="${fd.occupation ?? "---"}" readonly>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="email">Contact</label>
                                <input type="text" class="form-control" id="email" value="${fd.email ?? "---"}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="school">Address</label>
                                <input type="text" class="form-control" id="address" value="${fd.address ?? "---"}" readonly>
                            </div>
                        </div>
                    </div>
                `;
            })

            let string = `
                <div class="box box-success" style="font-size: 15px;">
                    <div class="box-body">
                        ${temp != "" ? temp : '<h2><b>No Recorded Family Data</b></h2>'}
                    </div>
                </div>
            `;

            $('.family').html(string);
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
                        <a class="btn btn-primary puwy" data-toggle="tooltip" title="Download" href="files/${applicant.id}/${evals.file}" download>
                            <span class="fa fa-download">
                        </span></a>
                        <a class="btn btn-danger puwy" data-toggle="tooltip" title="Delete File"  onClick="deleteFile(${evals.id}, ${applicant.id}, 'eval')">
                            <span class="fa fa-times">
                        </span></a>`;
                }
                else{
                    file += `
                        <a class="btn btn-danger puwy" data-toggle="tooltip" title="Delete"  onClick="deleteEval(${evals.id}, ${applicant.id}, 'eval')">
                            <span class="fa fa-times">
                        </span></a>
                    `;
                }

                file += `
                    <a class="btn btn-info puwy" data-toggle="tooltip" title="Upload New File" onClick="uploadFile(${evals.id}, ${applicant.id}, 'eval')">
                        <span class="fa fa-upload">
                    </span></a>
                `;

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
                    <div class="box-header" style="float: right;" data-toggle="tooltip" title="Add">
                        <a class="btn btn-success" data-toggle="tooltip" title="Add Evaluation" onClick="addEval('Evaluation', ${applicant.id}, 'eval')">
                            <i class="fa fa-plus"></i>
                        </a>
                        <a class="btn btn-info" data-toggle="tooltip" title="Add Recommendation" onClick="addEval('Recommendation', ${applicant.id}, 'eval')">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>

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

        function addEval(type, id, tab){
            swal({
                title: "Add " + type,
                html: `
                    ${input("vessel", "Vessel Name", null, 3, 9)}
                    ${input("date", "Date", null, 3, 9)}
                    ${input("remark", "Remarks", null, 3, 9)}
                `,
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        setTimeout(() => {
                            let a = $('[name="vessel"]').val();
                            let b = $('[name="date"]').val();
                            let c = $('[name="remark"]').val();

                            if(a == "" || b == ""){
                                swal.showValidationError('All fields is required');
                            }
                        resolve()}, 800);
                    });
                },
                width: "50%",
                onOpen: () => {
                    $('[name="date"]').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                    })
                }
            }).then(result => {
                if(result.value){
                    let vessel = $('[name="vessel"]').val();
                    let date = $('[name="date"]').val();
                    let remark = $('[name="remark"]').val();

                    let data = {};
                        data.applicant_id = id;
                        data.type = type;
                        data.vessel = vessel;
                        data.date = date;
                        data.value = remark;

                    update({
                        url: "{{ route('evaluation.create') }}",
                        data: data,
                        message: "Success"
                    }, () => {
                        setTimeout(() => {
                            console.log(id, tab);
                            reloadTab(null, id, tab);
                        }, 2000);
                    })
                }
            });
        }

        // CREW INFO END
        function uploadFile(id, aId, type){
            swal({
                title: 'Select File',
                html: `
                    <form action="{{ route('applications.uploadFiles') }}" enctype="multipart/form-data" method="POST" target="_blank">
                        @csrf
                        <input type="file" name="files[]" multiple id="file" class="swal2-file"/>
                        <input type="hidden" name="id" value="${id}" />
                        <input type="hidden" name="aId" value="${aId}" />
                        <input type="hidden" name="type" value="${type}" />
                    </form>
                `,
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        setTimeout(() => {
                            if(!$('#file').val()){
                                swal.showValidationError('No file Selected');
                            }
                        resolve()}, 500);
                    });
                },
            }).then(result2 => {
                if(result2.value){
                    $('.swal2-content form').submit();

                    swal('Uploading Files');
                    swal.showLoading();

                    // UPDATE TO KNOW IF FORM SUCCESSFULLY SUBMITTED THEN DO THE SUCCESS
                    setTimeout(() => {
                        swal({
                            type: 'success',
                            title: 'File successfully uploaded',
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
                            reloadTab(id, aId, type);
                        })
                    }, 1000);
                }
                else{
                    reloadTab(id, aId, type);
                }
            });
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

        function deleteFile(id, aId, type){
            swal({
                type: 'warning',
                title: 'Are you sure you want to delete FILE?',
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                cancelButtonText: 'Cancel',
            }).then(result => {
                if(result.value){
                    $.ajax({
                        url: '{{ route('applications.deleteFile') }}',
                        type: 'POST',
                        data: {id: id, aId: aId, type: type},
                        success: result => {
                            swal({
                                type: 'success',
                                title: 'File Deleted Successfully',
                                showConfirmButton: false,
                                timer: 800
                            }).then(() => {
                                reloadTab(id, aId, type)
                            });
                        }
                    });
                }
                else{
                    reloadTab(id, aId, type)
                }
            });
        }

        function deleteEval(id, aId, type){
            swal({
                type: 'warning',
                title: 'Are you sure you want to delete Evaluation/Recommendation?',
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                cancelButtonText: 'Cancel',
            }).then(result => {
                if(result.value){
                    $.ajax({
                        url: '{{ route('evaluation.delete') }}',
                        type: 'POST',
                        data: {id: id},
                        success: result => {
                            swal({
                                type: 'success',
                                title: 'Evaluation/Recommendation Deleted Successfully',
                                showConfirmButton: false,
                                timer: 800
                            }).then(() => {
                                reloadTab(id, aId, type)
                            });
                        }
                    });
                }
                else{
                    reloadTab(id, aId, type)
                }
            });
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

        function deleteFile2(id, name, filename, data){
            swal({
                type: 'question',
                title: 'Are you sure?',
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                cancelButtonText: 'Cancel',
            }).then(result => {
                if(result.value){
                    $.ajax({
                        url: '{{ route('applications.deleteFile') }}',
                        type: 'POST',
                        data: {id: id, name: name, file: filename},
                        success: result => {
                            swal({
                                type: 'success',
                                title: 'File Deleted Successfully',
                                showConfirmButton: false,
                                timer: 800
                            }).then(() => {
                                reShowFiles(data);
                            });
                        }
                    });
                }
                else{
                    reShowFiles(data);
                }
            });
        }

        function reShowFiles(data){
            showFiles(data[1], data[2], data[3]);
            $(`[href=".${data[0].toLowerCase()}Files"]`).tab('show');
        }

        function uploadFile2(id, name, type, data){
            swal({
                title: 'Select Files',
                html: `
                    <form action="{{ route('applications.uploadFiles') }}" enctype="multipart/form-data" method="POST" target="_blank">
                        @csrf
                        <input type="file" name="files[]" multiple id="files" class="swal2-file"/>
                        <input type="hidden" name="name" value="${name}" />
                        <input type="hidden" name="id" value="${id}" />
                        <input type="hidden" name="type" value="${type}" />
                    </form>
                `,
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        setTimeout(() => {
                            if(!$('#files').val()){
                                swal.showValidationError('No file Selected');
                            }
                        resolve()}, 500);
                    });
                },
            }).then(result2 => {
                if(result2.value){
                    $('.swal2-content form').submit();

                    swal('Uploading Files');
                    swal.showLoading();

                    // UPDATE TO KNOW IF FORM SUCCESSFULLY SUBMITTED THEN DO THE SUCCESS
                    setTimeout(() => {
                        swal({
                            type: 'success',
                            title: 'File successfully uploaded',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            reShowFiles(data);
                        })
                    }, 500);
                }
                else{
                    reShowFiles(data);
                }
            });
        }

        function exportBiodata(application){
            let type;

            if(["Lined-Up", "On Board"].includes(application.data('status2'))){
                @if(auth()->user()->fleet == "TOEI")
                    swal({
                        title: 'Check all ECDIS Specific',
                        html: `
                            <div class="checkbox col-md-offset-2 col-md-8" style="text-align: left;">
                                <label>
                                    <input type="checkbox" value="ECDIS FURUNO 2107"> ECDIS FURUNO 2107
                                </label><br>
                                <label>
                                    <input type="checkbox" value="ECDIS FURUNO 2807"> ECDIS FURUNO 2807
                                </label><br>
                                <label>
                                    <input type="checkbox" value="ECDIS FURUNO 3100/3200/3300"> ECDIS FURUNO 3100/3200/3300
                                </label><br>
                                <label>
                                    <input type="checkbox" value="ECDIS JRC 701B"> ECDIS JRC 701B
                                </label><br>
                                <label>
                                    <input type="checkbox" value="ECDIS JRC 7201"> ECDIS JRC 7201
                                </label><br>
                                <label>
                                    <input type="checkbox" value="ECDIS JRC 901B"> ECDIS JRC 901B
                                </label><br>
                                <label>
                                    <input type="checkbox" value="ECDIS JRC 9201"> ECDIS JRC 9201
                                </label><br>
                                <label>
                                    <input type="checkbox" value="ECDIS CHARTWORLD EG2"> ECDIS CHARTWORLD EG2
                                </label><br>
                                <label>
                                    <input type="checkbox" value="ECDIS TOKYO"> ECDIS TOKYO
                                </label><br>
                                <label>
                                    <input type="checkbox" value="ECDIS TRANSAS"> ECDIS TRANSAS
                                </label><br>
                                <label>
                                    <input type="checkbox" value="ECDIS PM3D"> ECDIS PM3D
                                </label><br>
                                <label>
                                    <input type="checkbox" value="ECDIS MARTEK"> ECDIS MARTEK
                                </label><br>
                                <label>
                                    <input type="checkbox" value="ECDIS MECY"> ECDIS MECY
                            </div>
                        `,
                        onOpen: () => {
                            $('#ecdisSpecific').select2({
                                tags: true
                            });

                            $('#ecdisSpecific').on('select2:open', e => {
                                $('.select2-container').css('z-index', 1060);
                            });
                        }
                    }).then(result => {
                        if(result.value){
                            let ecdises = [];
                            $('.checkbox input:checked').each((i, ecdis) => {
                                ecdises.push($(ecdis).val());
                            });
                            window.location.href = 'applications/export/' + application.data('id') + `/toei/?ecdises=${JSON.stringify(ecdises)}`;
                        }
                    })
                @else
                    let id = application.data('id');
                    
                    $.ajax({
                        url: "{{ route('applications.get2') }}",
                        data: {
                            cols: "*",
                            where: ['applicants.id', id],
                            load: ['pro_app']
                        },
                        success: result => {
                            result = JSON.parse(result)[0];
                            
                            // CHECK IF SINOCREW
                            if(result.principal_id == 999){
                                swal({
                                    title: 'Select Type',
                                    input: 'select',
                                    inputOptions: {
                                        sinocrew1: 'Maple Rising Format',
                                        sinocrew2: 'Xing Long Yung',
                                        sinocrew3: 'TENGDA'
                                    }
                                }).then(result => {
                                    if(result.value){
                                        type = result.value;
                                        window.location.href = 'applications/export/' + application.data('id') + '/' + type;
                                    }
                                })
                            }
                            else if(result.principal_id == 10){
                                swal({
                                    title: 'Select Type',
                                    input: 'select',
                                    inputOptions: {
                                        klcsm: 'Tanker',
                                        klcsmBulk: 'Bulk'
                                    }
                                }).then(result => {
                                    if(result.value){
                                        type = result.value;
                                        window.location.href = 'applications/export/' + application.data('id') + '/' + type;
                                    }
                                })
                            }
                            else{
                                window.location.href = 'applications/export/' + application.data('id');
                            }
                        }
                    })
                @endif
            }
            else{
                swal({
                    title: 'Select Export Type',
                    input: 'select',
                    inputOptions: {
                        '' : '',
                        @foreach($principals as $principal)
                            @if($principal->fleet == auth()->user()->fleet || auth()->user()->role == "Admin" || auth()->user()->role == "Cadet" || auth()->user()->role == "Encoder" || auth()->user()->role == "Training")
                                '{{ $principal->slug }}': '{{ $principal->name }}',
                            @endif
                        @endforeach
                        @if(auth()->user()->fleet == "FLEET D")
                            'toei': "TOEI",
                            'shinko': "SHINKO"
                        @elseif(auth()->user()->fleet == "FLEET C")
                            'hmm': "HMM"
                        @elseif(in_array(auth()->user()->id, [22, 4504, 5013, 6011, 5963, 6014, 6080, 5907]))
                            'western': "NITTA/TOEI"
                        @elseif(in_array(auth()->user()->id, [4545, 4861, 4988, 6016]))
                            'shinko': "SHINKO"
                        @elseif(in_array(auth()->user()->id, [4520]))
                            'klcsm': "KLCSM",
                            'hmm': "HMM"
                        @elseif(in_array(auth()->user()->id, [5901])) //SIR GWAK
                            'klcsm': "KLCSM",
                            'hmm': "HMM",
                            'possm': "POSSM",
                            'ckMaritime': "CK MARITIME",
                            'sinocrew': "SINOCREW",
                            'kosco': "KOSCO"
                        @endif
                    },
                    onOpen: () => {
                        $('.swal2-select').select2({
                            placeholder: 'Select Principal',
                            width: '100%',
                        });

                        $('.swal2-select').on('select2:open', function (e) {
                            $('.select2-dropdown--below').css('z-index', 1060);
                        });
                    }
                }).then(result => {
                    if(result.value){
                        type = result.value;
                        if(type == "klcsm"){
                            swal({
                                title: 'Select Type',
                                input: 'select',
                                inputOptions: {
                                    klcsm: 'Tanker',
                                    klcsmBulk: 'Bulk'
                                }
                            }).then(result => {
                                if(result.value){
                                    type = result.value;
                                    window.location.href = 'applications/export/' + application.data('id') + '/' + type;
                                }
                            })
                        }
                        else if(type == "sinocrew"){
                            swal({
                                title: 'Select Type',
                                input: 'select',
                                inputOptions: {
                                    sinocrew1: 'Maple Rising Format',
                                    sinocrew2: 'Xing Long Yung',
                                    sinocrew3: 'TENGDA'
                                }
                            }).then(result => {
                                if(result.value){
                                    type = result.value;
                                    window.location.href = 'applications/export/' + application.data('id') + '/' + type;
                                }
                            })
                        }
                        else if(type == "western"){
                            swal({
                                title: 'Select Flag',
                                input: 'select',
                                inputOptions: {
                                    western: 'PANAMA',
                                    westernLiberia: 'LIBERIA'
                                }
                            }).then(result => {
                                if(result.value){
                                    type = result.value;
                                    window.location.href = 'applications/export/' + application.data('id') + '/' + type;
                                }
                            })
                        }
                        else if(type == "toei"){
                            swal({
                                title: 'Check all ECDIS Specific',
                                html: `
                                    <div class="checkbox col-md-offset-2 col-md-8" style="text-align: left;">
                                        <label>
                                            <input type="checkbox" value="ECDIS FURUNO 2107"> ECDIS FURUNO 2107
                                        </label><br>
                                        <label>
                                            <input type="checkbox" value="ECDIS FURUNO 2807"> ECDIS FURUNO 2807
                                        </label><br>
                                        <label>
                                            <input type="checkbox" value="ECDIS FURUNO 3100/3200/3300"> ECDIS FURUNO 3100/3200/3300
                                        </label><br>
                                        <label>
                                            <input type="checkbox" value="ECDIS FURUNO 3300"> ECDIS FURUNO 3300
                                        </label><br>
                                        <label>
                                            <input type="checkbox" value="ECDIS JRC 701B"> ECDIS JRC 701B
                                        </label><br>
                                        <label>
                                            <input type="checkbox" value="ECDIS JRC 7201"> ECDIS JRC 7201
                                        </label><br>
                                        <label>
                                            <input type="checkbox" value="ECDIS JRC 901B"> ECDIS JRC 901B
                                        </label><br>
                                        <label>
                                            <input type="checkbox" value="ECDIS JRC 9201"> ECDIS JRC 9201
                                        </label><br>
                                        <label>
                                            <input type="checkbox" value="ECDIS CHARTWORLD EG2"> ECDIS CHARTWORLD EG2
                                        </label><br>
                                        <label>
                                            <input type="checkbox" value="ECDIS TOKYO"> ECDIS TOKYO
                                        </label><br>
                                        <label>
                                            <input type="checkbox" value="ECDIS TRANSAS"> ECDIS TRANSAS
                                        </label><br>
                                        <label>
                                            <input type="checkbox" value="ECDIS PM3D"> ECDIS PM3D
                                        </label><br>
                                        <label>
                                            <input type="checkbox" value="ECDIS MARTEK"> ECDIS MARTEK
                                        </label><br>
                                        <label>
                                            <input type="checkbox" value="ECDIS MECY"> ECDIS MECY
                                    </div>
                                `,
                                onOpen: () => {
                                    $('#ecdisSpecific').select2({
                                        tags: true
                                    });

                                    $('#ecdisSpecific').on('select2:open', e => {
                                        $('.select2-container').css('z-index', 1060);
                                    });
                                }
                            }).then(result => {
                                if(result.value){
                                    let ecdises = [];
                                    $('.checkbox input:checked').each((i, ecdis) => {
                                        ecdises.push($(ecdis).val());
                                    });
                                    window.location.href = 'applications/export/' + application.data('id') + '/' + type + `?ecdises=${JSON.stringify(ecdises)}`;
                                }
                            })
                        }
                        else{
                            window.location.href = 'applications/export/' + application.data('id') + '/' + type;
                        }
                    }
                });
            }
        }

        function rlu(aId, vessel_id){
            swal({
                type: 'warning',
                title: 'Confirmation',
                text: 'Please confirm removal of lineup.',
                showCancelButton: true,
                cancelButtonColor: '#f76c6b'
            }).then(result => {
                if(result.value){
                    $.ajax({
                        url: '{{ route('applications.updateProApp') }}',
                        data: {
                            col: 'applicant_id',
                            val: aId,
                            update: {principal_id: null, vessel_id: null, rank_id: null, status: 'Vacation'}
                        },
                        success: result => {
                            console.log('Remove LineUp', result);
                            table.search($('#table_filter input').val()).draw();
                            
                            swal({
                                type: 'success',
                                title: 'Successfully removed lineup',
                                timer: 800,
                                showConfirmButton: false
                            });
                        }
                    })
                }
            });
        }

        // ADD TO FLEET
        function atf(aId){
            swal({
                title: 'Select Fleet',
                input: 'select',
                inputOptions: {
                    'FLEET A' : 'FLEET A',
                    'FLEET B' : 'FLEET B',
                    'FLEET C' : 'FLEET C',
                    'FLEET D' : 'FLEET D',
                    'FLEET E' : 'FLEET E',
                    'TOEI' : 'TOEI',
                    'FISHING' : 'FISHING',
                },
                showCancelButton: true,
                cancelButtonColor: '#f76c6b'
            }).then(result => {
                if(result.value){
                    $.ajax({
                        url: '{{ route('users.ajaxUpdate2') }}',
                        data: {
                            column: 'fleet',
                            value: result.value,
                            id: aId
                        },
                        success: () => {
                            table.ajax.reload(null, false);
                            swal({
                                type: 'success',
                                title: 'Successfully assigned to fleet',
                                timer: 800,
                                showConfirmButton: false
                            })
                        }
                    })
                }
            });
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
                    
                    filter();
                }
            });
        }
	</script>
@endpush