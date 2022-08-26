@php
	$center = "text-align: center;";
	$bold = "font-weight: bold;";
	$und = "text-decoration: underline;";
	$fwd2 = "font-family: Wingdings 2; font-size: 12px;";
	// dd($data);

	$checkExpiry = function($doc){
		$expiry = null;
		
		if($doc->expiry_date != ""){
			$expiry = now()->parse($doc->expiry_date)->format('d-M-y');
		}
		elseif($doc->issue_date != "" && $doc->expiry_date == ""){
			$expiry = "UNLIMITED";
		}

		return $expiry;
	};

	$gNum = null;
	$marpols = [];
	$cd = function($name, $type, $ref = null) use($data, &$gNum, &$marpols, &$fwd2, $checkExpiry){
		$box = "0";
		$gNum = null;
		$marpols = [];

		if($type == "id" || $type == "lc" || $type == "med_cert"){
			if($name == "NC"){
				if(isset($data->document_lc->NCI)){
					$gNum = $checkExpiry($data->document_lc->NCI);
					$box = "R";
				}
				elseif(isset($data->document_lc->NCIII)){
					$gNum = $checkExpiry($data->document_lc->NCIII);
					$box = "R";
				}
			}
			elseif($name == "ATOCT"){
				if(isset($data->document_lc->{"ADVANCE TRAINING FOR OIL TANKER - ATOT"})){
					$gNum = $checkExpiry($data->document_lc->{"ADVANCE TRAINING FOR OIL TANKER - ATOT"});
					$box = "R";
				}
				elseif(isset($data->document_lc->{"ADVANCE TRAINING FOR CHEMICAL TANKER - ATCT"})){
					$gNum = $checkExpiry($data->document_lc->{"ADVANCE TRAINING FOR CHEMICAL TANKER - ATCT"});
					$box = "R";
				}
			}
			elseif($name == "MARPOL"){
				foreach(get_object_vars($data->document_lc) as $docu){
					$marpols[0] = "";
					$marpols[1] = "";
					$marpols[2] = "";
					$marpols[3] = "";
					$marpols[4] = "";
					$marpols[5] = "";

					if(str_starts_with($docu->type, $name)){
						$box = "R";
						$marpol = explode('ANNEX', $docu->type)[1]; //TO GET ONLY THE PART AFTER ANNEX 1-6/I-VI

						$marpols[0] = str_contains($marpol, '1') ? 'a' : '';
						$marpols[1] = str_contains($marpol, '2') ? 'a' : '';
						$marpols[2] = str_contains($marpol, '3') || str_contains($marpol, 'III') ? 'a' : '';
						$marpols[3] = str_contains($marpol, '4') || str_contains($marpol, 'IV') ? 'a' : '';
						$marpols[4] = str_contains($marpol, '5') || str_contains($marpol, 'V') ? 'a' : '';
						$marpols[5] = str_contains($marpol, '6') || str_contains($marpol, 'VI') ? 'a' : '';
					}
				}
			}
			elseif($name == "ECDIS"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if(str_starts_with($docu->type, $name)){
						$box = "R";
						$gNum = $checkExpiry($docu);
					}
				}
			}
			elseif($name == "ECDISG"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if($docu->type == "ECDIS" || $docu->type == "ECDIS GENERIC"){
						$box = "R";
						$gNum = $checkExpiry($docu);
					}
				}
			}
			elseif($name == "ECDISS"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if(str_starts_with($docu->type, 'ECDIS ' && $docu->type != "ECDIS GENERIC")){
						$box = "R";
						$ecdis = explode('IS ', $docu->type)[1];
						$gNum .= $ecdis . '/';
					}
				}

				if($gNum){
					$gNum = substr($gNum, 0, -1);
				}
			}
			elseif($name == "HAZMAT"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if(str_contains($docu->type, $name) || str_contains($docu->type, "HAZARDOUS")){
						$box = "R";
						$gNum = $checkExpiry($docu);
					}
				}
			}
			elseif($name == "SAT"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if($docu->type == $name || str_contains($docu->type, "SATELLITE")){
						$box = "R";
						$gNum = $checkExpiry($docu);
					}
				}
			}
			elseif($name == "EWE"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if($docu->type == "ERS WITH ERM" || $docu->type == "ERM WITH ERS"){
						$box = "R";
						$gNum = $checkExpiry($docu);
					}
				}
			}
			elseif($name == "BRM"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if($docu->type == "BRM" || $docu->type == "BTM" || $docu->type == "BRTM"){
						$box = "R";
						$gNum = $checkExpiry($docu);
					}
				}
			}
			elseif($name == "PADAMS"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if(str_contains($docu->type, $name) || str_contains($docu->type, "DRUG ABUSE")){
						$box = "R";
						$gNum = $checkExpiry($docu);
					}
				}
			}
			elseif($name == "SSO2"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if(str_contains($docu->type, "SHIP SAFETY OFFICER")){
						$box = "R";
						$gNum = $checkExpiry($docu);
					}
				}
			}
			elseif($name == "SHIPS CATERING"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if(str_contains($docu->type, "NCI")){
						$box = "R";
						$gNum = $checkExpiry($docu);
					}
				}
			}
			elseif($name == "MLC"){
				$ctr = 0;
				foreach(get_object_vars($data->document_lc) as $docu){
					if(($docu->type == "MLC TRAINING F1" || $docu->type == "MLC TRAINING F3") && $docu->no != ""){
						$ctr++;
					}
				}

				// IF HAS TWO MATCH PRESUMABLY MLC F1 AND F3
				if($ctr == 2){
					$box = "R";
				}
			}
			elseif($name == "OLC"){
				$ctr = 0;
				foreach(get_object_vars($data->document_lc) as $docu){
					if(($docu->type == "OLC TRAINING F1" || $docu->type == "OLC TRAINING F2" || $docu->type == "OLC TRAINING F3") && $docu->no != ""){
						$ctr++;
					}
				}

				// IF HAS THREE MATCH PRESUMABLY MLC F1 AND F3
				if($ctr == 3){
					$box = "R";
				}
			}
			elseif($name == "WELDING" || $name == "WATCH" || $name == "AUXILIARY" || $name == "ROPA" || $name == "ARPA" || $name == "SSBT" || $name == "SHIELDED METAL ARC WELDING"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if(str_contains($docu->type, $name)){
						$box = "R";
						$gNum = $checkExpiry($docu);
					}
				}
			}
			elseif(isset($data->{"document_$type"}->{$name})){
				$box = "R";

				if($name == "COC"){
					if($ref == "II-4/5"){
						foreach(get_object_vars($data->document_lc) as $docu){
							$regulations = json_decode($docu->regulation);

							if(str_starts_with($docu->type, 'COC') && (in_array("II/4", $regulations) || in_array("II/5", $regulations))){
								$name = $docu->type;
							}
						}	
					}
					else{
						foreach(get_object_vars($data->document_lc) as $docu){
							if(str_starts_with($docu->type, 'COC') && $docu->issuer != "MARINA"){
								$name = $docu->type;
							}
						}
					}
				}

				if($ref == "COP"){
					foreach(get_object_vars($data->document_lc) as $docu){
						if(str_starts_with($docu->type, $name) && $docu->issuer == "MARINA"){
							$name = $docu->type;
						}
					}
				}
				else{
					foreach(get_object_vars($data->document_lc) as $docu){
						if(str_starts_with($docu->type, $name) && $docu->issuer != "MARINA"){
							$name = $docu->type;
						}
					}
				}

				$gNum = $checkExpiry($data->{"document_$type"}->{$name});
			}
		}
		else{
			foreach (get_object_vars($data->document_flag) as $flag) {
				if($ref != "OTHER")
				{
					if($flag->country == $ref && $flag->type == $name){
						$box = "R";
						$gNum = $checkExpiry($flag);
					}
				}
				else{
					$c = $flag->country;
					if(($c != "Panama" || $c != "Marshall Island" && $c != "Liberia") && $flag->type == $name){
						$box = "R";
						$gNum = $checkExpiry($flag);
					}
				}
			}
		}

		if($box == "R"){
			$fwd2 = "font-family: Wingdings 2; font-size: 12px;";
		}
		else{
			$fwd2 = "font-family: Wingdings 2; font-size: 14px;";
		}
		// echo $box;
		echo "<td style='$fwd2 text-align: right;'>$box</td>";
	};
