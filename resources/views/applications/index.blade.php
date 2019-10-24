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
								<th>Status</th>
                                <th>Pic</th>
                                <th>Rank</th>
								<th>Last Name</th>
								<th>First Name</th>
								<th>Age</th>
								<th>Contact</th>
                                <th>Last Vessel</th>
								<th>Remarks</th>
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

        .dt-status b{
            color: red;
        }

        .select2-selection__choice{
            background-color: #f76c6b !important;
        }

        .select2-selection__choice__remove{
            color: black !important;
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
		var table = $('#table').DataTable({
            serverSide: true,
            ajax: {
                url: '{{ route('datatables.applications') }}',
                type: 'POST',
                data: () => {
                    return $('#formFilter').serialize();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'status', name: 'status' },
                { data: 'user.avatar', name: 'user.avatar' },
                { data: 'rank', name: 'rank' },
                { data: 'user.lname', name: 'user.lname' },
                { data: 'user.fname', name: 'user.fname' },
                { data: 'age', name: 'age' },
                { data: 'user.contact', name: 'user.contact' },
                { data: 'last_vessel', name: 'last_vessel' },
                { data: 'remarks', name: 'remarks' },
                { data: 'actions', name: 'actions' },
            ],
            columnDefs: [
                {
                    targets: 1,
                    className: "dt-status",
                    render: function(status, display, row){
                        if(status == "Lined-Up"){
                            status += `<br><b>${row.vessel}</b>`;
                        }

                        return status;
                    },
                },
                {
                    targets: 2,
                    className: "w50",
                    render: function(link){
                        return `<img src="${link}" alt="Applicant Photo"/>`;
                    },
                },
                {
                    targets: 0,
                    render: function(id, display, data){
                        return data.row;
                    },
                },
                {
                    targets: 9,
                    width: 85,
                    render: function(remarks, display, data){
                        remarks = remarks;
                        let selected = "";

                        remarks.forEach(remark => {
                            selected += `
                                <option value="${remark}" selected>${remark}</option>
                            `;
                        });

                        return `
                            <select id="table-select-${data.id}" data-id="${data.id}" multiple>
                                ${selected}
                            </select>
                        `;
                    },
                },
            ],
            drawCallback: function(){
                $('#table tbody').append('<div class="preloader"></div>');
                // MUST NOT BE INTERCHANGED t-i
                $('select').select2({
                    tags: true,
                    class: 'table-select',
                    disabled: {{ !in_array(auth()->user()->role, ['Admin', 'Crewing Manager']) ? 'true' : 'false' }}
                });

                $('[id^=table-select] + .select2-container').css('width', '100%');
                $('[id^=table-select] + .select2-container .select2-selection').css('border', 'none');

                $('[id^=table-select]').on('change', e => {
                    let input = $(e.target);
                    let id = input.data('id');
                    $.ajax({
                        type: "POST",
                        url: "{{ route('applications.updateData') }}",
                        data: {
                            id: id,
                            remarks: JSON.stringify(input.val())
                        },
                    });
                });

                // DISABLE SHOWING OF SELECTION OPTIONS WHEN UNSELECTING
                $("[id^=table-select]").on("select2:unselect", function (evt) {
                  if (!evt.params.originalEvent) {
                    return;
                  }

                  evt.params.originalEvent.stopPropagation();
                });

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
	    	$('[data-original-title="Export"]').on('click', application => {
                swal({
                    title: 'Select Export Type',
                    input: 'select',
                    inputOptions: {
                        Biodata:        'Biodata',
                        WalangLagay:    'Walang Lagay',
                        HistoryCheck:   'History Check',
                    },
                    showCancelButton: true,
                    cancelButtonColor: '#f76c6b'
                }).then(result => {
                    if(result.value){
                        application = $(application.target);
                        if(result.value == 'Biodata'){
                            exportBiodata(application);
                        }
                        else{
                            window.location.href = `{{ route('applications.exportDocument') }}/${application.data('id')}/${result.value}`;
                        }
                    }
                })
	    	});

            $('[data-original-title="Edit Application"]').on('click', application => {
                window.location.href = 'applications/edit/' + $(application.target).data('id');
            });

            $('[data-original-title="Line-Up"]').on('click', application => {
                let id = $(application.target).data('id');
                let status = $(application.target).data('status');
                let aRank, aVessel, aPrincipal;

                if(status == "Lined-Up"){
                    swal({
                        type: 'info',
                        title: 'This crew is already Lined-Up',
                        text: 'Choose action',
                        confirmButtonText: 'Change Line-Up',
                        cancelButtonText: 'Remove Line-Up',
                        showCancelButton: true,
                        cancelButtonColor: '#f76c6b',
                        allowOutsideClick: false,
                    }).then(result => {
                        if(result.dismiss == 'cancel'){
                            swal({
                                type: 'warning',
                                title: 'Confirmation',
                                text: "Are you sure you want to remove the crew's Line-Up?",
                                showCancelButton: true,
                                cancelButtonColor: '#f76c6b',
                                allowOutsideClick: false,
                            }).then(result => {
                                if(result.value){
                                    swal.showLoading();
                                    $.ajax({
                                        url: '{{ route('lineUp.remove') }}',
                                        data: {id: id},
                                        success: result => {
                                            setTimeout(() => {
                                                if(result){
                                                    swal({
                                                        type: 'success',
                                                        title: 'Line-Up successfully removed',
                                                        timer: 800,
                                                        showConfirmButton: false
                                                    }).then(() => {
                                                        table.ajax.reload(null, false);
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
                                            }, 500);
                                        }
                                    })
                                }
                            })
                            return;
                        }
                        else if(result.value){
                            selectRank();
                        }
                    });
                }
                else{
                    selectRank();
                }


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

                    swal('Loading Vessels');
                    swal.showLoading();

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
                                                }).then(() => {
                                                    table.ajax.reload(null, false);
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
                                        }, 500);
                                    }
                                })
                            }
                        });
                    }
                }
            });
	    }

        function exportBiodata(application){
            let type;

            if($(application.target).data('status') == "Lined-Up"){
                window.location.href = 'applications/export/' + $(application.target).data('id');
            }
            else{
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
            }
        }
	</script>
@endpush