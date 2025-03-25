<table>
	<tr>
		<td>Code</td>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<td>5</td>
		<td>6</td>
	</tr>

	<tr>
		<td>No.</td>
		<td>Vessel</td>
		<td>Vessel Code</td>
		<td>Type of vessel</td>
		<td>Flag</td>
		<td>IMO No.</td>
		<td>G/T</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	@php
		$vessels = [
			["MAGIC CHEMIST","CTMC","OIL/CHEMICAL Tanker","PANAMA","9707261", "29,806"],
			["LUCKY CHEMIST","CTLC","OIL/CHEMICAL Tanker","PANAMA","9686742", "29,806"],
			["GAS SUMMIT","GTSU","VLGC","PANAMA","9693549", "47,696"],
			["GAS WISDOM","GTWI","VLGC","PANAMA","9788992", "47,696"],
			["GAS GALA","GTGL","VLGC","PANAMA","9892406", "48,858"],
		];
	@endphp

	@foreach($vessels as $vessel)
		<tr>
			<td>{{ $loop->index+1 }}</td>
			<td>{{ $vessel[0] }}</td>
			<td>{{ $vessel[1] }}</td>
			<td>{{ $vessel[2] }}</td>
			<td>{{ $vessel[3] }}</td>
			<td>{{ $vessel[4] }}</td>
			<td>{{ $vessel[5] }}</td>
		</tr>
	@endforeach
</table>