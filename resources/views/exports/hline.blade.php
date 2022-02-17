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

	$rank_category = $data->rank->category;
	$total = 0;

	$getDocument = function($docu, $type, $name1 = null, $name2 = null, $ctr = 0) use ($data, $checkDate2, $rank) {

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

		if($number != '-----'){
			if($ctr == 0){ //NUM_ISSUE - EXPIRY_ISSUER
				echo "
					<tr>
						<td>$name1</td>
						<td colspan='4'>$number / $issue</td>
						<td>$name2</td>
						<td colspan='2'>$expiry / $docu->issuer</td>
					</tr>
				";
			}
			elseif($ctr == 1){ //NUM - GRADE/CATEGORY
				$grade = $data->rank->category;
				echo "
					<tr>
						<td>$name1</td>
						<td colspan='4'>$number</td>
						<td>$name2</td>
						<td colspan='2'>$grade</td>
					</tr>
				";
			}
			elseif($ctr == 2){ //NUM - EXPIRY
				echo "
					<tr>
						<td>$name1</td>
						<td colspan='4'>$number</td>
						<td>$name2</td>
						<td colspan='2'>$expiry</td>
					</tr>
				";
			}
			elseif($ctr == 3){ // NUM - EXPIRY_ISSUER
				echo "
					<tr>
						<td>$name1</td>
						<td colspan='4'>$number</td>
						<td>$name2</td>
						<td colspan='2'>$expiry / $docu->issuer</td>
					</tr>
				";
			}
			elseif($ctr == 4){ // NUM_ISSUE - EXPIRY
				echo "
					<tr>
						<td>$name1</td>
						<td colspan='4'>$number / $issue</td>
						<td>$name2</td>
						<td colspan='2'>$expiry</td>
					</tr>
				";
			}
			elseif($ctr == 5){ // ISSUER - ISSUE
				echo "
					<tr>
						<td>$name1</td>
						<td colspan='4'>$docu->issuer</td>
						<td>$name2</td>
						<td colspan='2'>$issue</td>
					</tr>
				";
			}
		}
		else{
			echo "
				<tr>
					<td>$name1</td>
					<td colspan='4'></td>
					<td>$name2</td>
					<td colspan='2'></td>
				</tr>
			";
		}
	};

	$ss = function($ss) use($checkDate2, $data){
		$rank = $data->ranks[$ss->rank];
		$diff = $ss->sign_on->diffInDays($ss->sign_off);
		$on = $checkDate2($ss->sign_on, 'i');
		$off = $checkDate2($ss->sign_off, 'i');
		$eng = str_replace('&', '&#38;', $ss->engine_type);

		echo "
			<tr>
				<td>$ss->vessel_name</td>
				<td>$ss->manning_agent</td>
				<td rowspan='2'>$rank</td>
				<td rowspan='2'>$ss->vessel_type</td>
				<td rowspan='2'>$ss->gross_tonnage</td>
				<td>$eng</td>
				<td rowspan='2'>$diff D</td>
				<td>$on</td>
				<td rowspan='2'>$ss->remarks</td>
			</tr>

			<tr>
				<td>$ss->flag</td>
				<td>$ss->crew_nationality</td>
				<td>$ss->bhp_kw</td>
				<td>$off</td>
			</tr>
		";
	};
@endphp

