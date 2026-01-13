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
			elseif(in_array($doc, ["HATCH COVER", "HAZMAT", "MENTAL HEALTH"])){
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

		$font = 'font-family: Wingdings 2;';
		
		echo "
			<tr>
				<td colspan='2'>$display</td>
				<td>$date</td>
				<td></td>
				<td style='$font'>0 0</td>
			</tr>
		";
	};

	$con = function($display) use($cleanText){
		$font = 'font-family: Wingdings 2; font-size: 11px;';
		$display = $cleanText($display);

		echo "
			<tr>
				<td colspan='2'>$display</td>
				<td></td>
				<td></td>
				<td style='$font'>0 0</td>
			</tr>
		";
	}
@endphp

<table>
	<tr>
		<td colspan="5" style="height: 45px;"></td>
	</tr>

	<tr>
		<td colspan="5">ENTRY DOCUMENTS</td>
	</tr>

	<tr>
		<td>Name:</td>
		<td>{{ $data->user->namefull }}</td>
		<td></td>
		<td>Vessel:</td>
		<td>{{ $data->vessel->name }}</td>
	</tr>

	<tr>
		<td>Position:</td>
		<td>{{ $data->rank }}</td>
		<td></td>
		<td>Date:</td>
		<td>{{ now()->toDateString() }}</td>
	</tr>

	<tr>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td colspan="2">Documents</td>
		<td>Validity Date</td>
		<td></td>
		<td>Dispatch</td>
	</tr>

	{{ $doc("PASSPORT", "PASSPORT", 'id') }}
	{{ $doc("US-VISA", "US-VISA (R C1/D)", 'id') }}
	{{ $doc("SEAMAN'S BOOK", "SEAMAN'S BOOK & SRC", 'id') }}
	{{ $doc("YELLOW FEVER", "YELLOW FEVER", 'med_cert') }}
	{{ $doc("TYPHOID", "TYPHOID", 'med_cert') }}
	{{ $doc("POLIO VACCINE", "POLIO VACCINE", 'med_cert') }}
	{{ $doc("MEDICAL CERTIFICATE", "MEDICAL CERTIFICATE", 'med_cert') }}
	{{ $con('Contract') }}

	<tr>
		<td colspan="2">National Assessed Certificates ( NAC ) / COC / COP</td>
		<td>Validity Date</td>
		<td></td>
		<td>DISPATCH</td>
	</tr>

	{{ $doc("COC", "MARINA COP II/2 - (CERTIFICATE)", 'lc', 1, 'II/2') }}
	{{ $doc("COE", "MARINA COP II/2 - (ENDORSEMENT)", 'lc', 1, 'II/2') }}
	{{ $doc("GMDSS/GOC", "MARINA GOC IV/2", 'lc', 0, 'IV/2') }}
	{{ $doc("COC", "MARINA COP III/2 - (CERTIFICATE)", 'lc', 1, 'III/2') }}
	{{ $doc("COE", "MARINA COP III/2 - (ENDORSEMENT)", 'lc', 1, 'III/2') }}
	{{ $doc("COC", "MARINA COP II/1 - (CERTIFICATE)", 'lc', 1, 'II/1') }}
	{{ $doc("COE", "MARINA COP II/1 - (ENDORSEMENT)", 'lc', 1, 'II/1') }}
	{{ $doc("COC", "MARINA COP III/1 - (CERTIFICATE)", 'lc', 1, 'III/1') }}
	{{ $doc("COE", "MARINA COP III/1 - (ENDORSEMENT)", 'lc', 1, 'III/1') }}
	{{ $doc("COC", "MARINA II/4", 'lc', 1, 'II/4') }}
	{{ $doc("COE", "MARINA II/5", 'lc', 1, 'II/5') }}
	{{ $doc("COC", "MARINA III/4", 'lc', 1, 'III/4') }}
	{{ $doc("COE", "MARINA III/5", 'lc', 1, 'III/5') }}
	{{ $doc("COC", "ELECTRO-TECHNICAL OFFICER (CERTIFICATE) - III/6", 'lc', 1, 'III/6') }}
	{{ $doc("NCI", "NATIONAL CERTIFICATE I", 'lc', 1) }}
	{{ $doc("NCIII", "NATIONAL CERTIFICATE III", 'lc', 0) }}
	{{ $doc("BASIC TRAINING - BT", "BT VI/1", 'lc') }}
	@php
		$a = "PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB";
		$b = "PSCRB VI/2.1"
	@endphp
	{{ $doc($a, $b, 'lc') }}
	{{ $doc("ADVANCE FIRE FIGHTING - AFF", "AFF VI/3", 'lc') }}
	{{ $doc("MEDICAL FIRST AID - MEFA", "MEFA VI/4.1", 'lc') }}
	{{ $doc("MEDICAL CARE - MECA", "MECA VI/4.2", 'lc') }}
	{{ $doc("SHIP SECURITY OFFICER - SSO", "SSO VI/5", 'lc') }}
	{{ $doc("SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD", "SDSD VI/6", 'lc') }}
	{{ $doc("ECDIS", "ECDIS GENERIC", 'lc', 1) }}
	{{ $doc("ECDIS JRC 901B", "ECDIS SPECIFIC: JAN 901B", 'lc', 1) }}
	{{ $doc("SSBT WITH BRM", "SSBT W/ BRM", 'lc', 1) }}
	{{ $doc("ERS WITH ERM", "ERS W/ ERM", 'lc', 2) }}

	<tr>
		<td colspan="2">Flag State Documents / Endorsement</td>
		<td>Validity Date</td>
		<td></td>
		<td>Dispatch</td>
	</tr>

	{{ $doc("BOOKLET", "Flag State Booklet & License (Panama)", 'flag') }}
	{{ $doc("BOOKLET", "Flag State Booklet & GOC (Panama)", 'flag') }}
	{{ $doc("SDSD", "Flag State SDSD (Panama)", 'flag') }}
	{{ $doc("SSO", "Flag State SSO (Panama)", 'flag') }}
	{{ $doc("SCC", "Flag State SCC (Panama)", 'flag') }}

	<tr>
		<td colspan="2">In house Certificate</td>
		<td>Issuance Date</td>
		<td></td>
		<td>Dispatch</td>
	</tr>

	{{ $con("Shinko Familiarization") }}
	{{ $doc("ANTI PIRACY", "Anti Piracy", 'lc', 2) }}
	{{ $doc("IN HOUSE TRAINING CERT WITH ISM", "In House Training Certificate", 'lc', 2) }}
	{{ $doc("MCRA", "MCRA", 'lc', 2) }}
	{{ $doc("PDOS", "PDOS", 'lc', 2) }}
	{{ $doc("MENTAL HEALTH", "MENTAL HEALTH AWARENESS", 'lc', 2) }}
	{{ $doc("HATCH COVER", "HATCH COVER OPERATION AND MAINTENANCE", 'lc', 2) }}
	{{ $doc("ENCLOSED SPACE ENTRY", "ENCLOSED SPACE TRAINING", 'lc') }}

	<tr>
		<td>Prepared By:</td>
		<td>BIANCA ISABEL REYES</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td></td>
		<td>CREWING OFFICER</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td>Checked &#38; Noted By:</td>
		<td>THEA MAE G. RIO</td>
		<td></td>
		<td>Reviewed By:</td>
		<td>NASTASHA KATE SAGUINSIN</td>
	</tr>

	<tr>
		<td></td>
		<td>CREWING MANAGER</td>
		<td></td>
		<td></td>
		<td>DOCUMENTATION OFFICER</td>
	</tr>
</table>