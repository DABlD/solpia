@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$u = "text-decoration: underline;";
	$bc = "$b$c";
	$blue = "color: #0000FF;";
	$cblue = "$c$blue";

	$fill = function(){
		echo "<tr><td colspan='22'></td></tr>";
	}
@endphp

<table>
	<tr>
		<td colspan="5" style="{{ $bc }}">PAYMENT DATE</td>
		<td colspan="12"></td>
		<td colspan="5" style="{{ $b }}">(For POEA, OWWA, PHILHEALTH ONLY)</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $b }}">OWWA</td>
		<td colspan="3" style="{{ $b }}">DELFIN</td>
		<td colspan="12"></td>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $b }}">1. Membership</td>
		<td colspan="2" style="{{ $c }}">VERLO CARL</td>
		<td></td>
		<td colspan="12"></td>
		<td colspan="2" style="{{ $b }}">CG No.</td>
		<td colspan="2" style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="5"></td>
		<td colspan="12" style="{{ $bc }}">PHILIPPINE OVERSEAS EMPLOYMENT ADMINISTRATION</td>
		<td colspan="2" style="{{ $b }}">RFP No.</td>
		<td colspan="2" style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $b }}">Philhealth/Medicare</td>
		<td style="{{ $c }}"></td>
		<td></td>
		<td colspan="12" style="{{ $bc }}">OVERSEAS WORKERS WELFARE ADMINISTRATION</td>
		<td colspan="3" style="{{ $b }}">Assessment No.</td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="5"></td>
		<td colspan="12" style="{{ $bc }}">PHILIPPINE HEALTH INSURANCE CORPORATION</td>
		<td colspan="3" style="{{ $b }}">Assessed Amount.</td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $b }}">OFW e-Card / ID no:</td>
		<td colspan="2"></td>
		<td colspan="12"></td>
		<td colspan="2"></td>
		<td>POEA:</td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td style="{{ $b }}">SSS No.</td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="12" rowspan="2" style="{{ $bc }}">INFORMATION SHEET</td>
		<td colspan="2"></td>
		<td style="{{ $b }}">OWWA:</td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td style="{{ $b }}">SID No.</td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2"></td>
		<td style="{{ $b }}">PHILHEALTH:</td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $b }}">PhilHealth No.</td>
		<td colspan="3" style="{{ $c }}"></td>
		<td colspan="12" style="{{ $bc }}"></td>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $b }} {{ $u }}">I. PERSONAL DATA</td>
		<td colspan="12"></td>
		<td colspan="5" style="{{ $bc }}">Change/s (if any)</td>
	</tr>

	<tr>
		<td colspan="5"></td>
		<td colspan="12"></td>
		<td colspan="5" style="{{ $bc }}">(Ffor balik-mangagawa only)</td>
	</tr>

	<tr>
		<td style="{{ $b }}">Name:</td>
		<td colspan="5" style="{{ $bc }} {{ $b }}">{{ $data->user->lname }}</td>
		<td colspan="6" style="{{ $bc }} {{ $b }}">{{ $data->user->fname }} {{ $data->user->suffix }}</td>
		<td colspan="6" style="{{ $bc }} {{ $b }}">{{ $data->user->mname }}</td>
		<td></td>
		<td colspan="3" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td style="{{ $b }}"></td>
		<td colspan="5" style="{{ $bc }} {{ $b }}">Family Name(Apelyido)</td>
		<td colspan="6" style="{{ $bc }} {{ $b }}">First Name(Pangalan)</td>
		<td colspan="6" style="{{ $bc }} {{ $b }}">Middle Name(Gitnang Apelyido)</td>
		<td></td>
		<td colspan="3" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="6">Address in the Philippines: (Tirahan)</td>
		<td colspan="16" style="{{ $c }} {{ $blue }}">{{ $data->user->address }}</td>
	</tr>

	<tr>
		<td colspan="2">Telephone No.:</td>
		<td colspan="5" style="{{ $c }} {{ $blue }}">#N/A</td>
		<td colspan="3">Cellphone No.:</td>
		<td colspan="4" style="{{ $cblue }}">{{ $data->user->contact }}</td>
		<td colspan="3">Email Address:</td>
		<td colspan="4" style="{{ $cblue }}">{{ $data->user->email }}</td>
	</tr>
</table>