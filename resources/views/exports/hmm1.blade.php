@php
	$checkDate2 = function($date, $type){
		if($date == "UNLIMITED"){
			return $date;
		}
		elseif($date == "" || $date == null){
			if($type == "E"){
				return 'UNLIMITED';
			}
			else{
				return '-----';
			}
		}
		else{
			return $date->format('d-M-Y');
		}
	};

	// CHECK IF WATCHKEEPING AND HAS RANK AND IS DECK OR ENGINE RATING
	if(isset($data->rank_id)){
		$rank = $data->rank_id;
	}
	else{
		if(isset($data->rank)){
			$rank = $data->rank->id;
		}
		else{
			$rank = 0;
		}
	}

	$rank_category = "";
	if(isset($data->rank)){
		$rank_category = $data->rank->category;
	}
	$total = 0;

	$getDocument = function($docu, $type, $issuer = null, $name = null, $regulation = null, $period = null) use ($data, $checkDate2, $rank) {
		$name   = !$name ? $docu : $name;

		if(in_array($type, ['id', 'lc', 'med_cert'])){
			if($type == "lc" && ($docu == "COC" || $docu == "COE") && $name == "NATIONAL LICENSE - RATINGS"){
				if($rank > 0 && $regulation){
					$tempDocu = $docu;
					$docu = false;
					$temp = "";

					if($rank >= 9 && $rank <= 23){
						foreach($data->document_lc as $document){
							$regulation = json_decode($document->regulation);
							
							if($rank >= 9 && $rank <= 14){
								$tempName = "COC";
								$temp = $tempDocu == $tempName ? 'II/4' : 'II/5';
							}
							elseif($rank >= 15 && $rank <= 23){
								$tempName = "COE";
								$temp = $tempDocu == $tempName ? 'III/4' : 'III/5';
							}

						    if($document->type == $tempName && in_array($temp, $regulation)){
						        $docu = $document;
						        break; 
						    }
						}

						$name .= " ($temp)";
					}
					else{
						$docu = false;
					}
				}
				else{
					return;
				}
			}
			elseif ($docu == 'ECDIS SPECIFIC') {
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

					$number = $docu ? $docu->no : '-----';
					$issue  = $docu ? $checkDate2($docu->issue_date, 'I') : '-----';
					$expiry = $docu ? $checkDate2($docu->expiry_date, 'E') : '-----';

					if($docu){
						$string .= "
							<tr>
								<td colspan='2'>
									<span></span><span></span>$ecdis
								</td>

								<td colspan='1'>$number</td>
								<td colspan='2'>$issue</td>
								<td colspan='3'>$expiry</td>
								<td colspan='1'></td>
							</tr>
						";
					}

				}

				if($string != ""){
					echo $string;
					return;
				}
			}
			elseif ($docu == 'SSBT WITH BRM') {
				$temp = $docu;
				$docu = isset($data->{"document_$type"}->$docu) ? $data->{"document_$type"}->$docu : false;

				if(!$docu){
					$name = 'SSBT';
					$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;

					if(!$docu){
						$name = 'BRM';
						$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
					}

					if(!$docu){
						$name = 'BTM';
						$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
					}
				}
			}
			else{
				$temp = $docu;
				$docu = isset($data->{"document_$type"}->$docu) ? $data->{"document_$type"}->$docu : false;

				if(!$docu && $temp == "RADAR"){
					$name = 'RADAR TRAINING COURSE';
					$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;

					if(!$docu){
						$name = 'RADAR SIMULATOR COURSE';
						$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
					}

					if(!$docu){
						$name = 'RADAR OPERATOR PLOTTING AID';
						$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
					}
				}
			}

		}
		elseif($type == 'flag'){

			$temp = $docu;
			$docu = false;

			if($rank >= 24 && $rank <= 26){
				if($temp == 'LICENSE'){
					$temp = "SHIP'S COOK ENDORSEMENT";
				}
			}

			foreach($data->document_flag as $document){
			    if($document->country == "Panama" && $document->type == $temp){
			        $docu = $document;
			    }
			}
		}

		$noNum  = $type == 'lc' ? 'no' : 'number';

		$number = $docu ? $docu->$noNum : '-----';
		$issue  = $docu ? $checkDate2($docu->issue_date, 'I') : '-----';
		$expiry = $docu ? $checkDate2($docu->expiry_date, 'E') : '-----';

		// $issuer = $issuer != null ? $issuer : $docu ? $docu->issuer : 'NOT APPLICABLE';
		if($issuer != ""){
			$issuer = $issuer;
		}
		else{
			$issuer = $type == "med_cert" ? 'clinic' : 'issuer';
			$issuer = $docu ? $docu->$issuer : 'NOT APPLICABLE';

			if($issuer == "NOT APPLICABLE" && $type == "med_cert"){
				$issuer = "REVERTING";
			}
		}

		$noNum  = $type == 'lc' ? 'no' : 'number';

		$number = $docu ? $docu->$noNum : '-----';
		$issue  = $docu ? $checkDate2($docu->issue_date, 'I') : '-----';
		$expiry = $docu ? $checkDate2($docu->expiry_date, 'E') : 'UNLIMITED';

		if($number != '-----' || $name == "NC1 LICENSE" || $name == "NC3 LICENSE" || $name == "PHILIPPINES" || $name == "US VISA" || $name == "PASSPORT"){
			if(str_starts_with($name, 'COC') || $name == "NC1 LICENSE" || $name == "NC3 LICENSE" || $name == "PHILIPPINES" || $name == "US VISA"){
				echo "
					<td>$name</td>
					<td>$issuer</td>
					<td>$number</td>
					<td colspan='2'>$issue</td>
					<td>$expiry</td>
				";
			}
			elseif ($name == "PASSPORT") {
				echo "
					<td>$issuer</td>
					<td>$number</td>
					<td colspan='2'>$issue</td>
					<td>$expiry</td>
				";
			}
			else{
				echo "
					<td colspan='3'>$name</td>
					<td colspan='2'>$number</td>
					<td colspan='2'>$period</td>
					<td colspan='3'>$issuer</td>
					<td>$issue</td>
					<td colspan='3'>$expiry</td>
				";
			}
		}
		else{
			echo "
				<td colspan='3'>$name</td>
				<td colspan='2'style='color: #ff0000; font-weight: bold;'>REVERTING</td>
				<td colspan='2'>$period</td>
				<td colspan='3'>$issuer</td>
				<td style='color: #ff0000; font-weight: bold;'>REVERTING</td>
				<td colspan='3' style='color: #ff0000; font-weight: bold;'>REVERTING</td>
			";
		}
	};

	function isBlank($name, $issuer){
		echo "
			<td>$name</td>
			<td>$issuer</td>
			<td>-----</td>
			<td colspan='2'>-----</td>
			<td>-----</td>
		";
	}
	
	function isBlank2(){
		echo "
			<td></td>
			<td></td>
			<td colspan='2'></td>
			<td></td>
			<td colspan='2'></td>
			<td></td>
		";
	}

	$eb = function($type) use ($data){
		foreach($data->educational_background as $eb){
			$course = str_replace('&', '&#38;', $eb->course);
			if($eb->type == $type){
				echo "$eb->school/$course/$eb->year/Graduated";
			}
		} 
	};

	$total = 0;
	// &$total is passing value by reference
	$ss = function($ss, $vr) use($checkDate2, &$total){
		if($ss->vessel_name != null && $ss->vessel_type != null){
			$on = $checkDate2($ss->sign_on, 'in');
			$off = $checkDate2($ss->sign_off, 'in');
			$eng = str_replace('&', '&#38;', $ss->engine_type);

			$dura = "-";
			if($ss->sign_on != "" && $ss->sign_off != ""){
				$dura = $ss->sign_on->diffInDays($ss->sign_off);
			}
			$man = str_replace('&', '&#38;', $ss->manning_agent);
			$bhp = str_replace('&', '&#38;', $ss->bhp_kw);
			$cn = str_replace('&', '&#38;', $ss->crew_nationality);

			$total += $ss->sign_on->diffInDays($ss->sign_off);

			echo "
				<td>$ss->flag</td>
				<td colspan='2'>$ss->vessel_name</td>
				<td>$ss->gross_tonnage</td>
				<td>$bhp</td>
				<td>$ss->vessel_type</td>
				<td>$vr</td>
				<td>$eng</td>
				<td>$on</td>
				<td>$off</td>
				<td>$dura</td>
				<td>$ss->remarks</td>
				<td>$cn</td>
				<td>$man</td>
				<td>$ss->principal</td>
			";
		}
	};
	$fd = function($fd, $i2) use($checkDate2){
		$i2++;
		$name = $fd->fname . ' ' . $fd->lname . ' ' . $fd->suffix ?? '';
		$dob = $checkDate2($fd->birthday, 'in');

		if($fd->fname == ""){
			return isBlank2();
		}

		echo "
			<td>$i2</td>
			<td>$fd->type</td>
			<td colspan='2'>$name</td>
			<td>$dob</td>
			<td colspan='2'>-----</td>
			<td>$fd->occupation</td>
		";
	};

