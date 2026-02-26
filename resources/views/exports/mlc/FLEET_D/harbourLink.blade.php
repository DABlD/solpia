@php
	// dd($data);
	$pp = null;
	$sb = null;

	foreach($data->document_id as $doc){
		if($doc->type == "PASSPORT"){
			$pp = $doc;
		}
		elseif($doc->type == "SEAMAN'S BOOK"){
			$sb = $doc;
		}
	}
@endphp

<table>
	<tr>
		<td colspan="10">SEAFARER EMPLOYMENT CONTRACT (SEC)</td>
	</tr>

	<tr><td colspan="10"></td></tr>

	<tr>
		<td colspan="10">This Contract is between:</td>
	</tr>

	<tr><td colspan="10"></td></tr>

	<tr>
		<td colspan="3">Seafarer's Name</td>
		<td>:</td>
		<td colspan="6">
			{{ $data->user->namefull }}
		</td>
	</tr>

	<tr>
		<td colspan="3">Date / Place Of Birth</td>
		<td>:</td>
		<td colspan="6">
			{{ isset($data->user->birthday) ? strtoupper($data->user->birthday->format('d F Y')) : "-" }} / {{ $data->birth_place }}
		</td>
	</tr>

	<tr>
		<td colspan="3">Passport Number</td>
		<td>:</td>
		<td colspan="6">
			{{ $pp->number }}
		</td>
	</tr>

	<tr>
		<td colspan="3">AND</td>
		<td></td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="3">Name Of Ship Owners</td>
		<td>:</td>
		<td colspan="6">HARBOUR-LINK LINES SDN. BHD.</td>
	</tr>

	<tr>
		<td colspan="3">Ship Manager</td>
		<td>:</td>
		<td colspan="6">HARBOUR-LINK MARINE SERVICES SDB. BHD.</td>
	</tr>

	<tr>
		<td colspan="3">Address</td>
		<td>:</td>
		<td colspan="6">
			Wisma Harbour, Parkcity Commerce Square,
			<br style='mso-data-placement:same-cell;' />
			Jalan Tun Ahmad Zaidi, 97000 Bintulu,
			<br style='mso-data-placement:same-cell;' />
			Sarawak, Malaysia.
		</td>
	</tr>

	<tr>
		<td colspan="3">Agent</td>
		<td>:</td>
		<td colspan="6">SOLPIA MARINE AND SHIP MANAGEMENT, INC.</td>
	</tr>

	<tr>
		<td colspan="3">Address</td>
		<td>:</td>
		<td colspan="6">
			2019 San Marcelino St.
			<br style='mso-data-placement:same-cell;' />
			Malate Manila 1004
			<br style='mso-data-placement:same-cell;' />
			Philippines
		</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="10">
			Capacity in which seafarer is to be employed
		</td>
	</tr>

	<tr>
		<td colspan="5">The capacity in which you are initially employed is</td>
		<td colspan="2">{{ $data->pro_app->rank->name }}</td>
		<td colspan="3">(rank)</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="10">Place of Work</td>
	</tr>

	<tr>
		<td colspan="2">You will be employed on</td>
		<td colspan="4">{{ $data->vessel->name }}</td>
		<td colspan="4">(ship's name)</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="10">Wages</td>
	</tr>

	<tr>
		<td colspan="2">Your total wages will be</td>
		<td>${{ $data->pro_app->wage ? number_format($data->pro_app->wage->basic) : "0" }}</td>
		<td colspan="7">per month inclusive leave paid &#38; overtime with/or formula for</td>
	</tr>

	<tr>
		<td colspan="10">determining wages, as follows:-</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="4">Basic Wage</td>
		<td>:</td>
		<td colspan="5">${{ $data->pro_app->wage ? number_format($data->pro_app->wage->basic) : "0" }}</td>
	</tr>

	<tr>
		<td colspan="4">Leave Pay</td>
		<td>:</td>
		<td colspan="5">${{ $data->pro_app->wage ? number_format($data->pro_app->wage->leave_pay) : "0" }}</td>
	</tr>

	<tr>
		<td colspan="4">Fixed Overtime</td>
		<td>:</td>
		<td colspan="5">${{ $data->pro_app->wage ? (number_format($data->pro_app->wage->fot) ?? number_format($data->pro_app->wage->ot)) : "0" }}</td>
	</tr>

	<tr>
		<td colspan="4">Owner Allowance/Incentive</td>
		<td>:</td>
		<td colspan="5">${{ $data->pro_app->wage ? (number_format($data->pro_app->wage->owner_allow) ?? "0") : "0" }}</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="2">Total</td>
		<td>:</td>
		<td colspan="5">${{ $data->pro_app->wage ? number_format($data->pro_app->wage->basic) : "0" }}</td>
	</tr>

	{{-- PAGE 2 --}}

	<tr>
		<td colspan="10">SEAFARER EMPLOYMENT CONTRACT (SEC)</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="10">Means of payment of wages</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT 1 --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			[overtime hours i.e. hours worked outside of normal working hours will be paid at a rate of …… … (insert overtime rate] (delete this sentence if not applicable)
		</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="10">Paid Annual Leave</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			If your employment commenced or terminates part way through the holiday year, your entitlement to paid annual leave will be assessed on a pro rate basis. Deductions from final salary due to you on termination of employment will be made in respect of any paid annual leave taken in excess of your entitlement.
		</td>
	</tr>

	<tr>
		<td colspan="10">
			There is no provision for the carry over of paid annual leave from one year to the next. All paid annual leave must be taken in the year in which it accrues. There is also no provision for payment to be made in lieu of untaken leave expect where paid annual leave has accrued but has not been taken at the date of termination of employment.
		</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="4">Notice of Termination of Employment</td>
		<td colspan="6">(Delete whichever is not applicable) (See Note 6)</td>
	</tr>

	<tr>
		<td colspan="10">Definite Period Agreement</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">OR</td>
	</tr>

	<tr>
		<td colspan="10">Indefinite Agreement</td>
	</tr>

	<tr>
		<td colspan="10">The length of notice which you are obliged to give to terminate your employment is [Insert notice period which is to be not less than seven days].</td>
	</tr>

	<tr>
		<td colspan="10">
			The length of notice which you are entitled to receive from the shipowner to terminate your employment is [insert notice period which is to be not less than seven day but shall not be lesser than the period given for the seafarer]
		</td>
	</tr>

	<tr>
		<td colspan="10">OR</td>
	</tr>

	<tr>
		<td colspan="10">Voyage Agreement</td>
	</tr>

	<tr>
		<td colspan="10">
			Your employment is for the length of the voyage of [ship] commencing on____________________[insert date] from the port of____________________[insert name of port] until____________________[insert date] or the vessel’ arrival in the port of	[insert name of port] at which point it will terminate, unless it is terminated for justified reasons in advance of this point.
		</td>
	</tr>

	{{-- PAGE 3 --}}
	<tr>
		<td colspan="10">SEAFARER EMPLOYMENT CONTRACT (SEC)</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			If you require medical care while you are on-boards this will be provided free of charge, including access to necessary medicines, medical equipment and facilities for diagnosis and treatment and medical information and expertise. Where practicable and appropriate, you will be given leave to visit a qualified medical doctor or dentists in ports of call for the purpose of obtaining treatment.
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			In the event of your death occurring on board or ashore during a voyage, the shipowner will meet the cost of burial expenses, or cremation where appropriate or required by local legislation, and the return of your property left on board to your next of kin.
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			You will be entitled to repatriation, at the expense of the shipowner, if you are away from your country of residence when this agreement is terminated:-
		</td>
	</tr>

	<tr>
		<td>●</td>
		<td colspan="9">
			By the ship-owner
		</td>
	</tr>

	<tr>
		<td>●</td>
		<td colspan="9">
			By you in the event of illness or injury or other medical condition requiring your repatriation, the event that the ship is proceeding to a Warlike Operation Area or the event of termination or interruption of employment in accordance with an industrial award or collective agreement.
		</td>
	</tr>

	<tr>
		<td>●</td>
		<td colspan="9">
			In circumstances where you are no longer able to carry out your duties under this agreement or cannot be expected to do so e.g. shipwreck, the sale of your ship or a change in ship’s registration.
		</td>
	</tr>

	<tr>
		<td colspan="10">
			
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="10">Minimum duration of service periods after which you are entitled to repatriation.</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	{{-- 4TH PAGE --}}
	<tr>
		<td colspan="10">SEAFARER EMPLOYMENT CONTRACT (SEC)</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">Hours of Work</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			Your hours of work will be arranged such as to ensure that you receive a minimum of 10 hours available for rest in each 24-hours period and a minimum of 77 hours rest in each seven-day period. This minimum period of rest may not be reduced below 10 hours expect in an emergency.
		</td>
	</tr>

	<tr>
		<td colspan="10">
			You may be required, at the absolute discretion of the Master, to work additional hours during an emergency affecting the safety of the ship, its passengers, crew or cargo or the marine environment or to give assistance to the other ships or persons in peril. You may also to be required to work additional hours for safety drills such as musters, fire fighting and lifeboat drills. In such circumstances you will be provided subsequently with (a) compensatory rest period(s).
		</td>
	</tr>

	<tr>
		<td colspan="10">
			Grievance and Disciplinary Procedures
		</td>
	</tr>

	<tr>
		<td colspan="10">
			(a)	Grievances
		</td>
	</tr>

	<tr>
		<td colspan="10">
			If you have a grievance regarding your employment, you should follow the shipowner’s grievance procedure a copy of which will be provided to you when you join the vessel.
		</td>
	</tr>

	<tr>
		<td colspan="10">
			(b)	Disciplinary Rules and Procedure
		</td>
	</tr>

	<tr>
		<td colspan="10">
			The disciplinary rules applicable to you are set in the shipowner’s Code of Conduct.
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			Compensation in respect of loss of personal property as a result of the loss or foundering the vessel
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	{{-- PAGE 5 --}}
	<tr>
		<td colspan="10">SEAFARER EMPLOYMENT CONTRACT (SEC)</td>
	</tr>

	<tr>
		<td colspan="10">Additional Provisions</td>
	</tr>

	<tr>
		<td>-</td>
		<td colspan="9">
			A seafarer bears the cost of his repatriation, and the cost of providing his replacement, should he terminate his employment prior to completing the specified period of employment even though he/she gave the period of notice to terminate his/her employment that was required by the agreement.
		</td>
	</tr>

	<tr>
		<td>-</td>
		<td colspan="9">
			A seafarer’s employment agreement shall continue to have effect while a seafarer is held captive on or off the ship as a result of acts of piracy or armed robbery against ships, regardless of whether the date fixed for its expiry has passed or either party has given notice to suspend or terminate it. For the purpose of this paragraph, the term:
		</td>
	</tr>

	<tr>
		<td>(a)</td>
		<td colspan="9">
			Piracy shall have the same meaning as in the United Nation Convention on the Law of the Sea, 1982;
		</td>
	</tr>

	<tr>
		<td>(b)</td>
		<td colspan="9">
			Armed robbery against ships means any illegal act of violence or detention or any act of depredation, or threat thereof, other than an act of piracy, committed for private ends and directed against a ship or against persons or property on board such ship, within a State’s internal waters, archipelagic waters and territorial sea, or any act of inciting or of intentionally facilitating an act described above
		</td>
	</tr>

	<tr>
		<td>-</td>
		<td colspan="9">
			Where a seafarer is held captive on or off the ship as a result of acts of piracy or armed robbery against ships, wages and other entitlements under the seafarer’s employment agreement, relevant collective bargaining agreement or applicable national laws, including the remittance of any allotments as provided in paragraph 4 of this Standard, shall continue to be paid during the entire period of captivity and until the seafarer is released and duly repatriated in accordance with Standard A2.5.1 or, where the seafarer dies while in captivity, until the date of death as determined in accordance with applicable national laws or regulations. The terms piracy and armed robbery against ships shall have in the same meaning as in Standard A2.1, paragraph 7.
		</td>
	</tr>

	<tr>
		<td>-</td>
		<td colspan="9">
			The entitlement to repatriation may lapse if the seafarers concerned do not claim it within a reasonable period of time to be define by national laws or regulations or collective agreements, except where they are held captive on or off the ship as a result of acts of piracy or armed robbery against ships. The terms piracy and armed robbery against ships shall have in the same meaning as in Standard A2.1, paragraph 7.
		</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="2"></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="4">{{ $data->pro_app->rank->abbr }} {{ $data->user->namefull }}</td>
		<td></td>
		<td colspan="4">MS. THEA MAE G. RIO (Crewing Manager)</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="4">(Signature of the seafarer)</td>
		<td></td>
		<td colspan="4">(signature)</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="4"></td>
		<td></td>
		<td colspan="4">(in behalf of Shipowner's representative)</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="4">Place where this Agreement is entered into</td>
		<td>:</td>
		{{-- <td colspan="4">{{ $data->pro_app->vessel->name }}</td> --}}
		<td colspan="4">
			@if($data->pro_app->status == "Lined-Up")
				MANILA, PHILIPPINES
			@else
				{{ $data->pro_app->vessel->name }}
			@endif
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="4">Date when this Agreement is entered into</td>
		<td>:</td>
		<td colspan="4">{{ now()->format('F j, Y') }}</td>
	</tr>

	{{-- PAGE 6 --}}
	<tr>
		<td colspan="10">SEAFARER EMPLOYMENT CONTRACT (SEC)</td>
	</tr>

	<tr>
		<td colspan="10">NOTES</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td>●</td>
		<td colspan="9">
			The place where the seafarer signed their employment agreement;
		</td>
	</tr>

	<tr>
		<td>●</td>
		<td colspan="9">
			Their country of residence;
		</td>
	</tr>

	<tr>
		<td>●</td>
		<td colspan="9">
			The place specified in any applicable collective agreement : or ,
		</td>
	</tr>

	<tr>
		<td>●</td>
		<td colspan="9">
			Subject to the agreement of shipowner, another place of the seafarer’s choosing.
		</td>
	</tr>

	<tr>
		<td colspan="10">
			Note 10 – Maximum duration of service period after which you are entitled to repatriation.
		</td>
	</tr>

	<tr>
		<td colspan="10">
			The maximum period of service following which a seafarer will be entitled to repatriation is to be not more than 52 weeks minus the period of statutory paid annual leave – see note 5
		</td>
	</tr>

	{{-- PAGE 7 --}}
	<tr>
		<td colspan="10">SEAFARER EMPLOYMENT CONTRACT (SEC)</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td>●</td>
		<td colspan="9">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td>●</td>
		<td colspan="9">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td>●</td>
		<td colspan="9">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td>●</td>
		<td colspan="9">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td>●</td>
		<td colspan="9">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="10">
			This list is illustrative only and should not be taken as listing all provisions that would be considered unacceptable.
		</td>
	</tr>

	<tr>
		<td colspan="10">
			{{-- RICH TEXT --}}
		</td>
	</tr>

</table>