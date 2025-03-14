<table>
	<tr>
		<td colspan="6">
			Ship's information
		</td>
	</tr>

	<tr>
		<td>No.</td>
		<td>Name of ship</td>
		<td>Type of ship</td>
		<td>GRT</td>
		<td>Engine power</td>
		<td>Ship's flag</td>
	</tr>

	@php
		$array = [
			['GAS ONE', 'P/LPG', 3450, 2380, "PANAMA"],
			['GAS DREAM', 'P/LPG', 4484, 3400, "PANAMA"],
			['GAS HARMONY', 'P/LPG', 3385, 3170, "PANAMA"],
			['GAS EVA', 'P/LPG', 3322, 2648, "PANAMA"],
			['GAS FRIEND', 'RLPG', 46129, 12360, "PANAMA"],
			['GAS COLUMBIA', 'RLPG', 22135, 9628, "PANAMA"],
			['GAS VISION', 'RLPG', 44694, 12360, "PANAMA"],
			['GAS POWER', 'RLPG', 46500, 12360, "PANAMA"],
			['GAS QUANTUM', 'RLPG', 22814, 9480, "PANAMA"],
			['GAS STAR', 'RLPG', 47754, 12600, "PANAMA"],
			['GAS SUMMIT', 'RLPG', 47754, 12600, "PANAMA"],
			['GAS WISDOM', 'RLPG', 74696, null, "PANAMA"],
			['GAS GALA', 'RLPG', 48858, null, "PANAMA"],
			['LUCKY CHEMIST', 'OIL/CHEM', 29806, null, "PANAMA"],
		];
	@endphp

	@foreach($array as $row)
		<tr>
			<td>{{ $loop->index+1 }}</td>
			<td>{{ $row[0] }}</td>
			<td>{{ $row[1] }}</td>
			<td>{{ number_format($row[2]) }}</td>
			<td>{{ $row[3] ? number_format($row[3]) . ' KW' : "" }}</td>
			<td>{{ $row[4] }}</td>
		</tr>
	@endforeach
</table>