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

	$cba = "IBF KFSU CA(BBCHP)";
	$leave = 9;

	$v = $data->vessel->name;
	$tFot = null;
	if(in_array($v, ['M/V DONG-A OKNOS', 'M/V DONG-A EOS'])){
		$allowance = 11.1;
	}
	elseif(in_array($v, ['M/V KMARIN ULSAN', 'M/V KMARIN MELBOURNE'])){
		$allowance = 12;
	}
	elseif(in_array($v, ['M/V KMARIN AZUR', "M/V BOKM SHANGHAI", 'M/V BOKM NINGBO'])){
		// $allowance = 11;
		$cba = "IBF FKSU/AMOSUP-KSA CBA";
	}
	elseif(in_array($v, ['M/V KMARIN ATLANTICA'])){
		$allowance = 12;
		$cba = "IBF FKSU/AMOSUP-KSA CBA";
	}
	elseif(in_array($v, ['M/V DAEBO GLADSTONE'])){
		$allowance = 12;
		$cba = "IBF FKSU CA(BBCHP)";
	}
	elseif(in_array($v, ['M/V GLOVIS COUNTESS'])){
		$cba = "IBF FKSU CA(BBCHP)";
		$allowance = 12;
		$leave = 10;
	}
	elseif(in_array($v, ['M/V DONG-A GLAUCOS'])){
		$cba = "IBF FKSU CA(BBCHP)";
		$allowance = 12;
	}
	elseif(in_array($v, ['M/V DONG-A METIS'])){
		$allowance = 12;
		$cba = "IBF FKSU CA(BBCHP)";
	}

	$pp = null;
	$sb = null;

	foreach($data->document_id as $docu){
		if($docu->type == "PASSPORT"){
			$pp = $docu;
		}
		elseif($docu->type == "SEAMAN'S BOOK"){
			$sb = $docu;
		}
	}

	$position = $data->pro_app->rank->importName;
	$position = str_replace('ASST.', 'ASSISTANT', $position);
	$position = str_replace('ENGR', 'ENGINEER', $position);
@endphp

