@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
@endphp

<table>
	<tr>
		<td colspan="11" style="{{ $bold }} {{ $center }}">RELEASE AND QUITCLAIM</td>
	</tr>

	<tr>
		<td colspan="11" style="height: 40px;"></td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $center }} height: 40px;">
			I, {{ $data->user->fname }} {{ $data->user->mname }} {{ $data->user->lname }} {{ $data->user->suffix }}, Filipino, {{ $data->civil_status }}, {{ $data->user->birthday->age }}, with present address at {{ $data->user->address }}, do hereby deposed and say:
		</td>

	</tr>

	<tr>
		<td colspan="11" style="height: 30px;"></td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $center }} height: 60px;">
			That, I do hereby release and free <span style="{{ $bold }}">Solpia Marine &#38; Ship Management Inc (company)</span>, with postal address at Solpia Building #2019 San Marcelino St. Malate Manila 1004; and each agent and/or any person in privity with them, from any further financial obligation and/or liability whatsoever, after my employment.</span>
		</td>
	</tr>

	<tr>
		<td colspan="11" style="height: 30px;"></td>
	</tr>

	<td colspan="11" style="{{ $center }} height: 60px;">
		That I further declare that all my original documents was handed over to me and do state above-mentioned company, and/or agent does not have liability to me howsoever, and, if there any, I hereby waive such claims against either and/or any person in privity with them arising out of my employment, non-rehire and contract with said Solpia Marine &#38; Ship Management Inc.
	</td>

	<tr><td colspan="11" style="height: 30px;"></td></tr>

	<tr>
		<td colspan="11" style="{{ $center }}">
			I have affixed my signature to the veracity and truthfulness of the foregoing statement.
		</td>
	</tr>

	<tr><td colspan="11" style="height: 30px;"></td></tr>

	<tr>
		<td colspan="11" style="{{ $center }}">
			Done this ____ day of ___________ {{ now()->format("Y") }} in Manila, Philippines.
		</td>
	</tr>

	<tr>
		<td colspan="11" style="height: 40px;"></td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $center }} text-decoration: underline;">
			{{ $data->user->fname }} {{ $data->user->mname }} {{ $data->user->lname }} {{ $data->user->suffix }}
		</td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $center }} {{ $bold }}">
			Seafarer
		</td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $center }}">
			(Signed in the presence of)
		</td>
	</tr>

	<tr>
		<td colspan="11" style="height: 65px;"></td>
	</tr>

	<tr>
		<td colspan="1"></td>
		<td colspan="4" style="border-bottom: 1px solid #000;"></td>
		<td colspan="1"></td>
		<td colspan="4" style="border-bottom: 1px solid #000;"></td>
		<td colspan="1"></td>
	</tr>

	<tr>
		<td colspan="11" style="height: 35px;"></td>
	</tr>

	<tr>
		<td colspan="11">ACKNOWLEDGEMENT</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr><td colspan="11">Republic of the Philippines)</td></tr>
	<tr><td colspan="11">City of Manila ) S.S.</td></tr>

	<tr>
		<td colspan="11" style="height: 30px;"></td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $center }}">
			Before me this,__________________________ at Manila Philippines, personally appeared with Passport No.___________________ issued at ________________ on, who is known to me to be the same person who executed the foregoing instrument and he acknowledged that the same in his free act and deed.
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $center }}">
			Witness my hand and notarial seal on the date and place first above-written herein.
		</td>
	</tr>

	<tr>
		<td colspan="11" style="height: 35px;"></td>
	</tr>

	<tr>
		<td colspan="11">Doc No.__________________</td>
	</tr>

	<tr>
		<td colspan="11">Page No.__________________</td>
	</tr>

	<tr>
		<td colspan="11">Book No.__________________</td>
	</tr>

	<tr>
		<td colspan="11">Series of__________________</td>
	</tr>
</table>