@php
	function checkDate2($date){
		if($date == "NO EXPIRY"){
			return $date;
		}
		elseif($date == "" || $date == null){
			return 'NO EXPIRY';
		}
		else{
			return $date->format('F j, Y');
		}
	}
@endphp

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
				{{ isset($applicant->vessel) ? $applicant->vessel->name : 'TBA' }}
			</td>

			<td colspan="2">
				FLAG
			</td>
			<td colspan="2">
				{{ isset($applicant->vessel) ? $applicant->vessel->flag : 'TBA' }}
			</td>

			<td colspan="2">
				TYPE
			</td>
			<td colspan="3">
				{{ isset($applicant->vessel) ? $applicant->vessel->type : 'TBA' }}
			</td>
		</tr>

		<!-- 2nd Row -->
		<tr>
			<td colspan="2">
				SEAMAN'S NAME
			</td>
			<td colspan="3">
				{{ $applicant->user->lname . ', ' . $applicant->user->fname . ' ' . $applicant->user->suffix . ' ' . $applicant->user->mname[0] }}
			</td>

			<td colspan="2">
				RANK
			</td>
			<td colspan="2">
				{{ isset($applicant->rank) ? $applicant->rank->name : 'TBA' }}
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

			@php
				$docu = isset($applicant->document_id->{"SEAMAN'S BOOK"}) ? $applicant->document_id->{"SEAMAN'S BOOK"} : false;
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->number : "-----"}}
			</td>
			<td colspan="2">
				{{ $docu ? checkDate2($docu->issue_date) : "-----"}}
			</td>
			<td colspan="2">
				{{ $docu ? checkDate2($docu->expiry_date) : "-----"}}
			</td>
			<td colspan="3">
				{{ $docu ? $docu->issuer : "NOT APPLICABLE"}}
			</td>
		</tr>

		<tr>
			<td colspan="5">
				NATIONAL LICENSE
			</td>

			@php 
				$name = 'COC';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
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
				{{ $docu ? $docu->number : "-----"}}
			</td>
			<td colspan="2">
				{{ $docu ? checkDate2($docu->issue_date) : "-----"}}
			</td>
			<td colspan="2">
				{{ $docu ? checkDate2($docu->expiry_date) : "-----"}}
			</td>
			<td colspan="3">
				{{ $docu ? $docu->issuer : "NOT APPLICABLE"}}
			</td>
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

			<td colspan="2">{{ $docu ? $docu->number : "-----"}}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----"}}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----"}}</td>
			<td colspan="3">
				{{ $docu ? $docu->issuer : "NOT APPLICABLE"}}
			</td>
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

			<td colspan="2">{{ $docu ? $docu->number : "-----"}}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----"}}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----"}}</td>
			<td colspan="3">
				{{ $docu ? $docu->issuer : "NOT APPLICABLE"}}
			</td>
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

			<td colspan="2">{{ $docu ? $docu->number : "-----"}}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----"}}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----"}}</td>
			<td colspan="3">
				{{ $docu ? $docu->issuer : "NOT APPLICABLE"}}
			</td>
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

			<td colspan="2">{{ $docu ? $docu->number : "-----"}}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----"}}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----"}}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE"}}</td>
		</tr>

		<tr>
			<td colspan="5">
				PASSPORT
			</td>

			@php 
				$name = 'PASSPORT';
				$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->number : "-----"}}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----"}}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----"}}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE"}}</td>
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

			<td colspan="2">{{ $docu ? $docu->no : "-----"}}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----"}}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----"}}</td>
			<td colspan="3">
				{{ $docu ? $docu->issuer : "NOT APPLICABLE"}}
			</td>
		</tr>

		<tr>
			<td colspan="5">
				NATIONAL LICENSE - COC
			</td>

			@php 
				$name = 'COC';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				NATIONAL LICENSE - COE
			</td>

			@php 
				$name = 'COE';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				NATIONAL GMDSS-GOC
			</td>

			@php 
				$name = 'GMDSS/GOC';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				FLAG STATE GMDSS-GOC
			</td>

			@php
				$docu = false;
				foreach($applicant->document_flag as $document){
				    if(in_array($document->country, ["Panama", "Marshall Islands"]) && $document->type == "GMDSS/GOC"){
				        $docu = $document;
				    }
				}
			@endphp

			<td colspan="2">
				{{ isset($applicant->document_lc->{$docu}) ? $applicant->document_lc->{$docu}->no : "-----" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$docu}) ? $applicant->document_lc->{$docu}->issue_date->format('F j, Y') : "-----" }}
			</td>
			<td colspan="2">
				{{ isset($applicant->document_lc->{$docu}) ? $applicant->document_lc->{$docu}->expiry_date->format('F j, Y') : "-----" }}
			</td>
			<td colspan="3">
				{{ $docu ? $docu->issuer : "NOT APPLICABLE"}}
			</td>
		</tr>

		<tr>
			<td colspan="5">
				RADAR TRAINING COURSE
			</td>

			@php 
				$name = 'RADAR TRAINING COURSE';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				ARPA TRAINING COURSE
			</td>

			@php 
				$name = 'ARPA TRAINING COURSE';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY COURSE, BASIC
			</td>

			@php 
				$name = 'BASIC TRAINING - BT';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp



			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY COURSE, SURVIVAL CRAFT
			</td>

			@php 
				$name = 'PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY COURSE, FIRE FIGHTING
			</td>

			@php 
				$name = 'ADVANCE FIRE FIGHTING - AFF';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY COURSE, FIRST AID
			</td>

			@php 
				$name = 'MEDICAL FIRST AID - MEFA';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY COURSE, RESCUE BOAT
			</td>

			@php 
				$name = 'FAST RESCUE BOAT - FRB';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				TANKER COURSE, FAMILIARIZATION
			</td>

			@php 
				$name = 'TANKER COURSE, FAMILIARIZATION';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="3" rowspan="3">
				TANKER COURSE, ADVANCED
			</td>

			@php 
				$name = 'TANKER COURSE, ADVANCED - OIL';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">OIL</td>
			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			@php 
				$name = 'TANKER COURSE, ADVANCED - CHEMICAL';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">CHEMICAL</td>
			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			@php 
				$name = 'TANKER COURSE, ADVANCED - LPG';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">LPG</td>
			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				VACCINATION - Y. FEVER
			</td>

			@php 
				$name = 'YELLOW FEVER';
				$docu = isset($applicant->document_med_certs->{$name}) ? $applicant->document_med_certs->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->number : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				DRUG AND ALCOHOL TEST
			</td>

			@php 
				$name = 'DRUG AND ALCOHOL TEST';
				$docu = isset($applicant->document_med_certs->{$name}) ? $applicant->document_med_certs->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->number : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				U.S.A VISA
			</td>

			@php 
				$name = 'US-VISA';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->number : "-----"}}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----"}}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----"}}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE"}}</td>
		</tr>

		<tr>
			<td colspan="5">
				DANGEROUS FLUID CARGO COURSE
			</td>

			@php 
				$name = 'DANGEROUS FLUID CARGO COURSE';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				SAFETY OFFICER'S TRAINING COURSE
			</td>

			@php 
				$name = "SAFETY OFFICER'S TRAINING COURSE";
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				MEDICAL CARE COURSE
			</td>

			@php 
				$name = "MEDICAL CARE - MECA";
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				SHIP HANDLING SIMULATION
			</td>

			@php 
				$name = "SHIP HANDLING SIMULATION";
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				POLLUTION PREVENTION COURSE
			</td>

			@php 
				$name = "POLLUTION PREVENTION COURSE";
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				ECDIS
			</td>

			@php 
				$name = "ECDIS";
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				BRIDGE TEAM/RESOURCE MANAGEMENT
			</td>

			@php 
				$name = "BRIDGE TEAM/RESOURCE MANAGEMENT";
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				RISK ASSESSMENT/INCIDENT INVESTIGATION COURSE
			</td>

			@php 
				$name = "RISK ASSESMENT/INCIDENT INVESTIGATION COURSE";
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				ISM COURSE
			</td>

			@php 
				$name = "IN HOUSE TRAINING CERT WITH ISM";
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? $docu->no : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->issue_date) : "-----" }}</td>
			<td colspan="2">{{ $docu ? checkDate2($docu->expiry_date) : "-----" }}</td>
			<td colspan="3">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="5">
				ISPS / SSO COURSE / SDSD
			</td>

			@php
				$docu = false;
				if(isset($applicant->rank)){
					if($applicant->rank->type == "OFFICER"){
						foreach($applicant->document_lc as $document){
						    if($document->type == "SHIP SECURITY OFFICER - SSO"){
						        $docu = $document;
						    }
						}
					}
					else{
						foreach($applicant->document_lc as $document){
						    if($document->type == "SHIP SECURITY AWARENESS TRAINING AND SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD"){
						        $docu = $document;
						    }
						}
					}
				}
			@endphp

			<td colspan="2">
				{{ $docu ? $docu->no : "-----"}}
			</td>
			<td colspan="2">
				{{ $docu ? checkDate2($docu->issue_date) : "-----"}}
			</td>
			<td colspan="2">
				{{ $docu ? checkDate2($docu->expiry_date) : "-----"}}
			</td>
			<td colspan="3">
				{{ $docu ? $docu->issuer : "NOT APPLICABLE"}}
			</td>
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