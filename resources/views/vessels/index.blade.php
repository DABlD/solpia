@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					@include('vessels.includes.toolbar')
				</div>

				<div class="box-body">
					<table class="table table-hover table-bordered" id="table" style="width: 100%;">
						<thead>
							<tr>
								<th>#</th>
								<th>Vessel Name</th>
								<th>Principal</th>
								<th>Flag</th>
								<th>Type</th>
                                <th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
					</table>
				</div>

				<div class="box-footer clearfix">
				</div>

			</div>
		</section>
	</div>

</section>
@endsection

@push('after-styles')
	<link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}">

	<style>
		#table img{
			width: 60px;
			height: 60px;
		}

		.w50{
			width: 60px !important;
		}

        .select2-selection__choice{
            background-color: #f76c6b !important;
        }

        .select2-selection__choice__remove{
            color: black !important;
        }

        .head1{
            background-color: #00a65a !important;
        }

        .clabel{
            margin-top: 20px;
            text-align: right;
        }

        .clabel2{
            margin-top: 5px;
            text-align: right;
        }

        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: #bdb9b9;
        }
	</style>
@endpush

@push('before-scripts')
	<script src="{{ asset('js/datatables.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>
@endpush

@push('after-scripts')
	<script>
		let table = $('#table').DataTable({
            serverSide: true,
            ajax: {
                url: '{{ route('datatables.vessels') }}',
                type: 'POST',
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'principal.name', name: 'principal.name' },
                { data: 'flag', name: 'flag' },
                { data: 'type', name: 'type' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions' },
            ],
            columnDefs: [
                {
                    targets: 5,
                    render: function(status){
                        let color = status == "ACTIVE" ? '#00a65a' : '#dd4b39';

                        return `
                            <span class="badge" style="background-color: ${color}">${status}</span>
                        `;
                    }
                },
            ],
            drawCallback: function(){
                $('#table tbody').append('<div class="preloader"></div>');
                // MUST NOT BE INTERCHANGED t-i
                tooltip();
            	initializeActions();
            },
            // order: [ [0, 'desc'] ],
        });

        table.on('draw', () => {
        	setTimeout(() => {
        		$('.preloader').fadeOut();
        	}, 800);
        });

        function initializeActions(){
            $('[data-original-title="View Vessel Details"]').on('click', vessel => {
                $.ajax({
                    url: 'vessels/get/' + $(vessel.target).data('id'),
                    success: vessel => {
                        vessel = JSON.parse(vessel);
                        let fields = "";

                        let names = [
                            "Vessel Name", "Principal", "Flag", "Type", "Manning Agent", "Year Built", "Builder", "Engine", "Gross Tonnage", "BHP", "Trade", "ECDIS", "Status"
                        ];

                        let columns = [
                            'name', 'principal.name', 'flag', "type", "manning_agent", "year_build", "builder", "engine", "gross_tonnage", "BHP", "trade", "ecdis", "status"
                        ];

                        $.each(Object.keys(vessel), (index, key) => {
                            let temp = columns.indexOf(key);
                            if(temp >= 0){
                                fields += `
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h5><strong>` + names[temp] + `</strong></h5>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" value="` + vessel[key]+ `" readonly/>
                                        </div>
                                    </div>
                                    <br id="` + key + `">
                                `;
                            }
                        });

                        swal({
                            title: 'Vessel Details',
                            width: '50%',
                            html: `
                                <br><br>
                                <div class="row">
                                    <div class="col-md-12">
                                        ` + fields + `
                                    </div>
                                </div>
                            `,
                            onBeforeOpen: () => {
                                // CUSTOM FIELDS

                                // OPTIONAL

                                // MODIFIERS
                            }
                        });
                    }
                });
            });

            $('[data-original-title="Import Vessels"]').on('click', () => {
                swal({
                    title: 'Select Excel File with Vessel Data',
                    html: `
                        <form id="vesselForm" method="POST" action="{{ route('vessels.import') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" class="swal2-file">
                        </form>
                    `
                }).then(file => {
                    if(file.value){
                        $('#vesselForm').submit();
                    }
                });
            });

            $('[data-original-title="View Line-Up"]').on('click', vessel => {
                getVesselCrew(vessel);
            });

            $('[data-original-title="Export Vessels"]').on('click', () => {
                swal({
                    title: 'Please select',
                    input: 'select',
                    inputOptions: {
                        '': 'All',
                        ACTIVE: 'Active',
                        INACTIVE: 'Inactive'
                    },
                }).then(result => {
                    if(!result.dismiss){
                        window.location.href = "{{ route('vessels.export') }}/" + result.value;
                    }
                })
            });
	    }

        function getVesselCrew(vessel, bul = false){
            $.ajax({
                type: 'POST',
                url: '{{ route('applications.getVesselCrew') }}',
                data: {id: !bul ? $(vessel.target).data('id') : vessel},
                dataType: 'json',
                success: result => {
                    if(!$('#linedUp').is(':visible')){
                        createModal();
                    }
                    showTables(result[0], result[1]);
                    $('#linedUp').on('show.bs.modal', e => {
                        $('select').select2({
                            tags: true,
                            class: 'table-select',
                            disabled: {{ !in_array(auth()->user()->role, ['Admin', 'Crewing Manager']) ? 'true' : 'false' }}
                        });

                        $('[id^=table-select] + .select2-container').css('width', '100%');
                        $('[id^=table-select] + .select2-container .select2-selection').css('border', 'none');
                        $('#linedUp .modal-dialog').css('width', '95%');
                        $('.remarks').css({
                            width: '120px',
                            'max-width': '120px'
                        });
                        $('.actions').css('width', '100px');

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

                        $('#linedUp').on('hidden.bs.modal', () => {
                            $('#linedUp').remove();
                        });
                    });

                    $('#linedUp').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#linedUp').modal('show');
                    $('.linedUp .select2-selection.select2-selection--multiple:odd').css('background-color', '#bdb9b9');
                    $('.onBoard .select2-selection.select2-selection--multiple:odd').css('background-color', '#bdb9b9');

                }
            });
        }

        function showTables(onBoard, linedUp){
            let table = `
                <table class="table table-bordered table-striped">
                    <tr>
                        <td>No.</td>
                        <td>Rank</td>
                        <td>Name</td>
                        <td>Age</td>
                        <td>Passport Exp.</td>
                        <td>Sbook Exp.</td>
                        <td>US Visa Exp.</td>
                        <td>Status</td>
                        <td>Remarks</td>
                        <td>Actions</td>
                    </tr>
            `;

            let table2 = `
                <table class="table table-bordered table-striped">
                    <tr>
                        <td>No.</td>
                        <td>Rank</td>
                        <td>Name</td>
                        <td>Age</td>
                        <td>Date Joined</td>
                        <td>MOB</td>
                        <td>Contract Duration</td>
                        <td>End of Contract</td>
                        <td>Passport Exp.</td>
                        <td>Sbook Exp.</td>
                        <td>US Visa Exp.</td>
                        <td>Joining Port</td>
                        <td>Reliever</td>
                        <td>Remarks</td>
                        <td>Actions</td>
                    </tr>
            `;

            // LINE UP TABLE
            linedUp.forEach((crew, index) => {
                crew.remarks = JSON.parse(crew.remarks);
                let selected = "";

                crew.remarks.forEach(remark => {
                    selected += `
                        <option value="${remark}" selected>${remark}</option>
                    `;
                });

                crew.remarks = `
                    <select id="table-select-${crew.applicant_id}" data-id="${crew.applicant_id}" multiple>
                        ${selected}
                    </select>
                `;

                table += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${crew.abbr}</td>
                        <td>${crew.lname + ', ' + crew.fname + ' ' + (crew.suffix || "") + ' ' + crew.mname}</td>
                        <td>${crew.age}</td>
                        <td>${moment(crew.PASSPORT).format('MMM DD, YYYY')}</td>
                        <td>${moment(crew["SEAMAN'S BOOK"]).format('MMM DD, YYYY')}</td>
                        <td>${moment(crew["US-VISA"]).format('MMM DD, YYYY')}</td>
                        <td>${crew.status2}</td>
                        <td class="remarks">${crew.remarks}</td>
                        <td class="actions">
                            <a class="btn btn-info" data-toggle="tooltip" title="Export Contract" onClick="getContract(${crew.applicant_id})">
                                <span class="fa fa-file-text"></span>
                            </a>
                            <a class="btn btn-success" data-toggle="tooltip" title="On-Board" onClick="onBoard(${crew.applicant_id})">
                                <span class="fa fa-ship"></span>
                            </a>
                        </td>
                    </tr>
                `;
            });

            // ON BOARD TABLE
            onBoard.forEach((crew, index) => {
                crew.remarks = JSON.parse(crew.remarks);
                let selected = "";

                crew.remarks.forEach(remark => {
                    selected += `
                        <option value="${remark}" selected>${remark}</option>
                    `;
                });

                crew.remarks = `
                    <select id="table-select-${crew.applicant_id}" data-id="${crew.applicant_id}" multiple>
                        ${selected}
                    </select>
                `;

                table2 += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${crew.abbr}</td>
                        <td>${crew.lname + ', ' + crew.fname + ' ' + (crew.suffix || "") + ' ' + crew.mname}</td>
                        <td>${crew.age}</td>
                        <td></td>
                        <td></td>
                        <td>${crew.months}</td>
                        <td>${moment(crew.joining_date).add(crew.months, 'months').format('DD-MMM-YY')}</td>
                        <td>${moment(crew.PASSPORT).format('MMM DD, YYYY')}</td>
                        <td>${moment(crew["SEAMAN'S BOOK"]).format('MMM DD, YYYY')}</td>
                        <td>${moment(crew["US-VISA"]).format('MMM DD, YYYY')}</td>
                        <td>${crew.joining_port}</td>
                        <td></td>
                        <td class="remarks">${crew.remarks}</td>
                        <td class="actions">
                            <a class="btn btn-info" data-toggle="tooltip" title="Export Contract">
                                <span class="fa fa-file-text"></span>
                            </a>
                            <a class="btn btn-success" data-toggle="tooltip" title="On-Board">
                                <span class="fa fa-ship"></span>
                            </a>
                        </td>
                    </tr>
                `;
            });

            $('.tab-pane.linedUp').html(table + "</table>");
            $('.tab-pane.onBoard').html(table2 + "</table>");
        }

        function onBoard(id){
            swal({
                title: 'Contract Details',
                html: `
                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel">Joining Port</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="port" class="swal2-input" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel">Joining Date</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="date" class="swal2-input" placeholder="Select Date"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel2">Months of Contract</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="number" min="1" id="months" class="form-control" />
                        </div>
                    </div>
                    <br>
                `,
                width: '30%',
                onOpen: () => {
                    $('#date').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                    })
                },
                confirmButtonText: "Create Contract",
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        setTimeout(() => {
                            let a = $('#port').val();
                            let b = $('#date').val();
                            let c = $('#months').val();

                            if(a == "" || b == "" || c == ""){
                                swal.showValidationError('All fields is required');
                            }
                        resolve()}, 500);
                    });
                },
            }).then(result => {
                if(result.value){
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('applications.onBoard') }}',
                        data: {
                            id: id,
                            port: $('#port').val(),
                            date: $('#date').val(),
                            months: $('#months').val(),
                        },
                        success: vessel => {
                            swal({
                                type: 'success',
                                title: 'Successfully Onboarded',
                                showConfirmButton: false,
                                timer: 800
                            }).then(() => {
                                getVesselCrew(vessel, true);
                                $('[href=".onBoard"]').click();
                            });
                        }
                    });
                }
            });
        };

        function getContract(id){
            swal({
                title: 'Choose Contract Type',
                input: 'select',
                inputOptions: {
                    'MLC CONTRACT': 'MLC CONTRACT',
                    'POEA CONTRACT': 'POEA CONTRACT'
                },
                inputPlaceholder: 'Select Contract',
            })
        }

        function createModal(){
            $('body').append(`
                <div class="modal fade" id="linedUp">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header head1">
                                
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>

                                <h4 class="modal-title">
                                    <b>Crew Details</b>
                                </h4>
                            </div>

                            <div class="modal-body">
                                <ul class="nav nav-pills" role="tablist">
                                    <li role="presentation" class="active"><a href=".linedUp" role="tab" data-toggle="pill">Lined Up</a>
                                    </li>
                                    <li role="presentation"><a href=".onBoard" role="tab" data-toggle="pill">On Board</a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in linedUp active"></div>
                                    <div role="tabpanel" class="tab-pane fade onBoard"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`
            );
        }
	</script>
@endpush