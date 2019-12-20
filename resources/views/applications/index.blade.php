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
			width: 60px !important;
		}

        .w100{
            width: 75px !important;
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

        .clabel{
            text-align: right;
        }

        .clabel2{
            text-align: right;
        }

        .col-md-7 .select2{
            margin-top: 8px;
        }

        #table .btn{
            margin-bottom: 3px !important;
        }

        .swal2-content .col-md-6 h4{
            text-align: left;
        }

        .file-buttons{
            text-align: right;
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
                { data: 'avatar', name: 'avatar' },
                { data: 'rank', name: 'rank' },
                { data: 'lname', name: 'lname' },
                { data: 'fname', name: 'fname' },
                { data: 'age', name: 'age' },
                { data: 'contact', name: 'contact' },
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
                    targets: 10,
                    className: "w100"
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
                $('#table select').select2({
                    tags: true,
                    class: 'table-select',
                    disabled: {{ !in_array(auth()->user()->role, ['Admin', 'Crewing Manager']) ? 'true' : 'false' }},
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
                            let data = {};
                            if($(application).data('status') != "Lined-Up"){
                                let savedVessels = {};
                                let savedVesselsString = "";

                                swal({
                                    title: 'Enter Details',
                                    html: '',
                                    onOpen: () => {
                                        swal.showLoading();

                                        $.ajax({
                                            url: '{{ route('vessels.getAll') }}',
                                            dataType: 'json',
                                            success: vessels => {
                                                vessels.forEach(vessel => {
                                                    if(savedVessels[vessel.name] == undefined){
                                                        savedVessels[vessel.name] = vessel;
                                                        savedVesselsString += `
                                                            <option value="${vessel.name}">${vessel.name}</option>
                                                        `;
                                                    }
                                                });

                                                $('#swal2-content').html(`
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <h4 class="clabel">Vessel Name</h4>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <select id="vessel" class="swal2-input">
                                                                <option></option>
                                                                ${savedVesselsString}
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <h4 class="clabel">Rank</h4>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <select id="rank" class="swal2-input">
                                                                <option></option>
                                                                @foreach($categories as $category => $ranks)
                                                                    <optgroup label="{{ $category }}"></optgroup>
                                                                    @foreach($ranks as $rank)
                                                                        <option value="{{ $rank->name }}">
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                                            {{ $rank->name }} ({{ $rank->abbr }})
                                                                        </option>
                                                                    @endforeach
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <br>
                                                `);
                                            }
                                        }).then(() => {
                                            $("#vessel").select2({
                                                placeholder: 'Select Vessel'
                                            });

                                            $("#rank").select2({
                                                placeholder: 'Select Rank'
                                            });

                                            $('#vessel, #rank').on('select2:open', () => {
                                                $('.select2-container').css('z-index', 1060);
                                            });

                                            $('#swal2-content').show();
                                            $('.select2-container').css('width', '100%');
                                            swal.hideLoading();
                                        });
                                    },
                                    width: '400px',
                                    showCancelButton: true,
                                    cancelButtonColor: '#f76c6b',
                                }).then(result2 => {
                                    if(result2.value){
                                        data.vessel = $('#vessel').val();
                                        data.rank = $('#rank').val();

                                        window.location.href = `{{ route('applications.exportDocument') }}/${application.data('id')}/${result.value}?` + $.param(data);
                                    }
                                })
                            }
                            else{
                                window.location.href = `{{ route('applications.exportDocument') }}/${application.data('id')}/${result.value}?` + $.param(data);
                            }
                        }
                    }
                })
	    	});

            $('[data-original-title="Edit Application"]').on('click', application => {
                window.location.href = 'applications/edit/' + $(application.target).data('id');
            });

            $('[data-original-title="Go to Principal"]').on('click', application => {
                let e = $(application.target);

                $.ajax({
                    url: `{{ route('applications.goToPrincipal') }}/${$(application.target).data('id')}`,
                    data: {
                        principal: e.data('principal')
                    },
                    success: result => {
                        swal({
                            type: 'success',
                            title: 'success',
                            timer: 800,
                            showConfirmButton: false
                        })
                    }
                })
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
                                        setTimeout(() => {
                                            $('.preview').on('click', e => {
                                                let file = $(e.target);
                                                
                                                if(imageFormats.includes(file.data('link').split('.').pop().toUpperCase())){
                                                    let gallery = new PhotoSwipe($('.pswp')[0], PhotoSwipeUI_Default, items, {index:file.data('index') - 1});

                                                    gallery.init();
                                                }
                                            });
                                        }, (total * 200));
                                    }
                                }
                                img.src = `files/${name}/${file.name}`;
                            }
                            else{
                                data = `data-link="files/${name}/${file.name}" data-index="${items.length}"`;

                                temp[index] = `
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
                        
                        setTimeout(() => {
                            temp.forEach(tempString => {
                                string[key] += tempString;
                            });

                            $(`.${key.toLowerCase()}Files`).html(string[key]);
                            $('.swal2-content .tab-content .first-row').css('text-align', 'left');
                            $('.swal2-content .tab-content .file-buttons').css('text-align', 'right');
                        }, (total * 200));
                    });

                    setTimeout(() => {
                        swal.hideLoading();
                    }, total * 200);
                }
            }).then(result2 => {
                if(result2.value){
                    uploadFile(id, name, $('[role="presentation"].active [role="tab"]')[0].innerText);
                }
            });
        }

        function uploadFile(id, name, type){
            swal({
                title: 'Select Files',
                html: `
                    <form action="{{ route('applications.uploadFiles') }}" enctype="multipart/form-data" method="POST" target="_blank">
                        @csrf
                        <input type="file" name="files[]" multiple id="files" class="swal2-file"/>
                        <input type="hidden" name="name" value="${name}" />
                        <input type="hidden" name="id" value="${id}" />
                        <input type="hidden" name="type" value="${type}" />
                    </form>
                `,
                showCancelButton: true,
                cancelButtonColor: '#f76c6b',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        setTimeout(() => {
                            if(!$('#files').val()){
                                swal.showValidationError('No file Selected');
                            }
                        resolve()}, 500);
                    });
                },
            }).then(result2 => {
                if(result2.value){
                    $('.swal2-content form').submit();

                    swal('Uploading Files');
                    swal.showLoading();

                    // UPDATE TO KNOW IF FORM SUCCESSFULLY SUBMITTED THEN DO THE SUCCESS
                    setTimeout(() => {
                        swal({
                            type: 'success',
                            title: 'File successfully uploaded',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            $(`[data-original-title="View Files"] [data-id="${id}"]`).click();
                        })
                    }, 500);
                }
            });
        }

        function exportBiodata(application){
            let type;

            if(application.data('status') == "Lined-Up"){
                window.location.href = 'applications/export/' + application.data('id');
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
                        window.location.href = 'applications/export/' + application.data('id') + '/' + type;
                    }
                });
            }
        }
	</script>
@endpush