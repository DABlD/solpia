@php
@endphp

<table>
	<tr>
		<td colspan="8">Seafarer`s Employment Agreement</td>
	</tr>

	<tr>
		<td colspan="8">The following parties to the SEA agree to fully comply with the terms stated hereinafter.</td>
	</tr>

	<tr>
		<td colspan="8">1.	Seafarer/Shipowner/Ship Manager/Agent/Ship</td> {{-- RICH TEXTED NO MORE --}}
	</tr>

	{{-- 1 --}}
	<tr>
		<td rowspan="2">Seafarer</td>
		<td>Name</td>
		<td colspan="3">{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}</td>
		<td>Date of Birth</td>
		<td colspan="2">{{ $data->user->birthday != "" ? $data->user->birthday->format('d-M-Y') : '' }}</td>
	</tr>

	<tr>
		<td>Capacity</td>
		<td colspan="3">{{ $data->position }}</td>
		<td>Birthplace / Nationality</td>
		<td colspan="2">{{ $data->birth_place }} / Filipino</td>
	</tr>

	<tr>
		<td rowspan="3">Shipowner</td>
		<td>Company</td>
		<td colspan="6">{{ $shipowner['company'] ?? "-" }}</td>
	</tr>

	<tr>
		<td>President</td>
		<td colspan="6">{{ $shipowner['president'] ?? "-" }}</td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="6">{{ $shipowner['address'] ?? "-" }}</td>
	</tr>

	<tr>
		<td rowspan="2">Ship Manager</td>
		<td>Company</td>
		<td colspan="6">{{ $shipmanager['company'] ?? "-" }}</td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="6">{{ $shipmanager['address'] ?? "-" }}</td>
	</tr>

	<tr>
		<td rowspan="2">Agent</td>
		<td>Company</td>
		<td colspan="6">Solpia Marine &#38; Ship Management, Inc.</td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="6">2019 San Marcelino St., Malate Manila, Philippines 1004</td>
	</tr>

	<tr>
		<td rowspan="2">Ship</td>
		<td>Ship name</td>
		<td colspan="3">{{ $data->vessel->name }}</td>
		<td>G/T</td>
		<td colspan="2">{{ $data->vessel->gross_tonnage }}</td>
	</tr>

	<tr>
		<td>Year built</td>
		<td colspan="3">{{ $data->vessel->year_build }}</td>
		<td>Flag</td>
		<td colspan="2">{{ $data->vessel->flag }}</td>
	</tr>

	{{-- 2 --}}

	<tr>
		<td colspan="8">2.	Period &#38; Termination of the agreement</td>
	</tr>

	<tr>
		<td rowspan="2">Period</td>
		<td>Date of commencement</td>
		<td colspan="6">{{ now()->parse($data->effective_date)->format('d-M-Y') }}</td>
	</tr>

	<tr>
		<td>Date of termination</td>
		<td colspan="6">{{ now()->parse($data->effective_date)->add($data->employment_months, 'months')->format('d-M-Y') }}</td>
	</tr>

	<tr>
		<td>Early Termination</td>
		<td colspan="7">
			1)	Where the shipowner intends to cancel a Seafarers' employment agreement, he/she shall inform the seafarer of
			<br style='mso-data-placement:same-cell;' />
			ㅤthe cancellation of the Seafarer’s employment agreement in writing with a period of advance notice of not less
			<br style='mso-data-placement:same-cell;' />
			ㅤthan 30 days.
			<br style='mso-data-placement:same-cell;' />
			2)	The seafarer shall give a notice to shipowner for their early termination in accordance with the flag state
			<br style='mso-data-placement:same-cell;' />
			ㅤregulations as follows.
			<br style='mso-data-placement:same-cell;' />
			ㅤ(1) Korea : Within 30 days  (2) Panama : Minimum 15 days in advance  
			<br style='mso-data-placement:same-cell;' />
			ㅤ(3) Marshall Islands/Liberia/Malta : Minimum 7 days in advance
		</td>
	</tr>

	{{-- 3 --}}

	<tr>
		<td colspan="8">3. Wages</td>
	</tr>

	<tr>
		<td rowspan="4">
			Basic pay
			<br style='mso-data-placement:same-cell;' />
			&#38; allowance
		</td>
		<td>Basic wage</td>
		<td colspan="2">Fixed/Guaranteed Overtime Allowance</td> {{-- RICH TEXTED NO MORE --}}
		<td colspan="2">Fixed Supervisor Allowance</td>
		<td colspan="2">Subsistence Allowance</td>
	</tr>

	<tr>
		<td>
			${{ $data->wage->basic ? ($data->wage->basic) : 0 }}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
		<td colspan="2">
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
		<td>Owner's Guaranteed Overtime Allowance</td>
		<td colspan="2">Seniority Allowance</td>
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
		<td>
			${{ $data->wage->owner_allow ?? 0}}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
		<td colspan="2">
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
		<td colspan="7">
			ㅤAll seafarers shall be paid for their work regularly and in full in accordance with this agreement. They shall be paid monthly wages
			<br style='mso-data-placement:same-cell;' />
			ㅤnot later than 15 days of the succeeding month from the date of commencement of the agreement until the date of arrival at point of
			<br style='mso-data-placement:same-cell;' />
			ㅤhire upontermination of their employment.
		</td>
	</tr>

	<tr>
		<td>Payment methods</td>
		<td colspan="7">
			ㅤWages should be paid directly to the seafarers` designated bank accounts unless they request otherwise in writing. 
			<br style='mso-data-placement:same-cell;' />
			ㅤSome allotments should be remitted in due time and directly to the person or persons nominated by the seafarers.
		</td>
	</tr>

	{{-- 4 --}}

	<tr>
		<td colspan="8">4. Paid leave</td>
	</tr>

	<tr>
		<td rowspan="2">The amount of paid leave</td>
		<td>Amount</td>
		<td colspan="6">Method of calculation</td>
	</tr>

	<tr>
		<td>
			${{ $data->wage->leave_pay ?? 0 }}
			<br style='mso-data-placement:same-cell;' />
			(USD/Month)
		</td>
		<td colspan="6">
			Basic Wage / 30 days X 9 days
		</td>
	</tr>

	<tr>
		<td>The number of days</td>
		<td colspan="7">
			ㅤThe number of days of paid leave shall be 9 days per 1 month of continuous service.
		</td>
	</tr>

	{{-- 5 --}}
	<tr>
		<td colspan="8">5.	Health and social security protection benefits</td>
	</tr>

	<tr>
		<td colspan="8">
			ㅤThe shipowner provides medical care, sickness benefit, unemployment benefit, employment injury benefit, invalidity benefit, survivors'
			<br style='mso-data-placement:same-cell;' />
			ㅤbenefit, SSS, PhilHealth, and Pag-IBIG to the seafarer.
		</td>
	</tr>

	{{-- 6 --}}
	<tr>
		<td colspan="8">6.	Seafarer's entitlement to repatriation</td>
	</tr>

	<tr>
		<td colspan="8">
			ㅤ1) The shipowner shall promptly repatriate the seafarer who leaves a ship at the place of which is not the seafarer's country of residence
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤor the place at which the seafarer agreed to enter into the engagement as the shipowner's expenses. However, in case where the
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤshipowner pay the expense of repatriation according to the request of the seafarer, shipowner does not have any responsibility 
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤfor the repatriation.
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			ㅤ2) Despite above 1, in case of the following particulars, the shipowner can recover the cost of repatriation from the seafarer.
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤa. When the seafarer leaves a ship without just cause.
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤb. When the seafarer leaves a ship according to disciplinary punishment which regulated in national laws.
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			ㅤ3) The amount of money to be spent by the shipowner pursuant to paragraph (1) shall include transportation, accommodation, meals expenses
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤincurred in the repatriation.
		</td>
	</tr>

	{{-- 7 --}}
	<tr>
		<td colspan="8">7.	Standard of Hours of Work and Hours of Rest</td>
	</tr>

	<tr>
		<td colspan="8">
			ㅤ1)	Hours of work
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤa. Hours of Ordinary Work : 8 hours in a day and 40 hours in a week.
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤb. Over Time Work : Fixed Over Time(103 hours) and Owner’s Guaranteed Overtime.
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			ㅤ2)	Hours of rest
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤa. Minimum of 10 hours rest in any 24 hour period and 77 hours in any seven-day period.
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤb. Minimum of 10 hours rest in any 24-hour period may be divided into no more than two periods, one of which shall be at least six hours in length
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

	{{-- 8 --}}
	<tr>
		<td colspan="8">8.	Provision and compliance with Risk assessments)</td>
	</tr>

	<tr>
		<td colspan="8">
			ㅤ1)	The shipowner shall provide the risk assessment table through the ship’s network (EDMS) and make it available for viewing at any time.
			<br style='mso-data-placement:same-cell;' />
			ㅤ2)	Seafarers shall be aware of the relevant information and check and utilize it frequently.
		</td>
	</tr>

	{{-- 9 --}}
	<tr>
		<td colspan="8">9.	Any facts which are not defined in this agreement</td>
	</tr>

	<tr>
		<td colspan="8">
			ㅤAny facts which are not defined in this agreement, these are complied with the law of flag state or Applicable collective bargaining agreement.
			<br style='mso-data-placement:same-cell;' />
			@if($data->vessel->id == 39)
			ㅤ※  As per 2022 amendments to MLC 2006, Standard A 2.1.7 / A 2.2.7 / Guideline B 2.5.1.8, this agreement including the wage, and
			@else
			ㅤ※  As per 2018 amendments to MLC 2006, Standard A 2.1.7 / A 2.2.7 / Guideline B 2.5.1.8, this agreement including the wage, and
			@endif
			<br style='mso-data-placement:same-cell;' />
			ㅤentitlement to repatriation continues to have effect while a seafarer is held captive on or off the ship as a result of acts of piracy or armed
			<br style='mso-data-placement:same-cell;' />
			ㅤrobbery against ships.
			<br style='mso-data-placement:same-cell;' />
			ㅤ※	Additional clause for Marshall Islands flag
			<br style='mso-data-placement:same-cell;' />
			ㅤThe terms and conditions laid down herein shall be subject to the applicable provisions of the Maritime Law and Regulations of the Republic
			<br style='mso-data-placement:same-cell;' />
			ㅤof the Marshall Islands and any dispute as to the terms and conditions of this contract shall be resolved in accordance with the Maritime Law
			<br style='mso-data-placement:same-cell;' />
			ㅤand Regulations of the Republic of the Marshall Islands.
			<br style='mso-data-placement:same-cell;' />
			ㅤ※	Additional clause for The Republic of Liberia flag
			<br style='mso-data-placement:same-cell;' />
			ㅤ1) Seafarers, prior to or in the process of engagement, shall be informed about their rights under the seafarers’ recruitment and placement
			<br style='mso-data-placement:same-cell;' />
			ㅤservices’ system of protection, to compensate seafarers for monetary loss that they may incur as a result of the failure of the recruitment
			<br style='mso-data-placement:same-cell;' />
			ㅤand placement service or the relevant shipowner under the seafarers’ employment agreement to meet its obligations to them.
			<br style='mso-data-placement:same-cell;' />
			ㅤ2)	After consultation with the shipowners’ and seafarers’ organizations, the Administration has determined that seafarers’ wages may be
			<br style='mso-data-placement:same-cell;' />
			ㅤpaid to an account other than the seafarers’ designated bank account, if this is requested in writing by the seafarer.
		</td>
	</tr>

	<tr>
		<td colspan="8">
			In witness whereof, 2 copies of this agreement have been made and mutually signed by either parties thence each one of them
			<br style='mso-data-placement:same-cell;' />
			{{-- HYUNDAI COURAGE --}}
			@if(in_array($data->vessel->id, [33,36,37,38]))
				are retained by the each party and the seafarer was given sufficient time to review and opportunity to seek advice on the
				<br style='mso-data-placement:same-cell;' />
				terms and condition and voluntarily accept them.
			@else
				are retained by the each party and the seafarer has opportunity to review on the terms and condition and voluntarily accept them.
			@endif
		</td>
	</tr>

	<tr>
		<td colspan="2">{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}</td>
		<td>(signature)</td>
		<td colspan="4">Mr. Adulf Kit Jumawan - Crewing Manager</td>
		<td>(signature)</td>
	</tr>

	<tr>
		<td colspan="2">(Seafarer)</td>
		<td></td>
		<td colspan="4">(Shipowner or for and on behalf of the shipowner)</td>
		<td></td>
	</tr>

	<tr>
		<td rowspan="2" colspan="3">
			ㅤPlace where and date when a seafarer’s employment
			<br style='mso-data-placement:same-cell;' />
			ㅤagreement is entered into.
		</td>
		<td colspan="2">ㅤPlace</td>
		<td colspan="3">ㅤManila, Philippines</td>
	</tr>

	<tr>
		<td colspan="2">ㅤDate</td>
		<td colspan="3">ㅤ{{ now()->parse($data->effective_date)->subDays(5)->format('d-M-Y') }}</td>
	</tr>
</table>