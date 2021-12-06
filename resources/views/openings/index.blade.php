@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					@include('openings.includes.toolbar')
				</div>

				<div class="box-body">
					<table class="table table-hover table-bordered" id="table" style="width: 100%;">
						<thead>
							<tr>
								<th>#</th>
								<th>Rank</th>
								<th>Vessel Type</th>
								<th>Remarks</th>
								<th>Status</th>
                                <th>Added On</th>
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
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

	<style>
		#table img{
			width: 60px;
			height: 60px;
		}

		.w50{
			width: 60px !important;
		}

        .head1{
            background-color: #00a65a !important;
        }

        .clabel{
            margin-top: 20px;
            text-align: right;
        }

        .clabel2{
            margin-top: 5px;
            text-align: right;
        }

        .clabel3{
            text-align: right;
        }

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
    <script src="{{ asset('js/select2.min.js') }}"></script>
@endpush

@push('after-scripts')
	<script>
		let table = $('#table').DataTable({
            serverSide: true,
            ajax: {
                url: '{{ route('datatables.openings') }}',
                type: 'POST',
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'rank', name: 'rank' },
                { data: 'type', name: 'type' },
                { data: 'remarks', name: 'remarks' },
                { data: 'status', name: 'status' },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions' },
            ],
            columnDefs: [
                {
                    targets: 4,
                    render: function(status, type, row){
                        console.log(status);
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
                {
                    targets: 5,
                    render: function(date){
                        return toDate(date);
                    }
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
            $('[data-original-title="Delete"]').on('click', e => {
                swal({
                    title: 'Confirmation',
                    type: 'question',
                    showCancelButton: true,
                    cancelButtonColor: '#f76c6b'
                }).then(result => {
                    if(result.value){
                        let job = $(e.target);
                        
                        $.ajax({
                            url: '{{ route("opening.delete") }}',
                            type: 'POST',
                            data: {id: job.data('id')},
                            success: result => {
                                console.log('Deleting: ' + result);
                                table.ajax.reload(null, false);
                            }
                        });
                    };
                });
            });

            $('[type="checkbox"]').on('click', e => {
                console.log('asd');
                let checkbox = $(e.target);
                let status = checkbox.is(':checked');
                
                $.ajax({
                    url: '{{ route('opening.statusUpdate') }}',
                    data: {
                        column: 'status',
                        value: status ? 1 : 0,
                        id: checkbox.data("id")
                    },
                    success: result => {
                        console.log("Updating: " + result);
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
        }

        $('#addJob').on('click', e => {
            swal({
                title: 'Add Job Detail',
                html: '<br><br>' + `
                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel3">Rank</h4>
                        </div>
                        <div class="col-md-7">
                            <select id="rank" class="swal2-input">
                                <option></option>
                                {!! $options !!}
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel"> Vessel Type</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="type" class="swal2-input" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel"> Engine Type</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="engine_type" class="swal2-input" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel"> Joining Date</h4>
                        </div>
                        <div class="col-md-7">
                            <input type="text" id="joining_date" class="swal2-input" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <h4 class="clabel">Remarks</h4>
                        </div>
                        <div class="col-md-7">
                            <textarea id="remarks" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                onOpen: () => {
                    $('#swal2-title').css({
                        'font-size': '28px',
                        'color': '#00c0ef'
                    });

                    // $('#joining_date').flatpickr()

                    $('#rank').select2({
                        placeholder: 'Select Rank',
                    });

                    $('#rank').on('select2:open', () => {
                        $('.select2-container').css('z-index', 1060);
                    });
                },
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        setTimeout(() => {
                            let a = $('#rank').val();

                            if(a == ""){
                                swal.showValidationError('Rank is required');
                            }
                        resolve()}, 500);
                    });
                },
            }).then(result => {
                if(result.value){
                    $.ajax({
                        url: '{{ route('opening.store') }}',
                        type: 'POST',
                        data: {
                            rank: $('#rank').val(),
                            type: $('#type').val(),
                            remarks: $('#remarks').val(),
                            engine_type: $('#engine_type').val(),
                            joining_date: $('#joining_date').val(),
                        },
                        success: result => {
                            console.log("Storing: " + result);
                            table.ajax.reload(null, false);
                        }
                    })
                }
            });
        });
	</script>
@endpush