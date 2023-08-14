let errorColor = "#f76c6b";
let successColor = "#28a745";

function toDate(timetamp){
	return moment(timetamp).format('MMM DD, YYYY');
}

function toDateTime(timestamp){
	return moment(timestamp).format('MMM. DD, YYYY h:mm A');	
}

// SWAL

function swalNotification(type, title, text = "", timer = null){
	swal({
		type: type,
		title: title,
		text: text,
		timer: timer ?? 800,
		showConfirmButton: false,
	});
}

function ss(title = "", text = ""){
	swal({
		type: "success",
		title: title,
		text: text,
		timer: 1000,
		showConfirmButton: false
	});
};

function se(title = "", text = ""){
	swal({
		type: "error",
		title: title,
		text: text,
		timer: 1000,
		showConfirmButton: false
	});
};

function sc(title = "", text = "", callback = null){
	swal({
		type: "question",
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
        </br>
    `;
};

function reload(table = "table"){
	$(`#${table}`).DataTable().ajax.reload();
};

function update(data, callback = null){
	$.ajax({
		url: data.url,
		type: "POST",
		data: {
			...data.data,
			// _token: $('meta[name="csrf-token"]').attr('content')
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

function checkbox(name, value, checked = ""){
    return `
        <input type="checkbox" name="${name}" value="${value}" ${checked}>
        <label for="${name}">${value}</label><br>
    `;
}