@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					<div class="pull-right">
						<a href="{{ route('users.create') }}" class="btn btn-success" data-toggle="tooltip" title="Add User" data-placement="left">
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
	<script src="{{ asset('js/swal.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}"></script>
@endpush

@push('after-scripts')
	<script>
		let table = $('#table').DataTable({
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
                        return toDate(date);
                    }
                },
            ],
            drawCallback: function(){
                $('#table tbody').append('<div class="preloader"></div>');
            },
            initComplete: () => {
            	initializeActions();
            }
            // order: [ [0, 'desc'] ],
        });

        table.on('draw', () => {
        	setTimeout(() => {
        		$('.preloader').fadeOut();
        	}, 800);
        });

        function initializeActions(){
	    	$('[title="View User"]').on('click', user => {
	    		$.ajax({
	    			url: 'users/get/' + $(user.target).data('id'),
	    			success: user => {
	    				user = JSON.parse(user);
	    				let fields = "";

	    				let names = [
	    					'First Name', 'Middle Name', 'Last Name', 
	    					'Birthday', 'Gender', 'Role',
	    					'Contact', 'Created At'
	    				];

	    				let columns = [
	    					'fname', 'mname', 'lname',
	    					'birthday', 'gender', 'role',
	    					'contact', 'created_at'
	    				];

	    				$.each(Object.keys(user), (index, key) => {
	    					let temp = columns.indexOf(key);
	    					if(temp >= 0){
	    						fields += `
									<div class="row">
										<div class="col-md-3">
											<h5><strong>` + names[temp] + `</strong></h5>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" value="` + user[key]+ `" readonly/>
										</div>
									</div>
									<br id="` + key + `">
								`;
	    					}
	    				});

	    				swal({
	    					title: 'User Details',
	    					width: '50%',
	    					html: `
	    						<br><br>
								<div class="row">
									<div class="col-md-3">
										<img src="` + user.avatar + `" alt="User Avatar" height="120px"/>
									</div>
									<div class="col-md-9">
										` + fields + `
									</div>
								</div>
	    					`,
	    					onBeforeOpen: () => {
	    						// CUSTOM FIELDS
	    						$(`	<div class="row">
										<div class="col-md-3">
											<h5><strong>Address</strong></h5>
										</div>
										<div class="col-md-9">
											<textarea type="text" class="form-control" readonly>`+ user.address +`</textarea>
										</div>
									</div>
									<br id="address">`).insertAfter($('#role'));

	    						$('h5').css('text-align', 'left');

	    						// OPTIONAL
	    						$('textarea').css('resize', 'none');

	    						// MODIFIERS
	    						let birthday = $($('#birthday')[0].previousElementSibling).find('.form-control');
	    						birthday.val(toDate(birthday.val()));

	    						let created_at = $($('#created_at')[0].previousElementSibling).find('.form-control');
	    						created_at.val(toDateTime(created_at.val()));
	    					}
	    				});
	    			}
	    		});
	    	});
        };
	</script>
@endpush