@extends('layouts.app')
@section('content')

<section class="content">

    <div class="row">
        <section class="col-lg-12">
            <div class="box box-info">

                <div class="box-header">
                    @include('candidates.includes.toolbar')
                </div>

                <div class="table-responsive">
                    <div class="box-body">
                        <table class="table table-hover table-bordered" id="table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Rank</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>#</th>
                                    <th>VSL EXP</th>
                                    <th>USV</th>
                                    <th>Source</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Fleet</th>
                                    <th>Vessel</th>
                                    <th>Remarks</th>
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
@endpush

@push('after-scripts')
    <script>
        var fleet = "{{ auth()->user()->fleet ?? "%%" }}";
        var user_id = null;
        var fVessel = "%%";
        var fRank = "%%";
        var fDate = "%%";
        var fStatus = "%%";

        var table = $('#table').DataTable({
            serverSide: true,
            pageLength: 10,
            ajax: {
                url: "{{ route('datatables.candidates') }}",
                type: "POST",
                dataType: "json",
                // dataSrc: "",
                data: f => {
                    f.fleet = fleet;
                    f.vessel = fVessel;
                    f.rank = fRank;
                    f.status = fStatus;
                    f.load = ['prospect', 'vessel']
                }
            },
            columns: [
                { data: 'id'},
                { data: 'prospect.rank'},
                { data: 'prospect.name'},
                { data: 'prospect.birthday'},
                { data: 'prospect.contact'},
                { data: 'prospect.exp'},
                { data: 'prospect.usv'},
                { data: 'prospect.source'},
                { data: 'status'},
                { data: 'created_at'},
                { data: 'fleet'},
                { data: 'vessel.name'},
                { data: 'remarks'}
            ],
            columnDefs: [
                {
                    targets: 9,
                    render: date =>{
                        return date ? moment(date).format('MMM DD, YYYY') : "-";
                    }
                },
                {
                    targets: 3,
                    render: date =>{
                        return date ? moment().diff(date, 'years') : "-";
                    }
                },
                {
                    targets: 3,
                    render: date =>{
                        return usv ? toDate(usv) : "-";
                    }
                },
                {
                    targets: 5,
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
                    targets: 11,
                    render: vname =>{
                        return vname ?? "TBA";
                    }
                },
                {
                    targets: [0,1,2,3,4,5,6,7,8,9,10,11,12],
                    className: 'text-center'
                }
            ],
            drawCallback: function(){
                $('#table tbody').append('<div class="preloader"></div>');
                // MUST NOT BE INTERCHANGED t-i
                tooltip();
                // initializeActions();
            },
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

        $('#fVessel').on('change', e => {
            fVessel = e.target.value;
            $('#table').DataTable().ajax.reload();
        });

        $('#fRank').on('change', e => {
            fRank = e.target.value;
            $('#table').DataTable().ajax.reload();
        });

        $(document).ready(() => {
            // GET VESSEL FOR FILTER
            $.ajax({
                url: '{{ route('vessels.get2') }}',
                data: {
                    cols: "*",
                    where: ['fleet', fleet],
                    where2: ['status', 'ACTIVE']
                },
                success: result => {
                    result = JSON.parse(result);
                    
                    let fVesselString = "";

                    result.forEach(vessel => {
                        fVesselString += `
                            <option value="${vessel.id}">${vessel.name}</option>
                        `;
                    })

                    $('#fVessel').append(fVesselString);
                     $('#fVessel').select2({
                        placeholder: 'Select Vessel'
                    });
                }
            });

            // GET RANK FOR FILTERS
            $.ajax({
                url: '{{ route('rank.get') }}',
                data: {
                    select: "*",
                },
                success: result => {
                    result = JSON.parse(result);
                    
                    let fRankString = "";

                    result.forEach(rank => {
                        fRankString += `
                            <option value="${rank.id}">${rank.name} (${rank.abbr})</option>
                        `;
                    })

                    $('#fRank').append(fRankString);
                     $('#fRank').select2({
                        placeholder: 'Select Rank'
                    });
                }
            });
        });
    </script>
@endpush