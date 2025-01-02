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

	$getDocument = function($docu, $type, $issuer = null, $name = null, $regulation = null, $riri = null) use ($applicant, $checkDate2, $rank) {
		$name   = !$name ? $docu : $name;

		if($rank >= 1 && $rank <= 4){
			$dRank = isset($applicant->rank) ? $applicant->rank->abbr : '----';

			if($docu == "GMDSS/GOC"){
				$dRank = "GMDSS OPERATOR";
			}
			elseif($docu == "SSO"){
				$dRank = "SHIP SAFETY OFFICER";
			}
		}
		else{
			$dRank = '-----';
		}

		if(in_array($type, ['id', 'lc', 'med_cert'])){
			if($type == "lc" && ($docu == "COC" || $docu == "COE")){
				if($rank > 0 && $regulation){
					$tempDocu = $docu;
					$docu = false;
					$temp = "";

					// IF RATINGS ONLY
					if($rank >= 9 && $rank <= 23){
						foreach($applicant->document_lc as $document){
							$regulation = json_decode($document->regulation);
							
							if($rank >= 9 && $rank <= 14){
								$temp = $docu == "COC" ? 'II/4' : 'II/5';
							}
							elseif($rank >= 15 && $rank <= 23){
								$temp = $docu == "COC" ? 'III/4' : 'III/5';
							}

						    if(in_array($temp, $regulation)){
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
								<td colspan='10'>
									$name
								</td>

								<td colspan='6'>$dRank</td>
								<td colspan='6'>$number</td>
								<td colspan='6'>$issue</td>
								<td colspan='6'>$expiry</td>
								<td colspan='6'>$issuer</td>
							</tr>
						";
					}

				}

				if($string != ""){
					echo $string;
					return;
				}
			}
			elseif ($docu == 'BTM') {
				$temp = $docu;
				$docu = isset($applicant->{"document_$type"}->$docu) ? $applicant->{"document_$type"}->$docu : false;

				if(!$docu){
					$name = 'ETM';
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
				}

				$name = 'BTM/ETM';
			}
			elseif ($docu == 'BRM') {
				$temp = $docu;
				$docu = isset($applicant->{"document_$type"}->$docu) ? $applicant->{"document_$type"}->$docu : false;

				if(!$docu){
					$name = 'ERM';
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
				}

				$name = 'BRM/ERM';
			}
			else{
				$temp = $docu;

				if($docu == "MLC TRAINING F1" && $rank > 4){
					$docu = false;
				}
				else{
					if($docu == "MLC TRAINING F" && ($rank >= 1 && $rank <= 4)){
						$docu .= '3';
					}
					elseif($docu == "MLC TRAINING F" && ($rank >= 5 && $rank <= 8)){
						$docu .= '4';
					}
					
					$docu = isset($applicant->{"document_$type"}->$docu) ? $applicant->{"document_$type"}->$docu : false;
				}

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
			        $docu->issuer = $docu->country;
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

			// if($issuer == "NOT APPLICABLE" && $type == "med_cert"){
			// 	$issuer = "REVERTING";
				
			// }
		}

		if(!$riri){
			echo "
				<tr>
					<td colspan='10'>
						$name
					</td>

					<td colspan='6'>$number</td>
					<td colspan='6'>$issue</td>
					<td colspan='6'>$expiry</td>
					<td colspan='6'>$issuer</td>
				</tr>
			";
		}
		else{
			echo "
				<tr>
					<td colspan='5'>
						$name
					</td>

					<td colspan='5'>$dRank</td>
					<td colspan='6'>$number</td>
					<td colspan='6'>$issue</td>
					<td colspan='6'>$expiry</td>
					<td colspan='6'>$issuer</td>
				</tr>
			";
		}
	};

	function addS($name){
		echo "
			<tr>
				<td colspan='34'>$name</td>
			</tr>
		";
	}
@endphp

<table>
	<tr>
		<td rowspan="11" colspan="8"></td>
		<td rowspan="2" colspan="18">BIO-DATA</td>
		<td colspan="8">CHECK BY</td>
	</tr>

	<tr>
		<td colspan="4">DP</td>
		<td colspan="4">GM MRN</td>
	</tr>

	<tr>
		<td colspan="18"></td>
		<td rowspan="2" colspan="4"></td>
		<td rowspan="2" colspan="4"></td>
	</tr>

	<tr></tr>
	<tr></tr>
	<tr></tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="12">
			Submit to Shoei Kissen Kaisha Co., Ltd. On:
		</td>
	</tr>

	<tr></tr>

	<tr>
		<td></td>
		<td colspan="5">Manning Agent:</td>
		<td colspan="9">SEYEONG MARINE CO.,LTD</td>
		<td colspan="3">Presenter</td>
		<td colspan="8"></td>
	</tr>

	<tr></tr>

	<tr>
		<td colspan="15"></td>
		<td colspan="3">Date:</td>
		<td colspan="8">{{ $applicant->created_at->format('M j, Y') }}</td>
	</tr>

	<tr></tr>

	<tr>
		<td colspan="3">Code No.:</td>
		<td colspan="4"></td>
		<td></td>
		<td colspan="2">Rank:</td>
		<td colspan="4">{{ isset($applicant->rank) ? $applicant->rank->abbr : 'TBA' }}</td>

		{{-- GET FIRST SOLPIA SEA SERVICE --}}
		@php
			$date_employed = $applicant->created_at->format('M j, Y');
			foreach($applicant->sea_service as $service){
				if(strpos(strtoupper($service->manning_agent), 'SOLPIA') !== false){
					$date_employed = $service->sign_on->format('M j, Y');
				}
			}
		@endphp

		<td colspan="5">Date Employed:</td>
		<td colspan="4">{{ $date_employed }}</td>
		<td colspan="3">Vessel:</td>
		<td colspan="8">{{ isset($applicant->vessel) ? $applicant->vessel->name : 'TBA' }}</td>
	</tr>

	<tr>
		<td colspan="34"></td>
	</tr>

	<tr>
		<td colspan="3">Name:</td>
		<td colspan="9">{{ $applicant->user->lname }}</td>
		<td></td>
		<td colspan="10">{{ $applicant->user->fname . ' ' . $applicant->user->suffix }}</td>
		<td></td>
		<td colspan="10">{{ $applicant->user->mname }}</td>
	</tr>

	<tr>
		<td colspan="5"></td>
		<td colspan="4">(Surname)</td>
		<td colspan="7"></td>
		<td colspan="5">(Given Name)</td>
		<td colspan="6"></td>
		<td colspan="5">(Middle Name)</td>
	</tr>

	<tr>
		<td colspan="3">Address:</td>
		<td colspan="21">{{ $applicant->provincial_address }}</td>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="34"></td>
	</tr>

	<tr>
		<td colspan="3"></td>
		<td colspan="21"></td>
		<td></td>
		<td colspan="4">Telephone:</td>
		<td colspan="5">{{ $applicant->provincial_contact }}</td>
	</tr>

	<tr>
		<td colspan="34"></td>
	</tr>

	<tr>
		<td colspan="3">Birth Date:</td>
		<td colspan="6">{{ $applicant->user->birthday->format('F j, Y') }}</td>
		<td colspan="3">Age:</td>
		<td colspan="2">{{ $applicant->user->birthday->diff(now())->format('%y') }}</td>
		<td colspan="3">Birth Place:</td>
		<td colspan="7">{{ $applicant->birth_place }}</td>
		<td></td>
		<td colspan="4">Nationality:</td>
		<td colspan="5">FILIPINO</td>
	</tr>

	<tr>
		<td colspan="34"></td>
	</tr>

	<tr>
		@php
			$weight = $applicant->weight;
			$height = $applicant->height;
		@endphp
		<td colspan="3">Civil Status:</td>
		<td colspan="6">{{ $applicant->civil_status }}</td>
		<td colspan="3">Weight:</td>
		<td colspan="4">{{ $weight }}</td>
		<td>kg</td>
		<td colspan="3">Height:</td>
		<td colspan="3">{{ $height }}</td>
		<td>cm</td>
		<td></td>
		<td colspan="4">BMI index:</td>
		<td colspan="5">{{ $applicant->bmi }}</td>
	</tr>

	<tr>
		<td colspan="34"></td>
	</tr>

	<tr>
		<td colspan="3">SSS No.:</td>
		<td colspan="6">{{ $applicant->sss }}</td>
		<td colspan="2">Tin:</td>
		<td colspan="6">{{ $applicant->tin }}</td>
		<td colspan="4">Shoe Size:</td>
		<td colspan="2">{{ $applicant->shoe_size }}</td>
		<td>cm</td>
		<td></td>
		<td colspan="4">Clothes Size:</td>
		<td colspan="5">{{ $applicant->clothes_size }}</td>
	</tr>

	<tr>
		<td colspan="34"></td>
	</tr>

	<tr>
		<td colspan="16">
			Name of Wife (or Nearest Relative) and Address
		</td>
		<td colspan="2"></td>
		<td colspan="3">Relation:</td>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td colspan="34"></td>
	</tr>

	<tr>
		<td colspan="2">Name</td>
		<td colspan="10"></td>
		<td></td>
		<td colspan="10"></td>
		<td></td>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="10"></td>
		<td></td>
		<td colspan="10"></td>
		<td></td>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="3">Address</td>
		<td colspan="22"></td>
		<td colspan="4">Telephone:</td>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td colspan="34"></td>
	</tr>

	{{-- EDUCATIONAL BACKGROUND --}}
	<tr>
		<td colspan="34">
			1. EDUCATIONAL ATTAINMENT
		</td>
	</tr>

	<tr>
		<td colspan="6">
			Year
		</td>
		<td colspan="14">
			School
		</td>
		<td colspan="14">
			Course Finished
		</td>
	</tr>

	@foreach($applicant->educational_background as $data){
		<tr>
			<td colspan="6">{{ $data->year }}</td>
			<td colspan="14">{{ $data->school }}</td>
			<td colspan="14">{{ $data->course }}</td>
		</tr>
	@endforeach
	
	{{-- LICENSES --}}
	{{ addS('2. LICENSES') }}

	<tr>
		<td colspan="5">LICENSE</td>
		<td colspan="5">RANK</td>
		<td colspan="6">NUMBER</td>
		<td colspan="6">DATE ISSUED</td>
		<td colspan="6">EXPIRY DATE</td>
		<td colspan="6">ISSUED BY</td>
	</tr>

	{{ $getDocument('', 			'lc', 		'MARINA', 		'National'			,'',true			)}}
	{{ $getDocument('LICENSE', 		'flag', 	'PANAMA', 		'Panama License'	,'',true			)}}
	{{ $getDocument('GMDSS/GOC', 	'flag', 	'', 			'GOC'				,'',true			)}}
	
	{{-- CERTIFICATES --}}
	{{ addS('3. CERTIFICATE') }}

	<tr>
		<td colspan="10">CERTIFICATE</td>
		<td colspan="6">NUMBER</td>
		<td colspan="6">DATE ISSUED</td>
		<td colspan="6">EXPIRY DATE</td>
		<td colspan="6">ISSUED BY</td>
	</tr>

	{{ $getDocument('PASSPORT', 	'id', 		'',			"Passport"						)}}
	{{ $getDocument("SEAMAN'S BOOK",'id', 		'', 		"Seaman's Book/Philippines"		)}}
	{{ $getDocument('BOOKLET', 		'flag', 	'PANAMA', 	"Seaman's Book/Panama"			)}}
	{{ $getDocument('', 		'flag', 	'', 	"Seaman's Book/Others"		)}}

	{{ addS('4. OTHER CERTIFICATES (MARINA/SOLAS/MARPOL/OTHERS') }}

	<tr>
		<td colspan="10">CERTIFICATE</td>
		<td colspan="6">NUMBER</td>
		<td colspan="6">DATE ISSUED</td>
		<td colspan="6">EXPIRY DATE</td>
		<td colspan="6">ISSUED BY</td>
	</tr>

	{{ $getDocument('COC', 			'lc',		'MARINA', 		'NATIONAL LICENSE-COC', 		true)}}
	{{ $getDocument('COE', 			'lc',		'MARINA', 		'NATIONAL LICENSE-COC', 		true)}}
	{{ $getDocument('BASIC TRAINING - BT', 'lc', 'MARINA', 'Basic Training')}}
	{{ $getDocument('PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB', 'lc', 'MARINA', 'Survival Craft and Rescue Boat')}}
	{{ $getDocument('ADVANCE FIRE FIGHTING - AFF', 'lc', 'MARINA', 'Advance Firefighting Course')}}
	{{ $getDocument('MEDICAL FIRST AID - MEFA', 'lc', 'MARINA', 'Medical First Aid')}}
	{{ $getDocument('MEDICAL CARE - MECA', 		'lc', 'MARINA', 'Medical Care Course')}}
	{{ $getDocument('SHIP SECURITY OFFICER - SSO', 'lc', 'MARINA', 'SSO (Ship Security Officer) Course/SSA')}}
	{{ $getDocument('FAST RESCUE BOAT - FRB', 'lc', 'MARINA', 'Proficiency in Fast Rescue Boat')}}
	{{ $getDocument('ADVANCE NAVIGATION', 'lc', '', 'Advance Navigation')}}
	{{ $getDocument('ADVANCE SHIPBOARD OPERATION AND MGT', 'lc', '', 'Advance Shipboard Operation and Management')}}
	{{ $getDocument('ECDIS', 'lc', '', 'ECDIS-Generic')}}

	{{-- NA Error formula in form sample --}}
	{{ $getDocument("", 'lc', '-----', '#N/A')}}

	{{ $getDocument('BRM', 'lc', '', 'Bridge Resource Management')}}
	{{ $getDocument('ARPA TRAINING COURSE', 'lc', '', 'ARPA')}}
	{{ $getDocument('ERS', 'lc', '', 'Engine Room Simulator (ERS)')}}
	{{ $getDocument('CONSOLIDATED MARPOL', 'lc', '', 'Consolidated Marpol 73/78')}}
	{{ $getDocument("SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD", 'lc', 'MARINA', 'Seafarers with Designated Security Duties')}}

	@php
		$raaank = (($rank >= 1 && $rank <= 4) || ($rank >= 9 && $rank <= 14)) ? 'Deck' : 'Engineer';
	@endphp

	@if(($rank >= 1 && $rank <= 4) || ($rank >= 9 && $rank <= 14))

	{{ $getDocument('MLC TRAINING F1', 'lc', '', "MLC FUNCTION 1 - Marine Deck Officers")}}
	{{ $getDocument('MLC TRAINING F1', 'lc', '', "MLC FUNCTION 2 - Marine Deck Officers")}}
	{{ $getDocument('MLC TRAINING F1', 'lc', '', "MLC FUNCTION 3 - Marine Deck Officers")}}
	{{ $getDocument('MLC TRAINING F1', 'lc', '', "MLC FUNCTION 4 - Marine Deck Officers")}}

	{{ $getDocument('', 'lc', '', "MLC FUNCTION 1 - Marine Engineer Officers")}}
	{{ $getDocument('', 'lc', '', "MLC FUNCTION 2 - Marine Engineer Officers")}}
	{{ $getDocument('', 'lc', '', "MLC FUNCTION 3 - Marine Engineer Officers")}}
	{{ $getDocument('', 'lc', '', "MLC FUNCTION 4 - Marine Engineer Officers")}}

	@elseif(($rank >= 5 && $rank <= 8) || ($rank >= 15 && $rank <= 21))

	{{ $getDocument('', 'lc', '', "MLC FUNCTION 1 - Marine Deck Officers")}}
	{{ $getDocument('', 'lc', '', "MLC FUNCTION 2 - Marine Deck Officers")}}
	{{ $getDocument('', 'lc', '', "MLC FUNCTION 3 - Marine Deck Officers")}}
	{{ $getDocument('', 'lc', '', "MLC FUNCTION 4 - Marine Deck Officers")}}

	{{ $getDocument('MLC TRAINING F1', 'lc', '', "MLC FUNCTION 1 - Marine Engineer Officers")}}
	{{ $getDocument('MLC TRAINING F1', 'lc', '', "MLC FUNCTION 2 - Marine Engineer Officers")}}
	{{ $getDocument('MLC TRAINING F1', 'lc', '', "MLC FUNCTION 3 - Marine Engineer Officers")}}
	{{ $getDocument('MLC TRAINING F1', 'lc', '', "MLC FUNCTION 4 - Marine Engineer Officers")}}

	@endif

	{{-- VISAS --}}
	{{ addS('5. CREW VISA') }}

	<tr>
		<td colspan="10">Country</td>
		<td colspan="6">Type/Class</td>
		<td colspan="6">Date Issued</td>
		<td colspan="6">Expiry Date</td>
		<td colspan="6">Remarks</td>
	</tr>
	
	{{ $getDocument('US-VISA', 'id', '', "U.S.A.")}}
	{{ $getDocument('MCV', 'id', '', "M.C.V.")}}

	{{-- MEDS --}}
	{{ addS('6. PHYSICAL INSPECTION / YELLOW CARD') }}

	<tr>
		<td colspan="10">CERTIFICATE</td>
		<td colspan="6">NUMBER</td>
		<td colspan="6">DATE ISSUED</td>
		<td colspan="6">EXPIRY DATE</td>
		<td colspan="6">REMARKS</td>
	</tr>

	{{ $getDocument('MEDICAL CERTIFICATE', 'med_cert', '', 'Physical Inspection')}}
	{{ $getDocument('CHOLERA', 'med_cert', '', 'Cholera')}}
	{{ $getDocument('YELLOW FEVER', 'med_cert', '', 'Yellow Fever')}}

	{{-- LINGUISTIC --}}
	{{ addS('7.1. ENGLISH AND JAPANESE LINGUISTICS') }}

	<tr>
		<td colspan="6">English</td>
		<td colspan="22">Class</td>
		<td colspan="6">Evaluation</td>
	</tr>

	<tr>
		<td colspan="6">Read and Write</td>
		<td colspan="22">Excellent / Good / Acceptable / Poor / Unsuitable</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="6">Speak and Listen</td>
		<td colspan="22">Excellent / Good / Acceptable / Poor / Unsuitable</td>
		<td colspan="6"></td>
	</tr>

	{{-- COMPUTER OPERATION --}}
	{{ addS('7.2. COMPUTER OPERATION') }}

	<tr>
		<td colspan="6">Software</td>
		<td colspan="22">Class</td>
		<td colspan="6">Evaluation</td>
	</tr>

	<tr>
		<td colspan="6">WORD and Other</td>
		<td colspan="22">Excellent / Good / Acceptable / Poor / Unsuitable</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="6">Excel and Other</td>
		<td colspan="22">Excellent / Good / Acceptable / Poor / Unsuitable</td>
		<td colspan="6"></td>
	</tr>

	{{ addS('8 TRAINING / EXPERIENCE FOR SAFETY MANAGEMENT SYSTEM') }}

	<tr>
		<td colspan="11">Type</td>
		<td colspan="11">Date</td>
		<td colspan="6">Period</td>
		<td colspan="6">Evaluation</td>
	</tr>

	<tr>
		<td colspan="11">Training for SMS</td>
		<td colspan="11"></td>
		<td colspan="6"></td>
		<td colspan="6"></td>
	</tr>
	
	<tr>
		<td colspan="11">Experience of SMS</td>
		<td colspan="11"></td>
		<td colspan="6"></td>
		<td colspan="6"></td>
	</tr>

	{{ addS('9. Ability of Welding') }}

	<tr>
		<td colspan="6">Welding</td>
		<td colspan="22">Class</td>
		<td colspan="6">Evaluation</td>
	</tr>

	<tr>
		<td colspan="2">Ability</td>
		<td colspan="22">Good / Acceptable / Poor</td>
		<td colspan="6"></td>
	</tr>

	{{ addS("10. SEAMAN'S HISTORY") }}

	<tr>
		<td></td>
		<td colspan="33">
			Sea service (within the last ten years) listed most recent service last,
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2">Note:</td>
		<td></td>
		<td colspan="30">
			1) Indicated wether vessel is M/V (Motor Vessel), S/S (Steam Ship) or S/T (Steam Turbine), etc.
		</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="30">
			2) Under TYPE indicate wether Bulk, Log, VLCC, Chemical LPG, PCC, Reefer, etc.
		</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="30">
			3) For Deck Officers / Ratings indicate Gross Tonnage of Vessel
		</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="30">
			4) For Enginer Officers / Rating indicate Gross Tonnage and Engine Type with Horsepower
		</td>
	</tr>

	<tr>
		<td colspan="6">Vessel's Name</td>
		<td colspan="4">Type</td>
		<td colspan="6">Gross Tonnage</td>
		<td colspan="6">Manning</td>
		<td colspan="6">Sign On</td>
		<td colspan="6">Reason/</td>
	</tr>

	<tr>
		<td colspan="6">Flag</td>
		<td colspan="4">Rank</td>
		<td colspan="6">Engine Type/KW</td>
		<td colspan="6">sailed with</td>
		<td colspan="6">Sign off</td>
		<td colspan="6">Sign-Off</td>
	</tr>

	@php
		$date_employed = $applicant->created_at->format('M j, Y');
	@endphp
	
	@foreach($applicant->sea_service as $service)
		<tr>
			<td colspan="6">{{ $service->vessel_name }}</td>
			<td colspan="4">{{ $service->vessel_type }}</td>
			@php 
				$temp = $service->gross_tonnage;
				$temp = $temp == "" ? '---' : $temp; 
			@endphp
			<td colspan="6">{{ is_numeric($temp) ? number_format($temp) : $temp}}</td>
			<td rowspan="2" colspan="6">{{ $service->manning_agent }}</td>
			<td colspan="6">{{ $service->sign_on != "" ? $service->sign_on->format('d.M.y') : "N/A" }}</td>
			<td rowspan="2" colspan="6">{{ $service->remarks }}</td>
		</tr>

		<tr>
			<td colspan="6">{{ $service->flag }}</td>
			<td colspan="4">{{ $applicant->ranks[$service->rank] }}</td>
			<td colspan="6">{{ $service->engine_type }} / {{ $service->bhp_kw }}</td>
			<td colspan="6">{{ $service->sign_off != "" ? $service->sign_off->format('d.M.y') : "N/A" }}</td>
		</tr>
	@endforeach

	<tr>
		<td colspan="34"></td>
	</tr>

	<tr>
		<td colspan="4">Crew's Name:</td>
		<td colspan="15">
			{{ $applicant->user->lname . ', ' . $applicant->user->fname . ' ' . $applicant->user->suffix . ' ' . $applicant->user->mname }}
		</td>
		<td></td>
		<td colspan="4">Presenter:</td>
		<td colspan="10">SHIRLEY ERASQUIN / CREWING MANAGER</td>
	</tr>

	<tr>
		<td colspan="34"></td>
	</tr>

</table>