@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					@include('users.includes.toolbar')
				</div>

				<div class="box-body">
					<table class="table table-hover table-bordered" id="table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Role</th>
								<th>Fleet</th>
								<th>Email / Username</th>
								<th>Birthday</th>
								<th>Status</th>
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

	<style>
		/* The switch - the box around the slider */
		.switch {
		  position: relative;
		  display: inline-block;
		  width: 60px;
		  height: 34px;
		}

		/* Hide default HTML checkbox */
		.switch input {
		  opacity: 0;
		  width: 0;
		  height: 0;
		}

		/* The slider */
		.slider {
		  position: absolute;
		  cursor: pointer;
		  top: 0;
		  left: 0;
		  right: 0;
		  bottom: 0;
		  background-color: #ccc;
		  -webkit-transition: .4s;
		  transition: .4s;
		}

		.slider:before {
		  position: absolute;
		  content: "";
		  height: 26px;
		  width: 26px;
		  left: 4px;
		  bottom: 4px;
		  background-color: white;
		  -webkit-transition: .4s;
		  transition: .4s;
		}

		input:checked + .slider {
		  background-color: #2196F3;
		}

		input:focus + .slider {
		  box-shadow: 0 0 1px #2196F3;
		}

		input:checked + .slider:before {
		  -webkit-transform: translateX(26px);
		  -ms-transform: translateX(26px);
		  transform: translateX(26px);
		}

		/* Rounded sliders */
		.slider.round {
		  border-radius: 34px;
		}

		.slider.round:before {
		  border-radius: 50%;
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
            	url: '{{ route('datatables.users') }}',
            	type: 'POST',
            },
            columns: [
                { data: 'fullname', name: 'fullname' },
                { data: 'role', name: 'role' },
                { data: 'fleet', name: 'fleet' },
                { data: 'email', name: 'email' },
                { data: 'birthday', name: 'birthday' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions' },
            ],
            columnDefs: [
                {
                    targets: 4,
                    render: function(date){
                        return toDate(date);
                    }
                },
                {
                    targets: 3,
                    render: function(email, type, row){
                        return email + " / " + row.username;
                    }
                },
                {
                    targets: 2,
                    render: function(fleet){
                        return fleet ?? '---';
                    }
                },
                {
                    targets: 5,
                    render: function(status, type, row){
                    	checked = status > 0 ? " checked" : "";
                    	id = ` data-id=${row.id}`;
                    	status = ` data-status=${row.status}`;

						return `
							<label class="switch">
								<input type="checkbox"${id}${status}${checked}>
								<span class="slider round"></span>
							</label>
						`
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
	    	$('[data-original-title="View User"]').on('click', user => {
	    		$.ajax({
	    			url: 'users/get/' + $(user.target).data('id'),
	    			success: user => {
	    				user = JSON.parse(user);
	    				let fields = "";

	    				let names = [
	    					'First Name', 'Middle Name', 'Last Name', 'Username',
	    					'Birthday', 'Gender', 'Role',
	    					'Contact', 'Created At'
	    				];

	    				let columns = [
	    					'fname', 'mname', 'lname', 'username',
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

	    	$('[data-original-title="Edit User"]').on('click', user => {
	    		window.location.href = "users/edit/" + $(user.target).data('id');
	    	});

	    	$('[data-original-title="Delete User"]').on('click', user => {
	    		swal({
	    			type: 'warning',
	    			title: 'Are you sure you want to delete?',
	    			showCancelButton: true,
	    			allowOutsideClick: false,
	    			cancelButtonColor: '#f76c6b',
	    		}).then(choice => {
	    			if(choice.value){
	    				$.ajax({
	    					url: 'users/delete/' + $(user.target).data('id'),
	    					success: result => {
	    						$('#table').DataTable().ajax.reload();

	    						swalNotification(
	    							result? 'success' : 'error',
	    							result? 'Successfully deleted' : 'Try Again',
	    						);
	    					}
	    				});
	    			}
	    		});
	    	});

	    	$('[type="checkbox"]').on('click', e => {
	    		let checkbox = $(e.target);
	    		let status = checkbox.is(':checked');
	    		
	    		$.ajax({
	    			url: '{{ route('users.ajaxUpdate') }}',
	    			data: {
	    				column: 'status',
	    				value: status ? 1 : 0,
	    				id: checkbox.data("id")
	    			},
	    			success: result => {
	    				console.log(result);
	    				if(result == 1){
	    					swal({
	    						type: 'success',
	    						title: 'Successfully updated',
	    						timer: 800,
	    						showConfirmButton: false
	    					});
	    				}
	    				else{
	    					swal({
	    						type: 'error',
	    						title: 'Try again',
	    						text: 'There was a problem updating the user',
	    						timer: 800,
	    						showConfirmButton: false
	    					}).then(() => {
	    						table.ajax.reload();
	    					})
	    				}
	    			}
	    		});
	    	});

            $('[data-original-title="Assign to a Fleet"]').on('click', user => {
                let id = $(user.target).data('id');

                swal({
                    title: 'Select Fleet',
                    input: 'select',
                    inputOptions: {
                        'FLEET A' : 'FLEET A',
                        'FLEET B' : 'FLEET B',
                        'FLEET C' : 'FLEET C',
                        'FLEET D' : 'FLEET D',
                        'FLEET E' : 'FLEET E',
                        'TOEI' : 'TOEI',
                        'FISHING' : 'FISHING',
                    },
                    showCancelButton: true,
                    cancelButtonColor: '#f76c6b'
                }).then(result => {
                    if(result.value){
                        $.ajax({
                            url: '{{ route('users.ajaxUpdate') }}',
                            data: {
                                id: id,
                                column: 'fleet',
                                value: result.value
                            },
                            success: () => {
                                table.ajax.reload(null, false);
                                swal({
                                    type: 'success',
                                    title: 'User Successfully Updated',
                                    timer: 800,
                                    showConfirmButton: false
                                })
                            }
                        })
                    }
                });
            });
        };
	</script>
@endpush