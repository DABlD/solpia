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
                                    <th>Join Date</th>
                                    <th>Port</th>
                                    <th>USV</th>
                                    <th>Salary</th>
                                    <th>Max Age</th>
                                    <th>Remarks</th>
                                    <th>Fleet</th>
                                    <th>Status</th>
                                    <th>Date Posted</th>
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
        var vessel = "%%";
        var rank = "%%";
        var date = "%%";

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
                    f.vessel = vessel;
                    f.rank = rank;
                    f.date = date;
                    f.load = ['vessel', 'rank']
                }
            },
            columns: [
                { data: 'id'},
                { data: 'vessel.name'},
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
                { data: 'actions'}
            ],
            columnDefs: [
                {
                    targets: [3, 11],
                    render: date =>{
                        return moment(date).format('MMM DD, YYYY');
                    }
                },
                {
                    targets: 5,
                    render: usv =>{
                        return usv ? "Required" : "---";
                    }
                }
            ],
            drawCallback: function(){
                $('#table tbody').append('<div class="preloader"></div>');
                // MUST NOT BE INTERCHANGED t-i
                tooltip();
                // initializeActions();
            },
            order: [],
            // order: [ [0, 'desc'] ],
        });

        table.on('draw', () => {
            setTimeout(() => {
                $('.preloader').fadeOut();
                if(swal.isVisible()){
                    swal.close();
                }
            }, 800);
        });

        $('#fleet').on('change', e => {
            fleet = e.target.value;
            $('#table').DataTable().ajax.reload();
        });

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
                                <option value=""></option>
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
                                placeholder: 'Select Vessel'
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

                    $('[name="joining_date"]').flatpickr({
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
                        if($('[name="vessel_id"]').val() == "" || $('[name="rank"]').val() == ""){
                            swal.showValidationError('Vessel and Rank is Required');
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
                                <option value=""></option>
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
                    ${input("remarks", "Remarks", data.remarks, 2,10)}
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
                                placeholder: 'Select Vessel'
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

                    $('[name="joining_date"]').flatpickr({
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
                },
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        if($('[name="vessel_id"]').val() == "" || $('[name="rank"]').val() == ""){
                            swal.showValidationError('Vessel and Rank is Required');
                        }
                            
                        setTimeout(() => {resolve()}, 500);
                    });
                },
            }).then(result => {
                if(result.value){
                    swal.showLoading();

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
                            usv: $("[name='usv']:checked").length
                        },
                        message: "Success"
                    }, () => {
                        reload();
                    })
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

                        string += `
                            <tr>
                                <td>${can.id}</td>
                                <td>${can.prospect.name}</td>
                                <td>${checkbox("ii", "test", can.initial_interview)}</td>
                                <td>${checkbox("wa", "test", can.written_assessment)}</td>
                                <td>${checkbox("ti", "test", can.technical_interview)}</td>
                                <td>${checkbox("pa", "test", can.principals_approval)}</td>
                                <td>${checkbox("fm", "test", can.medical)}</td>
                                <td>${checkbox("ob", "test", can.on_board)}</td>
                                <td>${can.status}</td>
                                <td>${action}</td>
                            </tr>
                        `;
                    })

                    if(string == ""){
                        string = `
                            <tr>
                                <td colspan="8">No candidates yet</td>
                            </tr>
                        `;
                    }
                    viewCandidates(string, req);
                }
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
 
        function checkbox(id, value, checked = ""){
            return `
                <input type="checkbox" id="${id}" ${checked}>
            `;
        }

        function viewCandidates(string, req){
            swal({
                title: `${req.rank.abbr} candidates for ${req.vessel.name}`,
                width: '70%',
                html: `
                    @if(in_array(auth()->user()->role, ["Admin", "Recruitment Officer"]))
                        <div class="pull-right" style="margin-bottom: 5px;">
                            <a class="btn btn-success" data-toggle="tooltip" title="Add Candidate" 
                                onclick="addCandidate(${req.id}, '${req.rank.abbr}', ${req.max_age}, ${req.usv}, ${req.vessel.id})">
                                <span class="fa fa-plus"></span>
                            </a>
                        </div>
                    @endif

                    <table id="candidate_table" class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Initial Interview</th>
                                <th>Written Assessment</th>
                                <th>Technical Interview</th>
                                <th>Principals Approval</th>
                                <th>For Medical</th>
                                <th>On Board</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${string}
                        </tbody>
                    </table>
                `,
                onOpen: () => {
                    $('#candidate_table th, #candidate_table td').css('text-align', 'center');
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
    </script>
@endpush