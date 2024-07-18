@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";

	$checkDate = function($date){
		if($date != "" && $date != null){
			return now()->parse($date)->format('d-M-Y');
		}
		else{
			return "N/A";
		}
	};

	$cleanText = function($text){
		// return str_replace('&', '&#38;', $text);
		return str_replace('&', '&#38;', $text);
	};

	$doc = function($doc, $display, $type, $requirement, $flag = null) use($checkDate, $data, $cleanText, $bold, $center){
		$display = $cleanText($display);
		$docu = null;

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
		elseif($doc == "SMS" || $doc == "WELDING"){
			foreach(get_object_vars($data->document_lc) as $document){
			    if(str_contains($document->type, $doc)){
			    	$docu = $document;
			    }
			}
		}
		elseif($doc == "COVID"){
			foreach(get_object_vars($data->document_med_cert) as $document){
			    if(str_contains($document->type, $doc)){
			    	if($docu && $document->issue_date < $docu->issue_date){
			    		continue;
			    	}

			    	$docu = $document;
			    }
			}
		}
		elseif($doc == "BRM/ERM"){
			foreach(get_object_vars($data->document_lc) as $document){
			    if(str_contains($document->type, "ERM") || str_contains($document->type, "BRM")){
			    	$docu = $document;
			    }
			}

		}
		elseif($doc == "COC-TESDA"){
			foreach(get_object_vars($data->document_lc) as $document){
			    if($document->type == "COC" && $document->issuer != "MARINA"){
			    	$docu = $document;
			    }
			}
		}
		elseif($doc == 'ECDIS SPECIFIC') {
			$array = [
				'ECDIS FURUNO 2107',
				'ECDIS FURUNO 3200',
				'ECDIS FURUNO 3300',
				'ECDIS JRC 701B',
				'ECDIS JRC 7201',
				'ECDIS JRC 901B',
				'ECDIS JRC 9201',
				'ECDIS MARTEK',
				'ECDIS MECYS',
				'ECDIS TRANSAS',
			];

			$string = "";
			foreach($array as $ecdis){
				$docu = isset($data->{"document_$type"}->$ecdis) ? $data->{"document_$type"}->$ecdis : false;

				if($docu){
					break;
				}
			}

			if($string != ""){
				echo $string;
				return;
			}
		}
		elseif($doc == "CF"){
			$ctr = 0;
			foreach(get_object_vars($data->{'document_' . $type}) as $document){
			    if(str_contains($document->type, 'CONTAINER')){
			    	$ctr++;
			    }
			    if(str_contains($document->type, 'FAMILIARIZATION')){
			    	$ctr++;
			    }
			}

			if($ctr == 2){
				$docu = $document;
			}
		}
		else{
			if($type != "flag"){
				$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
			}
			else{
				foreach (get_object_vars($data->document_flag) as $flag) {
					$country = ucwords(strtolower($data->vessel->flag));

					dd($country);

					if($flag->country == $country && $flag->type == $doc){
						$docu = $flag;
					}
				}
			}
		}

		$date = $docu ? $checkDate($docu->issue_date, $docu->expiry_date) : 'N/A';
		$number = $docu ? $docu->no ?? $docu->number : 'N/A';
		$issuer = $docu ? $cleanText($docu->issuer) : 'N/A';
		$issue_date = $docu ? $checkDate($docu->issue_date) : 'N/A';
		$expiry_date = $docu ? $checkDate($docu->expiry_date) : "N/A";

		if($issue_date != "N/A" && $expiry_date == "N/A"){
			$expiry_date = "UNLIMITED";
		}

		$number = $number == "" ? "N/A" : $number;

		echo "
			<td colspan='2'> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎$display</td>
			<td colspan='2' style='$center'>$number</td>
			<td colspan='2' style='$center'>$issue_date</td>
			<td style='$center'>$expiry_date</td>
			<td style='$center'>$requirement</td>
		";
	};

	$row = function($title, $rows) use ($cleanText, $bold){
		$title = $cleanText($title);
		echo "<td rowspan='$rows' style='$bold'> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎$title</td>";
	};
@endphp

