function toDate(timetamp){
	return moment(timetamp).format('MMM. DD, YYYY');
}

function toDateTime(timestamp){
	return moment(timestamp).format('MMM. DD, YYYY h:mm A');	
}