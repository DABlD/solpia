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
			return $date->format('F j, Y');
		}
	};

	// CHECK IF WATCHKEEPING AND HAS RANK AND IS DECK OR ENGINE RATING
	if(isset($applicant->rank_id)){
		$rank = $applicant->rank_id;
	}
	else{
		if(isset($applicant->rank)){
			$rank = $applicant->rank->id;
		}
		else{
			$rank = 0;
		}
	}

	$getDocument = function($docu, $type, $issuer = null, $name = null, $regulation = null) use ($applicant, $checkDate2, $rank) {
		$name   = !$name ? $docu : $name;

		if(in_array($type, ['id', 'lc', 'med_cert'])){

			if($type == "lc" && ($docu == "COC" || $docu == "COE") && $name == "NATIONAL LICENSE - RATINGS"){
				if($rank > 0 && $regulation){
					$tempDocu = $docu;
					$docu = false;
					$temp = "";

					if($rank >= 9 && $rank <= 23){
						foreach($applicant->document_lc as $document){
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
					$docu = isset($applicant->{"document_$type"}->$ecdis) ? $applicant->{"document_$type"}->$ecdis : false;

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
				$docu = isset($applicant->{"document_$type"}->$docu) ? $applicant->{"document_$type"}->$docu : false;

				if(!$docu){
					$name = 'SSBT';
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;

					if(!$docu){
						$name = 'BRM';
						$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
					}

					if(!$docu){
						$name = 'BTM';
						$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
					}
				}
			}
			else{
				$temp = $docu;
				$docu = isset($applicant->{"document_$type"}->$docu) ? $applicant->{"document_$type"}->$docu : false;

				if(!$docu && $temp == "RADAR"){
					$name = 'RADAR TRAINING COURSE';
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;

					if(!$docu){
						$name = 'RADAR SIMULATOR COURSE';
						$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
					}

					if(!$docu){
						$name = 'RADAR OPERATOR PLOTTING AID';
						$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
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

			foreach($applicant->document_flag as $document){
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

		if($name == "69"){
			$noNum  = $type == 'lc' ? 'no' : 'number';

			$number = $docu ? $docu->$noNum : '-----';
			$issue  = $docu ? $checkDate2($docu->issue_date, 'I') : '-----';
			$expiry = $docu ? $checkDate2($docu->expiry_date, 'E') : '-----';

			if($temp == "ADVANCE FIRE FIGHTING - AFF"){
				echo "
					<tr>
						<td colspan='2' rowspan='3'>
							Advanced Safety Course<span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
							- Fire Fighting<span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
							- Survival Craft And Rescue Boat<span></span><span></span>
							- First Aid
						</td>

						<td colspan='1'>$number</td>
						<td colspan='2'>$issue</td>
						<td colspan='3'>$expiry</td>
						<td colspan='1'></td>
					</tr>
				";
			}
			else{
				echo "
					<tr>
						<td colspan='1'>$number</td>
						<td colspan='2'>$issue</td>
						<td colspan='3'>$expiry</td>
						<td colspan='1'></td>
					</tr>
				";
			}
		}
		else{
			echo "
				<tr>
					<td colspan='2'>
						<span></span><span></span>$name
					</td>

					<td colspan='1'>$number</td>
					<td colspan='2'>$issue</td>
					<td colspan='3'>$expiry</td>
					<td colspan='1'></td>
				</tr>
			";
		}
	};
@endphp

<table>
	<tr>
		<td>asdasdasd</td>
	</tr>

	<tr>
		<td rowspan="2" colspan="5"></td>
		<td rowspan="2" colspan="4">
			FORM SP SOMETHING
		</td>
	</tr>

	<tr></tr>
	<tr></tr>

	<tr>
		<td colspan="9">
			Document Check List for Foreigner
		</td>
	</tr>

	<tr>
		<td colspan="9">
			*In case of no available document, please specify the status in a remark
		</td>
	</tr>

	<tr>
		<td>Name of Vessel</td>
		<td colspan="2">
			{{ isset($applicant->vessel) ? $applicant->vessel->name : '-----' }}
		</td>

		<td>Rank</td>
		<td colspan="2">
			{{ isset($applicant->rank) ? $applicant->rank->abbr : '-----' }}
		</td>

		<td>Name</td>
		<td colspan="2">
			{{ $applicant->user->lname . ', ' . $applicant->user->fname . ' ' . $applicant->user->suffix . ' ' . $applicant->user->mname[0] }}
		</td>
	</tr>

	<tr>
		<td colspan="2">Documents</td>
		<td>No.</td>
		<td colspan="2">Issue</td>
		<td colspan="3">Exp</td>
		<td>Remark</td>
	</tr>

	{{ $getDocument('PASSPORT', 	'id', 		'DFA',			'Passport'								)}}
	{{ $getDocument("SEAMAN'S BOOK",'id', 		'MARINA', 		"Seaman's Book"							)}}
	{{ $getDocument('COC', 			'lc', 		'MARINA', 		'C.O.C.'								)}}
	{{ $getDocument('GMDSS/GOC', 	'lc', 		'MARINA', 		'G.O.C.'								)}}
	{{ $getDocument('COC', 			'lc',		'MARINA', 		'Watch-keeping Certificate', 		true)}}
	{{ $getDocument('BOOKLET', 		'flag', 	'PANAMA', 		"Flagged Seaman's Book"					)}}
	{{ $getDocument('LICENSE', 		'flag', 	'PANAMA', 		'Flagged License'						)}}
	{{ $getDocument('BASIC TRAINING - BT', 'lc', 'MARINA', 		'Basic Safety Course'					)}}

	{{ $getDocument('ADVANCE FIRE FIGHTING - AFF', 'lc', 'MARINA', '69')}}
	{{ $getDocument('PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB', 'lc', 'MARINA', '69')}}
	{{ $getDocument('MEDICAL FIRST AID - MEFA', 'lc', 'MARINA', '69')}}

	{{ $getDocument('ARPA TRAINING COURSE', 'lc', '', 'ARPA')}}
	{{ $getDocument('RADAR', 'lc', '', 'Radar Simulation')}}
	{{ $getDocument('SSBT WITH BRM', 'lc', '', 'BRTM')}}

	{{ $getDocument('ERS WITH ERM', 'lc', '', 'ERM')}}
	{{ $getDocument('ECDIS', 'lc', '', 'ECDIS (Generic)')}}
	{{ $getDocument('ECDIS SPECIFIC', 'lc', '', 'ECDIS (Specific)')}}

	{{ $getDocument("US-VISA", 		'id', 		'US EMBASSY', 	'US Visa'								)}}
	{{ $getDocument('MEDICAL CERTIFICATE', 'med_cert', '', 'Medical Examination Certificate'			)}}
	{{ $getDocument('YELLOW FEVER', 'med_cert', '', 'Yellow Fever'										)}}

	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>a</td>
		<td colspan="3">Qualified</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="3">Unqualified</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>a</td>
		<td colspan="3">Qualified</td>
	</tr>
	<tr>
		<td colspan="2">Confirmed by: </td>
		<td colspan="3"><span></span><span></span><span></span>THEA GUERRA<span>
		<td></td>
		<td colspan="3">Unqualified</td>
	</tr>
</table>