@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";

	$checkDate = function($date, $type){
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
			return $date->format('Y-m-d');
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

	$cleanText = function($text){
		return str_replace('&', '&#38;', $text);
	};

	$doc = function($doc, $display, $type, $type2 = 0, $regulation = null) use($checkDate, $data, $cleanText, $c){
		$display = $cleanText($display);
		$docu = null;

		if($doc == "COC" || $doc == "COE" || $doc == "GMDSS/GOC"){
			foreach($data->{'document_' . $type} as $document){
				if($document->type == "$doc"){
					if($docu == null){
						$doc = $document;
					}
					else{
						if($document->issue_date > $docu->issue_date){
							$docu = $document;
						}
					}
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
			elseif($doc == "BRM/ERM"){
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

				if(!$docu){
					$doc = "SSBT WITH BRM";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
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
			elseif($doc == "ECDIS SPECIFIC"){
				if(isset($data->vessel)){
					$docu = isset($data->document_lc->{$data->vessel->ecdis}) ? $data->document_lc->{$temp} : null;
				}
			}
			elseif($doc == "MARINE ELECTRICAL"){
				$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;

				if(!$docu){
					$doc = "MARINE ELECTRICAL TRAINING";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
			}
			elseif($doc == "CONSOLIDATED MARPOL"){
				$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;

				if(!$docu){
					foreach($data->document_lc as $doc){
						if(str_contains($doc->type, "MARPOL")){
							$docu = $doc;
						}
					}
				}
			}
			elseif($doc == "WATCHKEEPING"){
				$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;

				if(!$docu){
					$doc = "DECK WATCH";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				if(!$docu){
					$doc = "ENGINE WATCH";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				if(!$docu){
					$doc = "DECK WATCHKEEPING";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				if(!$docu){
					$doc = "ENGINE WATCHKEEPING";
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
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

		$noNum  = $type == 'lc' ? 'no' : 'number';

		$number = $docu ? $docu->$noNum : '-----';
		$issue  = $docu ? $checkDate($docu->issue_date, 'I') : '-----';
		$expiry = $docu ? $checkDate($docu->expiry_date, 'E') : '-----';

		echo "
			<tr>
				<td colspan='2'>ㅤ$display</td>
				<td colspan='2' style='$c'>$number</td>
				<td style='$c'>$issue</td>
				<td style='$c'>$expiry</td>
				<td style='$c'></td>
			</tr>
		";
	};
@endphp

<table>
	<tr>
		<td colspan="7" style="{{ $bc }}">Document Check List for Seafarer</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">Vessel</td>
		<td colspan="2" style="{{ $c }}">{{ isset($data->vessel) ? $data->vessel->name : "-" }}</td>
		<td style="{{ $bc }}">Rank</td>
		<td style="{{ $c }}">{{ isset($applicant->rank) ? $applicant->rank->abbr : '-' }}</td>
		<td style="{{ $bc }}">Name</td>
		<td style="{{ $c }}">{{ $data->user->namefull }}</td>
	</tr>

	<tr>
		<td colspan="7" style="height: 5px;"></td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $bc }}">Documents</td>
		<td colspan="2" style="{{ $bc }}">Doc No.</td>
		<td style="{{ $bc }}">Issue</td>
		<td style="{{ $bc }}">Expire</td>
		<td style="{{ $bc }}">Remark</td>
	</tr>

	{{ $doc("PASSPORT", "Passport", 'id') }}
	{{ $doc("SEAMAN'S BOOK", "Seaman'S Book", 'id') }}
	{{ $doc("COC", "C.O.C", 'lc') }}
	{{ $doc("GMDSS/GOC", "GOC/ROC", 'lc') }}
	{{ $doc("WATCHKEEPING", "Watch-keeping Cert.", 'lc') }}
	{{ $doc("MEDICAL CARE - MECA", "Medical Care", 'lc') }}
	{{ $doc("CONSOLIDATED MARPOL", "Maritime Pollution Prevention", 'lc') }}
	{{ $doc("BOOKLET", "Flagged Seaman’s Book", 'flag') }}
	{{ $doc("LICENSE", "Flagged License", 'flag') }}
	{{ $doc("BASIC TRAINING - BT", "Basic Safety Course", 'lc') }}
	{{ $doc("BASIC TRAINING - BT", "Advanced Safety Course", 'lc') }} // ASK WHAT ADVANCED TRAINING
	{{ $doc("ADVANCE FIRE FIGHTING - AFF", " - Fire Fighting", 'lc') }}
	{{ $doc("PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB", "- Survival Craft & Rescue Boat", 'lc') }}
	{{ $doc("MEDICAL FIRST AID - MEFA", "- First Aid", 'lc') }}
	{{ $doc("ARPA TRAINING COURSE", "RADAR - ARPA", 'lc') }}
	{{ $doc("RADAR", "Radar Simulation", 'lc') }}
	{{ $doc("RADAR", "Radar Simulation", 'lc') }}
	{{ $doc("BRM/ERM", "BRTM / ERM", 'lc') }}
	{{ $doc("ECDIS", "ECDIS (Generic)", 'lc') }}
	{{ $doc("ECDIS SPECIFIC", "ECDIS (Specific)", 'lc') }}
	{{ $doc("SHIP'S COOK ENDORSEMENT", "Ship Cook Training", 'lc') }}
	{{ $doc("MEDICAL CERTIFICATE", "Medical Examination Cert.", 'med_cert') }}
	{{ $doc("YELLOW FEVER", "Yellow Fever", 'med_cert') }}
	{{ $doc("US-VISA", "US Visa", 'id') }}
</table>