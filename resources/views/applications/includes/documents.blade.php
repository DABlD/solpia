<div id="docu"></div>

@push('before-scripts')
    <script>
	
		$('#docu').append(`
			<u><h3><strong>ID</strong></h3></u>
			<div class="ID"></div>
			<span class="IDCount fd-count">0</span>
			<a class="btn btn-success" onclick="addDocu('ID')">
			    <span class="fa fa-plus"></span>
			    ID
			</a>

			<u><h3><strong>Flag</strong></h3></u>

			{{-- SELECT RANK FOR DOCUMENTS --}}
			<div class="row">
			    <div class="form-group col-md-4">
			        <select class="form-control" id="rank">
			            <option value=""></option>
			            @foreach($categories as $category => $ranks)
			                <optgroup label="{{ $category }}"></optgroup>
			                @foreach($ranks as $rank)
			                    <option value="{{ $rank->id }}">
			                        &nbsp;&nbsp;&nbsp;&nbsp;
			                        {{ $rank->name }} ({{ $rank->abbr }})
			                    </option>
			                @endforeach
			            @endforeach
			        </select>
			    </div>
			</div>

			<div class="Flag"></div>
			<span class="FlagCount fd-count">0</span>
			<a class="btn btn-success" onclick="addDocu('Flag')">
			    <span class="fa fa-plus"></span>
			    Flag
			</a>

			<u><h3><strong>License/Certificates</strong></h3></u>
			<div class="lc"></div>
			<span class="lcCount fd-count">0</span>
			<a class="btn btn-success" onclick="addDocu('lc')">
			    <span class="fa fa-plus"></span>
			    License/Certificates
			</a>

			<u><h3><strong>Medical Certificates</strong></h3></u>
			<div class="MedCert"></div>
			<span class="MedCertCount fd-count">0</span>
			<a class="btn btn-success" onclick="addDocu('MedCert')">
			    <span class="fa fa-plus"></span>
			    Medical Certificates
			</a>

			<u><h3><strong>Medical History</strong></h3></u>
			<div class="Med"></div>
			<span class="MedCount fd-count">0</span>
			<a class="btn btn-success" onclick="addDocu('Med')">
			    <span class="fa fa-plus"></span>
			    Medical History
			</a>
		`);

		let issuerString = `
			<option></option>
			@foreach($issuers as $issuer)
				<option value="{{ $issuer }}">{{ $issuer }}</option>
			@endforeach
		`;

		let regulationString = `
			<option></option>
			@foreach($regulations as $regulation)
				<option value="{{ $regulation }}">{{ $regulation }}</option>
			@endforeach
		`;

        function addDocu(type){
            $(`.${type}Count`)[0].innerText = parseInt($(`.${type}Count`)[0].innerText) + 1;

            let count = $('.docu').length + 1;
            let count2 = $('.docu-country').length + 1;

            let docu_class = 'form-control aeigh';
            let docu_class2 = 'form-control';

            // if($(`.${type}`).length == 0){
            // 	let temp = type == 'lc'? 'License/Certificates/Contracts' : type;
            //     appenddocu(`<div class="${type}"><u><h3><strong>${temp}</strong></h3></u>`);
            // }
            // else{
            //     appenddocu('<div>');
            // }

            let string;

            let dType = "docu-dtype";
            let lcType = "docu-lctype";
            let mcType = "docu-mctype";
            let medType = "docu-medtype";
            let medCase = "docu-case";
            let year = "docu-year";
            let clinic = "docu-clinic";
            let number = 'docu-number';
        	let issue_date = 'docu-issue_date';
        	let expiry_date = 'docu-expiry_date';
        	let with_mv = 'docu-with_mv';

        	let country = "docu-country";

        	let issuer = "docu-issuer";
        	let regulation = "docu-regulation";

        	// CREATE ID OPTIONS
        	var id_options = "";
        	var idOptions = [
        		'', 'PASSPORT', 'US-VISA', "SEAMAN BOOK", 'MCV'
        	];

        	idOptions.forEach(docu => {
        		docu2 = docu == "SEAMAN BOOK" ? "SEAMAN'S BOOK" : docu;
				id_options += `<option value="${docu}">${docu2}</option>`
			});

			//CREATE LC OPTIONS
			var lc_options = "";
			var lcOptions = 
			[

				'', 'NATIONAL LICENSE', 'WATCHKEEPING', 'RADAR SIMULATOR COURSE', 'ARPA TRAINING COURSE', 'SAFETY COURSE, BASIC', 'SAFETY COURSE, SURVIVAL CRAFT', 'SAFETY COURSE, FIRE FIGHTING', 'SAFETY COURSE, FIRST AID', 'SAFETY COURSE, RESCUE BOAT', 'VACCINATION - Y. FEVER', 'DRUG AND ALCOHOL TEST', 'SAFETY OFFICER\'S TRAINING COURSE', 'BRIDGE TEAM/RESOURCE MANAGEMENT', 'ISPS / SSO COURSE / SDSD', 'TANKER COURSE, FAMILIARIZATION', 'TANKER COURSE, ADVANCED - OIL', 'TANKER COURSE, ADVANCED - CHEMICAL', 'TANKER COURSE, ADVANCED - LPG', 'MARPOL 73/78', 'ERS WITH ERM', 'SSBT', 'MLC TRAINING F1', 'MLC TRAINING F2', 'MLC TRAINING F3', 'MLC TRAINING F4', 'OLC TRAINING F1', 'OLC TRAINING F2', 'OLC TRAINING F3', 'POEA CONTRACT', 'MLC/CBA CONTRACT'
			];

        	lcOptions.forEach(docu => {
				lc_options += `<option value="${docu}">${docu}</option>`
			});

			lc_options += `
				<option value="ECDIS">&nbsp;&nbsp;&nbsp;&nbsp;ECDIS</option>
				<optgroup label="ECDIS SPECIFIC"></optgroup>
					<option value="ECDIS FURUNO 2107">&nbsp;&nbsp;&nbsp;&nbsp;ECDIS FURUNO 2107</option>
					<option value="ECDIS FURUNO 3200">&nbsp;&nbsp;&nbsp;&nbsp;ECDIS FURUNO 3200</option>
					<option value="ECDIS FURUNO 3300">&nbsp;&nbsp;&nbsp;&nbsp;ECDIS FURUNO 3300</option>
					<option value="ECDIS JRC 701B">&nbsp;&nbsp;&nbsp;&nbsp;ECDIS JRC 701B</option>
					<option value="ECDIS JRC 7201">&nbsp;&nbsp;&nbsp;&nbsp;ECDIS JRC 7201</option>
					<option value="ECDIS JRC 901B">&nbsp;&nbsp;&nbsp;&nbsp;ECDIS JRC 901B</option>
					<option value="ECDIS JRC 9201">&nbsp;&nbsp;&nbsp;&nbsp;ECDIS JRC 9201</option>
					<option value="ECDIS MARTEK">&nbsp;&nbsp;&nbsp;&nbsp;ECDIS MARTEK</option>
					<option value="ECDIS MECYS">&nbsp;&nbsp;&nbsp;&nbsp;ECDIS MECYS</option>
					<option value="ECDIS TRANSAS">&nbsp;&nbsp;&nbsp;&nbsp;ECDIS TRANSAS</option>
				<optgroup label="SPECIAL CERTIFICATE"></optgroup>
					<option value="ENGLISH TEST">&nbsp;&nbsp;&nbsp;&nbsp;ENGLISH TEST</option>
					<option value="WELDING COURSE">&nbsp;&nbsp;&nbsp;&nbsp;WELDING COURSE</option>
					<option value="CARGO HANDLING">&nbsp;&nbsp;&nbsp;&nbsp;CARGO HANDLING</option>
					<option value="STABILITY AND TRIM">&nbsp;&nbsp;&nbsp;&nbsp;STABILITY AND TRIM</option>
					<option value="COLLISION AVOIDANCE">&nbsp;&nbsp;&nbsp;&nbsp;COLLISION AVOIDANCE</option>
					<option value="AUXILIARY MACHINERY SYSTEM">&nbsp;&nbsp;&nbsp;&nbsp;AUXILIARY MACHINERY SYSTEM</option>
					<option value="CONTROL ENGINEERING">&nbsp;&nbsp;&nbsp;&nbsp;CONTROL ENGINEERING</option>
					<option value="HYDRAULICS/PNEUMATICS">&nbsp;&nbsp;&nbsp;&nbsp;HYDRAULICS/PNEUMATICS</option>
					<option value="MARINE ELECTRO TECH">&nbsp;&nbsp;&nbsp;&nbsp;MARINE ELECTRO TECH</option>
					<option value="ELECTRONIC EQUIPMENT">&nbsp;&nbsp;&nbsp;&nbsp;ELECTRONIC EQUIPMENT</option>
					<option value="MARINE ELECTRICAL">&nbsp;&nbsp;&nbsp;&nbsp;MARINE ELECTRICAL</option>
					<option value="MARINE REFRIGIRATION/AIRCONDITIONING">&nbsp;&nbsp;&nbsp;&nbsp;MARINE REFRIGIRATION/AIRCONDITIONING</option>
					<option value="DANGEROUS FLUID CARGO COURSE">&nbsp;&nbsp;&nbsp;&nbsp;DANGEROUS FLUID CARGO COURSE</option>
					<option value="SHIP HANDLING SIMULATION">&nbsp;&nbsp;&nbsp;&nbsp;SHIP HANDLING SIMULATION</option>
					<option value="POLLUTION PREVENTION COURSE">&nbsp;&nbsp;&nbsp;&nbsp;POLLUTION PREVENTION COURSE</option>
					<option value="RISK ASSESMENT/INCIDENT INVESTIGATION COURSE">&nbsp;&nbsp;&nbsp;&nbsp;RISK ASSESMENT/INCIDENT INVESTIGATION COURSE</option>
					<option value="ADVANCE NAVIGATION">&nbsp;&nbsp;&nbsp;&nbsp;ADVANCE NAVIGATION</option>
					<option value="ADVANCE SHIPBOARD OPERATION AND MGT">&nbsp;&nbsp;&nbsp;&nbsp;ADVANCE SHIPBOARD OPERATION AND MGT</option>
					<option value="SATELLITE COMMUNICATION COURSE">&nbsp;&nbsp;&nbsp;&nbsp;SATELLITE COMMUNICATION COURSE</option>
				<optgroup label="IN HOUSE CERTIFICATE/SPECIAL TRAINING"></optgroup>
					<option value="ANTI PIRACY">&nbsp;&nbsp;&nbsp;&nbsp;ANTI PIRACY</option>
					<option value="IN HOUSE TRAINING CERT WITH ISM">&nbsp;&nbsp;&nbsp;&nbsp;IN HOUSE TRAINING CERT WITH ISM</option>
					<option value="GENERAL TRAINING RECORD BOOK">&nbsp;&nbsp;&nbsp;&nbsp;GENERAL TRAINING RECORD BOOK</option>
					<option value="PDOS">&nbsp;&nbsp;&nbsp;&nbsp;PDOS</option>
			`;

			// 'FLAG STATE SEAMAN BOOK (I.D BOOK)', 'FLAG STATE SEAMAN BOOK (I.D BOOK)', 'FLAG STATE S.Q. FOR TANKERS', 'FLAG STATE LICENSE', 'FLAG STATE SSO LICENSE', 'FLAG STATE ENDORSEMENT COOK COURSE', 'FLAG STATE GMDSS-GOC', 

			// COUNTRIES
			var flag_countries = 
			[

				'Afghanistan (AF)', 'Åland Islands (AX)', 'Albania (AL)', 'Algeria (DZ)', 'American Samoa (AS)', 'Andorra (AD)', 'Angola (AO)', 'Anguilla (AI)', 'Antarctica (AQ)', 'Antigua & Barbuda (AG)', 'Argentina (AR)', 'Armenia (AM)', 'Aruba (AW)', 'Ascension Island (AC)', 'Australia (AU)', 'Austria (AT)', 'Azerbaijan (AZ)', 'Bahamas (BS)', 'Bahrain (BH)', 'Bangladesh (BD)', 'Barbados (BB)', 'Belarus (BY)', 'Belgium (BE)', 'Belize (BZ)', 'Benin (BJ)', 'Bermuda (BM)', 'Bhutan (BT)', 'Bolivia (BO)', 'Bosnia & Herzegovina (BA)', 'Botswana (BW)', 'Brazil (BR)', 'British Indian Ocean Territory (IO)', 'British Virgin Islands (VG)', 'Brunei (BN)', 'Bulgaria (BG)', 'Burkina Faso (BF)', 'Burundi (BI)', 'Cambodia (KH)', 'Cameroon (CM)', 'Canada (CA)', 'Canary Islands (IC)', 'Cape Verde (CV)', 'Caribbean Netherlands (BQ)', 'Cayman Islands (KY)', 'Central African Republic (CF)', 'Ceuta & Melilla (EA)', 'Chad (TD)', 'Chile (CL)', 'China (CN)', 'Christmas Island (CX)', 'Cocos (Keeling) Islands (CC)', 'Colombia (CO)', 'Comoros (KM)', 'Congo - Brazzaville (CG)', 'Congo - Kinshasa (CD)', 'Cook Islands (CK)', 'Costa Rica (CR)', 'Côte d’Ivoire (CI)', 'Croatia (HR)', 'Cuba (CU)', 'Curaçao (CW)', 'Cyprus (CY)', 'Czechia (CZ)', 'Denmark (DK)', 'Diego Garcia (DG)', 'Djibouti (DJ)', 'Dominica (DM)', 'Dominican Republic (DO)', 'Ecuador (EC)', 'Egypt (EG)', 'El Salvador (SV)', 'Equatorial Guinea (GQ)', 'Eritrea (ER)', 'Estonia (EE)', 'Eswatini (SZ)', 'Ethiopia (ET)', 'Falkland Islands (FK)', 'Faroe Islands (FO)', 'Fiji (FJ)', 'Finland (FI)', 'France (FR)', 'French Guiana (GF)', 'French Polynesia (PF)', 'French Southern Territories (TF)', 'Gabon (GA)', 'Gambia (GM)', 'Georgia (GE)', 'Germany (DE)', 'Ghana (GH)', 'Gibraltar (GI)', 'Greece (GR)', 'Greenland (GL)', 'Grenada (GD)', 'Guadeloupe (GP)', 'Guam (GU)', 'Guatemala (GT)', 'Guernsey (GG)', 'Guinea (GN)', 'Guinea-Bissau (GW)', 'Guyana (GY)', 'Haiti (HT)', 'Honduras (HN)', 'Hong Kong SAR China (HK)', 'Hungary (HU)', 'Iceland (IS)', 'India (IN)', 'Indonesia (ID)', 'Iran (IR)', 'Iraq (IQ)', 'Ireland (IE)', 'Isle of Man (IM)', 'Israel (IL)', 'Italy (IT)', 'Jamaica (JM)', 'Japan (JP)', 'Jersey (JE)', 'Jordan (JO)', 'Kazakhstan (KZ)', 'Kenya (KE)', 'Kiribati (KI)', 'Kosovo (XK)', 'Kuwait (KW)', 'Kyrgyzstan (KG)', 'Laos (LA)', 'Latvia (LV)', 'Lebanon (LB)', 'Lesotho (LS)', 'Liberia (LR)', 'Libya (LY)', 'Liechtenstein (LI)', 'Lithuania (LT)', 'Luxembourg (LU)', 'Macao SAR China (MO)', 'Madagascar (MG)', 'Malawi (MW)', 'Maldives (MV)', 'Mali (ML)', 'Malta (MT)', 'Martinique (MQ)', 'Mauritania (MR)', 'Mauritius (MU)', 'Mayotte (YT)', 'Mexico (MX)', 'Micronesia (FM)', 'Moldova (MD)', 'Monaco (MC)', 'Mongolia (MN)', 'Montenegro (ME)', 'Montserrat (MS)', 'Morocco (MA)', 'Mozambique (MZ)', 'Myanmar (Burma) (MM)', 'Namibia (NA)', 'Nauru (NR)', 'Nepal (NP)', 'Netherlands (NL)', 'New Caledonia (NC)', 'New Zealand (NZ)', 'Nicaragua (NI)', 'Niger (NE)', 'Nigeria (NG)', 'Niue (NU)', 'Norfolk Island (NF)', 'North Macedonia (MK)', 'Northern Mariana Islands (MP)', 'Norway (NO)', 'Oman (OM)', 'Pakistan (PK)', 'Palau (PW)', 'Palestinian Territories (PS)', 'Papua New Guinea (PG)', 'Paraguay (PY)', 'Peru (PE)', 'Philippines (PH)', 'Pitcairn Islands (PN)', 'Poland (PL)', 'Portugal (PT)', 'Pseudo-Accents (XA)', 'Pseudo-Bidi (XB)', 'Puerto Rico (PR)', 'Qatar (QA)', 'Réunion (RE)', 'Romania (RO)', 'Russia (RU)', 'Rwanda (RW)', 'Samoa (WS)', 'San Marino (SM)', 'São Tomé & Príncipe (ST)', 'Saudi Arabia (SA)', 'Senegal (SN)', 'Serbia (RS)', 'Seychelles (SC)', 'Sierra Leone (SL)', 'Singapore (SG)', 'Sint Maarten (SX)', 'Slovakia (SK)', 'Slovenia (SI)', 'Solomon Islands (SB)', 'Somalia (SO)', 'South Africa (ZA)', 'South Georgia & South Sandwich Islands (GS)', 'South Sudan (SS)', 'Spain (ES)', 'Sri Lanka (LK)', 'St. Barthélemy (BL)', 'St. Helena (SH)', 'St. Kitts & Nevis (KN)', 'St. Lucia (LC)', 'St. Martin (MF)', 'St. Pierre & Miquelon (PM)', 'St. Vincent & Grenadines (VC)', 'Sudan (SD)', 'Suriname (SR)', 'Svalbard & Jan Mayen (SJ)', 'Sweden (SE)', 'Switzerland (CH)', 'Syria (SY)', 'Taiwan (TW)', 'Tajikistan (TJ)', 'Tanzania (TZ)', 'Thailand (TH)', 'Timor-Leste (TL)', 'Togo (TG)', 'Tokelau (TK)', 'Tonga (TO)', 'Trinidad & Tobago (TT)', 'Tristan da Cunha (TA)', 'Tunisia (TN)', 'Turkey (TR)', 'Turkmenistan (TM)', 'Turks & Caicos Islands (TC)', 'Tuvalu (TV)', 'U.S. Outlying Islands (UM)', 'U.S. Virgin Islands (VI)', 'Uganda (UG)', 'Ukraine (UA)', 'United Arab Emirates (AE)', 'United Kingdom (GB)', 'United States (US)', 'Uruguay (UY)', 'Uzbekistan (UZ)', 'Vanuatu (VU)', 'Vatican City (VA)', 'Venezuela (VE)', 'Vietnam (VN)', 'Wallis & Futuna (WF)', 'Western Sahara (EH)', 'Yemen (YE)', 'Zambia (ZM)', 'Zimbabwe (ZW)'
				];

			var flag_options = `
				<option></option>
				<optgroup label="Suggested"></optgroup>
					<option value="Panama">&nbsp;&nbsp;&nbsp;&nbsp;Panama (PA)</option>
					<option value="Marshall Islands">&nbsp;&nbsp;&nbsp;&nbsp;Marshall Islands (MH)</option>
					<option value="Malaysia">&nbsp;&nbsp;&nbsp;&nbsp;Malaysia (MY)</option>
					<option value="Korea">&nbsp;&nbsp;&nbsp;&nbsp;Korea (KR)</option>
				<optgroup label="Others"></optgroup>
			`;
 
        	flag_countries.forEach(docu => {
        		let value = docu;
        		value = value.split(' ');
        		value.pop();
        		value = value.join(' ');

				flag_options += "<option value='" + value + "'>&nbsp;&nbsp;&nbsp;&nbsp;" + docu + "</option>";
			});

        	// CREATE MED OPTIONS
        	var med_options = "";
        	var medOptions = [
        		'', 'HYPERTENSION', 'DIABETES', "POLYPS", 'GALLSTONE', 'MEASLES', 'CHICKEN POX'
        	];

        	medOptions.forEach(docu => {
				med_options += `<option value="${docu}">${docu}</option>`
			});

        	//<input type="hidden" name="docu-type${count}" value="${type}">
            if(type == "ID"){
            	string = `
            	    <div class="row docu">
						
						<span class="fa fa-times fa-2x" onclick="deleteRow(this, '${type}')"></span>
            	        <div class="form-group col-md-4">
            	            <label for="${dType}${count}">Type</label>
            	            <select class="${docu_class} ${dType}" name="${dType}${count}">
            	            	${id_options}
            	            </select>
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${dType}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-4">
            	            <label for="${issuer}${count}">Issuer</label>
            	            <select class="${docu_class} ${issuer}" name="${issuer}${count}">
            	            	${issuerString}
            	            </select>
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${issuer}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-4">
            	            <label for="${number}${count}">Number</label>
            	            <input type="text" class="${docu_class} ${number}" name="${number}${count}" placeholder="Enter Number">
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${number}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-4">
            	            <label for="${issue_date}${count}">Issue Date</label>
            	            <input type="text" class="${docu_class} ${issue_date}" name="${issue_date}${count}" placeholder="Select Issue Date">
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${issue_date}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-4">
            	            <label for="${expiry_date}${count}">Expiry Date</label>
            	            <input type="text" class="${docu_class} ${expiry_date}" name="${expiry_date}${count}" placeholder="Select Expiry Date">
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${expiry_date}${count}Error"></strong>
            	            </span>
            	        </div>
            	    </div>
            	    <hr>`;
            }
            else if(type == "Flag"){
            	string = `
            	    <div class="row flag${count2}">
						<span class="fa fa-times fa-2x" onclick="deleteRow(this, '${type}')"></span>
						<div class="row">
	            	        <div class="form-group col-md-3">
	            	            <label for="${country}${count2}">Country</label>
	            	            <select class="${docu_class} ${country}" name="${country}${count2}" data-fdcount="${count2}">
	            	            	${flag_options}
	            	            </select>
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${country}${count2}Error"></strong>
	            	            </span>
	            	        </div>
	            	    </div>
            	    </div>
            	    <hr>`;
            }
            else if(type == "MedCert"){
            	
            	string = `
            	    <div class="row docu">
						
						<span class="fa fa-times fa-2x" onclick="deleteRow(this, '${type}')"></span>
            	        <div class="form-group col-md-3">
            	            <label for="${mcType}${count}">Type</label>
            	            <select class="${docu_class} ${mcType}" name="${mcType}${count}">
            	            	<option></option>
            	            	<option value="MEDICAL CERTIFICATE">MEDICAL CERTIFICATE</option>
            	            	<option value="FLAG MEDICAL">FLAG MEDICAL</option>
            	            	<option value="YELLOW FEVER">YELLOW FEVER</option>
            	            	<option value="CHOLERA">CHOLERA</option>
            	            	<option value="CHEMICAL TEST">CHEMICAL TEST</option>
            	            	<option value="DRUG AND ALCOHOL TEST">DRUG AND ALCOHOL TEST</option>
            	            </select>
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${mcType}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-3">
            	            <label for="${clinic}${count}">Type</label>
            	            <select class="${docu_class} ${clinic}" name="${clinic}${count}">
            	            	<option></option>
            	            	<option value="MICAH">MICAH</option>
            	            	<option value="SM LAZO">SM LAZO</option>
            	            	<option value="PHYSICIAN">PHYSICIAN</option>
            	            	<option value="HALCION">HALCION</option>
            	            	<option value="BUREAU OF QUARANTINE">BUREAU OF QUARANTINE</option>
            	            </select>
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${clinic}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-3">
            	            <label for="${issue_date}${count}">Issue Date</label>
            	            <input type="text" class="${docu_class} ${issue_date}" name="${issue_date}${count}" placeholder="Select Issue Date">
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${issue_date}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-3">
            	            <label for="${expiry_date}${count}">Expiry Date</label>
            	            <input type="text" class="${docu_class} ${expiry_date}" name="${expiry_date}${count}" placeholder="Select Expiry Date">
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${expiry_date}${count}Error"></strong>
            	            </span>
            	        </div>
            	    </div>
            	    <hr>`;
            }
            else if(type == "Med"){
            	
            	string = `
            	    <div class="row docu">
						
						<span class="fa fa-times fa-2x" onclick="deleteRow(this, '${type}')"></span>

            	        <div class="form-group col-md-3">
            	            <label for="${medType}${count}">TYPE</label>
            	            <select class="${docu_class} ${medType}" name="${medType}${count}">
            	            	${med_options}
            	            </select>
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${medType}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-3">
            	            <label for="${with_mv}${count}">WITH VACCINE/MEDICATION</label>
            	            <select class="${docu_class} ${with_mv}" name="${with_mv}${count}">
            	            	<option></option>
            	            	<option value="YES">YES</option>
            	            	<option value="NO">NO</option>
            	            </select>
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${with_mv}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-3">
            	            <label for="${year}${count}">Year</label>
            	            <input type="text" class="${docu_class} ${year}" name="${year}${count}" placeholder="Enter Year">
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${year}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-3">
            	            <label for="${medCase}${count}">Case/Remark</label>
            	            <input type="text" class="${docu_class2} ${medCase}" name="${medCase}${count}" placeholder="Enter Case/Remark">
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${medCase}${count}Error"></strong>
            	            </span>
            	        </div>
            	    </div>
            	    <hr>`;
            }
            else{
                    
            	string = `
            	    <div class="row docu">
						
						<span class="fa fa-times fa-2x" onclick="deleteRow(this, '${type}')"></span>
            	        <div class="form-group col-md-4">
            	            <label for="${lcType}${count}">License/Certificate</label>
            	            <select class="${docu_class} ${lcType}" name="${lcType}${count}">
            	            	${lc_options}
            	            </select>
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${lcType}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-4">
            	            <label for="${issuer}${count}">Issuer</label>
            	            <select class="${docu_class2} ${issuer}" name="${issuer}${count}">
            	            	${issuerString}
            	            </select>
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${issuer}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-4">
            	            <label for="${regulation}${count}">Regulation</label>
            	            <select class="${docu_class2} ${regulation}" name="${regulation}${count}" multiple>
            	            	${regulationString}
            	            </select>
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${regulation}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-4">
            	            <label for="${number}${count}">Number</label>
            	            <input type="text" class="${docu_class2} ${number}" name="${number}${count}" placeholder="Enter Number">
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${number}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-4">
            	            <label for="${issue_date}${count}">Issue Date</label>
            	            <input type="text" class="${docu_class} ${issue_date}" name="${issue_date}${count}" placeholder="Select Issue Date">
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${issue_date}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-4">
            	            <label for="${expiry_date}${count}">Expiry Date</label>
            	            <input type="text" class="${docu_class} ${expiry_date}" name="${expiry_date}${count}" placeholder="Select Expiry Date">
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${expiry_date}${count}Error"></strong>
            	            </span>
            	        </div>
            	    </div>
            	    <hr>`;
            }

            // appenddocu(string, ctr? ` .${type}` : '');
            appenddocu(string, ` .${type}`);
            // if(type != 'Flag'){
	            $(`[name="${issue_date}${count}"], [name="${expiry_date}${count}"]`).flatpickr({
	                altInput: true,
	                altFormat: 'F j, Y',
	                dateFormat: 'Y-m-d',
	                // maxDate: moment().format('YYYY-MM-DD')
	            });
            // }

            if(type == "ID"){
            	$(`[name="${dType}${count}"]`).select2({
            		placeholder: 'Select Type',
            		tags: true
            	});

            	$(`[name="${issuer}${count}"]`).select2({
            		placeholder: 'Select or Input Issuer',
            		tags: true
            	});
            }
            else if(type == "Flag"){
            	$(`[name="${country}${count2}"]`).select2({
            		placeholder: 'Select Flag',
            		tags: true
            	});

            	setTimeout(() => {
            		$(`[name="${country}${count2}"]`).trigger('change');
            	}, 200);
            }
            else if(type == "MedCert"){
            	$(`[name="${mcType}${count}"]`).select2({
            		placeholder: 'Select Type',
            		tags: true
            	});

            	$(`[name="${clinic}${count}"]`).select2({
            		placeholder: 'Select Clinic',
            		tags: true
            	});
            }
            else if(type == "Med"){
            	$(`[name="${medType}${count}"]`).select2({
            		placeholder: 'Select Type',
            		tags: true
            	});
            	$(`[name="${with_mv}${count}"]`).select2({
            		placeholder: 'YES/NO',
            	});
            }
            else{
            	$(`[name="${lcType}${count}"]`).select2({
            		placeholder: 'Select Type',
            		tags: true
            	});

            	$(`[name="${issuer}${count}"]`).select2({
            		placeholder: 'Select or Input Issuer',
            		tags: true
            	});

            	$(`[name="${regulation}${count}"]`).select2({
            		placeholder: 'Select or Input Regulation',
            		tags: true
            	});
            }

	        // IF FLAG COUNTRY CHANGE
	        $(`.docu-country`).change(e => {
	        	let fdcount = $(e.target).data('fdcount');
	        	$(`.flag${fdcount}-documents`).hide();

	        	let string = `
					<div class="row docu flag${fdcount}-documents" style="display: none;">
					   	<div class="panel panel-default" style="margin: 0 15px 0 15px; border-color: #777">
					   		<div class="panel-body">
					   			${getDocuments($('#rank').val(), $(e.target).val(), fdcount)}
			   		   		</div>
			   		   	</div>
			   		</div>
	        	`;

				if($(`.flag${fdcount}-documents`).length != 0){
					$(`.flag${fdcount}-documents`).remove();
				}

				$(`.flag${fdcount}`).append(string);
	        	$(`.flag${fdcount}-documents`).slideDown();

	        	let pickr = $(`.flag${fdcount}-documents .form-group:nth-child(4n+3)`);
	        	pickr = pickr.add(`.flag${fdcount}-documents .form-group:nth-child(4n+4)`);

	        	pickr.each((index, input) => {
	        		input = $(input).find('input');
	        		input.flatpickr({
	        			altInput: true,
	        			altFormat: 'F j, Y',
	        			dateFormat: 'Y-m-d',
	        		});
	        	});
	        });
        }

        function getDocuments(rank, country, count){
        	let list = [
        		{
        			country: 'Panama',
        			details: [
        				{
	        				range: [
	        					[1,4]
	        				],
	        				documents: [
	        					'LICENSE', 'BOOKLET', 'GMDSS/GOC', 'GMDSS/GOC BOOKLET', 'SSO', 'SDSD'
	        				]
	        			},
	        			{
	        				range: [
	        					[5,8]
	        				],
	        				documents: [
	        					'LICENSE', 'BOOKLET', 'SSO', "SDSD"
	        				]
	        			},
	        			{
	        				range: [
	        					[9,21],
	        					[25,27]
	        				],
	        				documents: [
	        					'BOOKLET', 'SDSD'
	        				]
	        			},
	        			{
	        				range: [
	        					[22,24]
	        				],
	        				documents: [
	        					'BOOKLET', 'SDSD', "SHIP'S COOK ENDORSEMENT"
	        				]
	        			}
        			]
        		},
        		{
        			country: 'Marshall Islands',
        			details: [
        				{
        					range: [
        						[1,4]
        					],
        					documents: [
        						'LICENSE', 'BOOKLET', 'GMDSS/GOC', 'GMDSS/GOC BOOKLET', 'SSO', 'SDSD'
        					]
        				},
        				{
        					range: [
        						[5,8]
        					],
        					documents: [
        						'LICENSE', 'BOOKLET', 'SDSD'
        					]
        				},
        				{
        					range: [
        						[9,27]
        					],
        					documents: [
        						'BOOKLET', 'SDSD'
        					]
        				}
        			]
        		},
        		{
        			country: 'Korea',
        			details: [
        				{
        					range: [
        						[1,8]
        					],
        					documents: [
        						'LICENSE', 'BOOKLET'
        					]
        				}
        			]
        		},
        		// {
        		// 	country: 'Malaysia',
        		// 	details: [
        		// 		{
        		// 			range: [
        		// 				[1,8]
        		// 			],
        		// 			documents: [
        		// 				'LICENSE'
        		// 			]
        		// 		}
        		// 	]
        		// },
        		{
        			country: 'General',
        			details: [
        				{
        					range: [
        						[1,27]
        					],
        					documents: [
        						'LICENSE'
        					]
        				}
        			]
        		}
        	];

        	let documentString = "";
        	let matched = false;

        	list.every((row, index) => {
        		if(index == (list.length - 1)){
        			country = "General";
        		}

        		if(row.country == country){
        			let details = row.details;
        			details.forEach(detail => {
        				let ranges = detail.range;
        				ranges.forEach(range => {
        					if(rank >= range[0] && rank <= range[1]){
        						let documents = detail.documents;
        						matched = true;

        						documents.forEach(docu => {
        							documentString += flag(count, docu);
        						});
        					}
        				});
        			});
        		}

        		// If matched is true, the loop will break else next iteration
        		return matched ? false : true;
        	});

        	setTimeout(() => {
        		$('.Flag .docu-dtype').prop('disabled', true).css({
        			"cursor": 'not-allowed',
        			"border-color": 'rgba(247,108,107, 0.8)'
        		});
        	}, 300);

        	return documentString;
        }

        function flag(count, value = ""){
        	let docu_class = "form-control aeigh";
            let dType = "docu-dtype";
            let number = 'docu-number';
        	let issue_date = 'docu-issue_date';
        	let expiry_date = 'docu-expiry_date';

        	return `
				<div class="form-group col-md-3">
				    <label>Type</label>
				    <input class="${docu_class} ${dType}" value="${value}">
				    <span class="invalid-feedback hidden" role="alert">
				        <strong id="${dType}${count}Error"></strong>
				    </span>
				</div>

				<div class="form-group col-md-3">
				    <label for="${number}${count}">Number</label>
				    <input class="${docu_class} ${number}" placeholder="Enter Number">
				    <span class="invalid-feedback hidden" role="alert">
				        <strong id="${number}${count}Error"></strong>
				    </span>
				</div>

				<div class="form-group col-md-3">
				    <label for="${issue_date}${count}">Issue Date</label>
				    <input class="${docu_class} ${issue_date}" placeholder="Select Issue Date">
				    <span class="invalid-feedback hidden" role="alert">
				        <strong id="${issue_date}${count}Error"></strong>
				    </span>
				</div>

				<div class="form-group col-md-3">
				    <label for="${expiry_date}${count}">Expiry Date</label>
				    <input class="${docu_class} ${expiry_date}" placeholder="Select Expiry Date">
				    <span class="invalid-feedback hidden" role="alert">
				        <strong id="${expiry_date}${count}Error"></strong>
				    </span>
				</div>
        	`;
        }

        function appenddocu(string, addClass = ""){
            $('#docu' + addClass).append(string);
        }
    </script>
