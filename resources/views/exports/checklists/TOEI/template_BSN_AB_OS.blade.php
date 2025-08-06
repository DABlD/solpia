@php
	$vFlag = $data->vessel->flag ?? "-";
	
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
			elseif($doc == "SSBT WITH BRM"){
				$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;

				if(!$docu){
					$doc = "BRM";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				if(!$docu){
					$doc = "BRIDGE RESOURCE MANAGEMENT";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				if(!$docu){
					$doc = "BRIDGE RESOURCE AND TEAM MANAGEMENT";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				if(!$docu){
					$doc = "SSBT";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				if(!$docu){
					$doc = "BRTM";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
			}
			elseif($doc == "DECK WATCH"){
				$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;

				if(!$docu){
					$doc = "DECK WATCHKEEPING";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
			}
			elseif($doc == "SAFETY OFFICER"){
				foreach(get_object_vars($data->document_lc) as $document){
				    if(str_contains($document->type, $doc)){
				    	$docu = $document;
				    }
				}
			}
			elseif($doc == "SSBT2"){
				foreach(get_object_vars($data->document_lc) as $document){
				    if(str_contains($document->type, "SSBT") && str_contains($document->issuer, "MAGSAYSAY")){
				    	$docu = $document;
				    }
				}
			}
			else{
				if($type != "flag"){
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				else{
					$country = isset($data->vessel) ? ucwords(strtolower($data->vessel->flag)) : "-";
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

	$con = function($display){
		$font = 'font-family: Wingdings 2; font-size: 11px;';

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
	{{ $doc("COC", "MARINA COP II/4 - NAVIGATIONAL WATCH", 'lc', 1, 'II/4') }}
	{{ $doc("COE", "MARINA COP II/5 - ABLE SEAFARER DECK", 'lc', 1, 'II/5') }}
	{{ $doc("BASIC TRAINING - BT", "BASIC TRAINING (BT)", 'lc') }}
	@php
		$a = "PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB";
		$b = "SURVIVAL CRAFT & RESCUE BOAT (PSCRB)"
	@endphp
	{{ $doc($a, $b, 'lc') }}
	{{ $doc("ADVANCE FIRE FIGHTING - AFF", "ADVANCED FIREFIGHTING (AFF)", 'lc') }}
	{{ $doc("SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD", "SHIP SAFETY AWARENESS TRAINING (SSAT & SDSD)", 'lc') }}
	{{ $doc("EMPTY", "", 'lc') }}
	{{ $doc("EMPTY", "", 'lc') }}

	{{ $section("5. FLAG DOCUMENTS", 0) }}
	{{ $doc("BOOKLET", "FLAG BOOKLET", 'flag') }}
	{{ $doc("SDSD", "FLAG SDSD ENDORSEMENT", 'flag') }}
	{{ $doc("EMPTY", "", 'lc') }}
	{{ $doc("EMPTY", "", 'lc') }}
	{{ $doc("EMPTY", "", 'lc') }}

	{{ $section("6. TRAINING CERTIFICATES", 1) }}
	{{ $doc("DECK WATCH", "DECK WATCHKEEPING", 'lc', 2) }}
	{{ $doc("CONSOLIDATED MARPOL", "CONSOLIDATED MARPOL (ANNEX I-VI)", 'lc', 2) }}
	{{ $doc("STEERING COURSE", "STEERING COURSE", 'lc', 2) }}
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
	{{ $doc("ISM", "ISM CODE", 'lc', 2) }}
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
	@if(!isset($data->vessel))
		@if(in_array($data->rank2->id, [14,19]))
			{{ $doc("TRB", "CADET TRAINING RECORD BOOK", 'lc') }}
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
		{{ $doc("TEST", "", 'lc') }}
		{{ $doc("TEST", "", 'lc') }}
	{{-- //TOEI JAPAN | TOEI KOREA | TAIYO KAIUN --}}
	{{-- // DIAMOND Q, WEST T, ULTRA C, QUEEN F, MARGUERITE, HAPPINESS B, PACIFIC I, AFRICAN L, CAPE S, HAPPINESS F, GOLD O, SILVER O, CORONA R, LADY M, ULTRA V, ALAM K, CENTURION S, NORVIC C, CMB M, IKAN B, CAMELLIA I, DORIC K, WISTERIA, INDIGO J, EGRET R, NORD A, NORD D,--}}
	@elseif(in_array($data->vessel->id, [4613, 4615, 938, 4620, 4802, 5587, 61, 5, 6200, 27, 940, 949, 743, 952, 67, 6196, 5563, 6141, 4659, 4626, 4625, 4646, 4648, 4610, 4579, 4647, 4649, 6360, 8858, 9540]))
		{{-- CE/1AE --}}
		@if(in_array($data->rank2->id, [5, 6, 53]))
			{{ $doc("SAFETY OFFICER", "SHIP SAFETY OFFICERS COURSE", 'lc') }}
			{{ $doc("SMS FAMILIARIZATION", "SMS FAMILIARIZATION", 'lc') }}
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
		@else
			{{ $doc("SMS FAMILIARIZATION", "SMS FAMILIARIZATION", 'lc') }}
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			
			{{-- NORD A. TRITON CENTURY --}}
			@if(in_array($data->vessel->id, [6196,4647]))
				{{ $con("FINAL BRIEFING") }}
			@else
				{{ $doc("TEST", "", 'lc') }}
			@endif

			@if(in_array($data->rank2->id, [14,19]))
				{{ $doc("TRB", "CADET TRAINING RECORD BOOK", 'lc') }}
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
		@endif
	{{-- // NSSSM --}}
	{{-- // ULTRA P, IYO S --}}
	@elseif(in_array($data->vessel->id, [727, 247]))
		// MSTR CO 2O
		@if(in_array($data->rank2->id, [1]))
			{{ $doc("SAFETY OFFICER", "SHIP SAFETY OFFICERS COURSE", 'lc') }}
			{{ $doc("SSBT2", "SSBT with BRM (MAGSAYSAY)", 'lc') }}
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			{{ $doc("FUJI TRAINING", "FUJI TRAINING (FUJI TRADING)", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
		@elseif(in_array($data->rank2->id, [2,3]))
			{{ $doc("SAFETY OFFICER", "SHIP SAFETY OFFICERS COURSE", 'lc') }}
			{{ $doc("SSBT2", "SSBT with BRM (MAGSAYSAY)", 'lc') }}
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
		@elseif(in_array($data->rank2->id, [24]))
			{{ $doc("FUJI TRAINING", "FUJI TRAINING (FUJI TRADING)", 'lc') }}
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
		@elseif(in_array($data->rank2->id, [4]))
			{{ $doc("SSBT2", "SSBT with BRM (MAGSAYSAY)", 'lc') }}
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
		@else
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			@if(in_array($data->rank2->id, [14,19]))
				{{ $doc("TRB", "CADET TRAINING RECORD BOOK", 'lc') }}
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
		@endif
	{{-- KITAURA KAIUN --}}
	{{-- CELEBES CLOVER, GLORIOUS ROSE --}}
	@elseif(in_array($data->vessel->id, [4751, 5049]))
		{{-- MSTR, CE, 1AE, 2E --}}
		@if(in_array($data->rank2->id, [1]))
			{{ $doc("SAFETY OFFICER", "SHIP SAFETY OFFICERS COURSE", 'lc') }}
			{{ $doc("BULK CARRIER SHIP INSPECTION TRAINING", "BULK CARRIER SHIP INSPECTION TRAINING", 'lc') }}
			{{ $doc("WOODCHIP", "WOOD CHIP CARRIER MAINTENANCE AND HANDLING", 'lc') }}
			{{ $doc("SHIPBOARD HAZARDS SIMULATION AND SITUATIONAL AWARENESS TRAINING", "SHIPBOARD HAZARDS SIMULATION AND SITUATIONAL AWARENESS TRAINING", 'lc') }}
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
		{{-- CO --}}
		@elseif(in_array($data->rank2->id, [2]))
			{{ $doc("SAFETY OFFICER", "SHIP SAFETY OFFICERS COURSE", 'lc') }}
			{{ $doc("ENCLOSED SPACE ENTRY", "ENCLOSED SPACE ENTRY", 'lc') }}
			{{ $doc("BULK CARRIER SHIP INSPECTION TRAINING", "BULK CARRIER SHIP INSPECTION TRAINING", 'lc') }}
			{{ $doc("WOODCHIP", "WOOD CHIP CARRIER MAINTENANCE AND HANDLING", 'lc') }}
			{{ $doc("SHIPBOARD HAZARDS SIMULATION AND SITUATIONAL AWARENESS TRAINING", "SHIPBOARD HAZARDS SIMULATION AND SITUATIONAL AWARENESS TRAINING", 'lc') }}
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
		{{-- ENGINE OFFICERS EXCEPT FROM BIG 4 --}}
		@elseif(in_array($data->rank2->id, [7,8,54,55,57]))
			{{ $doc("WOODCHIP", "WOOD CHIP CARRIER MAINTENANCE AND HANDLING", 'lc') }}
			{{ $doc("SHIPBOARD HAZARDS SIMULATION AND SITUATIONAL AWARENESS TRAINING", "SHIPBOARD HAZARDS SIMULATION AND SITUATIONAL AWARENESS TRAINING", 'lc') }}
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
		{{-- THE REST OF DECK CREW --}}
		@elseif(in_array($data->rank2->id, [3,4,19,11,12,13,14,37,49,42,47,51]))
			{{ $doc("WOODCHIP", "WOOD CHIP CARRIER MAINTENANCE AND HANDLING", 'lc') }}
			{{ $doc("SHIPBOARD HAZARDS SIMULATION AND SITUATIONAL AWARENESS TRAINING", "SHIPBOARD HAZARDS SIMULATION AND SITUATIONAL AWARENESS TRAINING", 'lc') }}
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			@if(in_array($data->rank2->id, [14,19]))
				{{ $doc("TRB", "CADET TRAINING RECORD BOOK", 'lc') }}
			@else
				{{ $doc("TEST", "", 'lc') }}
			@endif
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
		{{-- BSN --}}
		@elseif(in_array($data->rank2->id, [9]))
			{{ $doc("BULK CARRIER SHIP INSPECTION TRAINING", "BULK CARRIER SHIP INSPECTION TRAINING", 'lc') }}
			{{ $doc("WOODCHIP", "WOOD CHIP CARRIER MAINTENANCE AND HANDLING", 'lc') }}
			{{ $doc("SHIPBOARD HAZARDS SIMULATION AND SITUATIONAL AWARENESS TRAINING", "SHIPBOARD HAZARDS SIMULATION AND SITUATIONAL AWARENESS TRAINING", 'lc') }}
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
		@else
			{{ $doc("SHIPBOARD HAZARDS SIMULATION AND SITUATIONAL AWARENESS TRAINING", "SHIPBOARD HAZARDS SIMULATION AND SITUATIONAL AWARENESS TRAINING", 'lc') }}
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
		@endif
	{{-- SMTECH --}}
	{{-- ULTRA R, MARITIME L, MARITIME K, CMB VAN DIJCK--}}
	@elseif(in_array($data->vessel->id, [66,51,231,4608]))
		{{-- MSTR --}}
		@if(in_array($data->rank2->id, [1]))
			{{ $con("HATCH COVER") }}
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			{{ $doc("IT EQUIPMENT SELF DECLARATION", "IT EQUIPMENT SELF DECLARATION", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
		@endif
		{{-- CO --}}
		@if(in_array($data->rank2->id, [2]))
			{{ $doc("SAFETY OFFICER", "SHIP SAFETY OFFICERS COURSE", 'lc') }}
			{{ $con("HATCH COVER") }}
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			{{ $doc("IT EQUIPMENT SELF DECLARATION", "IT EQUIPMENT SELF DECLARATION", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
		@else
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			{{ $doc("IT EQUIPMENT SELF DECLARATION", "IT EQUIPMENT SELF DECLARATION", 'lc') }}
			@if(in_array($data->rank2->id, [14,19]))
				{{ $doc("TRB", "CADET TRAINING RECORD BOOK", 'lc') }}
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
		@endif
	{{-- SHOEI KISEN --}}
	{{-- FEDERAL IMABARI, FEDERAL ICON, --}}
	@elseif(in_array($data->vessel->id, [23, 4634]))
		{{-- BIG 4 EXCEPT CO --}}
		@if(in_array($data->rank2->id, [1,5,6,53]))
			{{ $doc("CES TEST", "CES TEST", 'lc') }}
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			{{ $doc("IT EQUIPMENT SELF DECLARATION", "IT EQUIPMENT SELF DECLARATION", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
		@endif
		{{-- CO --}}
		@if(in_array($data->rank2->id, [2]))
			{{ $doc("SAFETY OFFICER", "SHIP SAFETY OFFICERS COURSE", 'lc') }}
			{{ $doc("CES TEST", "CES TEST", 'lc') }}
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			{{ $doc("IT EQUIPMENT SELF DECLARATION", "IT EQUIPMENT SELF DECLARATION", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
		@else
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			{{ $doc("IT EQUIPMENT SELF DECLARATION", "IT EQUIPMENT SELF DECLARATION", 'lc') }}
			@if(in_array($data->rank2->id, [14,19]))
				{{ $doc("TRB", "CADET TRAINING RECORD BOOK", 'lc') }}
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
		@endif
	{{-- SHUNZAN KAIUN --}}
	{{-- SPRING S, --}}
	@elseif(in_array($data->vessel->id, [4619]))
		{{-- CO --}}
		@if(in_array($data->rank2->id, [2]))
			{{ $doc("SAFETY OFFICER", "SHIP SAFETY OFFICERS COURSE", 'lc') }}
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
			{{ $doc("TEST", "", 'lc') }}
		@else
			{{ $doc("HAZMAT", "HAZMAT", 'lc') }}
			{{ $con("MENTAL HEALTH") }}
			@if(in_array($data->rank2->id, [14,19]))
				{{ $doc("TRB", "CADET TRAINING RECORD BOOK", 'lc') }}
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
		@endif
	{{-- NITTA KISEN --}}
	{{-- ANCASH A, ANLANTIC O, ATLANTIC B, NORD S, WECO E--}}
	@elseif(in_array($data->vessel->id, [7,8,9,4662,4765]))
		@php
			$temp = null;
			if(isset($data->document_med_cert->{'COVID-19 1ST DOSE'})){
				$temp = 'COVID-19 1ST DOSE';
			}
			if(isset($data->document_med_cert->{'COVID-19 2ND DOSE'})){
				$temp = 'COVID-19 2ND DOSE';
			}
			if(isset($data->document_med_cert->{'COVID-19 3RD DOSE'})){
				$temp = 'COVID-19 3RD DOSE';
			}
			if(isset($data->document_med_cert->{'COVID-19 4TH DOSE'})){
				$temp = 'COVID-19 4TH DOSE';
			}
		@endphp

		{{-- MSTR --}}
		@if(in_array($data->rank2->id, [1]))
			{{ $doc($temp, "COVID VACCINE - 1ST DOSE / 2ND DOSE / BOOSTER", 'med_cert') }}
			{{ $con("TOEI BRIEFING / JOINING CHECKLIST") }}
			{{ $con("PREJOINING BRIEFING CHECKLIST FOR CAPT &#38; CE") }}
			{{ $con("LETTER OF OATH MARPOL") }}
			{{ $con("LETTER OF OATH - DRUG &#38; ALCOHOL POLICY / SOCIAL MEDIA GUIDANCE") }}
			{{ $con("ECPT / MANAGEMENT SYSTEM TRAINING") }}
			{{ $con("DECLARATION OF ENVIRONMENTAL COMMITMENT") }}
			{{ $con("PRE JOINING EMS TRAINING RECORD") }}
			{{ $con("QUESTIONNAIRES TO SEAFARERS ON EMPLOYMENMT CONTRACT (P1-2)") }}
			{{ $con("PCR RESULT") }}
			{{ $doc("TEST", "", 'lc') }}
		@endif
		{{-- CO --}}
		@if(in_array($data->rank2->id, [2]))
			{{ $doc($temp, "COVID VACCINE - 1ST DOSE / 2ND DOSE / BOOSTER", 'med_cert') }}
			{{ $con("TOEI BRIEFING / JOINING CHECKLIST") }}
			{{ $con("LETTER OF OATH MARPOL") }}
			{{ $doc("SAFETY OFFICER", "SHIP SAFETY OFFICERS COURSE (SSOC) (CO &#38; CE)", 'lc') }}
			{{ $con("LETTER OF OATH - DRUG &#38; ALCOHOL POLICY / SOCIAL MEDIA GUIDANCE") }}
			{{ $con("ECPT / MANAGEMENT SYSTEM TRAINING") }}
			{{ $con("DECLARATION OF ENVIRONMENTAL COMMITMENT") }}
			{{ $con("PRE JOINING EMS TRAINING RECORD") }}
			{{ $con("QUESTIONNAIRES TO SEAFARERS ON EMPLOYMENMT CONTRACT (P1-2)") }}
			{{ $con("PCR RESULT") }}
			{{ $doc("TEST", "", 'lc') }}
		{{-- CE --}}
		@endif
		@if(in_array($data->rank2->id, [5]))
			{{ $doc($temp, "COVID VACCINE - 1ST DOSE / 2ND DOSE / BOOSTER", 'med_cert') }}
			{{ $con("TOEI BRIEFING / JOINING CHECKLIST") }}
			{{ $con("PREJOINING BRIEFING CHECKLIST FOR CAPT &#38; CE") }}
			{{ $con("LETTER OF OATH MARPOL") }}
			{{ $doc("SAFETY OFFICER", "SHIP SAFETY OFFICERS COURSE (SSOC) (CO &#38; CE)", 'lc') }}
			{{ $con("LETTER OF OATH - DRUG &#38; ALCOHOL POLICY / SOCIAL MEDIA GUIDANCE") }}
			{{ $con("ECPT / MANAGEMENT SYSTEM TRAINING") }}
			{{ $con("DECLARATION OF ENVIRONMENTAL COMMITMENT") }}
			{{ $con("PRE JOINING EMS TRAINING RECORD") }}
			{{ $con("QUESTIONNAIRES TO SEAFARERS ON EMPLOYMENMT CONTRACT (P1-2)") }}
			{{ $con("PCR RESULT") }}
		@else
			{{ $doc($temp, "COVID VACCINE - 1ST DOSE / 2ND DOSE / BOOSTER", 'med_cert') }}
			{{ $con("TOEI BRIEFING / JOINING CHECKLIST") }}
			{{ $con("LETTER OF OATH MARPOL") }}
			{{ $con("LETTER OF OATH - DRUG &#38; ALCOHOL POLICY / SOCIAL MEDIA GUIDANCE") }}
			{{ $con("ECPT / MANAGEMENT SYSTEM TRAINING") }}
			{{ $con("DECLARATION OF ENVIRONMENTAL COMMITMENT") }}
			{{ $con("PRE JOINING EMS TRAINING RECORD") }}
			{{ $con("QUESTIONNAIRES TO SEAFARERS ON EMPLOYMENMT CONTRACT (P1-2)") }}
			{{ $con("PCR RESULT") }}
			@if(in_array($data->rank2->id, [14,19]))
				{{ $doc("TRB", "CADET TRAINING RECORD BOOK", 'lc') }}
			@else
				{{ $doc("TEST", "", 'lc') }}
			@endif
			{{ $doc("TEST", "", 'lc') }}
		@endif
	@endif

	<tr>
		<td colspan="9" style="font-style: italic;">Note: (*) Original Copy was provided to crew as Personal Copy</td>
	</tr>

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