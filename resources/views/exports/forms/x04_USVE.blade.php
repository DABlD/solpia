@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b$c";
	$blue = "color: #0000FF;";
	$u = "text-decoration: underline;";

	// dd($data);
@endphp

<table>
	<tr>
		<td colspan="12" style="height: 50px;"></td>
	</tr>

	<tr>
		<td colspan="12" style="{{ $bc }} {{ $u }}">
			US VISA ENDORSEMENT FORM
		</td>
	</tr>

	<tr>
		<td colspan="8"></td>
		<td colspan="2" style="{{ $b }} text-align: right; height: 30px;">DATE / TIME:</td>
		<td style="{{ $c }} {{ $u }}">{{ now()->format("d-M-Y") }}</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $b }}">TO</td>
		<td colspan="2">:</td>
		<td colspan="2" style="{{ $bc }}">Processing Section - Visa</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $b }}">NAME</td>
		<td colspan="2">:</td>
		<td colspan="2" style="{{ $blue }}">{{ $data->user->namefull }}</td>
		<td colspan="1" style="{{ $b }}">RANK:</td>
		<td colspan="2" style="{{ $c }}">{{ $data->rank }}</td>
	</tr>

	@php
		$lastVessel = null;

		if($data->pro_app->status == "On Board"){
			$lastVessel = new stdClass();
			$lastVessel->vessel_name = $data->current_lineup->vessel->name;
			$lastVessel->sign_off = now()->parse($data->current_lineup->joining_date)->addMonths($data->current_lineup->months)->addDays($data->current_lineup->extensions_days);

			$temp = $data->data;
			$temp['eld'] = now()->parse($data->current_lineup->joining_date);
			$data->data = $temp;
		}
		else{
			if($data->sea_service->count()){
				$data->sea_service = $data->sea_service->sortByDesc('sign_off');
				$lastVessel = $data->sea_service->first();
			}
		}
	@endphp

	<tr>
		<td colspan="4" style="{{ $b }}">LAST VESSEL</td>
		<td colspan="2">:</td>
		<td colspan="2" style="{{ $blue }}">{{ $lastVessel ? $lastVessel->vessel_name : "-" }}</td>
		<td colspan="2" style="{{ $b }}">S/OFF DATE:</td>
		<td colspan="1" style="{{ $c }}">{{ isset($lastVessel->sign_off) ? $lastVessel->sign_off->format('d-M-Y') : "-" }}</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $b }}">Prospect Vessel</td>
		<td colspan="2">:</td>
		<td colspan="2" style="{{ $blue }}">{{ isset($data->pro_app->vessel) ? $data->pro_app->vessel->vessel_name : "-" }}</td>
		<td colspan="2" style="{{ $b }}">S/ON DATE:</td>
		<td colspan="1" style="{{ $c }}">{{ isset($data->data['eld']) ? now()->parse($data->data['eld'])->format('d-M-Y') : "-" }}</td>
	</tr>

	<tr>
		<td colspan="12" style="{{ $bc }} {{ $u }} height: 25px;">
			Remarks: (Must clearly explain to concerned seafarer)
		</td>
	</tr>

	<tr>
		<td colspan="12" style="{{ $b }} {{ $u }}">AA. FOR VISA PREPARATION ONLY (No vessel assignment yet)</td>
	</tr>

	<tr>
		<td></td>
		<td style="{{ $bc }}">&#8226;</td>
		<td colspan="10" style="{{ $b }} {{ $u }}">SEAFARERS FUNDED APPLICATION</td>
	</tr>

	<tr>
		<td rowspan="2"></td>
		<td rowspan="2">1.‎</td>
		<td rowspan="2" colspan="10">
			That applicable fee such as Visa application / processing cost + processing employment contract cost shall be on seafarer's account.
		</td>
	</tr>

	<tr></tr>

	<tr>
		<td rowspan="2"></td>
		<td rowspan="2">2.‎</td>
		<td rowspan="2" colspan="10">
			That such refusal or denial, on seafarer's account expenses, I fully understand that I cannot reimburse visa application / processing cost.
		</td>
	</tr>

	<tr></tr>

	<tr>
		<td rowspan="2"></td>
		<td rowspan="2">3.‎</td>
		<td rowspan="2" colspan="10">
			That I understand US visa will be processed under company's name &#38; responsibility and furthermore its advantages of having valid US visa, this I fully agreed that I can only withdraw documents only
		</td>
	</tr>

	<tr></tr>
	<tr>
		<td colspan="2"></td>
		<td style="{{ $c }}">after</td>
		<td colspan="3" style="{{ $b }} {{ $u }}">
			THREE (3) months
		</td>
		<td colspan="6">after payment of all accrued and related expenses.</td>
	</tr>

	<tr>
		<td rowspan="3"></td>
		<td rowspan="3">4.‎</td>
		<td rowspan="3" colspan="10" style="{{ $blue }} height: 19px;">
			That I understand &#38; fully agree that refund or reimbursement will only be paid / deposited to my account after embarkation date within 2-3 months or upon recovery from principal. And I am aware that refund is applicable only for vesssel with US Visa requiremnent.
		</td>
	</tr>

	<tr></tr>
	<tr></tr>

	<tr>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td></td>
		<td style="{{ $bc }}">&#8226;</td>
		<td colspan="10" style="{{ $b }} {{ $u }}">COMPANY FUNDED APPLICATION</td>
	</tr>

	<tr>
		<td rowspan="3"></td>
		<td rowspan="3">5.‎</td>
		<td rowspan="3" colspan="10">
			That visa application / processing cost in case of visa denial or refusal by the US Embassy, I am fully aware to repay the entire expenses incurred for the visa in favor of Solpia Marine &#38; Ship Management Inc.
		</td>
	</tr>

	<tr></tr>
	<tr></tr>

	<tr>
		<td></td>
		<td>6.‎</td>
		<td colspan="2" style="{{ $bc }}">NO REFUND</td>
		<td colspan="8">for the cases of embarking non-US Visa required vessels</td>
	</tr>

	<tr>
		<td></td>
		<td>7.‎</td>
		<td colspan="7" style="{{ $b }}">
			NO OTHER FEES TO BE COLLECTED for the NON-APPEARANCE
		</td>
		<td colspan="3">asides from the visa fees paid to</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="10">the bank as per Machine Readable Visa (MRV) application fee based on current rate.</td>
	</tr>

	<tr>
		<td></td>
		<td>8.‎</td>
		<td colspan="10" style="{{ $b }}">
			Both for REGULAR and SEAVRP applications an LBC delivery fee of PHP 600
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="10">to be paid by company and will be a salary deduction once crew embarked.</td>
	</tr>

	<tr>
		<td rowspan="3"></td>
		<td rowspan="3">9.‎</td>
		<td rowspan="3" colspan="10" style="{{ $blue }} height: 19px;">
			That I am fully aware that visa receipts is valid only for 1 YEAR from the date of payment. If visa appointment was CANCELLED due to early embarkation, will re-sched the visa application upon disembarkation IF RECEIPT IS STILL VALID.
		</td>
	</tr>

	<tr></tr>
	<tr></tr>

	<tr>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td colspan="12" style="{{ $b }} {{ $u }}">
			BB. FOR LINED UP CREW
		</td>
	</tr>

	<tr>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td rowspan="5" colspan="12">
				&#32;‎ ‎ ‎ ‎ ‎ In the event that cancellations of deployment, as advice by owners/principal, with this company looking forward that crew understands such changes and give Solpia ample time to re-assign seafarer to other vessel. However, if crews opt to withdraw documents with US Visa, crew must repay the remaining validity (pro rated basis) / unused portion. Owners / principal paid for the US Visa expecting that the validity of said US Visa will be used on-board their vessel.
		</td>
	</tr>

	<tr></tr>
	<tr></tr>
	<tr></tr>
	<tr></tr>

	<tr>
		<td colspan="3" style="{{ $c }} height: 17px;">Passport exp :</td>
		<td colspan="3" style="{{ $c }}">
			{{ isset($data->document_id->PASSPORT) ? $data->document_id->PASSPORT->expiry_date ? $data->document_id->PASSPORT->expiry_date->format('d-M-y') : "N/A" : "N/A" }}
		</td>
		<td style="{{ $c }}">SIRB exp :</td>
		<td style="{{ $c }}">
			{{ isset($data->document_id->{"SEAMAN'S BOOK"}) ? $data->document_id->{"SEAMAN'S BOOK"}->expiry_date ? $data->document_id->{"SEAMAN'S BOOK"}->expiry_date->format('d-M-y') : "N/A" : "N/A" }}
		</td>
		<td colspan="4">
			Crewing Officer: 
			@if(auth()->user()->gender == "Male")
				MR. 
			@else
				MS. 
			@endif
			
			{{ auth()->user()->fname }} {{ auth()->user()->lname }}
		</td>
	</tr>

	<tr>
		<td colspan="7" style="{{ $bc }}">Conformed by:</td>
		<td colspan="2"></td>
		<td colspan="2" style="{{ $bc }}">Endorsed by:</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="7" style="{{ $bc }}">{{ $data->user->namefull }}</td>
		<td colspan="2"></td>
		<td colspan="2" style="{{ $bc }}">
			@if(auth()->user()->fleet == "FLEET A")
		    	Ms. Precian Cervantes
			@elseif(auth()->user()->fleet == "FLEET B")
				Mr. Adulf Kit Jumawan
			@elseif(auth()->user()->fleet == "FLEET C")
				Ms. Shirley Erasquin
			@elseif(auth()->user()->fleet == "FLEET D")
				Ms. THEA MAE G. RIO
			@elseif(auth()->user()->fleet == "FLEET E")
				Mr. Dennis Quiño
			@elseif(auth()->user()->fleet == "FISHING")
				Mr. Ricardo Amparo
			@elseif(auth()->user()->fleet == "TOEI")
				Mr. Neil Romano
			@endif
		</td>
	</tr>

	<tr>
		<td colspan="7" style="{{ $bc }}">Seafarer Signature over printed name</td>
		<td colspan="2"></td>
		<td colspan="2" style="{{ $bc }}">Crewing Manager</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td colspan="9"></td>
		<td colspan="2" style="{{ $c }}">Noted by:</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="9"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="9"></td>
		<td colspan="2" style="{{ $c }}">CE Romano A. Mariano</td>
		<td></td>
	</tr>

	<tr>
		<td></td>
		<td style="{{ $c }}">{{ $data->data['chargeTo'] ? "X" : "" }}</td>
		<td colspan="3" style="{{ $c }}">Charge to Seafarer</td>
		<td style="{{ $c }}">{{ $data->data['chargeTo'] ? "" : "X" }}</td>
		<td>Charge to SMI</td>
		<td colspan="2"></td>
		<td colspan="2" style="{{ $bc }}">President</td>
		<td></td>
	</tr>
</table>