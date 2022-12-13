@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	$und = "text-decoration: underline;";
	$blue = "color: #0000FF;";
	$red = "color: #FF0000;";

	$checkDate = function($date){
		return $date ? now()->parse($date)->format('d-M-y') : '---';
	};
@endphp

<table>
	<tr>
		<td colspan="13" style="{{ $center }} {{ $bold }} height: 50px;">
			CREW HANDLING AGENT INFORMATION
		</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $center }}">Date</td>
		<td></td>
		<td colspan="5" style="{{ $bold }} {{ $red }}">
			{{ now()->format('d-M-Y') }}
		</td>
		<td colspan="5" style="{{ $center }} {{ $bold }}">F A X N O.</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $center }}">From</td>
		<td></td>
		<td colspan="5">
			SOLPIA MARINE &#38; SHIP MANAGEMENT INC.
		</td>
		<td colspan="5" style="{{ $center }} {{ $bold }}"></td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $center }}">TO</td>
		<td></td>
		<td colspan="5" style="{{ $bold }} {{ $red }}">
			{{ $data['to'] }}
		</td>
		<td colspan="5" style="{{ $center }} {{ $bold }}">T E L. N O.</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $center }}">CC</td>
		<td></td>
		<td colspan="5">
			TOEI JAPAN LTD.
		</td>
		<td colspan="5" style="{{ $center }} {{ $bold }}">
			632-8-2961908
		</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $center }}">CC</td>
		<td></td>
		<td colspan="5">
			SOLPIA MARINE &#38; SHIP MANAGEMENT INC.
		</td>
		<td colspan="5" style="{{ $center }} {{ $bold }}">
			E-MAIL Address
		</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $center }}">CC</td>
		<td></td>
		<td colspan="5">
			{{ $vessel->name }}
		</td>
		<td colspan="5" style="{{ $center }} {{ $und }} {{ $blue }} font-size: 8px;">
			toei@solpiamarine.com / toeisolpia@gmail.com
		</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $center }}">CC</td>
		<td></td>
		<td colspan="5">
		</td>
		<td colspan="5" rowspan="2" style="vertical-align: bottom;">‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎REF NO.</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $center }}">RE</td>
		<td></td>
		<td colspan="5" style="{{ $red }} {{ $bold }}">
			{{ $vessel->name }}/CREW CHANGE - {{ $data['port'] }}
		</td>
	</tr>

	<tr>
		<td colspan="13" style="{{ $center }} {{ $bold }} height: 30px; vertical-align: middle;">
			AS PER INSTRUCTION FROM OUR PRINCIPAL
		</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $bold }} {{ $center }} height: 40px;">EMBARKING CREW</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">RANK</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">DATE OF BIRTH</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">BIRTHPLACE</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">PASSPORT NO.</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">ISSUE</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">EXPIRY</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">SEAMAN BOOKLET</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">ISSUE</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">EXPIRY</td>
	</tr>

	@php
		$ctr = 1;
	@endphp
	@foreach($linedUps as $key => $crew)
		<tr>
			<td style="{{ $center }}">{{ $ctr }}</td>
			<td colspan="3" style="{{ $center }}">
				{{ $crew->lname }}, {{ $crew->fname }} {{ $crew->suffix }} {{ $crew->mname }}
			</td>
			<td style="{{ $center }}">{{ $crew->abbr }}</td>
			<td style="{{ $center }}">{{ $checkDate($crew->birthday) }}</td>
			<td style="{{ $center }}">{{ $crew->birth_place }}</td>
			<td style="{{ $center }}">{{ isset($crew->PASSPORT) ? $crew->PASSPORTn : "---" }}</td>
			<td style="{{ $center }}">{{ isset($crew->PASSPORT) ? $checkDate($crew->PASSPORTi) : "---" }}</td>
			<td style="{{ $center }}">{{ isset($crew->PASSPORT) ? $crew->PASSPORT->format("d-M-y") : "---" }}</td>
			<td style="{{ $center }}">{{ isset($crew->{"SEAMAN'S BOOK"}) ? $crew->{"SEAMAN'S BOOKn"} : "---" }}</td>
			<td style="{{ $center }}">{{ isset($crew->{"SEAMAN'S BOOK"}) ? $checkDate($crew->{"SEAMAN'S BOOKi"}) : "---" }}</td>
			<td style="{{ $center }}">{{ isset($crew->{"SEAMAN'S BOOK"}) ? $checkDate($crew->{"SEAMAN'S BOOK"}) : "---" }}</td>
		</tr>
		@php
			$ctr++;
		@endphp
	@endforeach

	<tr>
		<td colspan="13" style="{{ $bold }} height: 30px; vertical-align: top;">PROMOTION:</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $bold }} {{ $center }} height: 40px;">DISEMBARKING CREW</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">RANK</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">DATE OF BIRTH</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">BIRTHPLACE</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">PASSPORT NO.</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">ISSUE</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">EXPIRY</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">SEAMAN BOOKLET</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">ISSUE</td>
		<td style="{{ $bold }} {{ $center }} height: 40px;">EXPIRY</td>
	</tr>

	@php
		$ctr = 1;
	@endphp
	@foreach($onBoards as $key => $crew)
		<tr>
			<td style="{{ $center }}">{{ $ctr }}</td>
			<td colspan="3" style="{{ $center }}">
				{{ $crew->lname }}, {{ $crew->fname }} {{ $crew->suffix }} {{ $crew->mname }}
			</td>
			<td style="{{ $center }}">{{ $crew->abbr }}</td>
			<td style="{{ $center }}">{{ $checkDate($crew->birthday) }}</td>
			<td style="{{ $center }}">{{ $crew->birth_place }}</td>
			<td style="{{ $center }}">{{ isset($crew->PASSPORT) ? $crew->PASSPORTn : "---" }}</td>
			<td style="{{ $center }}">{{ isset($crew->PASSPORT) ? $checkDate($crew->PASSPORTi) : "---" }}</td>
			<td style="{{ $center }}">{{ isset($crew->PASSPORT) ? $crew->PASSPORT->format("d-M-y") : "---" }}</td>
			<td style="{{ $center }}">{{ isset($crew->{"SEAMAN'S BOOK"}) ? $crew->{"SEAMAN'S BOOKn"} : "---" }}</td>
			<td style="{{ $center }}">{{ isset($crew->{"SEAMAN'S BOOK"}) ? $checkDate($crew->{"SEAMAN'S BOOKi"}) : "---" }}</td>
			<td style="{{ $center }}">{{ isset($crew->{"SEAMAN'S BOOK"}) ? $checkDate($crew->{"SEAMAN'S BOOK"}) : "---" }}</td>
		</tr>
		@php
			$ctr++;
		@endphp
	@endforeach

	<tr>
		<td colspan="13" style="height: 30px;"></td>
	</tr>

	<tr>
		<td colspan="3" style="height: 30px;"></td>
		<td colspan="10" style="{{ $und }} {{ $bold }}height: 30px;">EMBARKING CREW</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2" style="{{ $center }} {{ $bold }}">Flight</td>
		<td style="{{ $center }} {{ $bold }}">Route</td>
		<td style="{{ $center }} {{ $bold }}">Date</td>
		<td style="{{ $center }} {{ $bold }}">ETD</td>
		<td style="{{ $center }} {{ $bold }}">ETA</td>
		<td style="{{ $center }} {{ $bold }}">Record</td>
		<td style="{{ $center }} {{ $bold }}">Status</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2" style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2" style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="8" style="{{ $center }} {{ $bold }}"></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="3" style="height: 30px;"></td>
		<td colspan="10" style="{{ $und }} {{ $bold }}height: 50px;">DISEMBARKING CREW</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2" style="{{ $center }} {{ $bold }}">Flight</td>
		<td style="{{ $center }} {{ $bold }}">Route</td>
		<td style="{{ $center }} {{ $bold }}">Date</td>
		<td style="{{ $center }} {{ $bold }}">ETD</td>
		<td style="{{ $center }} {{ $bold }}">ETA</td>
		<td style="{{ $center }} {{ $bold }}">Record</td>
		<td style="{{ $center }} {{ $bold }}">Status</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2" style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2" style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td style="{{ $center }} {{ $bold }}"></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="8" style="{{ $center }} {{ $bold }}"></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="13" style="height: 30px;"></td>
	</tr>

	<tr>
		<td></td>
		<td style="{{ $bold }}">BRGDS</td>
	</tr>
</table>