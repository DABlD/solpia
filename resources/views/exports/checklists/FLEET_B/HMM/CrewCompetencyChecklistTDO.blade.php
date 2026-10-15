{{-- ☑ --}}
@php
	if (!function_exists('checkDate2')) {
		function checkDate2($date, $type){
			if($date == "UNLIMITED"){
				return 'UNLIMITED';
			}
			elseif($date == "" || $date == null){
				if($type == "E"){
					return 'UNLIMITED';
				}
				else{
					return '-';
				}
			}
			else{
				// echo $date->format('F j, Y');
				echo $date->toFormattedDateString();
			}
		}
	}

	if (!function_exists('validityCheck')) {
		function validityCheck($issue, $expiry){
			if(isset($expiry) && $expiry <= now()->toDateString()){
				return false;
			}

			return true;
		}
	}

	$flag = $data->vessel->flag;
	$kFlag = "▢";
	$pFlag = "▢";
	$mFlag = "▢";
	$lFlag = "▢";
	$mltFlag = "▢";
	$etcFlag = "▢";

	if($flag == "PANAMA"){
		$pFlag = "☑";
	}
	elseif($flag == "KOREA"){
		$kFlag = "☑";
	}
	elseif($flag == "LIBERIA"){
		$lFlag = "☑";
	}
	elseif($flag == "MALTA"){
		$mltFlag = "☑";
	}
	elseif($flag == "MARSHALL ISLANDS"){
		$mFlag = "☑";
	}
	else{
		$etcFlag = "☑";
	}
@endphp

