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

	$getDocument = function($docu, $type, $issuer = null, $name = null, $regulation = null, $country = 'Philippines') use ($data, $checkDate2, $rank) {
		$name   = !$name ? $docu : $name;

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

		$issuer = str_replace('&', '&#38;', $issuer);

		$noNum  = $type == 'lc' ? 'no' : 'number';

		$number = $docu ? $docu->$noNum : '-----';
		$issue  = $docu ? $checkDate2($docu->issue_date, 'I') : '-----';
		$expiry = $docu ? $checkDate2($docu->expiry_date, 'E') : 'UNLIMITED';

		if($number != '-----'){
			echo "
				<tr>
					<td>$country</td>
					<td>$name</td>
					<td>$number</td>
					<td>$issue</td>
					<td>$expiry</td>
					<td>$issuer</td>
					<td></td>
				</tr>
			";
		}
		else{
			echo "
				<tr>
					<td>$country</td>
					<td>$name</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			";
		}
	};

	$header = function($i){
		if($i){
			echo "
				<tr>
					<td rowspan='2'>Nation</td>
					<td rowspan='2'>Classification</td>
					<td rowspan='2'>Number</td>
					<td colspan='2'>Date</td>
					<td rowspan='2'>Place / Organization</td>
					<td rowspan='2'>Remarks</td>
				</tr>

				<tr>
					<td>ISSUE</td>
					<td>VALID</td>
				</tr>
			";
		}
		else{
			echo "
				<tr>
					<td>Nation</td>
					<td>Classification</td>
					<td>Number</td>
					<td>Issued Date</td>
					<td>Expiry Date</td>
					<td>Issuing Office</td>
					<td>Remarks</td>
				</tr>
			";
		}
	};

	$break = function($text){
		echo "
			<tr>
				<td colspan='7'></td>
			</tr>

			<tr>
				<td colspan='3'>$text</td>
				<td colspan='4'></td>
			</tr>
		";
	};

	function isBlank($name, $country = "Philippines"){
		echo "
			<tr>
				<td>$country</td>
				<td>$name</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		";
	}
@endphp

