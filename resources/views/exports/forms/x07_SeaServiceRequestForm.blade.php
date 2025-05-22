@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	$middle = "vertical-align: middle;";
	$und = "text-decoration: underline;";
	$blue = "color: #0000FF;";
@endphp

<table>
	<tr>
		<td colspan="7" style="font-size: 15px; height: 60px;">
		</td>
	</tr>

	<tr>
		<td colspan="7" style="height: 70px; {{ $und }} {{ $bold }} {{ $center }} font-size: 20px;">
			REQUEST FOR SEA SERVICE CERTIFICATE
		</td>
	</tr>

	<tr>
		<td>DATE:</td>
		<td colspan="6" style="{{ $blue }}">{{ now()->format('d-M-y') }}</td>
	</tr>

	<tr>
		<td>RANK:</td>
		<td colspan="6" style="{{ $blue }}">{{ $data->rank }}</td>
	</tr>

	<tr>
		<td>NAME:</td>
		<td colspan="6" style="{{ $blue }}">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
	</tr>

	<tr>
		<td>PURPOSE:</td>
		<td colspan="6" style="{{ $blue }}">
			{{ $data->data['reason'] }}
		</td>
	</tr>

	<tr>
		<td colspan="7" style="height: 40px;"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td style="{{ $bold }} {{ $und }} {{ $center }} {{ $middle }}">DATE</td>
		<td></td>
		<td style="{{ $bold }} {{ $und }} {{ $center }} {{ $middle }}">PIC WITH SIGNATURE</td>
		<td></td>
		<td style="{{ $bold }} {{ $und }} {{ $center }} {{ $middle }}">REMARKS</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $middle }}">CREWING DEPT.</td>
		<td style="{{ $center }} {{ $blue }}">{{ now()->format('d-M-y') }}</td>
		<td></td>
		<td style="{{ $blue }} {{ $center }}">
			{{ auth()->user()->gender == "Male" ? "Mr" : "Ms." }} {{ auth()->user()->fname }} {{ auth()->user()->lname }}
		</td>
		<td></td>
		<td style="{{ $center }} {{ $blue }}"></td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $middle }}">ACCOUNTING DEPT.</td>
		<td style="{{ $center }} {{ $blue }} font-size: 9px;"></td>
		<td></td>
		<td style="{{ $center }} {{ $blue }}"></td>
		<td></td>
		<td style="{{ $center }} {{ $blue }}"></td>
	</tr>

	<tr>
		<td style="height: 80px; {{ $middle }}" colspan="2">ISSUED BY:</td>
		<td></td>
		<td colspan="3" style="height: 80px; {{ $middle }}">RECEIVED BY:</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $blue }} {{ $center }}">
			{{ auth()->user()->gender == "Male" ? "Mr." : "Ms." }} {{ auth()->user()->fname }} {{ auth()->user()->lname }}
		</td>
		<td></td>
		<td colspan="3" style="{{ $blue }} {{ $center }}">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $center }}">NAME &#38; SIGNATURE</td>
		<td></td>
		<td colspan="3">CREW'S NAME &#38; SIGNATURE</td>
	</tr>

	<tr>
		<td style="height: 50px;" colspan="7"></td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $center }}">DATE RECEIVED:</td>
		<td colspan="3" style="{{ $blue }} {{ $center }}"></td>
	</tr>

	<tr>
		<td style="height: 50px;" colspan="7"></td>
	</tr>

	<tr>
		<td colspan="2">SEA SERVICE CERT #:</td>
		<td colspan="3"></td>
		<td colspan="2"></td>
	</tr>

</table>