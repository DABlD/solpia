function getChecklist(fleet){
	if(fleet == "FLEET A"){
		return `
			<option value="default">Default</option>
		`;
	}
	else if(fleet == "FLEET B"){
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
			<option value="bulk">&nbsp;&nbsp;&nbsp;Bulk</option>
			<option value="tanker">&nbsp;&nbsp;&nbsp;Tanker</option>
		`;
	}
	else if(fleet == "FLEET D"){
		return `
			<option value="nsm_default"> 		NSM - DEFAULT 		 			</option>
			<option value="dlsm_sola_gratia">	DLSM - SOLA GRATIA 				</option>
			<option value="dlsm_kc_hadong_lib">	DLSM - KC HADONG - LIBERIA 		</option>
			<option value="dlsm_kc_hadong_mar">	DLSM - KC HADONG - MARSHALL		</option>
			<option value="hanj_dk_initio"> 	HANJOO - DK INITIO 				</option>
			<option value="hanj_dk_ione"> 		HANJOO - DK IONE 	 			</option>
			<option value="scm_gns_harmony"> 	SC MARINE - GNS HARMONY 		</option>
			<option value="scm_gns_harvest"> 	SC MARINE - GNS HARVEST 		</option>
			<option value="scm_gns_hope"> 		SC MARINE - GNS HOPE  			</option>
		`;
	}
	else if(fleet == "FLEET E"){
		return `
			<optgroup label="KOSCO"></optgroup>
				<option value="kos_bul_mar">&nbsp;&nbsp;&nbsp;KOSCO - BULK - MARSHALL</option>
				<option value="kos_bul_lib">&nbsp;&nbsp;&nbsp;KOSCO - BULK - LIBERIA</option>
				<option value="kos_cb_lib">&nbsp;&nbsp;&nbsp;KOSCO - CONTAINER & BULK - PANAMA</option>
			<optgroup label="POSSM"></optgroup>
				<option value="possm">&nbsp;&nbsp;&nbsp;Default</option>
		`;
	}
	else if(fleet == "TOEI"){
		return `
			<option value="Panama"> TOEI - PANAMA 		 	</option>
			<option value="Marshall Islands"> TOEI - MARSHALL ISLAND 	</option>
			<option value="Liberia"> TOEI - LIBERIA 			</option>
		`;
	}
	else if(fleet == "FISHING"){
		
	}
}