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
			<td colspan="2">TOEI</td>
			<td>Presenter:</td>
			<td colspan="2">SOLPIA</td>
		</tr>

		<tr>
			<td colspan="7"></td>
		</tr>

		<tr>
			<td colspan="4"></td>
			<td>Date:</td>
			<td colspan="2">{{ now()->toFormattedDateString() }}</td>
		</tr>

		<tr>
			<td colspan="9"></td>
		</tr>

		<tr>
			<td>Code No.:</td>
			<td></td>
			<td>Rank:</td>
			<td>{{ isset($applicant->rank) ? $applicant->rank->name : 'N/A' }}</td>
			<td>Date Employed:</td>
			<td></td>
			<td>Vessel:</td>
			<td colspan="2">{{ isset($applicant->vessel) ? $applicant->vessel->name : 'N/A' }}</td>
		</tr>

		<tr>
			<td>Name</td>
			<td colspan="2">{{ $applicant->user->lname }}</td>
			<td colspan="2">{{ $applicant->user->fname }}</td>
			<td colspan="2">{{ $applicant->user->mname }}</td>
			<td colspan="2"></td>
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
			<td colspan="8">{{ $applicant->user->address }}</td>
			{{-- <td></td>
			<td colspan="2"></td> --}}
		</tr>

		<tr>
			<td></td>
			<td colspan="4"></td>
			<td>Email:</td>
			<td colspan="3">{{ $applicant->user->email }}</td>
		</tr>

		<tr>
			<td>Birth Date:</td>
			<td>{{ $applicant->user->birthday->toFormattedDateString() }}</td>
			<td>Age:</td>
			<td>{{ $applicant->age }}</td>
			<td>Birth Place:</td>
			<td colspan="2">{{ $applicant->birth_place }}</td>
			<td>Nationality:</td>
			<td>FILIPINO</td>
		</tr>

		<tr>
			<td>Civil Status:</td>
			<td colspan="2">{{ $applicant->civil_status }}</td>
			<td>Weight:</td>
			<td>{{ $applicant->weight }}kg</td>
			<td>Height:</td>
			<td>{{ $applicant->height }}cm</td>
			<td>Eye Color:</td>
			<td>(Eye Color)</td>
		</tr>

		<tr>
			<td>SSS No.:</td>
			<td colspan="2">{{ $applicant->sss }}</td>
			<td>Tin:</td>
			<td>{{ $applicant->tin }}</td>
			<td>Shoes Size:</td>
			<td>{{ $applicant->shoe_size }}cm</td>
			<td>Clothes Size:</td>
			<td>{{ $applicant->clothes_size }}</td>
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

		@php
			$realFam = $applicant->family_data[0];
			$hasWife = false;

			foreach($applicant->family_data as $fam){
				if($fam->type == "Spouse"){
					$hasWife = true;
					$realFam = $fam;
				}
			}
		@endphp

		<tr>
			<td colspan="5">Name and address of Wife / Nearest Relative</td>
			<td>Relation</td>
			<td colspan="3">{{ $realFam->type }}</td>
		</tr>

		<tr>
			<td>Name</td>
			{{-- <td colspan="8"></td> --}}
			<td colspan="2">{{ $applicant->user->lname }}</td>
			<td colspan="2">{{ $applicant->user->fname }}</td>
			<td colspan="2">{{ $applicant->user->mname }}</td>
			<td colspan="2"></td>
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
			<td colspan="8">{{ $realFam->address }}</td>
		</tr>

		<tr>
			<td></td>
			<td colspan="2"></td>
		</tr>

		<tr>
			<td colspan="5"></td>
			<td>E-mail:</td>
			<td colspan="3">(Email)</td>
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

		@php 
			$name = "NATIONAL LICENSE";
			$isset = isset($applicant->document_id->{$name});
			if($isset){
				$docu = $applicant->document_id->{$name};
			}
		@endphp

		<tr>
			<td colspan="2">National License</td>
			<td colspan="2"></td>
			<td>{{ $isset ? $docu->no : "N/A" }}</td>
			<td>{{ $isset ? $docu->issue_date->toFormattedDateString() : "N/A" }}</td>
			<td>{{ $isset ? $docu->issue_date->toFormattedDateString() : "N/A" }}</td>
			<td colspan="2">Philippines</td>
		</tr>

		@php 
			$name = "Panama (PA)";
			$isset = isset($applicant->document_flag->{$name});
			if($isset){
				$docu = $applicant->document_flag->{$name};
			}
		@endphp

		<tr>
			<td colspan="2">Flag License</td>
			<td colspan="2"></td>
			<td>{{ $isset ? $docu->license_no : "N/A" }}</td>
			<td>{{ $isset ? $docu->issue_date->format('M j, Y') : "N/A" }}</td>
			<td>{{ $isset ? $docu->expiry_date->format('M j, Y') : "N/A" }}</td>
			<td colspan="2">Panama</td>
		</tr>

		@php 
			$name = "Marshall Islands (MH)";
			$isset = isset($applicant->document_flag->{$name});
			if($isset){
				$docu = $applicant->document_flag->{$name};
			}
		@endphp

		<tr>
			<td colspan="2">Flag GOC</td>
			<td colspan="2"></td>
			<td>{{ $isset? $docu->goc : "N/A" }}</td>
			<td>{{ $isset ? $docu->issue_date->format('M j, Y') : "N/A" }}</td>
			<td>{{ $isset ? $docu->expiry_date->format('M j, Y') : "N/A" }}</td>
			<td colspan="2">Marshall Islands</td>
		</tr>

		@php 
			$name = "Panama (PA)";
			$isset = isset($applicant->document_flag->{$name});
			if($isset){
				$docu = $applicant->document_flag->{$name};
			}
		@endphp

		<tr>
			<td colspan="2">Flag SSO</td>
			<td colspan="2"></td>
			<td>{{ $isset ? $docu->sso : "N/A" }}</td>
			<td>{{ $isset ? $docu->issue_date->format('M j, Y') : "N/A" }}</td>
			<td>{{ $isset ? $docu->expiry_date->format('M j, Y') : "N/A" }}</td>
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
					'D.F.A',
					['PASSPORT', 'DFA'] //NAME IN DB, ISSUER
				],
				[
					'U.S. C1/D Visa',
					'U.S EMBASSY',
					['US-VISA', 'US EMBASSY']
				],
				[
					"National Seaman's Book",
					'MARINA',
					['NATIONAL SEAMAN BOOK', 'MARINA']
				],
				[
					"Seaman's Book/Panama",
					'PANAMA',
					['SEAMAN BOOK', 'PANAMA']

				],
				[
					"Australia MCV",
					"AUSTRALIA",
					['AUSTRALIA MCV', 'AUSTRALIA']
				],
				[
					"Japanese Visa",
					"in case of Master & C/E",
					['JAPANESE VISA', '']
				]
			];
		@endphp
		
		@foreach($array as $cert)

			@php 
				$name = $cert[2][0];
				$issuer = $cert[2][1];

				// FIND DOCUMENT WITH GIVEN NAME AND ISSUER
				$isset = isset($applicant->document_id->{$name}) && $applicant->document_id->{$name}->issuer == $issuer;

				// IF NO MATCH IN DOCUMENT ID, TRY IN DOCUMENT LC
				if($isset){
					$docu = $applicant->document_id->{$name};
				}
				else{
					$isset = isset($applicant->document_lc->{$name}) && $applicant->document_lc->{$name}->issuer == $issuer;
					if($isset){
						$docu = $applicant->document_lc->{$name};
					}
				}
			@endphp

			<tr>
				<td colspan="2">{{ $cert[0] }}</td>
				<td colspan="2"></td>
				<td>{{ isset($docu) ? $docu->number : 'N/A' }}</td>
				<td>{{ isset($docu) ? $docu->issue_date->format('M j, Y') : 'N/A' }}</td>
				<td>{{ isset($docu) ? $docu->expiry_date->format('M j, Y') : 'N/A' }}</td>
				<td colspan="2">{{ $cert[1] }}</td>
			</tr>

			@php
				unset($docu);
			@endphp
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

			@php 
				$name = $cert[0];

				$isset = isset($applicant->id->{$name});
				
				if($isset){
					$docu = $applicant->document_id->{$name};
				}
				else{
					$isset = isset($applicant->document_lc->{$name});
					if($isset){
						$docu = $applicant->document_lc->{$name};
					}
				}
			@endphp

			<tr>
				<td colspan="4">{{ $cert[0] }}</td>
				<td>
					@if($cert[1] == "")
						@if(isset($docu))
							{{ isset($docu) ? $docu->number : 'N/A' }}
						@endif
					@else
						{{ $cert[1] }}
					@endif
				</td>
				<td>{{ isset($docu) ? $docu->issue_date->format('M j, Y') : 'N/A' }}</td>
				<td>{{ isset($docu) ? $docu->expiry_date->format('M j, Y') : 'N/A' }}</td>
				<td colspan="2">
					{{ isset($docu) ? $docu->issuer : 'N/A' }}
				</td>
			</tr>
		@endforeach
	
		<tr>
			<td colspan="5">5. PHYSICAL INSPECTION/YELLOW CARD</td>
		</tr>

		<tr>
			<td colspan="4">CERTIFICATE</td>
			<td>Experience of Measles, Chicken Pox</td>
			<td>With Vaccine</td>
			<td>Date Issued</td>
			<td>Expiry Date</td>
			<td>Issued By</td>
		</tr>

		<tr>	
			<td colspan="4">PHYSICAL INSPECTION</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

		<tr>	
			<td colspan="4">YELLOW FEVER</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

		<tr>	
			<td colspan="4">MEASLES, MUMPS, RUBELLA (MMR)</td>
			<td>YES/NO</td>
			<td>YES/NO</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

		<tr>	
			<td colspan="4">Chicken Pox</td>
			<td>YES/NO</td>
			<td>YES/NO</td>
			<td></td>
			<td></td>
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

		<tr>
			<td colspan="2">8. ABILITY OF WELDING</td>
		</tr>

		<tr>
			<td colspan="2"></td>
			<td colspan="5">Class</td>
			<td colspan="2">Evaluation</td>
		</tr>

		<tr>
			<td colspan="2">ABILITY</td>
			<td>Excellent</td>
			<td>Good</td>
			<td>Acceptable</td>
			<td>Poor</td>
			<td>Unsuitable</td>
			<td colspan="2"></td>
		</tr>

		<tr>
			<td colspan="2">9. SEAMAN'S HISTORY</td>
		</tr>

		<tr>
			<td>Note:</td>
		</tr>

		<tr>
			<td colspan="9">Sea service (with in the last ten years) listed most recent service last.</td>
		</tr>
		<tr>
			<td colspan="9">1) Indicated wether vessel is M/V (Motor Vessel), S/S (Steam Ship) or S/T (Steam Turbine), etc.</td>
		</tr>
		<tr>
			<td colspan="9">2) Under TYPE indicate wether Bulk, Log, VLCC, Chemical LPG, PCC, Reefer, etc.</td>
		</tr>
		<tr>
			<td colspan="9">3) For Deck Officers / Ratings indicate Gross Tonnage of Vessel</td>
		</tr>
		<tr>
			<td colspan="9">4) For Engine Officers / Rating indicate Gross Tonnage and Engine Type (example:SULZER 7RTA62) with Horsepower.</td>
		</tr>

		<tr>
			<td colspan="2">Vessel's Name</td>
			<td>Type</td>
			<td>Gross Tonnage</td>
			<td>Service Area</td>
			<td>Manning</td>
			<td>Sign On</td>
			<td colspan="2">Reason Sign-Off/Notes</td>
		</tr>

		<tr>
			<td colspan="2">Flag</td>
			<td>Rank</td>
			<td colspan="2">Engine Type / Power</td>
			<td>Manager</td>
			<td>Sign Off</td>
			<td>Period(Y-M-D)</td>
			<td>SMC</td>
		</tr>

		@foreach($applicant->sea_service as $data)
			<tr>
				<td colspan="2">{{ $data->vessel_name }}</td>
				<td>{{ $data->vessel_type }}</td>
				<td>{{ $data->gross_tonnage }}</td>
				<td>(Service Area)</td>
				<td>{{ $data->manning_agent }}</td>
				<td>{{ $data->sign_on->format('M j, Y') }}</td>
				<td colspan="2">{{ $data->remarks }}</td>
			</tr>
			<tr>
				<td colspan="2">{{ $data->flag }}</td>
				<td>{{ $data->rank }}</td>
				<td colspan="2">{{ $data->engine_type }} / {{ $data->bhp_kw }}kw</td>
				<td>{{ $data->principal }}</td>
				<td>{{ $data->sign_off->format('M j, Y') }}</td>
				<td>(Period)</td>
				<td>(SMC)</td>
			</tr>
		@endforeach
		
		<tr></tr>

		<tr>
			<td colspan="2">Crew's Name:</td>
			<td colspan="3">{{ $applicant->user->fname . ' ' . $applicant->user->mname . ' ' . $applicant->user->lname }}</td>
			<td>Presenter:</td>
			<td colspan="3">JEFFREY PLANTA / CREWING MANAGER</td>
		</tr>
	</tbody>
</table>