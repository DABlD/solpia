@php
	// dd($data->pro_app->wage);
	$wage = $data->pro_app->wage;
@endphp

<table>
	<tr>
		<td colspan="11">
			Contract of Employment of Seafarer
		</td>
	</tr>

	<tr>
		<td rowspan="11"></td>
		<td colspan="10">
		   	Parties under mentioned enter into employment contract and agree its implementation.
		</td>
	</tr>

	<tr>
		<td rowspan="3">Shipowner</td>
		<td>Company</td>
		<td colspan="4">TMS SHIPPING CO., LTD</td>
		<td rowspan="2" colspan="2">Tel</td>
		<td colspan="2" rowspan="2">
			TEL : +82-2-733-0841
			<br style='mso-data-placement:same-cell;' />
			FAX : +82-2-733-7236
		</td>
	</tr>

	<tr>
		<td>President</td>
		<td colspan="4">
			NAM KWANGHYUN
		</td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="8">
			#635, 81 SAMBONG-RO JONGNO-GU, SEOUL, KOREA
		</td>
	</tr>

	<tr>
		<td rowspan="3">Manning Agency</td>
		<td>Company</td>
		<td colspan="4">SOLPIA MARINE &#38; SHIP MANAGEMENT, INC</td>
		<td rowspan="2" colspan="2">Tel</td>
		<td colspan="2" rowspan="2">+632-567-1726/27</td>
	</tr>

	<tr>
		<td>President</td>
		<td colspan="4">
			ROMANO A. MARIANO
		</td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="8">
			SOLPIA BUILDING, No. 2019 San Marcelino Street, Malate, Manila, Philippines
		</td>
	</tr>

	<tr>
		<td rowspan="2">Vessel</td>
		<td>Name</td>
		<td colspan="4">{{ $data->vessel->name }}</td>
		<td colspan="2">Kind</td>
		<td colspan="2">{{ $data->vessel->type }}</td>
	</tr>

	<tr>
		<td>Built Year</td>
		<td colspan="2">
			{{ $data->vessel->year_build }} Year
		</td>
		<td>Flag</td>
		<td>{{ $data->vessel->flag }}</td>
		<td colspan="2">GRT</td>
		<td colspan="2">{{ number_format(str_replace(',', '', $data->vessel->gross_tonnage)) }}</td>
	</tr>

	<tr>
		<td rowspan="2">Seafarer</td>
		<td>Name</td>
		<td colspan="4">{{ $data->user->namefull }}</td>
		<td colspan="2">Birth Date</td>
		<td colspan="2">{{ $data->user->birthday ? $data->user->birthday->format('d-M-Y') : "-" }}</td>
	</tr>

	<tr>
		<td>Sex</td>
		<td colspan="2">남자(MALE)</td>
		<td>Nationality</td>
		<td>FILIPINO</td>
		<td colspan="2">Birth Place</td>
		<td colspan="2">
			{{ $data->birth_place }}
		</td>
	</tr>

	<tr><td colspan="11"></td></tr>

	<tr>
		<td>1.</td>
		<td colspan="8">
			Place &#38; Date of entering into Employment Contract
		</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">
			1.1 The place where seafarer's employment agreement is entered into :
		</td>
		<td colspan="2">
			{{ $data->pro_app->vessel->name }}
			{{-- @if($data->pro_app->status == "Lined-Up")
				MANILA, PHILIPPINES
			@else
				{{ $data->pro_app->vessel->name }}
			@endif --}}
		</td>
		<td></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">
			1.2 The date when seafarer's employment agreement is entered into :
		</td>
		<td colspan="2">
			{{ now()->format('d-M-Y') }}
		</td>
		<td></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">
			1.3 The places where Seafarers shall be entitled to be repatriated to : 
		</td>
		<td colspan="2">
			MANILA, PHILIPPINES
		</td>
		<td></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;1.3.1 Basically crew will be repatriated to his own country and also the place will be decided after discussion with crew.
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="9">
			2. The capacity/Rank in which the seafarer is to be employed : 
		</td>
		<td colspan="2">
			{{ $data->pro_app->rank->abbr }}
		</td>
	</tr>

	<tr>
		<td  colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">3. Wage</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			3.1 Basic pay and allowance
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="3">
			A) Basic Wage :
		</td>
		<td>{{ $wage ? number_format($wage->basic, 2) : 0 }}</td>
		<td></td>
		<td>USD / MONTH</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="3"></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="4">B) Fixed Overtime Allowance (based on 104hours) :</td>
		<td></td>
		<td></td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="3"></td>
		<td>{{ $data->wage ? number_format(($data->wage->ot ?? $data->wage->fot), 2) : 0 }}</td>
		<td></td>
		<td>USD / MONTH</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="3"></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="4">C) M.W. : Monthly Wage(C = A + B)</td>
		<td></td>
		<td></td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="3"></td>
		<td>{{ $data->wage ? number_format($data->wage->basic + ($data->wage->ot ?? $data->wage->fot), 2) : 0 }}</td>
		<td></td>
		<td>USD / MONTH</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="3"></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="3"></td>
	</tr>

	@php
		$allowance = 0;
		$allowance += $wage ? ($wage->other_allow ?? 0) : 0;
		$allowance += $wage ? ($wage->sup_allow ?? 0) : 0;
		$allowance += $wage ? ($wage->sub_allow ?? 0) : 0;
		$allowance += $wage ? ($wage->owner_allow ?? 0) : 0;
	@endphp

	<tr>
		<td colspan="2"></td>
		<td colspan="3">
			D) Allowance :
		</td>
		<td>{{ number_format($allowance, 2) }}</td>
		<td></td>
		<td>USD / MONTH</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="3"></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="4">E) Paid Leave : Basic Wage/30 X (9)DAYS</td>
		<td></td>
		<td></td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="3"></td>
		<td>{{ $data->wage ? number_format($data->wage->leave_pay, 2) : 0 }}</td>
		<td></td>
		<td>USD / MONTH</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="3"></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="4">F) M.T : Monthly Total (F = C + D + E)</td>
		<td></td>
		<td></td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="3"></td>
		<td>{{ $data->wage ? number_format($data->wage->total, 2) : 0 }}</td>
		<td></td>
		<td>USD / MONTH</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			3.2  The details of Other Allowances are applied to the Collective Bargaining Agreement or Rules of Employment.
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			3.3  Payment Date :
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			(15)th of every month. If the payment date falls on a holiday, payment will be made on the day before the holiday.
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			3.4  Payment methods : 
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			Payment will be paid to seafarer or credited to the bank account of seafarer. Some allotments should be
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			remitted directly to persons nominated by the seafarers.
		</td>
	</tr>

	{{-- PAGE 2 --}}
	<tr>
		<td></td>
		<td colspan="10">
			3.5  Deferred payment shall be made as follows.
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;   1) Korean crew (Leave Pay + Retirement Wage) - First wage payment date fixed after sign-off.
		</td>
	</tr>
	
	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;     2) Philippines crew (Leave Pay) - First wage payment date fixed after sign-off
		</td>
	</tr>
	
	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;       3) Myanmar crew (Leave Pay) - Basis on payment on the vessel before sign-off, otherwise,
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2"></td>
		<td colspan="8">
			first wage payment date after sign-off
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			3.6  Where a seafarer is held captive on or off the ship as a result ofacts of piracy or armed robbery against ships, wages
		</td>
	</tr>
	
	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;     and other entitlementsunder the seafarers’ employment agreement, relevant collective bargainingagreement or
		</td>
	</tr>
	
	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;     applicable national laws, including the remittance of anyallotments as provided in paragraph 3.4 above, shall continue
		</td>
	</tr>
	
	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;     to be paid duringthe entire period of captivity and until the seafarer is released and dulyrepatriated or, where the
		</td>
	</tr>
	
	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;     seafarer dies while in captivity, until the date ofdeath as determined in accordance with applicable the flag's national laws
		</td>
	</tr>
	
	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;     or regulations.
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			4. Paid Leave
		</td>
	</tr>

	<tr>
		<td colspan="11">
			4.1  The shipowner shall Provide "Paid leave" with seafarer who has completed (9) months of continuous service
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			on board (services on the vessel in repair or laid up shall be included).
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			of the service. However, the commencement of Leave Pay may be extended until the vessel's entry into port
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			when the vessel is under way.
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			4.2  The number of days of paid leave shall be (9.0) days per 1 month of continuous service on board.
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			4.3  Computation of Leave Pay
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			[Basic Wage/30day) x 9 days] x numbers of month of working
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			5. Hours of Work and Overtime
		</td>
	</tr>

	<tr>
		<td colspan="11">
			5.1 Hours of Work : The hours of work on board shall be 8 in a day and 40hours in a week
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			5.2. Overtime 
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			1) The hours of work may be extended for sixteen hours as a maximum in a week by the agreement of the persons
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			2) Notwithstanding the provision of paragraph 5.2.1), the ship owner may give an order of overtime work
		</td>
	</tr>
	
	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;      within 16 hours in a week to the crew who is performing the duty of navigational watch and within 4 hours
		</td>
	</tr>
	
	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;       in a week to other crew)
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			3) When there is an unavoidable circumstance such as securing the safety of ship operation etc., the ship owner 
		</td>
	</tr>
	
	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;      may give an order of overtime work to the crew even though it exceeds the hours of work perecribed
		</td>
	</tr>
	
	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;       in paragraphs 1) and 2))
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			5.3. Overtime allowance
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			The shipowner shall pay an fixed overtime allowance equivalent to the amount to seafarer for the work 
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			as provision of paragraph 5.2
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			6.  Daily victualling expenses
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			&nbsp; 1 DAY : 12 USD
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			7.  Period of employment
		</td>
	</tr>

	<tr>
		<td colspan="2">7.1 Period : From</td>
		<td colspan="2">
			{{ $data->effective_date ? now()->parse($data->effective_date)->format('d-M-Y') : "-" }}
		</td>
		<td>To</td>
		<td>
			{{ isset($data->effective_date) && isset($data->employment_months) ? now()->parse($data->effective_date)->addMonths(3)->format('d-M-Y') : "-" }}
		</td>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			7.2  But, If the seafarer disembarks midway of contract, the contract will terminate on the date of disembarkation.
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			And If the seafarer boards over the contract period, the contract will extend until the date of disembarkation.
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			7.3  In case where the shipowner terminates the contract, the required notice period shall be over 30 days in written, 
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			and notify the seafarer with a written document.
		</td>
	</tr>

	{{-- PAGE 3 --}}

	<tr>
		<td colspan="11">
			7.4  In case where the seafarer want to terminate the contract, he/she shall notify it between 15 days and 30 days 
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			to the shipowner by written notice.
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			7.5 A seafarer's employment agreement shall continue to effect when seafarer are held capitve on or off the ship
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			1) If the seafarers' employment greement expires while they are aboard.
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			2) When the seafarers' employment agreement in terminated by the shipowner or by the seafarer for justified reasons.
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;       excepted to carry them out in the specific circumstance.
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			9.2  Shipowner shall promptly repatriate the seafarer who leaves a ship at the place of which is not the seafarer's
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			 country of residence or the place at which the seafarer agreed to enter into the engagement as shipowner's
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			 expenses. however, in case where shipowner paid the expense of repatriation according shipowner to the
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			 request of seafarer, does not have any responsibility for the repatriation.
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			9.3 Shipowner shall be prohibitted that seafarers make an advance payment towards the cost of repatriation at
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			the beginning of their employment, and also recovering the cost of repatriaion from the seafarers' wages
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			or other entitlements.
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			9.4  Despite above 9.1, 9.2 &#38; 9.3, in case of the following particulars, shipowner can recover the cost of repatriation
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			from seafarer.
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			1) When the seafarer leaves a ship without just reason
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			2) When the seafarer leaves a ship according to disciplinary punishment which regulated in national laws
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			3) When the reason is conformed to the collective bargaining agreement or rules of employment or national laws
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			9.5 Maximum period of uninterrupted service on board, upon termination of which seafarers shall be entitled to be 
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			repatriated is the same as that of paid leave.)
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			10. Hours of Rest
		</td>
	</tr>

	<tr>
		<td colspan="11">
			10.1 The minimum hours of rest shall not be less than:
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			a. 10 hours in any 24-hour period, and
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			b. 77 hours in any 7-day period
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			10.2 Hours of rest may be divided into no more than two periods, one of which shall be at least six(6) hours in length, 
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			and the interval between consecutive periods of rest shall not exceed fourteen(14) hours.
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			11. Arbitration
		</td>
	</tr>

	<tr>
		<td colspan="11">
			11.1 The parties entering into this contract made in accorance with relavant clause in national law must abide by it, 
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			and any dispute caused on this contract must be settled by the national law. But, Any facts which are not defined 
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			in this contract, these are complied with national laws or the collective bargaining agreement or rules of employment. 
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="11">
			12. Others : 
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			12.1 Before signing on this contract, seafarer might be ensured that he shall not pay any of fee, commission 
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;    or expenses to his recuiting agency regardless of direct or indirect, in whole of in part. But it shall be excluded items 
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;    such as medical check-up, seaman's book, passport or other related document for travel.)
		</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			12.2 Seafarer has time and opportunity to review and seek advice on the terms and condition in the contract and
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;    freely accept them.
		</td>
	</tr>

	{{-- PAGE 4 --}}

	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;    In witness whereof, 2 copies of this Contract have been made and mutually signed by either parties thence
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="10">
			&nbsp;    each one of them are retained by the each party.
		</td>
	</tr>

	<tr>
		<td colspan="6"></td>
		<td>Date:</td>
		<td colspan="3">{{ now()->format('d-M-Y') }}</td>
	</tr>

	<tr>
		<td colspan="11">Seafarer Name:</td>
	</tr>

	<tr>
		<td colspan="7"></td>
		<td colspan="3">
			{{ $data->pro_app->rank->abbr }} {{ $data->user->namefull }}
		</td>
		<td>sign</td>
	</tr>

	<tr>
		<td colspan="7">
			Shipowner(s) or for and on behalf of the shipOwner(s) of the Vessel
		</td>
		<td colspan="4">C/E ROMANO A. MARIANO</td>
	</tr>

	<tr>
		<td colspan="7"></td>
		<td colspan="3">President</td>
		<td>sign</td>
	</tr>

</table>