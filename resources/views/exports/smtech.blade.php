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
		if(isset($crewRank)){
			$rank = $crewRank->id;
		}
		else{
			$rank = 0;
		}
	}

	// SET CREW RANK
	$crewRank = null;
	if(isset($applicant->vessel)){
		$crewRank = $applicant->rank;
	}
	else{
		if($applicant->document_flag->count()){
			$crewRank = $applicant->ranks2[$applicant->document_flag->first()->rank][0];
		}
		else{
			$crewRank = $applicant->rank;
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
			<td>{{ isset($crewRank) ? $crewRank->abbr : '-----' }}</td>
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
			<td colspan="9"></td>
		</tr>

		<tr>
			<td>Address:</td>
			<td colspan="5">{{ $applicant->user->address }}</td>
			<td></td>
			<td colspan="2"></td>
		</tr>

		<tr>
			<td></td>
			<td colspan="5"></td>
			<td style="color: #0000FF;">Email:</td>
			<td colspan="2">{{ $applicant->user->email ? $applicant->user->email : '-----' }}</td>
		</tr>

		<tr>
			<td>Birth Date:</td>
			<td>{{ $applicant->user->birthday ? $applicant->user->birthday->format('d-M-y') : "" }}</td>
			<td>Age:</td>
			<td>{{ $applicant->user->birthday ? $applicant->user->birthday->diffInYears(now()) : "" }}</td>
			<td>Birth Place:</td>
			<td colspan="2">{{ $applicant->birth_place }}</td>
			<td>Nationality:</td>
			<td>FILIPINO</td>
		</tr>

		<tr>
			<td>Civil Status:</td>
			<td colspan="2">{{ strtoupper($applicant->civil_status) }}</td>
			<td>Weight(kg):</td>
			<td>{{ $applicant->weight }}</td>
			<td>Height(cm):</td>
			<td>{{ $applicant->height }}</td>
			<td>Eye Color:</td>
			<td>{{ $applicant->eye_color }}</td>
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
			<td colspan="2">NORMAL</td>
			<td style="color: #FF0000;">Diabetes</td>

			@php
				$name = 'DIABETES';
				$docu = isset($applicant->document_med->{$name}) ? $applicant->document_med->{$name} : false;
			@endphp

			<td>{{ $docu ? 'CONTROLLED WITH MEDICATION' : 'NO' }}</td>
			<td></td>
			<td style="color: #FF0000;">Choleith</td>
			<td>NO</td>
		</tr>

		<tr>
			<td></td>
			<td colspan="2" style="color: #FF0000;">High/Low blood pressure</td>

			@php
				$name = 'HYPERTENSION';
				$docu = isset($applicant->document_med->{$name}) ? $applicant->document_med->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? 'CONTROLLED WITH MEDICATION' : 'NO' }}</td>
			<td colspan="2" style="color: #FF0000;">Renal Insufficiency</td>
			<td>NO</td>
			<td></td>
		</tr>

		@php
			$nok = null;
			$temps = ['Spouse', 'Son', 'Daughter', 'Father', 'Mother'];
			$childrens = 0;
			foreach($temps as $key => $temp){
				$childrens = 0;
				foreach($applicant->family_data as $fd){
					if($fd->type == "Son" || $fd->type == "Daughter"){
						$childrens++;
					}

					if($fd->type == $temp && $fd->fname != "" && $nok == null){
						$nok = $fd;
						break;
					}
				}
			}
		@endphp

		<tr>
			<td colspan="5">Name and Address of Wife / Nearest Relative</td>
			<td>Relation</td>
			<td colspan="3" style="text-align: center;">{{ $nok ? strtoupper($nok->type) : '-----' }}</td>
		</tr>

		<tr>
			<td>Name</td>
			{{-- <td colspan="8"></td> --}}
			<td colspan="2">{{ $nok ? $nok->lname : "-----" }}</td>
			<td colspan="2">{{ $nok ? $nok->fname . ' ' . $nok->suffix : "-----" }}</td>
			<td colspan="2">{{ $nok ? $nok->mname : "-----" }}</td>
			<td colspan="2">{{ $childrens }}</td>
		</tr>

		<tr>
			<td></td>
			<td colspan="2">(Surname)</td>
			<td colspan="2">(Given Name)</td>
			<td colspan="2">(Middle Name)</td>
			<td colspan="2">Number of Children</td>
		</tr>

		<tr>
			<td>Address:</td>
			{{-- <td colspan="8">{{ $realFam ? $realFam->address : "-" }}</td> --}}
			{{-- GUEVARRA SUGGESTED THAT THIS ONE SHOULD JUST BE THE SAME AS THE APPLICANTS ADDRESS --}}
			<td colspan="5">{{ $applicant->user->address }}</td>
			<td></td>
			<td colspan="2"></td>
		</tr>

		<tr>
			<td style="color: #0000FF;">Email:</td>
			<td colspan="4">{{ $applicant->user->email ? $applicant->user->email : '-----' }}</td>
			<td>Whatsapp ID</td>
			<td colspan="3"></td>
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
					<td colspan="2">{{ explode('-', $data->year)[1] }}</td>
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
			$regs = array();
			// $regs['dr'] = ["II/1", "II/2"];
			// $regs['er'] = ["III/1", "III/2"];
			$regs['dr'] = ["II/4", "II/5", "II/1", "II/2"];
			$regs['er'] = ["III/4", "III/5", "III/1", "III/2"];
			// $regs['dr'] = ["II/2", "II/1", "II/5", "II/4"];
			// $regs['er'] = ["III/2", "III/1", "III/5", "III/4"];

			$hl = null;
			$docu = null;
			$rt = str_starts_with($crewRank->category, "ENGINE") ? "er" : "dr";

			if($crewRank){
				if($crewRank->category == "GALLEY"){
					foreach($applicant->document_lc as $lc){
						if($lc->type == "NCIII"){
							$docu = $lc;
							break;
						}
						elseif($lc->type == "NCI"){
							$docu = $lc;
						}
					}
				}
				else{
					foreach($applicant->document_lc as $lc){
						if(str_starts_with($lc->type, "COC") || str_starts_with($lc->type, "COE")){
							$regulations = json_decode($lc->regulation);

							foreach($regs[$rt] as $key => $ref){
								if(in_array($ref, $regulations)){
									if($hl){
										if($key > $hl){
											$hl = $key;
											$docu = $lc;
											// IF FOR OFFICERS ONLY
											// if($hl >= 2){
											// }
										}
									}
									else{
										$hl = $key;
										$docu = $lc;
										// IF FOR OFFICERS ONLY
										// if($hl >= 2){
										// }
									}
								}
							}
						}
					}
				}
			}

			// HL 0 = DECK; HL 1 = ENGINE
		@endphp

		<tr>
			<td colspan="2" style="color: #FF0000;">
				National License
			</td>
			<td colspan="2">
				@if(isset($crewRank) && $docu)
					@if($hl == 0 && $hl !== null)
						@if($rt == "er")
							ENGINEERING WATCHKEEPING
						@else
							NAVIGATIONAL WATCHKEEPING
						@endif
					@elseif($hl == 1)
						@if($rt == "er")
							ABLE SEAFARER ENGINE
						@else
							ABLE SEAFARER DECK
						@endif
					@elseif($hl == 2)
						@if($rt == "er")
							OIC-ENGINEERING WATCH
						@else
							OIC-NAVIGATIONAL WATCH
						@endif
					@elseif($hl == 3)
						@if($rt == "er")
							@if(str_starts_with(strtoupper($docu->no), "CCE"))
								CHIEF ENGINEER
							@else
								SECOND ENGINEER
							@endif
						@else
							@if(str_starts_with(strtoupper($docu->no), "CMM"))
								MASTER MARINER
							@else
								CHIEF MATE
							@endif
						@endif
				 	{{-- GALLEY --}}
					@elseif($crewRank->id == 24)
						COOK
					@elseif($crewRank->id == 27 || $crewRank->id == 28)
						MESSMAN
					@else
						@php
							$rname = $crewRank->name;
							if($rname == "ENGINE CADET" || $rname == "ENGINE BOY"){
								$rname = "WIPER";
							}
							elseif($rname == "DECK CADET" || $rname == "DECK BOY"){
								$rname = "ORDINARY SEAMAN";
							}
						@endphp
					@endif
				@else
					-----
				@endif
			<td>{{ $docu ? strtoupper($docu->no) : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ (isset($crewRank) && $crewRank->category == "GALLEY") ? $docu->issuer ?? "MARINA" : "MARINA" }}</td>
		</tr>

		@php 
			$docu2 = false;
			if($crewRank->type == "OFFICER"){
				foreach($applicant->document_flag as $document){
				    if($document->country == "Panama" && $document->type == "LICENSE"){
				        $docu2 = $document;
				    }
				}
			}
		@endphp
	
		<tr>
			<td colspan="2" style="color: #FF0000;">Flag License</td> 
			<td colspan="2">
				@if(isset($crewRank) && $docu2)
					@if($hl == 0)
						@if($rt == "er")
							ENGINEERING WATCHKEEPING
						@else
							NAVIGATIONAL WATCHKEEPING
						@endif
					@elseif($hl == 1)
						@if($rt == "er")
							ABLE SEAFARER ENGINE
						@else
							ABLE SEAFARER DECK
						@endif
					@elseif($hl == 2)
						@if($rt == "er")
							OIC-ENGINEERING WATCH
						@else
							OIC-NAVIGATIONAL WATCH
						@endif
					@elseif($hl == 3)
						@if($rt == "er")
							@if(str_starts_with(strtoupper($docu->no), "CCE"))
								CHIEF ENGINEER
							@else
								SECOND ENGINEER
							@endif
						@else
							@if(str_starts_with(strtoupper($docu->no), "CMM"))
								MASTER MARINER
							@else
								CHIEF MATE
							@endif
						@endif
				 	{{-- GALLEY --}}
					@elseif($crewRank->id == 24)
						SHIP'S COOK
					@elseif($crewRank->id == 27 || $crewRank->id == 28)
						STEWARD
					@else
						@php
							$rname = $crewRank->name;
							if($rname == "ENGINE CADET" || $rname == "ENGINE BOY"){
								$rname = "WIPER";
							}
							elseif($rname == "DECK CADET" || $rname == "DECK BOY"){
								$rname = "ORDINARY SEAMAN";
							}
						@endphp
					@endif
				@else
					-----
				@endif
			</td>
			<td>{{ $docu2 ? strtoupper($docu2->number) : "-----" }}</td>
			<td>{{ $docu2 ? checkDate2($docu2->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu2 ? checkDate2($docu2->expiry_date, "E") : "-----" }}</td>
			{{-- <td colspan="2">{{ $docu ? "Panama" : "-" }}</td> --}}
			<td colspan="2">{{ $crewRank->type == "OFFICER" ? "PANAMA" : "NOT APPLICABLE" }}</td>
		</tr>

		@php 
			$docu = false;
			foreach($applicant->document_flag as $document){
			    if($document->country == "Panama" && $document->type == "GMDSS/GOC"){
			        $docu = $document;
			    }
			}
		@endphp

		{{-- {{ dd($applicant->document_flag, $docu->number) }} --}}
	
		<tr>
			<td colspan="2" style="color: #FF0000;">Flag GOC</td> 
			{{-- <td colspan="2">{{ $applicant->rank->name }}</td> --}}
			<td colspan="2">{{ $docu ? "GMDSS GENERAL OPERATOR" : "-----" }}</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">Marshall Is.</td>
			{{-- <td colspan="2">{{ $docu ? 'PANAMA' : 'NOT APPLICABLE' }}</td> --}}
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
			<td colspan="2" style="color: #FF0000;">Flag SSO</td> 
			{{-- <td colspan="2">{{ $applicant->rank->name }}</td> --}}
			<td colspan="2">{{ $docu ? "SHIP SECURITY OFFICER" : "-----" }}</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">Panama</td>
			{{-- <td colspan="2">{{ $docu ? 'PANAMA' : 'NOT APPLICABLE' }}</td> --}}
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
			<td colspan="2" style="color: #FF0000;">Passport</td>
			<td colspan="2">-----</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----"}}</td>
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
			<td colspan="2" style="color: #FF0000;">U.S. C1/D Visa</td>
			<td colspan="2">-----</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ ($docu && strtoupper($docu->number) != "REVERTING") ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">U.S EMBASSY</td>
		</tr>
		
		{{-- 3RD --}}
		@php 
			$name = "SEAMAN'S BOOK";
			$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
		@endphp

		<tr>
			<td colspan="2" style="color: #FF0000;">National Seaman's Book</td>
			<td colspan="2">-----</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">MARINA</td>
		</tr>
		
		{{-- 4TH --}}
		@php 
			$name = "SID";
			$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
		@endphp

		<tr>
			<td colspan="2" style="color: #FF0000;">S.I.D. (ILO C185)</td>
			<td colspan="2">-----</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">MARINA</td>
		</tr>
		
		{{-- 5TH --}}
		@php
			$docu = false;
			foreach($applicant->document_flag as $document){
			    if($document->country == "Panama" && $document->type == "BOOKLET"){
			        $docu = $document;
			    }
			}


			$rname = "";
			if($applicant->document_flag->count()){
				if($applicant->document_flag->first()->rank == 42){
					$rname = "ABLE SEAFARER DECK";
				}
				elseif($applicant->document_flag->first()->rank == 43){
					$rname = "ABLE SEAFARER ENGINE";
				}
				else{
					$rname = $applicant->ranks2[$applicant->document_flag->first()->rank][0]->name;
					if($rname == "ENGINE CADET" || $rname == "ENGINE BOY"){
						$rname = "WIPER";
					}
					elseif($rname == "DECK CADET" || $rname == "DECK BOY"){
						$rname = "ORDINARY SEAMAN";
					}
					elseif($crewRank->id == 24){
						$rname = "SHIP'S COOK";
					}
					elseif($crewRank->id == 27 || $crewRank->id == 28){
						$rname = "STEWARD";
					}
					elseif($crewRank->id == 3 || $crewRank->id == 4){
						$rname = "OIC-NAVIGATIONAL WATCH";
					}
					elseif($crewRank->id == 7 || $crewRank->id == 8){
						$rname = "OIC-ENGINEERING WATCH";
					}

					$rname = $rname == "MASTER" ? "MASTER MARINER" : $rname;
				}
			}
			elseif(isset($crewRank)){
				$rname = $crewRank->name;
				if($rname == "ENGINE CADET" || $rname == "ENGINE BOY"){
					$rname = "WIPER";
				}
				elseif($rname == "DECK CADET" || $rname == "DECK BOY"){
					$rname = "ORDINARY SEAMAN";
				}
				elseif($crewRank->id == 24){
					$rname = "SHIP'S COOK";
				}
				elseif($crewRank->id == 27 || $crewRank->id == 28){
					$rname = "STEWARD";
				}
				elseif($crewRank->id == 3 || $crewRank->id == 4){
					$rname = "OIC-NAVIGATIONAL WATCH";
				}
				elseif($crewRank->id == 7 || $crewRank->id == 8){
					$rname = "OIC-ENGINEERING WATCH";
				}

				$rname = $rname == "MASTER" ? "MASTER MARINER" : $rname;
			}
			else{
				$rname = "-----";
			}

			// dd($applicant->rank);
		@endphp

		<tr>
			<td colspan="2" style="color: #FF0000;">Seaman's Book/Panama</td>
			<td colspan="2">{{ $rname }}</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">PANAMA</td>
		</tr>

		@php 
			$name = "New Zealand eTA";
			$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
		@endphp
		<tr>
			<td colspan="2" style="color: #FF0000;">New Zealand eTA</td>
			<td colspan="2">-----</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----"}}</td>
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
			<td colspan="2" style="color: #FF0000;">Australian MCV</td>
			<td colspan="2">-----</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----"}}</td>
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
			<td colspan="2" style="color: #FF0000;">Japanese Visa</td>
			<td colspan="2">-----</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----"}}</td>
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
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		{{-- ADDL --}}
		{{-- IF RANK IS CO --}}
		@if($applicant->rank->id == 2)
			@php 
				$docu = false;
				foreach($applicant->document_lc as $temp){
					if(str_contains($temp->type, "SAFETY OFFICER")){
						$docu = $temp;
					}
				}
			@endphp

			<tr>
				<td colspan="4">Ship Safety Officer Training Course ( C/O Only )</td>
				<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
				<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
				<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
				<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
			</tr>
		@endif

		{{-- ADDLS --}}
		<tr>
			<td colspan="4">SIMS-Training ( ME/BWMS/EGCS-SCR)</td>
			<td>----</td>
			<td>----</td>
			<td>----</td>
			<td colspan="2">SMS INDIA</td>
		</tr>

		{{-- ADDLS --}}
		<tr>
			<td colspan="4">WORKSHOP</td>
			<td>----</td>
			<td>----</td>
			<td>----</td>
			<td colspan="2">SMTECH</td>
		</tr>

		{{-- ADDLS --}}
		<tr>
			<td colspan="4">SPECIAL BRIEFING</td>
			<td>----</td>
			<td>----</td>
			<td>----</td>
			<td colspan="2">SMTECH</td>
		</tr>

		{{-- 1ST POINT 5 --}}
		@php 
			$name = 'SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		{{-- <tr>
			<td colspan="4">SSAT with SDSD</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr> --}}

		{{-- 2ND --}}
		@php
		// FIX. IF DECK RATING. II/4. ELSE IF ENGINE RATING. III/4
		// OK NA
			// $docu = false;
			// foreach($applicant->document_lc as $document){
			// 	$regulation = json_decode($document->regulation);
			// 	$size = sizeof($regulation);
			// 	// $haystack = ["II/4", "III/4"];
			// 	$haystack = [];
				
			// 	if($rank >= 9 && $rank <= 14){
			// 		array_push($haystack, "II/4");
			// 	}
			// 	elseif($rank >= 15 && $rank <= 21){
			// 		array_push($haystack, "III/4");
			// 	}

			//     if($document->type == "COC" && $size == 1 && in_array($regulation[0], $haystack)){
			//         $docu = $document;
			//     }
			// }

			// DECK/ENGINE WATCH DAW TO
			$names = ["DECK WATCH", "ENGINE WATCH", "WATCHKEEPING", "DECK WATCHKEEPING", "ENGINE WATCHKEEPING"];
			$docu = false;

			foreach($applicant->document_lc as $doc){
				if(in_array($doc->type, $names)){
					$docu = $doc;
					break;
				}
			}
		@endphp

		<tr>
			<td colspan="4">Watchkeeping</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		{{-- 3RD --}}
		@php 
			$name = 'BASIC TRAINING - BT';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">Basic Safety Training Course  w/ PSSR</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		{{-- 4TH --}}
		@php 
			$name = 'PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">Survival Craft and Rescue Boat</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		{{-- 5TH --}}
		@php 
			$name = 'ADVANCE FIRE FIGHTING - AFF';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">Advance Fire Fighting Course</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		{{-- 6TH --}}
		@php 
			$name = 'MEDICAL FIRST AID - MEFA';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">Medical First Aid Course</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
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
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		{{-- 8TH --}}
		@php 
			$name = 'GMDSS/GOC';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">GMDSS (GOC)</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		{{-- 9TH --}}
		@php 
			$name = 'SATELLITE COMMUNICATION COURSE';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		{{-- <tr>
			<td colspan="4">Satellite Communication Course</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr> --}}

		{{-- 10TH --}}
		@php 
			$docu = false;

			if(isset($crewRank)){
				$tempDocu = null;

				foreach($applicant->document_lc as $document){
					$regulation = json_decode($document->regulation);

					if(str_starts_with($document->type, "COE") && (in_array('III/1', $regulations) || in_array('III/2', $regulations) || in_array('II/1', $regulations) || in_array('II/2', $regulations))){
						$docu = $document;
					}
				}

				if(!$docu && $tempDocu){
					$temp = $tempDocu;
				}
			}
		@endphp

		<tr>
			<td colspan="4">
				Endorsement Certificate / COC
			</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		@php 
			$es1 = null;
			$es2 = null;
			$ef1 = null;
			$ef = null;
			$et = null;

			foreach($applicant->document_lc as $doc){
				if(str_contains($doc->type, '701') || str_contains($doc->type, '901') || str_contains($doc->type, '2000')){
					$es1 = $doc;
				}
				elseif(str_contains($doc->type, '7201') || str_contains($doc->type, '9201')){
					$es2 = $doc;
				}
				elseif(str_contains($doc->type, 'FEA') && (str_contains($doc->type, '2107') || str_contains($doc->type, '2807'))){
					$ef1 = $doc;
				}
				elseif(str_contains($doc->type, '3300')){
					$ef = $doc;
				}
				elseif(str_contains($doc->type, 'KEIKI')){
					$et = $doc;
				}
			}

			$docu = $es1;
		@endphp

		{{-- ECDISCISM --}}
		<tr>
			<td colspan="4">ECDIS SPECIFIC 1</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		@php 
			$docu = $es2;
		@endphp
		{{-- ECDISCISM --}}
		<tr>
			<td colspan="4">ECDIS SPECIFIC 2</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		@php 
			$docu = $ef1; //FEA
		@endphp
		{{-- ECDISCISM --}}
		{{-- <tr>
			<td colspan="4">FURUNO ECDIS FEA</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr> --}}

		@php 
			$docu = $ef;
		@endphp
		{{-- ECDISCISM --}}
		<tr>
			<td colspan="4">FURUNO ECDIS FMD</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		@php 
			$docu = $et;
		@endphp
		{{-- ECDISCISM --}}
		<tr>
			<td colspan="4">TOKYO KEIKI</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		@php 
			$name = 'ECDIS';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp
		{{-- ECDISCISM --}}
		<tr>
			<td colspan="4">ECDIS GENERIC</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
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
			<td colspan="4">PHYSICAL INSPECTION (PEME)</td>
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
			<td>-----</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			{{-- <td>{{ $docu ? $docu->clinic : "-----" }}</td> --}}
			<td>BUREAU OF QUARANTINE</td>
		</tr>

		@php 
			$name = 'MEASLES';
			$docu = isset($applicant->document_med->{$name}) ? $applicant->document_med->{$name} : false;
		@endphp

		<tr>	
			<td colspan="4">MEASLES, MUMPS, RUBELLA (MMR)</td>
			<td>YES</td>
			<td>YES</td>
			<td>-----</td>
			<td>-----</td>
			<td>HEALTH CENTER</td>
		</tr>

		@php 
			$name = 'CHICKEN POX';
			$docu = isset($applicant->document_med->{$name}) ? $applicant->document_med->{$name} : false;
		@endphp

		<tr>	
			<td colspan="4">CHICKEN POX</td>
			<td>YES</td>
			<td>YES</td>
			<td>-----</td>
			<td>-----</td>
			<td>HEALTH CENTER</td>
		</tr>

		@php 
			$name = 'POLIO VACCINE (IPV)';
			$docu = isset($applicant->document_med_cert->{$name}) ? $applicant->document_med_cert->{$name} : false;
		@endphp

		<tr>	
			<td colspan="4">POLIO VACCINE (IPV)</td>
			<td>-----</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td>BUREAU OF QUARANTINE</td>
		</tr>
	
		<tr>
			<td colspan="4">6. COVID-19 VACCINATION</td>
		</tr>

		<tr>
			<td colspan="3">CERTIFICATE</td>
			<td></td>
			<td>1st dose</td>
			<td>
				2nd dose
				<br style='mso-data-placement:same-cell;' />
				(if required)
			</td>
			<td>
				3rd dose
				<br style='mso-data-placement:same-cell;' />
				(if required)
			</td>
			<td>
				Cert No.
				<br style='mso-data-placement:same-cell;' />
				(if have)
			</td>
			<td>Issued By</td>
		</tr>

		@php
			$name = 'COVID-19 1ST DOSE';
			$docu = isset($applicant->document_med_cert->{$name}) ? $applicant->document_med_cert->{$name} : false;

			$name2 = 'COVID-19 2ND DOSE';
			$docu2 = isset($applicant->document_med_cert->{$name2}) ? $applicant->document_med_cert->{$name2} : false;

			$name3 = 'COVID-19 3RD DOSE';
			$docu3 = isset($applicant->document_med_cert->{$name3}) ? $applicant->document_med_cert->{$name3} : false;
		@endphp

		<tr>
			<td rowspan="2" colspan="3">COVID-19 VACCINATION CARD</td>
			<td>Maker</td>
			<td>{{ $docu ? $docu->clinic : "-----" }}</td>
			<td>{{ $docu2 ? $docu2->clinic : "-----" }}</td>
			<td>{{ $docu3 ? $docu3->clinic : "-----" }}</td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
		</tr>

		<tr>
			<td>Date</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu2 ? checkDate2($docu2->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu3 ? checkDate2($docu3->issue_date, "I") : "-----" }}</td>
		</tr>

		{{-- end --}}
		<tr>
			<td colspan="4" style="font-weight: bold; text-align: left;">7. ENGLISH AND JAPANESE LINGUISTICS</td>
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
				<td>
					@if(isset($crewRank))
						@if(str_contains($crewRank->category, 'OFFICER'))
							GOOD
						@else
							ACCEPTABLE
						@endif
					@endif
				</td>
				<td></td>
			</tr>
		@endforeach

		<tr>
			<td colspan="6">8. TRAINING / EXPERIENCE FOR SAFETY MANAGEMENT SYSTEM</td>
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
				@if(isset($crewRank))
					@if(str_contains($crewRank->category, 'OFFICER'))
						<td>-</td>
						<td colspan="2">-</td>
						<td colspan="2">
							@if($row == "Training for SMS")
								REVERTING
							@endif
						</td>
					@else
						<td></td>
						<td colspan="2"></td>
						<td colspan="2"></td>
					@endif
				@endif
			</tr>
		@endforeach

		<tr>
			<td colspan="2">9. ABILITY OF WELDING</td>
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
			<td colspan="2">10. SEAMAN'S HISTORY</td>
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

		@php
			$applicant->sea_service = $applicant->sea_service->reverse()->take(12)->reverse();
			$applicant->sea_service = $applicant->sea_service->sortBy('sign_on');
		@endphp
		@foreach($applicant->sea_service as $key => $data)
			<tr>
				<td colspan="2">{{ $data->vessel_name }}</td>
				<td>{{ $data->vessel_type }}</td>
				<td colspan="2">{{ $data->gross_tonnage ? number_format((int)str_replace(',', '', $data->gross_tonnage)) : "" }}</td>
				<td>{{ $data->manning_agent }}</td>
				<td>{{ $data->sign_on != "" ? $data->sign_on->format('M j, Y') : "" }}</td>
				{{-- <td>{{ $data->sign_on != "" ? $data->sign_on->format('d-m-Y') : "" }}</td> --}}
				<td colspan="2">{{ $data->remarks }}</td>
			</tr>
			<tr>
				<td>{{ $data->flag }}</td>
				<td>
					@if(isset($data->crew_nationality))
						{{ $data->crew_nationality }}
					@endif
				</td>
				<td>{{ $applicant->ranks[$data->rank] }}</td>
				<td>
					@if(isset($crewRank))
						@if(str_starts_with($crewRank->category, 'ENGINE'))
							{{ $data->engine_type }} {{ $data->bhp_kw != 0 ? "/ " . $data->bhp_kw : "" }}
						@else
							@if($data->vessel_name != "")
								-----
							@endif
						@endif
					@endif
				</td>
				<td>{{ $data->trade ? $data->trade : "" }}</td>
				<td>{{ $data->principal }}</td>
				<td>{{ $data->sign_off != "" ? $data->sign_off->format('M j, Y') : "" }}</td>
				{{-- <td>{{ $data->sign_off != "" ? $data->sign_off->format('d-m-Y') : "" }}</td> --}}
				<td colspan="2">
					@if($data->sign_on != "" && $data->sign_off != "")
						{{ $data->sign_on->diff($data->sign_off)->format('%yyr, %mmos, %ddays') }}
					@endif
				</td>
			</tr>
		@endforeach
		
		<tr></tr>

		<tr>
			<td colspan="2">Crew's Name:</td>
			<td colspan="3">{{ $applicant->user->lname . ', ' . $applicant->user->fname . ' ' . $applicant->user->suffix . ' ' . $applicant->user->mname }}</td>
			<td>Presenter:</td>
			<td colspan="3">
				@if(in_array(auth()->user()->id, [4567, 4566]))
					LHEA MARQUEZ / ASST. CREWING MANAGER
				@else
					NEIL ROMANO / CREWING MANAGER
				@endif
			</td>
		</tr>

		<tr>
			<td colspan="2"></td>
			<td colspan="3"></td>
			<td></td>
			<td colspan="3"></td>
		</tr>

	</tbody>
</table>
