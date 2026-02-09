@php
	// dd($data);
	$maxSize = max(count($data[0]), count($data[1]), count($data[2]), count($data[3]), count($data[4]), count($data[5]));
	$maxSize2 = max(count($data[9]["Junior Officer"]), count($data[9]["Ratings"]));
@endphp

<table>
	<tr>
		<td colspan="6">
			Total number of recruited crew
		</td>
		<td></td>
		<td colspan="6">
			Total of successful applicants (For approval, For Medical, Passed, On board status)
		</td>
		<td></td>
		<td colspan="6">
			Total of unsuccessful (Rejected status with DECLINE, WITHDRAW, FAILED remark)
		</td>
		<td></td>
		<td colspan="6">
			Total of disapproved (Rejected status with DISAPPROVED remark)
		</td>
		<td></td>
		<td colspan="6">
			Total of unfit (Rejected status with UNFIT remark)
		</td>
		<td></td>
		<td colspan="6">
			Total of backed out/back out (Back out/Backed out remarks)
		</td>
		<td></td>
	</tr>

	<tr>
		<td>Rank</td>
		<td>Kalaw</td>
		<td>Online</td>
		<td>Walk-in</td>
		<td>Source</td>
		<td>Job Fair</td>
		<td></td>
		<td>Rank</td>
		<td>Kalaw</td>
		<td>Online</td>
		<td>Walk-in</td>
		<td>Source</td>
		<td>Job Fair</td>
		<td></td>
		<td>Rank</td>
		<td>Kalaw</td>
		<td>Online</td>
		<td>Walk-in</td>
		<td>Source</td>
		<td>Job Fair</td>
		<td></td>
		<td>Rank</td>
		<td>Kalaw</td>
		<td>Online</td>
		<td>Walk-in</td>
		<td>Source</td>
		<td>Job Fair</td>
		<td></td>
		<td>Rank</td>
		<td>Kalaw</td>
		<td>Online</td>
		<td>Walk-in</td>
		<td>Source</td>
		<td>Job Fair</td>
		<td></td>
		<td>Rank</td>
		<td>Kalaw</td>
		<td>Online</td>
		<td>Walk-in</td>
		<td>Source</td>
		<td>Job Fair</td>
	</tr>

	@foreach($data[0] as $key => $temp)
		<tr>
			<td>{{ $key }}</td>
			<td>{{ isset($data[0][$key]['Kalaw']) ? $data[0][$key]['Kalaw'] : 0 }}</td>
			<td>{{ isset($data[0][$key]['Online']) ? $data[0][$key]['Online'] : 0 }}</td>
			<td>{{ isset($data[0][$key]['Walk-in']) ? $data[0][$key]['Walk-in'] : 0 }}</td>
			<td>{{ isset($data[0][$key]['Source']) ? $data[0][$key]['Source'] : 0 }}</td>
			<td>{{ isset($data[0][$key]['Job Fair']) ? $data[0][$key]['Job Fair'] : 0 }}</td>
			<td></td>
			<td>{{ $key }}</td>
			<td>{{ isset($data[1][$key]['Kalaw']) ? $data[1][$key]['Kalaw'] : 0 }}</td>
			<td>{{ isset($data[1][$key]['Online']) ? $data[1][$key]['Online'] : 0 }}</td>
			<td>{{ isset($data[1][$key]['Walk-in']) ? $data[1][$key]['Walk-in'] : 0 }}</td>
			<td>{{ isset($data[1][$key]['Source']) ? $data[1][$key]['Source'] : 0 }}</td>
			<td>{{ isset($data[1][$key]['Job Fair']) ? $data[1][$key]['Job Fair'] : 0 }}</td>
			<td></td>
			<td>{{ $key }}</td>
			<td>{{ isset($data[2][$key]['Kalaw']) ? $data[2][$key]['Kalaw'] : 0 }}</td>
			<td>{{ isset($data[2][$key]['Online']) ? $data[2][$key]['Online'] : 0 }}</td>
			<td>{{ isset($data[2][$key]['Walk-in']) ? $data[2][$key]['Walk-in'] : 0 }}</td>
			<td>{{ isset($data[2][$key]['Source']) ? $data[2][$key]['Source'] : 0 }}</td>
			<td>{{ isset($data[2][$key]['Job Fair']) ? $data[2][$key]['Job Fair'] : 0 }}</td>
			<td></td>
			<td>{{ $key }}</td>
			<td>{{ isset($data[3][$key]['Kalaw']) ? $data[3][$key]['Kalaw'] : 0 }}</td>
			<td>{{ isset($data[3][$key]['Online']) ? $data[3][$key]['Online'] : 0 }}</td>
			<td>{{ isset($data[3][$key]['Walk-in']) ? $data[3][$key]['Walk-in'] : 0 }}</td>
			<td>{{ isset($data[3][$key]['Source']) ? $data[3][$key]['Source'] : 0 }}</td>
			<td>{{ isset($data[3][$key]['Job Fair']) ? $data[3][$key]['Job Fair'] : 0 }}</td>
			<td></td>
			<td>{{ $key }}</td>
			<td>{{ isset($data[4][$key]['Kalaw']) ? $data[4][$key]['Kalaw'] : 0 }}</td>
			<td>{{ isset($data[4][$key]['Online']) ? $data[4][$key]['Online'] : 0 }}</td>
			<td>{{ isset($data[4][$key]['Walk-in']) ? $data[4][$key]['Walk-in'] : 0 }}</td>
			<td>{{ isset($data[4][$key]['Source']) ? $data[4][$key]['Source'] : 0 }}</td>
			<td>{{ isset($data[4][$key]['Job Fair']) ? $data[4][$key]['Job Fair'] : 0 }}</td>
			<td></td>
			<td>{{ $key }}</td>
			<td>{{ isset($data[5][$key]['Kalaw']) ? $data[5][$key]['Kalaw'] : 0 }}</td>
			<td>{{ isset($data[5][$key]['Online']) ? $data[5][$key]['Online'] : 0 }}</td>
			<td>{{ isset($data[5][$key]['Walk-in']) ? $data[5][$key]['Walk-in'] : 0 }}</td>
			<td>{{ isset($data[5][$key]['Source']) ? $data[5][$key]['Source'] : 0 }}</td>
			<td>{{ isset($data[5][$key]['Job Fair']) ? $data[5][$key]['Job Fair'] : 0 }}</td>
		</tr>
	@endforeach

	<tr>
		<td>TOTAL</td>
		<td>=SUM(B3:B38)</td>
		<td>=SUM(C3:C38)</td>
		<td>=SUM(D3:D38)</td>
		<td>=SUM(E3:E38)</td>
		<td>=SUM(F3:F38)</td>
		<td></td>
		<td>TOTAL</td>
		<td>=SUM(I3:I38)</td>
		<td>=SUM(J3:J38)</td>
		<td>=SUM(K3:K38)</td>
		<td>=SUM(L3:L38)</td>
		<td>=SUM(M3:M38)</td>
		<td></td>
		<td>TOTAL</td>
		<td>=SUM(P3:P38)</td>
		<td>=SUM(Q3:Q38)</td>
		<td>=SUM(R3:R38)</td>
		<td>=SUM(S3:S38)</td>
		<td>=SUM(T3:T38)</td>
		<td></td>
		<td>TOTAL</td>
		<td>=SUM(W3:W38)</td>
		<td>=SUM(X3:X38)</td>
		<td>=SUM(Y3:Y38)</td>
		<td>=SUM(Z3:Z38)</td>
		<td>=SUM(AA3:AA38)</td>
		<td></td>
		<td>TOTAL</td>
		<td>=SUM(AD3:AD38)</td>
		<td>=SUM(AE3:AE38)</td>
		<td>=SUM(AF3:AF38)</td>
		<td>=SUM(AG3:AG38)</td>
		<td>=SUM(AH3:AH38)</td>
		<td></td>
		<td>TOTAL</td>
		<td>=SUM(AK3:AK38)</td>
		<td>=SUM(AL3:AL38)</td>
		<td>=SUM(AM3:AM38)</td>
		<td>=SUM(AN3:AN38)</td>
		<td>=SUM(AO3:AO38)</td>
	</tr>

	<tr></tr>

	<tr>
		<td colspan="5">Requested Crew</td>
	</tr>

	<tr>
		<td colspan="3">TOP 4</td>
		<td></td>
		<td colspan="3">Officer</td>
		<td></td>
		<td colspan="4">Ratings</td>
	</tr>

	@for($i = 0; $i < $maxSize2; $i++)
		<tr>
			@if(isset(array_keys($data[9]["Top 4"])[$i]))
				<td colspan="2">{{ array_keys($data[9]["Top 4"])[$i] }}</td>
				<td>{{ $data[9]["Top 4"][array_keys($data[9]["Top 4"])[$i]] }}</td>
			@else
				<td colspan="2"></td>
				<td></td>
			@endif

			<td></td>

			@if(isset(array_keys($data[9]["Junior Officer"])[$i]))
				<td colspan="2">{{ array_keys($data[9]["Junior Officer"])[$i] }}</td>
				<td>{{ $data[9]["Junior Officer"][array_keys($data[9]["Junior Officer"])[$i]] }}</td>
			@else
				<td colspan="2"></td>
				<td></td>
			@endif

			<td></td>

			@if(isset(array_keys($data[9]["Ratings"])[$i]))
				<td colspan="3">{{ array_keys($data[9]["Ratings"])[$i] }}</td>
				<td>{{ $data[9]["Ratings"][array_keys($data[9]["Ratings"])[$i]] }}</td>
			@else
				<td colspan="3"></td>
				<td></td>
			@endif
		</tr>
	@endfor

	<tr>
		<td></td>
	</tr>

	<tr>
		<td colspan="4">Timely Submission</td>
	</tr>

	<tr>
		<td></td>
		<td>On Time</td>
		<td>No</td>
		<td>Percent</td>
	</tr>

	<tr>
		<td>All</td>
		<td>{{ $data[6]['On time'] + $data[7]['On time'] + $data[8]['On time'] }}</td>
		<td>{{ $data[6]['No'] + $data[7]['No'] + $data[8]['No'] }}</td>
		<td>{{ ($data[6]['On time'] + $data[7]['On time'] + $data[8]['On time'] + $data[6]['No'] + $data[7]['No'] + $data[8]['No']) ? (($data[6]['On time'] + $data[7]['On time'] + $data[8]['On time']) / ($data[6]['On time'] + $data[7]['On time'] + $data[8]['On time'] + $data[6]['No'] + $data[7]['No'] + $data[8]['No'])) * 100 : 0 }}</td>
	</tr>

	<tr>
		<td>Top 4</td>
		<td>{{ $data[6]['On time'] }}</td>
		<td>{{ $data[6]['No'] }}</td>
		<td>{{ $data[6]['Percent'] }}</td>
	</tr>

	<tr>
		<td>Junior Officers</td>
		<td>{{ $data[7]['On time'] }}</td>
		<td>{{ $data[7]['No'] }}</td>
		<td>{{ $data[7]['Percent'] }}</td>
	</tr>

	<tr>
		<td>Ratings</td>
		<td>{{ $data[8]['On time'] }}</td>
		<td>{{ $data[8]['No'] }}</td>
		<td>{{ $data[8]['Percent'] }}</td>
	</tr>
</table>