@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	$blue = "color: #0000FF;";
	$und = "text-decoration: underline;";

	// FILLS
	$fo = "background-color: #FFC000;";
	$fg = "background-color: #D9D9D9;";

	$doc = function($applicant, $name, $type, $date = 1, $ratings = 0) use(&$docu, $ranks){
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
					if(str_starts_with(strtoupper($fd->country), $applicant->flag) && $fd->type == $name){
						$docu = $fd;
					}
				}
			}
			else{
				foreach(get_object_vars($applicant->document_flag) as $fd){
					if(str_starts_with(strtoupper($fd->country), $applicant->flag)){
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

		if($docu && (isset($docu->no) || isset($docu->number))){
			$expiry = null;
			if($docu->issue_date && !$docu->expiry_date){
				$expiry = "UNLIMITED";
			}
			elseif($docu->expiry_date){
				$expiry = $docu->expiry_date->format('d-M-y');
			}

			$diff = 69;
			$bg = "";
			if($expiry){
				$diff = now()->diffInMonths($docu->expiry_date);
			}

			if($expiry != "UNLIMITED"){
				if($diff <= 1){
					$bg = $fr;
				}
				elseif($diff <= 3){
					$bg = $fy;
				}
				elseif($diff <= 6){
					$bg = $fb;
				}
			}

			echo "
				<td style='$bg'>$expiry</td>
			";
		}
		else{
			echo "
				<td>$docu</td>
			";
		}
	};
@endphp

<table>
	<tr>
		<td></td>
		<td colspan="6" style="{{ $bold }} {{ $und }} {{ $blue }} font-size: 12px;">
			FLEET B - ONBOARD CREW DOCUMENTS MONITORING
		</td>
	</tr>

	<tr>
		<td></td>
		<td>DATE:</td>
		<td style="{{ $bold }} {{ $fo }}">{{ now()->format('d-M-Y') }}</td>
	</tr>

	<tr>
		<td colspan="8"></td>
		<td colspan="4" style="{{ $bold }} {{ $center }}">NATIONAL ID / VISA</td>
		<td colspan="7" style="{{ $bold }} {{ $center }}">FLAG LICENSE</td>
		<td colspan="4" style="{{ $bold }} {{ $center }}">NATIONAL LICENSE</td>
		<td colspan="3" style="{{ $bold }} {{ $center }}">COP TRAININGS</td>
		<td colspan="2" style="{{ $bold }} {{ $center }}">MEDICAL</td>
	</tr>

	<tr>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">NO.</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">PRINCIPAL</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">VESSEL NAME</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">RANK</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">NAME</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">DATE OF JOIN</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">MONTHHS ONBOARD</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">SENIORITY LEVEL</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">PASSPORT VALIDITY</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">SEAMAN'S BOOK VALIDITY</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">US VISA VALIDITY</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">MARITIME CREW VISA</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">FLAG</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">TYPE</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">BOOKLET VALIDITY</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">COC VALIDITY</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">GOC VALIDITY</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">SDSD/SSO VALIDITY</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">COOK ENDORSEMENT VALIDITY</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">COC LICENSE VALIDITY</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">GOC LICENSE VALIDITY</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">COC-RATINGS VALIDITY</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">COC-GALLEY VALIDITY</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">COP BT VALIDITY</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">COP PSCRB VALIDITY</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">COP AFF VALIDITY</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">MEDICAL VALIDITY</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">DAAT</td>
		<td style="{{ $bold }} {{ $und }} {{ $fg }} height: 30px;">PIC</td>
	</tr>

	@php
		$ctr = 1;
	@endphp
	@foreach($applicants as $applicant)
		@php
			$joining_date = now()->parse($applicant->joining_date);
		@endphp
		<tr>
			<td>{{ $ctr }}</td>
			<td>{{ $applicant->pname }}</td>
			<td>{{ $applicant->vname }}</td>
			<td>{{ $applicant->rname }}</td>
			<td>{{ $applicant->lname }}, {{ $applicant->fname }} {{ $applicant->suffix }} {{ $applicant->mname }}</td>
			<td>{{ $joining_date->format('d-M-y') }}</td>
			<td>{{ round(now()->diffInDays($joining_date) / 30, 1) }}</td>
			<td>{{ $applicant->seniority }}</td>

			{{ $doc($applicant, "PASSPORT", 'id') }}
			{{ $doc($applicant, "SEAMAN'S BOOK", 'id') }}
			{{ $doc($applicant, "US-VISA", 'id') }}
			{{ $doc($applicant, "MCV", 'id') }}
			<td>{{ $applicant->flag }}</td>
			{{ $doc($applicant, "rank", 'flag', 0) }}
			{{ $doc($applicant, "BOOKLET", 'flag') }}
			{{ $doc($applicant, "LICENSE", 'flag') }}
			{{ $doc($applicant, "GMDSS/GOC", 'flag') }}
			{{ $doc($applicant, $applicant->rtype == "OFFICER" ? "SSO" : "SDSD", 'flag') }}
			{{ $doc($applicant, "SHIP'S COOK ENDORSEMENT", 'flag') }}
			{{ $doc($applicant, "COC", 'lc', 1, 0) }}
			{{ $doc($applicant, "GMDSS/GOC", 'lc') }}
			{{ $doc($applicant, "COC", 'lc', 1, 1) }}
			{{ $doc($applicant, "NCIII", 'lc') }}
			{{ $doc($applicant, "BASIC TRAINING - BT", 'lc') }}
			{{ $doc($applicant, "PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB", 'lc') }}
			{{ $doc($applicant, "ADVANCE FIRE FIGHTING - AFF", 'lc') }}
			{{ $doc($applicant, "MEDICAL CERTIFICATE", 'med_cert') }}
			{{ $doc($applicant, "DRUG AND ALCOHOL TEST", 'med_cert') }}
			<td></td>
		</tr>
		@php
			$ctr++;
		@endphp
	@endforeach
		@php
		// die;
			$ctr++;
		@endphp
</table>