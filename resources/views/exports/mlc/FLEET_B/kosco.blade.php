@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	$blue = "color: #0000FF;";
	$bc = "$bold $center";

	// $wage = function($label, $wage){
	// 	$blue = "";
	// 	if(str_starts_with($label, 'B') || str_starts_with($label, 'C') || str_starts_with($label, 'D') || str_starts_with($label, 'F') || str_starts_with($label, 'G')){
	// 		$blue = "color: #0000FF;";
	// 	}

	// 	echo "
	// 		<tr>
	// 			<td colspan='5' style='$blue'> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎$label</td>
	// 			<td colspan='2' style='text-align: center;'>$wage</td>
	// 			<td></td>
	// 			<td>USD / MONTH</td>
	// 		</tr>
	// 	";
	// }
	$allowance = 12.0;

	$v = $data->vessel->name;
	if(in_array($v, ['M/V DONG-A OKNOS', 'M/V DONG-A EOS', 'M/V GLOVIS COUNTESS', 'M/V DONG-A GLAUCOS', 'M/V DONG-A METIS'])){
		$allowance = 11.1;
	}
	elseif(in_array($v, ["M/V BOKM SHANGHAI", 'M/V BOKM NINGBO', 'M/V KMARIN AZUR', 'M/V KMARIN ATLANTICA', 'M/V KMARIN ULSAN', 'M/V KMARIN MELBOURNE'])){
		$allowance = 12;
	}
	elseif(in_array($v, ['M/V DAEBO GLADSTONE'])){
		$allowance = 11.5;
	}
@endphp

