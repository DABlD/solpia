<table>
	<tbody>

		<tr>
			<td colspan="14">
				<h2>
					SOLPIA MARITIME AND SHIP MANAGEMENT INCORPORATED
				</h2>
			</td>
		</tr>
		<tr>
			<td colspan="14">
				<h4>
					APPLICATION FOR EMPLOYMENT
				</h4>
			</td>
		</tr>

		<tr>
			<td colspan="2">FIRST NAME</td>
			<td colspan="2">{{ $applicant->user->fname }}</td>
			<td colspan="2">BIRTHDAY</td>
			<td colspan="3">{{ $applicant->user->birthday->format('F j, Y') }}</td>
			<td colspan="1">GENDER</td>
			<td colspan="2">{{ $applicant->user->gender }}</td>
			<td colspan="2" rowspan="6"></td>
		</tr>

		<tr>
			<td colspan="2">MIDDLE NAME</td>
			<td colspan="2">{{ $applicant->user->mname }}</td>
			<td colspan="2">EMAIL</td>
			<td colspan="3">{{ $applicant->user->email }}</td>
			<td colspan="1">HEIGHT</td>
			<td colspan="1">{{ $applicant->height }}</td>
			<td colspan="1">CM</td>
		</tr>

		<tr>
			<td colspan="2">LAST NAME</td>
			<td colspan="2">{{ $applicant->user->lname }}</td>
			<td colspan="2">CONTACT</td>
			<td colspan="3">{{ $applicant->user->contact }}</td>
			<td colspan="1">WEIGHT</td>
			<td colspan="1">{{ $applicant->weight }}</td>
			<td colspan="1">KG</td>
		</tr>

		<tr>
			<td colspan="3">ADDRESS</td>
			<td colspan="9">{{ $applicant->user->address }}</td>
		</tr>

		<tr>
			<td colspan="3">PROVINCIAL ADDRESS</td>
			<td colspan="9">{{ $applicant->provincial_address }}</td>
		</tr>

		<tr>
			<td colspan="3">PROVINCIAL CONTACT NO.</td>
			<td colspan="3">{{ $applicant->provincial_contact }}</td>
			<td colspan="6"></td>
		</tr>

	</tbody>
</table>