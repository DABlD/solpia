@php
@endphp

<table>
	<tr>
		<td>CHAPTER  2</td>
		<td colspan="10">외국해원 표준근로계약서</td>
	</tr>

	<tr>
		<td colspan="11">2.1.2 PHILIPPINE CREW(Non Korea Flag Vessel)</td> // WILL BE EDITED TO RICH TEXT DUE TO CUSTOM UNDERLINE
	</tr>

	<tr>
		<td colspan="11">Seafarer`s Employment Agreement</td>
	</tr>

	<tr>
		<td colspan="11">The following parties to the SEA agree to fully comply with the terms stated hereinafter.</td>
	</tr>

	<tr>
		<td colspan="11">1.	Seafarer/Shipowner/Ship Manager/Agent/Ship</td> // RICH TEXT
	</tr>

	{{-- SEAFARER --}}
	<tr>
		<td rowspan="2">Seafarer</td>
		<td colspan="3">Name</td>
		<td colspan="3">{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}</td>
		<td colspan="2">Date of Birth</td>
		<td colspan="2">{{ $data->user->birthday != "" ? $data->user->birthday->format('d-M-Y') : '' }}</td>
	</tr>

	<tr>
		<td colspan="3">Capacity</td>
		<td colspan="3">{{ $data->position }}</td>
		<td colspan="2">Birthplace/Nationality</td>
		<td colspan="2">{{ $data->birth_place }} / Filipino</td>
	</tr>

	{{-- SHIPOWNER --}}
	<tr>
		<td rowspan="6">Shipowner</td>
		<td rowspan="3">Beneficial</td>
		<td colspan="2">Company</td>
		<td colspan="7">{{ $shipownerA['company'] ?? "-" }}</td>
	</tr>

	<tr>
		<td colspan="2">President</td>
		<td colspan="7">{{ $shipownerA['president'] ?? "-" }}</td>
	</tr>

	<tr>
		<td colspan="2">Address</td>
		<td colspan="7">{{ $shipownerA['address'] ?? "-" }}</td>
	</tr>

	<tr>
		<td rowspan="3">MLC</td>
		<td colspan="2">Company</td>
		<td colspan="7">{{ $shipownerB['company'] ?? "-" }}</td>
	</tr>

	<tr>
		<td colspan="2">President</td>
		<td colspan="7">{{ $shipownerB['president'] ?? "-" }}</td>
	</tr>

	<tr>
		<td colspan="2">Address</td>
		<td colspan="7">{{ $shipownerB['address'] ?? "-" }}</td>
	</tr>

	{{-- SHIP MANAGER --}}
	<tr>
		<td rowspan="2">Ship Manager</td>
		<td colspan="3">Company</td>
		<td colspan="7">{{ $shipmanager['company'] ?? "-" }}</td>
	</tr>

	<tr>
		<td colspan="3">Address</td>
		<td colspan="7">{{ $shipmanager['address'] ?? "-" }}</td>
	</tr>

	{{-- AGENT --}}
	<tr>
		<td rowspan="2">Agent</td>
		<td colspan="3">Company</td>
		<td colspan="7">Solpia Marine &#38; Ship Management, Inc.</td>
	</tr>

	<tr>
		<td colspan="3">Address</td>
		<td colspan="7">2019 San Marcelino St., Malate Manila, Philippines 1004</td>
	</tr>

	{{-- SHIP --}}
	<tr>
		<td rowspan="2">Ship</td>
		<td colspan="3">Ship name</td>
		<td colspan="3">{{ $data->vessel->name }}</td>
		<td colspan="2">G/T</td>
		<td colspan="2">{{ $data->vessel->gross_tonnage }}</td>
	</tr>

	<tr>
		<td colspan="3">Year Built</td>
		<td colspan="3">{{ $data->vessel->year_build }}</td>
		<td colspan="2">Flag</td>
		<td colspan="2">{{ $data->vessel->flag }}</td>
	</tr>

	{{-- END --}}

	{{-- COMMENCEMENT AND TERMINATION --}}
	<tr>
		<td colspan="11">2.	Period &#38; Termination of the agreement</td>
	</tr>

	<tr>
		<td rowspan="2">Period</td>
		<td colspan="3">Date of commencement</td>
		<td colspan="7">{{ now()->parse($data->effective_date)->format('d-M-Y') }}</td>
	</tr>

	<tr>
		<td colspan="3">Date of termination</td>
		<td colspan="7">{{ now()->parse($data->effective_date)->add($data->employment_months, 'months')->format('d-M-Y') }}</td>
	</tr>

	<tr>
		<td>Early termination</td>
		<td colspan="10">
			1)	Where the shipowner intends to cancel a Seafarers' employment agreement, he/she shall inform the seafarer of
			<br style='mso-data-placement:same-cell;' />
			ㅤthe cancellation of the Seafarers' employment agreement in writing with a period of advance notice of not less
			<br style='mso-data-placement:same-cell;' />
			ㅤthan 30 days.
			<br style='mso-data-placement:same-cell;' />
			2)	The seafarer shall give a notice to shipowner for their early termination in accordance with the flag state
			<br style='mso-data-placement:same-cell;' />
			ㅤregulations as follows.
			<br style='mso-data-placement:same-cell;' />
			ㅤ(1) Korea : Within 30days  (2) Panama : Minimum of 15 days in advance
			<br style='mso-data-placement:same-cell;' />
			ㅤ(3) Marshall Island / Liberia / Malta / Isle of Man : Minimum of 7 days in advance
		</td>
	</tr>

	{{-- WAGES --}}
	<tr>
		<td colspan="11">3.	Wages</td>
	</tr>

	<tr>
		<td rowspan="4">
			Basic pay 
			<br style='mso-data-placement:same-cell;' />
			&#38; allowance
		</td>
		<td colspan="3">Basic wage</td>
		<td colspan="3">Fixed/Guaranteed Overtime Allowance</td> {{-- RICH TEXTED --}}
		<td colspan="2">Fixed Supervisor Allowance</td>
		<td colspan="2">Subsistence Allowance</td>
	</tr>

	<tr>
		<td colspan="3">
			${{ $data->wage->basic ? ($data->wage->basic) : 0 }}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
		<td colspan="3">
			${{ $data->wage->fot ?? $data->wage->ot ?? 0 }}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
		<td colspan="2">
			${{ $data->wage->sup_allow ? number_format($data->wage->sup_allow) : 0 }}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
		<td colspan="2">
			${{ $data->wage->sub_allow ? number_format($data->wage->sub_allow) : 0 }}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
	</tr>

	<tr>
		<td colspan="3">Owner's Guaranteed Overtime Allowance</td>
		<td colspan="3">Seniority Allowance</td>
		<td colspan="2">Provident Fund (Contract Completion Bonus)</td> {{-- RICH TEXTED --}}
		<td colspan="2">Others</td>
	</tr>

	@php
		$seniority = $data->pro_app->seniority;

		$spay = 0;
		if($data->wage){
			$srpay = json_decode($data->wage->sr_pay);
			
			if($seniority > 1){
				$spay = $srpay[$seniority - 2];
			}
		}
	@endphp

	<tr>
		<td colspan="3">
			${{ $data->wage->owner_allow ?? 0}}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
		<td colspan="3">
			${{ $spay }}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
		<td colspan="2">
			${{ $data->wage->retire_allow ?? 0 }}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
		<td colspan="2">
			${{ $data->wage->other_allow ?? 0 }}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
	</tr>
</table>