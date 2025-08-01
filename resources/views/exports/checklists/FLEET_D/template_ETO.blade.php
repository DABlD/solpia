@php
	$vFlag = $data->vessel->flag;
	
	$checkDate = function($issue, $expiry, $type2){
		if($type2 == 1){
			if($issue != "" && $issue != null){
				return "UNLIMITED";
			}

			return null;
		}
		elseif($type2 == 2){
			if($issue != "" && $issue != null){
				return $issue->format('d-M-Y');
			}

			return null;
		}
		else{
			if($expiry == null || $expiry == ""){
				if($issue == null || $issue == ""){
					return "N/A";
				}
				else{
					return "UNLIMITED";
				}
			}

			return $expiry->format('d-M-Y');
		}
	};

	$cleanText = function($text){
		return str_replace('&', '&#38;', $text);
	};

	$section = function($type, $date) use($cleanText){
		$date = $date ? 'ISSUANCE' : 'VALIDITY';
		$type = $cleanText($type);

		$style = "font-weight: bold; background-color: #c0c0c0;";
		$left = 'text-align: left !important;';

		echo "
			<tr>
				<td colspan='3' style='$style $left'>$type</td>
				<td style='$style text-align: middle;'>$date DATE</td>
				<td style='$style text-align: middle;'>SMI</td>
				<td style='$style text-align: middle;'>CREW</td>
				<td style='$style text-align: middle;'>SCAN</td>
				<td style='$style text-align: middle;'>SIGN-OFF</td>
				<td style='$style text-align: middle;'>REMARKS</td>
			</tr>
		";
	};

	$doc = function($doc, $display, $type, $type2 = 0, $regulation = null) use($checkDate, $data, $cleanText){
		$display = $cleanText($display);
		$docu = null;

		if($regulation){
			foreach(get_object_vars($data->document_lc) as $document){
				$regulations = json_decode($document->regulation);

			    if(str_contains($document->type, $doc) && in_array($regulation, $regulations)){
			        $docu = $document;
			    }
			}
		}
		else{
			if($doc == "RADAR"){
				$doc = "RADAR SIMULATOR COURSE";
				$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;

				if(!$docu){
					$doc = "RADAR TRAINING COURSE";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
			}
			elseif($doc == "ARPA TRAINING COURSE"){
				$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;

				if(!$docu){
					$doc = "RADAR OPERATOR PLOTTING AID";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
			}
			elseif($doc == "ERS WITH ERM"){
				$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;

				if(!$docu){
					$doc = "ERS";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				if(!$docu){
					$doc = "ERM";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				if(!$docu){
					$doc = "ENGINE RESOURCE MANAGEMENT";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				if(!$docu){
					$doc = "ENGINE ROOM RESOURCE MANAGEMENT";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
			}
			elseif($doc == "MARINE ELECTRICAL"){
				$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;

				if(!$docu){
					$doc = "MARINE ELECTRICAL TRAINING";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
			}
			elseif($doc == "ENGINE WATCH"){
				$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;

				if(!$docu){
					$doc = "ENGINE WATCHKEEPING";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
			}
			elseif($doc == "WELDING"){
				foreach(get_object_vars($data->document_lc) as $document){
				    if(str_contains($document->type, $doc)){
				    	$docu = $document;
				    }
				}
			}
			else{
				if($type != "flag"){
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				else{
					$country = ucwords(strtolower($data->vessel->flag));
					foreach (get_object_vars($data->document_flag) as $flag) {
						if($flag->country == $country && $flag->type == $doc){
							$docu = $flag;
						}
					}
					$type2 = 0;
				}
			}
		}

		$date = $docu ? $checkDate($docu->issue_date, $docu->expiry_date, $type2) : '';

		$font = 'font-family: Wingdings 2; font-size: 11px;';

		$left = 'text-align: left !important;';
		
		echo "
			<tr>
				<td colspan='3' style='$left'>$display</td>
				<td>$date</td>
				<td style='$font'>0</td>
				<td style='$font'>0</td>
				<td style='$font'>0</td>
				<td style='$font'>0</td>
				<td></td>
			</tr>
		";
	};

	$con = function($display) use($cleanText){
		$font = 'font-family: Wingdings 2; font-size: 11px;';
		$display = $cleanText($display);

		echo "
			<tr>
				<td colspan='3'>$display</td>
				<td></td>
				<td style='$font'>0</td>
				<td style='$font'>0</td>
				<td style='$font'>0</td>
				<td style='$font'>0</td>
				<td></td>
			</tr>
		";
	}
@endphp

<table>
	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="9" style="text-decoration: underline; font-weight: bold; font-style: italic; background-color: #c0c0c0;">CREW DOCUMENT FINAL CHECKLIST</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td style="font-weight: bold;">JOINING DATE:</td>
		<td colspan="3" style="color: #f0060e;">
			{{ $data->departure ? $data->departure->format('d-M-Y') : '' }}
		</td>
		<td colspan="2" style="text-align: left; font-weight: bold;">JOINING PORT:</td>
		<td colspan="3">{{ $data->port ?? '' }}</td>
	</tr>

	<tr>
		<td style="font-weight: bold;">NAME:</td>
		<td colspan="3" style="color: #f0060e;">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td colspan="2" style="font-weight: bold;">Vessel:</td>
		<td colspan="3" style="color: #f0060e;">
			{{ $data->vessel->name ?? '' }}
		</td>
	</tr>

	<tr>
		<td style="font-weight: bold;">POSITION:</td>
		<td colspan="3" style="color: #f0060e;">{{ $data->rank }}</td>
		<td colspan="2" style="font-weight: bold;">Flag/Type:</td>
		<td colspan="3" style="color: #f0060e;">
			{{ $data->vessel->flag ?? '' }} / {{ $data->vessel->type ?? '' }}
		</td>
	</tr>

	<tr>
		<td colspan="8" style="height: 1px;"></td>
	</tr>

	{{ $section("1. ID DOCUMENTS", 0) }}
	{{ $doc("PASSPORT", "PASSPORT", 'id') }}
	{{ $doc("SEAMAN'S BOOK", "SEAMAN'S BOOK", 'id') }}
	{{ $doc("US-VISA", "US-VISA (R C1/D)", 'id') }}
	{{ $doc("SID", "SID (SEAFARER'S IDENTITY DOCUMENT)", 'id') }}
	{{ $doc("MCV", "AUSTRALIAN MCV (MARITIME CREW VISA)", 'id') }}

	{{ $section("2. MEDICAL / VACCINATION", 0) }}
	{{ $doc("MEDICAL CERTIFICATE", "MEDICAL CERTIFICATE", 'med_cert') }}
	{{ $doc("FLAG MEDICAL", "FLAG MEDICAL($vFlag)", 'med_cert') }}
	{{ $doc("YELLOW FEVER", "YELLOW FEVER", 'med_cert') }}
	{{ $doc("POLIO VACCINE (IPV)", "POLIO VACCINE", 'med_cert') }}

	{{ $section("3. SEAFARER'S EMPLOYMENT AGREEMENT", 1) }}
	{{ $con("POEA CONTRACT") }}
	{{ $con("MLC CONTRACT") }}
	{{ $con("MLC 5.1.5 COMPLAINT PROCEDURE") }}

	{{ $section("4. NATIONAL LICENSE / COP", 0) }}
	{{ $doc("COE", "ELECTRO-TECHNICAL OFFICER (CERTIFICATE) - III/6", 'lc', 1, 'III/6') }}
	{{ $doc("BASIC TRAINING - BT", "BASIC TRAINING (BT)", 'lc') }}
	@php
		$a = "PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB";
		$b = "SURVIVAL CRAFT & RESCUE BOAT (PSCRB)"
	@endphp
	{{ $doc($a, $b, 'lc') }}
	{{ $doc("ADVANCE FIRE FIGHTING - AFF", "ADVANCED FIREFIGHTING (AFF)", 'lc') }}
	{{ $doc("MEDICAL FIRST AID - MEFA", "MEDICAL FIRST AID (MEFA)", 'lc') }}
	{{ $doc("SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD", "SHIP SAFETY AWARENESS TRAINING (SSAT & SDSD)", 'lc') }}
	{{ $doc("EMPTY", "", 'lc') }}
	{{ $doc("EMPTY", "", 'lc') }}

	{{ $section("5. FLAG DOCUMENTS", 0) }}
	{{ $doc("BOOKLET", "FLAG BOOKLET", 'flag') }}
	{{ $doc("EMPTY", "", 'lc') }}
	{{ $doc("EMPTY", "", 'lc') }}
	{{ $doc("EMPTY", "", 'lc') }}
	{{ $doc("EMPTY", "", 'lc') }}

	{{ $section("6. TRAINING CERTIFICATES", 1) }}
	{{ $doc("ENGINE WATCH", "ENGINE WATCHKEEPING", 'lc', 2) }}
	{{ $doc("CONSOLIDATED MARPOL", "CONSOLIDATED MARPOL (ANNEX I-VI)", 'lc', 2) }}
	{{ $doc("WELDING", "WELDING TRAINING", 'lc', 2) }}
	{{ $doc("EMPTY", "", 'lc') }}
	{{ $doc("EMPTY", "", 'lc') }}
	{{ $doc("EMPTY", "", 'lc') }}
	{{ $doc("EMPTY", "", 'lc') }}
	{{ $doc("EMPTY", "", 'lc') }}
	{{ $doc("EMPTY", "", 'lc') }}

	{{ $section("7. IN HOUSE CERTIFICATE / SPECIAL TRAINING", 1) }}
	{{ $doc("PDOS", "PRE-DEPARTURE ORIENTATION SEMINAR (PDOS)", 'lc', 2) }}
	{{ $doc("ANTI PIRACY", "ANTI-PIRACY", 'lc', 2) }}
	{{ $doc("MCRA", "MARITIME CYBER RISK AWARENESS (MCRA)", 'lc', 2) }}
	{{ $doc("IN HOUSE TRAINING CERT WITH ISM", "ISM CODE", 'lc', 2) }}
	{{ $doc("GTRB", "GENERAL TRAINING RECORD BOOK", 'lc', 2) }}

	{{ $section("8. TRAVEL DOCUMENTS", 1) }}
	{{ $con("E-TICKET") }}
	{{ $con("GUARANTEE LETTER") }}
	{{ $con("OK TO BOARD") }}
	{{ $con("OEC") }}
	{{ $con("ENTRY / TRANSIT VISA") }}

	{{ $section("9. OTHERS", 1) }}
	{{ $con("BIO-DATA (PERSONAL DATA RECORD)") }}
	{{ $con("ALLOTMENT SUMMARY *") }}
	{{ $con("TURN-OVER NOTES") }}

	{{ $section("10. PRINCIPAL / OWNERS REQUIREMENTS", 1) }}

	@if(in_array($data->vessel->principal_id, [1, 3]))
		{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
		{{ $con("JOINING FINAL BRIEFING") }}
		{{ $con("SHINKO INVENTORY") }}
		{{ $con("MENTAL HEALTH AWARENESS") }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
	@elseif(in_array($data->vessel->principal_id, [8]))
		{{ $con("INTERGIS BRIEFING") }}
		{{ $con("MENTAL HEALTH AWARENESS") }}
		{{ $doc("KOSMA TRAINING CERTIFICATE", "KOSMA", 'lc') }}
		{{ $con("HANJOO MEDICAL HISTORY CHECKLIST") }}
		{{ $doc("KML", "KOREAN MARITIME LAW COURSE", 'lc') }}
		{{ $doc("DRUG AND ALCOHOL TEST", "PANAMA ADDITIONAL TEST (DRUG & ALCOHOL)", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
	@elseif(in_array($data->vessel->principal_id, [5]))
		{{ $doc("KOSMA TRAINING CERTIFICATE", "KOSMA", 'lc') }}
		{{ $doc("KML", "KOREAN MARITIME LAW COURSE", 'lc') }}
		{{-- GNS HARVEST --}}
		@if($data->vessel->id == 4753)
			{{ $doc("DRUG AND ALCOHOL TEST", "PANAMA ADDITIONAL TEST (DRUG & ALCOHOL)", 'lc') }}
		@else
			{{ $doc("TEST", "", 'lc') }}
		@endif
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
	@elseif(in_array($data->vessel->principal_id, [547]))
		{{ $con("DLSM BRIEFING") }}
		{{ $con("MENTAL HEALTH AWARENESS") }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
	@elseif(in_array($data->vessel->principal_id, [14]))
		{{ $con("NSM - SMM 07 - 14 PRE-JOINING FAMILARISATION", 1,1,1) }}
		{{ $con("NSM - SMM 07 - 15 Pre BriefingJoining", 1,1,1) }}
		{{ $con("NSM - SMM 07 - 16 Briefing pre Joining", 1,1,1) }}
		{{ $con("NSM - SMM 07 - 18 DRUG & ALCOHOL DECLARATION", 1,1,1) }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
	@elseif(in_array($data->vessel->principal_id, [897]))
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
	@else
		{{ $con("MENTAL HEALTH AWARENESS") }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
	@endif

	<tr>
		<td colspan="9" style="font-style: italic;">Note: (*) Original Copy was provided to crew as Personal Copy</td>
	</tr>

	<tr><td colspan="9"></td></tr>

	<tr>
		<td style="font-weight: bold; height: 15px;">DISPATCHED:</td>
		<td colspan="3" style="font-weight: bold;">{{ $data->officer }}</td>
		<td colspan="2" style="height: 15px;">CONFIRMED:</td>
		<td colspan="3" style="font-weight: bold; vertical-align: top !important;">{{ $data->user->namefull }}</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="3" style="font-weight: bold;">CREWING OFFICER / DATE</td>
		<td colspan="2"></td>
		<td colspan="3" style="font-weight: bold;">CREW SIGNATURE OVER PRINTED NAME / DATE</td>
	</tr>

	<tr><td colspan="9"></td></tr>

	<tr>
		<td style="font-weight: bold; height: 15px;">SCANNED:</td>
		<td colspan="3" style="font-weight: bold;">{{ $data->documentation }}</td>
		<td colspan="2" style="height: 15px;">VERIFIED:</td>
		<td colspan="3" style="font-weight: bold; vertical-align: top !important;">{{ $data->manager }}</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="3" style="font-weight: bold;">DOCUMENTATION ASST. / DATE</td>
		<td colspan="2"></td>
		<td colspan="3" style="font-weight: bold;">CREW MANAGER / DATE</td>
	</tr>

	<tr><td colspan="9"></td></tr>

	<tr>
		<td style="font-weight: bold; height: 15px;">SIGN-OFF:</td>
		<td colspan="3" style="font-weight: bold;">{{ $data->officer }}</td>
		<td colspan="2" style="height: 15px;">CONFIRMED:</td>
		<td colspan="3" style="font-weight: bold; vertical-align: top !important;">{{ $data->user->namefull }}</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="3" style="font-weight: bold;">CREWING OFFICER / DATE</td>
		<td colspan="2"></td>
		<td colspan="3" style="font-weight: bold;">CREW SIGNATURE OVER PRINTED NAME / DATE</td>
	</tr>
</table>