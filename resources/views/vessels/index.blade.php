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
                    targets: 6,
                    render: function(status){
                        let color = status == "ACTIVE" ? '#00a65a' : '#dd4b39';

                        return `
                            <span class="badge" style="background-color: ${color}">${status}</span>
                        `;
                    }
                },
                {
                    targets: 7,
                    width: '115px'
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

        function showVesselDetails(vessel, editable){
            let fields = "";

            let names = [
                "IMO",
                "Owner",
                "Size",
                "Vessel Name", 
                "Principal", 
                "Flag", 
                "Type", 
                "Manning Agent", 
                "Year Built", 
                "Builder", 
                "Engine", 
                "Gross Tonnage", 
                "BHP", 
                "Trade", 
                "ECDIS", 
            ];

            let columns = [
                'imo',
                'owner',
                'size',
                'name', 
                'principal.name', 
                'flag', 
                "type", 
                "manning_agent", 
                "year_build", 
                "builder", 
                "engine", 
                "gross_tonnage", 
                "BHP", 
                "trade", 
                "ecdis", 
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
                                <input type="text" id="vd-${key}" class="form-control" value="` + (vessel[key] ? vessel[key] : '') + `"${editable ? '' : ' readonly'}/>
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
                        $('#vd-size').select2({placeholder: 'Select Size'});
                        $('#vd-size').on("select2:open", () => {
                            $('.select2-dropdown').css({
                                'z-index': 9999
                            });
                        });
                        $('#select2-vd-size-container').css('text-align', 'left');
                    }
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
                                imo: $('#vd-imo').val(),
                                owner: $('#vd-owner').val(),
                                size: $('#vd-size').val(),
                                name: $('#vd-name').val(),
                                flag: $('#vd-flag').val(),
                                type: $('#vd-type').val(),
                                manning_agent: $('#vd-manning_agent').val(),
                                year_build: $('#vd-year_build').val(),
                                builder: $('#vd-builder').val(),
                                engine: $('#vd-engine').val(),
                                gross_tonnage: $('#vd-gross_tonnage').val(),
                                BHP: $('#vd-BHP').val(),
                                trade: $('#vd-trade').val(),
                                ecdis: $('#vd-ecdis').val()
                            },
                            success: () => {
                                swal({
                                    type: 'success',
                                    title: 'Vessel Details Successfully Updated',
                                    timer: 800,
                                    showConfirmButton: false
                                }).then(() => {
                                    $(`[data-original-title="View Vessel Details"] [data-id="${vessel.id}"]`).click();
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
                        cols: ['wages.*', 'r.name as rname'],
                        where: ['vessel_id', id],
                        order: ['r.id', 'asc']
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
                            <select id="rank_id" class="form-control">
                                <option value="">Select Rank</option>
                                ${rankString}
                            </select><br><br>

                            <input type="number" min="0" id="basic" class="form-control" placeholder="Basic Pay"><br>
                            <input type="number" min="0" id="leave_pay" class="form-control" placeholder="Leave Pay"><br>
                            <input type="number" min="0" id="fot" class="form-control" placeholder="F.O.T."><br>
                            <input type="number" min="0" id="ot" class="form-control" placeholder="G.O.T."><br>
                            <input type="number" min="0" id="sub_allow" class="form-control" placeholder="Sub. Allow."><br>
                            <input type="number" min="0" id="retire_allow" class="form-control" placeholder="Retire Allow."><br>
                            <input type="number" min="0" id="sup_allow" class="form-control" placeholder="Sup. Allow."><br>
                            <input type="number" min="0" id="engine_allow" class="form-control" placeholder="Engine Allow."><br>
                            <input type="number" min="0" id="other_allow" class="form-control" placeholder="Other Allow."><br>
                            <input type="number" min="0" id="voyage_allow" class="form-control" placeholder="Voyage Allow."><br>
                            <input type="number" min="0" id="owner_allow" class="form-control" placeholder="Owner Allow."><br>
                            <input type="number" min="0" id="tanker_allow" class="form-control" placeholder="Tanker Allow."><br>
                            <input type="number" min="0" id="aca" class="form-control" placeholder="ACA"><br>
                            <input type="number" min="0" id="total" class="form-control" placeholder="Total" readonly><br>
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
                        onOpen: () => {
                            $('#rank_id').select2();
                            $('#rank_id').on('select2:open', () => {
                                $('.swal2-container').css('z-index', 1000);
                            });

                            $('.swal2-container .form-control').on('input', () => {
                                let total = 0;
                                $('.swal2-container .form-control')
                                        .not(":first")
                                        .not(":last")
                                        .each((i, input) => {
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
                                    <select id="rank_id" class="form-control">
                                        <option value="">Select Rank</option>
                                        ${rankString}
                                    </select><br><br>

                                    <input type="number" min="0" value="${wage.basic}" id="basic" class="form-control" placeholder="Basic Pay"><br>
                                    <input type="number" min="0" value="${wage.leave_pay}" id="leave_pay" class="form-control" placeholder="Leave Pay"><br>
                                    <input type="number" min="0" value="${wage.fot}" id="fot" class="form-control" placeholder="F.O.T."><br>
                                    <input type="number" min="0" value="${wage.ot}" id="ot" class="form-control" placeholder="G.O.T."><br>
                                    <input type="number" min="0" value="${wage.sub_allow}" id="sub_allow" class="form-control" placeholder="Sub. Allow."><br>
                                    <input type="number" min="0" value="${wage.retire_allow}" id="retire_allow" class="form-control" placeholder="Retire Allow."><br>
                                    <input type="number" min="0" value="${wage.sup_allow}" id="sup_allow" class="form-control" placeholder="Sup. Allow."><br>
                                    <input type="number" min="0" value="${wage.engine_allow}" id="engine_allow" class="form-control" placeholder="Engine Allow."><br>
                                    <input type="number" min="0" value="${wage.other_allow}" id="other_allow" class="form-control" placeholder="Other Allow."><br>
                                    <input type="number" min="0" value="${wage.voyage_allow}" id="voyage_allow" class="form-control" placeholder="Voyage Allow."><br>
                                    <input type="number" min="0" value="${wage.owner_allow}" id="owner_allow" class="form-control" placeholder="Owner Allow."><br>
                                    <input type="number" min="0" value="${wage.tanker_allow}" id="tanker_allow" class="form-control" placeholder="Tanker Allow."><br>
                                    <input type="number" min="0" value="${wage.aca}" id="aca" class="form-control" placeholder="ACA"><br>
                                    <input type="number" min="0" value="${wage.total}" id="total" class="form-control" placeholder="Total" readonly><br>
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
                                onOpen: () => {
                                    $('#rank_id').select2();
                                    $('#rank_id').on('select2:open', () => {
                                        $('.swal2-container').css('z-index', 1000);
                                    });
                                    $('#rank_id').val(wage.rank_id).trigger('change');

                                    $('.swal2-container .form-control').on('input', () => {
                                        let total = 0;
                                        $('.swal2-container .form-control')
                                                .not(":first")
                                                .not(":last")
                                                .each((i, input) => {
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
                                <select id="principal_id" class="swal2-input">
                                    <option></option>
                                </select>
                                <input type="text" id="manning_agent" class="swal2-input" placeholder="Enter Manning Agent">
                                <input type="text" id="name" class="swal2-input" placeholder="Enter Vessel Name">
                                <input type="number" id="imo" class="swal2-input" placeholder="Enter IMO">
                                <input type="text" id="flag" class="swal2-input" placeholder="Enter Flag">
                                <input type="text" id="type" class="swal2-input" placeholder="Enter Type of Vessel">
                                <input type="text" id="year_build" class="swal2-input" placeholder="Enter Year Built">
                                <input type="text" id="builder" class="swal2-input" placeholder="Enter Builder">
                                <input type="text" id="engine" class="swal2-input" placeholder="Enter Engine">
                                <input type="number" id="gross_tonnage" class="swal2-input" placeholder="Enter GRT">
                                <input type="number" id="bhp" class="swal2-input" placeholder="Enter BHP">
                                <input type="text" id="trade" class="swal2-input" placeholder="Enter Trade Route">
                                <input type="text" id="ecdis" class="swal2-input" placeholder="Enter Trade ECDIS">
                            `,
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
                                let principal_id = $('#principal_id').val();
                                let manning_agent = $('#manning_agent').val();
                                let name = $('#name').val();
                                let imo = $('#imo').val();
                                let flag = $('#flag').val();
                                let type = $('#type').val();
                                let year_build = $('#year_build').val();
                                let builder = $('#builder').val();
                                let engine = $('#engine').val();
                                let gross_tonnage = $('#gross_tonnage').val();
                                let bhp = $('#bhp').val();
                                let trade = $('#trade').val();
                                let ecdis = $('#ecdis').val();

                                $.ajax({
                                    url: '{{ route('vessels.add') }}',
                                    data: {
                                        principal_id: principal_id,
                                        manning_agent: manning_agent,
                                        name: name,
                                        imo: imo,
                                        flag: flag,
                                        type: type,
                                        year_build: year_build,
                                        builder: builder,
                                        engine: engine,
                                        gross_tonnage: gross_tonnage,
                                        bhp: bhp,
                                        trade: trade,
                                        ecdis: ecdis
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
                    showTables(result[0], result[1], result[3]);
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

                        $('.actions').css('width', '150px');

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

                }
            });
        }

        function showTables(onBoard, linedUp, ranks){
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
                <b style="color: red;">Onsigners</b>
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
                            <a class="btn btn-danger" data-toggle="tooltip" title="Remove Lineup" onClick="rlu(${crew.applicant_id}, ${crew.vessel_id})">
                                <span class="fa fa-times"></span>
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
                        <td rowspan="2">${moment(crew.birthday).format('MMM DD, YYYY')}</td>

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

                <b style="color: red;">Offsigners</b>
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
            let onBoardReliever = [];
            let relieverRank = [];
            onBoard.forEach((crew, index) => {
                crew.remarks = JSON.parse(crew.remarks);
                let selected = "";
                let crewRankID = crew.rank_id;
                let crewRankCategory = ranks[crewRankID].category;

                if(crewRankCategory.startsWith("DECK")){
                    crewRankCategory = "DECK";
                }
                else if(crewRankCategory.startsWith("ENGINE")){
                    crewRankCategory = "ENGINE";
                }
                else{
                    crewRankCategory = "GALLEY";
                }

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
                    let curRankID = rengiSno.rank_id;
                    let curCategory = ranks[curRankID].category;

                    if(curCategory.startsWith("DECK")){
                        curCategory = "DECK";
                    }
                    else if(curCategory.startsWith("ENGINE")){
                        curCategory = "ENGINE";
                    }
                    else{
                        curCategory = "GALLEY";
                    }

                    if((crew.abbr == rengiSno.abbr && crew.applicant_id != rengiSno.applicant_id && rengiSno.status != "On Board") || (curRankID > crewRankID && crewRankCategory == curCategory && rengiSno.status != "Lined-Up")){
                        let name = `${rengiSno.lname + ', ' + rengiSno.fname + ' ' + (rengiSno.suffix || "") + ' ' + rengiSno.mname}`;

                        reliever += `
                            <option value="${rengiSno.applicant_id}"${rengiSno.applicant_id == crew.reliever ? ' selected' : ''}>${rengiSno.abbr} - ${name}</option>
                        `;

                        if(rengiSno.applicant_id == crew.reliever && curRankID != crewRankID){
                            onBoardReliever.push(rengiSno.applicant_id);
                            relieverRank[rengiSno.applicant_id] = crewRankID;
                        }
                    }
                });

                let onBoardButton = "";
                if(onBoardReliever.includes(crew.applicant_id)){
                    onBoardButton = `
                        &nbsp;&nbsp;<a class="btn btn-sm btn-success" data-toggle="tooltip" title="On Board Promotion" onClick="onBoardPromote(${crew.applicant_id}, ${crew.vessel_id}, ${relieverRank[crew.applicant_id]})">
                            <span class="fa fa-level-up fa-sm"></span>
                        </a>
                    `;
                }

                table2 += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${crew.abbr}</td>
                        <td>${crew.lname + ', ' + crew.fname + ' ' + (crew.suffix || "") + ' ' + crew.mname}</td>
                        <td>${crew.age}</td>
                        <td>${moment(crew.joining_date).format('DD-MMM-YY')}</td>
                        <td>${moment().diff(moment(crew.joining_date), 'months')}</td>
                        <td>${crew.months}</td>
                        <td>${moment(crew.joining_date).add(crew.months, 'months').format('DD-MMM-YY')}</td>
                        <td>${crew.PASSPORT ? moment(crew.PASSPORT).format('DD-MMM-YY') : '-----'}</td>
                        <td>${crew["SEAMAN'S BOOK"] ? moment(crew["SEAMAN'S BOOK"]).format('DD-MMM-YY') : '-----'}</td>
                        <td>${crew["US-VISA"] ? moment(crew["US-VISA"]).format('DD-MMM-YY') : '-----'}</td>
                        <td>${crew.joining_port ?? "---"}</td>
                        <td>${reliever}</td>
                        <td class="remarks">${crew.remarks}</td>
                        @if(auth()->user()->role != "Principal")
                        <td class="actions">
                            <a class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit On Board Details" onClick='eod(${crew.id}, ${crew.vessel_id}, "${crew.joining_date}", ${crew.months}, "${crew.joining_port ?? ""}")'>
                                <span class="fa fa-pencil fa-sm"></span>
                            </a>
                            <a class="btn btn-danger btn-sm" data-toggle="tooltip" title="Sign off" onClick="offBoard(${crew.applicant_id}, ${crew.vessel_id})">
                                <span class="fa fa-arrow-down fa-sm"></span>
                            </a>
                            ${onBoardButton}
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
                            <td rowspan="2">${moment(crew.birthday).format('MMM DD, YYYY')}</td>
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

                            if(b == "" || c == ""){
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
                            disembarkation_date: $('#date').val(),
                            type: 'Disembark',
                            remark: $('#remark').val()
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

        function onBoardPromote(applicant_id, vessel_id, rank_id){
            swal({
                title: "Enter Months of New Contract",
                input: 'number',
            }).then(result => {
                if(result.value && result.value != ""){
                    // DISEMBARK
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('applications.updateLineUpContract') }}",
                        data: {
                            id: applicant_id,
                            disembarkation_date: moment().format("YYYY-MM-DD"),
                            type: 'On Board Promotion',
                            remark: "On Board Promotion"
                        },
                        success: result2 => {
                            console.log('on board update lineup: ' + result.value);
                            // UPDATE STATUS
                            $.ajax({
                                type: 'POST',
                                url: `{{ route('applications.updateStatus') }}/${applicant_id}/${"On Board"}/${vessel_id}`,
                                data: {
                                    date: moment().format("YYYY-MM-DD"),
                                    months: result.value,
                                    rank: rank_id
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
                    'WalangLagay':          'Walang Lagay',
                    'MLCContract':          'MLC Contract',
                    'POEAContract':         'POEA Contract',
                    'RequestToProcess':     'Request To Process',
                    'DocumentChecklist':    'Document Checklist',
                    'X01_BorrowDocuments':  'Borrow Documents'
                    @if(auth()->user()->fleet == "FLEET B" || auth()->user()->role == "Admin")
                    @endif
                },
                inputPlaceholder: '',
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
            }).then(result => {
                if(result.value){
                    if(result.value == "MLCContract"){
                        getMLCData(id, result.value);
                    }
                    else if(result.value == "RequestToProcess"){
                        RTP(id);
                    }
                    else if(result.value == "X01_BorrowDocuments"){
                        FBBD(id, result.value);
                    }
                    else if(result.value == "DocumentChecklist"){
                        EDC(id, result.value);
                    }
                    else{
                        window.location.href = `{{ route('applications.exportDocument') }}/${id}/${result.value}`;
                    }
                }
            })
        }

        function EDC(id, type){
            let fleet = "{{ auth()->user()->fleet }}";
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
                    status: "Lined-Up",
                    fleet: fleet
                }

                if(result.value){
                    window.location.href = `{{ route('applications.exportDocument') }}/${id}/${type}?` + $.param({data});
                }
            });
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
                                <button type="button" class="btn btn-primary" onClick="omc(${id})">On Board Multiple Crew</button>
                                <button type="button" class="btn btn-success" onClick="batchExport(${id}, '${name}')">Batch Export</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>

                </div>`
            );
        }

        function batchExport(id, data){
            swal({
                title: 'Select Type',
                input: 'select',
                inputOptions: {
                    exportOnOff : 'Export On/Off Signers',
                    exportOnBoard : 'Export Onboard',
                    RTP : 'Request to Process',
                    RFSC: 'Shoe and Coverall Request',
                    RPPE: 'PPE Request'
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
                        if(type == null){
                            type = 'X02_RFSC';
                        }
                        window.location.href = `{{ route('applications.exportDocument') }}/${id}/${type}?` + $.param({
                            data2: crews,
                            // filename
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
                                <input type="number" min="1" id="months" class="form-control" />
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

                                if(b == "" || c == ""){
                                    swal.showValidationError('Date and Months is required');
                                }
                            resolve()}, 500);
                        });
                    },
                },
            ]).then(result => {
                if(result.value){
                    let port = $('#port').val();
                    let date = $('#date').val();
                    let months = $('#months').val();

                    crews.forEach(id => {
                        let ctr = 0;
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

        function exportOnOff(id){
            swal({
                title: 'Choose Format',
                input: 'select',
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                inputOptions: {
                    ShinkoOnOff: 'Shinko/All',
                    WesternOnOff: 'Nitta/TOEI'
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