@endpush

@push('after-scripts')
    <script>
        $('#rank').select2({
        	placeholder: 'Select Rank'
        });

        let list = [
     //    // LICENSES
     //    	{
     //    		range: [1, 2],
     //    		issuer: 'MARINA',
     //    		documents: [
     //    			'COC', 'COE', 'GMDSS/GOC'
     //    		],
     //    		regulation: [
     //    			['II/2', 'IV/2'],
     //    			['II/2', 'IV/2'],
     //    			['IV/2'],
     //    		]
     //    	},
     //    	{
     //    		range: [3, 4],
     //    		issuer: 'MARINA',
     //    		documents: [
     //    			'COC', 'COE', 'GMDSS/GOC'
     //    		],
     //    		regulation: [
     //    			['II/1', 'IV/2'],
     //    			['II/1', 'IV/2'],
     //    			['IV/2'],
     //    		]
     //    	},
     //    	{
     //    		range: [5, 6],
     //    		issuer: 'MARINA',
     //    		documents: [
     //    			'COC', 'COE'
     //    		],
     //    		regulation: [
     //    			['III/2'],
     //    			['III/2']
     //    		]
     //    	},
     //    	{
     //    		range: [7, 8],
     //    		issuer: 'MARINA',
     //    		documents: [
     //    			'COC', 'COE'
     //    		],
     //    		regulation: [
     //    			['III/1'],
     //    			['III/1']
     //    		]
     //    	},
     //    	{
     //    		range: [9, 14],
     //    		issuer: 'MARINA',
     //    		documents: [
     //    			'COC', 'COE'
     //    		],
     //    		regulation: [
     //    			['II/4'],
     //    			['II/5']
     //    		]
     //    	},
     //    	{
     //    		range: [15, 21],
     //    		issuer: 'MARINA',
     //    		documents: [
     //    			'COC', 'COE'
     //    		],
     //    		regulation: [
     //    			['III/4'],
     //    			['III/5']
     //    		]
     //    	},
     //    	{
     //    		range: [22, 27],
     //    		issuer: 'TESDA',
     //    		documents: [
     //    			'NCI', 'NCII', 'NCIII'
     //    		],
     //    		regulation: [
     //    			['--'],
     //    			['--'],
     //    			['--']
     //    		]
     //    	},
     //    // CERTIFICATES
     //    	// ALL
     //    	{
     //    		range: [1, 27],
     //    		issuer: 'MARINA',
     //    		documents: [
     //    			'BASIC TRAINING - BT', 
     //    			'PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB', 
     //    			'SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD', 
     //    			'HAZMAT', 
     //    			'ENGLISH TEST', 
     //    			'ANTI PIRACY', 
     //    			'IN HOUSE TRAINING CERT WITH ISM', 
     //    			'GENERAL TRAINING RECORD BOOK', 
     //    			'PDOS'
     //    		],
     //    		regulation: [
     //    			['VI/1'],
     //    			['VI/2.1'],
     //    			['VI/6'],
     //    			[],[],[],
     //    			[],[],[],
     //    		]
     //    	},
     //    	// OFFICERS
     //    	{
     //    		range: [1, 8],
     //    		issuer: 'MARINA',
     //    		documents: [
     //    			'FAST RESCUE BOAT - FRB',
     //    			'ADVANCE FIRE FIGHTING - AFF',
     //    			'MEDICAL FIRST AID - MEFA',
     //    			'MEDICAL CARE - MECA',
     //    			'SHIP SECURITY OFFICER - SSO',
     //    			'MARPOL 73/78',
     //    			'KML TRAINING',
     //    			'ECDIS TRANSAS',
     //    			'MLC TRAINING F1',
     //    			'MLC TRAINING F2',
     //    			'MLC TRAINING F3',
     //    			'MLC TRAINING F4',
     //    		],
     //    		regulation: [
     //    			['VI/2.2'],
     //    			['VI/3'],
     //    			['VI/4.1'],
     //    			['VI/4.2'],
     //    			['VI/5'],
     //    			[],[],[],[],
     //    			[],[],[],

     //    		]
     //    	},
     //    	// DECK OFFICERS
     //    	{
     //    		range: [1, 4],
     //    		issuer: 'MARINA',
     //    		documents: [
     //    			'RADAR SIMULATOR COURSE',
     //    			'BRIDGE TEAM/RESOURCE MANAGEMENT',
     //    			'SHIP SAFETY OFFICER',
     //    			// 'GMDSS/GOC',
     //    			'SSBT',
     //    			'ARPA TRAINING COURSE',
     //    			'ECDIS',
					// 'ECDIS FURUNO 2107',
					// 'ECDIS FURUNO 3200',
					// 'ECDIS FURUNO 3300',
					// 'ECDIS JRC 701B',
					// 'ECDIS JRC 7201',
					// 'ECDIS JRC 901B',
					// 'ECDIS JRC 9201',
					// 'ECDIS MARTEK',
					// 'ECDIS MECYS',
					// 'CARGO HANDLING',
					// 'STABILITY AND TRIM',
					// 'COLLISION AVOIDANCE',
					// 'DANGEROUS FLUID CARGO COURSE',
					// 'SHIP HANDLING SIMULATION',
					// 'POLLUTION PREVENTION COURSE',
					// 'RISK ASSESMENT/INCIDENT INVESTIGATION COURSE',
					// 'ADVANCE NAVIGATION',
					// 'ADVANCE SHIPBOARD OPERATION AND MGT.',
					// 'SATELLITE COMMUNICATION COURSE',
     //    		],
     //    		regulation: [
     //    			[],[],[],[],[],[],
     //    			[],[],[],[],[],[],
     //    			[],[],[],[],[],[],
     //    			[],[],[],[],[],[],
     //    			[],[],
     //    		]
     //    	},
     //    	// ENGINE OFFICERS
     //    	{
     //    		range: [5, 8],
     //    		issuer: 'MARINA',
     //    		documents: [
     //    			'ERS WITH ERM',
					// 'AUXILIARY MACHINERY SYSTEM',
					// 'CONTROL ENGINEERING',
					// 'HYDRAULICS/PNEUMATICS',
					// 'MARINE ELECTRO TECH',
					// 'ELECTRONIC EQUIPMENT',
					// 'MARINE ELECTRICAL',
					// 'MARINE REFRIGIRATION/AIRCONDITIONING',
     //    		],
     //    		regulation: [
     //    			[],[],[],[],
     //    			[],[],[],[],
     //    		]
     //    	},
     //    	// 2/0, 3/0
     //    	{
     //    		range: [3, 4],
     //    		issuer: 'MARINA',
     //    		documents: [
     //    			'OLC TRAINING F1',
     //    			'OLC TRAINING F2',
     //    			'OLC TRAINING F3',
     //    		],
     //    		regulation: [
     //    			[],[],[]
     //    		]
     //    	},
     //    	// 2AE, 3AE
     //    	{
     //    		range: [7,8],
     //    		issuer: 'MARINA',
     //    		documents: [
     //    			'OLC TRAINING F1',
     //    			'OLC TRAINING F2',
     //    			'OLC TRAINING F3',
     //    		],
     //    		regulation: [
     //    			[],[],[]
     //    		]
     //    	},
     //    	// ENGINE RATINGS
     //    	{
     //    		range: [15, 21],
     //    		issuer: 'MARINA',
     //    		documents: [
     //    			'WELDING CERT/SMAW'
     //    		],
     //    		regulation: [
     //    			[]
     //    		]
     //    	},
     //    	// GALLEY
     //    	{
     //    		range: [22, 27],
     //    		issuer: 'MARINA',
     //    		documents: [
     //    			'CATERING TRAINING CERT'
     //    		],
     //    		regulation: [
     //    			[]
     //    		]
     //    	},
        // NEW
        	{
        		range: [1, 4],
        		issuer: '',
        		documents: [
        			'COC', 
        			'COE', 
        			'GMDSS/GOC',
        			'BASIC TRAINING - BT', 
        			'PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB', 
        			'ADVANCE FIRE FIGHTING - AFF',
        			'MEDICAL FIRST AID - MEFA',
        			'MEDICAL CARE - MECA',
        			'SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD', 
        		],
        		regulation: [
        			[],[],[],[],[],[],[],[],[],
        		]
        	},
        	{
        		range: [5, 8],
        		issuer: '',
        		documents: [
        			'COC', 
        			'COE', 
        			'BASIC TRAINING - BT', 
        			'PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB', 
        			'ADVANCE FIRE FIGHTING - AFF',
        			'MEDICAL FIRST AID - MEFA',
        			'SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD', 
        		],
        		regulation: [
        			[],[],[],[],[],[],[]
        		]
        	},
        	{
        		range: [1, 3],
        		issuer: '',
        		documents: [
        			'SHIP SECURITY OFFICER - SSO',
        		],
        		regulation: [
        			[],
        		]
        	},
        ];

        $('#rank').change(e => {
        	swal.showLoading();
        	setTimeout(() => {
        		asdasd(e);
        	}, 100);
        });

        function asdasd(e){

        	let rank = e.target.value;

            $('.docu-country').each((index, country) => {
                $(country).trigger('change');
            });

            let ctr = 0;

            list.every(row => {
            	if(rank >= row.range[0] && rank <= row.range[1]){

            		row.documents.forEach((docu, index) => {
            			// IF DOCUMENT IS EXISTING IN LC, SKIP
            			if($(`[name^="docu-lctype"] [value="${docu}"]`).length){
            				return
            			}
            			$(`[name^="docu-lctype"] [value="${docu}"]`).parent().hide();
            			let match = $(`.lc [value="${docu}"]`);
            			if(match.length > 0){
            				ctr += 1;
            				let row = $(match[match.length - 1]).parent().parent().parent();
            				row.next().hide();
            				row.hide();
            			}

            			let count = $('.docu').length + 1;
            			addDocu('lc');
            			
            			// CHECK IF DOCUMENT IS IN OPTION, IF NOT ADD OPTION AND PRESELECT IT
        				if($(`[name="docu-lctype${count}"]`).find(`option[value="${docu}"]`).length){
        					$(`[name="docu-lctype${count}"]`).val(docu).trigger('change');
        				}
        				else{
        					let option = new Option(docu, docu, true, true);
        					$(`[name="docu-lctype${count}"]`).append(option).trigger('change');
        				}
            			
        				if($(`[name="docu-issuer${count}"]`).find(`option[value="${row.issuer}"]`).length){
        					$(`[name="docu-issuer${count}"]`).val(row.issuer).trigger('change');
        				}
        				else{
        					let option = new Option(row.issuer, row.issuer, true, true);
        					$(`[name="docu-issuer${count}"]`).append(option).trigger('change');
        				}

        				row.regulation[index].forEach(tempOption => {
        					if(!$(`[name="docu-regulation${count}"]`).find(`option[value="${row.regulation}"]`).length){
        						let option = new Option(tempOption, tempOption, true, true);
        						$(`[name="docu-regulation${count}"]`).append(option).trigger('change');
        					}
        				});
            		});
            	}
            	return true;
            });

            $(`.lcCount`)[0].innerText = parseInt($(`.lcCount`)[0].innerText) - ctr;

            setTimeout(() => {
            	$(`[name^="docu-lctype"]`).prop('disabled', true);
            	// $(`.lc [name^="docu-issuer"]`).prop('disabled', true);
            	// $(`[name^="docu-regulation"]`).prop('disabled', true);

            	setTimeout(() => {
            		let selection = $('.select2-container--disabled .select2-selection__rendered');
            		selection.css('cursor', 'not-allowed');
            		selection.parent().css('border-color', 'rgba(247,108,107, 0.8)');
            	}, 100);
            }, 400);

            swal.close();
        }
    </script>
@endpush