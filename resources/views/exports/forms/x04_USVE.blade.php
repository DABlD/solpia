@php
	$excrew = false;
	foreach ($data->sea_service as $service) {
	    if (stripos($service->manning_agent, 'SOLPIA') !== false) {
	        $excrew = true;
	        break;
	    }
	}
@endphp

<table>
	<tr>
		<td colspan="18">
			US VISA ENDORSEMENT
		</td>
	</tr>

	<tr>
		<td colspan="18">
			Note: This form outlines the policy of Solpia Marine &#38; Ship Management, Inc. (SMI) and serves as seafarer’s acknowledgment of the SMI-approved process for US visa applications initiated in relation to possible deployment, in compliance with the applicable DMW rules and MLC regulations on recruitment and placement.
		</td>
	</tr>

	<tr><td colspan="18"></td></tr>

	<tr>
		<td colspan="18">
			A. General Principles
		</td>
	</tr>

	{{-- ▪ --}}
	<tr>
		<td></td>
		<td>■</td>
		<td colspan="16">
			All costs and fees required by SMI for the purpose of recruitment and deployment including but not limited to visa application fees, processing fees, and related charges shall be borne by the company and not charged to the seafarer.
		</td>
	</tr>

	<tr>
		<td></td>
		<td>■</td>
		<td colspan="16">
			A seafarer may voluntarily request SMI to process his US visa at his own expense in preparation for possible deployment. Such voluntary request and any associated costs shall be properly documented in writing and shall be borne by the seafarer. Voluntary processing is optional and shall not affect the seafarer’s eligibility for assignment, ranking, or selection.
		</td>
	</tr>

	<tr>
		<td></td>
		<td>■</td>
		<td colspan="16">
			In the event that a seafarer voluntarily requests SMI to process his US visa in advance of vessel assignment, the corresponding amount paid by the seafarer for the Machine Readable Visa (MRV) shall be refunded in full by the company and deposited to his designated bank account upon successful visa issuance and once onboard SMI manned vessel.
		</td>
	</tr>

	<tr>
		<td></td>
		<td>■</td>
		<td colspan="16">
			If a seafarer who voluntarily requested for US visa application and personally paid all corresponding fees is later assigned to a vessel where a US visa is not required by the principal and/or shipowner, SMI shall not process any reimbursement of the US visa payment. However, reimbursement may be granted only if the assignment change was due to a deployment failure not attributed to the seafarer (e.g., vessel cancellation, principal’s withdrawal, or other valid company-related reasons).
		</td>
	</tr>

	<tr>
		<td></td>
		<td>■</td>
		<td colspan="16">
			No staff of SMI shall be allowed to receive money from or initiate the purchase of the MRV on behalf of any requesting seafarer. All MRV purchases shall be made directly by the seafarer and properly communicated to the assigned Crewing Officer or Visa Officer for monitoring and documentation purposes.
		</td>
	</tr>

	<tr><td colspan="18"></td></tr>

	<tr>
		<td colspan="18">
			B. Document Handling and Withdrawal
		</td>
	</tr>

	{{-- ▪ --}}
	<tr>
		<td></td>
		<td>■</td>
		<td colspan="16">
			SMI shall not withhold any seafarer’s personal documents (e.g., passport) as a condition for payment of fees or as a form of penalty. Any seafarer requesting the release of his personal documents shall have them returned as per SMI Document Withdrawal Policy and Process upon seafarer’s request, provided there are no lawful holds or outstanding legal processes.
		</td>
	</tr>

	<tr>
		<td></td>
		<td>■</td>
		<td colspan="16">
			If a seafarer voluntarily withdraws documents or cancels a US visa application previously initiated voluntarily and paid for by the seafarer, SMI will provide administrative assistance but shall not be required to refund any fees paid by the seafarer to third parties (e.g., bank payments for obtaining MRV).
		</td>
	</tr>

	<tr>
		<td></td>
		<td>■</td>
		<td colspan="16">
			If a seafarer voluntarily cancels a US visa application or withdraws his documents after the US visa has been processed and paid for by the company, SMI may recover the actual, reasonable, and properly documented expenses directly related to the visa application, provided that such recovery is transparent, proportionate, and supported by valid records.
		</td>
	</tr>

	<tr>
		<td></td>
		<td>■</td>
		<td colspan="16">
			Where a US visa application voluntarily requested and paid by the seafarer has been denied or refused by the US Embassy due to misdeclaration, untruthful information, non-appearance, misconduct toward the consul (applicable to first-time applicants) or other related reasons, SMI shall have no obligation to refund any fees paid by the seafarer to third parties (e.g., bank payments for obtaining MRV).
		</td>
	</tr>

	<tr>
		<td></td>
		<td>■</td>
		<td colspan="16">
			Where a US visa application funded by SMI has been denied or refused by the US Embassy due to misdeclaration, untruthful information, non-appearance, misconduct toward the consul (applicable to first-time applicants), or other related reasons, SMI shall require the seafarer to reimburse the costs incurred (e.g., bank payment for obtaining the MRV). Such cost recovery shall be suitable, reasonable, and properly documented.
		</td>
	</tr>

	<tr><td colspan="18"></td></tr>

	<tr>
		<td colspan="18">
			C. Visa Validity and Scheduling
		</td>
	</tr>

	{{-- ▪ --}}
	<tr>
		<td></td>
		<td>■</td>
		<td colspan="16">
			Visa receipts and appointment information are subject to the validity terms and conditions issued by the US Embassy. SMI will assist in re-scheduling or re-processing appointments where practicable. If a visa appointment or processing must be rescheduled due to company-initiated changes (such as early embarkation), SMI will make reasonable efforts to reschedule at no cost to the seafarer.
		</td>
	</tr>

	<tr><td colspan="18"></td></tr>

	<tr>
		<td colspan="18">
			D. Crew Acknowledgement, Declaration and Consent
		</td>
	</tr>

	<tr>
		<td colspan="18">
			I, ___________________________________________________________________, hereby acknowledge that I have read and fully understood SMI’s Policy on US Visa Application and Processing as stated above. I confirm that I was given the opportunity to ask questions or seek clarifications regarding its contents, and that all my inquiries were properly addressed to my satisfaction.
		</td>
	</tr>

	<tr><td colspan="18"></td></tr>

	<tr>
		<td colspan="18">
			I further declare that by affixing my signature below, I am confirming that I have signed this Crew Acknowledgment, Declaration, and Consent of my own free will and volition, without any form of coercion, force, intimidation, harassment, undue influence, or promise of benefit from the management, staff, or any interested party of SMI.
		</td>
	</tr>

	<tr><td colspan="18"></td></tr>

	<tr>
		<td colspan="18">
			Hence, I express my intention as follows:
		</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="16">
			I am voluntarily requesting SMI to process my US Visa application and I am willing to purchase the MRV at my own expense, in accordance with the company’s policy on US Visa Application and Processing.
		</td>
	</tr>

	<tr>
		<td colspan="18"></td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="16">
			I choose to wait for an assignment on a vessel that does not require a US visa, and I understand that this decision may result in a longer vacation period or extended waiting time before my next deployment, due to the limited availability of vessels that do not require a US visa.
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="5">
			{{ $data->user->namefull }}
		</td>
		<td colspan="3"></td>
		<td colspan="6">{{ now()->format('F j, Y') }}</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="5">
			Seafarer Signature over Printed Name
		</td>
		<td colspan="3"></td>
		<td colspan="6">Date</td>
		<td colspan="2"></td>
	</tr>
	
	<tr><td colspan="18"></td></tr>

	<tr>
		<td colspan="14">
			To: SMI Processing Section - Visa Officer
		</td>
		<td>Date:</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="18">
			Please process the US Visa application of the following crew member:
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td>Name of Crew</td>
		<td>:</td>
		<td colspan="8">
			{{ $data->user->namefull }}
		</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td>Rank / Position</td>
		<td>:</td>
		<td colspan="8">
			{{ $data->pro_app->rank->abbr }}
		</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td>Principal</td>
		<td>:</td>
		<td colspan="8">
			{{ $data->pro_app->principal->full_name }}
		</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td>Employment Status</td>
		<td>:</td>
		<td>{{ $excrew ? "" : "X" }}</td>
		<td>New Hire</td>
		<td></td>
		<td>{{ $excrew ? "X" : "" }}</td>
		<td>Ex-Crew</td>
		<td colspan="2">(Last Vessel:</td>
		<td colspan="6"></td>
		<td>)</td>
	</tr>

	<tr>
		<td colspan="18"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td>Type of Request</td>
		<td>:</td>
		<td>{{ $data->data['chargeTo'] ? "" : "X" }}</td>
		<td colspan="4">Company-required US Visa (funded)</td>
		<td>{{ $data->data['chargeTo'] ? "X" : "" }}</td>
		<td colspan="8">Voluntary US Visa Application (paid by seafarer)</td>
	</tr>

	<tr>
		<td colspan="18"></td>
	</tr>

	@php
		$sb = isset($data->document_id->{"SEAMAN'S BOOK"}) ? $data->document_id->{"SEAMAN'S BOOK"} : null;
		$pp = isset($data->document_id->{"PASSPORT"}) ? $data->document_id->{"PASSPORT"} : null;
	@endphp

	<tr>
		<td colspan="2"></td>
		<td>Document Status</td>
		<td>:</td>
		<td colspan="2">Passport Expiry:</td>
		<td colspan="4">{{ isset($pp) ? $pp->expiry_date ? $pp->expiry_date->format("d-M-Y") : "" : "" }}</td>
		<td></td>
		<td colspan="2">SIRB Expiry:</td>
		<td colspan="4">{{ isset($sb) ? $sb->expiry_date ? $sb->expiry_date->format("d-M-Y") : "" : "" }}</td>
		<td></td>
	</tr>

	<tr><td colspan="18"></td></tr>

	<tr>
		<td colspan="3">Requested by:</td>
		<td colspan="2"></td>
		<td colspan="4">Endorsed by:</td>
		<td colspan="3"></td>
		<td colspan="6">Approved by:</td>
	</tr>

	<tr>
		<td colspan="3">
			{{ auth()->user()->gender == "Female" ? "Ms." : "Mr." }} {{ ucfirst(strtolower(auth()->user()->fname)) }} {{ ucfirst(strtolower(auth()->user()->lname)) }}
		</td>
		<td colspan="2"></td>
		<td colspan="4">
			@if($data->user->fleet == "Fleet B")
				Mr. Adulf Kit Jumawan
			@elseif($data->user->fleet == "FLEET C")
				Ms. Shirley Erasquin
			@elseif($data->user->fleet == "FLEET D")
				Ms. Thea Mae G. Rio
			@elseif($data->user->fleet == "FISHING")
				Mr. Ricardo Amparo
			@elseif($data->user->fleet == "TOEI")
				Mr. Leonil Luis F. Romano
			@endif
		</td>
		<td colspan="3"></td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="3">Crewing Officer:</td>
		<td colspan="2"></td>
		<td colspan="4">Crewing Manager:</td>
		<td colspan="3"></td>
		<td colspan="6">CE Romano A. Mariano / President:</td>
	</tr>
</table>