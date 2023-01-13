@php
	$nbg = "background-color: #DADEDD;";
	$gbg = "background-color: #E2EFDA;";

	$navy = "color: 0B333C;";
	$blue = "color: 0000FF;";

	$b = "font-weight: bold;";
	$c = "text-align: center;";

	$bl = "border-left: 4px solid black;";
	$br = "border-right: 4px solid black;";
@endphp

<table>
	<tr>
		<td colspan="16" style="{{ $b }} height: 30px; font-size: 20px;">CREW REPLACEMENT PLAN</td>
	</tr>

	{{-- HEADER --}}
	<tr>
		<td rowspan="2" style="{{ $nbg }} {{ $navy }} {{ $c }}">VESSEL</td>
		<td rowspan="2" style="{{ $nbg }} {{ $navy }} {{ $c }}">RANK</td>
		<td colspan="5" style="{{ $nbg }} {{ $navy }} {{ $c }}">OFF-SIGNER</td>
		<td colspan="4" style="{{ $nbg }} {{ $navy }} {{ $c }}">ON-SIGNER</td>
		<td rowspan="2" style="{{ $nbg }} {{ $navy }} {{ $c }}">REMARK</td>
		<td rowspan="2" style="{{ $nbg }} {{ $navy }} {{ $c }}">PORT</td>
		<td rowspan="2" style="{{ $nbg }} {{ $navy }} {{ $c }}">FLAG</td>
		<td rowspan="2" style="{{ $nbg }} {{ $navy }} {{ $c }}">CRM</td>
		<td rowspan="2" style="{{ $nbg }} {{ $navy }} {{ $c }}">MRM</td>
	</tr>

	<tr>
		<td style="{{ $nbg }} {{ $navy }} {{ $c }}">NAME</td>
		<td style="{{ $nbg }} {{ $navy }} {{ $c }}">AGENT</td>
		<td style="{{ $nbg }} {{ $navy }} {{ $c }}">DATE</td>
		<td style="{{ $nbg }} {{ $navy }} {{ $c }}">REASON</td>
		<td style="{{ $nbg }} {{ $navy }} {{ $c }}">REMARK</td>
		<td style="{{ $nbg }} {{ $navy }} {{ $c }}">NAME</td>
		<td style="{{ $nbg }} {{ $navy }} {{ $c }}">AGENT</td>
		<td style="{{ $nbg }} {{ $navy }} {{ $c }}">DATE</td>
		<td style="{{ $nbg }} {{ $navy }} {{ $c }}">REMARK</td>
	</tr>

	@foreach($ids as $id)
		@php
			$flag = null;
		@endphp
		{{-- ROW --}}

		{{-- COLS --}}
		@if(isset($off[$id]))
			@foreach($off[$id] as $crew)
				<tr>
				@php
					$flag == null ? $flag = $crew->vessel->flag : null;

					if($flag == "MARSHALL ISLAND"){
						$flag = "MARSHALL";
					}
				@endphp
				<td style="{{ $c }} {{ $gbg }} {{ $bl }}">{{ $crew->vessel->name }}</td>
				<td style="{{ $c }}">{{ $crew->rank->abbr }}</td>
				<td>{{ $crew->applicant->user->namefull }}</td>
				<td style="{{ $c }}">SOLPIA</td>
				<td style="{{ $c }}"></td>
				<td style="{{ $c }}"></td>
				<td style="{{ $c }}"></td>

				@if($crew->pa_reliever)
					<td>{{ $crew->pa_reliever->applicant->user->namefull }}</td>
					<td style="{{ $c }}">SOLPIA</td>
					<td style="{{ $c }} {{ $blue }}">{{ $crew->pa_reliever->eld ? now()->parse($crew->pa_reliever->eld)->format('Y-m-d') : "-" }}</td>
					{{-- <td style="{{ $c }} {{ $blue }}">{{ $crew->pa_reliever->eld ? $crew->pa_reliever->eld : "-" }}</td> --}}
					<td style="{{ $c }}"></td>
				@else
					<td></td>
					<td style="{{ $c }}"></td>
					<td style="{{ $c }} {{ $blue }}"></td>
					<td style="{{ $c }}"></td>
				@endif

				<td></td>
				<td style="{{ $c }} {{ $gbg }}"></td>
				<td style="{{ $c }}">{{ $flag }}</td>
				<td style="{{ $c }}">김보경</td>
				<td style="{{ $c }} {{ $br }}">김상태</td>
				</tr>
			@endforeach
		@endif

		@if(isset($on[$id]))
			@php
				$flag == null ? $flag = $crew->vessel->flag : null;

				if($flag == "MARSHALL ISLAND"){
					$flag = "MARSHALL";
				}
			@endphp
			@foreach($on[$id] as $crew)
				<tr>
				<td style="{{ $c }} {{ $gbg }} {{ $bl }}">{{ $crew->vessel->name }}</td>
				<td style="{{ $c }}">{{ $crew->rank->abbr }}</td>
				<td></td>
				<td style="{{ $c }}"></td>
				<td style="{{ $c }}"></td>
				<td style="{{ $c }}"></td>
				<td style="{{ $c }}"></td>

				<td>{{ $crew->applicant->user->namefull }}</td>
				<td style="{{ $c }}">SOLPIA</td>
				<td style="{{ $c }} {{ $blue }}">{{ $crew->eld ? now()->parse($crew->eld)->format('Y-m-d') : "-" }}</td>
				<td style="{{ $c }}"></td>

				<td></td>
				<td style="{{ $c }} {{ $gbg }}"></td>
				<td style="{{ $c }}">{{ $flag }}</td>
				<td style="{{ $c }}">김보경</td>
				<td style="{{ $c }} {{ $br }}">김상태</td>
				</tr>
			@endforeach
		@endif

	    <tr>
	    	<td style="height: 1px; border: 4px solid black;"></td>
	    	<td style="height: 1px; border: 4px solid black;"></td>
	    	<td style="height: 1px; border: 4px solid black;"></td>
	    	<td style="height: 1px; border: 4px solid black;"></td>
	    	<td style="height: 1px; border: 4px solid black;"></td>
	    	<td style="height: 1px; border: 4px solid black;"></td>
	    	<td style="height: 1px; border: 4px solid black;"></td>
	    	<td style="height: 1px; border: 4px solid black;"></td>
	    	<td style="height: 1px; border: 4px solid black;"></td>
	    	<td style="height: 1px; border: 4px solid black;"></td>
	    	<td style="height: 1px; border: 4px solid black;"></td>
	    	<td style="height: 1px; border: 4px solid black;"></td>
	    	<td style="height: 1px; border: 4px solid black;"></td>
	    	<td style="height: 1px; border: 4px solid black;"></td>
	    	<td style="height: 1px; border: 4px solid black;"></td>
	    	<td style="height: 1px; border: 4px solid black;"></td>
	    </tr>
	@endforeach
</table>