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

	$rank_category = $data->rank ? $data->rank->category : null;
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
@endphp

<table>
	<tr>
		<td>Name</td>
		<td colspan="4">
			{{ $data->user->fname . ' ' . $data->user->mname . ' ' . $data->user->lname }}
		</td>
		<td colspan="3"></td>
		<td>Rank</td>
		<td colspan="2">{{ $data->rank ? $data->rank->abbr : "" }}</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="5">PHYSICAL EXAMINATION</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="2">Hospital</td>
		<td>Date</td>
		<td>Height</td>
		<td>Weight</td>
		<td>Vision (L)</td>
		<td>Vision (R)</td>
		<td>Blood Pressure</td>
		<td>X-ray</td>
		<td>AIDS</td>
		<td>Remarks</td>
	</tr>

	@php 
		$name = 'MEDICAL CERTIFICATE';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;
	@endphp

	<tr>
		<td colspan="2">MMC Medical Clinic</td>
		<td>{{ $docu ? $checkDate2($docu->issue_date, "I") : "-----" }}</td>
		<td>{{ $data->height }}cm</td>
		<td>{{ $data->weight }}kg</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	@php 
		$name = 'CHEMICAL TEST';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;
	@endphp

	<tr>
		<td colspan="2">CHEM Test</td>
		<td>{{ $docu ? $checkDate2($docu->issue_date, "I") : "-----" }}</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	@php 
		$name = 'DRUG AND ALCOHOL TEST';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;
	@endphp

	<tr>
		<td colspan="2">Drug and Alcohol Test</td>
		<td>{{ $docu ? $checkDate2($docu->issue_date, "I") : "-----" }}</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	{{-- LEAVE BLANK --}}
	<tr>
		<td colspan="2"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="5">VACCINATION</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="2">Vaccination</td>
		<td>Date</td>
		<td colspan="2">Expiry Date</td>
		<td colspan="3">Place</td>
		<td colspan="3">Remarks</td>
	</tr>

	@php 
		$name = 'YELLOW FEVER';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;
	@endphp

	<tr>
		<td colspan="2">Yellow Fever</td>
		<td>{{ $docu ? $checkDate2($docu->issue_date, "I") : "-----" }}</td>
		<td colspan="2">{{ $docu ? $checkDate2($docu->expiry_date, "E") : "-----" }}</td>
		<td colspan="3">{{ $docu ? $docu->clinic : "-----" }}</td>
		<td colspan="3"></td>
	</tr>

	@php 
		$name = 'CHOLERA';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;
	@endphp

	<tr>
		<td colspan="2">Cholera</td>
		<td>{{ $docu ? $checkDate2($docu->issue_date, "I") : "-----" }}</td>
		<td colspan="2">{{ $docu ? $checkDate2($docu->expiry_date, "E") : "-----" }}</td>
		<td colspan="3">{{ $docu ? $docu->clinic : "-----" }}</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td></td>
		<td colspan="2"></td>
		<td colspan="3"></td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td></td>
		<td colspan="2"></td>
		<td colspan="3"></td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="5">SPECIAL REMARKS</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td>Date</td>
		<td colspan="10">Contents</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10"></td>
	</tr>
</table>