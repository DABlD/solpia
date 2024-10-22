@php
	$row = function ($title, $numRows, $rows){
		$string = "";

		foreach($rows as $key => $item){
			$string .= "<tr>";

			if($key == 0){
				$string .= "<td rowspan='$numRows'>$title</td>";
			}

			$string .= "
				<td colspan='4'>$item[0]</td>
				<td>$item[1]</td>
				<td></td>
				<td></td>
				<td></td>
			";

			$string .= "</tr>";
		}

		echo $string;
	}
@endphp

<table>
	<tr>
		<td colspan="9" style="text-align: right; height: 30px;">FORM SP08-05(1/1)/2/24.10.01</td>
	</tr>

	<tr>
		<td colspan="9" style="font-size: 16px;">Interview Check List for Seafarer</td>
	</tr>

	<tr>
		<td colspan="2">Vessel Name</td>
		<td colspan="2">{{ isset($data->vessel) ? $data->vessel->name : "-" }}</td>
		<td colspan="2">Rank</td>
		<td colspan="2">{{ isset($data->rank) ? $data->rank->abbr : '-' }}</td>
		<td>Date of Interview</td>
	</tr>

	<tr>
		<td colspan="2">Name</td>
		<td colspan="2">{{ $data->user->namefull }}</td>
		<td colspan="2">Date of Birth</td>
		<td colspan="2">{{ isset($data->user->birthday) ? $data->user->birthday->format('M j, Y') : "-" }}</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="5" rowspan="2">Evaluation Item</td>
		<td rowspan="2">Score</td>
		<td colspan="2">Score</td>
		<td rowspan="2">Remark</td>
	</tr>

	<tr>
		<td>1st</td>
		<td>2nd</td>
	</tr>

	{{-- TITLE, # OF ROWS, ITEMS --}}
	{{ $row("Document (40)", 5, [
			["Onboard Career", 30], 
			["Own will disembarkation", 5],
			["Number of change company",5],
			["Non-board period",5],
			["Age",5],
		]) }}

	{{ $row("Interview (60)", 8, [
			["Knowledge",5],
			["Judgement",5],
			["Foreign language expression / Expressiveness",5],
			["Responsibility / Diligence",5],
			["Cooperation",5],
			["Initiative",5],
			["Qualification to perform task <br style='mso-data-placement:same-cell;' /> (Appearance or medical test result)",10],
			["Family relationship, personal history",10]
		]) }}

	<tr>
		<td colspan="5">Total Score</td>
		<td>100</td>	
		<td>=SUM(G8:G20)</td>	
		<td>=SUM(H8:H20)</td>	
		<td></td>	
	</tr>

	<tr>
		<td colspan="9">※ Refer to the evaluation criteria and reflect them in the first and second evaluation scores.</td>
	</tr>

	<tr>
		<td colspan="3">Smoking</td>
		<td colspan="2"></td>
		<td colspan="3">Alcohol</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">Document Preparation</td>
		<td colspan="2"></td>
		<td colspan="3">USA Visa</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">Status of legal education</td>
		<td colspan="2"></td>
		<td colspan="3">Available date for boarding</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="9" style="height: 5px;"></td>
	</tr>

	<tr>
		<td colspan="3">Comments</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td rowspan="2">
			1st
			<br style='mso-data-placement:same-cell;' />
			(Manning)
		</td>
		<td colspan="2">Rank/Name</td>
		<td colspan="2"></td>
		<td rowspan="2">
			2nd
			<br style='mso-data-placement:same-cell;' />
			(Manning)
		</td>
		<td colspan="2">Rank/Name</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="2">Sign</td>
		<td colspan="2" style="text-align: right;">(sign)</td>
		<td colspan="2">Sign</td>
		<td style="text-align: right;">(sign)</td>
	</tr>

	<tr>
		<td colspan="3">Recruitment Status</td>
		<td colspan="2"></td>
		<td colspan="3">Approved by DP</td>
		<td style="text-align: right;">(sign)</td>
	</tr>
</table>