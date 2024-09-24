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
		<td colspan="5">ㅤHMM Company Limited</td>
	</tr>

	<tr>
		<td colspan="2">President</td>
		<td colspan="5">ㅤKIM KYUNG BAE</td>
	</tr>

	<tr>
		<td colspan="2">Address</td>
		<td colspan="5">ㅤ108, Yeoui-daero, Yeongdeungpo-gu, Seoul, Republic of Korea</td>
	</tr>

	<tr>
		<td rowspan="2">Ship Manager</td>
		<td colspan="2">Company</td>
		<td colspan="5">ㅤHMM Ocean Service Co., Ltd</td>
	</tr>

	<tr>
		<td colspan="2">Address</td>
		<td colspan="5">ㅤ5th floor, Busan post office building, Jungang-Daero 63, Jung-Gu, Busan, Republic of Korea</td>
	</tr>

	<tr>
		<td rowspan="2">Agent</td>
		<td colspan="2">Company</td>
		<td colspan="5">ㅤSolpia Marine and Ship Management, Inc.</td>
	</tr>

	<tr>
		<td colspan="2">Address</td>
		<td colspan="5">ㅤ2019 San Marcelino St., Malate Manila, Philippines 1004</td>
	</tr>

	<tr>
		<td rowspan="2">Cadet</td>
		<td colspan="2">Name</td>
		<td colspan="5">ㅤ{{ $data->user->namefull }}</td>
	</tr>

	<tr>
		<td colspan="2">Date of Birth</td>
		<td>{{ isset($data->user->birthday) ? $data->user->birthday->format('d-M-Y') : "-" }}</td>
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
		<td>
			{{ now()->parse($data['effective_date'])->format('d-M-Y') }}
			<br style='mso-data-placement:same-cell;' />
			{{ now()->parse($data['effective_date'])->addMonths($data['employment_months'])->format('d-M-Y') }}
		</td>
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
		<td colspan="6">${{ isset($data->wage->total) ? $data->wage->total : "0" }}</td>
	</tr>

	<tr>
		<td colspan="6">(USD/Month)</td>
	</tr>

	<tr>
		<td colspan="2">Payment date/methods</td>
		<td colspan="6">Allowance shall be paid every month according to agency.</td>
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

	<tr>
		<td colspan="8">ㅤ5) Standard of Hours of Training and Hours of Rest</td>
	</tr>

	<tr>
		<td colspan="8">
			1)	Training hours
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤa.	Hours of Ordinary training: 8 Hours in a day and 40 Hours in a week
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			2)	Hours of rest
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤa. Minimum of 10 hours rest in any 24 hour period and 77 hours in any seven-day period.
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤb. Minimum of 10 hours rest in a 24 hour period may be divided into no more than 2 periods, one of which shall be at ㅤㅤㅤleast 6 hours in length.
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤc. The interval between consecutive periods of rest shall not exceed 14 hours.
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤd. Musters and drills shall be conducted in a manner that minimizes the disturbance of rest periods and does not induce ㅤㅤㅤfatigue.
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤe. When a cadet is on call, the cadet shall have an adequate compensatory rest period if the normal period of rest is ㅤㅤㅤdisturbed by call-outs to work.
		</td>
	</tr>

	<tr>
		<td colspan="8">ㅤ6) Provision and compliance with Risk assessments</td>
	</tr>

	<tr>
		<td colspan="8">
			1)	The shipowner shall provide the risk assessment table through the ship’s network (EDMS) and make it available for ㅤviewing at any time.
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			2)	Seafarers shall be aware of the relevant information and check and utilize it frequently.
		</td>
	</tr>

	<tr>
		<td colspan="8">ㅤ7) Any facts which are not defined in this agreement</td>
	</tr>

	<tr>
		<td colspan="8">
			Any facts which are not defined in this agreement, these are complied with the law of flag state. Furthermore, the terms and conditions laid down herein shall be subject to the applicable provisions of the Maritime Law and Regulations of the Republic of the Marshall Islands and any dispute as to the terms and conditions of this contract shall be resolved in accordance with the Maritime Law and Regulations of the Republic of the Marshall Islands.
		</td>
	</tr>

	<tr>
		<td colspan="8">
			In witness whereof, 2 copies of this agreement have been made and mutually signed by either parties thence each one of them are retained by the each party and the cadet has opportunity to review on the terms and condition and voluntarily accept them.
		</td>
	</tr>

	<tr>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="3">{{ $data->user->namefull }}</td>
		<td>(signature)</td>
		<td colspan="3"></td>
		<td>(signature)</td>
	</tr>

	<tr>
		<td colspan="3">Name of cadet</td>
		<td></td>
		<td colspan="4">Shipowner or for and on behalf of the shipowner</td>
	</tr>

	<tr>
		<td colspan="4" rowspan="2">
			Place where and date when a cadet agreement is entered into.
		</td>
		<td>Place</td>
		<td colspan="3">MANILA, PHILIPPINES</td>
	</tr>

	<tr>
		<td>Date</td>
		<td colspan="3">{{ now()->parse($data->effective_date)->subDays(5)->format('d-M-Y') }}</td>
	</tr>
</table>