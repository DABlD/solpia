@php
	$center = "text-align: center;";
	$middle = "vertical-align: middle;";
	$bold = "font-weight: bold;";
	$und = "text-decoration: underline;";
	$blue = "color: #0000FF;";
@endphp

<table>
	<tr>
		<td colspan="10" style="{{ $center }} {{ $bold }} {{ $und }} font-size: 14px;">
			US VISA ENDORSEMENT FORM
		</td>
	</tr>

	<tr>
		<td colspan="8"></td>
		<td style="text-align: left; {{ $bold }}">DATE/TIME</td>
		<td style="text-align: right;">{{ now()->format('d-F-Y') }}</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td style="font-size: 10px; {{ $bold }}" colspan="3">
			TO:
		</td>
		<td colspan="5" style="{{ $bold }}">
			Processing Section - Visa
		</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td style="font-size: 10px; {{ $bold }}" colspan="3">
			NAME:
		</td>
		<td colspan="4" style="font-size: 10px; {{ $bold }} {{ $blue }}">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->mname }}
		</td>
		<td></td>
		<td style="font-size: 10px; {{ $bold }}">
			RANK:
		</td>
		<td style="font-size: 10px; {{ $bold }} {{ $center }} {{ $blue }}">
			{{ $data->rank }}
		</td>
	</tr>

	<tr>
		<td style="font-size: 10px; {{ $bold }}" colspan="3">
			LAST VESSEL:
		</td>
		<td colspan="4" style="font-size: 10px; {{ $bold }} {{ $blue }}">
			{{ $data->sea_service[0]->vessel_name }}
		</td>
		<td></td>
		<td style="font-size: 10px; {{ $bold }}">
			S/OFF DATE:
		</td>
		<td style="font-size: 10px; {{ $bold }} {{ $center }} {{ $blue }}">
			{{ $data->sea_service[0]->sign_off ? $data->sea_service[0]->sign_off->format('d-F-y') : '---' }}
		</td>
	</tr>

	<tr>
		<td style="font-size: 10px; {{ $bold }}" colspan="3">
			PROSPECT VESSEL:
		</td>
		<td colspan="4" style="font-size: 10px; {{ $bold }} {{ $blue }}">
			{{ $data->vessel->name }}
		</td>
		<td></td>
		<td style="font-size: 10px; {{ $bold }}">
			S/ON DATE:
		</td>
		<td style="font-size: 10px; {{ $bold }} {{ $center }} {{ $blue }}">
			{{ $data->departure ? $data->departure->format('d-F-y') : '---' }}
		</td>
	</tr>

	<tr>
		<td style="{{ $middle }} {{ $center }} {{ $bold }} {{ $und }} height: 30px;" colspan="10">
			Remarks: (Must clearly explain to concert seafarer)
		</td>
	</tr>

	<tr>
		<td style="{{ $bold }} {{ $und }}" colspan="10">
			AA. FOR VISA PREPARATION ONLY (No vessel assignment yet)
		</td>
	</tr>

	<tr>
		<td></td>
		<td style="{{ $bold }} {{ $und }}" colspan="9">
			• SEAFARERS FUNDED APPLICATION
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="9">
			1. That applicable fee such as Visa application / processing cost + processing employment
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="8">
			contract cost shall be on seafarers account.
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="9">
			2. That such refusal or denial, on seafarer’s account expenses, I fully understand that I cannot
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="8">
			reimburse visa application / processing cost.
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="9">
			3. That I understand USA visa will be processed under company’s name &#38; responsibility and
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="8">
			furthermore its advantages of having valid USA visa, thus I fully agreed that I can only withdraw
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="8">
			documents only after <b><u>THREE (3) months</u></b> and after payment of all accrued and related
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="8">
			expenses.
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="9">
			4. That I understand &#38; fully agree that refund or reimbursement will only be paid / deposited to my
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="8">
			account after embarkation date within 2-3 months or upon recovery from principal. And I am
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="8">
			aware that refund is applicable only for vessel with US Visa requirement.
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="9" style="{{ $bold }}">
			• COMPANY FUNDED APPLICATION
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="9">
			5. That visa application / processing cost, in case of visa denial or refusal by the US Embassy, I
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="8">
			fully aware to repay the entire expenses incurred for the visa in favor of Solpia Marine &#38; Ship
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="8">
			Management Inc.
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="9">
			6. NO REFUND for the cases of embarking non-USA visa required vessels
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="9">
			7. <b>NO OTHER FEES TO BE COLLECTED</b> for the <b>NON-APPERANCE</b> asides from the visa fees 
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="8">
			paid to the bank as per (Machine Readable Visa (MRV) application fee based on current rate
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="9">
			8. <b>Both for REGULAR and SEAVRP applications a 2GO document delivery fee of PHP 435</b> to be
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="8">
			paid by company and will be a salary deduction once crew embarked.
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="9">
			9. That I am fully aware <b>that the visa receipt is valid only for 1 year</b> from the date of payment.
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="9">
			10. That I understand if my visa appointment will be CANCELLED due to early embarkation, the company
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="8">
			will <b>reschedule my application upon disembarkation if RECEIPT IS STILL VALID. If receipt</b>
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="8">
			<b>already expired, I fully agree to pay a new visa fee.</b>
		</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="10" style="{{ $bold }} {{ $und }}">
			BB. FOR LINED UP CREW
		</td>
	</tr>

	<tr>
		<td colspan="10" style="height: 65px; vertical-align: middle;">
			In the event that cancellations of deployment, as advice by owners/principal, with this company looking forward that crew understands such changes and give Solpia ample time to re-assign seafarer to other vessel. However, if crews opt to withdraw documents with US Visa crew, must repay the remaining validity (pro rata basis)/ unused portion. Owners / principal paid for the US Visa expecting that the validity of said Visa will be used on-board their vessel.
		</td>
	</tr>

	<tr>
		<td></td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="3">Passport exp:</td>
		<td colspan="2" style="{{ $center }} {{ $blue }}">
			{{ $data->document_id->PASSPORT ? $data->document_id->PASSPORT->expiry_date->format('d-M-y') : "N/A" }}
		</td>
		<td>SIRB exp:</td>
		<td style="{{ $center }} {{ $blue }}">
			{{ $data->document_id->{"SEAMAN'S BOOK"} ? $data->document_id->{"SEAMAN'S BOOK"}->expiry_date->format('d-M-y') : "N/A" }}
		</td>
		<td>Crewing Officer:</td>
		<td colspan="2" style="{{ $center }}">
			{{ auth()->user()->gender == "Male" ? "Mr" : "Ms" }}. {{ auth()->user()->fname }} {{ auth()->user()->lname }}
		</td>
	</tr>

	<tr>
		<td style="color: #FF0000; {{ $bold }} font-style: italic;" colspan="3">
			@php
				$bool = false;
				foreach($data->sea_service as $ss){
					if(str_contains($ss->manning_agent, 'SOLPIA')){
						$bool = true;
					}
				}
			@endphp

			@if($bool)
				EX-CREW
			@else
				NEW HIRE
			@endif
		</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $bold }} {{ $center }}">
			Conforme:
		</td>
		<td colspan="4"></td>
		<td colspan="2" style="{{ $bold }}">
			Endorsed by:
		</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td style="vertical-align: bottom; {{ $center }}" colspan="6">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td></td>
		<td colspan="3" style="{{ $center }}">
			@if(auth()->user()->fleet == "FLEET A")
				Ms. Precian Cervantes
			@elseif(auth()->user()->fleet == "FLEET B")
				Mr. Adulf Kit Jumawan
			@elseif(auth()->user()->fleet == "FLEET C")
				Ms. Jeanette Solidum
			@elseif(auth()->user()->fleet == "FLEET D")
				Ms. Thea Guerra
			@elseif(auth()->user()->fleet == "FLEET E")
				Mr. Homer Birco
			@elseif(auth()->user()->fleet == "TOEI")
				Mr. Neil Romano
			@endif
		</td>
	</tr>

	<tr>
		<td style="vertical-align: bottom; {{ $center }}" colspan="6">
			Seafarer Signature over printed name
		</td>
		<td></td>
		<td colspan="3" style="{{ $center }}">
			Crewing Manager
		</td>
	</tr>

	<tr>
		<td style="border: solid 1px #000000; {{ $bold }} {{ $center }}">
			{{ $data->data['chargeTo'] ? "X" : "" }}
		</td>
		<td style="font-size: 9px;" colspan="3">Charge to Seafarer</td>
		<td style="border: solid 1px #000000; {{ $bold }} {{ $center }}">
			{{ $data->data['chargeTo'] ? "" : "X" }}
		</td>
		<td style="font-size: 9px;" colspan="2">Charge to SMI</td>
		<td colspan="3">Noted by:</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="7"></td>
		<td style="{{ $center }}" colspan="3">C/E. ROMANO A. MARIANO</td>
	</tr>

	<tr>
		<td></td>
		<td style="color: #C1C1C1;" colspan="3">SMOP-USVEF-12</td>
		<td colspan="3"></td>
		<td colspan="3" style="{{ $center }}">PRESIDENT</td>
	</tr>

	<tr>
		<td style="font-size: 7px; text-align: right; vertical-align: bottom;" colspan="10">8,000.00</td>
	</tr>
</table>