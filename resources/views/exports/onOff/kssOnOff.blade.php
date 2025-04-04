@php
	// dd($data);
@endphp

<table>
	<tr>
		<td colspan="10">OFFICIAL ANNOUNCEMENT FOR CREW REPLACEMENT</td>
	</tr>

	<tr>
		<td colspan="2">Date:</td>
		<td colspan="3">{{ now()->format('d-M-Y') }}</td>
		<td colspan="2">Ship's Name:</td>
		<td colspan="3">{{ $vessel->name }}</td>
	</tr>

	<tr>
		<td colspan="2">Port of Crew Replacement:</td>
		<td colspan="3">{{ $data['port'] }}</td>
		<td colspan="2">Date of Crew Replacement:</td>
		<td colspan="3">{{ now()->parse($data['date'])->format('d-M-Y') }}</td>
	</tr>

	<tr>
		<td colspan="10">SIGN-ON CREW</td>
	</tr>

	<tr>
		<td>Rank</td>
		<td>Name</td>
		<td>Nationality</td>
		<td>
			D.O.B
			<br style='mso-data-placement:same-cell;' />
			( Resident
			<br style='mso-data-placement:same-cell;' />
			registration No.)
		</td>
		<td>
			Seaman Book No.
			<br style='mso-data-placement:same-cell;' />
			( Expiration Date )
		</td>
		<td>
			Passport No.
			<br style='mso-data-placement:same-cell;' />
			( Expiration Date )
		</td>
		<td>Residential District</td>
		<td>Smoking</td>
		<td>Employee ID No.</td>
		<td>ETC</td>
	</tr>

	@foreach($linedUps as $key => $onSigner)
		<tr>
			<td rowspan="2">{{ $onSigner->abbr }}</td>
			<td rowspan="2">{{ $onSigner->lname . ', ' . $onSigner->fname . ' ' . $onSigner->suffix . ' ' . $onSigner->mname }}</td>
			<td rowspan="2">FILIPINO</td>
			<td rowspan="2">{{ now()->parse($onSigner->birthday)->format('d-M-Y') }}</td>
			<td rowspan="2">
				{{ $onSigner->{"SEAMAN'S BOOKn"} ? strtoupper($onSigner->{"SEAMAN'S BOOKn"}) : '-' }}
				<br style='mso-data-placement:same-cell;' />
				{{ $onSigner->{"SEAMAN'S BOOK"} ? $onSigner->{"SEAMAN'S BOOK"}->format('d-M-Y') : '-' }}
			</td>
			<td rowspan="2">
				{{ $onSigner->{"PASSPORTn"} ? strtoupper($onSigner->{"PASSPORTn"}) : '-' }}
				<br style='mso-data-placement:same-cell;' />
				{{ $onSigner->{"PASSPORT"} ? $onSigner->{"PASSPORT"}->format('d-M-Y') : '-' }}
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	@endforeach

	<tr>
		<td colspan="10">SIGN-OFF CREW</td>
	</tr>

	<tr>
		<td>Rank</td>
		<td>Name</td>
		<td>Nationality</td>
		<td>
			D.O.B
			<br style='mso-data-placement:same-cell;' />
			( Resident
			<br style='mso-data-placement:same-cell;' />
			registration No.)
		</td>
		<td>
			Seaman Book No.
			<br style='mso-data-placement:same-cell;' />
			( Expiration Date )
		</td>
		<td>
			Passport No.
			<br style='mso-data-placement:same-cell;' />
			( Expiration Date )
		</td>
		<td colspan="4">ETC</td>
	</tr>

	@foreach($onBoards as $key => $offSigner)
		<tr>
			<td rowspan="2">{{ $offSigner->abbr }}</td>
			<td rowspan="2">{{ $offSigner->lname . ', ' . $offSigner->fname . ' ' . $offSigner->suffix . ' ' . $offSigner->mname }}</td>
			<td rowspan="2">FILIPINO</td>
			<td rowspan="2">{{ now()->parse($offSigner->birthday)->format('d-M-Y') }}</td>
			<td rowspan="2">
				{{ $offSigner->{"SEAMAN'S BOOKn"} ? strtoupper($offSigner->{"SEAMAN'S BOOKn"}) : '-' }}
				<br style='mso-data-placement:same-cell;' />
				{{ $offSigner->{"SEAMAN'S BOOK"} ? $offSigner->{"SEAMAN'S BOOK"}->format('d-M-Y') : '-' }}
			</td>
			<td rowspan="2">
				{{ $offSigner->{"PASSPORTn"} ? strtoupper($offSigner->{"PASSPORTn"}) : '-' }}
				<br style='mso-data-placement:same-cell;' />
				{{ $offSigner->{"PASSPORT"} ? $offSigner->{"PASSPORT"}->format('d-M-Y') : '-' }}
			</td>
			<td rowspan="2" colspan="4"></td>
		</tr>
	@endforeach

	<tr>
		<td colspan="10">FLIGHT SCHEDULE</td>
	</tr>

	<tr>
		<td>SIGN-ON</td>
		<td colspan="9">RVTG</td>
	</tr>

	<tr>
		<td>SIGN-OFF</td>
		<td colspan="9">RVTG</td>
	</tr>

	<tr>
		<td colspan="10">REMARK</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>
</table>