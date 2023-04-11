@php
	$checkDate = function($issue, $expiry, $type2){
		if($type2){
			if($issue != "" && $issue != null){
				return "UNLIMITED";
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
				<td style='$style'>$date DATE</td>
				<td style='$style'>DISPATCH</td>
				<td style='$style'>SCAN</td>
				<td style='$style'>SIGN</td>
				<td style='$style'>REMARKS</td>
			</tr>
		";
	};

	$doc = function($doc, $display, $type, $type2 = 0, $regulation = null, $b1 = 1, $b2 = 1, $b3 = 1) use($checkDate, $data, $cleanText){
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
			elseif($doc == "CULINARY"){
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
					foreach (get_object_vars($data->document_flag) as $flag) {
						if($flag->country == "Malaysia" && $flag->type == $doc){
							$docu = $flag;
						}
					}
				}
			}
		}

		$date = $docu ? $checkDate($docu->issue_date, $docu->expiry_date, $type2) : '';

		$font1 = $b1 ? 'font-family: Wingdings 2; font-size: 12px;' : "";
		$font2 = $b2 ? 'font-family: Wingdings 2; font-size: 12px;' : "";
		$font3 = $b3 ? 'font-family: Wingdings 2; font-size: 12px;' : "";
		$left = 'text-align: left !important;';

		$b1 = $b1 ? '0' : 'N/A';
		$b2 = $b2 ? '0' : 'N/A';
		$b3 = $b3 ? '0' : 'N/A';
		
		echo "
			<tr>
				<td colspan='3' style='$left'>$display</td>
				<td>$date</td>
				<td style='$font1'>$b1</td>
				<td style='$font2'>$b2</td>
				<td style='$font3'>$b3</td>
				<td></td>
			</tr>
		";
	};

	$con = function($display, $b1, $b2, $b3){
		$font1 = $b1 ? 'font-family: Wingdings 2; font-size: 12px;' : "";
		$font2 = $b2 ? 'font-family: Wingdings 2; font-size: 12px;' : "";
		$font3 = $b3 ? 'font-family: Wingdings 2; font-size: 12px;' : "";

		$b1 = $b1 ? '0' : 'N/A';
		$b2 = $b2 ? '0' : 'N/A';
		$b3 = $b3 ? '0' : 'N/A';

		echo "
			<tr>
				<td colspan='3'>$display</td>
				<td></td>
				<td style='$font1'>$b1</td>
				<td style='$font2'>$b2</td>
				<td style='$font3'>$b3</td>
				<td></td>
			</tr>
		";
	}
@endphp

