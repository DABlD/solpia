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
				return '---';
			}
		}
		else{
			return $date->format('d-M-Y');
		}
	};
@endphp

<table>
	<tr>
		<td colspan="16"></td>
	</tr>

	<tr>
		<td rowspan="72"></td>
		<td rowspan="3" colspan="10">Crew Interview Report</td>
		<td rowspan="2">DATE:</td>
		<td rowspan="2" colspan="4">{{ now()->format('d-M-Y') }}</td>
	</tr>

	<tr></tr>

	<tr>
		<td>Auditor:</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td rowspan="2" colspan="15">Information of Crew</td>
	</tr>

	<tr></tr>

	@php
		$sfx = $applicant->user->suffix;
	@endphp

	<tr>
		<td colspan="3">이름 Name</td>
		<td colspan="5">{{ $applicant->user->lname . ', ' . $applicant->user->fname . ' ' . ($sfx != "" ? $sfx . ' ' : '') . $applicant->user->mname }}</td>
		<td colspan="3">직급 Rank</td>
		<td colspan="4">{{ $applicant->rank->abbr ?? '---' }}</td>
	</tr>

	@php
		$docu = false;
		if($applicant->rank->id >= 1 && $applicant->rank->id <= 4)
		{
			$name = 'COC';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		}
	@endphp

	<tr>
		<td colspan="3">생년월일 Date of Birth</td>
		<td colspan="5">{{ $applicant->user->birthday->format('d-M-Y') }}</td>
		<td colspan="3">면허 License</td>
		<td colspan="4">{{ $docu ? $docu->no : 'N/A' }}</td>
	</tr>

	<tr>
		<td colspan="3">주소 Address</td>
		<td colspan="5">{{ $applicant->provincial_address }}</td>
		<td colspan="3">연락처 Contact No.</td>
		<td colspan="4">{{ $applicant->user->contact }}</td>
	</tr>

	@php
		$temp = $applicant->educational_background->last() ?? '---';
		$educ = $temp;

		if($temp != '---'){
			$educ = $temp->school . " / " . $temp->year;
		}
	@endphp

	<tr>
		<td colspan="3">가족사항 Family status</td>
		<td colspan="5">{{ $applicant->civil_status }}</td>
		<td colspan="3">학력 <br> School last attended</td>
		<td colspan="4">{{ $educ }}</td>
	</tr>

	<tr>
		<td colspan="3">기호 Taste</td>
		<td colspan="5">Drinking capacity :  MINIMAL <br> Smoking : NONE</td>
		<td colspan="3">특기 취미 <br> Specialty and Hobby</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="3">이력 조회 <br> Previous Career</td>
		<td colspan="12">{{ $applicant->ranks[$applicant->sea_service[0]->rank] }}</td>
	</tr>

	<tr>
		<td colspan="3">승선가능 일자 <br> Boarding Possible Date</td>
		<td colspan="12"></td>
	</tr>

	{{-- 1ST 2 ROW --}}

	<tr>
		<td rowspan="2" colspan="3">개인 증서 <br> Personal Certificates <br> (Expired date)</td>
		<td>Passport</td>
		<td colspan="2">Seaman Book</td>
		<td colspan="2">Basic Training</td>
		<td colspan="2">Panama Book</td>
		<td colspan="2">Marshall Book</td>
		<td colspan="3">Medical</td>
	</tr>

	@php
		$docu1 = isset($applicant->document_id->{'PASSPORT'}) ? $applicant->document_id->{'PASSPORT'} : false;
		$docu2 = isset($applicant->document_id->{"SEAMAN'S BOOK"}) ? $applicant->document_id->{"SEAMAN'S BOOK"} : false;

		$name = 'BASIC TRAINING - BT';
		$docu3 = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;

		$temp = 'BOOKLET';
		$docu4 = false;

		foreach($applicant->document_flag as $document){
		    if($document->country == "Panama" && $document->type == $temp){
		        $docu4 = $document;
		    }
		}

		$temp = 'BOOKLET';
		$docu5 = false;

		foreach($applicant->document_flag as $document){
		    if($document->country == "Marshall Islands" && $document->type == $temp){
		        $docu5 = $document;
		    }
		}

		$name = 'MEDICAL CERTIFICATE';
		$docu6 = isset($applicant->document_med_cert->{$name}) ? $applicant->document_med_cert->{$name} : false;
	@endphp

	<tr>
		<td>{{ $docu1 ? $checkDate2($docu1->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2">{{ $docu2 ? $checkDate2($docu2->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2">{{ $docu3 ? $checkDate2($docu2->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2">{{ $docu4 ? $checkDate2($docu2->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2">{{ $docu5 ? $checkDate2($docu2->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="3">{{ $docu6 ? $checkDate2($docu2->expiry_date, 'E') : 'FOR MEDICAL' }}</td>
	</tr>

	{{-- 2nd 2 ROW --}}

	<tr>
		<td rowspan="2" colspan="3">추가 개인 증서<br> Add personal certificates <br> (Expired date)</td>
		<td>COC</td>
		<td colspan="2">GOC</td>
		<td colspan="2">Korea COC</td>
		<td colspan="2">ECDIS<br>(issued date)</td>
		<td colspan="2">BRM<br>(issued date)</td>
		<td colspan="3">ERM<br>(issued date)</td>
	</tr>

	@php
		$docu1 = isset($applicant->document_lc->{'COC'}) ? $applicant->document_lc->{'COC'} : false;

		$docu2 = isset($applicant->document_lc->{"GMDSS/GOC"}) ? $applicant->document_lc->{"GMDSS/GOC"} : false;

		$name = 'KOREA COC';
		$docu3 = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;

		$name = 'ECDIS';
		$docu4 = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;

		// DOCU 5
		$name = 'SSBT WITH BRM';
		$docu5 = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;

		if(!$docu5){
			$name = 'SSBT';
			$docu5 = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;

			if(!$docu5){
				$name = 'BRM';
				$docu5 = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			}

			if(!$docu5){
				$name = 'BTM';
				$docu5 = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			}
		}

		// DOCU 6

		$name = 'ERS WITH ERM';
		$docu6 = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;

		if(!$docu6){
			$name = 'ERS';
			$docu6 = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;

			if(!$docu6){
				$name = 'ERM';
				$docu6 = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			}
		}
	@endphp

	<tr>
		<td>{{ $docu1 ? $checkDate2($docu1->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2">{{ $docu2 ? $checkDate2($docu2->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2">{{ $docu3 ? $checkDate2($docu2->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2">{{ $docu4 ? $checkDate2($docu2->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2">{{ $docu5 ? $checkDate2($docu2->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="3">{{ $docu6 ? $checkDate2($docu2->expiry_date, 'E') : 'FOR MEDICAL' }}</td>
	</tr>

	<tr>
		<td colspan="15"></td>
	</tr>

	<tr>
		<td colspan="4" rowspan="2">(A) Observation Points on Interview</td>
		<td colspan="5">SCALE</td>
		<td colspan="6" rowspan="2">COMMENTS</td>
	</tr>

	<tr>
		<td>excellent</td>
		<td>good</td>
		<td>average</td>
		<td>poor</td>
		<td>bad</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="2">Appearance (Physical)</td>
		<td>1st Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
		<td colspan="6" rowspan="2"></td>
	</tr>

	<tr>
		<td>2nd Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="2">Professional knowledge (Attach the check list for detail)</td>
		<td>1st Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
		<td colspan="6" rowspan="2"></td>
	</tr>

	<tr>
		<td>2nd Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="2">Attitude to safety and environmental protection</td>
		<td>1st Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
		<td colspan="6" rowspan="2"></td>
	</tr>

	<tr>
		<td>2nd Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="2">Motivation</td>
		<td>1st Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
		<td colspan="6" rowspan="2"></td>
	</tr>

	<tr>
		<td>2nd Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="2">Social Skills</td>
		<td>1st Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
		<td colspan="6" rowspan="2"></td>
	</tr>

	<tr>
		<td>2nd Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="2">Team-work ability</td>
		<td>1st Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
		<td colspan="6" rowspan="2"></td>
	</tr>

	<tr>
		<td>2nd Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="2">Ability to communicate</td>
		<td>1st Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
		<td colspan="6" rowspan="2"></td>
	</tr>

	<tr>
		<td>2nd Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="2">Ability to communicate in English</td>
		<td>1st Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
		<td colspan="6" rowspan="2"></td>
	</tr>

	<tr>
		<td>2nd Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="2">Record of the sea services</td>
		<td>1st Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
		<td colspan="6" rowspan="2"></td>
	</tr>

	<tr>
		<td>2nd Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="2">The previous appraisal reports (At least 2 vessels)</td>
		<td>1st Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
		<td colspan="6" rowspan="2"></td>
	</tr>

	<tr>
		<td>2nd Interviewer</td>
		<td>2</td>
		<td>1</td>
		<td>0</td>
		<td>-1</td>
		<td>-2</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="4">Total</td>
		<td>1st Interviewer</td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2">-2</td>
		<td colspan="6" rowspan="4">
			A person who got total 10 under shall be rejected.
		</td>
	</tr>

	<tr>
		<td>-Total</td>
	</tr>

	<tr>
		<td>2nd Interviewer</td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2"></td>
		<td rowspan="2">-2</td>
	</tr>

	<tr>
		<td>-Total</td>
	</tr>
	
	<tr><td colspan="15"></td></tr>

	{{-- ESSAY --}}

	{{-- 1st --}}
	<tr>
		<td colspan="15">(B) COMMENTS BY THE 1st INTERVIEWER</td>
	</tr>

	<tr><td colspan="15" rowspan="5"></td></tr>
	<tr></tr><tr></tr><tr></tr><tr></tr>
	<tr><td colspan="15"></td></tr>
	<tr>
		<td></td>
		<td>Passed</td>
		<td></td>
		<td>Rejected</td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="2">Signature:</td>
		<td colspan="5">JUMAWAN, ADULF KIT</td>
		<td></td>
	</tr>
	<tr><td colspan="15"></td></tr>

	{{-- 2nd --}}
	<tr>
		<td colspan="15">(C) COMMENTS BY THE 2nd INTERVIEWER</td>
	</tr>

	<tr>
		<td colspan="15">
			(VERIFIED BY THE G.MANAGER of MARINE AND ENGINEERING)
		</td>
	</tr>

	<tr><td colspan="15"></td></tr>

	<tr><td colspan="15" rowspan="5"></td></tr>
	<tr></tr><tr></tr><tr></tr><tr></tr>
	<tr><td colspan="15"></td></tr>
	<tr>
		<td></td>
		<td>Passed</td>
		<td></td>
		<td>Rejected</td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="2">Signature:</td>
		<td colspan="5">CAPT. HERNAN CASTILLO</td>
		<td></td>
	</tr>
	<tr><td colspan="15"></td></tr>

	{{-- 3rd --}}
	<tr>
		<td colspan="15">(D) COMMENTS BY THE 3rd INTERVIEWER (VERIFIED BY THE D.P.</td>
	</tr>

	<tr>
		<td colspan="15">
			(APPROVED BY THE D.P. UNDER 2ND GRADE)
		</td>
	</tr>

	<tr><td colspan="15"></td></tr>
	<tr><td colspan="15"></td></tr>
	<tr>
		<td></td>
		<td>Passed</td>
		<td></td>
		<td>Rejected</td>
	</tr>
	<tr><td colspan="15"></td></tr>

	<tr><td colspan="15"></td></tr>
</table>