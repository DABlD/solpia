@extends('layouts.app')
@section('content')

<section class="content">

    <div class="row">
        <section class="col-lg-12">
            <div class="box box-info">

                <div class="box-header">
                    {{-- @include('requirements.includes.toolbar') --}}
                </div>

                <div class="table-responsive">
                    <div class="box-body">
                        <table class="table table-hover table-bordered" id="table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Short Name</th>
                                    <th>Full Name</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Fleet</th>
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
    <style>
        
    </style>
@endpush

@push('before-scripts')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endpush

@push('after-scripts')
    <script>
        var fleet = "%%";

        var table = $('#table').DataTable({
            serverSide: true,
            pageLength: 20,
            ajax: {
                url: "{{ route('datatables.principals') }}",
                type: "POST",
                dataType: "json",
                // dataSrc: "",
                data: f => {
                    f.fleet = fleet;
                    f.where = ['active', 1]
                }
            },
            columns: [
                { data: 'id'},
                { data: 'name'},
                { data: 'full_name'},
                { data: 'address'},
                { data: 'contact'},
                { data: 'email'},
                { data: 'fleet'},
                { data: 'actions'}
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
                        url: "{{ route('principal.store') }}",
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

        function view(id){
            $.ajax({
                url: "{{ route('principal.get') }}",
                data: {
                    cols: '*',
                    where: ['id', id],
                },
                success: data => {
                    data = JSON.parse(data)[0];
                    showDetails(data);
                }
            });
        }

        function showDetails(data){
            swal({
                html: `
                    ${input("id", "", data.id, 2,10, 'hidden')}
                    ${input("name", "Short Name", data.name, 2,10)}
                    ${input("full_name", "Full Name", data.full_name, 2,10)}
                    ${input("address", "Address", data.address, 2,10)}
                    ${input("contact", "Contact", data.contact, 2,10)}
                    ${input("email", "Email", data.email, 2,10)}
                `,
                width: '800px',
                confirmButtonText: 'Update',
                showCancelButton: true,
                cancelButtonColor: errorColor,
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        let bool = true;
                        if($('[name="name"]').val() == ""){
                            swal.showValidationError('Short Name is required');
                        }
                        else{
                            let bool = false;
                            // Insert ajax validation
                            setTimeout(() => {resolve()}, 500);
                        }
                        bool ? setTimeout(() => {resolve()}, 500) : "";
                    });
                },
            }).then(result => {
                if(result.value){
                    swal.showLoading();

                    update({
                        url: "{{ route('principal.update') }}",
                        data: {
                            id: $("[name='id']").val(),
                            name: $("[name='name']").val(),
                            full_name: $("[name='full_name']").val(),
                            address: $("[name='address']").val(),
                            contact: $("[name='contact']").val(),
                            email: $("[name='email']").val(),
                        },
                        message: "Success"
                    }, () => {
                        reload();
                    })
                }
            });
        }
        
        // function update(id, status, label){
        //     sc("Confirmation", `Are you sure you want to ${label}?`, result => {
        //         if(result.value){
        //             swal.showLoading();
        //             update({
        //                 url: "{{ route('principal.update') }}",
        //                 data: {
        //                     id: id,
        //                     status: status
        //                 },
        //                 message: "Success"
        //             }, () => {
        //                 reload();
        //             })
        //         }
        //     });
        // }
    </script>
@endpush