<table>
	<tr>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="8" style="text-decoration: underline; font-weight: bold; font-style: italic; background-color: #c0c0c0;">CREW DOCUMENT FINAL CHECKLIST</td>
	</tr>

	<tr>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td style="font-weight: bold;">DEPARTURE DATE:</td>
		<td colspan="3" style="color: #f0060e;">
			{{ $data->departure ? $data->departure->format('d-M-Y') : '' }}
		</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td style="font-weight: bold;">NAME:</td>
		<td colspan="3" style="color: #f0060e;">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td style="font-weight: bold;">Vessel:</td>
		<td colspan="2" style="color: #f0060e;">
			{{ $data->vessel->name ?? '' }}
		</td>
	</tr>

	<tr>
		<td style="font-weight: bold;">POSITION:</td>
		<td colspan="3" style="color: #f0060e;">{{ $data->rank }}</td>
		<td style="font-weight: bold;">Flag/Type:</td>
		<td colspan="2" style="color: #f0060e;">
			{{ $data->vessel->flag ?? '' }} / {{ $data->vessel->type ?? '' }}
		</td>
	</tr>

	<tr>
		<td colspan="8" style="height: 1px;"></td>
	</tr>

	{{ $section("1. ID DOCUMENTS", 0) }}
	{{ $doc("PASSPORT", "PASSPORT", 'id') }}
	{{ $doc("SEAMAN'S BOOK", "SEAMAN'S BOOK", 'id') }}
	{{ $doc("SID", "SID", 'id') }}
	{{ $doc("OEC", "OEC", 'id') }}
	{{ $doc("MCV", "MCV", 'id') }}

	{{ $section("2. FLAG DOCUMENTS", 0) }}
	{{ $doc("BOOKLET", "MALAYSIA ID", 'flag') }}

	{{ $section("3. NATIONAL LICENSES", 0) }}
	{{ $doc("NCIII", "COC - NC3 LICENSE", 'lc', 1) }}

	{{ $section("4. CERTIFICATES WITH COP", 0) }}
	{{ $doc("BASIC TRAINING - BT", "BASIC TRAINING (BT)", 'lc') }}
	@php
		$a = "PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB";
		$b = "PROFICIENCY IN SURVIVAL CRAFT & RESCUE BOAT (PSCRB)"
	@endphp
	{{ $doc($a, $b, 'lc') }}
	{{ $doc("SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD", "SDSD", 'lc') }}

	{{ $section("5. OTHER CERTIFICATES", 0) }}
	{{ $doc("CULINARY", "BASIC CULINARY COURSE", 'lc') }}

	{{ $section("6. MEDICAL / VACCINATION", 1) }}
	{{ $doc("MEDICAL CERTIFICATE", "MEDICAL CERTIFICATE", 'med_cert') }}
	{{ $doc("FLAG MEDICAL", "MALAYSIAN MEDICAL CERTIFICATE", 'med_cert') }}
	{{ $doc("DRUG AND ALCOHOL TEST", "DAAT", 'med_cert') }}
	{{ $doc("YELLOW FEVER", "YELLOW FEVER", 'med_cert') }}
	{{ $doc("POLIO VACCINE (IPV)", "POLIO VACCINE", 'med_cert') }}

	{{ $section("7. CONTRACT / ADDENDUM / BIO DATA", 1) }}
	{{ $con("POEA CONTRACT *", 1,0,1) }}
	{{ $con("MLC (SEA CONTRACT)", 1,0,1) }}
	{{ $con("DAAT DECLARATION", 1,0,1) }}
	{{ $con("PERSONAL DATA RECORD", 1,1,1) }}
	{{ $con("MLC 5.1.5 COMPLAINT PROCEDURE", 1,1,1) }}

	{{ $section("8. IN HOUSE CERTIFICATE / SPECIAL TRAINING", 1) }}
	{{ $con("NSM - SMM 07 - 14 PRE-JOINING FAMILARISATION", 1,1,1) }}
	{{ $con("NSM - SMM 07 - 15 Pre BriefingJoining", 1,1,1) }}
	{{ $con("NSM - SMM 07 - 16 Briefing pre Joining", 1,1,1) }}
	{{ $con("NAUTICA BRIEFING FORM", 1,1,1) }}
	{{ $doc("ANTI PIRACY", "ANTI PIRACY", 'lc') }}
	{{ $doc("IN HOUSE TRAINING CERT WITH ISM", "IN HOUSE TRAINING CERTIFICATE WITH ISM", 'lc') }}
	{{ $doc("GENERAL TRAINING RECORD BOOK", "GENERAL TRAINING RECORD BOOK", 'lc', null, null, 1,0,1) }}

	{{ $section("9. TRAVEL DOCUMENTS", 1) }}
	{{ $con("PDOS, ETICKET, LOG, OKTB, KOREAN VISA", 1,0,0) }}

	<tr>
		<td style="font-weight: bold;">REMARKS:</td>
	</tr>

	<tr>
		<td colspan="8">(*) DOCUMENTS GIVEN TO CREW AS PERSONAL COPY</td>
	</tr>

	<tr>
		<td colspan="8" rowspan="4">
			ALLOTMENT SUMMARY*
			<br style='mso-data-placement:same-cell;' />
			POEA CONTRACT*
		</td>
	</tr>

	<tr></tr>
	<tr></tr>
	<tr></tr>

	<tr>
		<td style="font-weight: bold; height: 15px;">SCAN</td>
		<td colspan="3" style="font-weight: bold;">{{ $data->officer }}</td>
	</tr>

	<tr>
		<td style="height: 15px;">Date:</td>
		<td colspan="3" style="font-weight: bold; vertical-align: top !important;">CREWING OFFICER</td>
	</tr>

	<tr>
		<td style="font-weight: bold; height: 15px;">DISPATCH</td>
		<td colspan="3" style="font-weight: bold; vertical-align: bottom !important;">{{ $data->manager }}</td>
		<td></td>
		<td colspan="3" style="font-weight: bold;">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
	</tr>

	<tr>
		<td style="height: 15px;">Date:</td>
		<td colspan="3" style="font-weight: bold;">CREWING MANAGER</td>
		<td></td>
		<td colspan="3" style="font-weight: bold;">SEAFARER</td>
	</tr>

	<tr>
		<td style="font-weight: bold; height: 15px;">SIGN OFF</td>
		<td colspan="3" style="font-weight: bold;"></td>
		<td></td>
		<td colspan="3" style="font-weight: bold;">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
	</tr>

	<tr>
		<td style="height: 15px;">Date:</td>
		<td colspan="3" style="font-weight: bold;"></td>
		<td></td>
		<td colspan="3" style="font-weight: bold;">SEAFARER</td>
	</tr>
</table>