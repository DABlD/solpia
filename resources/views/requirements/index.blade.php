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
                    console.log(fleet);
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
        
        function update(id, status, label){
            sc("Confirmation", `Are you sure you want to ${label}?`, result => {
                if(result.value){
                    swal.showLoading();
                    update({
                        url: "{{ route('requirement.update') }}",
                        data: {
                            id: id,
                            status: status
                        },
                        message: "Success"
                    }, () => {
                        reload();
                    })
                }
            });
        }
    </script>
@endpush