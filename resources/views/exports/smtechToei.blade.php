<table>
	<tbody>
		<tr>
			<td colspan="7"></td>
			<td colspan="2">CHECKED BY</td>
		</tr>

		<tr>
			<td colspan="2" rowspan="8"></td>
			<td></td>
			<td colspan="3">BIO-DATA</td>
			<td></td>
			<td></td>
			<td>INCHARGE</td>
		</tr>

		<tr>
			<td colspan="5"></td>
			<td rowspan="3"></td>
			<td rowspan="3"></td>
		</tr>

		<tr>
			<td colspan="5"></td>
		</tr>

		<tr>
			<td colspan="5"></td>
		</tr>

		<tr>
			<td colspan="7"></td>
		</tr>

		<tr>
			<td colspan="2">Manning Agent:</td>
			<td colspan="2"></td>
			<td>Presenter:</td>
			<td colspan="2">SOLPIA</td>
		</tr>

		<tr>
			<td colspan="7"></td>
		</tr>

		<tr>
			<td colspan="4"></td>
			<td>Date:</td>
			<td colspan="2"></td>
		</tr>

		<tr>
			<td colspan="9"></td>
		</tr>

		<tr>
			<td>Code No.:</td>
			<td></td>
			<td>Rank:</td>
			<td></td>
			<td>Date Employed:</td>
			<td></td>
			<td>Vessel:</td>
			<td colspan="2"></td>
		</tr>

		<tr>
			<td>Name</td>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td></td>
			<td colspan="2">(Surname)</td>
			<td colspan="2">(Given Name)</td>
			<td colspan="2">(Middle Name)</td>
			<td colspan="2">(Chinese Character)</td>
		</tr>

		<tr>
			<td>Address:</td>
			<td colspan="5"></td>
			<td></td>
			<td colspan="2"></td>
		</tr>

		<tr>
			<td></td>
			<td colspan="5"></td>
			<td>Email:</td>
			<td colspan="2"></td>
		</tr>

		<tr>
			<td>Birth Date:</td>
			<td></td>
			<td>Age:</td>
			<td></td>
			<td>Birth Place:</td>
			<td colspan="2"></td>
			<td>Nationality:</td>
			<td></td>
		</tr>

		<tr>
			<td>Civil Status:</td>
			<td colspan="2"></td>
			<td>Weight:</td>
			<td>kg</td>
			<td>Height:</td>
			<td>cm</td>
			<td>Eye Color:</td>
			<td></td>
		</tr>

		<tr>
			<td>SSS No.:</td>
			<td colspan="2"></td>
			<td>Tin:</td>
			<td>kg</td>
			<td>Shoes Size:</td>
			<td>cm</td>
			<td>Clothes Size:</td>
			<td></td>
		</tr>

		<tr>
			<td colspan="4">Crew's physical condition</td>
			<td>Diabetes</td>
			<td></td>
			<td></td>
			<td>Choleith</td>
			<td></td>
		</tr>

		<tr>
			<td></td>
			<td colspan="2">High/Low blood pressure</td>
			<td colspan="2"></td>
			<td colspan="2">Renal Insufficiency</td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td colspan="5">Name and address of Wife / Nearest Relative</td>
			<td>Relation</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td>Name</td>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td></td>
			<td colspan="2">(Surname)</td>
			<td colspan="2">(Given Name)</td>
			<td colspan="2">(Middle Name)</td>
			<td colspan="2">(Number of Child)</td>
		</tr>

		<tr>
			<td>Adress:</td>
			<td colspan="5"></td>
		</tr>

		<tr>
			<td></td>
			<td colspan="2"></td>
		</tr>

		<tr>
			<td colspan="5"></td>
			<td>E-mail:</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="3">1. Educational Attainment</td>
		</tr>

		<tr>
			<td colspan="2">Year</td>
			<td colspan="4">School</td>
			<td colspan="3">Course Finished</td>
		</tr>

		@foreach($applicant->educational_background as $data)
			{{-- @if($data->course != "") --}}
				<tr>
					<td>{{ explode('-', $data->year)[0] }}</td>
					<td>{{ explode('-', $data->year)[1] }}</td>
					<td colspan="4">{{ $data->school }}</td>
					<td colspan="3">{{ $data->course }}</td>
				</tr>
			{{-- @endif --}}
		@endforeach

		<tr>
			<td colspan="2">2. Licenses</td>
		</tr>

		<tr>
			<td colspan="2">LICENSE</td>
			<td colspan="2">RANK</td>
			<td>Number</td>
			<td>Date Issued</td>
			<td>Expiry Date</td>
			<td colspan="2">Issued By</td>
		</tr>

		<tr>
			<td colspan="2">National License</td>
			<td colspan="2"></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="2">Philippines</td>
		</tr>

		<tr>
			<td colspan="2">Flag License</td>
			<td colspan="2"></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="2">Panama</td>
		</tr>

		<tr>
			<td colspan="2">Flag GOC</td>
			<td colspan="2"></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="2">Marshall Islands</td>
		</tr>

		<tr>
			<td colspan="2">Flag SSO</td>
			<td colspan="2"></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="2">Panama</td>
		</tr>
	</tbody>
</table>