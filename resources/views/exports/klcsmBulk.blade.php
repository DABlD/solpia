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

	$ssTotal["BULK"] = [0,0];
	$ssTotal["TANKER"] = [0,0];
	$ssTotal["CONTAINER"] = [0,0];
	$ssTotal["GENERAL CARGO"] = [0,0];
	$ssTotal["REEFER"] = [0,0];
	$ssTotal["OTHERS"] = [0,0];
	$totalMonths = 0;
	$totalYears = 0;

	foreach($data->sea_service as $ss){
		$type = strtoupper($ss->vessel_type);

		if(str_contains($type, 'BULK') || str_contains($type, 'VLOC')){
			$type = 'BULK';
		}
		elseif(str_contains($type, 'TANK') || str_contains($type, 'CHEM' || str_contains($type, 'VLCC'))){
			$type = 'TANKER';
		}
		elseif(str_contains($type, 'CONT')){
			$type = "CONTAINER";
		}
		elseif(str_contains($type, 'GEN') || str_contains($type, 'CARGO')){
			$type = "GENERAL CARGO";
		}
		elseif(str_contains($type, 'REEF')){
			$type = "REEFER";
		}
		else{
			$type = "OTHERS";
		}

		$ssTotal[$type][0] += $ss->total_months + 0.00;
		$ssTotal[$type][1] += round(($ss->total_months / 12), 2);

		$totalMonths += $ss->total_months + 0.00;
		$totalYears += round(($ss->total_months / 12), 2);
	}

	$rank_category = $data->rank->category;
	$total = 0;

	$getDocument = function($docu, $type, $name1 = null, $name2 = null) use ($data, $checkDate2, $rank) {
		if(in_array($type, ['id', 'lc', 'med_cert'])){
			if ($docu == 'SSBT WITH BRM') {
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

		$name1 = str_replace('&', '&#38;', $name1);

		if($number != '-----'){
			echo "
				<td colspan='4'>$name1</td>
				<td colspan='2'>$issue</td>
				<td>ALL CREW</td>
				<td>$expiry</td>
			";
		}
		else{
			echo "
				<td colspan='4'>$name1</td>
				<td colspan='2'>-----</td>
				<td>ALL CREW</td>
				<td>-----</td>
			";
		}
	};

	$ss = function($ss) use($checkDate2, $data){
		$rank = $data->ranks[$ss->rank];
		$on = $checkDate2($ss->sign_on, 'I');
		$off = $checkDate2($ss->sign_off, 'I');
		$diff = $ss->sign_on->diffInDays($ss->sign_off);

		echo "
			<td>$rank</td>
			<td colspan='2'>$ss->vessel_name</td>
			<td>$ss->vessel_type</td>
			<td>$ss->gross_tonnage</td>
			<td>$ss->bhp_kw</td>
			<td>$on</td>
			<td>$off</td>
			<td>$diff D</td>
			<td colspan='2'>$ss->remarks</td>
		";
	};

	function isBlank(){
		echo "
			<td></td>
			<td colspan='2'></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan='2'></td>
		";
	}

	function isBlank2($name){
		echo "
			<td colspan='4'>$name</td>
			<td colspan='2'>-----</td>
			<td>ALL CREW</td>
			<td>-----</td>
		";
	}
@endphp

<table>
	{{-- 1R --}}
	<tr>
		<td colspan="15">SMI-OPTN-011</td>
	</tr>

	{{-- 2R --}}
	<tr>
		<td colspan="15">CHECKLIST for RECRUITED CREW</td>
	</tr>

	{{-- 3R --}}
	<tr>
		<td colspan="15">Personal Record</td>
	</tr>

	{{-- 4R --}}
	<tr>
		<td rowspan="21">
			P
			{{ PHP_EOL }}
			E
			{{ PHP_EOL }}
			R
			{{ PHP_EOL }}
			S
			{{ PHP_EOL }}
			O
			{{ PHP_EOL }}
			N
			{{ PHP_EOL }}
			A
			{{ PHP_EOL }}
			L 
			{{ PHP_EOL }}
			{{ PHP_EOL }}
			R
			{{ PHP_EOL }}
			E
			{{ PHP_EOL }}
			C
			{{ PHP_EOL }}
			O
			{{ PHP_EOL }}
			R
			{{ PHP_EOL }}
			D
		</td>
		<td colspan="3">Rank</td>
		<td colspan="4">{{ $data->rank->name }}</td>
		<td>VESSEL</td>
		<td colspan="4">{{ $data->vessel->name ?? '-' }}</td>
		<td colspan="2">PICTURE</td>
	</tr>

	{{-- 5R --}}
	<tr>
		<td rowspan="2" colspan="3">Name</td>
		<td rowspan="2" colspan="5">
			{{ $data->user->fname . ' ' . $data->user->mname . ' ' . $data->user->lname }}
		</td>
		<td rowspan="2">AGE</td>
		<td rowspan="2">{{ $data->user->birthday->age }}</td>
		<td>Date of Birth</td>
		<td colspan="3">{{ $data->user->birthday->toFormattedDateString() }}</td>
	</tr>

	{{-- 6R --}}
	<tr>
		<td>Place of Birth</td>
		<td colspan="3">{{ $data->birth_place }}</td>
	</tr>

	{{-- 7R --}}
	<tr>
		<td colspan="3">Address</td>
		<td colspan="7">{{ $data->provincial_address == "" ? $data->user->address : $data->provincial_address }}</td>
		<td>Philippine License</td>
		<td colspan="3">
			@php 
				$name = 'COC';
				$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
			@endphp
			{{ $docu ? $docu->no : "-----" }}
		</td>
	</tr>

	{{-- 8R --}}
	<tr>
		<td colspan="3">School Career</td>
		<td colspan="7">
			@php
				$educ = "";
				foreach ($data->educational_background as $eb) {
					if($eb->course != ""){
						$educ = $eb;
					}
				}

				if($educ != ""){
					$educ = $educ->school . ' / ' . $educ->course . ' / ' . $educ->year;
				}

				echo $educ;
			@endphp
		</td>
		<td>Citizenship</td>
		<td colspan="3">FILIPINO</td>
	</tr>

	{{-- 9R --}}
	<tr>
		<td colspan="3">Drinking Capacity</td>
		<td>N/A</td>
		<td colspan="3">Drug Experience</td>
		<td>N/A</td>
		<td>YES</td>
		<td>or</td>
		<td>NO</td>
		<td colspan="3"></td>
	</tr>

	{{-- 10R --}}
	<tr>
		<td colspan="3">TOTAL</td>
		<td>BULK</td>
		<td>{{ $ssTotal["BULK"][1] }}</td>
		<td>Years</td>
		<td>{{ $ssTotal["BULK"][0] }}</td>
		<td>Months</td>
		<td>G. Cargo</td>
		<td>{{ $ssTotal["GENERAL CARGO"][1] }}</td>
		<td>Years</td>
		<td colspan="2">{{ $ssTotal["GENERAL CARGO"][0] }}</td>
		<td>Months</td>
	</tr>

	{{-- 11R --}}
	<tr>
		<td rowspan="2">Boarding Career</td>
		<td>{{ $totalYears }}</td>
		<td>YEARS</td>
		<td>Tanker</td>
		<td>{{ $ssTotal["TANKER"][1] }}</td>
		<td>Years</td>
		<td>{{ $ssTotal["TANKER"][0] }}</td>
		<td>Months</td>
		<td>Reefer</td>
		<td>{{ $ssTotal["REEFER"][1] }}</td>
		<td>Years</td>
		<td colspan="2">{{ $ssTotal["REEFER"][0] }}</td>
		<td>Months</td>
	</tr>

	{{-- 12R --}}
	<tr>
		<td>{{ $totalMonths }}</td>
		<td>MONTHS</td>
		<td>Container</td>
		<td>{{ $ssTotal["CONTAINER"][1] }}</td>
		<td>Years</td>
		<td>{{ $ssTotal["CONTAINER"][0] }}</td>
		<td>Months</td>
		<td>Others</td>
		<td>{{ $ssTotal["OTHERS"][1] }}</td>
		<td>Years</td>
		<td colspan="2">{{ $ssTotal["OTHERS"][0] }}</td>
		<td>Months</td>
	</tr>

	{{-- 13R --}}
	<tr>
		<td colspan="3">Boarding Career</td>
		<td>Rank</td>
		<td colspan="2">Vessel</td>
		<td>Type</td>
		<td>GRT</td>
		<td>HP</td>
		<td>Signed On</td>
		<td>Signed Off</td>
		<td>Period</td>
		<td colspan="2">Remarks</td>
	</tr>

	{{-- SEA SERVICE --}}
	<tr>
		<td rowspan="11" colspan="3"></td>
		{{ isset($data->sea_service[0]) ? $ss($data->sea_service[0]) : isBlank() }}
	</tr>

	<tr>{{ isset($data->sea_service[1]) ? $ss($data->sea_service[1]) : isBlank() }}</tr>
	<tr>{{ isset($data->sea_service[2]) ? $ss($data->sea_service[2]) : isBlank() }}</tr>
	<tr>{{ isset($data->sea_service[3]) ? $ss($data->sea_service[3]) : isBlank() }}</tr>
	<tr>{{ isset($data->sea_service[4]) ? $ss($data->sea_service[4]) : isBlank() }}</tr>
	<tr>{{ isset($data->sea_service[5]) ? $ss($data->sea_service[5]) : isBlank() }}</tr>
	<tr>{{ isset($data->sea_service[6]) ? $ss($data->sea_service[6]) : isBlank() }}</tr>
	<tr>{{ isset($data->sea_service[7]) ? $ss($data->sea_service[7]) : isBlank() }}</tr>
	<tr>{{ isset($data->sea_service[8]) ? $ss($data->sea_service[8]) : isBlank() }}</tr>
	<tr>{{ isset($data->sea_service[9]) ? $ss($data->sea_service[9]) : isBlank() }}</tr>
	<tr>{{ isset($data->sea_service[10]) ? $ss($data->sea_service[10]) : isBlank() }}</tr>

	{{-- RATINGS --}}
	<tr>
		<td colspan="15">
			Outstanding - 1
			<span></span>
			<span></span>
			/
			<span></span>
			<span></span>
			Very Satisfactory - 2
			<span></span>
			<span></span>
			/
			<span></span>
			<span></span>
			Satisfactory - 3
			<span></span>
			<span></span>
			/
			<span></span>
			<span></span>
			Un-Satisfactory - 4
			<span></span>
			<span></span>
			/
			<span></span>
			<span></span>
			Poor - 5
		</td>
	</tr>

	<tr>
		<td colspan="4">INTERVIEWER</td>
		<td>WORKING KNOWLEDGE</td>
		<td colspan="2">WILLINGNESS</td>
		<td colspan="2">RESPONSIBILITY</td>
		<td>GENERAL CHARACTER</td>
		<td>KNOWLEDGE</td>
		<td>OVERALL ASSESSMENT</td>
		<td colspan="3">SIGNATURE</td>
	</tr>

	{{-- 1st RATING --}}
	<tr>
		<td colspan="4">MS. JEANNETTE T. SOLIDUM</td>
		<td rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td colspan="3" rowspan="2"></td>
	</tr>

	<tr>
		<td colspan="4">Crewing Manager</td>
	</tr>

	{{-- 2nd RATING --}}
	<tr>
		<td colspan="4">CAPT. HERNAN D. CASTILLO</td>
		<td rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td colspan="3" rowspan="2"></td>
	</tr>

	<tr>
		<td colspan="4">Port Captain / Recruitment Manager</td>
	</tr>

	{{-- 3rd RATING --}}
	<tr>
		<td colspan="4">MR. JAE SIN SIM</td>
		<td rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td colspan="3" rowspan="2"></td>
	</tr>

	<tr>
		<td colspan="4">C.E.O</td>
	</tr>

	<tr>
		<td colspan="15">FIT FOT DUTY ( )</td>
	</tr>

	<tr>
		<td colspan="15">UNFIT FOT DUTY ( )</td>
	</tr>

	<tr>
		<td colspan="3">HEIGHT:</td>
		<td colspan="2">{{ $data->height }} cm</td>
		<td colspan="2">WEIGHT</td>
		<td colspan="2">{{ $data->weight }} kg</td>
		<td>SHOE SIZE</td>
		<td>{{ $data->shoe_size }}</td>
		<td>COVERALL</td>
		<td colspan="3">{{ $data->clothes_size }}</td>
	</tr>

	@php 
		$name = "SEAMAN'S BOOK";
		$docu = isset($data->document_id->{$name}) ? $data->document_id->{$name} : false;
	@endphp
	<tr>
		<td colspan="4">SEAMAN'S BOOK NO.</td>
		<td colspan="3">{{ $docu ? $docu->number : "-----"}}</td>
		<td colspan="2">ISSUED ON:</td>
		<td colspan="2">{{ $docu ? $checkDate2($docu->issue_date, "I") : "-----" }}</td>
		<td>VALIDITY:</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->expiry_date, "E") : "-----" }}</td>
	</tr>

	@php 
		$name = "PASSPORT";
		$docu = isset($data->document_id->{$name}) ? $data->document_id->{$name} : false;
	@endphp
	<tr>
		<td colspan="4">PASSPORT NO.</td>
		<td colspan="3">{{ $docu ? $docu->number : "-----"}}</td>
		<td colspan="2">ISSUED ON:</td>
		<td colspan="2">{{ $docu ? $checkDate2($docu->issue_date, "I") : "-----" }}</td>
		<td>VALIDITY:</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->expiry_date, "E") : "-----" }}</td>
	</tr>

	<tr>
		<td colspan="4" rowspan="8">
			COMPULSORY EDUCATION AND THEIR CERTIFICATES
		</td>
		<td colspan="4">Kind</td>
		<td colspan="2">Date of Education</td>
		<td>ALL CREW</td>
		<td>Date of Expiration</td>
		<td colspan="3">Result of Physical Examination</td>
	</tr>

	<tr>
		@php
			$name = "STCW '95 Endorsement(COP)II/4";
		@endphp
		{{ $getDocument('COC', 'lc', $name) }}
		<td colspan="3" rowspan="7">FOR MEDICAL</td>
	</tr>

	<tr>
		@php
			$name = "STCW '95 Endorsement(COP)II/5";
		@endphp
		{{ $getDocument('COE', 'lc', $name) }}
	</tr>

	<tr>
		{{ $getDocument('BASIC TRAINING - BT', 'lc', 'Basic Training(BT)') }}
	</tr>

	<tr>
		{{ $getDocument('PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB', 'lc', 'Prof. Survival Craft & Rec. Boat (PSCRB)') }}
	</tr>

	<tr>
		@php 
			$name = 'WATCHKEEPING';
			$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;

			if(!$docu){
				$name = 'ENGINE WATCH';
				$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
			}

			if(!$docu){
				$name = 'ENGINE WATCH';
				$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
			}
		@endphp
		{{ $getDocument($name, 'lc', 'Watchkeeping Cert.') }}
	</tr>

	<tr>
		{{ $getDocument('LICENSE', 'flag', 'License(Flag Requirement)') }}
	</tr>

	<tr>
		@php
			$name = 'SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD';
		@endphp
		{{ $getDocument($name, 'lc', "SAT and Seafarer's Designated Security Duties") }}
	</tr>
</table>