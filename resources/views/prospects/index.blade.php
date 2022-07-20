@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					@include('prospects.includes.toolbar')
				</div>

                <div class="table-responsive">
    				<div class="box-body">
    					<table class="table table-hover table-bordered" id="table" style="width: 100%;">
    						<thead>
    							<tr>
    								<th>#</th>
    								<th>Name</th>
                                    <th>Age</th>
    								<th>Contact</th>
                                    <th>Rank</th>
    								<th>NOC</th>
    								<th>Exp</th>
    								<th>USV</th>
                                    {{-- <th>Last Disembark</th>
                                    <th>Location</th>
                                    <th>Availability</th> --}}
                                    <th>Actions</th>
    							</tr>
    						</thead>
    					</table>
    				</div>
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
    <link rel="stylesheet" href="{{ asset('css/flatpickr.css') }}">
@endpush

@push('before-scripts')
	<script src="{{ asset('js/datatables.js') }}"></script>
	<script src="{{ asset('js/moment.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/checklist.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>
@endpush

@push('after-scripts')
	<script>
        swal({
            title: 'Loading',
            timer: 1500
        });
        swal.showLoading();
		var table = $('#table').DataTable({
            serverSide: true,
            pageLength: 20,
            ajax: {
                url: "{{ route('datatables.prospects') }}",
                type: "POST",
                dataType: "json",
                // dataSrc: "",
                data: {
                    table: 'prospect',
                    select: "*",
                }
            },
            columns: [
                { data: 'id'},
                { data: 'name'},
                { data: 'age'},
                { data: 'contact' },
                { data: 'rank' },
                { data: 'contracts' },
                { data: 'exp' },
                { data: 'usv' },
                // { data: 'last_disembark' },
                // { data: 'location' },
                // { data: 'availability' },
                { data: 'actions'}
            ],
            columnDefs: [
                {
                    targets: 6,
                    render: exp =>{
                        try{
                            let temp = "";
                            exp.forEach(xp => {
                                temp += "/" + xp;
                            });

                            return temp ? temp.substring(1) : "";
                        }
                        catch(e){
                            return exp;
                        };
                    }
                }
            ],
            drawCallback: function(){
                $('#table tbody').append('<div class="preloader"></div>');
                // MUST NOT BE INTERCHANGED t-i
                tooltip();
            	// initializeActions();
            },
            order: [ [0, 'desc'] ],
        });
        
        $('#table_filter input').unbind();
        $('#table_filter input').bind('keyup.DT', e => {
            if(e.which == 13){
                swal('Searching...');
                swal.showLoading();

                table.search($(e.target).val()).draw();
            }
        });

        table.on('draw', () => {
        	setTimeout(() => {
                $('th.sorting:nth-child(9)').css("width", "60px");
        		$('.preloader').fadeOut();
                if(swal.isVisible()){
                    swal.close();
                }
        	}, 800);
        });

        function create(){
            swal({
                html: `
                    ${input("name", "Name", null, 2,10)}
                    ${input("birthday", "Birthday", null, 2,10)}
                    ${input("age", "Age", null, 2,10, 'number')}
                    ${input("contact", "Contact", null, 2,10)}
                    ${input("email", "Email", null, 2,10, 'email')}
                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Rank
                        </div>
                        <div class="col-md-10 iInput">
                            <select name="rank" class="form-control">
                                <option value=""></option>
                            </select>
                        </div>
                    </div></br>
                    ${input("contracts", "NOC in Rank", null, 2,10, 'number')}
                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Vessel Exp
                        </div>
                        <div class="col-md-10 iInput">
                            <div class="col-md-3 iInput">
                                ${checkbox("exp", "Bulk")}
                                ${checkbox("exp", "Log Bulk")}
                                ${checkbox("exp", "Container")}
                                ${checkbox("exp", "Gen Cargo")}
                                ${checkbox("exp", "PCC")}
                                ${checkbox("exp", "Woodchip")}
                                ${checkbox("exp", "VLOC")}
                                ${checkbox("exp", "MPV")}
                                ${checkbox("exp", "Cement Carrier")}
                            </div>
                            <div class="col-md-3 iInput">
                                ${checkbox("exp", "Oil Chem")}
                                ${checkbox("exp", "Product")}
                                ${checkbox("exp", "VLCC")}
                                ${checkbox("exp", "LNG")}
                                ${checkbox("exp", "LPG")}
                            </div>
                            <div class="col-md-3 iInput">
                                ${checkbox("exp", "Purse Seiner")}
                                ${checkbox("exp", "Long Line")}
                                ${checkbox("exp", "Trawl")}
                                ${checkbox("exp", "Squid Jigger")}
                            </div>
                            <div class="col-md-3 iInput">
                                ${checkbox("exp", "Offshore")}
                                ${checkbox("exp", "Livestock")}
                                ${checkbox("exp", "Roro")}
                            </div>
                        </div>
                    </div></br>
                    ${input("availability", "Availability", null, 2,10)}
                    ${input("last_disembark", "Last Disembark", null, 2,10)}
                    ${input("location", "Location", null, 2,10)}
                    ${input("previous_salary", "Previous Salary", null, 2,10, 'number')}
                    ${input("usv", "US Visa", null, 2,10)}
                `,
                width: '650px',
                confirmButtonText: 'Add',
                showCancelButton: true,
                cancelButtonColor: errorColor,
                cancelButtonText: 'Cancel',
                onOpen: () => {
                    $('.iInput .iInput').css('text-align', 'left');
                    ranks = ['MSTR','C/O','2/O','3/O','C/E','1AE','2AE','3AE','BSN','AB','OS','GP-OS','A/O','DCDT','OLR1','OLR','WPR','A/E','ECDT','GP-WLDR','FTR','ELECT','T/ELECT','CCK','COOK','2CK','MSM','MBY','UTY','PMN','RMAN','A. RMAN','A. ELEC','DHAND','SMAN','JR. 3AE','JR. 30FF','TR. RMAN','FMAN','DBOY','EBOY','ABD','ABE'];
                    rankString = "";

                    ranks.forEach(rank => {
                        rankString += `
                            <option value="${rank}">${rank}</option>
                        `;
                    });
                    $(`[name="rank"]`).append(rankString);
                    $('[name="rank"]').select2({
                        placeholder: "Select Rank",
                        tags: true
                    });

                    $('[name="rank"]').on("select2:open", () => {
                        $('.select2-dropdown--below').css("z-index", 2000);
                    });

                    $('[name="last_disembark"], [name="birthday"]').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                    });

                    $('[name="birthday"]').on('change', e => {
                        e = $(e.target);
                        $("[name='age']").val(moment().diff(moment(e.val()), "years"));
                    });
                },
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        let bool = true;
                        if($('[name="name"]').val() == "" || $('[name="rank"]').val() == "" || $('[name="contact"]').val() == "" || $('[name="exp"]:checked').val() == undefined){
                            swal.showValidationError('Name, Rank, Contact, and Exp is required');
                        }
                        else{
                            let bool = false;
                            setTimeout(() => {resolve()}, 500);
                        }
                        bool ? setTimeout(() => {resolve()}, 500) : "";
                    });
                },
            }).then(result => {
                if(result.value){
                    swal.showLoading();

                    let exp = [];
                    $('[name="exp"]:checked').each((i, e) => {
                        exp.push(e.value);
                    });
                    
                    $.ajax({
                        url: "{{ route('prospect.store') }}",
                        type: "POST",
                        data: {
                            name: $("[name='name']").val(),
                            birthday: $("[name='birthday']").val(),
                            age: $("[name='age']").val(),
                            contact: $("[name='contact']").val(),
                            email: $("[name='email']").val(),
                            rank: $("[name='rank']").val(),
                            contracts: $("[name='contracts']").val(),
                            availability: $("[name='availability']").val(),
                            last_disembark: $("[name='last_disembark']").val(),
                            location: $("[name='location']").val(),
                            previous_salary: $("[name='previous_salary']").val(),
                            usv: $("[name='usv']").val(),
                            exp: exp,
                        },
                        success: () => {
                            ss("Success");
                            reload();
                        }
                    })
                }
            });
        }

        function view(id){
            $.ajax({
                url: "{{ route('prospect.get') }}",
                data: {
                    select: '*',
                    where: ['id', id],
                },
                success: data => {
                    data = JSON.parse(data)[0];
                    showDetails(data);
                }
            });
        }

        function showDetails(data){
            let exp = data.exp;
            console.log(exp);
            try{
                if(data.exp){
                    exp = JSON.parse(data.exp);
                }
                else{
                    exp = "x";
                }
            }
            catch(e){
                exp = "x";
            }
            console.log(exp);

            swal({
                html: `
                    ${input("id", "", data.id, 2,10, 'hidden')}
                    ${input("name", "Name", data.name, 2,10)}
                    ${input("birthday", "Birthday", data.birthday, 2,10)}
                    ${input("age", "Age", data.age, 2,10, 'number')}
                    ${input("contact", "Contact", data.contact, 2,10)}
                    ${input("email", "Email", data.email, 2,10, 'email')}
                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Rank
                        </div>
                        <div class="col-md-10 iInput">
                            <select name="rank" class="form-control">
                                <option value=""></option>
                            </select>
                        </div>
                    </div></br>
                    ${input("contracts", "NOC in Rank", data.contracts, 2,10, 'number')}
                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Vessel Exp
                        </div>
                        <div class="col-md-10 iInput">
                            <div class="col-md-3 iInput">
                                ${checkbox("exp", "Bulk", exp.includes("Bulk") ? "checked" : "")}
                                ${checkbox("exp", "Log Bulk", exp.includes("Log Bulk") ? "checked" : "")}
                                ${checkbox("exp", "Container", exp.includes("Container") ? "checked" : "")}
                                ${checkbox("exp", "Gen Cargo", exp.includes("Gen Cargo") ? "checked" : "")}
                                ${checkbox("exp", "PCC", exp.includes("PCC") ? "checked" : "")}
                                ${checkbox("exp", "Woodchip", exp.includes("Woodchip") ? "checked" : "")}
                                ${checkbox("exp", "VLOC", exp.includes("VLOC") ? "checked" : "")}
                                ${checkbox("exp", "MPV", exp.includes("MPV") ? "checked" : "")}
                                ${checkbox("exp", "Cement Carrier", exp.includes("Cement Carrier") ? "checked" : "")}
                            </div>
                            <div class="col-md-3 iInput">
                                ${checkbox("exp", "Oil Chem", exp.includes("Oil Chem") ? "checked" : "")}
                                ${checkbox("exp", "Product", exp.includes("Product") ? "checked" : "")}
                                ${checkbox("exp", "VLCC", exp.includes("VLCC") ? "checked" : "")}
                                ${checkbox("exp", "LNG", exp.includes("LNG") ? "checked" : "")}
                                ${checkbox("exp", "LPG", exp.includes("LPG") ? "checked" : "")}
                            </div>
                            <div class="col-md-3 iInput">
                                ${checkbox("exp", "Purse Seiner", exp.includes("Purse Seiner") ? "checked" : "")}
                                ${checkbox("exp", "Long Line", exp.includes("Long Line") ? "checked" : "")}
                                ${checkbox("exp", "Trawl", exp.includes("Trawl") ? "checked" : "")}
                                ${checkbox("exp", "Squid Jigger", exp.includes("Squid Jigger") ? "checked" : "")}
                            </div>
                            <div class="col-md-3 iInput">
                                ${checkbox("exp", "Offshore", exp.includes("Offshore") ? "checked" : "")}
                                ${checkbox("exp", "Livestock", exp.includes("Livestock") ? "checked" : "")}
                                ${checkbox("exp", "Roro", exp.includes("Roro") ? "checked" : "")}
                            </div>
                        </div>
                    </div></br>
                    ${input("availability", "Availability", data.availability, 2,10)}
                    ${input("last_disembark", "Last Disembark", data.last_disembark, 2,10)}
                    ${input("location", "Location", data.location, 2,10)}
                    ${input("previous_salary", "Previous Salary", data.previous_salary, 2,10, 'number')}
                    ${input("usv", "US Visa", data.usv, 2,10)}
                `,
                width: '800px',
                confirmButtonText: 'Update',
                showCancelButton: true,
                cancelButtonColor: errorColor,
                cancelButtonText: 'Cancel',
                onOpen: () => {
                    $('.iInput .iInput').css('text-align', 'left');
                    ranks = ['MSTR','C/O','2/O','3/O','C/E','1AE','2AE','3AE','BSN','AB','OS','GP-OS','A/O','DCDT','OLR1','OLR','WPR','A/E','ECDT','GP-WLDR','FTR','ELECT','T/ELECT','CCK','COOK','2CK','MSM','MBY','UTY','PMN','RMAN','A. RMAN','A. ELEC','DHAND','SMAN','JR. 3AE','JR. 30FF','TR. RMAN','FMAN','DBOY','EBOY','ABD','ABE', data.rank];
                    rankString = "";

                    ranks.forEach(rank => {
                        rankString += `
                            <option value="${rank}">${rank}</option>
                        `;
                    });
                    $(`[name="rank"]`).append(rankString);
                    $('[name="rank"]').select2({
                        placeholder: "Select Rank",
                        tags: true
                    });

                    if(data.rank != ""){
                        $('[name="rank"]').val(data.rank).change();
                    }

                    $('[name="rank"]').on("select2:open", () => {
                        $('.select2-dropdown--below').css("z-index", 2000);
                    });

                    $('[name="last_disembark"], [name="birthday"]').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                    });

                    $('[name="birthday"]').on('change', e => {
                        e = $(e.target);
                        $("[name='age']").val(moment().diff(moment(e.val()), "years"));
                    });
                },
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        let bool = true;
                        if($('[name="name"]').val() == "" || $('[name="rank"]').val() == "" || $('[name="contact"]').val() == "" || $('[name="exp"]:checked').val() == undefined){
                            swal.showValidationError('Name, Rank, Contact, and Exp is required');
                        }
                        else{
                            let bool = false;
                            // Insert ajax validation
                            setTimeout(() => {resolve()}, 500);
                        }
                        bool ? setTimeout(() => {resolve()}, 500) : "";
                    });
                },
            }).then(result => {
                if(result.value){
                    swal.showLoading();

                    let exp = [];
                    $('[name="exp"]:checked').each((i, e) => {
                        exp.push(e.value);
                    });

                    update({
                        url: "{{ route('prospect.update') }}",
                        data: {
                            id: $("[name='id']").val(),
                            name: $("[name='name']").val(),
                            birthday: $("[name='birthday']").val(),
                            age: $("[name='age']").val(),
                            contact: $("[name='contact']").val(),
                            email: $("[name='email']").val(),
                            rank: $("[name='rank']").val(),
                            contracts: $("[name='contracts']").val(),
                            availability: $("[name='availability']").val(),
                            last_disembark: $("[name='last_disembark']").val(),
                            location: $("[name='location']").val(),
                            previous_salary: $("[name='previous_salary']").val(),
                            usv: $("[name='usv']").val(),
                            exp: JSON.stringify(exp),
                        },
                        message: "Success"
                    }, () => {
                        reload();
                    })
                }
            });
        }

        function checkbox(name, value, checked = ""){
            return `
                <input type="checkbox" name="${name}" value="${value}" ${checked}>
                <label for="${name}">${value}</label><br>
            `;
        }
        
        function del(id){
            sc("Confirmation", "Are you sure you want to delete?", result => {
                if(result.value){
                    swal.showLoading();
                    update({
                        url: "{{ route('prospect.delete') }}",
                        data: {id: id},
                        message: "Success"
                    }, () => {
                        reload();
                    })
                }
            });
        }

        function imp(){
            swal({
                title: 'Select File',
                html: `
                    <form id="form" method="POST" action="{{ route('prospect.import') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" class="swal2-file">
                    </form>
                `
            }).then(file => {
                if(file.value){
                    $('#form').submit();
                }
            });
        }
	</script>
@endpush