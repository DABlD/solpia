<table>
	<tr>
		<td colspan="8">Agreement of cadetship</td>
	</tr>

	<tr>
		<td colspan="8">The following parties agrees this agreement to fully comply with the terms stated hereinafter.</td>
	</tr>

	<tr>
		<td colspan="8">1. Parties of the agreement</td>
	</tr>

	<tr>
		<td rowspan="3">Shipowner</td>
		<td colspan="2">Company</td>
		<td colspan="5">&#8205; HMM Company Limited</td>
	</tr>

	<tr>
		<td colspan="2">President</td>
		<td colspan="5">&#8205; KIM KYUNG BAE</td>
	</tr>

	<tr>
		<td colspan="2">Address</td>
		<td colspan="5">&#8205; 108, Yeoui-daero, Yeongdeungpo-gu, Seoul, Republic of Korea</td>
	</tr>

	<tr>
		<td rowspan="2">Ship Manager</td>
		<td colspan="2">Company</td>
		<td colspan="5">&#8205; HMM Ocean Service Co., Ltd</td>
	</tr>

	<tr>
		<td colspan="2">Address</td>
		<td colspan="5">&#8205; 5th floor, Busan post office building, Jungang-Daero 63, Jung-Gu, Busan, Republic of Korea</td>
	</tr>

	<tr>
		<td rowspan="2">Agent</td>
		<td colspan="2">Company</td>
		<td colspan="5">&#8205; Solpia Marine and Ship Management, Inc.</td>
	</tr>

	<tr>
		<td colspan="2">Address</td>
		<td colspan="5">&#8205; 2019 San Marcelino St., Malate Manila, Philippines 1004</td>
	</tr>

	<tr>
		<td rowspan="2">Cadet</td>
		<td colspan="2">Name</td>
		<td colspan="5">&#8205; {{ $data->user->namefull }}</td>
	</tr>

	<tr>
		<td colspan="2">Date of Birth</td>
		<td>&#8205; {{ isset($data->user->birthday) ? $data->user->birthday->format('d-M-Y') : "-" }}</td>
		<td colspan="2">Place of Birth</td>
		<td colspan="2">{{ $data->birth_place }}</td>
	</tr>

	<tr>
		<td colspan="8">2. Contents of the agreement</td>
	</tr>

	<tr>
		<td colspan="8">ㅤ1) Details</td>
	</tr>

	<tr>
		<td rowspan="3">Vessel</td>
		<td colspan="2">Name</td>
		<td>{{ $data->vessel->name }}</td>
		<td colspan="2">G/T</td>
		<td colspan="2">{{ $data->vessel->gross_tonnage }}</td>
	</tr>

	<tr>
		<td colspan="2">Year Built</td>
		<td>{{ $data->vessel->year_build }}</td>
		<td colspan="2">Flag</td>
		<td colspan="2">{{ $data->vessel->flag }}</td>
	</tr>

	<tr>
		<td colspan="2">Period of cadet ship</td>
		<td>{{ $data->employment_months }}</td>
		<td colspan="2">Duty</td>
		<td colspan="2">{{ $data->pro_app->rank->abbr }}</td>
	</tr>

	<tr>
		<td>Early Termination</td>
		<td colspan="7">
			The shipowner shall inform the cadet of the cancellation of the agreement of cadetship in writing with a period of advance notice of not less than 30 days, and the cadet shall inform the shipowner about it in writing at least 7 days’ notice within 30 days for the early termination.
		</td>
	</tr>

	<tr>
		<td colspan="8">ㅤ2) Allowance</td>
	</tr>

	<tr>
		<td rowspan="2" colspan="2">Training Allowance</td>
		<td colspan="6">${{ isset($data->wage->total) ? $data->wage->total : "0" }}.00</td>
	</tr>

	<tr>
		<td colspan="6">(USD/Month)</td>
	</tr>

	<tr>
		<td colspan="2">Payment date/methods</td>
		<td colspan="6">Allowance shall be paid every month according to agency agreement.</td>
	</tr>

	<tr>
		<td colspan="8">ㅤ3) Health and Social Security Protection Benefits</td>
	</tr>

	<tr>
		<td colspan="8">
			The shipowner provides Medical Treatment Compensation, Injury and Disease Compensation and Compensation for bereaved family etc. to the cadet.
		</td>
	</tr>

	<tr>
		<td colspan="8">ㅤ4) Cadet’s entitlement to repatriation</td>
	</tr>

	<tr>
		<td colspan="8">
			1) The shipowner shall promptly repatriate the cadet who leaves a ship at the place of which is not the cadet's country of ㅤresidence or the place at which the cadet agreed to enter into the engagement as the shipowner's expenses. However, in case ㅤwhere the shipowner pay the expense of repatriation according to the request of the cadet, shipowner does not have any ㅤresponsibility for the repatriation.
		</td>
	</tr>

	<tr>
		<td colspan="8">
			2) The amount of money to be spent by the shipowner pursuant to paragraph (1) shall include transportation, accommodation, ㅤmeals expenses incurred in the repatriation.
		</td>
	</tr>
</table>