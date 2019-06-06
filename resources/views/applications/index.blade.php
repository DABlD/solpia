@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					@include('applications.includes.toolbar')
				</div>

				<div class="box-body">
					<table class="table table-hover table-bordered" id="table" style="width: 100%;">
						<thead>
							<tr>
								<th>#</th>
								<th>Avatar</th>
								<th>First Name</th>
								<th>Middle Name</th>
								<th>Last Name</th>
								<th>Age</th>
								<th>Contact</th>
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
	<script src="{{ asset('js/moment.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}"></script>
@endpush

@push('after-scripts')
	<script>
		let table = $('#table').DataTable({
            serverSide: true,
            ajax: '{{ route('datatables.applications') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'user.avatar', name: 'user.avatar' },
                { data: 'user.fname', name: 'user.fname' },
                { data: 'user.mname', name: 'user.mname' },
                { data: 'user.lname', name: 'user.lname' },
                { data: 'age', name: 'age' },
                { data: 'user.contact', name: 'user.contact' },
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
                let type;

                swal({
                    title: 'Select Export Type',
                    input: 'select',
                    inputOptions: {
                        'shinko': 'SHINKO',
                        'kosco': 'KOSCO',
                        'toei': 'TOEI',
                        'smtech': 'SMTECH',
                        'scMarine': 'SC MARINE',
                        'imsco': 'IMSCO',
                        'seyeong': 'SEYEONG',
                        'hajoo': 'HAJOO',
                        'western': 'WESTERN',
                        'klcsm': 'KLCSM',
                        'hlineDintec': 'H-LINE & DINTEC',
                        'hms': 'HMS',
                        'nautica': 'NAUTICA'
                    },
                }).then(result => {
                    if(result.value){
                        type = result.value;
                        window.location.href = 'applications/export/' + $(application.target).data('id') + '/' + type;
                    }
                });

	    	});
	    }
	</script>
@endpush