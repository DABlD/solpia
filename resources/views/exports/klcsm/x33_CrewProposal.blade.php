@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";

	$getBmi = function($h, $w){
		if($h == null || $w == null){
			return '-';
		}

        $h = $h / 100;
        return round($w / ($h * $h));
	};

	$solpia = function($sss){
		foreach($sss as $ss){
			if(str_contains($ss->manning_agent, "SOLPIA")){
				return "Re-Emp";
			}
		}

		return "";
	};

	$total = function($sss, $type = null){
		$ctr = 0;

		foreach($sss as $ss){
			if(isset($ss->sign_on) && isset($ss->sign_off)){
				if($type){
					if(str_contains($ss->vessel_type, $type)){
						$ctr += $ss->sign_off->diffInMonths($ss->sign_on);
					}
				}
				else{
					$ctr += $ss->sign_off->diffInMonths($ss->sign_on);
				}
			}
		}

		$y = number_format($ctr / 12, 0);
		$m = number_format($ctr % 12, 0);

		return $y . "Y " . $m . "M";
	};
@endphp

<table>
	<tr>
		<td colspan="3" style="{{ $b }}">Ship's Name: {{ $vessel }}</td>
		<td colspan="14"></td>
	</tr>

	<tr>
		<td rowspan="2">No.</td>
		<td rowspan="2">Rank</td>
		<td rowspan="2">Name</td>
		<td rowspan="2">D.O.B</td>
		<td rowspan="2">AGE</td>
		<td rowspan="2">BMI</td>
		<td rowspan="2">Emp. No. (HRIS)</td>
		<td rowspan="2">
			Re-Emp,
			<br style='mso-data-placement:same-cell;' />
			or
			<br style='mso-data-placement:same-cell;' />
			New-Emp
		</td>
		<td rowspan="2">Last Ship (Company) Evaluation</td>
		<td colspan="2">
			Ship Career
			<br style='mso-data-placement:same-cell;' />
			(YY-MM)
		</td>
		<td rowspan="2">Combined Crew (Nationality)</td>
		<td rowspan="2">Welding Edu. /Training</td>
		<td rowspan="2">Cooking Evaluation</td>
		<td colspan="3">
			Korea Flag License / Cert.
			<br style='mso-data-placement:same-cell;' />
			(Issue / Exp. Date)
		</td>
	</tr>

	<tr>
		<td>Total</td>
		<td>Bulk</td>
		<td>COC</td>
		<td>PSCRB</td>
		<td>W/KEEPING</td>
	</tr>

	@foreach($data as $crew)
		<tr>
			<td rowspan="3">{{ $loop->index + 1 }}</td>
			<td rowspan="2">{{ $crew->rank }}</td>
			<td rowspan="2">{{ $crew->user->namefull }}</td>
			<td rowspan="2">{{ $crew->user->birthday ? $crew->user->birthday->format('M/d/Y') : '-' }}</td>
			<td rowspan="2">{{ $crew->user->birthday ? $crew->user->birthday->age : '-' }}</td>
			<td rowspan="2">{{ $getBmi($crew->height, $crew->weight) }}</td>
			<td rowspan="2">{{ optional(optional($crew->document_id)->firstWhere('type', 'HRIS ID'))->number ?? '-' }}</td>
			<td rowspan="2">{{ $solpia($crew->sea_service) }}</td>
			<td rowspan="2"></td>
			<td rowspan="2">{{ $total($crew->sea_service) }}</td>
			<td rowspan="2">{{ $total($crew->sea_service, 'BULK') }}</td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td></td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td>Remark</td>
			<td colspan="15"></td>
		</tr>
	@endforeach
</table>