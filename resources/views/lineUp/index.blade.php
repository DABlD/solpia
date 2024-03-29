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

    {{-- PHOTO VIEWER --}}
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="pswp__bg"></div>

        <div class="pswp__scroll-wrap">
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>

            <div class="pswp__ui pswp__ui--hidden">

                <div class="pswp__top-bar">

                    <div class="pswp__counter"></div>

                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                    <button class="pswp__button pswp__button--share" title="Share"></button>
                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                          <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                          </div>
                        </div>
                    </div>
                </div>

                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div> 
                </div>

                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                </button>

                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                </button>

                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
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
                },
                {
                    targets: 0,
                    render: function(id, display, data){
                        return data.row;
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
                width: '500px',
                allowOutsideClick: false,
                allowEscapeKey: false,
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

                    let total = 0;

                    Object.keys(files).forEach(key => {
                        string[key] = "<br>";

                        let length = files[key].length;

                        total += length;
                        let temp = [];

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

                                    temp[index] = `
                                        <div class="row">
                                            <div class="col-md-6 first-row">
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
                                        setTimeout(() => {
                                            $('.preview').on('click', e => {
                                                let file = $(e.target);
                                                
                                                if(imageFormats.includes(file.data('link').split('.').pop().toUpperCase())){
                                                    let gallery = new PhotoSwipe($('.pswp')[0], PhotoSwipeUI_Default, items, {index:file.data('index') - 1});

                                                    gallery.init();
                                                }
                                            });
                                        }, (total * 120));
                                    }
                                }
                                img.src = `files/${name}/${file.name}`;
                            }
                            else{
                                data = `data-link="files/${name}/${file.name}" data-index="${items.length}"`;

                                temp[index] = `
                                    <div class="row">
                                        <div class="col-md-6 first-row">
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
						
						setTimeout(() => {
                            temp.forEach(tempString => {
                                string[key] += tempString;
                            });

                        	$(`.${key.toLowerCase()}Files`).html(string[key]);
                            $('.swal2-content .tab-content .first-row').css('text-align', 'left');
                            $('.swal2-content .tab-content .file-buttons').css('text-align', 'right');
						}, (total * 120));
                    });

                    setTimeout(() => {
                        swal.hideLoading();
                    }, total * 120);
                }
            });
        }
	</script>
@endpush