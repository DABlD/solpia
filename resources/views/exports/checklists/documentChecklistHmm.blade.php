@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";

	$blue = "color: #0000FF;";

	$cleanText = function($text){
		return str_replace('&', '&#38;', $text);
	};

	$doc = function($doc, $display, $type, $req, $first = 0, $country = null) use($data, $cleanText, $b, $c, $bc, $blue){
		$display = $cleanText($display);
		$docu = null;

		if(in_array($doc, ["COC", "COE"])){
			foreach(get_object_vars($data->document_lc) as $document){
				if($document->type == $doc){
					// IF NO INPUT ISSUE DATE USE CREATED AT
					$date = isset($document->issue_date) ? $document->issue_date : $document->created_at;

					// USE DATE TO GET LATEST DOCUMENT WITH SAME TYPE
					if(isset($docu)){
						if($date > $docu->issue_date){
							$docu = $document;
						}
					}
					else{
						$docu = $document;
						// IF NO INPUT ISSUE DATE USE CREATED AT
						if($docu->issue_date == null){
							$docu->issue_date = $docu->created_at;
						}
					}
				}
			}
		}
		elseif($doc == "COC-TESDA"){
			foreach(get_object_vars($data->document_lc) as $document){
				if($document->type == $doc && $document->issuer == "TESDA"){
					$docu = $document;
				}
			}
		}
		else{
			if($doc == "RADAR"){
				$doc = "RADAR SIMULATOR COURSE";
				$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;

				if(!$docu){
					$doc = "RADAR TRAINING COURSE";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
			}
			elseif($doc == "ARPA TRAINING COURSE"){
				$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;

				if(!$docu){
					$doc = "RADAR OPERATOR PLOTTING AID";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
			}
			elseif($doc == "ERS WITH ERM"){
				$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;

				if(!$docu){
					$doc = "ERS";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				if(!$docu){
					$doc = "ERM";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				if(!$docu){
					$doc = "ENGINE RESOURCE MANAGEMENT";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				if(!$docu){
					$doc = "ENGINE ROOM RESOURCE MANAGEMENT";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
			}
			elseif($doc == "MARINE ELECTRICAL"){
				$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;

				if(!$docu){
					$doc = "MARINE ELECTRICAL TRAINING";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
			}
			elseif($doc == "HIV"){
				foreach($data->{'document_' . $type} as $temp){
					if(str_contains($temp->type, "HIV") || str_contains($temp->type, "AIDS")){
						$docu = $temp;
					}
				}
			}
			elseif($doc == "COVID"){
				$temp = $data->document_med_cert;
				if(isset($temp->{'COVID-19 4TH DOSE'})){
					$docu = $temp->{'COVID-19 4TH DOSE'};
				}
				elseif(isset($temp->{'COVID-19 3RD DOSE'})){
					$docu = $temp->{'COVID-19 3RD DOSE'};
				}
				elseif(isset($temp->{'COVID-19 2ND DOSE'})){
					$docu = $temp->{'COVID-19 2ND DOSE'};
				}
				elseif(isset($temp->{'COVID-19 1ST DOSE'})){
					$docu = $temp->{'COVID-19 1ST DOSE'};
				}
			}
			elseif($doc == "ECDIS SPECIFIC"){
				$temp = $data->vessel->ecdis ?? "-";
				$docu = isset($data->document_lc->{$temp}) ? $data->document_lc->{$temp} : null;
			}
			elseif($doc == "RM"){
				$temp = $data->document_lc;

				if(isset($temp->{'BRM'})){
					$docu = $temp->{'BRM'};
				}
				elseif(isset($temp->{'BRIDGE RESOURCE MANAGEMENT'})){
					$docu = $temp->{'BRIDGE RESOURCE MANAGEMENT'};
				}
				elseif(isset($temp->{'ERM'})){
					$docu = $temp->{'ERM'};
				}
				elseif(isset($temp->{'ENGINE RESOURCE MANAGEMENT'})){
					$docu = $temp->{'ENGINE RESOURCE MANAGEMENT'};
				}
			}
			elseif($doc == "SSBT"){
				$temp = $data->document_lc;

				if(isset($temp->{'SSBT'})){
					$docu = $temp->{'SSBT'};
				}
				elseif(isset($temp->{'SSBT WITH BRM'})){
					$docu = $temp->{'SSBT WITH BRM'};
				}
			}
			elseif($doc == "ERS"){
				$temp = $data->document_lc;

				if(isset($temp->{'ERS'})){
					$docu = $temp->{'ERS'};
				}
				elseif(isset($temp->{'ERS WITH ERM'})){
					$docu = $temp->{'ERS WITH ERM'};
				}
			}
			else{
				if($type != "flag"){
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				else{
					// $country = ucwords(strtolower($data->vessel->flag));
					foreach (get_object_vars($data->document_flag) as $flag) {
						if($flag->country == $country && $flag->type == $doc){
							$docu = $flag;
						}
					}
					$type2 = 0;
				}
			}
		}

		$num = isset($docu) ? (isset($docu->number) ? $docu->number : $docu->no) : "";
		$issue = isset($docu->issue_date) ? now()->parse($docu->issue_date)->format("d-M-Y") : "";
		$expiry = isset($docu->expiry_date) ? (isset($docu->issue_date) ? now()->parse($docu->expiry_date)->format('d-M-Y') : "Permanent") : "";

		if($first){
			echo "
				<td colspan='2'>$display</td>
				<td colspan='2' style='$c $blue'>$num</td>
				<td colspan='2' style='$c $blue'>$issue</td>
				<td style='$c $blue'>$expiry</td>
				<td style='$c'>$req</td>
			";
		}
		else{
			echo "
				<tr>
					<td colspan='2'>$display</td>
					<td colspan='2' style='$c $blue'>$num</td>
					<td colspan='2' style='$c $blue'>$issue</td>
					<td style='$c $blue'>$expiry</td>
					<td style='$c'>$req</td>
				</tr>
			";
		}
	};
@endphp

<table>
	<tr>
		<td colspan="9" style="height: 55px; {{ $bc }}">CREW COMPETENCY CHECKLIST</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">NAME</td>
		<td colspan="3" style="{{ $blue }}">{{ $data->user->namefull }}</td>
		<td colspan="2" style="{{ $bc }}">VESSEL</td>
		<td colspan="3" style="{{ $blue }}">{{ isset($data->vessel) ? $data->vessel->name : "-" }}</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">RANK</td>
		<td colspan="3" style="{{ $blue }}">{{ $data->rank }}</td>
		<td colspan="2" style="{{ $bc }}">JOINING DATE</td>
		<td colspan="3" style="{{ $blue }}">{{ $data->departure ? $data->departure->format('d-M-Y') : '' }}</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">OFFICIAL NO.</td>
		<td colspan="3" style="{{ $blue }}">-</td>
		<td colspan="2" style="{{ $bc }}">JOINING PORT</td>
		<td colspan="3" style="{{ $blue }}">{{ $data->port ?? '' }}</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 50px;">
			[Note] Master should oblige the duty to the joining crew after the check of his qualification with checklist before
			relief and should he sent it to the company iof you have any special problem (Kept on board the original copy).
		</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">CLASSIFICATION</td>
		<td colspan="2" style="{{ $bc }}">PARTICULARS</td>
		<td colspan="2" style="{{ $bc }}">NUMBER</td>
		<td colspan="2" style="{{ $bc }}">ISSUANCE</td>
		<td style="{{ $bc }}">VALIDITY</td>
		<td style="{{ $bc }}">REQUIREMENT</td>
	</tr>

	{{-- 1ST SECTION --}}
	<tr>
		<td rowspan="5" style="{{ $bc }}">SIRB &#38; PPT</td>
		{{ $doc("SEAMAN'S BOOK", "Seaman's book (Philippines)", "id", "All Rank", 1) }}
	</tr>
	{{ $doc("-", "Seaman's book (Panama)", "flag", "All Rank") }}
	{{ $doc("-", "Seaman's book (Marshall/Others)", "flag", "All Rank") }}
	{{ $doc("SEAMANS REGISTRATION CERTIFICATE", "Seaman's Registration Certificate", "id", "All Rank") }}
	{{ $doc("PASSPORT", "Passport (Philippines)", "id", "All Rank") }}

	{{-- 2ND SECTION --}}
	<tr>
		<td rowspan="2" style="{{ $bc }}">VISA</td>
		{{ $doc("US-VISA", "US VISA", "id", "All Rank", 1) }}
	</tr>
	{{ $doc("MCV", "Australian VISA", "id", "All Rank") }}

	{{-- 3RD SECTION --}}
	<tr>
		<td rowspan="12" style="{{ $bc }}">LICENSE</td>
		{{ $doc("COC", "Certificate of Competency (PRC)", "lc", "All D/E. Officer", 1) }}
	</tr>
	{{ $doc("COE", " Endorsement (PRC)", "lc", "All D/E. Officer") }}
	{{ $doc("LICENSE", "Panama License (or Booklet)", "flag", "All Rank", 0, "Panama") }}
	{{ $doc("LICENSE", "Marshall License (or Booklet)", "flag", "All Rank", 0, "Marshall Islands") }}
	{{ $doc("GMDSS/GOC", "G.O.C (Philippine)", "lc", "All D. Officer") }}
	{{ $doc("GMDSS/GOC", "G.O.C (Panama)", "flag", "All D. Officer", 0, "Panama") }}
	{{ $doc("GMDSS/GOC", "G.O.C (Marshall)", "flag", "All D. Officer", 0, "Marshall Islands") }}
	{{ $doc("SDSD", "Designated Security Duty(Panama)", "flag", "All Rank", 0, "Panama") }}
	{{ $doc("SHIP'S COOK ENDORSEMENT", "Ship's Cook(Panama)", "flag", "Catering Rating", 0, "Panama") }}
	{{ $doc("SHIP'S COOK ENDORSEMENT", "Ship's Cook(Marshall)", "flag", "Catering Rating", 0, "Marshall Islands") }}
	{{ $doc("BTOC", "Panama Oil Tanker Cert.", "flag", "All Rank/Oil Tanker", 0, "Panama") }}
	{{ $doc("COC-TESDA", "Certificate of Competency (TESDA)", "lc", "All Rank") }}

	{{-- 4TH SECTION --}}
	<tr>
		<td rowspan="8" style="{{ $bc }}">LICENSE</td>
		{{ $doc("MEDICAL CERTIFICATE", "Medical Examination Certificate", "med_cert", "All Rank", 1) }}
	</tr>
	{{ $doc("DRUG AND ALCOHOL TEST", "Drug & Alcohol Test", "med_cert", "All Rank") }}
	{{ $doc("HIV", "AIDS Test", "med_cert", "All Rank") }}
	{{ $doc("-", "Anti-Drug & Alcohol Affidavit", "med_cert", "All Rank") }}
	{{ $doc("CHEMICAL TEST", "Medical Examination for Chemical", "med_cert", "All Rank(C.Tanker)") }}
	{{ $doc("YELLOW FEVER", "Yellow Fever", "med_cert", "All Rank") }}
	{{ $doc("COVID", "COVID-19", "med_cert", "All Rank") }}
	{{ $doc("CHOLERA", "Cholera", "med_cert", "All Rank (Option)") }}

	{{-- 5TH SECTION --}}
	<tr>
		<td rowspan="19" style="{{ $bc }}">
			TRAINING
			<br style='mso-data-placement:same-cell;' />
			&lt;STCW 11 REQUIREMENT&gt;
		</td>
		{{ $doc("BASIC TRAINING - BT", "Basic Safety Course", "lc", "All Rank", 1) }}
	</tr>
	{{ $doc("PSSR", "Personal Safety & Social Responsibility", "lc", "All Rank") }}
	{{ $doc("ADVANCE FIRE FIGHTING - AFF", "Advanced Training in Fire Fighting", "lc", "All D/E officer") }}
	{{ $doc("PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB", "Proficiency in Survival Craft & Rescue Boat", "lc", "All D/E officer") }}
	{{ $doc("MEDICAL FIRST AID - MEFA", "Medical Emergency-First Aid", "lc", "All D/E officer") }}
	{{ $doc("MEDICAL CARE - MECA", "Medical Care", "lc", "Capt &#38; C/O") }}
	{{ $doc("RADAR SIMULATOR COURSE", "Radar Simulator Course (RSC)", "lc", "All D. officer") }}
	{{ $doc("RADAR OBSERVER COURSE", "Radar Observer Course (ROC)", "lc", "All D. officer") }}
	{{ $doc("ARPA TRAINING COURSE", "ARPA", "lc", "All D. officer") }}
	{{ $doc("ECDIS", "ECDIS (GENERIC - 40HRS)", "lc", "All D. officer") }}
	{{ $doc("ECDIS SPECIFIC", "ECDIS (TYPE SPECIFIC)", "lc", "All D. officer") }}
	{{ $doc("RM", "BRM/ERM", "lc", "All D/E officer") }}
	{{ $doc("GMDSS/GOC", "GMDSS", "lc", "All D. officer") }}
	{{ $doc("SHIPS RESTRICTED RADIO TELEPHONE OPERATORS COURSE", "Ship Restricted Radio Operator Course", "lc", "All D. officer") }}
	{{ $doc("BASIC TRAINING FOR OIL AND CHEMICAL TANKER - BTOCT", "Basic Training for Tanker", "lc", "All rank/Oil tanker") }}
	{{ $doc("ADVANCE TRAINING FOR OIL TANKER - ATOT", "Advanced Training for Tanker (Oil / Chemical / Liquified Gas)", "lc", "All D/E officer, BSN, Pumpman / Tanker") }}
	{{ $doc("SHORE-BASED FIREFIGHTING FOR TANKERS", "Shore-Based Fire Fighting", "lc", "All Rank") }}
	{{ $doc("SHIP SECURITY OFFICER - SSO", "ISPS-Ship Security Officer", "lc", "All D/E officer") }}
	{{ $doc("SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD", "ISPS-Designated Security Duty", "lc", "All rating") }}

	{{-- 6TH SECTION --}}
	<tr>
		<td rowspan="3" style="{{ $bc }}">
			CONTRACT
			<br style='mso-data-placement:same-cell;' />
			(Original-Crew / Copy-Master)
		</td>
		{{ $doc("---", "POEA Employment Contract", "lc", "All Rank", 1) }}
	</tr>
	{{ $doc("---", "AMOSUP - ITF Employment Contract", "lc", "All Rank") }}
	{{ $doc("---", "SEAFERER'S EMPLOYMENT AGREEMENT", "lc", "All Rank") }}

	{{-- 7TH SECTION --}}
	<tr>
		<td style="{{ $bc }}">
			LETTER
			<br style='mso-data-placement:same-cell;' />
			OF APPOINTMENT
		</td>
		{{ $doc("---", "Medical Officer", "lc", "2/O or C/O", 1) }}
	</tr>

	{{-- 8TH SECTION --}}
	<tr>
		<td rowspan="9" style="{{ $bc }}">
			OTHER IN-HOUSE AND OUTSIDE TRAINING
		</td>
		{{ $doc("---", "PDOS Certificate", "lc", "All Rank", 1) }}
	</tr>
	{{ $doc("---", "Refresher Course", "lc", "All Rank") }}
	{{ $doc("---", "HMMS", "lc", "All Rank") }}
	{{ $doc("---", "SHS", "lc", "All D. officer") }}
	{{ $doc("---", "KOREAN MARITIME LAW", "lc", "All D/E officer for Korea/BBCHP") }}
	{{ $doc("---", "Ballast water management training", "lc", "All D/E officer for Korea/BBCHP") }}
	{{ $doc("SSBT", "Ship Simulator & Bridge Teamwork(SSBT)", "lc", "All D. officer for TNKR/LNG (Every 5 year)") }}
	{{ $doc("---", "Cargo Ballast Handling Simulator(CBHS) (Depending on the boarding type of TNKR vessel)", "lc", "All D. officer for TNKR/LNG (Every 5 year)") }}
	{{ $doc("ERS", "Engine Room Management Simulator(ERS)", "lc", "All E. officer for TNKR/LNG (Every 5 year)") }}

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $c }} height: 30px;">
			Prepared
			<br style='mso-data-placement:same-cell;' />
			(By Agency)
		</td>
		<td colspan="4" style="{{ $c }}">
			Verified
			<br style='mso-data-placement:same-cell;' />
			(By PIC in Vessel)
		</td>
		<td colspan="3" style="{{ $c }}">
			Approved
			<br style='mso-data-placement:same-cell;' />
			(By Master)
		</td>
	</tr>

	<tr>
		<td colspan="2" style="height: 30px;"></td>
		<td colspan="4"></td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2">Date: </td>
		<td colspan="4">Date: </td>
		<td colspan="3">Date: </td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="9">CODE&lt;305-302B&gt;/2024.04.09/DCN24003</td>
	</tr>
</table>