@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";
@endphp

<table>
	<tr>
		<td style="{{ $bc }}">RANK</td>
		<td style="{{ $bc }}">TYPE</td>
		<td style="{{ $bc }}">SIGNON</td>
		<td style="{{ $bc }}">SIGNOFF</td>
		<td style="{{ $bc }}">DAYS</td>
		<td style="{{ $bc }}">YY/MM/DD</td>
		<td style="{{ $bc }}">REMARKS</td>
	</tr>

	@php
		$prev = null;
		$start = null;
		$total = 0;
	@endphp

	@foreach($data->sea_service as $ss)
		@php
			$diff = '-';
			if($prev != null){
				$diff = $ss->sign_off ? $ss->sign_off->diff($prev)->format('%yyr, %mmos, %ddays') : '-';
			}
			$days = (isset($ss->sign_on) && isset($ss->sign_off)) ? $ss->sign_off->diffInDays($ss->sign_on) : "-";
			$prev = $ss->sign_on;

			if($days != "-"){
				$total += $days;
			}
		@endphp
		<tr>
			<td style="{{ $c }}">{{ $ss->rank }}</td>
			<td style="{{ $c }}">{{ $ss->vessel_type }}</td>
			<td style="{{ $c }} background-color: #00B050;">{{ isset($ss->sign_on) ? $ss->sign_on->format('d-M-y') : "-" }}</td>
			<td style="{{ $c }} background-color: #00B050;">{{ isset($ss->sign_off) ? $ss->sign_off->format('d-M-y') : "-" }}</td>
			<td style="{{ $c }}">{{ $days }}</td>
			<td style="{{ $c }}">{{ (isset($ss->sign_on) && isset($ss->sign_off)) ? $ss->sign_off->diff($ss->sign_on)->format('%yyr, %mmos, %ddays') : "-" }}</td>
			<td style="{{ $c }}">{{ $ss->remarks }}</td>
			<td style="{{ $c }}">{{ $diff }}</td>
		</tr>
	@endforeach

	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td style="{{ $bc }} background-color: #FFFF00;">{{ $total }}</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td style="{{ $bc }}">TOTAL YEARS:</td>
		<td style="background-color: #00B050; color: #FFFF00;">{{ $total/365 }}</td>
	</tr>
</table>