@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	$color = "color: #0000FF;";
@endphp

<table>
	<tr>
		<td colspan="9">PHILIPPINE CREW</td>
	</tr>

	<tr>
		<td colspan="9" style="text-decoration: underline; height: 40px; font-size: 16px; {{ $bold }} {{ $center }}">
			Seafarer's Employment Agreement
		</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $center }}">
			The following parties to the SEA agree to fully complly with the terms state hereinafter
		</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="9" style="font-weight: bold;">
			1. Seafarer/Capacity/Shipowner/Ship Manager/Agent/Ship
		</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $center }}">Seafarer</td>
		<td>Name</td>
		<td colspan="3" style="{{ $center }} {{ $color }}">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td colspan="2" style="{{ $center }}">Date of Birth</td>
		<td colspan="2" style="{{ $center }} {{ $color }}">
			{{ $data->user->birthday != "" ? $data->user->birthday->format('d-M-Y') : '' }}
		</td>
	</tr>

	<tr>
		<td>Capacity</td>
		<td colspan="3" style="{{ $center }} {{ $color }}">
			{{ $data->position }}
		</td>
		<td colspan="2" style="{{ $center }}">Birthplace/Nationality</td>
		<td colspan="2" style="{{ $center }} {{ $color }}">
			{{ $data->birth_place }} / FILIPINO
		</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $center }}">Shipowner</td>
		<td>Company</td>
		<td colspan="7">{{ $data->shipowner }} / KYUNGBAE KIM</td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="7">{{ $data->sAddress }}</td>
	</tr>

	@if(isset($data->crewManager))
		<tr>
			<td rowspan="2" style="{{ $center }}">Ship Manager</td>
			<td>Company</td>
			<td colspan="7">{{ $data->crewManager }}</td>
		</tr>

		<tr>
			<td>Address</td>
			<td colspan="7">{{ $data->cAddress }}</td>
		</tr>
	@endif

	<tr>
		<td rowspan="2" style="{{ $center }}">Agent</td>
		<td>Company</td>
		<td colspan="7">Solpia Marine and Ship Management, Inc.</td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="7">2019 San Marcelino St., Malate Manila, Philippines 1004</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $center }}">Ship</td>
		<td>Ship Name</td>
		<td colspan="3" style="{{ $center }} {{ $color }}">{{ $data->vessel->name }}</td>
		<td colspan="2" style="{{ $center }}">G/T</td>
		<td colspan="2" style="{{ $center }} {{ $color }}">{{ $data->vessel->gross_tonnage }}</td>
	</tr>

	<tr>
		<td>Year Built</td>
		<td colspan="3" style="{{ $center }} {{ $color }}">{{ $data->vessel->year_build }}</td>
		<td colspan="2" style="{{ $center }}">Flag</td>
		<td colspan="2" style="{{ $center }} {{ $color }}">{{ $data->vessel->flag }}</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $bold }}">
			2. Period &#38; Termination of the agreement
		</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $center }}">Period</td>
		<td>Date of commencement</td>
		<td colspan="7" style="{{ $color }}">{{ now()->parse($data->effective_date)->format('d-M-Y') }}</td>
	</tr>

	<tr>
		<td>Date of termination</td>
		<td colspan="7" style="{{ $color }}">{{ now()->parse($data->effective_date)->add($data->employment_months, 'months')->format('d-M-Y') }}</td>
	</tr>

	<tr>
		<td style="{{ $center }}">Early Termination</td>
		<td colspan="8" style="height: 90px;">
			"1)	Where the shipowner intends to cancel a Seafarers' employment agreement, he/she shall inform the seafarer of the cancellation of the Seafarer’s employment agreement in writing with a period of advance notice of not less than 30 days.
			<br style="mso-data-placement:same-cell;" />
			2)	The seafarer shall give a notice to shipowner for their early termination in accordance with the flag state regulations as follows.
			<br style="mso-data-placement:same-cell;" />
			(1) Korea : Within 30 days  
			<br style="mso-data-placement:same-cell;" />
			(2) Panama : Minimum 15 days in advance  
			<br style="mso-data-placement:same-cell;" />
			(3) Marshall Islands/Liberia/Malta : Minimum 7 days in advance"
		</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $bold }}">3. Wages</td>
	</tr>

	<tr>
		<td rowspan="6" style="{{ $center }}">
			Basic pay 
			<br style="mso-data-placement:same-cell;" />
			&#38; allowance
		</td>
		<td style="{{ $center }}">Basic wage</td>
		<td colspan="2" style="{{ $center }}">Fixed/Guaranteed Overtime Allowance</td>
		<td colspan="3" style="{{ $center }}">Fixed Supervisor Allowance</td>
		<td colspan="2" style="{{ $center }}">Substinence Allowance</td>
	</tr>

	<tr>
		<td style="{{ $center }} {{ $color }}">
			@php
				$seniority = $data->pro_app->seniority;
				$srpay = json_decode($data->wage->sr_pay);
				$spay = 0;

				if($seniority > 1){
					$spay = $srpay[$seniority - 2];
				}
			@endphp
			${{ $data->wage->basic ? ($data->wage->basic) : 0 }}</td>
		<td colspan="2" style="{{ $center }} {{ $color }}">${{ $data->wage->fot ?? $data->wage->ot ?? 0 }}</td>
		<td colspan="3" style="{{ $center }} {{ $color }}">${{ $data->wage->sup_allow ?? 0 }}</td>
		<td colspan="2" style="{{ $center }} {{ $color }}">{{ $data->wage->sub_allow ?? 0 }}</td>
	</tr>

	<tr>
		<td style="{{ $center }}">(USD/Month)</td>
		<td colspan="2" style="{{ $center }}">(USD/Month)</td>
		<td colspan="3" style="{{ $center }}">(USD/Month)</td>
		<td colspan="2" style="{{ $center }}">(USD/Month)</td>
	</tr>

	<tr>
		<td style="{{ $center }}">Owner’s Guaranteed Overtime Allowance</td>
		<td colspan="2" style="{{ $center }}">Seniority Allowance</td>
		<td colspan="3" style="{{ $center }}">Provident Fund (Retirement Payment)</td>
		<td colspan="2" style="{{ $center }}">Others</td>
	</tr>

	<tr>
		<td style="{{ $center }} {{ $color }}">${{ $data->wage->owner_allow ?? 0}}</td>
		<td colspan="2" style="{{ $center }} {{ $color }}">${{ $spay }}</td>
		<td colspan="3" style="{{ $center }} {{ $color }}">${{ $data->wage->retire_allow ?? 0 }}</td>
		<td colspan="2" style="{{ $center }} {{ $color }}">{{ $data->wage->other_allow ?? 0 }}</td>
	</tr>

	<tr>
		<td style="{{ $center }}">(USD/Month)</td>
		<td colspan="2" style="{{ $center }}">(USD/Month)</td>
		<td colspan="3" style="{{ $center }}">(USD/Month)</td>
		<td colspan="2" style="{{ $center }}">(USD/Month)</td>
	</tr>

	<tr>
		<td style="text-decoration: underline; {{ $center }}">Payday</td>
		<td colspan="8">
			All seafarers shall be paid for their work regularly and in full in accordance with this agreement. They shall be paid monthly wages not later than 15 days of the succeeding month from the date of commencement of the agreement until the date of arrival at point of hire upon termination of their employment.
		</td>
	</tr>

	<tr>
		<td style="{{ $center }}">Payment methods</td>
		<td colspan="8">
			"Wages should be paid directly to the seafarers`designated bank accounts unless they request otherwise in writing. 
			Some allotments should be remitted in due time and directly to the person or persons nominated by the seafarers."
		</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $bold }}">4. Paid Leave</td>
	</tr>

	<tr>
		<td rowspan="3" style="{{ $center }}">The amound of Paid Leave</td>
		<td style="{{ $center }}">Amount of P/L</td>
		<td colspan="7" style="{{ $center }}">Method of calculation</td>
	</tr>

	<tr>
		<td style="{{ $center }} {{ $color }}">${{ $data->wage->leave_pay ?? 0 }}</td>
		<td rowspan="2" colspan="7" style="{{ $center }}">Basic Wage / 30 days X 9 days</td>
	</tr>

	<tr>
		<td style="{{ $center }}">(USD/Month)</td>
	</tr>

	<tr>
		<td style="text-decoration: underline; {{ $center }}">The number of days</td>
		<td colspan="8">The number of days of paid leave shall be 9 days per 1 month of continuous service.</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="9">
			{{-- set height to move to page 2 --}}
		</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $bold }}">
			5. Health and social security protection benefits
		</td>
	</tr>

	<tr>
		<td colspan="9">
			The shipowner provides medical care, sickness benefit, unemployment benefit, employment injury benefit, invalidity benefit, survivors' benefit, SSS, PhilHealth, and Pag-IBIG to the seafarer.
		</td>
	</tr>

	<tr>
		<td colspan="9">
			{{-- SPACE ONLY --}}
		</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $bold }}">
			6. Seafarer's entitlement to repatriation
		</td>
	</tr>

	<tr>
		<td colspan="9">
			1) The shipowner shall promptly repatriate the seafarer who leaves a ship at the place of which is not the seafarer's country of residence
			or the place at which the seafarer agreed to enter into the engagement as the shipowner's expenses. However, in case where the
			shipowner pay the expense of repatriation according to the request of the seafarer, shipowner does not have any responsibility 
			for the repatriation.
			<br style="mso-data-placement:same-cell;" />
			2) Despite above 1, in case of the following particulars, the shipowner can recover the cost of repatriation from the seafarer.
			<br style="mso-data-placement:same-cell;" />
			a. When the seafarer leaves a ship without just cause.
			<br style="mso-data-placement:same-cell;" />
			b. When the seafarer leaves a ship according to disciplinary punishment which regulated in national laws.
			<br style="mso-data-placement:same-cell;" />
			3) The amount of money to be spent by the shipowner pursuant to paragraph (1) shall include transportation, accommodation, meals expenses incurred in the repatriation.
		</td>
	</tr>

	<tr>
		<td colspan="9">
			{{-- SPACE ONLY --}}
		</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $bold }}">
			7. Standard of Hours of Work and Hours of Rest
		</td>
	</tr>

	<tr>
		<td colspan="9">
			1) Hours of work
			<br style="mso-data-placement:same-cell;" />
			a. Hours of Ordinary Work : 8 hours in a day and 40 hours in a week.
			<br style="mso-data-placement:same-cell;" />
			b. Over Time Work : Fixed Over Time(103 hours) and Owner’s Guaranteed Overtime.
			<br style="mso-data-placement:same-cell;" />
			2) Hours of rest
			<br style="mso-data-placement:same-cell;" />
			a. Minimum of 10 hours rest in any 24 hour period and 77 hours in any seven-day period.
			<br style="mso-data-placement:same-cell;" />
			b. Minimum of 10 hours rest in any 24-hour period may be divided into no more than two periods, one of which shall be at least six hours in length
			<br style="mso-data-placement:same-cell;" />
			c. The interval between consecutive periods of rest shall not exceed 14 hours.
			<br style="mso-data-placement:same-cell;" />
			d. Musters and drills shall be conducted in a manner that minimizes the disturbance of rest periods and does not induce fatigue.
			<br style="mso-data-placement:same-cell;" />
			e. When a seafarer is on call, such as when a machinery space is unattended, the seafarer shall have an adequate compensatory 
			<br style="mso-data-placement:same-cell;" />
			Rest periodic the normal period of rest is disturbed by call-outs to work.
		</td>
	</tr>

	<tr>
		<td colspan="9">
			{{-- SPACE ONLY --}}
		</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $bold }}">
			8. Provision and compliance with Risk assessments
		</td>
	</tr>

	<tr>
		<td colspan="9">
			1) The shipowner shall provide the risk assessment table through the ship's nemtwork (EDMS) and make it aavailable for viewing
			<br style="mso-data-placement:same-cell;" />
			at any time
			<br style="mso-data-placement:same-cell;" />
			2) Seafarers shall be aware of the relevant information and check and utilize it frequently
		</td>
	</tr>

	<tr>
		<td colspan="9">
			{{-- SPACE ONLY --}}
		</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $bold }}">
			9. Any facts which are not defined in this agreement
		</td>
	</tr>

	<tr>
		<td colspan="9">
			Any facts which are not defined in this agreement, Korean seafarers shall be applied [Regulations for employment], Foreign seafarers shall be applied [IBF FKSU CA(BBCHP)]
			<br style="mso-data-placement:same-cell;" />
			※  As per 2018 amendments to MLC 2006, Standard A 2.1.7 / A 2.2.7 / Guideline B 2.5.1.8, this agreement including the wage, and
			entitlement to repatriation continues to have effect while a seafarer is held captive on or off the ship as a result of acts of piracy or armed robbery against ships.
			<br style="mso-data-placement:same-cell;" />
			※	Additional clause for Marshall Islands flag
			The terms and conditions laid down herein shall be subject to the applicable provisions of the Maritime Law and Regulations of the Republic of the Marshall Islands and any dispute as to the terms and conditions of this contract shall be resolved in accordance with the Maritime Law and Regulations of the Republic of the Marshall Islands.
		</td>
	</tr>

	<tr>
		<td colspan="9">
			{{-- SPACE ONLY --}}
		</td>
	</tr>

	<tr>
		<td colspan="9">
			In witness whereof, 2 copies of this agreement have been made and mutually signed by either partiesthence each one of them are retained by the each party and the seafarer has opportunity to review on the terms and condition andvoluntarily accept them.
		</td>
	</tr>

	<tr>
		<td colspan="9">
			{{-- SET HEIGHT TO GIVE SPACE TO SIGNATURE --}}
		</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $center }} {{ $color }}">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td></td>
		<td colspan="4" style="{{ $center }} {{ $color }}">
			MS. JEANNETTE T. SOLIDUM - CREWING MANAGER
		</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $center }}">(signature)</td>
		<td></td>
		<td colspan="4" style="{{ $center }}">(signature)</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $center }}">(Seafarer)</td>
		<td></td>
		<td colspan="4" style="{{ $center }}">(Shipowner or for and on behalf of the shipowner)</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td rowspan="2" colspan="4">
			Place where and date when a seafarer’s employment 
			agreement is entered into.
		</td>
		<td colspan="2" style="{{ $center }}">Place</td>
		<td colspan="3" style="{{ $center }} {{ $color }}">MANILA, PHILIPPINES</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $center }}">Date</td>
		<td colspan="3" style="{{ $center }} {{ $color }}">{{ now()->format('d-M-Y') }}</td>
	</tr>

	<tr>
		<td colspan="9" style="text-align: right;"></td>
	</tr>
</table>