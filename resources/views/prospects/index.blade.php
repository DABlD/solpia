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
                                    <th>BMI</th>
    								<th>Contact</th>
                                    <th>Rank</th>
    								<th>NOC</th>
    								<th>Exp</th>
    								<th>USV</th>
                                    {{-- <th>Last Disembark</th>
                                    <th>Location</th>
                                    <th>Availability</th> --}}
                                    <th>Remarks</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    <th>Updated At</th>
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

    <style>
        .select2-selection__choice{
            color: black !important;
        }
    </style>
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
        var fName = "";
        var fMin_age = "";
        var fMax_age = "";
        var fRanks = [];
        var fUsv = "";
        var fExp = [];
        var fBool = false;
        var fRemarks = "";

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
                data: f => {
                    f.table = 'prospect';
                    f.select = "*";
                    f.filters = getFilters();
                }
            },
            columns: [
                { data: 'id'},
                { data: 'name'},
                { data: 'age'},
                { data: 'height'},
                { data: 'contact' },
                { data: 'rank' },
                { data: 'contracts' },
                { data: 'exp' },
                { data: 'usv' },
                // { data: 'last_disembark' },
                // { data: 'location' },
                // { data: 'availability' },
                { data: 'remarks'},
                { data: 'status'},
                { data: 'updated_at'}
                { data: 'actions'},
            ],
            columnDefs: [
                {
                    targets: 7,
                    render: exp =>{
                        try{
                            let temp = "";
                            exp = JSON.parse(exp.replace(/&quot;/g,'"'));
                            exp.forEach(xp => {
                                temp += "/" + xp;
                            });

                            return temp ? temp.substring(1) : "";
                        }
                        catch(e){
                            return exp;
                        };
                    }
                },
                {
                    targets: 3,
                    render: (h,a,row) =>{
                        let height = parseFloat(row.height / 100).toFixed(2);
                        let weight = row.weight;
                        let bmi = null;

                        if(height && weight){
                            bmi = Math.round(weight / (height * height));
                        }

                        return bmi;
                    }
                },
                {
                    targets: 9,
                    width: "20%"
                },
                {
                    targets: 10,
                    width: "200px"
                },
                {
                    targets: 11,
                    render: date => {
                        return toDate(date);
                    }
                }
            ],
            drawCallback: function(){
                $('#table tbody').append('<div class="preloader"></div>');
                // MUST NOT BE INTERCHANGED t-i
                tooltip();
            	// initializeActions();
            },
            // order: [],
            order: [ [12, 'desc'] ]
        });
        
        $('#table_filter input').unbind();
        $('#table_filter input').bind('keyup.DT', e => {
            if(e.which == 13){
                swal('Searching...');
                swal.showLoading();
                fBool = false;
                table.search($(e.target).val()).draw();
            }
        });

        table.on('draw', () => {
        	setTimeout(() => {
                $('th.sorting:nth-child(10)').css("width", "60px");
        		$('.preloader').fadeOut();
                if(swal.isVisible()){
                    swal.close();
                }
        	}, 800);
        });

        function create(){
            swal({
                html: `
                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Source
                        </div>
                        <div class="col-md-10 iInput" style="margin-top: 5px;">
                            <div class="col-md-2 iInput">
                                ${radio("source", "Kalaw")}
                            </div>
                            <div class="col-md-2 iInput">
                                ${radio("source", "Online")}
                            </div>
                            <div class="col-md-2 iInput">
                                ${radio("source", "Walk-in")}
                            </div>
                        </div>
                    </div></br>

                    ${input("name", "Name", null, 2,10)}
                    ${input("birthday", "Birthday", null, 2,10)}
                    ${input("age", "Age", null, 2,10, 'number')}

                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Height (cm)
                        </div>
                        <div class="col-md-2 iInput">
                            <input type="number" name="height" class="form-control">
                        </div>
                        <div class="col-md-2 iLabel">
                            Weight (kg)
                        </div>
                        <div class="col-md-2 iInput">
                            <input type="number" name="weight" class="form-control">
                        </div>
                        <div class="col-md-2 iLabel">
                            BMI
                        </div>
                        <div class="col-md-2 iInput">
                            <input type="number" name="bmi" class="form-control" disabled>
                        </div>
                    </div>
                    </br>

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
                                ${checkbox("exp", "Passenger")}
                                ${checkbox("exp", "Cruise")}
                                ${checkbox("exp", "Offshore")}
                                ${checkbox("exp", "Livestock")}
                                ${checkbox("exp", "Roro")}
                                ${checkbox("exp", "Domestic")}
                            </div>
                        </div>
                    </div></br>
                    ${input("availability", "Availability", null, 2,10)}
                    ${input("last_disembark", "Last Disembark", null, 2,10)}
                    ${input("location", "Location", null, 2,10)}
                    ${input("previous_salary", "Previous Salary", null, 2,10)}
                    ${input("usv", "US Visa", null, 2,10)}
                    ${input("remarks", "Remarks", null, 2,10)}
                `,
                width: '800px',
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

                    $('[name="last_disembark"], [name="birthday"], [name="availability"], [name="usv"]').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                    });

                    $('[name="birthday"]').on('change', e => {
                        e = $(e.target);
                        $("[name='age']").val(moment().diff(moment(e.val()), "years"));
                    });

                    $('[name="height"], [name="weight"]').on('keyup', e => {
                        let height = parseFloat($('[name="height"]').val() / 100).toFixed(2);
                        let weight = $('[name="weight"]').val();
                        let bmi = Math.round(weight / (height * height));

                        $("[name='bmi']").val(bmi);
                    });
                },
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        let bool = true;
                        if($('[name="name"]').val() == "" || $('[name="rank"]').val() == "" || $('[name="contact"]').val() == ""){
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
                            height: $("[name='height']").val(),
                            weight: $("[name='weight']").val(),
                            contact: $("[name='contact']").val(),
                            email: $("[name='email']").val(),
                            rank: $("[name='rank']").val(),
                            contracts: $("[name='contracts']").val(),
                            availability: $("[name='availability']").val(),
                            last_disembark: $("[name='last_disembark']").val(),
                            location: $("[name='location']").val(),
                            previous_salary: $("[name='previous_salary']").val(),
                            usv: $("[name='usv']").val(),
                            remarks: $("[name='remarks']").val(),
                            exp: exp,
                            source: $('[name="source"]:checked').val()
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
            try{
                if(data.exp){
                    exp = JSON.parse(data.exp);
                }
                else{
                    exp = "x";
                }
            }
            catch(e){
                exp = data.exp;
            }

            swal({
                html: `
                    ${input("id", "", data.id, 2,10, 'hidden')}
                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Source
                        </div>
                        <div class="col-md-10 iInput" style="margin-top: 5px;">
                            <div class="col-md-2 iInput">
                                ${radio("source", "Kalaw")}
                            </div>
                            <div class="col-md-2 iInput">
                                ${radio("source", "Online")}
                            </div>
                            <div class="col-md-2 iInput">
                                ${radio("source", "Walk-in")}
                            </div>
                        </div>
                    </div></br>
                    ${input("name", "Name", data.name, 2,10)}
                    ${input("birthday", "Birthday", data.birthday, 2,10)}
                    ${input("age", "Age", data.age, 2,10, 'number')}

                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Height
                        </div>
                        <div class="col-md-2 iInput">
                            <input type="number" name="height" placeholder="Enter Height (cm)" class="form-control" value="${data.height}">
                        </div>
                        <div class="col-md-2 iLabel">
                            Weight
                        </div>
                        <div class="col-md-2 iInput">
                            <input type="number" name="weight" placeholder="Enter Weight (kg)" class="form-control" value="${data.weight}">
                        </div>
                        <div class="col-md-2 iLabel">
                            BMI
                        </div>
                        <div class="col-md-2 iInput">
                            <input type="number" name="bmi" class="form-control" disabled>
                        </div>
                    </div>
                    </br>

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
                                ${checkbox("exp", "Passenger", exp.includes("Offshore") ? "checked" : "")}
                                ${checkbox("exp", "Cruise", exp.includes("Livestock") ? "checked" : "")}
                                ${checkbox("exp", "Offshore", exp.includes("Offshore") ? "checked" : "")}
                                ${checkbox("exp", "Livestock", exp.includes("Livestock") ? "checked" : "")}
                                ${checkbox("exp", "Roro", exp.includes("Roro") ? "checked" : "")}
                                ${checkbox("exp", "Domestic", exp.includes("Domestic") ? "checked" : "")}
                            </div>
                        </div>
                    </div></br>
                    ${input("availability", "Availability", data.availability, 2,10)}
                    ${input("last_disembark", "Last Disembark", data.last_disembark, 2,10)}
                    ${input("location", "Location", data.location, 2,10)}
                    ${input("previous_salary", "Previous Salary", data.previous_salary, 2,10)}
                    ${input("usv", "US Visa", data.usv, 2,10)}
                    ${input("remarks", "Remarks", data.remarks, 2,10)}
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

                    $('[name="last_disembark"], [name="birthday"], [name="availability"], [name="usv"]').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                    });

                    $('[name="birthday"]').on('change', e => {
                        e = $(e.target);
                        $("[name='age']").val(moment().diff(moment(e.val()), "years"));
                    });

                    $('[name="height"], [name="weight"]').on('keyup', e => {
                        let height = parseFloat($('[name="height"]').val() / 100).toFixed(2);
                        let weight = $('[name="weight"]').val();
                        let bmi = Math.round(weight / (height * height));

                        $("[name='bmi']").val(bmi);
                    });

                    if($('[name="height"]').val() != "" && $('[name="weight"]').val() != ""){
                        let height = parseFloat($('[name="height"]').val() / 100).toFixed(2);
                        let weight = $('[name="weight"]').val();
                        let bmi = Math.round(weight / (height * height));

                        $("[name='bmi']").val(bmi);
                    }

                    if(data.source){
                        $(`[name="source"][value="${data.source}"]`).click();
                    }
                },
                preConfirm: () => {
                    swal.showLoading();
                    return new Promise(resolve => {
                        let bool = true;
                        if($('[name="name"]').val() == "" || $('[name="rank"]').val() == "" || $('[name="contact"]').val() == ""){
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
                            height: $("[name='height']").val(),
                            weight: $("[name='weight']").val(),
                            contact: $("[name='contact']").val(),
                            email: $("[name='email']").val(),
                            rank: $("[name='rank']").val(),
                            contracts: $("[name='contracts']").val(),
                            availability: $("[name='availability']").val(),
                            last_disembark: $("[name='last_disembark']").val(),
                            location: $("[name='location']").val(),
                            previous_salary: $("[name='previous_salary']").val(),
                            usv: $("[name='usv']").val(),
                            remarks: $("[name='remarks']").val(),
                            exp: JSON.stringify(exp),
                            source: $('[name="source"]:checked').val()
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

        function radio(name, value, checked = ""){
            return `
                <input type="radio" name="${name}" value="${value}" ${checked}>
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
            // <option value="ProspectsImport">Recruiting</option>
            // <option value="ProspectsImport3">Prospect</option>
            // <option value="ProspectsImport5">Kalaw</option>
            // <option value="ProspectsImport6">Endorsed</option>
            swal({
                title: 'Select File',
                html: `
                    <form id="form" method="POST" action="{{ route('prospect.import') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" class="swal2-file">
                        <select name="import" class="form-control">
                            <option value="ProspectsImport2">Responses</option>
                            <option value="ProspectsImport4">Applicant Log</option>
                            <option value="ProspectsImport3">Applicant Log 2</option>
                        </select>
                    </form>
                `
            }).then(file => {
                if(file.value){
                    $('#form').submit();
                }
            });
        }

        function file(id, e){
            let file = e.dataset.file;
            let html = "No uploaded file yet";

            if(file){
                html = `
                    <a class="btn btn-success" onclick="viewFile('${file}', ${id})">
                        <span class="fa fa-search fa-xs">
                            View
                        </span>
                    </a>
                `;
            }

            swal({
                title: 'Crew Application Form',
                html: html,
                confirmButtonText: "Upload Form",
                showCancelButton: true,
                cancelButtonColor: errorColor,
                cancelButtonText: "Close"
            }).then(result => {
                if(result.value){
                    swal({
                        title: "Upload Form",
                        html: `
                            <form action="{{ route('prospect.uploadFile') }}" enctype="multipart/form-data" method="POST" target="_blank">
                                @csrf
                                <input type="hidden" name="id" value="${id}">
                                <input type="file" name="files" id="file" class="swal2-file"/>
                            </form>
                        `,
                        showCancelButton: true,
                        cancelButtonColor: errorColor,
                        cancelButtonText: "Cancel",
                        preConfirm: () => {
                            swal.showLoading();
                            return new Promise(resolve => {
                                setTimeout(() => {
                                    if(!$('#file').val()){
                                        swal.showValidationError('No file Selected');
                                    }
                                resolve()}, 500);
                            });
                        },
                    }).then(result2 => {
                        if(result2.value){
                            $('.swal2-content form').submit();

                            swal('Uploading File');
                            swal.showLoading();

                            // UPDATE TO KNOW IF FORM SUCCESSFULLY SUBMITTED THEN DO THE SUCCESS
                            setTimeout(() => {
                                swal({
                                    type: 'success',
                                    title: 'File successfully uploaded',
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                            }, 1000);
                        }
                    })
                }
            });
        }

        function viewFile(file, id){
            window.open(`prospectForms/${id}/${file}`);
        }

        function report(){
            swal({
                title: "Select Range",
                html: `
                    ${input("from", "From", moment().subtract(7, 'days').format("YYYY-MM-DD"), 3,9)}
                    ${input("to", "To", moment().format("YYYY-MM-DD"), 3,9)}
                `,
                onOpen: () => {
                    $('[name="from"], [name="to"]').flatpickr({
                        altInput: true,
                        altFormat: 'F j, Y',
                        dateFormat: 'Y-m-d',
                    });
                }
            }).then(result => {
                if(result.value){
                    let from = $('[name="from"]').val();
                    let to = $('[name="to"]').val();
                    window.location.href = `{{ route('prospect.report') }}/${from}/${to}`;
                }
            })
        }

        function filter(){
            swal({
                width: "650px",
                confirmButtonText: 'Apply Filter',
                showCancelButton: true,
                cancelButtonColor: errorColor,
                cancelButtonText: 'Reset Filter',
                showCloseButton: true,
                html:`
                    <br>
                    ${input("name", "Name", $('[type="search"]').val(), 2,10)}
                    <div class="row iRow">
                        <div class="col-md-6">
                            ${input("min_age", "Min Age", fMin_age, 4,8, 'number', 'min="20" max="60"')}
                        </div>
                        <div class="col-md-6">
                            ${input("max_age", "Max Age", fMax_age, 5,7, 'number', 'min="20" max="60"')}
                        </div>
                    </div>

                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Ranks
                        </div>
                        <div class="col-md-10 iInput">
                            <select name="ranks" class="form-control" data-placeholder="Select Ranks">
                            </select>
                        </div>
                    </div></br>

                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            Vessel Exp
                        </div>
                        <div class="col-md-10 iInput">
                            <div class="col-md-3 iInput">
                                ${checkbox("exp", "Bulk", fExp.includes("Bulk") ? "checked" : "")}
                                ${checkbox("exp", "Log Bulk", fExp.includes("Log Bulk") ? "checked" : "")}
                                ${checkbox("exp", "Container", fExp.includes("Container") ? "checked" : "")}
                                ${checkbox("exp", "Gen Cargo", fExp.includes("Gen Cargo") ? "checked" : "")}
                                ${checkbox("exp", "PCC", fExp.includes("PCC") ? "checked" : "")}
                                ${checkbox("exp", "Woodchip", fExp.includes("Woodchip") ? "checked" : "")}
                                ${checkbox("exp", "VLOC", fExp.includes("VLOC") ? "checked" : "")}
                                ${checkbox("exp", "MPV", fExp.includes("MPV") ? "checked" : "")}
                                ${checkbox("exp", "Cement Carrier", fExp.includes("Cement Carrier") ? "checked" : "")}
                            </div>
                            <div class="col-md-3 iInput">
                                ${checkbox("exp", "Oil Chem", fExp.includes("Oil Chem") ? "checked" : "")}
                                ${checkbox("exp", "Product", fExp.includes("Product") ? "checked" : "")}
                                ${checkbox("exp", "VLCC", fExp.includes("VLCC") ? "checked" : "")}
                                ${checkbox("exp", "LNG", fExp.includes("LNG") ? "checked" : "")}
                                ${checkbox("exp", "LPG", fExp.includes("LPG") ? "checked" : "")}
                            </div>
                            <div class="col-md-3 iInput">
                                ${checkbox("exp", "Purse Seiner", fExp.includes("Purse Seiner") ? "checked" : "")}
                                ${checkbox("exp", "Long Line", fExp.includes("Long Line") ? "checked" : "")}
                                ${checkbox("exp", "Trawl", fExp.includes("Trawl") ? "checked" : "")}
                                ${checkbox("exp", "Squid Jigger", fExp.includes("Squid Jigger") ? "checked" : "")}
                            </div>
                            <div class="col-md-3 iInput">
                                ${checkbox("exp", "Passenger", fExp.includes("Passenger") ? "checked" : "")}
                                ${checkbox("exp", "Cruise", fExp.includes("Cruise") ? "checked" : "")}
                                ${checkbox("exp", "Offshore", fExp.includes("Offshore") ? "checked" : "")}
                                ${checkbox("exp", "Livestock", fExp.includes("Livestock") ? "checked" : "")}
                                ${checkbox("exp", "Roro", fExp.includes("Roro") ? "checked" : "")}
                            </div>
                        </div>
                    </div></br>

                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                        </div>
                        <div class="col-md-10 iInput">
                            <select name="other_exp" class="form-control" data-placeholder="Other Vessel Types">
                            </select>
                        </div>
                    </div></br>

                    ${input("remarks", "Remarks", fRemarks, 2,10)}

                    <div class="row iRow">
                        <div class="col-md-2 iLabel">
                            US VISA
                        </div>
                        <div class="col-md-10 iInput">
                            <div class="col-md-12 iInput">
                                ${checkbox("usv", "REQUIRED")}
                            </div>
                        </div>
                    </div></br>

                `,
                onOpen: () => {
                    $('.iInput .iInput').css('text-align', 'left');

                    let temp = [];
                    fExp.forEach(exp => {
                        let temp2 = $(`[name="exp"][value="${exp}"]`);
                        if(!temp2.length){
                            temp.push(exp);
                            $(`[name="other_exp"]`).append(`
                                <option value="${exp}">${exp}</option>
                            `);
                        }
                    });

                    $('[name="other_exp"]').select2({
                        tags: true,
                        multiple: true,
                        closeOnSelect: false,
                        scrollAfterSelect: false,
                    })
                    .on('select2:selecting', e => {
                        $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop());
                    })
                    .on('select2:select', e => {
                        $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop'));
                        $('.select2-search__field').val("");
                        $('.select2-container--open .select2-search__field').click();
                    });
                    $('[name="other_exp"]').val(temp).trigger("change");

                    if(fUsv){
                        $(`[name="usv"]`).click();
                    }

                    $.ajax({
                        url: "{{ route('rank.get') }}",
                        data: {
                            select: "abbr",
                        },
                        success: result => {
                            result = JSON.parse(result);
                            ranks = [];
                            rankString = "";

                            result.forEach(rank => {
                                ranks.push(rank.abbr);
                                rankString += `
                                    <option value="${rank.abbr}">${rank.abbr}</option>
                                `;
                            });

                            $.ajax({
                                url: "{{ route('prospect.get') }}",
                                data: {
                                    select: "rank",
                                },
                                success: result => {
                                    result = JSON.parse(result);

                                    result.forEach(rank => {
                                        if(!ranks.includes(rank.rank) && rank.rank != null){
                                            ranks.push(rank.rank);
                                            rankString += `
                                                <option value="${rank.rank}">${rank.rank}</option>
                                            `;
                                        }
                                    });

                                    if(fRanks){
                                        fRanks.forEach(rank => {
                                            if(!ranks.includes(rank)){
                                                rankString += `
                                                    <option value="${rank}">${rank}</option>
                                                `;
                                            }
                                        });
                                    }

                                    $('[name="ranks"]').append(rankString);
                                    $('[name="ranks"]').select2({
                                        tags: true,
                                        multiple: true,
                                        closeOnSelect: false,
                                        scrollAfterSelect: false,
                                    })
                                    .on('select2:selecting', e => {
                                        $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop());
                                    })
                                    .on('select2:select', e => {
                                        $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop'));
                                        $('.select2-search__field').val("");
                                        $('.select2-container--open .select2-search__field').click();
                                    });

                                    $('[name="ranks"]').val(fRanks).trigger("change");
                                }
                            });
                        }
                    });
                }
            }).then(result => {
                if(result.value){
                    fName = $("[name='name']").val();
                    fMin_age = $("[name='min_age']").val();
                    fMax_age = $("[name='max_age']").val();
                    fRanks = $("[name='ranks']").val();
                    fUsv = $("[name='usv']:checked").val();
                    fRemarks = $("[name='remarks']").val();

                    let temp = [];
                    $('[name="exp"]:checked').each((i, e) => {
                        temp.push(e.value);
                    });

                    fExp = temp.concat($('[name="other_exp"]').val());
                    fBool = true;

                    reload();
                    $('[type="search"]').val(fName);
                }
                else if(result.dismiss == "cancel"){                    
                    fName = "";
                    fMin_age = 20;
                    fMax_age = 65;
                    fRanks = [];
                    fUsv = "";
                    fExp = [];
                    fBool = false;
                    fRemarks = "";
                    
                    filter();
                }
            });
        }

        function getFilters(){
            return {
                name: fName,
                min_age: fMin_age,
                max_age: fMax_age,
                ranks: fRanks,
                usv: fUsv,
                exp: fExp,
                remarks: fRemarks,
                bool: fBool
            }
        }
	</script>
@endpush