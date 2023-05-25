@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";

	$blue = "color: #55b6dd;";
@endphp

<table>
	<tr>
		<td colspan="8" style="height: 55px;"></td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $bc }} height: 33px; font-size: 14px;">JOINING CREW FINAL BRIEFING</td>
	</tr>

	<tr>
		<td colspan="2">Rank / Name:</td>
		<td colspan="4">
			{{ $data->rank }} / {{ $data->user->fullname2 }}
		</td>
		<td>Vessel / Flag:</td>
		<td>
			{{ $data->vessel->name }} / {{ $data->vessel->flag }}
		</td>
	</tr>

	<tr>
		<td colspan="2">Joining Port:</td>
		<td colspan="4">
			{{ $data->port }}
		</td>
		<td>Joining Date:</td>
		<td>
			{{ $data->eld ? now()->parse($data->eld)->format('d-M-Y') : "" }}
		</td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $b }} height: 30px;">Operations Department:</td>
	</tr>

	<tr>
		<td>* POEA Contract / Terms and Conditions Governing Overseas Contract Workers / Passing GOA</td>
	</tr>

	<tr>
		<td colspan="3">* POEA Memorandum Circulars</td>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td colspan="8">* GOA / Addendum / CBA if any</td>
	</tr>

	<tr>
		<td colspan="8">* Ships Property</td>
	</tr>

	<tr>
		<td colspan="8">* Grievance Machinery - address all concerns professionally. Inform Solpia Marine</td>
	</tr>

	<tr>
		<td colspan="8">* Promotion / Demotion / Rotation SCheme - ALL BASED ON GOOD PERFORMANCE.</td>
	</tr>

	<tr>
		<td colspan="8">* Crew mails / Packages / Hand Carry Cash</td>
	</tr>

	<tr>
		<td colspan="8">* Ships Official Communication</td>
	</tr>

	<tr>
		<td colspan="8">* Medical check abroad / Ailment - STAY HEALTH / LIVE HEALTHY. Bring enough maintenance medicine if any</td>
	</tr>

	<tr>
		<td colspan="8">* Injury - Accident / Alcohol - Drinking OB / FIght on board - THINK ABOUT YOUR FAMILY</td>
	</tr>

	<tr>
		<td colspan="8">* Repatriation / Report to Office - WITHIN 72 HOURS UPON ARRIVAL. Medical case</td>
	</tr>

	<tr>
		<td colspan="8">* Proceed to assigned nominated hospital / physician by the company</td>
	</tr>

	<tr>
		<td colspan="8">* Desertion / Left behind - Seafarer will pay all relative expenses.</td>
	</tr>

	<tr>
		<td colspan="8">* Flight details / Entry visa if any / Port Regulations &#38; Restrictions / Shore pass stamping</td>
	</tr>

	<tr>
		<td colspan="8">* Allowable Luggages (On / Off)</td>
	</tr>

	<tr>
		<td colspan="8">* Bring all valid visa in old passport / ALL seafaring documents</td>
	</tr>

	<tr>
		<td colspan="8">* Occasional assistance between different departments - IMPORTANCE OF CLEAN HOLDS</td>
	</tr>

	<tr>
		<td colspan="8">* IN TIME - NO DELAY TO VESSEL</td>
	</tr>

	<tr>
		<td colspan="8">* Crew harmony / Relationship on BOard / Cultural Differences.</td>
	</tr>

	<tr>
		<td colspan="8">* Walang Lagay - No gifts / No Rwards Policy to be employed / hired</td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $blue }}">* Personal appearance must be presentable in all aspect wiht reagards in hair stlye &#38; manner of dress in every port</td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $blue }}">* Prohibit any electronic device such as cellphone / tablet while on navigational and port watch</td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $blue }}">* Any form of gambling is prohibited while on board</td>
	</tr>

	<tr>
		<td colspan="8">* ADDITIONAL EXPENSES INCURRED DURING JOINING AND DISEMBARKING FROM VESSEL</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">1) Beverage / Snack / Alcoholic drinks / Any personal eating and / or unreasonable expenses</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">2) Any transportation chargers for personal tours.</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">3) Exceed 3 times of meal (Breakfast, Lunch, Dinner)</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">4) Penalties for willful damanges or actions</td>
	</tr>

	<tr>
		<td colspan="8">* DO NOT BRING ANY STUNNING DEVICES WITH YOU WHETHER IN TRANSIT IN ANY AIRPORT</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $b }} height: 30px;">Accounting / Admin Matters</td>
		<td colspan="2">Discussed by / Date</td>
		<td style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="7">* Wages / OT</td>
		<td>Port Captain</td>
	</tr>

	<tr>
		<td colspan="7">* Home Allotment / Leave Pay</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="7">* EXCHANGE RATE / BANK PREVAILING RATE</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="5">* Masters payment Order (MPO)</td>
		<td colspan="2">Discussed by / Date</td>
		<td style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="7">* CA / Loans - Bank / Pag-ibig / SSS</td>
		<td>Port Engineer</td>
	</tr>

	<tr>
		<td colspan="8">* HMO / Foreign FLag Charges</td>
	</tr>

	<tr>
		<td colspan="8">* CBA Retirement / Membership Fee</td>
	</tr>

	<tr>
		<td colspan="5"></td>
		<td colspan="2">Discussed by / Date</td>
		<td style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="7"></td>
		<td>Crewing Manager / Operations Manager</td>
	</tr>

	<tr>
		<td colspan="5">{{ $data->user->namefull }}</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="5">Seafarer's Name &#38; Signature</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="5"></td>
		<td colspan="2">Discussed by / Date</td>
		<td style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="7"></td>
		<td>Accounting Manager</td>
	</tr>
</table>