<table>
	<tr>
		<td>Name</td>
		<td colspan="2">
			{{ $data->user->fname . ' ' . $data->user->mname . ' ' . $data->user->lname }}
		</td>
		<td colspan="2"></td>
		<td>Rank</td>
		<td>{{ $data->rank->abbr }}</td>
	</tr>

	<tr>
		<td colspan="7"></td>
	</tr>

	<tr>
		<td colspan="3">I.D BOOK / QUALIFICATION</td>
		<td colspan="4"></td>
	</tr>

	{{ $header(0) }}

	{{ $getDocument('PASSPORT', 'id', null, 'Passport')}}
	{{ $getDocument("SEAMAN'S BOOK",'id', null, 'Seaman Book')}}
	{{ $getDocument("US-VISA", 'id', null, 'US Visa', null, "U.S.A")}}

	{{-- LEAVE BLANK --}}
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	{{ $break('COMPETENCY / CERTIFICATE') }}

	{{ $header(0) }}

	{{ $rank >= 1 && $rank <= 8 ? $getDocument('COC', 'lc') : isBlank('COC')}}	
	{{ $rank >= 1 && $rank <= 8 ? $getDocument('COE', 'lc') : isBlank('COE')}}	
	{{ $rank >= 1 && $rank <= 4 ? $getDocument('GMDSS/GOC', 'lc') : isBlank('GOC')}}
	{{ $rank >= 9 && $rank <= 14 ? $getDocument('COC', 'lc', null, "COP II-4", true) : isBlank('COP II-4')}}	
	{{ $rank >= 9 && $rank <= 14 ? $getDocument('COE', 'lc', null, "COP II-5", true) : isBlank('COP II-5')}}
	{{ $rank >= 15 && $rank <= 23 ? $getDocument('COC', 'lc', null, "COP III-4", true) : isBlank('COP III-4')}}
	{{ $rank >= 15 && $rank <= 23 ? $getDocument('COE', 'lc', null, "COP III-5", true) : isBlank('COP III-5')}}	

	<tr>
		<td colspan="7"></td>
	</tr>
	
	<tr>
		<td colspan="3">TRAINING &#38; EDUCATION</td>
		<td colspan="4"></td>
	</tr>

	{{ $header(1) }}

	@php
		$a = "BASIC TRAINING - BT";
		$b = "BT - Basic Training";
		$getDocument($a, 'lc', null, $b);

		$a = "PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB";
		$b = "PCSRB - Proficiency in Survival Craft &#38; Rescue Boat";
		$getDocument($a, 'lc', null, $b);
	
		$a = "BASIC TRAINING FOR OIL AND CHEMICAL TANKER - BTOCT";
		$b = "BTOCT - Basic Training for Oil and Chemical Tanker ";
		$getDocument($a, 'lc', null, $b);

		$a = "SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD";
		$b = "SSA SDSD - Ship Security Awareness Training &#38; Seafarers w/ Designated Security Duties";
		$getDocument($a, 'lc', null, $b);

		$a = "HAZMAT";
		$b = "HAZMAT - Hazardous Materials";
		$getDocument($a, 'lc', null, $b);

		$a = "ADVANCE TRAINING FOR OIL TANKER - ATOT";
		$b = "ATOT - Advance Training for Oil Tanker";
		$getDocument($a, 'lc', null, $b);

		$a = "ADVANCE TRAINING FOR CHEMICAL TANKER - ATCT";
		$b = "ATCT - Advance Training for Chemical Tanker";
		$getDocument($a, 'lc', null, $b);

		$a = "BASIC TRAINING FOR LIQUIFIED GAS TANKER CARGO OPERATIONS - BTLGT";
		$b = "BTLGT - Basic Training for Liquified Gas Tanker Cargo Operations";
		$getDocument($a, 'lc', null, $b);

		$a = "ADVANCED TRAINING FOR LIQUIFIED GAS TANKER CARGO OPERATIONS - ATLGT";
		$b = "ATLGT - Advance Training for Liquified Gas Tanker Cargo Operations";
		$getDocument($a, 'lc', null, $b);

		$a = "HIGH VOLTAGE TRAINING";
		$b = "High Voltage Training";
		$getDocument($a, 'lc', null, $b);

		$a = "ADVANCE FIRE FIGHTING - AFF";
		$b = "AFF - Advance Fire Fighting";
		$getDocument($a, 'lc', null, $b);

		$a = "MEDICAL CARE - MECA";
		$b = "MECA - Medical Care";
		$getDocument($a, 'lc', null, $b);

		$a = "MEDICAL FIRST AID - MEFA";
		$b = "MEFA - Medical First Aid";
		$getDocument($a, 'lc', null, $b);

		$a = "GMDSS/GOC";
		$b = "GMDSS";
		$getDocument($a, 'lc', null, $b);

		$a = "ECDIS";
		$b = "ECDIS - Generic";
		$getDocument($a, 'lc', null, $b);

		$a = "ECDIS PM3D";
		$b = "ECDIS - Marine Electronics PM3D";
		$getDocument($a, 'lc', null, $b);

		$a = "ECDIS JRC 901B";
		$b = "ECDIS - JRC-901B";
		$getDocument($a, 'lc', null, $b);

		$a = "SSBT WITH BRM";
		$b = "SSBT - BRM/BTM";
		$getDocument($a, 'lc', null, $b);

		$a = "ERS WITH ERM";
		$b = "ERS - ERM";
		$getDocument($a, 'lc', null, $b);

		$a = "ARPA TRAINING COURSE";
		$b = "ARPA - Automatic Radar Plotting";
		$getDocument($a, 'lc', null, $b);

		$a = "RADAR";
		$b = "RSC - Radar Simulator Course";
		$getDocument($a, 'lc', null, $b);

		$a = "KML";
		$b = "KML";
		$getDocument($a, 'lc', null, $b, null, 'Korea');

		$a = "ENGLISH TEST";
		$b = "ENGLISH TEST";
		$getDocument($a, 'lc', null, $b);

		$a = "WELDING COURSE";
		$b = "Welding";
		$getDocument($a, 'lc', null, $b);

		$a = "MCV";
		$b = "MCV";
		$getDocument($a, 'lc', null, $b, null, 'Australia');
	@endphp
</table>