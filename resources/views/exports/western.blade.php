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
			if($docu == "WATCHKEEPING"){
				$docu = false;
				foreach($applicant->document_lc as $document){
					// $watchCerts = ['DECK WATCH', 'ENGINE WATCH', 'ENGINE WATCHKEEPING', 'DECK WATCHKEEPING', 'WATCHKEEPING', 'NAV WATCH'];
					$regulations = json_decode($document->regulation);

				    if(in_array("II/4", $regulations) || in_array("III/4", $regulations)){
				        $docu = $document;
				    }
				    elseif(in_array("II/5", $regulations) || in_array("III/5", $regulations)){
				    	$docu = $document;
				        break;
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
					$name = 'BRIDGE RESOURCE MANAGEMENT';
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
				}
				if(!$docu){
					$name = 'ERM';
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
				}
				if(!$docu){
					$name = 'ENGINE RESOURCE MANAGEMENT';
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
				}
				if(!$docu){
					$name = 'SSBT WITH BRM';
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
				}

				$name = 'BRM/ERM';
			}
			elseif ($docu == 'ERS') {
				$temp = $docu;
				$docu = isset($applicant->{"document_$type"}->$docu) ? $applicant->{"document_$type"}->$docu : false;

				if(!$docu){
					$name = 'ERS WITH ERM';
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
				}
			}
			elseif($type == "lc" && $issuer == "MARINA"){
				$change = true;
				foreach(get_object_vars($applicant->document_lc) as $docs2){
					if(str_starts_with($docs2->type, $docu) && $docs2->issuer == "MARINA"){
						$docu = $docs2;
						$change = false;
					}
				}
				if($change){
					$docu = false;
				}
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

		$number = $docu ? strtoupper($docu->$noNum) : '-----';
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

		$issuer = str_replace('&', '&#38;', $issuer);

		if(!$riri){
			if($name == "1st Dose" || $name == "2nd Dose" || $name == "3rd Dose"){
				echo "
					<td colspan='3'>
						$name
					</td>

					<td colspan='6'>$number</td>
					<td colspan='6'>$issue</td>
					<td colspan='6'>$expiry</td>
					<td colspan='6'>$issuer</td>
				";
			}
			else{
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
		<td rowspan="2" colspan="18"></td>
		<td colspan="8">CHECK BY</td>
	</tr>

	<tr>
		<td colspan="4">GM MRN</td>
		<td colspan="4">INCHARGE</td>
	</tr>

	<tr>
		<td colspan="18"></td>
		<td rowspan="2" colspan="4"></td>
		<td rowspan="2" colspan="4"></td>
	</tr>

	<tr></tr>
	<tr></tr>
	<tr></tr>
	<tr></tr>
	<tr></tr>

	<tr>
		<td></td>
		<td colspan="6">Principal Company:</td>
		<td colspan="12">TOEI JAPAN LTD.</td>
	</tr>

	<tr></tr>

	<tr>
		<td colspan="15"></td>
		<td colspan="3">Date:</td>
		<td colspan="8">{{ now()->format('M j, Y') }}</td>
	</tr>

	<tr></tr>

	<tr>
		<td colspan="4">Code No.:</td>
		<td colspan="4"></td>
		<td colspan="2">Rank:</td>
		<td colspan="4">{{ isset($applicant->rank) ? $applicant->rank->abbr : 'TBA' }}</td>

		{{-- GET FIRST SOLPIA SEA SERVICE --}}
		@php
			$date_employed = null;
			foreach($applicant->sea_service as $service){
				if(strpos(strtoupper($service->manning_agent), 'SOLPIA') !== false && !$date_employed){
					$date_employed = $service->sign_on->format('M j, Y');
				}
			}

			if(!$date_employed){
				$date_employed = $applicant->created_at->format('M j, Y');
			}
		@endphp

		<td colspan="5">Date Employed:</td>
		<td colspan="4">{{ $date_employed }}</td>
		<td colspan="3">Vessel:</td>
		<td colspan="8">{{ isset($applicant->vessel) ? $applicant->vessel->name : 'TBA' }}</td>
	</tr>

	<tr>
		<td colspan="2">Name:</td>
		<td colspan="10">{{ $applicant->user->lname }}</td>
		<td></td>
		<td colspan="10">{{ $applicant->user->fname . ' ' . $applicant->user->suffix }}</td>
		<td></td>
		<td colspan="10">{{ $applicant->user->mname }}</td>
	</tr>

	<tr>
		<td colspan="5"></td>
		<td colspan="4">(Surname)</td>
		<td colspan="7"></td>
		<td colspan="5">(Given Name</td>
		<td colspan="6"></td>
		<td colspan="5">(Middle Name)</td>
	</tr>

	<tr>
		<td colspan="3">Address:</td>
		<td colspan="22">{{ $applicant->user->address ?? $applicant->provincial_address ?? '---' }}</td>
		<td colspan="4">Telephone:</td>
		<td colspan="5">{{ $applicant->user->contact }}</td>
	</tr>

	<tr>
		<td colspan="3"></td>
		<td colspan="22"></td>
		<td colspan="4">Nationality:</td>
		<td colspan="5">FILIPINO</td>
	</tr>

	<tr>
		<td colspan="4">Birth Date:</td>
		<td colspan="6">{{ $applicant->user->birthday->format('F j, Y') }}</td>
		<td colspan="2">Age:</td>
		<td colspan="2">{{ $applicant->user->birthday->diff(now())->format('%y') }}</td>
		<td colspan="4">Birth Place:</td>
		<td colspan="7">{{ $applicant->birth_place }}</td>
		<td colspan="4">BMI index:</td>
		@php
			$weight = $applicant->weight;
			$height = $applicant->height;
		@endphp
		<td colspan="5">{{ $applicant->bmi }}</td>
	</tr>

	<tr>
		<td colspan="4">Civil Status:</td>
		<td colspan="6">{{ $applicant->civil_status }}</td>
		<td colspan="3">Weight:</td>
		<td colspan="3">{{ $weight }}</td>
		<td>kg</td>
		<td colspan="3">Height:</td>
		<td colspan="3">{{ $height }}</td>
		<td>cm</td>
		<td></td>
		<td colspan="4">Eye Color:</td>
		<td colspan="5">{{ $applicant->eye_color }}</td>
	</tr>

	<tr>
		<td colspan="3">SSS No.:</td>
		<td colspan="7">{{ $applicant->sss }}</td>
		<td colspan="2">Tin:</td>
		<td colspan="5">{{ $applicant->tin }}</td>
		<td colspan="4">Shoe Size:</td>
		<td colspan="2">{{ $applicant->shoe_size }}</td>
		<td>cm</td>
		<td></td>
		<td colspan="5">Clothes Size:</td>
		<td colspan="4">{{ $applicant->clothes_size }}</td>
	</tr>

	{{-- EDUCATIONAL BACKGROUND --}}
	<tr>
		<td colspan="34">
			1. EDUCATIONAL ACHIEVEMENT
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

	@foreach($applicant->educational_background as $data)
		<tr>
			<td colspan="6">{{ $data->year }}</td>
			<td colspan="14">{{ $data->school }}</td>
			<td colspan="14">{{ $data->course }}</td>
		</tr>
	@endforeach
	
	{{-- LICENSES --}}
	{{ addS('2. LICENSES') }}

	<tr>
		<td colspan="5">License</td>
		<td colspan="5">Rank</td>
		<td colspan="6">Number</td>
		<td colspan="6">Date Issued</td>
		<td colspan="6">Expiry Date</td>
		<td colspan="6">Issued By</td>
	</tr>

	@if(isset($applicant->rank) && $applicant->rank->type == "OFFICER")
		{{ $getDocument('COC', 			'lc', 		'MARINA', 		'National License'	,'',true			)}}
	@else
		{{ $getDocument('COC-EMPTY', 			'lc', 		'MARINA', 		'National License'	,'',true			)}}
	@endif
	{{ $getDocument('GMDSS/GOC', 	'lc', 		'MARINA', 		'National GMDSS'	,'',true			)}}
	{{ $getDocument('LICENSE', 		'flag', 	'PANAMA', 		'Flag License'		,'',true			)}}
	{{ $getDocument('GMDSS/GOC', 	'flag', 	'', 			'Flag GMDSS'		,'',true			)}}
	@if($rank >= 1 && $rank <= 2)
		{{ $getDocument('SSO', 			'flag', 	'', 			'Flag SSO / SDSD'	,'',true			)}}
	@else
		{{ $getDocument('SDSD', 		'flag', 	'', 		'Flag SSO / SDSD'	,'',true			)}}
	@endif
	
	{{-- CERTIFICATES --}}
	{{ addS('3. CERTIFICATE') }}

	<tr>
		<td colspan="10">Certificate</td>
		<td colspan="6">Number</td>
		<td colspan="6">Date Issued</td>
		<td colspan="6">Expiry Date</td>
		<td colspan="6">Issued By</td>
	</tr>

	{{ $getDocument('PASSPORT', 	'id', 		'',			"National Passport"						)}}
	{{ $getDocument("SEAMAN'S BOOK",'id', 		'', 		"National Seaman's book"				)}}
	{{ $getDocument("SID",			'id', 		'', 		"Seafarer Identity Document(SID)"		)}}
	{{ $getDocument('BOOKLET', 		'flag', 	'PANAMA', 	"Flag Seaman's book"					)}}

	{{-- VISAS --}}
	
	@php 
		$name = "US-VISA";
		$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
	@endphp

	<tr>
		<td rowspan="3" colspan="2">VISA</td>
		<td colspan="8">USA Visa</td>
		<td colspan="6">{{ $docu ? $docu->number : "-----"}}</td>
		<td colspan="6">{{ $docu ? $checkDate2($docu->issue_date, "I") : "-----" }}</td>
		<td colspan="6">{{ $docu ? $checkDate2($docu->expiry_date, "E") : "-----" }}</td>
		<td colspan="6">USA Embassy</td>
	</tr>
	
	@php 
		$name = "MCV";
		$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
	@endphp

	<tr>
		<td colspan="8">Aus. MCV Visa</td>
		<td colspan="6">{{ $docu ? $docu->number : "-----"}}</td>
		<td colspan="6">{{ $docu ? $checkDate2($docu->issue_date, "I") : "-----" }}</td>
		<td colspan="6">{{ $docu ? $checkDate2($docu->expiry_date, "E") : "-----" }}</td>
		<td colspan="6">AUS Embassy</td>
	</tr>

	<tr>
		<td colspan="8">Other Visa</td>
		<td colspan="6">-----</td>
		<td colspan="6">-----</td>
		<td colspan="6">-----</td>
		<td colspan="6">-----</td>
	</tr>

	{{ addS('4. OTHER CERTIFICATES (MARINA/SOLAS/MARPOL/OTHERS') }}

	<tr>
		<td colspan="10">Certificate</td>
		<td colspan="6">Number</td>
		<td colspan="6">Date Issued</td>
		<td colspan="6">Expiry Date</td>
		<td colspan="6">Issued By</td>
	</tr>

	{{ $getDocument('WATCHKEEPING', 			'lc',		'MARINA', 		'Watchkeeping', 		true)}}
	{{ $getDocument('BASIC TRAINING - BT', 'lc', 'MARINA', 'Basic Safety Training Course')}}
	{{ $getDocument('PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB', 'lc', 'MARINA', 'Survival Craft And Rescue Boat')}}
	{{ $getDocument('ADVANCE FIRE FIGHTING - AFF', 'lc', 'MARINA', 'Fire-Fighting Course')}}
	{{ $getDocument('MEDICAL FIRST AID - MEFA', 'lc', 'MARINA', 'Medical First Aid Course')}}
	{{ $getDocument('RADAR', 'lc', '', 'Radar Observer')}}
	{{ $getDocument('ARPA TRAINING COURSE', 'lc', '', 'ARPA')}}	
	{{ $getDocument('BTM', 'lc', '', 'BTM/ETM')}}
	@if(isset($applicant->rank))
		@if(str_starts_with($applicant->rank->category, 'ENGINE'))
			{{ $getDocument('ERS', 'lc', '', 'ERS/ERM')}}
		@else
			{{ $getDocument('BRM', 'lc', '', 'BRM/ERM')}}
		@endif
	@endif
	{{ $getDocument('SHIP HANDLING SIMULATION', 'lc', '', 'Ship Simulator')}}


	{{-- 2ND fOUR 4 --}}
	{{ addS('4. OTHER CERTIFICATES (MARINA/SOLAS/MARPOL/OTHERS') }}

	<tr>
		<td colspan="10">Certificate</td>
		<td colspan="6">Number</td>
		<td colspan="6">Date Issued</td>
		<td colspan="6">Expiry Date</td>
		<td colspan="6">Issued By</td>
	</tr>

	{{ $getDocument('MEDICAL CARE - MECA', 'lc', 'MARINA', 'Medical Care Course (MCC)')}}
	{{ $getDocument('SHIP SECURITY OFFICER - SSO', 'lc', 'MARINA', 'Ship Security Officer (SSO)')}}
	{{ $getDocument("SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD", 'lc', 'MARINA', 'Security Awareness (SDSD)')}}
	{{ $getDocument('CONSOLIDATED MARPOL', 'lc', '', 'Marpol 1 73/78')}}

	@php
		$name = null;
		$jr = false;

		if($applicant->vessel){
			if(in_array($applicant->vessel->name, ["M/V UNITED HALO", "M/V VENUS HALO", "M/V ATLANTIC BUENAVISTA", "M/V NORD SINGAPORE"])){
				$name = "ECDIS JRC 9201";
				$jr = true;
			}
			elseif(in_array($applicant->vessel->name, ["M/V PHENOMENAL DIVA"])){
				$name = "ECDIS FURUNO 3100/3200/3300";
			}
			elseif(in_array($applicant->vessel->name, ["M/V FAIR OCEAN", "M/V AFRICAN ARROW", "M/V RED AZALEA", "M/V ATLANTIC OASIS", "M/V ANCASH QUEEN"])){
				$name = "ECDIS JRC 901B";
				$jr = true;
			}
			elseif(in_array($applicant->vessel->name, ["M/V EARTH HARMONY"])){
				$name = "ECDIS TOKYO";
			}
			elseif(in_array($applicant->vessel->name, ["MV WECO ESTHER"])){
				$name = "ECDIS CHARTWORLD EG2";
			}
		}

		$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
	@endphp

	<tr>
		<td rowspan="3" colspan="2">ECDIS</td>

		@if($jr && isset($applicant->rank) && $applicant->rank->category == "DECK OFFICER")
			<td colspan="8">
				Specific Training({{ $name }})
			</td>
			<td colspan="6">{{ $docu ? $docu->no : "-----"}}</td>
			<td colspan="6">{{ $docu ? $checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td colspan="6">{{ $docu ? $checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="6">{{ $docu ? $docu->issuer : "-----" }}</td>
		@else
			<td colspan="8">
				Specific Training(JRC)
			</td>
			<td colspan="6">-----</td>
			<td colspan="6">-----</td>
			<td colspan="6">-----</td>
			<td colspan="6">-----</td>
		@endif
	</tr>

	<tr>
		@if(isset($applicant->rank) && ($jr || $applicant->rank->category != "DECK OFFICER"))
			<td colspan="8">
				Specific Training(FURUNO)
			</td>
			<td colspan="6">-----</td>
			<td colspan="6">-----</td>
			<td colspan="6">-----</td>
			<td colspan="6">-----</td>
		@else
			<td colspan="8">
				Specific Training({{ $name }})
			</td>
			<td colspan="6">{{ $docu ? $docu->no : "-----"}}</td>
			<td colspan="6">{{ $docu ? $checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td colspan="6">{{ $docu ? $checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="6">{{ $docu ? $docu->issuer : "-----" }}</td>
		@endif
	</tr>
	
	@php 
		$name = "ECDIS";
		$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
	@endphp

	<tr>
		<td colspan="8">Generic Training</td>
		<td colspan="6">{{ $docu ? $docu->no : "-----"}}</td>
		<td colspan="6">{{ $docu ? $checkDate2($docu->issue_date, "I") : "-----" }}</td>
		<td colspan="6">{{ $docu ? $checkDate2($docu->expiry_date, "E") : "-----" }}</td>
		<td colspan="6">{{ $docu ? $docu->issuer : "-----" }}</td>
	</tr>

	{{-- CATERING --}}
	@php
		$docu = false;
		$name = "CATERING";

		foreach($applicant->document_lc as $document){
		    if(str_contains($document->type, $name)){
		    	$docu = $document;
		    }
		}
	@endphp

	<tr>
		<td rowspan="3" colspan="2">Catering</td>
		<td colspan="8">Catering Training</td>
		<td colspan="6">{{ $docu ? $docu->no : "-----"}}</td>
		<td colspan="6">{{ $docu ? $checkDate2($docu->issue_date, "I") : "-----" }}</td>
		<td colspan="6">{{ $docu ? $checkDate2($docu->expiry_date, "E") : "-----" }}</td>
		<td colspan="6">{{ $docu ? $docu->issuer : "-----" }}</td>
	</tr>

	@php
		$name = "NCI";
		$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
	@endphp

	<tr>
		<td colspan="8">National Certificate I</td>
		<td colspan="6">{{ $docu ? $docu->no : "-----"}}</td>
		<td colspan="6">{{ $docu ? $checkDate2($docu->issue_date, "I") : "-----" }}</td>
		<td colspan="6">{{ $docu ? $checkDate2($docu->expiry_date, "E") : "-----" }}</td>
		<td colspan="6">{{ $docu ? $docu->issuer : "-----" }}</td>
	</tr>
	
	@php 
		$name = "NCIII";
		$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
	@endphp

	<tr>
		<td colspan="8">National Certificate III</td>
		<td colspan="6">{{ $docu ? $docu->no : "-----"}}</td>
		<td colspan="6">{{ $docu ? $checkDate2($docu->issue_date, "I") : "-----" }}</td>
		<td colspan="6">{{ $docu ? $checkDate2($docu->expiry_date, "E") : "-----" }}</td>
		<td colspan="6">{{ $docu ? $docu->issuer : "-----" }}</td>
	</tr>

	{{ $getDocument("SAFETY OFFICER'S TRAINING COURSE", 'lc', 'for C/E, C/O', 'Safety Officer')}}
	{{ $getDocument("HIGH VOLTAGE TRAINING", 'lc', 'over 3,000 volt', 'High Voltage Training')}}

	{{-- REMOVE DAW SABI NI MA'AM JOSA 2/27/20 --}}
	{{-- {{ $getDocument("EMS TRAINING CERTIFICATE", 'lc', '', 'EMS Training Certificate')}}
	{{ $getDocument("NEW ENGINE ROOM MACHINERY - WESTERN", 'lc', '', 'Trainings for New Type Engine Room Machinery for New Vessels')}} --}}

	{{-- FILLERS --}}
	{{ $getDocument("", 'lc', '-----', '')}}
	{{ $getDocument("", 'lc', '-----', '')}}
	{{ $getDocument("", 'lc', '-----', '')}}
	{{ $getDocument("", 'lc', '-----', '')}}
	{{ $getDocument("", 'lc', '-----', '')}}
	{{ $getDocument("", 'lc', '-----', '')}}
	{{ $getDocument("", 'lc', '-----', '')}}

	{{-- MEDS --}}
	{{ addS('5. PHYSICAL INSPECTION / YELLOW CARD') }}

	<tr>
		<td colspan="10">Certificate</td>
		<td colspan="6">Number</td>
		<td colspan="6">Date Issued</td>
		<td colspan="6">Expiry Date</td>
		<td colspan="6">Remarks</td>
	</tr>

	{{ $getDocument('MEDICAL CERTIFICATE', 'med_cert', '', 'Physical Inspection')}}
	{{ $getDocument('YELLOW FEVER', 'med_cert', '', 'Yellow Fever')}}
	{{ $getDocument('POLIO VACCINE (IPV)', 'med_cert', '', 'POLIO VACCINE')}}

	<tr>
		<td colspan="7" rowspan="2">Covid Vaccine Certificate</td>
		{{ $getDocument('COVID-19 1ST DOSE', 'med_cert', '', '1st Dose')}}
	</tr>
	<tr>
		{{ $getDocument('COVID-19 2ND DOSE', 'med_cert', '', '2nd Dose')}}
	</tr>
	<tr>
		<td colspan="7" rowspan="2" style="font-weight: bold;">Covid Vaccine Booster</td>
		{{ $getDocument('COVID-19 3RD DOSE', 'med_cert', '', '1st Dose')}}
	</tr>
	<tr>
		{{ $getDocument('COVID-19 4TH DOSE', 'med_cert', '', '2nd Dose')}}
	</tr>
	
	{{-- LINGUISTIC --}}
	{{ addS('6. LINGUISTIC') }}

	<tr>
		<td colspan="6">English</td>
		<td colspan="22">Class</td>
		<td colspan="6">Evaluation</td>
	</tr>

	<tr>
		<td colspan="6">Read and Write</td>
		<td colspan="22">Good / Acceptable / Poor</td>
		<td colspan="6">GOOD</td>
	</tr>

	<tr>
		<td colspan="6">Speak and Listen</td>
		<td colspan="22">Good / Acceptable / Poor</td>
		<td colspan="6">GOOD</td>
	</tr>

	<tr>
		<td colspan="6">Japanese</td>
		<td colspan="22">Class</td>
		<td colspan="6">Evaluation</td>
	</tr>

	<tr>
		<td colspan="6">Read and Write</td>
		<td colspan="22">Good / Acceptable / Poor</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="6">Speak and Listen</td>
		<td colspan="22">Good / Acceptable / Poor</td>
		<td colspan="6"></td>
	</tr>

	{{ addS('7. TRAINING / EXPERIENCE FOR SAFETY AND MANAGEMENT SYSTEM') }}

	<tr>
		<td colspan="11">Type</td>
		<td colspan="11">Date</td>
		<td colspan="6">Period</td>
		<td colspan="6">Evaluation</td>
	</tr>

	@php 
		$name = "ECDIS";
		$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
	@endphp
	<tr>
		<td colspan="11">Training for SMS</td>
		<td colspan="11"></td>
		<td colspan="6"></td>
		<td colspan="6"></td>
	</tr>
	
	<tr>
		<td colspan="11">Experience for SMS</td>
		<td colspan="11"></td>
		<td colspan="6"></td>
		<td colspan="6"></td>
	</tr>
	
	<tr>
		<td colspan="11">Experience for SMS (System of Others)</td>
		<td colspan="11"></td>
		<td colspan="6"></td>
		<td colspan="6"></td>
	</tr>

	{{ addS('8. Ability of Welding') }}

	<tr>
		<td rowspan="2" colspan="6">Welding</td>
		<td colspan="22">Class</td>
		<td colspan="6">Evaluation</td>
	</tr>

	<tr>
		<td colspan="22">Good / Acceptable / Poor</td>
		<td colspan="6"></td>
	</tr>

	{{ addS('9. Evaluation by previous company') }}

	<tr>
		<td colspan="14">Professional/Technical knowledge</td>
		<td colspan="14">Good / Acceptable / Poor</td>
		<td colspan="6">GOOD</td>
	</tr>

	<tr>
		<td colspan="14">English Language Ability</td>
		<td colspan="14">Good / Acceptable / Poor</td>
		<td colspan="6">GOOD</td>
	</tr>

	<tr>
		<td colspan="14">Attitude</td>
		<td colspan="14">Good / Acceptable / Poor</td>
		<td colspan="6">GOOD</td>
	</tr>

	<tr>
		<td colspan="14">Sense of Responsibility</td>
		<td colspan="14">Good / Acceptable / Poor</td>
		<td colspan="6">GOOD</td>
	</tr>

	<tr>
		<td colspan="14">General Health</td>
		<td colspan="14">Good / Acceptable / Poor</td>
		<td colspan="6">GOOD</td>
	</tr>

	{{ addS("10. SEAMAN'S HISTORY") }}

	<tr>
		<td colspan="6">Vessel's Name</td>
		<td colspan="4">Type</td>
		<td colspan="6">Gross Tonnage</td>
		<td rowspan="2" colspan="6">Manning Agent</td>
		<td colspan="6">Sign On</td>
		<td rowspan="2" colspan="6">Sign off Reason</td>
	</tr>

	<tr>
		<td colspan="6">Flag</td>
		<td colspan="4">Rank</td>
		<td colspan="6">Engine Type/KW</td>
		<td colspan="6">Sign off</td>
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

	{{ addS('11. Remark') }}

	<tr>
		<td rowspan="3" colspan="34"></td>
	</tr>

	{{ addS('') }}
	{{ addS('') }}
	{{ addS('') }}

	<tr>
		<td colspan="10">Manning Company:</td>
		<td colspan="14">SOLPIA MARINE AND SHIP MANAGEMENT INC.</td>
		<td colspan="10"></td>
	</tr>

	{{ addS('') }}

	<tr>
		<td colspan="7">Managing Director:</td>
		<td colspan="8"></td>
		<td colspan="7">Crew's Name:</td>
		<td colspan="9">{{ $applicant->user->lname . ', ' . $applicant->user->fname . ' ' . $applicant->user->suffix . ' ' . $applicant->user->mname }}</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="27"></td>
		<td colspan="7">Revised by 2023.04.26</td>
	</tr>
</table>