<table>
	<tr>
		<td colspan="9" style="{{ $bold }} {{ $center }} font-size: 16px; height: 40px;">Crew Competency Checklist</td>
	</tr>

	<tr>
		<td style="{{ $bold }} {{ $center }}">NAME</td>
		<td colspan="3" style="{{ $center }}">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td colspan="2" style="{{ $bold }} {{ $center }}">VESSEL</td>
		<td colspan="3" style="{{ $bold }} {{ $center }}">{{ $data->vessel->name }}</td>
	</tr>

	<tr>
		<td style="{{ $bold }} {{ $center }}">RANK</td>
		<td colspan="3" style="{{ $center }}">{{ $data->rank }}</td>
		<td colspan="2" style="{{ $bold }} {{ $center }}">JOINING DATE</td>
		<td colspan="3" style="{{ $bold }} {{ $center }}">
			{{ isset($data->data) ? $data->data['joining_date'] : $data->pro_app->joining_date }}
		</td>
	</tr>

	<tr>
		<td style="{{ $bold }} {{ $center }}">OFFICIAL NO.</td>
		<td colspan="3" style="{{ $center }}"></td>
		<td colspan="2" style="{{ $bold }} {{ $center }}">JOINING PORT</td>
		<td colspan="3" style="{{ $bold }} {{ $center }}">
			{{ isset($data->data) ? $data->data['joining_port'] : $data->pro_app->joining_port }}
		</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 50px;">
			[Note] Master should oblige the duty to the joining crew after the check of his qualification with checklist before
			<br style='mso-data-placement:same-cell;' />
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎            
			 relief and should be sent it to the company if you have any special problem (Kept on board the original copy).
		</td>
	</tr>

	<tr>
		<td style="{{ $bold }} {{ $center }}">CLASSIFICATION</td>
		<td colspan="2" style="{{ $bold }} {{ $center }}">PARTICULARS</td>
		<td colspan="2" style="{{ $bold }} {{ $center }}">NUMBER</td>
		<td colspan="2" style="{{ $bold }} {{ $center }}">ISSUANCE</td>
		<td style="{{ $bold }} {{ $center }}">VALIDITY</td>
		<td style="{{ $bold }} {{ $center }}">REQUIREMENT</td>
	</tr>

	<tr>
		{{ $row("SIRB & PPT", 5) }}
		{{ $doc("SEAMAN'S BOOK", "Seaman's book (Philippine)", 'id', 'All Rank') }}
	</tr>
	<tr>{{ $doc("LICENSE", "Seaman's book (Panama)", 'flag', 'All Rank', 'Panama') }}</tr>
	<tr>{{ $doc("LICENSE", "Seaman's book (Marshall/Others)", 'flag', 'All Rank', 'Marshall Islands') }}</tr>
	<tr>{{ $doc("POEA EREGISTRATION", "Seaman's Registration Certificate", 'lc', 'All Rank') }}</tr>
	<tr>{{ $doc("PASSPORT", "Passport (Philippine)", 'id', 'All Rank') }}</tr>

	<tr>
		{{ $row("VISA", 2) }}
		{{ $doc("US-VISA", "US VISA", 'id', 'All Rank') }}
	</tr>
	<tr>{{ $doc("MCV", "Australia VISA", 'id', 'All Rank') }}</tr>

	<tr>
		{{ $row("LICENSE", 12) }}
		{{ $doc("COC", "Certificate of Competency (MARINA)", 'lc', 'All D/E. officer') }}
	</tr>
	<tr>{{ $doc("COE", "Endorsement (MARINA)", 'lc', 'All D/E. officer') }}</tr>
	<tr>{{ $doc("BOOKLET", "Panama License (or Booklet)", 'flag', 'All Rank', 'Panama') }}</tr>
	<tr>{{ $doc("BOOKLET", "Marshall License (or Booklet)", 'flag', 'All Rank', 'Marshall Islands') }}</tr>
	<tr>{{ $doc("GMDSS/GOC", "G.O.C (Philippine)", 'lc', 'All D. officer') }}</tr>
	<tr>{{ $doc("GMDSS/GOC", "G.O.C (Panama)", 'flag', 'All D. officer', 'Panama') }}</tr>
	<tr>{{ $doc("GMDSS/GOC", "G.O.C (Marshall)", 'flag', 'All D. officer', 'Marshall Islands') }}</tr>
	<tr>{{ $doc("SDSD", "Designated Security Duty(Panama)", 'flag', 'All Rank', 'Panama') }}</tr>
	<tr>{{ $doc("SHIP'S COOK ENDORSEMENT", "Ship's Cook(Panama)", 'flag', 'Catering Rating', 'Panama') }}</tr>
	<tr>{{ $doc("SHIP'S COOK ENDORSEMENT", "Ship's Cook(Marshall)", 'flag', 'Catering Rating', 'Marshall Islands') }}</tr>
	<tr>{{ $doc("GENERAL TANKER FAMILIARIZATION", "Panama Oil Tanker Cert.", 'lc', 'All rank/Oil Tanker') }}</tr>
	<tr>{{ $doc("COC-TESDA", "Certificate of Competency (TESDA)", 'lc', 'All Rating') }}</tr>

	<tr>
		{{ $row("MEDICAL", 8) }}
		{{ $doc("MEDICAL CERTIFICATE", "Medical Examination Certificate", 'med_cert', 'All Rank') }}
	</tr>
	<tr>{{ $doc("DRUG AND ALCOHOL TEST", "Drug & Alcohol Test", 'med_cert', 'All Rank') }}</tr>
	<tr>{{ $doc("AIDS TEST", "AIDS Test", 'med_cert', 'All Rank') }}</tr>
	<tr>{{ $doc("ANTI-DRUG AND ALCOHOL AFFIDAVIT", "Anti-Drug & Alcohol Affidavit", 'med_cert', 'All Rank') }}</tr>
	<tr>{{ $doc("CHEMICAL TEST", "Medical Examination for Chemical", 'med_cert', 'All rank(C.Tanker)') }}</tr>
	<tr>{{ $doc("YELLOW FEVER", "Yellow Fever", 'med_cert', 'All Rank') }}</tr>
	<tr>{{ $doc("COVID", "COVID-19", 'lc', 'All Rank') }}</tr>
	<tr>{{ $doc("CHOLERA", "Cholera", 'med_cert', 'All Rank(Option)') }}</tr>

	<tr>
		{{ $row("TRAINING ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(STCW ‎‏‏‎11 ‎‏‏‎REQUIREMENT)", 19) }}
		{{ $doc("BASIC TRAINING - BT", "Basic Safety Course", 'lc', 'All Rank') }}
	</tr>
	<tr>{{ $doc("BASIC TRAINING - BT", "Personal Safety & Social Responsibility", 'lc', 'All Rank') }}</tr>
	<tr>{{ $doc("ADVANCE FIRE FIGHTING - AFF", "Advanced Training in Fire Fighting", 'lc', 'All D/E Officer') }}</tr>
	<tr>{{ $doc("PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB", "Proficiency in Survival Craft & Rescue Boat", 'lc', 'All D/E Officer') }}</tr>
	<tr>{{ $doc("MEDICAL FIRST AID - MEFA", "Medical Emergency-First Aid", 'lc', 'All D/E Officer') }}</tr>
	<tr>{{ $doc("MEDICAL CARE - MECA", "Medical Care", 'lc', 'All D/E Officer') }}</tr>
	<tr>{{ $doc("RADAR SIMULATOR COURSE", "Radar Simulator Course (RSC)", 'lc', 'All D. Officer') }}</tr>
	<tr>{{ $doc("RADAR OBSERVER COURSE", "Radar Observer Course (ROC)", 'lc', 'All D. Officer') }}</tr>
	<tr>{{ $doc("ARPA TRAINING COURSE", "ARPA", 'lc', 'All D. Officer') }}</tr>
	<tr>{{ $doc("ECDIS", "ECDIS (GENERIC - 40HRS)", 'lc', 'All D. Officer') }}</tr>
	<tr>{{ $doc("ECDIS SPECIFIC", "ECDIS (TYPE SEPCIFIC)", 'lc', 'All D. Officer') }}</tr>
	<tr>{{ $doc("BRM/ERM", "BRM/ERM", 'lc', 'All D/E Officer') }}</tr>
	<tr>{{ $doc("GMDSS/GOC", "GMDSS", 'lc', 'All D. Officer') }}</tr>
	<tr>{{ $doc("SHIPS RESTRICTED RADIO TELEPHONE OPERATORS COURSE", "Ship Restricted Radio Operator Course", 'lc', 'All D. Officer') }}</tr>
	<tr>{{ $doc("BASIC TRAINING FOR OIL AND CHEMICAL TANKER", "Basic Training for Tanker", 'lc', 'All rank/Oil tanker') }}</tr>
	<tr>{{ $doc("ADVANCE TRAINING FOR OIL TANKER - ATOT", "Advanced Training for Tanker (Oil / Chemical / Liquified Gas)", 'lc', 'All D/E officer, BSN, Pumpman / Tanker') }}</tr>
	<tr>{{ $doc("SHORE-BASED FIREFIGHTING FOR TANKERS", "Shore-Based Fire Fighting", 'lc', 'All rank') }}</tr>
	<tr>{{ $doc("SHIP SECURITY OFFICER - SSO", "ISPS-Ship Security Officer", 'lc', 'All D/E Officer') }}</tr>
	<tr>{{ $doc("SDSD", "ISPS-Designated Security Duty", 'lc', 'All D/E Officer') }}</tr>

	<tr>
		{{ $row("CONTRACT  ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(Original-Crew ‎‏‏‎/ ‎‏‏‎Copy-Master)", 3) }}
		{{ $doc("POEA CONTRACT", "POEA Employment Contract", 'lc', 'All Rank') }}
	</tr>
	<tr>{{ $doc("AMOSUP CONTRACT", "AMOSUP - ITF Employment Contract", 'lc', 'All Rank') }}</tr>
	<tr>{{ $doc("SEAFARERS EMPLOYMENT AGREEMENT", "SEAFERER'S EMPLOYMENT AGREEMENT", 'lc', 'All Rank') }}</tr>

	<tr>
		{{ $row("LETTER OF APPOINTMENT", 1) }}
		{{ $doc("Medical Officer", "Medical Officer", 'lc', '2/O or C/O') }}
	</tr>

	<tr>
		{{ $row("OTHER IN-HOUSE AND  ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎OUTSIDE ‎‏‏‎TRAINING", 5) }}
		{{ $doc("PDOS", "PDOS Certificate", 'lc', 'All Rank') }}
	</tr>
	<tr>{{ $doc("Refresher Course", "Refresher Course", 'lc', 'All Rank') }}</tr>
	<tr>{{ $doc("HMMS", "HMMS", 'lc', 'All Rank') }}</tr>
	<tr>{{ $doc("SHS", "SHS", 'lc', 'All D. Officer') }}</tr>
	<tr>{{ $doc("KML", "KOREAN MARITIME LAW", 'lc', ' All D/E Officer for Korea/BBCHP') }}</tr>

	<tr><td colspan="9"></td></tr>

	<tr>
		<td colspan="2" style="height: 40px;">
			Prepared
			<br style='mso-data-placement:same-cell;' />
			(By Agency)
		</td>
		<td colspan="4" style="height: 40px;">
			Verified
			<br style='mso-data-placement:same-cell;' />
			(By PIC in Vessel)
		</td>
		<td colspan="3" style="height: 40px;">
			Approved
			<br style='mso-data-placement:same-cell;' />
			(By Master)
		</td>
	</tr>

	<tr>
		<td colspan="2" style="height: 40px;">
			SOLPIA MARINE &#38; SHIP MANAGEMENT, INC.
			<br style='mso-data-placement:same-cell;' />
			{{ auth()->user()->gender == "Male" ? "Mr." : "Ms." }} {{ auth()->user()->fname }} {{ auth()->user()->lname }} - CREWING OFFICER
		</td>
		<td colspan="4" style="height: 40px;"></td>
		<td colspan="3" style="height: 40px;"></td>
	</tr>

	<tr>
		<td colspan="2">Date: {{ now()->format('d-M-Y') }}</td>
		<td colspan="4">Date: </td>
		<td colspan="3">Date: </td>
	</tr>

	<tr><td colspan="9" style="height: 40px;"></td></tr>
	<tr><td colspan="9" style="height: 40px;">CODE	&lt;305-302B	&gt;/2021.08.27/DCN21008  APRVD A4</td></tr>
</table>