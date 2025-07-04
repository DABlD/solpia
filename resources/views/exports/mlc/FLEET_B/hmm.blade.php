@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	$color = "color: #0000FF;";
@endphp

<table>
	<tr>
		<td colspan="9">
			CHAPTER 2 ㅤ 외국해원 표준근로계약서
			<br>
			<br style='mso-data-placement:same-cell;' />
			2.1  PHILIPPINE CREW(Korea Flag Vessel)
			<br>
		</td>
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
			The following parties to the SEA agree to fully comply with the terms state hereinafter
		</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="9" style="font-weight: bold;">
			1. Seafarer/Shipowner/Ship Manager/Agent/Ship
		</td>
	</tr>

	<tr>
		@if(in_array($data->vessel->id, $newFormHMM))
			<td rowspan="2" style="{{ $center }}">Seafarer</td>
			<td colspan="2">Name</td>
			<td colspan="2" style="{{ $center }} {{ $color }}">
				{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
			</td>
			<td colspan="2" style="{{ $center }}">Date of Birth</td>
			<td colspan="2" style="{{ $center }} {{ $color }}">
				{{ $data->user->birthday != "" ? $data->user->birthday->format('d-M-Y') : '' }}
			</td>
		@else
			<td rowspan="2" style="{{ $center }}">Seafarer</td>
			<td>Name</td>
			<td colspan="3" style="{{ $center }} {{ $color }}">
				{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
			</td>
			<td colspan="2" style="{{ $center }}">Date of Birth</td>
			<td colspan="2" style="{{ $center }} {{ $color }}">
				{{ $data->user->birthday != "" ? $data->user->birthday->format('d-M-Y') : '' }}
			</td>
		@endif
	</tr>

	<tr>
		@if(in_array($data->vessel->id, $newFormHMM))
			<td colspan="2">Capacity</td>
			<td colspan="2" style="{{ $center }} {{ $color }}">
				{{ $data->position }}
			</td>
			<td colspan="2" style="{{ $center }}">Birthplace/Nationality</td>
			<td colspan="2" style="{{ $center }} {{ $color }}">
				{{ $data->birth_place }} / FILIPINO
			</td>
		@else
			<td>Capacity</td>
			<td colspan="3" style="{{ $center }} {{ $color }}">
				{{ $data->position }}
			</td>
			<td colspan="2" style="{{ $center }}">Birthplace/Nationality</td>
			<td colspan="2" style="{{ $center }} {{ $color }}">
				{{ $data->birth_place }} / FILIPINO
			</td>
		@endif
	</tr>

	{{-- INTERCHANGE SHIPOWNER AND Ship MANAGER --}}
	{{-- HMM AMETHYST / --}}
	@if($data->vessel->id == 6239)
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
			<td rowspan="3" style="{{ $center }}">Shipowner</td>
			<td>Company</td>
			<td colspan="7">{{ $data->shipowner }}</td>
		</tr>

		<tr>
			<td>President</td>
			<td colspan="7">KIM KYUNG BAE</td>
		</tr>

		<tr>
			<td>Address</td>
			<td colspan="7">{{ $data->sAddress }}</td>
		</tr>
	@else
		@if(in_array($data->vessel->id, $newFormHMM))
			<tr>
				<td rowspan="6" style="{{ $center }}">Shipowner</td>
				<td rowspan="3" style="text-decoration: underline;">Beneficial</td>
				<td style="text-decoration: underline;">Company</td>
				<td colspan="6">{{ $data->shipowner }}</td>
			</tr>

			<tr>
				<td style="text-decoration: underline;">President</td>
				<td colspan="6">KIM KYUNG BAE</td>
			</tr>

			<tr>
				<td style="text-decoration: underline;">Address</td>
				<td colspan="6">{{ $data->sAddress }}</td>
			</tr>

			<tr>
				<td rowspan="3" style="text-decoration: underline;">MLC</td>
				<td style="text-decoration: underline;">Company</td>
				<td colspan="6">{{ $data->shipowner2 }}</td>
			</tr>

			<tr>
				<td style="text-decoration: underline;">President</td>
				<td colspan="6">KIM GYOU BONG</td>
			</tr>

			<tr>
				<td style="text-decoration: underline;">Address</td>
				<td colspan="6">{{ $data->sAddress2 }}</td>
			</tr>
		@else
			<tr>
				<td rowspan="3" style="{{ $center }}">Shipowner</td>
				<td>Company</td>
				<td colspan="7">{{ $data->shipowner }}</td>
			</tr>

			<tr>
				<td>President</td>
				<td colspan="7">KIM KYUNG BAE</td>
			</tr>

			<tr>
				<td>Address</td>
				<td colspan="7">{{ $data->sAddress }}</td>
			</tr>
		@endif

		@if(isset($data->crewManager))
			@if(in_array($data->vessel->id, $newFormHMM))
				<tr>
					<td rowspan="2" style="{{ $center }} text-decoration: underline;">Ship Manager</td>
					<td colspan="2" style="text-decoration: underline;">Company</td>
					<td colspan="6">{{ $data->crewManager }}</td>
				</tr>

				<tr>
					<td colspan="2" style="text-decoration: underline;">Address</td>
					<td colspan="6">{{ $data->cAddress }}</td>
				</tr>
			@else
				<tr>
					<td rowspan="2" style="{{ $center }} text-decoration: underline;">Ship Manager</td>
					<td>Company</td>
					<td colspan="7">{{ $data->crewManager }}</td>
				</tr>

				<tr>
					<td>Address</td>
					<td colspan="7">{{ $data->cAddress }}</td>
				</tr>
			@endif
		@endif
	@endif

	@if(in_array($data->vessel->id, $newFormHMM))
		<tr>
			<td rowspan="2" style="{{ $center }}">Agent</td>
			<td colspan="2">Company</td>
			<td colspan="6">Solpia Marine and Ship Management, Inc.</td>
		</tr>

		<tr>
			<td colspan="2">Address</td>
			<td colspan="6">2019 San Marcelino St., Malate Manila, Philippines 1004</td>
		</tr>
	@else
		<tr>
			<td rowspan="2" style="{{ $center }}">Agent</td>
			<td>Company</td>
			<td colspan="7">Solpia Marine and Ship Management, Inc.</td>
		</tr>

		<tr>
			<td>Address</td>
			<td colspan="7">2019 San Marcelino St., Malate Manila, Philippines 1004</td>
		</tr>
	@endif

	@if(in_array($data->vessel->id, $newFormHMM))
		<tr>
			<td rowspan="2" style="{{ $center }}">Ship</td>
			<td colspan="2">Ship Name</td>
			<td colspan="2" style="{{ $center }}">{{ $data->vessel->name }}</td>
			<td colspan="2" style="{{ $center }}">G/T</td>
			<td colspan="2" style="{{ $center }}">{{ $data->vessel->gross_tonnage }}</td>
		</tr>

		<tr>
			<td colspan="2">Year Built</td>
			<td colspan="2" style="{{ $center }}">{{ $data->vessel->year_build }}</td>
			<td colspan="2" style="{{ $center }}">Flag</td>
			<td colspan="2" style="{{ $center }}">{{ $data->vessel->flag }}</td>
		</tr>
	@else
		<tr>
			<td rowspan="2" style="{{ $center }}">Ship</td>
			<td>Ship Name</td>
			<td colspan="3" style="{{ $center }}">{{ $data->vessel->name }}</td>
			<td colspan="2" style="{{ $center }}">G/T</td>
			<td colspan="2" style="{{ $center }}">{{ $data->vessel->gross_tonnage }}</td>
		</tr>

		<tr>
			<td>Year Built</td>
			<td colspan="3" style="{{ $center }}">{{ $data->vessel->year_build }}</td>
			<td colspan="2" style="{{ $center }}">Flag</td>
			<td colspan="2" style="{{ $center }}">{{ $data->vessel->flag }}</td>
		</tr>
	@endif

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $bold }}">
			2. Period &#38; Termination of the agreement
		</td>
	</tr>


	@if(in_array($data->vessel->id, $newFormHMM))
		<tr>
			<td rowspan="2" style="{{ $center }}">Period</td>
			<td colspan="2">Date of commencement</td>
			<td colspan="6" style="{{ $color }}">{{ now()->parse($data->effective_date)->format('d-M-Y') }}</td>
		</tr>

		<tr>
			<td colspan="2">Date of termination</td>
			<td colspan="6" style="{{ $color }}">{{ now()->parse($data->effective_date)->add($data->employment_months, 'months')->format('d-M-Y') }}</td>
		</tr>
	@else
		<tr>
			<td rowspan="2" style="{{ $center }}">Period</td>
			<td>Date of commencement</td>
			<td colspan="7" style="{{ $color }}">{{ now()->parse($data->effective_date)->format('d-M-Y') }}</td>
		</tr>

		<tr>
			<td>Date of termination</td>
			<td colspan="7" style="{{ $color }}">{{ now()->parse($data->effective_date)->add($data->employment_months, 'months')->format('d-M-Y') }}</td>
		</tr>
	@endif

	<tr>
		<td style="{{ $center }}">Early Termination</td>
		<td colspan="8" style="height: 90px;">
			ㅤ1) Where the shipowner intends to cancel a Seafarers' employment agreement, he/she shall inform the seafarer of
			<br style="mso-data-placement:same-cell;" />
			ㅤㅤthe cancellation of the Seafarer’s employment agreement in writing with a period of advance notice of not less
			<br style="mso-data-placement:same-cell;" />
			ㅤㅤthan 30 days.
			<br style="mso-data-placement:same-cell;" />
			ㅤ2) The seafarer shall give a notice to shipowner for their early termination in accordance with the flag state
			<br style="mso-data-placement:same-cell;" />
			ㅤㅤregulations as follows.
			<br style="mso-data-placement:same-cell;" />
			ㅤㅤ(1) Korea : Within 30 days  (2) Panama : Minimum 15 days in advance  
			<br style="mso-data-placement:same-cell;" />
			@if(in_array($data->vessel->id, $newFormHMM) || $data->vessel->id == 8791)
			ㅤㅤ(3) Marshall Islands / Liberia / Malta / Isle of Man  : Minimum 7 days in advance
			@else
			ㅤㅤ(3) Marshall Islands / Liberia / Malta : Minimum 7 days in advance
			@endif
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
		<td colspan="2" style="{{ $center }}">
			Fixed/Guaranteed
			<br style='mso-data-placement:same-cell;' />
			Overtime Allowance
		</td>
		<td colspan="3" style="{{ $center }}">Fixed Supervisor Allowance</td>
		<td colspan="2" style="{{ $center }}">Subsistence Allowance</td>
	</tr>

	<tr>
		<td style="{{ $center }} {{ $color }}">
			@php
				$seniority = $data->pro_app->seniority;

				$spay = 0;
				if($data->wage){
					$srpay = json_decode($data->wage->sr_pay);
					
					if($seniority > 1){
						$spay = $srpay[$seniority - 2];
					}
				}

			@endphp
			${{ $data->wage->basic ? ($data->wage->basic) : 0 }}</td>
		<td colspan="2" style="{{ $center }} {{ $color }}">${{ $data->wage->fot ?? $data->wage->ot ?? 0 }}</td>
		<td colspan="3" style="{{ $center }} {{ $color }}">${{ $data->wage->sup_allow ? number_format($data->wage->sup_allow) : 0 }}</td>
		<td colspan="2" style="{{ $center }} {{ $color }}">${{ $data->wage->sub_allow ? number_format($data->wage->sub_allow) : 0 }}</td>
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
		<td colspan="3" style="{{ $center }}">
			Provident Fund
			<br style='mso-data-placement:same-cell;' />
			(Contract Completion Bonus)
		</td>
		<td colspan="2" style="{{ $center }}">Others</td>
	</tr>

	<tr>
		<td style="{{ $center }} {{ $color }}">${{ $data->wage->owner_allow ?? 0}}</td>
		<td colspan="2" style="{{ $center }} {{ $color }}">${{ $spay }}</td>
		<td colspan="3" style="{{ $center }} {{ $color }}">${{ $data->wage->retire_allow ?? 0 }}</td>
		<td colspan="2" style="{{ $center }} {{ $color }}">${{ $data->wage->other_allow ?? 0 }}</td>
	</tr>

	<tr>
		<td style="{{ $center }}">(USD/Month)</td>
		<td colspan="2" style="{{ $center }}">(USD/Month)</td>
		<td colspan="3" style="{{ $center }}">(USD/Month)</td>
		<td colspan="2" style="{{ $center }}">(USD/Month)</td>
	</tr>

	<tr>
		@if(!in_array($data->vessel->id, $newFormHMM))
			<td style="{{ $center }}">Payday</td>
		@else
			<td style="text-decoration: underline; {{ $center }}">Payday</td>
		@endif
		<td colspan="8" style="text-align: justify;">
			All seafarers shall be paid for their work regularly and in full in accordance with this agreement. They shall be paid
			<br style='mso-data-placement:same-cell;' />
			monthly wages not later than 15 days of the succeeding month from the date of commencement of the agreement until
			<br style='mso-data-placement:same-cell;' />
			the date of arrival at point of hire upon termination of their employment.
		</td>
	</tr>

	<tr>
		<td style="{{ $center }}">Payment methods</td>
		<td colspan="8">
			Wages should be paid directly to the seafarer's designated bank accounts unless they request otherwise in writing.
			<br style='mso-data-placement:same-cell;' />
			Some allotments should be remitted in due time and directly to the person or persons nominated by the seafarers.
		</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $bold }}">4. Paid Leave</td>
	</tr>

	<tr>
		<td rowspan="3" style="{{ $center }}">
			The amount of 
			<br style='mso-data-placement:same-cell;' />
			paid leave
		</td>

		<td style="{{ $center }}">Amount</td>
		<td colspan="7" style="{{ $center }}">Method of calculation</td>
	</tr>

	<tr>
		<td style="{{ $center }} {{ $color }}">${{ $data->wage->leave_pay ?? 0 }}</td>
		@if(in_array($data->vessel->id, $newFormHMM))
			<td rowspan="2" colspan="7" style="{{ $center }}">Basic Wage / 30 days X ( 9 ) days</td>
		@else
			<td rowspan="2" colspan="7" style="{{ $center }}">Basic Wage / 30 days X 9 days</td>
		@endif
	</tr>

	<tr>
		<td style="{{ $center }}">(USD/Month)</td>
	</tr>

	<tr>
		<td style="{{ $center }}">The number of days</td>
		
		@if(in_array($data->vessel->id, $newFormHMM))
			<td colspan="8">The number of days of paid leave shall be ( 9 ) days per 1 month of continuous service.</td>
		@else
			<td colspan="8">The number of days of paid leave shall be 9 days per 1 month of continuous service.</td>
		@endif
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
			ㅤThe shipowner provides medical care, sickness benefit, unemployment benefit, employment injury benefit, invalidity benefit, survivors'
			<br style='mso-data-placement:same-cell;' />
			ㅤbenefit, SSS, PhilHealth, and Pag-IBIG to the seafarer.
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
			ㅤ1) The shipowner shall promptly repatriate the seafarer who leaves a ship at the place of which is not the seafarer's country of residence
			<br style="mso-data-placement:same-cell;" />
			ㅤㅤor the place at which the seafarer agreed to enter into the engagement as the shipowner's expenses. However, in case where the
			<br style="mso-data-placement:same-cell;" />
			ㅤㅤshipowner pay the expense of repatriation according to the request of the seafarer, shipowner does not have any responsibility 
			<br style="mso-data-placement:same-cell;" />
			ㅤㅤfor the repatriation.
			<br style="mso-data-placement:same-cell;" />
			<br style="mso-data-placement:same-cell;" />
			ㅤ2) Despite above 1, in case of the following particulars, the shipowner can recover the cost of repatriation from the seafarer.
			<br style="mso-data-placement:same-cell;" />
			ㅤㅤa. When the seafarer leaves a ship without just cause.
			<br style="mso-data-placement:same-cell;" />
			ㅤㅤb. When the seafarer leaves a ship according to disciplinary punishment which regulated in national laws.
			<br style="mso-data-placement:same-cell;" />
			<br style="mso-data-placement:same-cell;" />
			ㅤ3) The amount of money to be spent by the shipowner pursuant to paragraph (1) shall include transportation, accommodation, meals
			<br style="mso-data-placement:same-cell;" />
			ㅤㅤexpenses incurred in the repatriation.
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
			ㅤ1) Hours of work
			<br style="mso-data-placement:same-cell;" />
			ㅤㅤa. Hours of Ordinary Work : 8 hours in a day and 40 hours in a week.
			<br style="mso-data-placement:same-cell;" />
			ㅤㅤb. Over Time Work : Fixed Over Time(103 hours) and Owner’s Guaranteed Overtime.
			<br style="mso-data-placement:same-cell;" />
			<br style="mso-data-placement:same-cell;" />
			ㅤ2) Hours of rest
			<br style="mso-data-placement:same-cell;" />

			@if(in_array($data->vessel->id, $newFormHMM))
				ㅤㅤa. Minimum of 10 hours rest in any 24-hour period and 77 hours in any seven-day period.
			@else
				ㅤㅤa. Minimum of 10 hours rest in any 24 hour period and 77 hours in any seven-day period.
			@endif
			<br style="mso-data-placement:same-cell;" />

			@if(in_array($data->vessel->id, $newFormHMM) || $data->vessel->id == 8791)
				ㅤㅤb. Minimum of 10 hours rest in any 24-hour period may be divided into no more than 2 periods, one of which shall be at least 6 hours
					<br style="mso-data-placement:same-cell;" />
					ㅤㅤㅤin length
			@else
				ㅤㅤb. Minimum of 10 hours rest in any 24-hour period may be divided into no more than two periods, one of which shall be at least six hours
					<br style="mso-data-placement:same-cell;" />
				ㅤㅤㅤin length
			@endif
			<br style="mso-data-placement:same-cell;" />
			ㅤㅤc. The interval between consecutive periods of rest shall not exceed 14 hours.
			<br style="mso-data-placement:same-cell;" />
			ㅤㅤd. Musters and drills shall be conducted in a manner that minimizes the disturbance of rest periods and does not induce fatigue.
			<br style="mso-data-placement:same-cell;" />
			ㅤㅤe. When a seafarer is on call, such as when a machinery space is unattended, the seafarer shall have an adequate compensatory 
			<br style="mso-data-placement:same-cell;" />
			ㅤㅤㅤrest period if the normal period of rest is disturbed by call-outs to work.
		</td>
	</tr>

	<tr>
		<td colspan="9">
			{{-- SPACE ONLY --}}
		</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $bold }} text-decoration: underline;">
			8. Provision and compliance with Risk assessments
		</td>
	</tr>

	<tr>
		@if(in_array($data->vessel->id, $newFormHMM))
		<td colspan="9" style="text-decoration: underline;">
		@else
		<td colspan="9" style="text-decoration: underline;">
		@endif
			ㅤ1) The shipowner shall provide the risk assessment table through the ship's network (EDMS) and make it available for viewing at any time
			<br style="mso-data-placement:same-cell;" />
			ㅤ2) Seafarers shall be aware of the relevant information and check and utilize it frequently
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
			ㅤAny facts which are not defined in this agreement, these are complied with the law of flag state or applicable collective bargaining
			<br style="mso-data-placement:same-cell;" />
			ㅤagreement.
			<br style="mso-data-placement:same-cell;" />
			ㅤ※  As per 2018 amendments to MLC 2006, Standard A 2.1.7 / A 2.2.7 / Guideline B 2.5.1.8, this agreement including the wage, and
			<br style="mso-data-placement:same-cell;" />
			ㅤentitlement to repatriation continues to have effect while a seafarer is held captive on or off the ship as a result of acts of piracy or armed
			<br style="mso-data-placement:same-cell;" />
			ㅤrobbery against ships.
			{{-- DO NOT INCLUDE FOR BAMBOO STAR --}}
			@if($data->vessel->id != 7917)
			<br style="mso-data-placement:same-cell;" />
			ㅤ※	Additional clause for Marshall Islands flag
			<br style="mso-data-placement:same-cell;" />
			ㅤThe terms and conditions laid down herein shall be subject to the applicable provisions of the Maritime Law and Regulations of the Republic
			<br style="mso-data-placement:same-cell;" />
			ㅤof the Marshall Islands and any dispute as to the terms and conditions of this contract shall be resolved in accordance with the Maritime Law
			<br style="mso-data-placement:same-cell;" />
			ㅤand Regulations of the Republic of the Marshall Islands.
			@endif

			{{-- CM1 LIBERIA --}}
			@if(in_array($data->vessel->id, [6791, 7569, 7169, 6245, 7947, 6517, 4433, 33, 36, 37, 38, 6829, 4101, 4627, 3822, 4628, 4629, 2069, 2044, 39, 42, 2725, 8630, 8841, 8827, 8828]))
				<br style="mso-data-placement:same-cell;" />
				ㅤ※ Additional clause for The Republic of Liberia flag
				<br style="mso-data-placement:same-cell;" />
				ㅤ1)	Seafarers, prior to or in the process of engagement, shall be informed about their rights under the seafarers’ recruitment and placement
				<br style="mso-data-placement:same-cell;" />
				ㅤservices’ system of protection, to compensate seafarers for monetary loss that they may incur as a result of the failure of the recruitment
				<br style="mso-data-placement:same-cell;" />
				ㅤand placement service or the relevant shipowner under the seafarers’ employment agreement to meet its obligations to them.
				<br style="mso-data-placement:same-cell;" />
				ㅤ2)	After consultation with the shipowners’ and seafarers’ organizations, the Administration has determined that seafarers’ wages may be
				<br style="mso-data-placement:same-cell;" />
				ㅤpaid to an account other than the seafarers’ designated bank account, if this is requested in writing by the seafarer.
			@endif
		</td>
	</tr>

	<tr>
		<td colspan="9">
			{{-- SPACE ONLY --}}
		</td>
	</tr>

	<tr>
		<td colspan="9">
			In witness whereof, 2 copies of this agreement have been made and mutually signed by either parties thence each one of them are retained by the each party and the seafarer has opportunity to review on the terms and condition and voluntarily accept them.
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
		<td>(signature)</td>
		<td colspan="4" style="{{ $center }} {{ $color }}">
			MR. ADULF KIT  JUMAWAN - CREWING MANAGER
		</td>
		<td>(signature)</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $center }}"></td>
		<td></td>
		<td colspan="4" style="{{ $center }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $center }}">(Seafarer)</td>
		<td></td>

		@if(in_array($data->vessel->id, $newFormHMM))
			<td colspan="4" style="{{ $center }} text-decoration: underline;">For and on behalf of the Shipowner(Beneficial)</td>
		@else
			<td colspan="4" style="{{ $center }}">(Shipowner or for and on behalf of the shipowner)</td>
		@endif
		<td></td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td rowspan="2" colspan="4">
			ㅤPlace where and date when a seafarer’s employment
			<br style='mso-data-placement:same-cell;' />
			ㅤagreement is entered into.
		</td>
		<td colspan="2" style="{{ $center }}">Place</td>
		<td colspan="3" style="{{ $center }} {{ $color }}">MANILA, PHILIPPINES</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $center }}">Date</td>
		<td colspan="3" style="{{ $center }} {{ $color }}">
			@if($data->pro_app->status == "On Board")
				{{ now()->format('d-M-Y') }}
			@else
				{{ now()->parse($data->effective_date)->subDays(5)->format('d-M-Y') }}
			@endif
		</td>
	</tr>

	<tr>
		<td colspan="9" style="text-align: right;"></td>
	</tr>
</table>