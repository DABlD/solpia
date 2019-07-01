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
								<th>Vessel Name</th>
								<th>Principal</th>
								<th>Flag</th>
								<th>Type</th>
                                <th>Status</th>
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
	<script src="{{ asset('js/custom.js') }}"></script>
@endpush

@push('after-scripts')
	<script>
		let table = $('#table').DataTable({
            serverSide: true,
            ajax: '{{ route('datatables.vessels') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'principal.name', name: 'principal.name' },
                { data: 'flag', name: 'flag' },
                { data: 'type', name: 'type' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions' },
            ],
            columnDefs: [
                {
                    targets: 5,
                    render: function(status){
                        let color = status == "ACTIVE" ? '#00a65a' : '#dd4b39';

                        return `
                            <span class="badge" style="background-color: ${color}">${status}</span>
                        `;
                    }
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
	    }
	</script>
@endpush