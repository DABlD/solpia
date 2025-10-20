@php
	$center = "text-align: center;";
	$middle = "vertical-align: middle;";
	$bottom = "vertical-align: bottom;";
	$top = "vertical-align: top;";
	$bold = "font-weight: bold;";
	$und = "text-decoration: underline;";
	$red = "color: #FF0000;";
	$bb = "border-bottom: 1px solid #000000;";
	// dd($data);
@endphp

<table>
	<tr>
		<td rowspan="35"></td>
		<td colspan="9" style="height: 60px;"></td>
	</tr>

	<tr>
		<td style="{{ $center }}" colspan="9">CONTRACT CONFIRMATION FORM</td>
	</tr>

	<tr>
		<td style="{{ $center }} {{ $red }} {{ $und }}" colspan="9">PROMOTION</td>
	</tr>

	<tr>
		<td style="height: 20px;" colspan="6"></td>
		<td>DATE:</td>
		<td style="{{ $und }}">{{ now()->format('F j, Y') }}</td>
	</tr>

	<tr>
		<td colspan="2">VESSEL</td>
		<td colspan="3" style="{{ $center }}">{{ $data->vessel->name }}</td>
	</tr>

	<tr>
		<td colspan="2">NAME</td>
		<td colspan="3" style="{{ $center }}">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
	</tr>

	<tr>
		<td colspan="2">DATE OF BIRTH</td>
		<td colspan="3" style="{{ $center }}">{{ $data->user->birthday->format('F j, Y') }}</td>
	</tr>

	<tr>
		<td colspan="2">RANK (FROM/TO)</td>
		<td colspan="3" style="{{ $center }}">{{ $data->ranks[$data->pro_app->rank_id] }} - {{ $data->ranks[$data->data['rank']] }}</td>
	</tr>

	<tr>
		<td colspan="2">DATE EMBARKED</td>
		<td colspan="3" style="{{ $center }}">{{ $data->con->joining_date->format('F j, Y') }}</td>
	</tr>

	<tr>
		<td colspan="2">DATE OF EFFECTIVITY</td>
		<td colspan="3" style="{{ $center }}">{{ now()->parse($data->data["doe"])->format('F j, Y') }}</td>
	</tr>

	<tr>
		<td colspan="2">CONTRACT DURATION</td>
		<td colspan="3" style="{{ $center }}">{{ $data->data['cd'] }}</td>
	</tr>

	<tr>
		<td colspan="2">PREVIOUS MO. WAGE</td>
		<td colspan="3" style="{{ $center }}">${{ $data->wage1 }}</td>
	</tr>

	<tr>
		<td colspan="2">PRESENT MO. WAGE</td>
		<td colspan="3" style="{{ $center }}">${{ $data->wage2 }}</td>
	</tr>

	<tr>
		<td style="{{ $bold }} {{ $middle }} height: 30px;" colspan="9">
			1. DOCUMENTATION
		</td>
	</tr>

	<tr>
		<td rowspan="2"></td>
		<td style="{{ $center }} font-size: 9px;">SIRB</td>
		<td style="{{ $center }} font-size: 9px;">PPORT</td>
		<td style="{{ $center }} font-size: 9px;">COC</td>
		<td style="{{ $center }} font-size: 9px;">FLAG LICENSE</td>
		<td style="{{ $center }} font-size: 9px;">U.S. VISA/CONTRACT</td>
		<td style="{{ $center }} font-size: 9px;">Y. FEVER</td>
		<td style="{{ $center }} font-size: 9px;">MCV VISA</td>
		<td style="{{ $center }} font-size: 9px;">UNIFORM</td>
	</tr>

	@php
		// dd($data->document_id);
		$sb = $data->document_id->{"SEAMAN'S BOOK"} ?? null;
		$pp = $data->document_id->{"PASSPORT"} ?? null;
		$coc = null;
		foreach(get_object_vars($data->document_lc) as $lc){
			if(str_contains($lc, 'COC')){
				$coc = $lc;
			}
		}

		$fl = isset($data->document_flag->{"LICENSE"}) ? $data->document_flag->{"LICENSE"} : null;
		$uv = isset($data->document_id->{"US-VISA"}) ? $data->document_id->{"US-VISA"} : null;
		$yf = isset($data->document_med_cert->{"YELLOW FEVER"}) ? $data->document_med_cert->{"YELLOW FEVER"} : null;
		$mcv = isset($data->document_id->{"MCV"}) ? $data->document_id->{"MCV"} : null;
	@endphp
	<tr>
		<td style="{{ $center }} height: 40px;">
			{{ $sb->number ?? '-' }}
			<br style='mso-data-placement:same-cell;' />
			{{ isset($sb->expiry_date) ? $sb->expiry_date->format('d-M-Y') : '-' }}
		</td>
		<td style="{{ $center }} height: 40px;">
			{{ $pp->number ?? '-' }}
			<br style='mso-data-placement:same-cell;' />
			{{ isset($pp->expiry_date) ? $pp->expiry_date->format('d-M-Y') : '-' }}
		</td>
		<td style="{{ $center }} height: 40px;">
			{{ $coc->no ?? '-' }}
			<br style='mso-data-placement:same-cell;' />
			{{ isset($coc->expiry_date) ? $coc->expiry_date->format('d-M-Y') : '-' }}
		</td>
		<td style="{{ $center }} height: 40px;">
			{{ $fl->number ?? '-' }}
			<br style='mso-data-placement:same-cell;' />
			{{ isset($fl->expiry_date) ? $fl->expiry_date->format('d-M-Y') : '-' }}
		</td>
		<td style="{{ $center }} height: 40px;">
			{{ $uv->number ?? '-' }}
			<br style='mso-data-placement:same-cell;' />
			{{ $uv ? $uv->expiry_date->format('d-M-Y') : '-' }}
		</td>
		<td style="{{ $center }} height: 40px;">
			{{ $yf->number ?? '-' }}
			<br style='mso-data-placement:same-cell;' />
			{{ $yf ? $yf->expiry_date->format('d-M-Y') : '-' }}
		</td>
		<td style="{{ $center }} height: 40px;">
			{{ $mcv->number ?? '-' }}
			<br style='mso-data-placement:same-cell;' />
			{{ isset($mcv->expiry_date) ? $mcv->expiry_date->format('d-M-Y') : '-' }}
		</td>
		<td style="{{ $center }} height: 40px;">
		</td>
	</tr>

	<tr>
		<td style="{{ $bold }} {{ $middle }} height: 30px;" colspan="9">
			2. SEA EXPERIENCED (FOR PROMOTION CASES ONLY) :
		</td>
	</tr>

	<tr>
		<td rowspan="2"></td>
		<td style="{{ $center }} {{ $middle }} height: 35px;" colspan="3">PRESENT RANK</td>
		<td style="{{ $center }} {{ $middle }} height: 35px;" colspan="3">
			TOTAL MONTHS IN SOLPIA MARINE AT PRESENT RANK
		</td>
		<td style="{{ $center }} {{ $middle }} height: 35px;" colspan="2">
			TOTAL MONTHS IN OTHER COMPANIES AT PRESENT RANK
		</td>
	</tr>

	@php
		$solpia = 0;
		$others = 0;

		foreach($data->sea_service as $ss){
			if($ss->rank == $data->ranks2[$data->con->rank_id]){
				$total_months = 0;
				if($ss->sign_on && $ss->sign_off){
					$total_months = now()->parse($ss->sign_on)->diffInDays(now()->parse($ss->sign_off)) / 30;
				}

				if(str_contains($ss->manning_agent, 'SOLPIA')){
					$solpia += $total_months;
				}
				else{
					$others += $total_months;
				}
			}
		}
	@endphp

	<tr>
		<td style="{{ $center }} {{ $middle }} height: 40px;" colspan="3">{{ $data->rank }}</td>
		<td style="{{ $center }} {{ $middle }} height: 40px;" colspan="3">{{ round($solpia, 2) }}</td>
		<td style="{{ $center }} {{ $middle }} height: 40px;" colspan="2">{{ round($others, 2) }}</td>
	</tr>

	<tr>
		<td style="{{ $bold }} {{ $middle }} height: 30px;" colspan="9">
			3. RECOMMENDED BY:
		</td>
	</tr>

	<tr>
		<td style="{{ $middle }} {{ $center }} height: 25px;" colspan="9">
			{{ $data->data['recommended_by'] != "" ? $data->data['recommended_by'] : "N/A" }}
		</td>
	</tr>

	<tr>
		<td style="{{ $bold }} {{ $middle }} height: 30px;" colspan="9">
			4. OVERALL ASSESSMENTS:
		</td>
	</tr>

	<tr>
		<td rowspan="2"></td>
		<td style="{{ $center }} {{ $middle }} height: 40px;" colspan="3">RECTIFICATION PROCESS DONE</td>
		<td style="{{ $center }} {{ $middle }} height: 40px;" colspan="5"></td>
	</tr>

	<tr>
		<td style="{{ $center }} {{ $middle }} height: 40px;" colspan="3">FINAL REMARKS OF CREWING MANAGER</td>
		<td style="{{ $center }} {{ $middle }} height: 40px;" colspan="5">
			{{ $data->data['remarks'] != "" ? $data->data['remarks'] : "" }}
		</td>
	</tr>

	<tr>
		<td style="{{ $bold }} {{ $bottom }} height: 40px;" colspan="5">PREPARED BY:</td>
		<td style="{{ $bold }} {{ $bottom }} height: 40px;" colspan="4">REVIEWED BY:</td>
	</tr>

	<tr>
		<td style="{{ $bottom }} height: 20px;" colspan="5">
			{{ auth()->user()->gender == "Male" ? "Mr." : "Ms." }} {{ auth()->user()->fname }} {{ auth()->user()->lname }}
		</td>
		<td style="{{ $bottom }} height: 20px;" colspan="4"></td>
	</tr>

	<tr>
		<td style="{{ $top }} height: 20px;" colspan="5">Crewing Officer</td>
		<td style="{{ $top }} height: 20px;" colspan="4">Documentation Officer</td>
	</tr>

	<tr>
		<td style="{{ $bold }} {{ $bottom }} height: 40px;" colspan="5">PREPARED BY:</td>
		<td style="{{ $bold }} {{ $bottom }} height: 40px;" colspan="4">NOTED BY:</td>
	</tr>

	<tr>
		<td style="{{ $bottom }} height: 20px;" colspan="5">
			@if($data->vessel->fleet != "")
				@if($data->vessel->fleet == "TOEI")
					Mr. Philip Manapul
				@else
					Mr. Randy Andaya
				@endif
			@endif
		</td>
		<td style="{{ $bottom }} height: 20px;" colspan="4">Ms. Robelyn Ecleo</td>
	</tr>

	<tr>
		<td style="{{ $top }} height: 20px;" colspan="5">Liason Officer</td>
		<td style="{{ $top }} height: 20px;" colspan="4">Accounting Manager</td>
	</tr>

	<tr>
		<td style="{{ $bold }} {{ $bottom }} height: 40px;" colspan="5">CONFIRMED BY:</td>
		<td style="{{ $bold }} {{ $bottom }} height: 40px;" colspan="4">NOTED BY:</td>
	</tr>

	<tr>
		<td style="{{ $bottom }} height: 20px;" colspan="3">
			@if($data->vessel->fleet != "")
				@if($data->vessel->fleet == "FLEET A")
					Ms. Precian Cervantes
				@elseif($data->vessel->fleet == "FLEET B")
					Mr. Adulf Kit Jumawan
				@elseif($data->vessel->fleet == "FLEET C")
					Ms. Shirley Erasquin
				@elseif($data->vessel->fleet == "FLEET D")
					Ms. THEA MAE G. RIO
				@elseif($data->vessel->fleet == "FLEET E")
					Mr. Dennis Quiño
				@elseif($data->vessel->fleet == "TOEI")
					Mr. Neil Romano
				@endif
			@endif
		</td>
		<td style="{{ $bottom }} height: 20px; font-size: 8px;" colspan="2">
			{{ now()->format('m/d/Y H:i') }}
		</td>
		<td style="{{ $bottom }} height: 20px;" colspan="4"></td>
	</tr>

	<tr>
		<td style="{{ $top }} height: 20px;" colspan="5">Crewing Manager</td>
		<td style="{{ $top }} height: 20px;" colspan="4">Operations Manager</td>
	</tr>

	<tr>
		<td colspan="9" rowspan="2"></td>
	</tr>

	<tr></tr>

	<tr>
		<td style="font-size: 9px;" colspan="10">
			SMOP-PEW-17 (Rev 1) 16.08.17
		</td>
	</tr>
</table>