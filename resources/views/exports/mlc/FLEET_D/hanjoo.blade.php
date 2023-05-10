@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b$c";
	$u = "text-decoration: underline;";
@endphp

<table>
	<tr>
		<td colspan="8" style="{{ $bc }} {{ $u }} font-size: 20px;">SEAFARER EMPLOYMENT AGREEMENT</td>
	</tr>

	<tr>
		<td colspan="8" style="height: 30px;"></td>
	</tr>

	<tr>
		<td colspan="2" rowspan="4">Seafarer</td>
		<td>Name</td>
		<td colspan="3">{{ $data->user->namefull }}</td>
		<td>Position</td>
		<td>{{ $data->pro_app->rank->name }}</td>
	</tr>

	@php
		$pp = null;
		$sb = null;
		$mc = null;

		foreach($data->document_med_cert as $docu){
			if($docu->type == "MEDICAL CERTIFICATE"){
				$mc = $docu;
			}
		}

		foreach($data->document_id as $docu){
			if($docu->type == "PASSPORT"){
				$pp = $docu;
			}
			elseif($docu->type == "SEAMAN'S BOOK"){
				$sb = $docu;
			}
		}
	@endphp

	<tr>
		<td>Date of Birth</td>
		<td colspan="3">{{ $data->user->birthday ? $data->user->birthday->format("d M Y") : "---"}}</td>
		<td>Passport No.</td>
		<td>{{ $pp ? $pp->number : '---' }}</td>
	</tr>

	<tr>
		<td>Birthplace/Nationality</td>
		<td colspan="3">{{ $data->birth_place }}/FILIPINO</td>
		<td>Tel. No.</td>
		<td>{{ $data->user->contact }}</td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="5">{{ $data->user->address }}</td>
	</tr>

	<tr>
		<td colspan="2" rowspan="3">Shipowner</td>
		<td>Name</td>
		<td colspan="5">INTERGIS CO., LTD.</td>
	</tr>

	<tr>
		<td>Representative</td>
		<td colspan="5">MR. PARK DONG HO</td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="5">5F, MARINE CENTER BLDG., 52, CHUNGJANG-DAERO 9 BEON-GIL, JUNG-GU, BUSAN, KOREA. 48936</td>
	</tr>

	<tr>
		<td colspan="2" rowspan="2">Agency</td>
		<td>Name</td>
		<td colspan="5">SOLPIA MARINE &#38; SHIP MANAGEMENT, INC.</td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="5">NO. 2019 SOLPIA BLDG, SAN MARCELINO COR. QUIRINO AVENUE, MALATE MANILA</td>
	</tr>

	<tr>
		<td colspan="2" rowspan="2">Ship</td>
		<td>Name</td>
		<td colspan="3">{{ $data->vessel->name }}</td>
		<td>Gross Ton</td>
		<td style="text-align: left;">{{ $data->vessel->gross_tonnage }}</td>
	</tr>

	<tr>
		<td>Flag</td>
		<td colspan="3">{{ $data->vessel->flag }}</td>
		<td>Year of Build</td>
		<td style="text-align: left;">{{ $data->vessel->year_build }}</td>
	</tr>

	<tr>
		<td style="{{ $b }}" colspan="8">1. Period of Employment</td>
	</tr>

	@php
		$start = now()->parse($data->pro_app->eld);
		$end = now()->parse($data->pro_app->eld)->add($data->employment_months, 'months');
	@endphp
	<tr>
		<td colspan="2" style="{{ $c }}">
			‎‎‎‎
			1.1 Period:
		</td>
		<td colspan="2" style="{{ $bc }} {{ $u }}">
			({{ $start->format("d M Y") }}) ~ ({{ $end->format('d M Y') }})
		</td>
		<td style="{{ $bc }} {{ $u }}">
			{{ $data->employment_months }} Months
		</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="8">
			&#8205;&#8205;&#8205;&#8205;&#8205;&#8205;
			1.2 The duration of seafarers' employment contract is ({{ $data->employment_months }} Months) and it shall commence from the date of departure
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			from Philippines(or the date of embarkation on board when in Philippine port) and end on the date of arrival in Philippines after
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			disembarkation(or the date of disembarkation when in Philippine port).
		</td>
	</tr>

	<tr>
		<td style="height: 25px;" colspan="8"></td>
	</tr>

	<tr>
		<td style="{{ $b }}" colspan="8">
			2. Advance Notice of Rescission of the Seafarer's Employment Contract
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			When shipowner terminates the contract early, the required minimum notice period shall be over 30 days in written and notify each
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			other and when seafarer terminates the contract early, the required minimum notice shall be over 15days and within 30days notify
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			each other.
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			2.2 The shipowner shall require that a seafarer's employment agreement shall continue to have effect while a seafarer
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			is held captive on or off the ship as a result of acts of piracy or armed robbery against ships, regardless of whether the
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			date fixed for its expiry has passed or either party has given notice to suspend or terminate it in accordance with MLC
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			A2.1.7
		</td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $b }}">
			3. Wages
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			3.1 Basic pay and allowance
		</td>
	</tr>

	@php
		$basic = $data->wage && $data->wage->basic ? $data->wage->basic : 0.00;
		$ot = $data->wage && $data->wage->fot ? $data->wage->fot : $data->wage->ot ?? 0.00;
		$leave = $data->wage && $data->wage->leave_pay ? $data->wage->leave_pay : 0.00;
		$other = $data->wage && $data->wage->other_allow ? $data->wage->other_allow : 0.00;

		$mw = number_format($basic + $ot, 2);
		$total = number_format($basic + $ot + $leave + $other, 2);
		$basic = number_format($basic, 2);
		$ot = number_format($ot, 2);
		$leave = number_format($leave, 2);
		$other = number_format($other, 2);

		$tot = $data->wage && $data->wage->fot ? "FOT: Fixed Overtime Allowance" : "GOT: Guaranteed Overtime Allowance";
	@endphp

	<tr>
		<td colspan="7">
			‎‎‎‎‎‎‎‎‎‎‎‎
			(1) BW: Monthly Basic wage
		</td>
		<td style="text-align: right;">
			US ${{ $basic }}
		</td>
	</tr>

	<tr>
		<td colspan="7">
			‎‎‎‎‎‎‎‎‎‎‎‎
			(2) {{ $tot }} BW/173hrs x 1.25 x 103hrs
		</td>
		<td style="text-align: right;">
			US ${{ $ot }}
		</td>
	</tr>

	<tr>
		<td colspan="7">
			‎‎‎‎‎‎‎‎‎‎‎‎
			(3) MW: Monthly wages: BW + OT
		</td>
		<td style="text-align: right;">
			US ${{ $mw }}
		</td>
	</tr>

	<tr>
		<td colspan="7">
			‎‎‎‎‎‎‎‎‎‎‎‎
			(4) LP: Leave Pay: BW x 4.5 days/30
		</td>
		<td style="text-align: right;">
			US ${{ $leave }}
		</td>
	</tr>

	<tr>
		<td colspan="7">
			‎‎‎‎‎‎‎‎‎‎‎‎
			(5) Monthly Total: MW+LP+RA
		</td>
		<td style="text-align: right;">
			US ${{ $total }}
		</td>
	</tr>

	<tr>
		<td colspan="7">
			‎‎‎‎‎‎‎‎‎‎‎‎
			(6) Onboard Payments
		</td>
		<td style="text-align: right;">
			US ${{ $other }}
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			3.2 Payment of Wages and Methods
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			Wages shall be paid on the (15th) of every the next month to the person designated by the seafarer through the designated bank.
		</td>
	</tr>

	<tr>
		<td colspan="8" style="height: 105px;">
			‎‎‎‎
			3.3 In accordance with MLC A2.2.7, where a seafarer is held captive on or off the ship as a result of acts of piracy or armed  robbery  against  ships,  wages  and  other  entitlements  under  the  seafarers’  employment  agreement,  relevant collective bargaining agreement or applicable national laws, including the remittance of any allotments as provided in paragraph 4 of this Standard, shall continue to  be paid  during the  entire  period of captivity and until  the seafarer is released and duly repatriated in accordance with Standard A2.5.1 or, where the seafarer dies while in captivity, until the date of death as determined in accordance with applicable national laws or regulations. The terms piracy and armed robbery against ships shall have the same meaning as in Standard A2.1, paragraph 7
		</td>
	</tr>

	<tr>
		<td style="height: 30px;" colspan="8"></td>
	</tr>

	<tr>
		<td style="{{ $b }}" colspan="8">4. Paid Leave</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			4.1 Paid leave shall be granted on the basis of (4.5 days) per months of service.
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			4.2 The method which is calculating of paid leave as follows
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			Paid Leave - Basic Wage/30 x 4.5 days
		</td>
	</tr>

	<tr>
		<td style="height: 30px;" colspan="8"></td>
	</tr>

	<tr>
		<td style="{{ $b }}" colspan="8">5. Costs for food</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			Costs for food shall be (9.5 US dollars) per person/day excluding shipment cost.
		</td>
	</tr>

	<tr>
		<td style="height: 30px;" colspan="8"></td>
	</tr>

	<tr>
		<td style="{{ $b }}" colspan="8">6. Hours of Work and Hours of Rest</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			6.1 Hours of Work
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			Hours of work for seafarers shall be 8 hours a day and 40 hours a week commencing from Monday to Friday including 8 hours of
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			Saturday.
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			6.2 Over Time Work
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			Shipowner may require the seafarer to work overtime within (103 hours) per month.
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			6.3 Hours of rest
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			Shipowner shall provide seafarers with at least ten  hours of rest in any 24-hour period including 6 consecutive hours of rest and 77
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			hours of rest in any seven-day period.
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			6.4 Shipowner shall provide a compensatory rest period, comparable to hours of work performed, for seafarers who have performed
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			necesarry work although in a rest period or have been disturbed by call-outs to work during the normal period of rest.
		</td>
	</tr>

	<tr>
		<td style="height: 30px;" colspan="8"></td>
	</tr>

	<tr>
		<td style="{{ $b }}" colspan="8">7. Health and Social Security Benefits</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			Shipowner provides medical care, sickness benefit, employment injury benefit, disability benefit, and survivors' benefit to the
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			seafarer in accordance with "POEA (Philippine Overseas Employment Administration)".
		</td>
	</tr>

	<tr>
		<td style="height: 30px;" colspan="8"></td>
	</tr>

	<tr>
		<td style="{{ $b }}" colspan="8">8. Repatriation</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			8.1 Where the seafarer is to disembark at a port other than his/her resident, the owner shall repatriate the seafarer to the resident
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			place at the shipowner's expense and responsibility without delay. However, this shall not apply to the case that the expenses
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			necessary for the repatriation is paid to the seafarer by the shipowner on the request of the seafarer.
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			8.2 Shipowner is entitled to demand the seafarer to pay the expenses of repatriation borne by him in cases of falling under one of
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			the following sub-paragraphs. However, the shipowner shall not demand the seafarer to pay the expenses of repatriation equal to
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			50/100 of the expenses or more if the seafarer is repatriated after six month's service or more on board:
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎‎‎‎‎
			(1) where the seafarer has left the vessel at his/her discretion without a justifiable reason;
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎‎‎‎‎
			(2) where the seafarer has been discharged from the vessel by disciplinary punishment; or
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎‎‎‎‎
			(3) in cases of falling under one of the reasons dstipulated in CBA.
		</td>
	</tr>

	<tr>
		<td style="height: 30px;" colspan="8"></td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			8.3 In case of completion of contract duration specified in section 1.1, the seafarer is entitled to repatriation at shipowner's expenses.
		</td>
	</tr>

	<tr>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			8.4 The entitlement to repatriation may laps if the seafarers concerned do not claim it within a reasonable period of
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			time to be defined by national laws or regulations or collective agreements, except where they are held captive on or off
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			the ship as a result of acts of piracy or armed robbery against ships. The terms piracy and armed robbery against ships
		</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			shall have the same meaning as in Standard A2.1, paragraph 7
		</td>
	</tr>

	<tr>
		<td style="height: 50px;" colspan="8"></td>
	</tr>

	<tr>
		<td style="{{ $b }}" colspan="8">9. Remarks</td>
	</tr>

	<tr>
		<td colspan="8">
			‎‎‎‎
			Seafare has opportunity to review and seek advice on the terms and conditions before signin and freely accept them.
		</td>
	</tr>

	<tr>
		<td style="height: 50px;" colspan="8"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }}">{{ now()->format('d F Y') }}</td>
		<td></td>
		<td colspan="2" style="{{ $bc }}">{{ $data->vessel->name }}</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $c }}">Date this agreement signed</td>
		<td></td>
		<td colspan="2" style="{{ $c }}">Place this agreement signed</td>
	</tr>

	<tr>
		<td style="height: 50px;" colspan="8"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }}">MS. THEA MAE D. GUERRA - CREWING MANAGER</td>
		<td></td>
		<td colspan="2" style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }}">SOLPIA MARINE &#38; SHIP MANAGEMENT, INC.</td>
		<td></td>
		<td colspan="2" style="{{ $bc }}">{{ $data->user->namefull }}</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $c }}">Signature of Agency on behalf of Shipowner</td>
		<td></td>
		<td colspan="2" style="{{ $c }}">Signature of Seafarer</td>
	</tr>
</table>