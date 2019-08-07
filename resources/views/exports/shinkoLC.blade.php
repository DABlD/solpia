
<table>
	<tbody>
		<tr>
			<td colspan="14">
				SHINKO MARITIME CO., LTD.
			</td>
		</tr>

		<tr>
			<td colspan="14">
				APPLICATION FOR EMPLOYMENT
			</td>
		</tr>

		<tr>
			<td colspan="3">
				FOR FOREIGN
			</td>
		</tr>

		<tr>
			<td colspan="4">*  Please complete only bolded</td>
		</tr>

		<tr></tr>

		{{-- START ROWS --}}
		<tr>
			<td colspan="2">Ship's Name</td>
			<td colspan="3">
				{{ isset($applicant->vessel) ? $applicant->vessel->name : 'N/A' }}
			</td>
			<td colspan="5">Rank</td>
			<td colspan="4">
				{{ isset($applicant->rank) ? $applicant->rank->abbr : 'N/A' }}
			</td>
		</tr>

		<tr>
			<td colspan="2">Family Name</td>
			<td colspan="3">{{ $applicant->user->lname }}</td>
			<td colspan="5">Last School</td>
			<td colspan="4">{{ $applicant->educational_background->last()->school }}</td>
		</tr>

		<tr>
			<td colspan="2">First Name</td>
			<td colspan="3">{{ $applicant->user->fname . ' ' . $applicant->user->suffix }}</td>
			<td colspan="5">Course</td>
			<td colspan="4">{{ $applicant->educational_background->last()->course }}</td>
		</tr>

		<tr>
			<td colspan="2">Middle Name</td>
			<td colspan="3">{{ $applicant->user->mname }}</td>
			<td colspan="5">Duration</td>
			<td colspan="4">{{ $applicant->educational_background->last()->year }}</td>
		</tr>

		<tr>
			<td colspan="2">Birth Date</td>
			<td colspan="3">{{ $applicant->user->birthday->format('F j, Y') }}</td>
			<td colspan="5">Height/Weight</td>
			<td colspan="4">{{ $applicant->height }}cm / {{ $applicant->weight }}kg</td>
		</tr>

		<tr>
			<td colspan="2">Telephone</td>
			<td colspan="3">{{ $applicant->user->contact }}</td>
			<td colspan="5">Civil Status</td>
			<td colspan="4">{{ $applicant->civil_status }}</td>
		</tr>

		<tr>
			<td colspan="4">*  Check appearance of applicant</td>
		</tr>

		{{-- 2ND --}}
		<tr>
			<td colspan="2" rowspan="3">Items</td>
			<td colspan="3" rowspan="3">Checkpoint</td>
			<td colspan="5">Evaluation</td>
			<td colspan="4" rowspan="3">Remarks</td>
		</tr>

		<tr>
			<td>A</td>
			<td>B</td>
			<td>C</td>
			<td>D</td>
			<td>E</td>
		</tr>

		<tr>
			<td>10</td>
			<td>8</td>
			<td>6</td>
			<td>4</td>
			<td>2</td>
		</tr>
		
		<tr>
			<td colspan="14">1. Personal Qualification</td>
		</tr>

		<tr>
			<td colspan="2">Working</td>
			<td colspan="3">Satisfaction, Planning</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="4"></td>
		</tr>

		<tr>
			<td colspan="2">Adaptation</td>
			<td colspan="3">Responsibility, Patience</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="4"></td>
		</tr>

		<tr>
			<td colspan="2">Carrier</td>
			<td colspan="3">Shifting Co., Service Length</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="4"></td>
		</tr>

		<tr>
			<td colspan="2">English</td>
			<td colspan="3">hearing, speaking, reading, writing</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="4"></td>
		</tr>

		<tr>
			<td colspan="14">2. Personal Particulars</td>
		</tr>

		<tr>
			<td colspan="2">Appearance</td>
			<td colspan="3">Posture, Expression</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="4"></td>
		</tr>

		<tr>
			<td colspan="2">Family life</td>
			<td colspan="3">Status, Growing process</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="4"></td>
		</tr>

		<tr>
			<td colspan="2">Social life</td>
			<td colspan="3">Social activity andCarrier</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="4"></td>
		</tr>

		<tr>
			<td colspan="2">Ambition</td>
			<td colspan="3">Positiveness, Confidence</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="4"></td>
		</tr>

		<tr>
			<td colspan="2">Knowledge</td>
			<td colspan="3">Technical, Skill, Carrier</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="4"></td>
		</tr>

		<tr>
			<td colspan="2">Sociality</td>
			<td colspan="3">Courtesy, Self-control</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="4"></td>
		</tr>

		<tr>
			<td colspan="14">3. Identification of Carrier</td>
		</tr>

		@php
			$isset = true;
			if($applicant->sea_service->count() == 0){
				$isset = false;
			}
		@endphp

		<tr>
			<td colspan="2">Last Company</td>
			<td colspan="3">{{ $isset ? $applicant->sea_service->last()->principal : 'N/A' }}</td>
			<td colspan="5">Serve Period</td>
			<td colspan="4">
				{{ $isset ? ($applicant->sea_service->last()->sign_on->format('M j, Y') . '-' . $applicant->sea_service->last()->sign_off->format('M j, Y')) : 'N/A' }}
			</td>
		</tr>

		<tr>
			<td colspan="2">Last Rank</td>
			<td colspan="3">{{ $isset ? $applicant->sea_service->last()->rank : 'N/A' }}</td>
			<td colspan="5">Last Carrier</td>
			<td colspan="4">{{ $isset ? $applicant->sea_service->last()->vessel_name : 'N/A' }}</td>
		</tr>

		<tr>
			<td colspan="2">Own Disembark</td>
			<td colspan="3"></td>
			<td colspan="5">Reward/Punish</td>
			<td colspan="4"></td>
		</tr>

		<tr>
			<td colspan="14">4. Recommender</td>
		</tr>

		<tr>
			<td colspan="2">Section</td>
			<td colspan="3"></td>
			<td colspan="5">Rank/Name</td>
			<td colspan="4"></td>
		</tr>

		<tr>
			<td colspan="14">5. Health Condition</td>
		</tr>

		<tr>
			<td colspan="2">Family History</td>
			<td colspan="3"></td>
			<td colspan="5">Remark</td>
			<td colspan="4"></td>
		</tr>

		<tr>
			<td colspan="2">Chronic Disease</td>
			<td colspan="3"></td>
			<td colspan="5">Remark</td>
			<td colspan="4"></td>
		</tr>

		<tr>
			<td colspan="14">6. General Remark</td>
		</tr>

		<tr>
			<td colspan="14" rowspan="3"></td>
		</tr>

		<tr></tr>
		<tr></tr>

		<tr>
			<td colspan="14">7. Result (for Item 1 through item 3)</td>
		</tr>

		<tr>
			<td colspan="14" rowspan="3"></td>
		</tr>

		<tr></tr>
		<tr></tr>

		<tr>
			<td colspan="14">8. Result</td>
		</tr>

		<tr>
			<td colspan="2">Evaluation</td>
			<td colspan="3"></td>
			<td colspan="5">Judgement</td>
			<td>FIT</td>
			<td></td>
			<td>NOT FIT</td>
			<td></td>
		</tr>

		<tr>
			<td colspan="14">9. Name of interviewer</td>
		</tr>

		<tr>
			<td rowspan="3" colspan="2">
				Interviewer
					(Sub)
			</td>
			<td>Rank</td>
			<td colspan="2">CREWING MANAGER</td>
			<td rowspan="3" colspan="5">
				Interviewer
					(Main)
			</td>
			<td>Rank</td>
			<td colspan="3">PRESIDENT</td>
		</tr>

		<tr>
			<td>Name</td>
			<td colspan="2">JEFFREY PLANTA</td>
			<td>Name</td>
			<td colspan="3">C/E ROMANO MARIANO</td>
		</tr>

		<tr>
			<td>Signature</td>
			<td colspan="2"></td>
			<td>Signature</td>
			<td colspan="3"></td>
		</tr>
	</tbody>
</table>