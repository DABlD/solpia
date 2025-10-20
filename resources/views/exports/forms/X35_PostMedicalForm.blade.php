@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";
@endphp

<table>
	<tr>
		<td colspan="11" style="height: 60px;"></td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $bc }}">REQUEST FOR POST - MEDICAL EXAMINATION</td>
	</tr>

	<tr>
		<td colspan="10" style="text-align: right; {{ $b }}">DATE:</td>
		<td colspan="1" style="text-decoration: underline;">{{ now()->format('Y.m.d') }}</td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $b }}">
			Name of Seafarer: {{ $data->user->namefull }}
		</td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $b }}">
			Rank: {{ $data->current_lineup->rank->name }}
		</td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $b }}">
			Name of Vessel: {{ $data->pro_app->vessel->name }}
		</td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $b }}">
			Date &#38; Place of Embarkation: {{ $data->current_lineup->joining_port }} / {{ $data->current_lineup->joining_date->format("M j, Y") }}
		</td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $b }}">
			Date &#38; Place of Disembarkation: {{ $data->current_lineup->disembarkation_port }} / {{ $data->current_lineup->disembarkation_date ? now()->parse($data->current_lineup->disembarkation_date)->format("M j, Y") : "-" }}
		</td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $b }}">
			Date of Arrival in Manila: {{ $data->data['arrival_date'] != "" ? now()->parse($data->data['arrival_date'])->format('M j, Y') : "-" }}
		</td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $b }} font-style: italic;">
			MEDICAL REASON(S): SPECIFIC INSTRUCTION
		</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td style="{{ $b }}">ILLNESS</td>
		<td colspan="3"></td>
		<td></td>
		<td colspan="2" style="{{ $b }}">
			POST-MEDICAL/IN-HOUSE
		</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td style="{{ $b }}">INJURY</td>
		<td colspan="3"></td>
		<td></td>
		<td colspan="1" style="{{ $b }}">
			P &#38; I
		</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="6"></td>
		<td></td>
		<td style="{{ $b }}">
			OTHERS
		</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $bc }} font-style: italic;">
			Documents submitted:
		</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td></td>
		<td colspan="4" style="{{ $b }}">
			ㅤPassport
		</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td></td>
		<td colspan="4" style="{{ $b }}">
			ㅤSeaman's book
		</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td></td>
		<td colspan="4" style="{{ $b }}">
			ㅤIncident Report
		</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td></td>
		<td colspan="4" style="{{ $b }}">
			ㅤMaster's Report/Referral
		</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td></td>
		<td colspan="4" style="{{ $b }}">
			ㅤMedical Report/s abroad
		</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td></td>
		<td colspan="4" style="{{ $b }}">
			ㅤ201 FILE
		</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td></td>
		<td colspan="4" style="{{ $b }}">
			ㅤOthers:
		</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="11" style="font-style: italic; {{ $c }} font-size: 8px;">
			Write (/) or "N/A" in the space provided to show that you have read and filled out the form fully
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="8" style="font-style: italic; text-decoration: underline;">ENDORSED BY:</td>
		<td colspan="3" style="font-style: italic; text-decoration: underline;">NOTED BY:</td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $c }} font-style: italic; font-size: 7px; color: gray;">SIGNATURE OVER PRINTED NAME</td>
		<td colspan="2"></td>
		<td colspan="3" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $bc }}">CREWING OFFICER</td>
		<td colspan="2"></td>
		<td colspan="3" style="{{ $bc }}">GENERAL MANAGER</td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $c }} font-style: italic; font-size: 7px; color: gray;">SIGNATURE OVER PRINTED NAME</td>
		<td colspan="2"></td>
		<td colspan="3" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $bc }}">CREWING MANAGER</td>
		<td colspan="2"></td>
		<td colspan="3" style="{{ $bc }}">PRESIDENT</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11" style="font-style: italic; text-decoration: underline;">RECEIVED BY:</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $b }}">Claims Department:</td>
		<td colspan="4"></td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $b }}">Date:</td>
		<td colspan="6"></td>
		<td colspan="3"></td>
	</tr>
</table>