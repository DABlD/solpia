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
		<td colspan="5">For Filipino Ratings</td>
		<td colspan="4">{{ "<Vessel Type : CNTR, BULK>" }}</td>
	</tr>

	<tr>
		<td>Rank</td>
		<td colspan="2"></td>
		<td colspan="2">Verification criteria</td>
		<td colspan="2">Joining Vessel / Joining Date</td>
		<td>Checked by Vessel</td>
		<td rowspan="3">
			Related regulations / Remarks
		</td>
	</tr>

	<tr>
		<td rowspan="2">Name</td>
		<td rowspan="2" colspan="2"></td>
		<td rowspan="2">Validity</td>
		<td rowspan="2">Requirement</td>
		<td colspan="2"></td>
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
		<td colspan="2">Philippine / Myanmar / Indonesia</td>
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
		<td>-</td>
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
		<td>-</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
		<td></td>
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

			if(in_array($key, ["COC", "COE"]) && (in_array("III/1", $regulations) || in_array("III/2", $regulations))){
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
		<td rowspan="4">STCW III</td>
		<td rowspan="2">License</td>
		<td>COC (National)</td>
		<td rowspan="2">5Y</td>
		<td rowspan="2">
			All Engineers
		</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
		<td rowspan="3">
			III/1 (2AE, 3AE)<br>
			III/2 (CE, 1AE)<br>
			※ MAHIVO training<br>
			ㅤ- Applicable to ships equipped<br>
			ㅤwith equipment to generate,<br>
			ㅤdistribute or transform high<br>
			ㅤvoltage exceeding 1,000 volts
		</td>
	</tr>

	<tr>
		<td>Flag</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	@php
		$docu = false;

		foreach(get_object_vars($data->document_lc) as $doc){
			if(str_contains($doc->type, "MARINE HIGH VOLTAGE")){
				$docu = $doc;
			}
		}
	@endphp
	<tr>
		<td rowspan="2">High Voltage</td>
		<td>MAHIVO (Operation Lv)</td>
		<td>-</td>
		<td>2AE, 3AE</td>
		<td>Y {{ $docu ? "☑" : "▢" }}</td>
		<td>N {{ $docu ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
	</tr>

	@php
		$docu = false;

		foreach(get_object_vars($data->document_lc) as $doc){
			if(str_contains($doc->type, "MARINE HIGH VOLTAGE") && str_contains($doc->type, "Management")){
				$docu = $doc;
			}
		}
	@endphp
	<tr>
		<td>MAHIVO (Management Lv)</td>
		<td>-</td>
		<td>CE, 1AE</td>
		<td>Y {{ $docu ? "☑" : "▢" }}</td>
		<td>N {{ $docu ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
	</tr>

	@php
		$docu = false;
		$tDocu = false;
		$name = "SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD";

		foreach(get_object_vars($data->document_lc) as $doc){
			if($doc->type == $name){
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
		<td rowspan="8">STCW VI</td>
		<td rowspan="2">License</td>
		<td>DSD (National)</td>
		<td>-</td>
		<td rowspan="3">
			All Engineers
		</td>
		<td>Y {{ $docu ? "☑" : "▢" }}</td>
		<td>N {{ $docu ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
		<td rowspan="3">
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
		<td rowspan="6">Training Cert</td>
		<td>Designated Security Duty</td>
		<td>-</td>
		<td>Y {{ $tDocu ? "☑" : "▢" }}</td>
		<td>N {{ $tDocu ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
	</tr>

	@php
		$name = 'BASIC TRAINING - BT';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>Basic Training</td>
		<td rowspan="3">5Y</td>
		<td>All Engineers</td>
		<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "" }}</td>
		<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "" }}</td>
		<td></td>
		<td rowspan="5">
			VI/1 Basic Training<br>
			VI/2 Survival Craft &#38; Rescue Boat<br>
			VI/3 Advanced Fire Fighting<br>
			VI/4 Medical First-Aid / Medical Care
		</td>
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
		<td rowspan="3">All Engineers</td>
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

	<tr>
		<td>BT/SCR/AFF/MF/MC - Flag</td>
		<td>5Y</td>
		<td></td>
		<td></td>
		<td></td>
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
		<td rowspan="6">All Engineers</td>
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
		<td>Y {{ $tDocu ? "☑" : "▢" }}</td>
		<td>N {{ $tDocu ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
	</tr>

	<tr>
		<td>IGF Advanced</td>
		<td>Y ▢</td>
		<td>N ▢</td>
		<td>Y ▢ N ▢</td>
	</tr>

	@php 
		$name = "PDOS";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td rowspan="3">ETC</td>
		<td colspan="2">Pre-Departure Orientation Seminar</td>
		<td>every onboard</td>
		<td rowspan="3">All Engineers</td>
		<td>Y {{ $docu ? "☑" : "▢" }}</td>
		<td>N {{ $docu ? "▢" : "☑" }}</td>
		<td>Y ▢ N ▢</td>
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
		<td rowspan="4">
			Managed by HOS
		</td>
		<td colspan="2">Mental health(Bulk only)</td>
		<td>-</td>
		<td>
			C/E, 1/E<br>
			(Bulk only)
		</td>
		<td></td>
		<td></td>
		<td></td>
		<td rowspan="2">
			Rightship<br>
			section 15.13 (Mental health)<br>
			section 4.2 (Safety officer)
		</td>
	</tr>

	<tr>
		<td colspan="2">Safety Officer(including risk assessment)</td>
		<td>5Y</td>
		<td>C/E, 1/E</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="2">Ballast Water Management</td>
		<td>5Y</td>
		<td>All Engineers</td>
		<td></td>
		<td></td>
		<td></td>
		<td>Ballast Water Management</td>
	</tr>

	<tr>
		<td colspan="2">Marine Pollution Prevention Manager</td>
		<td>5Y</td>
		<td>C/E, 1/E</td>
		<td></td>
		<td></td>
		<td></td>
		<td>Korea Maritime Environment management Act</td>
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
		<td colspan="9">CODE{{ "<305-401A>" }}/2024.04.09/DCN24003 APRVD/A4</td>
	</tr>
</table>