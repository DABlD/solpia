function getChecklist(fleet){
	if(fleet == "FLEET A"){

	}
	else if(fleet == "FLEET B"){
		return `
			<option value="hms_con_kor">HMS - CONTAINER - KOREAN FLAG</option>
			<option value="hms_con_mal">HMS - CONTAINER - MALTA FLAG</option>
			<option value="hms_con_mar">HMS - CONTAINER - MARSHALL FLAG</option>
			<option value="hms_con_pan">HMS - CONTAINER - PANAMA FLAG</option>
			<option value="kos_bul_mar">KOSCO - BULK - MARSHALL</option>
			<option value="kos_bul_lib">KOSCO - BULK - LIBERIA</option>
			<option value="kos_cb_lib">KOSCO - CONTAINER & BULK - PANAMA</option>
		`;
	}
	else if(fleet == "FLEET C"){
		
	}
	else if(fleet == "FLEET D"){
		
	}
	else if(fleet == "FLEET E"){
		return `
			<option value="default">Default</option>
		`;
	}
	else if(fleet == "TOEI"){
		
	}
	else if(fleet == "FISHING"){
		
	}
}