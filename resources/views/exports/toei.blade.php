@php
	function checkDate2($date, $type){
		if($date == "UNLIMITED"){
			return 'UNLIMITED';
		}
		elseif($date == "" || $date == null){
			if($type == "E"){
				return 'UNLIMITED';
			}
			else{
				return '-----';
			}
		}
		else{
			// echo $date->format('F j, Y');
			echo $date->toFormattedDateString();
		}
	}

	if(isset($applicant->rank_id)){
		$rank = $applicant->rank_id;
	}
	else{
		if(isset($applicant->rank)){
			$rank = $applicant->rank->id;
		}
		else{
			$rank = 0;
		}
	}
@endphp

<table>
	<tbody>
		<tr>
			<td colspan="7"></td>
			<td colspan="2">CHECKED BY</td>
		</tr>

		<tr>
			<td colspan="2" rowspan="8"></td>
			<td></td>
			<td colspan="3">BIO-DATA</td>
			<td></td>
			<td></td>
			<td>INCHARGE</td>
		</tr>

		<tr>
			<td colspan="5"></td>
			<td rowspan="3"></td>
			<td rowspan="3"></td>
		</tr>

		<tr>
			<td colspan="5"></td>
		</tr>

		<tr>
			<td colspan="5"></td>
		</tr>

		<tr>
			<td colspan="7"></td>
		</tr>

		<tr>
			<td colspan="2">Manning Agent:</td>
			<td colspan="2">TOEI</td>
			<td>Presenter:</td>
			<td colspan="2">SOLPIA</td>
		</tr>

		<tr>
			<td colspan="7"></td>
		</tr>

		<tr>
			<td colspan="4"></td>
			<td>Date:</td>
			<td colspan="2">{{ now()->format('d-M-y') }}</td>
		</tr>	

		<tr>
			<td colspan="9"></td>
		</tr>

		<tr>
			<td>Code No.:</td>
			<td></td>
			<td>Rank:</td>
			<td>{{ isset($applicant->rank) ? $applicant->rank->abbr : '-----' }}</td>
			<td>Date Employed:</td>
			<td></td>
			<td>Vessel:</td>
			<td colspan="2">{{ isset($applicant->vessel) ? $applicant->vessel->name : '-----' }}</td>
		</tr>

		<tr>
			<td>Name</td>
			<td colspan="2">{{ $applicant->user->lname }}</td>
			<td colspan="2">{{ $applicant->user->fname . ' ' . $applicant->user->suffix }}</td>
			<td colspan="2">{{ $applicant->user->mname }}</td>
			<td colspan="2"></td>
		</tr>

		<tr>
			<td></td>
			<td colspan="2">(Surname)</td>
			<td colspan="2">(Given Name)</td>
			<td colspan="2">(Middle Name)</td>
			<td colspan="2"></td>
		</tr>

		<tr>
			<td colspan="9"></td>
		</tr>

		<tr>
			<td>Address:</td>
			<td colspan="5">{{ $applicant->user->address }}</td>
			<td>Telephone:</td>
			<td colspan="2">{{ $applicant->user->contact }}</td>
		</tr>

		<tr>
			<td></td>
			<td colspan="5"></td>
			<td>Email:</td>
			<td colspan="2">{{ $applicant->user->email ? $applicant->user->email : '-----' }}</td>
		</tr>

		<tr>
			<td>Birth Date:</td>
			<td>{{ $applicant->user->birthday->format('d-M-y') }}</td>
			<td>Age:</td>
			<td>{{ $applicant->user->birthday->diffInYears(now()) }}</td>
			<td>Birth Place:</td>
			<td colspan="2">{{ $applicant->birth_place }}</td>
			<td>Nationality:</td>
			<td>FILIPINO</td>
		</tr>

		<tr>
			<td>Civil Status:</td>
			<td colspan="2">{{ $applicant->civil_status }}</td>
			<td>Weight(kg):</td>
			<td>{{ $applicant->weight }}</td>
			<td>Height(cm):</td>
			<td>{{ $applicant->height }}</td>
			{{-- <td>Eye Color:</td>
			<td>Black</td> --}}
		</tr>

		<tr>
			<td>SSS No.:</td>
			<td colspan="2">{{ $applicant->sss ? $applicant->sss : '-----' }}</td>
			<td>BMI:</td>
			<td>{{ $applicant->bmi ? $applicant->bmi : '-----' }}</td>
			<td>Shoe Size(cm):</td>
			<td>{{ $applicant->shoe_size ? $applicant->shoe_size : '-----' }}</td>
			<td>Clothes Size:</td>
			<td>{{ $applicant->clothes_size ? $applicant->clothes_size : '-----' }}</td>
		</tr>

		<tr>
			<td colspan="2">Crew's physical condition</td>
			<td colspan="2">FIT FOR DUTY</td>
			<td>Diabetes</td>

			@php
				$name = 'DIABETES';
				$docu = isset($applicant->document_med->{$name}) ? $applicant->document_med->{$name} : false;
			@endphp

			<td>{{ $docu ? 'YES' : 'NO' }}</td>
			<td></td>
			<td>Choleith</td>
			<td>NO</td>
		</tr>

		<tr>
			<td></td>
			<td colspan="2">High/Low blood pressure</td>
			<td colspan="2">NORMAL</td>
			<td colspan="2">Renal Insufficiency</td>
			<td>NO</td>
			<td></td>
		</tr>

		@php
			$realFam = false;
			$numOfChild = 0;

			if(sizeof($applicant->family_data)){
				$realFam = $applicant->family_data->first();
				$hasWife = false;

				foreach($applicant->family_data as $fam){
					if($fam->type == "Son" || $fam->type == "Daughter"){
						$numOfChild++;
					}

					if($fam->type == "Beneficiary"){
						$hasWife = true;
						$realFam = $fam;
						break;
					}
				}
			}
		@endphp

		<tr>
			<td colspan="2">Spouse/Next of Kin</td>
			<td colspan="3"></td>
			<td>Relation</td>
			<td></td>
			<td>{{ $realFam ? $realFam->type : "-----" }}</td>
			<td></td>
		</tr>

		<tr>
			<td>Name</td>
			{{-- <td colspan="8"></td> --}}
			<td colspan="2">{{ $realFam ? $realFam->lname : "-----" }}</td>
			<td colspan="2">{{ $realFam ? $realFam->fname . ' ' . $realFam->suffix : "-----" }}</td>
			<td colspan="2">{{ $realFam ? $realFam->mname : "-----" }}</td>
			<td rowspan="2">Number of Children</td>
			<td rowspan="2">{{ $numOfChild }}</td>
		</tr>

		<tr>
			<td></td>
			<td colspan="2">(Surname)</td>
			<td colspan="2">(Given Name)</td>
			<td colspan="2">(Middle Name)</td>
		</tr>

		<tr>
			<td>Address:</td>
			{{-- <td colspan="8">{{ $realFam ? $realFam->address : "-" }}</td> --}}
			{{-- GUEVARRA SUGGESTED THAT THIS ONE SHOULD JUST BE THE SAME AS THE APPLICANTS ADDRESS --}}
			<td colspan="5">{{ $applicant->user->address }}</td>
			<td>Telephone:</td>
			<td colspan="2">{{ $applicant->provincial_contact }}</td>
		</tr>

		<tr>
			<td colspan="3">1. EDUCATIONAL ATTAINMENT</td>
		</tr>

		<tr>
			<td colspan="2">Year</td>
			<td colspan="4">School</td>
			<td colspan="3">Course Finished</td>
		</tr>

		@foreach($applicant->educational_background as $data)
			{{-- @if($data->course != "") --}}
				<tr>
					<td colspan="2">{{ explode('-', $data->year)[0] . " - " . explode('-', $data->year)[1] }}</td>
					<td colspan="4">{{ $data->school }}</td>
					<td colspan="3">{{ $data->course }}</td>
				</tr>
			{{-- @endif --}}
		@endforeach

		<tr>
			<td colspan="2">2. LICENSES</td>
		</tr>

		<tr>
			<td colspan="2">LICENSE</td>
			<td colspan="2">RANK</td>
			<td>Number</td>
			<td>Date Issued</td>
			<td>Expiry Date</td>
			<td colspan="2">Issued By</td>
		</tr>

		@php 
			$name = 'COC';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="2">
				National
			</td>
			<td colspan="2">{{ $applicant->rank->name }}</td>
			<td>{{ $docu ? $docu->no : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">MARINA</td>
		</tr>

		@php 
			$docu = false;
			foreach($applicant->document_flag as $document){
			    if($document->country == "Panama" && $document->type == "LICENSE"){
			        $docu = $document;
			    }
			}
		@endphp
	
		<tr>
			<td colspan="2">PANAMA</td> 
			<td colspan="2">{{ $applicant->rank->name }}</td>
			<td>{{ $docu ? $docu->number : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			{{-- <td colspan="2">{{ $docu ? "Panama" : "-" }}</td> --}}
			<td colspan="2">PANAMA</td>
		</tr>

		@php 
			$docu = false;
			foreach($applicant->document_flag as $document){
			    if($document->country == "Panama" && $document->type == "GMDSS/GOC"){
			        $docu = $document;
			    }
			}
		@endphp
	
		<tr>
			<td colspan="2">PANAMA GOC</td> 
			<td colspan="2">{{ $applicant->rank->name }}</td>
			<td>{{ $docu ? $docu->number : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			{{-- <td colspan="2">{{ $docu ? "Panama" : "-" }}</td> --}}
			<td colspan="2">{{ $docu ? '-----' : 'NOT APPLICABLE' }}</td>
		</tr>

		@php 
			$docu = false;
			foreach($applicant->document_flag as $document){
			    if($document->country == "Panama" && $document->type == "SSO"){
			        $docu = $document;
			    }
			}
		@endphp
	
		<tr>
			<td colspan="2">PANAMA SSO</td> 
			<td colspan="2">{{ $applicant->rank->name }}</td>
			<td>{{ $docu ? $docu->number : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			{{-- <td colspan="2">{{ $docu ? "Panama" : "-" }}</td> --}}
			<td colspan="2">{{ $docu ? '-----' : 'NOT APPLICABLE' }}</td>
		</tr>

		@php 
			$docu = false;
			foreach($applicant->document_flag as $document){
			    if($document->country == "Liberia" && $document->type == "LICENSE"){
			        $docu = $document;
			    }
			}
		@endphp
	
		<tr>
			<td colspan="2">LIBERIAN LIC</td> 
			<td colspan="2">{{ $applicant->rank->name }}</td>
			<td>{{ $docu ? $docu->number : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			{{-- <td colspan="2">{{ $docu ? "Panama" : "-" }}</td> --}}
			<td colspan="2">{{ $docu ? '-----' : 'NOT APPLICABLE' }}</td>
		</tr>

		<tr>
			<td colspan="2">3. CERTIFICATE</td>
		</tr>

		<tr>
			<td colspan="2">CERTIFICATE</td>
			<td colspan="2"></td>
			<td>Number</td>
			<td>Date Issued</td>
			<td>Expiry Date</td>
			<td colspan="2">Issued By</td>
		</tr>
		
		{{-- 1ST --}}
		@php 
			$name = "PASSPORT";
			$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
		@endphp

		<tr>
			<td colspan="2">Passport</td>
			<td colspan="2"></td>
			<td>{{ $docu ? $docu->number : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">D.F.A</td>
		</tr>
		
		{{-- 2ND --}}
		@php 
			$name = "US-VISA";
			$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
		@endphp

		<tr>
			<td colspan="2">U.S. C1/D Visa</td>
			<td colspan="2"></td>
			<td>{{ $docu ? $docu->number : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">U.S EMBASSY</td>
		</tr>
		
		{{-- 3RD --}}
		@php 
			$name = "SEAMAN'S BOOK";
			$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
		@endphp

		<tr>
			<td colspan="2">Seaman's Book(National)</td>
			<td colspan="2"></td>
			<td>{{ $docu ? $docu->number : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">MARINA</td>
		</tr>
		
		{{-- 4TH --}}
		@php
			$docu = false;
			foreach($applicant->document_flag as $document){
			    if($document->country == "Panama" && $document->type == "BOOKLET"){
			        $docu = $document;
			    }
			}
		@endphp

		<tr>
			<td colspan="2">Seaman's Book(Panama)</td>
			<td colspan="2">{{ isset($applicant->rank) ? $applicant->rank->name : '-----' }}</td>
			<td>{{ $docu ? $docu->number : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">PANAMA</td>
		</tr>
		
		{{-- 5TH --}}
		@php
			$docu = false;
			foreach($applicant->document_flag as $document){
			    if($document->country == "Liberia" && $document->type == "BOOKLET"){
			        $docu = $document;
			    }
			}
		@endphp

		<tr>
			<td colspan="2">Liberian Book</td>
			<td colspan="2">{{ isset($applicant->rank) ? $applicant->rank->name : '-----' }}</td>
			<td>{{ $docu ? $docu->number : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">PANAMA</td>
		</tr>
		
		{{-- 6TH --}}
		@php 
			$name = "MCV";
			$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
		@endphp

		<tr>
			<td colspan="2">AUS MCV Visa</td>
			<td colspan="2"></td>
			<td>{{ $docu ? $docu->number : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">AU-EMBASSY</td>
		</tr>
		
		{{-- 7TH --}}
		@php 
			$name = "JAPANESE VISA";
			$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
		@endphp

		<tr>
			<td colspan="2">Japanese Visa</td>
			<td colspan="2"></td>
			<td>{{ $docu ? $docu->number : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? 'JP-EMBASSY' : 'NOT APPLICABLE' }}</td>
		</tr>
	
		<tr>
			<td colspan="5">4. OTHER CERTIFICATES (MARINA/SOLAS/MARPOL/OTHERS)</td>
		</tr>

		<tr>
			<td colspan="4">CERTIFICATE</td>
			<td>Number</td>
			<td>Date Issued</td>
			<td>Expiry Date</td>
			<td colspan="2">Issued By</td>
		</tr>

		@php
			unset($name);
			unset($docu);
		@endphp

		{{-- 1ST --}}
		@php 
			$name = 'SHIP SECURITY OFFICER - SSO';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">SSO (Ship Security Officer) Course</td>
			<td>{{ $docu ? $docu->no : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
		</tr>

		{{-- 1ST POINT 5 --}}
		@php 
			$name = 'SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">SSAT with SDSD</td>
			<td>{{ $docu ? $docu->no : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
		</tr>

		{{-- 2ND --}}
		@php
		// FIX. IF DECK RATING. II/4. ELSE IF ENGINE RATING. III/4
		// OK NA
			$docu = false;
			foreach($applicant->document_lc as $document){
				$regulation = json_decode($document->regulation);
				$size = sizeof($regulation);
				// $haystack = ["II/4", "III/4"];
				$haystack = [];
				
				if($rank >= 9 && $rank <= 14){
					array_push($haystack, "II/4");
				}
				elseif($rank >= 15 && $rank <= 21){
					array_push($haystack, "III/4");
				}

			    if($document->type == "COC" && $size == 1 && in_array($regulation[0], $haystack)){
			        $docu = $document;
			    }
			}
		@endphp

		<tr>
			<td colspan="4">Watchkeeping</td>
			<td>{{ $docu ? $docu->no : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
		</tr>

		{{-- 3RD --}}
		@php 
			$name = 'BASIC TRAINING - BT';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">Basic Safety Training Course  w/ PSSR</td>
			<td>{{ $docu ? $docu->no : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
		</tr>

		{{-- 4TH --}}
		@php 
			$name = 'PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">Survival Craft and Rescue Boat</td>
			<td>{{ $docu ? $docu->no : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
		</tr>

		{{-- 5TH --}}
		@php 
			$name = 'ADVANCE FIRE FIGHTING - AFF';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">Advance Fire Fighting Course</td>
			<td>{{ $docu ? $docu->no : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
		</tr>

		{{-- 6TH --}}
		@php 
			$name = 'MEDICAL FIRST AID - MEFA';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">Medical First Aid Course</td>
			<td>{{ $docu ? $docu->no : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
		</tr>

		{{-- 7TH --}}
		@php 
			$name = 'RADAR TRAINING COURSE';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;

			if(!$docu){
				$name = 'RADAR SIMULATOR COURSE';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			}

			if(!$docu){
				$name = 'RADAR OPERATOR PLOTTING AID';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			}
		@endphp

		<tr>
			<td colspan="4">Radar Observer</td>
			<td>{{ $docu ? $docu->no : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
		</tr>

		{{-- 8TH --}}
		@php 
			$name = 'GMDSS/GOC';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">GMDSS (GOC)</td>
			<td>{{ $docu ? $docu->no : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
		</tr>

		{{-- 9TH --}}
		@php 
			$name = 'SATELLITE COMMUNICATION COURSE';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">Satellite Communication Course</td>
			<td>{{ $docu ? $docu->no : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
		</tr>

		{{-- 10TH --}}
		@php 
			$name = 'COE';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">
				Endorsement Certificate / COC
			</td>
			<td>{{ $docu ? $docu->no : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
		</tr>

		@php 
			$name = 'ECDIS';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp
		{{-- ECDISCISM --}}
		<tr>
			<td rowspan="2">ECDIS</td>
			<td colspan="3">Generic</td>
			<td>{{ $docu ? $docu->no : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
		</tr>

		<tr>
			<td colspan="3">Type Specific</td>
			@if(isset($applicant->ecdises[0]))
				@php 
					$name = $applicant->ecdises[0];
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
				@endphp
				<td>{{ $docu ? $docu->no : "REVERTING"}}</td>
				<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
				<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
				<td colspan="2">{{ $docu ? $docu->issuer : "REVERTING" }}</td>
			@else
				<td>-----</td>
				<td>-----</td>
				<td>-----</td>
				<td colspan="2">NOT APPLICABLE</td>
			@endif
		</tr>

		{{-- 11TH --}}
		@php 
			$name = 'HAZMAT';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">HAZMAT</td>
			<td>{{ $docu ? $docu->no : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
		</tr>

		{{-- 12TH --}}
		@php 
			$name = 'CONSOLIDATED MARPOL';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">MARPOL</td>
			<td>{{ $docu ? $docu->no : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
		</tr>

		{{-- 13TH --}}
		@php 
			$name = 'ERS WITH ERM';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;

			if(!isset($docu)){
				$name = 'ERS';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			}
		@endphp

		<tr>
			<td colspan="4">ERS</td>
			<td>{{ $docu ? $docu->no : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
		</tr>
	
		<tr>
			<td colspan="4">5. PHYSICAL INSPECTION/YELLOW CARD</td>
		</tr>

		<tr>
			<td rowspan="2" colspan="4">CERTIFICATE</td>
			<td>Infection History</td>
			<td>Vaccine</td>
			<td>Date Issued</td>
			<td>Expiry Date</td>
			<td>Issued By</td>
		</tr>

		<tr>
			<td>Y/N</td>
			<td>Y/N</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

		@php 
			$name = 'MEDICAL CERTIFICATE';
			$docu = isset($applicant->document_med_cert->{$name}) ? $applicant->document_med_cert->{$name} : false;
		@endphp

		<tr>	
			<td colspan="4">PEME</td>
			<td>-----</td>
			<td>-----</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "REVERTING" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td>{{ $docu ? $docu->clinic : "-----" }}</td>
		</tr>

		@php 
			$name = 'YELLOW FEVER';
			$docu = isset($applicant->document_med_cert->{$name}) ? $applicant->document_med_cert->{$name} : false;
		@endphp

		<tr>	
			<td colspan="4">YELLOW FEVER</td>
			<td>{{ $docu ? "YES" : "NO"}}</td>
			<td>{{ $docu ? $docu->number : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			{{-- <td>{{ $docu ? $docu->clinic : "-----" }}</td> --}}
			<td>QUARANTINE</td>
		</tr>

		@php 
			$name = 'MEASLES';
			$docu = isset($applicant->document_med->{$name}) ? $applicant->document_med->{$name} : false;
		@endphp

		<tr>	
			<td colspan="4">MEASLES, MUMPS, RUBELLA (MMR)</td>
			<td>{{ $docu ? "YES" : "NO"}}</td>
			<td>{{ $docu ? $docu->with_mv : "-----"}}</td>
			<td>-----</td>
			<td>-----</td>
			<td>{{ $docu ? $docu->case_remarks : "-----" }}</td>
		</tr>

		@php 
			$name = 'CHICKEN POX';
			$docu = isset($applicant->document_med->{$name}) ? $applicant->document_med->{$name} : false;
		@endphp

		<tr>	
			<td colspan="4">Chicken Pox</td>
			<td>{{ $docu ? "YES" : "NO"}}</td>
			<td>{{ $docu ? $docu->with_mv : "-----"}}</td>
			<td>-----</td>
			<td>-----</td>
			<td>{{ $docu ? $docu->case_remarks : "-----" }}</td>
		</tr>

		@php 
			$name = 'POLIO VACCINE (IPV)';
			$docu = isset($applicant->document_med->{$name}) ? $applicant->document_med->{$name} : false;
		@endphp

		<tr>	
			<td colspan="4">POLIO VACCINE (IPV)</td>
			<td>{{ $docu ? "YES" : "NO"}}</td>
			<td>{{ $docu ? $docu->number : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td>{{ $docu ? $docu->clinic : "-----" }}</td>
		</tr>

		@php 
			$name = 'COVID-19';
			$docu = isset($applicant->document_med->{$name}) ? $applicant->document_med->{$name} : false;

			$name2 = 'COVID-19 1ST DOSE';
			$docu2 = isset($applicant->document_med_cert->{$name2}) ? $applicant->document_med_cert->{$name2} : false;
		@endphp

		<tr>	
			<td colspan="4">COVID-19 (certificate copy must be attached)</td>
			<td>{{ $docu ? "YES" : "NO"}}</td>
			<td>{{ $docu2 ? $docu2->clinic : "-----"}}</td>
			<td>{{ $docu2 ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu2 ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td>-----</td>
		</tr>

		{{-- end --}}
		<tr>
			<td colspan="4">6. ENGLISH AND JAPANESE LINGUISTICS</td>
		</tr>

		<tr>
			<td colspan="2"></td>
			<td colspan="5">Class</td>
			<td>ENGLISH</td>
			<td>JAPANESE</td>
		</tr>

		@foreach(['READ & WRITE', 'SPEAK & LISTEN'] as $row)
			<tr>
				<td colspan="2">{{ $row }}</td>
				<td>Excellent</td>
				<td>Good</td>
				<td>Acceptable</td>
				<td>Poor</td>
				<td>Unsuitable</td>
				<td></td>
				<td></td>
			</tr>
		@endforeach

		<tr>
			<td colspan="6">7. TRAINING / EXPERIENCE FOR SAFETY MANAGEMENT SYSTEM</td>
		</tr>

		<tr>
			<td colspan="4">Type</td>
			<td>Date</td>
			<td colspan="2">Period</td>
			<td colspan="2">Evaluation</td>
		</tr>

		@foreach(['Training for SMS', 'Experience for SMS'] as $row)
			<tr>
				<td colspan="4">{{ $row }}</td>
				<td></td>
				<td colspan="2"></td>
				<td colspan="2"></td>
			</tr>
		@endforeach

		<tr>
			<td colspan="2">8. ABILITY OF WELDING</td>
		</tr>

		<tr>
			<td colspan="2"></td>
			<td colspan="5">Class</td>
			<td colspan="2">Evaluation</td>
		</tr>

		<tr>
			<td colspan="2">ABILITY</td>
			<td>Excellent</td>
			<td>Good</td>
			<td>Acceptable</td>
			<td>Poor</td>
			<td>Unsuitable</td>
			<td colspan="2"></td>
		</tr>

		<tr>
			<td colspan="2">9. SEAMAN'S HISTORY</td>
		</tr>

		<tr>
			<td>Note:</td>
		</tr>

		<tr>
			<td colspan="9">Sea service (with in the last ten years) listed most recent service last.</td>
		</tr>
		<tr>
			<td colspan="9">1) Indicated wether vessel is M/V (Motor Vessel), S/S (Steam Ship) or S/T (Steam Turbine), etc.</td>
		</tr>
		<tr>
			<td colspan="9">2) Under TYPE indicate wether Bulk, Log, VLCC, Chemical LPG, PCC, Reefer, etc.</td>
		</tr>
		<tr>
			<td colspan="9">3) For Deck Officers / Ratings indicate Gross Tonnage of Vessel</td>
		</tr>
		<tr>
			<td colspan="9">4) For Engine Officers / Rating indicate Gross Tonnage and Engine Type (example:SULZER 7RTA62) with KW.</td>
		</tr>

		<tr>
			<td colspan="2">Vessel's Name</td>
			<td>Type</td>
			<td colspan="2">Gross Tonnage, TEU</td>
			<td>Manning</td>
			<td>Sign On</td>
			<td colspan="2">Reason Sign-Off/Notes</td>
		</tr>

		<tr>
			<td>Flag</td>
			<td>Mixed Crew</td>
			<td>Rank</td>
			<td colspan="2">Engine KW / Service Area</td>
			<td>Manager</td>
			<td>Sign Off</td>
			<td>Period(Y-M-D)</td>
			<td>SMC</td>
		</tr>

		@foreach($applicant->sea_service as $data)
			<tr>
				<td colspan="2">{{ $data->vessel_name }}</td>
				<td>{{ $data->vessel_type }}</td>
				<td colspan="2">{{ $data->gross_tonnage }}</td>
				<td>{{ $data->manning_agent }}</td>
				<td>{{ $data->sign_on != "" ? $data->sign_on->format('M j, Y') : "-----" }}</td>
				<td colspan="2">{{ $data->remarks }}</td>
			</tr>
			<tr>
				<td>{{ $data->flag }}</td>
				<td>
					@if($data->crew_nationality == "FILIPINO" || $data->crew_nationality == "FULL CREW")
						FULL CREW
					@elseif($data->crew_nationality != "")
						MIXED CREW
					@endif
				</td>
				<td>{{ $applicant->ranks[$data->rank] }}</td>
				<td>{{ $data->engine_type }}</td>
				<td>{{ $data->trade }}</td>
				<td>{{ $data->principal }}</td>
				<td>{{ $data->sign_off != "" ? $data->sign_off->format('M j, Y') : "-----" }}</td>
				<td colspan="2">
					@if($data->sign_on != "" && $data->sign_off != "")
						{{ $data->sign_on->diff($data->sign_off->addDay())->format('%yyr, %mmos, %ddays') }}
					@else
						Not enough data
					@endif
				</td>
			</tr>
		@endforeach
		
		<tr></tr>

		<tr>
			<td colspan="2">Crew's Name:</td>
			<td colspan="3">{{ $applicant->user->lname . ', ' . $applicant->user->fname . ' ' . $applicant->user->suffix . ' ' . $applicant->user->mname }}</td>
			<td>Presenter:</td>
			<td colspan="3">NEIL ROMANO / CREWING MANAGER</td>
		</tr>

		<tr>
			<td colspan="2"></td>
			<td colspan="3"></td>
			<td></td>
			<td colspan="3"></td>
		</tr>

	</tbody>
</table>
