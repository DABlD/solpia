@php
	function checkDate3($date, $type){
		if($date == "NO EXPIRY"){
			return $date;
		}
		elseif($date == "" || $date == null){
			if($type == "E"){
				return 'NO EXPIRY';
			}
			else{
				return '-----';
			}
		}
		else{
			echo $date->format('F j, Y');
		}
	}
@endphp

<table>
	<tbody>
		<tr>
			<td colspan="15">
				SHINKO MARITIME CO., LTD.
			</td>
		</tr>

		<tr>
			<td colspan="15">
				APPLICATION FOR EMPLOYMENT
			</td>
		</tr>

		<tr>
			<td rowspan="4" colspan="7"></td>
			<td rowspan="4" colspan="2">Name in Chinese</td>
			<td rowspan="4" colspan="3">{{-- FILL --}}</td>
			<td rowspan="8" colspan="3"></td>
		</tr>

		<tr></tr>
		<tr></tr>
		<tr></tr>

		<tr>
			<td colspan="3">Ship's Name</td>
			<td colspan="4">
				{{ isset($applicant->vessel) ? $applicant->vessel->name : '-----' }}
			</td>

			<td colspan="2">Rank</td>
			<td colspan="3">
				{{ isset($applicant->rank) ? $applicant->rank->abbr : '-----' }}
			</td>
		</tr>

		<tr>
			<td colspan="3">Family Name</td>
			<td colspan="4">{{ $applicant->user->lname }}</td>

			<td colspan="2">Birth Date</td>
			<td colspan="3">{{ $applicant->user->birthday->format('F j, Y') }}</td>
		</tr>

		<tr>
			<td colspan="3">First Name</td>
			<td colspan="4">{{ $applicant->user->fname . ' ' . $applicant->user->suffix }}</td>

			<td colspan="2">Height</td>
			<td colspan="2">{{ $applicant->height }}</td>
			<td>cm</td>
		</tr>

		<tr>
			<td colspan="3">Middle Name</td>
			<td colspan="4">{{ $applicant->user->mname }}</td>

			<td colspan="2">Weight</td>
			<td colspan="2">{{ $applicant->weight }}</td>
			<td>kg</td>
		</tr>

		<tr>
			<td colspan="8">BASIC DOCUMENTATION</td>
			<td colspan="7">ADDRESS AND PARTICULAR</td>
		</tr>

		<tr>
			<td colspan="3">Classification</td>
			<td colspan="2">Number</td>
			<td colspan="2">Expiry</td>

			<td colspan="2" rowspan="2">Present Address</td>
			<td colspan="6" rowspan="2">{{ $applicant->user->address }}</td>
		</tr>

		@php 
			$name = "SEAMAN'S BOOK";
			$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
		@endphp

		<tr>
			<td rowspan="2" colspan="2">SM Book</td>
			<td>National</td>
			<td colspan="2">{{ $docu ? $docu->number : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate3($docu->expiry_date, "E") : "-----" }}</td>
		</tr>

		<tr>
			<td>Flag State</td>

			@php 
				$docu = false;
				foreach($applicant->document_flag as $document){
				    if($document->country == "Panama" && $document->type == "BOOKLET"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "-----" }}
			</td>
			<td colspan="2">
				{{ $docu ? checkDate3($docu->expiry_date, "E") : "-----" }}
			</td>
			<td colspan="2">Tel</td>
			<td colspan="6">{{ $applicant->user->contact }}</td>
		</tr>

		@php 
			$name = 'COC';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td rowspan="2" colspan="2">COC</td>
			<td>National</td>
			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate3($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">Place of Birth</td>
			<td colspan="6">{{ $applicant->birth_place }}</td>
		</tr>

		@php
			$docu = false;
			foreach($applicant->document_flag as $document){
			    if($document->country == "Panama" && $document->type == "LICENSE"){
			        $docu = $document;
			    }
			}
		@endphp

		<tr>
			<td>Flag State</td>
			<td colspan="2">{{ $docu ? $docu->number : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate3($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">Religion</td>
			<td colspan="6">{{ $applicant->religion }}</td>
		</tr>

		@php 
			$name = 'GMDSS/GOC';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td rowspan="2" colspan="2">GOC</td>
			<td>National</td>
			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate3($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="8">Schooling</td>
		</tr>

		@php
			$docu = false;
			foreach($applicant->document_flag as $document){
			    if($document->country == "Panama" && $document->type == "GMDSS/GOC"){
			        $docu = $document;
			    }
			}
		@endphp

		@php
			$lastSchool = sizeof($applicant->educational_background) ? : false;
		@endphp

		<tr>
			<td>Flag State</td>
			<td colspan="2">
				{{ $docu ? $docu->number : "-----" }}
			<td colspan="2">
				{{ $docu ? checkDate3($docu->expiry_date, "E") : "-----" }}
			</td>
			<td colspan="2">Last School</td>
			<td colspan="6">{{ $lastSchool ? $applicant->educational_background->last()->school : "N/A" }}</td>
		</tr>

		@php 
			$name = 'PASSPORT';
			$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
		@endphp

		<tr>
			<td colspan="3">Passport</td>
			<td colspan="2">{{ $docu ? $docu->number : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate3($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">Period</td>
			<td colspan="6">{{ $lastSchool ? $applicant->educational_background->last()->year : "N/A" }}</td>
		</tr>

		@php 
			$name = 'US-VISA';
			$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
		@endphp

		<tr>
			<td colspan="3">U.S.A. Visa</td>
			<td colspan="2">{{ $docu ? $docu->number : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate3($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">Specialty</td>
			<td colspan="6">{{ $lastSchool ? $applicant->educational_background->last()->course : "N/A" }}</td>
		</tr>

		<tr>
			<td colspan="15">FAMILY STATUS</td>
		</tr>

		<tr>
			<td colspan="2">Relation</td>
			<td colspan="2">Name</td>
			<td colspan="2">Birth</td>
			<td>Occupation</td>
			<td>Relation</td>
			<td colspan="3">Name</td>
			<td colspan="2">Birth</td>
			<td colspan="2">Occupation</td>
		</tr>

		@foreach($applicant->family_data as $family)
			@if($family->lname == "")
				@php continue; @endphp
			@endif

			@if($loop->index % 2 == 0)
				<tr>
					<td colspan="2">{{ $family->type }}</td>
					<td colspan="2">{{ $family->lname . ', ' . $family->fname . ' ' . $family->suffix . ' ' . $family->mname }}</td>
					<td colspan="2">{{ $family->birthday != ""?$family->birthday->format('F j, Y') : '' }}</td>
					<td>{{ $family->occupation }}</td>
			@else
					<td>{{ $family->type }}</td>
					<td colspan="3">{{ $family->lname . ', ' . $family->fname . ' ' . $family->suffix . ' ' . $family->mname }}</td>
					<td colspan="2">{{ $family->birthday != ""?$family->birthday->format('F j, Y') : '' }}</td>
					<td colspan="2">{{ $family->occupation }}</td>
				</tr>
			@endif
		@endforeach

		<tr>
			<td colspan="15">
				<span>
					S E A
				</span>
				<span></span>
				<span>
					C A R R I E R
				</span>
			</td>
		</tr>

		<tr>
			<td rowspan="2">No</td>
			<td rowspan="2" colspan="3">
				Vessel<br>
				Name
			</td>
			<td rowspan="2">
				Wage<br>
				(US$)
			</td>
			<td rowspan="2">
				Period<br>
				From/To
			</td>
			<td rowspan="2">
				<br>
				M
			</td>
			<td rowspan="2">
				<br>
				Rank
			</td>
			<td rowspan="2" colspan="2">
				Vsl Type<br>
				Eng Type
			</td>
			<td rowspan="2">
				GRT<br>
				Output/BHP
			</td>
			<td rowspan="2" colspan="2">
				Agent<br>
				Principal
			</td>
			<td rowspan="2" colspan="2">
				Reason for<br>
				Leaving
			</td>
		</tr>

		<tr></tr>

		@foreach($applicant->sea_service as $service)
			<tr>
				<td rowspan="2">{{ $loop->index + 1 }}</td>
				<td rowspan="2" colspan="3">{{ $service->vessel_name }}</td>
				<td rowspan="2">{{ $service->previous_salary }}</td>
				<td rowspan="1">{{ $service->sign_on != "" ? $service->sign_on->format('d.M.y') : "N/A" }}</td>
				<td rowspan="2">
					@if($service->sign_on != "" && $service->sign_off != "")
						{{ round($service->sign_on->floatDiffInMonths($service->sign_off), 1) }}
					@else
						Insufficient data
					@endif
				</td>
				<td rowspan="2">{{ $applicant->ranks[$service->rank] }}</td>
				<td rowspan="1" colspan="2">{{ $service->vessel_type }}</td>
				<td rowspan="1">{{ $service->gross_tonnage }}</td>
				<td rowspan="1" colspan="2">{{ $service->manning_agent }}</td>
				<td rowspan="2" colspan="2">{{ $service->remarks }}</td>
			</tr>
			<tr>
				<td rowspan="1">{{ $service->sign_off != "" ? $service->sign_off->format('d.M.y') : "N/A" }}</td>
				<td rowspan="1" colspan="2">{{ $service->engine_type }}</td>
				<td rowspan="1">{{ ceil(($service->bhp_kw * 0.745) / 5) * 5 }}</td>
				<td rowspan="1" colspan="2">{{ $service->principal }}</td>
			</tr>
		@endforeach

		<tr>
			<td colspan="10">Have you ever been sued in court or before any Administrative body?</td>
			<td>Yes</td>
			<td></td>
			<td>No</td>
			<td>a</td>
			<td></td>
		</tr>

		<tr></tr>

		<tr>
			<td colspan="8">If "yes", give particulars</td>
			<td colspan="7"></td>
		</tr>

		<tr>
			<td colspan="8">Who recommended you to this company?</td>
			<td colspan="7"></td>
		</tr>

		<tr></tr>
		<tr>
			<td colspan="15" rowspan="2">I, undersigned, hereby certify that all informations provided herein are true and correct.  Any misrepresentation may cause of dismissal at all the costs burden to myself.</td>
		</tr>

		<tr></tr>
		<tr></tr>

		<tr>
			<td colspan="8"></td>
			<td colspan="6">{{-- Border --}}</td>
		</tr>
		<tr>
			<td colspan="9"></td>
			<td colspan="4">Signature of Applicant</td>
			<td colspan="2"></td>
		</tr>
	</tbody>
</table>