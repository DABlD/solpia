@php
	// dd($data);
@endphp

<table>
	<tr>
		<td colspan="9">Seafarer Employment Contract</td>
	</tr>

	<tr><td colspan="9"></td></tr>

	<tr>
		<td colspan="9">The following parties to the contract agree to fully comply with the terms stated hereinafter.</td>
	</tr>

	<tr><td colspan="9"></td></tr>

	<tr>
		<td colspan="9">1. Contracting parties</td>
	</tr>

	<tr>
		<td rowspan="2">Shipowner</td>
		<td>Company Name</td>
		<td colspan="3">KSS LINE LTD.</td>
		<td>Tel.</td>
		<td colspan="3">+82-2-3702-2700</td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="7">8th Floor, Daeil Building, 12, Insadong-gil, Jongno-gu, Seoul, Korea</td>
	</tr>

	<tr>
		<td rowspan="2">Agent</td>
		<td>Company Name</td>
		<td colspan="3">Solpia Marine &#38; Ship Management, Inc.</td>
		<td>Tel.</td>
		<td colspan="3">+63-2 - 8567-1726</td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="7">2019 San Marcelino St., Malate Manila, Philippines 1004</td>
	</tr>

	<tr>
		<td rowspan="3">Seafarer</td>
		<td>Name</td>
		<td colspan="3">{{ $data->user->fullname2 }}</td>
		<td>Birth date</td>
		<td colspan="3">{{ isset($data->user->birthday) ? $data->user->birthday->format('d-M-y') : "-" }}</td>
	</tr>

	<tr>
		<td>Nationality</td>
		<td colspan="3">FILIPINO</td>
		<td>Birth place</td>
		<td colspan="3">{{ $data->birth_place }}</td>
	</tr>

	<tr>
		<td>Rank</td>
		<td colspan="3">{{ $data->pro_app->rank->abbr }}</td>
		<td>Sex</td>
		<td colspan="3">Male</td>
	</tr>

	<tr>
		<td rowspan="2">Vessel</td>
		<td>Name</td>
		<td colspan="3">{{ $data->vessel->name }}</td>
		<td>G/T</td>
		<td colspan="3">{{ $data->vessel->gross_tonnage }}</td>
	</tr>

	<tr>
		<td>IMO No.</td>
		<td colspan="3">{{ $data->vessel->imo }}</td>
		<td>Flag</td>
		<td colspan="3">{{ $data->vessel->flag }}</td>
	</tr>

	<tr>
		<td colspan="9">2. The place where and date when seafarer's employment agreement is entered into</td>
	</tr>

	<tr>
		<td>Place</td>
		<td colspan="8">{{ $data->pro_app->status == "On Board" ? "On-board" : "Manila, Philippines" }}</td>
	</tr>

	<tr>
		<td>Date</td>
		<td colspan="8">{{ now()->format('d-M-y') }}</td>
	</tr>

	<tr>
		<td colspan="9">3. Contract</td>
	</tr>

	<tr>
		<td colspan="4">The Duty in which the seafarer is to be employed</td>
		<td colspan="5">{{ $data->pro_app->rank->abbr }}</td>
	</tr>

	<tr>
		<td colspan="2">Duration of Contract</td>
		<td>From</td>
		<td colspan="2">{{ now()->parse($data->effective_date)->format('d-M-y') }}</td>
		<td>To</td>
		<td colspan="2">{{ now()->add($data->employment_months, 'months')->format('d-M-y') }}</td>
		<td>({{ $data->employment_months }} Months)</td>
	</tr>

	@php
		$wage = $data->wage;
		$basic = ceil($wage->basic ?? 0);
		// if(!in_array($data->id, [1243, 1422, 1657, 1703, 1730, 1773, 2013, 2672, 2767])){
		// 	dd($data->id, $basic, $wage);
		// }
		$ot = ceil($wage->fot ?? $wage->fot ?? 0);
		$lp = ceil($wage->leave_pay ?? 0);

		// allowances
		$sa = ceil($wage->sup_allow ?? 0);
		$so = ceil($wage->sub_allow ?? 0);
		$oa = ceil($wage->owner_allow ?? 0);
		$oa2 = ceil($wage->other_allow ?? 0);
		$ra = ceil($wage->retire_allow ?? 0);

		$total = $basic + $ot + $lp + $sa + $so + $oa + $ra + $oa2;

		$total = number_format($total, 2);
	@endphp

	<tr>
		<td rowspan="9" colspan="2">Basic pay and allowance</td>
		<td colspan="3">A) Basic wage</td>
		<td colspan="2">{{ $basic }}</td>
		<td colspan="2">US$ / Month</td>
	</tr>

	<tr>
		<td colspan="3">B) Fixed guaranteed overtime</td>
		<td colspan="2">{{ $ot }}</td>
		<td colspan="2">US$ / Month</td>
	</tr>

	<tr>
		<td colspan="3">C) Leave pay (9days)ㅤㅤ*See Note below 'Paid Leave'</td>
		<td colspan="2">{{ $lp }}</td>
		<td colspan="2">US$ / Month</td>
	</tr>

	<tr>
		<td colspan="3">D) Fixed supervisor allowance</td>
		<td colspan="2">{{ $sa }}</td>
		<td colspan="2">US$ / Month</td>
	</tr>

	<tr>
		<td colspan="3">E) Subsistence allowance</td>
		<td colspan="2">{{ $so }}</td>
		<td colspan="2">US$ / Month</td>
	</tr>

	<tr>
		<td colspan="3">F) Contract completion bonus</td>
		<td colspan="2">{{ $ra }}</td>
		<td colspan="2">US$ / Month</td>
	</tr>

	<tr>
		<td colspan="3">G) Special allowance</td>
		<td colspan="2">{{ $oa }}</td>
		<td colspan="2">US$ / Month</td>
	</tr>

	<tr>
		<td colspan="3">H) Monthly wage (A+B+C+D+E+F+G)</td>
		<td colspan="2">{{ $total }}</td>
		<td colspan="2">US$ / Month</td>
	</tr>

	<tr>
		<td colspan="3">I) FKSU Member fee (Deducted from crew wage)</td>
		<td colspan="2">40</td>
		<td colspan="2">US$ / Month</td>
	</tr>

	<tr>
		<td colspan="2">Payment date</td>
		<td colspan="7">15th of following month</td>
	</tr>

	<tr>
		<td>Payment methods</td>
		<td colspan="8">
			1. Payment will be paid to seafarer or credited to the bank account of seafarer. Some allotments should be remitted directly to persons nominated by the seafarers and remittance fee shall paid by company
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			2. When rate of exchange used where payment has been made in a currency from one agreed to, company official announcement exchange rate are applied.
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			3. Where a seafarer is held captive on or off the ship as a result of acts of piracy or armed robbery against ships, wages and other entitlements shall continue to be paid during the entire period of captivity and until the seafarer is released and duly repatriated or, where the seafarer dies while in captivity, until the date of death as determined in accordance with applicable national laws or regulations.
		</td>
	</tr>

	<tr>
		<td>Paid Leave</td>
		<td colspan="8">
			1. The number of Paid leave pursuant to above 1 shall be 9 days per I month of continuous services
			<br style='mso-data-placement:same-cell;' />
			2. It shall be settled within two weeks after arrival of the seafarers at the point of hire.
		</td>
	</tr>

	{{-- PAGE 2 --}}
	<tr>
		<td>Hours of Work/Rest</td>
		<td colspan="8">
			1. Hours of Work : 40 hours per week
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			2. Guaranteed Overtime : 103 hours per month
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			3. Hours of Rest
			<br style='mso-data-placement:same-cell;' />
			ㅤ1) The shipowner shall give the crew ten hours of rest or more in any 24hour period and seventy
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤseven hours of rest or more in any seven-day period
			<br style='mso-data-placement:same-cell;' />
			ㅤ2) Hours of rest may be divided into no more than two periods, one of which shall be at least six
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤhours in length, and the interval between consecutive periods of rest shall not exceed 14 hours.
			<br style='mso-data-placement:same-cell;' />
			ㅤ3) Musters and drills shall be conducted in a manner that minimizes the disturbance of rest periods
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤand does not induce fatigue
			<br style='mso-data-placement:same-cell;' />
			ㅤ4) When a seafarer is on call, such as when a machinery space is unattended, the seafarer shall have
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤan adequate compensatory rest period if the normal period of rest is disturbed by call-outs to work
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			4. Holiday of seafarers is Saturday and Sunday and Korean legal holiday, worker’s day and designated
			<br style='mso-data-placement:same-cell;' />
			ㅤday by Company.
		</td>
	</tr>

	<tr>
		<td>Termination of employment</td>
		<td colspan="8">
			1. Termination of employment as follow case;
			<br style='mso-data-placement:same-cell;' />
			ㅤ1) Finish of contract period
			<br style='mso-data-placement:same-cell;' />
			ㅤ2) Missing: One (1) month after the date of missing
			<br style='mso-data-placement:same-cell;' />
			ㅤ3) Death: The date of death (If died in foreign country, the date of retirement shall be the date when the
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤremains return home.)
			<br style='mso-data-placement:same-cell;' />
			ㅤ4) When Disciplinary Action has been relieved: Decided by ‘Shipboard Personnel’ Personnel Committee
			<br style='mso-data-placement:same-cell;' />
			ㅤ5) When the one left the vessel without due course: The date of disembarkation
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			2. In case where the shipowner terminates the contract, the required notice period shall be 30 days in advance, and notify the seafarer with a written document.
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			3. In case where the seafarer want to terminate the contract, he/she shall notify it between 15 days and 30 days to the shipowner.
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			4. A seafarer’s employment agreement shall continue to effect when seafarer are held captive on or off the ship as a result of acts of piracy or armed robbery against ships, regardless of whether the date fixed for its expiry has passed or either party has given notice to suspend or terminate it
		</td>
	</tr>

	<tr>
		<td>Health and social security protection benefits</td>
		<td colspan="8">
			
		</td>
	</tr>

	<tr>
		<td>Repatriation</td>
		<td colspan="8">
			
		</td>
	</tr>

	<tr>
		<td>Any other business</td>
		<td colspan="8">
			
		</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="9">In witness whereof, 2 copies of this agreement have been made and mutually signed by either parties thence each one of them</td>
	</tr>

	<tr>
		<td colspan="9">are retained by the each party and the seafarer has opportunity to review and seek advice on the terms and condition and</td>
	</tr>

	<tr>
		<td colspan="9">voluntarily accept them.</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td>Seafarer</td>
		<td colspan="2">{{ $data->user->namefull }}</td>
		<td>(signature)</td>
		<td></td>
		<td>Shipowner</td>
		<td colspan="2"></td>
		<td>(signature)</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2"></td>
		<td></td>
		<td></td>
		<td colspan="4">or for and on behalf of the shipowner of the vessel</td>
	</tr>

</table>