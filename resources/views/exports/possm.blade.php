@php
	$checkDate2 = function($date, $type){
		if($date == "LIFETIME"){
			return $date;
		}
		elseif($date == "" || $date == null){
			if($type == "E"){
				return 'LIFETIME';
			}
			else{
				return '-----';
			}
		}
		else{
			return $date->format('d.M.Y');
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

	$rank_category = isset($data->rank) ? $data->rank->category : null;
	$total = 0;

	$getDocument = function($docu, $type, $name = null, $ctr) use ($data, $checkDate2, $rank) {

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

		$center = "style='text-align: center;'";

		if($number != '-----'){
			$issuer = $name ?? $docu->type;
			if($ctr == 1){
				echo "
					<tr>
						<td colspan='3'>$issuer</td>
						<td colspan='3' $center>$number</td>
						<td colspan='2' $center>$issue</td>
						<td colspan='2' $center>$expiry</td>
					</tr>
				";
			}
			else if($ctr == 2){
				echo "
					<td colspan='2'>$name</td>
					<td $center>$number</td>
					<td colspan='2' $center>$issue</td>
				";
			}
			else if($ctr == 3){
				echo "
					<td colspan='2'>$name</td>
					<td colspan='2' $center>$number</td>
					<td colspan='1' $center>$issue</td>
				";
			}
			else if($ctr == 4){
				echo "
					<tr>
						<td colspan='3'>$issuer</td>
						<td colspan='3' $center>$number</td>
						<td colspan='2' $center>$issue</td>
						<td colspan='2' $center>$expiry</td>
					</tr>
				";
			}
			else if($ctr == 5){
				$clinic = $docu->clinic;
				echo "
					<tr>
						<td colspan='3'>$issuer</td>
						<td colspan='3' $center>$clinic - $number</td>
						<td colspan='2' $center>$issue</td>
						<td colspan='2' $center>$expiry</td>
					</tr>
				";
			}
		}
		else{
			if($ctr == 1){
				echo "
					<tr>
						<td colspan='3'>$name</td>
						<td colspan='3' $center></td>
						<td colspan='2' $center></td>
						<td colspan='2' $center></td>
					</tr>
				";
			}
			else if($ctr == 2){
				echo "
					<td colspan='2'>$name</td>
					<td $center></td>
					<td colspan='2' $center></td>
				";
			}
			else if($ctr == 3){
				echo "
					<td colspan='2'>$name</td>
					<td colspan='2' $center></td>
					<td colspan='1' $center></td>
				";
			}
			else if($ctr == 4){
				echo "
					<tr>
						<td colspan='3'>$name</td>
						<td colspan='3' $center></td>
						<td colspan='2' $center></td>
						<td colspan='2' $center></td>
					</tr>
				";
			}
			else if($ctr == 5){
				echo "
					<tr>
						<td colspan='3'>$name</td>
						<td colspan='3' $center></td>
						<td colspan='2' $center></td>
						<td colspan='2' $center></td>
					</tr>
				";
			}
		}
	};

	$ss = function($ss) use($checkDate2, $data){
		$rank = $data->ranks[$ss->rank];
		$on = $checkDate2($ss->sign_on, 'i');
		$off = $checkDate2($ss->sign_off, 'i');

		$diff = "";
		if($ss->sign_on && $ss->sign_off){
			$year = $ss->sign_on->diff($ss->sign_off)->format('%y');
			$diff = $ss->sign_on->diff($ss->sign_off)->format('%mM %dD');

			if($year > 0){
				$diff = $year . "Y " . $diff;
			}
		}
		$eng = str_replace('&', '&#38;', $ss->engine_type);
		$manning = str_replace('&', '&#38;', $ss->manning_agent);
		$font = "style='font-size: 8px;'";

		echo "
			<tr>
				<td colspan='2' $font>$ss->vessel_name</td>
				<td $font>$ss->vessel_type / $eng</td>
				<td $font>$ss->gross_tonnage</td>
				<td $font>$ss->bhp_kw</td>
				<td $font>$rank</td>
				<td $font>$on - $off</td>
				<td $font>$diff</td>
				<td $font>$manning</td>
				<td $font>$ss->remarks</td>
			</tr>
		";
	};

	function nL($str = "", $size = 10){
		$size = $size . "px;";
		echo "
			<tr>
				<td colspan='10' style='text-align: center; font-weight: bold; font-size: $size'>$str</td>
			</tr>
		";
	}
@endphp

<table>
	<tr>
		<td style="font-weight: bold; color: #808080;">Annex 9</td>
		<td colspan="8"></td>
		<td>PIC</td>
	</tr>

	{{ nl('SOLPIA MARINE AND SHIP MANAGEMENT, INC.', 16) }}
	{{ nl() }}
	{{ nl('PERSONAL DATA SHEET', 12) }}

	<tr>
		<td colspan="8"></td>
		<td colspan="2" rowspan="3"></td>
	</tr>

	<tr>
		<td colspan="2">VESSEL NAME</td>
		<td colspan="4">{{ $data->vessel ? $data->vessel->name : '---' }}</td>
	</tr>

	<tr>
		<td colspan="2">REGISTRY</td>
		<td colspan="4">{{ $data->vessel ? $data->vessel->flag : '---' }}</td>
	</tr>

	{{ nl() }}

	<tr>
		<td colspan="8" style="font-weight: bold;">I. PERSONAL DATA</td>
		<td>CODE NO:</td>
		<td>POS - {{ isset($data->rank) ? $data->rank->abbr : "" }}</td>
	</tr>

	{{ nl() }}

	<tr>
		<td colspan="2">NAME</td>
		<td colspan="4">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->mname }} {{ $data->user->suffix }}
		</td>
		<td>RANK</td>
		<td>{{ isset($data->rank) ? $data->rank->abbr : "" }}</td>
		<td>CIVIL STATUS</td>
		<td>{{ $data->civil_status }}</td>
	</tr>

	<tr>
		<td colspan="2">DATE OF BIRTH</td>
		<td colspan="4">{{ $data->user->birthday->format("d.M.Y") }}</td>
		<td colspan="2">PLACE OF BIRTH</td>
		<td colspan="2">{{ $data->birth_place }}</td>
	</tr>

	<tr>
		<td colspan="2">RELIGION</td>
		<td colspan="4">{{ $data->religion }}</td>
		<td>HEIGHT</td>
		<td style="text-align: left;">{{ $data->height }}</td>
		<td>WEIGHT</td>
		<td style="text-align: left;">{{ $data->weight }}</td>
	</tr>

	<tr>
		<td colspan="2">ADDRESS</td>
		<td colspan="6">{{ $data->user->address ?? $data->provincial_address }}</td>
		<td>RACE</td>
		<td>FILIPINO</td>
	</tr>

	{{ nl() }}

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
		<td colspan="2">NEXT OF KIN</td>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="2">NAME</td>
		<td colspan="5">
			@if($nok)
				{{ $nok->lname }}, {{ $nok->fname }} {{ $nok->mname }} {{ $nok->suffix }}
			@else
				-----
			@endif
		</td>
		<td colspan="2">RELATIONSHIP</td>
		<td>{{ $nok ? $nok->type : '-----' }}</td>
	</tr>

	<tr>
		<td colspan="2">ADDRESS</td>
		<td colspan="5">{{ $nok ? $nok->address : '-----' }}</td>
		<td colspan="2">NO. OF CHILDREN</td>
		<td style="text-align: left;">{{ $childrens }}</td>
	</tr>

	<tr>
		<td colspan="10">EDUCATIONAL ATTAINMENT</td>
	</tr>

	@php
		$eb = null;
		$year = "-";
		$temps = ['College', 'Vocational', 'Undergrad'];

		foreach($temps as $temp){
			foreach($data->educational_background as $eb2){
				if($eb2->type == $temp && $eb2->school != "" && $eb == null){
					$eb = $eb2;
					break;
				}
			}
		}

		if($eb){
			$temp = explode('-', $eb->year);
			$year = $temp[1] != "" ? $temp[1] : "";
		}
	@endphp

	<tr>
		<td>COURSE</td>
		<td colspan="2">{{ $eb ? $eb->course : '-' }}</td>
		<td>SCHOOL</td>
		<td colspan="4">{{ $eb ? $eb->school : '-' }}</td>
		<td>YEAR</td>
		<td style="text-align: left;">{{ $year }}</td>
	</tr>

	{{ nl() }}
	{{ nl() }}
	{{ nl("II. LICENSES") }}

	<tr>
		<td colspan="2" style="font-weight: bold; text-align: center;">LICENSES</td>
		<td style="font-weight: bold; text-align: center;">GRADE (Class)</td>
		<td colspan="3" style="font-weight: bold; text-align: center;">NUMBER</td>
		<td colspan="2" style="font-weight: bold; text-align: center;">DATE ISSUED</td>
		<td colspan="2" style="font-weight: bold; text-align: center;">EXPIRY DATE</td>
	</tr>

	<tr>
		<td colspan="2">MYANMAR</td>
		<td style="text-align: center;"></td>
		<td colspan="3" style="text-align: center;" ></td>
		<td colspan="2" style="text-align: center;" ></td>
		<td colspan="2" style="text-align: center;" ></td>
	</tr>

	<tr>
		<td colspan="2">FOREIGN(     )</td>
		<td style="text-align: center;"></td>
		<td colspan="3" style="text-align: center;"></td>
		<td colspan="2" style="text-align: center;"></td>
		<td colspan="2" style="text-align: center;"></td>
	</tr>

	<tr>
		<td colspan="2" style="text-align: center;"></td>
		<td style="text-align: center;"></td>
		<td colspan="3" style="text-align: center;"></td>
		<td colspan="2" style="text-align: center;"></td>
		<td colspan="2" style="text-align: center;"></td>
	</tr>

	{{ nl() }}
	{{ nl() }}
	{{ nl("III. SEAMAN'S BOOK &#38; CERTIFICATES") }}

	<tr>
		<td colspan="3"></td>
		<td colspan="3" style="font-weight: bold; text-align: center;">NUMBER</td>
		<td colspan="2" style="font-weight: bold; text-align: center;">DATE ISSUED</td>
		<td colspan="2" style="font-weight: bold; text-align: center;">EXPIRY DATE</td>
	</tr>

	{{ $getDocument("SEAMAN'S BOOK",'id','S.I.BOOK', 1)}}
	{{ $getDocument("PASSPORT",'id',null, 1)}}
	{{ $getDocument("US-VISA",'id',"U.S. VISA C1/D", 1)}}

	<tr>
		<td colspan="3">FOREIGN S.BOOK(  )</td>
		<td colspan="3" style="text-align: center;"></td>
		<td colspan="2" style="text-align: center;"></td>
		<td colspan="2" style="text-align: center;"></td>
	</tr>

	{{ $getDocument("COE",'lc',"CERTIFICATE OF COMPETENCY", 1)}}
	{{ $getDocument("GMDSS/GOC",'lc',"GOC ID", 1)}}
	{{ $getDocument("YELLOW FEVER",'med_cert',null, 1)}}

	<tr>
		<td colspan="2"></td>
		<td style="font-weight: bold; text-align: center;">NUMBER</td>
		<td colspan="2" style="font-weight: bold; text-align: center;">DATE ISSUED</td>
		<td colspan="2"></td>
		<td colspan="2" style="font-weight: bold; text-align: center;">NUMBER</td>
		<td colspan="1" style="font-weight: bold; text-align: center;">DATE ISSUED</td>
	</tr>

	<tr>
		{{ $getDocument("BASIC TRAINING - BT",'lc',"F&#38;BSTC", 2) }}
		{{ $getDocument("ENGLISH TEST",'lc',"MAR-ENGLISH", 3) }}
	</tr>

	<tr>
		{{ $getDocument("PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB",'lc',"PSC-RB", 2) }}
		{{ $getDocument("SHIP HANDLING SIMULATION",'lc',"SHS", 3) }}
	</tr>

	<tr>
		{{ $getDocument("ADVANCE FIRE FIGHTING - AFF",'lc',"Adv-FF", 2) }}
		{{ $getDocument("ERS WITH ERM",'lc',"ERS", 3) }}
	</tr>

	<tr>
		{{ $getDocument("MEDICAL FIRST AID - MEFA",'lc',"MED. FIRST AID", 2) }}
		{{ $getDocument("SATELLITE COMMUNICATION COURSE",'lc',"INMARSAT", 3) }}
	</tr>

	<tr>
		{{ $getDocument("MEDICAL CARE - MECA",'lc',"MEDICAL CARE", 2) }}
		{{ $getDocument("GMDSS/GOC",'lc',"GMDSS", 3) }}
	</tr>

	@php
		$name = 'RADAR TRAINING COURSE';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;

		if(!$docu){
			$name = 'RADAR SIMULATOR COURSE';
			$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
		}

		if(!$docu){
			$name = 'RADAR OPERATOR PLOTTING AID';
		}
	@endphp

	<tr>
		{{ $getDocument("$name",'lc',"ROSC", 2) }}
		{{ $getDocument("ADVANCE TRAINING FOR OIL TANKER - ATOT",'lc',"OIL Tk FAM/OPR", 3) }}
	</tr>

	<tr>
		{{ $getDocument("ARPA TRAINING COURSE",'lc',"ARPA", 2) }}
		{{ $getDocument("ADVANCE TRAINING FOR CHEMICAL TANKER - ATCT",'lc',"CHEM Tk FAM/OPR", 3) }}
	</tr>

	@php
		$reg = null;
		if(isset($data->rank)){
			$reg = str_starts_with($data->rank->category, 'DECK') ? "II/4" : "III/4";
		}

		$docu = false;

		foreach($data->document_lc as $document){
			$regulation = json_decode($document->regulation);
			if(in_array($reg, $regulation)){
				$docu = $document;
			}
		}
	@endphp

	<tr>
		<td colspan="2">WATCHKEEPING</td>
		<td>{{ $docu ? $docu->number : "" }}</td>
		<td colspan="2">{{ $docu ? $checkDate2($docu->issue_date, 'I') : "" }}</td>

		<td colspan="2">OTHERS</td>
		<td colspan="2"></td>
		<td colspan="1"></td>
	</tr>

	{{ nl() }}
	{{ nl('IV. SEA SERVICE RECORD') }}

	<tr>
		<td colspan="2">NAME OF VESSEL</td>
		<td>TYPE OF VSL/ENG.</td>
		<td>GRT</td>
		<td>HP</td>
		<td>RANK</td>
		<td>PERIOD FROM - TO</td>
		<td>TOTAL SVC</td>
		<td>AGENCY</td>
		<td>REMARKS</td>
	</tr>

	@foreach($data->sea_service as $temp)
		{{ $ss($temp) }}
	@endforeach

	<tr>
		<td style="font-weight: bold;">FORM NO.</td>
		<td colspan="6"></td>
		<td colspan="2" style="font-weight: bold;">MAY 01, 2004</td>
	</tr>

	{{ nl() }}
	{{ nl() }}
	{{ nl("V. VACCINATION RECORDS") }}

	<tr>
		<td colspan="3" style="font-weight: bold; text-align: center;">TYPE OF VACCINE</td>
		<td colspan="3" style="font-weight: bold; text-align: center;">NUMBER</td>
		<td colspan="2" style="font-weight: bold; text-align: center;">DATE ISSUED</td>
		<td colspan="2" style="font-weight: bold; text-align: center;">EXPIRY DATE</td>
	</tr>

	{{ $getDocument("POLIO VACCINE (IPV)",'med_cert',"POLIO", 4) }}
	{{ $getDocument("COVID-19 1ST DOSE",'med_cert',"COVID VACCINE", 5) }}
	{{ $getDocument("COVID-19 2ND DOSE",'med_cert',"", 5) }}
	{{ $getDocument("COVID-19 3RD DOSE",'med_cert',"", 5) }}
	{{ $getDocument("BLANK",'med_cert',null, 5) }}
	{{ $getDocument("BLANK",'med_cert',null, 5) }}

	{{ nl() }}
	{{ nl() }}
	<tr>
		<td colspan="10" >VI. BMI - {{ $data->bmi }}</td>
	</tr>
	{{ nl() }}

	<tr>
		<td colspan="10" style="font-style: italic;">
			I hereby attest and certify that all information I have provided are true and correct and that I am not suffering from any medical ailments that will cause my unfitness &#38; repatriation &#38; I am fully aware that misinterpretation herein shall be ground for the disqualification of my application and/or repatriation at my own account &#38; criminal prosecution in the court of law.
		</td>
	</tr>

	<tr>
		<td colspan="7"></td>
		<td colspan="3">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->mname }} {{ $data->user->suffix }}

		</td>
	</tr>

	<tr>
		<td colspan="7"></td>
		<td colspan="3">(Signature over printed name)</td>
	</tr>

	<tr>
		<td colspan="7"></td>
		<td colspan="3">Applicants Signature</td>
	</tr>
</table>