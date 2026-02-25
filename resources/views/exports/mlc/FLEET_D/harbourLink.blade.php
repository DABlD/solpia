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
		<td colspan="9">SEAFARER EMPLOYMENT CONTRACT (SEC)</td>
	</tr>

	<tr><td colspan="9"></td></tr>

	<tr>
		<td colspan="9">This Contract is between:</td>
	</tr>

	<tr><td colspan="9"></td></tr>

	<tr>
		<td colspan="2">Seafarer's Name</td>
		<td>:</td>
		<td colspan="6">
			{{ $data->user->namefull }}
		</td>
	</tr>

	<tr>
		<td colspan="2">Date / Place Of Birth</td>
		<td>:</td>
		<td colspan="6">
			{{ isset($data->user->birthday) ? $data->user->birthday->format('d F Y') : "-" }} / {{ $data->birth_place }}
		</td>
	</tr>

	<tr>
		<td colspan="2">Passport Number</td>
		<td>:</td>
		<td colspan="6">
			{{ $pp->number }}
		</td>
	</tr>

	<tr>
		<td colspan="2">AND</td>
		<td></td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="2">Name Of Ship Owners</td>
		<td>:</td>
		<td colspan="6">HARBOUR-LINK LINES SDN. BHD.</td>
	</tr>

	<tr>
		<td colspan="2">Ship Manager</td>
		<td>:</td>
		<td colspan="6">HARBOUR-LINK MARINE SERVICES SDB. BHD.S</td>
	</tr>

	<tr>
		<td colspan="2">Address</td>
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
		<td colspan="2">Agent</td>
		<td>:</td>
		<td colspan="6">SOLPIA MARINE AND SHIP MANAGEMENT, INC.</td>
	</tr>

	<tr>
		<td colspan="2">Address</td>
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
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="9">
			Capacity in which seafarer is to be employed
		</td>
	</tr>

	<tr>
		<td colspan="4">The capacity in which you are initially employed is</td>
		<td colspan="2">{{ $data->pro_app->rank->abbr }}</td>
		<td colspan="3">(rank)</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="9">Place of Work</td>
	</tr>

	<tr>
		<td>You will be employed on</td>
		<td colspan="4">{{ $data->vessel->name }}</td>
		<td colspan="4">(ship's name)</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="9">Wages</td>
	</tr>

	<tr>
		<td>Your total wages will be</td>
		<td>${{ $data->pro_app->wage ? $data->pro_app->wage->basic : "0" }}</td>
		<td colspan="7">per month inclusive leave paid &#38; overtime with/or formula for</td>
	</tr>

	<tr>
		<td colspan="9">determining wages, as follows:-</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="3">Basic Wage</td>
		<td>:</td>
		<td colspan="5">${{ $data->pro_app->wage ? $data->pro_app->wage->basic : "0" }}</td>
	</tr>

	<tr>
		<td colspan="3">Leave Pay</td>
		<td>:</td>
		<td colspan="5">${{ $data->pro_app->wage ? $data->pro_app->wage->leave_pay : "0" }}</td>
	</tr>

	<tr>
		<td colspan="3">Fixed Overtime</td>
		<td>:</td>
		<td colspan="5">${{ $data->pro_app->wage ? ($data->pro_app->wage->fot ?? $data->pro_app->wage->ot) : "0" }}</td>
	</tr>

	<tr>
		<td colspan="3">Owner Allowance/Incentive</td>
		<td>:</td>
		<td colspan="5">${{ $data->pro_app->wage ? ($data->pro_app->wage->owner_allow ?? "0") : "0" }}</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2">Total</td>
		<td>:</td>
		<td colspan="5">${{ $data->pro_app->wage ? $data->pro_app->wage->basic : "0" }}</td>
	</tr>

	{{-- PAGE 2 --}}

	<tr>
		<td colspan="9">SEAFARER EMPLOYMENT CONTRACT (SEC)</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="9">Means of payment of wages</td>
	</tr>

	<tr>
		<td colspan="9">
			{{-- RICH TEXT 1 --}}
		</td>
	</tr>

	<tr>
		<td colspan="9">
			[overtime hours i.e. hours worked outside of normal working hours will be paid at a rate of …… … (insert overtime rate] (delete this sentence if not applicable)
		</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="9">Paid Annual Leave</td>
	</tr>

	<tr>
		<td colspan="9">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="9">
			If your employment commenced or terminates part way through the holiday year, your entitlement to paid annual leave will be assessed on a pro rate basis. Deductions from final salary due to you on termination of employment will be made in respect of any paid annual leave taken in excess of your entitlement.
		</td>
	</tr>

	<tr>
		<td colspan="9">
			There is no provision for the carry over of paid annual leave from one year to the next. All paid annual leave must be taken in the year in which it accrues. There is also no provision for payment to be made in lieu of untaken leave expect where paid annual leave has accrued but has not been taken at the date of termination of employment.
		</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="3">Notice of Termination of Employment</td>
		<td colspan="6">(Delete whichever is not applicable) (See Note 6)</td>
	</tr>

	<tr>
		<td colspan="9">Definite Period Agreement</td>
	</tr>

	<tr>
		<td colspan="9">
			{{-- RICH TEXT --}}
		</td>
	</tr>

	<tr>
		<td colspan="9">OR</td>
	</tr>

	<tr>
		<td colspan="9">Indefinite Agreement</td>
	</tr>

	<tr>
		<td colspan="9">The length of notice which you are obliged to give to terminate your employment is [Insert notice period which is to be not less than seven days].</td>
	</tr>

	<tr>
		<td colspan="9">
			The length of notice which you are entitled to receive from the shipowner to terminate your employment is [insert notice period which is to be not less than seven day but shall not be lesser than the period given for the seafarer]
		</td>
	</tr>

	<tr>
		<td colspan="9">OR</td>
	</tr>

	<tr>
		<td colspan="9">Voyage Agreement</td>
	</tr>

	<tr>
		<td colspan="9">
			Your employment is for the length of the voyage of [ship] commencing on____________________[insert date] from the port of____________________[insert name of port] until____________________[insert date] or the vessel’ arrival in the port of	[insert name of port] at which point it will terminate, unless it is terminated for justified reasons in advance of this point.
		</td>
	</tr>
</table>