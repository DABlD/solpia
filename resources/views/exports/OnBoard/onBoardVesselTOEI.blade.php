@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	$blue = "color: #0000FF;";
	$und = "text-decoration: underline;";

	// FILLS
	$fo = "background-color: #FFC000;";
	$fg = "background-color: #D9D9D9;";
	$fr = "background-color: #FFFF00;";
	$fr2 = "background-color: #FF0000;";

	$doc = function($applicant, $name, $type, $date = 1, $ratings = 0) use(&$docu, $ranks, $center, $blue, $und){
		$docu = null;
		$fy = "background-color: #FFFF00;";
		$fr = "background-color: #FF0000;";
		$fb = "background-color: #00B0F0;";
		if($type == "id" || $type == "lc"){
			if($type == "id"){
				if(isset($applicant->document_id->{$name})){
					$docu = $applicant->document_id->{$name};
				}
			}
			else{
				if($name == "NCIII"){
					if(isset($applicant->document_lc->{$name})){
						$docu = $applicant->document_lc->{$name};
					}
					elseif(isset($applicant->document_lc->NCI)){
						$docu = $applicant->document_lc->NCI;
					}
				}
				else{
					foreach(get_object_vars($applicant->document_lc) as $lc){
						if(str_starts_with($lc->type, $name)){
							$regulations = json_decode($lc->regulation);

							if($ratings){
								if(in_array("II/4", $regulations) || in_array("II/5", $regulations) || in_array("III/4", $regulations) || in_array("III/5", $regulations)){
									$docu = $lc;
								}
							}
							else{
								if(!in_array("II/4", $regulations) && !in_array("II/5", $regulations) && !in_array("III/4", $regulations) && !in_array("III/5", $regulations) && $lc->issuer == "MARINA"){
									$docu = $lc;
								}
							}
						}
					}
				}
			}
		}
		elseif($type == "flag"){
			if($date){
				foreach(get_object_vars($applicant->document_flag) as $fd){
					if(str_starts_with(strtoupper($fd->country), $applicant->vessel->flag) && $fd->type == $name){
						$docu = $fd;
					}
				}
			}
			else{
				foreach(get_object_vars($applicant->document_flag) as $fd){
					if(str_starts_with(strtoupper($fd->country), $applicant->vessel->flag)){
						$value = $fd->{$name};

						if($name == "rank"){
							$docu = $ranks[$value-1]->abbr;
						}
					}
				}
			}
		}
		else{
			$docu = isset($applicant->document_med_cert->$name) ? $applicant->document_med_cert->$name : null;
		}

		$nh = now()->diffInMonths(now()->parse($applicant->joining_date)) <= 3 ? true : false;
		$bg = $nh ? $fy : "";

		if($docu && (isset($docu->no) || isset($docu->number))){			
			$expiry = null;
			if($docu->issue_date && !$docu->expiry_date){
				$expiry = "UNLIMITED";
			}
			elseif($docu->expiry_date){
				$expiry = $docu->expiry_date->format('Y-m-d');
			}
			else{
				$expiry = '---';
			}

			$diff = 0;
			if($expiry){
				$diff = now()->diffInDays($docu->expiry_date);
			}

			if($expiry != "UNLIMITED" && $expiry != "---"){
				if(now()->format("Y-m-d") > $expiry || $diff <= 30){
					$bg = $fr;
				}
				elseif($diff <= 90){
					$bg = $fy;
				}

				$expiry = now()->parse($expiry)->format('d-M-y');
			}


			echo "
				<td style='$center $bg'>$expiry</td>
			";
		}
		else{
			echo "
				<td style='$center $bg'>---</td>
			";
		}
	};
@endphp

