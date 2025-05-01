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
</table>