<table>

	<tr>
		<td colspan="9">Crew Competency Checklist</td>
	</tr>

	<tr>
		<td colspan="9">(Vessel Flag {{ $kFlag }}KOR {{ $pFlag }}PAN {{ $mFlag }}MAR {{ $lFlag }}LIB {{ $mltFlag }}MLT {{ $etcFlag }}ETC)</td>
	</tr>

	<tr>
		<td colspan="5">For Filipino Officers</td>
		<td colspan="4">{{ "<Vessel Type : OIL/CHEM TNKR>" }}</td>
	</tr>

	<tr>
		<td>Rank</td>
		<td colspan="2">{{ $data->pro_app->rank->abbr }}</td>
		<td colspan="2">Verification criteria</td>
		<td colspan="2">Joining Vessel / Joining Date</td>
		<td>Checked by Vessel</td>
		<td rowspan="3">
			Related regulations / Remarks
		</td>
	</tr>

	<tr>
		<td rowspan="2">Name</td>
		<td rowspan="2" colspan="2">{{ $data->user->namefull }}</td>
		<td rowspan="2">Validity</td>
		<td rowspan="2">Requirement</td>
		<td colspan="2">{{ $data->pro_app->vessel->name }} / {{ $data->data['joining_date'] ?? ""  }}</td>
		<td>After Embarkation</td>
	</tr>

	<tr>
		<td>Issued Date</td>
		<td>Expiry Date</td>
		<td>Expiry Date</td>
	</tr>

	@php 
		$name = "SEAMAN'S BOOK";
		$docu = isset($data->document_id->{$name}) ? $data->document_id->{$name} : false;
	@endphp
	<tr>
		<td rowspan="2">SIRB</td>
		<td colspan="2">Philippine</td>
		<td>10Y</td>
		<td rowspan="12">All Ranks</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
		<td>Each National Law</td>
	</tr>

	@php
		$docu = false;
		foreach($data->document_flag as $document){
		    if($document->country == $flag && $document->type == "BOOKLET"){
		        $docu = $document;
		    }
		}
	@endphp
	<tr>
		<td colspan="2">Flag</td>
		<td>5Y</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
		<td>Flag Rule</td>
	</tr>

	@php 
		$name = "PASSPORT";
		$docu = isset($data->document_id->{$name}) ? $data->document_id->{$name} : false;
	@endphp
	<tr>
		<td>PPT</td>
		<td colspan="2">Passport</td>
		<td rowspan="2">10Y</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
		<td></td>
	</tr>

	@php 
		$name = "US-VISA";
		$docu = isset($data->document_id->{$name}) ? $data->document_id->{$name} : false;
	@endphp
	<tr>
		<td rowspan="3">VISA</td>
		<td colspan="2">US VISA</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
		<td></td>
	</tr>

	@php 
		$name = "MCV";
		$docu = isset($data->document_id->{$name}) ? $data->document_id->{$name} : false;
	@endphp
	<tr>
		<td colspan="2">Australia VISA (MCV)</td>
		<td>3Y</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
		<td></td>
	</tr>

	@php 
		$name = "New Zealand eTA";
		$docu = isset($data->document_id->{$name}) ? $data->document_id->{$name} : false;
	@endphp
	<tr>
		<td colspan="2">New Zealand VISA (NZeTA)</td>
		<td>5Y</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
		<td>Issue at every sign-on</td>
	</tr>

	@php 
		$name = "SID";
		$docu = isset($data->document_id->{$name}) ? $data->document_id->{$name} : false;
	@endphp
	<tr>
		<td>SID</td>
		<td colspan="2">Seafarer's Identification Document</td>
		<td>5Y</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
		<td>For Brazil Formality</td>
	</tr>

	@php 
		$name = 'MEDICAL CERTIFICATE';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;

		$name = 'FLAG MEDICAL';
		$docu2 = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;

		$y = "▢";
		$n = "▢";

		if(isset($docu->issue_date) && isset($docu2->issue_date)){
			$t1 = validityCheck($docu->issue_date, $docu->expiry_date);
			$t2 = validityCheck($docu2->issue_date, $docu2->expiry_date);

			if($t1 && $t2){
				$y = "☑";
			}
			else{
				$n = "☑";
			}
		}
	@endphp
	<tr>
		<td rowspan="5">MEDICAL</td>
		<td colspan="2">PEME with FLAG MEDICAL CERT</td>
		<td rowspan="2">every onboard</td>
		<td>Y  {{ $y }}</td>
		<td>N  {{ $n }}</td>
		<td>
			Y  ▢			N  ▢
		</td>
		<td></td>
	</tr>

	@php 
		$name = 'DRUG AND ALCOHOL TEST';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;

		$y = "▢";
		$n = "▢";

		if(isset($docu->issue_date)){
			$t1 = validityCheck($docu->issue_date, $docu->expiry_date);

			if($t1){
				$y = "☑";
			}
			else{
				$n = "☑";
			}
		}
	@endphp
	<tr>
		<td colspan="2">Drug &#38; Alcohol</td>
		<td>Y  {{ $y }}</td>
		<td>N  {{ $n }}</td>
		<td>
			Y  ▢			N  ▢
		</td>
		<td></td>
	</tr>

	@php 
		$name = "POLIO VACCINE (IPV)";
		$docu = isset($data->document_id->{$name}) ? $data->document_id->{$name} : false;
	@endphp
	<tr>
		<td colspan="2">Polio Vaccine</td>
		<td>1Y</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
		<td></td>
	</tr>

	@php 
		$name = 'YELLOW FEVER';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;

		$docu2 = null;
		foreach($data->document_med_cert as $dmc){
			if(str_contains($dmc->type, "COVID")){
				$docu2 = $dmc;
			}
		}

		$yf = "▢";
		$c  = "▢";

		if(isset($docu->issue_date)){
			$t1 = validityCheck($docu->issue_date, $docu->expiry_date);

			if($t1){
				$yf = "☑";
			}
		};

		if(isset($docu2->issue_date)){
			$t1 = validityCheck($docu2->issue_date, $docu2->expiry_date);

			if($t1){
				$c = "☑";
			}
		}
	@endphp
	<tr>
		<td colspan="2">Yellow Fever / COVID-19</td>
		<td>-</td>
		<td>YF  {{ $yf }}</td>
		<td>C   {{ $c }}</td>
		<td>
			YF  ▢			C  ▢
		</td>
		<td>WHO / National</td>
	</tr>

	@php
		$name = 'METHANOL TEST';
		$docu = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;

		$name = 'BENZENE TEST';
		$docu2 = isset($data->document_med_cert->{$name}) ? $data->document_med_cert->{$name} : false;

		$y = "▢";
		$n = "▢";

		if(isset($docu->issue_date) || isset($docu2->issue_date)){
			$t1 = null;
			$t2 = null;

			if(isset($docu->issue_date)){
				$t1 = validityCheck($docu->issue_date, $docu->expiry_date);
			}
			if(isset($docu2->issue_date)){
				$t2 = validityCheck($docu2->issue_date, $docu2->expiry_date);
			}


			if($t1 || $t2){
				$y = "☑";
			}
			else{
				$n = "☑";
			}
		}
	@endphp
	<tr>
		<td colspan="2">Medical Examination of Chemical</td>
		<td>every onboard</td>
		<td>Y  {{ $y }}</td>
		<td>N  {{ $n }}</td>
		<td>
			Y  ▢			N  ▢
		</td>
		<td>only for Methanol / DF vessel</td>
	</tr>

	@php 
		$docu = null;

		foreach(get_object_vars($data->document_lc) as $key => $doc){
			$regulations = json_decode($doc->regulation);

			if(in_array($key, ["COC", "COE"]) && (in_array("II/1", $regulations) || in_array("II/2", $regulations))){
				if($docu == null){
					$docu = $doc;
				}
				elseif($doc->issue_date > $docu->issue_date){
					$docu = $doc;
				}
			}
		}
	@endphp
	<tr>
		<td rowspan="3">STCW II</td>
		<td rowspan="2">License</td>
		<td>COC (National)</td>
		<td rowspan="2">5Y</td>
		<td rowspan="3">
			MTR &#38;<br>
			All Officers
		</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
		<td rowspan="3">
			II/1 (3O, 2O)<br>
			II/2 (CO, MTR)
		</td>
	</tr>

	<tr>
		<td>Flag</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	@php
		$roc = isset($data->document_lc->{"RADAR OBSERVER COURSE"}) ? "☑" : "▢";
		$rsc = isset($data->document_lc->{"RADAR SIMULATOR COURSE"}) ? "☑" : "▢";
		$e = isset($data->document_lc->{"ECDIS"}) ? "☑" : "▢";
		$arpa = isset($data->document_lc->{"ARPA TRAINING COURSE"}) ? "☑" : "▢";
	@endphp
	<tr>
		<td>Training Cert</td>
		<td>RADAR/ECDIS/(GENERIC)/ARPA</td>
		<td>-</td>
		<td>
			ROCㅤㅤㅤRSC<br>
			 {{ $roc }}ㅤㅤㅤㅤ{{ $rsc }}
		</td>
		<td>
			ㅤEㅤㅤARPA<br>
			{{ $e }}ㅤㅤㅤ{{ $arpa }}
		</td>
		<td>
			ROCㅤRSCㅤEㅤARP<br>
			▢ㅤㅤ▢ㅤ▢ㅤ▢
		</td>
	</tr>

	@php
		$docu = null;

		foreach(get_object_vars($data->document_lc) as $doc){
			if($doc->type == "GMDSS/GOC"){
				if($docu && $doc->issue_date > $docu->issue_date){
					$docu = $doc;
				}
				else{
					if($doc->issue_date > now()->toDateString()){
						$docu = $doc;
					}
				}
			}
		}
	@endphp
	<tr>
		<td rowspan="2">STCW IV</td>
		<td rowspan="2">License</td>
		<td>GOC (National)</td>
		<td rowspan="2">5Y</td>
		<td rowspan="2">
			MTR &#38;<br>
			All Officers
		</td>
		<td>Y {{ $docu ? "☑" : "▢" }}</td>
		<td>N {{ $docu ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
		<td rowspan="2">IV/2</td>
	</tr>

	<tr>
		<td>Flag</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	@php
		$docu = null;
		$tDocu = null;
		$tDocu2 = null;
		$name = null;
		// dd($data->rank); //MSTR

		if($data->rank == "MSTR"){
			$name = "SHIP SECURITY OFFICER - SSO";
		}
		else{
			$name = "SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD";
		}

		foreach(get_object_vars($data->document_lc) as $doc){
			if($doc->type == $name){
				if($doc->issuer != "MARINA"){
					if($name == "SHIP SECURITY OFFICER - SSO"){
						$tDocu = $doc;
					}
					else{
						$tDocu2 = $doc;
					}
				}
				else{
					if($docu && $doc->issue_date > $docu->issue_date){
						$docu = $doc;
					}
					else{
						if($doc->issue_date > now()->toDateString()){
							$docu = $doc;
						}
					}
				}
			}
		}
	@endphp
	<tr>
		<td rowspan="10">STCW VI</td>
		<td rowspan="2">License</td>
		<td>SSO/DSD (National)</td>
		<td>-</td>
		<td rowspan="2">
			MTR (SSO)
			<br>
			All Officers (DSD)
		</td>
		<td>Y {{ $docu ? "☑" : "▢" }}</td>
		<td>N {{ $docu ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
		<td rowspan="4">
			VI/5 (SSO)<br>
			VI/6 (DSD)
		</td>
	</tr>

	<tr>
		<td>Flag</td>
		<td>5Y</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td rowspan="8">Training Cert</td>
		<td>Ship Security Officer</td>
		<td rowspan="2">-</td>
		<td>MTR, CO</td>
		<td>Y {{ $tDocu ? "☑" : "▢" }}</td>
		<td>N {{ $tDocu ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
	</tr>

	<tr>
		<td>Designated Security Duty</td>
		<td>All Officers</td>
		<td>Y {{ $tDocu2 ? "☑" : "▢" }}</td>
		<td>N {{ $tDocu2 ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
	</tr>

	@php
		$name = 'BASIC TRAINING - BT';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>Basic Training</td>
		<td rowspan="4">5Y</td>
		<td rowspan="2">
			MTR &#38;<br>
			All Officers
		</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
		<td rowspan="6">
			VI/1 Basic Training<br>
			VI/2 Survival Craft &#38; Rescue Boat
			VI/3 Advanced Fire Fighting
			VI/4 Medical First-Aid / Medical Care
			<br>
			<br>
			* 2O, 3O - MECA 5Y<br>
			(by Refresher course)
		</td>
	</tr>

	@php
		$name = 'BT-PSSR';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>BT-PSSR Updating (If necessary)</td>
		<td>Y {{ $docu ? "☑" : "▢" }}</td>
		<td>N {{ $docu ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
	</tr>

	@php
		$name = 'PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>Survival Craft &#38; Rescue Boat</td>
		<td>Engaged in the relevant duty</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
	</tr>

	@php
		$name = 'ADVANCE FIRE FIGHTING - AFF';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>Advanced Fire Fighting</td>
		<td rowspan="2">
			MTR &#38;<br>
			All Officers
		</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
	</tr>

	@php
		$name = 'MEDICAL FIRST AID - MEFA';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>Medical First-Aid</td>
		<td>-</td>
		<td>Y {{ $docu ? "☑" : "▢" }}</td>
		<td>N {{ $docu ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
	</tr>

	@php
		$name = 'MEDICAL CARE - MECA';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>Medical Care</td>
		<td>-</td>
		<td>
			Engaged in the relevant duty
		</td>
		<td>Y {{ $docu ? "☑" : "▢" }}</td>
		<td>N {{ $docu ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
	</tr>

	@php
		$docu = false;
		$tDocu = false;

		foreach(get_object_vars($data->document_lc) as $doc){
			if(in_array("IGF", explode(' ', $doc->type))){
				if($doc->issuer == "MARINA"){
					$docu = $doc;
				}
				else{
					$tDocu = $doc;
				}
			}
		}
	@endphp
	<tr>
		<td rowspan="6">STCW V/3</td>
		<td rowspan="2">IGF Basic</td>
		<td>COP (National)</td>
		<td rowspan="4">5Y</td>
		<td rowspan="2">
			MTR &#38;<br>
			All Officers
		</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
		<td rowspan="6">
			V/3-4 (IGF Basic)<br>
			V/3-7 (IGF Advanced)
		</td>
	</tr>

	<tr>
		<td>Flag</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td rowspan="2">IGF Advanced</td>
		<td>COP (National)</td>
		<td rowspan="2">
			MTR &#38;<br>
			All Officers
		</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td>Flag</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td rowspan="2">Training Cert</td>
		<td>IGF Basic</td>
		<td rowspan="2">-</td>
		<td>MTR &#38; All Officers</td>
		<td>Y {{ $tDocu ? "☑" : "▢" }}</td>
		<td>N {{ $tDocu ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
	</tr>

	<tr>
		<td>IGF Advanced</td>
		<td>MTR</td>
		<td>Y ▢</td>
		<td>N ▢</td>
		<td>Y ▢ N ▢</td>
	</tr>

	@php
		$btoc = "▢";
		$btlgt = "▢";
		$atot = "▢";
		$atct = "▢";
		$atlgt = "▢";

		foreach($data->document_lc as $docu){
			if(str_contains($docu->type, "BTOCT")){
				$btoc = $docu->no ? "☑" : "▢";
			}
			elseif(str_contains($docu->type, "BTLGT")){
				$btlgt = $docu->no ? "☑" : "▢";
			}
			elseif(str_contains($docu->type, "ATOT")){
				$atot = $docu->no ? "☑" : "▢";
			}
			elseif(str_contains($docu->type, "ATCT")){
				$atct = $docu->no ? "☑" : "▢";
			}
			elseif(str_contains($docu->type, "ATLGT")){
				$atlgt = $docu->no ? "☑" : "▢";
			}
		}
	@endphp

	@php 
		$name = "BASIC TRAINING FOR OIL AND CHEMICAL TANKER - BTOCT";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td rowspan="8">STCW V/1</td>
		<td rowspan="4">License</td>
		<td>BTOC/BTLGT(National)</td>
		<td rowspan="6">5Y</td>
		<td rowspan="8">
			MRT &#38;<br>
			All Officers
		</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
		<td rowspan="8">
			Tanker
			<br style='mso-data-placement:same-cell;' />
			V/1-1.1 (BTOC)
			<br style='mso-data-placement:same-cell;' />
			V/1-1.3 (ATOT)
			<br style='mso-data-placement:same-cell;' />
			V/1-1.5 (ATCT)
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			Liquefied Gas Tanker
			<br style='mso-data-placement:same-cell;' />
			V/1-2.1 (BTLGT)
			<br style='mso-data-placement:same-cell;' />
			V/1-2.3 (ALGT)
		</td>
	</tr>

	@php 
		$name = "BTOC";
		$docu = isset($data->document_flag->{$name}) ? $data->document_flag->{$name} : false;
	@endphp
	<tr>
		<td>Flag</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
	</tr>

	@php 
		$name = "ADVANCE TRAINING FOR OIL TANKER - ATOT";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>ATOT/ALGT (National)</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
	</tr>

	@php 
		$name = "ATOT";
		$docu = isset($data->document_flag->{$name}) ? $data->document_flag->{$name} : false;
	@endphp
	<tr>
		<td>Flag</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
	</tr>

	@php 
		$name = "ADVANCE TRAINING FOR CHEMICAL TANKER - ATCT";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td rowspan="2">License (Chemical Tanker)</td>
		<td>ATCT (National)</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
	</tr>

	@php 
		$name = "ATCT";
		$docu = isset($data->document_flag->{$name}) ? $data->document_flag->{$name} : false;
	@endphp
	<tr>
		<td>Flag</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
	</tr>

	<tr>
		<td rowspan="2">Training Cert</td>
		<td>Basic Training for</td>
		<td rowspan="2">
			-
		</td>
		<td>
			Oil &#38; Chemical<br>
			{{ $btoc }}
		</td>
		<td>
			Liquified Gas Tanker<br>
			{{ $btlgt }}
		</td>
		<td>
			BTOCㅤㅤBTLGT
			<br>
			{{ $btoc }}ㅤㅤㅤㅤ {{ $btlgt }}
		</td>
	</tr>
	<tr>
		<td>Advanced Training for</td>
		<td colspan="2">
			OilㅤㅤㅤChemicalㅤㅤㅤLiquified Gas
			<br>
			{{ $atot }}ㅤㅤㅤㅤㅤㅤ {{ $atct }}ㅤㅤㅤㅤㅤㅤㅤ {{ $atlgt }}
		</td>
		<td>
			OilㅤㅤChemiㅤㅤL/G
			<br>
			{{ $atot }}ㅤㅤㅤ {{ $atct }}ㅤㅤㅤ {{ $atlgt }}
		</td>
	</tr>

	@php 
		$name = "SSBT WITH BRM";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td rowspan="4">SIRE</td>
		<td colspan="2">SSBT / SHS w/BRM</td>
		<td rowspan="2">5Y</td>
		<td rowspan="2">
			MTR &#38;<br>
			All Officers
		</td>
		<td>Y {{ $docu ? "☑" : "▢" }}</td>
		<td>N {{ $docu ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
		<td rowspan="4">
			SSBT : SIRE 2.0  3.3.1
			<br>
			CBHS : SIRE 2.0  3.3.3
			<br>
			SHS(Specific)
			<br>
			 -. SIRE 2.0  3.3.2,  TMSA 5-3-2
			<br>
			 -. RISQ 2.6
			<br>
			 -. C/O to be promoted as a master
			    or Master to be assigned to new 
			    type of vessel
			<br>
			 Safety officer :  TMSA 9A-1-1
		</td>
	</tr>

	@php
		$name = 'CARGO AND BALLAST HANDLING SIMULATOR - CBHS';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td colspan="2">Cargo &#38; Ballast Handling Simulator</td>
		<td>Y {{ $docu ? "☑" : "▢" }}</td>
		<td>N {{ $docu ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="2"> SHS (Specific)</td>
		<td>-</td>
		<td rowspan="2">MTR, C/O</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	@php
		$docu = false;

		foreach(get_object_vars($data->document_lc) as $doc){
			if(str_contains($doc->type, "SAFETY") || str_contains($doc->type, "RISK")){
				$docu = $doc;
			}
		}
	@endphp
	<tr>
		<td colspan="2">Safety Officer (including risk assessment &#38; accident investigation course)</td>
		<td>5Y</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
	</tr>

	@php 
		$name = "PDOS";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td rowspan="4">ETC</td>
		<td colspan="2">Pre-Departure Orientation Seminar</td>
		<td>every onboard</td>
		<td rowspan="4">
			MTR &#38;<br>
			All Officers
		</td>
		<td>Y {{ $docu ? "☑" : "▢" }}</td>
		<td>N {{ $docu ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
		<td></td>
	</tr>

	@php
		$j90 = "▢";
		$j92 = "▢";
		$f2  = "▢";
		$f3  = "▢";
		$etc = "▢";

		foreach(get_object_vars($data->document_lc) as $doc){
			if(str_contains($doc->type, "JRC 90")){
				$j90 = "☑";
			}
			elseif(str_contains($doc->type, "JRC 92")){
				$j92 = "☑";
			}
			elseif(str_contains($doc->type, "FURUNO 2")){
				$f2 = "☑";
			}
			elseif(str_contains($doc->type, "FURUNO 3")){
				$f3 = "☑";
			}
			else{
				$etc = "☑";
			}
		}
	@endphp
	<tr>
		<td colspan="2">ECDIS TST</td>
		<td>-</td>
		<td colspan="2">
			J90ㅤㅤJ92ㅤㅤF2ㅤㅤF3ㅤㅤetc<br>
			{{ $j90 }}ㅤㅤ {{ $j92 }}ㅤㅤ{{ $f2 }}ㅤㅤ{{ $f3 }}ㅤㅤ{{ $etc }}
		</td>
		<td>
			J90ㅤJ92ㅤF2ㅤF3ㅤetc<br>
			▢ㅤ ▢ㅤ▢ㅤ▢ㅤ▢
		</td>
		<td></td>
	</tr>

	@php
		$name = 'KML';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td colspan="2">Korean Maritime Law</td>
		<td>-</td>
		<td>Y {{ $docu ? "☑" : "▢" }}</td>
		<td>N {{ $docu ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
		<td>KML</td>
	</tr>

	@php
		$docu = false;

		foreach(get_object_vars($data->document_lc) as $doc){
			if(str_contains($doc->type, "KOSMA")){
				$docu = $doc;
			}
		}
	@endphp
	<tr>
		<td colspan="2">Seafarer Labor Human rights protection</td>
		<td>1Y</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
		<td>KOSMA</td>
	</tr>

	<tr>
		<td rowspan="3">
			Managed by HOS
		</td>
		<td colspan="2">Ballast Water Management</td>
		<td>5Y</td>
		<td>
			MTR &#38;<br>
			All Officers
		</td>
		<td></td>
		<td></td>
		<td></td>
		<td>Ballast Water Management</td>
	</tr>

	<tr>
		<td colspan="2">Marine Pollution Prevention Manager</td>
		<td>5Y</td>
		<td>C/O</td>
		<td></td>
		<td></td>
		<td></td>
		<td>Korea Maritime Environment management Act</td>
	</tr>

	<tr>
		<td colspan="2">Anti Piracy Training</td>
		<td>5Y</td>
		<td>
			MTR, CO<br>
			(Korean flag/BBCHP)
		</td>
		<td></td>
		<td></td>
		<td></td>
		<td>Pirate Damage Prevention Act</td>
	</tr>

	<tr>
		<td colspan="3">POEA Contract</td>
		<td rowspan="3">every onboard</td>
		<td rowspan="3">All Ranks</td>
		<td>Y ▢</td>
		<td>N ▢</td>
		<td>Y ▢ N ▢</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">AMOSUP</td>
		<td>Y ▢</td>
		<td>N ▢</td>
		<td>Y ▢ N ▢</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">Seafarer's Employment Agreement</td>
		<td>Y ▢</td>
		<td>N ▢</td>
		<td>Y ▢ N ▢</td>
		<td>MLC 2.1</td>
	</tr>

	<tr>
		<td colspan="5">Date of confirmation</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="5">Name of Person in Charge (Sign)</td>
		<td>CREW</td>
		<td>MANNING AGENCY</td>
		<td>MASTER</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="9">[Note] Master should oblige the duty to the joining crew after the check of his qualification with checklist before relief and shold be seent it to the company if you have any special problem (Kept on board the original copy).</td>
	</tr>

	<tr>
		<td colspan="9">CODE{{ "<305-403A>" }}/2026.09.30/DCN26008 APRVD/A4</td>
	</tr>
</table>