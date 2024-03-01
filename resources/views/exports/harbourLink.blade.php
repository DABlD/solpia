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
			elseif ($docu == 'BRM') {
				$temp = $docu;
				$docu = isset($applicant->{"document_$type"}->$docu) ? $applicant->{"document_$type"}->$docu : false;
				if(!$docu){
					$name = 'BTM';
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
					if(!$docu){
						$name = 'SSBT';
						$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
					}
				}
			}
			elseif ($docu == 'ERM') {
				$temp = $docu;
				$docu = isset($applicant->{"document_$type"}->$docu) ? $applicant->{"document_$type"}->$docu : false;
				if(!$docu){
					$name = 'ETM';
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
					if(!$docu){
						$name = 'ERS';
						$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
					}
				}
			}
			elseif($docu == "WATCHKEEPING"){
				$temp = $docu;
				$docu = isset($data->{'document_' . $type}->{$docu}) ? $data->{'document_' . $type}->{$docu} : null;
				if(!$docu){
					$doc = "DECK WATCHKEEPING";
					$docu = isset($data->{'document_' . $type}->{$docu}) ? $data->{'document_' . $type}->{$docu} : null;
				}
				if(!$docu){
					$doc = "DECK WATCH";
					$docu = isset($data->{'document_' . $type}->{$docu}) ? $data->{'document_' . $type}->{$docu} : null;
				}
				if(!$docu){
					$doc = "ENGINE WATCHKEEPING";
					$docu = isset($data->{'document_' . $type}->{$docu}) ? $data->{'document_' . $type}->{$docu} : null;
				}
				if(!$docu){
					$doc = "ENGINE WATCH";
					$docu = isset($data->{'document_' . $type}->{$docu}) ? $data->{'document_' . $type}->{$docu} : null;
				}
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

		if($doc == "HK-VISA"){
			$number = "NOT APPLICABLE";
			$issuer = "NOT APPLICABLE";
			$issue = "NOT APPLICABLE";
			$expiry = "NOT APPLICABLE";
		}

		$blue = 'color: #0000FF;';
		
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
				<td colspan='3'>$title</td>
				<td style='$center $blue'>$number</td>
				<td style='$center'>$issue</td>
				<td style='$center'>$expiry</td>
				<td style='$center'>$issuer</td>
			";
		}
		elseif($type2 == 7){
			echo "
				<td colspan='3'>$title</td>
				<td style='$center $blue'>NOT APPLICABLE</td>
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
			$grt = $clean($ss->gross_tonnage);
			$on = $checkDate($ss->sign_on);
			$off = $checkDate($ss->sign_off);
			$manning = $clean($ss->manning_agent);
			$rank = null;
			if(isset($ss->rank) && $ss->rank != ""){
				$rank = $ranks[$ss->rank];
			}

			echo "
				<tr>
					<td style='$center'>$rank</td>
					<td style='$center' colspan='3'>$ss->vessel_name</td>
					<td style='$center'>$ss->vessel_type</td>
					<td style='$center'>$engine</td>
					<td style='$center'>$bhp</td>
					<td style='$center'>$grt</td>
					<td style='$center'>$on</td>
					<td style='$center'>$off</td>
					<td style='$center' colspan='2'>$manning</td>
				</tr>
			";
		}
		else{
			echo "
				<tr>
					<td style='$center'></td>
					<td style='$center' colspan='3'></td>
					<td style='$center'></td>
					<td style='$center'></td>
					<td style='$center'></td>
					<td style='$center'></td>
					<td style='$center'></td>
					<td style='$center'></td>
					<td style='$center' colspan='2'></td>
				</tr>
			";
		}
	};
@endphp

