@php
	function checkDate2($date, $type){
		if($date == "NO EXPIRY"){
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
			<td colspan="2">{{ now()->toFormattedDateString() }}</td>
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
			<td colspan="2">(Chinese Character)</td>
		</tr>

		<tr>
			<td>Address:</td>
			<td colspan="8">{{ $applicant->user->address }}</td>
			{{-- <td></td>
			<td colspan="2"></td> --}}
		</tr>

		<tr>
			<td></td>
			<td colspan="4"></td>
			<td>Email:</td>
			<td colspan="3">{{ $applicant->user->email ? $applicant->user->email : '-----' }}</td>
		</tr>

		<tr>
			<td>Birth Date:</td>
			<td>{{ $applicant->user->birthday->format('M j, Y') }}</td>
			<td>Age:</td>
			<td>{{ $applicant->age }}</td>
			<td>Birth Place:</td>
			<td colspan="2">{{ $applicant->birth_place }}</td>
			<td>Nationality:</td>
			<td>FILIPINO</td>
		</tr>

		<tr>
			<td>Civil Status:</td>
			<td colspan="2">{{ $applicant->civil_status }}</td>
			<td>Weight:</td>
			<td>{{ $applicant->weight }}kg</td>
			<td>Height:</td>
			<td>{{ $applicant->height }}cm</td>
			<td>Eye Color:</td>
			<td>Black</td>
		</tr>

		<tr>
			<td>SSS No.:</td>
			<td colspan="2">{{ $applicant->sss ? $applicant->sss : '-----' }}</td>
			<td>Tin:</td>
			<td>{{ $applicant->tin ? $applicant->tin : '-----' }}</td>
			<td>Shoes Size:</td>
			<td>{{ $applicant->shoe_size ? $applicant->shoe_size : '-----' }}cm</td>
			<td>Clothes Size:</td>
			<td>{{ $applicant->clothes_size ? $applicant->clothes_size : '-----' }}</td>
		</tr>

		<tr>
			<td colspan="3">Crew's physical condition</td>
			<td>NORMAL</td>
			<td>Diabetes</td>

			@php
				$name = 'DIABETES';
				$docu = isset($applicant->document_med->{$name}) ? $applicant->document_med->{$name} : false;
			@endphp

			<td>{{ !$docu ? 'YES' : 'NO' }}</td>
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

			if(sizeof($applicant->family_data)){
				$realFam = $applicant->family_data->first();
				$hasWife = false;

				foreach($applicant->family_data as $fam){
					if($fam->type == "Beneficiary"){
						$hasWife = true;
						$realFam = $fam;
						break;
					}
				}
			}
		@endphp

		<tr>
			<td colspan="5">Name and address of Wife / Nearest Relative</td>
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
			<td colspan="2"></td>
		</tr>

		<tr>
			<td></td>
			<td colspan="2">(Surname)</td>
			<td colspan="2">(Given Name)</td>
			<td colspan="2">(Middle Name)</td>
			<td colspan="2">(Number of Child)</td>
		</tr>

		<tr>
			<td>Address:</td>
			{{-- <td colspan="8">{{ $realFam ? $realFam->address : "-" }}</td> --}}
			{{-- GUEVARRA SUGGESTED THAT THIS ONE SHOULD JUST BE THE SAME AS THE APPLICANTS ADDRESS --}}
			<td colspan="8">{{ $applicant->user->address }}</td>
		</tr>

		<tr>
			<td></td>
			<td colspan="2"></td>
		</tr>

		<tr>
			<td colspan="5"></td>
			<td>E-mail:</td>
			<td colspan="3">{{ $realFam ? $realFam->email : "-----" }}</td>
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
					<td>{{ explode('-', $data->year)[0] }}</td>
					<td>{{ explode('-', $data->year)[1] }}</td>
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
				National License
				@if(isset($applicant->rank) && $applicant->rank->id >= 9 && $applicant->rank->id <= 21)
					(II/4)
				@endif
			</td>
			<td colspan="2"></td>
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
			<td colspan="2">Flag License</td> 
			<td colspan="2"></td>
			<td>{{ $docu ? $docu->number : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			{{-- <td colspan="2">{{ $docu ? "Panama" : "-" }}</td> --}}
			<td colspan="2">PANAMA</td>
		</tr>

		{{-- @php 
			$docu = false;
			foreach($applicant->document_flag as $document){
			    if($document->country == "Marshall Islands" && $document->type == "GMDSS/GOC"){
			        $docu = $document;
			    }
			}
		@endphp --}}

		{{-- <tr>
			<td colspan="2">Flag GOC</td>
			<td colspan="2"></td>
			<td>{{ $docu? $docu->number : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? "Marshall Islands" : "-" }}</td>
		</tr> --}}

		<tr>
			<td colspan="2"></td>
			<td colspan="2"></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="2"></td>
		</tr>

		{{-- @php 
			$docu = false;
			foreach($applicant->document_flag as $document){
			    if($document->country == "Panama" && $document->type == "SSO"){
			        $docu = $document;
			    }
			}
		@endphp

		<tr>
			<td colspan="2">Flag SSO</td>
			<td colspan="2"></td>
			<td>{{ $docu ? $docu->number : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">PANAMA</td>
		</tr> --}}

		<tr>
			<td colspan="2"></td>
			<td colspan="2"></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="2"></td>
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
			<td colspan="2">{{ isset($applicant->rank) ? $applicant->rank->abbr : '-----' }}</td>
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
			<td colspan="2">{{ isset($applicant->rank) ? $applicant->rank->abbr : '-----' }}</td>
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
			<td colspan="2">National Seaman's Book</td>
			<td colspan="2">{{ isset($applicant->rank) ? $applicant->rank->abbr : '-----' }}</td>
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
			<td colspan="2">Seaman's Book/Panama</td>
			<td colspan="2">{{ isset($applicant->rank) ? $applicant->rank->abbr : '-----' }}</td>
			<td>{{ $docu ? $docu->number : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">PANAMA</td>
		</tr>
		
		{{-- 5TH --}}
		@php 
			$name = "MCV";
			$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
		@endphp

		<tr>
			<td colspan="2">AUSTRALIA MCV</td>
			<td colspan="2">{{ isset($applicant->rank) ? $applicant->rank->abbr : '-----' }}</td>
			<td>{{ $docu ? $docu->number : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">AU-EMBASSY</td>
		</tr>
		
		{{-- 6TH --}}
		@php 
			$name = "JAPANESE VISA";
			$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
		@endphp

		<tr>
			<td colspan="2">Japanese Visa</td>
			<td colspan="2">{{ isset($applicant->rank) ? $applicant->rank->abbr : '-----' }}</td>
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
				
				if($applicant->rank >= 9 && $applicant->rank <= 14){
					array_push($haystack, "II/4");
				}
				elseif($applicant->rank >= 15 && $applicant->rank <= 21){
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
			$name = 'COC';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">
				Endorsement Certificate /
				@if(isset($applicant->rank) && $applicant->rank->id >= 1 && $applicant->rank->id <= 8)
					COE
				@else
					COC
				@endif
			</td>
			<td>{{ $docu ? $docu->no : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
		</tr>

		@if(isset($applicant->rank) && $applicant->rank->id >=5 && $applicant->rank->id <= 8)
			{{-- 11TH --}}
			@php 
				$name = 'ERS WITH ERM';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<tr>
				<td colspan="4">ERS WITH ERM</td>
				<td>{{ $docu ? $docu->no : "-----"}}</td>
				<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
				<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
				<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
			</tr>

			{{-- 12TH --}}
			@php 
				$name = 'ERS';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<tr>
				<td colspan="4">ERS</td>
				<td>{{ $docu ? $docu->no : "-----"}}</td>
				<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
				<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
				<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
			</tr>

			{{-- 13TH --}}
			@php 
				$name = 'ERM';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<tr>
				<td colspan="4">ERM</td>
				<td>{{ $docu ? $docu->no : "-----"}}</td>
				<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
				<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
				<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
			</tr>

			{{-- 14TH --}}
			<tr>
				<td colspan="4"></td><td></td><td></td><td></td><td colspan="2"></td>
			</tr>

			{{-- 15TH --}}
			<tr>
				<td colspan="4"></td><td></td><td></td><td></td><td colspan="2"></td>
			</tr>
		@else
			{{-- 11TH --}}
			@php 
				$name = 'ECDIS JRC 701B';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<tr>
				<td colspan="4">JRC ECDIS SPECIFIC 1</td>
				{{-- <td>{{ $docu ? $docu->no : "-----"}}</td> --}}
				<td>JAN-701B/901B/2000</td>
				<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
				<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
				<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
			</tr>

			{{-- 12TH --}}
			@php 
				$name = 'ECDIS JRC 9201';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<tr>
				<td colspan="4">JRC ECDIS SPECIFIC 2</td>
				{{-- <td>{{ $docu ? $docu->no : "-----"}}</td> --}}
				<td>JAN-9201/7201</td>
				<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
				<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
				<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
			</tr>

			{{-- 13TH --}}
			@php 
				$name = 'ECDIS FURUNO 2107';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<tr>
				<td colspan="4">FURUNO ECDIS FEA</td>
				{{-- <td>{{ $docu ? $docu->no : "-----"}}</td> --}}
				<td>FEA-2107/FEA-2807</td>
				<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
				<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
				<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
			</tr>

			{{-- 14TH --}}
			@php 
				$name = 'ECDIS FURUNO 3300';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<tr>
				<td colspan="4">FURUNO ECDIS FMD</td>
				{{-- <td>{{ $docu ? $docu->no : "-----"}}</td> --}}
				<td>FMD-3300</td>
				<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
				<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
				<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
			</tr>

			{{-- 15TH --}}
			@php 
				$name = 'ECDIS';
				$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
			@endphp

			<tr>
				<td colspan="4">ECDIS GENERIC</td>
				<td>{{ $docu ? $docu->no : "-----"}}</td>
				<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
				<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
				<td colspan="2">{{ $docu ? $docu->issuer : "-----" }}</td>
			</tr>
		@endif
	
		<tr>
			<td colspan="4">5. PHYSICAL INSPECTION/YELLOW CARD</td>
		</tr>

		<tr>
			<td colspan="4">CERTIFICATE</td>
			<td>Experience of Measles, Chicken Pox</td>
			<td>With Vaccine</td>
			<td>Date Issued</td>
			<td>Expiry Date</td>
			<td>Issued By</td>
		</tr>

		@php 
			$name = 'MEDICAL CERTIFICATE';
			$docu = isset($applicant->document_med_cert->{$name}) ? $applicant->document_med_cert->{$name} : false;
		@endphp

		<tr>	
			<td colspan="4">PHYSICAL INSPECTION</td>
			<td>{{ $docu ? "YES" : "NO"}}</td>
			<td>{{ $docu ? $docu->no : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
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
			<td colspan="9">4) For Engine Officers / Rating indicate Gross Tonnage and Engine Type (example:SULZER 7RTA62) with Horsepower.</td>
		</tr>

		<tr>
			<td colspan="2">Vessel's Name</td>
			<td>Type</td>
			<td>Gross Tonnage</td>
			<td>Service Area</td>
			<td>Manning</td>
			<td>Sign On</td>
			<td colspan="2">Reason Sign-Off/Notes</td>
		</tr>

		<tr>
			<td colspan="2">Flag</td>
			<td>Rank</td>
			<td colspan="2">Engine Type / Power</td>
			<td>Manager</td>
			<td>Sign Off</td>
			<td>Period(Y-M-D)</td>
			<td>SMC</td>
		</tr>

		@foreach($applicant->sea_service as $data)
			<tr>
				<td colspan="2">{{ $data->vessel_name }}</td>
				<td>{{ $data->vessel_type }}</td>
				<td>{{ $data->gross_tonnage }}</td>
				<td>{{ $data->trade }}</td>
				<td>{{ $data->manning_agent }}</td>
				<td>{{ $data->sign_on != "" ? $data->sign_on->format('M j, Y') : "-----" }}</td>
				<td colspan="2">{{ $data->remarks }}</td>
			</tr>
			<tr>
				<td colspan="2">{{ $data->flag }}</td>
				<td>{{ $applicant->ranks[$data->rank] }}</td>
				<td colspan="2">{{ $data->engine_type }} / {{ $data->bhp_kw }}</td>
				<td>{{ $data->principal }}</td>
				<td>{{ $data->sign_off != "" ? $data->sign_off->format('M j, Y') : "-----" }}</td>
				<td colspan="2">
					@if($data->sign_on != "" && $data->sign_off != "")
						{{ $data->sign_on->diff($data->sign_off)->format('%yyr, %mmos, %ddays') }}
					@else
						Not enough data
					@endif
				</td>
			</tr>
		@endforeach
		
		<tr></tr>

		<tr>
			<td colspan="2">Crew's Name:</td>
			<td colspan="3">{{ $applicant->user->lname . ', ' . $applicant->user->fname . ' ' . $applicant->user->suffix . ' ' . $applicant->user->lname }}</td>
			<td>Presenter:</td>
			<td colspan="3">NEIL ROMANO / CREWING MANAGER</td>
		</tr>
	</tbody>
</table>