<table>
	<tr>
		<td colspan="9" style="height: 40px; font-size: 14px; {{ $bc }}">
			SEAFARER'S EMPLOYMENT AGREEMENT
		</td>
	</tr>

	<tr>
		<td colspan="9">
			ㅤThis Employment Agreement is entered into between the Seafarer and the Shipowner(or the Employer on behalf of the Shipowner)
		</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $bc }}">Registered Owner</td>
		<td style="{{ $center }}">Company</td>
		<td colspan="7">{{ $data->shipowner }}</td>
	</tr>

	<tr>
		<td style="{{ $center }}">Address</td>
		<td colspan="7">{{ $data->sAddress }}</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $bc }}">
			MLC
			Shipowner
			(Manager)
		</td>
		<td style="{{ $center }}">Company</td>
		<td colspan="7">KMARIN Ocean Services Corporation (KOSCO)</td>
	</tr>

	<tr>
		<td style="{{ $center }}">Address</td>
		<td colspan="7">5F(KUKDONG Bldg), 67, Chungjang-daero 5beon-gil, Jung-gu, Busan, 48934, Republic of Korea</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $bc }}">Manning Agency</td>
		<td style="{{ $center }}">Company</td>
		<td colspan="7">SOLPIA MARINE AND SHIP MANAGEMENT, INC.</td>
	</tr>

	<tr>
		<td style="{{ $center }}">Address</td>
		<td colspan="7">Solpia Bldg, #2019 San Marcelino St. Malate, Manila, Philippines 1004</td>
	</tr>

	<tr>
		<td rowspan="4" style="{{ $bc }}">Seafarer</td>
		<td style="{{ $center }}">Name</td>
		<td colspan="3">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td style="{{ $center }}">Position</td>
		<td colspan="3" style="{{ $center }}">{{ $position }}</td>
	</tr>

	<tr>
		<td style="{{ $center }} font-size: 8px;">Date of Birth</td>
		<td colspan="3">
			{{ $data->user->birthday ? $data->user->birthday->format('d-M-Y') : "N/A" }}
		</td>
		<td style="{{ $center }}">Birthplace</td>
		<td colspan="3" style="{{ $center }}">{{ $data->birth_place }}</td>
	</tr>

	<tr>
		<td style="{{ $center }}">Passport</td>
		<td colspan="3">
			{{ $pp ? $pp->number . ' / ' . $pp->expiry_date->format('d-M-Y') : " - " }}
		</td>
		<td style="{{ $center }}">Seaman's Bk</td>
		<td colspan="3" style="{{ $center }} font-size: 8px;">
			{{ $sb ? $sb->number . ' / ' . $sb->expiry_date->format('d-M-Y') : " - " }}
		</td>
	</tr>

	<tr>
		<td style="{{ $center }}">Nationality</td>
		<td colspan="3">
			Filipino
		</td>
		<td style="{{ $center }}">Applicable CBA</td>
		<td colspan="3" style="{{ $center }} font-size: 8px;">{{ $cba }}</td>
	</tr>

	{{-- @php
		// FIND PASSPORT
		$pp = null;
		$sb = null;
		foreach($data->document_id as $id){
			if($id->type == "PASSPORT"){
				$id->issue = $id->issue_date ? now()->parse($id->issue_date)->format("Y-m-d") : "";
				$id->expiry = $id->expiry_date ? now()->parse($id->expiry_date)->format("Y-m-d") : "UNLIMITED";
				$pp = $id;
			}
			if($id->type == "SEAMAN'S BOOK"){
				$id->issue = $id->issue_date ? now()->parse($id->issue_date)->format("Y-m-d") : "";
				$id->expiry = $id->expiry_date ? now()->parse($id->expiry_date)->format("Y-m-d") : "UNLIMITED";
				$sb = $id;
			}
		}
	@endphp --}}

	<tr>
		<td rowspan="2" style="{{ $bc }}">Vessel</td>
		<td style="{{ $center }}">Name</td>
		<td colspan="3">{{ $data->vessel->name }}</td>
		<td style="{{ $center }}">Gross Ton</td>
		<td colspan="3" style="{{ $center }}">{{ $data->vessel->gross_tonnage }} G/T</td>
	</tr>

	<tr>
		<td style="{{ $center }}">Flag</td>
		<td colspan="3">{{ $data->vessel->flag }}</td>
		<td style="{{ $center }}">Year of Built</td>
		<td colspan="3" style="{{ $center }}">{{ $data->vessel->year_build }}</td>
	</tr>

	<tr>
		<td rowspan="3" style="{{ $bc }}">Period</td>
		<td style="{{ $center }}">From</td>
		<td colspan="3">{{ now()->parse($data->effective_date)->format('d-M-y') }}</td>
		<td style="{{ $center }}">To</td>
		<td colspan="3" style="{{ $center }}">{{ now()->parse($data->effective_date)->add($data->employment_months, 'months')->format('d-M-y') }}</td>
	</tr>

	<tr>
		<td style="{{ $center }}">Place</td>
		<td colspan="3">MANILA, PHILIPPINES</td>
		<td style="{{ $center }}">Date</td>
		<td colspan="3" style="{{ $center }}">{{ now()->parse()->format('d-M-Y') }}</td>
	</tr>

	<tr>
		<td colspan="8" style="height: 200px;">
			1. The probationary period shall only apply during the first term of employment and shall be 10 weeks.
			<br style='mso-data-placement:same-cell;' />
			During this period both the seafarer and/or the Company shall be entitled to terminate the
			<br style='mso-data-placement:same-cell;' />
			employment prior to the expiry of the contract during this period.
			<br style='mso-data-placement:same-cell;' />
			2. The periods of employment shall be from the date of departure of his residence (or a place where
			<br style='mso-data-placement:same-cell;' />
			he concluded an employment agreement) to the date of arrival in country of his residence (or a place
			<br style='mso-data-placement:same-cell;' />
			where he concluded an employment agreement) after terminate the Seafarer's employment agreement,
			<br style='mso-data-placement:same-cell;' />
			unless terminated for just cause or causes enumerated in this agreement.
			<br style='mso-data-placement:same-cell;' />
			3. Seafarer or shipowner shall provide minimum notice periods in writings for the early
			<br style='mso-data-placement:same-cell;' />
			termination of the seafarer's employment agreement. The minimum notice shall not be less than 30
			<br style='mso-data-placement:same-cell;' />
			days.
			<br style='mso-data-placement:same-cell;' />
			4. Where a seafarer's employment agreement is terminated while a vessel is out at sea, agreement
			<br style='mso-data-placement:same-cell;' />
			shall be deemed to continue until the ship enters the next port and unloads all cargoes to be
			<br style='mso-data-placement:same-cell;' />
			unloaded or lands all passengers who are to leave the ship at the port.
			<br style='mso-data-placement:same-cell;' />
			5. Seafarer's employment agreements shall continue to have effect while seafarer is held
			<br style='mso-data-placement:same-cell;' />
			captive on or off the ship as a result of acts of piracy or armed robbery against ships, regardless of
			<br style='mso-data-placement:same-cell;' />
			whether the date fixed for its expiry has passed or either party has given notice to suspend or
			<br style='mso-data-placement:same-cell;' />
			terminate it.
		</td>
	</tr>

	<tr>
		<td rowspan="5" style="{{ $bc }}">Wages</td>
		<td colspan="2">A) Basic Wage</td>
		<td colspan="2" style="{{ $center }}">${{ $data->wage->basic ?? 0 }}</td>
		<td colspan="2">
			B.) Guaranteed Overtime Allowance (BW/173x1.25x103hrs)
		</td>
		<td colspan="2" style="{{ $center }}">${{ $data->wage->fot ?? $data->wage->ot ?? 0 }}</td>
	</tr>

	<tr>
		<td colspan="2">C) Supervisor Allowance</td>
		<td colspan="2" style="{{ $center }}">${{ $data->wage->sup_allow ?? 0 }}</td>
		<td colspan="2">D) Monthly Wage (A+B+C)</td>
		@php
			$monthly = ($data->wage->basic ?? 0) + ($data->wage->fot ?? $data->wage->ot ?? 0) + ($data->wage->sup_allow ?? 0)
		@endphp
		<td colspan="2" style="{{ $center }}">${{ $monthly }}</td>
	</tr>

	<tr>
		<td colspan="2">E) Leave Pay</td>
		<td colspan="2" style="{{ $center }}">${{ $data->wage->leave_pay ?? 0 }}</td>
		<td colspan="2">F) Subsistence Allowance</td>
		<td colspan="2" style="{{ $center }}">${{ $data->wage->sub_allow ?? 0 }}</td>
	</tr>

	<tr>
		<td colspan="2">G) Owner's Allowance</td>
		<td colspan="2" style="{{ $center }}">${{ $data->wage->owner_allow ?? 0 }}</td>
		<td colspan="2">H) Provident Fund</td>
		<td colspan="2" style="{{ $center }}">${{ $data->wage->other_allow ?? 0 }}</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $center }}">Monthly Total (D+E+F+G+H)</td>
		<td colspan="4" style="{{ $center }}">${{ ($monthly) + ($data->wage->leave_pay ?? 0) + ($data->wage->sub_allow ?? 0) + ($data->wage->owner_allow ?? 0) + ($data->wage->other_allow ?? 0) }}</td>
	</tr>

	<tr>
		<td style="{{ $bc }} height: 45px;">Wages</td>
		<td colspan="8">
			1. The calculation of Fixed(Guaranteed) Overtime Allowance is as follows
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤFixed(or Guaranteed) Overtime Allowance = A) Basic wage / 173hrs * 1.25 * 103hrs
			<br style='mso-data-placement:same-cell;' />
			2. The Overtime rate per hour = B) Fixed(or Guaranteed) Overtime Allowance / 103hrs
		</td>
	</tr>

	<tr>
		<td style="{{ $bc }} height: 65px;">Payment</td>
		<td colspan="8">
			1. Payment date : The shipowner pay seafarer's wage at the end of each calendar month. If the payment date falls on a
			<br style='mso-data-placement:same-cell;' />
			holiday, payment will be made on the day before the holiday).
			<br style='mso-data-placement:same-cell;' />
			2. Payment methods : The shipowner shall pay all or part of wages to seafarer or other person designated by seafarer by
			<br style='mso-data-placement:same-cell;' />
			means of deposit with a financial company, bank, etc.
		</td>
	</tr>

	<tr>
		<td style="{{ $bc }} height: 55px;">Paid Leave</td>
		<td colspan="8">
			1. The number of days of paid leave shall be {{ $leave }} days per a month of continuous service onboard.
			<br style='mso-data-placement:same-cell;' />
			2. The method which is calculation of leave pay as follows.
			<br style='mso-data-placement:same-cell;' />
			ㅤLeave Pay = (Basic wage) / 30 days x {{ $leave }}days
		</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $bc }}">Provision</td>
		<td colspan="2">Costs for food shall be</td>
		<td colspan="2">({{ $allowance }} US Dollars)</td>
		<td colspan="4">per person/day excluding shipment cost.</td>
	</tr>

	<tr>
		<td colspan="8" style="height: 55px;">
			2. During the seafarer's employment agreement period, having regard to the number of seafarers on board, their religious requirements and cultural practices, and the duration and nature of the voyage, shipowner shall provide seafarers with adequate, varied, balanced and nutritious meals and drinking water free of charge.
		</td>
	</tr>

	<tr>
		<td style="{{ $bc }} height: 130px;">Health and social security benefits</td>
		<td colspan="8">
			1. The shipowner shall ensure prompt disembarkation of seafarers in need of immediate medical care from the vessel and access to medical facilities ashore for the provision of appropriate treatment.
			<br style='mso-data-placement:same-cell;' />
			2. The shipowner shall provide all necessary appropriately-sized personal protective equipment and measures to prevent occupational accidents, injuries and diseases on board.
			<br style='mso-data-placement:same-cell;' />
			3. Where the seafarer has died during a vessel's voyage, the shipowner shall take measures to repatriate the body or ashes, in accordance with the wishes of the seafarer or their next of kin.
			<br style='mso-data-placement:same-cell;' />
			4. The shipowner shall provide medical care, Employment Injury and Sickness Benefit, Unemployment Benefit, Death/Disability Compensation, Pension Fund for Families of Deceased Seafarer(Survivor's Benefit) to the seafarer in accordance with Crew's National Law or Collective Bargaining Agreement.
		</td>
	</tr>

	<tr>
		<td style="{{ $bc }} height: 170px;">Hours of Work and Hours of Rest</td>
		<td colspan="8">
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
			2. This period of 24 hours shall begin at the time a seafarer starts work immediately after having had a period at least 6
			<br style='mso-data-placement:same-cell;' />
			consecutive hours off duty.
			<br style='mso-data-placement:same-cell;' />
			3. The hours of rest may be divided into no more than 2 periods, one of which shall be at least 6 hours in length, and the
			<br style='mso-data-placement:same-cell;' />
			interval between consecutive periods of rest shall not exceed 14 hours.
			<br style='mso-data-placement:same-cell;' />
			4. Shipowner shall provide a compensatory rest period, comparable to hours of work performed, for seafarers who have
			<br style='mso-data-placement:same-cell;' />
			performed necessary work although in a rest period or have been disturbed by call-outs to work during the normal period
			<br style='mso-data-placement:same-cell;' />
			of rest.
		</td>
	</tr>

	<tr>
		<td style="{{ $bc }} height: 170px;">Seafarer's entitlement to repatriation</td>
		<td colspan="8">
			1. Where the seafarer leaves at the port which is not a place of his residence nor a place where he concluded the
			<br style='mso-data-placement:same-cell;' />
			seafarer's employment agreement, a shipowner shall repatriate him to a place of his residence or a place where he
			<br style='mso-data-placement:same-cell;' />
			concluded the seafarer's employment agreements without delay at the expenses and on the responsibility of the
			<br style='mso-data-placement:same-cell;' />
			shipowner.
			<br style='mso-data-placement:same-cell;' />
			2. The seafarer shall be entitled to repatriation at the Company's expense on termination of employment.
			<br style='mso-data-placement:same-cell;' />
			3. Despite above 2, where a seafarer falls under any of the following cases, a shipowner may claim expenses incurred in
			<br style='mso-data-placement:same-cell;' />
			the repatriation against seafarer
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤ1) Where a seafarer leaves a ship at his/her discretion without a justifiable reason;
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤ2) Where a seafarer leaves a ship after he/she has been disciplined to leave the ship;
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤ3) here a seafarer falls under the reasons prescribed by a collective bargaining agreement
			<br style='mso-data-placement:same-cell;' />
			4. The maximum period the seafarer can be expected to serve onboard before being entitled to repatriation at
			<br style='mso-data-placement:same-cell;' />
			shipowner's expense is periods of seafarer's employment agreement and the entitlement to repatriation shall not lapse in
			<br style='mso-data-placement:same-cell;' />
			the situation that the seafarer is held captive in accordance with a collective bargaining agreement.
		</td>
	</tr>

	<tr>
		<td style="{{ $bc }} height: 120px;">Any facts not defined in this agreement</td>
		<td colspan="8">
			1. Shipowner shall compensate seafarers for monetary loss that they may incur as a result of the failure of the shipowner under this agreement to meet its obligations to them.
			<br style='mso-data-placement:same-cell;' />
			2. Shipowner shall provide appropiate means with internet access for social connectivity of the seafarer.
			<br style='mso-data-placement:same-cell;' />
			3. Any facts which are not defined in this agreement, these are complied with the law of flag state, crew's national law, and a collective bargaining agreement.
			<br style='mso-data-placement:same-cell;' />
			4. Before autographing to this agreement, the seafarer confirmed that no fees or other charges for recruitment or placement or for providing employment to seafarers are borne directly or indirectly, in whole or in part, to the agent of seafarer recruitment and placement. (Other than the cost of the passport or other similar personal travel documents.) If the seafarer found that, the fact should be noticed to the shipowner immediately.
		</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 35px;">
			In witness whereof, 2 copies of this agreement have been made and mutually signed by either parties thence each one of them are retained
			<br style='mso-data-placement:same-cell;' />
			by the each party.
			<br style='mso-data-placement:same-cell;' />
			And, seafarer has opportunity to review and seek advice on the terms and condition and freely accept them.
		</td>
	</tr>

	<tr>
		<td colspan="4" style="height: 80px;">SHIRLEY T. ERASQUIN</td>
		<td style="height: 80px;"></td>
		<td colspan="4" style="height: 80px;"></td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $center }} vertical-align: top;">for and on behalf of the shipowner of the vessel</td>
		<td></td>
		<td colspan="4" style="{{ $center }} vertical-align: top;">Signature of Seafarer</td>
	</tr>
</table>