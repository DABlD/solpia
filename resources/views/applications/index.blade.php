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
                                    <th>Pic</th>
                                    <th>Rank</th>
    								<th>Last Name</th>
    								<th>First Name</th>
    								<th>Age</th>
    								<th>Contact</th>
                                    <th>Last Vessel</th>
                                    @if(auth()->user()->role == "Cadet" || auth()->user()->role == "Encoder" || auth()->user()->role == "Admin")
    								    <th>Fleet</th>
                                    @endif
                                    <th>Remarks</th>
                                    <th>Actions</th>
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
        swal({
            title: 'Loading',
            timer: 1500
        });
        swal.showLoading();
		var table = $('#table').DataTable({
            serverSide: true,
            ajax: {
                url: '{{ route('datatables.applications') }}',
                type: 'POST',
                data: () => {
                    return $('#formFilter').serialize();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'pa_s', name: 'pa_s' },
                { data: 'avatar', name: 'avatar', visible: false},
                { data: 'rank', name: 'rank' },
                { data: 'lname', name: 'lname' },
                { data: 'fname', name: 'fname' },
                { data: 'age', name: 'age' },
                { data: 'contact', name: 'contact' },
                { data: 'last_vessel', name: 'last_vessel' },
                @if(auth()->user()->role == "Cadet" || auth()->user()->role == "Encoder" || auth()->user()->role == "Admin")
                    { data: 'fleet', name: 'fleet' },
                @endif
                { data: 'remarks', name: 'remarks' },
                { data: 'actions', name: 'actions' },
                { data: 'search', name: 'search', visible: false }
            ],
            columnDefs: [
                {
                    targets: 1,
                    render: function(status, display, row){
                        if(status == "Lined-Up" || status == "On Board"){
                            status += `<br><b data-status="${status}">${row.vessel}</b>`;
                        }

                        return status;
                    },
                },
                {
                    targets: 2,
                    className: "w50",
                    render: function(link){
                        return `<img src="${link}" alt="Applicant Photo"/>`;
                    },
                },
                {
                    targets: 0,
                    render: function(id, display, data){
                        return id;
                    },
                },
                {
                    targets: 4,
                    render: function(row){
                        return row;
                    },
                },
                @if(auth()->user()->role == "Cadet" || auth()->user()->role == "Encoder" || auth()->user()->role == "Admin")
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
                    disabled: {{ !in_array(auth()->user()->role, ['Admin', 'Crewing Manager']) ? 'true' : 'false' }},
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
            }

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

        function initializeActions(){
	    	$('[data-original-title="Export"]').on('click', application => {
                swal({
                    title: 'Select Export Type',
                    input: 'select',
                    inputOptions: {
                        Biodata:        'Biodata',
                        WalangLagay:    'Walang Lagay',
                        HistoryCheck:   'History Check',
                        SeaServiceCertificate:   'Certificate of Sea Service',
                        DocumentChecklist:   'Document Checklist'
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
                            let data = {};
                            if($(application).data('status') != "Lined-Up"){
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

                            @if(auth()->user()->role == "Admin" && auth()->user()->fleet == null)
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
                    }
                })
	    	});

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
                            where: ['fleet', '{{ auth()->user()->fleet }}'],
                            cols: ['id', 'name', 'principal_id']
                        },
                        dataType: 'json',
                        success: result => {
                            result.forEach(a => {
                                aPrincipal
                                vessels[a.id] = a.name;
                                aPrincipal[a.id] = a.principal_id;
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
                                <input type="string" id="eld" placeholder="Expected Date of Lineup (optional)" class="form-control">
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
                                        @if(auth()->user()->fleet == "Fleet B" || auth()->user()->role == "Admin")
                                            mob: $('#mob').val(),
                                            eld: $('#eld').val()
                                        @endif
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
                                </ul>
                                <br><br>

                                <div class="tab-content">
                                  <div role="tabpanel" class="tab-pane fade in pinfo active">a</div>
                                  <div role="tabpanel" class="tab-pane fade educbg">b</div>
                                  <div role="tabpanel" class="tab-pane fade ids">c</div>
                                  <div role="tabpanel" class="tab-pane fade flags">c</div>
                                  <div role="tabpanel" class="tab-pane fade l_cs">c</div>
                                  <div role="tabpanel" class="tab-pane fade med_certs">d</div>
                                  <div role="tabpanel" class="tab-pane fade meds">d</div>
                                  <div role="tabpanel" class="tab-pane fade ss">d</div>
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
                success: files => {
                    files = JSON.parse(files).file;
                    try{
                        files = JSON.parse(files);

                        images = [];
                        files.forEach(file => {
                            console.log(file);
                            let img = new Image();
                            img.src = `files/${aId}/${file}`;
                            img.onload = () => {
                                images.push({
                                    src: img.src,
                                    w: img.width,
                                    h: img.height,
                                });
                            };
                        });

                        setTimeout(() => {
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
                        }, files.length * 250);
                    } catch (error){
                        console.log(files.split('.').pop().toUpperCase());
                        console.log(imageFormats.includes(files.split('.').pop().toUpperCase()));
                        console.log(imageFormats.includes(files.split('.').pop().toUpperCase()));
                        if(imageFormats.includes(files.split('.').pop().toUpperCase())){
                            let img = new Image();
                            img.src = `files/${aId}/${files}`;
                            img.onload = () => {
                                let gallery = new PhotoSwipe(
                                    $('.pswp')[0], 
                                    PhotoSwipeUI_Default, 
                                    [{
                                        src: img.src,
                                        w: img.width,
                                        h: img.height,
                                    }], 
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
                            };
                        }
                        else if(files[0].split('.').pop().toUpperCase() == "PDF"){
                            window.open(`files/${aId}/${files[0]}`);
                        }
                    }
                }
            })
        }

        function deleteFile(id, aId, type){
            swal({
                type: 'warning',
                title: 'Are you sure you want to delete?',
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

            if(application.data('status') == "Lined-Up"){
                window.location.href = 'applications/export/' + application.data('id');
            }
            else{
                swal({
                    title: 'Select Export Type',
                    input: 'select',
                    inputOptions: {
                        '' : '',
                        @foreach($principals as $principal)
                            @if($principal->fleet == auth()->user()->fleet || auth()->user()->role == "Admin")
                                '{{ $principal->slug }}': '{{ $principal->name }}',
                            @endif
                        @endforeach
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
                                            <input type="checkbox" value="ECDIS FURUNO 3200"> ECDIS FURUNO 3200
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
	</script>
@endpush