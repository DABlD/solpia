@php
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
		$allowance = 10.5;
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
	// dd($data);
@endphp

<table>
	<tr>
		<td colspan="6">CADET'S TRAINING AGREEMENT</td>
	</tr>

	<tr>
		<td colspan="6">This Employment Agreement is entered into between the Seafarer and the Shipowner(or the Employer on behalf of the Shipowner)</td>
	</tr>

	<tr>
		<td rowspan="2">Registered Owner</td>
		<td>Company</td>
		<td colspan="4">ㅤ{{ $data->shipowner }}</td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="4">ㅤ{{ $data->sAddress }}</td>
	</tr>

	<tr>
		<td rowspan="2">MLC Shipowner (Manager)</td>
		<td>Company</td>
		<td colspan="4">ㅤKMARIN Ocean Services Corporation (KOSCO)</td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="4">ㅤ5F(KUKDONG Bldg), 67, Chungjang-daero 5beon-gil, Jung-gu, Busan, 48934, Republic of Korea</td>
	</tr>

	<tr>
		<td rowspan="2">Manning Agency</td>
		<td>Company</td>
		<td colspan="4">ㅤSOLPIA MARINE &#38; SHIP MANAGEMENT, INC.</td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="4">ㅤSolpia Bldg, #2019 San Marcelino St. Malate, Manila, Philippines 1004</td>
	</tr>

	<tr>
		<td rowspan="4">Cadet</td>
		<td>Name</td>
		<td colspan="2">ㅤ{{ $data->user->namefull }}</td>
		<td>Position</td>
		<td>ㅤ{{ $data->position }}</td>
	</tr>

	<tr>
		<td>Date of birth</td>
		<td colspan="2">ㅤ{{ $data->user->birthday ? $data->user->birthday->format('n/j/Y') : "N/A" }}</td>
		<td>Birthplace</td>
		<td>ㅤ{{ $data->birth_place }}</td>
	</tr>

	<tr>
		<td>Passport</td>
		<td colspan="2">ㅤ{{ $pp ? $pp->number . ' / ' . $pp->expiry_date->format('n/j/Y') : " - " }}</td>
		<td>Seaman's Bk</td>
		<td>ㅤ{{ $sb ? $sb->number . ' / ' . $sb->expiry_date->format('n/j/Y') : " - " }}</td>
	</tr>

	<tr>
		<td>Nationality</td>
		<td colspan="2">ㅤPHILIPPINE</td>
		<td>Applicable CBA</td>
		<td>ㅤ{{ $cba }}</td>
	</tr>

	<tr>
		<td rowspan="2">Vessel</td>
		<td>Name</td>
		<td colspan="2">ㅤ{{ $data->vessel->name }}</td>
		<td>Gross Ton</td>
		<td>ㅤ{{ $data->vessel->gross_tonnage }} G/T</td>
	</tr>

	<tr>
		<td>Flag</td>
		<td colspan="2">ㅤ{{ $data->vessel->flag }}</td>
		<td>Year of Build</td>
		<td>ㅤ{{ $data->vessel->year_build }}</td>
	</tr>

	<tr>
		<td>Period</td>
		<td>From</td>
		<td colspan="2">ㅤ{{ now()->parse($data->effective_date)->format('n/j/Y') }}</td>
		<td>To</td>
		<td>ㅤ{{ now()->parse($data->effective_date)->add($data->employment_months, 'months')->format('n/j/Y') }}</td>
	</tr>

	<tr>
		<td colspan="6">
			1. Commencement of training of the individual cadet shall be at the time of departure from the country of residence to the date of expiration of
			<br style='mso-data-placement:same-cell;' />
			agreement or arrival in the country of residence, unless terminated for just cause or causes enumerated.
			<br style='mso-data-placement:same-cell;' />
			2. The maximum periods of training shall be nine months, which may be extended to ten months or reduced to eight months for operational
			<br style='mso-data-placement:same-cell;' />
			convenience. This periods of training may be reduced following the individual "Cadet's Training Agreement" between themselves and the company.
			<br style='mso-data-placement:same-cell;' />
			3. In the case that the cadet is held captive as a result of acts of piracy and any illegal act of violence, detention, depredation and threat, the
			<br style='mso-data-placement:same-cell;' />
			shipowner, shall not cancel the cadet's training agreement and shall continue until the cadet are released and returned to the repatriation destination
			<br style='mso-data-placement:same-cell;' />
			where is regulated in Clause 1 above no matter what the period of agreement expires.
		</td>
	</tr>

	<tr>
		<td colspan="2">Training Allowance</td>
		<td colspan="4">USD {{ $data->wage->total }} / Month</td>
	</tr>

	<tr>
		<td colspan="2">Payment</td>
		<td colspan="4">Training Allowance shall be paid on the end day of every month to the cadet directly.</td>
	</tr>

	<tr>
		<td>Provision Fee</td>
		<td colspan="5">
			{{-- Costs for food shall be ( {{ $allowance }} US dollars ) per person/day excluding shipment cost. --}}
		</td>
	</tr>

	<tr>
		<td>
			Health and social security benefits
		</td>
		<td colspan="5">
			The shipowner shall provide medical care, Employment Injury and Sickness Benefit, Unemployment Benefit,
			<br style='mso-data-placement:same-cell;' />
			Death/Disability Compensation, Pension Fund for Families of Deceased Seafarer(Survivor's Benefit) to the cadet in
			<br style='mso-data-placement:same-cell;' />
			accordance with Crew's National Law or Collective Bargaining Agreement.
		</td>
	</tr>

	<tr>
		<td>
			Hours of Training and Hours of Rest
		</td>
		<td colspan="5">
			[Hours of Training]
			<br style='mso-data-placement:same-cell;' />
			1. The working hours shall be 8 hours per day, Monday to Friday, a total working hours of 40 hours per week.
			<br style='mso-data-placement:same-cell;' />
			2. The fixed overtime and the guaranteed overtime shall not be more than 103 hours per month.
			<br style='mso-data-placement:same-cell;' />
			[Hours of Rest]
			<br style='mso-data-placement:same-cell;' />
			1. The seafarer shall have a minimum of 10 hours rest in any 24 hour period and 77 hours in any seven-day period.
			<br style='mso-data-placement:same-cell;' />
			2. This period of 24 hours shall begin at the time a seafarer starts work immediately after having had a period at
			<br style='mso-data-placement:same-cell;' />
			least 6 consecutive hours off duty.
			<br style='mso-data-placement:same-cell;' />
			3. The hours of rest may be divided into no more than 2 periods, one of which shall be at least 6 hours in length,
			<br style='mso-data-placement:same-cell;' />
			and the interval between consecutive periods of rest shall not exceed 14 hours.
			<br style='mso-data-placement:same-cell;' />
			4. Shipowner shall provide a compensatory rest period, comparable to hours of work performed, for seafarers who
			<br style='mso-data-placement:same-cell;' />
			have performed necessary work although in a rest period or have been disturbed by call-outs to work during the normal period of rest.
		</td>
	</tr>

	<tr>
		<td>
			Cadet's entitlement to repatriation
		</td>
		<td colspan="5">
			1. Where the cadet leaves at a port other than the chosen repatriation destination, the shipowner shall repatriate
			<br style='mso-data-placement:same-cell;' />
			the cadet to the chosen repatriation destination at the shipowner's expense and responsibility without delay.
			<br style='mso-data-placement:same-cell;' />
			However, this shall not apply to the case that the expenses necessary for the repatriation is paid to the cadet by the
			<br style='mso-data-placement:same-cell;' />
			shipowner on the request of the cadet. 
			<br style='mso-data-placement:same-cell;' />
			2. Despite above 1, where a cadet falls under any of the following cases, a shipowner may claim expenses incurred in
			<br style='mso-data-placement:same-cell;' />
			the repatriation against cadet
			<br style='mso-data-placement:same-cell;' />
			ㅤ1) Where the cadet has left the vessel at his/her discretion without a justifiable reason;
			<br style='mso-data-placement:same-cell;' />
			ㅤ2) Where the cadet has been discharged from the vessel by disciplinary punishment; or
			<br style='mso-data-placement:same-cell;' />
			ㅤ3) Where a cadet falls under the reasons prescribed by a collective bargaining agreement
			<br style='mso-data-placement:same-cell;' />
			3. The maximum period the cadet can be expected to serve onboard before being entitled to repatriation at
			<br style='mso-data-placement:same-cell;' />
			shipowner's expense is periods of cadet's training agreement and the entitlement to repatriation shall not lapse in
			<br style='mso-data-placement:same-cell;' />
			the situation that the cadet is held captive in accordance with a collective bargaining agreement.
		</td>
	</tr>

	<tr>
		<td>
			Any facts not defined in this agreement
		</td>
		<td colspan="5">
			1. Any facts which are not defined in this agreement, these are complied with the law of flag state, crew's national
			<br style='mso-data-placement:same-cell;' />
			law, and a collective bargaining agreement.
			<br style='mso-data-placement:same-cell;' />
			2. Before autographing to this contract, the seafarer confirmed that no fees or other charges for recruitment or
			<br style='mso-data-placement:same-cell;' />
			placement or for providing employment to seafarers are borne directly or indirectly, in whole or in part, to the
			<br style='mso-data-placement:same-cell;' />
			agent of seafarer recruitment and placement. (Other than the cost of the passport or other similar personal travel
			<br style='mso-data-placement:same-cell;' />
			documents.) If the seafarer found that, the fact should be noticed to the shipowner immediately."
		</td>
	</tr>

	<tr>
		<td colspan="6">
			In witness whereof, 2 copies of this agreement have been made and mutually signed by either parties thence each one of them are
			<br style='mso-data-placement:same-cell;' />
			retained by the each party.
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />

			Cadet has opportunity to review and seek advice on the terms and condition and freely accept them.
		</td>
	</tr>

	<tr>
		<td colspan="3"></td>
		<td></td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="3">
			Shipowner(s) or for and on behalf of the shipowner(s) of the vessel
		</td>
		<td></td>
		<td colspan="2" style="text-align: right;">
			Signature of Cadet
		</td>
	</tr>

	<tr>
		<td colspan="6"></td>
	</tr>
</table>