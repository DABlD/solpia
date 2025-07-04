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
		<td rowspan="79"></td>
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

	@php
        $ss = false;
        foreach($data->sea_service as $ss){
			if(str_contains($ss->manning_agent, 'SOLPIA')){
				$ss = $ss;
				break;
			}
        }
	@endphp

	<tr>
		<td style="{{ $bold }}">Crew Name:</td>
		<td colspan="3" style="{{ $bottom }}">
			{{ $data->rank }} {{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td></td>
		<td colspan="2" style="{{ $bold }}">Latest Vessel:</td>
		<td style="{{ $center }} {{ $bottom }}">

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
		<td rowspan="66"></td>
		<td colspan="4" style="font-size: 8px; font-style: italic;">
		    Include options offered &#38; measures take to convince crew to stay.
		 </td>
	</tr>

	{{ $dept("FLEET B", "Mr. Adulf Kit Jumawan", "Crewing Manager", "(+ Medical Matters)") }}
	{{ $dept("FLEET C", "Ms. Shirley Erasquin", "Crewing Manager", "(+ Medical Matters)") }}
	{{ $dept("FLEET D", "Ms. Thea Mae G. Rio", "Crewing Manager", "(+ Medical Matters)") }}
	{{ $dept("TOEI DIVISION", "Mr. Neil Romano", "Crewing Manager", "(+ Medical Matters)") }}
	{{ $dept("TOEI DIVISION", "Ms. Lhea Marquez(Fleet A)", "Asst Crewing Manager", "(+ Medical Matters)") }}
	{{ $dept("TOEI DIVISION", "Ms. Laura Fernando (Fleet B)", "Asst Crewing Manager", "(+ Medical Matters)") }}
	{{ $dept("TOEI DIVISION", "Ms. Jeneva Bianca Santos(Fleet C)", "Asst Crewing Manager", "(+ Medical Matters)") }}
	{{ $dept("FISHING FLEET", "Mr. Ricardo Amparo", "Crewing Manager", "(+ Medical Matters)") }}
	{{ $dept("LIAISON OFFICER", "Mr. Randy Andaya", "", "(Contract)") }}
	{{ $dept("LIAISON OFFICER (TOEI)", "Mr. Philip Manapul", "", "(Contract)") }}	
	{{ $dept("DOCUMENTATION OFFICER / SMI", "Ms. Natasha Saguinsin /", "Ms. Merhla De Asis", "(Flag / Visa)") }}
	{{ $dept("DOCUMENTATION OFFICER / TOEI", "Ms. Yvonne Cruz", "", "", true) }}

	{{-- PAGE 2 SEPARATOR --}}
	<tr>
		<td colspan="3"></td>
		<td colspan="4"></td>
	</tr>
	
	{{-- PAGE 2 SEPARATOR --}}
	<tr>
		<td colspan="3"></td>
		<td colspan="4"></td>
	</tr>

	{{ $dept("ADMIN / CLAIMS", "Ms. Claudette Pasaylo", "Admin / Claims Officer", "(Claims / Legal)") }}
	{{ $dept("ACCOUNTING", "Ms. Robelyn Ecleo / Ms. Mylene Relano", "Admin / Accounting Manager", "") }}

	{{ $dept("PRINCIPAL'S REPRESENTIVE", "Mr. Gyeonghwan Gwak / Mr. Kyoung T. Ko", "", "") }}

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