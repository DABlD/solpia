@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	$bc = "$bold $center";
	$blue = "color: #0000FF;";
@endphp

<table>
	<tr>
		<td colspan="2" style="{{ $bold }}">{{ $vessel->name }}</td>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td colspan="15" style="{{ $bc }} height: 25px; font-size: 11px;">LIST OF CREW REPLACEMENT</td>
	</tr>

	<tr><td colspan="15"></td></tr>
	<tr>
		<td colspan="11"></td>
		<td colspan="2" style="{{ $bold }} text-align: right;">DATE OF CREW REPLACEMENT:</td>
		<td style="{{ $blue }}">{{ $data['date'] ? now()->parse($data['date'])->format('d/M/Y') : "---" }}</td>
		<td></td>
	</tr>
	<tr>
		<td colspan="12"></td>
		<td style="{{ $bold }} text-align: right;">PORT:</td>
		<td style="{{ $blue }}">{{ $data['port'] }}</td>
		<td></td>
	</tr>
	<tr><td colspan="15"></td></tr>

	<tr>
		<td colspan="2" style="{{ $bold }}">ON-SIGNERS</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $bc }}">No</td>
		<td rowspan="2" style="{{ $bc }}">
			Name
			<br style='mso-data-placement:same-cell;' />
			((Last-First-Middle))
		</td>
		<td rowspan="2" style="{{ $bc }}">Rank</td>
		<td rowspan="2" style="{{ $bc }}">Nationality</td>
		<td rowspan="2" style="{{ $bc }}">Date of Birth</td>
		<td colspan="3" style="{{ $bc }}">Passport</td>
		<td colspan="3" style="{{ $bc }}">Seaman Book</td>
		<td rowspan="2" style="{{ $bc }}">COVID 19 VACCINE</td>
		<td rowspan="2" style="{{ $bc }}">Contract No.</td>
		<td rowspan="2" style="{{ $bc }}">Add</td>
		<td rowspan="2" style="{{ $bc }}">Remark</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">No.</td>
		<td style="{{ $bc }}">Issue Date</td>
		<td style="{{ $bc }}">Exp. Date</td>
		<td style="{{ $bc }}">No.</td>
		<td style="{{ $bc }}">Issue Date</td>
		<td style="{{ $bc }}">Exp. Date</td>
	</tr>

	@php
		$ctr = 1;
	@endphp
	@foreach($linedUps as $key => $onSigner)
		<tr>
			<td style="{{ $center }}">{{ $ctr }}</td>
			<td style="{{ $center }}">{{ $onSigner->lname }} {{ $onSigner->fname }} {{ $onSigner->suffix }} {{ $onSigner->mname }}</td>
			<td style="{{ $center }}">{{ $onSigner->abbr }}</td>
			<td style="{{ $center }}">FILIPINO</td>
			<td style="{{ $center }}">{{ $onSigner->birthday ? now()->parse($onSigner->birthday)->format("d/m/Y") : "-----" }}</td>
			<td style="{{ $center }}">{{ $onSigner->{'PASSPORTn'} ? strtoupper($onSigner->{'PASSPORTn'}) : '-----' }}</td>
			<td style="{{ $center }}">{{ $onSigner->{'PASSPORTi'} ? now()->parse($onSigner->{'PASSPORTi'})->format('d/m/Y') : '-----' }}</td>
			<td style="{{ $center }}">{{ $onSigner->{'PASSPORT'} ? now()->parse($onSigner->{'PASSPORT'})->format('d/m/Y') : '-----' }}</td>
			<td style="{{ $center }}">{{ $onSigner->{"SEAMAN'S BOOKn"} ? strtoupper($onSigner->{"SEAMAN'S BOOKn"}) : '-----' }}</td>
			<td style="{{ $center }}">{{ $onSigner->{"SEAMAN'S BOOKi"} ? now()->parse($onSigner->{"SEAMAN'S BOOKi"})->format('d/m/Y') : '-----' }}</td>
			<td style="{{ $center }}">{{ $onSigner->{"SEAMAN'S BOOK"} ? now()->parse($onSigner->{"SEAMAN'S BOOK"})->format('d/m/Y') : '-----' }}</td>
			<td style="{{ $center }}">{{ $onSigner->covidVaccines->count() ? "FULLY VACCINATED" : "---" }}</td>
			<td style="{{ $center }}"></td>
			<td style="{{ $center }}"></td>
			<td style="{{ $center }}"></td>
		</tr>
		@php
			$ctr++;
		@endphp
	@endforeach

	<tr><td colspan="15"></td></tr>
	<tr><td colspan="15" style="height: 50px;"></td></tr>

	<tr>
		<td colspan="2" style="{{ $bold }}">OFF-SIGNERS</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $bc }}">No</td>
		<td rowspan="2" style="{{ $bc }}">
			Name
			<br style='mso-data-placement:same-cell;' />
			((Last-First-Middle))
		</td>
		<td rowspan="2" style="{{ $bc }}">Rank</td>
		<td rowspan="2" style="{{ $bc }}">Nationality</td>
		<td rowspan="2" style="{{ $bc }}">Date of Birth</td>
		<td colspan="3" style="{{ $bc }}">Passport</td>
		<td colspan="3" style="{{ $bc }}">Seaman Book</td>
		<td rowspan="2" style="{{ $bc }}">COVID 19 VACCINE</td>
		<td rowspan="2" style="{{ $bc }}">Contract No.</td>
		<td rowspan="2" style="{{ $bc }}">Add</td>
		<td rowspan="2" style="{{ $bc }}">Remark</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">No.</td>
		<td style="{{ $bc }}">Issue Date</td>
		<td style="{{ $bc }}">Exp. Date</td>
		<td style="{{ $bc }}">No.</td>
		<td style="{{ $bc }}">Issue Date</td>
		<td style="{{ $bc }}">Exp. Date</td>
	</tr>

	@php
		$ctr = 1;

		$clean = function($text){
			$text = str_replace("Ñ", "N", $text);
			$text = str_replace("ñ", "n", $text);
			$text = preg_replace('/[^A-Za-z0-9\-]/', '', $text);

			return $text;
		};
	@endphp
	@foreach($onBoards as $key => $onBoard)
		<tr>
			<td style="{{ $center }}">{{ $ctr }}</td>
			<td style="{{ $center }}">
				{{ $clean($onBoard->lname) }} {{ $clean($onBoard->fname) }} {{ $clean($onBoard->suffix) }} {{ $clean($onBoard->mname) }}
			</td>
			<td style="{{ $center }}">{{ $onBoard->abbr }}</td>
			<td style="{{ $center }}">FILIPINO</td>
			<td style="{{ $center }}">{{ $onBoard->birthday ? now()->parse($onBoard->birthday)->format("d/m/Y") : "-----" }}</td>
			<td style="{{ $center }}">{{ $onBoard->{'PASSPORTn'} ? strtoupper($onBoard->{'PASSPORTn'}) : '-----' }}</td>
			<td style="{{ $center }}">{{ $onBoard->{'PASSPORTi'} ? now()->parse($onBoard->{'PASSPORTi'})->format('d/m/Y') : '-----' }}</td>
			<td style="{{ $center }}">{{ $onBoard->{'PASSPORT'} ? now()->parse($onBoard->{'PASSPORT'})->format('d/m/Y') : '-----' }}</td>
			<td style="{{ $center }}">{{ $onBoard->{"SEAMAN'S BOOKn"} ? strtoupper($onBoard->{"SEAMAN'S BOOKn"}) : '-----' }}</td>
			<td style="{{ $center }}">{{ $onBoard->{"SEAMAN'S BOOKi"} ? now()->parse($onBoard->{"SEAMAN'S BOOKi"})->format('d/m/Y') : '-----' }}</td>
			<td style="{{ $center }}">{{ $onBoard->{"SEAMAN'S BOOK"} ? now()->parse($onBoard->{"SEAMAN'S BOOK"})->format('d/m/Y') : '-----' }}</td>
			<td style="{{ $center }}">{{ $onBoard->covidVaccines->count() ? "FULLY VACCINATED" : "---" }}</td>
			<td style="{{ $center }}"></td>
			<td style="{{ $center }}"></td>
			<td style="{{ $center }}"></td>
		</tr>
		@php
			$ctr++;
		@endphp
	@endforeach

	<tr><td colspan="15"></td></tr>
</table>