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
                url: '{{ route('datatables.applications') }}',
                type: 'POST',
            },
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
                        '' : '',
                        @foreach($principals as $principal)
                            '{{ $principal->slug }}': '{{ $principal->name }}',
                        @endforeach
                    },
                    onOpen: () => {
                        $('.swal2-select').select2({
                            placeholder: 'Select Principal',
                            width: '100%',
                        });

                        $('.swal2-select').on('select2:open', function (e) {
                            $('.select2-dropdown--below').css('z-index', 1060);
                        });
                    }
                }).then(result => {
                    if(result.value){
                        type = result.value;
                        window.location.href = 'applications/export/' + $(application.target).data('id') + '/' + type;
                    }
                });
	    	});

            $('[data-original-title="Line-Up"]').on('click', application => {
                let id = $(application.target).data('id');
                let aRank, aVessel, aPrincipal;

                selectRank();

                function selectRank(){
                    swal({
                        title: 'Select Rank',
                        input: 'select',
                        allowOutsideClick: false,
                        showCancelButton: true,
                        cancelButtonColor: '#f76c6b',
                        onOpen: () => {
                            $('.swal2-select').append(`
                                <option></option>
                                @foreach($categories as $category => $ranks)
                                    <optgroup label="{{ $category }}"></optgroup>
                                    @foreach($ranks as $rank)
                                        <option value="{{ $rank->id }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            {{ $rank->name }} ({{ $rank->abbr }})
                                        </option>
                                    @endforeach
                                @endforeach
                            `);

                            $('.swal2-select').select2({
                                placeholder: 'Select Rank',
                                width: '100%',
                            });

                            $('.swal2-select').on('select2:open', function (e) {
                                $('.select2-dropdown--below').css('z-index', 1060);
                            });
                        },
                    }).then(rank => {
                        if(rank.value){
                            aRank = rank.value;
                            selectPrincipal();
                        }
                    });
                }

                function selectPrincipal(){
                    swal({
                        title: 'Select Principal',
                        input: 'select',
                        inputOptions: {
                            '' : '',
                            @foreach($principals as $principal)
                                '{{ $principal->id }}': '{{ $principal->name }}',
                            @endforeach
                        },
                        allowOutsideClick: false,
                        showCancelButton: true,
                        cancelButtonColor: '#f76c6b',
                        onOpen: () => {
                            $('.swal2-select').select2({
                                placeholder: 'Select Principal',
                                width: '100%',
                            });

                            $('.swal2-select').on('select2:open', function (e) {
                                $('.select2-dropdown--below').css('z-index', 1060);
                            });
                        },
                    }).then(principal => {
                        if(principal.value){
                            aPrincipal = principal.value;
                            selectVessel();
                        }
                    });
                }

                function selectVessel(){
                    let vessels = [];

                    $.ajax({
                        url: '{{ route('vessels.get') }}',
                        data: {id: aPrincipal},
                        dataType: 'json',
                        success: result => {
                            result.forEach(a => {
                                vessels[a.id] = a.name;
                            });

                            setTimeout(() => {
                                showSelectVessel();
                            }, 500);
                        }
                    });

                    function showSelectVessel(){
                        swal({
                            title: 'Select Vessel',
                            input: 'select',
                            inputOptions: {
                                '' : '',
                                ...vessels //merged 2 objects
                            },
                            allowOutsideClick: false,
                            showCancelButton: true,
                            cancelButtonColor: '#f76c6b',
                            onOpen: () => {
                                $('.swal2-select').select2({
                                    placeholder: 'Select Vessel',
                                    width: '100%',
                                });

                                $('.swal2-select').on('select2:open', function (e) {
                                    $('.select2-dropdown--below').css('z-index', 1060);
                                });
                            },
                        }).then(vessel => {
                            if(vessel.value){
                                aVessel = vessel.value;
                                swal.showLoading();

                                $.ajax({
                                    url: '{{ route('applications.lineUp') }}',
                                    data: {
                                        applicant_id: id,
                                        rank_id: aRank,
                                        principal_id: aPrincipal,
                                        vessel_id: aVessel,
                                    },
                                    success: result => {
                                        setTimeout(() => {
                                            if(result){
                                                swal({
                                                    type: 'success',
                                                    title: 'Applicant Successfully Lined-Up to Principal',
                                                    timer: 800,
                                                    showConfirmButton: false
                                                });
                                            }
                                            else{
                                                swal({
                                                    type: 'error',
                                                    title: 'Try Again',
                                                    timer: 800,
                                                    showConfirmButton: false
                                                });
                                            }
                                        }, 1000);
                                    }
                                })
                            }
                        });
                    }
                }
            });
	    }
	</script>
@endpush