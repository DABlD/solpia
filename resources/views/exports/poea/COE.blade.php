@php
	$b = "font-weight: bold";
	$c = "text-align: center;";
	$bc = "$b$c";
@endphp

<table>
	<tr>
		<td colspan="5">Top Copy - Seafarer</td>
		<td colspan="5">Pink Copy - Ship's File</td>
		<td colspan="5">Green Copy - ITF London</td>
		<td colspan="5">Yellow Copy - Company File</td>
	</tr>

	<tr>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }}">
			SEAFARER'S EMPLOYMENT CONTRACT
		</td>
	</tr>

	<tr>
		<td>Date</td>
		<td style="{{ $c }}"></td>
		<td>and agree to be effective from</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="5" style="height: 10px;"></td>
	</tr>

	<tr>
		<td colspan="4">This Employment Contract is entered into between the Seafarer and the Owner/Agent of the Owner of the Ship</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="4">(hereinafter called the Company.)</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $b }}">THE SEAFARER</td>
	</tr>

	<tr>
		<td colspan="3">‎‎Surname</td>
		<td colspan="2">‎‎Given Names</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $c }}">{{ $data->user->lname }}</td>
		<td colspan="2" style="{{ $c }}">{{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}</td>
	</tr>

	<tr>
		<td colspan="5">‎‎Full home address</td>
	</tr>

	<tr>
		<td colspan="5" style="height: 40px;" style="{{ $c }}">
			{{ $data->user->address }}
		</td>
	</tr>

	<tr>
		<td colspan="3">‎‎Position:</td>
		<td colspan="2">‎‎Medicial certificate issued on:</td>
	</tr>

	@php
		$doc = isset($data->document_med_cert->{"MEDICAL CERTIFICATE"}) ? $data->document_med_cert->{"MEDICAL CERTIFICATE"} : null;
	@endphp

	<tr>
		<td colspan="3" style="{{ $c }}">{{ $data->pro_app->rank->abbr }}</td>
		<td colspan="2" style="{{ $c }}">{{ $doc ? $doc->issue_date ? $doc->issue_date->format("F j, Y") : "-" : "-" }}</td>
	</tr>

	<tr>
		<td colspan="3">‎‎Estimated time of taking up position:</td>
		<td colspan="2">‎‎Port where position is taken up:</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $c }}">{{ $data->req["employment_months"] }}</td>
		<td colspan="2" style="{{ $c }}">{{ $data->req["pointOfHire"] }}</td>
	</tr>

	<tr>
		<td colspan="3">‎‎Nationality:</td>
		<td colspan="2">‎‎Passport no:</td>
	</tr>

	@php
		$doc = isset($data->document_id->{"PASSPORT"}) ? $data->document_med_cert->{"PASSPORT"} : null;
	@endphp

	<tr>
		<td colspan="3" style="{{ $c }}">FILIPINO</td>
		<td colspan="2" style="{{ $c }}">{{ $doc ? $doc->no : "-" }}</td>
	</tr>

	<tr>
		<td colspan="3">‎‎Date of birth:</td>
		<td colspan="2">‎‎Seaman's book no:</td>
	</tr>

	@php
		$doc = isset($data->document_id->{"SEAMAN'S BOOK"}) ? $data->document_med_cert->{"SEAMAN'S BOOK"} : null;
	@endphp

	<tr>
		<td colspan="3" style="{{ $c }}">{{ $data->user->birthday ? $data->user->birthday->format("F j, Y") : "-" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $doc ? $doc->no : "-" }}</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $b }}">THE EMPLOYER</td>
	</tr>

	<tr>
		<td colspan="5">‎‎Name:</td>
		<td colspan="5" style="{{ $c }}">SOLPIA MARINE AND SHIP MANAGEMENT, INC.</td>
	</tr>

	<tr>
		<td colspan="5">‎‎Address:</td>
		<td colspan="5" style="{{ $c }}">SOLPIA MARINE 2019 SAN MARCELINO ST., COR QUIRINO AVE. MALATE, MANILA.</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $b }} height: 40px;">THE SHIP</td>
	</tr>

	<tr>
		<td colspan="4">‎‎Name:</td>
		<td>‎‎IMO:</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $c }}">{{ $data->pro_app->vessel->name }}</td>
		<td style="{{ $c }}">{{ $data->pro_app->vessel->imo }}</td>
	</tr>

	<tr>
		<td colspan="3">‎‎Flag:</td>
		<td colspan="2">‎‎Port of Registry:</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $c }}">{{ $data->pro_app->vessel->flag }}</td>
		<td colspan="2" style="{{ $c }}">{{ $data->pro_app->vessel->flag }}</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $b }}">TERMS OF THE CONTRACT</td>
	</tr>

	<tr>
		<td colspan="2">‎‎Period of employment:</td>
		<td colspan="2">‎‎Wages from and including:</td>
		<td>‎‎Basic hours of work per week</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $c }}">{{ $data->req["employment_months"] }}</td>
		<td colspan="2" style="{{ $c }}">UPON DEPARTURE</td>
		<td style="{{ $c }}">{{ $data->pro_app->vessel->work_hours }}</td>
	</tr>

	<tr>
		<td colspan="2">‎‎Basic monthly wage:</td>
		<td colspan="2">‎‎Month overtime hours guaranteed):</td>
		<td>‎‎Overtime rate for hours worked in excess of 103 hrs:</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $c }}">${{ $data->wage->basic ?? 0 }}</td>
		<td colspan="2" style="{{ $c }}">{{ $data->wage->ot_hours }}</td>
		<td style="{{ $c }}">{{ $data->wage->ot_per_hour }} per hour</td>
	</tr>
</table>