@extends('layouts.app')
@section('content')

<section class="content">

    <div class="row">
        <section class="col-lg-12">
            <div class="box box-info">

                <div class="box-header">
                    @include('vessels.includes.toolbar')
                </div>

                <div class="table-responsive">
                    <div class="box-body">
                        <table class="table table-hover table-bordered" id="table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Hidden</th>
                                    <th>IMO</th>
                                    <th>Vessel Name</th>
                                    <th>Fleet</th>
                                    <th>Principal</th>
                                    <th>Flag</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    @if(auth()->user()->id == 23)
                                        <th>ID</th>
                                    @endif
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

        .modal thead tr, .wages thead tr{
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
            width: 39.22px;
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

        table .btn{
            width: 39.22px;
        }

        .proposedCrew{
            display: flex;
            align-items: center;
            border-bottom: 1px solid grey;
        }

        .pcrd{
            color: red;
        }

        .proposedCrew .name{
            text-align: left;
        }

        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0; 
        }

        #table td{
            text-align: center;
        }

        .nav-pills a{
            border-top: 3px solid lightgray !important;
        }

        .w-25{
            width: 25%;
        }

        .btn-sm{
            font-size: .65em !important;
        }
    </style>
@endpush

@push('before-scripts')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="{{ asset('js/checklist.js') }}"></script>
@endpush

