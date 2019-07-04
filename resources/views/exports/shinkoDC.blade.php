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
			<td colspan="3">
				{{ isset($applicant->vessel) ? $applicant->vessel->name : 'N/A' }}
			</td>

			<td colspan="2">
				FLAG
			</td>
			<td colspan="2">
				{{ isset($applicant->vessel) ? $applicant->vessel->flag : 'N/A' }}
			</td>

			<td colspan="2">
				TYPE
			</td>
			<td colspan="3">
				{{ isset($applicant->vessel) ? $applicant->vessel->type : 'N/A' }}
			</td>
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
			<td colspan="2">
				{{ isset($applicant->rank) ? $applicant->rank->name : 'N/A' }}
			</td>

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
			<td colspan="2">
				{{ now()->format('M j, Y') }}
			</td>

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
				{{ isset($applicant->document_id->{"SEAMAN'S BOOK"}) ? $applicant->document_id->{"SEAMAN'S BOOK"}->number : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_id->{"SEAMAN'S BOOK"}) ? $applicant->document_id->{"SEAMAN'S BOOK"}->issue_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_id->{"SEAMAN'S BOOK"}) ? $applicant->document_id->{"SEAMAN'S BOOK"}->expiry_date->format('F j, Y') : "N/A" }}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				NATIONAL LICENSE
			</td>

			@php
				$docu = isset($applicant->document_lc->{'COC'}) ? $applicant->document_lc->{'COC'} : false;
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->no : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				FLAG STATE SEAMAN BOOK (I.D BOOK)
			</td>

			@php
				$docu = false;
				foreach($applicant->document_flag as $document){
				    if($document->country == "Panama" && $document->type == "Booklet"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				FLAG STATE S.Q. FOR TANKERS
			</td>

			<td colspan="2"></td>
			<td colspan="2"></td>
			<td colspan="2"></td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				FLAG STATE LICENSE
			</td>

			@php
				$docu = false;
				foreach($applicant->document_flag as $document){
				    if($document->country == "Panama" && $document->type == "License"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">{{ $docu ? $docu->number : "N/A"}}</td>
			<td colspan="2">{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}</td>
			<td colspan="2">{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				FLAG STATE SSO LICENSE
			</td>

			@php
				$docu = false;
				foreach($applicant->document_flag as $document){
				    if($document->country == "Panama" && $document->type == "SSO"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">{{ $docu ? $docu->number : "N/A"}}</td>
			<td colspan="2">{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}</td>
			<td colspan="2">{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				FLAG STATE ENDORSEMENT COOK COURSE
			</td>

			@php
				$docu = false;
				foreach($applicant->document_flag as $document){
				    if($document->country == "Panama" && $document->type == "SHIP'S COOK ENDORSEMENT"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">{{ $docu ? $docu->number : "N/A"}}</td>
			<td colspan="2">{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}</td>
			<td colspan="2">{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				MEDICAL CERTIFICATE
			</td>

			@php
				$docu = false;
				foreach($applicant->document_flag as $document){
				    if($document->country == "Panama" && $document->type == "MEDICAL CERTIFICATE"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">{{ $docu ? $docu->number : "N/A"}}</td>
			<td colspan="2">{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}</td>
			<td colspan="2">{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				PASSPORT
			</td>

			@php $doc = "PASSPORT"; @endphp

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
				NATIONAL STCW-WATCH KEEPING
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
					$regulation = json_decode($document->regulation);
					$size = sizeof($regulation);
					$haystack = ["II/4", "III/4"];

				    if($document->type == "COC" && $size == 1 && in_array($regulation[0], $haystack)){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">{{ $docu ? $docu->number : "N/A"}}</td>
			<td colspan="2">{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}</td>
			<td colspan="2">{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				
			</td>

			<td colspan="2"></td>
			<td colspan="2"></td>
			<td colspan="2"></td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				
			</td>

			<td colspan="2"></td>
			<td colspan="2"></td>
			<td colspan="2"></td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				NATIONAL GMDSS-GOC
			</td>

			@php $doc = "GOC"; @endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->no : "N/A" }}
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

			@php
				$docu = false;
				foreach($applicant->document_flag as $document){
				    if(in_array($document->country, ["Panama", "Marshall Islands"]) && $document->type == "GOC"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$doc}) ? $applicant->document_lc->{$doc}->no : "N/A" }}
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

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "RADAR TRAINING COURSE"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				ARPA TRAINING COURSE
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "ARPA TRAINING COURSE"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY COURSE, BASIC
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "BASIC TRAINING - BT"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY COURSE, SURVIVAL CRAFT
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY COURSE, FIRE FIGHTING
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "ADVANCE FIRE FIGHTING - AFF"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY COURSE, FIRST AID
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "MEDICAL FIRST AID - MEFA"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY COURSE, RESCUE BOAT
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "FAST RESCUE BOAT - FRB"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				TANKER COURSE, FAMILIARIZATION
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "TANKER COURSE, FAMILIARIZATION"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="3" rowspan="3">
				TANKER COURSE, ADVANCED
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "TANKER COURSE, ADVANCED - OIL"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">OIL</td>
			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="2">CHEMICAL</td>
			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "TANKER COURSE, ADVANCED - LPG"){
				        $docu = $document;
				    }
				}
			@endphp

		<tr>
			<td colspan="2">LPG</td>
			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				VACCINATION - Y. FEVER
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "YELLOW FEVER"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3">
				{{ $docu ? $docu->issuer : "N/A"}}
			</td>
		</tr>

		<tr>
			<td colspan="5">
				DRUG AND ALCOHOL TEST
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "DRUG AND ALCOHOL TEST"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2"></td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3">
				{{ $docu ? $docu->issuer : "N/A"}}
			</td>
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

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "DANGEROUS FLUID CARGO COURSE"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY OFFICER'S TRAINING COURSE
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "SAFETY OFFICER'S TRAINING COURSE"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				MEDICAL CARE COURSE
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "MEDICAL CARE - MECA"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				SHIP HANDLING SIMULATION
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "SHIP HANDLING SIMULATION"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				POLLUTION PREVENTION COURSE
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "POLLUTION PREVENTION COURSE"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				ECDIS
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "ECDIS"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				BRIDGE TEAM/RESOURCE MANAGEMENT
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "BRIDGE TEAM/RESOURCE MANAGEMENT"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				RISK ASSESSMENT/INCIDENT INVESTIGATION COURSE
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "RISK ASSESMENT/INCIDENT INVESTIGATION COURSE"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				ISM COURSE
			</td>

			@php
				$docu = false;
				foreach($applicant->document_lc as $document){
				    if($document->type == "IN HOUSE TRAINING CERT WITH ISM"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->issue_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="2">
				{{ $docu ? $docu->expiry_date->format('F j, Y') : "N/A"}}
			</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="5">
				ISPS / SSO COURSE / SDSD
			</td>

			<td colspan="2">
				
			</td>
			<td colspan="2">
				
			</td>
			<td colspan="2">
				
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