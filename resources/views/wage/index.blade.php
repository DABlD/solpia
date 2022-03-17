@extends('layouts.app')
@section('content')

<section class="content">

    <div class="row">
        <section class="col-lg-12">
            <div class="box box-info">

                <div class="box-header">
                    @include('wage.includes.toolbar')
                </div>

                <div class="box-body">
                    <table class="table table-hover table-bordered" id="table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Principal</th>
                                <th>Vessel</th>
                                <th>Rank</th>
                                <th>Basic</th>
                                <th>Leave Pay</th>
                                <th>F.O.T</th>
                                <th>G.O.T</th>
                                <th>Sub. Allow.</th>
                                <th>Retire Allow.</th>
                                <th>Sup. Allow.</th>
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
@endpush

@push('before-scripts')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
@endpush

@push('after-scripts')
    <script>
        let table = $('#table').DataTable({
            serverSide: true,
            ajax: {
                url: '{{ route('datatables.wages') }}',
                type: 'POST',
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'pname', name: 'pname' },
                { data: 'vname', name: 'vname' },
                { data: 'rname', name: 'rname' },
                { data: 'basic', name: 'basic' },
                { data: 'leave_pay', name: 'leave_pay' },
                { data: 'fot', name: 'fot' },
                { data: 'ot', name: 'ot' },
                { data: 'sub_allow', name: 'sub_allow' },
                { data: 'retire_allow', name: 'retire_allow' },
                { data: 'sup_allow', name: 'sup_allow' },
                { data: 'actions', name: 'actions' },
            ],
            // columnDefs: [
            //     {
            //         targets: 6,
            //         render: function(status){
            //             let color = status == "ACTIVE" ? '#00a65a' : '#dd4b39';

            //             return `
            //                 <span class="badge" style="background-color: ${color}">${status}</span>
            //             `;
            //         }
            //     },
            //     {
            //         targets: 7,
            //         width: '115px'
            //     },
            // ],
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
                if(swal.isVisible()){
                    swal.close();
                }
            }, 800);
        });

        function initializeActions(){
            // $('[data-original-title="View Vessel Details"]').on('click', vessel => {
            //     $.ajax({
            //         url: 'vessels/get/' + $(vessel.target).data('id'),
            //         success: vessel => {
            //             vessel = JSON.parse(vessel);
            //             table.ajax.reload(null, false);
            //         }
            //     });
            // });
        }


        $('[title="Add Entry"]').on('click', () => {
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
                            <select id="principal_id" class="form-control">
                                <option value="">Select Principal</option>
                            </select><br><br>
                            <select id="vessel_id" class="form-control">
                                <option value="">Select Vessel</option>
                            </select><br><br>
                            <select id="rank_id" class="form-control">
                                <option value="">Select Rank</option>
                                ${rankString}
                            </select><br><br>
                        `,
                        onOpen: () => {
                            $('#principal_id, #vessel_id, #rank_id').select2();
                            $('#principal_id, #vessel_id, #rank_id').on('select2:open', () => {
                                $('.swal2-container').css('z-index', 1000);
                            });

                            swal.showLoading();

                            // GET PRINCIPALS
                            $.ajax({
                                url: '{{ route('principal.get') }}',
                                data: {
                                    cols: ['id', 'name'],
                                    where: ['active', 1]
                                },
                                success: principals => {
                                    principals = JSON.parse(principals);
                                    let principalString = "";
                                    principals.forEach(principal => {
                                        principalString += `
                                            <option value="${principal.id}">${principal.name}</option>
                                        `;
                                    });

                                    $('#principal_id').append(principalString);
                                    swal.hideLoading();
                                }
                            });

                            $('#principal_id').on('change', e => {
                                swal.showLoading();
                                pid = e.target.value;

                                $.ajax({
                                    url: '{{ route('vessels.get') }}',
                                    data: {
                                        id: pid
                                    },
                                    success: vessels => {
                                        vessels = JSON.parse(vessels);
                                        let vesselString = "";
                                        vessels.forEach(vessel => {
                                            vesselString += `
                                                <option value="${vessel.id}">${vessel.name}</option>
                                            `;
                                        });

                                        $('#vessel_id').append(vesselString);
                                        swal.hideLoading();
                                    }
                                });
                            });
                        }
                    });
                }
            })
        });

        function addWage(principal_id, vessel_id){
            swal({
                title: 'Enter Details',
                html: `
                    <input type="hidden" id="principal_id" value="${principal_id}">
                    <input type="hidden" id="vessel_id" value="${vessel_id}">

                    <select id="rank_id"></select>
                `
            })
        }
    </script>
@endpush