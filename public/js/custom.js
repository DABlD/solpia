function toDate(timetamp){
	return moment(timetamp).format('MMM. DD, YYYY');
}

function toDateTime(timestamp){
	return moment(timestamp).format('MMM. DD, YYYY h:mm A');	
}

// SWAL

function swalNotification(type, title, text = ""){
	swal({
		type: type,
		title: title,
		text: text,
		timer: 800,
		showConfirmButton: false,
	});
}