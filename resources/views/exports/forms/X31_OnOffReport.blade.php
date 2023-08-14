@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";

	$size = sizeof($data->on) > sizeof($data->off) ? sizeof($data->on) : sizeof($data->off);
@endphp

<table>
	<tr>
		<td colspan="11" style="height: 60px;"></td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $bc }}">LIST OF ON AND OFF SIGNER CREW PER VESSEL</td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $bc }}">FOR DMW-OWMS SYSTEM UPDATING</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td style="{{ $bc }}">VESSEL</td>
		<td style="{{ $bc }}">OEC NO.</td>
		<td style="{{ $bc }}">DATE</td>
		<td style="{{ $bc }}">RANK</td>
		<td style="{{ $bc }}" colspan="2">ON SIGNER CREW</td>
		<td></td>
		<td style="{{ $bc }}">DATE</td>
		<td style="{{ $bc }}">RANK</td>
		<td style="{{ $bc }}" colspan="2">OFF SIGNER CREW</td>
	</tr>

	@for($i = 0; $i < $size; $i++)
		<tr>
			@if(isset($data->on[$i]))
				<td style="{{ $c }}">{{ $data->on[$i]->vessel->name }}</td>
				<td style="{{ $c }}">{{ $data->on[$i]->OEC }}</td>
				<td style="{{ $c }}">{{ $data->on[$i]->joining_date->format('d-M-y') }}</td>
				<td style="{{ $c }}">{{ $data->on[$i]->rank->abbr }}</td>
				<td style="{{ $c }}" colspan="2">{{ $data->on[$i]->applicant->user->namefull }}</td>
			@else
				<td style="{{ $c }}"></td>
				<td style="{{ $c }}"></td>
				<td style="{{ $c }}"></td>
				<td style="{{ $c }}"></td>
				<td style="{{ $c }}" colspan="2"></td>
			@endif

			<td></td>

			@if(isset($data->off[$i]))
				<td style="{{ $c }}">{{ $data->off[$i]->disembarkation_date->format('d-M-y') }}</td>
				<td style="{{ $c }}">{{ $data->off[$i]->rank->abbr }}</td>
				<td style="{{ $c }}" colspan="2">{{ $data->off[$i]->applicant->user->namefull }}</td>
			@else
				<td style="{{ $c }}"></td>
				<td style="{{ $c }}"></td>
				<td style="{{ $c }}" colspan="2"></td>
			@endif
		</tr>
	@endfor

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="5" style="height: 30px;">Submitted By: (Crewing Dept) {{ auth()->user()->gender == "Male" ? "Mr." : "Ms." }} {{ auth()->user()->fullname }}</td>
		<td colspan="5" style="height: 30px;">Received By: (Liaison Officer)</td>
		<td style="height: 30px;">Date: </td>
	</tr>
</table>