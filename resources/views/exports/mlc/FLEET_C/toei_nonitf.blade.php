@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";

	$verdana = "font-family: Verdana;";

	$und = "text-decoration: underline;";

	$header = function($pn) use($bc, $c, $verdana){
		echo "
			<tr>
				<td colspan='2' rowspan='4'></td>
				<td colspan='5' rowspan='2' style='font-size: 12; $bc $verdana'>VR Maritime Services Private Limited</td>
				<td style='font-size:8; $verdana'>Issue: 00</td>
			</tr>

			<tr>
				<td style='font-size:8; $verdana'>Revision: 03</td>
			</tr>

			<tr>
				<td colspan='5' style='font-size: 10; $c $verdana'>FPS 04A: Seafarer’s Employment Agreement </td>
				<td style='font-size:8; $verdana'>Date: 03rd Aug 2024</td>
			</tr>

			<tr>
				<td colspan='5'></td>
				<td style='font-size:8; $verdana'>Page: $pn of 16</td>
			</tr>
		";
	}
@endphp

<table>
	{{ $header(1) }}

	<tr>
		<td colspan="8" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $bc }} {{ $und }} font-size: 11px;">SEAFARER’S EMPLOYMENT AGREEMENT – Part I</td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $bc }} font-size: 10px;">ASSIGNMENT LETTER</td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $c }} font-size: 10px;">This Agreement incorporates the 2018 amendments to the MLC 2006</td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $c }} font-size: 10px;">This Employment Agreement is entered into between the Owner/Agent of the Registered Owner of a vessel</td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $c }} font-size: 10px;">(hereinafter called the COMPANY) and the SEAFARER.</td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $b }} font-size: 9.5px;">The Ship</td>
	</tr>

	<tr>
		<td style="font-size: 9;" colspan="2">&#8205; Name</td>
		<td style="font-size: 9; {{ $c }}" colspan="2"></td>
		<td style="font-size: 9;">&#8205; IMO No.</td>
		<td style="font-size: 9; {{ $c }}" colspan="3"></td>
	</tr>

	<tr>
		<td style="font-size: 9;" colspan="2">&#8205; Flag</td>
		<td style="font-size: 9; {{ $c }}" colspan="2"></td>
		<td style="font-size: 9;">&#8205; Port of Registry</td>
		<td style="font-size: 9; {{ $c }}" colspan="3"></td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $b }} font-size: 9.5px;">The Registered Ship-Owner (COMPANY)</td>
	</tr>

	<tr>
		<td style="font-size: 9;" colspan="2">&#8205; Name</td>
		<td style="font-size: 9; {{ $c }}" colspan="6"></td>
	</tr>

	<tr>
		<td style="font-size: 9;" colspan="2">&#8205; Address</td>
		<td style="font-size: 9; {{ $c }}" colspan="6"></td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $b }} font-size: 9.5px;">The Ship-Owner (COMPANY) Representative (MLC Shipowner)</td>
	</tr>

	<tr>
		<td style="font-size: 9;" colspan="2">&#8205; Name</td>
		<td style="font-size: 9; {{ $c }}" colspan="6"></td>
	</tr>

	<tr>
		<td style="font-size: 9;" colspan="2">&#8205; Address</td>
		<td style="font-size: 9; {{ $c }}" colspan="6"></td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $b }} font-size: 9.5px;">The Seafarer</td>
	</tr>

	<tr>
		<td style="font-size: 9;" colspan="2">
			&#8205; Surname
			<br style='mso-data-placement:same-cell;' />
			&#8205; (in capital letters)
		</td>
		<td style="font-size: 9; {{ $c }}" colspan="2"></td>
		<td style="font-size: 9;">
			&#8205; The capacity/Rank in
			<br style='mso-data-placement:same-cell;' />
			&#8205; which the seafarer is
			<br style='mso-data-placement:same-cell;' />
			&#8205; employed
		</td>
		<td style="font-size: 9; {{ $c }}" colspan="3"></td>
	</tr>

	<tr>
		<td style="font-size: 9;" colspan="2">
			&#8205; Given Name
		</td>
		<td style="font-size: 9; {{ $c }}" colspan="2"></td>
		<td style="font-size: 9;">
			&#8205; COC Rank/Issued
			<br style='mso-data-placement:same-cell;' />
			&#8205; Country
		</td>
		<td style="font-size: 9; {{ $c }}" colspan="2">-</td>
		<td style="font-size: 9; {{ $c }}">-</td>
	</tr>

	<tr>
		<td style="font-size: 9;" colspan="2">
			&#8205; Middle Name
		</td>
		<td style="font-size: 9; {{ $c }}" colspan="2"></td>
		<td style="font-size: 9;">
			&#8205; Passport No./Valid till
			<br style='mso-data-placement:same-cell;' />
			&#8205; date
		</td>
		<td style="font-size: 9; {{ $c }}" colspan="2"></td>
		<td style="font-size: 9; {{ $c }}"></td>
	</tr>

	<tr>
		<td style="font-size: 9;" colspan="2">
			&#8205; Nationality
		</td>
		<td style="font-size: 9; {{ $c }}" colspan="2"></td>
		<td style="font-size: 9;">
			&#8205; Seaman's Book No./
			<br style='mso-data-placement:same-cell;' />
			&#8205; Valid date
		</td>
		<td style="font-size: 9; {{ $c }}" colspan="2"></td>
		<td style="font-size: 9; {{ $c }}"></td>
	</tr>

	<tr>
		<td style="font-size: 9;" colspan="2">
			&#8205; Date of Birth
			<br style='mso-data-placement:same-cell;' />
			&#8205; (dd-mm-yyyy)
		</td>
		<td style="font-size: 9; {{ $c }}" colspan="2"></td>
		<td style="font-size: 9;">
			&#8205; Medical Cert valid till
			<br style='mso-data-placement:same-cell;' />
			&#8205; date
		</td>
		<td style="font-size: 9; {{ $c }}" colspan="3"></td>
	</tr>

	<tr>
		<td style="font-size: 9;" colspan="2">
			&#8205; Place of Birth
		</td>
		<td style="font-size: 9; {{ $c }}" colspan="2"></td>
		<td style="font-size: 9;">
			&#8205; Estimated time of
			<br style='mso-data-placement:same-cell;' />
			&#8205; joining
		</td>
		<td style="font-size: 9; {{ $c }}" colspan="3"></td>
	</tr>

	<tr>
		<td style="font-size: 9;" colspan="2">
			&#8205; BSID No. / Valid till
		</td>
		<td style="font-size: 9; {{ $c }}" colspan="2"></td>
		<td style="font-size: 9;">
			&#8205; Port of joining
		</td>
		<td style="font-size: 9; {{ $c }}" colspan="3"></td>
	</tr>

	<tr>
		<td style="font-size: 9; {{ $c }}" colspan="4"></td>
		<td style="font-size: 9;">
			&#8205; Home Port
		</td>
		<td style="font-size: 9; {{ $c }}" colspan="3"></td>
	</tr>

	<tr>
		<td style="font-size: 9;" colspan="2">
			&#8205; Full home address
		</td>
		<td style="font-size: 9; {{ $c }}" colspan="6"></td>
	</tr>
</table>