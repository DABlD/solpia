{{-- INCLUDED ON vessels.index --}}

<script>
	
	function showTables(onBoard, linedUp, ranks, vid){
	    let table = `
	        <table class="table table-bordered table-striped">
	            <thead>
	                <tr>
	                    <td><b>No.</b></td>
	                    <td><b>Rank</b></td>
	                    <td><b>Name</b></td>
	                    <td><b>Age</b></td>
	                    <td><b>Passport Exp.</b></td>
	                    <td><b>Sbook Exp.</b></td>
	                    <td><b>US Visa Exp.</b></td>
	                    <td><b>Status</b></td>
	                    <td><b>Remarks</b></td>
	                    @if(auth()->user()->role != "Principal")
	                    <td><b>Actions</b></td>
	                    @endif
	                </tr>
	            </thead>
	            <tbody>
	    `;

	    let table2 = `
	        <table class="table table-bordered table-striped">
	            <thead>
	                <tr>
	                    <td><b>No.</b></td>
	                    <td><b>Rank</b></td>
	                    @if(in_array(auth()->user()->fleet, ["FLEET B"]) || auth()->user()->id == 23)
	                        <td><b>SL</b></td>
	                    @endif
	                    <td><b>Name</b></td>
	                    <td><b>Age</b></td>
	                    <td><b>Joining Date</b></td>
	                    <td><b>MOB</b></td>
	                    <td><b>Contract<br>Duration</b></td>
	                    <td><b>End of<br>Contract</b></td>
	                    <td><b>Passport Exp.</b></td>
	                    <td><b>Sbook Exp.</b></td>
	                    <td><b>US Visa Exp.</b></td>
	                    <td><b>Joining<br>Port</b></td>
	                    <td><b>Reliever</b></td>
	                    <td><b>Remarks</b></td>
	                    @if(auth()->user()->role != "Principal")
	                        <td><b>Actions</b></td>
	                    @endif
	                </tr>
	            </thead>
	            <tbody>
	    `;

	    let table3 = `
	        <b style="color: red;">Onsigners</b>
	        <table class="table table-bordered custom-striped">
	            <thead>
	                <tr>
	                    <td class="cs1"><b>No.</b></td>
	                    <td class="cs2"><b>Rank</b></td>
	                    <td class="cs3"><b>Name</b></td>
	                    <td class="cs4"><b>DOB</b></td>
	                    <td class="cs5"><b>PASSPORT<br>EXPIRY DATE</b></td>
	                    <td class="cs6"><b>SBOOK<br>EXPIRY DATE</b></td>
	                    <td class="cs7"><b>US VISA<br>EXPIRY DATE</b></td>
	                </tr>
	            </thead>
	            <tbody>
	    `;

	    // LINE UP TABLE
	    linedUp.forEach((crew, index) => {
	        crew.remarks = JSON.parse(crew.remarks);
	        let selected = "";

	        crew.remarks.forEach(remark => {
	            selected += `
	                <option value="${remark}" selected>${remark}</option>
	            `;
	        });

	        crew.remarks = `
	            <select id="table-select-${crew.applicant_id}" data-id="${crew.applicant_id}" multiple>
	                ${selected}
	            </select>
	        `;

	        table += `
	            <tr>
	                <td>${index + 1}</td>
	                <td>${crew.abbr}</td>
	                <td class="LUN" data-id="${crew.applicant_id}">${crew.lname + ', ' + crew.fname + ' ' + (crew.suffix || "") + ' ' + crew.mname}</td>
	                <td>${crew.age}</td>
	                <td>${crew.PASSPORT ? moment(crew.PASSPORT).format('MMM DD, YYYY') : '-----'}</td>
	                <td>${crew["SEAMAN'S BOOK"] ? moment(crew["SEAMAN'S BOOK"]).format('MMM DD, YYYY') : '-----'}</td>
	                <td>${crew["US-VISA"] ? moment(crew["US-VISA"]).format('MMM DD, YYYY') : '-----'}</td>
	                <td>${crew.status2}</td>
	                <td class="remarks">${crew.remarks}</td>
	                @if(auth()->user()->role != "Principal")
	                <td class="actions">
	                    <a class="btn btn-info" data-toggle="tooltip" title="Export Documents" onClick="getContract(${crew.applicant_id})">
	                        <span class="fa fa-file-text"></span>
	                    </a>
	                    <a class="btn btn-primary btn-search" data-toggle="tooltip" onClick="viewInfo(${crew.applicant_id})">
	                        <span class="fa fa-search" onClick="viewInfo(${crew.applicant_id})"></span>
	                    </a>
	                    <a class="btn btn-success" data-toggle="tooltip" title="On-Board" onClick="onBoard(${crew.applicant_id}, ${crew.vessel_id})">
	                        <span class="fa fa-ship"></span>
	                    </a>
	                    <a class="btn btn-danger" data-toggle="tooltip" title="Remove Lineup" onClick="rlu(${crew.applicant_id}, ${crew.vessel_id})">
	                        <span class="fa fa-times"></span>
	                    </a>
	                </td>
	                @endif
	            </tr>
	        `;

	        table3 += `
	            <tr>
	                <td rowspan="2">${index + 1}</td>
	                <td rowspan="2">${crew.abbr}</td>
	                <td rowspan="2">${crew.lname + ', ' + crew.fname + ' ' + (crew.suffix || "") + ' ' + crew.mname}</td>
	                <td rowspan="2">${moment(crew.birthday).format('MMM DD, YYYY')}</td>

	                <td>${crew.PASSPORTn ? crew.PASSPORTn : '-----'}</td>
	                <td>${crew["SEAMAN'S BOOKn"] ? crew["SEAMAN'S BOOKn"] : '-----'}</td>
	                <td>${crew["US-VISAn"] ? crew["US-VISAn"] : '-----'}</td>
	            </tr>

	            <tr>
	                <td>${crew.PASSPORT ? moment(crew.PASSPORT).format('MMM DD, YYYY') : '-----'}</td>
	                <td>${crew["SEAMAN'S BOOK"] ? moment(crew["SEAMAN'S BOOK"]).format('MMM DD, YYYY') : '-----'}</td>
	                <td>${crew["US-VISA"] ? moment(crew["US-VISA"]).format('MMM DD, YYYY') : '-----'}</td>
	            </tr>
	        `;
	    });

	    table3 += `
	        </tbody></table>

	        <b style="color: red;">Offsigners</b>
	        <table class="table table-bordered custom-striped">
	            <thead>
	                <tr>
	                    <td class="cs1"><b>No.</b></td>
	                    <td class="cs2"><b>Rank</b></td>
	                    <td class="cs3"><b>Name</b></td>
	                    <td class="cs4"><b>DOB</b></td>
	                    <td class="cs5"><b>PASSPORT<br>EXPIRY DATE</b></td>
	                    <td class="cs6"><b>SBOOK<br>EXPIRY DATE</b></td>
	                    <td class="cs7"><b>US VISA<br>EXPIRY DATE</b></td>
	                </tr>
	            </thead>
	            <tbody>
	    `;

	    // ON BOARD TABLE
	    let onBoardReliever = [];
	    let relieverRank = [];
	    onBoard.forEach((crew, index) => {
	        crew.remarks = JSON.parse(crew.remarks);
	        let selected = "";
	        let crewRankID = crew.rank_id;
	        let crewRankCategory = ranks[crewRankID].category;

	        if(crewRankCategory.startsWith("DECK")){
	            crewRankCategory = "DECK";
	        }
	        else if(crewRankCategory.startsWith("ENGINE")){
	            crewRankCategory = "ENGINE";
	        }
	        else{
	            crewRankCategory = "GALLEY";
	        }

	        crew.remarks.forEach(remark => {
	            selected += `
	                <option value="${remark}" selected>${remark}</option>
	            `;
	        });

	        crew.remarks = `
	            <select id="table-select-${crew.applicant_id}" data-id="${crew.applicant_id}" multiple>
	                ${selected}
	            </select>
	        `;

	        let reliever = `
	            <select id="table-selectR-${crew.applicant_id}" data-id="${crew.applicant_id}">
	            <option value="">Select Reliever</option>
	            <option value="No Reliever"${crew.reliever == "No Reliever" ? ' selected' : ''}>No Reliever</option>
	        `;

	        linedUp.concat(onBoard).forEach(rengiSno => {
	            let curRankID = rengiSno.rank_id;
	            let curCategory = ranks[curRankID].category;

	            if(curCategory.startsWith("ENGINE")){
	                curCategory = "ENGINE";
	            }
	            else if(curCategory.startsWith("DECK")){
	                curCategory = "DECK";
	            }
	            else if(crewRankID == 11){ //OS OR WPR GALLEY WILL BE AVAILABLE AS RELIEVER
	                curCategory = "DECK";
	            }
	            else if(crewRankID == 17){ //OS OR WPR GALLEY WILL BE AVAILABLE AS RELIEVER
	                curCategory = "ENGINE";
	            }
	            // else{
	            //     curCategory = "GALLEY";
	            // }

	            if((crew.abbr == rengiSno.abbr && crew.applicant_id != rengiSno.applicant_id && rengiSno.status != "On Board") || (curRankID > crewRankID && crewRankCategory == curCategory && rengiSno.status != "Lined-Up")){
	                let name = `${rengiSno.lname + ', ' + rengiSno.fname + ' ' + (rengiSno.suffix || "") + ' ' + rengiSno.mname}`;

	                reliever += `
	                    <option value="${rengiSno.applicant_id}"${rengiSno.applicant_id == crew.reliever ? ' selected' : ''}>${rengiSno.abbr} - ${name}</option>
	                `;

	                if(rengiSno.applicant_id == crew.reliever && curRankID != crewRankID){
	                    onBoardReliever.push(rengiSno.applicant_id);
	                    relieverRank[rengiSno.applicant_id] = crewRankID;
	                }
	            }
	        });

	        let onBoardButton = "";
	        // if(onBoardReliever.includes(crew.applicant_id)){
	            onBoardButton = `
	                <a class="btn btn-sm btn-success" data-toggle="tooltip" title="On Board Promotion" onClick="onBoardPromote(${crew.applicant_id}, ${crew.vessel_id}, ${relieverRank[crew.applicant_id]})">
	                    <span class="fa fa-level-up fa-sm"></span>
	                </a>
	            `;
	        // }

	        let cd = crew.months;
	        let cd2 = crew.months;
	        if(crew.extensions){
	            let tempExt = JSON.parse(crew.extensions);
	            tempExt.forEach(ext => {
	                cd += `+${ext}`;
	                cd2 += parseInt(ext);
	            });
	        }
	        let disembarkation_date = moment(crew.joining_date).add(cd2, 'months');

	        table2 += `
	            <tr>
	                <td>${index + 1}</td>
	                <td>${crew.abbr}</td>
	                @if(in_array(auth()->user()->fleet, ["FLEET B"]) || auth()->user()->id == 23)
	                    <td>${crew.seniority}</td>
	                @endif
	                <td class="OBC" data-id="${crew.applicant_id}">${crew.lname + ', ' + crew.fname + ' ' + (crew.suffix || "") + ' ' + crew.mname}</td>
	                <td>${crew.age}</td>
	                <td class="jdate" data-id="${crew.applicant_id}" data-date="${crew.joining_date}">${moment(crew.joining_date).format('DD-MMM-YY')}</td>
	                <td>${moment().diff(moment(crew.joining_date), 'months')}</td>
	                <td>${cd}</td>
	                <td class="ddate" data-id="${crew.applicant_id}" data-date="${moment(disembarkation_date).format("YYYY-MM-DD")}">${disembarkation_date.format('DD-MMM-YY')}</td>
	                <td>${crew.PASSPORT ? moment(crew.PASSPORT).format('DD-MMM-YY') : '-----'}</td>
	                <td>${crew["SEAMAN'S BOOK"] ? moment(crew["SEAMAN'S BOOK"]).format('DD-MMM-YY') : '-----'}</td>
	                <td>${crew["US-VISA"] ? moment(crew["US-VISA"]).format('DD-MMM-YY') : '-----'}</td>
	                <td>${crew.joining_port ?? "---"}</td>
	                <td>${reliever}</td>
	                <td class="remarks">${crew.remarks}</td>
	                @if(auth()->user()->role != "Principal")
	                <td class="actions">
	                    <a class="btn btn-info btn-sm" data-toggle="tooltip" title="Export Documents" onClick="getContract2(${crew.applicant_id})">
	                        <span class="fa fa-file-text"></span>
	                    </a>
	                    <a class="btn btn-success btn-sm" data-toggle="tooltip" title="Edit On Board Details" onClick='eod(${crew.id}, ${crew.vessel_id}, "${crew.joining_date}", ${crew.months}, "${crew.joining_port ?? ""}")'>
	                        <span class="fa fa-pencil fa-sm"></span>
	                    </a>
	                    <a class="btn btn-warning btn-sm" data-toggle="tooltip" title="Extend Contract" onClick="extendContract(${crew.applicant_id}, ${crew.vessel_id})">
	                        <span class="fa fa-calendar-plus-o"></span>
	                    </a>
	                    <a class="btn btn-primary btn-search" data-toggle="tooltip" onClick="viewInfo(${crew.applicant_id})">
	                        <span class="fa fa-search" onClick="viewInfo(${crew.applicant_id})"></span>
	                    </a>
	                    <a class="btn btn-danger btn-sm" data-toggle="tooltip" title="Sign off" onClick="offBoard(${crew.applicant_id}, ${crew.vessel_id}, '${disembarkation_date.format('YYYY-MM-DD')}')">
	                        <span class="fa fa-arrow-down fa-sm"></span>
	                    </a>
	                    ${onBoardButton}
	                </td>
	                @endif
	            </tr>
	        `;

	        if(crew.reliever){
	            table3 += `
	                <tr>
	                    <td rowspan="2">${index + 1}</td>
	                    <td rowspan="2">${crew.abbr}</td>
	                    <td rowspan="2">${crew.lname + ', ' + crew.fname + ' ' + (crew.suffix || "") + ' ' + crew.mname}</td>
	                    <td rowspan="2">${moment(crew.birthday).format('MMM DD, YYYY')}</td>
	                    <td>
	                        ${crew.PASSPORTn ? crew.PASSPORTn : '-----'}
	                    </td>
	                    <td>
	                        ${crew["SEAMAN'S BOOKn"] ? crew["SEAMAN'S BOOKn"] : '-----'}
	                    </td>
	                    <td>
	                        ${crew["US-VISAn"] ? crew["US-VISAn"] : '-----'}
	                    </td>
	                </tr>

	                <tr>
	                    <td>${crew.PASSPORT ? moment(crew.PASSPORT).format('MMM DD, YYYY') : '-----'}</td>
	                    <td>${crew["SEAMAN'S BOOK"] ? moment(crew["SEAMAN'S BOOK"]).format('MMM DD, YYYY') : '-----'}</td>
	                    <td>${crew["US-VISA"] ? moment(crew["US-VISA"]).format('MMM DD, YYYY') : '-----'}</td>
	                </tr>
	            `;
	        }

	    });

	    $('.tab-pane.linedUp').html(table + "</tbody></table>");
	    $('.tab-pane.onBoard').html(table2 + "</table>");
	    $('.tab-pane.summary').html(table3 + "</table>");

	    $('.tab-pane.documents').html(
	        `
	            <div class="row">
	                <div class="col-md-11">
	                </div>
	                <div class="col-md-1" style="text-align: right;">
	                    <a class="btn btn-success btn-sm" data-toggle="tooltip" title="Export" onclick="exportMonitoring(${vid})">
	                        <span class="fa fa-file"></span> &nbsp;Export
	                    </a>
	                </div>
	            </div>
	            <br>
	            <div class="row">
	                <div class="col-md-12" id="onboardCrewDocuments" style="overflow-x: scroll; overflow-y: scroll; width: 99%; height: 500px;">
	                </div>
	            </div>
	        `
	    );

	    displayDocuments(vid, ranks);
	}

	function displayDocuments(vid, ranks){
		$.ajax({
			url: "{{ route('vessels.getOnboardCrew') }}",
			data: {id: vid},
			success: result => {
				result = JSON.parse(result);
				let obcs = result[0];
				let vessel = result[1];
				let string = "";

				obcs.forEach((obc, index) => {
					let user = obc.applicant.user;
					let months = Number(obc.months) + Number(obc.extensions ? JSON.parse(obc.extensions).reduce((a,b)=>a+b,0) : 0);

					// IDS
					let pp = filterDocs(obc.document_id, 'PASSPORT');
					let sb = filterDocs(obc.document_id, "SEAMAN'S BOOK");
					let usv = filterDocs(obc.document_id, 'US-VISA');
					let mcv = filterDocs(obc.document_id, 'MCV');

					// FLAG
					let fBooklet = filterDocs(obc.document_flag, 'BOOKLET', vessel.flag);
					let fLicense = filterDocs(obc.document_flag, 'LICENSE', vessel.flag);
					let fGoc = filterDocs(obc.document_flag, 'GMDSS/GOC', vessel.flag);
					let fSso = filterDocs(obc.document_flag, 'SSO', vessel.flag);
					let fSdsd = filterDocs(obc.document_flag, 'SDSD', vessel.flag);
					let fCook = filterDocs(obc.document_flag, "SHIP'S COOK ENDORSEMENT", vessel.flag);
					let fRank = fBooklet ? fBooklet.rank : fLicense ? fLicense.rank : fSdsd ? fSdsd.rank : null;
					let fSsoSdsd = fSso ?? fSdsd;

					// LICENSE
					let oic = filterDocs(obc.document_lc, 'COC', null, 'OIC');
					let goc = filterDocs(obc.document_lc, 'GMDSS/GOC');
					let cocR = filterDocs(obc.document_lc, 'COC', null, 'RATINGS');
					let cocG = filterDocs(obc.document_lc, 'COC', null, 'GALLEY');
					let cocG2 = filterDocs(obc.document_lc, 'COC', null, 'GALLEY2');
					cocG = cocG ?? cocG2;

					// COP
					let bt = filterDocs(obc.document_lc, 'BASIC TRAINING - BT');
					let pscrb = filterDocs(obc.document_lc, 'PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB');
					let aff = filterDocs(obc.document_lc, 'ADVANCE FIRE FIGHTING - AFF');
					let sdsd = filterDocs(obc.document_lc, 'SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD');
					let kml = filterDocs(obc.document_lc, 'KML');

					// MEDICAL
					let medical = filterDocs(obc.document_med_cert, 'MEDICAL CERTIFICATE');

					string += `
						<tr>
							<td>${index+1}</td>
							<td>${user.crew.pro_app.rank.abbr}</td>
							<td class="w-25">${user.lname}, ${user.fname}</td>
							<td>${user.birthday ? toDate(user.birthday, 'DD-MMM-YY') : "-"}&nbsp;</td>
							<td>${user.birthday ? moment().diff(moment(user.birthday), 'years') : "-"}</td>
							<td>${toDate(obc.joining_date, 'DD-MMM-YY')}&nbsp;</td>
							<td>${months}</td>
							<td>${toDate(moment(obc.joining_date, 'DD-MMM-YY').add(months, 'months'))}</td>
							<td>${moment().diff(moment(obc.joining_date), 'months')}</td>

							{{-- DOCUMENTS --}}
							<td>${pp ? pp.number : "N/A"}</td>
							<td>${(pp && pp.issue_date != null) ? (pp.expiry_date != null ? toDate(pp.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>
							<td>${sb ? sb.number : "N/A"}</td>
							<td>${(sb && sb.issue_date != null) ? (sb.expiry_date != null ? toDate(sb.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>
							<td>${(usv && usv.issue_date != null) ? (usv.expiry_date != null ? toDate(usv.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>
							<td>${mcv ? mcv.number : "N/A"}</td>
							<td>${(mcv && mcv.issue_date != null) ? (mcv.expiry_date != null ? toDate(mcv.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>

							{{-- FLAG --}}
							<td>${vessel.flag}</td>
							<td>${fRank ? ranks[fRank].abbr : "N/A"}</td>
							<td>${(fBooklet && fBooklet.issue_date != null) ? (fBooklet.expiry_date != null ? toDate(fBooklet.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>
							<td>${(fLicense && fLicense.issue_date != null) ? (fLicense.expiry_date != null ? toDate(fLicense.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>
							<td>${(fGoc && fGoc.issue_date != null) ? (fGoc.expiry_date != null ? toDate(fGoc.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>
							<td>${(fSsoSdsd && fSsoSdsd.issue_date != null) ? (fSsoSdsd.expiry_date != null ? toDate(fSsoSdsd.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>
							<td>${(fCook && fCook.issue_date != null) ? (fCook.expiry_date != null ? toDate(fCook.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>

							{{-- LICENSES --}}
							<td>${(oic && oic.issue_date != null) ? (oic.expiry_date != null ? toDate(oic.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>
							<td>${(goc && goc.issue_date != null) ? (goc.expiry_date != null ? toDate(goc.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>
							<td>${(cocR && cocR.issue_date != null) ? (cocR.expiry_date != null ? toDate(cocR.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>
							<td>${(cocG && cocG.issue_date != null) ? (cocG.expiry_date != null ? toDate(cocG.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>

							{{-- COP --}}
							<td>${(bt && bt.issue_date != null) ? (bt.expiry_date != null ? toDate(bt.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>
							<td>${(pscrb && pscrb.issue_date != null) ? (pscrb.expiry_date != null ? toDate(pscrb.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>
							<td>${(aff && aff.issue_date != null) ? (aff.expiry_date != null ? toDate(aff.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>
							<td>${(sdsd && sdsd.issue_date != null) ? (sdsd.expiry_date != null ? toDate(sdsd.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>
							<td>${(kml && kml.issue_date != null) ? (kml.expiry_date != null ? toDate(kml.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>

							{{-- MEDICAL --}}
							<td>${medical ? (medical.expiry_date ? toDate(medical.expiry_date, 'DD-MMM-YY') : "UNLIMITED") : "N/A"}</td>
							<td></td>
						</tr>
					`;
				});

				string = `
					<table id="documentTable" class="table table-bordered table-striped" style="text-align: center; font-size: 12px;">

						<tbody>
							<tr class="dttr">
								<td></td>
								<td></td>
								<td class="w-25"></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td colspan="7" style="background-color: #FFC000;">NATIONAL ID / VISA</td>
								<td colspan="7" style="background-color: #FF99FF;">FLAG LICENSE</td>
								<td colspan="4" style="background-color: #92D050;">NATIONAL LICENSE</td>
								<td colspan="4" style="background-color: #F8CBAD;">COP TRAININGS</td>
								<td style="background-color: #BDD7EE;"></td>
								<td style="background-color: #66FFCC;">MEDICAL</td>
								<td style="background-color: #00B0F0;">REMARKS</td>
							</tr>

							<tr class="dttr">
								<td>NO.</td>
								<td>RANK</td>
								<td class="w-25">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td>
									DATE OF 
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BIRTH&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
								<td>AGE</td>
								<td>
									DATE OF
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;JOIN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
								<td>CONTRACT DURATION</td>
								<td>DATE OF CONTRACT TERMINATION</td>
								<td>MONTHS ONBOARD</td>
								<td>PASSPORT NO.</td>
								<td>PASSPORT VALIDITY</td>
								<td>SIRB NO.</td>
								<td>SEAMAN'S BOOK VALIDITY</td>
								<td>&nbsp;&nbsp;US VISA VALIDITY&nbsp;&nbsp;</td>
								<td>
									&nbsp;MARITIME&nbsp; 
									CREW VISA 
									PPRT NO.
								</td>
								<td>
									&nbsp;MARITIME&nbsp;
									CREW VISA
									EXPIRY
								</td>
								<td>FLAG</td>
								<td>RANK</td>
								<td>BOOKLET</td>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GOC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;SDSD/SSO&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COOK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td>
									OIC
									&nbsp;&nbsp;&nbsp;&nbsp;LICENSE&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
								<td>
									GOC
									&nbsp;&nbsp;&nbsp;&nbsp;LICENSE&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
								<td>
									COC-
									&nbsp;&nbsp;&nbsp;&nbsp;RATINGS&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
								<td>
									COC-
									&nbsp;&nbsp;&nbsp;GALLEY&nbsp;&nbsp;&nbsp;
								</td>
								<td>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									BT
								</td>
								<td>
									COP
									&nbsp;&nbsp;&nbsp;&nbsp;PSCRB&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
								<td>
									COP 
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AFF&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
								<td>
									COP
									&nbsp;&nbsp;&nbsp;&nbsp;SDSD&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
								<td>KML LICENSE</td>
								<td>&nbsp;MEDICAL&nbsp;</td>
								<td>FACEBOOK NAME</td>
							</tr>

							${string}
						</tbody>
					</table>
				`;

				$('#onboardCrewDocuments').append(string);
				$('.dttr td').css('font-weight', 'bold');
				$('#documentTable td').css('vertical-align', 'middle');

				$('#onboardCrewDocuments td').each((id, elem) => {

					// FREEZE COLUMN
					if($(elem).hasClass("w-25")){
						$(elem).css({
							position: "sticky",
							left: "0px",
							"background-color": $(elem).parent().css('background-color')
						});
					}

					// FREEZE ROW
					if(id >= 16 && id <= 49){
						$(elem).css({
							position: "sticky",
							top: "0px",
							"background-color": $(elem).parent().css('background-color')
						});

						// NAME
						if(id == 18){
							$(elem).css('z-index', 9999);
						}
					}

					if(elem.innerText.length == 9 && !isNaN(Date.parse(elem.innerText))){
						let diff = moment(elem.innerText).diff(moment(), 'days');
						let color = null;

						if(diff <= 30){
							color = "fd6787";
						}
						else if(diff <= 60){
							color = "fff44c";
						}
						else if(diff <= 90){
							color = "288eeb";
						}

						if(color){
							$(elem).css('background-color', '#' + color);
						}
					}
				});
			}
		})
	}

	function filterDocs(obj, type, flag = null, coc = null){
		let docu = null;
		let backup = null;

		obj.forEach(doc => {
			if(flag){
				if(doc.type.includes(type) && doc.country.toLowerCase() == flag.toLowerCase()){
					docu = doc;
				}
			}
			else if(coc){
				let regulations = JSON.parse(doc.regulation);

				if(coc == "OIC"){
					if(doc.type == "COC" && (regulations.includes('II/2') || regulations.includes('III/2') || regulations.includes('II/1') || regulations.includes('III/1'))){
						docu = doc;
					}
				}
				else if(coc == "RATINGS"){
					if(doc.type == "COC" && (regulations.includes('II/4') || regulations.includes('III/4'))){
						docu = doc;
					}
				}
				else if(coc == "GALLEY"){
					if(doc.type == "NCIII"){
						docu = doc;
					}
				}
				else if(coc == "GALLEY2"){
					if(doc.type == "NCI"){
						docu = doc;
					}
				}
			}
			else{
				if(doc.type.includes(type)){
					docu = doc;
				}
			}

			if(docu){
				if(backup == null){
					backup = docu;
				}
				else{
					if(docu.issue_date > backup.issue_date){
						backup = docu;
					}
				}
			}
		});

		return backup;
	}
</script>