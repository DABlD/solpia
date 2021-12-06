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
                                <th>Pic</th>
                                <th>Rank</th>
                                <th>Surname</th>
                                <th>First Name</th>
                                <th>Age</th>
                                <th>Contact</th>
                                <th>Last Vessel</th>
                                <th>Date Applied</th>
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

    <style>
        #table img{
            width: 60px;
            height: 60px;
        }

        .select2-selection__choice{
            background-color: #f76c6b !important;
        }

        .select2-selection__choice__remove{
            color: black !important;
        }

        .w50{
            width: 60px !important;
        }

        .w150{
            width: 150px !important;
        }
    </style>
@endpush

@push('before-scripts')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
@endpush

@push('after-scripts')
    <script>
        let table = $('#table').DataTable({
            serverSide: true,
            ajax: {
                url: '{{ route('datatables.recruitments') }}',
                type: 'POST',
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'avatar', name: 'avatar' },
                { data: 'rank', name: 'rank' },
                { data: 'lname', name: 'lname' },
                { data: 'fname', name: 'fname' },
                { data: 'age', name: 'age' },
                { data: 'contact', name: 'contact' },
                { data: 'last_vessel', name: 'last_vessel'},
                { data: 'created_at', name: 'created_at'},
                { data: 'actions', name: 'actions' },
            ],
            columnDefs: [
                {
                    targets: 1,
                    className: "w50",
                    render: function(link){
                        return `<img src="${link}" alt="Applicant Photo"/>`;
                    },
                },
                {
                    className: "w150",
                    targets: 8,
                    render: function(date){
                        return moment(date).format('MMM DD, YYYY HH:MM:SS');
                    },
                },
            ],
            drawCallback: function(){
                $('#table tbody').append('<div class="preloader"></div>');
                // MUST NOT BE INTERCHANGED t-i
                tooltip();
                initializeActions();
            },
            order: [ [8, 'desc'] ],
        });

        table.on('draw', () => {
            setTimeout(() => {
                $('.preloader').fadeOut();
            }, 800);
        });

        function initializeActions(){

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
        }
    </script>
@endpush