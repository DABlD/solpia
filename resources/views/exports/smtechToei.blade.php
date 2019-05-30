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
			<td colspan="3">1. EDUCATIONAL ATTAINMENT</td>
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
			<td colspan="2">2. LICENSES</td>
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

		<tr>
			<td colspan="2">3. CERTIFICATE</td>
		</tr>

		<tr>
			<td colspan="2">CERTIFICATE</td>
			<td colspan="2"></td>
			<td>Number</td>
			<td>Date Issued</td>
			<td>Expiry Date</td>
			<td colspan="2">Issued By</td>
		</tr>

		@php
			// CERTIFICATES
			$array = [
				[
					'Passport',
					'D.F.A'
				],
				[
					'U.S. C1/D Visa',
					'U.S EMBASSY'
				],
				[
					"National Seaman's Book",
					'MARINA'
				],
				[
					"Seaman's Book/Panama",
					'PANAMA'
				],
				[
					"Australia MCV",
					"AUSTRALIA"
				],
				[
					"Japanese Visa",
					"in case of Master & C/E"
				]
			];
		@endphp
		
		@foreach($array as $cert)
			<tr>
				<td colspan="2">{{ $cert[0] }}</td>
				<td colspan="2"></td>
				<td>
					@if($loop->last)
						N/A
					@endif
				</td>
				<td></td>
				<td></td>
				<td colspan="2">{{ $cert[1] }}</td>
			</tr>
		@endforeach
	
		<tr>
			<td colspan="5">4. OTHER CERTIFICATES (MARINA/SOLAS/MARPOL/OTHERS)</td>
		</tr>

		<tr>
			<td colspan="4">CERTIFICATE</td>
			<td>Number</td>
			<td>Date Issued</td>
			<td>Expiry Date</td>
			<td colspan="2">Issued By</td>
		</tr>

		@php
			// OTHER CERTIFICATES
			$array = [
				[
					'SSO (Ship Security Officer) Course',
					'',
					''
				],
				[
					'Watchkeeping',
					'',
					'P.R.C.'
				],
				[
					'Basic Safety Training Course  w/ PSSR',
					'',
					''
				],
				[
					'Survival Craft & Rescue Boat',
					'',
					''
				],
				[
					'Advance Fire Fighting Course',
					'',
					''
				],
				[
					'Medical First Aid Course',
					'',
					''
				],
				[
					'Radar Observer',
					'',
					''
				],
				[
					'GMDSS (GOC)',
					'',
					''
				],
				[
					'Satellite Communication Course',
					'',
					''
				],
				[
					'Endorsement Certificate / COC',
					'',
					'P.R.C.'
				],
				[
					'JRC ECDIS SPECIFIC 1',
					'JAN-701B/901B/2000',
					''
				],
				[
					'JRC ECDIS SPECIFIC 2',
					'JAN-9201/7201',
					''
				],
				[
					'FURUNO ECDIS FEA',
					'FEA-2107/FEA-2807',
					''
				],
				[
					'FURUNO ECDIS FMD',
					'FMD-3300',
					''
				],
				[
					'ECDIS GENERIC',
					'',
					''
				],
			];
		@endphp
		
		@foreach($array as $cert)
			<tr>
				<td colspan="4">{{ $cert[0] }}</td>
				<td>{{ $cert[1] }}</td>
				<td></td>
				<td></td>
				<td colspan="2">{{ $cert[2] }}</td>
			</tr>
		@endforeach
	
		<tr>
			<td colspan="5">5. PHYSICAL INSPECTION/YELLOW CARD</td>
		</tr>

		<tr>
			<td colspan="4">CERTIFICATE</td>
			<td>Number</td>
			<td>Date Issued</td>
			<td>Expiry Date</td>
			<td colspan="2">Issued By</td>
		</tr>

		<tr>	
			<td colspan="4" rowspan="2">PHYSICAL INSPECTION<br>YELLOW FEVER</td>
			<td></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
		</tr>

		<tr>
			<td></td>
		</tr>

		{{-- end --}}
		<tr>
			<td colspan="4">6. ENGLISH AND JAPANESE LINGUISTICS</td>
		</tr>

		<tr>
			<td colspan="2"></td>
			<td colspan="5">Class</td>
			<td>ENGLISH</td>
			<td>JAPANESE</td>
		</tr>

		@foreach(['READ & WRITE', 'SPEAK & LISTEN'] as $row)
			<tr>
				<td colspan="2">{{ $row }}</td>
				<td>Excellent</td>
				<td>Good</td>
				<td>Acceptable</td>
				<td>Poor</td>
				<td>Unsuitable</td>
				<td></td>
				<td></td>
			</tr>
		@endforeach

		<tr>
			<td colspan="5">7. TRAINING / EXPERIENCE FOR SAFETY MANAGEMENT SYSTEM</td>
		</tr>

		<tr>
			<td colspan="4">Type</td>
			<td>Date</td>
			<td colspan="2">Period</td>
			<td colspan="2">Evaluation</td>
		</tr>

		@foreach(['Training for SMS', 'Experience for SMS'] as $row)
			<tr>
				<td colspan="4">{{ $row }}</td>
				<td></td>
				<td colspan="2"></td>
				<td colspan="2"></td>
			</tr>
		@endforeach
	</tbody>
</table>