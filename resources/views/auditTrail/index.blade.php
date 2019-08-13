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
								<th>User</th>
								<th>IP</th>
								<th>Hostname</th>
								<th>Device</th>
                                <th>Browser</th>
								<th>Platform</th>
                                <th>Datetime</th>
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

	<style>
		#table img{
			width: 60px;
			height: 60px;
		}

		.w50{
			width: 60px !important;
		}
	</style>
@endpush

@push('before-scripts')
	<script src="{{ asset('js/datatables.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}"></script>
@endpush

@push('after-scripts')
	<script>
		let table = $('#table').DataTable({
            serverSide: true,
            ajax: {
                url: '{{ route('datatables.auditTrail') }}',
                type: 'POST',
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'user_id', name: 'user_id' },
                { data: 'ip', name: 'ip' },
                { data: 'hostname', name: 'hostname' },
                { data: 'device', name: 'device' },
                { data: 'browser', name: 'browser' },
                { data: 'platform', name: 'platform' },
                { data: 'created_at', name: 'created_at' },
            ],
            columnDefs: [
                {
                    targets: 0,
                    width: "10px"
                },
                {
                    targets: 1,
                    render: function(id, a, row){
                        return id + " " + row.action;
                    },
                },
                {
                    targets: 7,
                    render: function(created_at){
                        return toDate(created_at);
                    },
                },
            ],
            drawCallback: function(){
                $('#table tbody').append('<div class="preloader"></div>');
                // MUST NOT BE INTERCHANGED t-i
                tooltip();
            	initializeActions();
            },
            order: [ [0, 'desc'] ],
        });

        table.on('draw', () => {
        	setTimeout(() => {
        		$('.preloader').fadeOut();
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
	    }
	</script>
@endpush