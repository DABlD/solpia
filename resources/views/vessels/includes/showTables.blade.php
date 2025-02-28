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
	                <div class="col-md-12" id="onboardCrewDocuments" style="overflow-x: scroll; overflow-y: scroll; width: 99%;">
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
					let pp = filter(obc.document_id, 'PASSPORT');
					let sb = filter(obc.document_id, "SEAMAN'S BOOK");
					let usv = filter(obc.document_id, 'US-VISA');
					let mcv = filter(obc.document_id, 'MCV');

					// FLAG
					let fBooklet = filter(obc.document_flag, 'BOOKLET', vessel.flag);
					let fLicense = filter(obc.document_flag, 'LICENSE', vessel.flag);
					let fGoc = filter(obc.document_flag, 'GMDSS/GOC', vessel.flag);
					let fSso = filter(obc.document_flag, 'SSO', vessel.flag);
					let fSdsd = filter(obc.document_flag, 'SDSD', vessel.flag);
					let fCook = filter(obc.document_flag, "SHIP'S COOK ENDORSEMENT", vessel.flag);
					let fRank = fBooklet ? fBooklet.rank_id : fLicense ? fLicense.rank_id : fSdsd ? fSdsd.rank_id : null;
					let fSsoSdsd = fSso ?? fSdsd;

					// LICENSE
					let oic = filter(obc.document_lc, 'COC', null, 'OIC');
					let goc = filter(obc.document_lc, 'GMDSS/GOC');
					let cocR = filter(obc.document_lc, 'COC', null, 'RATINGS');
					let cocG = filter(obc.document_lc, 'COC', null, 'GALLEY');
					let cocG2 = filter(obc.document_lc, 'COC', null, 'GALLEY2');
					cocG = cocG ?? cocG2;

					// COP
					let bt = filter(obc.document_lc, 'BASIC TRAINING - BT');
					let pscrb = filter(obc.document_lc, 'PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB');
					let aff = filter(obc.document_lc, 'ADVANCE FIRE FIGHTING - AFF');
					let sdsd = filter(obc.document_lc, 'SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD');
					let kml = filter(obc.document_lc, 'KML');

					// MEDICAL
					let medical = filter(obc.document_med_cert, 'MEDICAL CERTIFICATE');

					string += `
						<tr>
							<td>${index+1}</td>
							<td>${user.crew.pro_app.rank.abbr}</td>
							<td class="w-25">${user.lname}, ${user.fname} ${user.suffix} ${user.mname}</td>
							<td>${user.birthday ? toDate(user.birthday) : "-"}</td>
							<td>${user.birthday ? moment().diff(moment(user.birthday), 'years') : "-"}</td>
							<td>${toDate(obc.joining_date)}</td>
							<td>${months}</td>
							<td>${toDate(moment(obc.joining_date).add(months, 'months'))}</td>
							<td>${moment().diff(moment(obc.joining_date), 'months')}</td>

							{{-- DOCUMENTS --}}
							<td>${pp ? pp.number : "N/A"}</td>
							<td>${pp ? (pp.expiry_date ? toDate(pp.expiry_date) : "UNLIMITED") : "N/A"}</td>
							<td>${sb ? sb.number : "N/A"}</td>
							<td>${sb ? (sb.expiry_date ? toDate(sb.expiry_date) : "UNLIMITED") : "N/A"}</td>
							<td>${usv ? (usv.expiry_date ? toDate(usv.expiry_date) : "UNLIMITED") : "N/A"}</td>
							<td>${mcv ? mcv.number : "N/A"}</td>
							<td>${mcv ? (mcv.expiry_date ? toDate(mcv.expiry_date) : "UNLIMITED") : "N/A"}</td>

							{{-- FLAG --}}
							<td>${vessel.flag}</td>
							<td>${fRank ? ranks[fRank].abbr : "N/A"}</td>
							<td>${fBooklet ? (fBooklet.expiry_date ? toDate(fBooklet.expiry_date) : "UNLIMITED") : "N/A"}</td>
							<td>${fLicense ? (fLicense.expiry_date ? toDate(fLicense.expiry_date) : "UNLIMITED") : "N/A"}</td>
							<td>${fGoc ? (fGoc.expiry_date ? toDate(fGoc.expiry_date) : "UNLIMITED") : "N/A"}</td>
							<td>${fSsoSdsd ? (fSsoSdsd.expiry_date ? toDate(fSsoSdsd.expiry_date) : "UNLIMITED") : "N/A"}</td>
							<td>${fCook ? (fCook.expiry_date ? toDate(fCook.expiry_date) : "UNLIMITED") : "N/A"}</td>

							{{-- LICENSES --}}
							<td>${oic ? (oic.expiry_date ? toDate(oic.expiry_date) : "UNLIMITED") : "N/A"}</td>
							<td>${goc ? (goc.expiry_date ? toDate(goc.expiry_date) : "UNLIMITED") : "N/A"}</td>
							<td>${cocR ? (cocR.expiry_date ? toDate(cocR.expiry_date) : "UNLIMITED") : "N/A"}</td>
							<td>${cocG ? (cocG.expiry_date ? toDate(cocG.expiry_date) : "UNLIMITED") : "N/A"}</td>

							{{-- COP --}}
							<td>${bt ? (bt.expiry_date ? toDate(bt.expiry_date) : "UNLIMITED") : "N/A"}</td>
							<td>${pscrb ? (pscrb.expiry_date ? toDate(pscrb.expiry_date) : "UNLIMITED") : "N/A"}</td>
							<td>${aff ? (aff.expiry_date ? toDate(aff.expiry_date) : "UNLIMITED") : "N/A"}</td>
							<td>${sdsd ? (sdsd.expiry_date ? toDate(sdsd.expiry_date) : "UNLIMITED") : "N/A"}</td>
							<td>${kml ? (kml.expiry_date ? toDate(kml.expiry_date) : "UNLIMITED") : "N/A"}</td>

							{{-- MEDICAL --}}
							<td>${medical ? (medical.expiry_date ? toDate(medical.expiry_date) : "UNLIMITED") : "N/A"}</td>
						</tr>
					`;
				});

				string = `
					<table class="table table-bordered table-striped" style="text-align: center; font-size: 12px;">

						<tbody>
							<tr>
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

							<tr>
								<td>NO.</td>
								<td>RANK</td>
								<td class="w-25">NAME</td>
								<td>DATE OF BIRTH</td>
								<td>AGE</td>
								<td>DATE OF JOIN</td>
								<td>CONTRACT DURATION</td>
								<td>DATE OF CONTRACT TERMINATION</td>
								<td>MONTHS ONBOARD</td>
								<td>PASSPORT NO.</td>
								<td>PASSPORT VALIDITY</td>
								<td>SIRB NO.</td>
								<td>SEAMAN'S BOOK VALIDITY</td>
								<td>US VISA VALIDITY</td>
								<td>MARITIME CREW VISA PPRT NO.</td>
								<td>MARIITME CREW VISA EXPIRY</td>
								<td>FLAG</td>
								<td>RANK</td>
								<td>BOOKLET</td>
								<td>COC</td>
								<td>GOC</td>
								<td>SDSD/SSO</td>
								<td>COOK</td>
								<td>OIC LICENSE</td>
								<td>GOC LICENSE</td>
								<td>COC-RATINGS</td>
								<td>COC-GALLEY</td>
								<td>COP BT</td>
								<td>COP PSCRB</td>
								<td>COP AFF</td>
								<td>COP SDSD</td>
								<td>KML LICENSE</td>
								<td>MEDICAL</td>
								<td>FACEBOOK NAME</td>
							</tr>

							${string}
						</tbody>
					</table>
				`;

				$('#onboardCrewDocuments').append(string);
			}
		})
	}

	function filter(obj, type, flag = null, coc = null){
		let docu = null;

		obj.forEach(doc => {
			if(flag){
				if(doc.type.includes(type) && doc.country.toLowerCase() == flag.toLowerCase()){
					docu = doc;
				}
			}
			else if(coc){
				let regulations = JSON.parse(doc.regulation);

				if(coc == "OIC"){
					if(doc.type == "COC" && (regulations.includes('II/2') || regulations.includes('III/2'))){
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
		});

		return docu;
	}
</script>