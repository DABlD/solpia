@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					<div class="pull-right">
						<a href="" class="btn btn-success" data-toggle="tooltip" title="Add User" data-placement="left">
							<span class="fa fa-plus"></span>
						</a>
					</div>
				</div>

				<div class="box-body">
					<table class="table table-hover table-bordered" id="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Role</th>
								<th>Email</th>
								<th>Birthday</th>
								<th>Contact</th>
								<th>Created At</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
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
@endpush

@push('before-scripts')
	<script src="{{ asset('js/datatables.js') }}"></script>
	<script src="{{ asset('js/moment.js') }}"></script>
@endpush

@push('after-scripts')
	<script>
		$('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('datatables.users') }}',
            columns: [
                { data: 'fullname', name: 'fullname' },
                { data: 'role', name: 'role' },
                { data: 'email', name: 'email' },
                { data: 'birthday', name: 'birthday' },
                { data: 'contact', name: 'contact' },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions' },
            ],
            columnDefs: [
                {
                    targets: [3,5],
                    render: function(date){
                        return moment(date).format('MMM DD, YYYY');
                    }
                },
            ],
            // fnDrawCallback: function(){
            //     $('#requestsPreloader').fadeOut();
            // }
            // order: [ [0, 'desc'] ],
        });
	</script>
@endpush