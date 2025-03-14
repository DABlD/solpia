@php
	$size = sizeof($data);
@endphp

<table>
	<tr>
		<td></td>
		<td colspan="34">
			{{ $vessel->name }} - ONBOARD CREW DOCUMENTS MONITORING
		</td>
	</tr>

	<tr>
		<td></td>
		<td>DATE:</td>
		<td>{{ now()->format('m/d/y') }}</td>
		<td colspan="32">
		</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="8">NATIONAL ID / VISA</td>
		<td colspan="7">FLAG LICENSE</td>
		<td colspan="4">NATIONAL LICENSE</td>
		<td colspan="6">COP TRAININGS</td>
		<td>Trainings</td>
		<td colspan="2">MEDICAL</td>
		<td colspan="3">VACCINE</td>
		<td colspan="2">BBHCP</td>
		<td>REMARKS</td>
	</tr>

	<tr>
		<td>NO.</td>
		<td>PRINCIPAL</td>
		<td>VESSEL NAME</td>
		<td>RANK</td>
		<td>NAME</td>
		<td>DATE OF BIRTH</td>
		<td>AGE</td>
		<td>DATE OF JOIN</td>
		<td>CONTRACT DURATION</td>
		<td>DATE OF CONTRACT TERMINATION</td>
		<td>MONTHS ONBOARD</td>
		<td>PASSPORT NO.</td>
		<td>PASSPORT VALIDITY</td>
		<td>SIRB NO.</td>
		<td>SEAMAN'S BOOK VALIDITY</td>
		<td>SID VALIDITY</td>
		<td>US VISA VALIDITY</td>
		<td>MARITIME CREW VISA PPRT NO.</td>
		<td>MARIITME CREW VISA EXPIRY</td>
		<td>FLAG</td>
		<td>RANK</td>
		<td>BOOKLET</td>
		<td>COC</td>
		<td>GOC</td>
		<td>SDSD/SSO</td>
		<td>COOK</td>
		<td>COC/COE LICENSE</td>
		<td>GOC LICENSE</td>
		<td>COC-RATINGS</td>
		<td>COC-GALLEY</td>
		<td>BT</td>
		<td>PSCRB</td>
		<td>AFF</td>
		<td>MEFA</td>
		<td>MECA</td>
		<td>SDSD/SSO</td>
		<td>ECDIS Specific</td>
		<td>MEDICAL</td>
		<td>DAAT</td>
		<td>YELLOW FEVER</td>
		<td>POLIO VACCINE</td>
		<td>COVID VACCINE</td>
		<td>KOSMA LICENSE</td>
		<td>KML LICENSE</td>
		<td>FACEBOOK NAME</td>
	</tr>

	@foreach($data as $obc)
		<tr>
			<td>{{ $loop->index + 1 }}</td>
			<td>{{ $vessel->principal->name }}</td>
			<td>{{ $vessel->name }}</td>
			<td>{{ $obc->applicant->user->crew->pro_app->rank->abbr }}</td>
			<td>{{ $obc->applicant->user->namefull }}</td>
			<td>{{ isset($obc->applicant->user->birthday) ? $obc->applicant->user->birthday->format('d-M-y') : "N/A" }}</td>
			<td>{{ isset($obc->applicant->user->birthday) ? $obc->applicant->user->birthday->age : "N/A" }}</td>
			<td>{{ $obc->joining_date->format('d-M-y') }}</td>

			@php
				$months = $obc->months + ($obc->extensions ? array_sum(json_decode($obc->extensions)) : 0);
			@endphp
			<td>{{ $months }}</td>
			<td>=DATEVALUE("{{ $obc->joining_date->addMonths($months)->format('m/d/Y') }}")</td>
			<td>{{ now()->diffInMonths($obc->joining_date) }}</td>

			{{-- PASSPORT --}}
			@php
				$docu = null;
				foreach($obc->document_id as $doc){
					if($doc->type == "PASSPORT"){
						$docu = $doc;
					}
				}
			@endphp
			<td>{{ $docu ? $docu->number : "N/A" }}</td>
			<td>{{ $docu ? ($docu->expiry_date ? '=DATEVALUE("' . $docu->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>

			{{-- SEAMANS BOOK --}}
			@php
				$docu = null;
				foreach($obc->document_id as $doc){
					if($doc->type == "SEAMAN'S BOOK"){
						$docu = $doc;
					}
				}
			@endphp
			<td>{{ $docu ? $docu->number : "N/A" }}</td>
			<td>{{ $docu ? ($docu->expiry_date ? '=DATEVALUE("' . $docu->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>

			{{-- US VISA --}}
			@php
				$docu = null;
				foreach($obc->document_id as $doc){
					if($doc->type == "US-VISA"){
						$docu = $doc;
					}
				}
			@endphp
			<td>{{ $docu ? ($docu->expiry_date ? '=DATEVALUE("' . $docu->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>

			{{-- SID --}}
			@php
				$docu = null;
				foreach($obc->document_id as $doc){
					if($doc->type == "SID"){
						$docu = $doc;
					}
				}
			@endphp
			<td>{{ $docu ? ($docu->expiry_date ? '=DATEVALUE("' . $docu->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>

			{{-- MCV --}}
			@php
				$docu = null;
				foreach($obc->document_id as $doc){
					if($doc->type == "MCV"){
						$docu = $doc;
					}
				}
			@endphp
			<td>{{ $docu ? $docu->number : "N/A" }}</td>
			<td>{{ $docu ? ($docu->expiry_date ? '=DATEVALUE("' . $docu->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>

			{{-- FLAG DOCUMENTS --}}
			@php
				$fRank = null; $fBooklet = null; $fCoc = null; $fGoc = null; $fSdsdSso = null; $fCook = null;

				foreach($obc->document_flag as $doc){
					if(strtoupper($doc->country) == strtoupper($vessel->flag)){
						if($doc->type == "BOOKLET"){
							$fBooklet = $doc;
							$fRank = $doc->rankz->abbr;
						}
						elseif($doc->type == "LICENSE"){
							$fCoc = $doc;
							$fRank = $doc->rankz->abbr;
						}
						elseif($doc->type == "GMDSS/GOC"){
							$fGoc = $doc;
							$fRank = $doc->rankz->abbr;
						}
						elseif($doc->type == "SSO"){
							$fSdsdSso = $doc;
							$fRank = $doc->rankz->abbr;
						}
						elseif($doc->type == "SDSD" && $fSdsdSso == null){
							$fSdsdSso = $doc;
							$fRank = $doc->rankz->abbr;
						}
						elseif($doc->type == "SHIP'S COOK ENDORSEMENT"){
							$fCook = $doc;
							$fRank = $doc->rankz->abbr;
						}
					}
				}
			@endphp
			<td>{{ $vessel->flag ?? "N/A" }}</td>
			<td>{{ $fRank }}</td>
			<td>{{ $fBooklet ? ($fBooklet->expiry_date ? '=DATEVALUE("' . $fBooklet->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $fCoc ? ($fCoc->expiry_date ? '=DATEVALUE("' . $fCoc->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $fGoc ? ($fGoc->expiry_date ? '=DATEVALUE("' . $fGoc->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $fSdsdSso ? ($fSdsdSso->expiry_date ? '=DATEVALUE("' . $fSdsdSso->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $fCook ? ($fCook->expiry_date ? '=DATEVALUE("' . $fCook->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>

			{{-- LICENSES --}}
			@php
				$oic = null; $goc = null; $cocR = null; $cocG = null;
				$bt = null; $pscrb = null; $aff = null; $sdsd = null;
				$sso = null; $mefa = null; $meca = null;

				$kml = null; $kosma = null;
				foreach($obc->document_lc as $doc){
					if($doc->type == "COC"){
						$regulations = json_decode($doc->regulation);
						if(in_array("II/2", $regulations) || in_array("III/2", $regulations)){
							$oic = $doc;
						}
						elseif(in_array("II/4", $regulations) || in_array("III/4", $regulations)){
							$cocR = $doc;
						}
					}
					elseif($doc->type == "GMDSS/GOC"){
						$goc = $doc;
					}
					elseif($doc->type == "NCIII"){
						$cocG = $doc;
					}
					elseif($doc->type == "NCI" && $cocG == null){
						$cocG = $doc;
					}
					elseif($doc->type == "BASIC TRAINING - BT"){
						$bt = $doc;
					}
					elseif($doc->type == "PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB"){
						$pscrb = $doc;
					}
					elseif($doc->type == "ADVANCE FIRE FIGHTING - AFF"){
						$aff = $doc;
					}
					elseif($doc->type == "SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD"){
						$sdsd = $doc;
					}
					elseif($doc->type == "SHIP SECURITY OFFICER - SSO"){
						$sso = $doc;
					}
					elseif($doc->type == "MEDICAL FIRST AID - MEFA"){
						$mefa = $doc;
					}
					elseif($doc->type == "MEDICAL CARE - MECA"){
						$meca = $doc;
					}
					elseif(str_contains($doc->type, "KML")){
						$kml = $doc;
					}
					elseif(str_contains($doc->type, "KOSMA")){
						$kosma = $doc;
					}
				}

				$sdsd = $sso ? $sso : $sdsd; // SSO IF CREW HAS SSO
			@endphp
			<td>{{ $oic ? ($oic->expiry_date ? '=DATEVALUE("' . $oic->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $goc ? ($goc->expiry_date ? '=DATEVALUE("' . $goc->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $cocR ? ($cocR->expiry_date ? '=DATEVALUE("' . $cocR->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $cocG ? ($cocG->expiry_date ? '=DATEVALUE("' . $cocG->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $bt ? ($bt->expiry_date ? '=DATEVALUE("' . $bt->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $pscrb ? ($pscrb->expiry_date ? '=DATEVALUE("' . $pscrb->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $aff ? ($aff->expiry_date ? '=DATEVALUE("' . $aff->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $mefa ?( $mefa->expiry_date ? '=DATEVALUE("' . $mefa->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $meca ?( $meca->expiry_date ? '=DATEVALUE("' . $meca->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $sdsd ?( $sdsd->expiry_date ? '=DATEVALUE("' . $sdsd->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>N/A</td>

			@php
				$medical = null; $daat = null; $yf = null; $polio = null; $covid = null;

				foreach($obc->document_med_cert as $doc){
					if($doc->type == "MEDICAL CERTIFICATE"){
						if($medical == null){
							$medical = $doc;
						}
						else{
							if($doc->issue_date > $medical->issue_date){
								$medical = $doc;
							}
						}
					}
					elseif($doc->type == "DRUG AND ALCOHOL TEST"){
						$daat = $doc;
					}
					elseif($doc->type == "YELLOW FEVER"){
						$yf = $doc;
					}
					elseif($doc->type == "POLIO VACCINE (IPV)"){
						$polio = $doc;
					}
					elseif(str_contains($doc->type, "COVID")){
						$covid = $doc;
					}
				}
			@endphp

			<td>{{ $medical ? ($medical->expiry_date ? '=DATEVALUE("' . $medical->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $daat ? ($daat->expiry_date ? '=DATEVALUE("' . $daat->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $yf ? ($yf->expiry_date ? '=DATEVALUE("' . $yf->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $polio ? ($polio->expiry_date ? '=DATEVALUE("' . $polio->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $covid ? ($covid->expiry_date ? '=DATEVALUE("' . $covid->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>


			<td>{{ $kosma ? ($kosma->expiry_date ? '=DATEVALUE("' . $kosma->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $kml ? ($kml->expiry_date ? '=DATEVALUE("' . $kml->expiry_date->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>

			<td></td>
		</tr>
	@endforeach
</table>