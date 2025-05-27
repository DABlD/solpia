@php
	// dd($onBoards);
@endphp

<table>
	<tr>
		<td style="height: 60px;"></td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="6">1. 승선 </td>
	</tr>

	<tr>
		<td></td>
		<td rowspan="2">RANK</td>
		<td rowspan="2">NAME</td>
		<td rowspan="2">DOB</td>
		<td>PASSPORT</td>
		<td>SEAMAN BOOK</td>
		<td rowspan="2">REMARK</td>
	</tr>

	<tr>
		<td></td>
		<td>EXP.DATE</td>
		<td>EXP.DATE</td>
	</tr>

	@foreach($linedUps as $key => $onSigner)
		<tr>
			<td></td>
			<td rowspan="2">{{ $onSigner->abbr }}</td>
			<td rowspan="2">{{ $onSigner->lname . ', ' . $onSigner->fname . ' ' . $onSigner->suffix . ' ' . $onSigner->mname }}</td>
			<td rowspan="2">{{ now()->parse($onSigner->birthday)->format('d-M-y') }}</td>
			<td>{{ $onSigner->{'PASSPORTn'} ? strtoupper($onSigner->{'PASSPORTn'}) : '-----' }}</td>
			<td>{{ $onSigner->{"SEAMAN'S BOOKn"} ? strtoupper($onSigner->{"SEAMAN'S BOOKn"}) : '-----' }}</td>
			<td rowspan="2"></td>
		</tr>

		<tr>
			<td></td>
			<td>{{ $onSigner->{'PASSPORT'} ? $onSigner->{'PASSPORT'}->format('d-M-y') : '----' }}</td>
			<td>{{ $onSigner->{"SEAMAN'S BOOK"} ? $onSigner->{"SEAMAN'S BOOK"}->format('d-M-y') : '-----' }}</td>
		</tr>
	@endforeach

	<tr>
		<td></td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td style="color: #0070C0; font-weight: bold;">FLIGHT SCHEDULE:</td>
		<td style="color: #0070C0; font-weight: bold;">TO FOLLOW</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="6">2. 하선 </td>
	</tr>

	<tr>
		<td></td>
		<td rowspan="2">RANK</td>
		<td rowspan="2">NAME</td>
		<td rowspan="2">DOB</td>
		<td>SEAMAN BOOK</td>
		<td>PASSPORT</td>
		<td rowspan="2">REMARK</td>
	</tr>

	<tr>
		<td></td>
		<td>EXP.DATE</td>
		<td>EXP.DATE</td>
	</tr>

	@foreach($onBoards as $key => $offSigner)
		<tr>
			<td></td>
			<td rowspan="2">{{ $offSigner->abbr }}</td>
			<td rowspan="2">{{ $offSigner->lname . ', ' . $offSigner->fname . ' ' . $offSigner->suffix . ' ' . $offSigner->mname }}</td>
			<td rowspan="2">{{ now()->parse($offSigner->birthday)->format('d-M-y') }}</td>
			<td>{{ $offSigner->{'PASSPORTn'} ? strtoupper($offSigner->{'PASSPORTn'}) : '-----' }}</td>
			<td>{{ $offSigner->{"SEAMAN'S BOOKn"} ? strtoupper($offSigner->{"SEAMAN'S BOOKn"}) : '-----' }}</td>
			<td rowspan="2"></td>
		</tr>

		<tr>
			<td></td>
			<td>{{ $offSigner->{'PASSPORT'} ? $offSigner->{'PASSPORT'}->format('d-M-y') : '----' }}</td>
			<td>{{ $offSigner->{"SEAMAN'S BOOK"} ? $offSigner->{"SEAMAN'S BOOK"}->format('d-M-y') : '-----' }}</td>
		</tr>
	@endforeach

	<tr>
		<td></td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td style="color: #0070C0; font-weight: bold;">FLIGHT SCHEDULE:</td>
		<td style="color: #0070C0; font-weight: bold;">TO FOLLOW</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td style="height: 45px;"></td>
		<td colspan="6"></td>
	</tr>
</table>