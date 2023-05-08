@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b$c";
	$u = "text-decoration: underline;";
@endphp

<table>
	<tr>
		<td colspan="7" style="{{ $bc }}">SEAFARER EMPLOYMENT AGREEMENT</td>
	</tr>

	<tr>
		<td colspan="7" style="height: 30px;"></td>
	</tr>

	<tr>
		<td colspan="2" rowspan="4" style="{{ $c }}">Seafarer</td>
		<td>Name</td>
		<td colspan="3">{{ $data->user->namefull }}</td>
		<td>Position</td>
		<td>{{ $data->pro_app->rank->name }}</td>
	</tr>

	@php
		$pp = null;
		$sb = null;
		$mc = null;

		foreach($data->document_med_cert as $docu){
			if($docu->type == "MEDICAL CERTIFICATE"){
				$mc = $docu;
			}
		}

		foreach($data->document_id as $docu){
			if($docu->type == "PASSPORT"){
				$pp = $docu;
			}
			elseif($docu->type == "SEAMAN'S BOOK"){
				$sb = $docu;
			}
		}
	@endphp

	<tr>
		<td>Date of Birth</td>
		<td colspan="3">{{ $data->user->birthday ? $data->user->birthday->format("d M Y") : "---"}}</td>
		<td>Passport No.</td>
		<td>{{ $pp ? $pp->number : '---' }}</td>
	</tr>

	<tr>
		<td>Birthplace/Nationality</td>
		<td colspan="3">{{ $data->birth_place }}/FILIPINO</td>
		<td>Tel. No.</td>
		<td>{{ $data->user->contact }}</td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="5">{{ $data->user->address }}</td>
	</tr>
</table>