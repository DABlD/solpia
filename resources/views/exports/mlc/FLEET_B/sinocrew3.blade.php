@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b$c";
@endphp

<table>
	<tr>
		<td colspan="6" style="text-align: right;">HSCC TCC</td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $bc }} height: 35px; font-size: 14px;">SEAFARER'S EMPLOYMENT CONTRACT</td>
	</tr>

	<tr>
		<td style="{{ $c }}">Date:</td>
		<td style="{{ $c }}">{{ now()->format('d/F/Y') }}</td>
		<td>and agreed to be effective from</td>
		<td></td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="6" style="height: 5px;"></td>
	</tr>

	<tr>
		<td colspan="6" style="height: 30px;">The Employment Contract is entered into between the Seafarer and the Shipowner / the Employer on behalf of the Shipowner</td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $b }} height: 24px;">THE SEAFARER</td>
	</tr>

	<tr>
		<td colspan="4" style="height: 12px;">Surname:</td>
		<td colspan="2" style="height: 12px;">Given Names:</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $b }}">{{ $data->user->lname }}</td>
		<td colspan="2" style="{{ $b }}">{{ $data->user->fname }} {{ $data->user->suffix }}</td>
	</tr>

	<tr>
		<td colspan="6" style="height: 12px;">Full home address:</td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $b }}">{{ $data->user->address ?? $data->provincial_address }}</td>
	</tr>

	@php
		$pp = null;
		$sb = null;
		$mc = null;

		foreach($data->document_med_cert as $docu){
			if($docu->type == "MEDICAL CERTIFICATE"){
				$mc = $docu;
			}
		}

		foreach($data->document_id as $docu){
			if($docu->type == "PASSPORT"){
				$pp = $docu;
			}
			elseif($docu->type == "SEAMAN'S BOOK"){
				$sb = $docu;
			}
		}
	@endphp

	<tr>
		<td colspan="4" style="height: 12px;">Position:</td>
		<td colspan="2" style="height: 12px;">Medical certificate issed on:</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $b }}">{{ $data->pro_app->rank->abbr }} </td>
		<td colspan="2" style="{{ $b }}">{{ $mc ? (isset($mc->issue_date) ? $mc->issue_date->format("d/F/Y") : "---") : "---"  }}</td>
	</tr>

	<tr>
		<td colspan="4" style="height: 12px;">Estimated time of taking up position:</td>
		<td colspan="2" style="height: 12px;">Port where position is taken up:</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $b }}">{{ $data->employment_months }}</td>
		<td colspan="2" style="{{ $b }}">{{ $data->port }}</td>
	</tr>

	<tr>
		<td colspan="4" style="height: 12px;">Nationality:</td>
		<td colspan="2" style="height: 12px;">Passport no:</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $b }}">FILIPINO</td>
		<td colspan="2" style="{{ $b }}">{{ $pp ? $pp->number : '---' }}</td>
	</tr>

	<tr>
		<td colspan="4" style="height: 12px;">Date and place of birth:</td>
		<td colspan="2" style="height: 12px;">Seaman's book no:</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $b }}">{{ isset($data->user->birthday) ? $data->user->birthday->format('d/M/Y') : "---" }}</td>
		<td colspan="2" style="{{ $b }}">{{ $sb ? $sb->number : '---' }}</td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $b }} height: 24px;">THE SHIPOWNER</td>
	</tr>

	<tr>
		<td colspan="6" style="height: 12px;">Name:</td>
	</tr>

	<tr>
		<td colspan="6">JIA FENG SHIPPING(FUZHOU)LIMITED</td>
	</tr>

	<tr>
		<td colspan="6" style="height: 12px;">Address:</td>
	</tr>

	<tr>
		<td colspan="6" style="height: 47px;">UNIT 03, 05, FLOOR 14, CANGSHAN WANDA (INTERSECTION OF THE NORTH SIDE OF ORIGINAL PUSHANG ROAD AND THE EAST SIDE OF JINZHOU SOUTH ROAD) A1#, 272 PUSAHGN ROAD, JINSHAN STREET, CANGSHAN DISTRICT, FUZHOU CITY, FUJIAN PROVINCE P.R.C.</td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $b }} height: 25px;">THE EMPLOYER [if different from the Shipowner]</td>
	</tr>

	<tr>
		<td colspan="6" style="height: 12px;">Name:</td>
	</tr>

	<tr>
		<td colspan="6">SINOCREW</td>
	</tr>

	<tr>
		<td colspan="6" style="height: 12px;">Address:</td>
	</tr>

	<tr>
		<td colspan="6" style="height: 30px;">8TH FLOOR, BLOCK C, EAST BUILDING, YONGHE BUILDING, 28 ANDINGMEN EAST STREET, DONGCHENG DISTRICT, BEIJING</td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $b }} height: 24px;">THE SHIP</td>
	</tr>

	<tr>
		<td colspan="5" style="height: 12px;">Name:</td>
		<td style="height: 12px;">IMO No:</td>
	</tr>

	<tr>
		<td colspan="5" style="height: 12px; {{ $b }}">{{ $data->vessel->name }}</td>
		<td style="height: 12px; {{ $b }}">{{ $data->vessel->imo }}</td>
	</tr>

	<tr>
		<td colspan="4" style="height: 12px;">Flag:</td>
		<td colspan="2" style="height: 12px;">Port of registry:</td>
	</tr>

	<tr>
		<td colspan="4" style="height: 12px; {{ $b }}">{{ $data->vessel->flag }}</td>
		<td colspan="2" style="height: 12px; {{ $b }}">{{ $data->vessel->flag }}</td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $b }} height: 24px;">TERMS OF THE CONTRACT</td>
	</tr>

	<tr>
		<td colspan="3" style="height: 12px;">Period of employment:</td>
		<td colspan="2" style="height: 12px;">Wages from and including:</td>
		<td colspan="1" style="height: 12px;">Basic hours of work per week:</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $b }} text-align: left;">{{ $data->employment_months }} +/-1 MONTHS</td>
		<td colspan="2" style="{{ $b }}">{{ $data->pro_app->eld ? $data->pro_app->eld->format('d/M/Y') : "---" }}</td>
		<td colspan="1" style="{{ $b }}">{{ $data->pro_app->vessel->work_hours ?? "-" }}</td>
	</tr>

	<tr>
		<td colspan="3" style="height: 12px;">Basic monthly wage:</td>
		<td style="height: 12px;">Monthly overtime:</td>
		<td style="height: 12px; text-align: right;">(103 hours guaranteed)</td>
		<td colspan="1" style="height: 12px;">Overtime rate for hours worked in excess of 95 hrs:</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $b }}">USD {{ $data->wage && $data->wage->basic ? $data->wage->basic : 0.00 }}</td>
		<td colspan="2" style="{{ $b }}">USD {{ $data->wage ? $data->wage->ot ?? "N/A" : 0.00 }}</td>
		<td colspan="1" style="{{ $b }}">USD {{ $data->wage ? $data->wage->ot_per_hour : 0.00 }}</td>
	</tr>

	<tr>
		<td colspan="3" style="height: 12px;">Leave: Number of days per month</td>
		<td colspan="2" style="height: 12px;">Monthly leave pay:</td>
		<td colspan="1" style="height: 12px;">Monthly subsistence allowance on leave:</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $b }}">{{ $data->wage && $data->wage->leave_per_month ? $data->wage->leave_per_month : 0 }} DAYS</td>
		<td colspan="2" style="{{ $b }}">USD {{ $data->wage && $data->wage->leave_pay ? $data->wage->leave_pay : 0.00 }}</td>
		<td colspan="1" style="{{ $b }}">USD {{ $data->wage && $data->wage->sub_allow ? $data->wage->sub_allow : 0.00 }}</td>
	</tr>

	@php
		$salary = 0;

		$salary += $data->wage->basic ?? 0.00;
		$salary += $data->wage->leave_pay ?? 0.00;
		$salary += $data->wage->fot ?? 0.00;
		$salary += $data->wage->ot ?? 0.00;
		$salary += $data->wage->sub_allow ?? 0.00;
		$salary += $data->wage->owner_allow ?? 0.00;
	@endphp

	<tr>
		<td colspan="3" style="height: 12px;">Monthly fixed overtime:</td>
		<td colspan="2" style="height: 12px;">Company bonus:</td>
		<td colspan="1" style="height: 12px;">Total wages:</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $b }}">USD {{ $data->wage ? $data->wage->fot ?? "N/A" : 0.00 }}</td>
		<td colspan="2" style="{{ $b }}">USD {{ $data->wage && $data->wage->owner_allow ? $data->wage->owner_allow : 0.00 }}</td>
		<td colspan="1" style="{{ $b }}">USD {{ $salary }}</td>
	</tr>

	<tr>
		<td colspan="6" style="height: 24px;">Social Contribution:</td>
	</tr>

	<tr>
		<td colspan="6">1. The ITF-IMEC CBA 2019-2020 shall be incorporated into and to form part of the contract, refer CBA</td>
	</tr>

	<tr>
		<td colspan="6" style="height: 30px;">2. The Ship's Articles shall be deemed for all purposes to include the terms of this Contract (including the applicable ITF-IMEC CBA) and it shall be the duty of the Company to ensure that the Ship's Articles reflect these terms. Theses terms shall take precedence over all other terms.</td>
	</tr>

	<tr>
		<td colspan="6" style="height: 30px;">3. The ITF may vary the terms and conditions of the applicable ITF-IMEC CBA from time to time. Terms and conditions as so varied shall form part of this Contract with effect from the date of the Variation in place of the Terms and Conditions current immediately preceding the Variation.</td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $b }}">CONFIRMATION OF THE CONTRACT</td>
	</tr>

	<tr>
		<td colspan="4">Signature of Shipowner / Employer on behalf of the Shipowner:</td>
		<td colspan="2">Signature of Seafarer:</td>
	</tr>

	<tr>
		<td colspan="4" style="height: 40px;"></td>
		<td style="height: 40px;">Place:</td>
		<td style="height: 40px;">Date:</td>
	</tr>
</table>