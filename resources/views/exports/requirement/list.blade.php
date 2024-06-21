@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";
@endphp

<table>
	<tr>
		<td>ID</td>
		<td>Vessel</td>
		<td>Type</td>
		<td>Rank</td>
		<td>Joining Date</td>
		<td>PORT</td>
		<td>USV</td>
		<td>Max Age</td>
		<td>Status</td>
		<td>Date Posted</td>
		<td>Prospect</td>
		<td>Remarks</td>
	</tr>

	@foreach($data as $req)
		<tr>
			<td>{{ $req->id }}</td>
			<td>{{ isset($req->vessel) ? $req->vessel->name : "---" }}</td>
			<td>{{ isset($req->vessel) ? $req->vessel->type : "---" }}</td>
			<td>{{ $req->rank2->abbr }}</td>
			<td>{{ $req->joining_date->format('Y-m-d') }}</td>
			<td>{{ $req->joining_port }}</td>
			<td>{{ $req->usv ? "Required" : "---" }}</td>
			<td>{{ $req->max_age }}</td>
			<td>{{ $req->status }}</td>
			<td>{{ $req->created_at->format('Y-m-d') }}</td>
			<td>{{ sizeof($req->candidates) }}</td>
			<td>{{ $req->remarks }}</td>
		</tr>
	@endforeach
</table>