@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";
@endphp

<table>
	<tr>
		<td colspan="3" rowspan="3">
			POS
		</td>
		<td colspan="6" rowspan="3">
			Seafarer's Employment Agreement
			<br style='mso-data-placement:same-cell;' />
			(PHILIPPINE CREW)
		</td>
		<td colspan="2">Form No.</td>
		<td>SCRE-04B-01-02</td>
	</tr>

	<tr>
		<td colspan="2">Revision No.</td>
		<td>5</td>
	</tr>

	<tr>
		<td colspan="2">Revision Date</td>
		<td>2021-12-03</td>
	</tr>

	<tr>
		<td colspan="12">The following parties to the contract agree to fully comply with the terms stated hereinafter:</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="2" style="{{ $bc }}">Shipowner</td>
		<td style="{{ $bc }}">Company / Representative</td>
		<td colspan="8">POS SM CO.,LTD./ Myeong Su KIM</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">Address</td>
		<td colspan="8">102, Jungang-daero, Jung-gu, Busan, Korea</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="2" style="{{ $bc }}">Agent</td>
		<td style="{{ $bc }}">Company</td>
		<td colspan="8">SOLPIA MARINE &#38; SHIP MANAGEMENT, INC.</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">Address</td>
		<td colspan="8">2019 San Marcelino St, Malate, Manila, Philippines 1004</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="2" style="{{ $bc }}">Vessel</td>
		<td style="{{ $bc }}">Name</td>
		<td colspan="5" style="{{ $c }}">{{ $data->vessel->name }}</td>
		<td colspan="2" style="{{ $bc }}">Kind</td>
		<td style="{{ $c }}">{{ $data->vessel->type }}</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">Built Year</td>
		<td colspan="5" style="{{ $c }}">{{ $data->vessel->year_build }}</td>
		<td colspan="2" style="{{ $bc }}">Gross Ton.</td>
		<td style="{{ $c }}">{{ $data->vessel->gross_tonnage }}</td>
	</tr>

	@php
		$pp = null;
		$sb = null;

		foreach($data->document_id as $docu){
			if($docu->type == "PASSPORT"){
				$pp = $docu;
			}
			elseif($docu->type == "SEAMAN'S BOOK"){
				$sb = $docu;
			}
		}

		$start = now()->parse($data->pro_app->eld);
		$end = now()->parse($data->pro_app->eld)->add($data->employment_months, 'months');

		// SALARY
		$basic = $data->wage && $data->wage->basic ? $data->wage->basic : 0.00;
		$ot = $data->wage && $data->wage->fot ? $data->wage->fot : $data->wage->ot ?? 0.00;
		$leave = $data->wage && $data->wage->leave_pay ? $data->wage->leave_pay : 0.00;
		$other = $data->wage && $data->wage->other_allow ? $data->wage->other_allow : 0.00;

		$mw = number_format($basic + $ot, 2);
		$total = number_format($basic + $ot + $leave + $other, 2);
		$basic = number_format($basic, 2);
		$ot = number_format($ot, 2);
		$leave = number_format($leave, 2);
		$other = number_format($other, 2);
	@endphp

	<tr>
		<td colspan="3" rowspan="3" style="{{ $bc }}">Seafarer</td>
		<td style="{{ $bc }}">Name</td>
		<td colspan="5" style="{{ $c }}">{{ $data->user->fullname }}</td>
		<td colspan="2" style="{{ $bc }}">Duty</td>
		<td style="{{ $c }}">{{ $data->pro_app->rank->abbr }}</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">Passport No.</td>
		<td style="{{ $c }}">{{ $pp ? $pp->number : "---" }}</td>
		<td colspan="2" style="{{ $bc }}">Seaman's Book No.</td>
		<td colspan="3" style="{{ $c }}">{{ $sb ? $sb->number : "---" }}</td>
		<td style="{{ $bc }}">License No.</td>
		<td style="{{ $c }}"></td>
	</tr>

	<tr>
		<td style="{{ $bc }}">Sex</td>
		<td style="{{ $c }}">{{ $data->user->gender }}</td>
		<td style="{{ $bc }}">Birthdate</td>
		<td style="{{ $c }}">{{ $data->user->birthday ? $data->user->birthday->format("Y-m-d") : "---"}}</td>
		<td style="{{ $bc }}">Birthplace</td>
		<td colspan="2" style="{{ $c }}">{{ $data->birth_place }}</td>
		<td style="{{ $bc }}">Nationality</td>
		<td style="{{ $c }}">FILIPINO</td>
	</tr>

	<tr>
		<td colspan="12">1. The place where and date when seafarer's employment agreement agreement is entered into?</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2">1.1 Place:</td>
		<td colspan="9">{{ $data->vessel->name }}</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2">1.2 Date:</td>
		<td colspan="9">{{ $start->format('Y-m-d') }}</td>
	</tr>

	<tr>
		<td colspan="12">2. Monthly Wage</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="4">A) B.W.: Basic Wage</td>
		<td style="text-align: right;">{{ $basic }}</td>
	</tr>
</table>