
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
			<td rowspan="4" colspan="7"></td>
			<td rowspan="4" colspan="2">Name in Chinese</td>
			<td rowspan="4" colspan="2">{{-- FILL --}}</td>
			<td rowspan="8" colspan="3"></td>
		</tr>

		<tr></tr>
		<tr></tr>
		<tr></tr>

		<tr>
			<td colspan="2">Ship's Name</td>
			<td colspan="4">
				{{ isset($applicant->vessel) ? $applicant->vessel->name : 'N/A' }}
			</td>

			<td colspan="2">Rank</td>
			<td colspan="3">
				{{ isset($applicant->rank) ? $applicant->rank->abbr : 'N/A' }}
			</td>
		</tr>

		<tr>
			<td colspan="2">Family Name</td>
			<td colspan="4">{{ $applicant->user->lname }}</td>

			<td colspan="2">Birth Date</td>
			<td colspan="3">{{ $applicant->user->birthday->format('F j, Y') }}</td>
		</tr>

		<tr>
			<td colspan="2">First Name</td>
			<td colspan="4">{{ $applicant->user->fname }}</td>

			<td colspan="2">Height</td>
			<td colspan="2">{{ $applicant->height }}</td>
			<td>cm</td>
		</tr>

		<tr>
			<td colspan="2">Middle Name</td>
			<td colspan="4">{{ $applicant->user->mname }}</td>

			<td colspan="2">Weight</td>
			<td colspan="2">{{ $applicant->weight }}</td>
			<td>kg</td>
		</tr>

		<tr>
			<td colspan="7">BASIC DOCUMENTATION</td>
			<td colspan="7">ADDRESS AND PARTICULAR</td>
		</tr>

		<tr>
			<td colspan="2">Classification</td>
			<td colspan="2">Number</td>
			<td colspan="2">Expiry</td>

			<td colspan="2" rowspan="2">Present Address</td>
			<td colspan="6" rowspan="2">{{ $applicant->user->address }}</td>
		</tr>

		<tr>
			<td rowspan="2">SM Book</td>
			<td>National</td>
			<td colspan="2">
				{{ isset($applicant->document_id->{"SEAMAN'S BOOK"}) ? $applicant->document_id->{"SEAMAN'S BOOK"}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_id->{"SEAMAN'S BOOK"}) ? $applicant->document_id->{"SEAMAN'S BOOK"}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
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
				{{ $docu ? $docu->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">Tel</td>
			<td colspan="6">{{ $applicant->user->contact }}</td>
		</tr>

		@php
			$docu = false;
			foreach($applicant->document_flag as $document){
			    if($document->country == "Panama" && $document->type == "BOOKLET"){
			        $docu = $document;
			    }
			}
		@endphp

		<tr>
			<td rowspan="2">COC</td>
			<td>National</td>
			<td colspan="2">{{ isset($applicant->document_lc->{'COC'}) ? $applicant->document_lc->{'COC'}->no : "N/A" }}</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->COC) ? $applicant->document_lc->COC->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">Place of Birth</td>
			<td colspan="6">{{ $applicant->birth_place }}</td>
		</tr>

		@php
			$docu = false;
			foreach($applicant->document_flag as $document){
			    if($document->country == "Panama" && $document->type == "COC"){
			        $docu = $document;
			    }
			}
		@endphp

		<tr>
			<td>Flag State</td>
			<td colspan="2">{{ $docu ? $docu->number : "N/A" }}</td>
			<td colspan="2">{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A" }}</td>
			<td colspan="2">Religion</td>
			<td colspan="6">{{ $applicant->religion }}</td>
		</tr>

		<tr>
			<td rowspan="2">GOC</td>
			<td>National</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{'GMDSS/GOC'}) ? $applicant->document_lc->{'GMDSS/GOC'}->no : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{'GMDSS/GOC'}) ? $applicant->document_lc->{'GMDSS/GOC'}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
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

		<tr>
			<td>Flag State</td>
			<td colspan="2">
				{{ $docu ? $docu->number : "N/A" }}
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">Last School</td>
			<td colspan="6">{{ $applicant->educational_background->last()->school }}</td>
		</tr>

		<tr>
			<td colspan="2">Passport</td>
			<td colspan="2">{{ isset($applicant->document_id->{'PASSPORT'}) ? $applicant->document_id->{'PASSPORT'}->number : "N/A" }}
			<td colspan="2">
				{{ isset($applicant->document_id->{'PASSPORT'}) ? $applicant->document_id->{'PASSPORT'}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">Period</td>
			<td colspan="6">{{ $applicant->educational_background->last()->year }}</td>
		</tr>

		<tr>
			<td colspan="2">U.S.A. Visa</td>
			<td colspan="2">{{ isset($applicant->document_id->{'US-VISA'}) ? $applicant->document_id->{'US-VISA'}->number : "N/A" }}
			<td colspan="2">{{ isset($applicant->document_id->{'US-VISA'}) ? $applicant->document_id->{'US-VISA'}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">Specialty</td>
			<td colspan="6">{{ $applicant->educational_background->last()->course }}</td>
		</tr>

		<tr>
			<td colspan="14">FAMILY STATUS</td>
		</tr>

		<tr>
			<td>Relation</td>
			<td colspan="2">Name</td>
			<td colspan="2">Birth</td>
			<td>Occupation</td>
			<td>Relation</td>
			<td colspan="3">Name</td>
			<td colspan="2">Birth</td>
			<td colspan="2">Occupation</td>
		</tr>

		@foreach($applicant->family_data as $family)
			@if($loop->index % 2 == 0)
				<tr>
					<td>{{ $family->type }}</td>
					<td colspan="2">{{ $family->name }}</td>
					<td colspan="2">{{ $family->birthday->toDateString() != "0000-01-01"?$family->birthday->format('F j, Y') : '' }}</td>
					<td>{{ $family->occupation }}</td>
			@else
					<td>{{ $family->type }}</td>
					<td colspan="3">{{ $family->name }}</td>
					<td colspan="2">{{ $family->birthday->toDateString() != "0000-01-01"?$family->birthday->format('F j, Y') : '' }}</td>
					<td colspan="2">{{ $family->occupation }}</td>
				</tr>
			@endif
		@endforeach

		<tr>
			<td colspan="14">S E A C A R R I E R</td>
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
			<td rowspan="2">
				Vsl Type<br>
				Eng Type
			</td>
			<td rowspan="2">
				GRT<br>
				BHP/KW
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
				<td rowspan="2">${{ $service->previous_salary }}</td>
				<td rowspan="1">{{ $service->sign_on->format('M j, Y') }}</td>
				<td rowspan="2">
					{{ round($service->sign_on->diffInMonths($service->sign_off) + 
						((($service->sign_on->diffInDays($service->sign_off)) / 30) / 30), 2) }}
				</td>
				<td rowspan="2">{{ $service->rank }}</td>
				<td rowspan="1">{{ $service->vessel_type }}</td>
				<td rowspan="1">{{ $service->gross_tonnage }}</td>
				<td rowspan="1" colspan="2">{{ $service->manning_agent }}</td>
				<td rowspan="2" colspan="2">{{ $service->remarks }}</td>
			</tr>
			<tr>
				<td rowspan="1">{{ $service->sign_off->format('M j, Y') }}</td>
				<td rowspan="1">{{ $service->engine_type }}</td>
				<td rowspan="1">{{ $service->bhp_kw }}</td>
				<td rowspan="1" colspan="2">{{ $service->principal }}</td>
			</tr>
		@endforeach

		<tr>
			<td colspan="9">Have you ever been sued in court or before any Administrative body?</td>
			<td>Yes</td>
			<td></td>
			<td>No</td>
			<td></td>
			<td></td>
		</tr>

		<tr></tr>

		<tr>
			<td colspan="7">If "yes", give particulars</td>
			<td colspan="7"></td>
		</tr>

		<tr>
			<td colspan="7">Who recommended you to this company?</td>
			<td colspan="7"></td>
		</tr>

		<tr></tr>
		<tr>
			<td colspan="14" rowspan="2">I, undersigned, hereby certify that all informations provided herein are true and correct.  Any misrepresentation may cause of dismissal at all the costs burden to myself.</td>
		</tr>

		<tr></tr>
		<tr></tr>

		<tr>
			<td colspan="7"></td>
			<td colspan="6">{{-- Border --}}</td>
		</tr>
		<tr>
			<td colspan="8"></td>
			<td colspan="4">Signature of Applicant</td>
			<td colspan="2"></td>
		</tr>
	</tbody>
</table>