<table>
	<tr>
		<td colspan="9" style="text-decoration: underline;">CREW PERSONAL DATA</td>
	</tr>

	<tr>
		<td colspan="9">SOLPIA MARINE &#38; SHIP MANAGEMENT, INC.</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td>Name of Vessel</td>
		<td colspan="4">{{ $data->vessel->name ?? '-' }}</td>
		<td>Rank</td>
		<td colspan="2">{{ $data->rank->abbr }}</td>
		<td rowspan="7">PHOTO</td>
	</tr>

	<tr>
		<td>Full Name</td>
		<td colspan="4">
			{{ $data->user->fname . ' ' . $data->user->mname . ' ' . $data->user->lname }}}
		</td>
		<td>Status</td>
		<td colspan="2">{{ $data->status }}</td>
	</tr>

	<tr>
		<td>Place of Birth</td>
		<td colspan="4">{{ $data->birth_place }}</td>
		<td>Date</td>
		<td colspan="2">{{ $checkDate2($data->user->birthday, 'a') }}</td>
	</tr>

	<tr>
		<td>Family Organization</td>
		@php
			$parent = "";
			$ctr = 0;
			foreach($data->family_data as $fd){
				if($fd->type == "Son"){
					$ctr++;
				}
				if($fd->type == "Father" || $fd->type == "Mother"){
					$ctr = $parent == "" ? 0 : 1;
					$parent .= $fd->fname . ' ';

					if(!$ctr){
						$parent .= "& ";
					}
				}

			}
			$parent .= $data->user->lname;
		@endphp
		<td>Son</td>
		<td>{{ $ctr }}</td>

		@php
			$ctr = 0;
			foreach($data->family_data as $fd){
				if($fd->type == "Daughter"){
					$ctr++;
				}
			}
		@endphp
		<td>Daughter</td>
		<td>{{ $ctr }}</td>

		<td>Parent</td>
		<td colspan="2">{{ $parent }}</td>
	</tr>

	<tr>
		<td>Eye Sight</td>
		<td>Left</td>
		<td></td>
		<td>Right</td>
		<td></td>
		<td>Blood</td>
		<td colspan="2">{{ $data->blood_type }}</td>
	</tr>

	<tr>
		<td>Height</td>
		<td colspan="4">{{ $data->height }}cm</td>
		<td>Weight</td>
		<td colspan="2">{{ $data->weight }}kg</td>
	</tr>

	<tr>
		<td>Waist Size</td>
		<td colspan="4">{{ $data->waistline }}</td>
		<td>Shoes</td>
		<td colspan="2">{{ $data->shoe_size }}</td>
	</tr>

	<tr>
		<td>Home Address</td>
		<td colspan="8">{{ $data->user->address }}</td>
	</tr>

	<tr>
		<td colspan="9">EDUCATION &#38; DOCUMENT DATA</td>
	</tr>

	{{ $getDocument('PASSPORT', 'id', "P/P No./ Date of Issue", 'Expire / Plc Of Issued')}}
	{{ $getDocument("SEAMAN'S BOOK",'id', 'S/B No./ Date of Issue', 'Expire / Plc Of Issued')}}
	{{ $getDocument('COC', 'lc', 'Marine License', 'Grade', 1) }}
	{{ $getDocument('COE', 'lc', 'Marine License Endorsment', 'Expire', 2) }}
	{{-- {{ $getDocument('KML', 'lc', 'Korean License', 'Expire ', 2) }} --}}
	{{ $getDocument('GMDSS/GOC', 'flag', 'GMDSS', 'Expire / Plc Of Issued', 3) }}
	{{ $getDocument('LICENSE', 'flag', 'F.License No./ Date of Issue', 'Expire', 4) }}
	{{ $getDocument('GMDSS/GOC BOOKLET', 'flag', 'GMDSS Lic No./ Date of Issue', 'Expire', 4) }}
	{{ $getDocument('SDSD', 'flag', 'Panama SDSD No. / Date of Issue', 'Expire', 4) }}
	{{ $getDocument('SSBT WITH BRM', 'lc', 'Bridge Resource Management', 'Expire / Plc Of Issued', 3) }}
	{{ $getDocument('SHIP SECURITY OFFICER - SSO', 'lc', 'SSO', 'Expire / Plc Of Issued', 3) }}
	{{ $getDocument('SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD', 'lc', 'SDSD', 'Expire / Plc Of Issued', 3) }}
	{{ $getDocument('BASIC TRAINING - BT', 'lc', 'BST No. / Date of Issue', 'Expire / Plc Of Issued') }}
	{{ $getDocument('WATCHKEEPING', 'lc', 'Watch K. No. / Date of Issue', 'Expire / Plc Of Issued') }}
	{{ $getDocument('ARPA TRAINING COURSE', 'lc', 'ARPA Simulator', 'Expire / Plc Of Issued', 3) }}
	{{ $getDocument('RADAR', 'lc', 'Radar Simulator', 'Expire / Plc Of Issued', 3) }}
	{{-- {{ $getDocument('SCRC', 'lc', 'Radar Simulator', 'Expire / Plc Of Issued', 3) }}
	{{ $getDocument('AFRC', 'lc', 'Radar Simulator', 'Expire / Plc Of Issued', 3) }} --}}
	{{ $getDocument('MEDICAL FIRST AID - MEFA', 'lc', 'Medical First Aid', 'Expire / Plc Of Issued', 3) }}
	{{ $getDocument('MEDICAL CARE - MECA', 'lc', 'Medical Care on Board', 'Expire / Plc Of Issued', 3) }}
	{{ $getDocument('BASIC TRAINING FOR OIL AND CHEMICAL TANKER - BTOCT', 'lc', 'Tanker Familiarization', 'Expire / Plc Of Issued', 3) }}
	{{ $getDocument('KML', 'lc', 'KML Training', 'Expire / Plc Of Issued', 3) }}
	{{ $getDocument('WELDING COURSE', 'lc', 'Welding No. / Date of Issue', 'Expire / Plc Of Issued') }}
	{{ $getDocument('YELLOW FEVER', 'med_cert', 'Yellow Fever No. / Date of Issue', 'Expire / Plc Of Issued') }}

	@php 
		$name = 'MEDICAL CERTIFICATE';
		$docu = isset($applicant->document_med_cert->{$name}) ? $applicant->document_med_cert->{$name} : false;
	@endphp

	<tr>
		<td>Plc of medical Check Up</td>
		<td colspan='4'>{{ $docu ? $docu->no : "-----"}}</td>
		<td>Date</td>
		<td colspan='2'>{{ $docu ? $checkDate2($docu->issue_date, "I") : "-----" }}</td>
	</tr>

	{{ $getDocument('US-VISA', 'id', 'US C1/D Visa No. / Date of Issue', 'Expire', 4) }}

	@php
		$temp = null;
		foreach($data->educational_background as $eb){
			if($eb->type == "Vocational"){
				$temp = $eb;
			}
			if($eb->type == "College"){
				$temp = $eb;
			}
		}
	@endphp

	<tr>
		<td>Education &#38; Place</td>
		<td colspan='4'>{{ $temp ? $eb->type . ' / ' . $eb->school : '---' }}</td>
		<td>Religion</td>
		<td colspan='2'>{{ $data->religion }}</td>
	</tr>

	<tr>
		<td colspan="9">RECORD OF SEA SERVICE</td>
	</tr>

	<tr>
		<td>Name of Vessel</td>
		<td>Agent</td>
		<td rowspan="2">Rank</td>
		<td rowspan="2">Kind of Vessel</td>
		<td rowspan="2">Gross Tonage</td>
		<td rowspan="2">T/Engine <br> HP</td>
		<td rowspan="2">Period</td>
		<td>Sign On</td>
		<td rowspan="2">Remark</td>
	</tr>

	<tr>
		<td>Flag of Vessel</td>
		<td>Combined Crew</td>
		<td>Sign Off</td>
	</tr>

	{{ isset($data->sea_service[0]) ? $ss($data->sea_service[0]) : isBlank() }}
	{{ isset($data->sea_service[1]) ? $ss($data->sea_service[1]) : isBlank() }}
	{{ isset($data->sea_service[2]) ? $ss($data->sea_service[2]) : isBlank() }}
	{{ isset($data->sea_service[3]) ? $ss($data->sea_service[3]) : isBlank() }}
	{{ isset($data->sea_service[4]) ? $ss($data->sea_service[4]) : isBlank() }}
	{{ isset($data->sea_service[5]) ? $ss($data->sea_service[5]) : isBlank() }}
	{{ isset($data->sea_service[6]) ? $ss($data->sea_service[6]) : isBlank() }}
	{{ isset($data->sea_service[7]) ? $ss($data->sea_service[7]) : isBlank() }}
	{{ isset($data->sea_service[8]) ? $ss($data->sea_service[8]) : isBlank() }}
	{{ isset($data->sea_service[9]) ? $ss($data->sea_service[9]) : isBlank() }}
	{{ isset($data->sea_service[10]) ? $ss($data->sea_service[10]) : isBlank() }}

	<tr>
		<td colspan="9" style="text-decoration: underline;">SATISFACTION POINTS</td>
	</tr>

	<tr>
		<td>INTERVIEWER</td>
		<td>WORKING KNOWLEDGE</td>
		<td>WILLINGESS TO WORK</td>
		<td>RESPONSIBILITY</td>
		<td>GENERAL CHARACTER</td>
		<td>KNOWLEDGE IN ENGLISH</td>
		<td>OVERALL ASSESSMENT</td>
		<td colspan="2">SIGNATURE</td>
	</tr>

	<tr>
		<td colspan="9">
			Outstanding - 1              /              Very Satisfactory - 2              /           Satisfactory - 3             /           Un-Satisfactory - 4                  /                Poor - 5
		</td>
	</tr>

	<tr>
		<td>MS. JEANETTE T SOLIDUM</td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2" colspan="2"></td>
	</tr>

	<tr>
		<td>Crewing Manager</td>
	</tr>

	<tr>
		<td>CAPT. HERNAN D. CASTILLO</td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2" colspan="2"></td>
	</tr>

	<tr>
		<td>Port Captain / Recruitment Manager</td>
	</tr>

	<tr>
		<td>MR. JAE SIN SIM</td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2" colspan="2"></td>
	</tr>

	<tr>
		<td>C.E.O</td>
	</tr>
</table>