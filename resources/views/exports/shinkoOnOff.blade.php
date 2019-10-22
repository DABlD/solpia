<table>
	<tr>
		<td colspan="4">
			ON-SIGNERS ({{ sizeof($linedUps) }} CREW)
		</td>
	</tr>

	<tr>
		<td rowspan="2">NO.</td>
		<td rowspan="2">RANK</td>
		<td rowspan="2">NAME</td>
		<td colspan="4">CANDIDATES PARTICULAR</td>
	</tr>

	<tr>
		<td>DOB</td>
		<td>PASSPORT<br>EXPIRY DATE</td>
		<td>SBOOK<br>EXPIRY DATE</td>
		<td>US VISA<br>EXPIRY DATE</td>
		<td>REMARKS</td>
	</tr>

	@foreach($linedUps as $key => $onSigner)
		<tr>
			<td rowspan="2">{{ $key + 1 }}</td>
			<td rowspan="2">{{ $onSigner->abbr }}</td>
			<td rowspan="2">{{ $onSigner->lname . ', ' . $onSigner->fname . ' ' . $onSigner->suffix . ' ' . $onSigner->mname }}</td>
			<td rowspan="2">{{ now()->parse($onSigner->joining_date)->format('d-M-Y') }}</td>
			<td>{{ $onSigner->{'PASSPORTn'} ?? '-----' }}</td>
			<td>{{ $onSigner->{"SEAMAN'S BOOKn"} ?? '-----' }}</td>
			<td>{{ $onSigner->{'US-VISAn'} ?? '-----' }}</td>
			<td rowspan="2"></td>
		</tr>

		<tr>
			<td>{{ $onSigner->{'PASSPORT'} ? $onSigner->{'PASSPORT'}->format('d-M-Y') : '----' }}</td>
			<td>{{ $onSigner->{"SEAMAN'S BOOK"} ? $onSigner->{"SEAMAN'S BOOK"}->format('d-M-Y') : '-----' }}</td>
			<td>{{ $onSigner->{'US-VISA'} ? $onSigner->{'US-VISA'}->format('d-M-Y') : '-----'}}</td>
		</tr>
	@endforeach

	<tr></tr>

	{{-- OFFSIGNERS --}}
	<tr>
		<td colspan="4">
			ON-SIGNERS ({{ sizeof($onBoards) }} CREW)
		</td>
	</tr>

	<tr>
		<td rowspan="2">NO.</td>
		<td rowspan="2">RANK</td>
		<td rowspan="2">NAME</td>
		<td colspan="4">CANDIDATES PARTICULAR</td>
	</tr>

	<tr>
		<td>DOB</td>
		<td>PASSPORT<br>EXPIRY DATE</td>
		<td>SBOOK<br>EXPIRY DATE</td>
		<td>US VISA<br>EXPIRY DATE</td>
		<td>REMARKS</td>
	</tr>

	@foreach($onBoards as $key => $offSigner)
		<tr>
			<td rowspan="2">{{ $key + 1 }}</td>
			<td rowspan="2">{{ $offSigner->abbr }}</td>
			<td rowspan="2">{{ $offSigner->lname . ', ' . $offSigner->fname . ' ' . $offSigner->suffix . ' ' . $offSigner->mname }}</td>
			<td rowspan="2">{{ now()->parse($offSigner->joining_date)->format('d-M-Y') }}</td>
			<td>{{ $offSigner->{'PASSPORTn'} ?? '-----' }}</td>
			<td>{{ $offSigner->{"SEAMAN'S BOOKn"} ?? '-----' }}</td>
			<td>{{ $offSigner->{'US-VISAn'} ?? '-----' }}</td>
			<td rowspan="2"></td>
		</tr>

		<tr>
			<td>{{ $offSigner->{'PASSPORT'} ? $offSigner->{'PASSPORT'}->format('d-M-Y') : '----' }}</td>
			<td>{{ $offSigner->{"SEAMAN'S BOOK"} ? $offSigner->{"SEAMAN'S BOOK"}->format('d-M-Y') : '-----' }}</td>
			<td>{{ $offSigner->{'US-VISA'} ? $offSigner->{'US-VISA'}->format('d-M-Y') : '-----'}}</td>
		</tr>
	@endforeach
</table>