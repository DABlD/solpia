@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	// dd($data);

	$wage = function($label, $wage){
		echo "
			<tr>
				<td colspan='5'> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎$label</td>
				<td colspan='2' style='text-align: center;'>$wage</td>
				<td></td>
				<td>USD / MONTH</td>
			</tr>
		";
	}
@endphp

<table>
	<tr>
		<td colspan="10" style="{{ $bold }} {{ $center }} height: 50px; font-size: 18px;">Contract of Employment for Seafarer</td>
	</tr>

	<tr>
		<td colspan="10" style="height: 40px;">The following parties to the contract agree to fully comply with the terms stated hereinafter:</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $bold }} {{ $center }}">Shipowner</td>
		<td style="{{ $bold }} {{ $center }}">Company</td>
		<td colspan="6" style="{{ $bold }} {{ $center }}">KMARIN OCEAN SERVICES CORPORATION</td>
		<td style="{{ $bold }} {{ $center }}">Tel.</td>
		<td style="{{ $bold }} {{ $center }}">82-51-714-3210</td>
	</tr>

	<tr>
		<td style="{{ $bold }} {{ $center }}">Address</td>
		<td colspan="8" style="{{ $bold }} {{ $center }}">
			5F (KUKDONG BLDG), 67, CHANGJANG-DAERO 5BEON-GIL, JUNG-GU, BUSAN, REPUBLIC OF KOREA
		</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $bold }} {{ $center }}">Agent</td>
		<td style="{{ $bold }} {{ $center }}">Company</td>
		<td colspan="6" style="{{ $bold }} {{ $center }}">SOLPIA MARINE AND SHIP MANAGEMENT, INC.</td>
		<td style="{{ $bold }} {{ $center }}">Tel.</td>
		<td style="{{ $bold }} {{ $center }}">63-2-567-1726</td>
	</tr>

	<tr>
		<td style="{{ $bold }} {{ $center }}">Address</td>
		<td colspan="8" style="{{ $bold }} {{ $center }}">
			Solpia Bldg, #2019 San Marcelino  St. Malate, Manila, Philippines 1004
		</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $bold }} {{ $center }}">Vessel</td>
		<td style="{{ $bold }} {{ $center }}">Name</td>
		<td colspan="6" style="{{ $bold }} {{ $center }}">{{ $data->vessel->name }}</td>
		<td style="{{ $bold }} {{ $center }}">Kind</td>
		<td style="{{ $bold }} {{ $center }}">{{ $data->vessel->type }}</td>
	</tr>

	<tr>
		<td style="{{ $bold }} {{ $center }}">Built Year</td>
		<td colspan="6" style="{{ $bold }} {{ $center }}">{{ $data->vessel->year_build }} Year</td>
		<td style="{{ $bold }} {{ $center }}">GRT</td>
		<td style="{{ $bold }} {{ $center }}">{{ $data->vessel->gross_tonnage }}</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $bold }} {{ $center }}">Seafarer</td>
		<td style="{{ $bold }} {{ $center }}">Name</td>
		<td colspan="6" style="{{ $bold }} {{ $center }}">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td style="{{ $bold }} {{ $center }}">Birthdate</td>
		<td style="{{ $bold }} {{ $center }}">{{ $data->user->birthday->format('d-M-Y') }}</td>
	</tr>

	<tr>
		<td style="{{ $bold }} {{ $center }}">Sex</td>
		<td colspan="3" style="{{ $bold }} {{ $center }}">남자(MALE)</td>
		<td style="{{ $bold }} {{ $center }}">Nationality</td>
		<td colspan="2" style="{{ $bold }} {{ $center }}">FILIPINO</td>
		<td style="{{ $bold }} {{ $center }}">Birthplace</td>
		<td style="{{ $bold }} {{ $center }}">{{ $data->birth_place }}</td>
	</tr>

	<tr>
		<td colspan="10" style="height: 50px;">
			1. Place &#38; Date
		</td>
	</tr>

	<tr>
		<td colspan="9">
			1.1 The place where seafarer's employment agreement is entered into :
		</td>
		<td style="{{ $center }}">{{ $data->vessel->name }}</td>
	</tr>

	<tr>
		<td colspan="9">
			1.2 The places where Seafarers shall be entitled to be repatriated to : 
		</td>
		<td style="{{ $center }}">MANILA, PHILIPPINES</td>
	</tr>

	<tr><td colspan="10"></td></tr>

	<tr>
		<td colspan="9">
			2. The capacity in which the seafarer is to be employed :
		</td>
		<td style="{{ $center }}">{{ $data->position }}</td>
	</tr>

	<tr><td colspan="10"></td></tr>

	<tr>
		<td colspan="10">Wage</td>
	</tr>

	<tr>
		<td colspan="10">3.1 Basic pay and allowance</td>
	</tr>

	@php
		$ot = $data->wage->fot ?? $data->wage->ot ?? 0;
		$otl = $data->wage->fot ? "Fixed Overtime Allowance" : "Guaranteed Overtime Allowance";
		$monthly = $data->wage->basic + $ot + $data->wage->sup_allow + $data->wage->sub_allow;
	@endphp
	{{ $wage("A.) Basic Wage :", $data->wage->basic ?? 0) }}
	{{ $wage("B.) $otl :", $ot) }}
	{{ $wage("C.) SVP (Supervisor Allowance) :", $data->wage->sup_allow ?? 0) }}
	{{ $wage("D.) SUB.A (Subsistence Allowance) :", $data->wage->sub_allow ?? 0) }}
	{{ $wage("E.) M.W. : Monthly Wage(E= A + B + C + D)", $monthly) }}
	<tr><td colspan="10"></td></tr>
	{{ $wage("F.) O.W (Owner's Allowance) :", $data->wage->owner_allow ?? 0) }}
	{{ $wage("G.) R.A. (Retirement Allowance) :", $data->wage->retire_allow ?? 0) }}
	<tr><td colspan="10"></td></tr>
	{{ $wage("H.) M.T : Monthly Total (H = E + F + G):", $data->wage->owner_allow + $data->wage->retire_allow + $monthly) }}

	<tr><td colspan="10"></td></tr>
	<tr>
		<td colspan="10">3.2  The details of Other Allowances are applied according to the Collective Bargaining Agreement (IBF FKSU-AMOSUP-KSA CBA) or Rules of Employment.</td>
	</tr>

	<tr>
		<td colspan="10" style="height: 50px;">3.3 Payment date:</td>
	</tr>

	<tr>
		<td> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎( 15 )th of every month. If the payment date falls on a holiday, payment will be made on the day before the holiday.</td>
	</tr>

	<tr>
		<td colspan="9"></td>
		<td style="{{ $center }} height: 60px;">page 1/3</td>
	</tr>

	{{-- PAGE 2 PAGE 2 PAGE 2 PAGE 2 --}}
	{{-- PAGE 2 PAGE 2 PAGE 2 PAGE 2 --}}
	{{-- PAGE 2 PAGE 2 PAGE 2 PAGE 2 --}}
	{{-- PAGE 2 PAGE 2 PAGE 2 PAGE 2 --}}

	<tr>
		<td colspan="10" style="{{ $bold }} {{ $center }} height: 50px; font-size: 18px;">Contract of Employment for Seafarer</td>
	</tr>

	<tr>
		<td colspan="10">
			3.4 Payment methods:
		</td>
	</tr>

	<tr>
		<td colspan="10">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ Payment will be paid to seafarer or credited to the bank account of seafarer. Some allotments should be
		</td>
	</tr>

	<tr>
		<td colspan="10">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ remitted directly to persons nominated by the seafarers.
		</td>
	</tr>

	<tr><td colspan="10" style="height: 20px;"></td></tr>

	<tr><td colspan="10">4. Paid Leave</td></tr>
	<tr>
		<td colspan="10">
			4.1 The shipowner shall Provide "Paid Leave" to the seafarer who has completed ( 2) months of continuous service on board
		</td>
	</tr>

	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ (services on the vessel in repair or laid up shall be included).</td>
	</tr>

	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ However, the commencement of Leave Pay may be extended until the vessel's entry into port when the vessel is under way. </td>
	</tr>
	<tr><td colspan="10"></td></tr>
	<tr><td colspan="10">4.2  The number of days of paid leave pursuant to 4.1 and 4.2 shall be (6) days per 1 month of continuous service on board.</td></tr>
	<tr><td colspan="10"></td></tr>

	<tr>
		<td colspan="5">4.3 Paid Leave : Basic Wage/30 X (6) DAYS</td>
		<td colspan="3" style="{{ $center }}">{{ $data->wage->leave_pay ?? 0 }}</td>
		<td colspan="2">USD / MONTH</td>
	</tr>

	<tr>
		<td colspan="10">5. Daily victulling expenses</td>
	</tr>

	<tr>
		<td style="{{ $bold }}"></td>
		<td style="{{ $bold }}"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎1DAY :</td>
		<td style="{{ $bold }}">10.5 USD</td>
	</tr>

	<tr><td colspan="10" style="height: 20px;"></td></tr>

	<tr><td colspan="10">6. Period of employment</td></tr>
	<tr>
		<td>6.1 Period : From</td>
		<td colspan="2" style="{{ $center }}">{{ now()->parse($data->effective_date)->format('d-M-y') }}</td>
		<td>To</td>
		<td colspan="3" style="{{ $center }}">{{ now()->parse($data->effective_date)->add($data->employment_months, 'months')->sub(1, 'day')->format('d-M-y') }}</td>
		<td colspan="3"></td>
	</tr>

	<tr><td colspan="10" style="height: 20px;"></td></tr>
	<tr>
		<td colspan="10">6.2  But, in cases where the seafarer disembarks midway of contract, and in cases where the seafarer boards over</td>
	</tr>

	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎   the contract period, the end point for its expiry is in accordance with National Law / CBA / Rule of Employment.‎‏‏‎</td>
	</tr>

	<tr><td colspan="10" style="height: 20px;"></td></tr>
	<tr>
		<td colspan="10">6.3  In case where the shipowner terminates the contract, the required notice period shall be over 30 days in written,</td>
	</tr>

	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎   and notify the seafarer with a written document.</td>
	</tr>

	<tr><td colspan="10" style="height: 20px;"></td></tr>
	<tr>
		<td colspan="10">6.4  In case where the seafarer want to terminate the contract, he/she shall notify it between 15 days and 30 days to the shipowner.</td>
	</tr>

	<tr><td colspan="10" style="height: 20px;"></td></tr>
	<tr><td colspan="10">7.  Health and social security protection benefits</td></tr>
	<tr><td colspan="10">7.1  Shipowner provides medical care, sickness benefit, unemployment benefit, old-age benefit, employment injury benefit, invalidity</td></tr>

	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     benefit, family benefit and survivors' benefit to the seafarer  in accordance with National Law / CBA / Rules of Employment.</td>
	</tr>

	<tr><td colspan="10" style="height: 20px;"></td></tr>
	<tr><td colspan="10">8.  Seafarer's entitlement to repatriation</td></tr>
	<tr><td colspan="10">8.1  Where a seafarer leaves a ship at the port which is not a place of his/her residence or a place where he/she concluded</td></tr>

	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     the contract of employment, a shipowner shall repatriate him/her to a place where he/she wishes to be repatriated either</td>
	</tr>

	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     a place of his/her residence or a place where he/she concluded the contract of employment without delay at the cost of</td>
	</tr>

	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     the shipowner and on his/her own responsibility: Provided, That this shall not apply to cases where the shipowner</td>
	</tr>

	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     reimburses expenses incurred in the repatriation at the request of the seafarer.</td>
	</tr>

	<tr>
		<td colspan="9"></td>
		<td style="{{ $center }} height: 20px;">page 2/3</td>
	</tr>

	{{-- PAGE 3 PAGE 3 PAGE 3 PAGE 3 --}}
	{{-- PAGE 3 PAGE 3 PAGE 3 PAGE 3 --}}
	{{-- PAGE 3 PAGE 3 PAGE 3 PAGE 3 --}}
	{{-- PAGE 3 PAGE 3 PAGE 3 PAGE 3 --}}

	<tr>
		<td colspan="10" style="{{ $bold }} {{ $center }} height: 50px; font-size: 18px;">Contract of Employment for Seafarer</td>
	</tr>


	<tr><td colspan="10">8.2  Despite above 8.1, in case of the following particulars, shipowner can recover the cost of repatriation from seafarer.</td></tr>

	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     1.) When the seafarer leaves a ship without just reason</td>
	</tr>

	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     2) When the seafarer leaves a ship according to disciplinary punishment which regulated in National Laws</td>
	</tr>

	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     3) When the reason is conformed to the Collective Bargaining Agreement or Rules of Employment or National Laws</td>
	</tr>

	<tr><td colspan="10" style="height: 20px;"></td></tr>
	<tr><td colspan="10">8.3 The maximum duration of service periods on board which a seafarer is entitled to repatriation is ( 2 )months,</td></tr>
	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     and such periods to be less than 12months.</td>
	</tr>

	<tr><td colspan="10" style="height: 20px;"></td></tr>
	<tr><td colspan="10">9. Hour of Work and Hours of Rest</td></tr>
	<tr><td colspan="10">9.1 Hour of work for Seafarers shall be 8 hours a day and 40 hours a week commencing from Monday to Friday.</td></tr>
	<tr><td colspan="10">9.2 The minimum hours of rest shall no be less than:</td></tr>
	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     a. 10 hours in any 24-hour period, and</td>
	</tr>
	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     b. 77 hours in any 7-day period</td>
	</tr>

	<tr><td colspan="10" style="height: 20px;"></td></tr>
	<tr><td colspan="10">9.3 Hours of rest may be divided into no more than two periods, one of which shall be at least six(6) hours in length,</td></tr>
	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     and the interval between consecutive periods of rest shall not exceed fourteen(14) hours.</td>
	</tr>

	<tr><td colspan="10" style="height: 20px;"></td></tr>
	<tr><td colspan="10">10.  Any facts which are not defined in this contract, these are complied with National Laws or the Collective</td></tr>
	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     Bargaining Agreement or Rules of Employment</td>
	</tr>

	<tr><td colspan="10" style="height: 20px;"></td></tr>
	<tr><td colspan="10">11. (Flag’s Maritime Regulation)</td></tr>
	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     The parties to this contract hereby stipulate that the terms and conditions laid down herein shall be subject to the applicable</td>
	</tr>
	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     provisions of the Maritime Law and Regulations of the Republic of Panama. Any dispute as to the terms and conditions of this</td>
	</tr>
	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     contract shall be resolved in accordance with the Maritime Law and Regulations of the Republic of Panama</td>
	</tr>

	<tr><td colspan="10" style="height: 20px;"></td></tr>
	<tr><td colspan="10">12. Any other business : </td></tr>

	<tr><td colspan="10" style="height: 20px;"></td></tr>
	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     Seafarer has time and opportunity to review and seek advice on the terms and condition in the contract and</td>
	</tr>
	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     freely accept them.</td>
	</tr>

	<tr><td colspan="10" style="height: 20px;"></td></tr>
	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     In witness whereof, 2 copies of this Contract have been made and mutually signed by either parties thence</td>
	</tr>
	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     each one of them are retained by the each party.</td>
	</tr>

	<tr><td colspan="10" style="height: 20px;"></td></tr>
	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     This 'Contract of Employment for Seafarer' is the revised seafarers' employment agreements according to MLC 2006</td>
	</tr>
	<tr>
		<td colspan="3"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     freely accept them.</td>
		<td colspan="3" style="{{ $center }}">{{ now()->parse($data->date_processed)->format('d-M-y') }}</td>
	</tr>

	<tr>
		<td colspan="8" style="text-align: right;">Date:</td>
		<td colspan="2" style="{{ $center }}">{{ now()->parse($data->date_processed)->format('d-M-y') }}</td>
	</tr>

	<tr>
		<td colspan="10" style="height: 30px;"></td>
	</tr>

	<tr>
		<td colspan="8"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     Seafarer Name:</td>
		<td colspan="2" style="text-align: right;">sign</td>
	</tr>

	<tr>
		<td colspan="8"></td>
		<td colspan="2" style="{{ $center }}">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
	</tr>

	<tr>
		<td colspan="8" style="height: 50px;"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎     (Shipowner(s) or for and on behalf of the shipOwner(s) of the Vessel)</td>
		<td colspan="2" style="height: 50px; text-align: right;">sign</td>
	</tr>

	<tr>
		<td colspan="8"></td>
		<td colspan="2" style="{{ $center }}">KMARINE OCEAN SERVICES CORPORATION</td>
	</tr>

	<tr>
		<td colspan="10" style="text-align: right;">page 3/3</td>
	</tr>
</table>