<table>
	<tr>
		<td colspan="8" style="height: 40px; font-size: 16px; {{ $bc }}">
			SEAFARER'S EMPLOYMENT AGREEMENT
		</td>
	</tr>

	<tr>
		<td colspan="8">
			This Employment Agreement is entered into between the Seafarer and the Shipowner(or the Employer on behalf of the Shipowner)
		</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $bc }}">Shipowner</td>
		<td style="{{ $center }}">Company</td>
		<td colspan="6">{{ $data->shipowner }}</td>
	</tr>

	<tr>
		<td style="{{ $center }}">Address</td>
		<td colspan="6">{{ $data->sAddress }}</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $bc }}">Ship Manager</td>
		<td style="{{ $center }}">Company</td>
		<td colspan="6">KMARIN Ocean Services Corporation (KOSCO)</td>
	</tr>

	<tr>
		<td style="{{ $center }}">Address</td>
		<td colspan="6">5F(KUKDONG Bldg), 67, Chungjang-daero 5beon-gil, Jung-gu, Busan, 48934, Republic of Korea</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $bc }}">Manning Agency</td>
		<td style="{{ $center }}">Company</td>
		<td colspan="6">SOLPIA MARINE AND SHIP MANAGEMENT, INC.</td>
	</tr>

	<tr>
		<td style="{{ $center }}">Address</td>
		<td colspan="6">Solpia Bldg, #2019 San Marcelino St. Malate, Manila, Philippines 1004</td>
	</tr>

	<tr>
		<td rowspan="3" style="{{ $bc }}">Seafarer</td>
		<td style="{{ $center }}">Name</td>
		<td colspan="3">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td style="{{ $center }}">Position</td>
		<td colspan="2" style="{{ $center }}">{{ $data->position }}</td>
	</tr>

	<tr>
		<td style="{{ $center }} font-size: 8px;">Date of Birth</td>
		<td colspan="3">
			{{ $data->user->birthday ? $data->user->birthday->format('d-M-Y') : "N/A" }}
		</td>
		<td style="{{ $center }}">Birthplace</td>
		<td colspan="2" style="{{ $center }}">{{ $data->birth_place }}</td>
	</tr>

	<tr>
		<td style="{{ $center }}">Nationality</td>
		<td colspan="3">
			Filipino
		</td>
		<td style="{{ $center }}">Applicable CBA</td>
		<td colspan="2" style="{{ $center }} font-size: 8px;">IBF KFSU CA(BBCHP)</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $bc }}">Vessel</td>
		<td style="{{ $center }}">Name</td>
		<td colspan="3">{{ $data->vessel->name }}</td>
		<td style="{{ $center }}">Gross Ton</td>
		<td colspan="2" style="{{ $center }}">{{ $data->vessel->gross_tonnage }}</td>
	</tr>

	<tr>
		<td style="{{ $center }}">Flag</td>
		<td colspan="3">{{ $data->vessel->flag }}</td>
		<td style="{{ $center }}">Year of Built</td>
		<td colspan="2" style="{{ $center }}">{{ $data->vessel->year_build }}</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">Period</td>
		<td style="{{ $center }}">From</td>
		<td colspan="3">{{ now()->parse($data->effective_date)->format('d-M-y') }}</td>
		<td style="{{ $center }}">To</td>
		<td colspan="2" style="{{ $center }}">{{ now()->parse($data->effective_date)->add($data->employment_months, 'months')->format('d-M-y') }}</td>
	</tr>

	<tr>
		<td colspan="8" style="height: 140px;">
			1. The probationary period shall only apply during the first term of employment and shall be 10 weeks. During this period both the seafarer and/or the Company shall be entitled to terminate the employment prior to the expiry of the contract during this period.
			<br style='mso-data-placement:same-cell;' />
			2. The periods of employment shall be from the date of departure of his residence to the date of arrival in country of his residence after terminate the Seafarer's employment agreement, unless terminated for just cause or causes enumerated in this agreement.
			<br style='mso-data-placement:same-cell;' />
			3. Seafarer or shipowner shall provide minimum notice periods in writings for the early termination of the seafarer's employment agreement. The minimum notice shall not be less than 30 days.
			<br style='mso-data-placement:same-cell;' />
			4. Seafarer's employment agreements shall continue to have effect while seafarer is held captive on or off the ship as a result of acts of piracy or armed robbery against ships, regardless of whether the date fixed for its expiry has passed or either party has given notice to suspend or terminate it.
		</td>
	</tr>

	<tr>
		<td rowspan="5" style="{{ $bc }}">Wages</td>
		<td colspan="2">A) Basic Wage</td>
		<td colspan="2" style="{{ $center }}">${{ $data->wage->basic ?? 0 }}</td>
		<td colspan="2">
			@if($data->vessel->id == 4643)
				B.) Fixed Overtime Allowance (BW/173x1.25x103hrs)
			@else
				B.) Fixed Overtime Allowance (BW/173x1.5x103hrs)
			@endif
		</td>
		<td style="{{ $center }}">${{ $data->wage->fot ?? $data->wage->ot ?? 0 }}</td>
	</tr>

	<tr>
		<td colspan="2">C) Supervisor Allowance</td>
		<td colspan="2" style="{{ $center }}">${{ $data->wage->sup_allow ?? 0 }}</td>
		<td colspan="2">D) Monthly Wage (A+B+C)</td>
		@php
			$monthly = ($data->wage->basic ?? 0) + ($data->wage->fot ?? $data->wage->ot ?? 0) + ($data->wage->sup_allow ?? 0)
		@endphp
		<td style="{{ $center }}">${{ $monthly }}</td>
	</tr>

	<tr>
		<td colspan="2">E) Leave Pay</td>
		<td colspan="2" style="{{ $center }}">${{ $data->wage->leave_pay ?? 0 }}</td>
		<td colspan="2">F) Subsistence Allowance</td>
		<td style="{{ $center }}">${{ $data->wage->sub_allow ?? 0 }}</td>
	</tr>

	<tr>
		<td colspan="2">G) Owner's Allowance</td>
		<td colspan="2" style="{{ $center }}">${{ $data->wage->owner_allow ?? 0 }}</td>
		<td colspan="2">H) Other Allowance</td>
		<td style="{{ $center }}">${{ $data->wage->other_allow ?? 0 }}</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $center }}">Monthly Total (D+E+F+G+H)</td>
		<td colspan="3" style="{{ $center }}">${{ ($monthly) + ($data->wage->leave_pay ?? 0) + ($data->wage->sub_allow ?? 0) + ($data->wage->owner_allow ?? 0) + ($data->wage->other_allow ?? 0) }}</td>
	</tr>

	<tr>
		<td style="{{ $bc }} height: 45px;">Paid Leave</td>
		<td colspan="7">
			1. The number of days of paid leave shall be 9 days per a month of continuous service onboard.
			<br style='mso-data-placement:same-cell;' />
			2. The method which is calculationf of leave pay as follows.
			<br style='mso-data-placement:same-cell;' />
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎Leave Pay = (Basic wage) / 30 days x 9days
		</td>
	</tr>

	<tr>
		<td style="{{ $bc }} height: 55px;">Payment</td>
		<td colspan="7">
			1. Payment date : The shipowner pay seafarer's wage at the end of each calendar month. If the payment date falls on a holiday, payment will be made on the day before the holiday).
			<br style='mso-data-placement:same-cell;' />
			2. Payment methods : The shipowner shall pay all or part of wages to seafarer or other person designated by seafarer by means of deposit with a financial company, bank, etc.
		</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">Provision</td>
		<td colspan="7">
			Costs for food shall be ({{ $allowance }} US Dollars) per person/day excluding shipment cost.
		</td>
	</tr>

	<tr>
		<td style="{{ $bc }} height: 60px;">Health and Social Security Benefits</td>
		<td colspan="7">
			The shipowner shall provide medical care, Employment Injury and Sickness Benefit, Unemployment Benefit, Death/Disability Compensation, Pension Fund for Families of Deceased Seafarer(Survivor's Benefit) to the seafarer in accordance with Crew's National Law or Collective Bargaining Agreement.
		</td>
	</tr>

	<tr>
		<td style="{{ $bc }} height: 160px;">Hours of Work and Hours of Rest</td>
		<td colspan="7">
			[Hours of Work]
			<br style='mso-data-placement:same-cell;' />
			1. The working hours shall be 8 hours per day, Monday to Friday, a total working hours of 40 hours per week.
			<br style='mso-data-placement:same-cell;' />
			2. The fixed overtime and the guaranteed overtime shall not be more than 103 hours per month.
			<br style='mso-data-placement:same-cell;' />
			[Hours of Rest]
			<br style='mso-data-placement:same-cell;' />
			1. The seafarer shall have a minimum of 10 hours rest in any 24 hour period and 77 hours in any seven-day period.
			<br style='mso-data-placement:same-cell;' />
			2. This period of 24 hours shall begin at the time a seafarer starts work immediately after having had a period at least 6 consecutive hours off duty.
			<br style='mso-data-placement:same-cell;' />
			3. The hours of rest may be divided into no more than 2 periods, one of which shall be at least 6 hours in length, and the interval between consecutive periods of rest shall not exceed 14 hours.
			<br style='mso-data-placement:same-cell;' />
			4. Shipowner shall provide a compensatory rest period, comparable to hours of work performed, for seafarers who have performed necessary work although in a rest period or have been disturbed by call-outs to work during the normal period of rest.
		</td>
	</tr>

	<tr>
		<td style="{{ $bc }} height: 160px;">Seafarer's Entitlement to Repatriation</td>
		<td colspan="7">
			1. Where the seafarer leaves at the port which is not a place of his residence nor a place where he concluded the seafarer's employment agreement, a shipowner shall repatriate him to a place of his residence or a place where he concluded the seafarer's employment agreements without delay at the expenses and on the responsibility of the shipowner.
			<br style='mso-data-placement:same-cell;' />
			2. Despite above 1, where a seafarer falls under any of the following cases, a shipowner may claim expenses incurred in the repatriation against seafarer
			<br style='mso-data-placement:same-cell;' />
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎1) Where a seafarer leaves a ship at his/her discretion without a justifiable reason;<br style='mso-data-placement:same-cell;' />
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎2) Where a seafarer leaves a ship after he/she has been disciplined to leave the ship;<br style='mso-data-placement:same-cell;' />
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎3) here a seafarer falls under the reasons prescribed by a collective bargaining agreement<br style='mso-data-placement:same-cell;' />
			3. The maximum period the seafarer can be expected to serve onboard before being entitled to repatriation at shipowner's expense is periods of seafarer's employment agreement and the entitlement to repatriation shall not lapse in the situation that the seafarer is held captive in accordance with a collective bargaining agreement.
		</td>
	</tr>

	<tr>
		<td style="{{ $bc }} height: 130px;">Any facts not defined in this agreement</td>
		<td colspan="7">
			1. Any facts which are not defined in this agreement, these are complied with the law of flag state, crew's national law, and a collective bargaining agreement. The parties to this agreement hereby stipulate that the terms and conditions laid down herein shall be subject to the applicable provisions of the Maritime Law and Regulations of the Republic of the Marshall Islands. Any dispute as to the terms and conditions of this agreement shall be resolved in accordance with the Maritime Law and Regulatios of the Republic of the Marshall Island.
			<br style='mso-data-placement:same-cell;' />
			2. Before autographing to this contract, the seafarer confirmed that no fees or other charges for recruitment or placement or for providing employment to seafarers are borne directly or indirectly, in whole or in part, to the agent of seafarer recruitment and placement. (Other than the cost of the passport or other similar personal travel documents.) If the seafarer found that, the fact should be noticed to the shipowner immediately.
		</td>
	</tr>

	<tr>
		<td colspan="8" style="height: 40px;">
			In witness whereof, 2 copies of this agreement have been made and mutually signed by either parties thence each one of them are retained by the each party.
			And, seafarer has opportunity to review and seek advice on the terms and condition and freely accept them.
		</td>
	</tr>

	<tr>
		<td colspan="4" style="height: 120px;"></td>
		<td style="height: 120px;"></td>
		<td colspan="3" style="height: 120px;"></td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $center }} vertical-align: top;">for and on behalf of the shipowner of the vessel</td>
		<td></td>
		<td colspan="3" style="{{ $center }} vertical-align: top;">Signature of Seafarer</td>
	</tr>

	<tr>
		<td colspan="2" rowspan="2">The place where and date when the seafarers' employment agreement is entered into</td>
		<td colspan="2" style="{{ $center }}">Place</td>
		<td colspan="4" style="{{ $center }}">MANILA, PHILIPPINES</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $center }}">Date</td>
		<td colspan="4" style="{{ $center }}">{{ now()->parse($data->date_processed)->format('d-M-y') }}</td>
	</tr>
</table>