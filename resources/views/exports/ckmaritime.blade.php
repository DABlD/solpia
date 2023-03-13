@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";

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
			return $date->format('d/m/Y');
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

	$doc = function($docu, $type, $issuer = null, $name = null, $regulation = null) use ($data, $checkDate2, $rank, $cleanText, $bc, $b) {
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
								<td colspan='5' style='$bc'>$name</td>
								<td colspan='3' style='$bc'>$number</td>
								<td colspan='2' style='$bc'>$issue</td>
								<td colspan='2' style='$bc'>$expiry</td>
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
			elseif($docu == "WATCHKEEPING"){
				$temp = $docu;
				$docu = isset($data->{'document_' . $type}->{$docu}) ? $data->{'document_' . $type}->{$docu} : null;

				if(!$docu){
					$doc = "DECK WATCHKEEPING";
					$docu = isset($data->{'document_' . $type}->{$docu}) ? $data->{'document_' . $type}->{$docu} : null;
				}

				if(!$docu){
					$doc = "DECK WATCH";
					$docu = isset($data->{'document_' . $type}->{$docu}) ? $data->{'document_' . $type}->{$docu} : null;
				}

				if(!$docu){
					$doc = "ENGINE WATCHKEEPING";
					$docu = isset($data->{'document_' . $type}->{$docu}) ? $data->{'document_' . $type}->{$docu} : null;
				}

				if(!$docu){
					$doc = "ENGINE WATCH";
					$docu = isset($data->{'document_' . $type}->{$docu}) ? $data->{'document_' . $type}->{$docu} : null;
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

		$number = $docu ? $docu->$noNum : '';
		$issue  = $docu ? $checkDate2($docu->issue_date, 'I') : '';
		$expiry = $docu ? $checkDate2($docu->expiry_date, 'E') : '';

		$issuer = $issuer ?? 'NOT APPLICABLE';

		$name = $cleanText($name);
		
		echo "
			<tr>
				<td colspan='5' style='$b'>$name</td>
				<td colspan='3' style='$bc'>$number</td>
				<td colspan='2' style='$bc'>$issue</td>
				<td colspan='2' style='$bc'>$expiry</td>
			</tr>
		";
	};
@endphp

<table>
	<tr>
		<td colspan="12" style="{{ $bc }} height: 40px; font-size: 15px;">BIO-DATA</td>
	</tr>
	<tr>
		<td rowspan="9"></td>
		<td colspan="7"></td>
		<td style="{{ $bc }}">Nationality:</td>
		<td colspan="3" style="{{ $c }}">FILIPINO</td>
	</tr>
	<tr>
		<td colspan="7"></td>
		<td style="{{ $bc }}">Vessel Name:</td>
		<td colspan="3" style="{{ $c }}">{{ $data->vessel ? $data->vessel->name : "---" }}</td>
	</tr>
	<tr>
		<td colspan="7"></td>
		<td style="{{ $bc }}">Rank:</td>
		<td colspan="3" style="{{ $c }}">{{ $data->rank ? $data->rank->abbr : "---" }}</td>
	</tr>
	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td style="{{ $b }}">NAME:(English)</td>
		<td colspan="3">{{ $data->user->namefull }}</td>
		<td colspan="4" style="{{ $bc }}">NAME:(Korea)</td>
		<td colspan="3" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td style="{{ $bc }}">AGE:</td>
		<td colspan="2" style="{{ $c }}">
			{{ $data->user->birthday ? $data->user->birthday->age : "---" }}
		</td>
		<td style="{{ $bc }}">BIRTH DATE:</td>
		<td colspan="3" style="{{ $c }}">
			{{ $data->user->birthday ? $data->user->birthday->format("d/m/Y") : "---" }}
		</td>
		<td style="{{ $bc }}">BIRTH PLACE:</td>
		<td colspan="3" style="{{ $c }}">{{ $data->birth_place ?? "---" }}</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">ADD.:</td>
		<td colspan="6" style="{{ $c }}">{{ $data->user->address ?? "---" }}</td>
		<td style="{{ $bc }}">TEL.:</td>
		<td colspan="3" style="{{ $c }}">{{ $data->user->contact ?? "---" }}</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">HEIGHT:</td>
		<td style="{{ $c }}">{{ $data->height ?? "-" }} cm</td>
		<td style="{{ $bc }}">WEIGHT:</td>
		<td style="{{ $c }}">{{ $data->weight ?? "-" }}</td>
		<td style="{{ $c }}">Kg</td>
		<td style="{{ $bc }}">BLOOD:</td>
		<td style="{{ $c }}">{{ $data->blood_type ?? "-" }}</td>
		<td style="{{ $bc }}">SHOES SIZE:</td>
		<td style="{{ $c }}">{{ $data->shoe_size ? $data->shoe_size * 10 : "-" }} mm</td>
		<td style="{{ $bc }}">CLOTHES SIZE:</td>
		<td style="{{ $c }}">{{ $data->clothes_size ?? "-" }}</td>
	</tr>

	@php
		$nok = null;
		foreach($data->family_data as $fd){
			if($fd->type == "Spouse"){
				$nok = $fd;
				break;
			}
		}

		if(!$nok){
			foreach($data->family_data as $fd){
				if($fd->type == "Father" || $fd->type == "Mother"){
					$nok = $fd;
					break;
				}
			}
		}

		if(!$nok){
			foreach($data->family_data as $fd){
				if($fd->type == "Son" || $fd->type == "Daughter"){
					$nok = $fd;
					break;
				}
			}
		}
	@endphp

	<tr>
		<td style="{{ $bc }}">CIVIL STATUS:</td>
		<td colspan="2" style="{{ $c }}">{{ $data->civil_status ?? "-" }}</td>
		<td colspan="4" style="{{ $bc }}">EMERGENCY CONTACT(WIFE OR NEAREST RELATIVE):</td>
		<td colspan="4" style="{{ $bc }}">
			{{ $nok->namefull ?? "-" }}/{{ $nok->email ?? "-" }} ({{ $nok->type }})
		</td>
	</tr>

	<tr>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td colspan="12">1. EDUCATIONAL ATTAINMENT</td>
	</tr>

	@php
		$educ = null;

		foreach($data->educational_background as $eb){
			if($eb->type == "College"){
				$educ = $eb;
				break;
			}
		}

		if(!$educ){
			foreach($data->educational_background as $eb){
				if($eb->type == "Vocational"){
					$educ = $eb;
					break;
				}
			}
		}

		if(!$educ){
			foreach($data->educational_background as $eb){
				if($eb->type == "Undergraduate"){
					$educ = $eb;
					break;
				}
			}
		}
	@endphp

	<tr>
		<td style="{{ $bc }}">YEAR</td>
		<td colspan="7" style="{{ $bc }}">SCHOOL</td>
		<td colspan="4" style="{{ $bc }}">COURSE FINISHED</td>
	</tr>

	<tr>
		<td style="{{ $c }}">{{ $educ ? $educ->year : "-" }}</td>
		<td colspan="7" style="{{ $c }}">{{ $educ ? $educ->school : "-" }}</td>
		<td colspan="4" style="{{ $c }}">{{ $educ ? $educ->course : "-" }}</td>
	</tr>

	<tr>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td colspan="12">2. LICENSE</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">COUNTRY</td>
		<td style="{{ $bc }}">KIND</td>
		<td style="{{ $bc }}">RANK</td>
		<td colspan="2" style="{{ $bc }}">NUMBER</td>
		<td colspan="3" style="{{ $bc }}">DATE OF ISSUE</td>
		<td colspan="2" style="{{ $bc }}">DATE OF EXPIRY</td>
		<td colspan="2" style="{{ $bc }}">REMARK</td>
	</tr>

	@php
		$coc = isset($data->document_lc->COC) ? $data->document_lc->COC : null;
		$goc = isset($data->document_lc->{"GMDSS/GOC"}) ? $data->document_lc->{"GMDSS/GOC"} : null;
	@endphp

	<tr>
		<td rowspan="2" style="{{ $bc }}">PHILIPPINES</td>
		<td style="{{ $bc }}">COC</td>
		<td style="{{ $bc }}">{{ $coc ? $data->rank->abbr : "" }}</td>
		<td colspan="2" style="{{ $bc }}">
			{{ $coc ? $coc->no : "" }}
		</td>
		<td colspan="3" style="{{ $bc }}">
			{{ $coc ? $coc->issue_date ? $coc->issue_date->format("m/d/Y") : "" : "" }}
		</td>
		<td colspan="2" style="{{ $bc }}">
			{{ $coc ? $coc->expiry_date ? $coc->expiry_date->format("m/d/Y") : "" : "" }}
		</td>
		<td colspan="2" style="{{ $bc }}">CHECKED</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">GOC</td>
		<td style="{{ $bc }}">{{ $goc ? $data->rank->abbr : "" }}</td>
		<td colspan="2" style="{{ $bc }}">
			{{ $goc ? $goc->no : "" }}
		</td>
		<td colspan="3" style="{{ $bc }}">
			{{ $goc ? $goc->issue_date ? $goc->issue_date->format("m/d/Y") : "" : "" }}
		</td>
		<td colspan="2" style="{{ $bc }}">
			{{ $goc ? $goc->expiry_date ? $goc->expiry_date->format("m/d/Y") : "" : "" }}
		</td>
		<td colspan="2" style="{{ $bc }}">CHECKED</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $bc }}">KOREA</td>
		<td style="{{ $bc }}"></td>
		<td style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
		<td colspan="3" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td style="{{ $bc }}"></td>
		<td style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
		<td colspan="3" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $bc }}">MARSHALL</td>
		<td style="{{ $bc }}"></td>
		<td style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
		<td colspan="3" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td style="{{ $bc }}"></td>
		<td style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
		<td colspan="3" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td colspan="12">3. CERTIFICATES</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $bc }}">TYPE</td>
		<td colspan="3" style="{{ $bc }}">NUMBER</td>
		<td colspan="3" style="{{ $bc }}">DATE OF ISSUE</td>
		<td colspan="2" style="{{ $bc }}">DATE OF EXPIRY</td>
		<td colspan="2" style="{{ $bc }}">REMARK</td>
	</tr>

	@php
		$sb = $data->document_id->{"SEAMAN'S BOOK"} ?? null;
		$pp = $data->document_id->{"PASSPORT"} ?? null;
	@endphp

	<tr>
		<td style="{{ $bc }}">SEAMAN'S BOOK</td>
		<td style="{{ $bc }}">OWN</td>
		<td colspan="3" style="{{ $bc }}">
			{{ $sb ? $sb->number : "" }}
		</td>
		<td colspan="3" style="{{ $bc }}">
			{{ $sb ? $sb->issue_date ? $sb->issue_date->format("d/m/Y") : "" : "" }}
		</td>
		<td colspan="2" style="{{ $bc }}">
			{{ $sb ? $sb->expiry_date ? $sb->expiry_date->format("d/m/Y") : "" : "" }}
		</td>
		<td colspan="2" style="{{ $bc }}">CHECKED</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">SEAMAN'S BOOK</td>
		<td style="{{ $bc }}">PANAMA</td>
		<td colspan="3" style="{{ $bc }}"></td>
		<td colspan="3" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td style="{{ $bc }}">SEAMAN'S BOOK</td>
		<td style="{{ $bc }}">MARSHALL</td>
		<td colspan="3" style="{{ $bc }}"></td>
		<td colspan="3" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td style="{{ $bc }}">PASSPORT</td>
		<td style="{{ $bc }}">OWN</td>
		<td colspan="3" style="{{ $bc }}">
			{{ $pp ? $pp->number : "" }}
		</td>
		<td colspan="3" style="{{ $bc }}">
			{{ $pp ? $pp->issue_date ? $pp->issue_date->format("d/m/Y") : "" : "" }}
		</td>
		<td colspan="2" style="{{ $bc }}">
			{{ $pp ? $pp->expiry_date ? $pp->expiry_date->format("d/m/Y") : "" : "" }}
		</td>
		<td colspan="2" style="{{ $bc }}">CHECKED</td>
	</tr>

	<tr>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td colspan="12">4. VISA</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }}">TYPE</td>
		<td colspan="3" style="{{ $bc }}">NUMBER</td>
		<td colspan="2" style="{{ $bc }}">DATE OF EXPIRY</td>
		<td colspan="2" style="{{ $bc }}">REMARK</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }}"></td>
		<td colspan="3" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }}"></td>
		<td colspan="3" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }}"></td>
		<td colspan="3" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td colspan="12">5. OTHER CERTIFICATES (SOLAS/MARPOL/TRANKER/OTHERS)</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }}">NAME</td>
		<td colspan="3" style="{{ $bc }}">NUMBER</td>
		<td colspan="2" style="{{ $bc }}">DATE OF ISSUE</td>
		<td colspan="2" style="{{ $bc }}">DATE OF EXPIRY</td>
	</tr>

	{{ $doc('BASIC TRAINING - BT', 		'lc', 		null,	'기초안전교육 SFTBT(BST)')}}

	@php
		$a = isset($data->document_lc->{"ADVANCE FIRE FIGHTING - AFF"}) ? $data->document_lc->{"ADVANCE FIRE FIGHTING - AFF"} : null;
		$b = isset($data->document_lc->{"PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB"}) ? $data->document_lc->{"PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB"} : null;
		$c = isset($data->document_lc->{"MEDICAL FIRST AID - MEFA"}) ? $data->document_lc->{"MEDICAL FIRST AID - MEFA"} : null;

		$dok = null;
		if(isset($a)){
			$dok = $a;
		}

		if(isset($b)){
			if(isset($a)){
				if($b->expiry_date < $a->expiry_date){
					$dok = $b;
				}
			}
			else{
				$dok = $b;
			}
		}
		elseif(isset($c)){
			if(isset($dok)){
				if($c->expiry_date < $dok->expiry_date){
					$dok = $c;
				}
			}
			else{
				$dok = $c;
			}
		}
	@endphp

	<tr>
		<td colspan="5" style="{{ $b }}">상급안전교육 AFFT, PSCRB, MFA</td>
		<td colspan="3" style="{{ $bc }}">{{ $dok ? $dok->no : "" }}</td>
		<td colspan="2" style="{{ $bc }}">{{ $dok ? $dok->issue_date ? $dok->issue_date->format("d/m/Y") : "" : "" }}</td>
		<td colspan="2" style="{{ $bc }}">{{ $dok ? $dok->expiry_date ? $dok->expiry_date->format("d/m/Y") : "" : "" }}</td>
	</tr>

	{{ $doc('BTOCT', 		'lc', 		null,	'유조선/케미컬 기초교육 BTOC')}}
	{{ $doc('BTLGT', 		'lc', 		null,	'액화가스 기초교육 BTLGT')}}
	{{ $doc('AOT', 			'lc', 		null,	'유조선 직무교육 AOT')}}
	{{ $doc('ACT', 			'lc', 		null,	'케미컬 직무교육 ACT')}}
	{{ $doc('ALGT',			'lc', 		null,	'액화가스 직무교육 ALGT')}}

	{{ $doc('SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD',			'lc', 		null,	'선박보안교육 SFSAT/SSO/SSD')}}

	{{ $doc('SSBT WITH BRM',			'lc', 		null,	'리더십&팀워크 Leadership&Teamwork')}}
	{{ $doc('FILL',			'lc', 		null,	'리더십&팀워크 리더십&관리기술 Leadership&Managerial Skill')}}
	{{ $doc('RADAR',		'lc', 		null,	'레이더시뮬레이션 ROSC')}}

	{{ $doc('ARPA TRAINING COURSE',		'lc', 		null,	'자동충돌 예방교육 ARPA')}}

	{{ $doc('ECDIS',		'lc', 		null,	'전자해도시스템교육 ECDIS Generic')}}
	{{ $doc('ECDIS JRC 901B',		'lc', 		null,	'전자해도TST교육 ECDIS JRC 901B')}}

	{{ $doc('FILL',			'lc', 		null,	'선박모의조종 SHS')}}
	{{ $doc('FILL',			'lc', 		null,	'원양선 직무교육 CTMC/CTCS')}}
	{{ $doc('FILL',			'lc', 		null,	'원양선 직무교육 CTMC/CTCS')}}
	{{ $doc('FILL',			'lc', 		null,	'오염방지관리인 MPPT (C/E)')}}
	{{ $doc('FILL',			'lc', 		null,	'유해액체관리인 MPPT (C/O)')}}
	{{ $doc('FILL',			'lc', 		null,	'선박안전관리자 Shipboard safety officer')}}

	{{ $doc('MEDICAL CARE - MECA',			'lc', 		null,	'의료관리자자격취득교육 Medical care training')}}
	{{ $doc('FILL',			'lc', 		null,	'해적피해예방교육 Pirate harm damage prevention')}}
	{{ $doc('FILL',			'lc', 		null,	'위험성평가&사고분석 Risk Ass.&Incident Inv.')}}
	{{ $doc('FILL',			'lc', 		null,	'선박평형수 관리교육 Ballast water management')}}
	{{ $doc('WATCHKEEPING',	'lc', 		null,	'당직부원 교육 Watch Keeping Education')}}
	{{ $doc('WELDING COURSE',	'lc', 		null,	'용접 기술교육 Welding cert')}}
	{{ $doc('FILL',			'lc', 		null,	'LIFTRAFT 검사자격증 Liferaft inspection cert')}}
	{{ $doc('FILL',			'lc', 		null,	'PMS 자격증서 PMS qualification cert (C/E)')}}
	{{ $doc('FILL',			'lc', 		null,	'교육훈련이수증 (학교) Completed course cert')}}
	{{ $doc('FILL',			'lc', 		null,	'교육훈련이수증 (연수원) Completed course cert')}}

	<tr>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td colspan="12">6. PHYSICAL INSPECTION, YELLOW CARD</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }}"></td>
		<td colspan="3" style="{{ $bc }}">DATE OF ISSUE</td>
		<td colspan="2" style="{{ $bc }}">DATE OF EXPIRY</td>
		<td colspan="2" style="{{ $bc }}">REMARK</td>
	</tr>

	@php
		$name = 'MEDICAL CERTIFICATE';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;
	@endphp
	<tr>
		<td colspan="5" style="{{ $bc }}">HEALTH CERTIFICATE</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->issue_date, 'I') : "" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : "" }}</td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	@php
		$name = 'PHYSICAL INSPECTION';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;
	@endphp
	<tr>
		<td colspan="5" style="{{ $bc }}">PHYSICAL INSPECTION</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->issue_date, 'I') : "" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	@php
		$name = 'DRUG AND ALCOHOL TEST';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;
	@endphp
	<tr>
		<td colspan="5" style="{{ $bc }}">DRUG/ALCOHOL</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->issue_date, 'I') : "" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	@php
		$name = 'BENZENE';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;
	@endphp
	<tr>
		<td colspan="5" style="{{ $bc }}">BENZENE</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->issue_date, 'I') : "" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	@php
		$name = 'CHOLERA';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;
	@endphp
	<tr>
		<td colspan="5" style="{{ $bc }}">CHOLERA</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->issue_date, 'I') : "" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	@php
		$name = 'YELLOW FEVER';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;
	@endphp
	<tr>
		<td colspan="5" style="{{ $bc }}">YELLOW FEVER</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->issue_date, 'I') : "" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	@php
		$name = 'POLIO VACCINE (IPV)';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;
	@endphp
	<tr>
		<td colspan="5" style="{{ $bc }}">POLIO VACCINE (IPV)</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->issue_date, 'I') : "" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	@php
		$name = 'COVID-19 1ST DOSE';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;
	@endphp
	<tr>
		<td colspan="5" style="{{ $bc }}">COVID-19 1ST DOSE</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->issue_date, 'I') : "" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	@php
		$name = 'COVID-19 2ND DOSE';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;
	@endphp
	<tr>
		<td colspan="5" style="{{ $bc }}">COVID-19 2ND DOSE</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->issue_date, 'I') : "" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	@php
		$name = 'COVID-19 3RD DOSE';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;
	@endphp
	<tr>
		<td colspan="5" style="{{ $bc }}">COVID-19 3RD DOSE</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->issue_date, 'I') : "" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td colspan="12">7. ENGLISH LINGUISTICS</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $bc }}"></td>
		<td colspan="3" style="{{ $bc }}">EVALUATION</td>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $bc }}">READING AND WRITING</td>
		<td colspan="3" style="{{ $c }}"></td>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $bc }}">SPEAKING AND LISTENING</td>
		<td colspan="3" style="{{ $c }}"></td>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td colspan="12">8. SEAMAN'S HISTORY</td>
	</tr>

	<tr>
		<td style="{{ $bc }} height: 40px;">VESSEL NAME / FLAG</td>
		<td style="{{ $bc }}">TYPE / RANK</td>
		<td style="{{ $bc }}">GROSS TONNAGE</td>
		<td colspan="2" style="{{ $bc }}">ENGINE TYPE / POWER</td>
		<td colspan="3" style="{{ $bc }}">MANNING CO.</td>
		<td colspan="2" style="{{ $bc }}">SIGN-ON / OFF</td>
		<td colspan="2" style="{{ $bc }}">REASON OF SIGN-OFF</td>
	</tr>

	@foreach($data->sea_service as $ss)
		<tr>
			<td style="{{ $c }}">{{ $ss->vessel_name }}</td>
			<td style="{{ $c }}">{{ $ss->vessel_type }}</td>
			<td rowspan="2" style="{{ $c }}">{{ $ss->gross_tonnage }}</td>
			<td colspan="2" style="{{ $c }}">{{ $ss->engine_type }}</td>
			<td rowspan="2" colspan="3" style="{{ $c }}">{{ $ss->manning_agent }}</td>
			<td colspan="2" style="{{ $c }}">{{ $ss->sign_on ? $ss->sign_on->format("m/d/Y") : "" }}</td>
			<td rowspan="2" colspan="2" style="{{ $c }}">{{ $ss->remarks }}</td>
		</tr>

		<tr>
			<td style="{{ $c }}">{{ $ss->flag }}</td>
			<td style="{{ $c }}">{{ $ss->rank }}</td>
			<td colspan="2" style="{{ $c }}">{{ $ss->bhp_kw }}</td>
			<td colspan="2" style="{{ $c }}">{{ $ss->sign_off ? $ss->sign_off->format("m/d/Y") : "" }}</td>
		</tr>
	@endforeach
</table>