@push('after-scripts')
    <script>
        let fFleet = "{{ auth()->user()->fleet ?? "%%" }}";
        let fPrincipal = "%%";
        let fFlag = "%%";
        let fType = "%%";
        let fStatus = "Active";

        @if(auth()->user()->id == 23)
        {{-- FOR TEST --}}
        {{-- fFleet = "FLEET B";
        fType = "VLCC"; --}}
        @endif

        function getFilters(){
            return {
                fleet: fFleet,
                principal: fPrincipal,
                flag: fFlag,
                type: fType,
                status: fStatus
            };
        }

        let table = $('#table').DataTable({
            serverSide: true,
            ajax: {
                url: '{{ route('datatables.vessels') }}',
                type: 'POST',
                data: f => {
                    f.filters = getFilters();
                }
            },
            columns: [
                { data: 'created_at', name: 'created_at', visible: false },
                { data: 'imo', name: 'imo' },
                { data: 'name', name: 'name' },
                { data: 'fleet', name: 'fleet' },
                { data: 'pname', name: 'pname' },
                { data: 'flag', name: 'flag' },
                { data: 'type', name: 'type' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions' },
                @if(auth()->user()->id == 23)
                    { data: 'id', name: 'id' },
                @endif
            ],
            columnDefs: [
                {
                    targets: 7,
                    render: function(status){
                        let color = status == "ACTIVE" ? '#00a65a' : '#dd4b39';

                        return `
                            <span class="badge" style="background-color: ${color}">${status}</span>
                        `;
                    }
                },
                {
                    targets: 8,
                    width: '115px'
                },
            ],
            drawCallback: function(){
                $('#table tbody').append('<div class="preloader"></div>');
                // MUST NOT BE INTERCHANGED t-i
                tooltip();
                initializeActions();

                @if(auth()->user()->id == 23)
                {{-- FOR TEST. USE VESSEL ID --}}
                {{-- $('[data-id="5842"][data-original-title="View Crew List"]').click(); --}}
                @endif
            },
            order: [ [0, 'desc'] ],
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

        function filter(){
            swal({
                title: 'Filters',
                html: `
                    <div class="row iRow">
                        <div class="col-md-3 iLabel">
                            Fleet
                        </div>
                        <div class="col-md-9 iInput">
                            <select id="fFleet" class="form-control">
                                <option value="%%">All</option>
                                <option value="FLEET A">Fleet A</option>
                                <option value="FLEET B">Fleet B</option>
                                <option value="FLEET C">Fleet C</option>
                                <option value="FLEET D">Fleet D</option>
                                <option value="FLEET E">Fleet E</option>
                                <option value="TOEI">TOEI</option>
                                <option value="Fishing">Fishing</option>
                            </select>
                        </div>
                    </div>
                    </br>

                    <div class="row iRow">
                        <div class="col-md-3 iLabel">
                            Principal
                        </div>
                        <div class="col-md-9 iInput">
                            <select id="fPrincipal" class="form-control">
                                <option value="%%">All</option>
                                @foreach($principals as $principal)
                                    <option class="fPrincipal" data-fleet="{{ $principal->fleet }}" value="{{ $principal->id }}">{{ $principal->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    </br>

                    <div class="row iRow">
                        <div class="col-md-3 iLabel">
                            Flag
                        </div>
                        <div class="col-md-9 iInput">
                            <select id="fFlag" class="form-control">
                                <option value="%%">All</option>
                                @foreach($flags2 as $flag)
                                    @if($flag->flag != "")
                                    <option value="{{ $flag->flag }}">{{ $flag->flag }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    </br>

                    <div class="row iRow">
                        <div class="col-md-3 iLabel">
                            Type
                        </div>
                        <div class="col-md-9 iInput">
                            <select id="fType" class="form-control">
                                <option value="%%">All</option>
                                <option value="BULK CARRIER">BULK CARRIER</option>
                                <option value="BULK CARRIER (LOG)">BULK CARRIER (LOG)</option>
                                <option value="CONTAINER">CONTAINER</option>
                                <option value="CAR CARRIER">CAR CARRIER</option>
                                <option value="GENERAL CARGO">GENERAL CARGO</option>
                                <option value="OIL/CHEM">OIL/CHEM</option>
                                <option value="PROD. TANKER">PROD. TANKER</option>
                                <option value="LNG">LNG</option>
                                <option value="VLCC">VLCC</option>
                                <option value="WOODCHIP">WOODCHIP</option>
                                <option value="PURSE SEINER">PURSE SEINER</option>
                                <option value="LONGLINER">LONGLINER</option>
                                <option value="TRAWLER">TRAWLER</option>
                                <option value="SQUID JIGGER">SQUID JIGGER</option>
                                <option value="LONGLINER (TUNA)">LONGLINER (TUNA)</option>
                            </select>
                        </div>
                    </div>
                    </br>

                    <div class="row iRow">
                        <div class="col-md-3 iLabel">
                            Status
                        </div>
                        <div class="col-md-9 iInput">
                            <select id="fStatus" class="form-control">
                                <option value="%%">All</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    </br>
                `,
                onOpen: () => {
                    $('#fFleet').val(fFleet);
                    $('#fPrincipal').val(fPrincipal);
                    $('#fFlag').val(fFlag);
                    $('#fType').val(fType);
                    $('#fStatus').val(fStatus);

                    $('#fType, #fFlag, #fPrincipal').select2();

                    $('#fPrincipal').on('select2:open', function (e) {
                        let fleet = $('#fFleet').val().toUpperCase();

                        if(fleet != "%%"){
                            setTimeout(() => {
                                $(`.fPrincipal`).addClass('hidden');
                                $('.select2-results__option').hide()
                                if(fleet != "%%"){
                                    $(`[data-fleet="${fleet}"]`).removeClass('hidden');
                                    $(`.fPrincipal:not(.hidden)`).each((i,e) => {
                                        $(`.select2-results__option:contains(${e.innerText})`).show()
                                    });

                                    if(fleet == "FLEET C"){
                                        $(`.select2-results__option:contains(HMM)`).show()
                                    }
                                    else if(fleet == "FLEET D"){
                                        $(`.select2-results__option:contains(TOEI)`).show()
                                    }
                                }
                                else{
                                    $(`.fPrincipal`).removeClass('hidden');
                                    $('.select2-results__options .select2-results__option').show();
                                }

                                // $('#fPrincipal').select2("destroy").select2();
                            }, 10);
                        }
                    });
                }
            }).then(result => {
                if(result.value){
                    fFleet = $('#fFleet').val();
                    fPrincipal = $('#fPrincipal').val();
                    fFlag = $('#fFlag').val();
                    fType = $('#fType').val();
                    fStatus = $('#fStatus').val();

                    reload();
                }
            });
        }

        function showVesselDetails(vessel, editable){
            let fields = "";

            let names = [
                "IMO",
                "Size",
                "Vessel Name",
                "Flag", 
                "Type", 
                "Manning Agent", 
                "Ship Manager", 
                "Year Built", 
                "Builder", 
                "Engine", 
                "Gross Tonnage", 
                "KW", 
                "Trade", 
                "ECDIS", 
                'Former Agency',
                'Former Principal',
                'MLC Shipowner',
                'Address',
                'Registered Shipowner',
                'Address',
                'Work Hours',
                'MAX OT HOURS',
                'CBA AFFILIATION',
                'Classification Society',
                'Months in Contract'
            ];

            let columns = [
                'imo',
                'size',
                'name', 
                'flag', 
                "type", 
                "manning_agent", 
                "ship_manager", 
                "year_build", 
                "builder", 
                "engine", 
                "gross_tonnage", 
                "BHP", 
                "trade", 
                "ecdis",
                'former_agency',
                'former_principal',
                'mlc_shipowner',
                'mlc_shipowner_address',
                'registered_shipowner',
                'registered_shipowner_address',
                'work_hours',
                'ot_hours',
                'cba_affiliation',
                'classification',
                'months_in_contract'
            ];

            $.each(Object.keys(vessel), (index, key) => {
                let temp = columns.indexOf(key);

                if(temp >= 0){
                    fields += `
                        <div class="row">
                            <div class="col-md-3" style="text-align: left;">
                                <h5><strong>` + names[temp] + `</strong></h5>
                            </div>
                            <div class="col-md-9">
                                <input type="text" id="vd-${key}" class="form-control" value="` + (vessel[key] ? ["BHP", "gross_tonnage"].includes(key) ? parseFloat(vessel[key].split(',').join('')).toLocaleString() : vessel[key] : '') + `"${editable ? '' : ' readonly'}/>
                            </div>
                        </div>
                        <br id="` + key + `">
                    `;
                }
            });

            let principal = "";
            if(editable){
                principal = `
                    <div class="row">
                        <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                            <strong>
                                Select Principal
                            </strong>
                        </div>
                        <div class="col-md-9">
                            <select id="principal_id" class="form-control" ${editable ? '' : 'disabled'}>
                                <option></option>
                            </select>
                        </div>
                    </div>
                    </br>
                `;
            }
            else{
                principal = `
                    <div class="row">
                        <div class="col-md-3" style="text-align: left;">
                            <h5><strong>Principal</strong></h5>
                        </div>
                        <div class="col-md-9">
                            <input type="text" id="principal_id" class="form-control" readonly/>
                        </div>
                    </div>
                    <br>
                `;
            }

            swal({
                title: 'Vessel Details',
                width: '50%',
                html: `
                    <br><br>
                    ${principal}
                    <div class="row">
                        <div class="col-md-12">
                            ` + fields + `
                        </div>
                    </div>
                `,
                onBeforeOpen: () => {
                    // CUSTOM FIELDS
                    $.ajax({
                        url: '{{ route('principal.get') }}',
                        data: {
                            cols: ['id', 'name', 'active'],
                            where: ['active', 1]
                        },
                        success: principals => {
                            principals = Object.entries(JSON.parse(principals));
                            let options = "";
                            let options2 = [];

                            principals.reverse().forEach((principal, index) => {
                                options += `<option value="${principal[1].id}">${principal[1].name}</option>`;
                                options2[principal[1].id] = principal[1].name;
                            });


                            if(editable){
                                $('#principal_id').append(options);
                                $('#principal_id').select2({
                                    placeholder: 'Select Principal',
                                    tags: true
                                });

                                $('#principal_id').val(vessel['principal_id']).change();
                            }
                            else{
                                $('#principal_id').val(options2[vessel['principal_id']]);
                            }
                        }
                    });
                    // OPTIONAL

                    // MODIFIERS
                },
                onOpen: () => {
                    if(editable){
                        let col = $('#vd-size').parent();
                        $('#vd-size').remove();

                        let string = `
                            <select id="vd-size" class="form-control">
                                <option value=""></option>
                                <optgroup label="Bulk"></optgroup>
                                    <option value="Handymax">&nbsp;&nbsp;&nbsp;&nbsp;Handymax</option>
                                    <option value="Handysize">&nbsp;&nbsp;&nbsp;&nbsp;Handysize</option>
                                    <option value="Supramax">&nbsp;&nbsp;&nbsp;&nbsp;Supramax</option>
                                    <option value="Panamax">&nbsp;&nbsp;&nbsp;&nbsp;Panamax</option>
                                    <option value="Post Panamax">&nbsp;&nbsp;&nbsp;&nbsp;Post Panamax</option>
                                    <option value="Capesize">&nbsp;&nbsp;&nbsp;&nbsp;Capesize</option>
                                    <option value="VLOC">&nbsp;&nbsp;&nbsp;&nbsp;VLOC</option>
                                <optgroup label="Tanker"></optgroup>
                                    <option value="Aframax">&nbsp;&nbsp;&nbsp;&nbsp;Aframax</option>
                                    <option value="Suezmax">&nbsp;&nbsp;&nbsp;&nbsp;Suezmax</option>
                                    <option value="VLCC">&nbsp;&nbsp;&nbsp;&nbsp;VLCC</option>
                            </select>
                        `;

                        col.append(string);
                        if(vessel.size){
                            $('#vd-size').val(vessel.size);
                        }

                        $('#vd-size').select2({placeholder: 'Select Size'});
                        $('#vd-size').on("select2:open", () => {
                            $('.select2-dropdown').css({
                                'z-index': 9999
                            });
                        });
                        $('#select2-vd-size-container').css('text-align', 'left');
                    }

                    function updateTextView(_obj){
                        var num = getNumber(_obj.val());
                        if(num==0){
                            _obj.val('');
                        }
                        else{
                            _obj.val(num.toLocaleString());
                        }
                    }

                    function getNumber(_str){
                        var arr = _str.split('');
                        var out = new Array();
                        for(var cnt=0;cnt<arr.length;cnt++){
                            if(isNaN(arr[cnt])==false){
                                out.push(arr[cnt]);
                            }
                        }
                        return Number(out.join(''));
                    }

                    $('#vd-BHP, #vd-gross_tonnage').on('keyup',function(){
                        updateTextView($(this));
                    });
                },
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                cancelButtonText: 'Close',
                confirmButtonText: editable ? 'Save' : 'Edit'
            }).then(result => {
                if(result.value){
                    if(editable){
                        $.ajax({
                            url: '{{ route('vessels.updateAll') }}',
                            data: {
                                id: vessel.id,
                                principal_id: $('#principal_id').val(),
                                imo: $('#vd-imo').val(),
                                size: $('#vd-size').val(),
                                name: $('#vd-name').val(),
                                flag: $('#vd-flag').val(),
                                type: $('#vd-type').val(),
                                manning_agent: $('#vd-manning_agent').val(),
                                ship_manager: $('#vd-ship_manager').val(),
                                year_build: $('#vd-year_build').val(),
                                builder: $('#vd-builder').val(),
                                engine: $('#vd-engine').val(),
                                gross_tonnage: $('#vd-gross_tonnage').val(),
                                BHP: $('#vd-BHP').val(),
                                trade: $('#vd-trade').val(),
                                ecdis: $('#vd-ecdis').val(),
                                former_agency: $('#vd-former_agency').val(),
                                former_principal: $('#vd-former_principal').val(),
                                mlc_shipowner: $('#vd-mlc_shipowner').val(),
                                mlc_shipowner_address: $('#vd-mlc_shipowner_address').val(),
                                registered_shipowner_address: $('#vd-registered_shipowner_address').val(),
                                registered_shipowner: $('#vd-registered_shipowner').val(),
                                work_hours: $('#vd-work_hours').val(),
                                ot_per_hour: $('#vd-ot_per_hour').val(),
                                ot_hours: $('#vd-ot_hours').val(),
                                cba_affiliation: $('#vd-cba_affiliation').val(),
                                classification: $('#vd-classification').val(),
                                months_in_contract: $('#vd-months_in_contract').val()
                            },
                            success: () => {
                                swal({
                                    type: 'success',
                                    title: 'Vessel Details Successfully Updated',
                                    timer: 800,
                                    showConfirmButton: false
                                }).then(() => {
                                    reload();

                                    setTimeout(() => {
                                        $(`[data-original-title="View Vessel Details"] [data-id="${vessel.id}"]`).click();
                                    }, 1500);
                                });
                            }
                        })
                    }
                    else{
                        showVesselDetails(vessel, true);
                    }
                }
            });
        }

        function initializeActions(){
            $('[data-original-title="View Vessel Details"]').on('click', vessel => {
                $.ajax({
                    url: 'vessels/get/' + $(vessel.target).data('id'),
                    data: {
                        status: $(vessel.target).data('status')
                    },
                    success: vessel => {
                        vessel = JSON.parse(vessel);
                        showVesselDetails(vessel, false);
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

                            <select name="type" class="form-control">
                                <option value="default">Default</option>
                                <option value="addVesselDetails">Additional Vessel Details</option>
                                <option value="addVesselWageScale">Import Wage Scale</option>
                            </select>
                        </form>
                    `
                }).then(file => {
                    if(file.value){
                        $('#vesselForm').submit();
                    }
                });
            });

            $('[data-original-title="View Crew List"]').on('click', vessel => {
                swal.showLoading();
                getVesselCrew(vessel);
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

            $('[data-original-title="Assign to a Fleet"]').on('click', vessel => {
                let id = $(vessel.target).data('id');

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
                            url: '{{ route('vessels.update') }}',
                            data: {
                                id: id,
                                column: 'fleet',
                                value: result.value
                            },
                            success: () => {
                                table.ajax.reload(null, false);
                                swal({
                                    type: 'success',
                                    title: 'Fleet Successfully Updated',
                                    timer: 800,
                                    showConfirmButton: false
                                })
                            }
                        })
                    }
                });
            });

            $('[data-original-title="Ships Particular"]').on('click', vessel => {
                let id = $(vessel.target).data('id');
                $.ajax({
                    url: '{{ route('vessels.getParticular') }}',
                    data: {id: id},
                    success: particular => {
                        if(particular != ""){
                            swal({
                                html: `
                                    <a href="particulars/${particular}" download>
                                        <h3>Download Here</h3>
                                    </a>
                                `,
                                confirmButtonText: 'Upload New',
                                showCancelButton: true,
                                cancelButtonColor: '#f76c6b',
                                cancelButtonText: 'Close'
                            }).then(result => {
                                if(result.value){
                                    uploadParticular(id);
                                }
                            });
                        }
                        else{
                            swal({
                                html: `
                                    <h3 style="color: red;">No File Yet</h3>
                                `,
                                confirmButtonText: 'Upload',
                                showCancelButton: true,
                                cancelButtonColor: '#f76c6b',
                                cancelButtonText: 'Close'
                            }).then(result => {
                                if(result.value){
                                    uploadParticular(id);
                                }
                            })
                        }
                    }
                })
            });

            $('[data-original-title="Wage Scale"]').on('click', vessel => {
                let id = $(vessel.target).data('id');
                let vname = $(vessel.target).data('name');

                $.ajax({
                    url: '{{ route('wage.get') }}',
                    data: {
                        cols: ['wages.*', 'r.abbr as rname'],
                        where: ['vessel_id', id],
                        order: ['r.order', 'asc']
                    },
                    success: wages => {
                        showWages(wages, id, vname);
                    }
                })
            });
        }

        function showWages(wages, vid, vname){
            wages = JSON.parse(wages);
            let wageString = "";

            swal({
                title: vname + ' Wages',
                width: '95%',
                html: `
                    <div class="table-responsive">
                    <table class="table table-bordered table-striped wages">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Rank</td>
                                <td>BP</td>
                                <td>LP</td>
                                <td>FOT</td>
                                <td>GOT</td>
                                <td>SUB ALLOW.</td>
                                <td>RETIRE ALLOW.</td>
                                <td>SUP ALLOW</td>
                                <td>ENGINE ALLOW</td>
                                <td>OTHER ALLOW</td>
                                <td>VOYAGE ALLOW</td>
                                <td>OWNER ALLOW</td>
                                <td>TANKER ALLOW</td>
                                <td>ACA</td>
                                <td>TOTAL</td>
                                <td>OT/HR</td>
                                <td>LPM</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    </div>
                `,
                onBeforeOpen: () => {
                    wages.forEach(wage => {
                        wageString += `
                            <tr>
                                <td>${wage.id}</td>
                                <td>${wage.rname}</td>
                                <td>${wage.basic}</td>
                                <td>${wage.leave_pay ?? '---'}</td>
                                <td>${wage.fot ?? '---'}</td>
                                <td>${wage.ot ?? '---'}</td>
                                <td>${wage.sub_allow ?? '---'}</td>
                                <td>${wage.retire_allow ?? '---'}</td>
                                <td>${wage.sup_allow ?? '---'}</td>
                                <td>${wage.engine_allow ?? '---'}</td>
                                <td>${wage.other_allow ?? '---'}</td>
                                <td>${wage.voyage_allow ?? '---'}</td>
                                <td>${wage.owner_allow ?? '---'}</td>
                                <td>${wage.tanker_allow ?? '---'}</td>
                                <td>${wage.aca ?? '---'}</td>
                                <td>${wage.total}</td>
                                <td>${wage.ot_per_hour ?? '---'}</td>
                                <td>${wage.leave_per_month ?? '---'}</td>
                                <td>${wage.actions}</td>
                            </tr>
                        `;
                    });
                },
                onOpen: () => {
                    $('.wages tbody').html(wageString);
                    $('.swal2-title').css('width', '100%');
                    $('.swal2-content td').css('vertical-align', 'middle');
                    $('.swal2-title').append(`
                        <div class="pull-right">
                            <a class="btn btn-success" onClick="addEntry(${vid})">
                                Add Entry
                            </a>
                            <a class="btn btn-info" onClick="duplicate(${vid})">
                                Duplicate Wage to Other Vessel
                            </a>
                        </div>`);
                }
            })
        }

        function addEntry(vid){
            swal.showLoading();

            $.ajax({
                url: '{{ route('applications.getRanks') }}',
                success: ranks => {
                    ranks = JSON.parse(ranks);
                    let rankString = "";

                    Object.keys(ranks).forEach(category => {
                        rankString += `<optgroup label="${category}"></optgroup>`;

                        ranks[category].forEach(rank => {
                            rankString += `
                                <option value="${rank.id}">
                                    &nbsp;&nbsp;&nbsp;${rank.name} (${rank.abbr})
                                </option>`;
                        });
                    });

                    swal({
                        title: 'Enter Details',
                        html: `

                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                <select id="rank_id" class="form-control">
                                    <option value="">Select Rank</option>
                                    ${rankString}
                                </select>
                            </div>
                            <br><br>
                            <br><br>
                            
                            <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                Basic Pay
                            </div>    
                            <div class="col-md-9">
                                <input type="number" min="0" id="basic" class="form-control compute"><br>
                            </div>
                            
                            <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                Leave Pay
                            </div>                                
                            <div class="col-md-9">
                                <input type="number" min="0" id="leave_pay" class="form-control compute"><br>
                            </div>
                            
                            <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                F.O.T.
                            </div>                                
                            <div class="col-md-9">
                                <input type="number" min="0" id="fot" class="form-control compute"><br>
                            </div>
                            
                            <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                G.O.T.
                            </div>                                
                            <div class="col-md-9">
                                <input type="number" min="0" id="ot" class="form-control compute"><br>
                            </div>
                            
                            <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                Sub. Allow.
                            </div>                                
                            <div class="col-md-9">
                                <input type="number" min="0" id="sub_allow" class="form-control compute"><br>
                            </div>
                            
                            <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                Retire Allow.
                            </div>                                
                            <div class="col-md-9">
                                <input type="number" min="0" id="retire_allow" class="form-control compute"><br>
                            </div>
                            
                            <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                Sup. Allow.
                            </div>                                
                            <div class="col-md-9">
                                <input type="number" min="0" id="sup_allow" class="form-control compute"><br>
                            </div>
                            
                            <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                Engine Allow.
                            </div>                                
                            <div class="col-md-9">
                                <input type="number" min="0" id="engine_allow" class="form-control compute"><br>
                            </div>
                            
                            <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                Other Allow.
                            </div>                                
                            <div class="col-md-9">
                                <input type="number" min="0" id="other_allow" class="form-control compute"><br>
                            </div>
                            
                            <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                Voyage Allow.
                            </div>                                
                            <div class="col-md-9">
                                <input type="number" min="0" id="voyage_allow" class="form-control compute"><br>
                            </div>
                            
                            <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                Owner Allow.
                            </div>                                
                            <div class="col-md-9">
                                <input type="number" min="0" id="owner_allow" class="form-control compute"><br>
                            </div>
                            
                            <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                Tanker Allow.
                            </div>                                
                            <div class="col-md-9">
                                <input type="number" min="0" id="tanker_allow" class="form-control compute"><br>
                            </div>
                            
                            <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                ACA
                            </div>                        
                            <div class="col-md-9">
                                <input type="number" min="0" id="aca" class="form-control compute"><br>
                            </div>

                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                <input type="number" min="0" id="total" class="form-control" placeholder="Total" readonly><br>
                            </div>
                            
                            </br>
                            </br>

                            <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                OT/HR
                            </div>
                            <div class="col-md-9">
                                <input type="number" min="0" id="ot_per_hour" class="form-control"><br>
                            </div>
                            <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                Leave Per Month
                            </div>
                            <div class="col-md-9">
                                <input type="number" min="0" id="leave_per_month" class="form-control"><br>
                            </div>
                        `,
                        width: "500px",
                        preConfirm: () => {
                            swal.showLoading();
                            return new Promise(resolve => {
                                setTimeout(() => {
                                    if($('#rank_id').val() == ""){
                                        swal.showValidationError('At least rank is required');
                                    }
                                resolve()}, 500);
                            });
                        },
                        onOpen: () => {
                            $('#rank_id').select2();
                            $('#rank_id').on('select2:open', () => {
                                $('.swal2-container').css('z-index', 1000);
                            });

                            $('.form-control.compute').on('input', () => {
                                let total = 0;
                                $('.form-control.compute').each((i, input) => {
                                    if(input.value != ""){
                                        total = parseFloat(total) + parseFloat(input.value);
                                    }
                                });
                                $('#total').val(total);
                            });
                        }
                    }).then(result => {
                        swal.close();
                        if(result.value){
                            $.ajax({
                                url: '{{ route('wage.create') }}',
                                data: {
                                    rank_id: $('#rank_id').val(),
                                    basic: $('#basic').val(),
                                    leave_pay: $('#leave_pay').val(),
                                    fot: $('#fot').val(),
                                    ot: $('#ot').val(),
                                    sub_allow: $('#sub_allow').val(),
                                    retire_allow: $('#retire_allow').val(),
                                    sup_allow: $('#sup_allow').val(),
                                    engine_allow: $('#engine_allow').val(),
                                    other_allow: $('#other_allow').val(),
                                    voyage_allow: $('#voyage_allow').val(),
                                    owner_allow: $('#owner_allow').val(),
                                    tanker_allow: $('#tanker_allow').val(),
                                    aca: $('#aca').val(),
                                    total: $('#total').val(),
                                    ot_per_hour: $('#ot_per_hour').val(),
                                    leave_per_month: $('#leave_per_month').val(),
                                    vessel_id: vid
                                },
                                success: result => {
                                    console.log("Added Wage for Vessel #" + vid, result);
                                    swal({
                                        type: 'success',
                                        title: 'Success',
                                        showConfirmButton: false,
                                        timer: 800
                                    }).then(() => {
                                        $(`.btn-default [data-id=${vid}]`).click();
                                    });
                                }
                            });
                        }
                        else{
                            $(`.btn-default [data-id=${vid}]`).click();
                        }
                    });
                }
            });
        }

        function duplicate(vid){
            $.ajax({
                url: '{{ route('wage.getVessels') }}',
                success: vessels => {
                    vessels = JSON.parse(vessels);

                    swal({
                        title: 'Select Vessel',
                        html: `
                            <select id="vessel">
                                <option value="">Select Vessel</option>
                            </select>
                        `,
                        showCancelButton: true,
                        cancelButtonColor: '#f76c6b',
                        onOpen: () => {
                            let choices = "";

                            console.log(vessels);
                            vessels.forEach(vessel => {
                                choices += `<option value="${vessel.id}">${vessel.name} (${vessel.imo})</option>`;
                            });

                            $('#vessel').append(choices);
                            $('#vessel').select2();
                            $('#vessel').on('select2:open', () => {
                                $('.swal2-container').css("z-index", 1000);
                            });
                        }
                    }).then(result => {
                        if(result.value){
                            let vid2 = $('#vessel').val();

                            $.ajax({
                                url: '{{ route('wage.duplicate') }}',
                                data: {vid: vid, vid2: vid2},
                                type: 'POST',
                                success: result => {
                                    if(result){
                                        console.log("Duplicated Wage for Vessel #" + vid + " to Vessel #" + vid2);

                                        swal({
                                            type: 'success',
                                            title: 'Success',
                                            showConfirmButton: false,
                                            timer: 800
                                        }).then(() => {
                                            $(`.btn-default [data-id=${vid2}]`).click();
                                        })
                                    }
                                }
                            })
                        }
                        else{
                            $(`.btn-default [data-id=${vid}]`).click();
                        }
                    });
                }
            })
        }

        function deleteWage(id, vid){
            swal({
                type: 'warning',
                title: 'Confirmation',
                text: 'Are you sure you want to delete entry?',
                showCancelButton: true,
                cancelButtonColor: '#f76c6b'
            }).then(result => {
                if(result.value){
                    $.ajax({
                        url: '{{ route('wage.delete') }}',
                        type: 'POST',
                        data: {id: id},
                        success: result => {
                            console.log(`Deleted Wage id #${id} from vessel #${vid}`, result);
                            swal({
                                type: 'success',
                                title: 'Success',
                                timer: 800,
                                showConfirmButton: false
                            }).then(() => {
                                $(`.btn-default [data-id=${vid}]`).click();
                            })
                        }
                    })
                }
                else{
                    $(`.btn-default [data-id=${vid}]`).click();
                }
            })
        }

        function editEntry(id){
            swal.close();
            swal.showLoading();

            $.ajax({
                url: '{{ route('wage.get') }}',
                data: {
                    cols: ['wages.*', 'r.name as rname'],
                    where: ['wages.id', id],
                },
                success: wage => {
                    wage = JSON.parse(wage)[0];
                    
                    $.ajax({
                        url: '{{ route('applications.getRanks') }}',
                        success: ranks => {
                            ranks = JSON.parse(ranks);
                            let rankString = "";

                            Object.keys(ranks).forEach(category => {
                                rankString += `<optgroup label="${category}"></optgroup>`;

                                ranks[category].forEach(rank => {
                                    rankString += `
                                        <option value="${rank.id}">
                                            &nbsp;&nbsp;&nbsp;${rank.name} (${rank.abbr})
                                        </option>`;
                                });
                            });

                            swal({
                                title: 'Enter Details',
                                html: `
                                    <div class="col-md-3"></div>
                                    <div class="col-md-9">
                                        <select id="rank_id" class="form-control">
                                            <option value="">Select Rank</option>
                                            ${rankString}
                                        </select>
                                    </div>
                                    <br><br>
                                    <br><br>
                                    
                                    <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                        Basic Pay
                                    </div>    
                                    <div class="col-md-9">
                                        <input type="number" min="0" value="${wage.basic}" id="basic" class="form-control compute"><br>
                                    </div>
                                    
                                    <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                        Leave Pay
                                    </div>                                
                                    <div class="col-md-9">
                                        <input type="number" min="0" value="${wage.leave_pay}" id="leave_pay" class="form-control compute"><br>
                                    </div>
                                    
                                    <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                        F.O.T.
                                    </div>                                
                                    <div class="col-md-9">
                                        <input type="number" min="0" value="${wage.fot}" id="fot" class="form-control compute"><br>
                                    </div>
                                    
                                    <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                        G.O.T.
                                    </div>                                
                                    <div class="col-md-9">
                                        <input type="number" min="0" value="${wage.ot}" id="ot" class="form-control compute"><br>
                                    </div>
                                    
                                    <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                        Sub. Allow.
                                    </div>                                
                                    <div class="col-md-9">
                                        <input type="number" min="0" value="${wage.sub_allow}" id="sub_allow" class="form-control compute"><br>
                                    </div>
                                    
                                    <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                        Retire Allow.
                                    </div>                                
                                    <div class="col-md-9">
                                        <input type="number" min="0" value="${wage.retire_allow}" id="retire_allow" class="form-control compute"><br>
                                    </div>
                                    
                                    <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                        Sup. Allow.
                                    </div>                                
                                    <div class="col-md-9">
                                        <input type="number" min="0" value="${wage.sup_allow}" id="sup_allow" class="form-control compute"><br>
                                    </div>
                                    
                                    <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                        Engine Allow.
                                    </div>                                
                                    <div class="col-md-9">
                                        <input type="number" min="0" value="${wage.engine_allow}" id="engine_allow" class="form-control compute"><br>
                                    </div>
                                    
                                    <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                        Other Allow.
                                    </div>                                
                                    <div class="col-md-9">
                                        <input type="number" min="0" value="${wage.other_allow}" id="other_allow" class="form-control compute"><br>
                                    </div>
                                    
                                    <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                        Voyage Allow.
                                    </div>                                
                                    <div class="col-md-9">
                                        <input type="number" min="0" value="${wage.voyage_allow}" id="voyage_allow" class="form-control compute"><br>
                                    </div>
                                    
                                    <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                        Owner Allow.
                                    </div>                                
                                    <div class="col-md-9">
                                        <input type="number" min="0" value="${wage.owner_allow}" id="owner_allow" class="form-control compute"><br>
                                    </div>
                                    
                                    <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                        Tanker Allow.
                                    </div>                                
                                    <div class="col-md-9">
                                        <input type="number" min="0" value="${wage.tanker_allow}" id="tanker_allow" class="form-control compute"><br>
                                    </div>
                                    
                                    <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                        ACA
                                    </div>                        
                                    <div class="col-md-9">
                                        <input type="number" min="0" value="${wage.aca}" id="aca" class="form-control compute"><br>
                                    </div>

                                    <div class="col-md-3"></div>
                                    <div class="col-md-9">
                                        <input type="number" min="0" id="total" class="form-control" placeholder="Total" readonly><br>
                                    </div>
                            
                                    </br>
                                    </br>

                                    <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                        OT/HR
                                    </div>                        
                                    <div class="col-md-9">
                                        <input type="number" min="0" value="${wage.ot_per_hour}" id="ot_per_hour" class="form-control"><br>
                                    </div>

                                    <div class="col-md-3" style="text-align:left; margin-top: 10px; font-weight: bold; font-size: 12px;">
                                        Leave Per Month
                                    </div>                        
                                    <div class="col-md-9">
                                        <input type="number" min="0" value="${wage.leave_per_month}" id="leave_per_month" class="form-control"><br>
                                    </div>
                                `,
                                preConfirm: () => {
                                    swal.showLoading();
                                    return new Promise(resolve => {
                                        setTimeout(() => {
                                            if($('#rank_id').val() == ""){
                                                swal.showValidationError('At least rank is required');
                                            }
                                        resolve()}, 500);
                                    });
                                },
                                width: "500px",
                                onOpen: () => {
                                    $('#rank_id').select2();
                                    $('#rank_id').on('select2:open', () => {
                                        $('.swal2-container').css('z-index', 1000);
                                    });
                                    $('#rank_id').val(wage.rank_id).trigger('change');

                                    let total = 0;
                                    $('.form-control.compute').each((i, input) => {
                                        if(input.value != ""){
                                            total = parseFloat(total) + parseFloat(input.value);
                                        }
                                    });
                                    $('#total').val(total);

                                    $('.form-control.compute').on('input', () => {
                                        let total = 0;
                                        $('.form-control.compute').each((i, input) => {
                                            if(input.value != ""){
                                                total = parseFloat(total) + parseFloat(input.value);
                                            }
                                        });
                                        $('#total').val(total);
                                    });
                                }
                            }).then(result => {
                                swal.close();
                                if(result.value){
                                    $.ajax({
                                        url: '{{ route('wage.update') }}',
                                        type: 'POST',
                                        data: {
                                            rank_id: $('#rank_id').val(),
                                            basic: $('#basic').val(),
                                            leave_pay: $('#leave_pay').val(),
                                            fot: $('#fot').val(),
                                            ot: $('#ot').val(),
                                            sub_allow: $('#sub_allow').val(),
                                            retire_allow: $('#retire_allow').val(),
                                            sup_allow: $('#sup_allow').val(),
                                            engine_allow: $('#engine_allow').val(),
                                            other_allow: $('#other_allow').val(),
                                            voyage_allow: $('#voyage_allow').val(),
                                            owner_allow: $('#owner_allow').val(),
                                            tanker_allow: $('#tanker_allow').val(),
                                            aca: $('#aca').val(),
                                            total: $('#total').val(),
                                            ot_per_hour: $('#ot_per_hour').val(),
                                            leave_per_month: $('#leave_per_month').val(),
                                            id: id
                                        },
                                        success: result => {
                                            console.log("Updated Wage #" + id, result);
                                            swal({
                                                type: 'success',
                                                title: 'Success',
                                                showConfirmButton: false,
                                                timer: 800
                                            }).then(() => {
                                                $(`.btn-default [data-id=${wage.vessel_id}]`).click();
                                            });
                                        }
                                    });
                                }
                                else{
                                    $(`.btn-default [data-id=${wage.vessel_id}]`).click();
                                }
                            });
                        }
                    })
                }
            })
        }

        function showSr(id, vid){
            $.ajax({
                url: '{{ route('wage.get') }}',
                data: {
                    cols: ['wages.id', 'wages.sr_pay'],
                    where: ['wages.id', id],
                },
                success: wage => {
                    wage = JSON.parse(wage)[0];
                    let sr_pay = wage.sr_pay;
                    let srStr = "";
                    let len = 2;

                    if(sr_pay != null && sr_pay != ""){
                        sr_pay = JSON.parse(sr_pay);
                        sr_pay.forEach(sr => {
                            srStr += `
                                <tr>
                                    <td>
                                        ${len}
                                    </td>
                                    <td>
                                        <input type="text" value="${sr}"><br>
                                    </td>
                                </tr>
                            `;
                            len++;
                        })
                    }

                    swal({
                        html: `<table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td>Seniority Level</td>
                                    <td>Seniority Pay</td>
                                </tr>
                            </thead>
                            <tbody id="srs">
                                ${srStr}
                            </tbody>
                        </table>`,
                        showCancelButton: true,
                        cancelButtonText: 'Save',
                        cancelButtonColor: '#00a65a',
                        confirmButtonText: 'Add Entry',
                        showCloseButton: true,
                        onOpen: () => {
                            $('.swal2-container input').css({
                                'border': 'none',
                                'text-align': 'center'
                            });
                        },
                        preConfirm: () => {
                            return new Promise(resolve => {
                                $('#srs').append(`
                                    <tr>
                                        <td>
                                            ${len}
                                        </td>
                                        <td>
                                            <input type="text"><br>
                                        </td>
                                    </tr>
                                `);
                                len++;
                                $('.swal2-container input').css({
                                    'border': 'none',
                                    'text-align': 'center'
                                });

                                swal.enableButtons();
                            });
                        },
                    }).then(result => {
                        if(result.dismiss == "cancel"){
                            let srs = $('.swal2-container input:visible');
                            let srsv = [];

                            srs.each((i, sr) => {
                                const temp = $(sr).val();
                                if(temp != ""){
                                    srsv.push(temp);
                                }
                            });

                            $.ajax({
                                url: '{{ route('wage.update') }}',
                                type: 'POST',
                                data: {
                                    id: id,
                                    sr_pay: JSON.stringify(srsv)
                                },
                                success: result => {
                                    console.log("Updated SR Pay of wage id #" + id, result);
                                    swal({
                                        type: 'success',
                                        timer: 800,
                                        showConfirmButton: false,
                                    }).then(() => {
                                        $(`.btn-default [data-id=${vid}]`).click();
                                    });
                                }
                            })
                        }
                        else{
                            $(`.btn-default [data-id=${vid}]`).click();
                        }
                    })
                }
            })
        }

        $('[title="Add Vessel"]').on('click', () => {
            swal.showLoading();

            $.ajax({
                url: '{{ route('principal.get') }}',
                data: {
                    cols: ['id', 'name', 'active'],
                    where: ['active', 1]
                },
                success: principals => {
                    setTimeout(() => {
                        swal({
                            title: 'Enter Vessel Details',
                            html: `
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Select Principal
                                    </div>
                                    <div class="col-md-9">
                                        <select id="principal_id" class="form-control">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Enter Manning Agent
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="manning_agent" class="form-control" value="SOLPIA">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Enter Ship Manager (Optional)
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="ship_manager" class="form-control">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Enter Vessel Name
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="name" class="form-control">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Enter IMO
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" id="imo" class="form-control">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Enter Flag
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="flag" class="form-control">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Enter Type of Vessel
                                    </div>
                                    <div class="col-md-9">
                                        <select id="type" class="form-control">
                                            <option value="">Select Vessel Type</option>
                                            <option value="BULK CARRIER">BULK CARRIER</option>
                                            <option value="BULK CARRIER (LOG)">BULK CARRIER (LOG)</option>
                                            <option value="CONTAINER">CONTAINER</option>
                                            <option value="CAR CARRIER">CAR CARRIER</option>
                                            <option value="GENERAL CARGO">GENERAL CARGO</option>
                                            <option value="OIL/CHEM">OIL/CHEM</option>
                                            <option value="PROD. TANKER">PROD. TANKER</option>
                                            <option value="LNG">LNG</option>
                                            <option value="VLCC">VLCC</option>
                                            <option value="WOODCHIP">WOODCHIP</option>
                                            <option value="PURSE SEINER">PURSE SEINER</option>
                                            <option value="LONGLINER">LONGLINER</option>
                                            <option value="TRAWLER">TRAWLER</option>
                                            <option value="SQUID JIGGER">SQUID JIGGER</option>
                                            <option value="LONGLINER (TUNA)">LONGLINER (TUNA)</option>
                                        </select>
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Enter Year Built
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="year_build" class="form-control">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Enter Builder
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="builder" class="form-control">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Enter Engine
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="engine" class="form-control">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Enter GRT
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" id="gross_tonnage" class="form-control">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Enter KW
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" id="bhp" class="form-control">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Enter Trade Route
                                    </div>
                                    <div class="col-md-9">
                                        <select id="trade" class="form-control">
                                            <option value="">Select Trade</option>
                                            @foreach($trades as $trade)
                                                @if($trade->trade != "")
                                                <option value="{{ $trade->trade }}">{{ $trade->trade }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Enter Trade ECDIS
                                    </div>
                                    <div class="col-md-9">
                                        <select id="ecdis" class="form-control">
                                            <option value="">Select Vessel Type</option>
                                            @foreach($ecdiss as $ecdis)
                                                @if($ecdis->ecdis != "")
                                                <option value="{{ $ecdis->ecdis }}">{{ $ecdis->ecdis }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Former Agency
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="former_agency" class="form-control">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Former Principal
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="former_principal" class="form-control">
                                    </div>
                                </div>
                                </br>
                                </br>

                                <h3 style="text-align: left;"><b>For POEA Contract</b></h3>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        MLC Shipowner
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="mlc_shipowner" class="form-control">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Address
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="mlc_shipowner_address" class="form-control">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Registered Shipowner
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="registered_shipowner" class="form-control">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Address
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="registered_shipowner_address" class="form-control">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Work Hours
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="work_hours" class="form-control">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        MAX OT PER HOUR
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="ot_hours" class="form-control">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        CBA AFFILIATION
                                    </div>
                                    <div class="col-md-9">
                                        <select id="cba_afflication" class="form-control">
                                            <option value="">Select CBA Affliation</option>
                                            @foreach($cbas as $cba)
                                                @if($cba->cba_affiliation != "")
                                                <option value="{{ $cba->cba_affiliation }}">{{ $cba->cba_affiliation }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Classification Society
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="classifications" class="form-control">
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    <div class="col-md-3" style="margin-top: 10px; text-align: left;">
                                        Months in Contract
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="months_in_contract" class="form-control">
                                    </div>
                                </div>
                                </br>
                            `,
                            width: "50%",
                            preConfirm: () => {
                                swal.showLoading();
                                return new Promise(resolve => {
                                    setTimeout(() => {
                                        let error = "Up to IMO is required";

                                        if(!$('#principal_id').val()){
                                            swal.showValidationError(error);
                                        }
                                        if(!$('#manning_agent').val()){
                                            swal.showValidationError(error);
                                        }
                                        if(!$('#name').val()){
                                            swal.showValidationError(error);
                                        }
                                        if(!$('#imo').val()){
                                            swal.showValidationError(error);
                                        }
                                    resolve()}, 500);
                                });
                            },
                            onOpen: () => {
                                principals = Object.entries(JSON.parse(principals));
                                let space = "&nbsp;&nbsp;&nbsp;";
                                let options = "";

                                principals.reverse().forEach((principal, index) => {
                                    options += `<option value="${principal[1].id}">${space + principal[1].name}</option>`;
                                });

                                $('#principal_id').append(options);
                                $('#principal_id').select2({
                                    placeholder: 'Select Principal',
                                    tags: true
                                });

                                $('#cba_affliation, #trade, #ecdis').select2();

                                $('#type').select2({
                                    tags: true
                                });

                                // CSS
                                $(".swal2-input[type='number']").css({
                                    'max-width': '100%'
                                });

                                $('.select2-selection').css({
                                    'text-align': 'left'
                                });

                                $('#principal_id').on("select2:open", () => {
                                    $('.select2-dropdown').css({
                                        'z-index': 9999
                                    });
                                });
                            }
                        }).then(result => {
                            if(result.value){
                                $.ajax({
                                    url: '{{ route('vessels.add') }}',
                                    data: {
                                        principal_id: $('#principal_id').val(),
                                        manning_agent: $('#manning_agent').val(),
                                        ship_manager: $('#ship_manager').val(),
                                        name: $('#name').val(),
                                        imo: $('#imo').val(),
                                        flag: $('#flag').val(),
                                        type: $('#type').val(),
                                        year_build: $('#year_build').val(),
                                        builder: $('#builder').val(),
                                        engine: $('#engine').val(),
                                        gross_tonnage: $('#gross_tonnage').val(),
                                        bhp: $('#bhp').val(),
                                        trade: $('#trade').val(),
                                        ecdis: $('#ecdis').val(),
                                        former_agency: $('#former_agency').val(),
                                        former_principal: $('#former_principal').val(),
                                        mlc_shipowner: $('#mlc_shipowner').val(),
                                        mlc_shipowner_address: $('#mlc_shipowner_address').val(),
                                        registered_shipowner: $('#registered_shipowner').val(),
                                        registered_shipowner_address: $('#registered_shipowner_address').val(),
                                        work_hours: $('#work_hours').val(),
                                        ot_hours: $('#ot_hours').val(),
                                        cba_affiliation: $('#cba_affiliation').val(),
                                        classification: $('#classification').val(),
                                        months_in_contract: $('#months_in_contract').val()
                                    },
                                    success: result => {
                                        console.log("vessel add", result);

                                        swal({
                                            type: 'success',
                                            title: 'Successfully added vessel',
                                            timer: 800,
                                            showConfirmButton: false
                                        })
                                    }
                                })
                            }
                        });
                    }, 1000);
                }
            });
        });

        function uploadParticular(id){
            swal({
                title: 'Select File',
                html: `
                    <form action="{{ route('vessels.updateParticular') }}" enctype="multipart/form-data" method="POST" target="_blank">
                        @csrf
                        <input type="file" name="file[]" id="file" class="swal2-file"/>
                        <input type="hidden" name="id" value="${id}">
                    </form>
                `,
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
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                cancelButtonText: 'Close'
            }).then(result => {
                if(result.value){
                    $('.swal2-content form').submit();
                    swal({
                        type: 'success',
                        title: 'Successful Upload',
                        timer: 1000,
                        showConfirmButton: false
                    })
                }
            })
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
                    showTables(result[0], result[1], result[3], !bul ? $(vessel.target).data('id') : vessel);

                    // CLOSE LOADING
                    swal.close();
                    
                    $('#linedUp').on('show.bs.modal', e => {
                        // REMOVE ALL EVENTS
                        $('[id^=table-select]').unbind();

                        $('select').select2({
                            tags: true,
                            class: 'table-select',
                            disabled: {{ !in_array(auth()->user()->role, ['Admin', 'Crewing Manager', 'Crewing Officer']) ? 'true' : 'false' }}
                        });

                        $('[id^=table-select] + .select2-container').css('width', '100%');
                        $('[id^=table-select] + .select2-container .select2-selection').css('border', 'none');
                        $('#linedUp .modal-dialog').css('width', '95%');
                        $('.remarks').css({
                            width: '120px',
                            'max-width': '120px'
                        });

                        $('.actions1').css('width', '190px');
                        $('.actions2').css('width', '150px');

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
                                    reliever: input.val(),
                                    type: 'Embark'
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

                    $('#linedUp').on('hide.bs.modal', e => {
                        $('#table_filter [type="search"]').focus();
                    });

                    $('body').keydown(function(e){
                        if(e.which == 27){
                            $('#linedUp').modal('hide');
                        }
                    });
                }
            });
        }

        function exportMonitoring(vid){
             window.open("{{ route('vessels.exportMonitoring') }}?id=" + vid, '_blank');
        }

        function viewInfo(id){
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
        };

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

                            if(b == "" || c == ""){
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

        function offBoard(id, vessel_id, date){
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
                                <option value="Vacation">FINISHED CONTRACT</option>
                                <option value="DISMISSAL">DISMISSAL</option>
                                <option value="OWN WILL">OWN WILL</option>
                                <option value="MEDICAL REPAT">MEDICAL REPAT</option>
                                <option value="VESSEL SOLD">VESSEL SOLD</option>
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
                        defaultDate: date
                    });

                    $('#remark').on('select2:open', () => {
                        $('.select2 .select2-container').css('z-index', 1060);
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

                            if(b == "" || c == ""){
                                swal.showValidationError('All fields is required');
                            }
                        resolve()}, 500);
                    });
                },
            }).then(result => {
                if(result.value){
                    // UPDATE STATUS
                    $.ajax({
                        type: 'POST',
                        url: `{{ route('applications.updateStatus') }}/${id}/${$('#remark').val()}/${vessel_id}`,
                        data: {
                            id: id,
                            disembarkation_port: $('#port').val(),
                            disembarkation_date: $('#date').val(),
                            remark: $('#remark').val()
                        },
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

        function onBoardPromote(applicant_id, vessel_id, rank_id){
            $.ajax({
                url: '{{ route('applications.getRanks') }}',
                success: ranks => {
                    ranks = JSON.parse(ranks);
                    let rankString = "";
                    let rankArray = [];

                    Object.keys(ranks).forEach(category => {
                        rankString += `<optgroup label="${category}"></optgroup>`;

                        ranks[category].forEach(rank => {
                            rankArray[rank.id] = rank.abbr;
                            rankString += `
                                <option value="${rank.id}">
                                    &nbsp;&nbsp;&nbsp;${rank.name} (${rank.abbr})
                                </option>`;
                        });
                    });

                    swal({
                        title: "Enter Details",
                        html: `
                            <div style="text-align: left;">
                                <label>Effective Date</label>
                            </div>
                            <input type="text" id="ed" class="form-control"><br>

                            <input type="number" min="1" id="cd" class="form-control" placeholder="Contract Duration"><br>

                            <select id="rank_id" class="form-control">
                                <option value="">Promote To:</option>
                                ${rankString}
                            </select><br><br>
                        `,
                        onOpen: () => {
                            $('#rank_id').select2();

                            $('#ed').flatpickr({
                                altInput: true,
                                altFormat: 'F j, Y',
                                dateFormat: 'Y-m-d',
                                defaultDate: moment().format("YYYY-MM-DD")
                            })
                        }
                    }).then(result => {
                        let cd = $('#cd').val();
                        let rank = $('#rank_id').val();
                        let ed = $('#ed').val();

                        if(result.value && cd != "" && rank != "" && ed != ""){
                            // DISEMBARK
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('applications.updateLineUpContract') }}",
                                data: {
                                    id: applicant_id,
                                    disembarkation_date: moment().format("YYYY-MM-DD"),
                                    ed: ed,
                                    type: 'On Board Promotion',
                                    remark: "Promoted as " + rankArray[rank]
                                },
                                success: result2 => {
                                    console.log('on board update lineup: ' + result.value);
                                    // UPDATE STATUS
                                    $.ajax({
                                        type: 'POST',
                                        url: `{{ route('applications.updateStatus') }}/${applicant_id}/${"On Board"}/${vessel_id}`,
                                        data: {
                                            date: ed,
                                            months: cd,
                                            rank: rank
                                        },
                                        success: result => {
                                            swal({
                                                type: 'success',
                                                title: 'Successfully Promoted On Board',
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
                    })
                }
            });
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

                            getVesselCrew(vessel_id, true);
                            $('[href=".linedUp"]').click();

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

        function eod(id, vessel_id, joining_date, months, joining_port){
            swal({
                title: 'Edit Details',
                width: '30%',
                html: `
                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel">Joining Date</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="joining_date" class="swal2-input" placeholder="Select Date"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel">Contract Duration</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="number" min="1" id="months" class="form-control" style="margin-top: 10px;" value="${months}" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel2" style="margin-top: 15px;">Joining Port</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="joining_port" class="swal2-input" value="${joining_port ?? ""}" />
                        </div>
                    </div>
                    <br>
                `,
                onOpen: () => {
                    $('#joining_date').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                        defaultDate: moment(joining_date).format("YYYY-MM-DD")
                    })
                },
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                confirmButtonText: "Update",
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        setTimeout(() => {
                            let a = $('#joining_date').val();
                            let b = $('#months').val();
                            let c = $('#joining_port').val();

                            if(a == "" || b == ""){
                                swal.showValidationError('Joining Date and Contract Duration is required');
                            }
                        resolve()}, 500);
                    });
                },
            }).then(result => {
                if(result.value){
                    $.ajax({
                        url: '{{ route('applications.updateContract') }}',
                        data: {
                            col: 'id',
                            val: id,
                            update: {
                                joining_date: $('#joining_date').val(),
                                months: $('#months').val(),
                                joining_port: $('#joining_port').val(),
                            }
                        },
                        success: result => {
                            console.log('Update LineUp', result);

                            getVesselCrew(vessel_id, true);
                            $('[href=".onBoard"]').click();

                            swal({
                                type: 'success',
                                title: 'Successfully Updated On-Board Details',
                                timer: 800,
                                showConfirmButton: false
                            });
                        }
                    })
                }
            })
        }

        function getContract(id){
            swal({
                title: 'Select Document',
                input: 'select',
                inputOptions: {
                    'Biodata':                          'Biodata',
                    'X01_BorrowDocuments':              'Borrow Documents',
                    'X11_CrewCompetencyChecklist':      'Crew Competency Checklist',
                    'Y06_EMSDeclaration':               'EMS Declaration',
                    'X29_FinalBriefing':                'Final Briefing',
                    'DocumentChecklist':                'Final Document Checklist',
                    'X08_KoscoWaiver':                  'Kosco Waiver',
                    'Y04_LetterOfOath':                 'Letter Of Oath',
                    'Y03_LetterOfOathMarpol':           'Letter Of Oath (MARPOL)',
                    'X28_DispatchChecklist':            'Line-up/Dispatch Checklist',
                    'MLCContract':                      'MLC Contract',
                    'POEAContract':                     'POEA Contract',
                    'X39_QualificationChecklistKSS':    'Qualification Checklist (KSS Line)',
                    'Y07_TOEIMLCQuestionnaire':         'TOEI - MLC Questionnaire',
                    'X04_USVE':                         'US Visa Endorsement Form',
                    'WalangLagay':                      'Walang Lagay',
                },
                onOpen: () => {
                    $('.swal2-select').select2();
                    $('.swal2-select').on("select2:open", () => {
                        $('.select2-dropdown').css({
                            'z-index': 9999
                        });
                    });
                    $('.swal2-select').parent().css('text-align', 'center');
                    $('.select2-container').css('width', '100%');
                },
                inputPlaceholder: '',
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
            }).then(result => {
                if(result.value){
                    if(result.value == "MLCContract"){
                        getMLCData(id, result.value);
                    }
                    else if(result.value == "Biodata"){
                        exportBiodata(id);
                    }
                    else if(result.value == "POEAContract"){
                        getPOEAData(id, result.value);
                    }
                    else if(result.value == "X01_BorrowDocuments"){
                        FBBD(id, result.value);
                    }
                    else if(result.value == "DocumentChecklist"){
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
                                    EDC(id, fleet, "DocumentChecklist");
                                }
                            });
                        @else
                            EDC(id, fleet, "DocumentChecklist");
                        @endif
                    }
                    else if(result.value == "X04_USVE"){
                        USVE(id, result.value);
                    }
                    else if(result.value == "X11_CrewCompetencyChecklist"){
                        CCC(id, result.value);
                    }
                    else if(result.value == "X28_DispatchChecklist"){
                        getDispatchChecklistData(id, result.value);
                    }
                    else if(result.value == "X29_FinalBriefing"){
                        getFinalBriefingData(id, result.value);
                    }
                    else if(result.value.includes("Y0")){
                        let data = {};
                            data.id = id;
                            data.exportType = "pdf";

                        window.location.href = `{{ route('applications.exportDocument') }}/${id}/${result.value}?` + $.param(data);
                    }
                    else{
                        window.location.href = `{{ route('applications.exportDocument') }}/${id}/${result.value}`;
                    }
                }
            })
        }

        function exportBiodata(id){
            console.log('biodata');
            $.ajax({
                url: "{{ route('applications.get2') }}",
                data: {
                    cols: "*",
                    where: ['applicants.id', id],
                    load: ['pro_app']
                },
                success: result => {
                    result = JSON.parse(result)[0];
                    console.log(result);
                    
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
                                window.location.href = 'applications/export/' + id + '/' + type;
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
                                window.location.href = 'applications/export/' + id + '/' + type;
                            }
                        })
                    }
                    // IF TOEI
                    else if(result.principal_id == 3){
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
                                window.location.href = 'applications/export/' + id + `/toei/?ecdises=${JSON.stringify(ecdises)}`;
                            }
                        })
                    }
                    else{
                        window.location.href = 'applications/export/' + id;
                    }
                }
            })
        }

        function getContract2(id){
            swal({
                title: 'Select Document',
                input: 'select',
                inputOptions: {
                    'XBD'               : "Biodata",
                    'contract_amendment': "Contract Amendment",
                    'MLCContract':          'MLC Contract',
                    'X20_DebriefingForm':  'Debriefing Form',
                    @if(in_array(auth()->user()->fleet, ["FLEET A", "TOEI"]) || auth()->user()->role == "Admin")
                        'Y03_LetterOfOathMarpol':  'Letter Of Oath (MARPOL)',
                        'Y04_LetterOfOath':  'Letter Of Oath',
                        'Y06_EMSDeclaration':  'EMS Declaration',
                        'Y07_TOEIMLCQuestionnaire': "TOEI - MLC Questionnaire"
                    @endif
                },
                inputPlaceholder: '',
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
            }).then(result => {
                if(result.value){
                    if(result.value.startsWith("X")){
                        // will call x01,x02,x06,x15,x20, etc
                        window[result.value.slice(0,3)](id, result.value);
                    }
                    else if(result.value == "MLCContract"){
                        getMLCData(id, result.value);
                    }
                    else if(result.value == "contract_amendment"){
                        contractAmendment(id);
                    }
                    else if(result.value.includes("Y0")){
                        let data = {};
                            data.id = id;
                            data.exportType = "pdf";

                        window.location.href = `{{ route('applications.exportDocument') }}/${id}/${result.value}?` + $.param(data);
                    }
                    else{
                        window.location.href = `{{ route('applications.exportDocument') }}/${id}/${result.value}`;
                    }
                }
            })
        }

        function XBD(id, ehh){
            window.location.href = 'applications/export/' + id;
        }

        function contractAmendment(id){
            swal({
                title: 'Select Category',
                input: 'select',
                inputOptions: {
                    'X15_Ext_Form':  'Extension',
                    'X15_Ext_Form2':  'Salary Amendment',
                    'X06_Ext_Prom_Form':  'Extension Promotion'
                },
                inputPlaceholder: '',
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
            }).then(result => {
                if(result.value){
                    window[result.value.slice(0,3)](id, result.value, result.value.slice(-1) == 2 ? "SALARY AMENDMENT" : "EXTENSION");
                }
            })
        }

        function X06(id, type){
            swal.showLoading();

            $.ajax({
                url: '{{ route('applications.getRanks') }}',
                success: ranks => {
                    ranks = JSON.parse(ranks);
                    let rankString = "";

                    Object.keys(ranks).forEach(category => {
                        rankString += `<optgroup label="${category}"></optgroup>`;

                        ranks[category].forEach(rank => {
                            rankString += `
                                <option value="${rank.id}">
                                    &nbsp;&nbsp;&nbsp;${rank.name} (${rank.abbr})
                                </option>`;
                        });
                    });

                    swal({
                        title: 'Enter Details',
                        html: `
                            <select id="rank_id" class="form-control">
                                <option value="">Promote To:</option>
                                ${rankString}
                            </select><br><br>

                            <input type="text" id="doe" class="form-control" placeholder="Date of Effectivity"><br>
                            <input type="text" id="recommended_by" class="form-control" placeholder="Recommended By (optional)"><br>
                            <input type="text" id="remarks" class="form-control" placeholder="Remarks (optional)"><br>
                            <input type="number" min="1" id="cd" class="form-control" placeholder="Contract Duration (optional)"><br>
                        `,
                        preConfirm: () => {
                            swal.showLoading();
                            return new Promise(resolve => {
                                setTimeout(() => {
                                    if($('#rank_id').val() == ""){
                                        swal.showValidationError('Date of Effectivity is required');
                                    }
                                resolve()}, 500);
                            });
                        },
                        onOpen: () => {
                            $('#rank_id').select2();
                            $('#rank_id').on('select2:open', () => {
                                $('.select2-dropdown').css('z-index', 1060);
                            });

                            $('#doe').flatpickr({
                                altInput: true,
                                altFormat: 'F j, Y',
                                dateFormat: 'Y-m-d'
                            })
                        }
                    }).then(result => {
                        if(result.value){
                            let data = {
                                rank: $('#rank_id').val(),
                                doe: $('#doe').val(),
                                recommended_by: $('#recommended_by').val(),
                                remarks: $('#remarks').val(),
                                status: "On Board",
                                cd: $('#cd').val()
                            }

                            window.location.href = `{{ route('applications.exportDocument') }}/${id}/${type}?` + $.param({data});
                        }
                    });
                }
            });
        }

        function X15(id, type, type2){
            swal.showLoading();

            swal({
                title: 'Enter Details',
                html: `
                    <input type="text" id="doe" class="form-control" placeholder="Date of Effectivity"><br>
                    <input type="text" id="recommended_by" class="form-control" placeholder="Recommended By (optional)"><br>
                    <input type="text" id="remarks" class="form-control" placeholder="Remarks (optional)"><br>
                    <input type="number" min="1" id="cd" class="form-control" placeholder="Contract Duration (optional)"><br>
                `,
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        setTimeout(() => {
                            if($('#doe').val() == ""){
                                swal.showValidationError('Date of Effectivity is required');
                            }
                        resolve()}, 500);
                    });
                },
                onOpen: () => {
                    $('#doe').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d'
                    })
                }
            }).then(result => {
                if(result.value){
                    let data = {
                        doe: $('#doe').val(),
                        recommended_by: $('#recommended_by').val(),
                        remarks: $('#remarks').val(),
                        status: "On Board",
                        type2: type2,
                        cd: $('#cd').val()
                    }

                    if(type2 == "SALARY AMENDMENT"){
                        type = "X15_Ext_Form";
                        data.filename = "X15_Salary_Amendment";
                    }

                    window.location.href = `{{ route('applications.exportDocument') }}/${id}/${type}?` + $.param({data});
                }
            });
        }

        function X20(id, type){
            swal({
                title: 'Enter Details',
                width: '500px',
                html: `
                    ${input('joining_date', '', $(`.jdate[data-id="${id}"]`).data('date'), 4, 8, 'hidden')},
                    ${input('disembarkation_date', 'Date Disembarked', $(`.ddate[data-id="${id}"]`).data('date'), 4, 8)},

                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="iLabel">Reason for Signed/Off</h4>
                        </div>
                        <div class="col-md-8">
                            <select id="remark" class="swal2-input">
                                <option value="FINISHED CONTRACT">FINISHED CONTRACT</option>
                                <option value="DISMISSAL">DISMISSAL</option>
                                <option value="OWN WILL">OWN WILL</option>
                                <option value="MEDICAL REPAT">MEDICAL REPAT</option>
                                <option value="VESSEL SOLD">VESSEL SOLD</option>
                            </select>
                        </div>
                    </div>

                    <br>
                    ${input('arrival_date', 'Arrival Date (optional)', null, 4, 8)},
                `,
                onOpen: () => {
                    $('[name="disembarkation_date"], [name="arrival_date"]').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                    })

                    $('#remark').select2({tags: true});
                }
            }).then(result => {
                if(result.value){
                    let data = {
                        joining_date: $('[name="joining_date"]').val(),
                        disembarkation_date: $('[name="disembarkation_date"]').val(),
                        arrival_date: $('[name="arrival_date"]').val(),
                        remarks: $('#remark').val(),
                        status: "On Board"
                    }

                    window.location.href = `{{ route('applications.exportDocument') }}/${id}/${type}?` + $.param({data});
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

        function CCC(id, type){
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
                        swal({
                            title: 'Joining Details: ',
                            html: `
                                <input type="text" id="joining_date" placeholder="Joining Date (optional)" class="form-control">
                                <br>
                                <input type="text" id="joining_port" placeholder="Joining Port (optional)" class="form-control">
                            `,
                            showCancelButton: true,
                            cancelButtonColor: '#f76c6b',
                            onOpen: () => {
                                let string = "";

                                $('#joining_date').flatpickr({
                                    altInput: true,
                                    altFormat: 'F j, Y',
                                    dateFormat: 'Y-m-d',
                                })
                            }
                        }).then(result => {
                            if(result.value){
                                let data = {
                                    status: 'Lined-Up',
                                    joining_date: $('#joining_date').val(),
                                    joining_port: $('#joining_port').val()
                                }

                                window.location.href = `{{ route('applications.exportDocument') }}/${id}/${type}?` + $.param({data});
                            }
                        });
                    }
                    else{
                        window.location.href = `{{ route('applications.exportDocument') }}/${id}/${type}`;
                    }
                }
            });
        }

        function EDC(id, fleet, type){
            let data = {
                type: "template",
                status: "Lined-Up",
                fleet: fleet
            }

            window.location.href = `{{ route('applications.exportDocument') }}/${id}/${type}?` + $.param({data});
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
                            <input type="text" id="med_date" placeholder="(Optional)"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 style="text-align: right;">Port</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="port" class="form-control" placeholder="(Optional)"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 style="text-align: right;">Months of employment</h4>
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
                    $('#med_date').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                    });

                    $('#date_processed').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                        defaultDate: moment().format('YYYY-MM-DD')
                    });

                    $.ajax({
                        url: '{{ route('applications.getAllInfo') }}',
                        data: {
                            id: id
                        },
                        success: result => {
                            result = JSON.parse(result);
                            let date = moment().format('YYYY-MM-DD');

                            if(result.lup){
                                date = moment(result.lup.joining_date);
                                months = result.lup.months;

                                if(result.lup.extensions){
                                    let extensions = JSON.parse(result.lup.extensions);
                                    date = date.add(result.lup.months, 'months');

                                    for(i = 0, j = 1; i < extensions.length; i++, j++){
                                        months = extensions[i];
                                        if(j < extensions.length){
                                            date = date.add(months, 'months');
                                        }
                                    }
                                }
                                
                                date = date.format("YYYY-MM-DD");
                                $('#employment_months').val(months);
                            }
                            else if(result.pro_app.status == "Lined-Up"){
                                $('#employment_months').val(result.pro_app.mob);
                            }
                            else{
                                date = result.pro_app.eld;
                            }

                            $('#effective_date').flatpickr({
                                altInput: true,
                                altFormat: 'F j, Y',
                                dateFormat: 'Y-m-d',
                                defaultDate: date
                            });
                        }
                    })

                    setTimeout(() => {
                        $('.col-md-7 .swal2-input').css('margin', '0px');
                        $('.swal2-content .clabel').css('margin-top', '8px');
                    },800);
                },
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        setTimeout(() => {
                            let a = $('#date_processed').val();
                            let b = $('#effective_date').val();
                            let d = $('#employment_months').val();

                            if(a == "" || b == "" || d == ""){
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
                    data.port               = $('#port').val();

                    if(id == 2692){
                        swal({
                            title: 'Select Format',
                            input: 'select',
                            inputOptions: {
                                'NONITF': 'NON-ITF',
                                'ITF': 'ITF'
                            }
                        }).then(result2 => {
                            if(result2.value){
                                data.itf = result2.value;
                                generateMLC(id, type, data);
                            }
                        });
                    }
                    else{
                        generateMLC(id, type, data);
                    }
                }
            });
        }

        function generateMLC(id, type, data){
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
                        data.fleet = result.value;
                        window.location.href = `{{ route('applications.exportDocument') }}/${id}/${type}?` + $.param(data);
                    }
                });
            @else
                data.fleet = '{{ auth()->user()->fleet }}';
                window.location.href = `{{ route('applications.exportDocument') }}/${id}/${type}?` + $.param(data);
            @endif
        }

        function getDispatchChecklistData(id, type){
            let data = {};
            swal({
                title: 'Fill all details',
                html: `

                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel">Tentative Joining Date</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="eld" class="swal2-input" placeholder="(Optional)"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 style="text-align: right;">Port</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="port" class="form-control" placeholder="(Optional)"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 style="text-align: right;">Months of employment</h4>
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
                    $.ajax({
                        url: '{{ route('applications.getAllInfo') }}',
                        data: {
                            id: id
                        },
                        success: result => {
                            result = JSON.parse(result);
                            let date = moment().format('YYYY-MM-DD');

                            if(result.lup){
                                date = moment(result.lup.joining_date);
                                months = result.lup.months;

                                if(result.lup.extensions){
                                    let extensions = JSON.parse(result.lup.extensions);
                                    date = date.add(result.lup.months, 'months');

                                    for(i = 0, j = 1; i < extensions.length; i++, j++){
                                        months = extensions[i];
                                        if(j < extensions.length){
                                            date = date.add(months, 'months');
                                        }
                                    }
                                }
                                
                                date = date.format("YYYY-MM-DD");
                                $('#employment_months').val(months);
                            }
                            else if(result.pro_app.status == "Lined-Up"){
                                $('#employment_months').val(result.pro_app.mob);
                            }
                            else{
                                date = result.pro_app.eld;
                            }

                            $('#eld').flatpickr({
                                altInput: true,
                                altFormat: 'F j, Y',
                                dateFormat: 'Y-m-d',
                                defaultDate: date
                            });
                        }
                    })
                },
            }).then(result => {
                if(result.value){
                    data.eld                = $('#eld').val();
                    data.employment_months  = $('#employment_months').val();
                    data.port               = $('#port').val();

                    window.location.href = `{{ route('applications.exportDocument') }}/${id}/${type}?` + $.param(data);
                }
            });
        }

        function X41_BatchDispatchChecklist(id, name){
            let data = {};
            swal({
                title: 'Fill all details',
                html: `

                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel">Tentative Joining Date</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="eld" class="swal2-input" placeholder="(Optional)"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 style="text-align: right;">Port</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="port" class="form-control" placeholder="(Optional)"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 style="text-align: right;">Months of employment</h4>
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
                    $('#eld').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d'
                    });
                },
            }).then(result => {
                if(result.value){
                    data.vid                = id;
                    data.eld                = $('#eld').val();
                    data.employment_months  = $('#employment_months').val();
                    data.port               = $('#port').val();
                    data.filename           = name.replace('/', '') + " Dispatch Checklist";

                    window.location.href = `{{ route('applications.exportDocument') }}/1/X41_BatchDispatchChecklist?` + $.param(data);
                }
            });
        }

        function getFinalBriefingData(id, type){
            let data = {};
            swal({
                title: 'Enter details',
                html: `

                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel">Joining Date</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="eld" class="swal2-input" placeholder="(Optional)"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 style="text-align: right;">Port</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="port" class="form-control" placeholder="(Optional)"/>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                width: '40%',
                onOpen: () => {
                    $.ajax({
                        url: '{{ route('applications.getAllInfo') }}',
                        data: {
                            id: id
                        },
                        success: result => {
                            result = JSON.parse(result);
                            let date = moment().format('YYYY-MM-DD');

                            if(result.lup){
                                date = moment(result.lup.joining_date);
                                date = date.format("YYYY-MM-DD");
                            }
                            else{
                                date = result.pro_app.eld;
                            }

                            $('#eld').flatpickr({
                                altInput: true,
                                altFormat: 'F j, Y',
                                dateFormat: 'Y-m-d',
                                defaultDate: date
                            });
                        }
                    })
                },
            }).then(result => {
                if(result.value){
                    data.eld                = $('#eld').val();
                    data.port               = $('#port').val();

                    window.location.href = `{{ route('applications.exportDocument') }}/${id}/${type}?` + $.param(data);
                }
            });
        }

        function getPOEAData(id, type){
            let data = {};
            swal({
                title: 'Fill all details',
                html: `
                    <br>
                    <div class="row">
                        <div class="col-md-5">
                            <h4 style="text-align: right;">Months of employment</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="number" id="employment_months" class="form-control" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5" style="margin-top: 10px;">
                            <h4 style="text-align: right;">Select Format</h4>
                        </div>
                        <div class="col-md-7">
                            <select id="format" class="swal2-input">
                                <option value="">Select Format</option>
                                <option value="x22_POEAFormatContract">POEA</option>
                                <option value="x23_TOEIFormatContract">TOEI</option>
                                <option value="x27_NITTATOEIFormatContract">NITTA/TOEI</option>
                                <option value="x24_CADETFormatContract">CADET</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 style="text-align: right;">Point of Hire</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="pointOfHire" value="MANILA, PHILIPPINES" class="form-control" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 style="text-align: right;">With Stamp</h4>
                        </div>
                        <div class="col-md-7" style="text-align: left; margin-top: 10px;">
                            <input type="checkbox" id="stamp" checked>
                        </div>
                    </div>

                    <hr>

                    <h2 class="swal2-title">Extension Details</h2>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 style="text-align: right;">Months</h4>
                        </div>
                        <div class="col-md-5">
                            <input type="number" id="ext_months" class="form-control" />
                        </div>
                        <div class="col-md-1">
                            ${checkbox("plus", "+")}
                        </div>
                        <div class="col-md-1">
                            ${checkbox("minus", "-")}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5" style="margin-top: 10px;">
                            <h4 style="text-align: right;">Select One</h4>
                        </div>
                        <div class="col-md-7">
                            <select id="suffix" class="swal2-select">
                                <option value="">-</option>
                                <option value="PROMOTION ON BOARD">PROMOTION ON BOARD</option>
                                <option value="WITH MUTUAL CONSENT OF BOTH PARTIES">WITH MUTUAL CONSENT OF BOTH PARTIES</option>
                            </select>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                width: '500px',
                onOpen: () => {
                    $.ajax({
                        url: '{{ route('applications.getAllInfo') }}',
                        data: {
                            id: id
                        },
                        success: result => {
                            result = JSON.parse(result);
                            let date = moment().format('YYYY-MM-DD');

                            if(result.lup){
                                date = moment(result.lup.joining_date);
                                months = result.lup.months;

                                if(result.lup.extensions){
                                    let extensions = JSON.parse(result.lup.extensions);
                                    date = date.add(result.lup.months, 'months');

                                    for(i = 0, j = 1; i < extensions.length; i++, j++){
                                        months = extensions[i];
                                        if(j < extensions.length){
                                            date = date.add(months, 'months');
                                        }
                                    }
                                }
                                
                                date = date.format("YYYY-MM-DD");
                                $('#employment_months').val(months);
                            }
                            else if(result.pro_app.status == "Lined-Up"){
                                $('#employment_months').val(result.pro_app.mob);
                            }
                            else{
                                date = result.pro_app.eld;
                            }
                        }
                    })
                },
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        setTimeout(() => {
                            let a = $('#employment_months').val();
                            let b = $('#format').val();

                            if(a == "" || b == ""){
                                swal.showValidationError('Please fill all fields');
                            }
                        resolve()}, 800);
                    });
                },
            }).then(result => {
                if(result.value){
                    let data = {};
                        data.id = id;
                        data.folder = "POEA\\";
                        data.employment_months  = $('#employment_months').val();
                        data.pointOfHire  = $('#pointOfHire').val();
                        data.stamp = $('#stamp').is(":checked") ? true : false;
                        data.format = $('#format').val();
                        data.plus = $('[name="plus"]').is(':checked');
                        data.minus = $('[name="minus"]').is(':checked');
                        data.ext_months = $('#ext_months').val();
                        data.suffix = $('#suffix').val();

                    window.location.href = `{{ route('applications.exportDocument') }}/${id}/POEA_Contract?` + $.param(data);
                }
            });
        }

        function createModal(vessel, id){
            $('body').append(`
                <div class="modal fade" id="linedUp">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header head1">
                                
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>

                                <h4 class="modal-title">
                                    <b><span style="color: #ca0032;">${vessel.name}</span> - Crew Details</b>
                                    <span class="hidden" id="vessel_flag">${vessel.flag}</span>
                                </h4>
                            </div>

                            <div class="modal-body">
                                @if(auth()->user()->role == "Admin" || auth()->user()->fleet == "FLEET C")
                                    <a class="btn btn-info" onclick="proposeCrew('${vessel.name}', ${id})">
                                        <span class="fa fa-download"> Propose Crew</span>
                                    </a>
                                @endif

                                <ul class="nav nav-pills" role="tablist" style="margin-top: 5px;">
                                    <li role="presentation" class="active">
                                        <a href=".linedUp" role="tab" data-toggle="pill">Lined Up</a>
                                    </li>
                                    <li role="presentation">
                                        <a href=".onBoard" role="tab" data-toggle="pill">On Board</a>
                                    </li>
                                    <li role="presentation">
                                        <a href=".summary" role="tab" data-toggle="pill">Summary</a>
                                    </li>
                                    <li role="presentation">
                                        <a href=".documents" role="tab" data-toggle="pill">Documents Monitoring</a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in linedUp active"></div>
                                    <div role="tabpanel" class="tab-pane fade onBoard"></div>
                                    <div role="tabpanel" class="tab-pane fade summary"></div>
                                    <div role="tabpanel" class="tab-pane fade documents"></div>
                                </div>
                            </div>

                            <div class="modal-footer" style="background-color: transparent;">
                                <button type="button" class="btn btn-success" onClick="batchExport(${id}, '${vessel.name}')">Batch Export</button>
                                <button type="button" class="btn btn-primary" onClick="omc(${id})">On Board Multiple Crew</button>
                                <button type="button" class="btn btn-warning" onClick="dmc(${id})">Disembark Multiple Crew</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>

                </div>`
            );

            $('#linedUp').on('shown.bs.modal', function() {
                $(document).off('focusin.modal');
            });
        }

        function batchExport(id, data){
            swal({
                title: 'Select Type',
                input: 'select',
                inputOptions: {
                    X38_BatchCrewCompetencyChecklist:   'Crew Competency Checklist',
                    X32_CrewUniform:                    'Crew Uniform Order Slip',
                    X37_LinedUpFinalBriefing:           'Final Briefing',
                    X40_BatchDocumentChecklist:         'Final Document Checklist (Onboard Crew)',
                    X41_BatchDispatchChecklist:         'Line-up/Dispatch Checklist',
                    X25_MLCLinedUp:                     'Lined-Up Crew MLC',
                    X26_POEALinedUp:                    'Lined-Up Crew POEA Contract',
                    exportOffCovid :                    'Offsigners Covid Vaccines',
                    exportOffDocs :                     'Offsigners SIRB and PPRT',
                    exportOffUSV :                      'Offsigners US Visa',
                    exportOnOff :                       'On/Off Signers',
                    exportOnBoard :                     'Onboard Crewlist',
                    X16_MLCOnboard:                     'Onboard Crew MLC',
                    X27_POEAOnBoard:                    'Onboard Crew POEA Contract',
                    exportOnCovid :                     'Onsigners Covid Vaccines',
                    exportOnDocs :                      'Onsigners SIRB and PPRT',
                    exportOnUSV :                       'Onsigners US Visa',
                    RTP :                               'Request to Process (Lined-Up Crew)',
                    RTP2 :                              'Request to Process (Onboard Crew)',
                    RFSC:                               'Shoe and Coverall Request',
                },
                cancelButtonColor: '#f76c6b',
                width: '300px',
                onOpen: () => {
                    $('.swal2-select').select2();
                    $('.swal2-select').on("select2:open", () => {
                        $('.select2-dropdown').css({
                            'z-index': 9999
                        });
                    });
                    $('.swal2-select').parent().css('text-align', 'center');
                    $('.select2-container').css('width', '100%');
                }
            }).then(result => {
                if(result.value){
                    window[result.value](id, data);
                }
            })
        }

        function RPPE(id){
            RFSC(id, 'X03_RPPE');
        }

        function RFSC(id, type = null){
            let crews = [];

            let temp = $('.LUN');
            let crewString = "";

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

            swal({
                confirmButtonText: 'Submit',
                cancelButtonColor: '#f76c6b',
                allowOutsideClick: false,
                showCancelButton: true,
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
            }).then(result => {
                if(result.value){
                    if(crews.length){
                        // if(type == null){
                            name = type.replace('/', '') + " - Request for Shoe and Coverall";
                            type = 'X02_RFSC';
                        // }

                        window.location.href = `{{ route('applications.exportDocument') }}/1/${type}?` + $.param({
                            data2: crews,
                            filename: name
                        });
                    }
                }
            })
        }

        function omc(vid){
            let crews = [];

            let temp = $('.LUN');
            let crewString = "";

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
                    title: 'Fill Details',
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
                                <input type="number" min="1" value="0" id="months" class="form-control" />
                            </div>
                        </div>
                        <br>
                    `,
                    width: '450px',
                    onOpen: () => {
                        $('#swal2-title').css({
                            'font-size': '28px',
                            'color': '#00c0ef'
                        });

                        $('#date').flatpickr({
                            altInput: true,
                            altFormat: 'F j, Y',
                            dateFormat: 'Y-m-d',
                        })
                    },
                    preConfirm: () => {
                        swal.showLoading();
                        return new Promise(resolve => {
                            setTimeout(() => {
                                let b = $('#date').val();
                                let c = $('#months').val();

                                if(b == ""){
                                    swal.showValidationError('Date is required');
                                }
                            resolve()}, 500);
                        });
                    }
                },
            ]).then(result => {
                if(result.value){
                    let port = $('#port').val();
                    let date = $('#date').val();
                    let months = $('#months').val();
                    let ctr = 0;

                    crews.forEach(id => {
                        $.ajax({
                            type: 'POST',
                            url: `{{ route('applications.updateStatus') }}/${id}/On Board/${vid}`,
                            data: {
                                id: id,
                                port: port,
                                date: date,
                                months: months
                            },
                            success: vessel => {
                                ctr++;

                                if(ctr == crews.length){
                                    swal({
                                        type: 'success',
                                        title: 'Successfully Boarded ' + crews.length + ' Crew',
                                        showConfirmButton: false,
                                        timer: 800
                                    }).then(() => {
                                        getVesselCrew(vessel, true);
                                        $('[href=".onBoard"]').click();
                                    });
                                }
                            }
                        });
                    });
                }
            })
        }

        function dmc(vid){
            let crews = [];

            let temp = $('.OBC');
            let crewString = "";

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
                    title: 'Fill Details',
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
                                    <option value="Vacation">FINISHED CONTRACT</option>
                                    <option value="DISMISSAL">DISMISSAL</option>
                                    <option value="OWN WILL">OWN WILL</option>
                                    <option value="MEDICAL REPAT">MEDICAL REPAT</option>
                                    <option value="VESSEL SOLD">VESSEL SOLD</option>
                                </select>
                            </div>
                        </div>
                    `,
                    width: '450px',
                    onOpen: () => {
                        $('#swal2-title').css({
                            'font-size': '28px',
                            'color': '#00c0ef'
                        });

                        $('#date').flatpickr({
                            altInput: true,
                            altFormat: 'F j, Y',
                            dateFormat: 'Y-m-d',
                        });

                        $('#remark').select2({
                            placeholder: 'Select Remark',
                            tags: true
                        });

                        $('#remark').on('select2:open', () => {
                            $('.select2 .select2-container').css('z-index', 1060);
                        });
                    },
                    preConfirm: () => {
                        swal.showLoading();
                        return new Promise(resolve => {
                            setTimeout(() => {
                                let b = $('#date').val();
                                let c = $('#remark').val();

                                if(b == "" && c == ""){
                                    swal.showValidationError('Date and Remarks is required');
                                }
                            resolve()}, 500);
                        });
                    }
                },
            ]).then(result => {
                if(result.value){
                    let port = $('#port').val();
                    let date = $('#date').val();
                    let remark = $('#remark').val();
                    let ctr = 0;

                    crews.forEach(id => {
                        $.ajax({
                            type: 'POST',
                            url: `{{ route('applications.updateStatus') }}/${id}/${$('#remark').val()}/${vid}`,
                            data: {
                                id: id,
                                disembarkation_port: port,
                                disembarkation_date: date,
                                remark: $('#remark').val()
                            },
                            success: vessel => {
                                ctr++;

                                if(ctr == crews.length){
                                    swal({
                                        type: 'success',
                                        title: 'Successfully Disembarked ' + crews.length + ' Crew',
                                        showConfirmButton: false,
                                        timer: 800
                                    }).then(() => {
                                        console.log(vessel);
                                        getVesselCrew(vessel, true);
                                        $('[href=".onBoard"]').click();
                                    });
                                }
                            }
                        });
                    });

                }
            })
        }

        function exportOnOff(id, vname){
            swal({
                title: 'Choose Format',
                input: 'select',
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                inputOptions: {
                    ShinkoOnOff: 'Default',
                    HmmOnOff: 'HMM',
                    HmmSingapore: 'HMM (Singapore)',
                    KlcsmOnOff: 'KLCSM',
                    KlcsmBulkOnOff: 'KLCSM BULK',
                    KoscoOnOff: 'KOSCO',
                    KssOnOff: 'KSS',
                    WesternOnOff: 'Nitta/TOEI',
                    ToeiOnOff: 'TOEI',
                },
            }).then(result => {
                let data = {};
                if(result.value){
                    if(result.value == "ToeiOnOff"){
                        swal({
                            title: 'Enter Details',
                            showCancelButton: true,
                            cancelButtonColor: '#f76c6b',
                            html: `
                                <input type="text" id="to" class="form-control" placeholder="To"><br>
                                <input type="text" id="port" class="form-control" placeholder="Port"><br>
                            `
                        }).then(result2 => {
                            if(result2.value){
                                data.to = $('#to').val();
                                data.port = $('#port').val();
                                data.vname = vname;
                            }
                            window.location.href = `{{ route('applications.exportOnOff') }}/${id}/${result.value}?` + $.param({data: data});
                        });
                    }
                    else if(["KoscoOnOff", "KssOnOff"].includes(result.value)){
                        swal({
                            title: 'Enter Details',
                            showCancelButton: true,
                            cancelButtonColor: '#f76c6b',
                            html: `
                                <input type="date" id="date" class="form-control" placeholder="Date of Replacement"><br>
                                <input type="text" id="port" class="form-control" placeholder="Port"><br>
                            `
                        }).then(result2 => {
                            if(result2.value){
                                data.date = $('#date').val();
                                data.port = $('#port').val();
                                data.vname = vname;
                            }
                            window.location.href = `{{ route('applications.exportOnOff') }}/${id}/${result.value}?` + $.param({data: data});
                        });
                    }
                    else{
                        window.location.href = `{{ route('applications.exportOnOff') }}/${id}/${result.value}`;
                    }
                }
            })
        }

        function exportOnBoard(id, name){
            let data = {};
            data.id = id;
            data.filename = name.substring(4) + " - Onboard";
            data.fleet = "{{ auth()->user()->fleet }}";

            @if(auth()->user()->fleet == null)
                swal({
                    title: "Select Format",
                    input: 'select',
                    inputOptions: {
                        '': 'Default',
                        TOEI: 'TOEI'
                    },
                }).then(result => {
                    if(!result.dismiss){
                        data.fleet = result.value;
                        window.location.href = `{{ route('applications.exportDocument') }}/1/OnBoardVessel?` + $.param(data);
                    }
                })
            @else
                window.location.href = `{{ route('applications.exportDocument') }}/1/OnBoardVessel?` + $.param(data);
            @endif
        }

        function exportOnDocs(id, name){
            let crews = [];

            let temp = $('.LUN');
            let crewString = "";

            temp.each((index, value) => {
                let temp2 = $(value);

                crewString += `  
                    <div class="row">
                        <div class="col-md-2">
                            <input type="checkbox" class="crew-checklist" data-id="${temp2.data('id')}" checked />
                        </div>
                        <div class="col-md-10">
                            <label for="">
                                ${temp2[0].innerText}
                            </label>
                        </div>
                    </div>
                `;
            });

            swal({
                cancelButtonColor: '#f76c6b',
                allowOutsideClick: false,
                showCancelButton: true,
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
            }).then(result => {
                if(result.value){
                    let data = {};
                    data.ids = crews;
                    data.filename = name.replace(/[^\w\s]/gi, '') + " - Onsigners PPRT AND SIRB";
                    data.exportType = "pdf";

                    const type = "Y01_OnsignerDocs";

                    window.location.href = `{{ route('applications.exportDocument') }}/1/${type}?` + $.param(data);
                }
            })

        }

        function exportOnUSV(id, name){
            let data = {};
            data.id = id;
            data.filename = name.replace(/[^\w\s]/gi, '') + " - Onsigners US Visa";
            data.exportType = "pdf";

            const type = "Y08_OnsignerUSV";

            window.location.href = `{{ route('applications.exportDocument') }}/1/${type}?` + $.param(data);
        }

        function exportOnCovid(id, name){
            let data = {};
            data.id = id;
            data.filename = name.replace(/[^\w\s]/gi, '') + " - Onsigners Covid Vaccinations";
            data.exportType = "pdf";

            const type = "Y10_OnsignerCovid";

            window.location.href = `{{ route('applications.exportDocument') }}/1/${type}?` + $.param(data);
        }

        function exportOffDocs(id, name){
            let crews = [];

            let temp = $('.OBC');
            let crewString = "";

            temp.each((index, value) => {
                let temp2 = $(value);
                let checked = "";

                if(temp2.parent().find(`#table-selectR-${temp2.data('id')}`).val() != ""){
                    checked = "checked";
                }

                crewString += `  
                    <div class="row">
                        <div class="col-md-2">
                            <input type="checkbox" class="crew-checklist" data-id="${temp2.data('id')}" ${checked} />
                        </div>
                        <div class="col-md-10">
                            <label for="">
                                ${temp2[0].innerText}
                            </label>
                        </div>
                    </div>
                `;
            });

            swal({
                title: 'Select Crew',
                html: '<br><br>' + crewString,
                width: '450px',
                cancelButtonColor: '#f76c6b',
                allowOutsideClick: false,
                showCancelButton: true,
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
            }).then(result => {
                if(result.value){
                    let data = {};
                    data.ids = crews;
                    data.filename = name.replace(/[^\w\s]/gi, '') + " - Offsigners PPRT AND SIRB";
                    data.exportType = "pdf";

                    const type = "Y02_OffsignerDocs";

                    window.location.href = `{{ route('applications.exportDocument') }}/1/${type}?` + $.param(data);
                }
            })

        }

        function exportOffUSV(id, name){
            let data = {};
            data.id = id;
            data.filename = name.replace(/[^\w\s]/gi, '') + " - Offsigners US Visa";
            data.exportType = "pdf";

            const type = "Y09_OffsignerUSV";

            window.location.href = `{{ route('applications.exportDocument') }}/1/${type}?` + $.param(data);
        }

        function exportOffCovid(id, name){
            let data = {};
            data.id = id;
            data.filename = name.replace(/[^\w\s]/gi, '') + " - Offsigners Covid Vaccinations";
            data.exportType = "pdf";

            const type = "Y11_OffsignerCovid";

            window.location.href = `{{ route('applications.exportDocument') }}/1/${type}?` + $.param(data);
        }

        function RTP(id){
            let crews = [];
            let docus = [];
            let flag = null;
            let visa = null;

            let temp = $('.LUN');
            let crewString = "";
            let docuString = "";

            let docuArray = [
                {name: 'USA VISA REFUND',},
                {name: 'VISA'},
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
                                ${value.name == "VISA" ? input("visa", "", $('#visa_flag').html(), 0,12) : ""}
                                ${value.name == "FLAG" ? input("flag", "", $('#vessel_flag').html(), 0,12) : ""}
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

                                flag = $('[name="flag"]').val();
                                visa = $('[name="visa"]').val();
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
                                <h4 class="clabel">Department</h4>
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
                        flag: flag,
                        visa: visa,
                        isApplicant: false
                    };

                    window.location.href = `{{ route('applications.exportDocument') }}/1/RequestToProcess?` + $.param(data);
                }
            })
        }

        function RTP2(id){
            let crews = [];
            let docus = [];

            let temp = $('.OBC');
            let crewString = "";
            let docuString = "";

            let docuArray = [
                {name: 'USA VISA REFUND',},
                {name: 'VISA'},
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
                                ${value.name == "VISA" ? input("visa", "", $('#visa_flag').html(), 0,12) : ""}
                                ${value.name == "FLAG" ? input("flag", "", $('#vessel_flag').html(), 0,12) : ""}
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

                                visa = $('[name="visa"]').val();
                                flag = $('[name="flag"]').val();
                            resolve()}, 500);
                        });
                    },
                },
                {
                    ...config,
                    title: 'Fill Details',
                    html: '<br><br>' + `
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="clabel">Department</h4>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="department" class="swal2-input" />
                            </div>
                        </div>
                    `,
                    width: '450px',
                    onOpen: () => {
                        $('#swal2-title').css({
                            'font-size': '28px',
                            'color': '#00c0ef'
                        });
                    },
                    preConfirm: () => {
                        swal.showLoading();
                        return new Promise(resolve => {
                            setTimeout(() => {
                                let a = $('#department').val();

                                if(a == ""){
                                    swal.showValidationError('All fields is required');
                                }
                            resolve()}, 500);
                        });
                    },
                },
            ]).then(result => {
                if(result.value){
                    let vname = $('.modal-title span')[0].innerText;

                    let data = {
                        crews: crews,
                        docus: docus,
                        department: $('#department').val(),
                        departure: "Onboard",
                        filename: vname.substring(vname.match("/") ? 4 : 3) + ' - Request To Process',
                        flag: flag,
                        visa: visa,
                        isApplicant: false
                    };

                    window.location.href = `{{ route('applications.exportDocument') }}/1/RequestToProcess?` + $.param(data);
                }
            })
        }

        function X38_BatchCrewCompetencyChecklist(vid, name){
            swal({
                title: 'Joining Details: ',
                html: `
                    <input type="text" id="joining_date" placeholder="Joining Date (optional)" class="form-control">
                    <br>
                    <input type="text" id="joining_port" placeholder="Joining Port (optional)" class="form-control">
                `,
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                onOpen: () => {
                    let string = "";

                    $('#joining_date').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                    })
                }
            }).then(result => {
                if(result.value){
                    let data = {
                        status: 'Lined-Up',
                        joining_date: $('#joining_date').val(),
                        joining_port: $('#joining_port').val(),
                        vid: vid,
                        filename: name.replace(/[^a-zA-Z0-9 ]/g, '') + " - Crew Competency Checklist"
                    }

                    window.location.href = `{{ route('applications.exportDocument') }}/1/X38_BatchCrewCompetencyChecklist?` + $.param(data);
                }
            });
        }

        function X16_MLCOnboard(vid, name){
            let data = {
                vid: vid,
                filename: name.replace(/[^a-zA-Z0-9 ]/g, '') + " - Onboard Crew MLC"
            };

            window.location.href = `{{ route('applications.exportDocument') }}/1/X16_MLCOnboard?` + $.param(data);
        }

        function X25_MLCLinedUp(vid, name){
            swal({
                title: "Enter Details",
                html: `
                    <div class="row">
                        <div class="col-md-3" style="text-align: left;">
                            <h5><strong>Joining Date</strong></h5>
                        </div>
                        <div class="col-md-9">
                            <input type="text" id="joining_date" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3" style="text-align: left;">
                            <h5><strong>Months</strong></h5>
                        </div>
                        <div class="col-md-9">
                            <input type="number" min="1" id="months" class="form-control">
                        </div>
                    </div>
                `,
                onOpen: () => {
                    $('#joining_date').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                    })
                },
                preConfirm: () => {
                    return new Promise(resolve => {
                        setTimeout(() => {
                            if($('#joining_date') == "" || $('#months') == ""){
                                swal.showValidationError('Please fill all fields');
                            }
                        resolve()}, 500);
                    });
                }
            }).then(result => {
                if(result.value){
                    let data = {
                        vid: vid,
                        joining_date: $('#joining_date').val(),
                        months: $('#months').val(),
                        filename: name.replace(/[^a-zA-Z0-9 ]/g, '') + " - Lined-Up Crew MLC"
                    };

                    window.location.href = `{{ route('applications.exportDocument') }}/1/X25_MLCLinedUp?` + $.param(data);
                }
            })
        }

        function X26_POEALinedUp(vid, name){
            let data = {};
            swal({
                title: 'Fill all details',
                html: `
                    <div class="row">
                        <div class="col-md-5">
                            <h4 style="text-align: right;">Months of employment</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="number" id="employment_months" class="form-control" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5" style="margin-top: 10px;">
                            <h4 style="text-align: right;">Select Format</h4>
                        </div>
                        <div class="col-md-7">
                            <select id="format" class="swal2-input">
                                <option value="">Select Format</option>
                                <option value="x22_POEAFormatContract">POEA</option>
                                <option value="x23_TOEIFormatContract">TOEI</option>
                                <option value="x27_NITTATOEIFormatContract">NITTA/TOEI</option>
                                <option value="x24_CADETFormatContract">CADET</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 style="text-align: right;">Point of Hire</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="pointOfHire" value="MANILA, PHILIPPINES" class="form-control" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 style="text-align: right;">With Stamp</h4>
                        </div>
                        <div class="col-md-7" style="text-align: left; margin-top: 10px;">
                            <input type="checkbox" id="stamp" checked>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                width: '500px',
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        setTimeout(() => {
                            let a = $('#employment_months').val();
                            let b = $('#format').val();

                            if(a == "" || b == ""){
                                swal.showValidationError('Please fill all fields');
                            }
                        resolve()}, 800);
                    });
                },
            }).then(result => {
                if(result.value){
                    let data = {};
                        data.vid = vid;
                        data.folder = "POEA\\";
                        data.employment_months  = $('#employment_months').val();
                        data.pointOfHire  = $('#pointOfHire').val();
                        data.stamp = $('#stamp').is(":checked") ? true : false;
                        data.format = $('#format').val();
                        data.filename = name.replace(/[^\w\s]/gi, '') + " Lined-Up Crew POEA Contracts " + moment().format("YYYY-MM-DD");

                    window.location.href = `{{ route('applications.exportDocument') }}/1/X26_POEALinedUp?` + $.param(data);
                }
            });
        }

        function extendContract(id, vid, disembarkation_date){
            swal({
                title: "Enter Details",
                html: `
                    <div style="text-align: left;">
                        <label>Effective Date</label>
                    </div>
                    <input type="text" id="ed" class="form-control"><br>

                    <div style="text-align: left;">
                        <label>Months</label>
                    </div>
                    <input type="number" min="1" id="months" class="form-control"><br>
                `,
                onOpen: () => {
                    $('#ed').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                        defaultDate: moment(disembarkation_date).add(1, 'day').format("YYYY-MM-DD")
                    });
                },
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        setTimeout(() => {
                            let months = $('#months').val();
                            let ed = $('#ed').val();

                            if(months == "" || ed == ""){
                                swal.showValidationError('All fiels required');
                            }
                        resolve()}, 500);
                    });
                }
            }).then(result => {
                if(result.value){
                    let months = $('#months').val();
                    let ed = $('#ed').val();

                    $.ajax({
                        url: '{{ route('applications.extendContract') }}',
                        data: {
                            id: id,
                            months: months,
                            ed: ed,
                            diff: moment(ed).diff(moment(disembarkation_date), 'days')
                        },
                        success: () => {
                            swal({
                                type: 'success',
                                title: 'Contract Successfully Updated',
                                showConfirmButton: false,
                                timer: 800
                            }).then(() => {
                                getVesselCrew(vid, true);
                                $('[href=".onBoard"]').click();
                            });

                        }
                    })
                }
            });
        }

        function X32_CrewUniform(id){
            let crews = [];

            let temp = $('.LUN');
            let crewString = "";

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

            swal({
                cancelButtonColor: '#f76c6b',
                allowOutsideClick: false,
                showCancelButton: true,
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
            }).then(result => {
                if(result.value){
                    let data = {
                        crews: crews,
                        filename: $('.modal-title span')[0].innerText.substring(4) + ' - Crew Uniform Order Slip',
                        isApplicant: false
                    };

                    window.location.href = `{{ route('applications.exportDocument') }}/1/X32_CrewUniform?` + $.param(data);
                }
            })
        }

        function X37_LinedUpFinalBriefing(id){
            swal({
                title: 'Enter details',
                html: `

                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel">Joining Date</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="eld" class="swal2-input" placeholder="(Optional)"/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 style="text-align: right;">Port</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="port" class="form-control" placeholder="(Optional)"/>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                width: '40%',
                onOpen: () => {
                    $.ajax({
                        url: '{{ route('applications.getAllInfo') }}',
                        data: {
                            id: $('.linedUp .LUN:first').data('id') // SEARCH ID OF A LINEDUP CREW
                        },
                        success: result => {
                            result = JSON.parse(result);
                            let date = moment().format('YYYY-MM-DD');

                            if(result.lup){
                                date = moment(result.lup.joining_date);
                                date = date.format("YYYY-MM-DD");
                            }
                            else{
                                date = result.pro_app.eld;
                            }

                            $('#eld').flatpickr({
                                altInput: true,
                                altFormat: 'F j, Y',
                                dateFormat: 'Y-m-d',
                                defaultDate: date
                            });
                        }
                    })
                },
            }).then(result => {
                if(result.value){
                    let data = {
                        vid: id,
                        eld: $('#eld').val(),
                        port: $('#port').val(),
                        filename: $('.modal-title span')[0].innerText.substring(4) + ' - Final Briefing Forms'
                    };

                    window.location.href = `{{ route('applications.exportDocument') }}/1/X37_LinedUpFinalBriefing?` + $.param(data);
                }
            });


        }

        function X40_BatchDocumentChecklist(id){
            let data = {
                vid: id
            };
            
            window.location.href = `{{ route('applications.exportDocument') }}/1/X40_BatchDocumentChecklist?` + $.param(data);
        }

        // MAIN EXPORTS
        function exportData(){
            swal({
                title: 'Select Type',
                input: 'select',
                inputOptions: {
                    principalsOnboardCrew : 'Principal\'s Onboard Crew',
                    x19_LineUpCrewPerVessel: 'Line-up Crew per Vessel'
                },
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                width: '300px',
                onOpen: () => {
                    $('.swal2-select').select2();
                    $('.swal2-select').on("select2:open", () => {
                        $('.select2-dropdown').css({
                            'z-index': 9999
                        });
                    });
                    $('.swal2-select').parent().css('text-align', 'center');
                    $('.select2-container').css('width', '100%');
                }
            }).then(result => {
                if(result.value){
                    window[result.value]();
                }
            })
        }

        function principalsOnboardCrew(){
            $.ajax({
                url: '{{ route('principal.get') }}',
                data: {
                    cols: ['id', 'name', 'active', 'fleet'],
                    where: ['active', 1]
                },
                success: principals => {
                    principals = JSON.parse(principals);
                    select = [];

                    principals.forEach(principal => {
                        $bool = true;

                        @if(auth()->user()->fleet)
                            if(principal.fleet != "{{ auth()->user()->fleet }}"){
                                $bool = false;
                            }
                        @endif

                        if($bool){
                            select[principal.id] = principal.name;
                        }
                    });

                    swal({
                        title: 'Select Principal',
                        input: 'select',
                        inputOptions: select,
                        showCancelButton: true,
                        cancelButtonColor: '#f76c6b'
                    }).then(result => {
                        if(result.value){
                            window.location.href = `{{ route('principal.getOnboardCrew') }}/${result.value}`;
                        }
                    });
                }
            });
        }

        function x19_LineUpCrewPerVessel(){
            $.ajax({
                url: '{{ route('vessels.get2') }}',
                data: {
                    cols: ['vessels.name', 'vessels.id'],
                    where: ['status', 'ACTIVE'],
                    @if(auth()->user()->fleet)
                        where2: ['fleet', '{{ auth()->user()->fleet }}']
                    @endif
                },
                success: result => {
                    vessels = JSON.parse(result);
                    
                    let vesselString = "";
                    vessels.forEach(vessel => {
                        vesselString += `
                            <input type="checkbox" value="${vessel.id}">
                            <label for="${vessel.id}">${vessel.name}</label><br>
                        `;
                    });

                    swal({
                        title: 'Select Vessel/s',
                        html: `
                            <div style="text-align: left;">
                                ${vesselString}
                            </div>
                        `,
                        showCancelButton: true,
                        cancelButtonColor: '#f76c6b',
                    }).then(result => {
                        if(result.value){
                            let temp = $('[type="checkbox"]:checked');
                            let vessels = [];

                            temp.each((id, vessel) => {
                                vessels.push(vessel.value)
                            });
                            
                            let data = {};
                                data.id = vessels;
                                data.filename = "Lined-up Crew";

                            window.location.href = `{{ route('applications.exportDocument') }}/1/x19_LineUpCrewPerVessel?` + $.param(data);
                        }
                    });
                }
            })
        }

        function exportCrewChangePlan(){
            $.ajax({
                url: '{{ route('principal.get') }}',
                data: {
                    cols: "*",
                    where: ['active', 1]
                },
                success: result => {
                    result = JSON.parse(result);
                    let options = [];

                    result.forEach(principal => {
                        options[principal.id] = principal.name;
                    });

                    swal({
                        input: 'select',
                        inputOptions: options,
                        inputPlaceholder: "Select Principal"
                    }).then(result => {
                        if(result.value){
                            let data = {};
                                data.id = result.value;
                                data.folder = "CrewChange\\";
                                data.filename = "Crew Change Plan";

                            window.location.href = `{{ route('applications.exportDocument') }}/1/x21_CrewChangePlan?` + $.param(data);
                        }
                    })
                }
            })
        }

        function exportDocs(){
            swal({
                title: 'Select Type',
                input: 'select',
                inputOptions: {
                    exportVessels : 'Vessels',
                    exportCrewChangePlan: 'Crew Change Plan',
                    X31_OnOffReport : 'On/Off Report',
                },
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                width: '300px',
                onOpen: () => {
                    $('.swal2-select').select2();
                    $('.swal2-select').on("select2:open", () => {
                        $('.select2-dropdown').css({
                            'z-index': 9999
                        });
                    });
                    $('.swal2-select').parent().css('text-align', 'center');
                    $('.select2-container').css('width', '100%');
                }
            }).then(result => {
                if(result.value){
                    window[result.value]();
                }
            })
        }

        function exportVessels(){
            window.location.href = "{{ route('vessels.export') }}";
            // window.location.href = "{{ route('vessels.export') }}/" + result.value;
            // swal({
            //     title: 'Please select',
            //     input: 'select',
            //     inputOptions: {
            //         '': 'All',
            //         ACTIVE: 'Active',
            //         INACTIVE: 'Inactive'
            //     },
            // }).then(result => {
            //     if(!result.dismiss){
            //     }
            // })
        }

        function X31_OnOffReport(){
            $.ajax({
                url: '{{ route('vessels.get2') }}',
                data: {
                    cols: "*",
                    where: ["fleet", "{{ auth()->user()->fleet ?? "%%" }}"],
                },
                success: result => {
                    result = JSON.parse(result);

                    let vessels = [];
                    let vesselString = "";

                    result.forEach(vessel => {
                        vesselString += `
                            <div class="col-md-4 col-lg-3 col-sm-6 iInput" style="text-align: left;">
                                ${checkbox("vessels", vessel.name, `checked data-status="${vessel.status}" data-id="${vessel.id}"`)}
                            </div>
                        `;
                    });

                    swal({
                        title: "Select Vessels",
                        html: `
                            <div class="row">
                                <div class="col-md-2">
                                    <select id="vFilter" class="form-control">
                                        <option value="all">Select All</option>
                                        <option value="active">Select Active Only</option>
                                        <option value="inactive">Select Inactive Only</option>
                                        <option value="uall">Unselect All</option>
                                    </select>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                ${vesselString}
                            </div>
                        `,
                        width: '70%',
                        onOpen: () => {
                            $('#vFilter').on('change', e => {
                                $('[name="vessels"]').prop('checked', false);

                                if(e.target.value == "all"){
                                    $('[name="vessels"]').prop('checked', true);
                                }
                                else if(e.target.value == "active"){
                                    $('[name="vessels"][data-status="ACTIVE"]').prop('checked', true);
                                }
                                else if(e.target.value == "inactive"){
                                    $('[name="vessels"][data-status="INACTIVE"]').prop('checked', true);
                                }
                            })
                        }
                    }).then(result => {
                        if(result.value){
                            let vessels = [];

                            $('[name="vessels"]:checked').each((a, cb) => {
                                vessels.push(cb.dataset.id);
                            });

                            if(vessels){
                                X31_OnOffReport2(vessels);
                            }
                            else{
                                swal('No vessel selected');
                            }
                        }
                    });
                }
            });
        }

        function X31_OnOffReport2(vessels){
            swal({
                title: "Select Duration",
                html: `
                    ${input("from", "From", null, 2,10)}
                    ${input("to", "To", null, 2,10)}
                `,
                width: '400px',
                onOpen: () => {
                    $('[name="from"], [name="to"]').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                    });
                },
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        let bool = true;
                        if($('[name="from"]').val() == "" || $('[name="to"]').val() == ""){
                            swal.showValidationError('Select Date Range');
                        }
                        else{
                            let bool = false;
                            setTimeout(() => {resolve()}, 500);
                        }
                        bool ? setTimeout(() => {resolve()}, 500) : "";
                    });
                },
            }).then(result => {
                if(result.value){
                    let data = {};
                        data.from = $('[name="from"]').val();
                        data.to = $('[name="to"]').val();
                        data.vessels = vessels;
                        data.filename = `List of On Off Crew from ${toDate(moment(data.from))} - ${toDate(moment(data.to))}`;

                    window.location.href = `{{ route('applications.exportDocument') }}/1/X31_OnOffReport?` + $.param(data);
                }
            });
        }

        function proposeCrew(vessel, id){
            $('#linedUp').modal('toggle');
            swal.showLoading();

            let config = {
                confirmButtonText: 'Export',
                cancelButtonColor: '#f76c6b',
                allowOutsideClick: false,
                showCancelButton: true,
            }

            let rankString = [];
            $.ajax({
                url: '{{ route('rank.get') }}',
                data: {select: ['id', 'abbr']},
                success: result => {
                    result = JSON.parse(result);
                    result.forEach(rank => {
                        rankString += `
                            <option value="${rank.id}">${rank.abbr}</option>
                        `;
                    });
                }
            }).then(() => {
                $.ajax({
                    url: '{{ route('applications.get2') }}',
                    data: {
                        where: ['u.fleet', 'FLEET C'],
                        where2: ['applicants.status', 'Vacation'],
                        where3: ['u.deleted_at', null],
                        cols: ['applicants.*', 'u.status', 'u.fname', 'u.lname'],
                        load: ['pro_app.rank']
                    },
                    success: applicants => {
                        applicants = JSON.parse(applicants);

                        let crewString = "";
                        applicants.forEach(crew => {
                            let name = `${crew.lname}, ${crew.fname}`;
                            let rank = crew.pro_app.rank ? crew.pro_app.rank.abbr : "-";
                            let rId = crew.pro_app.rank ? crew.pro_app.rank.id : "-";

                            crewString += `
                                <option value="${crew.id}" data-name="${name}" data-rank="${rId}">${rank} ${name}</option>
                            `;
                        });
                        setTimeout(() => {
                            swal({
                                ...config,
                                title: 'Select all crew to be proposed',
                                width: '500px',
                                html: `
                                    <select id="crewList">
                                        <option value="">Search</option>
                                        ${crewString}
                                    </select>

                                    <br><br>
                                `,
                                onOpen: () => {
                                    $('#crewList').select2();
                                    $('#crewList').on('change', e => {
                                        let id = e.target.value;
                                        let name = $(e.target).find('option:selected').data('name');
                                        let rank = $(e.target).find('option:selected').data('rank');

                                        if(id){
                                            $('#crewList').select2('val', 0);

                                            $('#swal2-content').append(`
                                                <div class="row proposedCrew" id="pc${id}">
                                                    <input type="hidden" class="id" value="${id}">
                                                    <input type="hidden" class="rank" value="${rank}">

                                                    <div class="col-md-6 name" id="pcn${id}">
                                                        ${name}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select class="swal2-select rank" id="pcr${id}">
                                                            ${rankString}
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2" id="pcrd${id}">
                                                        <span class="fa fa-times pcrd" data-id="${id}"></span>
                                                    </div>
                                                </div>
                                            `);

                                            $(`#pcr${id}`).val(rank);

                                            $('.pcrd').off();
                                            $('.pcrd').on('click', e => {
                                                let id = e.target.dataset.id;

                                                $(`#pc${id}`).fadeOut();
                                                setTimeout(() => {
                                                    $(`#pc${id}`).remove();
                                                }, 1000);
                                            });
                                        }

                                    });

                                }
                            }).then(result => {
                                if(result.value){
                                    let crews = [];

                                    $('.proposedCrew').each((i, crew) => {
                                        crews.push([$(crew).find('.id').val(), $(crew).find('.rank').val()]);
                                    })

                                    let data = {};
                                        data.crews = crews;
                                        data.folder = "KLCSM\\";
                                        data.filename = "Crew Proposal Form";
                                        data.vessel = vessel;

                                    window.location.href = `{{ route('applications.exportDocument') }}/1/X33_CrewProposal?` + $.param(data);
                                }
                            })
                        }, 2000);
                    }
                })
            });
        }
    </script>

    @include('vessels.includes.showTables')
@endpush

{{-- <div class="row proposedCrew" id="pc0">
    <div class="col-md-2" id="ctr0">
        1
    </div>
    <div class="col-md-5 name" id="pcn0">
        Test Name 1
    </div>
    <div class="col-md-3">
        <select class="swal2-select rank" id="pcr0">
            ${rankString}
        </select>
    </div>
    <div class="col-md-2" id="pcrd0">
        <span class="fa fa-times pcrd" data-id="0"></span>
    </div>
</div> --}}