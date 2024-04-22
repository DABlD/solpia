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

		if($crewRank == null && $applicant->document_flag->count()){
			$applicant->load('document_flag');
			$crewRank = $applicant->ranks2[$applicant->document_flag->first()->rank]->first();
		}
	}

	$fr = "background-color: #FF0000;";
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
			{{-- <td>Eye Color:</td>
			<td>Black</td> --}}
		</tr>

		<tr>
			<td>SSS No.:</td>
			<td colspan="2">{{ $applicant->sss ? $applicant->sss : '-----' }}</td>
			<td>BMI:</td>
			@php
				$weight = $applicant->weight ? $applicant->weight : null;
				$height = $applicant->height ? $applicant->height / 100 : null;
				$bmi = null;

				if($weight && $height){
					$bmi = round($weight / ($height * $height), 2);
				}
			@endphp
			<td>{{ $bmi }}</td>
			{{-- <td>{{ $applicant->bmi ? $applicant->bmi : '-----' }}</td> --}}
			<td>Shoe Size(cm):</td>
			<td>{{ $applicant->shoe_size ? $applicant->shoe_size : '-----' }}</td>
			<td>Clothes Size:</td>
			<td>{{ $applicant->clothes_size ? $applicant->clothes_size : '-----' }}</td>
		</tr>

		<tr>
			<td colspan="2">Crew's physical condition</td>
			<td colspan="2">NORMAL</td>
			<td>Diabetes</td>

			@php
				$name = 'DIABETES';
				$docu = isset($applicant->document_med->{$name}) ? $applicant->document_med->{$name} : false;
			@endphp

			<td>{{ $docu ? 'CONTROLLED WITH MEDICATION' : 'NO' }}</td>
			<td></td>
			<td>Choleith</td>
			<td>NO</td>
		</tr>

		<tr>
			<td></td>
			<td colspan="2">High/Low blood pressure</td>

			@php
				$name = 'HYPERTENSION';
				$docu = isset($applicant->document_med->{$name}) ? $applicant->document_med->{$name} : false;
			@endphp

			<td colspan="2">{{ $docu ? 'CONTROLLED WITH MEDICATION' : 'NO' }}</td>
			<td colspan="2">Renal Insufficiency</td>
			<td>NO</td>
			<td></td>
		</tr>

		@php
			$nok = null;
			$temps = ['Spouse', 'Partner', 'Son', 'Daughter', 'Father', 'Mother'];
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
			<td colspan="2">Spouse/Next of Kin</td>
			<td colspan="3"></td>
			<td>Relation</td>
			<td colspan="3" style="text-align: center;">{{ $nok ? strtoupper($nok->type) : '-----' }}</td>
		</tr>

		<tr>
			<td>Name</td>
			{{-- <td colspan="8"></td> --}}
			<td colspan="2">{{ $nok ? $nok->lname : "-----" }}</td>
			<td colspan="2">{{ $nok ? $nok->fname . ' ' . $nok->suffix : "-----" }}</td>
			<td colspan="2">{{ $nok ? $nok->mname : "-----" }}</td>
			<td rowspan="2">Number of Children</td>
			<td rowspan="2">{{ $childrens }}</td>
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
			$rt = isset($crewRank) && str_starts_with($crewRank->category, "ENGINE") ? "er" : "dr";

			if($crewRank){
				if($crewRank->category == "GALLEY"){
					foreach($applicant->document_lc as $lc){
						if($lc->type == "NCIII"){
							$docu = $lc;
							$hl = 9; //CHIEF COOK
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
										if($key >= $hl){
											// IF FOR OFFICERS ONLY
											if($key >= 2){
												if(str_starts_with($lc->type, "COC")){
													$hl = $key;
													$docu = $lc;
												}
											}
											else{
												$hl = $key;
												$docu = $lc;
											}
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
			<td colspan="2">
				NATIONAL
			</td>
			<td colspan="2">
				@if(isset($crewRank) && $docu)
					@if($hl == 0 && $hl !== null)
						@if($rt == "er")
							ENGINEERING WATCH
						@else
							NAVIGATIONAL WATCH
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
				 	{{-- CHIEF COOK --}}
				 	@elseif($hl == 9)
				 		SHIP'S COOK
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
			if(isset($crewRank) && $crewRank->type == "OFFICER"){
				foreach($applicant->document_flag as $document){
				    if($document->country == "Panama" && $document->type == "LICENSE"){
				        $docu2 = $document;
				    }
				}
			}
		@endphp
	
		<tr>
			<td colspan="2">PANAMA</td> 
			<td colspan="2">
				@if(isset($crewRank) && $docu2)
					@if($hl == 0)
						@if($rt == "er")
							ENGINEERING WATCH
						@else
							NAVIGATIONAL WATCH
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
			<td colspan="2">{{ isset($crewRank->type) && $crewRank->type == "OFFICER" ? "PANAMA" : "NOT APPLICABLE" }}</td>
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
			<td colspan="2">PANAMA GOC</td> 
			{{-- <td colspan="2">{{ $applicant->rank->name }}</td> --}}
			<td colspan="2">{{ $docu ? "GMDSS GENERAL OPERATOR" : "-----" }}</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			{{-- <td colspan="2">{{ $docu ? "Panama" : "-" }}</td> --}}
			<td colspan="2">{{ $docu ? 'PANAMA' : 'NOT APPLICABLE' }}</td>
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
			{{-- <td colspan="2">{{ $applicant->rank->name }}</td> --}}
			<td colspan="2">{{ $docu ? "SHIP SECURITY OFFICER" : "-----" }}</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			{{-- <td colspan="2">{{ $docu ? "Panama" : "-" }}</td> --}}
			<td colspan="2">{{ $docu ? 'PANAMA' : 'NOT APPLICABLE' }}</td>
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
			{{-- <td colspan="2">{{ $applicant->rank->name }}</td> --}}
			<td colspan="2">-----</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----" }}</td>
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
			<td colspan="2">U.S. C1/D Visa</td>
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
			<td colspan="2">Seaman's Book(National)</td>
			<td colspan="2">-----</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----"}}</td>
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
			<td colspan="2">Seaman's Book(Panama)</td>
			<td colspan="2">{{ $rname }}</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----"}}</td>
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
			<td colspan="2">-----</td>
			<td>{{ $docu ? strtoupper($docu->number) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">LIBERIA</td>
		</tr>
		
		{{-- 6TH --}}
		@php 
			$name = "MCV";
			$docu = isset($applicant->document_id->{$name}) ? $applicant->document_id->{$name} : false;
		@endphp

		<tr>
			<td colspan="2">AUS MCV Visa</td>
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
			<td colspan="2">Japanese Visa</td>
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

		{{-- 1ST POINT 5 --}}
		@php 
			$name = 'SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp

		<tr>
			<td colspan="4">SSAT with SDSD</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

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

		<tr>
			<td colspan="4">Satellite Communication Course</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		{{-- 10TH --}}
		@php 
			$docu = false;

			if(isset($crewRank)){
				$tempDocu = null;

				foreach($applicant->document_lc as $document){
					$regulation = json_decode($document->regulation);
					// dd($applicant->document_lc);
					// dd($document);

					if(str_starts_with($document->type, "COE") && (in_array('III/1', $regulation) || in_array('III/2', $regulation) || in_array('II/1', $regulation) || in_array('II/2', $regulation))){
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
			$name = 'ECDIS';
			$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
		@endphp
		{{-- ECDISCISM --}}
		<tr>
			<td rowspan="2">ECDIS</td>
			<td colspan="3">Generic</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		<tr>
			<td colspan="3">Type Specific</td>
			@if(isset($applicant->ecdises[0]))
				@php
					$name = $applicant->ecdises[0];
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
				@endphp
				<td>{{ $docu ? strtoupper($docu->no) : "REVERTING"}}</td>
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
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		{{-- 12TH --}}
		@php 
			$docu = false;
			foreach($applicant->document_lc as $doc){
				if(str_contains($doc->type, "MARPOL")){
					$docu = $doc;
				}
			}
		@endphp

		<tr>
			<td colspan="4">MARPOL</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		{{-- 13TH --}}
		@php 
			if(isset($crewRank)){
				if(str_contains($crewRank->category, "DECK")){
					$name = 'SSBT WITH BRM';
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;

					if(!isset($docu)){
						$name = 'SSBT';
						$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
					}
					if(!isset($docu)){
						$name = 'BRM';
						$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
					}
					if(!isset($docu)){
						$name = 'BTM';
						$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
					}
				}
				else{
					$name = 'ERS WITH ERM';
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;

					if(!isset($docu)){
						$name = 'ERS';
						$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
					}

				}
			}
		@endphp

		<tr>
			<td colspan="4">
				@if(isset($crewRank) && str_contains($crewRank->category, "DECK"))
					SSBT W/ BRM
				@else
					ERS W/ ERM
				@endif
			</td>
			<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
			<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
			<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
			<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
		</tr>

		@php 
			$docu = false;
			$docu2 = false;
			$rr1 = null;
			$rr2 = null;

			if(isset($crewRank)){
				$tRank = $crewRank->id;

				if($tRank == 9 || $tRank == 10 || $tRank == 11){
					$rr1 = "II/4";
					$rr2 = "II/5";
				}
				else if($tRank == 15 || $tRank == 16 || $tRank == 17){
					$rr1 = "III/4";
					$rr2 = "III/5";
				}

				foreach($applicant->document_lc as $lc){
					$regulations = json_decode($lc->regulation);

					if(in_array($rr1, $regulations)){
						$docu = $lc;
					}
					if(in_array($rr2, $regulations)){
						$docu2 = $lc;
					}
				}
			}
		@endphp

		@if($crewRank)
			{{-- AB,OLR,OS,WPR WITH SENIOR OFFICER LICENSE --}}
			@if(($tRank == 10 && $hl == 2) || ($tRank == 16 && $hl == 2) || ($tRank == 9 && $hl == 2) || ($tRank == 15 && $hl == 2) || ($tRank == 42 && $hl == 2) || ($tRank == 43 && $hl == 2) || ($tRank == 11 && $hl == 2) || ($tRank == 17 && $hl == 2))
				<tr>
					<td colspan="4">
						MARINA COP REGULATION {{ $rr2 }}
					</td>
					<td>{{ $docu2 ? $docu2->no : "-----"}}</td>
					<td>{{ $docu2 ? checkDate2($docu2->issue_date, "I") : "-----" }}</td>
					<td>{{ $docu2 ? checkDate2($docu2->expiry_date, "E") : "-----" }}</td>
					<td colspan="2">{{ $docu2 ? $docu2->issuer : "NOT APPLICABLE" }}</td>
				</tr>
			@endif

			{{-- AB, OLR OR OS, WPR WITH JUNIOR OFFICER LICENSE --}}
			@if($tRank == 10 || $tRank == 16 || $tRank == 9 || $tRank == 15 || $tRank == 42 || $tRank == 43 || ($tRank == 11 && $hl >= 1) || ($tRank == 17 && $hl >= 1))
				<tr>
					<td colspan="4">
						MARINA COP REGULATION {{ $rr1 }}
					</td>
					<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
					<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
					<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
					<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
				</tr>
			@endif
		@endif

		@if($crewRank)
			@if($hl == 9)
				@php 
					$name = 'NCI';
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
				@endphp

				<tr>
					<td colspan="4">MESSMAN</td>
					<td>{{ $docu ? strtoupper($docu->no) : "-----"}}</td>
					<td>{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}</td>
					<td>{{ $docu ? checkDate2($docu->expiry_date, "E") : "-----" }}</td>
					<td colspan="2">{{ $docu ? $docu->issuer : "NOT APPLICABLE" }}</td>
				</tr>
			@endif
		@endif
	
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

		@php
			$name = 'COVID-19 1ST DOSE';
			$docu = isset($applicant->document_med_cert->{$name}) ? $applicant->document_med_cert->{$name} : false;

			$name2 = 'COVID-19 2ND DOSE';
			$docu2 = isset($applicant->document_med_cert->{$name2}) ? $applicant->document_med_cert->{$name2} : false;

			$name3 = 'COVID-19 3RD DOSE';
			$docu3 = isset($applicant->document_med_cert->{$name3}) ? $applicant->document_med_cert->{$name3} : false;
		@endphp

		<tr>	
			<td colspan="4">COVID-19 (certificate copy must be attached)</td>
			<td>NO</td>
			{{-- <td>{{ $docu2 ? "YES" : "NO"}}</td> --}}
			<td>{{ $docu ? $docu->clinic : "-----"}}</td>
			<td>
				{{ $docu ? checkDate2($docu->issue_date, "I") : "-----" }}
				@if($docu2)
					 &#38; {{ $docu2 ? checkDate2($docu2->issue_date, "I") : "-----" }}
				@endif

			</td>
			<td>-----</td>
			<td>
				{{ $docu ? $docu->issuer : "-----" }}
				@if($docu2)
					 &#38; {{ $docu2 ? $docu2->issuer : "-----" }}
				@endif
			</td>
		</tr>

		<tr>	
			<td colspan="4">COVID-19 BOOSTER(certificate copy must be attached)</td>
			<td>-----</td>
			{{-- <td>{{ $docu2 ? "YES" : "NO"}}</td> --}}
			<td>{{ $docu3 ? $docu3->clinic : "-----"}}</td>
			<td>
				{{ $docu3 ? checkDate2($docu3->issue_date, "I") : "-----" }}
			</td>
			<td>-----</td>
			<td>{{ $docu3 ? $docu3->issuer : "-----"}}</td>
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

		@php
			$applicant->sea_service = $applicant->sea_service->reverse()->take(12)->reverse();
;		@endphp
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
				<td>{{ $data->ship_manager ?? $data->principal }}</td>
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
