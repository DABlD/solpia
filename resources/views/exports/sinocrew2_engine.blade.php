@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b$c";

	$checkDate2 = function($date, $type = null){
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
			return $date->format('d/M/Y');
		}
	};

	$cleanText = function($text){
		return str_replace('&', '&#38;', $text);
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

	$doc = function($docu, $type, $issuer = null, $name = null, $regulation = null) use ($data, $checkDate2, $rank, $cleanText, $c) {
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
				elseif($temp == "POLLUTION"){
					foreach(get_object_vars($data->document_lc) as $document){
					    if(str_contains($document->type, $temp)){
					        $docu = $document;
					    }
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
			    if($document->type == $temp){
			        $docu = $document;
			    }
			}
		}

		$noNum  = $type == 'lc' ? 'no' : 'number';

		$number = $docu ? $docu->$noNum : '-----';
		$issue  = $docu ? $checkDate2($docu->issue_date, 'I') : '-----';
		$expiry = $docu ? $checkDate2($docu->expiry_date, 'E') : '-----';

		$issuer = $issuer ?? 'NOT APPLICABLE';

		echo "
			<tr>
				<td colspan='3' style='$c height: 30px;'>$name</td>
				<td style='$c height: 30px;'>PH</td>
				<td colspan='2' style='$c height: 30px;'>$number</td>
				<td colspan='2' style='$c height: 30px;'>$issue</td>
				<td colspan='2' style='$c height: 30px;'>$expiry</td>
			</tr>
		";
	};

	$ss = function($ss) use ($cleanText, $checkDate2, $c, $data){
		$name = $cleanText($ss->vessel_name);
		$rank = isset($ss->rank) ? $data->ranks[$ss->rank] : "---";
		$eng = $cleanText($ss->engine_type);
		$bhp = $cleanText($ss->bhp_kw);
		$owners = $cleanText($ss->owners);
		$from = $checkDate2($ss->sign_on);
		$to = $checkDate2($ss->sign_off);

		if($ss){
			echo "
				<tr>
					<td style='{{ $c }} height: 50px;'>$name</td>
					<td style='{{ $c }} height: 50px;'>$rank</td>
					<td style='{{ $c }} height: 50px;'>$eng</td>
					<td style='{{ $c }} height: 50px;' colspan='2'>$bhp</td>
					<td style='{{ $c }} height: 50px;' colspan='2'>$owners</td>
					<td style='{{ $c }} height: 50px;' colspan='2'>$from</td>
					<td style='{{ $c }} height: 50px;'>$to</td>
				</tr>
			";
		}
		else{
			echo "
				<tr>
					<td style='{{ $c }} height: 50px;'></td>
					<td style='{{ $c }} height: 50px;'></td>
					<td style='{{ $c }} height: 50px;'></td>
					<td style='{{ $c }} height: 50px;' colspan='2'></td>
					<td style='{{ $c }} height: 50px;' colspan='2'></td>
					<td style='{{ $c }} height: 50px;' colspan='2'></td>
					<td style='{{ $c }} height: 50px;'></td>
				</tr>
			";
		}
	};
	// dd($data);
@endphp

<table>
	<tr>
		<td colspan="9" style="height: 70px;"></td>
		<td style="height: 70px;"></td>
	</tr>

	<tr>
		<td colspan="10" style="{{ $bc }}">CURRICULUM VITAE</td>
	</tr>

	<tr style="height: 40px;">
		<td>RANK</td>
		<td style="text-align: right;">:</td>
		<td colspan="2">{{ $data->rank->name }}</td>

		<td colspan="2">AVAILABLE FROM</td>
		<td style="text-align: right;">:</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td>SURNAME</td>
		<td style="text-align: right;">:</td>
		<td colspan="2">{{ $data->user->lname }}</td>

		<td colspan="2">GIVEN NAME(S)</td>
		<td style="text-align: right;">:</td>
		<td colspan="3">{{ $data->user->fname }}</td>
	</tr>

	@php
		$sb = null;
		$pp = null;

		foreach($data->document_id as $docu){
			if($docu->type == "PASSPORT"){
				$pp = $docu;
			}
			elseif($docu->type == "SEAMAN'S BOOK"){
				$sb = $docu;
			}
		}
	@endphp

	<tr>
		<td>NATIONALITY</td>
		<td style="text-align: right;">:</td>
		<td colspan="2">FILIPINO</td>

		<td colspan="2">SEAMAN BOOK</td>
		<td style="text-align: right;">:</td>
		<td colspan="3">{{ $sb ? $sb->number : "---" }}</td>
	</tr>

	<tr>
		<td>DATE OF BIRTH</td>
		<td style="text-align: right;">:</td>
		<td colspan="2">{{ isset($data->user->birthday) ? $data->user->birthday->format('d/M/Y') : "---" }}</td>

		<td colspan="2">AGE</td>
		<td style="text-align: right;">:</td>
		<td colspan="3">{{ isset($data->user->birthday) ? $data->user->birthday->age : "---" }}</td>
	</tr>

	<tr>
		<td>PLACE OF BIRTH</td>
		<td style="text-align: right;">:</td>
		<td colspan="2">{{ $data->birth_place }}</td>

		<td colspan="2">PHONE</td>
		<td style="text-align: right;">:</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td>ADDRESS</td>
		<td style="text-align: right;">:</td>
		<td colspan="8">{{ $data->user->address }}</td>
	</tr>

	<tr>
		<td>MOBILE PHONE</td>
		<td style="text-align: right;">:</td>
		<td colspan="2">{{ $data->user->contact }}</td>

		<td colspan="2">E-MAIL</td>
		<td style="text-align: right;">:</td>
		<td colspan="3">{{ $data->user->email }}</td>
	</tr>

	<tr style="height: 40px;">
		<td>NEAREST AIRPORT</td>
		<td style="text-align: right;">:</td>
		<td colspan="2"></td>

		<td colspan="2">CIVIL STATUS</td>
		<td style="text-align: right;">:</td>
		<td colspan="3">{{ $data->civil_status }}</td>
	</tr>

	@php
		$nok = null;
		$temps = ['Spouse', 'Son', 'Daughter', 'Father', 'Mother'];
		$childrens = 0;

		foreach($temps as $key => $temp){
			foreach($data->family_data as $fd){
				if(($fd->type == "Son" || $fd->type == "Daughter") && $key == 0){
					$childrens++;
				}

				if($fd->type == $temp && $fd->fname != "" && $nok == null){
					$nok = $fd;
					break;
				}
			}
		}
	@endphp

	<tr>
		<td>NEXT OF KIN</td>
		<td style="text-align: right;">:</td>
		<td colspan="2">{{ $nok->lname }}, {{ $nok->fname }} {{ $nok->suffix }} {{ $nok->mname }}</td>

		<td colspan="2">RELATIONSHIP</td>
		<td style="text-align: right;">:</td>
		<td colspan="3">{{ $nok->type }}</td>
	</tr>

	<tr>
		<td>DATE OF BIRTH</td>
		<td style="text-align: right;">:</td>
		<td colspan="2">{{ isset($nok->birthday) ? $nok->birthday->format('d/M/Y') : "---" }}</td>

		<td colspan="2">PLACE OF BIRTH</td>
		<td style="text-align: right;">:</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td>ADDRESS</td>
		<td style="text-align: right;">:</td>
		<td colspan="8">{{ $nok->address }}</td>
	</tr>

	<tr>
		<td>PHONE</td>
		<td style="text-align: right;">:</td>
		<td colspan="2">{{ $nok->contact }}</td>

		<td colspan="2">E-MAIL</td>
		<td style="text-align: right;">:</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="10" style="{{ $bc }}">RECORDS OF SEA SERVICE</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">VESSEL'S NAME</td>
		<td style="{{ $bc }}">RANK</td>
		<td style="{{ $bc }}">MAIN ENGINE</td>
		<td colspan="2" style="{{ $bc }}">ME OUTPUT</td>
		<td colspan="2" style="{{ $bc }}">CREW OWNERS</td>
		<td colspan="2" style="{{ $bc }}">FROM</td>
		<td style="{{ $bc }}">TO</td>
	</tr>

	{{ isset($data->sea_service[0]) ? $ss($data->sea_service[0]) : $ss(false) }}
	{{ isset($data->sea_service[1]) ? $ss($data->sea_service[1]) : $ss(false) }}
	{{ isset($data->sea_service[2]) ? $ss($data->sea_service[2]) : $ss(false) }}
	{{ isset($data->sea_service[3]) ? $ss($data->sea_service[3]) : $ss(false) }}
	{{ isset($data->sea_service[4]) ? $ss($data->sea_service[4]) : $ss(false) }}

	<tr>
		<td colspan="10" style="height: 30px;">
			The Seaman's command of the English language has been evaluated as compliant with the STCW'10 and
		</td>
	</tr>

	<tr>
		<td colspan="10">
			Company's requirements.
		</td>
	</tr>

	<tr>
		<td colspan="10">
			1) - Single, Married, Separated, Divorced or Widowed
		</td>
	</tr>

	<tr>
		<td colspan="10">
			2) - Vessel Type and Gross Tonnage for deck crew; Main Engine Type and output in kW for engine crew
		</td>
	</tr>

	<tr>
		<td colspan="10" style="height: 105px;"></td>
	</tr>

	<tr>
		<td colspan="10" style="height: 30px; {{ $bc }}">NATIONAL DOCUMENTS</td>
	</tr>

	<tr>
		<td colspan="10" style="height: 30px;">
			Name: {{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $c }} height: 30px;">Document</td>
		<td style="{{ $c }} height: 30px;">Issuing Country</td>
		<td colspan="2" style="{{ $c }} height: 30px;">Number</td>
		<td colspan="2" style="{{ $c }} height: 30px;">Date of Issue</td>
		<td colspan="2" style="{{ $c }} height: 30px;">Date of Expiry</td>
	</tr>

	{{ $doc('COC', 					'lc',		'MARINA', 		"Certificate Of Competency (" . $data->rank->abbr . ")"									)}}
	{{ $doc('BASIC TRAINING', 		'lc',		'MARINA', 		'Basic Training (Reg VI/1 + A-VI/1-2)'													)}}

	@php
		$temp = "PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB";
	@endphp
	{{ $doc($temp,			 		'lc',		'MARINA', 		'Proficiency in Survival Craft And Rescue Boats (Reg VI/2 + A-VI/2) '					)}}

	@php
		$temp = "SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD";
	@endphp
	{{ $doc($temp,			 		'lc',		'MARINA', 		'Seafarers with Designated Security Duties (Reg VI/6-2)  '								)}}

	@php
		$temp = "SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD";
	@endphp
	{{ $doc($temp,			 		'lc',		'MARINA', 		'Security Awareness Training (Reg VI/6+A-VI/6)   '										)}}

	{{ $doc('ADVANCE FIRE FIGHTING - AFF', 		'lc',		'MARINA', 		'Training in Advanced Fire-fighting (Reg VI/3 + A-VI/3) '					)}}
	{{ $doc('MEDICAL FIRST AID - MEFA', 		'lc',		'MARINA', 		'Training in Medical First Aid (Reg VI/4-2 + A-VI/4-2)  '					)}}
	{{ $doc('MEDICAL CERTIFICATE', 				'med_cert',	null,	 		'Medical Certificate For Seafarers Of The People’s Republic Of China  '		)}}
	{{ $doc("SEAMAN'S BOOK", 					'id',		null,			'Seaman Book'																)}}
	{{ $doc("SEAMAN'S BOOK", 					'id',		null,			'Seaman Record Book'														)}}
	{{ $doc("PASSPORT",		 					'id',		null,			'Yellow Fever'																)}}
	{{ $doc("YELLOW FEVER",		 				'med_cert',	null,			'Passport'																	)}}
	{{ $doc("CHOLERA",			 				'med_cert',	null,			'Cholera'																	)}}

	<tr><td colspan="10" style="height: 30px;"></td></tr>

	<tr>
		<td colspan="10" style="{{ $bc }} height: 30px;">FOREIGN FLAGSTATE DOCUMENTS</td>
	</tr>

	<tr>
		<td colspan="10" style="height: 30px;">Name: {{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $c }} height: 30px;">Document</td>
		<td style="{{ $c }} height: 30px;">Issuing Country</td>
		<td colspan="2" style="{{ $c }} height: 30px;">Number</td>
		<td colspan="2" style="{{ $c }} height: 30px;">Date of Issue</td>
		<td colspan="2" style="{{ $c }} height: 30px;">Date of Expiry</td>
	</tr>

	@foreach($data->document_flag as $docu)
		@if($docu->number != "")
			<tr>
				<td colspan="3" style="{{ $c }} height: 30px;">{{ $docu->type }}</td>
				<td style="{{ $c }} height: 30px;">{{ $docu->country }}</td>
				<td colspan="2" style="{{ $c }} height: 30px;">{{ $docu->number != "" ? $docu->number : "" }}</td>
				<td colspan="2" style="{{ $c }} height: 30px;">{{ $docu->number != "" ? $checkDate2($docu->issue_date, 'I') : '-----' }}</td>
				<td colspan="2" style="{{ $c }} height: 30px;">{{ $docu->number != "" ? $checkDate2($docu->expiry_date, 'E') : '-----' }}</td>
			</tr>
		@endif
	@endforeach

	<tr>
		<td colspan="10" style="height: 40px;">
			The Seaman, as a condition of Employment, has acknowledged the obligation to adhere to the Vessel's Drug and Alcohol Policy, as implemented onboard.
		</td>
	</tr>
</table>