<table>
	<tr>
		<td colspan="12" rowspan="2" style="{{ $center }} font-size: 24px; height: 55px;">SEAFARER APPLICATION FORM</td>
	</tr>

	<tr></tr>

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

	@php
		$rank = null;
		if(isset($data->rank)){
			$rank = $data->rank->name;
			if($rank == "2ND OFFICER"){
				$rank = "SECOND OFFICER";
			}
			elseif($rank == "3RD OFFICER"){
				$rank = "THIRD OFFICER";
			}
			elseif($rank == "1ST ASST. ENGR"){
				$rank = "FIRST ASSISTANT ENGINEER";
			}
			elseif($rank == "2ND ASST. ENGR"){
				$rank = "SECOND ASSISTANT ENGINEER";
			}
			elseif($rank == "3RD ASST. ENGR"){
				$rank = "THIRD ASSISTANT ENGINEER";
			}
		}
	@endphp
	<tr>
		<td colspan="5">{{ $rank }}</td>
	</tr>

	<tr>
		<td colspan="2">Date available</td>
		<td colspan="3">Application Date</td>
	</tr>

	<tr>
		<td colspan="2">Anytime</td>
		<td colspan="3">{{ now()->format('F j, Y') }}</td>
	</tr>

	<tr>
		<td colspan="2">Manning Agent</td>
		<td colspan="3">For Vessel</td>
	</tr>

	<tr>
		<td colspan="2">Solpia Marine &#38; Ship Mgt. Inc</td>
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
		<td colspan="6">{{ $spouse->lname ?? "" }}, {{ $spouse->fname ?? "" }} {{ $spouse->suffix ?? "" }} {{ $spouse->mname ?? "" }}</td>
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
			@if($nok)
				{{ $nok->lname }}, {{ $nok->fname }} {{ $nok->suffix }} {{ $nok->mname }}
			@else
				---
			@endif
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
		<td colspan="3" rowspan="2" style="{{ $center }}">{{ $nok->type ?? '---' }}</td>
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
		<td colspan="5" rowspan="3">{{ $data->user->address }}</td>
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
		<td style="{{ $center }}" rowspan="2">Horse- Power</td>
		<td style="{{ $center }}" rowspan="2">GT</td>
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
		<td colspan="12" rowspan="2" style="{{ $center }} font-size: 20px; height: 65px;">SEAFARER APPLICATION FORM</td>
	</tr>

	<tr></tr>

	<tr><td colspan="12" style="height: 5px;"></td></tr>

	<tr>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td style="{{ $center }} {{ $bold }}">No</td>
		<td colspan="3" style="{{ $center }} {{ $bold }}">Descriptions of Documents and Certificate</td>
		<td style="{{ $center }} {{ $bold }}">Cert No</td>
		<td style="{{ $center }} {{ $bold }}">Issued</td>
		<td style="{{ $center }} {{ $bold }}">Valid</td>
		<td style="{{ $center }} {{ $bold }}">Issue By</td>
		<td colspan="4" style="{{ $center }} {{ $bold }} text-decoration: underline;">
			Declaration To Be Signed By the Applicant
		</td>
	</tr>

	<tr>
		<td>1</td>
		{{ $doc('MEDICAL CERTIFICATE', 'Medical/Physical Examination Report Cert', 'med_cert', 6) }}

		<td colspan="4" rowspan="26" style="{{ $center }}">
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

	<tr>
		<td>2</td>
		{{ $doc('MSID', 'Malaysia Seafarer Card/MSID', 'lc', 6) }}
	</tr>
	<tr>
		<td>3</td>
		{{ $doc('MCOR', 'Malaysia COR(for Officers only)', 'lc', 7) }}
	</tr>
	<tr>
		{{-- COVID --}}
		<td>4</td>
		<td colspan="3">Covid Vaccination:</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		{{-- dose 1 --}}
		<td></td>
		{{ $doc('COVID-19 1ST DOSE', 'a) Dose 1', 'med_cert', 6) }}
	</tr>
	<tr>
		{{-- dose 2 --}}
		<td></td>
		{{ $doc('COVID-19 2ND DOSE', 'b) Dose 2', 'med_cert', 6) }}
	</tr>
	<tr>
		{{-- Booster --}}
		<td></td>
		{{ $doc('COVID-19 3RD DOSE', 'c) Booster', 'med_cert', 6) }}
	</tr>
	<tr>
		<td>5</td>
		{{ $doc('YELLOW FEVER', 'Yellow Fever/Stamaril', 'med_cert', 6) }}
	</tr>
	<tr>
		<td style="height: 35px;">6</td>
		{{ $doc('TYPHOID', 'Typhoid Vaccination (for Cook and Messboy only)', 'med_cert', 6) }}
	</tr>
	<tr>
		<td style="height: 35px;">7</td>
		{{ $doc('WATCHKEEPING', 'Watchkeeping Rating(Deck/Engine) or ASD/ASE', 'lc', 6) }}
	</tr>
	<tr>
		<td>8</td>
		{{ $doc('BASIC TRAINING - BT', 'Basic Safety Training(BST or BSTR)', 'lc', 6) }}
	</tr>
	<tr>
		<td style="height: 35px;">9</td>
		{{ $doc('PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB', 'Proficiency Survival Craft and Rescure Boats (PSCRB or PSCRBR)', 'lc', 6) }}
	</tr>
	<tr>
		<td>10</td>
		{{ $doc('MEDICAL FIRST AID - MEFA', 'Medical First Aid (MFA)', 'lc', 6) }}
	</tr>
	<tr>
		<td>11</td>
		{{ $doc('ADVANCE FIRE FIGHTING - AFF', 'Advance Fire Fighting (AFF ir AFFR)', 'lc', 6) }}
	</tr>
	<tr>
		<td style="height: 35px;">12</td>
		{{ $doc('MEDICAL CARE - MECA', 'Medical Care on Board Ship (Master and C/O only)', 'lc', 7) }}
	</tr>
	<tr>
		<td>13</td>
		{{ $doc('LMS', 'Leadership and Managerial Skill (LMS)', 'lc', 7) }}
	</tr>
	<tr>
		<td style="height: 35px;">14</td>
		{{ $doc('ECDIS', 'ECDIS/Electronic Chart Display &#38; Inf. System', 'lc', 7) }}
	</tr>
	<tr>
		<td>15</td>
		{{ $doc('ARPA TRAINING COURSE', 'ARPA Radar Simulator', 'lc', 6) }}
	</tr>
	<tr>
		<td>16</td>
		{{ $doc('BTM', 'Bridge Resource Management - BRM', 'lc', 6) }}
	</tr>
	<tr>
		<td>17</td>
		{{ $doc('ETM', 'Engine Resource Management - ERM', 'lc', 6) }}
	</tr>
	<tr>
		<td style="height: 35px;">18</td>
		{{ $doc('SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD', 'Designated Security Duties (DSD) or Security Related Training (SRT VI-6)', 'lc', 6) }}
	</tr>
	<tr>
		<td style="height: 35px;">19</td>
		{{ $doc('SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD', 'Ship Security Awareness (SSA) or Security Related Training (SRT VI-6)', 'lc', 6) }}
	</tr>
	<tr>
		<td style="height: 35px;">20</td>
		{{ $doc('SHIP SECURITY OFFICER - SSO', 'Ship Security Officer Certificate (Compulsory for Master)', 'lc', 7) }}
	</tr>
	<tr>
		<td style="height: 35px;">21</td>
		{{ $doc("SAFETY OFFICER'S TRAINING COURSE", 'Ship Safety Officer Certificate (Compulsory for Master & Chief Officer)', 'lc', 6) }}
	</tr>
	<tr>
		<td style="height: 35px;">22</td>
		{{ $doc('NCIII', 'Shipboard Catering Management / Ship Cook (MLC 2006)', 'lc', 7) }}
	</tr>
	<tr>
		<td style="height: 35px;">23</td>
		{{ $doc('NC1', 'Food Handling Certificate (Messboy &#38; C/Cook)', 'lc', 7) }}
	</tr>
	<tr>
		<td style="height: 35px;">24</td>
		{{ $doc("WELDING COURSE", 'Welder Performance Qualification (WPQ) or 3G/6G Welding Certificate', 'lc', 6) }}
		<td colspan="2" style="{{ $center }}">…………………………</td>
		<td colspan="2" style="{{ $center }}">……………………………………………</td>
	</tr>
	<tr>
		<td>25</td>
		{{ $doc('ELECTRO-TECHNICAL RATINGS', 'Electro Technical Rating(ETR)', 'lc', 6) }}
		<td colspan="2" style="{{ $center }}">Date</td>
		<td colspan="2" style="{{ $center }}">Signature of Applicant</td>
	</tr>
</table>