@endphp

<table>
	<tr>
		<td rowspan="42"></td>
		<td colspan="24">{{-- LETTER HEAD --}}</td>
	</tr>

	<tr>
		<td colspan="22"></td>
		<td>RANK:</td>
		<td>{{ isset($data->rank) ? $data->rank->abbr : '--' }}</td>
	</tr>

	<tr>
		<td rowspan=50></td>
		<td colspan="3" rowspan="7">{{-- AVATAR --}}</td>
		<td colspan="5">{{ $data->user->fname }} {{ $data->user->mname }} {{ $data->user->lname }}</td>
		<td colspan="6" rowspan="2" style="text-decoration: underline;">PERSONAL HISTORY</td>
		<td>Military</td>	
		<td>Branch of Army</td>	
		<td colspan="7">N/A</td>	
	</tr>

	<tr>
		<td>GIVEN NAME</td>
		<td>M.I.</td>
		<td colspan="3">SURNAME</td>
		<td>Service</td>
		<td>Period</td>
		<td colspan="7">N/A</td>
	</tr>

	<tr>
		<td colspan="2">Nationality</td>
		<td colspan="3">FILIPINO</td>
		<td colspan="6">ADDRESS</td>
		<td>Hobbies</td>
		<td colspan="2">{{-- HOBBY --}}</td>
		<td>Specialty</td>
		<td colspan="2">{{-- SPECIALTY --}}</td>
		<td>Religion</td>
		<td colspan="2">{{ $data->religion }}</td>
	</tr>

	<tr>
		<td colspan="2">Date of Birth</td>
		<td colspan="3">{{ $data->user->birthday ? $data->user->birthday->format('d-F-Y') : '---' }}</td>
		<td>Home Address</td>
		<td colspan="5">{{ $data->user->address }}</td>
		<td>Tel No.</td>
		<td colspan="2">{{ $data->user->contact }}</td>
		<td>Property</td>
		<td>Movab</td>
		<td>N/A</td>
		<td>Fixed</td>
		<td colspan="2">N/A</td>
	</tr>

	<tr>
		<td colspan="2">Place of Birth</td>
		<td colspan="3">{{ $data->birth_place }}</td>
		<td colspan="4">Contact Address in Manila (If Available)</td>
		<td colspan="4">{{ $data->provincial_address ?? "None" }}</td>
		<td>Tel No.</td>
		<td colspan="2">{{ $data->provincial_contact ?? "None" }}</td>
		<td></td>
		<td colspan="2">Owned ( )</td>
		<td>Rental ( )</td>
	</tr>

	<tr>
		<td colspan="4">Past Sickness/Operations</td>
		<td>NIL</td>
		<td rowspan="8" style="text-decoration: underline;">MARINE TRAINING AND/OR CERTIFICATES</td>
		<td colspan="3" rowspan="2">Course</td>
		<td colspan="2" rowspan="2">Number</td>
		<td colspan="2" rowspan="2">Period</td>
		<td colspan="4">Issue</td>
		<td colspan="3" rowspan="2">Validity</td>
	</tr>

	<tr>
		<td colspan="4">Present Sickness/Allergy</td>
		<td>NIL</td>
		<td colspan="3">Institution</td>
		<td>Date</td>
	</tr>

	<tr>
		<td colspan="2" rowspan="3" style="text-decoration: underline;">PHYSICAL</td>
		<td>Race</td>
		<td colspan="2">FILIPINO</td>
		<td>Blood Type</td>
		<td colspan="2">{{ $data->blood_type }}</td>

		{{-- 1 --}}
		{{ $getDocument('BASIC TRAINING - BT', 'lc', 'MARINA', 		'COP BT', '', '5 YEARS')}}
	</tr>

	<tr>
		<td>Height</td>
		<td colspan="2">{{ $data->height }}</td>
		<td>Foot Size</td>
		<td>{{ $data->shoe_size }}</td>
		<td>mm</td>

		{{-- 2 --}}
		{{ $getDocument('PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB', 'lc', 'MARINA', 		'COP PSCRB', '', '5 YEARS')}}
	</tr>

	<tr>
		<td>Weight</td>
		<td colspan="2">{{ $data->weight }}</td>
		<td>Vision</td>
		<td></td>
		<td></td>

		{{-- 3 --}}
		{{ $getDocument('SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD', 'lc', 'MARINA', 		'COP SDSD', null, 'UNLIMITED')}}
	</tr>

	<tr>
		<td colspan="2" rowspan="7" style="text-decoration: underline;">LICENSE</td>
		<td>Grade</td>
		<td>Issued By</td>
		<td>Cert No.</td>
		<td colspan="2">Date of Issue</td>
		<td>Validity</td>

		{{-- 4 --}}
		{{ $getDocument('MEDICAL CERTIFICATE', 'med_cert', '', 		'MEDICAL EXAMINATION', '', '2 YEARS', null, "2 YEARS")}}
	</tr>

	<tr>
		@if($rank_category == "DECK OFFICER")
			{{ $getDocument('COC', 			'lc', 		'MARINA', 		'COC-DECK OFFICER')}}
		@else
			{{ isBlank('COC-DECK OFFICER', 'MARINA') }}
		@endif

		{{-- 5 --}}
		{{ $getDocument('DRUG AND ALCOHOL TEST', 'med_cert', '', null, null, "1 YEAR")}}
	</tr>

	<tr>
		@if($rank_category == "ENGINE OFFICER")
			{{ $getDocument('COC', 			'lc', 		'MARINA', 		'COC-ENGINE OFFICER')}}
		@else
			{{ isBlank('COC-ENGINE OFFICER', 'MARINA') }}
		@endif

		{{-- 6 --}}
		{{ $getDocument('YELLOW FEVER', 'med_cert', '', 'YELLOW FEVER', null, 'UNLIMITED')}}
	</tr>

	<tr>
		@if($rank_category == "DECK RATING")
			{{ $getDocument('COC', 			'lc', 		'MARINA', 		'COC-DECK RATING')}}
		@else
			{{ isBlank('COC-DECK RATING', 'MARINA') }}
		@endif

		<td rowspan="2" style="text-decoration: underline;">SEAMAN'S CAREER</td>
		<td rowspan="3" colspan="2">Name of Vessel</td>
		<td rowspan="3">G/T</td>
		<td rowspan="3">PS BHP</td>
		<td rowspan="3">Type of Vessel</td>
		<td rowspan="3">Rank</td>
		<td rowspan="3">Engine</td>
		<td colspan="2">Data</td>
		<td rowspan="3">Duration</td>
		<td rowspan="3">Reason for Disembarkation</td>
		<td rowspan="3">Nationality of Combined Crew</td>
		<td colspan="2">Company</td>
	</tr>

	<tr>
		@if($rank_category == "ENGINE RATING")
			{{ $getDocument('COC', 			'lc', 		'MARINA', 		'COC-ENGINE RATING')}}
		@else
			{{ isBlank('COC-ENGINE RATING', 'MARINA') }}
		@endif
		
		<td rowspan="2">Embark</td>
		<td rowspan="2">Disembark</td>
		<td rowspan="2">Manning</td>
		<td rowspan="2">Principal</td>
	</tr>

	<tr>
		{{ $getDocument('NCI', 			'lc', 		'TESDA', 		'NC1 LICENSE')}}
		
		<td>Flag</td>
	</tr>

	{{-- SEA SERVICE --}}
	<tr>
		{{ $getDocument('NCIII', 			'lc', 		'TESDA', 		'NC3 LICENSE')}}
		
		@php 
			$i = 0;
			if(isset($data->sea_service[$i])){
				echo $ss($data->sea_service[$i], $data['ranks'][$data->sea_service[$i]->rank]);
			}
		@endphp
	</tr>

	<tr>
		<td colspan="2" rowspan="2">SEAMAN'S BOOK</td>
		{{ $getDocument("SEAMAN'S BOOK",'id','MARINA', "PHILIPPINES")}}
		
		@php 
			$i = 1; 
			if(isset($data->sea_service[$i])){
				echo $ss($data->sea_service[$i], $data['ranks'][$data->sea_service[$i]->rank]);
			}
		@endphp
	</tr>

	<tr>
		{{ $getDocument("US-VISA", 		'id', 		'US EMBASSY', 	'US VISA')}}
		
		@php 
			$i = 2; 
			if(isset($data->sea_service[$i])){
				echo $ss($data->sea_service[$i], $data['ranks'][$data->sea_service[$i]->rank]);
			}
		@endphp
	</tr>

	<tr>
		<td colspan="3">Passport</td>
		{{ $getDocument('PASSPORT', 'id','DFA')}}
		
		@php 
			$i = 3; 
			if(isset($data->sea_service[$i])){
				echo $ss($data->sea_service[$i], $data['ranks'][$data->sea_service[$i]->rank]);
			}
		@endphp
	</tr>

	<tr>
		<td colspan="8" style="text-decoration: underline;">FAMILY BACKGROUND</td>
		
		@php 
			$i = 4; 
			if(isset($data->sea_service[$i])){
				echo $ss($data->sea_service[$i], $data['ranks'][$data->sea_service[$i]->rank]);
			}
		@endphp
	</tr>

	<tr>
		<td></td>
		<td>Relation</td>
		<td colspan="2">Name</td>
		<td>D.O.B.</td>
		<td colspan="2">Schooling</td>
		<td>Occupation</td>
		
		@php 
			$i = 5; 
			if(isset($data->sea_service[$i])){
				echo $ss($data->sea_service[$i], $data['ranks'][$data->sea_service[$i]->rank]);
			}
		@endphp
	</tr>

	<tr>
		@php 
			$i2 = 0; 
		@endphp
		{{ isset($data->family_data[$i2]) ? $fd($data->family_data[$i2], $i2) : isBlank2() }}
		
		@php 
			$i = 6; 
			if(isset($data->sea_service[$i])){
				echo $ss($data->sea_service[$i], $data['ranks'][$data->sea_service[$i]->rank]);
			}
		@endphp
	</tr>

	<tr>
		@php 
			$i2 = 1; 
		@endphp
		{{ isset($data->family_data[$i2]) ? $fd($data->family_data[$i2], $i2) : isBlank2() }}
		
		@php 
			$i = 7; 
			if(isset($data->sea_service[$i])){
				echo $ss($data->sea_service[$i], $data['ranks'][$data->sea_service[$i]->rank]);
			}
		@endphp
	</tr>

	<tr>
		@php 
			$i2 = 2; 
		@endphp
		{{ isset($data->family_data[$i2]) ? $fd($data->family_data[$i2], $i2) : isBlank2() }}
		
		@php 
			$i = 8; 
			if(isset($data->sea_service[$i])){
				echo $ss($data->sea_service[$i], $data['ranks'][$data->sea_service[$i]->rank]);
			}
		@endphp
	</tr>

	<tr>
		@php 
			$i2 = 3; 
		@endphp
		{{ isset($data->family_data[$i2]) ? $fd($data->family_data[$i2], $i2) : isBlank2() }}
		
		@php 
			$i = 9; 
			if(isset($data->sea_service[$i])){
				echo $ss($data->sea_service[$i], $data['ranks'][$data->sea_service[$i]->rank]);
			}
		@endphp
	</tr>

	<tr>
		@php 
			$i2 = 4; 
		@endphp
		{{ isset($data->family_data[$i2]) ? $fd($data->family_data[$i2], $i2) : isBlank2() }}
		
		@php 
			$i = 10; 
			if(isset($data->sea_service[$i])){
				echo $ss($data->sea_service[$i], $data['ranks'][$data->sea_service[$i]->rank]);
			}
		@endphp
	</tr>

	<tr>
		@php 
			$i2 = 5; 
		@endphp
		{{ isset($data->family_data[$i2]) ? $fd($data->family_data[$i2], $i2) : isBlank2() }}
		
		@php 
			$i = 11; 
			if(isset($data->sea_service[$i])){
				echo $ss($data->sea_service[$i], $data['ranks'][$data->sea_service[$i]->rank]);
			}
		@endphp
	</tr>

	<tr>
		@php 
			$i2 = 6;
		@endphp
		{{ isset($data->family_data[$i2]) ? $fd($data->family_data[$i2], $i2) : isBlank2() }}
		
		<td></td>
		<td colspan="2"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>Total: </td>
		<td>{{ $total }}</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		@php 
			$i2 = 7; 
		@endphp
		{{ isset($data->family_data[$i2]) ? $fd($data->family_data[$i2], $i2) : isBlank2() }}
		
		<td>Land Job</td>
		<td colspan="14"></td>
	</tr>

	<tr>
		@php 
			$i2 = 8; 
		@endphp
		{{ isset($data->family_data[$i2]) ? $fd($data->family_data[$i2], $i2) : isBlank2() }}
		
		<td colspan="2">Special Career</td>
		<td colspan="13"></td>
	</tr>

	<tr>
		@php 
			$i2 = 9; 
		@endphp
		{{ isset($data->family_data[$i2]) ? $fd($data->family_data[$i2], $i2) : isBlank2() }}
		
		<td colspan="2">Board Examination</td>
		<td colspan="13"></td>
	</tr>

	<tr>
		@php 
			$i2 = 10; 
		@endphp
		{{ isset($data->family_data[$i2]) ? $fd($data->family_data[$i2], $i2) : isBlank2() }}
		
		<td>Cadetship</td>
		<td colspan="14"></td>
	</tr>

	<tr>
		@php 
			$i2 = 11; 
		@endphp
		{{ isset($data->family_data[$i2]) ? $fd($data->family_data[$i2], $i2) : isBlank2() }}
		
		<td colspan="5">Rewards/Punishments from POEA/Former Company/Others</td>
		<td colspan="10"></td>
	</tr>

	<tr>
		@php 
			$i2 = 12; 
		@endphp
		{{ isset($data->family_data[$i2]) ? $fd($data->family_data[$i2], $i2) : isBlank2() }}
		
		<td rowspan="3">Remarks:</td>
		<td colspan="14" style="background-color: #ebf8a4"></td>
	</tr>

	<tr>
		@php 
			$i2 = 13; 
		@endphp
		{{ isset($data->family_data[$i2]) ? $fd($data->family_data[$i2], $i2) : isBlank2() }}
		
		<td colspan="14"></td>
	</tr>

	{{-- EDUCATIONAL BG --}}
	<tr>
		<td colspan="8">Educational Background (Name/Major Study/School Year/Graduated/Quit)</td>
		
		<td colspan="14"></td>
	</tr>

	<tr>
		<td colspan="2">Primary/Elementary</td>
		<td colspan="6">{{ $eb('Elementary') }}</td>
		
		<td colspan="10">I hereby certify that the above information are true and correct in every detail.</td>
		<td colspan="2">Serial #</td>
		<td colspan="3" rowspan="2">
			@if(auth()->user()->fleet == "FLEET D")
				MS. JANICE AGUACITO
			@endif
		</td>
	</tr>

	<tr>
		<td colspan="2">Secondary</td>
		<td colspan="6">{{ $eb('High School') }}</td>
		
		<td colspan="10"></td>
		<td colspan="2">Encoder:</td>
	</tr>

	<tr>
		<td colspan="2">Colleges</td>
		<td colspan="6">{{ $eb('College') }}</td>
		
		<td>Date: </td>
		<td colspan="4">{{ now()->format('d-M-Y') }}</td>
		<td>Applicant:</td>
		<td colspan="4">{{ $data->user->fname . ' ' . $data->user->mname . ' ' . $data->user->lname }}</td>
		<td colspan="2">Approved By:</td>
		<td colspan="3">
			@if(auth()->user()->fleet == "FLEET B")
				MR. ADULF KIT JUMAWAN
			@elseif(auth()->user()->fleet == "FLEET D")
				MS. THEA GUERRA
			@else
				@if(auth()->user()->gender == "Male")
					MR. {{ auth()->user()->fname }} {{ auth()->user()->lname }}
				@else
					MS. {{ auth()->user()->fname }} {{ auth()->user()->lname }}
				@endif
			@endif
		</td>
	</tr>
</table>