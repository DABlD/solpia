@php
	$center = "text-align: center;";
	$middle = "vertical-align: middle;";
	$bottom = "vertical-align: bottom;";
	$bold = "font-weight: bold;";
	$und = "text-decoration: underline;";
	$blue = "color: #0000FF;";
	$bb = "border-bottom: 1px solid #000000;";

	$dept = function($dept, $staff, $position, $medical, $type = null) use($bold, $middle, $center, $blue, $bb){
		if($type){
			echo "
				<tr>
					<td style='$bold' colspan='2'>$dept</td>
					<td style='$bb'></td>
					<td colspan='4' rowspan='2' style='$middle $center $blue'></td>
				</tr>

				<tr>
					<td colspan='2' style='$bold'>$medical</td>
					<td>$staff</td>
				</tr>

				<tr>
					<td colspan='3'></td>
					<td colspan='4'></td>
				</tr>
			";
		}
		else{
			echo "
				<tr>
					<td style='$bold' colspan='2'>$dept</td>
					<td style='$bb'></td>
					<td colspan='4' rowspan='3' style='$middle $center $blue'></td>
				</tr>

				<tr>
					<td colspan='2' style='$bold'>$medical</td>
					<td>$staff</td>
				</tr>

				<tr>
					<td colspan='2'></td>
					<td>$position</td>
				</tr>

				<tr>
					<td colspan='3'></td>
					<td colspan='4'></td>
				</tr>
			";
		}
	};
@endphp

<table>
	<tr>
		<td rowspan="61"></td>
		<td colspan="8" style="height: 50px;"></td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $center }} {{ $bold }} font-size: 16px;">
			DOCUMENT CLEARANCE FORM
		</td>
	</tr>

	<tr>
		<td colspan="6"></td>
		<td style="text-align: right; {{ $bottom }}">Date:</td>
		<td style="{{ $center }} {{ $bottom }}">
			{{ now()->format('l, F d, Y') }}
		</td>
	</tr>

	<tr>
		<td style="{{ $bold }}">Crew Name:</td>
		<td colspan="3" style="{{ $bottom }}">
			{{ $data->rank }} {{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td></td>
		<td colspan="2" style="{{ $bold }}">Latest Vessel:</td>
		<td style="{{ $center }} {{ $bottom }}">
			@php
		        $ss = false;
		        foreach($data->sea_service as $ss){
					if(str_contains($ss->manning_agent, 'SOLPIA')){
						$ss = $ss;
					}
		        }
			@endphp

			@if($ss)
				{{ $ss->vessel_name }}
			@else
				NEW HIRE
			@endif
		</td>
	</tr>

	<tr>
		<td colspan="7"></td>
		<td style="{{ $bold }} {{ $bottom }}">COMMENTS</td>
	</tr>

	<tr>
		<td colspan="3"></td>
		<td rowspan="50"></td>
		<td colspan="4" style="font-size: 8px; font-style: italic;">
		    Include options offered &#38; measures take to convince crew to stay.
		 </td>
	</tr>

	{{ $dept("FLEET A", "Ms. Precian Cervantes", "Asst Crewing Manager", "(+ Medical)") }}
	{{ $dept("FLEET B", "Mr. Adulf Kit Jumawan", "Crewing Manager", "(+ Medical)") }}
	{{ $dept("FLEET C", "Ms. Jeannette Solidum", "Crewing Manager", "(+ Medical)") }}
	{{ $dept("FLEET D", "Ms. Thea Guerra", "Crewing Manager", "(+ Medical)") }}
	{{ $dept("FLEET E", "Mr. Dennis Quiño", "Asst Crewing Manager", "(+ Medical)") }}
	{{ $dept("TOEI DIVISION", "Mr. Neil Romano", "Crewing Manager", "(+ Medical)") }}
	{{ $dept("TOEI DIVISION", "Ms. Lhea Marquez", "Asst Crewing Manager", "(+ Medical)") }}
	{{ $dept("FISHING FLEET", "Mr. Ricardo Amparo", "Asst Crewing Manager", "(+ Medical)") }}
	{{ $dept("PRINCIPAL / REP", "YH Kim or Mr. Ko", "", "", 1) }}
	{{ $dept("Contract / Visa", "Liaison/Documentation Officer", "", "Flag Documents", 1) }}
	{{ $dept("Claims / Legal", "Admin Manager", "", "", 1) }}
	{{ $dept("Accounting", "Ms. Lhen Ecleo", "Accounting Manager", "") }}

	<tr>
		<td style="{{ $bold }}">Noted by:</td>
		<td colspan="2"></td>
		<td colspan="4" style="{{ $bold }}">Acknowledged by:</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td style="{{ $bb }}"></td>
		<td></td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td>C/E Romano Mariano</td>
		<td></td>
		<td colspan="3" style="{{ $center }}">CEO</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td>President / Gen Mgr</td>
		<td></td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td style="{{ $bold }}">Remarks:</td>
		<td colspan="2"></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td style="height: 67px;" colspan="8"></td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="4" style="{{ $center }} {{ $bottom }} height: 20px;">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }} / {{ now()->toFormattedDateString() }}
		</td>
	</tr>

	<tr>
		<td colspan="4" style="font-size: 9px; color: #D9D9D9;">
			0945-871-4080 / 0998-169-8151
		</td>
		<td style="{{ $center }}" colspan="4">Crew Signature over printer name/Date</td>
	</tr>

</table>