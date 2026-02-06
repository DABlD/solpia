@extends('layouts.app')
@section('content')

<section class="content">

    <div class="row">
        <section class="col-lg-12">
            <div class="box box-info">

                <div class="box-header">
                    @include('requirements.includes.toolbar')
                </div>

                <div class="table-responsive">
                    <div class="box-body">
                        <table class="table table-hover table-bordered" id="table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Vessel</th>
                                    <th>Rank</th>
                                    <th style="width: 100px;">Join Date</th>
                                    <th>Port</th>
                                    <th>USV</th>
                                    <th>Salary</th>
                                    <th>Max Age</th>
                                    <th>Remarks</th>
                                    <th>Fleet</th>
                                    <th>Status</th>
                                    <th>Date Posted</th>
                                    <th>Deadline</th>
                                    <th>Prospect</th>
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
        .shipicon{
            margin-top: 3px;
            padding-left: 8px;
            padding-right: 8px;
        }

        table{
            font-size: 14px;
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
        var fleet = "{{ auth()->user()->fleet ?? "%%" }}";
        @if(auth()->user()->id == 4501)
            fleet = "%%";
        @endif
        var user_id = null;
        var fVessel = "%%";
        var fRank = "%%";
        var fDate = "%%";
        var fVesselType = "%%";
        var fStatus = "AVAILABLE";

        var table = $('#table').DataTable({
            serverSide: true,
            pageLength: 50,
            ajax: {
                url: "{{ route('datatables.requirements') }}",
                type: "POST",
                dataType: "json",
                // dataSrc: "",
                data: f => {
                    f.fleet = fleet;
                    f.user_id = user_id;
                    f.vesselType = fVesselType;
                    f.vessel = fVessel;
                    f.rank = fRank;
                    f.date = fDate;
                    f.status = fStatus;
                    f.load = ['vessel', 'rank', 'candidates']
                }
            },
            columns: [
                { data: 'id'},
                { data: 'vessel'},
                { data: 'rank.abbr'},
                { data: 'joining_date' },
                { data: 'joining_port' },
                { data: 'usv' },
                { data: 'salary' },
                { data: 'max_age' },
                { data: 'remarks'},
                { data: 'fleet'},
                { data: 'status'},
                { data: 'created_at'},
                { data: 'deadline'},
                { data: 'candidates.length'},
                { data: 'actions'}
            ],
            columnDefs: [
                {
                    targets: [3,12],
                    className: "text-center",
                    render: date =>{
                        let temp = date ? moment(date).format('DD-MMM-YY') : "-";

                        if(moment(date).diff(moment(), 'days') <= 30){
                            temp = `
                                <div style="color: red; font-weight: bold;">
                                    ${temp}
                                </div>
                            `;
                        }

                        return temp;
                    }
                },
                {
                    targets: [11],
                    className: "text-center",
                    render: date =>{
                        let temp = date ? moment(date).format('DD-MMM-YY') : "-";
                        return temp;
                    }
                },
                {
                    targets: 5,
                    render: usv =>{
                        return usv ? "Required" : "---";
                    }
                },
                {
                    targets: 6,
                    render: salary =>{
                        return salary ? "$" + parseFloat(salary).toLocaleString() : "---";
                    }
                },
                {
                    targets: 13,
                    className: "text-center"
                },
                {
                    targets: 14,
                    width: "60px"
                },
                {
                    targets: 1,
                    render: vessel =>{
                        if(vessel){
                            return `
                                ${vessel.name}
                                <br>
                                {{-- <div style="color: orange;">${vessel.type}</div> --}}
                                <div style="font-style: italic; color: #369589;">${vessel.type}</div>
                            `;
                        }
                        else{
                            return "TBN";
                        }
                    }
                }
            ],
            drawCallback: function(){
                $('#table tbody').append('<div class="preloader"></div>');
                // MUST NOT BE INTERCHANGED t-i
                tooltip();
                // initializeActions();
            },
            searching: false,
            order: [ [0, 'desc'] ],
        });

        table.on('draw', () => {
            setTimeout(() => {
                $('.preloader').fadeOut();
                if(swal.isVisible()){
                    swal.close();
                }
            }, 800);
        });

        function continuesReload(){
            setTimeout(() => {
                console.log("reload");
                reload();
                continuesReload();
            }, 30000);
        }
        // continuesReload();

        $('#fleet').on('change', e => {
            if(isNaN(e.target.value)){
                fleet = e.target.value;
                user_id = null;
            }
            else{
                user_id = e.target.value;
                fleet = "%%";
            }
            $('#table').DataTable().ajax.reload();
        });

        $('#status').on('change', e => {
            fStatus = e.target.value;
            $('#table').DataTable().ajax.reload();
        });

        $('#fRank').on('change', e => {
            fRank = e.target.value;
            $('#table').DataTable().ajax.reload();
        });

        $('#fVessel').on('change', e => {
            fVessel = e.target.value;
            $('#table').DataTable().ajax.reload();
        });

        $('#fVesselType').on('change', e => {
            fVesselType = e.target.value;
            getVesselList();
            $('#table').DataTable().ajax.reload();
        });

        $(document).ready(() => {
            getVesselList();
        });

        function getVesselList(){
            $.ajax({
                url: '{{ route('vessels.get2') }}',
                data: {
                    cols: "*",
                    where: ['fleet', fleet],
                    where2: ['status', 'ACTIVE'],
                    where3: ['type', fVesselType]
                },
                success: result => {
                    result = JSON.parse(result);
                    
                    let fVesselString = '<option value="%%">All</option>';

                    result.forEach(vessel => {
                        fVesselString += `
                            <option value="${vessel.id}">${vessel.name}</option>
                        `;
                    })

                    $('#fVessel').html(fVesselString);
                    $('#fVessel').select2({
                        placeholder: 'Select Vessel'
                    });
                    $('#fRank').select2({
                        placeholder: 'Select Rank'
                    });
                }
            })
        }

        function create(){
            swal({
                title: "Input Details",
                html: `
                    @if(auth()->user()->fleet == null)
                        <div class="row iRow">
                            <div class="col-md-2 iLabel">
                                Fleet
                            </div>
                            <div class="col-md-10 iInput">
                                <select name="fleet" class="form-control">
                                    <option value="FLEET A">FLEET A</option>
                                    <option value="FLEET B">FLEET B</option>
                                    <option value="FLEET C">FLEET C</option>
                                    <option value="FLEET D">FLEET D</option>
                                    <option value="FLEET E">FLEET E</option>
                                    <option value="TOEI">TOEI</option>
                                    <option value="FISHING">FISHING</option>
                                </select>
                            </div>
                        </div></br>
                    @endif
                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Vessel
                        </div>
                        <div class="col-md-10 iInput">
                            <select name="vessel_id" class="form-control">
                                <option value="">TBN</option>
                            </select>
                        </div>
                    </div></br>
                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Rank
                        </div>
                        <div class="col-md-10 iInput">
                            <select name="rank" class="form-control">
                                <option value=""></option>
                            </select>
                        </div>
                    </div></br>
                    ${input("joining_date", "Joining Date", null, 2,10)}
                    ${input("joining_port", "Joining Port", null, 2,10)}
                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            US Visa
                        </div>
                        <div class="col-md-10 iInput">
                            <div class="col-md-12 iInput" style="text-align: left;">
                                ${checkbox("usv", "Require")}
                            </div>
                        </div>
                    </div></br>
                    ${input("salary", "Salary", null, 2,10, 'number', 'min=0')}
                    ${input("max_age", "Max Age", 60, 2,10, 'number', 'min=30 max=65')}
                    ${input("deadline", "Deadline", null, 2,10)}
                    ${input("remarks", "Remarks", null, 2,10)}
                `,
                width: '650px',
                confirmButtonText: 'Add',
                showCancelButton: true,
                cancelButtonColor: errorColor,
                cancelButtonText: 'Cancel',
                onOpen: () => {
                    $.ajax({
                        url: '{{ route('vessels.get2') }}',
                        data: {
                            cols: ['id', 'name'],
                            where: ['status', 'ACTIVE'],
                            where2: ['fleet', fleet]
                        },
                        success: vessels => {
                            vessels = JSON.parse(vessels);
                            vesselString = "";

                            vessels.forEach(vessel => {
                                vesselString += `
                                    <option value="${vessel.id}">${vessel.name}</option>
                                `;
                            });

                            $('[name="vessel_id"]').append(vesselString);
                            $('[name="vessel_id"]').select2({
                                // placeholder: 'Select Vessel',
                                tags: true
                            });
                        }
                    });

                    $.ajax({
                        url: '{{ route('rank.get') }}',
                        data: {
                            select: ['id', 'abbr', 'name'],
                        },
                        success: ranks => {
                            ranks = JSON.parse(ranks);
                            rankString = "";

                            ranks.forEach(rank => {
                                rankString += `
                                    <option value="${rank.id}">${rank.name} (${rank.abbr})</option>
                                `;
                            });

                            $('[name="rank"]').append(rankString);
                            $('[name="rank"]').select2({
                                placeholder: 'Select Rank'
                            });
                        }
                    });

                    $('[name="joining_date"], [name="deadline"]').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                        minDate: moment().format("YYYY-MM-DD")
                    });

                    $('[name="rank"], [name="vessel_id"]').on('change', e => {
                        if($('[name="rank"]').val() && $('[name="vessel_id"]').val()){
                            $.ajax({
                                url: '{{ route('wage.get') }}',
                                data: {
                                    cols: 'total',
                                    where: ['vessel_id', $('[name="vessel_id"]').val()],
                                    where2: ['rank_id', $('[name="rank"]').val()]
                                },
                                success: wage => {
                                    wage = JSON.parse(wage)[0];
                                    if(wage){
                                        $('[name="salary"]').val(wage.total);
                                    }
                                    else{
                                        $('[name="salary"]').val(0);
                                    }
                                }
                            })
                        }
                    });
                },
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        if($('[name="rank"]').val() == ""){
                            swal.showValidationError('Rank is Required');
                        }
                            
                        setTimeout(() => {resolve()}, 500);
                    });
                },
            }).then(result => {
                if(result.value){
                    swal.showLoading();
                    
                    $.ajax({
                        url: "{{ route('requirement.store') }}",
                        type: "POST",
                        data: {
                            @if(auth()->user()->fleet != null)
                                fleet: fleet,
                            @else
                                fleet: $("[name='fleet']").val(),
                            @endif
                            vessel_id: $("[name='vessel_id']").val(),
                            rank: $("[name='rank']").val(),
                            joining_date: $("[name='joining_date']").val(),
                            joining_port: $("[name='joining_port']").val(),
                            salary: $("[name='salary']").val(),
                            max_age: $("[name='max_age']").val(),
                            deadline: $("[name='deadline']").val(),
                            remarks: $("[name='remarks']").val(),
                            usv: $("[name='usv']:checked").length
                        },
                        success: () => {
                            ss("Success");
                            reload();
                        }
                    })
                }
            });
        }

        function checkbox(name, value, checked = ""){
            return `
                <input type="checkbox" name="${name}" value="${value}" ${checked}>
                <label for="${name}">${value}</label><br>
            `;
        }
        
        function del(id){
            sc("Confirmation", "Are you sure you want to delete?", result => {
                if(result.value){
                    swal.showLoading();
                    update({
                        url: "{{ route('requirement.delete') }}",
                        data: {id: id},
                        message: "Success"
                    }, () => {
                        reload();
                    })
                }
            });
        }

        function view(id){
            $.ajax({
                url: "{{ route('requirement.get') }}",
                data: {
                    select: '*',
                    where: ['id', id],
                },
                success: data => {
                    data = JSON.parse(data)[0];
                    showDetails(data);
                }
            });
        }

        function showDetails(data){
            let exp = data.exp;
            try{
                if(data.exp){
                    exp = JSON.parse(data.exp);
                }
                else{
                    exp = "x";
                }
            }
            catch(e){
                exp = "x";
            }

            swal({
                html: `
                    ${input("id", "", data.id, 2,10, 'hidden')}
                    @if(auth()->user()->fleet == null)
                        <div class="row iRow">
                            <div class="col-md-2 iLabel">
                                Fleet
                            </div>
                            <div class="col-md-10 iInput">
                                <select name="fleet" class="form-control">
                                    <option value="FLEET A">FLEET A</option>
                                    <option value="FLEET B">FLEET B</option>
                                    <option value="FLEET C">FLEET C</option>
                                    <option value="FLEET D">FLEET D</option>
                                    <option value="FLEET E">FLEET E</option>
                                    <option value="TOEI">TOEI</option>
                                    <option value="FISHING">FISHING</option>
                                </select>
                            </div>
                        </div></br>
                    @endif
                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Vessel
                        </div>
                        <div class="col-md-10 iInput">
                            <select name="vessel_id" class="form-control">
                                <option value="">TBN</option>
                            </select>
                        </div>
                    </div></br>
                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Rank
                        </div>
                        <div class="col-md-10 iInput">
                            <select name="rank" class="form-control">
                                <option value=""></option>
                            </select>
                        </div>
                    </div></br>
                    ${input("joining_date", "Joining Date", data.joining_date, 2,10)}
                    ${input("joining_port", "Joining Port", data.joining_port, 2,10)}
                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            US Visa
                        </div>
                        <div class="col-md-10 iInput">
                            <div class="col-md-12 iInput" style="text-align: left;">
                                ${checkbox("usv", "Require")}
                            </div>
                        </div>
                    </div></br>
                    ${input("salary", "Salary", data.salary, 2,10, 'number', 'min=0')}
                    ${input("max_age", "Max Age", data.max_age, 2,10, 'number', 'min=30 max=65')}
                    ${input("deadline", "Deadline", null, 2,10)}
                    ${input("remarks", "Remarks", data.remarks, 2,10)}
                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Status
                        </div>
                        <div class="col-md-10 iInput">
                            <select name="status" class="form-control">
                                <option value="AVAILABLE">AVAILABLE</option>
                                <option value="COMPLETED">COMPLETED</option>
                                <option value="ON HOLD">ON HOLD</option>
                                <option value="CANCELLED">CANCELLED</option>
                            </select>
                        </div>
                    </div></br>
                `,
                width: '800px',
                confirmButtonText: 'Update',
                showCancelButton: true,
                cancelButtonColor: errorColor,
                cancelButtonText: 'Cancel',
                onOpen: () => {
                    $.ajax({
                        url: '{{ route('vessels.get2') }}',
                        data: {
                            cols: ['id', 'name'],
                            where: ['status', 'ACTIVE'],
                            where2: ['fleet', fleet]
                        },
                        success: vessels => {
                            vessels = JSON.parse(vessels);
                            vesselString = "";

                            vessels.forEach(vessel => {
                                vesselString += `
                                    <option value="${vessel.id}">${vessel.name}</option>
                                `;
                            });

                            $('[name="vessel_id"]').append(vesselString);
                            $('[name="vessel_id"]').val(data.vessel_id);
                            $('[name="vessel_id"]').select2({
                                // placeholder: 'Select Vessel'
                                tags: true
                            });
                        }
                    });

                    $.ajax({
                        url: '{{ route('rank.get') }}',
                        data: {
                            select: ['id', 'abbr', 'name'],
                        },
                        success: ranks => {
                            ranks = JSON.parse(ranks);
                            rankString = "";

                            ranks.forEach(rank => {
                                rankString += `
                                    <option value="${rank.id}">${rank.name} (${rank.abbr})</option>
                                `;
                            });

                            $('[name="rank"]').append(rankString);
                            $('[name="rank"]').val(data.rank);
                            $('[name="rank"]').select2({
                                placeholder: 'Select Rank'
                            });
                        }
                    });

                    $('[name="joining_date"], [name="deadline"]').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                        minDate: moment().format("YYYY-MM-DD")
                    });

                    $('[name="rank"], [name="vessel_id"]').on('change', e => {
                        if($('[name="rank"]').val() && $('[name="vessel_id"]').val()){
                            $.ajax({
                                url: '{{ route('wage.get') }}',
                                data: {
                                    cols: 'total',
                                    where: ['vessel_id', $('[name="vessel_id"]').val()],
                                    where2: ['rank_id', $('[name="rank"]').val()]
                                },
                                success: wage => {
                                    wage = JSON.parse(wage)[0];
                                    if(wage){
                                        $('[name="salary"]').val(wage.total);
                                    }
                                    else{
                                        $('[name="salary"]').val(0);
                                    }
                                }
                            })
                        }
                    });

                    @if(auth()->user()->fleet == null)
                        $('[name="fleet"]').val(data.fleet).change();
                    @endif

                    if(data.usv){
                        $('.swal2-content [type="checkbox"]').click();
                    }

                    $('[name="status"]').val(data.status);
                },
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        if($('[name="rank"]').val() == ""){
                            swal.showValidationError('Vessel and Rank is Required');
                        }
                            
                        setTimeout(() => {resolve()}, 500);
                    });
                },
            }).then(result => {
                if(result.value){
                    swal.showLoading();

                    if($("[name='status']").val() == "CANCELLED" && data.status != "CANCELLED"){
                        let data = {
                            id: $("[name='id']").val(),
                            @if(auth()->user()->fleet == null)
                                fleet: $("[name='fleet']").val(),
                            @endif
                            vessel_id: $("[name='vessel_id']").val(),
                            rank: $("[name='rank']").val(),
                            joining_date: $("[name='joining_date']").val(),
                            joining_port: $("[name='joining_port']").val(),
                            salary: $("[name='salary']").val(),
                            max_age: $("[name='max_age']").val(),
                            remarks: $("[name='remarks']").val(),
                            status: $("[name='status']").val(),
                            deadline: $("[name='deadline']").val(),
                            usv: $("[name='usv']:checked").length
                        };

                        swal({
                            title: 'Reason for cancellation',
                            html: `${input("cReason", "", null, 0,12)}`,
                            preConfirm: () => {
                                swal.showLoading();
                                return new Promise(resolve => {
                                    if($('[name="cReason"]').val() == ""){
                                        swal.showValidationError('Required');
                                    }
                                        
                                    setTimeout(() => {resolve()}, 500);
                                });
                            },
                        }).then(result => {
                            if(result.value){
                                data.remarks = data.remarks + " / Cancelled due to " + $("[name='cReason']").val();

                                update({
                                    url: "{{ route('requirement.update') }}",
                                    data: data,
                                    message: "Success"
                                }, () => {
                                    reload();
                                })
                            }
                        });
                    }
                    else{
                        update({
                            url: "{{ route('requirement.update') }}",
                            data: {
                                id: $("[name='id']").val(),
                                @if(auth()->user()->fleet == null)
                                    fleet: $("[name='fleet']").val(),
                                @endif
                                vessel_id: $("[name='vessel_id']").val(),
                                rank: $("[name='rank']").val(),
                                joining_date: $("[name='joining_date']").val(),
                                joining_port: $("[name='joining_port']").val(),
                                salary: $("[name='salary']").val(),
                                max_age: $("[name='max_age']").val(),
                                remarks: $("[name='remarks']").val(),
                                status: $("[name='status']").val(),
                                deadline: $("[name='deadline']").val(),
                                usv: $("[name='usv']:checked").length
                            },
                            message: "Success"
                        }, () => {
                            reload();
                        })
                    }
                }
            });
        }

        function candidates(id){
            $.ajax({
                url: '{{ route('candidate.get') }}',
                data: {
                    where: ['requirement_id', id],
                    load: ["prospect"]
                },
                success: result => {
                    result = JSON.parse(result);

                    let candidates = result.candidates;
                    let req = result.req;
                    let string = "";

                    candidates.forEach(can => {
                        let action = `
                            <a class="btn btn-danger" data-toggle="tooltip" title="Reject" 
                                onclick="reject(${req.id}, ${can.id})">
                                <span class="fa fa-ban"></span>
                            </a>
                        `;

                        let file = "N/A";

                        if(can.prospect.file != null){
                            file = `
                                <a class="btn btn-success" onclick="viewFile('${can.prospect.file}', ${can.prospect.id})">
                                    <span class="fa fa-file fa-xs">
                                    </span>
                                </a>`;
                        }

                        string += `
                            <tr>
                                <td>${can.id}</td>
                                <td>${can.prospect.name}</td>
                                <td>${can.prospect.age}</td>
                                <td>${checkbox2("ii" + can.id, "test", can.initial_interview, can.status)}</td>
                                <td>${checkbox2("wa" + can.id, "test", can.written_assessment, can.status)}</td>
                                <td>${checkbox2("ti" + can.id, "test", can.technical_interview, can.status)}</td>
                                <td>${checkbox2("ec" + can.id, "test", can.endorsed_to_crewing, can.status)}</td>
                                <td>${checkbox2("pa" + can.id, "test", can.principals_approval, can.status)}</td>
                                <td>${checkbox2("fm" + can.id, "test", can.medical, can.status)}</td>
                                <td>${checkbox2("ob" + can.id, "test", can.on_board, can.status)}</td>
                                <td id="can${can.id}">${can.status}</td>
                                <td>${toDateTime(can.updated_at)}</td>
                                <td>${file}</td>
                                <td>
                                    <textarea id="canRemark${can.id}" style="width: 100%; resize: vertical;" cols="40" rows="2" value="${can.remarks}">${can.remarks ?? ""}</textarea>
                                </td>
                                <td>${["REJECTED", "ON BOARD"].includes(can.status) ? "" : action}</td>
                            </tr>
                        `;
                    })

                    if(string == ""){
                        string = `
                            <tr>
                                <td colspan="15">No candidates yet</td>
                            </tr>
                        `;
                    }
                    viewCandidates(string, req);
                    candidates.forEach(can => {
                        disableButtons(can.id, can.status);
                    });

                    let cbs = ["ii", "wa", "ti", "ec", "pa", "fm", "ob"];

                    /*ONCLICK EVENTS*/
                    cbs.forEach(cb => {
                        $(`[class^="${cb}"]`).on('click', e => {
                            let ctr = 0;
                            swal.showLoading();

                            let id2 = e.target.className.replace(cb, "");
                            let isChecked = e.target.checked;
                            let temp = {
                                ii: "initial_interview",
                                wa: "written_assessment",
                                ti: "technical_interview",
                                ec: "endorsed_to_crewing",
                                pa: "principals_approval",
                                fm: "medical",
                                ob: "on_board"
                            };

                            let data = {};
                            data["id"] = id2;
                            data[temp[cb]] = isChecked ? 1 : 0;

                            if(["ii", "wa", "ti", "ec"].includes(cb)){
                                ["ii", "wa", "ti", "ec"].forEach(cb2 => {
                                    if($(`.${cb2}${id2}`).is(":checked")){
                                        ctr++;
                                    }
                                });

                                data["status"] = ctr < 4 ? "PENDING" : "FOR APPROVAL";
                            }
                            else if(cb == "pa"){
                                data["status"] = isChecked ? "FOR MEDICAL" : "FOR APPROVAL";
                            }
                            else if(cb == "fm"){
                                data["status"] = isChecked ? "PASSED" : "FOR MEDICAL";
                            }
                            else if(cb == "ob"){
                                data["status"] = isChecked ? "ON BOARD" : "PASSED";
                            }

                            if(data["status"] != undefined){
                                $(`#can${id2}`).html(data["status"]);
                                disableButtons(id2, data["status"]);
                            }

                            if(data["status"] == "ON BOARD"){
                                $.ajax({
                                    url: '{{ route('requirement.update') }}',
                                    type: "POST",
                                    data: {
                                        id: req.id,
                                        status: "COMPLETED"
                                    },
                                    success: () => {
                                        reload();
                                        updateCandidate(data, id);
                                    }
                                });
                            }
                            else{
                                updateCandidate(data, id);
                            }
                        })
                    });

                    $(`[id^="canRemark"]`).bind('keyup.DT', e => {
                        if(e.which == 13){
                            let id = e.target.id.replace("canRemark", "");
                            updateCandidate({
                                id: id,
                                remarks: e.target.value
                            }, id);
                        }
                    });
                }
            });
        }

        function viewFile(file, id){
            window.open(`prospectForms/${id}/${file}`);
        }

        function updateCandidate(data, id){
            data.updated_at = moment().format("YYYY-MM-DD HH:mm:ss");
            $.ajax({
                url: '{{ route('candidate.update') }}',
                type: "POST",
                data: data,
                success: () => {
                    setTimeout(() => {
                        swal.hideLoading();
                        $('.swal2-content').append(`
                            <div id='updateSuccess' style='color: green; text-align: center; font-weight: bold;'>
                                Successfully Updated
                            </div>
                        `);
                    }, 800);

                    setTimeout(() => {
                        $('#updateSuccess').remove();
                        console.log(id);
                        candidates(id);
                    }, 2000);
                }
            });
        }

        function disableButtons(id, status){
            let cbs = ["ii", "wa", "ti", "ec", "pa", "fm", "ob"];

            /*ENABLE ALL*/
            cbs.forEach(cb => {
                $(`.${cb}${id}`).prop('disabled', false);
            });

            let temp = [];

            if(status == "PENDING"){
                temp = ["ii", "wa", "ti", "ec"];
                let ctr = 0;
                temp.forEach(cb => {
                    if($(`.${cb}${id}`).is(':checked')){
                        ctr++;
                    }
                });

                temp = ctr < 4 ? ["pa", "fm", "ob"] : ["fm", "ob"];
            }
            else if(status == "FOR APPROVAL"){
                temp = ["ii", "wa", "ti", "ec", "fm", "ob"];
            }
            else if(status == "FOR MEDICAL"){
                temp = ["ii", "wa", "ti", "ec", "ob"];
            }
            else if(status == "PASSED"){
                temp = ["ii", "wa", "ti", "ec", "pa", "fm"];
            }
            else if(status == "REJECTED" || status == "ON BOARD"){
                temp = ["ii", "wa", "ti", "ec", "pa", "fm", "ob"];
            }

            // disable 
            temp.forEach(cb => {
                $(`.${cb}${id}`).prop('disabled', true);
            });
        }

        function reject(rid, cid){
            swal({
                title: "Confirmation",
                text: "Are you sure you want to reject this crew?",
                showCancelButton: true,
                cancelButtonColor: errorColor
            }).then(result => {
                if(result.value){
                    update({
                        url: "{{ route('candidate.update') }}",
                        data: {
                            id: cid,
                            status: 'REJECTED'
                        },
                        message: "Success"
                    }, () => {
                        setTimeout(() => {
                            candidates(rid);
                        }, 1000)
                    })
                }
                else{
                    candidates(rid);
                }
            })
        }
 
        function checkbox2(id, value, checked = "", status){
            if(checked){
                checked = "checked";
            }

            return `
                <input type="checkbox" class="${id}" ${checked} ${status == "REJECTED" ? "disabled" : ""}>
            `;
        }

        function viewCandidates(string, req){
            swal({
                title: `${req.rank.abbr} candidates for ${req.vessel ? req.vessel.name : "TBN"}`,
                width: '95%',
                html: `
                    @if(in_array(auth()->user()->role, ["Admin", "Recruitment Officer"]))
                        <div class="pull-right" style="margin-bottom: 5px;">
                            <a class="btn btn-success" data-toggle="tooltip" title="Add Candidate" 
                                onclick="addCandidate(${req.id}, '${req.rank.abbr}', ${req.max_age}, ${req.usv}, ${req.vessel ? req.vessel.id : 0})">
                                <span class="fa fa-plus"></span>
                            </a>
                        </div>
                    @endif

                    <table id="candidate_table" class="table table-hover table-bordered">
                        <thead style="background-color: #ffddcc;">
                            <tr>
                                <th style="vertical-align: middle;">ID</th>
                                <th style="vertical-align: middle;">Name</th>
                                <th style="vertical-align: middle;">Age</th>
                                <th style="vertical-align: middle;">Initial<br>Interview</th>
                                <th style="vertical-align: middle;">Written<br>Assessment</th>
                                <th style="vertical-align: middle;">Technical<br>Interview</th>
                                <th style="vertical-align: middle;">Endorsed<br>To Crewing</th>
                                <th style="vertical-align: middle;">Principals<br>Approval</th>
                                <th style="vertical-align: middle;">Ongoing<br>Medical</th>
                                <th style="vertical-align: middle;">On<br>Board</th>
                                <th style="vertical-align: middle;">Status</th>
                                <th style="vertical-align: middle;">Last<br>Updated</th>
                                <th style="vertical-align: middle;">Form</th>
                                <th style="vertical-align: middle;">Remark</th>
                                <th style="vertical-align: middle;">Action</th>
                            </tr>
                        </thead>
                        <tbody style="border: 1px solid black;">
                            ${string}
                        </tbody>
                    </table>
                `,
                onOpen: () => {
                    $('#candidate_table th, #candidate_table td').css('text-align', 'center');
                    $('#candidate_table td').css({
                        "border-bottom": "1px solid #c9c9c9",
                        "border-top": "1px solid #c9c9c9"
                    });
                    $('#candidate_table textarea').css({
                        border: "none"
                    });
                }
            })
        }

        function addCandidate(id, rank, age, usv, vid){
            swal({
                title: `Candidate Suggestions`,
                width: '70%',
                html: `
                    <table id="suggestions_table" class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NAME</th>
                                <th>RANK</th>
                                <th>AGE</th>
                                <th>EXP</th>
                                <th>CONTACT</th>
                                <th>USV</th>
                                <th>LOCATION</th>
                                <th>SALARY</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                `,
                onOpen: () => {
                    $('#suggestions_table th, #suggestions_table td').css('text-align', 'center');
                    $('#suggestions_table th').css('background-color', '#ffddcc');
                    var table2 = $('#suggestions_table').DataTable({
                        serverSide: true,
                        pageLength: 10,
                        ajax: {
                            url: "{{ route('datatables.suggestCandidate') }}",
                            type: "POST",
                            dataType: "json",
                            // dataSrc: "",
                            data: f => {
                                f.rank = rank;
                                f.age = age;
                                f.usv = usv;
                            }
                        },
                        columns: [
                            { data: 'id'},
                            { data: 'name'},
                            { data: 'rank'},
                            { data: 'age' },
                            { data: 'exp' },
                            { data: 'contact' },
                            { data: 'usv' },
                            { data: 'location' },
                            { data: 'previous_salary'},
                            { data: 'actions2'}
                        ],
                        columnDefs: [
                            {
                                targets: 3,
                                render: (age, d, row) =>{
                                    return row.birthday ? moment().diff(row.birthday, 'years') : age;
                                }
                            },
                            {
                                targets: 4,
                                render: exp =>{
                                    try{
                                        let temp = "";
                                        exp = JSON.parse(exp.replace(/&quot;/g,'"'));
                                        exp.forEach(xp => {
                                            temp += "/" + xp;
                                        });

                                        return temp ? temp.substring(1) : "";
                                    }
                                    catch(e){
                                        return exp;
                                    };
                                }
                            },
                            {
                                targets: 6,
                                render: usv =>{
                                    return usv ? toDate(usv) : "-";
                                }
                            },
                            {
                                targets: 8,
                                render: salary =>{
                                    return salary ?? "-";
                                }
                            },
                            {
                                targets: 9,
                                render: action =>{
                                    return `
                                        <a class='btn btn-success btn-sm' data-toggle='tooltip' title='Propose' onclick='propose(${id}, ${action}, "${rank}", ${age}, ${usv}, ${vid})'>
                                            <span class="fa fa-user-plus fa-2xs"></span>
                                        </a>
                                    `;
                                }
                            },
                        ],
                        drawCallback: function(){
                            $('#suggestions_table tbody').append('<div class="preloader"></div>');
                            // MUST NOT BE INTERCHANGED t-i
                            tooltip();
                            // initializeActions();
                        },
                        order: [ [0, 'desc'] ],
                    });

                    $('#suggestions_table_filter input').unbind();
                    $('#suggestions_table_filter input').bind('keyup.DT', e => {
                        if(e.which == 13){
                            table2.search($(e.target).val()).draw();
                        }
                    });

                    table2.on('draw', () => {
                        setTimeout(() => {
                            $('.preloader').fadeOut();
                        }, 800);
                    });
                }
            }).then(result => {
                if(result.value){
                    candidates(id);
                }
            });
        }

        function propose(rid, pid, rank, age, usv, vid){
            swal({
                title: "Confirmation",
                text: "Are you sure you want to propose this crew?",
                showCancelButton: true,
                cancelButtonColor: errorColor
            }).then(result => {
                if(result.value){
                    $.ajax({
                        url: "{{ route('candidate.store') }}",
                        type: "POST",
                        data: {
                            requirement_id: rid,
                            prospect_id: pid,
                            vessel_id: vid,
                        },
                        success: () => {
                            ss("Success");
                            reload();
                            setTimeout(() => {
                                candidates(rid);
                            }, 1000)
                        }
                    })
                }
                else{
                    addCandidate(rid, rank, age, usv);
                }
            })
        }

        function exporto(){
            window.location.href = `{{ route('requirement.export') }}`;
        }

        function vesselDetails(vid){
            $.ajax({
                url: 'vessels/get/' + vid,
                success: vessel => {
                    vessel = JSON.parse(vessel);
                    showVesselDetails(vessel, false);
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
    </script>
@endpush