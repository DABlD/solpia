@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";

	$blue = "color: #0000FF;";

	$cleanText = function($text){
		return str_replace('&', '&#38;', $text);
	};

	$doc = function($doc, $display, $type, $req, $first = 0, $country = null) use($data, $cleanText, $bc, $blue){
		$display = $cleanText($display);
		$docu = null;

		if(in_array($doc, ["COC", "COE"])){
			foreach(get_object_vars($data->document_lc) as $document){
				if($document->type == $doc){
					// IF NO INPUT ISSUE DATE USE CREATED AT
					$date = isset($document->issue_date) ? $document->issue_date : $document->created_at;

					// USE DATE TO GET LATEST DOCUMENT WITH SAME TYPE
					if(isset($docu)){
						if($date > $docu->issue_date){
							$docu = $document;
						}
					}
					else{
						$docu = $document;
						// IF NO INPUT ISSUE DATE USE CREATED AT
						if($docu->issue_date == null){
							$docu->issue_date = $docu->created_at;
						}
					}
				}
			}
		}
		elseif($doc == "COC-TESDA"){
			foreach(get_object_vars($data->document_lc) as $document){
				if($document->type == $doc && $document->issuer == "TESDA"){
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
			else{
				if($type != "flag"){
					$docu = isset($data->{'document_' . $type}->{$doc}) ? $data->{'document_' . $type}->{$doc} : null;
				}
				else{
					// $country = ucwords(strtolower($data->vessel->flag));
					foreach (get_object_vars($data->document_flag) as $flag) {
						if($flag->country == $country && $flag->type == $doc){
							$docu = $flag;
						}
					}
					$type2 = 0;
				}
			}
		}

		$num = isset($docu) ? (isset($docu->number) ? $docu->number : $docu->no) : "";
		$issue = isset($docu->issue_date) ? now()->parse($docu->issue_date)->format("d-M-Y") : "";
		$expiry = isset($docu->expiry_date) ? (isset($docu->issue_date) ? now()->parse($docu->expiry_date)->format('d-M-Y') : "Permanent") : "";

		if($first){
			echo "
				<td colspan='2'>$display</td>
				<td colspan='2' style='$bc $blue'>$num</td>
				<td colspan='2' style='$bc $blue'>$issue</td>
				<td style='$bc $blue'>$expiry</td>
				<td style='$bc $blue'>$req</td>
			";
		}
		else{
			echo "
				<tr>
					<td colspan='2'>$display</td>
					<td colspan='2' style='$bc $blue'>$num</td>
					<td colspan='2' style='$bc $blue'>$issue</td>
					<td style='$bc $blue'>$expiry</td>
					<td style='$bc $blue'>$req</td>
				</tr>
			";
		}
	};
@endphp

<table>
	<tr>
		<td colspan="9" style="height: 50px; {{ $bc }}">CREW COMPETENCY CHECKLIST</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">NAME</td>
		<td colspan="3" style="{{ $blue }}">{{ $data->user->namefull }}</td>
		<td colspan="2" style="{{ $bc }}">VESSEL</td>
		<td colspan="3" style="{{ $blue }}">{{ isset($data->vessel) ? $data->vessel->name : "-" }}</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">RANK</td>
		<td colspan="3" style="{{ $blue }}">{{ $data->rank }}</td>
		<td colspan="2" style="{{ $bc }}">JOINING DATE</td>
		<td colspan="3" style="{{ $blue }}">{{ $data->departure ? $data->departure->format('d-M-Y') : '' }}</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">OFFICIAL NO.</td>
		<td colspan="3" style="{{ $blue }}">-</td>
		<td colspan="2" style="{{ $bc }}">JOINING PORT</td>
		<td colspan="3" style="{{ $blue }}">{{ $data->port ?? '' }}</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 50px;">
			[Note] Master should oblige the duty to the joining crew after the check of his qualification with checklist before
			relief and should he sent it to the company iof you have any special problem (Kept on board the original copy).
		</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">CLASSIFICATION</td>
		<td colspan="2" style="{{ $bc }}">PARTICULARS</td>
		<td colspan="2" style="{{ $bc }}">NUMBER</td>
		<td colspan="2" style="{{ $bc }}">ISSUANCE</td>
		<td style="{{ $bc }}">VALIDITY</td>
		<td style="{{ $bc }}">REQUIREMENT</td>
	</tr>

	{{-- 1ST SECTION --}}
	<tr>
		<td rowspan="5" style="{{ $bc }}">SIRB &#38; PPT</td>
		{{ $doc("SEAMAN'S BOOK", "Seaman's book (Philippines)", "id", "All Rank", 1) }}
	</tr>
	{{ $doc("-", "Seaman's book (Panama)", "flag", "All Rank") }}
	{{ $doc("-", "Seaman's book (Marshall/Others)", "flag", "All Rank") }}
	{{ $doc("SEAMANS REGISTRATION CERTIFICATE", "Seaman's Registration Certificate", "id", "All Rank") }}
	{{ $doc("PASSPORT", "Passport (Philippines)", "id", "All Rank") }}

	{{-- 2ND SECTION --}}
	<tr>
		<td rowspan="2" style="{{ $bc }}">VISA</td>
		{{ $doc("US-VISA", "US VISA", "id", "All Rank", 1) }}
	</tr>
	{{ $doc("MCV", "Australian VISA", "id", "All Rank") }}

	{{-- 3RD SECTION --}}
	<tr>
		<td rowspan="12" style="{{ $bc }}">LICENSE</td>
		{{ $doc("COC", "Certificate of Competency (PRC)", "lc", "All D/E. Officer", 1) }}
	</tr>
	{{ $doc("COE", " Endorsement (PRC)", "lc", "All D/E. Officer") }}
	{{ $doc("LICENSE", "Panama License (or Booklet)", "flag", "All Rank", 0, "Panama") }}
	{{ $doc("LICENSE", "Marshall License (or Booklet)", "flag", "All Rank", 0, "Marshall Islands") }}
	{{ $doc("GMDSS/GOC", "G.O.C (Philippine)", "lc", "All D. Officer") }}
	{{ $doc("GMDSS/GOC", "G.O.C (Panama)", "flag", "All D. Officer", 0, "Panama") }}
	{{ $doc("GMDSS/GOC", "G.O.C (Marshall)", "flag", "All D. Officer", 0, "Marshall Islands") }}
	{{ $doc("SDSD", "Designated Security Duty(Panama)", "flag", "All Rank", 0, "Panama") }}
	{{ $doc("SHIP'S COOK ENDORSEMENT", "Ship's Cook(Panama)", "flag", "Catering Rating", 0, "Panama") }}
	{{ $doc("SHIP'S COOK ENDORSEMENT", "Ship's Cook(Marshall)", "flag", "Catering Rating", 0, "Marshall Islands") }}
	{{ $doc("BTOC", "Panama Oil Tanker Cert.", "flag", "All Rank/Oil Tanker", 0, "Panama") }}
	{{ $doc("COC-TESDA", "Certificate of Competency (TESDA)", "lc", "All Rank") }}
</table>