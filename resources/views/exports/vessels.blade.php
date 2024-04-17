@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";
@endphp

<table>
	<tr>
		<td colspan="12" style="{{ $bc }} height: 40px;">FLEET LIST MANNED BY SOLPIA MARINE AS OF {{ now()->format('F Y') }}</td>
	</tr>

	<tr>
		<td style="{{ $c }} height: 42px;">PRINCIPAL</td>
		<td style="{{ $c }} height: 42px;">VESSEL NAME</td>
		<td style="{{ $c }} height: 42px;">FLEET</td>
		<td style="{{ $c }} height: 42px;">FLAG</td>
		<td style="{{ $c }} height: 42px;">TYPE</td>
		<td style="{{ $c }} height: 42px;">YEAR BUILT</td>
		<td style="{{ $c }} height: 42px;">ENGINE MAKE/MODEL</td>
		<td style="{{ $c }} height: 42px;">KW</td>
		<td style="{{ $c }} height: 42px;">TRADE</td>
		<td style="{{ $c }} height: 42px;">NO. OF CREW</td>
		<td style="{{ $c }} height: 42px;">TOTAL</td>
		<td style="{{ $c }} height: 42px;">TOTAL VESSEL</td>
	</tr>

	@foreach($data as $principal => $types)
		@php
			$ctr = 0;
		@endphp
		@foreach($types as $type)
			@php
				$ctr++;
			@endphp
			{{-- DISREGARD COUNT VARIABLE --}}
			@if(is_object($type))
				@foreach($type as $vessel)
					<tr>
						{{-- @if($loop->first && $ctr == 1)
							<td rowspan="{{ $types['count'] }}">{{ $principal }}</td>
						@endif --}}
						<td>{{ $principal }}</td>
						<td>{{ $vessel['name'] }}</td>
						<td>{{ $vessel['fleet'] }}</td>
						<td>{{ $vessel['flag'] }}</td>
						<td>{{ $vessel['type'] }}</td>
						<td>{{ $vessel['year_build'] }}</td>
						<td>{{ $vessel['engine'] }}</td>
						<td>{{ $vessel['BHP'] }}</td>
						<td>{{ $vessel['trade'] }}</td>
						<td>{{ $vessel['noc'] }}</td>
						@if($loop->first && $ctr == 1)
							<td rowspan="{{ $types['count'] }}">{{ $types['totalCrew'] }}</td>
						@endif
						@if($loop->first && $ctr == 1)
							<td rowspan="{{ $types['count'] }}">{{ sizeof($type) }}</td>
						@endif
					</tr>
				@endforeach
			@endif
		@endforeach
	@endforeach

	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td style="{{ $bc }}">TOTAL</td>
		<td style="color: #FF0000; {{ $bc }}">=SUBTOTAL(9, K3:K{{ $total + 2 }})</td>
		<td style="color: #FF0000; {{ $bc }}">=SUBTOTAL(9, L3:L{{ $total + 2 }})</td>
	</tr>
</table>