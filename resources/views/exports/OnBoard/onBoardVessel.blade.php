@php
	function verifyDate($date){
		return $date ? $date->format('d-M-y') : '---';
	}

	$cleanText = function($text){
		return str_replace('&', '&#38;', $text);
	};
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
		@php
			$cd = $crew->months;
			$cd2 = $crew->months;

			if($crew->extensions){
				$tempExt = json_decode($crew->extensions);
				foreach($tempExt as $ext){
					$cd = $cd . "+$ext";
					$cd2 += (int)$ext;
				}
			}

			$dd = now()->parse($crew->joining_date)->add($cd2, 'months');
		@endphp
		<tr>
			<td></td>
			<td>{{ $loop->iteration }}</td>
			<td>{{ $crew->abbr }}</td>
			<td>{{ $cleanText($crew->lname . ', ' . $crew->fname . ' ' . ($crew->suffix ?? "") . ' ' . $crew->mname) }}</td>
			<td>{{ $crew->age }}</td>
			<td>{{ $crew->joining_date->format('d-M-y') }}</td>
			<td>{{ $crew->joining_date->diffInMonths(now()) }}</td>
			<td>{{ $cd }}</td>
			<td>{{ $dd->format('d-M-y') }}</td>
			<td>{{ verifyDate($crew->{"PASSPORT"}) }}</td>
			<td>{{ verifyDate($crew->{"SEAMAN'S BOOK"}) }}</td>
			<td>{{ verifyDate($crew->{"US-VISA"}) }}</td>
			<td>{{ $cleanText($crew->joining_port) }}</td>
			<td>{{ $cleanText($crew->reliever) }}</td>
			<td>
				@php
					$remarks = json_decode($crew->remarks);
					foreach ($remarks as $key => $remark) {
						if($key > 0){
							echo ', ';
						}
						echo $cleanText($remark);
					}
				@endphp
			</td>
		</tr>

	@endforeach
</table>