@endphp

<table>
	<tr>
		<td colspan="19" style="height: 50px;"></td>
	</tr>

	<tr>
		<td colspan="19" style="{{ $center }} {{ $und }} height: 30px; font-size: 20px;">
			CREW DOCUMENTS CHECKLIST
		</td>
	</tr>

	<tr>
		<td colspan="2">NAME:</td>
		<td colspan="7" style="{{ $bold }}">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td colspan="2"></td>
		<td>RANK:</td>
		<td colspan="7" style="{{ $bold }}">{{ $data->rank }}</td>
	</tr>

	<tr>
		<td colspan="2">Contact No.</td>
		<td colspan="7" style="{{ $bold }}">
			{{ $data->user->contact }}
		</td>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="19"></td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $bold }}">MANDATORY DOCUMENTS:</td>
		<td colspan="3"></td>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎TRAINING CERTIFICATES COP:</td>
	</tr>

	<tr>
		<td></td>
		{{ $cd("PASSPORT", "id") }}
		<td colspan="4">PASSPORT:</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("BASIC TRAINING - BT", 'lc', 'COP') }}
		<td colspan="4">BT</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		{{ $cd("US-VISA", "id") }}
		<td colspan="4">US VISA:</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB", 'lc', 'COP') }}
		<td colspan="4">PSCRB</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		{{ $cd("SEAMAN'S BOOK", "id") }}
		<td colspan="4">SIRB:</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("ADVANCE FIRE FIGHTING - AFF", 'lc', 'COP') }}
		<td colspan="4">ATFF</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		{{ $cd("SRN", "lc") }}
		<td colspan="4">SRN (RANK):</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("MEDICAL FIRST AID - MEFA", 'lc', 'COP') }}
		<td colspan="4">MEFA</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		{{ $cd("COC", "lc") }}
		<td colspan="4">PRC/COP (LICENSE):</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("MEDICAL CARE - MECA", 'lc', 'COP') }}
		<td colspan="4">MECA</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		{{ $cd("GMDSS/GOC", "lc") }}
		<td colspan="4">GOC:</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("FAST RESCUE BOAT - FRB", 'lc', 'COP') }}
		<td colspan="4">PFRB</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		{{ $cd("COC", "lc", "II-4/5") }}
		<td colspan="4">COP (DECK/ENGINE):2/4-5</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("SHIP SECURITY OFFICER - SSO", 'lc', 'COP') }}
		<td colspan="4">SSO</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		{{ $cd("NC", "lc") }}
		<td colspan="4">NC 1 / NC 3:</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD", 'lc', 'COP') }}
		<td colspan="4">SDSD SAT</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		{{ $cd("YELLOW FEVER", "med_cert") }}
		<td colspan="4">YELLOW FEVER:</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("BASIC TRAINING FOR OIL AND CHEMICAL TANKER - BTOCT", 'lc', 'COP') }}
		<td colspan="4">BTOCT</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		{{ $cd("MCV", "id") }}
		<td colspan="4">MCV:</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("ATOCT", 'lc', 'COP') }}
		<td colspan="4">ATOCT</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td colspan="19"></td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $bold }}">FLAG LICENSE:</td>
		<td colspan="3"></td>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎TRAINING CERTIFICATES:</td>
	</tr>

	<tr>
		{{ $cd("LICENSE", "flag", 'Panama') }}
		<td colspan="3">PANAMA:</td>
		{{ $cd("BOOKLET", "flag", 'Panama') }}
		<td>BOOKLET</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("BASIC TRAINING - BT", 'lc') }}
		<td colspan="3">BT</td>
		{{ $cd("BASIC TRAINING FOR OIL AND CHEMICAL TANKER - BTOCT", 'lc') }}
		<td colspan="4">BTOCT</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		{{ $cd("GMDSS/GOC", "flag", 'Panama') }}
		<td>GMDSS</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB", 'lc') }}
		<td colspan="3">PSCRB</td>
		{{ $cd("ATOCT", 'lc') }}
		<td colspan="4">ATOCT</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="4">ENDORSEMENT</td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("ADVANCE FIRE FIGHTING - AFF", 'lc') }}
		<td colspan="3">ATFF</td>
		{{ $cd("WELDING", 'lc') }}
		<td colspan="4">WELDING COURSE</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		{{ $cd("SSO", "flag", 'Panama') }}
		<td>SSO</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("MEDICAL FIRST AID - MEFA", 'lc') }}
		<td colspan="8">MEFA</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		{{ $cd("SDSD", "flag", 'Panama') }}
		<td>SDSD SAT</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("MEDICAL CARE - MECA", 'lc') }}
		<td colspan="8">MECA</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		{{ $cd("ECDIS", "flag", 'Panama') }}
		<td>ECDIS</td>
		<td colspan="3" style="{{ $center }}"></td>
		<td></td>
		{{ $cd("FAST RESCUE BOAT - FRB", 'lc') }}
		<td colspan="8">PFRB</td>
	</tr>

	<tr>
		{{ $cd("LICENSE", "flag", 'Marshall Island') }}
		<td colspan="3">MARSHALL:</td>
		{{ $cd("BOOKLET", "flag", 'Marshall Island') }}
		<td>BOOKLET</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("WATCH", 'lc') }}
		<td colspan="8">WATCHKEEPING (DECK / ENGINE)</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		{{-- <td style="{{ $fwd2 }} text-align: right; color: #FFFFFF;"></td> --}}
		{{ $cd("LICENSE", "flag", 'Marshall Island') }}
		<td>COC</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("SHIP SECURITY OFFICER - SSO", 'lc') }}
		<td colspan="8">SSO</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="2">SQC</td>
		<td></td>
		<td></td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("SDSD", 'lc') }}
		<td colspan="8">SDSD SAT</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		{{ $cd("BT", "flag", 'Marshall Island') }}
		<td>BT / BST</td>
		<td></td>
		{{ $cd("MEFA", 'flag', 'Marshall Island') }}
		<td>MEFA</td>
		<td></td>
		{{ $cd("HAZMAT", 'lc') }}
		<td>HAZMAT</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		{{ $cd("PSCRB", "flag", 'Marshall Island') }}
		<td>PSCRB</td>
		<td></td>
		{{ $cd("MECA", 'flag', 'Marshall Island') }}
		<td>MECA</td>
		<td></td>
		{{ $cd("CONSOLIDATED MARPOL", 'lc') }}
		<td>CONSOLIDATED MARPOL</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		{{ $cd("AFF", "flag", 'Marshall Island') }}
		<td>ATFF</td>
		<td></td>
		{{ $cd("TANKERMAN", 'flag', 'Marshall Island') }}
		<td>TANKERMAN</td>
		<td></td>
		{{ $cd("MARPOL", 'lc') }}
		<td>MARPOL</td>
		@foreach($marpols as $marpol)
			<td style='font-family: Marlett;'>{{ $marpol }}</td>
		@endforeach
		<td></td>
	</tr>

	<tr>
		{{ $cd("LICENSE", "flag", 'Liberia') }}
		<td colspan="3">LIBERIA:</td>
		{{ $cd("BOOKLET", "flag", 'Liberia') }}
		<td>BOOKLET</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td colspan="2"></td>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<td>5</td>
		<td>6</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="4"></td>
		{{ $cd("GMDSS/GOC", "flag", 'Liberia') }}
		<td>GOC</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("PADAMS", 'lc') }}
		<td colspan="8">PADAMS</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		{{ $cd("ENDORSEMENT", "flag", 'Liberia') }}
		<td>ENDORSEMENT</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("ML", 'lc') }}
		<td colspan="8">MARITIME ENGLISH (OFFICERS/RATINGS)</td>
	</tr>

	<tr>
		{{ $cd("LICENSE", "flag", 'OTHER') }}
		<td colspan="3">OTHERS:</td>
		{{ $cd("BOOKLET", "flag", 'OTHER') }}
		<td>BOOKLET</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		{{ $cd("ISM", 'lc') }}
		<td colspan="8">ISM FAMILIARIZATION</td>
	</tr>

	<tr>
		<td></td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $bold }}">DECK DEPARTMENT:</td>
		<td colspan="3"></td>
		<td colspan="10" style="{{ $bold }}">ENGINE DEPARTMENT:</td>
	</tr>

	<tr>
		{{ $cd("ECDIS", 'lc') }}
		<td></td>
		<td colspan="4">ECDIS</td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("ERM", 'lc') }}
		<td colspan="8">ERM</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		{{ $cd("ECDISG", 'lc') }}
		<td colspan="3">GENERIC (2)</td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("ERS", 'lc') }}
		<td colspan="8">ERS</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		{{ $cd("ECDISS", 'lc') }}
		<td colspan="3">SPECIFIC (2)   ‎‏‏‎TYPE:</td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("EWE", 'lc') }}
		<td colspan="8">ERS W/ ERM - ERRS W/ ERRM</td>
	</tr>

	<tr>
		{{ $cd("GMDSS/GOC", 'lc') }}
		<td colspan="5">GMDSS / GOC</td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("AUXILIARY", 'lc') }}
		<td colspan="8">AUXILIARY MACHINERY SYSTEM</td>
	</tr>

	<tr>
		{{ $cd("SAT", 'lc') }}
		<td colspan="5">INMARSAT / SATCOM</td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("CONTROL ENGINEERING", 'lc') }}
		<td colspan="8">CONTROL ENGINEERING</td>
	</tr>

	<tr>
		{{ $cd("SAT", 'lc') }}
		<td colspan="5">RSC</td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("CONTROL ENGINEERING", 'lc') }}
		<td colspan="8">HYDRAULICS / PNEUMATICS</td>
	</tr>

	<tr>
		{{ $cd("ROP", 'lc') }}
		<td colspan="5">ROP</td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("MARINE ELECTRO TECH", 'lc') }}
		<td colspan="8">MARINE ELECTRO TECH</td>
	</tr>

	<tr>
		{{ $cd("ROPA", 'lc') }}
		<td colspan="5">ROPA</td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("ELECTRONIC EQUIPMENT", 'lc') }}
		<td colspan="8">ELECTRONIC EQUIPMENT</td>
	</tr>

	<tr>
		{{ $cd("ARPA", 'lc') }}
		<td colspan="5">ARPA</td>
		<td colspan="3"></td>
		<td></td>
		<td></td>
		<td colspan="8"></td>
	</tr>

	<tr>
		{{ $cd("SRROC", 'lc') }}
		<td colspan="5">SRROC</td>
		<td colspan="3"></td>
		<td colspan="10" style="{{ $bold }}">OTHER CERTIFICATES:</td>
	</tr>

	<tr>
		{{ $cd("BRM", 'lc') }}
		<td colspan="5">BRTM / BTM / BRM</td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("SHIELDED METAL ARC WELDING", 'lc') }}
		<td colspan="8">SHIELDED METAL</td>
	</tr>

	<tr>
		{{ $cd("SSBT", 'lc') }}
		<td colspan="5">SSBT</td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("LPG / LNG", 'lc') }}
		<td colspan="8">LPG / LNG</td>
	</tr>

	<tr>
		{{ $cd("ECDIS", 'lc') }}
		<td colspan="5">ECDIS</td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("MLC", 'lc') }}
		<td colspan="8">MLC - FUNCTION 1 3</td>
	</tr>

	<tr>
		{{ $cd("CARGO HANDLING", 'lc') }}
		<td colspan="5">CARGO HANDLING</td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("OLC", 'lc') }}
		<td colspan="8">OLC - FUNCTION 1 2 3</td>
	</tr>

	<tr>
		{{ $cd("COLLISION AVOIDANCE", 'lc') }}
		<td colspan="5">COLLISION AVOIDANCE</td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("SHIPS CATERING", 'lc') }}
		<td colspan="8">SHIPS CATERING</td>
	</tr>

	<tr>
		{{ $cd("SSO2", 'lc') }}
		<td colspan="5">SHIP SAFETY OFFICERS</td>
		<td colspan="3"></td>
		<td colspan="10" style="{{ $bold }}">OTHERS:</td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $bold }}">GALLEY DEPARTMENT:</td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("BLANK", 'lc') }}
		<td colspan="8"></td>
	</tr>

	<tr>
		{{ $cd("NCI", 'lc') }}
		<td colspan="5">SHIP CATERING - NC 1</td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("BLANK", 'lc') }}
		<td colspan="8"></td>
	</tr>

	<tr>
		{{ $cd("NCIII", 'lc') }}
		<td colspan="5">SHIP CATERING - NC 3</td>
		<td colspan="3"></td>
		<td></td>
		{{ $cd("BLANK", 'lc') }}
		<td colspan="8"></td>
	</tr>

	<tr>
		{{ $cd("KC", 'lc') }}
		<td colspan="5">KOREAN COOKING</td>
		<td colspan="3"></td>
		<td colspan="10" style="{{ $bold }}">REMARKS </td>
	</tr>

	<tr>
		<td></td>
		<td colspan="5"></td>
		<td colspan="3"></td>
		<td colspan="10" style="{{ $bold }}"></td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $bold }} font-style: italic;">RECEIVED AND CHECKED BY:</td>
		<td colspan="3"></td>
		<td colspan="10" style="{{ $bold }}"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="5"></td>
		<td colspan="3"></td>
		<td colspan="10" style="{{ $bold }}"></td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $bold }} {{ $center }}">{{ auth()->user()->fullname }}</td>
		<td></td>
		<td colspan="10" style="{{ $bold }}"></td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $bold }} {{ $center }}">{{ auth()->user()->role }}</td>
		<td></td>
		<td colspan="10" style="{{ $bold }}"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="5"></td>
		<td colspan="3"></td>
		<td colspan="10" style="{{ $bold }}"></td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $bold }} font-style: italic;">DATE:</td>
		<td colspan="6" style="{{ $bold }} {{ $center }}">{{ now()->format("d-M-y") }}</td>
		<td></td>
		<td></td>
		<td colspan="8" style="{{ $center }}">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $center }}">CREW COPY</td>
		<td></td>
		<td></td>
		<td colspan="8" style="{{ $bold }} {{ $center }}">Crew's Printed Name and Signature</td>
	</tr>
</table>