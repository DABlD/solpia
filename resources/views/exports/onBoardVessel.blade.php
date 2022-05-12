@php
	function verifyDate($date){
		return $date ? $date->format('d-M-y') : '---';
	}
@endphp

<table>
	<tr>
		<td colspan="15"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="3">M/V {{ $filename }}</td>
	</tr>

	<tr>
		<td></td>
		<td>No.</td>
		<td>Rank</td>
		<td>Name</td>
		<td>Age</td>
		<td>Date Joined</td>
		<td>MOB</td>
		<td>Contract Duration</td>
		<td>End of Contract</td>
		<td>Passport Exp.</td>
		<td>Sbook Exp.</td>
		<td>US Visa Exp.</td>
		<td>Joining Port</td>
		<td>Reliever</td>
		<td>Remarks</td>
	</tr>

	@foreach($data as $crew)
		<tr>
			<td></td>
			<td>{{ $loop->iteration }}</td>
			<td>{{ $crew->abbr }}</td>
			<td>{{ $crew->lname . ', ' . $crew->fname . ' ' . ($crew->suffix ?? "") . ' ' . $crew->mname }}</td>
			<td>{{ $crew->age }}</td>
			<td>{{ $crew->joining_date->format('d-M-y') }}</td>
			<td>{{ $crew->joining_date->diffInMonths(now()) }}</td>
			<td>{{ $crew->months }}</td>
			<td>{{ $crew->joining_date->addMonths($crew->months)->format('d-M-y') }}</td>
			<td>{{ verifyDate($crew->{"PASSPORT"}) }}</td>
			<td>{{ verifyDate($crew->{"SEAMAN'S BOOK"}) }}</td>
			<td>{{ verifyDate($crew->{"US-VISA"}) }}</td>
			<td>{{ $crew->joining_port }}</td>
			<td>{{ $crew->reliever }}</td>
			<td>
				@php
					$remarks = json_decode($crew->remarks);
					foreach ($remarks as $key => $remark) {
						if($key > 0){
							echo ', ';
						}
						echo $remark;
					}
				@endphp
			</td>
		</tr>
	@endforeach
</table>