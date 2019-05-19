<table>
	<tbody>
		<!-- HEADER -->
		<tr>
			<td colspan="14">
				DOCUMENT CHECK LIST
			</td>
		</tr>
		<tr>
			<td colspan="14"></td>
		</tr>

		<!-- MAIN -->

		<!-- 1st Row -->
		<tr>
			<td colspan="2">
				VESSEL NAME
			</td>
			<td colspan="3"></td>

			<td colspan="2">
				FLAG
			</td>
			<td colspan="2"></td>

			<td colspan="2">
				TYPE
			</td>
			<td colspan="3"></td>
		</tr>

		<!-- 2nd Row -->
		<tr>
			<td colspan="2">
				SEAMAN'S NAME
			</td>
			<td colspan="3">
				{{ $applicant->user->fname . ' ' . $applicant->user->mname . ' ' . $applicant->user->lname }}
			</td>

			<td colspan="2">
				RANK
			</td>
			<td colspan="2"></td>

			<td colspan="2">
				NATIONALITY
			</td>
			<td colspan="3">
				FILIPINO
			</td>
		</tr>

		<!-- 3rd Row -->
		<tr>
			<td colspan="2">
				BIRTH DATE
			</td>
			<td colspan="3">
				{{ $applicant->user->birthday->format('F j, Y') }}
			</td>

			<td colspan="2">
				JOINING DATE
			</td>
			<td colspan="2"></td>

			<td colspan="2">
				SIGN OF VERIFIER
			</td>
			<td colspan="3"></td>
		</tr>

		<!-- 4th Row -->
		<tr>
			<td colspan="5">
				DOCUMENTS
			</td>

			<td colspan="2">
				NUMBER
			</td>
			<td colspan="2">
				ISSUE
			</td>

			<td colspan="2">
				EXPIRY
			</td>
			<td colspan="3">
				REMARK
			</td>
		</tr>

		<!-- 5th Row -->
		<tr>
			<td colspan="5">
				NATIONAL SEAMAN BOOK
			</td>

			<td colspan="2">
				{{ isset($applicant->document_id->{'SEAMANS BOOK'}) ? $applicant->document_id->{'SEAMANS BOOK'}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_id->{'SEAMANS BOOK'}->issue_date) ? $applicant->document_id->{'SEAMANS BOOK'}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_id->{'SEAMANS BOOK'}->expiry_date) ? $applicant->document_id->{'SEAMANS BOOK'}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				NATIONAL LICENSE
			</td>
			<td colspan="2">
				{{ isset($applicant->document_id->{'NATIONAL LICENSE'}) ? $applicant->document_id->{'NATIONAL LICENSE'}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_id->{'NATIONAL LICENSE'}) ? $applicant->document_id->{'NATIONAL LICENSE'}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_id->{'NATIONAL LICENSE'}) ? $applicant->document_id->{'NATIONAL LICENSE'}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				FLAG STATE SEAMAN BOOK (I.D BOOK)
			</td>

			<td colspan="2">
				{{ isset($applicant->document_flag->{'FLAG STATE SEAMAN BOOK (I.D BOOK)'}) ? $applicant->document_flag->{'FLAG STATE SEAMAN BOOK (I.D BOOK)'}->number : "N/A" }}
			</td>
			<td colspan="2">N/A</td>
			<td colspan="2">N/A</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				FLAG STATE S.Q. FOR TANKERS
			</td>

			<td colspan="2">
				{{ isset($applicant->document_flag->{'FLAG STATE S.Q. FOR TANKERS'}) ? $applicant->document_flag->{'FLAG STATE S.Q. FOR TANKERS'}->number : "N/A" }}
			</td>
			<td colspan="2">N/A</td>
			<td colspan="2">N/A</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				FLAG STATE LICENSE
			</td>

			<td colspan="2">
				{{ isset($applicant->document_flag->{'FLAG STATE LICENSE'}) ? $applicant->document_flag->{'FLAG STATE LICENSE'}->number : "N/A" }}
			</td>
			<td colspan="2">N/A</td>
			<td colspan="2">N/A</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				FLAG STATE SSO LICENSE
			</td>

			<td colspan="2">
				{{ isset($applicant->document_flag->{'FLAG STATE SSO LICENSE'}) ? $applicant->document_flag->{'FLAG STATE SSO LICENSE'}->number : "N/A" }}
			</td>
			<td colspan="2">N/A</td>
			<td colspan="2">N/A</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				FLAG STATE ENDORSEMENT COOK COURSE
			</td>

			<td colspan="2">
				{{ isset($applicant->document_flag->{'FLAG STATE ENDORSEMENT COOK COURSE'}) ? $applicant->document_flag->{'FLAG STATE ENDORSEMENT COOK COURSE'}->number : "N/A" }}
			</td>
			<td colspan="2">N/A</td>
			<td colspan="2">N/A</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				MEDICAL CERTIFICATE
			</td>

			<td colspan="2">
				{{ isset($applicant->document_lc->{'MEDICAL CERTIFICATE'}) ? $applicant->document_lc->{'MEDICAL CERTIFICATE'}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{'MEDICAL CERTIFICATE'}) ? $applicant->document_lc->{'MEDICAL CERTIFICATE'}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{'MEDICAL CERTIFICATE'}) ? $applicant->document_lc->{'MEDICAL CERTIFICATE'}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				PASSPORT
			</td>

			<td colspan="2">
				{{ isset($applicant->document_id->{'PASSPORT'}) ? $applicant->document_id->{'PASSPORT'}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_id->{'PASSPORT'}) ? $applicant->document_id->{'PASSPORT'}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_id->{'PASSPORT'}) ? $applicant->document_id->{'PASSPORT'}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				NATIONAL STCW-WATCH KEEPING
			</td>

			<td colspan="2">
				{{ isset($applicant->document_lc->{'NATIONAL STCW-WATCH KEEPING'}) ? $applicant->document_lc->{'NATIONAL STCW-WATCH KEEPING'}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{'NATIONAL STCW-WATCH KEEPING'}) ? $applicant->document_lc->{'NATIONAL STCW-WATCH KEEPING'}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{'NATIONAL STCW-WATCH KEEPING'}) ? $applicant->document_lc->{'NATIONAL STCW-WATCH KEEPING'}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				N/A
			</td>

			<td colspan="2">N/A</td>
			<td colspan="2">N/A</td>
			<td colspan="2">N/A</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				N/A
			</td>

			<td colspan="2">N/A</td>
			<td colspan="2">N/A</td>
			<td colspan="2">N/A</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				NATIONAL GMDSS-GOC
			</td>

			@php $doc = "NATIONAL GMDSS-GOC"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				FLAG STATE GMDSS-GOC
			</td>

			@php $doc = "FLAG STATE GMDSS-GOC"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				RADAR TRAINING COURSE
			</td>

			@php $doc = "RADAR TRAINING COURSE"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				ARPA TRAINING COURSE
			</td>

			@php $doc = "ARPA TRAINING COURSE"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY COURSE, BASIC
			</td>

			@php $doc = "ASAFETY COURSE, BASIC"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY COURSE, SURVIVAL CRAFT
			</td>
			
			@php $doc = "SAFETY COURSE, SURVIVAL CRAFT"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY COURSE, FIRE FIGHTING
			</td>
			
			@php $doc = "SAFETY COURSE, FIRE FIGHTING"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY COURSE, FIRST AID
			</td>
			
			@php $doc = "SAFETY COURSE, FIRST AID"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY COURSE, RESCUE BOAT
			</td>
			
			@php $doc = "SAFETY COURSE, RESCUE BOAT"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				TANKER COURSE, FAMILIARIZATION
			</td>
			
			@php $doc = "TANKER COURSE, FAMILIARIZATION"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="3" rowspan="3">
				TANKER COURSE, ADVANCED
			</td>
			
			@php $doc = "TANKER COURSE, ADVANCED - OIL"; @endphp

			<td colspan="2">OIL</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>
			
			@php $doc = "STANKER COURSE, ADVANCED - CHEMICAL"; @endphp

		<tr>
			<td colspan="2">CHEMICAL</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>
			
			@php $doc = "STANKER COURSE, ADVANCED - LPG"; @endphp

		<tr>
			<td colspan="2">LPG</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				VACCINATION - Y. FEVER
			</td>
			
			@php $doc = "VACCINATION - Y. FEVER"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				DRUG AND ALCOHOL TEST
			</td>
			
			@php $doc = "DRUG AND ALCOHOL TEST"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				U.S.A VISA
			</td>
			
			@php $doc = "US-VISA"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_id->{$doc}) ? $applicant->document_id->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_id->{$doc}) ? $applicant->document_id->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_id->{$doc}) ? $applicant->document_id->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				DANGEROUS FLUID CARGO COURSE
			</td>
			
			@php $doc = "DANGEROUS FLUID CARGO COURSE"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY OFFICER'S TRAINING COURSE
			</td>
			
			@php $doc = "SAFETY OFFICER'S TRAINING COURSE"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				MEDICAL CARE COURSE
			</td>
			
			@php $doc = "MEDICAL CARE COURSE"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				SHIP HANDLING SIMULATION
			</td>
			
			@php $doc = "SHIP HANDLING SIMULATION"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				POLLUTION PREVENTION COURSE
			</td>
			
			@php $doc = "POLLUTION PREVENTION COURSE"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				ECDIS
			</td>
			
			@php $doc = "ECDIS"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				BRIDGE TEAM/RESOURCE MANAGEMENT
			</td>
			
			@php $doc = "BRIDGE TEAM/RESOURCE MANAGEMENT"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				RISK ASSESSMENT/INCIDENT INVESTIGATION COURSE
			</td>
			
			@php $doc = "RISK ASSESSMENT/INCIDENT INVESTIGATION COURSE"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				ISM COURSE
			</td>
			
			@php $doc = "ISM COURSE"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				ISPS / SSO COURSE / SDSD
			</td>
			
			@php $doc = "ISPS / SSO COURSE / SDSD"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5" rowspan="3">
				AUTHENTICATION FOR LICENSES
				AND CERTIFICATES IF THEY ARE
				TRUTH
			</td>

			<td colspan="4" rowspan="3">
				MEANS OF AUTHENTICATION:
				INTERNET, FAX, PHONE,
				LETTER, PRESENTING TO
				ADMINISTRATION
			</td>
			<td colspan="5" rowspan="3">
				CONFIRMED BY:
			</td>
		</tr>
	</tbody>
</table>