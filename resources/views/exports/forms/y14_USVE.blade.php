@php
	// dd($data['applicant'], $data['req']);
	$ds = "font-family: 'Arial Narrow'; font-size: 9.5px;";
	$ds2 = "font-family: 'Arial Narrow'; font-size: 9.5px; text-align: justify;";
@endphp

<style>
	@page {
	  margin-top: 5mm;
	  margin-bottom: 5mm;
	}

	.footer {
		position: fixed;
		bottom: -13mm;       /* move into the page margin */
		left: 0;
		right: 0;
		height: 15mm;
		font-size: 8px;
		color: #555;
	}

	.footer table {
		width: 100%;
		border-collapse: collapse;
	}

	.footer td {
		vertical-align: middle;
	}

	.page-break {
	    page-break-after: always;
	}
</style>

@foreach($data['applicants'] as $applicant)
	@php
		$data['applicant'] = $applicant;
	@endphp

	<table>
		<tr>
			<td colspan="15" style="height: 40px;">
				<img src="{{ public_path('images/letter_head.jpg') }}" height="60px" width="700px">
			</td>
		</tr>

		<tr>
			<td colspan="15" style="font-weight: bold; text-align: center;">
				US VISA ENDORSEMENT FORM
			</td>
		</tr>

		<tr>
			<td colspan="15" style="{{ $ds2 }}">
				Note: This form outlines the policy of Solpia Marine & Ship Management, Inc. (SMI) and serves as seafarer’s acknowledgment of the SMI-approved process for US visa applications initiated in relation to possible deployment, in compliance with the applicable DMW rules and MLC regulations on recruitment and placement.
			</td>
		</tr>

		<tr><td style="height: 3px;"></td></tr>

		<tr>
			<td colspan="15" style="{{ $ds }} font-weight: bold;">
				A. General Principles
			</td>
		</tr>

		<tr>
			<td colspan="1"></td>
			<td colspan="1">&#8226</td>
			<td colspan="13" style="{{ $ds2 }}">
				All costs and fees required by SMI for the purpose of recruitment and deployment including but not limited to visa application fees, processing fees, and related charges shall be borne by the company and not charged to the seafarer.
			</td>
		</tr>

		<tr>
			<td colspan="1"></td>
			<td colspan="1">&#8226</td>
			<td colspan="13" style="{{ $ds2 }}">
				A seafarer may voluntarily request SMI to process his US visa at his own expense in preparation for possible deployment. Such voluntary request and any associated costs shall be properly documented in writing and shall be borne by the seafarer. Voluntary processing is optional and shall not affect the seafarer’s eligibility for assignment, ranking, or selection.
			</td>
		</tr>

		<tr>
			<td colspan="1"></td>
			<td colspan="1">&#8226</td>
			<td colspan="13" style="{{ $ds2 }}">
				In the event that a seafarer voluntarily requests SMI to process his US visa in advance of vessel assignment, the corresponding amount paid by the seafarer for the Machine Readable Visa (MRV) shall be refunded in full by the company and deposited to his designated bank account upon successful visa issuance and once onboard SMI manned vessel.
			</td>
		</tr>

		<tr>
			<td colspan="1"></td>
			<td colspan="1">&#8226</td>
			<td colspan="13" style="{{ $ds2 }}">
				If a seafarer who voluntarily requested for US visa application and personally paid all corresponding fees is later assigned to a vessel where a US visa is not required by the principal and/or shipowner, SMI shall not process any reimbursement of the US visa payment. However, reimbursement may be granted only if the assignment change was due to a deployment failure not attributed to the seafarer (e.g., vessel cancellation, principal’s withdrawal, or other valid company-related reasons).
			</td>
		</tr>

		<tr>
			<td colspan="1"></td>
			<td colspan="1">&#8226</td>
			<td colspan="13" style="{{ $ds2 }}">
				No staff of SMI shall be allowed to receive money from or initiate the purchase of the MRV on behalf of any requesting seafarer. All MRV purchases shall be made directly by the seafarer and properly communicated to the assigned Crewing Officer or Visa Officer for monitoring and documentation purposes.
			</td>
		</tr>

		<tr><td style="height: 3px;"></td></tr>

		<tr>
			<td colspan="15" style="{{ $ds }} font-weight: bold;">
				B. Document Handling and Withdrawal
			</td>
		</tr>

		<tr>
			<td colspan="1"></td>
			<td colspan="1">&#8226</td>
			<td colspan="13" style="{{ $ds2 }}">
				SMI shall not withhold any seafarer’s personal documents (e.g., passport) as a condition for payment of fees or as a form of penalty. Any seafarer requesting the release of his personal documents shall have them returned as per SMI Document Withdrawal Policy and Process upon seafarer’s request, provided there are no lawful holds or outstanding legal processes.
			</td>
		</tr>

		<tr>
			<td colspan="1"></td>
			<td colspan="1">&#8226</td>
			<td colspan="13" style="{{ $ds2 }}">
				If a seafarer voluntarily withdraws documents or cancels a US visa application previously initiated voluntarily and paid for by the seafarer, SMI will provide administrative assistance but shall not be required to refund any fees paid by the seafarer to third parties (e.g., bank payments for obtaining MRV).
			</td>
		</tr>

		<tr>
			<td colspan="1"></td>
			<td colspan="1">&#8226</td>
			<td colspan="13" style="{{ $ds2 }}">
				If a seafarer voluntarily cancels a US visa application or withdraws his documents after the US visa has been processed and paid for by the company, SMI may recover the actual, reasonable, and properly documented expenses directly related to the visa application, provided that such recovery is transparent, proportionate, and supported by valid records.
			</td>
		</tr>

		<tr>
			<td colspan="1"></td>
			<td colspan="1">&#8226</td>
			<td colspan="13" style="{{ $ds2 }}">
				Where a US visa application voluntarily requested and paid by the seafarer has been denied or refused by the US Embassy due to misdeclaration, untruthful information, non-appearance, misconduct toward the consul (applicable to first-time applicants) or other related reasons, SMI shall have no obligation to refund any fees paid by the seafarer to third parties (e.g., bank payments for obtaining MRV).
			</td>
		</tr>

		<tr>
			<td colspan="1"></td>
			<td colspan="1">&#8226</td>
			<td colspan="13" style="{{ $ds2 }}">
				Where a US visa application funded by SMI has been denied or refused by the US Embassy due to misdeclaration, untruthful information, non-appearance, misconduct toward the consul (applicable to first-time applicants), or other related reasons, SMI shall require the seafarer to reimburse the costs incurred (e.g., bank payment for obtaining the MRV). Such cost recovery shall be suitable, reasonable, and properly documented.
			</td>
		</tr>

		<tr><td style="height: 3px;"></td></tr>

		<tr>
			<td colspan="15" style="{{ $ds }} font-weight: bold;">
				C. Visa Validity and Scheduling
			</td>
		</tr>

		<tr>
			<td colspan="1"></td>
			<td colspan="1">&#8226</td>
			<td colspan="13" style="{{ $ds2 }}">
				Visa receipts and appointment information are subject to the validity terms and conditions issued by the US Embassy. SMI will assist in re-scheduling or re-processing appointments where practicable. If a visa appointment or processing must be rescheduled due to company-initiated changes (such as early embarkation), SMI will make reasonable efforts to reschedule at no cost to the seafarer.
			</td>
		</tr>

		<tr><td style="height: 3px;"></td></tr>

		<tr>
			<td colspan="15" style="{{ $ds }} font-weight: bold;">
				D. Crew Acknowledgement, Declaration and Consent 
			</td>
		</tr>

		<tr>
			<td colspan="15" style="{{ $ds2 }}">
				I, <span style="text-decoration: underline;">{{ $data['applicant']->user->namefull }}</span>, hereby acknowledge that I have read and fully understood SMI’s Policy on US Visa Application and Processing as stated above. I confirm that I was given the opportunity to ask questions or seek clarifications regarding its contents, and that all my inquiries were properly addressed to my satisfaction. 
			</td>
		</tr>

		<tr><td style="height: 3px;"></td></tr>

		<tr>
			<td colspan="15" style="{{ $ds2 }}">
				I further declare that by affixing my signature below, I am confirming that I have signed this Crew Acknowledgment, Declaration, and Consent of my own free will and volition, without any form of coercion, force, intimidation, harassment, undue influence, or promise of benefit from the management, staff, or any interested party of SMI.
			</td>
		</tr>

		<tr><td style="height: 1px;"></td></tr>

		<tr>
			<td colspan="15" style="{{ $ds2 }}">
				Hence, I express my intention as follows:
			</td>
		</tr>

		<tr><td style="height: 1px;"></td></tr>

		<tr>
			<td></td>
			<td style="border: 1px solid black;"></td>
			<td colspan="13" style="{{ $ds2 }}">
				<i>I am voluntarily requesting SMI to process my US Visa application and I am willing to purchase the MRV at my own expense, in accordance with the company’s policy on US Visa Application and Processing.</i>
			</td>
		</tr>

		<tr><td style="height: 3px;"></td></tr>

		<tr>
			<td></td>
			<td style="border: 1px solid black;"></td>
			<td colspan="13" style="{{ $ds2 }}">
				<i>I choose to wait for an assignment on a vessel that does not require a US visa, and I understand that this decision may result in a longer vacation period or extended waiting time before my next deployment, due to the limited availability of vessels that do not require a US visa. </i>
			</td>
		</tr>

		<tr><td style="height: 15px;"></td></tr>

		<tr>
			<td colspan="2"></td>
			<td colspan="5" style="{{ $ds }} border-bottom: 1px solid black; text-align: center; font-weight: bold;">
				{{ $data['applicant']->user->namefull }}
			</td>
			<td colspan="3"></td>
			<td colspan="4" style="border-bottom: 1px solid black;"></td>
			<td></td>
		</tr>

		<tr>
			<td colspan="2"></td>
			<td colspan="5" style="{{ $ds }} text-align: center; font-weight: bold;">
				Seafarer Signature over Printed Name
			</td>
			<td colspan="3"></td>
			<td colspan="4" style="{{ $ds }} text-align: center; font-weight: bold;">Date</td>
			<td></td>
		</tr>

		<tr>
			<td colspan="15">
				<hr style="height: 1px; background-color: black; width: 100%;">
			</td>
		</tr>

		<tr>
			<td colspan="11" style="{{ $ds }} font-weight: bold;">To: SMI Processing Section - Visa Officer</td>
			<td style="{{ $ds }} text-align: right;">Date:</td>
			<td colspan="3" style="border-bottom: 1px solid black;"></td>
		</tr>

		<tr><td style="height: 3px;"></td></tr>

		<tr>
			<td colspan="15" style="{{ $ds }}">
				Please process the US Visa application of the following crew member:
			</td>
		</tr>

		<tr>
			<td colspan="2"></td>
			<td style="{{ $ds }}">Name of Crew</td>
			<td>:</td>
			<td colspan="7" style="{{ $ds }} border-bottom: 1px solid black;">
				{{ $data['applicant']->user->namefull }}
			</td>
		</tr>

		<tr>
			<td colspan="2"></td>
			<td style="{{ $ds }}">Rank / Position</td>
			<td>:</td>
			<td colspan="7" style="{{ $ds }} border-bottom: 1px solid black;">
				{{ $data['applicant']->pro_app->rank->abbr }}
			</td>
		</tr>

		<tr>
			<td colspan="2"></td>
			<td style="{{ $ds }}">Principal</td>
			<td>:</td>
			<td colspan="7" style="{{ $ds }} border-bottom: 1px solid black;">
				{{ $data['applicant']->pro_app->principal->name }}
			</td>
		</tr>

		<tr><td style="height: 1px;"></td></tr>

		@php
			$lastVessel = null;

			$ss = false;
	        foreach($data['applicant']->sea_service as $ss){
				if(str_contains($ss->manning_agent, 'SOLPIA')){
					$ss = $ss;
					$lastVessel = $ss;
					break;
				}
	        }
		@endphp

		<tr>
			<td colspan="2"></td>
			<td style="{{ $ds }}">Employment Status</td>
			<td>:</td>
			<td style="{{ $ds }} text-align: center; font-weight: bold; border: 1px solid black;">
				{{ $ss ? "" : "X" }}
			</td>
			<td style="{{ $ds }}">New Hire</td>
			<td></td>
			<td style="{{ $ds }} text-align: center; font-weight: bold; border: 1px solid black;">
				{{ $ss ? "X" : "" }}
			</td>
			<td style="{{ $ds }}">Ex-Crew</td>
			<td colspan="5" style="{{ $ds }}">
				(Last Vessel: <u>{{ $lastVessel ? $lastVessel->vessel_name : "N/A" }}</u>)
			</td>
		</tr>

		<tr>
			<td colspan="2"></td>
			<td style="{{ $ds }}">Type of Request</td>
			<td>:</td>
			<td style="{{ $ds }} text-align: center; font-weight: bold; border: 1px solid black;">
				{{ $data['req']['chargeTo'] ? "" : "X" }}
			</td>

			<td colspan="3" style="{{ $ds }}">Company-required US Visa(funded)</td>

			<td style="{{ $ds }} text-align: center; font-weight: bold; border: 1px solid black;">
				{{ $data['req']['chargeTo'] ? "X" : "" }}
			</td>
			<td colspan="5" style="{{ $ds }}">Voluntary US Visa Application(paid by seafarer)</td>
		</tr>

		@php
			$sb = $data['applicant']->document_id->firstWhere('type', "SEAMAN'S BOOK");
			$pp = $data['applicant']->document_id->firstWhere('type', "PASSPORT");
		@endphp

		<tr>
			<td colspan="2"></td>
			<td style="{{ $ds }}">Document Status</td>
			<td>:</td>
			<td colspan="2" style="{{ $ds }}">Passport Expiry:</td>
			<td colspan="2" style="{{ $ds }} text-align: center; border: 1px solid black;">
				{{ isset($pp) ? $pp->expiry_date ? $pp->expiry_date->format("d-M-Y") : "" : "" }}
			</td>
			<td></td>
			<td colspan="2" style="{{ $ds }}">SIRB Expiry:</td>
			<td colspan="2" style="{{ $ds }} text-align: center; border: 1px solid black;">
				{{ isset($sb) ? $sb->expiry_date ? $sb->expiry_date->format("d-M-Y") : "" : "" }}
			</td>
		</tr>

		<tr><td style="height: 3px;"></td></tr>

		<tr>
			<td colspan="4" style="{{ $ds }}">Requested by:</td>
			<td colspan="2"></td>
			<td colspan="4" style="{{ $ds }}">Endorsed by:</td>
			<td colspan="1"></td>
			<td colspan="5" style="{{ $ds }}">Approved by:</td>
		</tr>

		<tr>
			<td colspan="4" style="{{ $ds }} text-align: center; font-weight: bold; border-bottom: 1px solid black; vertical-align: bottom;"></td>
			<td colspan="2" style="height: 20px;"></td>
			<td colspan="4" style="{{ $ds }} text-align: center; font-weight: bold; border-bottom: 1px solid black; vertical-align: bottom;">
				@if($data['applicant']->user->fleet == "TOEI")
					Mr. Leonil Luis F. Romano
				@elseif($data['applicant']->user->fleet == "FLEET B")
					Mr. Adulf Kit Jumawan
				@elseif($data['applicant']->user->fleet == "FLEET C")
					Ms. Shirley Erasquin
				@elseif($data['applicant']->user->fleet == "FLEET D")
					Ms. Thea Mae G. Rio
				@elseif($data['applicant']->user->fleet == "FISHING")
					Mr. Ricardo Amparo
				@endif
			</td>
			<td colspan="1"></td>
			<td colspan="5" style="{{ $ds }} text-align: center; font-weight: bold; border-bottom: 1px solid black; vertical-align: bottom;"></td>
		</tr>

		<tr>
			<td colspan="4" style="{{ $ds }} text-align: center; font-weight: bold;">
				Crewing Officer
			</td>
			<td colspan="2"></td>
			<td colspan="4" style="{{ $ds }} text-align: center; font-weight: bold;">
				Crewing Manager
			</td>
			<td colspan="1"></td>
			<td colspan="5" style="{{ $ds }} text-align: center; font-weight: bold;">
				CE Romano A. Mariano / President
			</td>
		</tr>
	</table>

	<div class="footer">
		<table>
		    <tr>
		        <!-- LEFT -->
		        <td style="text-align:left;">
		            Doc. No. SMOP-USVEF-12 
		        </td>
		        <!-- CENTER -->
		        <td style="text-align:center;">
		            Effective Date: 18 November 2020 
		        </td>
		        <!-- RIGHT -->
		        <td style="text-align:right;">
		            Revision No.: 03 (25 October 2025) 
		        </td>
		    </tr>
		</table>
	</div>

	@if($loop->index < sizeof($data['applicants']) - 1)
		<div class="page-break"></div>
	@endif

@endforeach