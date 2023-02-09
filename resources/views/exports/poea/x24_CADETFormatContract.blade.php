@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$i = "font-style: italic;";
	$bc = "$b$c";
@endphp

<table>
	<tr>
		<td colspan="9" style="{{ $c }}">Republic of the Philippines</td>
	</tr>

		<tr>
			<td colspan="9" style="{{ $c }}">Department of Labor and Employment</td>
		</tr>
		<tr>
			<td colspan="9" style="{{ $bc }}">PHILIPPINE OVERSEAS EMPLOYMENT ADMINISTRATION</td>
		</tr>
		<tr>
			<td colspan="9"></td>
		</tr>
		<tr>
			<td colspan="9" style="{{ $bc }}">Standard Cadet Training AGreement</td>
		</tr>
		<tr>
			<td colspan="9" style="{{ $bc }}">On ships Engaged in International Voyage</td>
		</tr>

		<tr>
			<td colspan="9">KNOW ALL MEN BY THESE PRESENTS:</td>
		</tr>
		<tr>
			<td colspan="6" style="{{ $c }}">This Agreement, entered into voluntarily by and between:</td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="2">Name of Cadet:</td>
			<td colspan="7" style="{{ $i }} {{ $c }}">{{ $data->user->namefull }}</td>	
		</tr>

		<tr>
			<td>Date of Birth:</td>
			<td colspan="4" style="{{ $c }} {{ $i }}">{{ $data->user->birthday ? $data->user->birthday->format('d-M-y') : "---" }}</td>
			<td>Place of Birth:</td>
			<td colspan="3" style="{{ $c }} {{ $i }}">{{ $data->birth_place }}</td>
		</tr>

		<tr>
			<td>Address:</td>
			<td colspan="8" style="{{ $c }} {{ $i }}">{{ $data->user->address }}</td>
		</tr>

		<tr>
			<td>SIRB</td>
			<td colspan="4" style="{{ $c }} {{ $i }}">
				{{ isset($data->document_id->{"SEAMAN'S BOOK"}) ? $data->document_id->{"SEAMAN'S BOOK"}->number : "---" }}
			</td>
			<td>E-Reg. No.</td>
			<td colspan="3" style="{{ $c }} {{ $i }}">
				{{ isset($data->document_lc->{"POEA EREGISTRATION"}) ? $data->document_lc->{"POEA EREGISTRATION"}->number : "---" }}
			</td>
		</tr>

		<tr>
			<td colspan="9">Hereinafter referred to as the Cadet</td>
		</tr>

		<tr>
			<td colspan="9" style="{{ $c }}">and</td>
		</tr>

		<tr>
			<td colspan="3">Name of Agent:</td>
			<td colspan="6" style="{{ $c }} {{ $i }}">SOLPIA MARINE AND SHIP MANAGEMENT INC.</td>
		</tr>

		<tr>
			<td colspan="3">Name of Sponsoring Company:</td>
			<td colspan="6" style="{{ $c }} {{ $i }}">{{ $data->pro_app->vessel->principal->full_name }}</td>
		</tr>

		<tr>
			<td colspan="3">Address of Sponsoring Company:</td>
			<td colspan="6" style="{{ $c }} {{ $i }}">{{ $data->pro_app->vessel->principal->address }}</td>
		</tr>

		@php
			$educ = null;

			foreach($data->educational_background as $eb){
				if($eb->type == "College"){
					$educ = $eb;
					break;
				}
				elseif($eb->type == "Undergrad"){
					$educ = $eb;
					break;
				}
				elseif($eb->type == "Vocational"){
					$educ = $eb;
					break;
				}
				elseif($eb->type == "High School"){
					$educ = $eb;
					break;
				}
			}
		@endphp

		<tr>
			<td colspan="3">Name of School:</td>
			<td colspan="6" style="{{ $c }} {{ $i }}">{{ $educ ? $educ->school : "N/A" }}</td>
		</tr>

		<tr>
			<td colspan="3">Address of School:</td>
			<td colspan="6" style="{{ $c }} {{ $i }}">{{ $educ ? $educ->address : "N/A" }}</td>
		</tr>

		<tr>
			<td colspan="9">for the following vessel:</td>
		</tr>

		<tr>
			<td colspan="2">Name of Vessel:</td>
			<td colspan="7" style="{{ $c }} {{ $i }}">{{ $data->pro_app->vessel->name }}</td>
		</tr>

		<tr>
			<td>IMO Number:</td>
			<td colspan="2" style="{{ $c }} {{ $i }}">{{ $data->pro_app->vessel->imo }}</td>
			<td colspan="2"></td>
			<td colspan="2">Gross Registered Tonnage (GRT):</td>
			<td colspan="2" style="{{ $c }} {{ $i }}">{{ $data->pro_app->vessel->gross_tonnage }}</td>
		</tr>

		<tr>
			<td>Flag:</td>
			<td colspan="2" style="{{ $c }} {{ $i }}">{{ $data->pro_app->vessel->flag }}</td>
			<td colspan="2"></td>
			<td colspan="2">Year Built:</td>
			<td colspan="2" style="{{ $c }} {{ $i }}">{{ $data->pro_app->vessel->year_build }}</td>
		</tr>

		<tr>
			<td>Type of Vessel:</td>
			<td colspan="2" style="{{ $c }} {{ $i }}">{{ $data->pro_app->vessel->type }}</td>
			<td colspan="2"></td>
			<td colspan="2">Classification Society:</td>
			<td colspan="2" style="{{ $c }} {{ $i }}">{{ $data->pro_app->vessel->classification }}</td>
		</tr>

		<tr>
			<td colspan="9">herein after referred to as the Principal</td>
		</tr>

		<tr>
			<td colspan="9" style="{{ $c }}">WITNESSETH</td>
		</tr>

		<tr>
			<td colspan="9">
				1. ‎‏‏‎ ‎‏‏‎ ‎‏‏‎That the Cadet shall be embarked for Training on board under the following terms and conditions:
			</td>
		</tr>

		<tr>
			<td style="text-align: right;">1.1</td>
			<td colspan="3">Duration of Training:</td>
			<td colspan="5">
				{{ $data->req['employment_months'] }} MONTHS (+/- 1 MONTH WITH MUTUAL CONSENT OF BOTH PARTIES)
			</td>
		</tr>

		<tr>
			<td style="text-align: right;">1.2</td>
			<td colspan="3">Position:</td>
			<td colspan="5" style="{{ $i }}">{{ $data->pro_app->rank->name }}</td>
		</tr>

		<tr>
			<td style="text-align: right;">1.3</td>
			<td colspan="3">Monthly Stipend:</td>
			<td colspan="5" style="{{ $i }}">${{ $data->wage->basic ?? 0 }}</td>
		</tr>

		<tr>
			<td style="text-align: right;">1.4</td>
			<td colspan="3">Hours of Training:</td>
			<td colspan="5" style="{{ $i }}">8 HOURS / DAY</td>
		</tr>

		<tr>
			<td style="text-align: right;">1.5</td>
			<td colspan="3">Point of Departure:</td>
			<td colspan="5" style="{{ $i }}">{{ $data->req['pointOfHire'] }}</td>
		</tr>

		<tr>
			<td style="text-align: right;">1.6</td>
			<td colspan="3">Commend of Training:</td>
			<td colspan="5" style="{{ $i }}">UPON DEPARTURE</td>
		</tr>

		<tr>
			<td colspan="9">
				2. ‎‏‏‎ ‎‏‏‎ ‎‏‏‎The terms and conditions in accordance with Governing Board Resolution No. 09, and Memorandun Circular
			</td>
		</tr>

		<tr>
			<td colspan="9">
				 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎No. 10, both Series of 2010, and Memorandum Circular No. 34, Series of 2020 (Compliance with the 2016)
			</td>
		</tr>

		<tr>
			<td colspan="9">
				 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎Amendments to the Maritime Labour Convention, 2006) shall be strictly and faithfully observed.
			</td>
		</tr>

		<tr><td colspan="9"></td></tr>

		<tr>
			<td colspan="9">
				3. ‎‏‏‎ ‎‏‏‎ ‎‏‏‎Any alterations or changes, in any part of this Agreement shall be evaluated, verified, processed and approved by the
			</td>
		</tr>

		<tr>
			<td colspan="9">
				 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎Philippine Overseas Employment (POEA). Upon approval, the same shall be deemed an integral part of this
			</td>
		</tr>

		<tr>
			<td colspan="9">
				 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎POEA approved Standard Cadet Training Agreement.
			</td>
		</tr>

		<tr><td colspan="9"></td></tr>

		<tr>
			<td colspan="9">
				4. ‎‏‏‎ ‎‏‏‎ ‎‏‏‎Violations of the terms and conditions of this Agreement with its appproved Annex A shall be ground for disciplinary action
			</td>
		</tr>

		<tr>
			<td colspan="9">
				 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎against the erring party.
			</td>
		</tr>

		<tr><td colspan="9"></td></tr>

		<tr>
			<td colspan="9">
				5. ‎‏‏‎ ‎‏‏‎ ‎‏‏‎Training credits earned and documented in the Training Record Book shall be accepted by the School as fulfilment of the
			</td>
		</tr>

		<tr>
			<td colspan="9">
				 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎shipboard training requirements for the grant of Bachelor of Science Degree in the program in which the cadet is enrolled.
			</td>
		</tr>

		<tr><td colspan="9"></td></tr>

		<tr>
			<td colspan="6">
				 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎IN WITNESS WHEREOF the parties have hereto set their hand this
			</td>
			<td style="{{ $c }} {{ $i }}">{{ now()->format("jS") }}</td>
			<td style="{{ $c }} {{ $i }}">day of</td>
			<td style="{{ $c }} {{ $i }}">{{ now()->format('F') }}</td>
		</tr>

		<tr>
			<td colspan="9">{{ now()->format('Y') }} at Manila Philippines.</td>
		</tr>

		<tr>
			<td colspan="9"></td>
		</tr>

		<tr>
			<td colspan="3" style="{{ $bc }} {{ $i }}">{{ $data->user->fullname2 }}</td>
			<td colspan="3"></td>
			<td colspan="3" style="{{ $bc }} {{ $i }}">C/E. ROMANO A. MARIANO</td>
		</tr>

		<tr>
			<td colspan="3" style="{{ $c }}">Name &#38; Signature of Cadet</td>
			<td colspan="3"></td>
			<td colspan="3" style="{{ $c }}">PRESIDENT</td>
		</tr>

		<tr>
			<td colspan="3" style="{{ $bc }} {{ $i }}">{{ now()->format('d-M-y') }}</td>
			<td colspan="3"></td>
			<td colspan="3" style="{{ $c }}">Name &#38; Signature of Sponsoring Company/Representative</td>
		</tr>

		<tr>
			<td colspan="3" style="{{ $c }}">Date</td>
			<td colspan="6"></td>
		</tr>

		<tr>
			<td colspan="3"></td>
			<td colspan="4" style="{{ $c }}"></td>
			<td colspan="2"></td>
		</tr>

		<tr>
			<td colspan="3"></td>
			<td colspan="4" style="{{ $c }}">Name &#38; Signature of School Representative</td>
			<td colspan="2"></td>
		</tr>

		<tr>
			<td colspan="9"></td>
		</tr>

		<tr>
			<td colspan="9" style="{{ $b }}">Verified and approved by the POEA:</td>
		</tr>

		<tr>
			<td colspan="4" style="{{ $c }}"></td>
			<td colspan="5"></td>
		</tr>

		<tr>
			<td colspan="4" style="{{ $c }}">Name and Signature of POEA official</td>
			<td colspan="5"></td>
		</tr>
</table>