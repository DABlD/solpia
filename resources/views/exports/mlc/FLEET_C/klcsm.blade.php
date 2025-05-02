<table>
	<tr>
		<td colspan="11">Contract of Employment for Seafarer</td>
	</tr>

	<tr>
		<td colspan="11">The following parties to the contract agree to fully comply with the terms stated hereinafter:</td>
	</tr>

	<tr>
		<td colspan="1" rowspan="6">Shipowner</td>
		<td colspan="2">Name of the</td>
		<td colspan="6" rowspan="2">{{ $data->vshipowner }}</td>
		<td colspan="1" rowspan="2">Phone number</td>
		<td colspan="1" rowspan="2">{{ $data->vphoneNumber }}</td>
	</tr>

	<tr>
		<td colspan="2">company</td>
	</tr>

	<tr>
		<td colspan="2">Location of</td>
		<td colspan="8" rowspan="2">{{ $data->vaddress }}</td>
	</tr>

	<tr>
		<td colspan="2">the company</td>
	</tr>

	<tr>
		<td colspan="2">Name of the</td>
		<td colspan="6" rowspan="2">{{ $data->vemployer }}</td>
		<td colspan="1" rowspan="2">Identification number</td>
		<td colspan="1" rowspan="2">{{ $data->videntification }}</td>
	</tr>

	<tr>
		<td colspan="2">employer</td>
	</tr>

	<tr>
		<td colspan="1" rowspan="5">Seafarer</td>
		<td colspan="2">Name of</td>
		<td colspan="6" rowspan="2">{{ $data->user->namefull }}</td>
		<td colspan="1">Date of birth</td>
		<td colspan="1">{{ $data->user->birthday ? $data->user->birthday->format('d/M/Y') : "-" }}</td>
	</tr>

	<tr>
		<td colspan="2">seafarer</td>
		<td colspan="1">Age</td>
		<td colspan="1">{{ $data->user->birthday ? $data->user->birthday->age : "-" }}</td>
	</tr>

	<tr>
		<td colspan="2">Sex</td>
		<td colspan="6">Male</td>
		<td colspan="1">Birth place</td>
		<td>{{ $data->birth_place }}</td>
	</tr>

	<tr>
		<td colspan="2">Address of seafarer</td>
		<td colspan="8" rowspan="2">{{ $data->user->address ?? $data->provincial_address }}</td>
	</tr>

	<tr>
		<td colspan="2">(in home country)</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">1. Contract Period</td>
	</tr>

	<tr>
		<td colspan="2">1.1. from</td>
		<td>({{ now()->parse($data->effective_date)->format('d/M/Y') }})</td>
		<td>to</td>
		<td colspan="5">({{ now()->parse($data->effective_date)->add($data->employment_months, 'months')->format('d/M/Y') }})</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="2">1.2. the port of sailing</td>
		<td colspan="3">({{ $data->port }})</td>
		<td colspan="5">to the port of destination UNFIXED</td>
		<td></td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">2. Advance Notice of Rescission of the Seafarer's Employment Contract</td>
	</tr>

	<tr>
		<td colspan="11">
			If the shipowner or the seafarer wishes to make a rescission of the seafarer's employment contract, to the extent that the seafarer must make an advance notice of rescission to the shipowner before 15 days and to the extent that the shipowner must make a written advance notice of rescission to the more than 30 days, prior to the rescission of the contract.
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">3. Vessel of Employment and Rank</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="5">3.1. Vessel of Employment</td>
		<td colspan="4">{{ $data->vessel->name }}</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td>Official No.</td>
		<td colspan="2">{{ $data->vofficialNo }}</td>
		<td colspan="2">Flag.</td>
		<td colspan="4">{{ $data->vessel->flag }}</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td>Gross Tonnage.</td>
		<td colspan="2">{{ $data->vessel->gross_tonnage }}</td>
		<td colspan="2">Year built</td>
		<td colspan="4">{{ $data->vessel->year_build }}</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td>3.2 Rank:</td>
		<td colspan="10">{{ $data->pro_app->rank->abbr }}</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">4. Hours of Work and Overtime</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">4.1. The hours of work on board shall be eight hours in a day and forty hours in a week.</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">4.2. Overtime</td>
	</tr>

	<tr>
		<td colspan="11">1) The hours of work may be extended for sixteen hours as a maximum in a week by the agreement of the persons concerned.</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			2) Notwithstanding the provision of paragraph 4.1) the shipowner may give an order of overtime work within sixteen hours 
			in a week to the crew who is performing the duty of navigational watch and within 4 hours in a week to other crew.
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			3) When there is an unavoidable circumstance such as securing the safety of ship operation etc., the shipowner may give an 
			order of overtime work to the crew even though it exceeds the hours of work prescribed in paragraphs 1) and 2)
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">4.3. Overtime Allowance:</td>
	</tr>

	<tr>
		<td colspan="11">The shipowner shall pay an fixed overtime allowance equivalent to the amount to seafarer for the work as provision of paragraph 4.2.</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">5. Hours of Rest and Holiday</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			5.1. The shipowner shall give the crew ten hours of rest or more in any 24 hour period and seventy seven hours of rest or more 
			in any seven-day period.
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			5.2. Hours of rest may be divided into no more than two periods, one of which shall be at least six hours in length, and the interval between consecutive periods of rest shall not exceed 14 hours.
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			5.3. Holiday of seafarers is Saturday and Sunday and Korean legal holiday, worker’s day.
		</td>
	</tr>

	<tr><td colspan="11" style="height: 100px;"></td></tr>

	{{-- PAGE 2 --}}
	{{-- PAGE 2 --}}
	{{-- PAGE 2 --}}

	@php
		$wage = $data->wage;
		$basic = ceil($wage->basic);
		// if(!in_array($data->id, [1243, 1422, 1657, 1703, 1730, 1773, 2013, 2672, 2767])){
		// 	dd($data->id, $basic, $wage);
		// }
		// $ot = ceil($basic / 173 * 103 * 1.25);
		$ot = ceil($wage->fot ?? $wage->ot);
		$lp = ceil($basic * 9 / 30);

		// allowances
		$sa = ceil($wage->sup_allow ?? 0);
		$so = ceil($wage->sub_allow ?? 0);
		$oa = ceil($wage->owner_allow ?? 0);
		$oa2 = ceil($wage->other_allow ?? 0);
		$ra = ceil($wage->retire_allow ?? 0);

		$ccb = number_format(str_contains($data->vessel->type, "BUL") ? 80 : 0, 2);

		$total = $basic + $ot + $lp + $sa + $so + $oa + $ra + $oa2 + $ccb - 40;
		if($data->vessel->type == "LNG"){
			$total += 40;
		}

		$total = number_format($total, 2);

		$so = number_format($so, 2);
	@endphp

	<tr>
		<td colspan="11">6. Payment</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td>6.1. Consolidated pay and benefits</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td>1) Consolidated pay</td>
	</tr>

	<tr>
		<td colspan="2">&#9312; Monthly total wages:</td>
		<td></td>
		<td>US$</td>
		<td>{{ $total }}</td>
		<td></td>
		<td colspan="5">
			@if($data->vessel->type == "LNG")
				Before deduction FKSU Membership Fee
			@else
				After deduction FKSU Membership Fee
			@endif
		</td>
	</tr>

	<tr>
		<td colspan="2">&#9313; Basic Wage:</td>
		<td></td>
		<td>US$</td>
		<td>{{ number_format($basic, 2) }}</td>
		<td></td>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td colspan="11">2) Fixed Overtime Allowances, Other Allowances, deduction and calculation method</td>
	</tr>

	<tr>
		<td colspan="2">&#9312; O/T:</td>
		<td></td>
		<td>US$</td>
		<td>{{ number_format($ot, 2) }}</td>
		<td></td>
		<td colspan="5">Calculation method: Basic / 173hrs x 1.25 x 103hrs</td>
	</tr>

	<tr>
		<td colspan="2">&#9313; Other allowances:</td>
		<td>(Owner Allowance):</td>
		<td>US$</td>
		<td>{{ number_format($sa + $so + $oa + $ra + $oa2, 2) }}</td>
		<td></td>
		<td colspan="5">Calculation method: OWNER'S DISCRETION</td>
	</tr>

	<tr>
		<td colspan="2">&#9314; Leave pay:</td>
		<td></td>
		<td>US$</td>
		<td>{{ number_format($lp, 2) }}</td>
		<td></td>
		<td colspan="5">Calculation method: Basic wage x 9days / 30days</td>
	</tr>

	<tr>
		<td colspan="3">&#9315; FKSU Membership Fee:</td>
		<td>US$</td>
		<td>40</td>
		<td></td>
		<td colspan="5">As IBF FKSU CA (BBCHP) Article 33</td>
	</tr>

	<tr>
		<td colspan="3">&#9316; GOVT. Tax deduction:</td>
		<td colspan="2">As Regulations</td>
		<td></td>
		<td colspan="5"></td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			3) Health and social security protection benefits - Shipowner provides medical care, sickness benefit, employment injury benefit, invalidity benefit, family benefit and survivors’ benefit to the seafarer.
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			6.2. Payment date:
		</td>

	<tr>
		<td colspan="11">
			Every 15th next month. If the payment date falls on a holiday, payment will be made on the day before the holiday.
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			6.3. Payment methods: Payment will be paid to seafarer or credited to the bank account of seafarer.
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			7. Paid Leave
		</td>
	</tr>

	<tr>
		<td colspan="8">7.1. The shipowner shall provide paid leave to the seafarer who has completed (</td>
		<td>8</td>
		<td colspan="2">) months of continuous service on board</td>
	</tr>

	<tr>
		<td colspan="6">(services on the vessel in repair or laid up shall be included) within (</td>
		<td>4</td>
		<td colspan="4">) months from the time of completion of the service.</td>
	</tr>

	<tr>
		<td colspan="11">
			However, the commencement of paid leave may be extended until the vessel's entry  into port when the vessel is under way.
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			7.2 The leave pay should be given to seafarers even though the seafarers could not complete the contract.
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			7.3. The number of days of paid leave pursuant to 7.1 and 7.2 shall be (9) days per one month of continuous service on board.
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			7.4. In place of the four hours of each week in overtime work, one day of paid leave shall be added to the number of days of paid leave pursuant to 7.3.
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			7.5. In the calculation of the number of days of paid leave, the service period on board of less than one month shall be calculated at a rate of days, but a fraction of less than one day shall be one day.
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			7.6. The time and place of port granting paid leave shall be decided on the negotiation between the shipowner and the seafarer.
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			8. Daily Provision Fee : US$ 14.0 / Day
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			9. Repatriation
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			9.1. Shipowner shall ensure that seafarers are entitled to repatriation in the following circumstances.
		</td>
	</tr>

	<tr>
		<td colspan="11">
			1) If the seafarers’ employment agreement expires while they are aboard
		</td>
	</tr>

	<tr>
		<td colspan="11">
			2) When the seafarers’ employment agreement in terminated by the shipowner or by the seafarer for justified reasons
		</td>
	</tr>

	<tr>
		<td colspan="11">
			3) When the seafarers are no longer able to carry out their duties under their employment agreement or cannot be excepted to carry them out in the specific circumstance
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			9.2. In addition, shall facilitate the prompt repatriation of seafarers, including when they are deemed abandoned within the meaning of following circumstances.
		</td>
	</tr>

	<tr>
		<td colspan="11">
			1) Fails to cover the cost of the seafarer’s repatriation
		</td>
	</tr>

	<tr>
		<td colspan="11">
			2) Has left the seafarer without the necessary maintenance and support
		</td>
	</tr>

	<tr>
		<td colspan="11">
			3) Has otherwise unilaterally severed their ties with the seafarer including failure to pay contractual wages for a period of at least two months.
		</td>
	</tr>

	<tr><td colspan="11" style="height: 100px;"></td></tr>

	{{-- PAGE 3 --}}
	{{-- PAGE 3 --}}
	{{-- PAGE 3 --}}

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			Seafarer’s employment agreement shall continue to have effect while a seafarer is held captive on or off the ship as
			<br style='mso-data-placement:same-cell;' />
			a result of acts of piracy or armed robbery against ships, regardless of whether the date fixed for its expiry has passed 
			<br style='mso-data-placement:same-cell;' />
			or either party has given notice to suspend or terminate it.
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			Shipowner provides medical care, unemployment benefit, old-age benefit, employment injury benefit, invalidity benefit, 
			<br style='mso-data-placement:same-cell;' />
			survivors' benefit to the seafarer in accordance with National Law / CBA / Rule of Employment.
			<br style='mso-data-placement:same-cell;' />
			And terms not regulated in this contract will follow the one that is more advantageous to both parties comparing the Laws 
			<br style='mso-data-placement:same-cell;' />
			of Flag State / CBA / Rule of Employment.
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			Before autographing to this contract, the seafarer confirmed that no fees or other charges for recruitment or placement
			<br style='mso-data-placement:same-cell;' />
			or for providing employment to seafarers are borne directly or indirectly, in whole or in part, to the agent of seafarer 
			<br style='mso-data-placement:same-cell;' />
			recruitment and placement. (other than the cost of the seafarer obtaining the seafarer’s book and a passport or other 
			<br style='mso-data-placement:same-cell;' />
			similar personal travel documents.). If the seafarer found that, the fact should be noticed to the shipowner immediately.
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="11">
			Seafarers signing a seafarers' employment agreement be given an opportunity to examine and seek 'advice on the 
			<br style='mso-data-placement:same-cell;' />
			agreement before signing, as well as such other facilities as are necessary to ensure that they have freely entered into 
			<br style='mso-data-placement:same-cell;' />
			an agreement with a sufficient understanding of their rights and responsibilities.
			<br style='mso-data-placement:same-cell;' />
			In addition, seafarers, prior to or in the process of engagement, shall be informed about their rights under the seafarers’ 
			<br style='mso-data-placement:same-cell;' />
			recruitment and placement services’ system of protection, to compensate seafarers for monetary loss that they may 
			<br style='mso-data-placement:same-cell;' />
			incur as a result of the failure of the recruitment and placement service or the relevant shipowner under the seafarers’ 
			<br style='mso-data-placement:same-cell;' />
			employment agreement to meet its obligations to them.
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="4">14. The place of conclude contract:</td>
		<td colspan="7">MANILA, PHILIPPINES</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="4">15. The time of conclude contract (dd/mm/yy)</td>
		<td colspan="7">{{ now()->format('l, F j, Y') }}</td>
	</tr>

	<tr><td colspan="11" style="height: 80px;"></td></tr>

	<tr>
		<td colspan="4"></td>
		<td>Shipowner</td>
		<td colspan="2"></td>
		<td colspan="3">
			@if($data->vessel->type == "LNG")
				KOREA LINE LNG CORP
			@else
				KOREA LINE CORPORATION
			@endif
		</td>
	</tr>

	<tr><td colspan="11" style="height: 72px;"></td></tr>

	<tr>
		<td colspan="4"></td>
		<td>Agent</td>
		<td colspan="3"></td>
		<td colspan="2">Shirley Erasquin</td>
	</tr>

	<tr><td colspan="11" style="height: 30px;"></td></tr>

	<tr>
		<td colspan="4"></td>
		<td></td>
		<td colspan="3"></td>
		<td colspan="2">CREWING MANAGER</td>
	</tr>

	<tr>
		<td colspan="5"></td>
		<td colspan="5">Solpia Marine &#38; Ship Management Inc.</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td colspan="4"></td>
		<td>Seafarer:</td>
		<td colspan="5">
			{{ $data->user->namefull }}
		</td>
		<td>(signature)</td>
	</tr>

	<tr><td colspan="11" style="height: 140px;"></td></tr>
</table>