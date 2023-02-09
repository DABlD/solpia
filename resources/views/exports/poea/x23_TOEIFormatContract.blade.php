@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$i = "font-style: italic;";
	$bc = "$b$c";
@endphp

<table>
	<tr>
		<td colspan="12" style="{{ $c }}">Republic of the Philippines</td>
	</tr>

	<tr>
		<td colspan="12" style="{{ $c }}">Department of Labor and Employment</td>
	</tr>

	<tr>
		<td colspan="12" style="{{ $bc }}">PHILIPPINE OVERSEAS EMPLOYMENT ADMINISTRATION</td>
	</tr>

	<tr><td colspan="12"></td></tr>

	<tr>
		<td colspan="12" style="{{ $bc }}">SEAFARER'S EMPLOYMENT AGREEMENT</td>
	</tr>

	<tr><td colspan="12"></td></tr>

	<tr>
		<td colspan="12">KNOW ALL MEN BY THESE PRESENTS:</td>
	</tr>

	<tr><td colspan="12"></td></tr>

	<tr>
		<td colspan="12">This Contract, entered into volutarily by and between:</td>
	</tr>

	<tr><td colspan="12"></td></tr>

	<tr>
		<td colspan="3">Name of Seafarer:</td>
		<td colspan="9" style="{{ $c }} {{ $i }}">{{ $data->user->namefull }}</td>
	</tr>

	<tr>
		<td colspan="2">Date of Birth:</td>
		<td colspan="3" style="{{ $c }} {{ $i }}">{{ $data->user->birthday ? $data->user->birthday->format('d-M-Y') : "---" }}</td>
		<td colspan="2" style="{{ $c }}">Place of Birth:</td>
		<td colspan="5" style="{{ $c }} {{ $i }}">{{ $data->birth_place }}</td>
	</tr>

	<tr>
		<td>Address:</td>
		<td colspan="11" style="{{ $c }} {{ $i }}">{{ $data->user->address }}</td>
	</tr>

	<tr>
		<td colspan="2">SIRB:</td>
		<td colspan="2" style="{{ $c }} {{ $i }}">{{ isset($data->document_id->{"SEAMAN'S BOOK"}) ? $data->document_id->{"SEAMAN'S BOOK"}->number : "---" }}</td>
		<td style="{{ $c }}">E-Reg. No.</td>
		<td colspan="2" style="{{ $c }} {{ $i }}">{{ isset($data->document_lc->{"POEA EREGISTRATION"}) ? $data->document_lc->{"POEA EREGISTRATION"}->number : "---" }}</td>
		<td colspan="2" style="{{ $c }}">License No.</td>
		@php
			$license = null;
			foreach ($data->document_lc as $doc) {
  				$regulations = json_decode($document->regulation);

  				if(in_array("II/1", $regulations) || in_array("III/1", $regulations)){
  					$license = $doc;
  				}

  				if(in_array("II/2", $regulations) || in_array("III/2", $regulations)){
  					$license = $doc;
  					break;
  				}
			}
		@endphp
		<td colspan="3" style="{{ $c }} {{ $i }}">{{ $license ? $license->no : "NOT APPLICABLE" }}</td>
	</tr>

	<tr>
		<td colspan="12">Hereinafter referred to as the Seafarer</td>
	</tr>

	<tr>
		<td colspan="12" style="{{ $c }}">And</td>
	</tr>

	<tr>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td colspan="4">Name of Agent:</td>
		<td colspan="8" style="{{ $bc }} {{ $i }}">SOLPIA MARINE AND SHIP MANAGEMENT INC.</td>
	</tr>

	<tr>
		<td colspan="4">Name of Principal:</td>
		<td colspan="8" style="{{ $bc }} {{ $i }}">{{ $data->pro_app->vessel->principal->full_name }}</td>
	</tr>

	<tr>
		<td colspan="4">Address:</td>
		<td colspan="8" style="{{ $bc }} {{ $i }}">{{ $data->pro_app->vessel->principal->address }}</td>
	</tr>

	<tr>
		<td colspan="4">Name of MLC Shipowner:</td>
		<td colspan="8" style="{{ $bc }} {{ $i }}">{{ $data->pro_app->vessel->mlc_shipowner }}</td>
	</tr>

	<tr>
		<td colspan="4">Address:</td>
		<td colspan="8" style="{{ $bc }} {{ $i }}">{{ $data->pro_app->vessel->mlc_shipowner_address }}</td>
	</tr>

	@if($data->pro_app->vessel->registered_shipowner)
		<tr>
			<td colspan="4">Name of Registered Shipowner:</td>
			<td colspan="8" style="{{ $bc }} {{ $i }}">{{ $data->pro_app->vessel->registered_shipowner }}</td>
		</tr>

		<tr>
			<td colspan="4">Address:</td>
			<td colspan="8" style="{{ $bc }} {{ $i }}">{{ $data->pro_app->vessel->registered_shipowner_address }}</td>
		</tr>
	@endif

	<tr>
		<td colspan="4"></td>
		<td colspan="8" style="{{ $c }}">(Principal/Country)</td>
	</tr>

	<tr>
		<td colspan="12">For the following vessel:</td>
	</tr>

	<tr>
		<td colspan="3">Name of Vessel:</td>
		<td colspan="9" style="{{ $bc }} {{ $i }}">{{ $data->pro_app->vessel->name }}</td>
	</tr>

	<tr>
		<td colspan="2">IMO Number:</td>
		<td colspan="2" style="{{ $bc }} {{ $i }}">{{ $data->pro_app->vessel->imo }}</td>
		<td colspan="3" style="{{ $c }}">Gross Registerd Tonnage (GRT):</td>
		<td colspan="2" style="{{ $bc }} {{ $i }}">{{ $data->pro_app->vessel->gross_tonnage }}</td>
		<td colspan="2" style="{{ $c }}">Year Built:</td>
		<td style="{{ $bc }} {{ $i }}">{{ $data->pro_app->vessel->year_build }}</td>
	</tr>

	<tr>
		<td colspan="2">Flag:</td>
		<td colspan="2" style="{{ $bc }} {{ $i }}">{{ $data->pro_app->vessel->flag }}</td>
		<td colspan="2" style="{{ $c }}">Type of Vessel:</td>
		<td style="{{ $bc }} {{ $i }}">{{ $data->pro_app->vessel->type }}</td>
		<td colspan="3" style="{{ $c }}">Classification Society:</td>
		<td colspan="2" style="{{ $bc }} {{ $i }}">{{ $data->pro_app->vessel->classification }}</td>
	</tr>

	<tr>
		<td colspan="12">Hereinafter referred to as the Employer</td>
	</tr>

	<tr>
		<td colspan="12" style="height: 25px;"></td>
	</tr>

	<tr>
		<td colspan="12">1. That the seafarer shall be employed on board under the following terms and conditions:</td>
	</tr>

	<tr>
		<td></td>
		<td>1.1</td>
		<td colspan="3">Duration of Contract:</td>
		<td colspan="7" style="{{ $b }} {{ $i }}">{{ $data->req['employment_months'] }} MONTHS (+/- 1 MONTH WITH MUTUAL CONSENT OF BOTH PARTIES)</td>
	</tr>

	<tr>
		<td></td>
		<td>1.2</td>
		<td colspan="3">Position:</td>
		<td colspan="7" style="{{ $b }} {{ $i }}">{{ $data->pro_app->rank->name }}</td>
	</tr>
	
	<tr>
		<td></td>
		<td>1.3</td>
		<td colspan="3">Basic Monthly Salary:</td>
		<td colspan="2" style="{{ $b }} {{ $i }}">${{ $data->wage->basic }}</td>
		<td colspan="2" style="text-align: right;">{{ $data->pro_app->rank->type == "OFFICER" ? "F.O.T." : "G.O.T." }}:</td>
		<td colspan="3" style="{{ $b }} {{ $i }} text-align: right;">${{ $data->wage->fot ?? $data->wage->ot ?? "" }}</td>
	</tr>
	
	<tr>
		<td></td>
		<td>1.4</td>
		<td colspan="3">Hours of Work:</td>
		<td colspan="2" style="{{ $b }} {{ $i }}">{{ $data->pro_app->vessel->work_hours }} HOURS / WEEK</td>
		<td colspan="2" style="text-align: right;">RETIRE ALLOW:</td>
		<td colspan="3" style="{{ $b }} {{ $i }} text-align: right;">${{ $data->wage->retire_allow ?? 0 }}</td>
	</tr>
	
	<tr>
		<td></td>
		<td>1.5</td>
		<td colspan="2">Overtime:</td>
		<td style="text-align: right; {{ $b }}">{{ $data->pro_app->vessel->ot_per_hour }} OT</td>
		<td colspan="2" style="{{ $b }} {{ $i }}">/ HR AFTER {{ $data->pro_app->vessel->ot_hours }} HOURS</td>
		<td colspan="2" style="text-align: right;">SUB ALLOW:</td>
		<td colspan="3" style="{{ $b }} {{ $i }} text-align: right;">${{ $data->wage->sub_allow ?? 0 }}</td>
	</tr>
	
	<tr>
		<td></td>
		<td>1.6</td>
		<td colspan="3">Vacation Leave with Pay:</td>
		<td colspan="2" style="{{ $b }} {{ $i }}">${{ $data->wage->leave_pay ?? 0}} / MONTH</td>
		<td colspan="2" style="text-align: right;"></td>
		<td colspan="3" style="{{ $b }} {{ $i }} text-align: right;"></td>
	</tr>
	
	<tr>
		<td></td>
		<td>1.7</td>
		<td colspan="3">Point of Hire:</td>
		<td colspan="2" style="{{ $b }} {{ $i }}">{{ $data->req['pointOfHire'] }}</td>
		<td colspan="2" style="text-align: right;"></td>
		<td colspan="3" style="{{ $b }} {{ $i }} text-align: right;"></td>
	</tr>
	
	<tr>
		<td></td>
		<td>1.8</td>
		<td colspan="3">CBA if applicable:</td>
		<td colspan="2" style="{{ $b }} {{ $i }}">{{ $data->pro_app->vessel->cba_affiliation }}</td>
		<td colspan="2" style="text-align: right;"></td>
		<td colspan="3" style="{{ $b }} {{ $i }} text-align: right;"></td>
	</tr>

	<tr>
		<td colspan="12" style="height: 20px;">2.  ‎‏‏‎The terms and conditions in accordancce with Governing Board Resolution No. 09, and Memorandum Circular</td>
	</tr>

	<tr>
		<td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎      No. 10, both Series of 2010, and Memorandum Circular No. 34, Series of 2020 (Compliance with the 2018</td>
	</tr>

	<tr>
		<td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎      Amendments to the Maritime Labour Convention, 2006) shall be strictly and faithfully observed.</td>
	</tr>

	<tr><td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎</td></tr>

	<tr>
		<td colspan="12">3.   Any alterations or changes, in any part of this Contract shall be evaluated, verified, processed and</td>
	</tr>

	<tr>
		<td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎      approved by the Philippine Overseas Employment Administration (POEA). Upon approval, the same shall</td>
	</tr>

	<tr>
		<td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎      be deemed an integral part of the Standard Terms and Conditions Governing the Employment of Filipino</td>
	</tr>

	<tr>
		<td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎      Seafarers On Board Ocean-Going Vessels.</td>
	</tr>

	<tr><td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎</td></tr>

	<tr>
		<td colspan="12">4.  Violations of the terms and conditions of this Contract with its approved addendum shall be ground for </td>
	</tr>

	<tr>
		<td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎     disciplinary action against the erring party.</td>
	</tr>

	<tr><td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎</td></tr>

	<tr>
		<td colspan="8"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎ ‎‏‏‎IN WITNESS WHEREOF the parties have hereunto set their hands this </td>
		<td style="{{ $c }} {{ $b }} {{ $i }}">{{ now()->format("jS") }}</td>
		<td style="{{ $c }}">day of</td>
		<td colspan="2" style="{{ $c }} {{ $b }} {{ $i }}">{{ now()->format('F') }}</td>
	</tr>

	<tr>
		<td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎ 2023 at Manila Philippines.</td>
	</tr>

	<tr><td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎</td></tr>

	<tr>
		<td colspan="8"></td>
		<td colspan="4" style="{{ $b }} {{ $c }} {{ $i }}">C/E. ROMANO A. MARIANO</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $b }} {{ $c }} {{ $i }}">{{ $data->user->fullname2 }}</td>
		<td colspan="4"></td>
		<td colspan="4" style="{{ $c }}">PRESIDENT</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $c }}">Seafarer</td>
		<td colspan="4"></td>
		<td colspan="4" style="{{ $c }}">For the Employer</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $c }} {{ $i }}">{{ now()->format('d-M-Y') }}</td>
		<td colspan="4"></td>
		<td colspan="4" style="{{ $c }} {{ $i }}"></td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $c }}">Date</td>
		<td colspan="4"></td>
		<td colspan="4" style="{{ $c }}">Name &#38; Signature of POEA Official</td>
	</tr>

	{{-- {{ dd($data) }} --}}

</table>