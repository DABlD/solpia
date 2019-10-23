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

	@foreach($linedUps as $key => $onSigner)
		<tr>
			<td>{{ $key + 1 }}</td>
			<td>{{ $onSigner->abbr }}</td>
			<td>{{ $onSigner->lname . ', ' . $onSigner->fname . ' ' . $onSigner->suffix . ' ' . $onSigner->mname }}</td>
			<td>{{ now()->parse($onSigner->birthday)->format('d-M-Y') }}</td>
			<td>{{ $onSigner->{'PASSPORTn'} ?? '-----' }}</td>
			<td>{{ $onSigner->{"SEAMAN'S BOOKn"} ?? '-----' }}</td>
			<td>{{ $onSigner->lastShip }}</td>
		</tr>
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

	@foreach($onBoards as $key => $onBoard)
		<tr>
			<td>{{ $key + 1 }}</td>
			<td>{{ $onBoard->abbr }}</td>
			<td>{{ $onBoard->lname . ', ' . $onBoard->fname . ' ' . $onBoard->suffix . ' ' . $onBoard->mname }}</td>
			<td>{{ now()->parse($onBoard->birthday)->format('d-M-Y') }}</td>
			<td>{{ $onBoard->{'PASSPORTn'} ?? '-----' }}</td>
			<td>{{ $onBoard->{"SEAMAN'S BOOKn"} ?? '-----' }}</td>
			<td></td>
		</tr>
	@endforeach
</table>