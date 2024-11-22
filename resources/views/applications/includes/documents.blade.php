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
			            // AJAX INSERT RANK STRING HERE
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

		let issuerString = "<option></option>";
		let regulationString = "<option></option>";
		let rankString = "<option></option>";
		let rankString2 = "<option></option>";

        // LOAD ISSUER OPTIONS
        $(document).ready(() => {
        	@foreach($issuers as $issuer)
        		issuerString += `
        			<option value="{{ $issuer }}">{{ $issuer }}</option>
        		`;
        	@endforeach

        	@foreach($regulations as $regulation)
        		@php
        			$tempReg = json_decode($regulation)[0] ?? $regulation;
        		@endphp
        		regulationString += `
        			<option value="{{ $tempReg }}">{{ $tempReg }}</option>
        		`;
        	@endforeach

        	@foreach($categories as $category)
        		@foreach($category as $rank)
        			rankString += `
        				<option value="{{ $rank->id }}">{{ $rank->name }} ({{ $rank->abbr }})</option>
        			`;
        			rankString2 += `
        				<option value="{{ $rank->name }}">{{ $rank->name }} ({{ $rank->abbr }})</option>
        			`;
        		@endforeach
        	@endforeach

        	$('#rank').append(rankString);
        	@if(isset($edit))
    			populate_data();
        	@endif
	    });

        function addDocu(type){
            $(`.${type}Count`)[0].innerText = parseInt($(`.${type}Count`)[0].innerText) + 1;

            let count = $('.docu').length + 1;
            let count2 = $('.docu-country').length + 1;

            let docu_class = 'form-control';
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
        		'', 'PASSPORT', 'US-VISA', "SEAMAN BOOK", 'MCV', 'JAPANESE VISA', "SEAMANS REGISTRATION CERTIFICATE", "SID",
        		'KOREAN VISA', 'CHINESE VISA'
        	];

        	idOptions.forEach(docu => {
        		docu2 = docu == "SEAMAN BOOK" ? "SEAMAN'S BOOK" : docu;
				id_options += `<option value="${docu}">${docu2}</option>`
			});

			//CREATE LC OPTIONS
			var lc_options = "";
			var lcOptions = [''];

        	lcOptions.forEach(docu => {
				lc_options += `<option value="${docu}">${docu}</option>`
			});

			lc_options += `
				<optgroup label="NATIONAL LICENSES"></optgroup>
					<option value="COC">&nbsp;&nbsp;&nbsp;&nbsp;COC</option>
					<option value="COE">&nbsp;&nbsp;&nbsp;&nbsp;COE</option>
					<option value="GMDSS/GOC">&nbsp;&nbsp;&nbsp;&nbsp;GMDSS/GOC</option>
				<optgroup label="COP"></optgroup>

					<option value="BASIC TRAINING - BT">&nbsp;&nbsp;&nbsp;&nbsp;BASIC TRAINING - BT</option>
					<option value="PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB">&nbsp;&nbsp;&nbsp;&nbsp;PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB</option>
					<option value="ADVANCE FIRE FIGHTING - AFF">&nbsp;&nbsp;&nbsp;&nbsp;ADVANCE FIRE FIGHTING - AFF</option>
					<option value="MEDICAL FIRST AID - MEFA">&nbsp;&nbsp;&nbsp;&nbsp;MEDICAL FIRST AID - MEFA</option>
					<option value="FAST RESCUE BOAT - FRB">&nbsp;&nbsp;&nbsp;&nbsp;FAST RESCUE BOAT - FRB</option>
					<option value="MEDICAL CARE - MECA">&nbsp;&nbsp;&nbsp;&nbsp;MEDICAL CARE - MECA</option>
					<option value="SHIP SECURITY OFFICER - SSO">&nbsp;&nbsp;&nbsp;&nbsp;SHIP SECURITY OFFICER - SSO</option>
					<option value="SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD">&nbsp;&nbsp;&nbsp;&nbsp;SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD</option>

				<optgroup label="GALLEY"></optgroup>
					<option value="NCI">&nbsp;&nbsp;&nbsp;&nbsp;NCI</option>
					<option value="NCII">&nbsp;&nbsp;&nbsp;&nbsp;NCII</option>
					<option value="NCIII">&nbsp;&nbsp;&nbsp;&nbsp;NCIII</option>
					<option value="KOREAN COOKING">&nbsp;&nbsp;&nbsp;&nbsp;KOREAN COOKING/CUISINE</option>

				<optgroup label="TRAINING CERTIFICATES"></optgroup>
					<option value="ARPA TRAINING COURSE">&nbsp;&nbsp;&nbsp;&nbsp;ARPA TRAINING COURSE</option>
					<option value="CONSOLIDATED MARPOL">&nbsp;&nbsp;&nbsp;&nbsp;CONSOLIDATED MARPOL</option>
					<option value="ECDIS">&nbsp;&nbsp;&nbsp;&nbsp;ECDIS GENERIC</option>
					<optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;ECDIS SPECIFIC"></optgroup>
						<option value="ECDIS FURUNO 2107">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ECDIS FURUNO 2107</option>
						<option value="ECDIS FURUNO 2807">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ECDIS FURUNO 2807</option>
						<option value="ECDIS FURUNO 3100/3200/3300">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ECDIS FURUNO 3100/3200/3300</Option>
						<option value="ECDIS JRC 701B">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ECDIS JRC 701B</option>
						<option value="ECDIS JRC 7201">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ECDIS JRC 7201</option>
						<option value="ECDIS JRC 901B">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ECDIS JRC 901B</option>
						<option value="ECDIS JRC 9201">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ECDIS JRC 9201</option>
						<option value="ECDIS CHARTWORLD EG2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ECDIS CHARTWORLD EG2</option>
						<option value="ECDIS TOKYO">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ECDIS TOKYO</option>
						<option value="ECDIS MECYS PM3D">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ECDIS PM3D</option>
						<option value="ECDIS MARTEK">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ECDIS MARTEK</option>
						<option value="ECDIS TRANSAS">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ECDIS TRANSAS</option>
					<option value="ERS WITH ERM">&nbsp;&nbsp;&nbsp;&nbsp;ERS WITH ERM</option>
					<option value="ERS">&nbsp;&nbsp;&nbsp;&nbsp;ERS</option>
					<option value="ERM">&nbsp;&nbsp;&nbsp;&nbsp;ERM</option>
					<option value="PRACTICAL ASSESSMENT IN MANAGEMENT LEVEL">&nbsp;&nbsp;&nbsp;&nbsp;PRACTICAL ASSESSMENT IN MANAGEMENT LEVEL</option>
					<option value="MLC TRAINING F1">&nbsp;&nbsp;&nbsp;&nbsp;MLC TRAINING F1</option>
					<option value="MLC TRAINING F2">&nbsp;&nbsp;&nbsp;&nbsp;MLC TRAINING F2</option>
					<option value="MLC TRAINING F3">&nbsp;&nbsp;&nbsp;&nbsp;MLC TRAINING F3</option>
					<option value="MLC TRAINING F4">&nbsp;&nbsp;&nbsp;&nbsp;MLC TRAINING F4</option>
					<option value="OLC TRAINING F1">&nbsp;&nbsp;&nbsp;&nbsp;OLC TRAINING F1</option>
					<option value="OLC TRAINING F2">&nbsp;&nbsp;&nbsp;&nbsp;OLC TRAINING F2</option>
					<option value="OLC TRAINING F3">&nbsp;&nbsp;&nbsp;&nbsp;OLC TRAINING F3</option>
					<option value="OLC TRAINING F4">&nbsp;&nbsp;&nbsp;&nbsp;OLC TRAINING F4</option>
					<option value="RADAR SIMULATOR COURSE">&nbsp;&nbsp;&nbsp;&nbsp;RADAR SIMULATOR COURSE</option>
					<option value="RADAR TRAINING COURSE">&nbsp;&nbsp;&nbsp;&nbsp;RADAR TRAINING COURSE</option>
					<option value="RADAR OPERATOR PLOTTING AID">&nbsp;&nbsp;&nbsp;&nbsp;RADAR OPERATOR PLOTTING AID</option>
					<option value="RADAR OBSERVER COURSE">&nbsp;&nbsp;&nbsp;&nbsp;RADAR OBSERVER COURSE</option>
					<option value="SSBT WITH BRM">&nbsp;&nbsp;&nbsp;&nbsp;SSBT WITH BRM</option>
					<option value="SSBT">&nbsp;&nbsp;&nbsp;&nbsp;SSBT</option>
					<option value="BRM">&nbsp;&nbsp;&nbsp;&nbsp;BRM</option>
					<option value="SAFETY OFFICER\'S TRAINING COURSE">&nbsp;&nbsp;&nbsp;&nbsp;SAFETY OFFICER\'S TRAINING COURSE</option>
					<option value="SRC">&nbsp;&nbsp;&nbsp;&nbsp;SRC</option>
					<option value="ENGINE WATCH">&nbsp;&nbsp;&nbsp;&nbsp;ENGINE WATCH</option>
					<option value="DECK WATCH">&nbsp;&nbsp;&nbsp;&nbsp;DECK WATCH</option>
					<option value="PADAMS">&nbsp;&nbsp;&nbsp;&nbsp;PADAMS</option>
					<option value="MARITIME POLLUTION PREVENTION">&nbsp;&nbsp;&nbsp;&nbsp;MARITIME POLLUTION PREVENTION</option>
					<option value="KOSCO - IN HOUSE TRAINING RECORD">&nbsp;&nbsp;&nbsp;&nbsp;KOSCO - IN HOUSE TRAINING RECORD</option>
					<option value="ADVANCE NAVIGATION">&nbsp;&nbsp;&nbsp;&nbsp;ADVANCE NAVIGATION</option>
					<option value="ADVANCE SHIPBOARD OPERATION AND MGT">&nbsp;&nbsp;&nbsp;&nbsp;ADVANCE SHIPBOARD OPERATION AND MGT</option>
					<option value="AUXILIARY MACHINERY SYSTEM">&nbsp;&nbsp;&nbsp;&nbsp;AUXILIARY MACHINERY SYSTEM</option>
					<option value="CARGO HANDLING">&nbsp;&nbsp;&nbsp;&nbsp;CARGO HANDLING</option>
					<option value="COLLISION AVOIDANCE">&nbsp;&nbsp;&nbsp;&nbsp;COLLISION AVOIDANCE</option>
					<option value="CONTROL ENGINEERING">&nbsp;&nbsp;&nbsp;&nbsp;CONTROL ENGINEERING</option>
					<option value="DANGEROUS FLUID CARGO COURSE">&nbsp;&nbsp;&nbsp;&nbsp;DANGEROUS FLUID CARGO COURSE</option>
					<option value="ELECTRONIC EQUIPMENT">&nbsp;&nbsp;&nbsp;&nbsp;ELECTRONIC EQUIPMENT</option>
					<option value="ENGLISH TEST">&nbsp;&nbsp;&nbsp;&nbsp;ENGLISH TEST</option>
					<option value="HYDRAULICS/PNEUMATICS">&nbsp;&nbsp;&nbsp;&nbsp;HYDRAULICS/PNEUMATICS</option>
					<option value="MARINE ELECTRICAL">&nbsp;&nbsp;&nbsp;&nbsp;MARINE ELECTRICAL</option>
					<option value="MARINE ELECTRO TECH">&nbsp;&nbsp;&nbsp;&nbsp;MARINE ELECTRO TECH</option>
					<option value="MARINE REFRIGERATION/AIRCONDITIONING">&nbsp;&nbsp;&nbsp;&nbsp;MARINE REFRIGERATION/AIRCONDITIONING</option>
					<option value="RISK ASSESSMENT / INCIDENT INVESTIGATION COURSE">&nbsp;&nbsp;&nbsp;&nbsp;RISK ASSESSMENT / INCIDENT INVESTIGATION COURSE</option>
					<option value="SATELLITE COMMUNICATION COURSE">&nbsp;&nbsp;&nbsp;&nbsp;SATELLITE COMMUNICATION COURSE</option>
					<option value="SHIP HANDLING SIMULATION">&nbsp;&nbsp;&nbsp;&nbsp;SHIP HANDLING SIMULATION</option>
					<option value="STABILITY AND TRIM">&nbsp;&nbsp;&nbsp;&nbsp;STABILITY AND TRIM</option>
					<option value="MARINE ELECTRIC WITH REEFER">&nbsp;&nbsp;&nbsp;&nbsp;MARINE ELECTRIC WITH REEFER</option>
					<option value="WELDING COURSE">&nbsp;&nbsp;&nbsp;&nbsp;WELDING COURSE</option>
					<option value="SHIELDED METAL ARC WELDING">&nbsp;&nbsp;&nbsp;&nbsp;SHIELDED METAL ARC WELDING</option>
					<option value="KML">&nbsp;&nbsp;&nbsp;&nbsp;KOREAN MARITIME LAW - KML</option>
					<option value="CATERING TRAINING">&nbsp;&nbsp;&nbsp;&nbsp;CATERING TRAINING</option>
					<option value="HIGH VOLTAGE TRAINING">&nbsp;&nbsp;&nbsp;&nbsp;HIGH VOLTAGE TRAINING</option>
					<option value="NEW ENGINE ROOM MACHINERY - WESTERN">&nbsp;&nbsp;&nbsp;&nbsp;NEW ENGINE ROOM MACHINERY - WESTERN</option>
					<option value="ELECTRONIC NAVIGATION SYSTEMS - ENS">&nbsp;&nbsp;&nbsp;&nbsp;ELECTRONIC NAVIGATION SYSTEMS - ENS</option>
					<option value="ELECTRO-TECHNICAL RATINGS">&nbsp;&nbsp;&nbsp;&nbsp;ELECTRO-TECHNICAL RATINGS</option>
					<option value="ELECTRO-TECHNICAL OFFICER">&nbsp;&nbsp;&nbsp;&nbsp;ELECTRO-TECHNICAL OFFICER</option>
					<option value="GENERAL TANKER FAMILIARIZATION">&nbsp;&nbsp;&nbsp;&nbsp;GENERAL TANKER FAMILIARIZATION</option>
					<option value="CONTAINER FAMILIARIZATION">&nbsp;&nbsp;&nbsp;&nbsp;CONTAINER FAMILIARIZATION</option>
					<option value="PSSR">&nbsp;&nbsp;&nbsp;&nbsp;PERSONAL SAFETY AND SOCIAL RESPONSIBILITIES - PSSR</option>
					<option value="SHIPS RESTRICTED RADIO TELEPHONE OPERATORS COURSE">&nbsp;&nbsp;&nbsp;&nbsp;SHIPS RESTRICTED RADIO TELEPHONE OPERATORS COURSE</option>
					<option value="SHORE-BASED FIREFIGHTING FOR TANKERS">&nbsp;&nbsp;&nbsp;&nbsp;SHORE-BASED FIREFIGHTING FOR TANKERS</option>
					<option value="STEERING COURSE">&nbsp;&nbsp;&nbsp;&nbsp;STEERING COURSE</option>
					<option value="SHIPBOARD CULINARY COURSE">&nbsp;&nbsp;&nbsp;&nbsp;SHIPBOARD CULINARY COURSE</option>
					<option value="MESSMAN/STEWARD COURSE">&nbsp;&nbsp;&nbsp;&nbsp;MESSMAN/STEWARD COURSE</option>
					<option value="BULK CARRIER SHIP INSPECTION TRAINING">&nbsp;&nbsp;&nbsp;&nbsp;BULK CARRIER SHIP INSPECTION TRAINING</option>
					<option value="BULK CARRIER SHIP INSPECTION TRAINING">&nbsp;&nbsp;&nbsp;&nbsp;BULK CARRIER SHIP INSPECTION TRAINING</option>
					<option value="ENCLOSED SPACE ENTRY">&nbsp;&nbsp;&nbsp;&nbsp;ENCLOSED SPACE ENTRY</option>
					<option value="SHIPBOARD HAZARDS SIMULATION AND SITUATIONAL AWARENESS TRAINING">&nbsp;&nbsp;&nbsp;&nbsp;SHIPBOARD HAZARDS SIMULATION AND SITUATIONAL AWARENESS TRAINING</option>

				<optgroup label="TANKER CERTIFICATES"></optgroup>
					<option value="BASIC TRAINING FOR OIL AND CHEMICAL TANKER - BTOCT">&nbsp;&nbsp;&nbsp;&nbsp;BASIC TRAINING FOR OIL AND CHEMICAL TANKER - BTOCT</option>
					<option value="ADVANCE TRAINING FOR OIL TANKER - ATOT">&nbsp;&nbsp;&nbsp;&nbsp;ADVANCE TRAINING FOR OIL TANKER - ATOT</option>
					<option value="BASIC TRAINING FOR LIQUIFIED GAS TANKER CARGO OPERATIONS - BTLGT">&nbsp;&nbsp;&nbsp;&nbsp;BASIC TRAINING FOR LIQUIFIED GAS TANKER CARGO OPERATIONS - BTLGT</option>
					<option value="ADVANCED TRAINING FOR LIQUIFIED GAS TANKER CARGO OPERATIONS - ATLGT">&nbsp;&nbsp;&nbsp;&nbsp;ADVANCED TRAINING FOR LIQUIFIED GAS TANKER CARGO OPERATIONS - ATLGT</option>
					<option value="ADVANCE TRAINING FOR CHEMICAL TANKER - ATCT">&nbsp;&nbsp;&nbsp;&nbsp;ADVANCE TRAINING FOR CHEMICAL TANKER - ATCT</option>
					<option value="BTOC ENDORSEMENT">&nbsp;&nbsp;&nbsp;&nbsp;BTOC ENDORSEMENT</option>
					<option value="ATOT ENDORSEMENT">&nbsp;&nbsp;&nbsp;&nbsp;ATOT ENDORSEMENT</option>
					<option value="ATCT ENDORSEMENT">&nbsp;&nbsp;&nbsp;&nbsp;ATCT ENDORSEMENT</option>

				<optgroup label="IN HOUSE CERTIFICATE/SPECIAL TRAINING"></optgroup>
					<option value="ANTI PIRACY">&nbsp;&nbsp;&nbsp;&nbsp;ANTI PIRACY</option>
					<option value="GENERAL TRAINING RECORD BOOK">&nbsp;&nbsp;&nbsp;&nbsp;GENERAL TRAINING RECORD BOOK</option>
					<option value="IN HOUSE TRAINING CERT WITH ISM">&nbsp;&nbsp;&nbsp;&nbsp;IN HOUSE TRAINING CERT WITH ISM</option>
					<option value="PDOS">&nbsp;&nbsp;&nbsp;&nbsp;PDOS - PRE-DEPARTURE ORIENTATION SEMINAR</option>
					<option value="HAZMAT">&nbsp;&nbsp;&nbsp;&nbsp;HAZMAT - Dangerous, Hazardous and Harmful Substance (Bulk)</option>
					<option value="MENTAL HEALTH">&nbsp;&nbsp;&nbsp;&nbsp;Mental Health Awareness</option>
					<option value="MCRA">&nbsp;&nbsp;&nbsp;&nbsp;MCRA - MARITIME CYBER RISK AWARENESS/MANAGEMENT</option>
					<option value="GTRB">&nbsp;&nbsp;&nbsp;&nbsp;GTRB - GENERAL TRAINING RECORD BOOK</option>
					<option value="BASIC MARITIME COMPUTER COURSE">&nbsp;&nbsp;&nbsp;&nbsp;BASIC MARITIME COMPUTER COURSE</option>

				<optgroup label="CONTRACTS"></optgroup>
					<option value="POEA CONTRACT">&nbsp;&nbsp;&nbsp;&nbsp;POEA CONTRACT</option>
					<option value="AMOSUP CONTRACT">&nbsp;&nbsp;&nbsp;&nbsp;AMOSUP CONTRACT</option>
					<option value="MLC/CBA CONTRACT">&nbsp;&nbsp;&nbsp;&nbsp;MLC/CBA CONTRACT</option>
					<option value="SEAFARERS EMPLOYMENT AGREEMENT">&nbsp;&nbsp;&nbsp;&nbsp;SEAFARERS EMPLOYMENT AGREEMENT</option>

				<optgroup label="OTHERS"></optgroup>
					<option value="POEA EREGISTRATION">&nbsp;&nbsp;&nbsp;&nbsp;POEA EREGISTRATION</option>
					<option value="NBI">&nbsp;&nbsp;&nbsp;&nbsp;NBI</option>
					<option value="DRIVERS LICENSE">&nbsp;&nbsp;&nbsp;&nbsp;DRIVER'S LICENSE</option>

				<optgroup label="TESTS"></optgroup>
					<option value="CES TEST">&nbsp;&nbsp;&nbsp;&nbsp;CES TEST</option>
			`;

			// 'FLAG STATE SEAMAN BOOK (I.D BOOK)', 'FLAG STATE SEAMAN BOOK (I.D BOOK)', 'FLAG STATE S.Q. FOR TANKERS', 'FLAG STATE LICENSE', 'FLAG STATE SSO LICENSE', 'FLAG STATE ENDORSEMENT COOK COURSE', 'FLAG STATE GMDSS-GOC', 

			// COUNTRIES
			var flag_countries = 
			[

				'Afghanistan (AF)', 'Åland Islands (AX)', 'Albania (AL)', 'Algeria (DZ)', 'American Samoa (AS)', 'Andorra (AD)', 'Angola (AO)', 'Anguilla (AI)', 'Antarctica (AQ)', 'Antigua & Barbuda (AG)', 'Argentina (AR)', 'Armenia (AM)', 'Aruba (AW)', 'Ascension Island (AC)', 'Australia (AU)', 'Austria (AT)', 'Azerbaijan (AZ)', 'Bahamas (BS)', 'Bahrain (BH)', 'Bangladesh (BD)', 'Barbados (BB)', 'Belarus (BY)', 'Belgium (BE)', 'Belize (BZ)', 'Benin (BJ)', 'Bermuda (BM)', 'Bhutan (BT)', 'Bolivia (BO)', 'Bosnia & Herzegovina (BA)', 'Botswana (BW)', 'Brazil (BR)', 'British Indian Ocean Territory (IO)', 'British Virgin Islands (VG)', 'Brunei (BN)', 'Bulgaria (BG)', 'Burkina Faso (BF)', 'Burundi (BI)', 'Cambodia (KH)', 'Cameroon (CM)', 'Canada (CA)', 'Canary Islands (IC)', 'Cape Verde (CV)', 'Caribbean Netherlands (BQ)', 'Cayman Islands (KY)', 'Central African Republic (CF)', 'Ceuta & Melilla (EA)', 'Chad (TD)', 'Chile (CL)', 'China (CN)', 'Christmas Island (CX)', 'Cocos (Keeling) Islands (CC)', 'Colombia (CO)', 'Comoros (KM)', 'Congo - Brazzaville (CG)', 'Congo - Kinshasa (CD)', 'Cook Islands (CK)', 'Costa Rica (CR)', 'Côte d’Ivoire (CI)', 'Croatia (HR)', 'Cuba (CU)', 'Curaçao (CW)', 'Cyprus (CY)', 'Czechia (CZ)', 'Denmark (DK)', 'Diego Garcia (DG)', 'Djibouti (DJ)', 'Dominica (DM)', 'Dominican Republic (DO)', 'Ecuador (EC)', 'Egypt (EG)', 'El Salvador (SV)', 'Equatorial Guinea (GQ)', 'Eritrea (ER)', 'Estonia (EE)', 'Eswatini (SZ)', 'Ethiopia (ET)', 'Falkland Islands (FK)', 'Faroe Islands (FO)', 'Fiji (FJ)', 'Finland (FI)', 'France (FR)', 'French Guiana (GF)', 'French Polynesia (PF)', 'French Southern Territories (TF)', 'Gabon (GA)', 'Gambia (GM)', 'Georgia (GE)', 'Germany (DE)', 'Ghana (GH)', 'Gibraltar (GI)', 'Greece (GR)', 'Greenland (GL)', 'Grenada (GD)', 'Guadeloupe (GP)', 'Guam (GU)', 'Guatemala (GT)', 'Guernsey (GG)', 'Guinea (GN)', 'Guinea-Bissau (GW)', 'Guyana (GY)', 'Haiti (HT)', 'Honduras (HN)', 'Hong Kong SAR China (HK)', 'Hungary (HU)', 'Iceland (IS)', 'India (IN)', 'Indonesia (ID)', 'Iran (IR)', 'Iraq (IQ)', 'Ireland (IE)', 'Isle of Man (IM)', 'Israel (IL)', 'Italy (IT)', 'Jamaica (JM)', 'Japan (JP)', 'Jersey (JE)', 'Jordan (JO)', 'Kazakhstan (KZ)', 'Kenya (KE)', 'Kiribati (KI)', 'Kosovo (XK)', 'Kuwait (KW)', 'Kyrgyzstan (KG)', 'Laos (LA)', 'Latvia (LV)', 'Lebanon (LB)', 'Lesotho (LS)', 'Libya (LY)', 'Liechtenstein (LI)', 'Lithuania (LT)', 'Luxembourg (LU)', 'Macao SAR China (MO)', 'Madagascar (MG)', 'Malawi (MW)', 'Maldives (MV)', 'Mali (ML)', 'Malta (MT)', 'Martinique (MQ)', 'Mauritania (MR)', 'Mauritius (MU)', 'Mayotte (YT)', 'Mexico (MX)', 'Micronesia (FM)', 'Moldova (MD)', 'Monaco (MC)', 'Mongolia (MN)', 'Montenegro (ME)', 'Montserrat (MS)', 'Morocco (MA)', 'Mozambique (MZ)', 'Myanmar (Burma) (MM)', 'Namibia (NA)', 'Nauru (NR)', 'Nepal (NP)', 'Netherlands (NL)', 'New Caledonia (NC)', 'New Zealand (NZ)', 'Nicaragua (NI)', 'Niger (NE)', 'Nigeria (NG)', 'Niue (NU)', 'Norfolk Island (NF)', 'North Macedonia (MK)', 'Northern Mariana Islands (MP)', 'Norway (NO)', 'Oman (OM)', 'Pakistan (PK)', 'Palau (PW)', 'Palestinian Territories (PS)', 'Papua New Guinea (PG)', 'Paraguay (PY)', 'Peru (PE)', 'Philippines (PH)', 'Pitcairn Islands (PN)', 'Poland (PL)', 'Portugal (PT)', 'Pseudo-Accents (XA)', 'Pseudo-Bidi (XB)', 'Puerto Rico (PR)', 'Qatar (QA)', 'Réunion (RE)', 'Romania (RO)', 'Russia (RU)', 'Rwanda (RW)', 'Samoa (WS)', 'San Marino (SM)', 'São Tomé & Príncipe (ST)', 'Saudi Arabia (SA)', 'Senegal (SN)', 'Serbia (RS)', 'Seychelles (SC)', 'Sierra Leone (SL)', 'Singapore (SG)', 'Sint Maarten (SX)', 'Slovakia (SK)', 'Slovenia (SI)', 'Solomon Islands (SB)', 'Somalia (SO)', 'South Africa (ZA)', 'South Georgia & South Sandwich Islands (GS)', 'South Sudan (SS)', 'Spain (ES)', 'Sri Lanka (LK)', 'St. Barthélemy (BL)', 'St. Helena (SH)', 'St. Kitts & Nevis (KN)', 'St. Lucia (LC)', 'St. Martin (MF)', 'St. Pierre & Miquelon (PM)', 'St. Vincent & Grenadines (VC)', 'Sudan (SD)', 'Suriname (SR)', 'Svalbard & Jan Mayen (SJ)', 'Sweden (SE)', 'Switzerland (CH)', 'Syria (SY)', 'Taiwan (TW)', 'Tajikistan (TJ)', 'Tanzania (TZ)', 'Thailand (TH)', 'Timor-Leste (TL)', 'Togo (TG)', 'Tokelau (TK)', 'Tonga (TO)', 'Trinidad & Tobago (TT)', 'Tristan da Cunha (TA)', 'Tunisia (TN)', 'Turkey (TR)', 'Turkmenistan (TM)', 'Turks & Caicos Islands (TC)', 'Tuvalu (TV)', 'U.S. Outlying Islands (UM)', 'U.S. Virgin Islands (VI)', 'Uganda (UG)', 'Ukraine (UA)', 'United Arab Emirates (AE)', 'United Kingdom (GB)', 'United States (US)', 'Uruguay (UY)', 'Uzbekistan (UZ)', 'Vanuatu (VU)', 'Vatican City (VA)', 'Venezuela (VE)', 'Vietnam (VN)', 'Wallis & Futuna (WF)', 'Western Sahara (EH)', 'Yemen (YE)', 'Zambia (ZM)', 'Zimbabwe (ZW)'
				];

			var flag_options = `
				<option></option>
				<optgroup label="Suggested"></optgroup>
					<option value="Panama">&nbsp;&nbsp;&nbsp;&nbsp;Panama (PA)</option>
					<option value="Marshall Islands">&nbsp;&nbsp;&nbsp;&nbsp;Marshall Islands (MH)</option>
					<option value="Malaysia">&nbsp;&nbsp;&nbsp;&nbsp;Malaysia (MY)</option>
					<option value="Korea">&nbsp;&nbsp;&nbsp;&nbsp;Korea (KR)</option>
					<option value="Liberia">&nbsp;&nbsp;&nbsp;&nbsp;Liberia (LR)</option>
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
        		'', 'HYPERTENSION', 'DIABETES', "POLYPS", 'GALLSTONE', 'MEASLES', 'CHICKEN POX', 'COVID-19'
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
            	        <div class="form-group col-md-2">
            	            <label for="${mcType}${count}">Type</label>
            	            <select class="${docu_class} ${mcType}" name="${mcType}${count}">
            	            	<option></option>
            	            	<option value="MEDICAL CERTIFICATE">MEDICAL CERTIFICATE</option>
            	            	<option value="FLAG MEDICAL">FLAG MEDICAL</option>
            	            	<option value="YELLOW FEVER">YELLOW FEVER</option>
            	            	<option value="POLIO VACCINE (IPV)">POLIO VACCINE (IPV)</option>
            	            	<option value="CHOLERA">CHOLERA</option>
            	            	<option value="CHEMICAL TEST">CHEMICAL TEST</option>
            	            	<option value="DRUG AND ALCOHOL TEST">DRUG AND ALCOHOL TEST</option>
            	            	<option value="MMR">MMR VACCINE</option>
            	            	<option value="TYPHOID">TYPHOID</option>
            	            	<option value="COVID-19 1ST DOSE">COVID-19 1ST DOSE</option>
            	            	<option value="COVID-19 2ND DOSE">COVID-19 2ND DOSE</option>
            	            	<option value="COVID-19 3RD DOSE">COVID-19 3RD DOSE</option>
            	            	<option value="COVID-19 4TH DOSE">COVID-19 4TH DOSE</option>
            	            	<option value="COVID-19 5TH DOSE">COVID-19 5TH DOSE</option>
            	            	<option value="COVID-19 6TH DOSE">COVID-19 6TH DOSE</option>
            	            	<option value="BENZENE TEST">BENZENE TEST</option>
            	            </select>
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${mcType}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-2">
            	            <label for="${clinic}${count}">Clinic\\Covid Vaccine Brand</label>
            	            <select class="${docu_class} ${clinic}" name="${clinic}${count}">
            	            	<option></option>
            	            	<optgroup label="Suggested"></optgroup>
	            	            	<option value="MICAH">&nbsp;&nbsp;&nbsp;MICAH</option>
	            	            	<option value="SUPERCARE">&nbsp;&nbsp;&nbsp;SUPERCARE</option>
	            	            	<option value="SM LAZO">&nbsp;&nbsp;&nbsp;SM LAZO</option>
	            	            	<option value="PHYSICIAN">&nbsp;&nbsp;&nbsp;PHYSICIAN</option>
	            	            	<option value="HALCION">&nbsp;&nbsp;&nbsp;HALCION</option>
	            	            	<option value="MMC">&nbsp;&nbsp;&nbsp;MMC</option>
	            	            	<option value="MCIS">&nbsp;&nbsp;&nbsp;MCIS</option>
	            	            	<option value="BUREAU OF QUARANTINE">&nbsp;&nbsp;&nbsp;BUREAU OF QUARANTINE</option>
            	            	<optgroup label="Covid Vaccine Brand">&nbsp;&nbsp;&nbsp;</optgroup>
	            	            	<option value="SINOVAC">&nbsp;&nbsp;&nbsp;SINOVAC</option>
	            	            	<option value="ASTRAZENECA">&nbsp;&nbsp;&nbsp;ASTRAZENECA</option>
	            	            	<option value="MODERNA">&nbsp;&nbsp;&nbsp;MODERNA</option>
	            	            	<option value="PFIZER">&nbsp;&nbsp;&nbsp;PFIZER</option>
	            	            	<option value="SPUTNIK">&nbsp;&nbsp;&nbsp;SPUTNIK</option>
	            	            	<option value="SINOPHARM">&nbsp;&nbsp;&nbsp;SINOPHARM</option>
	            	            	<option value="BHARAT">&nbsp;&nbsp;&nbsp;BHARAT</option>
	            	            	<option value="FCN">&nbsp;&nbsp;&nbsp;FCN</option>
	            	            	<option value="JOHNSON AND JOHNSON">&nbsp;&nbsp;&nbsp;JOHNSON AND JOHNSON</option>
            	            </select>
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${clinic}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-2">
            	            <label for="${issuer}${count}">Issuer</label>
            	            <input type="text" class="${docu_class} ${issuer}" name="${issuer}${count}" placeholder="Enter Issuer">
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${issuer}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-2">
            	            <label for="${number}${count}">Number</label>
            	            <input type="text" class="${docu_class} ${number}" name="${number}${count}" placeholder="Enter Number">
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${number}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-2">
            	            <label for="${issue_date}${count}">Issue Date</label>
            	            <input type="text" class="${docu_class} ${issue_date}" name="${issue_date}${count}" placeholder="Select Issue Date">
            	            <span class="invalid-feedback hidden" role="alert">
            	                <strong id="${issue_date}${count}Error"></strong>
            	            </span>
            	        </div>
            	        <div class="form-group col-md-2">
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
            	let config = {
	                altInput: true,
	                altFormat: 'F j, Y',
	                dateFormat: 'Y-m-d',
	            };

	            $(`[name="${issue_date}${count}"]`).flatpickr({
	            	...config,
	            	...{
	            		maxDate: moment().format('YYYY-MM-DD')
	            	}
	            });
	            $(`[name="${expiry_date}${count}"]`).flatpickr(config);
            // }
			
			// IF ISSUE DATE SELECTED MODIFY MIN EXPIRY DATE
			$(`[name="${issue_date}${count}"]`).on('change', e => {
				let expiry = $(e.target).parent().parent().find('.docu-expiry_date');
				
				if(e.target.value != ""){
					$(expiry[0]).flatpickr({
		            	...config,
		            	...{
		            		minDate: moment(e.target.value).add(1, 'day').format('YYYY-MM-DD')
		            	}
		            });
				}
			})

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

	        // EXPIRY NOTIFICATIONS
	        $('.ID .docu-dtype').change(e => {
	        	if(e.target.value == "PASSPORT" || e.target.value == "SEAMAN BOOK"){
	        		let input = $(e.target).parent().parent().find('.docu-number');

	        		let length = e.target.value == "PASSPORT" ? 9 : 8;

        			input.off('change');

        			input.change(e => {
        				if(e.target.value.length != length){
        					swal({
        						type: 'error',
        						title: 'Invalid input. Check length.',
        					}).then(() => {
        						showError(input, $(input), $('#' + input.attr('name') + 'Error'), 'Invalid input');
        					})
        				}
        				else{
        					clearError(input, $(input), $('#' + input.attr('name') + 'Error'));
        				}
        			});

        			checkExpiry(e);

        			$($(e.target).parent().parent().find('.docu-expiry_date')).change(() => {
        				checkExpiry(e);
        			});

        			if(input.val() != ""){
        				input.trigger('change');
        			}
	        	}
	        });
        }

        function checkExpiry(e){
    		let issue = $(e.target).parent().parent().find('.docu-issue_date');
    		let expiry = $(e.target).parent().parent().find('.docu-expiry_date');

			let array = [];
			[issue, expiry].forEach(inputDate => {
				let date = inputDate[0].value;
				if(date != ""){
					array.push(date);
				}
			});

        	if(array.length == 2){
        		let now = moment().startOf('day');
        		
        		let years = moment(array[1]).diff(now, 'years');
        		now = now.add(years, 'years');

        		let months = moment(array[1]).diff(now, 'months');
        		now = now.add(months, 'months');

        		let days = moment(array[1]).diff(now, 'days');

        		let length = e.target.value == "PASSPORT" ? 18 : 12;

        		if(months <= 0 && days <= 0 && years <= 0){
        			swal({
        				type: 'info',
        				title: e.target.value + ` is expired`,
        			})
        		}
        		else if((months + (years * 12)) < length){
        			swal({
        				type: 'info',
        				title: e.target.value + ` will expire in\n${months + (years * 12)} month/s ${days} day/s`,
        			})
        		}
        	}
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
	        					'LICENSE', 'BOOKLET', 'GMDSS/GOC', 'GMDSS/GOC BOOKLET', 'SSO', 'SDSD', 'CT'
	        				]
	        			},
	        			{
	        				range: [
	        					[5,8]
	        				],
	        				documents: [
	        					'LICENSE', 'BOOKLET', 'SSO', "SDSD", 'CT'
	        				]
	        			},
	        			{
	        				range: [
	        					[9,23],
	        					[27,57]
	        				],
	        				documents: [
	        					'BOOKLET', 'SDSD', 'ENDORSEMENT', 'CT'
	        				]
	        			},
	        			{
	        				range: [
	        					[24,26],
	        					[57]
	        				],
	        				documents: [
	        					'BOOKLET', 'SDSD', "SHIP'S COOK ENDORSEMENT", 'CT'
	        				]
	        			},
        				{
        					range: [
        						[1,57]
        					],
        					documents: [
        						'BTOC', 'ATOT', 'ATCT'
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
        						[9,57]
        					],
        					documents: [
        						'BOOKLET', 'SDSD'
        					]
        				},
        				{
        					range: [
        						[1,57]
        					],
        					documents: [
        						'BT', 'PSCRB', 'AFF', 'MEFA', 'MECA', 'BTOC', 'ATOT', 'ATCT'
        					]
        				},
	        			{
	        				range: [
	        					[24,26],
	        					[57]
	        				],
	        				documents: [
	        					"SHIP'S COOK ENDORSEMENT"
	        				]
	        			}
        			]
        		},
        		{
        			country: 'Korea',
        			details: [
        				{
        					range: [
        						[1,57]
        					],
        					documents: [
        						'LICENSE', 'BOOKLET', 'PSCRB', 'BTOC', 'ATOT', 'ATCT'
        					]
        				}
        			]
        		},
        		{
        			country: 'Liberia',
        			details: [
        				{
        					range: [
        						[1,57]
        					],
        					documents: [
        						'LICENSE', 'BOOKLET', 'CRA', 'BTOC', 'ATOT', 'ATCT'
        					]
        				},
        				{
        					range: [
        						[24,26],
        						[57]
        					],
        					documents: [
        						"SHIP'S COOK ENDORSEMENT", 'CRA'
        					]
        				},
        				{
        					range: [
        						[1,57]
        					],
        					documents: [
        						'BT', 'PSCRB', 'AFF', 'MEFA', 'MECA', 'SDSD', 'CRA'
        					]
        				},
        			]
        		},
        		{
        			country: 'Malaysia',
        			details: [
        				{
        					range: [
        						[1,57]
        					],
        					documents: [
        						'LICENSE', 'BOOKLET'
        					]
        				}
        			]
        		},
        		{
        			country: 'General',
        			details: [
        				{
        					range: [
        						[1,57]
        					],
        					documents: [
        						'LICENSE', 'BTOC', 'ATOT', 'ATCT'
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
        	let docu_class = "form-control";
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
        // LICENSES
        	{
        		range: [1, 2],
        		issuer: 'MARINA',
        		documents: [
        			'COC', 'COE', 'GMDSS/GOC'
        		],
        		regulation: [
        			['II/2', 'IV/2'],
        			['II/2', 'IV/2'],
        			['IV/2'],
        		]
        	},
        	{
        		range: [3, 4],
        		issuer: 'MARINA',
        		documents: [
        			'COC', 'COE', 'GMDSS/GOC'
        		],
        		regulation: [
        			['II/1', 'IV/2'],
        			['II/1', 'IV/2'],
        			['IV/2'],
        		]
        	},
        	{
        		range: [5, 6],
        		issuer: 'MARINA',
        		documents: [
        			'COC', 'COE'
        		],
        		regulation: [
        			['III/2'],
        			['III/2']
        		]
        	},
        	{
        		range: [7, 8],
        		issuer: 'MARINA',
        		documents: [
        			'COC', 'COE'
        		],
        		regulation: [
        			['III/1'],
        			['III/1']
        		]
        	},
        	{
        		range: [9, 14],
        		issuer: 'MARINA',
        		documents: [
        			'COC', 'COE'
        		],
        		regulation: [
        			['II/4'],
        			['II/5']
        		]
        	},
        	{
        		range: [15, 23],
        		issuer: 'MARINA',
        		documents: [
        			'COC', 'COE'
        		],
        		regulation: [
        			['III/4'],
        			['III/5']
        		]
        	},
        	{
        		range: [24, 29],
        		issuer: 'TESDA',
        		documents: [
        			'NCI', 'NCII', 'NCIII'
        		],
        		regulation: [
        			[],[],[]
        		]
        	},
        // CERTIFICATES
        	// ALL OFFICERS
        	{
        		range: [1, 8],
        		issuer: 'MARINA',
        		documents: [
        			'BASIC TRAINING - BT',
        			'PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB',
        			'ADVANCE FIRE FIGHTING - AFF',
        			'MEDICAL FIRST AID - MEFA',
        			'MEDICAL CARE - MECA',
        			'SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD',
        			'SHIP SECURITY OFFICER - SSO',
        		],
        		regulation: [
        			['VI/1'], ['VI/2.1'],
        			['VI/3'], ['VI/4.1'],
        			['VI/4.2'], ['VI/6'],
        			['VI/5'],
        		]
        	},
        	// ALL DECK OFFICERS
        	{
        		range: [1, 4],
        		issuer: '',
        		documents: [
        			'ECDIS',
        			// ECDIS SPECIFIC
        			'SSBT WITH BRM',
        			'ARPA TRAINING COURSE',
        			'RADAR SIMULATOR COURSE',
        		],
        		regulation: [
        			[], [], [], []
        		]
        	},
        	// ALL ENGINE OFFICERS
        	{
        		range: [5, 8],
        		issuer: '',
        		documents: [
        			'ERS WITH ERM',
        		],
        		regulation: [
        			[]
        		]
        	},
        	// ALL SENIOR OFFICERS
        	{
        		range: [1, 2],
        		issuer: '',
        		documents: [
        			'MLC TRAINING F1',
        			'MLC TRAINING F2',
        			'MLC TRAINING F3',
        			'MLC TRAINING F4'
        		],
        		regulation: [
        			[], [], [], []
        		]
        	},
        	{
        		range: [5, 6],
        		issuer: '',
        		documents: [
        			'MLC TRAINING F1',
        			'MLC TRAINING F2',
        			'MLC TRAINING F3',
        			'MLC TRAINING F4'
        		],
        		regulation: [
        			[], [], [], []
        		]
        	},
        	// ALL JUNIOR OFFICER
        	{
        		range: [3, 4],
        		issuer: '',
        		documents: [
        			'OLC TRAINING F1',
        			'OLC TRAINING F2',
        			'OLC TRAINING F3',
        			'OLC TRAINING F4'
        		],
        		regulation: [
        			[], [], [], []
        		]
        	},
        	{
        		range: [7, 8],
        		issuer: '',
        		documents: [
        			'OLC TRAINING F1',
        			'OLC TRAINING F2',
        			'OLC TRAINING F3',
        			'OLC TRAINING F4'
        		],
        		regulation: [
        			[], [], [], []
        		]
        	},
        	// ALL RATINGS
        	{
        		range: [9, 23],
        		issuer: 'MARINA',
        		documents: [
        			'BASIC TRAINING - BT',
        			'PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB',
        		],
        		regulation: [
        			['VI/1'], ['VI/2.1'],
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

            // ERASE ALL LC DOCUMENTS
			@if(!isset($edit))
	            $('.lc .row, .lc hr').remove();
	            $(`.lcCount`)[0].innerText = 0;
			@endif

            list.every(row => {
            	if(rank >= row.range[0] && rank <= row.range[1]){
            		row.documents.forEach((docu, index) => {
            			
            			// IF DOCUMENT IS EXISTING IN LC, SKIP
						@if(isset($edit))
	            			if($(`select.docu-lctype [value="${docu}"]:selected`).length){
	            				return
	            			}
	            			// else{
		            		// 	$(`[name^="docu-lctype"] [value="${docu}"]`).parent().hide();
		            		// 	let match = $(`.lc [value="${docu}"]`);

		            		// 	if(match.length > 0){
		            		// 		ctr += 1;
		            		// 		let row = $(match[match.length - 1]).parent().parent().parent();
		            		// 		row.next().hide();
		            		// 		row.hide();
		            		// 	}
	            			// }
	            		@endif
            			// END

            			let count = $('.docu').length + 1;
            			addDocu('lc');
            			
            			// CHECK IF DOCUMENT IS IN OPTION, IF NOT ADD OPTION AND PRESELECT IT
        				checkIfExisting($(`[name="docu-lctype${count}"]`), docu);
        				// if($(`[name="docu-lctype${count}"]`).find(`option[value="${docu}"]`).length){
        				// 	$(`[name="docu-lctype${count}"]`).val(docu).trigger('change');
        				// }
        				// else{
        				// 	let option = new Option(docu, docu, true, true);
        				// 	$(`[name="docu-lctype${count}"]`).append(option).trigger('change');
        				// }
        				// if($(`[name="docu-issuer${count}"]`).find(`option[value="${row.issuer}"]`).length){
        				// 	$(`[name="docu-issuer${count}"]`).val(row.issuer).trigger('change');
        				// }
        				// else{
        				// 	let option = new Option(row.issuer, row.issuer, true, true);
        				// 	$(`[name="docu-issuer${count}"]`).append(option).trigger('change');
        				// }

        				checkIfExisting($(`[name="docu-issuer${count}"]`), row.issuer);
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

        // ADD OPTION
        function checkIfExisting(element, docu){
			if(element.find(`option[value="${docu}"]`).length){
				element.val(docu).trigger('change');
			}
			else{
				addOption(element, docu);
			}
        }

        function addOption(element, docu){
        	let option = new Option(docu, docu, true, true);
			$(element).append(option).trigger('change');
        }
    </script>
@endpush
