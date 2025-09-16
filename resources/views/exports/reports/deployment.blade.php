@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";

	$candidates = $data;
	$data = $data->groupBy('prospect.source');

	$getCount = function($source, $month) use($data){
		$count = 0;

		if(isset($data[$source])){
			foreach($data[$source] as $candidate){
				if($candidate->month == $month){
					$count++;
				}
			}
		}

		return $count;
	};
@endphp

<table>
	<tr>
		<td></td>
		<td colspan="16" style="height: 50px;"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="16" style="{{ $bc }} height: 25px; font-size: 16px;">Recruitment on line Portal</td>
	</tr>

	<tr>
		<td></td>
		<td style="{{ $c }}">No.</td>
		<td style="{{ $c }}">KPI Definition</td>
		<td style="{{ $c }}">Frequency</td>
		<td style="{{ $c }}">January</td>
		<td style="{{ $c }}">February</td>
		<td style="{{ $c }}">March</td>
		<td style="{{ $c }}">April</td>
		<td style="{{ $c }}">May</td>
		<td style="{{ $c }}">June</td>
		<td style="{{ $c }}">July</td>
		<td style="{{ $c }}">August</td>
		<td style="{{ $c }}">September</td>
		<td style="{{ $c }}">October</td>
		<td style="{{ $c }}">November</td>
		<td style="{{ $c }}">December</td>
		<td style="{{ $c }}">Total</td>

		<td></td>
		<td style="{{ $c }}">Source</td>
		<td style="{{ $c }}">Name</td>
		<td style="{{ $c }}">Rank</td>
		<td style="{{ $c }}">Vessel</td>
		<td style="{{ $c }}">Joining Date</td>
		<td style="{{ $c }}">Status</td>
	</tr>

	<tr>
		<td></td>
		<td>1</td>
		<td>Kalaw</td>
		<td>Monthly</td>
		<td>{{ $getCount('Kalaw', 'Jan') }}</td>
		<td>{{ $getCount('Kalaw', 'Feb') }}</td>
		<td>{{ $getCount('Kalaw', 'Mar') }}</td>
		<td>{{ $getCount('Kalaw', 'Apr') }}</td>
		<td>{{ $getCount('Kalaw', 'May') }}</td>
		<td>{{ $getCount('Kalaw', 'Jun') }}</td>
		<td>{{ $getCount('Kalaw', 'Jul') }}</td>
		<td>{{ $getCount('Kalaw', 'Aug') }}</td>
		<td>{{ $getCount('Kalaw', 'Sep') }}</td>
		<td>{{ $getCount('Kalaw', 'Oct') }}</td>
		<td>{{ $getCount('Kalaw', 'Nov') }}</td>
		<td>{{ $getCount('Kalaw', 'Dec') }}</td>
		<td>=SUM(E4:P4)</td>

		<td></td>
		<td style="{{ $c }}">{{ isset($candidates[0]) ? $candidates[0]->prospect->source : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[0]) ? $candidates[0]->prospect->name : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[0]) ? $candidates[0]->prospect->rank : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[0]) ? $candidates[0]->vessel->name : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[0]) ? $candidates[0]->requirement->joining_date->format('F j, Y') : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[0]) ? $candidates[0]->status : "" }}</td>
	</tr>

	<tr>
		<td></td>
		<td>2</td>
		<td>Online</td>
		<td>Monthly</td>
		<td>{{ $getCount('Online', 'Jan') }}</td>
		<td>{{ $getCount('Online', 'Feb') }}</td>
		<td>{{ $getCount('Online', 'Mar') }}</td>
		<td>{{ $getCount('Online', 'Apr') }}</td>
		<td>{{ $getCount('Online', 'May') }}</td>
		<td>{{ $getCount('Online', 'Jun') }}</td>
		<td>{{ $getCount('Online', 'Jul') }}</td>
		<td>{{ $getCount('Online', 'Aug') }}</td>
		<td>{{ $getCount('Online', 'Sep') }}</td>
		<td>{{ $getCount('Online', 'Oct') }}</td>
		<td>{{ $getCount('Online', 'Nov') }}</td>
		<td>{{ $getCount('Online', 'Dec') }}</td>
		<td>=SUM(E5:P5)</td>

		<td></td>
		<td style="{{ $c }}">{{ isset($candidates[1]) ? $candidates[1]->prospect->source : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[1]) ? $candidates[1]->prospect->name : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[1]) ? $candidates[1]->prospect->rank : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[1]) ? $candidates[1]->vessel->name : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[1]) ? $candidates[1]->requirement->joining_date->format('F j, Y') : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[1]) ? $candidates[1]->status : "" }}</td>
	</tr>

	<tr>
		<td></td>
		<td>3</td>
		<td>Walk-in</td>
		<td>Monthly</td>
		<td>{{ $getCount('Walk-in', 'Jan') }}</td>
		<td>{{ $getCount('Walk-in', 'Feb') }}</td>
		<td>{{ $getCount('Walk-in', 'Mar') }}</td>
		<td>{{ $getCount('Walk-in', 'Apr') }}</td>
		<td>{{ $getCount('Walk-in', 'May') }}</td>
		<td>{{ $getCount('Walk-in', 'Jun') }}</td>
		<td>{{ $getCount('Walk-in', 'Jul') }}</td>
		<td>{{ $getCount('Walk-in', 'Aug') }}</td>
		<td>{{ $getCount('Walk-in', 'Sep') }}</td>
		<td>{{ $getCount('Walk-in', 'Oct') }}</td>
		<td>{{ $getCount('Walk-in', 'Nov') }}</td>
		<td>{{ $getCount('Walk-in', 'Dec') }}</td>
		<td>=SUM(E6:P6)</td>

		<td></td>
		<td style="{{ $c }}">{{ isset($candidates[2]) ? $candidates[2]->prospect->source : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[2]) ? $candidates[2]->prospect->name : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[2]) ? $candidates[2]->prospect->rank : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[2]) ? $candidates[2]->vessel->name : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[2]) ? $candidates[2]->requirement->joining_date->format('F j, Y') : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[2]) ? $candidates[2]->status : "" }}</td>
	</tr>

	<tr>
		<td></td>
		<td>4</td>
		<td>Source</td>
		<td>Monthly</td>
		<td>{{ $getCount('Source', 'Jan') }}</td>
		<td>{{ $getCount('Source', 'Feb') }}</td>
		<td>{{ $getCount('Source', 'Mar') }}</td>
		<td>{{ $getCount('Source', 'Apr') }}</td>
		<td>{{ $getCount('Source', 'May') }}</td>
		<td>{{ $getCount('Source', 'Jun') }}</td>
		<td>{{ $getCount('Source', 'Jul') }}</td>
		<td>{{ $getCount('Source', 'Aug') }}</td>
		<td>{{ $getCount('Source', 'Sep') }}</td>
		<td>{{ $getCount('Source', 'Oct') }}</td>
		<td>{{ $getCount('Source', 'Nov') }}</td>
		<td>{{ $getCount('Source', 'Dec') }}</td>
		<td>=SUM(E7:P7)</td>

		<td></td>
		<td style="{{ $c }}">{{ isset($candidates[3]) ? $candidates[3]->prospect->source : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[3]) ? $candidates[3]->prospect->name : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[3]) ? $candidates[3]->prospect->rank : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[3]) ? $candidates[3]->vessel->name : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[4]) ? $candidates[4]->requirement->joining_date->format('F j, Y') : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[3]) ? $candidates[3]->status : "" }}</td>
	</tr>

	<tr>
		<td></td>
		<td>5</td>
		<td>No Label</td>
		<td>Monthly</td>
		<td>{{ $getCount('', 'Jan') }}</td>
		<td>{{ $getCount('', 'Feb') }}</td>
		<td>{{ $getCount('', 'Mar') }}</td>
		<td>{{ $getCount('', 'Apr') }}</td>
		<td>{{ $getCount('', 'May') }}</td>
		<td>{{ $getCount('', 'Jun') }}</td>
		<td>{{ $getCount('', 'Jul') }}</td>
		<td>{{ $getCount('', 'Aug') }}</td>
		<td>{{ $getCount('', 'Sep') }}</td>
		<td>{{ $getCount('', 'Oct') }}</td>
		<td>{{ $getCount('', 'Nov') }}</td>
		<td>{{ $getCount('', 'Dec') }}</td>
		<td>=SUM(E8:P8)</td>

		<td></td>
		<td style="{{ $c }}">{{ isset($candidates[4]) ? $candidates[4]->prospect->source : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[4]) ? $candidates[4]->prospect->name : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[4]) ? $candidates[4]->prospect->rank : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[4]) ? $candidates[4]->vessel->name : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[5]) ? $candidates[5]->requirement->joining_date->format('F j, Y') : "" }}</td>
		<td style="{{ $c }}">{{ isset($candidates[4]) ? $candidates[4]->status : "" }}</td>
	</tr>

	@for($i = 5; $i < sizeof($candidates); $i++)
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
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>

			<td></td>
			<td style="{{ $c }}">{{ isset($candidates[$i]) ? $candidates[$i]->prospect->source : "" }}</td>
			<td style="{{ $c }}">{{ isset($candidates[$i]) ? $candidates[$i]->prospect->name : "" }}</td>
			<td style="{{ $c }}">{{ isset($candidates[$i]) ? $candidates[$i]->prospect->rank : "" }}</td>
			<td style="{{ $c }}">{{ isset($candidates[$i]) ? $candidates[$i]->vessel->name : "" }}</td>
			<td style="{{ $c }}">{{ isset($candidates[$i]) ? $candidates[$i]->requirement->joining_date->format('F j, Y') : "" }}</td>
			<td style="{{ $c }}">{{ isset($candidates[$i]) ? $candidates[$i]->status : "" }}</td>
		</tr>
	@endfor

</table>