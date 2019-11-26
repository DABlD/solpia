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

    {{-- PHOTO VIWER --}}
    <link rel="stylesheet" href="{{ asset('css/photoswipe.css') }}">
    <link rel="stylesheet" href="{{ asset('css/photoswipe-default-skin.css') }}">

	<style>
		#table img{
			width: 60px;
			height: 60px;
		}

		.w50{
			width: 50px !important;
		}

		.w70{
			width: 70px !important;
		}
	</style>
@endpush

@push('before-scripts')
	<script src="{{ asset('js/datatables.js') }}"></script>
	<script src="{{ asset('js/moment.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>

    {{-- PHOTOVIEWER --}}
    <script src="{{ asset('js/photoswipe.js') }}"></script>
    <script src="{{ asset('js/photoswipe-ui-default.js') }}"></script>
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
                { data: 'avatar', name: 'avatar' },
                { data: 'fname', name: 'fname' },
                { data: 'lname', name: 'lname' },
                { data: 'vname', name: 'vname' },
                { data: 'rname', name: 'rname' },
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
                {
                	targets: 7,
                    className: "w70",
                }
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
	    		swal('Exporting');
	    		swal.showLoading();
          		window.location.href = 'applications/exportLineUp/' + $(application.target).data('id') + '/' + '{{ $principal->slug }}';
          		setTimeout(() => {
          			swal.close();
          		}, 5000);
	    	});

	    	$('[data-original-title="View Files"]').on('click', application => {
	    	    let id = $(application.target).data('id');
	    	    swal('Loading Files');
	    	    swal.showLoading('Loading Files');

	    	    $.ajax({
	    	        type: 'POST',
	    	        url: '{{ route('applications.getFiles') }}',
	    	        data:{id: id},
	    	        dataType: 'json',
	    	        success: result => {
	    	            setTimeout(() => {
	    	                showFiles(id, result[1], result[0]);
	    	            }, 500);
	    	        }
	    	    })
	    	});
	    }


	    function showFiles(id, name, files){
	        swal({
	            title: name + "'s Files",
	            showCancelButton: true,
	            cancelButtonColor: '#f76c6b',
	            cancelButtonText: 'Exit',
	            confirmButtonText: 'Upload Files',
	            width: '500px',
	            allowOutsideClick: false,
	            html: `
	                <hr style="margin: 5px 0px 5px 0px;" />
	                <ul class="nav nav-pills" role="tablist">
	                    <li role="presentation" class="active">
	                        <a href=".idFiles" role="tab" data-toggle="pill">ID</a>
	                    </li>
	                    <li role="presentation">
	                        <a href=".certificateFiles" role="tab" data-toggle="pill">Certificate</a>
	                    </li>
	                    <li role="presentation">
	                        <a href=".medicalFiles" role="tab" data-toggle="pill">Medical</a>
	                    </li>
	                    <li role="presentation">
	                        <a href=".principalFiles" role="tab" data-toggle="pill">Principal</a>
	                    </li>
	                    <li role="presentation">
	                        <a href=".evaluationFiles" role="tab" data-toggle="pill">Evaluation</a>
	                    </li>
	                </ul>

	                <!-- Tab panes -->
	                <div class="tab-content">
	                    <div role="tabpanel" class="tab-pane fade in idFiles active"><h3>NO FILES</h3></div>
	                    <div role="tabpanel" class="tab-pane fade certificateFiles"><h3>NO FILES</h3></div>
	                    <div role="tabpanel" class="tab-pane fade medicalFiles"><h3>NO FILES</h3></div>
	                    <div role="tabpanel" class="tab-pane fade principalFiles"><h3>NO FILES</h3></div>
	                    <div role="tabpanel" class="tab-pane fade evaluationFiles"><h3>NO FILES</h3></div>
	                </div>
	            `,
	            onOpen: () => {
	                swal.showLoading();

	                let items = [];
	                let imageFormats = ['JPEG', 'JPG', 'PNG', 'GIF'];
	                let string = [];

	                Object.keys(files).forEach(key => {
	                    string[key] = "<br>";
	                    files[key].forEach((file, index) => {
	                        // GET IMAGE DIMENSIONS
	                        if(imageFormats.includes(file.name.split('.').pop().toUpperCase())){
	                            let img = new Image();
	                            img.onload = () => {
	                                items.push({
	                                    src: `files/${name}/${file.name}`,
	                                    w: img.width,
	                                    h: img.height,
	                                    i: index
	                                });

	                                data = `data-link="files/${name}/${file.name}" data-index="${items.length}"`;

	                                string[key] += `
	                                    <div class="row">
	                                        <div class="col-md-6">
	                                            <h4>${index + 1}.) ${file.name}</h4>
	                                        </div>
	                                        <div class="col-md-6 file-buttons">
	                                            <a class="btn btn-info preview" ${data} target="_blank">
	                                                <span class="fa fa-search" ${data}}></span>
	                                            </a>&nbsp;
	                                            <a class="btn btn-success" href="files/${name}/${file.name}" download>
	                                                <span class="fa fa-download"></span>
	                                            </a>&nbsp;
	                                            <a class="btn btn-danger">
	                                                <span class="fa fa-trash"></span>
	                                            </a>
	                                        </div>
	                                    </div>
	                                `;

	                                if((index + 1) == files[key].length){
	                                    $(`.${key.toLowerCase()}Files`).html(string[key]);

	                                    $('.preview').on('click', e => {
	                                        let file = $(e.target);
	                                        
	                                        if(imageFormats.includes(file.data('link').split('.').pop().toUpperCase())){
	                                            let gallery = new PhotoSwipe($('.pswp')[0], PhotoSwipeUI_Default, items, {index:file.data('index') - 1});
	                                            gallery.init();
	                                        }
	                                    });
	                                }
	                            }
	                            img.src = `files/${name}/${file.name}`;
	                        }
	                        else{
	                            data = `data-link="files/${name}/${file.name}" data-index="${items.length}"`;

	                            string[key] += `
	                                <div class="row">
	                                    <div class="col-md-6">
	                                        <h4>${index + 1}.) ${file.name}</h4>
	                                    </div>
	                                    <div class="col-md-6 file-buttons">
	                                        <a class="btn btn-success" href="files/${name}/${file.name}" download>
	                                            <span class="fa fa-download"></span>
	                                        </a>&nbsp;
	                                        <a class="btn btn-danger">
	                                            <span class="fa fa-trash"></span>
	                                        </a>
	                                    </div>
	                                </div>
	                            `;
	                        }
	                    });

	                    $(`.${key.toLowerCase()}Files`).html(string[key]);
	                });

	                setTimeout(() => {
	                    swal.hideLoading();
	                }, 300);
	            }
	        }).then(result2 => {
	            if(result2.value){
	                uploadFile(id, name, $('[role="presentation"].active [role="tab"]')[0].innerText);
	            }
	        });
	    }
	</script>
@endpush