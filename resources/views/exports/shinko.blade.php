
<table>
	<tbody>
		<tr>
			<td colspan="14">
				<h2>SHINKO MARITIME CO., LTD.</h2>
			</td>
		</tr>

		<tr>
			<td colspan="14">
				<h3>APPLICATION FOR EMPLOYMENT</h3>
			</td>
		</tr>

		<tr>
			<td rowspan="4" colspan="7"></td>
			<td rowspan="4" colspan="2">Name in Chinese</td>
			<td rowspan="4" colspan="2">{{-- FILL --}}</td>
			<td rowspan="8" colspan="3"></td>
		</tr>

		<tr></tr>
		<tr></tr>
		<tr></tr>

		<tr>
			<td colspan="2">Ship's Name</td>
			<td colspan="4">{{-- FILL --}}</td>

			<td colspan="2">Rank</td>
			<td colspan="3">{{-- FILL --}}</td>
		</tr>

		<tr>
			<td colspan="2">Family Name</td>
			<td colspan="4">{{ $applicant->user->lname }}</td>

			<td colspan="2">Birth Date</td>
			<td colspan="3">{{ $applicant->user->birthday->format('F j, Y') }}</td>
		</tr>

		<tr>
			<td colspan="2">First Name</td>
			<td colspan="4">{{ $applicant->user->fname }}</td>

			<td colspan="2">Height</td>
			<td colspan="2">{{ $applicant->height }}</td>
			<td>cm</td>
		</tr>

		<tr>
			<td colspan="2">Middle Name</td>
			<td colspan="4">{{ $applicant->user->mname }}</td>

			<td colspan="2">Weight</td>
			<td colspan="2">{{ $applicant->weight }}</td>
			<td>kg</td>
		</tr>

		<tr>
			<td colspan="7">BASIC DOCUMENTATION</td>
			<td colspan="7">ADDRESS AND PARTICULAR</td>
		</tr>
	</tbody>
</table>