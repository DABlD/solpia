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
		<td colspan="12">1. That the employee shall be employed on board under the following terms and conditions:</td>
	</tr>

	<tr>
		<td colspan="2" style="text-align: right;">1.1</td>
		<td colspan="3">Duration of Contract:</td>
		<td colspan="7" style="{{ $b }} {{ $i }}">
			@php
				$suffix = "";

				if($data->req['ext_months']){
					$sMonths = $data->req['ext_months'] . " MONTHS ";

					if($data->req['plus'] == "true" && $data->req['minus'] == "true"){
						$suffix .= "+/- $sMonths";
					}
					elseif($data->req['plus'] == "true"){
						$suffix .= "+ $sMonths";
					}
					elseif($data->req['minus'] == "true"){
						$suffix .= "- $sMonths";
					}
				}

				$suffix .= $data->req['suffix'];
				
			@endphp
			{{ $data->req['employment_months'] }} MONTHS ({{ $suffix }})
		</td>
	</tr>

	<tr>
		<td colspan="2" style="text-align: right;">1.2</td>
		<td colspan="3">Position:</td>
		<td colspan="7" style="{{ $b }} {{ $i }}">{{ $data->pro_app->rank->name }}</td>
	</tr>
	
	<tr>
		<td colspan="2" style="text-align: right;">1.3</td>
		<td colspan="3">Basic Monthly Salary:</td>
		<td colspan="7" style="{{ $b }} {{ $i }}">${{ $data->wage->basic }}</td>
	</tr>
	
	<tr>
		<td colspan="2" style="text-align: right;">1.4</td>
		<td colspan="3">Hours of Work:</td>
		<td colspan="7" style="{{ $b }} {{ $i }}">{{ $data->pro_app->vessel->work_hours }} HOURS / WEEK</td>
	</tr>
	
	<tr>
		<td colspan="2" style="text-align: right;">1.5</td>
		<td colspan="3">Overtime:</td>
		<td colspan="7" style="{{ $b }} {{ $i }}">
			{{ $data->pro_app->rank->type == "OFFICER" ? "F.O.T." : "G.O.T." }}
			‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
			${{ $data->wage->fot ?? $data->wage->ot ?? "" }}
			‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
			{{ $data->pro_app->vessel->ot_per_hour }} OT / HR AFTER {{ $data->pro_app->vessel->ot_hours }} HOURS
		</td>
	</tr>
	
	<tr>
		<td colspan="2" style="text-align: right;">1.6</td>
		<td colspan="3">Vacation Leave with Pay:</td>
		<td colspan="7" style="{{ $b }} {{ $i }}">
			${{ $data->wage->leave_pay ?? 0}}
			‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
			‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
			9days/month
		</td>
	</tr>
	
	<tr>
		<td colspan="2" style="text-align: right;">1.7</td>
		<td colspan="3">Others:</td>
		<td colspan="7" style="{{ $b }} {{ $i }}">
			S.A.
			‎‏‏‎ ‎‏‏‎ ‎‏‏‎
			${{ $data->wage->sub_allow ?? 0}}
			‎‏‏‎ ‎‏‏‎
			P.F.
			‎‏‏‎ ‎‏‏‎ ‎‏‏‎
			${{ $data->wage->retire_allow ?? 0}}
			‎‏‏‎ ‎‏‏‎
			S.V.A
			‎‏‏‎ ‎‏‏‎ ‎‏‏‎
			${{ $data->wage->sup_allow ?? 0}}
			‎‏‏‎ ‎‏‏‎
			Owner Allow:
			‎‏‏‎ ‎‏‏‎ ‎‏‏‎
			${{ $data->wage->owner_allow ?? 0}}
			‎‏‏‎ ‎‏‏‎
			Other Allow:
			‎‏‏‎ ‎‏‏‎ ‎‏‏‎
			${{ $data->wage->other_allow ?? 0}}
		</td>
	</tr>
	
	<tr>
		<td colspan="2" style="text-align: right;">1.8</td>
		<td colspan="3">Total Salary:</td>
		<td colspan="7" style="{{ $b }} {{ $i }}">${{ $data->wage->total }}</td>
	</tr>
	
	<tr>
		<td colspan="2" style="text-align: right;">1.9</td>
		<td colspan="3">Point of Hire:</td>
		<td colspan="7" style="{{ $b }} {{ $i }}">{{ $data->req['pointOfHire'] }}</td>
	</tr>
	
	<tr>
		<td colspan="2" style="text-align: right;"> ‎‏‏‎1.10</td>
		<td colspan="4">Collective Bargaining Agreement, if any:</td>
		<td colspan="6" style="{{ $bc }} {{ $i }}">{{ $data->pro_app->vessel->cba_affiliation }}</td>
	</tr>

	<tr>
		<td colspan="12" style="height: 20px;">2. The current and applicable ITF Collective Agreement shall be considered to be incorporated into and to form part</td>
	</tr>

	<tr>
		<td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎of the contract and shall compliance with the 2018 amendment to the code of Maritime Labor Convention 2006.</td>
	</tr>

	<tr><td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎</td></tr>

	<tr>
		<td colspan="12">3. The Ship's Articles shall be deemed for all purpose to include the term of this contract (including the applicable ITF</td>
	</tr>

	<tr>
		<td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎Collective Agreement) and it shall be the duty of the company to ensure that the ship's Articles reflect these terms.</td>
	</tr>

	<tr>
		<td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎These terms shall take precedence over all other terms.</td>
	</tr>

	<tr><td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎</td></tr>

	<tr>
		<td colspan="12">4. The Seafarer has read, understood and agreed to the terms and conditions of employment as identified in the</td>
	</tr>

	<tr>
		<td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎Collective Agreement and enters into this contract freely.</td>
	</tr>

	<tr><td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎</td></tr>

	<tr>
		<td colspan="8"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎ ‎‏‏‎IN WITNESS WHEREOF the parties have hereunto set their hands this </td>
		<td style="{{ $c }} {{ $b }} {{ $i }}">{{ now()->format("jS") }}</td>
		<td style="{{ $c }}">day of</td>
		<td colspan="2" style="{{ $c }} {{ $b }} {{ $i }}">{{ now()->format('F') }}</td>
	</tr>

	<tr>
		<td colspan="12"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎ {{ now()->format('Y') }} at Manila Philippines.</td>
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
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="4"></td>
		<td colspan="4" style="{{ $c }}">(for the MLC Shipowner)</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="4"></td>
		<td colspan="4" style="{{ $c }}">Name &#38; Signature/Designation</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $c }} {{ $i }}"></td>
		<td colspan="4"></td>
		<td colspan="4" style="{{ $c }} {{ $i }}"></td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $c }}">Date</td>
		<td colspan="4"></td>
		<td colspan="4" style="{{ $c }}">Date</td>
	</tr>

	{{-- {{ dd($data) }} --}}

</table>