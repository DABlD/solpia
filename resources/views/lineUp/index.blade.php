@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					{{-- @include('lineUp.includes.toolbar') --}}
				</div>

				<div class="box-body">
					<table class="table table-hover table-bordered" id="table" style="width: 100%;">
						<thead>
							<tr>
								<th>#</th>
								<th>Avatar</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Vessel</th>
								<th>Rank</th>
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
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

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
    <script src="{{ asset('js/select2.min.js') }}"></script>
@endpush

@push('after-scripts')
	<script>
		let table = $('#table').DataTable({
            serverSide: true,
            ajax: {
            	url: '{{ route('datatables.processedApplicant', ['id' => $principal->id]) }}',
            	type: 'POST',
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'user.avatar', name: 'user.avatar' },
                { data: 'user.fname', name: 'user.fname' },
                { data: 'user.lname', name: 'user.lname' },
                { data: 'vessel.name', name: 'vessel.name' },
                { data: 'rank.name', name: 'rank.name' },
                { data: 'status', name: 'status' },
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
	    	$('[data-original-title="Export Application"]').on('click', application => {
	    		swal.showLoading();
          		window.location.href = 'applications/exportLineUp/' + $(application.target).data('id') + '/' + '{{ $principal->slug }}';
          		setTimeout(() => {
          			swal.close();
          		}, 5000);
	    	});
	    }
	</script>
@endpush