<table>
	<tr>
		<td colspan="12">KLCSM CO., LTD.</td>
	</tr>

	<tr>
		<td colspan="12">INTERVIEW LIST</td>
	</tr>

	<tr>
		<td colspan="12">FOR FOREIGN CREW</td>
	</tr>

	<tr>
		<td colspan="12">※ Please complete only bolded area</td>
	</tr>

	<tr>
		<td>Ship's Name</td>
		<td colspan="2">{{ $data->vessel->name ?? '-' }}</td>
		<td colspan="5">Rank</td>
		<td colspan="4">{{ $data->rank->abbr }}</td>
	</tr>

	<tr>
		<td>Family Name</td>
		<td colspan="2">{{ $data->user->lname }}</td>
		<td colspan="5">Last School</td>
		<td colspan="4">
			@php
				$checkDate2 = function($date, $type){
					if($date == "UNLIMITED"){
						return $date;
					}
					elseif($date == "" || $date == null){
						if($type == "E"){
							return 'UNLIMITED';
						}
						else{
							return '-----';
						}
					}
					else{
						return $date->format('d-M-Y');
					}
				};

				$temp = null;
				foreach ($data->educational_background as $eb) {
					$temp = $eb;
					if($temp->type == "College" || $temp->type == "Vocational"){
						echo $temp->school;
						break;
					}
				}
			@endphp
		</td>
	</tr>

	<tr>
		<td>Given Name</td>
		<td colspan="2">{{ $data->user->fname }}</td>
		<td colspan="5">Course</td>
		<td colspan="4">{{ $temp->course ?? '-' }}</td>
	</tr>

	<tr>
		<td>Middle Name</td>
		<td colspan="2">{{ $data->user->mname }}</td>
		<td colspan="5">Duration</td>
		<td colspan="4">{{ $temp->type == "College" ? "4yrs" : "2yrs" }}</td>
	</tr>

	<tr>
		<td>Birth Date</td>
		<td colspan="2">{{ $checkDate2($data->user->birthday, 'a') }}</td>
		<td colspan="5">Height / Weight</td>
		<td colspan="4">{{ $data->height }}cm / {{ $data->weight }}kg</td>
	</tr>

	<tr>
		<td>Telephone No.</td>
		<td colspan="2">{{ $data->user->contact }}</td>
		<td colspan="5">Civil Status</td>
		<td colspan="4">{{ $data->civil_status }}</td>
	</tr>

	<tr>
		<td colspan="12">※ Check appearance of applicant</td>
	</tr>

	<tr>
		<td rowspan="3">Items</td>
		<td colspan="2" rowspan="3">Check Point</td>
		<td colspan="5">Evaluation</td>
		<td colspan="4" rowspan="3">Remark</td>
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
		<td colspan="12">1. Personal Qualification</td>
	</tr>

	<tr>
		<td>Working Attitude</td>
		<td colspan="2">Satisfaction, Planning</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td>Adaptation</td>
		<td colspan="2">Responsibility, Patience</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td>Career</td>
		<td colspan="2">Shifting co., Service Length</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td>English</td>
		<td colspan="2">Hearing, Speaking, Reading, Writing</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="12">2. Personal Particulars</td>
	</tr>

	<tr>
		<td>Appearance</td>
		<td colspan="2">Posture, Expression</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td>Family life</td>
		<td colspan="2">Status, Growing process</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td>Social life</td>
		<td colspan="2">Social activity and carrier</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td>Ambition</td>
		<td colspan="2">Positiveness, Confidence</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td>Knowledge</td>
		<td colspan="2">Technical, Skill, Career</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td>Sociality</td>
		<td colspan="2">Courtesy, Self-control</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="12">3. Identification of Carrier</td>
	</tr>

	@php
		$lss = $data->sea_service[0];
	@endphp

	<tr>
		<td>Last Company</td>
		<td colspan="2">{{ $data->sea_service[0]->manning_agent }}</td>
		<td colspan="5">Serve Period</td>
		<td colspan="4">
			{{ $lss->sign_on ? $lss->sign_on->format("d M Y") : '---'}}
			 - 
			{{ $lss->sign_off ? $lss->sign_off->format("d M Y") : '---'}}
		</td>
	</tr>

	<tr>
		<td>Last Rank</td>
		<td colspan="2">{{ $data->sea_service[0]->rank }}</td>
		<td colspan="5">Last Carrier</td>
		<td colspan="4">{{ $data->sea_service[0]->vessel_type }}</td>
	</tr>

	<tr>
		<td>Own Disembark</td>
		<td colspan="2">{{ $data->sea_service[0]->remarks }}</td>
		<td colspan="5">Previous Records</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="12">4. Recommender</td>
	</tr>

	<tr>
		<td>Section</td>
		<td colspan="2">CREWING DEPARTMENT</td>
		<td colspan="5">Rank/Name</td>
		<td colspan="4"></td>
	</tr>
	
	<tr>
		<td colspan="12">5. Health Condition</td>
	</tr>

	<tr>
		<td>Family History</td>
		<td colspan="2"></td>
		<td colspan="5">Remark</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td>Chronic Disease</td>
		<td colspan="2"></td>
		<td colspan="5">Remark</td>
		<td colspan="4"></td>
	</tr>
	
	<tr>
		<td colspan="12">6. General Remark</td>
	</tr>

	<tr>
		<td colspan="12"></td>
	</tr>
	
	<tr>
		<td colspan="12">7. Result(for item 1 through item 3)</td>
	</tr>

	<tr>
		<td colspan="12"></td>
	</tr>
	
	<tr>
		<td colspan="12">8. Result</td>
	</tr>

	<tr>
		<td>Evaluation</td>
		<td colspan="2"></td>
		<td colspan="5">Judgement</td>
		<td>FIT</td>
		<td>a</td>
		<td>NOT FIT</td>
		<td></td>
	</tr>
	
	<tr>
		<td colspan="12">9. Name of Interviewer</td>
	</tr>

	<tr>
		<td>Interviewer</td>
		<td>Rank</td>
		<td>CREWING MANAGER</td>
		<td colspan="5">Interviewer</td>
		<td>Rank</td>
		<td colspan="3">PORT CAPTAIN</td>
	</tr>

	<tr>
		<td>(Sub)</td>
		<td>Name</td>
		<td>JEANNETTE T. SOLIDUM</td>
		<td colspan="5">(Main)</td>
		<td>Name</td>
		<td colspan="3">CAPT. HERNAN D. CASTILLO</td>
	</tr>

	<tr>
		<td></td>
		<td>Signature</td>
		<td></td>
		<td colspan="5">(Main)</td>
		<td>Signature</td>
		<td colspan="3"></td>
	</tr>
</table>