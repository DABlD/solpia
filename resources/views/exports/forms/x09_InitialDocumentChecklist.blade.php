@php
	$center = "text-align: center;";
	$bold = "font-weight: bold;";
	$und = "text-decoration: underline;";
	$fwd2 = "font-family: Wingdings 2; font-size: 12px;";
	// dd($data);

	$gNum = null;
	$marpols = [];
	$cd = function($name, $type, $ref = null) use($data, &$gNum, &$marpols, &$fwd2){
		$box = "0";
		$gNum = null;
		$marpols = [];

		if($type == "id" || $type == "lc" || $type == "med_cert"){
			if($name == "NC"){
				if(isset($data->document_lc->NCI)){
					$gNum = $data->document_lc->NCI->no;
					$box = "R";
				}
				elseif(isset($data->document_lc->NCIII)){
					$gNum = $data->document_lc->NCIII->no;
					$box = "R";
				}
			}
			elseif($name == "ATOCT"){
				if(isset($data->document_lc->{"ADVANCE TRAINING FOR OIL TANKER - ATOT"})){
					$gNum = $data->document_lc->{"ADVANCE TRAINING FOR OIL TANKER - ATOT"}->no;
					$box = "R";
				}
				elseif(isset($data->document_lc->{"ADVANCE TRAINING FOR CHEMICAL TANKER - ATCT"})){
					$gNum = $data->document_lc->{"ADVANCE TRAINING FOR CHEMICAL TANKER - ATCT"}->no;
					$box = "R";
				}
			}
			elseif($name == "MARPOL"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if(str_starts_with($docu->type, $name)){
						$box = "R";
						$marpol = explode('ANNEX', $docu->type)[1]; //TO GET ONLY THE PART AFTER ANNEX 1-6/I-VI

						$marpols[0] = str_contains($marpol, '1') ? 'R' : '0';
						$marpols[1] = str_contains($marpol, '2') ? 'R' : '0';
						$marpols[2] = str_contains($marpol, '3') || str_contains($marpol, 'III') ? 'R' : '0';
						$marpols[3] = str_contains($marpol, '4') || str_contains($marpol, 'IV') ? 'R' : '0';
						$marpols[4] = str_contains($marpol, '5') || str_contains($marpol, 'V') ? 'R' : '0';
						$marpols[5] = str_contains($marpol, '6') || str_contains($marpol, 'VI') ? 'R' : '0';
					}
				}
			}
			elseif($name == "ECDIS"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if(str_starts_with($docu->type, $name)){
						$box = "R";
						$gNum = $docu->no;
					}
				}
			}
			elseif($name == "ECDISG"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if($docu->type == "ECDIS" || $docu->type == "ECDIS GENERIC"){
						$box = "R";
						$gNum = $docu->no;
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
						$gNum = $docu->no;
					}
				}
			}
			elseif($name == "SAT"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if($docu->type == $name || str_contains($docu->type, "SATELLITE")){
						$box = "R";
						$gNum = $docu->no;
					}
				}
			}
			elseif($name == "EWE"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if($docu->type == "ERS WITH ERM" || $docu->type == "ERM WITH ERS"){
						$box = "R";
						$gNum = $docu->no;
					}
				}
			}
			elseif($name == "PADAMS"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if(str_contains($docu->type, $name) || str_contains($docu->type, "DRUG ABUSE")){
						$box = "R";
						$gNum = $docu->no;
					}
				}
			}
			elseif($name == "WELDING" || $name == "WATCH" || $name == "AUXILIARY"){
				foreach(get_object_vars($data->document_lc) as $docu){
					if(str_contains($docu->type, $name)){
						$box = "R";
						$gNum = $docu->no;
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

				$gNum = $data->{"document_$type"}->{$name}->{$type == "id" ? "number" : "no"};
			}
		}
		else{
			foreach (get_object_vars($data->document_flag) as $flag) {
				if($ref != "OTHER")
				{
					if($flag->country == $ref && $flag->type == $name){
						$box = "R";
						$gNum = $flag->number;
					}
				}
				else{
					$c = $flag->country;
					if(($c != "Panama" || $c != "Marshall Island" && $c != "Liberia") && $flag->type == $name){
						$box = "R";
						$gNum = $flag->number;
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
		echo $box;
	};
@endphp

<table>
	<tr>
		<td colspan="19" style="height: 50px;"></td>
	</tr>

	<tr>
		<td colspan="19" style="{{ $center }} {{ $und }} height: 25px; font-size: 20px;">
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
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("PASSPORT", "id") }}</td>
		<td colspan="4">PASSPORT:</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("BASIC TRAINING - BT", 'lc', 'COP') }}</td>
		<td colspan="4">BT</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("US-VISA", "id") }}</td>
		<td colspan="4">US VISA:</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB", 'lc', 'COP') }}</td>
		<td colspan="4">PSCRB</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("SEAMAN'S BOOK", "id") }}</td>
		<td colspan="4">SIRB:</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("ADVANCE FIRE FIGHTING - AFF", 'lc', 'COP') }}</td>
		<td colspan="4">ATFF</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("SRN", "lc") }}</td>
		<td colspan="4">SRN (RANK):</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("MEDICAL FIRST AID - MEFA", 'lc', 'COP') }}</td>
		<td colspan="4">MEFA</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("COC", "lc") }}</td>
		<td colspan="4">PRC/COP (LICENSE):</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("MEDICAL CARE - MECA", 'lc', 'COP') }}</td>
		<td colspan="4">MECA</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("GMDSS/GOC", "lc") }}</td>
		<td colspan="4">GOC:</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("FAST RESCUE BOAT - FRB", 'lc', 'COP') }}</td>
		<td colspan="4">PFRB</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("COC", "lc", "II-4/5") }}</td>
		<td colspan="4">COP (DECK/ENGINE):2/4-5</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("SHIP SECURITY OFFICER - SSO", 'lc', 'COP') }}</td>
		<td colspan="4">SSO</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("NC", "lc") }}</td>
		<td colspan="4">NC 1 / NC 3:</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD", 'lc', 'COP') }}</td>
		<td colspan="4">SDSD SAT</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("YELLOW FEVER", "med_cert") }}</td>
		<td colspan="4">YELLOW FEVER:</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("BASIC TRAINING FOR OIL AND CHEMICAL TANKER - BTOCT", 'lc', 'COP') }}</td>
		<td colspan="4">BTOCT</td>
		<td colspan="4" style="{{ $center }}">{{ $gNum }}</td>
	</tr>

	<tr>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("MCV", "id") }}</td>
		<td colspan="4">MCV:</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("ATOCT", 'lc', 'COP') }}</td>
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
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("LICENSE", "flag", 'Panama') }}</td>
		<td colspan="3">PANAMA:</td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("BOOKLET", "flag", 'Panama') }}</td>
		<td>BOOKLET</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("BASIC TRAINING - BT", 'lc') }}</td>
		<td colspan="3">BT</td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("BASIC TRAINING FOR OIL AND CHEMICAL TANKER - BTOCT", 'lc') }}</td>
		<td colspan="4">BTOCT</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("GMDSS/GOC", "flag", 'Panama') }}</td>
		<td>GMDSS</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB", 'lc') }}</td>
		<td colspan="3">PSCRB</td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("ATOCT", 'lc') }}</td>
		<td colspan="4">ATOCT</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="4">ENDORSEMENT</td>
		<td colspan="3"></td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("ADVANCE FIRE FIGHTING - AFF", 'lc') }}</td>
		<td colspan="3">ATFF</td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("WELDING", 'lc') }}</td>
		<td colspan="4">WELDING COURSE</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("SSO", "flag", 'Panama') }}</td>
		<td>SSO</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("MEDICAL FIRST AID - MEFA", 'lc') }}</td>
		<td colspan="8">MEFA</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("SDSD", "flag", 'Panama') }}</td>
		<td>SDSD SAT</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("MEDICAL CARE - MECA", 'lc') }}</td>
		<td colspan="8">MECA</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("ECDIS", "flag", 'Panama') }}</td>
		<td>ECDIS</td>
		<td colspan="3" style="{{ $center }}"></td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("FAST RESCUE BOAT - FRB", 'lc') }}</td>
		<td colspan="8">PFRB</td>
	</tr>

	<tr>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("LICENSE", "flag", 'Marshall Island') }}</td>
		<td colspan="3">MARSHALL:</td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("BOOKLET", "flag", 'Marshall Island') }}</td>
		<td>BOOKLET</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("WATCH", 'lc') }}</td>
		<td colspan="8">WATCHKEEPING (DECK / ENGINE)</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td style="{{ $fwd2 }} text-align: right; color: #FFFFFF;">{{ $cd("LICENSE", "flag", 'Marshall Island') }}</td>
		<td>COC</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("SHIP SECURITY OFFICER - SSO", 'lc') }}</td>
		<td colspan="8">SSO</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="2">SQC</td>
		<td></td>
		<td></td>
		<td colspan="3"></td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("SDSD", 'lc') }}</td>
		<td colspan="8">SDSD SAT</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("BT", "flag", 'Marshall Island') }}</td>
		<td>BT / BST</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("MEFA", 'flag', 'Marshall Island') }}</td>
		<td>MEFA</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("HAZMAT", 'lc') }}</td>
		<td>HAZMAT</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("PSCRB", "flag", 'Marshall Island') }}</td>
		<td>PSCRB</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("MECA", 'flag', 'Marshall Island') }}</td>
		<td>MECA</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("CONSOLIDATED MARPOL", 'lc') }}</td>
		<td>CONSOLIDATED MARPOL</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("AFF", "flag", 'Marshall Island') }}</td>
		<td>ATFF</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("TANKERMAN", 'flag', 'Marshall Island') }}</td>
		<td>TANKERMAN</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("MARPOL", 'lc') }}</td>
		<td>MARPOL</td>
		@foreach($marpols as $marpol)
			<td style="{{ $fwd2 }}">{{ $marpol }}</td>	
		@endforeach
		<td></td>
	</tr>

	<tr>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("LICENSE", "flag", 'Liberia') }}</td>
		<td colspan="3">LIBERIA:</td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("BOOKLET", "flag", 'Liberia') }}</td>
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
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("GMDSS/GOC", "flag", 'Liberia') }}</td>
		<td>GOC</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("PADAMS", 'lc') }}</td>
		<td colspan="8">PADAMS</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("ENDORSEMENT", "flag", 'Liberia') }}</td>
		<td>ENDORSEMENT</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("ML", 'lc') }}</td>
		<td colspan="8">MARITIME ENGLISH (OFFICERS/RATINGS)</td>
	</tr>

	<tr>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("LICENSE", "flag", 'OTHER') }}</td>
		<td colspan="3">OTHERS:</td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("BOOKLET", "flag", 'OTHER') }}</td>
		<td>BOOKLET</td>
		<td colspan="3" style="{{ $center }}">{{ $gNum }}</td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("ISM", 'lc') }}</td>
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
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("ECDIS", 'lc') }}</td>
		<td></td>
		<td colspan="4">ECDIS</td>
		<td colspan="3"></td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("ERM", 'lc') }}</td>
		<td colspan="8">ERM</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("ECDISG", 'lc') }}</td>
		<td colspan="3">GENERIC (2)</td>
		<td colspan="3"></td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("ERS", 'lc') }}</td>
		<td colspan="8">ERS</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("ECDISS", 'lc') }}</td>
		<td colspan="3">SPECIFIC (2)   ‎‏‏‎TYPE:</td>
		<td colspan="3"></td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("EWE", 'lc') }}</td>
		<td colspan="8">ERS W/ ERM - ERRS W/ ERRM</td>
	</tr>

	<tr>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("GMDSS/GOC", 'lc') }}</td>
		<td colspan="5">GMDSS / GOC</td>
		<td colspan="3"></td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("AUXILIARY", 'lc') }}</td>
		<td colspan="8">AUXILIARY MACHINERY SYSTEM</td>
	</tr>

	<tr>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("SAT", 'lc') }}</td>
		<td colspan="5">INMARSAT / SATCOM</td>
		<td colspan="3"></td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("CONTROL ENGINEERING", 'lc') }}</td>
		<td colspan="8">CONTROL ENGINEERING</td>
	</tr>

	<tr>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("SAT", 'lc') }}</td>
		<td colspan="5">RSC</td>
		<td colspan="3"></td>
		<td></td>
		<td style="{{ $fwd2 }} text-align: right;">{{ $cd("CONTROL ENGINEERING", 'lc') }}</td>
		<td colspan="8">HYDRAULICS / PNEUMATICS</td>
	</tr>
</table>