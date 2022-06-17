@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	// dd($data);

	$clean = function($string){
		return str_replace('&', '&#38;', $string);
	};

	$checkDate = function($date){
		if($date == null || $date == ""){
			return "---";
		}
		else{
			return $date->format('d-M-Y');
		}
	};

	$doc = function($doc, $title, $type, $type2, $flag = null, $regulation = null) use($checkDate, $data, $clean, $bold, $center){
		$docu = null;
		$title = $clean($title);

		if($regulation){
			foreach(get_object_vars($data->document_lc) as $document){
				$regulations = json_decode($document->regulation);

			    if(str_contains($document->type, $doc) && in_array($regulation, $regulations)){
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
			elseif($doc == "COC" || $doc == "COE"){
				$temp = null;
				foreach (get_object_vars($data->document_lc) as $lc){
					if(str_starts_with($lc->type, $doc)){
						if($temp){
							if($lc->issue_date >= $temp->issue_date){
								$temp = $lc;
							}
						}
						else{
							$temp = $lc;
						}
					}
				}

				$docu = $temp;
			}
			elseif($doc == "GAS TANKER"){
				$temp = null;
				foreach (get_object_vars($data->document_lc) as $lc){
					if(str_starts_with($lc->type, $doc)){
						$temp = $lc;
					}
				}

				$docu = $temp;
			}
			else{
				if($type != "flag"){
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				else{
					foreach (get_object_vars($data->document_flag) as $flag) {
						if($flag->country == $flag && $flag->type == $doc){
							$docu = $flag;
						}
					}
				}
			}
		}

		$number = $docu ? $docu->{$type == "id" ? "number" : "no"} : "---";
		$issuer = $docu ? $clean($docu->issuer) : "---";
		$issue = $docu ? $checkDate($docu->issue_date) : "---";
		$expiry = $docu ? $checkDate($docu->expiry_date) : "---";
		
		if($type2 == 1){
			echo "
				<tr>
					<td colspan='4'>$title</td>
					<td colspan='3'>Issue At</td>
					<td colspan='3'>Issue Date</td>
					<td colspan='2'>Expiry Date</td>
				</tr>

				<tr>
					<td colspan='4'>$number</td>
					<td colspan='3'>$issuer</td>
					<td colspan='3'>$issue</td>
					<td colspan='2'>$expiry</td>
				</tr>
			";
		}
		elseif($type2 == 2){
			echo "
				<td colspan='4'>$title</td>
				<td colspan='3'>Issue Date / Expiry Date</td>
			";
		}
		elseif($type2 == 3){
			echo "
				<td colspan='3'>$title</td>
				<td colspan='2'>Issue Date / Expiry Date</td>
			";
		}
		elseif($type2 == 4){
			echo "
				<td colspan='4'>$number</td>
				<td colspan='3'>$issue / $expiry</td>
			";
		}
		elseif($type2 == 5){
			echo "
				<td colspan='3'>$number</td>
				<td colspan='2'>$issue / $expiry</td>
			";
		}
		elseif($type2 == 6){
			echo "
				<td colspan='4'>$title</td>
				<td style='$center'>$number</td>
				<td style='$center'>$issue</td>
				<td style='$center'>$expiry</td>
				<td style='$center'>$issuer</td>
			";
		}
		elseif($type2 == 7){
			echo "
				<td colspan='4'>$title</td>
				<td style='$center'>NOT APPLICABLE</td>
				<td style='$center'>---</td>
				<td style='$center'>---</td>
				<td style='$center'>---</td>
			";
		}
	};

	$ss = function($ss) use($checkDate, $clean, $center, $ranks){
		if($ss){
			$engine = $clean($ss->engine_type);
			$bhp = $clean($ss->bhp_kw);
			$on = $checkDate($ss->sign_on);
			$off = $checkDate($ss->sign_off);
			$manning = $clean($ss->manning_agent);
			$rank = $ranks[$ss->rank];

			echo "
				<tr>
					<td style='$center'>$rank</td>
					<td style='$center' colspan='3'>$ss->vessel_name</td>
					<td style='$center'>$ss->vessel_type</td>
					<td style='$center'>$engine</td>
					<td style='$center'>$bhp</td>
					<td style='$center'></td>
					<td style='$center'>$on</td>
					<td style='$center'>$off</td>
					<td style='$center' colspan='2'>$manning</td>
				</tr>
			";
		}
	};
@endphp

<table>
	<tr>
		<td colspan="11" rowspan="2" style="{{ $center }} font-size: 24px; height: 30px;">SEAFARER APPLICATION FORM</td>
		<td style="{{ $bold }} height: 30px;">NSM-SMM-07-03</td>
	</tr>

	<tr>
		<td style="height: 30px;">ISSUED: 20.09.2015</td>
	</tr>

	<tr><td colspan="12" style="height: 5px;"></td></tr>

	<tr>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td colspan="10"></td>
		<td colspan="2" rowspan="8" style="{{ $center }}">Recent Photograph</td>
	</tr>

	<tr>
		<td colspan="4" rowspan="6"></td>
		<td colspan="5">Position Applied</td>
		<td rowspan="6"></td>
	</tr>

	<tr>
		<td colspan="5">{{ $data->rank->name }}</td>
	</tr>

	<tr>
		<td colspan="2">Date available</td>
		<td colspan="3">Application Date</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="3">{{ now()->format('F j, Y') }}</td>
	</tr>

	<tr>
		<td colspan="2">Manning Agent</td>
		<td colspan="3">For Vessel</td>
	</tr>

	<tr>
		<td colspan="2">Solpia Marine</td>
		<td colspan="3">{{ $data->vessel ? $data->vessel->name : "N/A" }}</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="12" style="height: 10px;"></td>
	</tr>

	<tr>
		<td colspan="10">Full Name (Underline Surname)</td>
		<td colspan="2">Nationality</td>
	</tr>

	<tr>
		<td colspan="10">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td colspan="2">
			FILIPINO
		</td>
	</tr>

	<tr>
		<td colspan="4">Place of Birth</td>
		<td colspan="3">Date of Birth</td>
		<td colspan="3">Weight (Kg)</td>
		<td colspan="2">Height (cm)</td>
	</tr>

	<tr>
		<td colspan="4">{{ $data->birth_place }}</td>
		<td colspan="3">{{ $data->user->birthday ? $data->user->birthday->format('d-M-Y') : "---" }}</td>
		<td colspan="3" style="text-align: left;">{{ $data->weight }}</td>
		<td colspan="2" style="text-align: left;">{{ $data->height }}</td>
	</tr>

	@php
		$spouse = null;
		$mother = null;
		$father = null;
		$noc = 0;
		foreach($data->family_data as $fd){
			if($fd->type == "Spouse"){
				$spouse = $fd;
			}
			elseif($fd->type == "Mother"){
				$mother = $fd;
			}
			elseif($fd->type == "Father"){
				$father = $fd;
			}
			elseif($fd->type == "Son" || $fd->type == "Daughter"){
				$noc++;
			}
		}
	@endphp

	<tr>
		<td colspan="4">Marital Status</td>
		<td colspan="6">Name of Spouse</td>
		<td colspan="2">No. of Children</td>
	</tr>

	<tr>
		<td colspan="4">{{ $data->civil_status }}</td>
		<td colspan="6">{{ $spouse->lname }}, {{ $spouse->fname }} {{ $spouse->suffix }} {{ $spouse->mname }}</td>
		<td colspan="2" style="text-align: left;">{{ $noc }}</td>
	</tr>

	<tr>
		<td colspan="7">Tel: (Home)</td>
		<td colspan="5">Name of Next of Kin</td>
	</tr>

	<tr>
		<td colspan="7">{{ $data->provincial_contact }}</td>
		<td colspan="5" rowspan="3" style="{{ $center }}">
			@php
				$nok = $spouse ?? $father ?? $mother ?? null;
			@endphp
			{{ $nok->lname }}, {{ $nok->fname }} {{ $nok->suffix }} {{ $nok->mname }}
		</td>
	</tr>

	<tr>
		<td colspan="7">Tel: (Mobile)</td>
	</tr>

	<tr>
		<td colspan="7">{{ $data->user->contact }}</td>
	</tr>

	<tr>
		<td colspan="7">Email</td>
		<td colspan="3">Relationship</td>
		<td colspan="2">Tel</td>
	</tr>

	<tr>
		<td colspan="7">{{ $data->user->email }}</td>
		<td colspan="3" rowspan="2" style="{{ $center }}">{{ $nok->type }}</td>
		<td colspan="2" rowspan="2" style="{{ $center }}">{{ $data->provincial_contact }}</td>
	</tr>

	<tr>
		<td colspan="7">Address</td>
	</tr>

	<tr>
		<td colspan="7" rowspan="2">{{ $data->user->address }}</td>
		<td colspan="5">Address of Next of Kin</td>
	</tr>

	<tr>
		<td colspan="5" rowspan="3">{{ $nok->address }}</td>
	</tr>

	<tr>
		<td colspan="7">Most Convenient Airport</td>
	</tr>

	<tr>
		<td colspan="7"></td>
	</tr>

	{{ $doc('PASSPORT', "Passport", 'id', 1) }}
	{{ $doc("SEAMAN'S BOOK", "Seaman Book No", 'id', 1) }}
	{{ $doc('US-VISA', "U S A Visa (Type)" ,'id', 1) }}
	{{ $doc('HK-VISA', "Chinese / Hong Kong Visa (Type)" ,'id', 1) }}
	{{ $doc('COC', "Certificate of Competency No / Capacity (Limitations)" ,'lc', 1) }}

	<tr>
		{{ $doc('COE', "Certificate of Endorsement S'pore (COC) No" ,'lc', 2) }}
		{{ $doc('GMDSS/GOC', "Certificate of Endorsement Hkg (GOC) No" ,'lc', 3) }}
	</tr>
	<tr>
		{{ $doc('COE', "Certificate of Endorsement S'pore (COC) No" ,'lc', 4) }}
		{{ $doc('GMDSS/GOC', "Certificate of Endorsement Hkg (GOC) No" ,'lc', 5) }}
	</tr>

	<tr><td colspan="12"></td></tr>

	<tr>
		<td colspan="12" style="{{ $bold }}">Details of Previous Sea Service</td>
	</tr>

	<tr>
		<td style="{{ $center }}" rowspan="2">Rank</td>
		<td style="{{ $center }}" rowspan="2" colspan="3">Name of Vessel</td>
		<td style="{{ $center }}" rowspan="2">Type of Vessel</td>
		<td style="{{ $center }}" rowspan="2">Type of Engine</td>
		<td style="{{ $center }}" rowspan="2">Horse-Power</td>
		<td style="{{ $center }}" rowspan="2">DWT</td>
		<td style="{{ $center }}" colspan="2">Period of Service</td>
		<td style="{{ $center }}" rowspan="2" colspan="2">Name of Company</td>
	</tr>

	<tr>
		<td style="{{ $center }}">Sign-ON</td>
		<td style="{{ $center }}">Sign-OFF</td>
	</tr>

	{{ isset($data->sea_service[0]) ? $ss($data->sea_service[0]) : $ss(null) }}
	{{ isset($data->sea_service[1]) ? $ss($data->sea_service[1]) : $ss(null) }}
	{{ isset($data->sea_service[2]) ? $ss($data->sea_service[2]) : $ss(null) }}
	{{ isset($data->sea_service[3]) ? $ss($data->sea_service[3]) : $ss(null) }}
	{{ isset($data->sea_service[4]) ? $ss($data->sea_service[4]) : $ss(null) }}
	{{ isset($data->sea_service[5]) ? $ss($data->sea_service[5]) : $ss(null) }}
	{{ isset($data->sea_service[6]) ? $ss($data->sea_service[6]) : $ss(null) }}
	{{ isset($data->sea_service[7]) ? $ss($data->sea_service[7]) : $ss(null) }}
	{{ isset($data->sea_service[8]) ? $ss($data->sea_service[8]) : $ss(null) }}
	{{ isset($data->sea_service[9]) ? $ss($data->sea_service[9]) : $ss(null) }}
	{{ isset($data->sea_service[10]) ? $ss($data->sea_service[10]) : $ss(null) }}
	{{ isset($data->sea_service[11]) ? $ss($data->sea_service[11]) : $ss(null) }}
	{{ isset($data->sea_service[12]) ? $ss($data->sea_service[12]) : $ss(null) }}
	{{ isset($data->sea_service[13]) ? $ss($data->sea_service[13]) : $ss(null) }}
	{{ isset($data->sea_service[14]) ? $ss($data->sea_service[14]) : $ss(null) }}
	{{ isset($data->sea_service[15]) ? $ss($data->sea_service[15]) : $ss(null) }}

	{{-- 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE --}}
	{{-- 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE --}}
	{{-- 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE --}}
	{{-- 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE --}}
	{{-- 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE --}}
	{{-- 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE --}}
	{{-- 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE --}}
	{{-- 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE --}}
	{{-- 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE --}}
	{{-- 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE --}}
	{{-- 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE 2ND PAGE --}}
	<tr>
		<td colspan="11" rowspan="2" style="{{ $center }} font-size: 20px; height: 30px;">SEAFARER APPLICATION FORM</td>
		<td style="{{ $bold }} height: 30px;">FORM : C - 06</td>
	</tr>

	<tr>
		<td style="height: 30px;">ISSUED: 02.02.2011</td>
	</tr>

	<tr><td colspan="12" style="height: 5px;"></td></tr>

	<tr>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $center }} {{ $bold }}">Qualification</td>
		<td style="{{ $center }} {{ $bold }}">Cert No</td>
		<td style="{{ $center }} {{ $bold }}">Issued</td>
		<td style="{{ $center }} {{ $bold }}">Valid</td>
		<td style="{{ $center }} {{ $bold }}">Issue By</td>
		<td colspan="4" style="{{ $center }} {{ $bold }} text-decoration: underline;">
			Declaration To Be Signed By the Applicant
		</td>
	</tr>

	<tr>
		{{ $doc('GMDSS/GOC', 'GMDSS', 'lc', 6) }}
		<td colspan="4" rowspan="21" style="{{ $center }}">
			<br style='mso-data-placement:same-cell;' />
			I hereby certify that the information contained
			<br style='mso-data-placement:same-cell;' />
			in this form is complete &#38; correct. I understand that
			<br style='mso-data-placement:same-cell;' />
			the Company may terminate my service at any time
			<br style='mso-data-placement:same-cell;' />
			if any of the above information is fount to be false.
		</td>
	</tr>

	<tr>{{ $doc('SHIP HANDLING SIMULATION', 'Ship Handling', 'lc', 6) }}</tr>
	<tr>{{ $doc('ADVANCE FIRE FIGHTING - AFF', 'Advance Fire Fighting', 'lc', 6) }}</tr>
	<tr>{{ $doc('MEDICAL CARE - MECA', 'Medical Care (Compulsory for Master)', 'lc', 6) }}</tr>
	<tr>{{ $doc('MEDICAL FIRST AID - MEFA', 'Medical First Aid', 'lc', 6) }}</tr>
	<tr>{{ $doc('SURVIVAL AT SEA', 'Survival at Sea', 'lc', 6) }}</tr>
	<tr>{{ $doc('PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB', 'Survival Craft & Rescue boat', 'lc', 6) }}</tr>
	<tr>{{ $doc('GENERAL TANKER FAMILIARIZATION', 'Tanker Familiarization', 'lc', 6) }}</tr>
	<tr>{{ $doc('GAS TANKER', 'Advanced / Specialized Gas Tanker Safety', 'lc', 6) }}</tr>
	<tr>{{ $doc('ADVANCE TRAINING FOR OIL TANKER - ATOT', 'Advanced / Specialized Oil Tanker Safety', 'lc', 6) }}</tr>
	<tr>{{ $doc('ADVANCE TRAINING FOR CHEMICAL TANKER - ATCT', 'Advanced / Specialized Chemical Tanker Safety', 'lc', 6) }}</tr>
	<tr>{{ $doc('ELECTRONIC NAVIGATION SYSTEMS - ENS', 'Electronic Navigation Systems - ENS (Compulsory for Deck Officer)', 'lc', 6) }}</tr>
	<tr>{{ $doc('NCC', 'NCC (For Deck Officers)', 'lc', 7) }}</tr>
	<tr>{{ $doc('PSSR', 'PSSR', 'lc', 7) }}</tr>
	<tr>{{ $doc('DCE', 'DCE (OIL)', 'lc', 7) }}</tr>
	<tr>{{ $doc('DCE', 'DCE (CHEM)', 'lc', 7) }}</tr>
	<tr>{{ $doc('DCE', 'DCE (LPG)', 'lc', 7) }}</tr>
	<tr>{{ $doc('BTM', 'Bridge Team Management - BTM', 'lc', 6) }}</tr>
	<tr>{{ $doc('ETM', 'Engine Team Management - ETM', 'lc', 6) }}</tr>
	<tr>{{ $doc('IN HOUSE TRAINING CERT WITH ISM', 'ISM Code Familiarization', 'lc', 6) }}</tr>
	<tr>{{ $doc('RISK ASSESSMENT / INCIDENT INVESTIGATION COURSE', 'Risk Assessment', 'lc', 6) }}</tr>
	<tr>
		{{ $doc("SAFETY OFFICER'S TRAINING COURSE", 'Ship Safety Officer Certificate (Compulsory for Master & Chief Officer)', 'lc', 6) }}
		<td colspan="2" style="{{ $center }}">…………………………</td>
		<td colspan="2" style="{{ $center }}">……………………………………………</td>
	</tr>
	<tr>
		{{ $doc('SHIP SECURITY OFFICER - SSO', 'Ship Security Officer Certificate (Compulsory for Master)', 'lc', 6) }}
		<td colspan="2" style="{{ $center }}">Date</td>
		<td colspan="2" style="{{ $center }}">Signature of Applicant</td>
	</tr>

	<tr>
		<td colspan="12" style="{{ $bold }} height: 60px;">
			PPE &#38; Clothing Size
		</td>
	</tr>

	<tr>
		<td colspan="3">Safety Shoes:</td>
		<td colspan="2">Boiler Suit:</td>
		<td colspan="2">Winter Jacket:</td>
		<td colspan="3">Long John (Upper):</td>
		<td colspan="2">Long John (Lower):</td>
	</tr>

	<tr>
		<td colspan="3">{{ $data->shoe_size }}</td>
		<td colspan="2">{{ $data->clothes_size }}</td>
		<td colspan="2">{{ $data->clothes_size }}</td>
		<td colspan="3">{{ $data->clothes_size }}</td>
		<td colspan="2">{{ $data->waistline }}</td>
	</tr>

	<tr>
		<td colspan="3">For Officers Only:</td>
		<td colspan="2">White Shirt:</td>
		<td colspan="7">Blue Pants:</td>
	</tr>

	<tr>
		<td colspan="3"></td>
		<td colspan="2">{{ $data->clothes_size }}</td>
		<td colspan="7">{{ $data->waistline }}</td>
	</tr>

	<tr><td colspan="12" style="text-decoration: underline; height: 40px;">Available Sizes</td></tr>
	<tr><td colspan="12">Safety Shoes Sizes : 5, 6, 7, 8, 9, 10, 11, 12.</td></tr>
	<tr><td colspan="12">Boiler Suit / Winter Jacket / Long John Sizes: XS, S, M, L, XL, XXL.</td></tr>
	<tr><td colspan="12">White Shirt Sizes: S, M, L, XL</td></tr>
	<tr><td colspan="12">Blue Pants Sizes (Inches): 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40.</td></tr>

	<tr><td colspan="12" style="height: 80px; {{ $bold }}">For Office:</td></tr>
	<tr><td colspan="12"></td></tr>

	<tr>
		<td colspan="2">Interview by / Date:</td>
		<td colspan="5"></td>
		<td>Department:</td>
		<td colspan="2"></td>
		<td>Status:</td>
		<td>Approval / Rejected</td>
	</tr>

	<tr>
		<td colspan="2" rowspan="10">Comments:</td>
		<td colspan="10"></td>
	</tr>

	<tr><td colspan="10"></td></tr>
	<tr><td colspan="10"></td></tr>
	<tr><td colspan="10"></td></tr>
	<tr><td colspan="10"></td></tr>
	<tr><td colspan="10"></td></tr>
	<tr><td colspan="10"></td></tr>
	<tr><td colspan="10"></td></tr>
	<tr><td colspan="10"></td></tr>
	<tr><td colspan="10"></td></tr>
</table>