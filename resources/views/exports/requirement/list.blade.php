@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";

	$steps = [
	    'initial_interview',
	    'written_assessment',
	    'technical_interview',
	    'endorsed_to_crewing',
	    'principals_approval',
	    'medical',
	    'on_board',
	];
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
		<td>Deadline</td>
		<td>Fleet</td>
		<td>Prospect</td>
		<td>Remarks</td>
	</tr>

	@foreach($data as $req)
		<tr>
			<td>{{ $req->id }}</td>
			<td>{{ isset($req->vessel) ? $req->vessel->name : "---" }}</td>
			<td>{{ isset($req->vessel) ? $req->vessel->type : "---" }}</td>
			<td>{{ $req->rank2->abbr ?? "-" }}</td>
			<td>{{ $req->joining_date ? $req->joining_date->format('Y-m-d') : "-" }}</td>
			<td>{{ $req->joining_port }}</td>
			<td>{{ $req->usv ? "Required" : "---" }}</td>
			<td>{{ $req->max_age }}</td>
			<td>{{ $req->status }}</td>
			<td>{{ $req->created_at->format('Y-m-d') }}</td>
			<td>{{ $req->deadline ? $req->deadline->format('Y-m-d') : "-" }}</td>
			<td>{{ $req->fleet }}</td>
			{{-- <td>{{ sizeof($req->candidates) }}</td> --}}
			<td>
				@foreach($req->candidates as $candidate)
					@php
						$latestStep = "Pending";

					    for ($i = count($steps) - 1; $i >= 0; $i--) {

					        $step = $steps[$i];

					        if ($candidate->$step == 1) {
					            $latestStep = $step;
					            break;
					        }
					    }
					@endphp

					&#8226; {{ $candidate->prospect->name }} - {{ $candidate->on_board ? "Onboard" : $latestStep }}
					@if(!$loop->last)
						<br>
					@endif
					{!! $candidate->remarks ? "<br>" . $candidate->remarks : "" !!}
				@endforeach
			</td>
			<td>
				{{ $req->remarks }}
			</td>
		</tr>
	@endforeach
</table>