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
                                <th>Fleet</th>
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

        .table-striped>tbody>tr:nth-of-type(even) {
            background-color: #fdeee6;
        }

        .onBoard{
            overflow-x: scroll;
        }

        .modal thead tr{
            background-color: #ffddcc !important;
        }

        .custom-striped tr:nth-child(4n+3), .custom-striped tr:nth-child(4n+4) {
            background-color: #fdeee6;
        }

        .custom-striped td{
            padding-top: 1px !important;
            padding-bottom: 1px !important;
        }

        .custom-striped .cs1{
            width: 5%;
        }

        .custom-striped .cs2{
            width: 5%;
        }

        .custom-striped .cs3{
            width: 30%;
        }

        .custom-striped .cs4{
            width: 15%;
        }

        .custom-striped .cs5{
            width: 15%;
        }

        .custom-striped .cs6{
            width: 15%;
        }

        .custom-striped .cs7{
            width: 15%;
        }

        td .btn{
            margin-top: 3px;
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
                { data: 'fleet', name: 'fleet' },
                { data: 'pname', name: 'pname' },
                { data: 'flag', name: 'flag' },
                { data: 'type', name: 'type' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions' },
            ],
            columnDefs: [
                {
                    targets: 0,
                    render: function(id, display, data){
                        return data.row;
                    },
                },
                {
                    targets: 6,
                    render: function(status){
                        console.log(status);
                        let color = status == "ACTIVE" ? '#00a65a' : '#dd4b39';

                        return `
                            <span class="badge" style="background-color: ${color}">${status}</span>
                        `;
                    }
                },
                {
                    targets: 7,
                    width: '120px'
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

            $('[data-original-title="View Crew List"]').on('click', vessel => {
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

            $('[data-original-title="Remove"]').on('click', vessel => {
                let id = $(vessel.target).data('id');

                swal({
                    type: 'question',
                    title: 'Are you sure you want to remove?',
                    text: 'Vessel will not appear here but info will still be in the database',
                    showCancelButton: true,
                    cancelButtonColor: '#f76c6b'
                }).then(result => {
                    if(result.value){
                        $.ajax({
                            url: '{{ route('vessels.update') }}',
                            data: {
                                id: id,
                                column: 'status',
                                value: 'INACTIVE'
                            },
                            success: () => {
                                console.log();
                                table.ajax.reload(null, false);
                                swal({
                                    type: 'success',
                                    title: 'Vessel Successfully Removed',
                                    timer: 1000,
                                    showConfirmButton: false
                                })
                            }
                        })
                    }
                })
            });

            $('[data-original-title="Activate"]').on('click', vessel => {
                let id = $(vessel.target).data('id');

                swal({
                    type: 'question',
                    title: 'Are you sure you want to activate?',
                    showCancelButton: true,
                    cancelButtonColor: '#f76c6b'
                }).then(result => {
                    if(result.value){
                        $.ajax({
                            url: '{{ route('vessels.update') }}',
                            data: {
                                id: id,
                                column: 'status',
                                value: 'ACTIVE'
                            },
                            success: () => {
                                console.log();
                                table.ajax.reload(null, false);
                                swal({
                                    type: 'success',
                                    timer: 1000,
                                    showConfirmButton: false
                                })
                            }
                        })
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
                        createModal(result[2],!bul ? $(vessel.target).data('id') : vessel);
                    }
                    showTables(result[0], result[1]);
                    $('#linedUp').on('show.bs.modal', e => {

                        // REMOVE ALL EVENTS
                        $('[id^=table-select]').unbind();

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

                        $('[id^=table-select-]').on('change', e => {
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

                        // SELECT RELIEVER
                        $('[id^=table-selectR]').on('change', e => {
                            let input = $(e.target);
                            let id = input.data('id');
                            $.ajax({
                                type: "POST",
                                url: "{{ route('applications.updateLineUpContract') }}",
                                data: {
                                    id: id,
                                    reliever: input.val()
                                },
                                success: () => {
                                    swal({
                                        type: 'success',
                                        title: 'Success',
                                        timer: 800,
                                        showConfirmButton: false
                                    }).then(() => {
                                        getVesselCrew(!bul ? $(vessel.target).data('id') : vessel, true);
                                        $('[href=".onBoard"]').click();
                                    });
                                }
                            });
                        });

                        // DISABLE SHOWING OF SELECTION OPTIONS WHEN UNSELECTING
                        $("[id^=table-select-]").on("select2:unselect", function (evt) {
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

                }
            });
        }

        function showTables(onBoard, linedUp){
            let table = `
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td><b>No.</b></td>
                            <td><b>Rank</b></td>
                            <td><b>Name</b></td>
                            <td><b>Age</b></td>
                            <td><b>Passport Exp.</b></td>
                            <td><b>Sbook Exp.</b></td>
                            <td><b>US Visa Exp.</b></td>
                            <td><b>Status</b></td>
                            <td><b>Remarks</b></td>
                            @if(auth()->user()->role != "Principal")
                            <td><b>Actions</b></td>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
            `;

            let table2 = `
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td><b>No.</b></td>
                            <td><b>Rank</b></td>
                            <td><b>Name</b></td>
                            <td><b>Age</b></td>
                            <td><b>Date Joined</b></td>
                            <td><b>MOB</b></td>
                            <td><b>Contract<br>Duration</b></td>
                            <td><b>End of<br>Contract</b></td>
                            <td><b>Passport Exp.</b></td>
                            <td><b>Sbook Exp.</b></td>
                            <td><b>US Visa Exp.</b></td>
                            <td><b>Joining<br>Port</b></td>
                            <td><b>Reliever</b></td>
                            <td><b>Remarks</b></td>
                            @if(auth()->user()->role != "Principal")
                            <td><b>Actions</b></td>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
            `;

            let table3 = `
                <table class="table table-bordered custom-striped">
                    <thead>
                        <tr>
                            <td class="cs1"><b>No.</b></td>
                            <td class="cs2"><b>Rank</b></td>
                            <td class="cs3"><b>Name</b></td>
                            <td class="cs4"><b>DOB</b></td>
                            <td class="cs5"><b>PASSPORT<br>EXPIRY DATE</b></td>
                            <td class="cs6"><b>SBOOK<br>EXPIRY DATE</b></td>
                            <td class="cs7"><b>US VISA<br>EXPIRY DATE</b></td>
                        </tr>
                    </thead>
                    <tbody>
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
                        <td class="LUN" data-id="${crew.applicant_id}">${crew.lname + ', ' + crew.fname + ' ' + (crew.suffix || "") + ' ' + crew.mname}</td>
                        <td>${crew.age}</td>
                        <td>${crew.PASSPORT ? moment(crew.PASSPORT).format('MMM DD, YYYY') : '-----'}</td>
                        <td>${crew["SEAMAN'S BOOK"] ? moment(crew["SEAMAN'S BOOK"]).format('MMM DD, YYYY') : '-----'}</td>
                        <td>${crew["US-VISA"] ? moment(crew["US-VISA"]).format('MMM DD, YYYY') : '-----'}</td>
                        <td>${crew.status2}</td>
                        <td class="remarks">${crew.remarks}</td>
                        @if(auth()->user()->role != "Principal")
                        <td class="actions">
                            <a class="btn btn-info" data-toggle="tooltip" title="Export Documents" onClick="getContract(${crew.applicant_id})">
                                <span class="fa fa-file-text"></span>
                            </a>
                            <a class="btn btn-success" data-toggle="tooltip" title="On-Board" onClick="onBoard(${crew.applicant_id}, ${crew.vessel_id})">
                                <span class="fa fa-ship"></span>
                            </a>
                        </td>
                        @endif
                    </tr>
                `;

                table3 += `
                    <tr>
                        <td rowspan="2">${index + 1}</td>
                        <td rowspan="2">${crew.abbr}</td>
                        <td rowspan="2">${crew.lname + ', ' + crew.fname + ' ' + (crew.suffix || "") + ' ' + crew.mname}</td>
                        <td rowspan="2">${moment(crew.joining_date).format('MMM DD, YYYY')}</td>

                        <td>${crew.PASSPORTn ? crew.PASSPORTn : '-----'}</td>
                        <td>${crew["SEAMAN'S BOOKn"] ? crew["SEAMAN'S BOOKn"] : '-----'}</td>
                        <td>${crew["US-VISAn"] ? crew["US-VISAn"] : '-----'}</td>
                    </tr>

                    <tr>
                        <td>${crew.PASSPORT ? moment(crew.PASSPORT).format('MMM DD, YYYY') : '-----'}</td>
                        <td>${crew["SEAMAN'S BOOK"] ? moment(crew["SEAMAN'S BOOK"]).format('MMM DD, YYYY') : '-----'}</td>
                        <td>${crew["US-VISA"] ? moment(crew["US-VISA"]).format('MMM DD, YYYY') : '-----'}</td>
                    </tr>
                `;
            });

            table3 += `
                </tbody></table>

                <table class="table table-bordered custom-striped">
                    <thead>
                        <tr>
                            <td class="cs1"><b>No.</b></td>
                            <td class="cs2"><b>Rank</b></td>
                            <td class="cs3"><b>Name</b></td>
                            <td class="cs4"><b>DOB</b></td>
                            <td class="cs5"><b>PASSPORT<br>EXPIRY DATE</b></td>
                            <td class="cs6"><b>SBOOK<br>EXPIRY DATE</b></td>
                            <td class="cs7"><b>US VISA<br>EXPIRY DATE</b></td>
                        </tr>
                    </thead>
                    <tbody>
            `;

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

                let reliever = `
                    <select id="table-selectR-${crew.applicant_id}" data-id="${crew.applicant_id}">
                    <option value="">Select Reliever</option>
                    <option value="No Reliever"${crew.reliever == "No Reliever" ? ' selected' : ''}>No Reliever</option>
                `;

                linedUp.concat(onBoard).forEach(rengiSno => {
                    if(crew.abbr == rengiSno.abbr && crew.applicant_id != rengiSno.applicant_id){
                        let name = `${rengiSno.lname + ', ' + rengiSno.fname + ' ' + (rengiSno.suffix || "") + ' ' + rengiSno.mname}`;

                        reliever += `
                            <option value="${rengiSno.applicant_id}"${rengiSno.applicant_id == crew.reliever ? ' selected' : ''}>${rengiSno.abbr} - ${name}</option>
                        `;
                    }
                });

                table2 += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${crew.abbr}</td>
                        <td>${crew.lname + ', ' + crew.fname + ' ' + (crew.suffix || "") + ' ' + crew.mname}</td>
                        <td>${crew.age}</td>
                        <td>${moment(crew.joining_date).format('DD-MMM-YY')}</td>
                        <td>${moment(crew.joining_date).diff(moment(), 'months')}</td>
                        <td>${crew.months}</td>
                        <td>${moment(crew.joining_date).add(crew.months, 'months').format('DD-MMM-YY')}</td>
                        <td>${crew.PASSPORT ? moment(crew.PASSPORT).format('DD-MMM-YY') : '-----'}</td>
                        <td>${crew["SEAMAN'S BOOK"] ? moment(crew["SEAMAN'S BOOK"]).format('DD-MMM-YY') : '-----'}</td>
                        <td>${crew["US-VISA"] ? moment(crew["US-VISA"]).format('DD-MMM-YY') : '-----'}</td>
                        <td>${crew.joining_port}</td>
                        <td>${reliever}</td>
                        <td class="remarks">${crew.remarks}</td>
                        @if(auth()->user()->role != "Principal")
                        <td class="actions">
                            <a class="btn btn-danger" data-toggle="tooltip" title="Sign off" onClick="offBoard(${crew.applicant_id}, ${crew.vessel_id})">
                                <span class="fa fa-ship"></span>
                            </a>
                        </td>
                        @endif
                    </tr>
                `;

                if(crew.reliever){
                    table3 += `
                        <tr>
                            <td rowspan="2">${index + 1}</td>
                            <td rowspan="2">${crew.abbr}</td>
                            <td rowspan="2">${crew.lname + ', ' + crew.fname + ' ' + (crew.suffix || "") + ' ' + crew.mname}</td>
                            <td rowspan="2">${moment(crew.joining_date).format('MMM DD, YYYY')}</td>
                            <td>
                                ${crew.PASSPORTn ? crew.PASSPORTn : '-----'}
                            </td>
                            <td>
                                ${crew["SEAMAN'S BOOKn"] ? crew["SEAMAN'S BOOKn"] : '-----'}
                            </td>
                            <td>
                                ${crew["US-VISAn"] ? crew["US-VISAn"] : '-----'}
                            </td>
                        </tr>

                        <tr>
                            <td>${crew.PASSPORT ? moment(crew.PASSPORT).format('MMM DD, YYYY') : '-----'}</td>
                            <td>${crew["SEAMAN'S BOOK"] ? moment(crew["SEAMAN'S BOOK"]).format('MMM DD, YYYY') : '-----'}</td>
                            <td>${crew["US-VISA"] ? moment(crew["US-VISA"]).format('MMM DD, YYYY') : '-----'}</td>
                        </tr>
                    `;
                }

            });

            $('.tab-pane.linedUp').html(table + "</tbody></table>");
            $('.tab-pane.onBoard').html(table2 + "</table>");
            $('.tab-pane.summary').html(table3 + "</table>");
        }

        function onBoard(id, vessel_id){
            swal({
                title: 'Onboarding Details',
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
                onOpen: () => {
                    $('#date').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                    })
                },
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                confirmButtonText: "Onboard Crew",
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
                        url: `{{ route('applications.updateStatus') }}/${id}/On Board/${vessel_id}`,
                        data: {
                            id: id,
                            port: $('#port').val(),
                            date: $('#date').val(),
                            months: $('#months').val(),
                        },
                        success: vessel => {
                            swal({
                                type: 'success',
                                title: 'Successfully Boarded',
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

        function offBoard(id, vessel_id){
            swal({
                title: 'Disembarkation Details',
                html: `
                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel">Disembarkation Port</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="port" class="swal2-input" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel">Disembarkation Date</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="date" class="swal2-input" placeholder="Select Date"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel2">Remarks</h4>
                        </div>
                        <div class="col-md-7">
                            <select id="remark" class="swal2-input">
                                <option></option>
                                <option value="Vacation">VACATION</option>
                                <option value="DISMISSAL">DISMISSAL</option>
                                <option value="OWN WILL">OWN WILL</option>
                                <option value="MEDICAL REPAT">MEDICAL REPAT</option>
                            </select>
                        </div>
                    </div>
                    <br>
                `,
                onOpen: () => {
                    $('#remark').select2({
                        placeholder: 'Select Remark',
                        tags: true
                    });

                    $('#date').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                    });

                    $('#remark').on('select2:open', () => {
                        $('.select2-container').css('z-index', 1060);
                    });
                },
                width: '50%',
                preConfirm: input => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        setTimeout(() => {
                            let a = $('#port').val();
                            let b = $('#date').val();
                            let c = $('#remark').val();

                            if(a == "" || b == "" || c == ""){
                                swal.showValidationError('All fields is required');
                            }
                        resolve()}, 500);
                    });
                },
            }).then(result => {
                if(result.value){

                    // SAVE DISEMBARKATION DETAILS
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('applications.updateLineUpContract') }}",
                        data: {
                            id: id,
                            disembarkation_port: $('#port').val(),
                            disembarkation_date: $('#date').val()
                        }
                    });

                    // UPDATE STATUS
                    $.ajax({
                        type: 'POST',
                        url: `{{ route('applications.updateStatus') }}/${id}/${$('#remark').val()}/${vessel_id}`,
                        success: result => {
                            swal({
                                type: 'success',
                                title: 'Successfully Disembarked',
                                showConfirmButton: false,
                                timer: 800
                            }).then(() => {
                                getVesselCrew(vessel_id, true);
                                $('[href=".onBoard"]').click();
                            });
                        }
                    });
                }
            });
        }

        function getContract(id){
            swal({
                title: 'Select Document',
                input: 'select',
                inputOptions: {
                    'WalangLagay':      'Walang Lagay',
                    'MLCContract':      'MLC Contract',
                    'POEAContract':     'POEA Contract',
                    'RequestToProcess': 'Request To Process'
                },
                inputPlaceholder: '',
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
            }).then(result => {
                if(result.value){
                    if(result.value == "MLCContract"){
                        getMLCData(id, result.value);
                    }
                    else{
                        window.location.href = `{{ route('applications.exportDocument') }}/${id}/${result.value}`;
                    }
                }
            })
        }

        function getMLCData(id, type){
            let data = {};
            swal({
                title: 'Fill all details',
                html: `
                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel">Date Processed</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="date_processed" class="swal2-input" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel">Effective Date</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="effective_date" class="swal2-input" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel">Med Cert Issue Date</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="med_date" class="swal2-input" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel">Months of employment</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="number" id="employment_months" class="form-control" />
                        </div>
                    </div>
                `,
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                width: '40%',
                onOpen: () => {
                    $('#date_processed, #effective_date, #med_date').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                    })
                },
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        setTimeout(() => {
                            let a = $('#date_processed').val();
                            let b = $('#effective_date').val();
                            let c = $('#med_date').val();
                            let d = $('#employment_months').val();

                            if(a == "" || b == "" || c == "" || d == ""){
                                swal.showValidationError('All fields is required');
                            }
                        resolve()}, 800);
                    });
                },
            }).then(result => {
                if(result.value){
                    data.date_processed     = $('#date_processed').val();
                    data.effective_date     = $('#effective_date').val();
                    data.valid_till         = moment(data.effective_date).add(9, 'months').subtract(1, 'day').format('YYYY-MM-DD');
                    data.med_date           = $('#med_date').val();
                    data.employment_months  = $('#employment_months').val();

                    window.location.href = `{{ route('applications.exportDocument') }}/${id}/${type}?` + $.param(data);
                }
            });
        }

        function createModal(name, id){
            $('body').append(`
                <div class="modal fade" id="linedUp">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header head1">
                                
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>

                                <h4 class="modal-title">
                                    <b><span style="color: #ca0032;">${name}</span> - Crew Details</b>
                                </h4>
                            </div>

                            <div class="modal-body">
                                <ul class="nav nav-pills" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href=".linedUp" role="tab" data-toggle="pill">Lined Up</a>
                                    </li>
                                    <li role="presentation">
                                        <a href=".onBoard" role="tab" data-toggle="pill">On Board</a>
                                    </li>
                                    <li role="presentation">
                                        <a href=".summary" role="tab" data-toggle="pill">Summary</a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in linedUp active"></div>
                                    <div role="tabpanel" class="tab-pane fade onBoard"></div>
                                    <div role="tabpanel" class="tab-pane fade summary"></div>
                                </div>
                            </div>

                            <div class="modal-footer" style="background-color: transparent;">
                                <button type="button" class="btn btn-info" onClick="exportOnOff(${id})">Export On/Off Signers</button>
                                <button type="button" class="btn btn-success" onClick="exportOnBoard(${id}, '${name}')">Export Onboard</button>
                                @if(auth()->user()->role != "Principal")
                                <button type="button" class="btn btn-warning" onClick="RTP(${id})">Request to Process</button>
                                @endif
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>

                </div>`
            );
        }

        function exportOnOff(id){
            swal({
                title: 'Choose Format',
                input: 'select',
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                inputOptions: {
                    ShinkoOnOff: 'Shinko/All',
                    WesternOnOff: 'Western'
                },
            }).then(result => {
                if(result.value){
                    window.location.href = `{{ route('applications.exportOnOff') }}/${id}/${result.value}`;
                }
            })
        }

        function exportOnBoard(id, name){
            let data = {};
            data.id = id;
            data.filename = name.substring(4) + " - Onboard";

            window.location.href = `{{ route('applications.exportDocument') }}/1/OnBoardVessel?` + $.param(data);
        }

        function RTP(id){
            let crews = [];
            let docus = [];

            let temp = $('.LUN');
            let crewString = "";
            let docuString = "";

            let docuArray = [
                {name: 'USA VISA REFUND',},
                {name: 'FLAG'},
                {name: 'VESSEL / PRINCIPAL ENROLLMENT / AMENDMENT'},
                {name: 'IHT CERT'},
                {name: 'CONTRACT'}
            ];

            temp.each((index, value) => {
                let temp2 = $(value);

                crewString += `  
                    <div class="row">
                        <div class="col-md-2">
                            <input type="checkbox" class="crew-checklist" data-id="${temp2.data('id')}" />
                        </div>
                        <div class="col-md-10">
                            <label for="">
                                ${temp2[0].innerText}
                            </label>
                        </div>
                    </div>
                `;
            });

            docuArray.forEach((value, index) => {
                docuString += `  
                    <div class="row">
                        <div class="col-md-2">
                            <input type="checkbox" class="docu-checklist" data-id="${index}" />
                        </div>
                        <div class="col-md-10">
                            <label for="">
                                ${value.name}
                            </label>
                        </div>
                    </div>
                `;
            });

            let config = {
                confirmButtonText: 'Next',
                cancelButtonColor: '#f76c6b',
                allowOutsideClick: false,
                showCancelButton: true,
            }

            swal.queue([
                {
                    ...config,
                    title: 'Select Crew',
                    html: '<br><br>' + crewString,
                    width: '450px',
                    onOpen: () => {
                        $('#swal2-title').css({
                            'font-size': '28px',
                            'color': '#00c0ef'
                        });
                        $('#swal2-content .col-md-10').css('text-align', 'left');
                        $('#swal2-content .col-md-10 label').css({
                            "font-size": '20px',
                            "text-align": 'left'
                        });
                        $('#swal2-content input[type=checkbox]').css({
                            'zoom': '1.7',
                            'margin': '1px 0 0'
                        });
                    },
                    preConfirm: () => {
                        swal.showLoading();
                        return new Promise(resolve => {
                            setTimeout(() => {
                                let temp3 = $(".crew-checklist:checked");
                                
                                temp3.each((index, value) => {
                                    crews.push($(value).data('id'));
                                });
                            resolve()}, 500);
                        });
                    },
                },
                {
                    ...config,
                    title: 'Select Documents',
                    html: '<br><br>' + docuString,
                    width: '450px',
                    onOpen: () => {
                        $('#swal2-title').css({
                            'font-size': '28px',
                            'color': '#00c0ef'
                        });
                        $('#swal2-content .col-md-10').css('text-align', 'left');
                        $('#swal2-content .col-md-10 label').css({
                            "font-size": '20px',
                            "text-align": 'left'
                        });
                        $('#swal2-content input[type=checkbox]').css({
                            'zoom': '1.7',
                            'margin': '1px 0 0'
                        });
                    },
                    preConfirm: () => {
                        swal.showLoading();
                        return new Promise(resolve => {
                            setTimeout(() => {
                                let temp3 = $(".docu-checklist:checked");
                                
                                temp3.each((index, value) => {
                                    docus.push($(value).data('id'));
                                });
                            resolve()}, 500);
                        });
                    },
                },
                {
                    ...config,
                    title: 'Fill Details',
                    html: '<br><br>' + `
                        <div class="row">
                            <div class="col-md-5">
                                <h4 class="clabel">Deparment</h4>
                            </div>
                            <div class="col-md-7">
                                <input type="text" id="department" class="swal2-input" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <h4 class="clabel">Port / Country</h4>
                            </div>
                            <div class="col-md-7">
                                <input type="text" id="port" class="swal2-input" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <h4 class="clabel">Departure</h4>
                            </div>
                            <div class="col-md-7">
                                <input type="text" id="departure" class="swal2-input" />
                            </div>
                        </div>
                    `,
                    width: '450px',
                    onOpen: () => {
                        $('#swal2-title').css({
                            'font-size': '28px',
                            'color': '#00c0ef'
                        });

                        $('#departure').flatpickr({
                            altInput: true,
                            altFormat: 'F j, Y',
                            dateFormat: 'Y-m-d',
                        })
                    },
                    preConfirm: () => {
                        swal.showLoading();
                        return new Promise(resolve => {
                            setTimeout(() => {
                                let a = $('#department').val();
                                let b = $('#port').val();
                                let c = $('#departure').val();

                                if(a == "" || b == "" || c == ""){
                                    swal.showValidationError('All fields is required');
                                }
                            resolve()}, 500);
                        });
                    },
                },
            ]).then(result => {
                if(result.value){
                    let data = {
                        crews: crews,
                        docus: docus,
                        department: $('#department').val(),
                        port: $('#port').val(),
                        departure: $('#departure').val(),
                        filename: $('.modal-title span')[0].innerText.substring(4) + ' - Request To Process',
                        isApplicant: false
                    };

                    window.location.href = `{{ route('applications.exportDocument') }}/1/RequestToProcess?` + $.param(data);
                }
            })
        }
    </script>
@endpush