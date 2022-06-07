function getChecklist(fleet){
	if(fleet == "FLEET A"){

	}
	else if(fleet == "FLEET B"){
		return `
			<option value="hmm_con_kor">HMM - CONTAINER - KOREAN FLAG</option>
			<option value="hmm_con_mal">HMM - CONTAINER - MALTA FLAG</option>
			<option value="hmm_con_mar">HMM - CONTAINER - MARSHALL FLAG</option>
			<option value="hmm_con_pan">HMM - CONTAINER - PANAMA FLAG</option>
			<option value="kos_bul_mar">KOSCO - BULK - MARSHALL</option>
			<option value="kos_bul_lib">KOSCO - BULK - LIBERIA</option>
			<option value="kos_cb_lib">KOSCO - CONTAINER & BULK - PANAMA</option>
		`;
	}
	else if(fleet == "FLEET C"){

	}
	else if(fleet == "FLEET D"){
		return `
			<option value="nsm_default"> 		NSM - DEFAULT 		 		</option>
			<option value="dlsm_sola_gratia">	DLSM - SOLA GRATIA 			</option>
			<option value="dlsm_kc_hadong">		DLSM - KC HADONG 			</option>
			<option value="hanj_dk_initio"> 	HANJOO - DK INITIO 			</option>
			<option value="hanj_dk_ione"> 		HANJOO - DK IONE 	 		</option>
			<option value="scm_gns_harmony"> 	SC MARINE - GNS HARMONY 	</option>
			<option value="scm_gns_harvest"> 	SC MARINE - GNS HARVEST 	</option>
			<option value="scm_gns_hope"> 		SC MARINE - GNS HOPE  		</option>
		`;
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