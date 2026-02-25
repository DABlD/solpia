@php
	// dd($data);
@endphp

<table>
	<tr>
		<td>Vessel</td>
		<td>Rank</td>
		<td>Name</td>
		<td>SIRB NO</td>
		<td>SIRB Expiry</td>
		<td>USV Expiry</td>
	</tr>

	@foreach($data as $crew)
		@php
			$sirb = null;
			$usv = null;

			foreach($crew->applicant->document_id as $doc){
				if($doc->type == "SEAMAN'S BOOK"){
					$sirb = $doc;
				}
				elseif($doc->type == "US-VISA"){
					$usv = $doc;
				}
			}
		@endphp
		<tr>
			<td>{{ $vessel }}</td>
			<td>{{ $crew->rank->abbr }}</td>
			<td>{{ $crew->applicant->user->namefull }}</td>
			<td>{{ $sirb ? $sirb->number : "-" }}</td>
			<td>{{ $sirb ? ($sirb->expiry_date ? $sirb->expiry_date->format('d-M-Y') : "-") : "-" }}</td>
			<td>{{ $usv ? ($usv->expiry_date ? $usv->expiry_date->format('d-M-Y') : "-") : "-" }}</td>
		</tr>
	@endforeach
</table>