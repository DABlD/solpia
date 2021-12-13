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
		<td colspan="16">Checklist For Recruiting Crew</td>
		<td colspan="6">Date of Interview</td>
	</tr>

	<tr>
		<td colspan="16">Personal Record</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td rowspan="23">P<span></span>E<span></span>R<span></span>S<span></span>O<span></span>N<span></span>A<span></span>L<span></span>R<span></span>E<span></span>C<span></span>O<span></span>R<span></span>D</td>
		<td colspan="3">Rank</td>
		<td colspan="9">{{ $applicant->rank->name ?? '---' }}</td>
		<td colspan="2">VESSEL</td>
		<td colspan="7">{{ $applicant->vessel->name ?? '---' }}</td>
	</tr>

	@php
		$sfx = $applicant->user->suffix;
	@endphp

	<tr>
		<td colspan="3">Name</td>
		<td colspan="9">{{ $applicant->user->lname . ', ' . $applicant->user->fname . ' ' . ($sfx != "" ? $sfx . ' ' : '') . $applicant->user->mname }}</td>
		<td colspan="2">Birth Date</td>
		<td colspan="7">{{ $applicant->user->birthday->format('M j, Y') }}</td>
	</tr>

	<tr>
		<td colspan="3">Address</td>
		<td colspan="9">{{ $applicant->provincial_address }}</td>
		<td colspan="2">Place of Birth</td>
		<td colspan="7">{{ $applicant->birth_place }}</td>
	</tr>

	<tr>
		<td colspan="3">Contact Number</td>
		<td colspan="9">{{ $applicant->user->contact }}</td>
		<td colspan="2" rowspan="2">CITIZENSHIP</td>
		<td colspan="7" rowspan="2">FILIPINO</td>
	</tr>

	@php
		$temp = $applicant->educational_background->last() ?? '---';
		$educ = $temp;

		if($temp != '---'){
			$educ = $temp->school . ' / ' . $temp->course . ' / ' . $temp->year;
		}
	@endphp
	<tr>
		<td colspan="3">School Career</td>
		<td colspan="9">{{ $educ }}</td>
	</tr>

	<tr>
		<td colspan="3">Drinking Capacity</td>
		<td colspan="9">MINIMAL</td>
		<td colspan="2" rowspan="2">Foreigner License</td>
		<td colspan="7" rowspan="2"></td>
	</tr>

	<tr>
		<td colspan="3">Drug</td>
		<td colspan="9"></td>
	</tr>
	
	{{-- BOARDING CAREER --}}
	<tr>
		<td colspan="3">TOTAL</td>
		<td>Bulk</td>
		<td colspan="2">{{ $ssTotalY['bulk'] }}</td>
		<td colspan="3">Years</td>
		<td>{{ $ssTotalM['bulk'] }}</td>
		<td>Months</td>
		<td colspan="3">G. Cargo</td>
		<td  colspan="2"></td>
		<td></td>
		<td colspan="2">Years</td>
		<td></td>
		<td>Months</td>
	</tr>

	<tr>
		<td rowspan="2">Boarding Career</td>
		<td></td>
		<td>YEAR</td>
		<td>Tanker</td>
		<td colspan="2"></td>
		<td colspan="3">Years</td>
		<td></td>
		<td>Months</td>
		<td colspan="3">Reefer</td>
		<td  colspan="2"></td>
		<td></td>
		<td colspan="2">Years</td>
		<td></td>
		<td>Months</td>
	</tr>

	<tr>
		<td></td>
		<td>MONTHS</td>
		<td>Container</td>
		<td colspan="2">{{ $ssTotalY['container'] }}</td>
		<td colspan="3">Years</td>
		<td>{{ $ssTotalM['container'] }}</td>
		<td>Months</td>
		<td colspan="3">Others</td>
		<td  colspan="2"></td>
		<td></td>
		<td colspan="2">Years</td>
		<td></td>
		<td>Months</td>
	</tr>

	<tr>
		<td colspan="3">Boarding Career</td>
		<td>Rank</td>
		<td colspan="3">Vessel</td>
		<td colspan="2">Type</td>
		<td>GRT</td>
		<td>ENGINE/HP</td>
		<td>YEAR BUILT</td>
		<td colspan="2">Signed On</td>
		<td colspan="2">Signed Off</td>
		<td>MONTHS</td>
		<td>AGENCY</td>
		<td>PRINCIPAL</td>
		<td colspan="2">Remarks</td>
	</tr>

	@php
		$ctr = 0;
	@endphp

	@foreach($applicant->sea_service as $service)
		@php
			if($ctr == 12){
				break;
			}
			else{
				$ctr++;
			}
		@endphp

		<tr>
			<td colspan="3"></td>
			<td>{{ $applicant->ranks[$service->rank] }}</td>
			<td colspan="3">{{ $service->vessel_name }}</td>
			<td colspan="2">{{ $service->vessel_type }}</td>
			@php 
				$temp = $service->gross_tonnage;
				$temp = $temp == "" ? '' : $temp; 
			@endphp
			<td>{{ is_numeric($temp) ? number_format($temp) : $temp}}</td>
			@php
				$temp2 = $service->engine_type . ' / ' . $service->bhp_kw;
			@endphp
			<td>{{ $temp2 != " / " ? $temp2 : '' }}</td>
			<td>{{ $service->year_built }}</td>
			<td colspan="2">{{ $service->sign_on != "" ? $service->sign_on->format('d.M.y') : "" }}</td>
			<td colspan="2">{{ $service->sign_off != "" ? $service->sign_off->format('d.M.y') : "" }}</td>
			<td>
				@if($service->sign_on != "" && $service->sign_off != "")
					{{ round($service->sign_on->floatDiffInMonths($service->sign_off), 1) }}
				@endif
			</td>
			<td>{{ $service->manning_agent }}</td>
			<td>{{ $service->principal }}</td>
			<td colspan="2">{{ $service->remarks }}</td>
		</tr>
	@endforeach

	{{-- AFTER SEA SERVICE --}}
	<tr>
		<td colspan="4">INTERVIEWER</td>
		<td colspan="2">WORKING KNOWLEDGE</td>
		<td colspan="2">WILLINGNESS TO WORK</td>
		<td colspan="3">RESPONSIBILITY</td>
		<td colspan="2">GENERAL CHARACTER</td>
		<td colspan="2">KNOWLEDGE IN ENGLISH</td>
		<td colspan="3">OVERALL ASSESSMENT</td>
		<td colspan="2">SIGNATURE</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="22">Satisfaction Points</td>
	</tr>

	<tr>
		<td colspan="22">
			Outstanding - 5
			<span></span>
			<span></span>
			/
			<span></span>
			<span></span>
			Very Satisfactory - 4
			<span></span>
			<span></span>
			/
			<span></span>
			<span></span>
			Satisfactory - 3
			<span></span>
			<span></span>
			/
			<span></span>
			<span></span>
			Un-Satisfactory - 2
			<span></span>
			<span></span>
			/
			<span></span>
			<span></span>
			Poor - 1
		</td>
	</tr>

	<tr>
		<td colspan="4">
			MR. ADULF KIT JUMAWAN
		</td>
		<td colspan="2" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td colspan="3" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td colspan="3" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
	</tr>

	<tr>
		<td colspan="4">
			Crewing Manager
		</td>
	</tr>

	<tr>
		<td colspan="4">
			C/E ROMANO A. MARIANO
		</td>
		<td colspan="2" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td colspan="3" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td colspan="3" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
	</tr>

	<tr>
		<td colspan="4">
			President
		</td>
	</tr>

	<tr>
		<td colspan="4">
			MR. JAE SIN SIM
		<td colspan="2" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td colspan="3" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td colspan="3" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
		<td colspan="2" rowspan="2"></td>
	</tr>

	<tr>
		<td colspan="4">
			C.E.O.
		</td>
	</tr>

	<tr>
		<td colspan="22">
			FIT FOR DUTY
			<span></span><span></span><span></span>
			(
			<span></span><span></span>✔<span></span><span></span>
			)
		</td>
	</tr>

	<tr>
		<td colspan="22">
			UNFIT FOR DUTY
			<span></span>
			(
			<span></span><span></span><span></span><span></span>
			)
		</td>
	</tr>

	<tr>
		<td colspan="3">HEIGHT(cm):</td>
		<td colspan="3">{{ $applicant->height }}</td>
		<td colspan="2">WEIGHT(kg):</td>
		<td colspan="3">{{ $applicant->weight }}</td>
		<td colspan="2">SHOE SIZE(cm):</td>
		<td colspan="2">{{ $applicant->shoe_size }}</td>
		<td colspan="2">COVERALL:</td>
		<td colspan="2">{{ $applicant->clothes_size }}</td>
		<td colspan="2">WAISTLINE(inches):</td>
		<td>{{ $applicant->waistline }}</td>
	</tr>

	@php
		$docu = isset($applicant->document_id->{'PASSPORT'}) ? $applicant->document_id->{'PASSPORT'} : false;
	@endphp
	<tr>
		<td colspan="4">PASSPORT NO.</td>
		<td colspan="4">{{ $docu->number ?? '---' }}</td>
		<td colspan="3">ISSUED ON:</td>
		<td colspan="4">{{ $docu ? $checkDate2($docu->issue_date, 'I') : 'N/A' }}</td>
		<td colspan="2">VALIDITY:</td>
		<td colspan="5">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$docu = isset($applicant->document_id->{"SEAMAN'S BOOK"}) ? $applicant->document_id->{"SEAMAN'S BOOK"} : false;
	@endphp
	<tr>
		<td colspan="4">SEAMAN'S BOOK NO.</td>
		<td colspan="4">{{ $docu->number ?? '---' }}</td>
		<td colspan="3">ISSUED ON:</td>
		<td colspan="4">{{ $docu ? $checkDate2($docu->issue_date, 'I') : 'N/A' }}</td>
		<td colspan="2">VALIDITY:</td>
		<td colspan="5">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>
	
	@php
		$temp = 'BOOKLET';
		$docu = false;

		foreach($applicant->document_flag as $document){
		    if($document->country == "Panama" && $document->type == $temp){
		        $docu = $document;
		    }
		}
	@endphp

	<tr>
		<td colspan="4">PANAMA BOOKLET</td>
		<td colspan="4">{{ $docu->number ?? '---' }}</td>
		<td colspan="3">ISSUED ON:</td>
		<td colspan="4">{{ $docu ? $checkDate2($docu->issue_date, 'I') : 'N/A' }}</td>
		<td colspan="2">VALIDITY:</td>
		<td colspan="5">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	<tr>
		<td colspan="4" rowspan="12">COMPULSARY EDUCATION AND THEIR CERTIFICATES</td>
		<td colspan="5">Kind</td>
		<td colspan="2">Certificate No.</td>
		<td colspan="3">Date of Education</td>
		<td colspan="3">Target Person</td>
		<td colspan="3">Date of Expiration</td>
		<td colspan="2">Result of Physical</td>
	</tr>

	@php
		$docu = false;
		if($applicant->rank){				
			if($applicant->rank->id >= 1 && $applicant->rank->id <= 4)
			{
				$name = 'COC';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			}
		}
	@endphp

	<tr>
		<td colspan="5">STCW '95 Endorsement(COC)</td>
		<td colspan="2">{{ $docu ? $docu->no : 'N/A' }}</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->issue_date, 'I') : 'N/A' }}</td>
		<td colspan="3">DECK OFFICER</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
		<td colspan="2" rowspan="11">FIT TO WORK</td>
	</tr>

	@php
		$docu = false;
		if($applicant->rank){
			if($applicant->rank->id >= 1 && $applicant->rank->id <= 4)
			{
				$name = 'GMDSS/GOC';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			}
		}
	@endphp

	<tr>
		<td colspan="5">GMDSS Radio Operator (GOC)</td>
		<td colspan="2">{{ $docu ? $docu->no : 'N/A' }}</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->issue_date, 'I') : 'N/A' }}</td>
		<td colspan="3">DECK OFFICER</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$docu = false;
		if($applicant->rank){
			if(($applicant->rank->id >= 1 && $applicant->rank->id <= 8) || ($applicant->rank->id >= 15 && $applicant->rank->id <= 21))
			{
				$temp = 'LICENSE';
				$docu = false;

				foreach($applicant->document_flag as $document){
					if($document->country == "Korea" && $document->type == $temp){
						$docu = $document;
					}
				}
			}
		}
	@endphp

	<tr>
		<td colspan="5">Korean License (KML)</td>
		<td colspan="2">{{ $docu ? $docu->number : 'N/A' }}</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->issue_date, 'I') : 'N/A' }}</td>
		<td colspan="3">OFFICERS / ENGINEERS</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$name = 'BASIC TRAINING - BT';
		$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
	@endphp

	<tr>
		<td colspan="5">Basic Training (BT)</td>
		<td colspan="2">{{ $docu ? $docu->no : 'N/A' }}</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->issue_date, 'I') : 'N/A' }}</td>
		<td colspan="3">ALL CREW</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$docu = false;
		if($applicant->rank){
			if(($applicant->rank->id >= 1 && $applicant->rank->id <= 8) || ($applicant->rank->id >= 15 && $applicant->rank->id <= 21) || in_array($applicant->rank->id, [9, 10, 15]))
			{
				$name = 'PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			}
		}
	@endphp

	<tr>
		<td colspan="5">Prof. Survival Craft &#x26; Rec. Boat(PSCRB)</td>
		<td colspan="2">{{ $docu ? $docu->no : 'N/A' }}</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->issue_date, 'I') : 'N/A' }}</td>
		<td colspan="3">OFFICERS / ENGINEERS / BSN / AB / OLR1</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$docu = false;
		if($applicant->rank){
			if(in_array($applicant->rank->id, [9, 10, 11, 15, 16, 17]))
			{
				foreach($applicant->document_lc as $document){
					$regulation = json_decode($document->regulation);
					
					if($applicant->rank->id >= 9 && $applicant->rank->id <= 11){
						$temp = 'II/4';
					}
					elseif($applicant->rank->id >= 15 && $applicant->rank->id <= 17){
						$temp = 'III/4';
					}

					if(in_array($temp, $regulation)){
						$docu = $document;
						break;
					}
				}
			}
		}
	@endphp

	<tr>
		<td colspan="5">Watchkeeping Cert.</td>
		<td colspan="2">{{ $docu ? $docu->no : 'N/A' }}</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->issue_date, 'I') : 'N/A' }}</td>
		<td colspan="3">BSN / AB / OS / OLR1 / OLR / WPR</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$docu = false;
		if($applicant->rank){
			if($applicant->rank->id >= 1 && $applicant->rank->id <= 8)
			{
				$temp = 'LICENSE';
				$docu = false;

				foreach($applicant->document_flag as $document){
					if($document->country == "Panama" && $document->type == $temp){
						$docu = $document;
					}
				}
			}
		}
	@endphp

	<tr>
		<td colspan="5">License (PANAMA Flag Requirement)</td>
		<td colspan="2">{{ $docu ? $docu->number : 'N/A' }}</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->issue_date, 'I') : 'N/A' }}</td>
		<td colspan="3">OFFICERS</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$name = 'SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD';
		$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
	@endphp

	<tr>
		<td colspan="5">SAT and Seafarer's Designated Security Duties</td>
		<td colspan="2">{{ $docu ? $docu->no : 'N/A' }}</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->issue_date, 'I') : 'N/A' }}</td>
		<td colspan="3">ALL CREW</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$docu = false;
		if($applicant->rank){
			if($applicant->rank->id >= 1 && $applicant->rank->id <= 4)
			{
				$docu = 'SSBT WITH BRM';
				$docu = isset($applicant->document_lc->$docu) ? $applicant->document_lc->{$docu} : false;

				if(!$docu){
					$docu = 'SSBT';
					$docu = isset($applicant->document_lc->{$docu}) ? $applicant->document_lc->{$docu} : false;
				}

				if(!$docu){
					$docu = 'BRM';
					$docu = isset($applicant->document_lc->{$docu}) ? $applicant->document_lc->{$docu} : false;
				}

				if(!$docu){
					$docu = 'BTM';
					$docu = isset($applicant->document_lc->{$docu}) ? $applicant->document_lc->{$docu} : false;
				}
			}
		}
	@endphp

	<tr>
		<td colspan="5">Bridge Resource Management (BRM)</td>
		<td colspan="2">{{ $docu ? $docu->no : 'N/A' }}</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->issue_date, 'I') : 'N/A' }}</td>
		<td colspan="3">ALL DECK OFFICERS</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$docu = false;
		if($applicant->rank){
			if(($applicant->rank->id >= 5 && $applicant->rank->id <= 8) || ($applicant->rank->id >= 15 && $applicant->rank->id <= 21))
			{
				$name = 'ERS WITH ERM';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			}
		}
	@endphp

	<tr>
		<td colspan="5">Engine Resource Management (ERM)</td>
		<td colspan="2">{{ $docu ? $docu->no : 'N/A' }}</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->issue_date, 'I') : 'N/A' }}</td>
		<td colspan="3">ALL ENGINEERS</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$docu = false;
		if($applicant->rank){
			if($applicant->rank->id >= 1 && $applicant->rank->id <= 4)
			{
				$name = 'ECDIS';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			}
		}
	@endphp

	<tr>
		<td colspan="5">Electronic Chart Display and Information System (ECDIS)</td>
		<td colspan="2">{{ $docu ? $docu->no : 'N/A' }}</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->issue_date, 'I') : 'N/A' }}</td>
		<td colspan="3">ALL DECK OFFICERS</td>
		<td colspan="3">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

</table>