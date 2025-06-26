@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";

	$principal = null;
	$vessel = null;
	$eld = null;

	foreach($data as $crew){
		if(!$principal && isset($crew->pro_app->principal)){
			$principal = $crew->pro_app->principal->name;
		}
		if(!$vessel && isset($crew->pro_app->vessel)){
			$vessel = $crew->pro_app->vessel->name;
		}
		if(!$eld && isset($crew->pro_app->eld)){
			$eld = $crew->pro_app->eld;
		}
	}
@endphp

<table>
	<tr>
		<td colspan="10" style="height: 50px;">
			{{-- LETTERHEAD --}}
		</td>
	</tr>

	<tr>
		<td colspan="10" style="{{ $bc }} text-decoration: underline; height: 45px; font-size: 20px">CREW UNIFORM ORDER SLIP</td>
	</tr>

	<tr>
		<td colspan="3">DATE SUBMITTED:</td>
		<td colspan="2" style="{{ $c }}">{{ now()->toDateString() }}</td>
		<td colspan="2"></td>
		<td>P.O. NO.:</td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">SUBMITTED BY:</td>
		<td colspan="2" style="{{ $c }}">
			@if(auth()->user()->gender == "Male")
				MR. {{ auth()->user()->fname }} {{ auth()->user()->lname }}
			@else
				MS. {{ auth()->user()->fname }} {{ auth()->user()->lname }}
			@endif
		</td>
		<td colspan="2"></td>
		<td></td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">FLEET ASSIGNED:</td>
		<td colspan="2" style="{{ $c }}">{{ auth()->user()->fleet }}</td>
		<td colspan="2"></td>
		<td></td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">PRINCIPAL:</td>
		<td colspan="2" style="{{ $c }}">{{ $principal }}</td>
		<td colspan="2"></td>
		<td></td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">VESSEL:</td>
		<td colspan="2" style="{{ $c }}">{{ $vessel }}</td>
		<td colspan="2"></td>
		<td>ETD:</td>
		<td style="{{ $c }}">{{ $eld ? $eld->format('d-M-Y') : "-" }}</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td style="{{ $bc }}">NO.</td>
		<td style="{{ $bc }}">RANK</td>
		<td colspan="4" style="{{ $bc }}">
			CREW NAME
			<br style='mso-data-placement:same-cell;' />
			(Last Name, F. MI)
		</td>
		<td colspan="2" style="{{ $bc }}">
			SIZES
			<br style='mso-data-placement:same-cell;' />
			(Including waistline)
			<br style='mso-data-placement:same-cell;' />
			(ex. M/30)
		</td>
		<td colspan="2" style="{{ $bc }}">
			SHOE SIZE
			<br style='mso-data-placement:same-cell;' />
			(IN UK - NO
			<br style='mso-data-placement:same-cell;' />
			HALF SIZE)
		</td>
	</tr>

	@for($i = 0; $i < (sizeof($data) >= 7 ? sizeof($data) : 7); $i++)
		@if(isset($data[$i]))
			@php
				$ss = $data[$i]->shoe_size;

				if($data[$i]->user->fleet == "FLEET D" && $ss > 100){
					if($ss == 225) {$ss = 2;}
					elseif($ss == 230) {$ss = 3;}
					elseif($ss == 235) {$ss = 4;}
					elseif($ss == 240) {$ss = 5;}
					elseif($ss == 245) {$ss = 5.5;}
					elseif($ss == 250) {$ss = 6;}
					elseif($ss == 255) {$ss = 7;}
					elseif($ss == 260) {$ss = 8;}
					elseif($ss == 265) {$ss = 9;}
					elseif($ss == 270) {$ss = 10;}
					elseif($ss == 275) {$ss = 10.5;}
					elseif($ss == 280) {$ss = 11;}
					elseif($ss == 285) {$ss = 12;}
					elseif($ss == 290) {$ss = 13;}
				}
			@endphp

			<tr>
				<td style="{{ $c }}">{{ $i+1 }}</td>
				<td style="{{ $c }}">{{ $data[$i]->pro_app->rank->abbr }}</td>
				<td colspan="4" style="{{ $c }}">{{ $data[$i]->user->namefull }}</td>
				<td colspan="2" style="{{ $c }}">{{ $data[$i]->clothes_size }}/{{ $data[$i]->waistline }}</td>
				<td colspan="2" style="{{ $c }}">{{ $ss }}</td>
			</tr>
		@else
			<tr>
				<td style="{{ $c }}"></td>
				<td style="{{ $c }}"></td>
				<td colspan="4" style="{{ $c }}"></td>
				<td colspan="2" style="{{ $c }}"></td>
				<td colspan="2" style="{{ $c }}"></td>
			</tr>
		@endif
	@endfor

	<tr>
		<td colspan="10" style="height: 5px;"></td>
	</tr>

	<tr>
		<td colspan="2">Received by:</td>
		<td colspan="2" style="{{ $c }}"></td>
		<td style="{{ $c }}">Dated: </td>
		<td colspan="3" style="{{ $c }}">{{ now()->format('F j, Y') }}</td>
	</tr>

	<tr>
		<td colspan="4" style="text-align: left; font-size: 9px; font-style: italic; height: 40px;">DOC NO: SMAC-PUR-01</td>
		<td colspan="3" style="text-align: center; font-size: 9px; font-style: italic; height: 40px;">EFFECTIVE DATE: 12 FEB 2024</td>
		<td colspan="3" style="text-align: right; font-size: 9px; font-style: italic; height: 40px;">REV NO: 2.0 Feb. 12, 2024</td>
	</tr>

	{{-- PAGE2 --}}
	/////////////////////////////////////////////////////////////////////////////////

	<tr>
		<td colspan="10" style="height: 60px;">
			{{-- LETTERHEAD --}}
		</td>
	</tr>

	<tr>
		<td colspan="10" style="{{ $bc }} text-decoration: underline; height: 45px; font-size: 20px">CREW UNIFORM ORDER SLIP</td>
	</tr>

	<tr>
		<td colspan="3">DATE SUBMITTED:</td>
		<td colspan="2" style="{{ $c }}">{{ now()->toDateString() }}</td>
		<td colspan="2"></td>
		<td>P.O. NO.:</td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">SUBMITTED BY:</td>
		<td colspan="2" style="{{ $c }}">
			@if(auth()->user()->gender == "Male")
				MR. {{ auth()->user()->fname }} {{ auth()->user()->lname }}
			@else
				MS. {{ auth()->user()->fname }} {{ auth()->user()->lname }}
			@endif
		</td>
		<td colspan="2"></td>
		<td></td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">FLEET ASSIGNED:</td>
		<td colspan="2" style="{{ $c }}">{{ auth()->user()->fleet }}</td>
		<td colspan="2"></td>
		<td></td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">PRINCIPAL:</td>
		<td colspan="2" style="{{ $c }}">{{ $principal }}</td>
		<td colspan="2"></td>
		<td></td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">VESSEL:</td>
		<td colspan="2" style="{{ $c }}">{{ $vessel }}</td>
		<td colspan="2"></td>
		<td>ETD:</td>
		<td style="{{ $c }}">{{ $eld ? $eld->format('d-M-Y') : "-" }}</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td style="{{ $bc }}">NO.</td>
		<td style="{{ $bc }}">RANK</td>
		<td colspan="4" style="{{ $bc }}">
			CREW NAME
			<br style='mso-data-placement:same-cell;' />
			(Last Name, F. MI)
		</td>
		<td colspan="2" style="{{ $bc }}">
			SIZES
			<br style='mso-data-placement:same-cell;' />
			(Including waistline)
			<br style='mso-data-placement:same-cell;' />
			(ex. M/30)
		</td>
		<td colspan="2" style="{{ $bc }}">
			SHOE SIZE
			<br style='mso-data-placement:same-cell;' />
			(IN UK - NO
			<br style='mso-data-placement:same-cell;' />
			HALF SIZE)
		</td>
	</tr>

	@for($i = 0; $i < (sizeof($data) >= 7 ? sizeof($data) : 7); $i++)
		@if(isset($data[$i]))
			@php
				$ss = $data[$i]->shoe_size;

				if($data[$i]->user->fleet == "FLEET D" && $ss > 100){
					if($ss == 225) {$ss = 2;}
					elseif($ss == 230) {$ss = 3;}
					elseif($ss == 235) {$ss = 4;}
					elseif($ss == 240) {$ss = 5;}
					elseif($ss == 245) {$ss = 5.5;}
					elseif($ss == 250) {$ss = 6;}
					elseif($ss == 255) {$ss = 7;}
					elseif($ss == 260) {$ss = 8;}
					elseif($ss == 265) {$ss = 9;}
					elseif($ss == 270) {$ss = 10;}
					elseif($ss == 275) {$ss = 10.5;}
					elseif($ss == 280) {$ss = 11;}
					elseif($ss == 285) {$ss = 12;}
					elseif($ss == 290) {$ss = 13;}
				}
			@endphp

			<tr>
				<td style="{{ $c }}">{{ $i+1 }}</td>
				<td style="{{ $c }}">{{ $data[$i]->pro_app->rank->abbr }}</td>
				<td colspan="4" style="{{ $c }}">{{ $data[$i]->user->namefull }}</td>
				<td colspan="2" style="{{ $c }}">{{ $data[$i]->clothes_size }}/{{ $data[$i]->waistline }}</td>
				<td colspan="2" style="{{ $c }}">{{ $ss }}</td>
			</tr>
		@else
			<tr>
				<td style="{{ $c }}"></td>
				<td style="{{ $c }}"></td>
				<td colspan="4" style="{{ $c }}"></td>
				<td colspan="2" style="{{ $c }}"></td>
				<td colspan="2" style="{{ $c }}"></td>
			</tr>
		@endif
	@endfor

	<tr>
		<td colspan="10" style="height: 5px;"></td>
	</tr>

	<tr>
		<td colspan="2">Received by:</td>
		<td colspan="2" style="{{ $c }}"></td>
		<td style="{{ $c }}">Dated: </td>
		<td colspan="3" style="{{ $c }}">{{ now()->format('F j, Y') }}</td>
	</tr>

	<tr>
		<td colspan="4" style="text-align: left; font-size: 9px; font-style: italic; height: 40px;">DOC NO: SMAC-PUR-01</td>
		<td colspan="3" style="text-align: center; font-size: 9px; font-style: italic; height: 40px;">EFFECTIVE DATE: 12 FEB 2024</td>
		<td colspan="3" style="text-align: right; font-size: 9px; font-style: italic; height: 40px;">REV NO: 2.0 Feb. 12, 2024</td>
	</tr>
</table>