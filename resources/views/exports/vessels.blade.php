<table>
	<tr>
		<td></td>
		<td colspan="13">FLEET LIST</td>
	</tr>

	<tr>
		<td>NO.</td>
		<td>PRINCIPAL</td>
		<td>VESSEL NAME</td>
		<td>FLAG</td>
		<td>VESSEL TYPE</td>
		<td>YEAR BUILT</td>
		<td>BUILDER</td>
		<td>ENGINE MAKE/MODEL</td>
		<td>G/T</td>
		<td></td>
		<td>BHP</td>
		<td>TRADE</td>
		<td>ECDIS</td>
		<td>STATUS</td>
	</tr>

	@foreach($datas as $data)
		<tr>
			<td>{{ ($loop->index + 1) }}</td>
			<td>{{ $data->principal->name }}</td>
			<td>{{ $data->name }}</td>
			<td>{{ $data->flag }}</td>
			<td>{{ $data->type }}</td>
			<td>{{ $data->year_build }}</td>
			<td>{{ $data->builder }}</td>
			<td>{{ $data->engine }}</td>
			<td>{{ $data->gross_tonnage }}</td>
			<td>{{ ceil(($data->BHP * 0.745) / 5) * 5 }}</td>
			<td>{{ $data->BHP }}</td>
			<td>{{ $data->trade }}</td>
			<td>{{ $data->ecdis }}</td>
			<td>{{ $data->status }}</td>
		</tr>
	@endforeach
</table>