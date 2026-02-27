@php
	// dd($data)
@endphp

<table>
	<tr>
		<td>#</td>
		<td>Rank</td>
		<td>Name</td>
		<td>Source</td>
		<td>Status</td>
		<td>Date</td>
		<td>Remarks</td>
	</tr>

	@foreach($data as $candidate)
		<tr>
			<td>{{ $loop->index+1 }}</td>
			<td>{{ $candidate->prospect->rank }}</td>
			<td>{{ $candidate->prospect->name }}</td>
			<td>{{ $candidate->prospect->source }}</td>
			<td>{{ $candidate->status }}</td>
			<td>{{ $candidate->created_at->format('M j, Y') }}</td>
			<td>{{ $candidate->remarks }}</td>
		</tr>
	@endforeach
</table>