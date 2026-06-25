@php
@endphp

<table>
	<tr>
		<td>CHAPTER  2</td>
		<td colspan="10">Seafarer's employment agreement for Foreign Crew</td>
	</tr>

	<tr>
		<td colspan="11">2.2 NON KOREAN CREW(Non Korea Flag Vessel)</td> {{--  WILL BE EDITED TO RICH TEXT DUE TO CUSTOM UNDERLINE --}}
	</tr>

	<tr>
		<td colspan="11">Seafarer`s Employment Agreement</td>
	</tr>

	<tr>
		<td colspan="11">The following parties to the SEA agree to fully comply with the terms stated hereinafter.</td>
	</tr>

	<tr>
		<td colspan="11">1.	Seafarer/Shipowner/Ship Manager/Agent/Ship</td> // RICH TEXT
	</tr>

	{{-- SEAFARER --}}
	<tr>
		<td rowspan="2">Seafarer</td>
		<td colspan="3">Name</td>
		<td colspan="3">{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}</td>
		<td colspan="2">Date of Birth</td>
		<td colspan="2">{{ $data->user->birthday != "" ? $data->user->birthday->format('d-M-Y') : '' }}</td>
	</tr>

	<tr>
		<td colspan="3">Capacity</td>
		<td colspan="3">{{ $data->position }}</td>
		<td colspan="2">Birthplace/Nationality</td>
		<td colspan="2">{{ $data->birth_place }} / Filipino</td>
	</tr>

	{{-- SHIPOWNER --}}
	<tr>
		<td rowspan="6">Shipowner</td>
		<td rowspan="3">Beneficial</td>
		<td colspan="2">Company</td>
		<td colspan="7">{{ $shipownerA['company'] ?? "-" }}</td>
	</tr>

	<tr>
		<td colspan="2">President</td>
		<td colspan="7">{{ $shipownerA['president'] ?? "-" }}</td>
	</tr>

	<tr>
		<td colspan="2">Address</td>
		<td colspan="7">{{ $shipownerA['address'] ?? "-" }}</td>
	</tr>

	<tr>
		<td rowspan="3">MLC</td>
		<td colspan="2">Company</td>
		<td colspan="7">{{ $shipownerB['company'] ?? "-" }}</td>
	</tr>

	<tr>
		<td colspan="2">President</td>
		<td colspan="7">{{ $shipownerB['president'] ?? "-" }}</td>
	</tr>

	<tr>
		<td colspan="2">Address</td>
		<td colspan="7">{{ $shipownerB['address'] ?? "-" }}</td>
	</tr>

	{{-- SHIP MANAGER --}}
	<tr>
		<td rowspan="2">Ship Manager</td>
		<td colspan="3">Company</td>
		<td colspan="7">{{ $shipmanager['company'] ?? "-" }}</td>
	</tr>

	<tr>
		<td colspan="3">Address</td>
		<td colspan="7">{{ $shipmanager['address'] ?? "-" }}</td>
	</tr>

	{{-- AGENT --}}
	<tr>
		<td rowspan="2">Agent</td>
		<td colspan="3">Company</td>
		<td colspan="7">Solpia Marine &#38; Ship Management, Inc.</td>
	</tr>

	<tr>
		<td colspan="3">Address</td>
		<td colspan="7">2019 San Marcelino St., Malate Manila, Philippines 1004</td>
	</tr>

	{{-- SHIP --}}
	<tr>
		<td rowspan="2">Ship</td>
		<td colspan="3">Ship name</td>
		<td colspan="3">{{ $data->vessel->name }}</td>
		<td colspan="2">G/T</td>
		<td colspan="2">{{ $data->vessel->gross_tonnage }}</td>
	</tr>

	<tr>
		<td colspan="3">Year Built</td>
		<td colspan="3">{{ $data->vessel->year_build }}</td>
		<td colspan="2">Flag</td>
		<td colspan="2">{{ $data->vessel->flag }}</td>
	</tr>

	{{-- END --}}

	{{-- COMMENCEMENT AND TERMINATION --}}
	<tr>
		<td colspan="11">2.	Period &#38; Termination of the agreement</td>
	</tr>

	<tr>
		<td rowspan="2">Period</td>
		<td colspan="3">Date of commencement</td>
		<td colspan="7">{{ now()->parse($data->effective_date)->format('d-M-Y') }}</td>
	</tr>

	<tr>
		<td colspan="3">Date of termination</td>
		<td colspan="7">{{ now()->parse($data->effective_date)->add($data->employment_months, 'months')->format('d-M-Y') }}</td>
	</tr>

	<tr>
		<td>Early termination</td>
		<td colspan="10">
			1)	Where the shipowner intends to cancel a Seafarers' employment agreement, he/she shall inform the seafarer of
			<br style='mso-data-placement:same-cell;' />
			ㅤthe cancellation of the Seafarers' employment agreement in writing with a period of advance notice of not less
			<br style='mso-data-placement:same-cell;' />
			ㅤthan 30 days.
			<br style='mso-data-placement:same-cell;' />
			2)	The seafarer shall give a notice to shipowner for their early termination in accordance with the flag state
			<br style='mso-data-placement:same-cell;' />
			ㅤregulations as follows.
			<br style='mso-data-placement:same-cell;' />
			ㅤ(1) Korea : Within 30days  (2) Panama : Minimum of 15 days in advance
			<br style='mso-data-placement:same-cell;' />
			ㅤ(3) Marshall Island / Liberia / Malta / Isle of Man : Minimum of 7 days in advance
		</td>
	</tr>

	{{-- WAGES --}}
	<tr>
		<td colspan="11">3.	Wages</td>
	</tr>

	<tr>
		<td rowspan="4">
			Basic pay 
			<br style='mso-data-placement:same-cell;' />
			&#38; allowance
		</td>
		<td colspan="3">Basic wage</td>
		<td colspan="3">Fixed/Guaranteed Overtime Allowance</td> {{-- RICH TEXTED --}}
		<td colspan="2">Fixed Supervisor Allowance</td>
		<td colspan="2">Subsistence Allowance</td>
	</tr>

	<tr>
		<td colspan="3">
			${{ $data->wage->basic ? ($data->wage->basic) : 0 }}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
		<td colspan="3">
			${{ $data->wage->fot ?? $data->wage->ot ?? 0 }}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
		<td colspan="2">
			${{ $data->wage->sup_allow ? number_format($data->wage->sup_allow) : 0 }}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
		<td colspan="2">
			${{ $data->wage->sub_allow ? number_format($data->wage->sub_allow) : 0 }}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
	</tr>

	<tr>
		<td colspan="3">Owner's Guaranteed Overtime Allowance</td>
		<td colspan="3">Seniority Allowance</td>
		<td colspan="2">Provident Fund (Contract Completion Bonus)</td> {{-- RICH TEXTED --}}
		<td colspan="2">Others</td>
	</tr>

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

	<tr>
		<td colspan="3">
			${{ $data->wage->owner_allow ?? 0}}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
		<td colspan="3">
			${{ $spay }}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
		<td colspan="2">
			${{ $data->wage->retire_allow ?? 0 }}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
		<td colspan="2">
			${{ $data->wage->other_allow ?? 0 }}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
	</tr>

	<tr>
		<td>Payday</td>
		<td colspan="10">
			All seafarers shall be paid for their work regularly and in full in accordance with this agreement. They shall be entitled
			<br style='mso-data-placement:same-cell;' />
			to payment of their net wages at the end of each calendar month until the date of arrival at point of hire upon
			<br style='mso-data-placement:same-cell;' />
			termination of their employment.
		</td>
	</tr>

	<tr>
		<td>Payment methods</td>
		<td colspan="10">
			Wages should be paid directly to the seafarers on board or remitted to their designated bank accounts unless they
			<br style='mso-data-placement:same-cell;' />
			request otherwise in writing.
			<br style='mso-data-placement:same-cell;' />
			Some allotments should be remitted in due time and directly to the person or persons nominated by the seafarers.
		</td>
	</tr>

	{{-- PAID LEAVE --}}
	<tr>
		<td colspan="11">4.	Paid Leave</td>
	</tr>

	<tr>
		<td rowspan="2">The amount of Paid leave</td>
		<td colspan="3">Amount</td>
		<td colspan="7">Method of calculation</td>
	</tr>

	<tr>
		<td colspan="3">
			${{ $data->wage->leave_pay ?? 0 }}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
		<td colspan="7">Basic Wage / 30 days X ( 9 ) days</td>
	</tr>

	<tr>
		<td>The number of days</td>
		<td colspan="10">ㅤThe number of days of paid leave shall be ( 9 ) days per 1 month of continuous service.</td>
	</tr>

	{{-- Health and social security protection benefits --}}
	<tr>
		<td colspan="11">5.	Health and social security protection benefits</td>
	</tr>

	<tr>
		<td colspan="11">
			ㅤ※ㅤPhilippine Crew : The shipowner provides medical care, sickness benefit, unemployment benefit, employment injury benefit,
			<br style='mso-data-placement:same-cell;' />
			ㅤinvalidity benefit, survivors' benefit, SSS, PhilHealth, and Pag-IBIG to the seafarer.
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			ㅤ※ㅤMyanmar/Indonesian Crew : The shipowner provides medical care, sickness benefit, unemployment benefit, employment injury 
			<br style='mso-data-placement:same-cell;' />
			ㅤbenefit, invalidity benefit, and survivors' benefit to the seafarer.
		</td>
	</tr>

	<tr>
		<td colspan="11">6.	Seafarer's entitlement to repatriation</td>
	</tr>

	<tr>
		<td colspan="11">
			ㅤ 1)	The shipowner shall promptly repatriate the seafarer who leaves a ship at the place of which is not the seafarer's country of residence
			<br style='mso-data-placement:same-cell;' />
			ㅤ ㅤ or the place at which the seafarer agreed to enter into the engagement as the shipowner's expenses. However, in case where the
			<br style='mso-data-placement:same-cell;' />
			ㅤ ㅤ shipowner pay the expense of repatriation according to the request of the seafarer, shipowner does not have any responsibility 
			<br style='mso-data-placement:same-cell;' />
			ㅤ ㅤ for the repatriation.
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			ㅤ2) Despite above 1, in case of the following particulars, the shipowner can recover the cost of repatriation from the seafarer.
			<br style='mso-data-placement:same-cell;' />
			ㅤ ㅤ a. When the seafarer leaves a ship without just cause.
			<br style='mso-data-placement:same-cell;' />
			ㅤ ㅤ b. When the seafarer leaves a ship according to disciplinary punishment which regulated in national laws.
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			ㅤ3) The amount of money to be spent by the shipowner pursuant to paragraph (1) shall include transportation, accommodation, meals
			<br style='mso-data-placement:same-cell;' />
			ㅤ ㅤ expenses incurred in the repatriation.
		</td>
	</tr>

	<tr>
		<td colspan="11">7.	Standard of Hours of Work and Hours of Rest</td>
	</tr>

	<tr>
		<td colspan="11">
			ㅤ1)	Hours of work
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤa. Hours of Ordinary Work : 8 hours in a day and 40 hours in a week.
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤb. Over Time Work : Fixed Over Time(103 hours) and Owner’s Guaranteed Overtime.
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			ㅤ2)	Hours of rest
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤa. Minimum of 10 hours rest in any 24-hour period and 77 hours in any seven-day period.
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤb. Minimum of 10 hours rest in any 24-hour period may be divided into no more than 2 periods, one of which shall be at least 6 hours
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤㅤin length.
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤc. The interval between consecutive periods of rest shall not exceed 14 hours.
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤd. Musters and drills shall be conducted in a manner that minimizes the disturbance of rest periods and does not induce fatigue.
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤe. When a seafarer is on call, such as when a machinery space is unattended, the seafarer shall have an adequate compensatory 
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤㅤrest period if the normal period of rest is disturbed by call-outs to work.
		</td>
	</tr>

	<tr>
		<td colspan="11">8.	Provision and compliance with Risk assessments</td>
	</tr>

	<tr>
		<td colspan="11">
			ㅤ1)  The Shipowner shall provide the risk assessment table through the ship’s network(EDMS) and make it available for viewing at any time.
			<br style='mso-data-placement:same-cell;' />
			ㅤ2)  Seafarers shall be aware of the relevant information and check and utilize it frequently.
		</td>
	</tr>

	<tr>
		<td colspan="11">9.	Any facts which are not defined in this agreement</td>
	</tr>

	<tr>
		<td colspan="11">
			ㅤAny facts which are not defined in this agreement, these are complied with the law of flag state or applicable collective bargaining
			<br style='mso-data-placement:same-cell;' />
			ㅤagreement.
			<br style='mso-data-placement:same-cell;' />
			ㅤ[⬛ IBF FKSU CA(BBCHP)  / ⬜ IBF FKSU/AMOSUP-KSA CBA  / ⬜ PNO Model IBF CBA  / ⬜ Seafarer’s National Law]
			<br style='mso-data-placement:same-cell;' />
		</td>
	</tr>

	<tr>
		<td colspan="11">
			ㅤ※  As per 2018 amendments to MLC 2006, Standard A 2.1.7 / A 2.2.7 / Guideline B 2.5.1.8, this agreement including the wage, and
			<br style='mso-data-placement:same-cell;' />
			ㅤentitlement to repatriation continues to have effect while a seafarer is held captive on or off the ship as a result of acts of piracy or armed
			<br style='mso-data-placement:same-cell;' />
			ㅤrobbery against ships.
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			ㅤ※  As per 2022 amendments to MLC 2006, Standard A1.4.5(c)(vi), seafarers, prior to or in the process of engagement, shall be informed
			<br style='mso-data-placement:same-cell;' />
			ㅤabout their rights under the seafarers’ recruitment and placement services’ system of protection, to compensate seafarers for monetary loss
			<br style='mso-data-placement:same-cell;' />
			ㅤthat they may incur as a result of the failure of the recruitment and placement service or the relevant shipowner under the seafarers’
			<br style='mso-data-placement:same-cell;' />
			ㅤemployment agreement to meet its obligations to them.
			<br style='mso-data-placement:same-cell;' />

			{{-- IF NOT "M/V HMM HARMONY","M/V HMM MASTER","M/V HMM MIRACLE" --}}
			@if(!in_array($data->vessel->id, [6829,7998,7108]))
				{{-- PARAMOUNT, ORIENTAL AQUAMARINE, UNIVERSAL CHALLENGER, FRONTIER, INNOVATOR --}}
				{{-- PACIFIC CHAMP, ATLANTIC AFFINITY, BONANZA, OCEAN FLORA --}}
				@if(in_array($data->vessel->id, [8169,6072,5842,5801,5553,7517,7141,9274,7917,9591]))
				<br style='mso-data-placement:same-cell;' />
				ㅤ※	Additional clause for Liberia flag
				<br style='mso-data-placement:same-cell;' />
				ㅤAfter consultation with the shipowners’ and seafarers’ organizations, the Administration has determined that seafarers’ wages may be paid to
				<br style='mso-data-placement:same-cell;' />
				ㅤan account other than the seafarers’ designated bank account, if this is requested in writing by the seafarer.
				{{-- ULSAN, ANTWERP --}}
				@elseif(in_array($data->vessel->id, [4637, 4623]))
				<br style='mso-data-placement:same-cell;' />
				ㅤ※	Additional clause for Marshall Islands flag
				<br style='mso-data-placement:same-cell;' />
				ㅤThe terms and conditions laid down herein shall be subject to the applicable provisions of the Maritime Law and Regulations of the Republic 
				<br style='mso-data-placement:same-cell;' />
				ㅤof the Marshall Islands and any dispute as to the terms and conditions of this contract shall be resolved in accordance with the Maritime Law 
				<br style='mso-data-placement:same-cell;' />
				ㅤand Regulations of the Republic of the Marshall Islands.
				@endif
			@endif
		</td>
	</tr>

	<tr>
		<td colspan="11">
			In witness whereof, 2 copies of this agreement have been made and mutually signed by either parties thence each one of them 
			<br style='mso-data-placement:same-cell;' />
			are retained by the each party and the seafarer was given sufficient time to review and opportunity to seek advice on the terms
			<br style='mso-data-placement:same-cell;' />
			and condition and voluntarily accept them.
		</td>
	</tr>

	<tr>
		<td colspan="3">{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}</td>
		<td colspan="2">(signature)</td>
		<td colspan="5">Mr. Adulf Kit Jumawan - Crewing Manager</td>
		<td>(signature)</td>
	</tr>

	<tr>
		<td colspan="3">(Seafarer)</td>
		<td colspan="2"></td>
		<td colspan="5">
			@if(in_array($data->vessel->name, ["M/V ATLANTIC BONANZA", "M/V PACIFIC CHAMP", "M/V ATLANTIC AFFINITY","M/V OCEAN FLORA", "M/T ORIENTAL AQUAMARINE", "M/T UNIVERSAL CHALLENGER", "M/T UNIVERSAL FRONTIER", "M/T UNIVERSAL INNOVATOR", "M/V HMM PARAMOUNT", "M/V GLOBAL GOLDEN"]))
				(For and on behalf of the Shipowner)
			@else
				(For and on behalf of the Shipowner(Beneficial))
			@endif
		</td>
		<td></td>
	</tr>

	<tr>
		<td rowspan="2" colspan="5">
			ㅤPlace where and date when a seafarer’s employment
			<br style='mso-data-placement:same-cell;' />
			ㅤagreement is entered into.
		</td>
		<td colspan="3">ㅤPlace</td>
		<td colspan="3">ㅤManila, Philippines</td>
	</tr>

	<tr>
		<td colspan="3">ㅤDate</td>
		<td colspan="3">ㅤ
			@if($data->pro_app->status == "On Board")
				{{ now()->format('d-M-Y') }}
			@else
				{{ now()->parse($data->effective_date)->subDays(5)->format('d-M-Y') }}
			@endif
		</td>
	</tr>
</table>