@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$u = "text-decoration: underline;";
	$i = "font-style: italic;";
	$red = "color: #FF0000;";
	$bc = "$b $c";

	// dd($data);
@endphp

<table>
	<tr>
		<td style="height: 70px;" colspan="10"></td>
	</tr>

	<tr>
		<td colspan="10" style="{{ $bc }} {{ $u }} {{ $i }} font-size: 15px;">DE-BRIEFING FORM</td>
	</tr>

	<tr>
		<td colspan="10" style="{{ $bc }} {{ $u }} {{ $i }} {{ $red }}">To be filled up by Offsigning crew</td>
	</tr>

	<tr><td colspan="10"></td></tr>

	<tr>
		<td colspan="5" style="{{ $b }}">Rank/Name:</td>
		<td></td>
		<td colspan="4" style="{{ $b }}">Vessel Name:</td>
	</tr>

	<tr>
		<td colspan="5" style="height: 20px;">{{ $data->rank }} / {{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}</td>
		<td style="height: 20px;"></td>
		<td colspan="4" style="height: 20px;">{{ $data->vessel->name }}</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $b }}">Date Embarked:</td>
		<td></td>
		<td colspan="4" style="{{ $b }}">Date Disembarked:</td>
	</tr>

	<tr>
		<td colspan="5" style="height: 20px;">{{ now()->parse($data->data['joining_date'])->format('d-M-Y') }}</td>
		<td style="height: 20px;"></td>
		<td colspan="4" style="height: 20px;">{{ now()->parse($data->data['disembarkation_date'])->format('d-M-Y') }}</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $b }}">Reason for Signed Off:</td>
		<td></td>
		<td colspan="4" style="{{ $b }}">Date Arrived in Manila:</td>
	</tr>

	<tr>
		<td colspan="5" style="height: 20px;">{{ $data->data['remarks'] }}</td>
		<td style="height: 20px;"></td>
		<td colspan="4" style="height: 20px;">{{ $data->data['arrival_date'] != "" ? now()->parse($data->data['arrival_date'])->format('d-M-Y') : "" }}</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $b }}">Contact Tel. No and Address:</td>
		<td></td>
		<td colspan="4" style="{{ $b }}">Body Mass Index(BMI):</td>
	</tr>

	<tr>
		<td colspan="5" style="height: 20px;"></td>
		<td style="height: 20px;"></td>
		<td colspan="4" style="height: 20px;">WEIGHT: (Kg)</td>
	</tr>

	<tr>
		<td colspan="5" style="height: 20px;"></td>
		<td style="height: 20px;"></td>
		<td colspan="4" style="height: 20px;">HEIGHT: (cm)</td>
	</tr>

	<tr>
		<td colspan="5" style="height: 20px;"></td>
		<td style="height: 20px;"></td>
		<td colspan="4" style="height: 20px;">Total BMI:</td>
	</tr>

	<tr><td colspan="10"></td></tr>

	<tr>
		<td style="{{ $b }}">AA.</td>
		<td colspan="9">Willing to rejoin our company</td>
	</tr>

	<tr>
		<td colspan="3"></td>
		<td style="{{ $c }}">&#x2610;</td>
		<td>YES</td>
		<td style="{{ $c }}">&#x2610;</td>
		<td>NO</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="4">1) If yes, expected joining date (month):</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="4">1) If no, why?</td>
		<td colspan="4"></td>
	</tr>

	<tr><td colspan="10"></td></tr>

	<tr>
		<td style="{{ $b }}">BB.</td>
		<td colspan="9">Any special schedule on vacation?:</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td style="{{ $b }}">CC.</td>
		<td colspan="9">
			Please answer the following questions as objectively as you can, encircle the appropriate score
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="9">for the situation described.</td>
	</tr>

	<tr>
		<td colspan="7"></td>
		<td colspan="3" style="{{ $b }} {{ $i }}">Please check if yes or no.</td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">1.</td>
		<td colspan="6">Safe work practices / drills onboard?</td>
		<td style="{{ $c }}">&#x2610;</td>
		<td>Yes &#x2610;</td>
		<td>No</td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">2.</td>
		<td colspan="6">In-house training course prior joining onboard?</td>
		<td style="{{ $c }}">&#x2610;</td>
		<td>Yes &#x2610;</td>
		<td>No</td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">3.</td>
		<td colspan="6">Is this training course useful in applying in your job?</td>
		<td style="{{ $c }}">&#x2610;</td>
		<td>Yes &#x2610;</td>
		<td>No</td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">4.</td>
		<td colspan="6">Any training course do you need you should attend?</td>
		<td style="{{ $c }}">&#x2610;</td>
		<td>Yes &#x2610;</td>
		<td>No</td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;"></td>
		<td></td>
		<td colspan="5">If yes, what course or any suggestion?:</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">5.</td>
		<td colspan="6">Were you given any training onboard?</td>
		<td style="{{ $c }}">&#x2610;</td>
		<td>Yes &#x2610;</td>
		<td>No</td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">6.</td>
		<td colspan="6">Any minor accident, near misses and/or oil spill, any bad experience?</td>
		<td style="{{ $c }}">&#x2610;</td>
		<td>Yes &#x2610;</td>
		<td>No</td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;"></td>
		<td></td>
		<td colspan="5">If yes, what kind of?</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">7.</td>
		<td colspan="6">Any discord, conflicts, barriers from combination nationality?</td>
		<td style="{{ $c }}">&#x2610;</td>
		<td>Yes &#x2610;</td>
		<td>No</td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;"></td>
		<td></td>
		<td colspan="5">If yes, please details:</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">8.</td>
		<td colspan="6">Any injury, illness, medical treatment onboard?</td>
		<td style="{{ $c }}">&#x2610;</td>
		<td>Yes &#x2610;</td>
		<td>No</td>
	</tr>

	<tr>
		<td style="{{ $b }}"></td>
		<td></td>
		<td colspan="5">If yes, how many times?</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td style="height: 45px; {{ $c }}"></td>
		<td colspan="2" style="height: 45px; {{ $c }}"></td>
		<td style="height: 45px; {{ $c }}"></td>
		<td colspan="4" style="height: 45px; {{ $c }}"></td>
		<td colspan="2" style="height: 45px; {{ $c }}"></td>
	</tr>

	<tr>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}">Date</td>
		<td style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}">Signature Over Printed Name</td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="10" style="height: 140px;"></td>
	</tr>

	<tr>
		<td style="{{ $b }} height: 20px;">DD.</td>
		<td colspan="9" style="height: 30px;">How do you rate the situation onboard the vessel with respect to the indicated items?</td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $bc }} height: 30px;">OBSERVATIONS</td>
		<td style="{{ $bc }} height: 30px;">VERY GOOD</td>
		<td style="{{ $bc }} height: 30px;">GOOD</td>
		<td style="{{ $bc }} height: 30px;">FAIR</td>
		<td style="{{ $bc }} height: 30px;">POOR</td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">9.</td>
		<td colspan="5">Overall shipboard safety management</td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">10.</td>
		<td colspan="5">Leadership of Master and Chief Engineer</td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">11.</td>
		<td colspan="5">Discipline, camaraderie and teamwork among crew</td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">12.</td>
		<td colspan="5">Adequacy and Food quality</td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">13.</td>
		<td colspan="5">Rest period and Entertainment onboard</td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">14.</td>
		<td colspan="5">Solpia Crews preformance quality onboard the vessel</td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
	</tr>

	<tr>
		<td style="{{ $b }} height: 30px;">EE.</td>
		<td colspan="9" style="height: 30px;">How do you rate the services of the company throughout your contract and transaction with office staff.</td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $bc }} height: 30px;">OBSERVATIONS</td>
		<td style="{{ $bc }} height: 30px;">VERY GOOD</td>
		<td style="{{ $bc }} height: 30px;">GOOD</td>
		<td style="{{ $bc }} height: 30px;">FAIR</td>
		<td style="{{ $bc }} height: 30px;">POOR</td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">15.</td>
		<td colspan="5">Crew relation with Office staff</td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">16.</td>
		<td colspan="5">Office staff relations with crew family</td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">17.</td>
		<td colspan="5">Allotment / Special remittance processing</td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
	</tr>

	<tr>
		<td style="{{ $b }} text-align: left;">18.</td>
		<td colspan="5">Office attendance to official request from crew onboard</td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
		<td style="{{ $c }}"></td>
	</tr>

	<tr>
		<td style="{{ $b }} height: 30px;">FF.</td>
		<td colspan="9" style="height: 30px;">Do you have any complaints, comments or suggestions regarding any matter indcated in item EE.?</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="4"></td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="4" style="{{ $c }}">Signature Over Printed Name</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="10" style="{{ $bc }} {{ $i }} font-size: 14px;">THANK YOU VERY MUCH!</td>
	</tr>

	<tr>
		<td colspan="10" style="{{ $bc }} {{ $i }} {{ $red }}" height="30px;">FOR COMPANY PERSONNEL USE ONLY</td>
	</tr>

	<tr>
		<td colspan="4">A.) Documents Submitted</td>
		<td colspan="5">Remarks</td>
	</tr>

	@php
		$expiry = "---";
		$docu = $data->document_id->filter(function($temp){
			return $temp->type == "SEAMAN'S BOOK";
		});

		if(sizeof($docu) && $docu->first()->expiry_date){
			$expiry = now()->parse($docu->first()->expiry_date)->format('d-M-Y');
		}
	@endphp
	<tr>
		<td style="{{ $c }}">&#x2610;</td>
		<td>SIRB</td>
		<td colspan="2">
			Validity:
			{{ $expiry }}
		</td>
		<td colspan="6"></td>
	</tr>

	@php
		$expiry = "---";
		$docu = $data->document_id->filter(function($temp){
			return $temp->type == "PASSPORT";
		});

		if(sizeof($docu) && $docu->first()->expiry_date){
			$expiry = now()->parse($docu->first()->expiry_date)->format('d-M-Y');
		}
	@endphp
	<tr>
		<td style="{{ $c }}">&#x2610;</td>
		<td>PPRT</td>
		<td colspan="2">
			Validity:
			{{ $expiry }}
		</td>
		<td colspan="6"></td>
	</tr>

	@php
		$expiry = "---";
		$docu = $data->document_id->filter(function($temp){
			return $temp->type == "US-VISA";
		});

		if(sizeof($docu) && $docu->first()->expiry_date){
			$expiry = now()->parse($docu->first()->expiry_date)->format('d-M-Y');
		}
	@endphp
	<tr>
		<td style="{{ $c }}">&#x2610;</td>
		<td>US VISA</td>
		<td colspan="2">
			Validity:
			{{ $expiry }}
		</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td style="{{ $c }}">&#x2610;</td>
		<td colspan="3">Training Record Book (TRB)</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="10" style="{{ $b }}">Additional Remarks:</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="10">B.) Accounting Department</td>
	</tr>

	<tr>
		<td style="{{ $c }}">&#x2610;</td>
		<td colspan="9">Final Wage Payment</td>
	</tr>

	<tr>
		<td style="{{ $c }}">&#x2610;</td>
		<td colspan="9">Own-will Case, refundable expenses</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $bc }} text-decoration: underline;">Evaluator</td>
		<td colspan="8" style="{{ $bc }} text-decoration: underline;">Remarks:</td>
	</tr>

	<tr>
		<td colspan="2" style="text-align: left;">1.</td>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="2" style="text-align: left;">2.</td>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="2" style="text-align: left;">3.</td>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="2" style="text-align: left;">4.</td>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="10" style="height: 7.5"></td>
	</tr>

	<tr>
		<td colspan="4" style="height: 20px;">Discuss Schedule of Next Assignment</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="4" style="height: 20px;">Performance Evaluation Rate (Vessel)</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="4" style="height: 20px;">Welding Knowledge (ENGINE CREW)</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $bc }} height: 40px;">OBSERVATION</td>
		<td colspan="2" style="{{ $bc }} height: 40px;">SATISFACTIRY</td>
		<td style="{{ $bc }} height: 40px;">GOOD</td>
		<td style="{{ $bc }} height: 40px;">FAIR</td>
		<td style="{{ $bc }} height: 40px;">POOR</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $bc }} height: 30px;"></td>
		<td colspan="2" style="{{ $bc }} height: 30px;"></td>
		<td style="{{ $bc }} height: 30px;"></td>
		<td style="{{ $bc }} height: 30px;"></td>
		<td style="{{ $bc }} height: 30px;"></td>
		<td colspan="2" style="height: 30px;"></td>
	</tr>
</table>