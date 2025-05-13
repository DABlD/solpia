@php
	$start = now()->parse($data->effective_date);
@endphp

<table>
	<tr>
		<td colspan="13">CONTRACT OF EMPLOYMENT FOR SEAFARER</td>
	</tr>

	<tr>
		<td colspan="13">The following parties to the contract agree to fully comply with the terms state hereinafter.</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="3">Shipowner</td>
		<td colspan="2">Name of the company</td>
		<td colspan="5">CHANG MYUNG SHIPPING</td>
		<td colspan="2">Phone number</td>
		<td>+82-2-2175-7000</td>
	</tr>

	<tr>
		<td colspan="2">
			Location of the
			<br style='mso-data-placement:same-cell;' />
			company
		</td>
		<td colspan="8">3F, 30, Sinchonnyeok-ro, Seodaemun-gu, Seoul, Korea</td>
	</tr>

	<tr>
		<td colspan="2">
			Name of the
			<br style='mso-data-placement:same-cell;' />
			employee
		</td>
		<td colspan="5">JUNG SUNG HO</td>
		<td colspan="2">Identification number</td>
		<td>110-81-36497</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="5">Seafarer</td>
		<td colspan="2" rowspan="2">Name of seafarer</td>
		<td colspan="5" rowspan="2">{{ $data->user->namefull }}</td>
		<td colspan="2">Date of birth</td>
		<td>{{ isset($data->user->birthday) ? $data->user->birthday->format('M/d/Y') : "-"  }}</td>
	</tr>

	<tr>
		<td colspan="2">Age</td>
		<td>{{ isset($data->user->birthday) ? $data->user->birthday->age : "-"  }}</td>
	</tr>

	<tr>
		<td colspan="2" rowspan="2">Sex</td>
		<td colspan="5" rowspan="2">Male</td>
		<td colspan="2">Birth place</td>
		<td>{{ $data->birth_place }}</td>
	</tr>

	<tr>
		<td colspan="2">Nationality</td>
		<td>PHILIPPINES</td>
	</tr>

	<tr>
		<td colspan="2">
			Address of seafarer
			<br style='mso-data-placement:same-cell;' />
			(in home country)
		</td>
		<td colspan="8">{{ $data->user->address ?? $data->provincial_address }}</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>1.ㅤ</td>
		<td colspan="12">CONTRACT PERIOD</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>1.1</td>
		<td></td>
		<td>From</td>
		<td colspan="2">({{ $start->format('M/d/Y') }})</td>
		<td>to</td>
		<td colspan="5">({{ $start->add($data->employment_months, 'months')->format('d/M/Y') }})</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>1.2</td>
		<td></td>
		<td colspan="2">The port of Sailing</td>
		<td colspan="6">({{ $data->port }})</td>
		<td colspan="3">to the port of destination (NOT FIXED)</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>2.ㅤ</td>
		<td colspan="12">ADVANCE NOTICE OF RESCISSION OF THE SEAFARER'S EMPLOYMENT CONTRACT</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="12">If the shipowner or the seafare wishes to make a rescission of the seafarer's employment contract,</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="12">to the extent that the seafarer must make a advance notice of rescission to the shipowner more than</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="12">fifteen days and to the extent that the shipowner must make a written advance notice of rescision</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="12">to the more than thirty days, prior to the rescission of the contract.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>3.ㅤ</td>
		<td colspan="12">VESSEL OF EMPLOYMENT AND RANK</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>3.1</td>
		<td></td>
		<td colspan="3">VESSEL OF EMPLOYMENT:</td>
		<td colspan="8">{{ $data->vessel->name }}</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="3">Official No.</td>
		<td colspan="5">{{ $data->official_no }}</td>
		<td colspan="3">Flag</td>
		<td>{{ $data->vessel->flag }}</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="3">Gross Tonnage</td>
		<td colspan="5">{{ $data->vessel->gross_tonnage }}</td>
		<td colspan="3">Year built(Keel Laying)</td>
		<td>{{ $data->vessel->year_build }}</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>3.2</td>
		<td></td>
		<td>RANK </td>
		<td colspan="10"> : {{ $data->pro_app->rank->abbr }}</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>4.ㅤ</td>
		<td colspan="12">HOURS OF WORK AND OVERTIME</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>4.1</td>
		<td></td>
		<td colspan="11">HOURS OF WORK</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">The hours of work on board shall be eight hours in a day and forty hours in a week.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	{{-- 2ND PAGE --}}
	{{-- 2ND PAGE --}}
	{{-- 2ND PAGE --}}

	<tr>
		<td>4.2</td>
		<td></td>
		<td colspan="11">OVERTIME</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">
			1) The hours of work may be extended for sixteen hours as a maximum in a week by the
		</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">
			ㅤagreement of the persons concerned.
		</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">
			2) Notwithstanding the provision of paragraph 4.1, the shipowner may give an order of overtime
		</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">
			ㅤwork within sixteen hours in a seek to the crew who is performing the duty of navigational
		</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">
			ㅤwatch and within 4 hours in a week to other crews.
		</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">
			3) When there is an unavoidable circumstance such as securing the safety of ship operation etc.,
		</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">
			ㅤthe shipowner may give an order of overtime work to the crew even though it exeeds the
		</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">
			ㅤhours of work prescribed in paragraphs 1) and 2).
		</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>4.3</td>
		<td></td>
		<td colspan="11">OVERTIME ALLOWANCE</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">The shipowner shall pay an (Fixed/Guaranteed) overtime allowance equivalent to the amount</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">to seafarer  for the work as provision of paragraph 4.2.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>5.ㅤ</td>
		<td colspan="12">HOURS OF REST AND HOLIDAY</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>5.1</td>
		<td></td>
		<td colspan="11">The shipowner shall give the crew ten hours of rest or more in any 24 hour period and seventy</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">seven hours of rest or more in any seven-day period.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>5.2</td>
		<td></td>
		<td colspan="11">Hours of rest may be divided into no more than two periods, one of which shall be at least six</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">hours in length, and the interval between consecutive periods of rest shall not exceed 14 hours.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>5.3</td>
		<td></td>
		<td colspan="11">Holiday of seafarers is Saturday and Sunday and Korean legal holiday, worker’s day.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>6.ㅤ</td>
		<td colspan="3">Daily victualizing expenses</td>
		<td>:</td>
		<td colspan="4">USD 14.00 / DAY</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>7.ㅤ</td>
		<td colspan="12">PAYMENT</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>7.1</td>
		<td></td>
		<td colspan="11">CONSOLIDATED PAY AND BENEFITS</td>
	</tr>

	@php
		$wage = $data->wage;
		$basic = $wage->basic ? $wage->basic : 0;
		$ot = $wage->fot ?? $wage->ot ?? 0;
		$fsa = $wage->owner_allow ? $wage->owner_allow : 0;
		$lp = $wage->leave_pay ? $wage->leave_pay : 0;
		$sa = $wage->sub_allow ? $wage->sub_allow : 0;
		$cb = $wage->other_allow ? $wage->other_allow : 0;

		$total = $basic + $ot + $fsa + $lp + $sa + $cb;
	@endphp

	<tr>
		<td></td>
		<td>1)</td>
		<td colspan="2">Basic Wageㅤㅤㅤ:</td>
		<td>USD</td>
		<td colspan="2">{{ number_format((float)$basic, 2) }}</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">(Fixed O/T for officer, engineer / Guaranteed O/T for rating)</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td>①</td>
		<td>O/Tㅤㅤ:ㅤUSD</td>
		<td colspan="2">{{ number_format((float)$ot, 2) }}</td>
		<td></td>
		<td colspan="6">* Basic wage / 173hrx x 1.25 x 103hrs</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td>②</td>
		<td>F/S/Aㅤ :ㅤUSD</td>
		<td colspan="2">{{ number_format((float)$fsa, 2) }}</td>
		<td></td>
		<td colspan="6">* Fixed Supervision Allowance, If applicable.</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td>③</td>
		<td>L/Pㅤㅤ :ㅤUSD</td>
		<td colspan="2">{{ number_format((float)$lp, 2) }}</td>
		<td></td>
		<td colspan="6">* Leave Pay, Basic wage x 9days / 30days</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td>④</td>
		<td>S/Aㅤㅤ:ㅤUSD</td>
		<td colspan="2">{{ number_format((float)$sa, 2) }}</td>
		<td></td>
		<td colspan="6">* Subsistence Allowance</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td>⑤</td>
		<td>C/Bㅤㅤ:ㅤUSD</td>
		<td colspan="2">{{ number_format((float)$cb, 2) }}</td>
		<td></td>
		<td colspan="6">* Contract completed Bonus</td>
	</tr>

	<tr>
		<td></td>
		<td>3)</td>
		<td colspan="2">Monthly Wageㅤㅤㅤ:</td>
		<td>USD</td>
		<td colspan="2">{{ number_format((float)$total, 2) }}</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td></td>
		<td>4)</td>
		<td colspan="11">GOVT. Tax deduction :  As REGULATIONS</td>
	</tr>

	<tr>
		<td></td>
		<td>4)</td>
		<td colspan="11">Health and social security protection benefits</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">- Shipowner provides medical care, sickness benefit, employment injury benefit,</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">invalidity benefit, family benefit and survivors’ benefit to the seafarer.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>7.2</td>
		<td></td>
		<td colspan="11">Payment date</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">(15) of every following month. If the payment date falls on a holiday, payment will be made</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">on the day before the holiday.</td>
	</tr>

	<tr>
		<td>7.3</td>
		<td></td>
		<td colspan="11">Payment methods</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">Payment will be paid to seafarer or credited to the bank account of seafarer.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>8.ㅤ</td>
		<td colspan="12">PAID LEAVE</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>8.1</td>
		<td></td>
		<td colspan="11">The shipowner shall provide paid leave to the seafarer who has completed ( 8 ) months of</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">continuous service on board(services on the vessel in repair or laid up shall be included) within</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">( 4 ) months form the time of completion of the service.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>8.2</td>
		<td></td>
		<td colspan="11">The leave pay should be given to seafarers even though the seafarers could not complete the contract.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>8.3</td>
		<td></td>
		<td colspan="11">The number of days of paid leave pursuant to 8.1 and 8.2 shall be ( 9 ) days per one month of </td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">continuous service on board.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>8.4</td>
		<td></td>
		<td colspan="11">In the calculation of the number of days of paid leave, the service period on board of less than</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">one month shall be calculated at a rate of days, but a fraction of less than one day shall be one day.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>8.5</td>
		<td></td>
		<td colspan="11">The time and place of port granting paid leave shall be decided on the negotiation between  </td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">the shipowner and the seafarer.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>9.ㅤ</td>
		<td colspan="12">REPATRIATION</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>9.1</td>
		<td></td>
		<td colspan="11">Shipowner shall ensure that seafarers are entitled to repatriation in the following circumstances.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">1) If the seafarers’ employment agreement expires while they are aboard</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">2) When the seafarers’ employment agreement in terminated by the shipowner or by the seafarer</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">ㅤfor justified reasons.</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">3) When the seafarers are no longer able to carry out their duties under their employment </td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">ㅤagreement or cannot be excepted to carry them out in the specific circumstance.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>9.2</td>
		<td></td>
		<td colspan="11">If the repatriation is serious default of the seafarer’s employment obligations notwithstanding</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">the provision of paragraph 8.1, the seafarer shall be liable a subset of the cost of repatriation</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="11">in accordance with collective agreement.</td>
	</tr>

	<tr>
		<td>10.ㅤ</td>
		<td colspan="12">Seafarer’s employment agreement shall continue to have effect while a seafarer is held captive on or</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="12">off the ship as a result of acts of piracy or armed robbery against ships, regardless of whether the date</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="12">fixed for its expiry has passed or either party has given notice to suspend or terminate it.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>11.ㅤ</td>
		<td colspan="12">Shipowner shall cover the health and social security protection benefits to be provided to the seafarer </td>
	</tr>

	<tr>
		<td></td>
		<td colspan="12">by due process of law. And the terms not regulated in this contract will follow </td>
	</tr>

	<tr>
		<td></td>
		<td colspan="12">the one that is more advantageous to both parties comparing the Laws of Flag State / CBA.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>12.ㅤ</td>
		<td colspan="12">Before autographing to this contract, the seafarer confirmed that no fees or other charges for</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="12">If the seafarer found that, the fact should be noticed to the shipowner immediately.</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="12">recruitment or placement or for providing employment to seafarers are borne directly or indirectly, </td>
	</tr>

	<tr>
		<td></td>
		<td colspan="12">in whole or in part, to the agent of seafarer recruitment and placement. (other than the cost of</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="12">the seafarer obtaining the seafarer’s book and a passport or other similar personal travel</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="12">documents.)</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	{{-- PAGE 3 --}}
	{{-- PAGE 3 --}}
	{{-- PAGE 3 --}}

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>13.ㅤ</td>
		<td colspan="10">THE PLACE OF CONCLUDE CONTRACT</td>
		<td colspan="2">MANILA, PHILIPPINES</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>14.ㅤ</td>
		<td colspan="10">THE TIME OF CONCLUDE CONTRACT (MM/DD/YYYY)</td>
		<td colspan="2">{{ $start->format('M/d/Y') }}</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td>15.ㅤ</td>
		<td colspan="12">Seafarers signing a seafarers' employment agreement be given an opportunity to examine and seek</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="12">advice on the agreement before signing, as well as such other facilities as are necessary to ensure</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="12">that they have freely entered into an agreement with a sufficient understanding of their rights</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="12">and responsibilities.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td colspan="5"></td>
		<td colspan="3">Shipowner :</td>
		<td colspan="5">CHANG MYUNG SHIPPING CO., LTD.</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td colspan="5"></td>
		<td colspan="3">Agent :</td>
		<td colspan="5">SOLPIA MARINE &#38; SHIP MANAGEMENT, INC.</td>
	</tr>

	<tr>
		<td colspan="13">(Signature or seal)</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td colspan="7"></td>
		<td colspan="3">Seafarer : </td>
		<td>{{ $data->user->namefull }}</td>
	</tr>

	<tr>
		<td colspan="13">(Signature or seal)</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td colspan="13">Distribution of Employment Contract</td>
	</tr>

	<tr>
		<td colspan="13">
			1. Master (Vessel)  ㅤ-ㅤㅤCopy
		</td>
	</tr>

	<tr>
		<td colspan="13">
			2. Seafarerㅤㅤㅤㅤ  -ㅤㅤOriginal
		</td>
	</tr>

	<tr>
		<td colspan="13">
			3. Agencyㅤ ㅤ  ㅤ ㅤ-ㅤㅤOriginal
		</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

</table>