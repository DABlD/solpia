<table>
	<tr>
		<td colspan="4">
			On-Signers ({{ sizeof($linedUps) }} Ph. Crew)
		</td>
	</tr>

	<tr>
		<td>NO.</td>
		<td>RANK</td>
		<td>NAME</td>
		<td>DOB</td>
		<td>Passport No.</td>
		<td>S. Book No.</td>
		<td>Last Ship</td>
	</tr>

	@php
		$ctr = 1;
	@endphp
	@foreach($linedUps as $key => $onSigner)
		<tr>
			<td>{{ $ctr }}</td>
			<td>{{ $onSigner->abbr }}</td>
			<td>{{ $onSigner->lname . ', ' . $onSigner->fname . ' ' . $onSigner->suffix . ' ' . $onSigner->mname }}</td>
			<td>{{ now()->parse($onSigner->birthday)->format('d-M-Y') }}</td>
			<td>{{ $onSigner->{'PASSPORTn'} ? strtoupper($onSigner->{'PASSPORTn'}) : '-----' }}</td>
			<td>{{ $onSigner->{"SEAMAN'S BOOKn"} ? strtoupper($onSigner->{"SEAMAN'S BOOKn"}) : '-----' }}</td>
			<td>{{ $onSigner->lastShip }}</td>
		</tr>
		@php
			$ctr++;
		@endphp
	@endforeach

	<tr></tr>

	{{-- OFFSIGNERS --}}
	<tr>
		<td colspan="4">
			Off-Signers ({{ sizeof($onBoards) }} Ph. Crew)
		</td>
	</tr>

	<tr>
		<td>NO.</td>
		<td>RANK</td>
		<td>NAME</td>
		<td>DOB</td>
		<td>Passport No.</td>
		<td>S. Book No.</td>
		<td>Remarks</td>
	</tr>

	@php
		$ctr = 1;
	@endphp
	@foreach($onBoards as $key => $onBoard)
		<tr>
			<td>{{ $ctr }}</td>
			<td>{{ $onBoard->abbr }}</td>
			<td>{{ $onBoard->lname . ', ' . $onBoard->fname . ' ' . $onBoard->suffix . ' ' . $onBoard->mname }}</td>
			<td>{{ now()->parse($onBoard->birthday)->format('d-M-Y') }}</td>
			<td>{{ $onBoard->{'PASSPORTn'} ? strtoupper($onBoard->{'PASSPORTn'}) : '-----' }}</td>
			<td>{{ $onBoard->{"SEAMAN'S BOOKn"} ? strtoupper($onBoard->{"SEAMAN'S BOOKn"}) : '-----' }}</td>
			<td></td>
		</tr>
		@php
			$ctr++;
		@endphp
	@endforeach
</table>