<table>
	<tr>
		<td colspan="3" style="{{ $bold }} {{ $blue }}">
			FLEET A - CREWLIST
		</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $bold }} {{ $blue }}">
			TOEI FLEET VESSEL
		</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $blue }}"></td>
		<td style="{{ $bold }} {{ $blue }}"></td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $center }} {{ $blue }} {{ $und }}">PERSONAL INFORMATION</td>
		<td colspan="5" style="{{ $center }} {{ $blue }} {{ $und }}">TRAVEL DOCUMENTS</td>
		<td colspan="8" style="{{ $center }} {{ $blue }} {{ $und }}">FLAG / NATIONAL LICENCES</td>
	</tr>

	<tr>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">NO</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">PRINCIPAL</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">VESSEL NAME</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">RANK</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">NAME</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">DOB</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">AGE</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">SIGN-ON</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">SIGN-OFF</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">DOC</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">MOB</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">PPRT</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">SIRB</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">US VISA</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">MCV</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">PEME</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">NATIONAL<br style='mso-data-placement:same-cell;' />LICENSE</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">RANK</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">GOC</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">FLAG</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">TYPE</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">FLAG<br style='mso-data-placement:same-cell;' />LIC/SIRB</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">FLAG GOC</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">FLAG<br style='mso-data-placement:same-cell;' />SSO/SDSD</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">BT COP</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">PSCRB<br style='mso-data-placement:same-cell;' />COP</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">AFF COP</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">OWWA INS.<br style='mso-data-placement:same-cell;' />2 YRS</td>
	</tr>

	@php
		$ctr = 0;
	@endphp
	@foreach($data as $applicant)
		<tr>
			@php
				$ctr++;
				$mob = now()->diffInDays(now()->parse($applicant->joining_date)) / 30;
				$nh = $mob <= 3 ? true : false;
				$bg = $nh ? $fr : "";

				$bg2 = $mob >= 6 ? ($mob >= 9 ? $fr2 : $fr) : $bg;
			@endphp

			<td style="{{ $center }} {{ $bg }}">{{ $ctr }}</td>
			<td style="{{ $center }} {{ $bg }}">{{ $applicant->vessel->principal->name }}</td>
			<td style="{{ $center }} {{ $bg }}">{{ str_replace('- Onboard', '', $filename) }}</td>
			<td style="{{ $center }} {{ $bg }}">{{ $applicant->abbr }}</td>
			<td style="{{ $center }} {{ $bg }}">
				{{ $applicant->lname }}, {{ $applicant->fname }} {{ $applicant->suffix }} {{ $applicant->mname }}
			</td>
			<td style="{{ $center }} {{ $bg }}">
				{{ $applicant->birthday ? now()->parse($applicant->birthday)->format('d-M-y') : "---" }}
			</td>
			<td style="{{ $center }} {{ $bg }}">
				{{ $applicant->birthday ? now()->parse($applicant->birthday)->age : "---" }}
			</td>
			<td style="{{ $center }} {{ $bg }}">
				{{ $applicant->joining_date ? now()->parse($applicant->joining_date)->format('d-M-y') : '---' }}
			</td>
			<td style="{{ $center }} {{ $bg }}">
				{{ $applicant->joining_date ? now()->parse($applicant->joining_date)->add($applicant->months, 'months')->format('d-M-y') : '---' }}
			</td>
			<td style="{{ $center }} {{ $bg }}">
				{{ $applicant->months }}
			</td>
			<td style="{{ $center }} {{ $bg2 }}">
				=(TODAY()-H{{ $ctr + 5 }})/30
			</td>

			{{ $doc($applicant, "PASSPORT", 'id') }}
			{{ $doc($applicant, "SEAMAN'S BOOK", 'id') }}
			{{ $doc($applicant, "US-VISA", 'id') }}
			{{ $doc($applicant, "MCV", 'id') }}
			{{ $doc($applicant, "MEDICAL CERTIFICATE", 'med_cert') }}
			{{ $doc($applicant, "COC", 'lc', 1, $applicant->rType == "RATING" ? 1 : 0) }}
			<td style="{{ $center }} {{ $bg }}">{{ $applicant->abbr }}</td>
			{{ $doc($applicant, "GMDSS/GOC", 'lc') }}
			<td style="{{ $center }} {{ $bg }}">{{ $applicant->vessel->flag }}</td>
			<td style="{{ $center }} {{ $bg }}">{{ $applicant->vessel->type }}</td>
			{{ $doc($applicant, "LICENSE", 'flag') }}
			{{ $doc($applicant, "GMDSS/GOC", 'flag') }}
			{{ $doc($applicant, $applicant->rType == "OFFICER" ? "SSO" : "SDSD", 'flag') }}
			{{ $doc($applicant, "BASIC TRAINING - BT", 'lc') }}
			{{ $doc($applicant, "PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB", 'lc') }}
			{{ $doc($applicant, "ADVANCE FIRE FIGHTING - AFF", 'lc') }}
			<td style="{{ $center }} {{ $bg }}"></td>
		</tr>
	@endforeach
</table>