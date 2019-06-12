<div id="docu"></div>

@push('before-scripts')
    <script>
        function addDocu(type){
            $(`.${type}Count`)[0].innerText = parseInt($(`.${type}Count`)[0].innerText) + 1;

            let count = $('.docu').length + 1;

            let docu_class = 'form-control aeigh';
            let docu_class2 = 'form-control';

            if($(`.${type}`).length == 0){
            	let temp = type == 'lc'? 'License/Certificates/Contracts' : type;
                appenddocu(`<div class="${type}"><u><h3><strong>${temp}</strong></h3></u>`);
            }
            else{
                appenddocu('<div>');
            }

            let string;

            let dType = "docu-dtype";
            let lcType = "docu-lctype";
            let number = 'docu-number';
        	let issue_date = 'docu-issue_date';
        	let expiry_date = 'docu-expiry_date';

        	let country = "docu-country";
        	let booklet_no = "docu-bookletNo";
        	let license_no = "docu-licenseNo";
        	let goc = "docu-goc";
        	let sso = "docu-sso";
        	let sdsd = "docu-sdsd";

        	let issuer = "docu-issuer";

        	// CREATE ID OPTIONS
        	var id_options = "";
        	var idOptions = [
        		'', 'PASSPORT', 'US-VISA', 'NATIONAL SEAMAN BOOK', 'FLAG STATE SEAMAN BOOK (I.D BOOK)','MCV W/ PPRT'
        	];

        	idOptions.forEach(docu => {
				id_options += `<option value="${docu}">${docu}</option>`
			});

			//CREATE LC OPTIONS
			var lc_options = "";
			var lcOptions = [
				'', 'NATIONAL LICENSE', 'FLAG STATE SEAMAN BOOK (I.D BOOK)', 'FLAG STATE S.Q. FOR TANKERS', 'FLAG STATE LICENSE', 'FLAG STATE SSO LICENSE', 'FLAG STATE ENDORSEMENT COOK COURSE', 'MEDICAL CERTIFICATE', 'NATIONAL STCW-WATCH KEEPING', 'NATIONAL GMDSS-GOC', 'FLAG STATE GMDSS-GOC', 'RADAR TRAINING COURSE', 'ARPA TRAINING COURSE', 'SAFETY COURSE, BASIC', 'SAFETY COURSE, SURVIVAL CRAFT', 'SAFETY COURSE, FIRE FIGHTING', 'SAFETY COURSE, FIRST AID', 'SAFETY COURSE, RESCUE BOAT', 'TANKER COURSE, FAMILIARIZATION', 'VACCINATION - Y. FEVER', 'DRUG AND ALCOHOL TEST', 'DANGEROUS FLUID CARGO COURSE', 'SAFETY OFFICER\'S TRAINING COURSE', 'MEDICAL CARE COURSE', 'SHIP HANDLING SIMULATION', 'POLLUTION PREVENTION COURSE', 'ECDIS', 'BRIDGE TEAM/RESOURCE MANAGEMENT', 'RISK ASSESSMENT/INCIDENT INVESTIGATION COURSE', 'ISM COURSE', 'ISPS / SSO COURSE / SDSD', 'TANKER COURSE, ADVANCED - OIL', 'TANKER COURSE, ADVANCED - CHEMICAL', 'TANKER COURSE, ADVANCED - LPG'
			];

        	lcOptions.forEach(docu => {
				lc_options += `<option value="${docu}">${docu}</option>`
			});

			// COUNTRIES
			var flag_countries = [
				'', 'Afghanistan (AF)', 'Åland Islands (AX)', 'Albania (AL)', 'Algeria (DZ)', 'American Samoa (AS)', 'Andorra (AD)', 'Angola (AO)', 'Anguilla (AI)', 'Antarctica (AQ)', 'Antigua & Barbuda (AG)', 'Argentina (AR)', 'Armenia (AM)', 'Aruba (AW)', 'Ascension Island (AC)', 'Australia (AU)', 'Austria (AT)', 'Azerbaijan (AZ)', 'Bahamas (BS)', 'Bahrain (BH)', 'Bangladesh (BD)', 'Barbados (BB)', 'Belarus (BY)', 'Belgium (BE)', 'Belize (BZ)', 'Benin (BJ)', 'Bermuda (BM)', 'Bhutan (BT)', 'Bolivia (BO)', 'Bosnia & Herzegovina (BA)', 'Botswana (BW)', 'Brazil (BR)', 'British Indian Ocean Territory (IO)', 'British Virgin Islands (VG)', 'Brunei (BN)', 'Bulgaria (BG)', 'Burkina Faso (BF)', 'Burundi (BI)', 'Cambodia (KH)', 'Cameroon (CM)', 'Canada (CA)', 'Canary Islands (IC)', 'Cape Verde (CV)', 'Caribbean Netherlands (BQ)', 'Cayman Islands (KY)', 'Central African Republic (CF)', 'Ceuta & Melilla (EA)', 'Chad (TD)', 'Chile (CL)', 'China (CN)', 'Christmas Island (CX)', 'Cocos (Keeling) Islands (CC)', 'Colombia (CO)', 'Comoros (KM)', 'Congo - Brazzaville (CG)', 'Congo - Kinshasa (CD)', 'Cook Islands (CK)', 'Costa Rica (CR)', 'Côte d’Ivoire (CI)', 'Croatia (HR)', 'Cuba (CU)', 'Curaçao (CW)', 'Cyprus (CY)', 'Czechia (CZ)', 'Denmark (DK)', 'Diego Garcia (DG)', 'Djibouti (DJ)', 'Dominica (DM)', 'Dominican Republic (DO)', 'Ecuador (EC)', 'Egypt (EG)', 'El Salvador (SV)', 'Equatorial Guinea (GQ)', 'Eritrea (ER)', 'Estonia (EE)', 'Eswatini (SZ)', 'Ethiopia (ET)', 'Falkland Islands (FK)', 'Faroe Islands (FO)', 'Fiji (FJ)', 'Finland (FI)', 'France (FR)', 'French Guiana (GF)', 'French Polynesia (PF)', 'French Southern Territories (TF)', 'Gabon (GA)', 'Gambia (GM)', 'Georgia (GE)', 'Germany (DE)', 'Ghana (GH)', 'Gibraltar (GI)', 'Greece (GR)', 'Greenland (GL)', 'Grenada (GD)', 'Guadeloupe (GP)', 'Guam (GU)', 'Guatemala (GT)', 'Guernsey (GG)', 'Guinea (GN)', 'Guinea-Bissau (GW)', 'Guyana (GY)', 'Haiti (HT)', 'Honduras (HN)', 'Hong Kong SAR China (HK)', 'Hungary (HU)', 'Iceland (IS)', 'India (IN)', 'Indonesia (ID)', 'Iran (IR)', 'Iraq (IQ)', 'Ireland (IE)', 'Isle of Man (IM)', 'Israel (IL)', 'Italy (IT)', 'Jamaica (JM)', 'Japan (JP)', 'Jersey (JE)', 'Jordan (JO)', 'Kazakhstan (KZ)', 'Kenya (KE)', 'Kiribati (KI)', 'Kosovo (XK)', 'Kuwait (KW)', 'Kyrgyzstan (KG)', 'Laos (LA)', 'Latvia (LV)', 'Lebanon (LB)', 'Lesotho (LS)', 'Liberia (LR)', 'Libya (LY)', 'Liechtenstein (LI)', 'Lithuania (LT)', 'Luxembourg (LU)', 'Macao SAR China (MO)', 'Madagascar (MG)', 'Malawi (MW)', 'Malaysia (MY)', 'Maldives (MV)', 'Mali (ML)', 'Malta (MT)', 'Marshall Islands (MH)', 'Martinique (MQ)', 'Mauritania (MR)', 'Mauritius (MU)', 'Mayotte (YT)', 'Mexico (MX)', 'Micronesia (FM)', 'Moldova (MD)', 'Monaco (MC)', 'Mongolia (MN)', 'Montenegro (ME)', 'Montserrat (MS)', 'Morocco (MA)', 'Mozambique (MZ)', 'Myanmar (Burma) (MM)', 'Namibia (NA)', 'Nauru (NR)', 'Nepal (NP)', 'Netherlands (NL)', 'New Caledonia (NC)', 'New Zealand (NZ)', 'Nicaragua (NI)', 'Niger (NE)', 'Nigeria (NG)', 'Niue (NU)', 'Norfolk Island (NF)', 'North Korea (KP)', 'North Macedonia (MK)', 'Northern Mariana Islands (MP)', 'Norway (NO)', 'Oman (OM)', 'Pakistan (PK)', 'Palau (PW)', 'Palestinian Territories (PS)', 'Panama (PA)', 'Papua New Guinea (PG)', 'Paraguay (PY)', 'Peru (PE)', 'Philippines (PH)', 'Pitcairn Islands (PN)', 'Poland (PL)', 'Portugal (PT)', 'Pseudo-Accents (XA)', 'Pseudo-Bidi (XB)', 'Puerto Rico (PR)', 'Qatar (QA)', 'Réunion (RE)', 'Romania (RO)', 'Russia (RU)', 'Rwanda (RW)', 'Samoa (WS)', 'San Marino (SM)', 'São Tomé & Príncipe (ST)', 'Saudi Arabia (SA)', 'Senegal (SN)', 'Serbia (RS)', 'Seychelles (SC)', 'Sierra Leone (SL)', 'Singapore (SG)', 'Sint Maarten (SX)', 'Slovakia (SK)', 'Slovenia (SI)', 'Solomon Islands (SB)', 'Somalia (SO)', 'South Africa (ZA)', 'South Georgia & South Sandwich Islands (GS)', 'South Korea (KR)', 'South Sudan (SS)', 'Spain (ES)', 'Sri Lanka (LK)', 'St. Barthélemy (BL)', 'St. Helena (SH)', 'St. Kitts & Nevis (KN)', 'St. Lucia (LC)', 'St. Martin (MF)', 'St. Pierre & Miquelon (PM)', 'St. Vincent & Grenadines (VC)', 'Sudan (SD)', 'Suriname (SR)', 'Svalbard & Jan Mayen (SJ)', 'Sweden (SE)', 'Switzerland (CH)', 'Syria (SY)', 'Taiwan (TW)', 'Tajikistan (TJ)', 'Tanzania (TZ)', 'Thailand (TH)', 'Timor-Leste (TL)', 'Togo (TG)', 'Tokelau (TK)', 'Tonga (TO)', 'Trinidad & Tobago (TT)', 'Tristan da Cunha (TA)', 'Tunisia (TN)', 'Turkey (TR)', 'Turkmenistan (TM)', 'Turks & Caicos Islands (TC)', 'Tuvalu (TV)', 'U.S. Outlying Islands (UM)', 'U.S. Virgin Islands (VI)', 'Uganda (UG)', 'Ukraine (UA)', 'United Arab Emirates (AE)', 'United Kingdom (GB)', 'United States (US)', 'Uruguay (UY)', 'Uzbekistan (UZ)', 'Vanuatu (VU)', 'Vatican City (VA)', 'Venezuela (VE)', 'Vietnam (VN)', 'Wallis & Futuna (WF)', 'Western Sahara (EH)', 'Yemen (YE)', 'Zambia (ZM)', 'Zimbabwe (ZW)'];
			var flag_options = "";

        	flag_countries.forEach(docu => {
				flag_options += `<option value="${docu}">${docu}</option>`
			});


        	//<input type="hidden" name="docu-type${count}" value="${type}">
            if(type == "ID"){
            	string = `
	            	    <div class="row docu">

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
	            	            <input type="text" class="${docu_class} ${issuer}" name="${issuer}${count}" placeholder="Enter Issuer">
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
	            	    <hr>
	            	</div>`;
            }
            else if(type == "Flag"){

	            	            // <input type="text" class="${docu_class} ${country}" name="${country}${count}" placeholder="Enter Country">

            	string = `
	            	    <div class="row docu">
							
	            	        <div class="form-group col-md-3">
	            	            <label for="${country}${count}">Country</label>
	            	            <select class="${docu_class} ${country}" name="${country}${count}">
	            	            	${flag_options}
	            	            </select>
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${country}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	        <div class="form-group col-md-3">
	            	            <label for="${booklet_no}${count}">Booklet No.</label>
	            	            <input type="text" class="${docu_class} ${booklet_no}" name="${booklet_no}${count}" placeholder="Enter Booklet No.">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${booklet_no}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	        <div class="form-group col-md-3">
	            	            <label for="${license_no}${count}">License No.</label>
	            	            <input type="text" class="${docu_class} ${license_no}" name="${license_no}${count}" placeholder="Enter License No.">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${license_no}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	        <div class="form-group col-md-3">
	            	            <label for="${goc}${count}">GOC</label>
	            	            <input type="text" class="${docu_class} ${goc}" name="${goc}${count}" placeholder="Enter GOC">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${goc}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	        <div class="form-group col-md-3">
	            	            <label for="${sso}${count}">SSO</label>
	            	            <input type="text" class="${docu_class} ${sso}" name="${sso}${count}" placeholder="Enter SSO">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${sso}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	        <div class="form-group col-md-3">
	            	            <label for="${sdsd}${count}">SDSD</label>
	            	            <input type="text" class="${docu_class} ${sdsd}" name="${sdsd}${count}" placeholder="Enter SDSD">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${sdsd}${count}Error"></strong>
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
	            	    <hr>
	            	</div>`;
            }
            else{
            	string = `
	            	    <div class="row docu">
							
	            	        <div class="form-group col-md-4">
	            	            <label for="${lcType}${count}">License/Certificate Type</label>
	            	            <select class="${docu_class} ${lcType}" name="${lcType}${count}">
	            	            	${lc_options}
	            	            </select>
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${lcType}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	        <div class="form-group col-md-4">
	            	            <label for="${issuer}${count}">Issuer</label>
	            	            <input type="text" class="${docu_class2} ${issuer}" name="${issuer}${count}" placeholder="Enter Issuer">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${issuer}${count}Error"></strong>
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
	            	    <hr>
	            	</div>`;
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
            }
            else if(type == "Flag"){
            	$(`[name="${country}${count}"]`).select2({
            		placeholder: 'Select Flag',
            		tags: true
            	});
            }
            else{
            	$(`[name="${lcType}${count}"]`).select2({
            		placeholder: 'Select Type',
            		tags: true
            	});
            }
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
        setTimeout(() => {
        	asd();
        }, 500);
    </script>
@endpush