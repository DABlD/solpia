<table>
	<thead>
		<tr>
			<th></th>
			<th>Action</th>
			<th>IP</th>
			<th>Hostname</th>
			<th>Device</th>
			<th>Browser</th>
			<th>Platform</th>
			<th>Datetime</th>
		</tr>
	</thead>
	@foreach($datas as $data)
		<tr>
			<td>{{ ($loop->index + 1) }}</td>
			<td>{{ $data->username . ' ' . $data->action }}</td>
			<td>{{ $data->ip }}</td>
			<td>{{ $data->hostname }}</td>
			<td>{{ $data->device }}</td>
			<td>{{ $data->browser }}</td>
			<td>{{ $data->platform }}</td>
			<td>{{ $data->created_at->format('F j, Y h:i A') }}</td>
		</tr>
	@endforeach
</table>