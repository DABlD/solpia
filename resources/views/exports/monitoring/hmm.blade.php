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
		<td>{{ now()->format('m/d/Y') }}</td>
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
		<td colspan="7">NATIONAL ID / VISA</td>
		<td colspan="7">FLAG LICENSE</td>
		<td colspan="4">NATIONAL LICENSE</td>
		<td colspan="4">COP TRAININGS</td>
		<td></td>
		<td>MEDICAL</td>
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
		<td>OIC LICENSE</td>
		<td>GOC LICENSE</td>
		<td>COC-RATINGS</td>
		<td>COC-GALLEY</td>
		<td>COP BT</td>
		<td>COP PSCRB</td>
		<td>COP AFF</td>
		<td>COP SDSD</td>
		<td>KML LICENSE</td>
		<td>MEDICAL</td>
		<td>FACEBOOK NAME</td>
	</tr>

	@foreach($data as $obc)
		<tr>
			<td>{{ $loop->index + 1 }}</td>
			<td>{{ $vessel->principal->name }}</td>
			<td>{{ $vessel->name }}</td>
			<td>{{ $obc->applicant->user->crew->pro_app->rank->abbr }}</td>
			<td>{{ $obc->applicant->user->namefull }}</td>
			<td>{{ isset($obc->applicant->user->birthday) ? $obc->applicant->user->birthday->format('d-M-yy') : "N/A" }}</td>
			<td>{{ isset($obc->applicant->user->birthday) ? $obc->applicant->user->birthday->age : "N/A" }}</td>
			<td>{{ $obc->joining_date->format('d-M-yy') }}</td>

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
				$kml = null;
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
					elseif(str_contains($doc->type, "KML")){
						$kml = $doc;
					}
				}
			@endphp
			<td>{{ $oic ? ($oic->expiry_date ? '=DATEVALUE("' . $oic->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $goc ? ($goc->expiry_date ? '=DATEVALUE("' . $goc->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $cocR ? ($cocR->expiry_date ? '=DATEVALUE("' . $cocR->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $cocG ? ($cocG->expiry_date ? '=DATEVALUE("' . $cocG->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $bt ? ($bt->expiry_date ? '=DATEVALUE("' . $bt->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $pscrb ? ($pscrb->expiry_date ? '=DATEVALUE("' . $pscrb->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $aff ? ($aff->expiry_date ? '=DATEVALUE("' . $aff->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $sdsd ?( $sdsd->expiry_date ? '=DATEVALUE("' . $sdsd->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>
			<td>{{ $kml ? ($kml->expiry_date ? '=DATEVALUE("' . $kml->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>

			@php
				$docu = null;
				foreach($obc->document_med_cert as $doc){
					if($doc->type == "MEDICAL CERTIFICATE"){
						if($docu == null){
							$docu = $doc;
						}
						else{
							if($doc->issue_date > $docu->issue_date){
								$docu = $doc;
							}
						}
					}
				}
			@endphp

			<td>{{ $docu ? ($docu->expiry_date ? '=DATEVALUE("' . $docu->format('m/d/Y') . '")' : "UNLIMITED") : "N/A" }}</td>

			<td></td>
		</tr>
	@endforeach
</table>