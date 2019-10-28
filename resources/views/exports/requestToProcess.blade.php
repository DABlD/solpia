<table>
	<tr>
		<td rowspan="5" colspan="41"></td>
	</tr>

	<tr></tr>
	<tr></tr>
	<tr></tr>
	<tr></tr>

	<tr>
		<td colspan="41">REQUEST TO PROCESS</td>
	</tr>

	<tr>
		<td colspan="41"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="2">{{ in_array(0, $data->docus) ? 'a' : '' }}</td>
		<td colspan="14">USA VISA REFUND</td>
		<td>{{ in_array(1, $data->docus) ? 'a' : '' }}</td>
		<td colspan="9">FLAG</td>
		<td colspan="2">{{ in_array(2, $data->docus) ? 'a' : '' }}</td>
		<td colspan="11">VESSEL / PRINCIPAL ENROLLMENT / AMENDMENT</td>
	</tr>

	<tr>
		<td colspan="41"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="2"></td>
		<td colspan="7">OTHER VISA</td>
		<td colspan="7"></td>
		<td>{{ in_array(3, $data->docus) ? 'a' : '' }}</td>
		<td colspan="9">IHT CERT</td>
		<td colspan="2">{{ in_array(4, $data->docus) ? 'a' : '' }}</td>
		<td colspan="11">CONTRACT</td>
	</tr>

	<tr>
		<td colspan="39"></td>
		<td>No.:</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="41"></td>
	</tr>

	<tr>
		<td colspan="11">DEPARTMENT:</td>
		<td colspan="28">{{ $data->department }}</td>
		<td>DATE:</td>
		<td>{{ now()->toFormattedDateString() }}</td>
	</tr>

	<tr>
		<td colspan="41"></td>
	</tr>

	<tr>
		<td colspan="41"></td>
	</tr>

	<tr>
		<td colspan="16">SEAFARER NAME</td>
		<td colspan="9">RANK / POSITION</td>
		<td colspan="13">VESSEL</td>
		<td colspan="2">PORT / COUNTRY</td>
		<td>DEPARTURE</td>
	</tr>

	@foreach($crews as $crew)
		@php
			$name = $crew->user->lname . ', ' . $crew->user->fname . ' ' . ($crew->user->suffix == "" ? '' : $crew->user->suffix . ' ') . $crew->user->mname;
			$name = $crew->user->lname == '' ? '' : $name;
		@endphp
		<tr>
			<td colspan="16">{{ $name }}</td>
			<td colspan="9">{{ $crew->rank }}</td>
			<td colspan="13">{{ $crew->vessel }}</td>
			<td colspan="2">{{ $crew->rank != "" ? $data->port : '' }}</td>
			<td>{{ $crew->rank == "" ? "" : now()->parse($data->departure)->toFormattedDateString() }}</td>
		</tr>
	@endforeach

	<tr>
		<td colspan="41"></td>
	</tr>

	<tr>
		<td colspan="11">Requested by:</td>
		<td colspan="11">Approved by:</td>
		<td colspan="12">Noted by:</td>
		<td colspan="7">Received By:</td>
	</tr>

	<tr>
		<td colspan="11"></td>
		<td colspan="11"></td>
		<td colspan="12"></td>
		<td colspan="7"></td>
	</tr>

	<tr>
		<td colspan="11"></td>
		<td colspan="11"></td>
		<td colspan="12"></td>
		<td colspan="7"></td>
	</tr>

	<tr>
		<td colspan="11"></td>
		<td colspan="11"></td>
		<td colspan="12"></td>
		<td colspan="7"></td>
	</tr>

	<tr>
		<td colspan="41">SMOP-RTP-09</td>
	</tr>
</table>