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

					// $issuer = $issuer != null ? $issuer : $docu ? $docu->issuer : 'NOT APPLICABLE';
					if($issuer != ""){
						$issuer = $issuer;
					}
					else{
						$issuer = $docu ? $docu->issuer : 'NOT APPLICABLE';
					}

					if($docu){
						$string .= "
							<tr>
								<td colspan='5'>
									- $ecdis
								</td>

								<td colspan='2'>$number</td>
								<td colspan='2'>$issue</td>
								<td colspan='2'>$expiry</td>
								<td colspan='3'>$issuer</td>
							</tr>
						";
					}

				}

				if($string != ""){
					echo $string;
					return;
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

		echo "
			<tr>
				<td colspan='5'>
					- $name
				</td>

				<td colspan='2'>$number</td>
				<td colspan='2'>$issue</td>
				<td colspan='2'>$expiry</td>
				<td colspan='3'>$issuer</td>
			</tr>
		";
	};

	function addS($name){
		echo "
			<tr>
				<td colspan='5'>$name:</td>
				<td colspan='2'></td>
				<td colspan='2'></td>
				<td colspan='2'></td>
				<td colspan='3'></td>
			</tr>
		";
	}
@endphp

<table>
	<tbody>
		<!-- HEADER -->
		<tr>
			<td colspan="14">
				DOCUMENT CHECK LIST
			</td>
		</tr>
		<tr>
			<td colspan="14"></td>
		</tr>

		<!-- MAIN -->

		<!-- 1st Row -->
		<tr>
			<td colspan="2">
				VESSEL NAME
			</td>
			<td colspan="3">
				{{ isset($applicant->vessel) ? $applicant->vessel->name : 'TBA' }}
			</td>

			{{-- GET FLAG --}}
			@php
				$flag = "-----";
				if(sizeof($applicant->document_flag)){
					$flag = $applicant->document_flag->first()->country;
				}
			@endphp

			<td colspan="2">
				FLAG
			</td>
			<td colspan="2">
				{{ $flag }}
			</td>

			<td colspan="2">
				TYPE
			</td>
			<td colspan="3">
				{{ isset($applicant->vessel) ? $applicant->vessel->type : 'TBA' }}
			</td>
		</tr>

		<!-- 2nd Row -->
		<tr>
			<td colspan="2">
				SEAMAN'S NAME
			</td>
			<td colspan="3">
				{{ $applicant->user->lname . ', ' . $applicant->user->fname . ' ' . $applicant->user->suffix . ' ' . $applicant->user->mname[0] }}
			</td>

			<td colspan="2">
				RANK
			</td>
			<td colspan="2">
				{{ isset($applicant->rank) ? $applicant->rank->name : 'TBA' }}
			</td>

			<td colspan="2">
				NATIONALITY
			</td>
			<td colspan="3">
				FILIPINO
			</td>
		</tr>

		<!-- 3rd Row -->
		<tr>
			<td colspan="2">
				BIRTH DATE
			</td>
			<td colspan="3">
				{{ $applicant->user->birthday->format('F j, Y') }}
			</td>

			<td colspan="2">
				JOINING DATE
			</td>
			<td colspan="2">
				-----
			</td>

			<td colspan="2">
				SIGN OF VERIFIER
			</td>
			<td colspan="3"></td>
		</tr>

		<!-- 4th Row -->
		<tr>
			<td colspan="14"></td>
		</tr>

		<!-- 5th Row -->
		<tr>
			<td colspan="5">
				DOCUMENTS
			</td>

			<td colspan="2">
				NUMBER
			</td>
			<td colspan="2">
				ISSUE
			</td>

			<td colspan="2">
				EXPIRY
			</td>
			<td colspan="3">
				Issuing Authority / Remarks
			</td>
		</tr>

		{{-- DOCUMENTS --}}
		{{ addS('IDENTIFICATION') }}

		{{ $getDocument('PASSPORT', 	'id', 		'DFA'													)}}
		{{ $getDocument("SEAMAN'S BOOK",'id', 		'MARINA', 		'NATIONAL SEAMAN BOOK'					)}}
		{{ $getDocument("US-VISA", 		'id', 		'US EMBASSY', 	'U.S.A. VISA'							)}}
		{{ $getDocument("MCV", 			'id', 		'DHA - AUSTRALIA'										)}}

		{{ addS('NATIONAL LICENSES') }}

		{{ $getDocument('COC', 			'lc', 		'MARINA', 		'NATIONAL LICENSE - COC'				)}}
		{{ $getDocument('COE', 			'lc', 		'MARINA', 		'NATIONAL LICENSE - COE'				)}}
		{{ $getDocument('GMDSS/GOC', 	'lc', 		'MARINA', 		'NATIONAL GMDSS - GOC'					)}}
		{{ $getDocument('COC', 			'lc',		'MARINA', 		'NATIONAL LICENSE - RATINGS', 		true)}}
		{{ $getDocument('COE', 			'lc', 		'MARINA', 		'NATIONAL LICENSE - RATINGS', 		true)}}
		{{ $getDocument('NCIII', 		'lc', 		'TESDA', 		'NATIONAL LICENSE - CCK (NCIII)', 	true)}}
		{{ $getDocument('NCI', 			'lc',	 	'TESDA', 		'NATIONAL LICENSE - MSM (NCI)', 	true)}}

		{{ addS('FLAG STATE CERTIFICATES') }}

		{{-- ($docu, $type, $issuer = null, $name = null, $regulation = null) --}}

		{{ $getDocument('LICENSE', 		'flag', 	'PANAMA', 		'FLAG STATE LICENSE'					)}}
		{{ $getDocument('GMDSS/GOC', 	'flag', 	'PANAMA', 		'FLAG STATE GMDSS-GOC'					)}}
		{{ $getDocument('BOOKLET', 		'flag', 	'PANAMA', 		'FLAG STATE SEAMAN BOOK (I.D. BOOK)'	)}}
		{{ $getDocument('SSO', 			'flag', 	'PANAMA', 		'FLAG STATE SSO LICENSE'				)}}
		{{ $getDocument("SHIP'S COOK ENDORSEMENT", 'flag', 'PANAMA', 'FLAG STATE ENDORSEMENT COOK COURSE')}}

		{{ addS('TRAINING CERTIFICATES') }}
		
		{{ $getDocument('BASIC TRAINING - BT', 'lc', 'MARINA', 'BASIC TRAINING (BT)')}}
		{{ $getDocument('PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB', 'lc', 'MARINA', 'PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT (PSCRB)')}}
		{{ $getDocument('ADVANCE FIRE FIGHTING - AFF', 'lc', 'MARINA', 'ADVANCE FIRE FIGHTING (AFF)')}}
		{{ $getDocument('MEDICAL FIRST AID - MEFA', 'lc', 'MARINA', 'MEDICAL FIRST AID (MEFA)')}}
		{{ $getDocument('MEDICAL CARE (MECA)', 'lc', 'MARINA', 'MEDICAL CARE (MECA)')}}
		{{ $getDocument('SHIP SECURITY OFFICER - SSO', 'lc', 'MARINA', 'SHIP SECURITY OFFICER (SSO)')}}
		{{ $getDocument("SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD", 'lc', 'MARINA', 'SHIP SECURITY AWARENESS w/ SDSD')}}
		{{ $getDocument('FAST RESCUE BOAT - FRB', 'lc', 'MARINA', 'FAST RESCUE BOAT (FRB)')}}

		{{ $getDocument('ECDIS', 'lc', '', 'ECDIS GENERIC')}}
		{{ $getDocument('ECDIS SPECIFIC', 'lc', '', 'ECDIS SPECIFIC')}}

		{{ $getDocument('SSBT WITH BRM', 'lc', '', 'BRIDGE TEAM/RESOURCE MANAGEMENT')}}
		{{ $getDocument('SHIP HANDLING SIMULATION', 'lc', '', 'SHIP HANDLING SIMULATION')}}
		{{ $getDocument('ERS WITH ERM', 'lc', '', 'ENGINE ROOM SIMULATOR w/ ENGINE RESOURCE MGT.')}}
		{{ $getDocument('ARPA TRAINING COURSE', 'lc', '', 'ARPA TRAINING COURSE')}}
		{{ $getDocument('RADAR', 'lc', '', 'RADAR TRAINING COURSE')}}
		{{ $getDocument('CONSOLIDATED MARPOL', 'lc', '', 'MARPOL')}}
		{{ $getDocument('IN HOUSE TRAINING CERT WITH ISM', 'lc', 'SOLPIA', 'ISM/ISPS COURSE')}}
		{{ $getDocument('ANTI PIRACY', 'lc', 'SOLPIA', 'ANTI-PIRACY AWARENESS TRAINING')}}
		{{ $getDocument('WELDING COURSE', 'lc', '', 'WELDING CERTIFICATE')}}
		{{ $getDocument("SAFETY OFFICER'S TRAINING COURSE", 'lc')}}
		{{ $getDocument('DANGEROUS FLUID CARGO COURSE', 'lc')}}
		{{ $getDocument('CARGO HANDLING', 'lc', '')}}
		{{ $getDocument('RISK ASSESSMENT / INCIDENT INVESTIGATION COURSE', 'lc', '', 'RISK ASSESSMENT / INCIDENT INVESTIGATION COURSE')}}

		{{ addS('MEDICAL CERTIFICATES') }}

		{{ $getDocument('MEDICAL CERTIFICATE', 'med_cert', '', 'MEDICAL EXAMINATION')}}
		{{ $getDocument('YELLOW FEVER', 'med_cert', '', 'VACCINATION - YELLOW FEVER')}}
		{{ $getDocument('DRUG AND ALCOHOL TEST', 'med_cert')}}

		
		<tr>
			<td colspan="5" rowspan="3">
				AUTHENTICATION FOR LICENSES
				AND CERTIFICATES IF THEY ARE
				TRUTH
			</td>

			<td colspan="4" rowspan="3">
				MEANS OF AUTHENTICATION:
				INTERNET, FAX, PHONE,
				LETTER, PRESENTING TO
				ADMINISTRATION
			</td>
			<td colspan="5" rowspan="3">
				CONFIRMED BY: JEFFREY R. PLANTA
				<br>
				(Crewing Manager)
			</td>
		</tr>
	</tbody>
</table>