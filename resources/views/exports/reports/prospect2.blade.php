@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";
@endphp

<table>
	<tr>
		<td colspan="9" style="{{ $bc }} height: 40px; font-size: 26px;">
			Prospect Report from {{ $from }} - {{ $to }}
		</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">#</td>
		<td style="{{ $bc }}">Rank</td>
		<td style="{{ $bc }}">Name</td>
		<td style="{{ $bc }}">Age</td>
		<td style="{{ $bc }}">Contact</td>
		<td style="{{ $bc }}">Email</td>
		<td style="{{ $bc }}">USV</td>
		<td style="{{ $bc }}">Exp</td>
		<td style="{{ $bc }}">Date</td>
		<td style="{{ $bc }}">TOTAL</td>
		<td style="{{ $bc }} color: #FF0000;">=SUBTOTAL(3, A3:A{{ sizeof($data) + 3 }})</td>
	</tr>

	@foreach($data as $prospect)
		<tr>
			<td style="{{ $c }}">{{ $loop->index+1 }}</td>
			<td style="{{ $c }}">{{ $prospect['rank'] }}</td>
			<td style="{{ $c }}">{{ $prospect['name'] }}</td>
			<td style="{{ $c }}">{{ isset($prospect['birthday']) ? now()->parse($prospect['birthday'])->age : $prospect['age'] ?? '-' }}</td>
			<td style="{{ $c }}">{{ $prospect['contact'] }}</td>
			<td style="{{ $c }}">{{ $prospect['email'] }}</td>
			<td style="{{ $c }}">{{ isset($prospect['usv']) ? now()->parse($prospect['usv'])->format('F j, Y') : '-' }}</td>
			<td style="{{ $c }}">{{ $prospect['exp'] }}</td>
			{{-- <td style="{{ $c }}">{{ implode(',', json_decode($prospect['exp'])) }}</td> --}}
			<td style="{{ $c }}">{{ now()->parse($prospect['created_at'])->format('F j, Y') }}</td>
		</tr>
	@endforeach
</table>