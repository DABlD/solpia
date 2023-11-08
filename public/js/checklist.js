function getChecklist(fleet){
	if(fleet == "FLEET B"){
		return `
			<option value="template"> 		DEFAULT 		 			</option>
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