@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					@include('auditTrail.includes.toolbar')
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
                        return row.username + " " + row.action;
                    },
                },
                {
                    targets: 7,
                    render: function(created_at){
                        return toDateTime(created_at);
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
            $('[data-original-title="Export Logs"]').on('click', () => {
                swal({
                    title: 'Do you want to export',
                    type: 'question',
                    showCancelButton: true,
                    cancelButtonColor: '#f76c6b'
                }).then(result => {
                    if(result.value){
                        window.location.href = "{{ route('auditTrail.export') }}";
                    };
                });
            });
        }
	</script>
@endpush