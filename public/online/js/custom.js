let errorColor = "#f76c6b";
let successColor = "#28a745";
let dateFormat = "YYYY-MM-DD";
let dateFormat2 = "MMM DD, YYYY";
let dateTimeFormat = "YYYY-MM-DD H:m:s";

function toDate(timetamp){
	return moment(timetamp).format('MMM DD, YYYY');
}

function toDateTime(timestamp){
	return moment(timestamp).format('MMM. DD, YYYY h:mm A');	
}

function ss(title = "", text = ""){
	Swal.fire({
		icon: "success",
		title: title,
		text: text,
		timer: 1000,
		showConfirmButton: false
	});
};

function se(title = "", text = ""){
	Swal.fire({
		icon: "error",
		title: title,
		text: text,
		timer: 1000,
		showConfirmButton: false
	});
};

function sc(title = "", text = "", callback = null){
	Swal.fire({
		icon: "question",
		title: title,
		text: text,
		showCancelButton: true,
		cancelButtonColor: errorColor
	}).then(result => {
		if(typeof callback == "function"){
			callback(result);
		}
	});
};

function input(name, placeholder, value, c1, c2, type = "text", autocomplete=""){
    return `
        <div class="row iRow">
            <div class="col-md-${c1} iLabel">
                ${placeholder}
            </div>
            <div class="col-md-${c2} iInput">
                <input type="${type}" name="${name}" placeholder="Enter ${placeholder}" class="form-control" value="${value ?? ""}" ${autocomplete}>
            </div>
        </div>
    `;
};

function reload(){
	$('#table').DataTable().ajax.reload();
};

function update(data, callback = null){
	$.ajax({
		url: data.url,
		type: "POST",
		data: {
			...data.data,
			_token: $('meta[name="csrf-token"]').attr('content')
		},
		success: () => {
			if(data.message){
				ss(data.message);
			}

			if(typeof callback == "function"){
				callback();
			}
		}
	});
}

function toFloat(value, decimals = 2){
	return parseFloat(value).toFixed(decimals);
}

function dateNow(){
	return moment().format(dateFormat);
}

function dateTimeNow(){
	return moment().format(dateTimeFormat);
}

// CHECK IF ROUTE IS IN GROUP THEN OPEN GROUP
if($('.nav-link.active').parent().parent().has('.nav-treeview')){
	$('.nav-link.active').parent().parent().show();
	$('.nav-link.active').parent().parent().parent().addClass('menu-is-opening menu-open');
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

// REMOVE CLASS OF DATATABLE SEARCH BARS
setTimeout(() => {
	$('[name="table_length"]').removeClass();
	$('#table_filter [type="search"]').removeClass();
}, 500);
