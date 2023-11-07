function getChecklist(fleet){
	if(fleet == "FLEET B"){
		return `
			<optgroup label="HMM"></optgroup>
				<option value="hmm_con_kor">&nbsp;&nbsp;&nbsp;HMM - CONTAINER - KOREAN FLAG</option>
				<option value="hmm_con_mal">&nbsp;&nbsp;&nbsp;HMM - CONTAINER - MALTA FLAG</option>
				<option value="hmm_con_mar">&nbsp;&nbsp;&nbsp;HMM - CONTAINER - MARSHALL FLAG</option>
				<option value="hmm_con_pan">&nbsp;&nbsp;&nbsp;HMM - CONTAINER - PANAMA FLAG</option>
			<optgroup label="KOSCO"></optgroup>
				<option value="kos_bul_mar">&nbsp;&nbsp;&nbsp;KOSCO - BULK - MARSHALL</option>
				<option value="kos_bul_lib">&nbsp;&nbsp;&nbsp;KOSCO - BULK - LIBERIA</option>
				<option value="kos_cb_lib">&nbsp;&nbsp;&nbsp;KOSCO - CONTAINER & BULK - PANAMA</option>
			<optgroup label="POSSM"></optgroup>
				<option value="possm">&nbsp;&nbsp;&nbsp;Default</option>
		`;
	}
	else if(fleet == "FLEET C"){
		return `
			<option value="template"> 		DEFAULT 		 			</option>
		`;
	}
	else if(fleet == "FLEET D"){
		return `
			<option value="template"> 		DEFAULT 		 			</option>
		`;
	}
	else if(fleet == "TOEI"){
		return `
			<option value="template"> 		NSM - DEFAULT 		 			</option>
		`;
	}
	else if(fleet == "FISHING"){
		return `
			<option value="template"> 		NSM - DEFAULT 		 			</option>
		`;
	}
}