<table>
	<thead>
		<tr>
			<th></th>
			<th>Avatar</th>
			<th>Last Name</th>
			<th>First Name</th>
			<th>Middle Name</th>
			<th>Date of Birth</th>
			<th>Place of Birth</th>
			<th>Religion</th>
			<th>Address</th>
			<th>Contact</th>
			<th>Provincial Address</th>
			<th>Contact</th>
			<th>Age</th>
			<th>Height</th>
			<th>Weight</th>
			<th>BMI</th>
			<th>Blood Type</th>
			<th>Civil Status</th>
			<th>TIN</th>
			<th>SSS</th>
			<th>Waistline</th>
			<th>Shoe Size</th>
		</tr>
	</thead>
	<tbody>
		@foreach($applicants as $index => $applicant)
			<tr>
				<td>{{ $index+1 }}</td>
				<td></td>
				<td>{{ $applicant->user->lname }}</td>
				<td>{{ $applicant->user->fname }}</td>
				<td>{{ $applicant->user->mname }}</td>
				<td>{{ $applicant->user->birthday->format('F j, Y') }}</td>
				<td>{{ $applicant->birth_place }}</td>
				<td>{{ $applicant->religion }}</td>
				<td>{{ $applicant->user->address }}</td>
				<td>{{ $applicant->user->contact }}</td>
				<td>{{ $applicant->provincial_address }}</td>
				<td>{{ $applicant->provincial_contact }}</td>
				<td>{{ $applicant->age }}</td>
				<td>{{ $applicant->height }}cm</td>
				<td>{{ $applicant->weight }}kg</td>
				<td>{{ $applicant->bmi }}</td>
				<td>{{ $applicant->blood_type }}</td>
				<td>{{ $applicant->civil_status }}</td>
				<td>{{ $applicant->tin }}</td>
				<td>{{ $applicant->sss }}</td>
				<td>{{ $applicant->waistline }}inch</td>
				<td>{{ $applicant->shoe_size }}cm</td>
			</tr>
		@endforeach
	</tbody>
</table>