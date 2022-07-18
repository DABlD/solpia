@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	$blue = "color: #0000FF;";
	$und = "text-decoration: underline;";

	// FILLS
	$fo = "background-color: #FFC000;";
	$fg = "background-color: #D9D9D9;";

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
			else{
				$expiry = '---';
			}

			$diff = 69;
			$bg = "";
			if($expiry){
				$diff = now()->diffInDays($docu->expiry_date);
			}

			if($expiry != "UNLIMITED" && $expiry != "---"){
				if($diff <= 90){
					$bg = $fr;
				}
			}

			echo "
				<td style='$center $bg'>$expiry</td>
			";
		}
		else{
			echo "
				<td style='$center'>---</td>
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
			SHINKO MARITIME
		</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $blue }}">Updated as of: </td>
		<td style="{{ $bold }} {{ $blue }}">{{ now()->format('F j, Y') }}</td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $center }} {{ $blue }} {{ $und }}"></td>
		<td colspan="5" style="{{ $center }} {{ $blue }} {{ $und }}">TRAVEL DOCUMENTS</td>
		<td colspan="8" style="{{ $center }} {{ $blue }} {{ $und }}">FLAG / NATIONAL DOCUMENTS</td>
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
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">NATIONAL LICENSE</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">RANK</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">GOC</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">FLAG</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">TYPE</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">FLAG LIC/SIRB</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">FLAG GOC</td>
		<td style="{{ $center }} {{ $blue }} {{ $und }} height: 30px;">FLAG SSO/SDSD</td>
	</tr>

	@php
		$ctr = 0;
		$ctr2 = 0;
	@endphp
	@foreach($applicants as $key => $va)
		@php
			if($ctr != 0){
				echo '
					<tr>
						<td style="background-color: #808080;"></td>
						<td colspan="15"></td>
					</tr>
				';
			}

			$ctr3 = 0;
		@endphp
		@foreach($va as $applicant)
			<tr>
				@php
					$ctr2++;
					$ctr3++;
				@endphp

				<td style="{{ $center }}">{{ $ctr3 }}</td>
				<td style="{{ $center }}">{{ $applicant->pname }}</td>
				<td style="{{ $center }}">{{ $key }}</td>
				<td style="{{ $center }}">{{ $ranks[$applicant->rid]->abbr }}</td>
				<td style="{{ $center }}">
					{{ $applicant->lname }}, {{ $applicant->pname }} {{ $applicant->suffix }} {{ $applicant->mname }}
				</td>
				<td style="{{ $center }}">
					{{ $applicant->birthday ? now()->parse($applicant->birthday)->format('d-M-y') : "---" }}
				</td>
				<td style="{{ $center }}">
					{{ $applicant->birthday ? now()->parse($applicant->birthday)->age : "---" }}
				</td>
				<td style="{{ $center }}">
					{{ $applicant->joining_date ? now()->parse($applicant->joining_date)->format('d-M-y') : '---' }}
				</td>
				<td style="{{ $center }}">
					{{ $applicant->joining_date ? now()->parse($applicant->joining_date)->add($applicant->months, 'months')->format('d-M-y') : '---' }}
				</td>
				<td style="{{ $center }}">
					{{ $applicant->months }}
				</td>
				<td style="{{ $center }}">
					=(TODAY()-H{{ $ctr + $ctr2 + 5 }})/30
				</td>

				{{ $doc($applicant, "PASSPORT", 'id') }}
				{{ $doc($applicant, "SEAMAN'S BOOK", 'id') }}
				{{ $doc($applicant, "US-VISA", 'id') }}
				{{ $doc($applicant, "MCV", 'id') }}
				{{ $doc($applicant, "MEDICAL CERTIFICATE", 'med_cert') }}
				{{ $doc($applicant, "COC", 'lc', 1, 1) }}
				<td style="{{ $center }}">{{ $ranks[$applicant->rid]->abbr }}</td>
				{{ $doc($applicant, "GMDSS/GOC", 'lc') }}
				<td style="{{ $center }}">{{ $applicant->flag }}</td>
				<td style="{{ $center }}">{{ $applicant->type }}</td>
				{{ $doc($applicant, "LICENSE", 'flag') }}
				{{ $doc($applicant, "GMDSS/GOC", 'flag') }}
				{{ $doc($applicant, $applicant->rtype == "OFFICER" ? "SSO" : "SDSD", 'flag') }}
			</tr>
		@endforeach
		@php
			$ctr++;
		@endphp
	@endforeach

	<tr>
		<td colspan="24" style="height: 40px;"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2">TOTAL VESSEL:</td>
		<td>{{ sizeof($applicants) }}</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2">TOTAL CREW ONBOARD</td>
		<td>{{ $ctr2 }}</td>
	</tr>
</table>