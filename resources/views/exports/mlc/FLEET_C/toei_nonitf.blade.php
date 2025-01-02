@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";

	$verdana = "font-family: Verdana;";

	$und = "text-decoration: underline;";

	$header = function($pn) use($bc, $c, $verdana){
		echo "
			<tr>
				<td colspan='2' rowspan='4'></td>
				<td colspan='5' rowspan='2' style='font-size: 12; $bc $verdana'>SOLPIA MARINE &#38; MANAGEMENT, INC.</td>
				<td style='font-size:8; $verdana'>Issue: 00</td>
			</tr>

			<tr>
				<td style='font-size:8; $verdana'>Revision: 03</td>
			</tr>

			<tr>
				<td colspan='5' style='font-size: 10; $c $verdana'>FPS 04A: Seafarer’s Employment Agreement </td>
				<td style='font-size:8; $verdana'>Date: 03rd Aug 2024</td>
			</tr>

			<tr>
				<td colspan='5'></td>
				<td style='font-size:8; $verdana'>Page: $pn of 16</td>
			</tr>
		";
	};
@endphp

<table>
	{{ $header(1) }}

	{{-- 1ST PAGE --}}
	<a>
		<tr>
			<td colspan="8" style="{{ $c }}"></td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $bc }} {{ $und }} font-size: 11px;">SEAFARER’S EMPLOYMENT AGREEMENT – Part I</td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $bc }} font-size: 10px;">ASSIGNMENT LETTER</td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $c }} font-size: 10px;">This Agreement incorporates the 2018 amendments to the MLC 2006</td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $c }} font-size: 10px;">This Employment Agreement is entered into between the Owner/Agent of the Registered Owner of a vessel</td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $c }} font-size: 10px;">(hereinafter called the COMPANY) and the SEAFARER.</td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $b }} font-size: 9.5px;">The Ship</td>
		</tr>

		<tr>
			<td style="font-size: 9;" colspan="2">&#8205; Name</td>
			<td style="font-size: 9; {{ $c }}" colspan="2">{{ $data->vessel->name }}</td>
			<td style="font-size: 9;">&#8205; IMO No.</td>
			<td style="font-size: 9; {{ $c }}" colspan="3">{{ $data->vessel->imo }}</td>
		</tr>

		<tr>
			<td style="font-size: 9;" colspan="2">&#8205; Flag</td>
			<td style="font-size: 9; {{ $c }}" colspan="2">{{ $data->vessel->flag }}</td>
			<td style="font-size: 9;">&#8205; Port of Registry</td>
			<td style="font-size: 9; {{ $c }}" colspan="3">Monrovia</td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $b }} font-size: 9.5px;">The Registered Ship-Owner (COMPANY)</td>
		</tr>

		<tr>
			<td style="font-size: 9;" colspan="2">&#8205; Name</td>
			<td style="font-size: 9; {{ $c }}" colspan="6">BRAVERY MARITIME LTD.</td>
		</tr>

		<tr>
			<td style="font-size: 9;" colspan="2">&#8205; Address</td>
			<td style="font-size: 9; {{ $c }}" colspan="6">TRUST COMPANY COMPLEX AJELTAKE ROAD, AJELTAKE ISLAND, MAJURO, MARSHALL ISLANDS MN 96960</td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $b }} font-size: 9.5px;">The Ship-Owner (COMPANY) Representative (MLC Shipowner)</td>
		</tr>

		<tr>
			<td style="font-size: 9;" colspan="2">&#8205; Name</td>
			<td style="font-size: 9; {{ $c }}" colspan="6">ROYAL MARINE SHIPMANAGEMENT PTE LTD. </td>
		</tr>

		<tr>
			<td style="font-size: 9;" colspan="2">&#8205; Address</td>
			<td style="font-size: 9; {{ $c }}" colspan="6">1 COLEMAN STREET, #09-02A, THE ADELPHI, SINGAPORE 179803</td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $b }} font-size: 9.5px;">The Seafarer</td>
		</tr>

		<tr>
			<td style="font-size: 9;" colspan="2">
				&#8205; Surname
				<br style='mso-data-placement:same-cell;' />
				&#8205; (in capital letters)
			</td>
			<td style="font-size: 9; {{ $c }}" colspan="2">{{ $data->user->lname }}</td>
			<td style="font-size: 9;">
				&#8205; The capacity/Rank in
				<br style='mso-data-placement:same-cell;' />
				&#8205; which the seafarer is
				<br style='mso-data-placement:same-cell;' />
				&#8205; employed
			</td>
			<td style="font-size: 9; {{ $c }}" colspan="3">{{ $data->pro_app->rank->abbr }}</td>
		</tr>

		{{-- NEED TO GET COC --}}
		@php
			$coc = null;
			$pp = null;
			$sb = null;
			$mc = null;

			foreach($data->document_lc as $docu){
				if($docu->type == "COC"){
					if($coc == null){
						$coc = $docu;
					}
					else{
						if($docu->type->issue_date > $coc->issue_date){
							$coc = $docu;
						}
					}
				}
			}

			foreach($data->document_id as $docu){
				if($docu->type == "PASSPORT"){
					$pp = $docu;
				}
				if($docu->type == "SEAMAN'S BOOK"){
					$sb = $docu;
				}
			}

			foreach($data->document_med_cert as $docu){
				if($docu->type == "MEDICAL CERTIFICATE"){
					$mc = $docu;
				}
			}
		@endphp

		<tr>
			<td style="font-size: 9;" colspan="2">
				&#8205; Given Name
			</td>
			<td style="font-size: 9; {{ $c }}" colspan="2">{{ $data->user->fname }} {{ $data->user->suffix }}</td>
			<td style="font-size: 9;">
				&#8205; COC Rank/Issued
				<br style='mso-data-placement:same-cell;' />
				&#8205; Country
			</td>
			<td style="font-size: 9; {{ $c }}" colspan="2">{{ $coc ? $coc->rank2->abbr : "-" }}</td>
			<td style="font-size: 9; {{ $c }}">{{ $coc ? $coc->issue_date->format('d-m-Y') : "-" }}</td>
		</tr>

		<tr>
			<td style="font-size: 9;" colspan="2">
				&#8205; Middle Name
			</td>
			<td style="font-size: 9; {{ $c }}" colspan="2">{{ $data->user->mname }}</td>
			<td style="font-size: 9;">
				&#8205; Passport No./Valid till
				<br style='mso-data-placement:same-cell;' />
				&#8205; date
			</td>
			<td style="font-size: 9; {{ $c }}" colspan="2">{{ $pp ? $pp->no : "-" }}</td>
			<td style="font-size: 9; {{ $c }}">{{ $pp ? $pp->issue_date->format('d-m-Y') : "-" }}</td>
		</tr>

		<tr>
			<td style="font-size: 9;" colspan="2">
				&#8205; Nationality
			</td>
			<td style="font-size: 9; {{ $c }}" colspan="2">FILIPINO</td>
			<td style="font-size: 9;">
				&#8205; Seaman's Book No./
				<br style='mso-data-placement:same-cell;' />
				&#8205; Valid date
			</td>
			<td style="font-size: 9; {{ $c }}" colspan="2">{{ $sb ? $sb->no : "-" }}</td>
			<td style="font-size: 9; {{ $c }}">{{ $sb ? $sb->issue_date->format('d-m-Y') : "-" }}</td>
		</tr>

		<tr>
			<td style="font-size: 9;" colspan="2">
				&#8205; Date of Birth
				<br style='mso-data-placement:same-cell;' />
				&#8205; (dd-mm-yyyy)
			</td>
			<td style="font-size: 9; {{ $c }}" colspan="2">{{ isset($data->user->birthday) ? $data->user->birthday->format('d-m-Y') : "-"}}</td>
			<td style="font-size: 9;">
				&#8205; Medical Cert valid till
				<br style='mso-data-placement:same-cell;' />
				&#8205; date
			</td>
			<td style="font-size: 9; {{ $c }}" colspan="3">{{ $mc ? $mc->expiry_date->format('d-m-Y') : "-" }}</td>
		</tr>

		<tr>
			<td style="font-size: 9;" colspan="2">
				&#8205; Place of Birth
			</td>
			<td style="font-size: 9; {{ $c }}" colspan="2">{{ $data->birth_place }}</td>
			<td style="font-size: 9;">
				&#8205; Estimated time of
				<br style='mso-data-placement:same-cell;' />
				&#8205; joining
			</td>
			<td style="font-size: 9; {{ $c }}" colspan="3">{{ now()->parse($data->effective_date)->format('d-m-Y') }}</td>
		</tr>

		<tr>
			<td style="font-size: 9;" colspan="2">
				&#8205; BSID No. / Valid till
			</td>
			<td style="font-size: 9; {{ $c }}" colspan="2"></td>
			<td style="font-size: 9;">
				&#8205; Port of joining
			</td>
			<td style="font-size: 9; {{ $c }}" colspan="3">{{ $data->port }}</td>
		</tr>

		<tr>
			<td style="font-size: 9; {{ $c }}" colspan="4"></td>
			<td style="font-size: 9;">
				&#8205; Home Port
			</td>
			<td style="font-size: 9; {{ $c }}" colspan="3">MANILA, PHILIPPINES</td>
		</tr>

		<tr>
			<td style="font-size: 9;" colspan="2">
				&#8205; Full home address
			</td>
			<td style="font-size: 9; {{ $c }}" colspan="6">{{ $data->user->address }}</td>
		</tr>
	</a>

	{{-- 2ND PAGE --}}
	{{ $header(2) }}
	<a>
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				&#8205; Next of Kin of
				<br style='mso-data-placement:same-cell;' />
				&#8205; Seafarer
			</td>
			<td style="{{ $bc }}" colspan="2">First NOK</td>
			<td style="{{ $bc }}" colspan="2">Second NOK</td>
			<td style="{{ $bc }}" colspan="3">Third NOK</td>
		</tr>

		{{-- GET NOKS --}}
		@php
			$childs = [];

			foreach($data->family_data as $fd){
				if(in_array($fd->type, ['Daughter', 'Son'])){
					array_push($childs, $fd);
				}
			}
		@endphp

		<tr>
			<td>&#8205; Name of NOK</td>
			<td colspan="2" style="{{ $c }}"></td>
			<td colspan="2" style="{{ $c }}"></td>
			<td colspan="3" style="{{ $c }}"></td>
		</tr>

		<tr>
			<td>
				&#8205; Percentage of
				<br style='mso-data-placement:same-cell;' />
				&#8205; claim
			</td>
			<td colspan="2" style="{{ $c }}"></td>
			<td colspan="2" style="{{ $c }}"></td>
			<td colspan="3" style="{{ $c }}"></td>
		</tr>

		<tr>
			<td>&#8205; Relationship</td>
			<td colspan="2" style="{{ $c }}"></td>
			<td colspan="2" style="{{ $c }}"></td>
			<td colspan="3" style="{{ $c }}"></td>
		</tr>

		<tr>
			<td>&#8205; Date of Birth</td>
			<td colspan="2" style="{{ $c }}"></td>
			<td colspan="2" style="{{ $c }}"></td>
			<td colspan="3" style="{{ $c }}"></td>
		</tr>

		<tr>
			<td>
				&#8205; Contact
				<br style='mso-data-placement:same-cell;' />
				&#8205; Address
			</td>
			<td colspan="2" style="{{ $c }}"></td>
			<td colspan="2" style="{{ $c }}"></td>
			<td colspan="3" style="{{ $c }}"></td>
		</tr>

		<tr>
			<td>&#8205; Telephone</td>
			<td colspan="2" style="{{ $c }}"></td>
			<td colspan="2" style="{{ $c }}"></td>
			<td colspan="3" style="{{ $c }}"></td>
		</tr>

		<tr>
			<td>&#8205; Email</td>
			<td colspan="2" style="{{ $c }}"></td>
			<td colspan="2" style="{{ $c }}"></td>
			<td colspan="3" style="{{ $c }}"></td>
		</tr>

		<tr>
			<td style="{{ $bc }}">Child</td>
			<td style="{{ $bc }}" colspan="2">Name</td>
			<td style="{{ $bc }}" colspan="2">Date of Birth</td>
			<td style="{{ $bc }}" colspan="3">Gender</td>
		</tr>

		<tr>
			<td style="{{ $bc }}">1st Child</td>
			<td style="{{ $c }}" colspan="2">{{ isset($childs[0]) ? $childs[0]->fullName2 : "" }}</td>
			<td style="{{ $c }}" colspan="2">{{ isset($childs[0]) ? (isset($childs[0]->birthday) ? $childs[0]->birthday->format('d-F-Y') : "-") : "" }}</td>
			<td style="{{ $c }}" colspan="3">{{ isset($childs[0]) ? ($childs[0]->type == "Son" ? "Male" : "Female") : "" }}</td>
		</tr>

		<tr>
			<td style="{{ $bc }}">2nd Child</td>
			<td style="{{ $c }}" colspan="2">{{ isset($childs[1]) ? $childs[1]->fullName2 : "" }}</td>
			<td style="{{ $c }}" colspan="2">{{ isset($childs[1]) ? (isset($childs[1]->birthday) ? $childs[1]->birthday->format('d-F-Y') : "-") : "" }}</td>
			<td style="{{ $c }}" colspan="3">{{ isset($childs[1]) ? ($childs[1]->type == "Son" ? "Male" : "Female") : "" }}</td>
		</tr>

		<tr>
			<td style="{{ $bc }}">3rd Child</td>
			<td style="{{ $c }}" colspan="2">{{ isset($childs[2]) ? $childs[2]->fullName2 : "" }}</td>
			<td style="{{ $c }}" colspan="2">{{ isset($childs[2]) ? (isset($childs[2]->birthday) ? $childs[2]->birthday->format('d-F-Y') : "-") : "" }}</td>
			<td style="{{ $c }}" colspan="3">{{ isset($childs[2]) ? ($childs[2]->type == "Son" ? "Male" : "Female") : "" }}</td>
		</tr>

		<tr>
			<td style="{{ $bc }}">4th Child</td>
			<td style="{{ $c }}" colspan="2">{{ isset($childs[2]) ? $childs[2]->fullName2 : "" }}</td>
			<td style="{{ $c }}" colspan="2">{{ isset($childs[2]) ? (isset($childs[2]->birthday) ? $childs[2]->birthday->format('d-F-Y') : "-") : "" }}</td>
			<td style="{{ $c }}" colspan="3">{{ isset($childs[2]) ? ($childs[2]->type == "Son" ? "Male" : "Female") : "" }}</td>
		</tr>

		<tr>
			<td style="{{ $bc }}">
				Seafarer's 
				<br style='mso-data-placement:same-cell;' />
				Signature
			</td>
			<td style="{{ $bc }}" colspan="2"></td>
			<td style="{{ $bc }}" colspan="2">
				Seafarer's left thumb 
				<br style='mso-data-placement:same-cell;' />
				impression
			</td>
			<td style="{{ $bc }}" colspan="3"></td>
		</tr>

		<tr>
			<td style="{{ $bc }}" rowspan="4">
				Personal Bank 
				<br style='mso-data-placement:same-cell;' />
				Account
			</td>
			<td style="{{ $bc }}" colspan="2">Name of Bank</td>
			<td style="{{ $bc }}" colspan="2">Name of Beneficiary</td>
			<td style="{{ $bc }}" colspan="3">Account no./SWIFT code</td>
		</tr>

		<tr>
			<td colspan="2"></td>
			<td colspan="2"></td>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td colspan="2"></td>
			<td colspan="2"></td>
			<td style="{{ $bc }}">
				SWIFT 
				<br style='mso-data-placement:same-cell;' />
				Code
			</td>
			<td colspan="2"></td>
		</tr>

		<tr>
			<td colspan="2"></td>
			<td colspan="2"></td>
			<td style="{{ $bc }}">
				IFSC
				<br style='mso-data-placement:same-cell;' />
				Code
			</td>
			<td colspan="2"></td>
		</tr>

		<tr>
			<td colspan="3" style="{{ $bc }}">Name of Manning Agent</td>
			<td colspan="5" style="{{ $bc }}">SOLPIA MARINE &#38; SHIP MANAGEMENT, INC.</td>
		</tr>

		<tr>
			<td colspan="3" style="{{ $bc }}">Terms of the Agreement</td>
			<td colspan="5"></td>
		</tr>

		@php
			$wage = $data->wage;
		@endphp

		<tr>
			<td colspan="2">&#8205; Basic wage</td>
			<td style="{{ $c }}">{{ $wage ? number_format($wage->basic, 2) : ""}}</td>
			<td style="{{ $c }}">USD/Month</td>
			<td colspan="2">&#8205; Period of employment</td>
			<td style="{{ $c }}">9 (+/-1)</td>
			<td>&#8205; Months</td>
		</tr>

		<tr>
			<td colspan="2">&#8205; Overtime Pay</td>
			<td style="{{ $c }}">{{ $wage ? number_format($wage->fot ?? $wage->ot, 2) : ""}}</td>
			<td style="{{ $c }}">USD/Month</td>
			<td colspan="2">&#8205; Guaranteed Overtime Hours</td>
			<td style="{{ $c }}">104</td>
			<td>&#8205; Hours/Month</td>
		</tr>

		<tr>
			<td colspan="2">&#8205; Leave Pay</td>
			<td style="{{ $c }}">{{ $wage ? number_format($wage->leave_pay, 2) : ""}}</td>
			<td style="{{ $c }}">USD/Month</td>
			<td colspan="2">&#8205; Overtime Rate</td>
			<td style="{{ $c }}"></td>
			<td>&#8205; USD/Hour</td>
		</tr>

		<tr>
			<td colspan="2">&#8205; Other Allowances</td>
			<td style="{{ $c }}">{{ $wage ? number_format($wage->owner_allow, 2) : ""}}</td>
			<td style="{{ $c }}">USD/Month</td>
			<td colspan="2" rowspan="2">
				&#8205; PF Seafarer's Contribution
				<br style='mso-data-placement:same-cell;' />
				&#8205; (per month)
			</td>
			<td rowspan="2" style="{{ $c }}"></td>
			<td rowspan="2">&#8205; USD/Month</td>
		</tr>

		<tr>
			<td colspan="2">&#8205; Fixed Stipend</td>
			<td style="{{ $c }}"></td>
			<td style="{{ $c }}">USD/Month</td>
		</tr>

		<tr>
			<td colspan="2" style="{{ $b }}">&#8205; Wage in Grand Total</td>
			<td style="{{ $c }}"></td>
			<td style="{{ $bc }}">USD/Month</td>
			<td colspan="2">&#8205; Others</td>
			<td style="{{ $c }}"></td>
			<td></td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8">
				&#8205; Kindly note your full wages and applicable allowances will commence with effect from: Upon boarding the vessel.
			</td>
		</tr>

		<tr>
			<td colspan="8">
				&#8205; Basic wages will commence w.e.f. departure from the country of origin till joining the vessel and during sign off basic wages
				<br style='mso-data-placement:same-cell;' />
				&#8205; shall commence for travel days till arrival of country of origin.
			</td>
		</tr>
	</a>

	{{-- 3ND PAGE --}}
	{{ $header(3) }}
	<a>
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $bc }} font-style: 11px;">DECLARATION BY THE SEAFARER</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8">
			ㅤㅤI acknowledge receipt of copy of this “Seafarer’s Employment Agreement” which I have read in conjunction
			</td>
		</tr>

		<tr>
			<td colspan="8">
			ㅤㅤwith MUI/ NUSI / ITF / Company’s Standard Service Terms and Conditions I would request the COMPANY to
			</td>
		</tr>

		<tr>
			<td colspan="8">
			ㅤㅤsettle my monthly onboard income:
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="text-align: right;">&#9745;</td>
			<td></td>
			<td colspan="6">To my personal bank account; or</td>
		</tr>

		<tr>
			<td style="text-align: right;">&#9744;</td>
			<td></td>
			<td colspan="6">To my Manning Agent’s account; or</td>
		</tr>

		<tr>
			<td style="text-align: right;">&#9744;</td>
			<td></td>
			<td colspan="6">All paid in Cash onboard (Applicable to cadet/Rating Trainee only)</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8">
			ㅤㅤThe original Agreement will be kept by the SEAFARER and the Manning Agent, the scanned true copy 
			</td>
		</tr>

		<tr>
			<td colspan="8">
			ㅤㅤto be sent to the Master of the vessel and the COMPANY.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8">
			ㅤㅤIt is agreed that the seafarer's personal data may be passed on to other individuals or organizations as
			</td>
		</tr>

		<tr>
			<td colspan="8">
			ㅤㅤdetermined appropriate by the shipowner or another party acting on behalf of the shipowner, for execution of 
			</td>
		</tr>

		<tr>
			<td colspan="8">
			ㅤㅤthis agreement.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8">
			ㅤㅤNo one shall disclose confidential information to any third party for any purpose other than for the purposes of 
			</td>
		</tr>

		<tr>
			<td colspan="8">
			ㅤㅤthis agreement.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8">
			ㅤㅤI confirm that all certificates, declarations and documents provided are factual and true. All health 
			</td>
		</tr>

		<tr>
			<td colspan="8">
			ㅤㅤconditions known to me have been declared during the PEME (Pre-Employment Medical 
			</td>
		</tr>

		<tr>
			<td colspan="8">
			ㅤㅤExamination) to the Company’s doctor.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8">
			ㅤㅤI will abide by all the international rules and regulations, Safety Management System of the vessel and  
			</td>
		</tr>

		<tr>
			<td colspan="8">
			ㅤㅤthe Company’s policies and procedures.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8">
			ㅤㅤI have read and understood the terms of engagement, appended Annexures and Articles to this contract and 
			</td>
		</tr>

		<tr>
			<td colspan="8">
			ㅤㅤI am in agreement with them.
			</td>
		</tr>

		<tr>
			<td colspan="8">
			</td>
		</tr>

		<tr>
			<td colspan="4" style="{{ $b }}">
				For Solpia Marine &#38; Ship Management, Inc.
				<br style='mso-data-placement:same-cell;' />
				RPSL-MUM-199
				<br style='mso-data-placement:same-cell;' />
				(As agents only, for and on behalf of Owners)
			</td>
			<td colspan="4" style="{{ $b }}">
				I acknowledge receipt of copy of this
				<br style='mso-data-placement:same-cell;' />
				“Seafarer’s Employment Agreement” which I have read in
				<br style='mso-data-placement:same-cell;' />
				conjunction with MUI / NUSI / ITF / Company’s Standard
				<br style='mso-data-placement:same-cell;' />
				Service Terms and Conditions
			</td>
		</tr>

		<tr>
			<td colspan="4" style="{{ $b }}">
				Signature and Stamp:
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				Date &#38; Place: {{ $data->req['date_processed'] }} / MANILA, PHILIPPINES
			</td>

			<td colspan="4" style="{{ $b }}">
				Seafarer's Signature:
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				Date &#38; Place: {{ $data->req['date_processed'] }} / MANILA, PHILIPPINES
			</td>
		</tr>

		<tr>
			<td></td>
			<td colspan="7">Original: Seafarer / For Solpia Marine &#38; Ship Management, Inc.</td>
		</tr>

		<tr>
			<td></td>
			<td colspan="7">CC: Master</td>
		</tr>
	</a>

	{{-- 4TH PAGE --}}
	{{ $header(4) }}
	<a>
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $bc }} {{ $und }} font-style: 11px;">SEAFARER’S EMPLOYMENT AGREEMENT – Part II</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $bc }} font-style: 11px;">SERVICE TERMS AND CONDITIONS</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 1ㅤㅤENGAGEMENT AND DISCHARGE
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">1.1</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				Your employment shall commence from the day you depart from the port of engagement in your country of origin and shall cease on the day you sign off from the vessel in your country of origin or on the day of arrival at the port of engagement, whichever is the later.
			</td>	
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 2ㅤㅤCONTRACT PERIOD OF SERVICE ONBOARD 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">2.1</td>
			<td colspan="7" style="text-align: justify; height: 60px;">
				You shall continue to serve on board for a minimum period of four/ five/six/nine months on board the COMPANY’s vessel. Every effort will be made by the COMPANY to ensure that you will be relieved at the completion of the contract but such period may be extended or reduced by 1 (one) month for operational convenience of the COMPANY. 
			</td>	
		</tr>

		<tr>
			<td style="{{ $c }}">2.2</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				If you request for an extension of contract, the above-mentioned period of 1 (one) month will apply from the expiry date of the extended period. 
			</td>	
		</tr>

		<tr>
			<td style="{{ $c }}">2.3</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				During the period of your employment, you may be required to sail on vessels of any type/size under any flag within normal trading limits and on wages and other benefits as specified in the seafarer’s employment agreement. 
			</td>	
		</tr>

		<tr>
			<td style="{{ $c }}">2.4</td>
			<td colspan="7" style="text-align: justify; height: 60px;">
				During the period of your employment, you may be required to work on vessel/s belonging to any of the company’s subsidiaries or associates or any other company whose vessel(s) are being formally managed by the company. Under such circumstances your salary and all other benefits shall remain as specified in this contract. 
			</td>	
		</tr>

		<tr>
			<td style="{{ $c }}">2.5</td>
			<td colspan="7" style="text-align: justify; height: 75px;">
				During the period of your employment, you may be required to attend the inspections of new building(s) under construction. In the event that accommodation is not available on board the vessel, the company will provide alternative accommodation. The company will either provide transportation to and from your place of work or reimburse you for the actual costs and expenses incurred by you for transportation. 
			</td>	
		</tr>

		<tr>
			<td style="{{ $c }}">2.6</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				In case the vessel on which you are serving is sold / scrapped or the company has lost the management of such vessel, your services may be transferred to any other vessel(s) owned or managed by the company. 
			</td>	
		</tr>

		<tr>
			<td style="{{ $c }}">2.7</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				This employment contract will be deemed to be terminated without any further liability on part of the company on the date of your arrival at the port of engagement in your country of origin irrespective of the reasons for relief.  
			</td>	
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 3ㅤㅤPROBATION PERIOD
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">3.1</td>
			<td colspan="7" style="text-align: justify; height: 60px;">
				The first three (3) months of your service with the company shall be treated as a probationary period. During this period, the company may, by giving fifteen (15) days’ notice in writing or by paying fifteen (15) days basic salary in lieu thereof, cancel this contract without assigning any reasons. You will be repatriated to the port of engagement on the company’s account.  
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">3.2</td>
			<td colspan="7" style="text-align: justify; height: 60px;">
				If you wish to be relieved during the probationary period, you are required to give fifteen (15) days’ notice in writing to the company. The company will endeavor to relieve you within fifteen (15) days after receipt of your notice or at a port of convenience, whichever is later. In such case you will be responsible for your repatriation expenses to the port of engagement in your country of origin.  
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">3.3</td>
			<td colspan="7" style="text-align: justify; height: 75px;">
				In the event you intend to leave the company after having completed the probationary period, you are required to give one (1) month’s written notice and you will be responsible for your repatriation expenses to the port of engagement. In the event that you give less than one (1) month’s written notice, without the company’s consent, you will be responsible for your repatriation expenses to the port of engagement in your country of origin.   
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">3.4</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				If you have finished at least one contract with the company, the probation period referred to in Clause 3.1 is not applicable for your next engagement with the company.   
			</td>
		</tr>
	</a>

	{{-- 5TH PAGE --}}
	{{ $header(5) }}
	<a>
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 4ㅤㅤMEDICAL EXAMINATION 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">4.1</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				Prior to engagement by the company, you shall undergo a medical examination carried out by a doctor appointed either by the company or their liaison office/manning agents. 
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">4.2</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				At the time of your medical examination, you shall provide the doctor with true and complete information pertinent to your current medical condition and past medical history giving details of ailments, if any, you had suffered.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">4.3</td>
			<td colspan="7" style="text-align: justify; height: 60px;">
				Knowingly concealing a pre-existing illness or condition in the pre-employment medical examination shall constitute misrepresentation and you shall be disqualified from any compensation and benefits. This is likewise a cause for termination of employment and imposition of administrative sanctions by the company. 
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">4.4</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				You shall carry the current medical fitness certificate issued by the doctor and present it to the Master upon joining the vessel.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">4.5</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				Crew members proven to be medically unfit for seagoing duties will not be permitted to join the company’s vessel(s).
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 5ㅤㅤJOINING EXPENSES AND ASSISTANCE 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">5.1</td>
			<td colspan="7" style="text-align: justify; height: 60px;">
				The company will assist you to obtain the required certificates (other than national certificates and those that are mandatory as per national/international regulations), licenses and other necessary documents (excluding passport renewal and extensions necessary) for service on vessels of a particular flag.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">5.2</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				The company will reimburse petty expenses incurred by you whilst joining the vessel after your departure from port of engagement, including visa fees, airport tax and hotel accommodation, if any, out of your country of origin. 
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">5.3</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				Your joining expenses, if any, will be settled on board the vessel directly by the Master upon submission of appropriate supporting vouchers/bills after approval from the company.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">5.4</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				While staying in a hotel on the company’s account, you are required to settle all personal expenses incurred by you, for example personal long-distance calls, entertainment of guests, bar, laundry, cigarettes and the like, prior to leaving the hotel.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">5.5</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				For the purpose of securing employment with the company, you are not required to pay any agency fee / charges to any organization.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 6ㅤㅤTRAVEL 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">6.1</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				The company agrees to bring you from the port of engagement to the vessel/shipyard, as applicable, at the commencement of your engagement with the company and to repatriate you to the port of engagement upon the completion of your engagement.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">6.2</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				Where air travel is involved, you will be entitled to travel by economy class. The company will not make any refund in lieu of fare. When traveling by air, you shall limit the weight of your baggage to 30 kg or as endorsed in the air ticket. Any excess baggage charges will be on your account. 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 7ㅤㅤCOMPLAINT PROCEDURE 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">7.1</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				A Complaint Procedure for any grievances that you may have on board the vessel has been established. A copy of this is provided onboard by the employer.
			</td>
		</tr>
	</a>

	{{-- 6TH PAGE --}}
	{{ $header(6) }}
	<a>
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 8ㅤㅤBOARDING &#38; LODGING 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">8.1</td>
			<td colspan="7" style="text-align: justify; height: 90px;">
				During the period of service onboard the vessel you shall be provided with – 
				<br style='mso-data-placement:same-cell;' />
				a)	Sufficient food of good quality; 
				<br style='mso-data-placement:same-cell;' />
				b)	One mattress and at least two pillows, two blankets, two bed sheets, two pillowcases and two towels.
				ㅤThe bed sheets and pillowcases shall be changed at least every second week and towels every week; 
				<br style='mso-data-placement:same-cell;' />
				c)	Necessary cutlery, crockery and toiletries; 
				<br style='mso-data-placement:same-cell;' />
				d)	Laundry facilities onboard and recreational facilities. 
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">8.2</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				During your tenure onboard, the company will provide food and potable water of appropriate quality, nutritional value and quantity taking into account differing cultural and religious backgrounds.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 9ㅤㅤUNIFORMS AND PROTECTIVE CLOTHING
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">9.1</td>
			<td colspan="7" style="text-align: justify; height: 15px;">
				All Seafarers shall be required to wear uniforms during their service on board the vessel.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">9.2</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				If you are required to work in cold weather conditions, you shall be provided with suitable clothing on loan by the company.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">9.3</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				Overalls, safety apparel and safety-working gear shall be provided to you on loan by the company for use on board the vessel. 
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">9.4</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				Safety working gear remains the property of the company and shall be retained on board the vessel at the time when you sign off the vessel. 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 10ㅤㅤWORKING HOURS AND REST PERIODS 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">10.1</td>
			<td colspan="7" style="text-align: justify; height: 15px;">
				The normal working hours shall be 44 hours per week. 
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">10.2</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				The normal working hours is 8 hours daily from Monday to Friday, and 4 hours on Saturday. Sunday is to be considered as a day of rest.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">10.3</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				Overtime work for ratings shall be performed at the direction of the Master or the Master's representative in accordance with the company's policy.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">10.4</td>
			<td colspan="7" style="text-align: justify; height: 60px;">
				Overtime work for ratings shall be computed based on fixed or guaranteed overtime. This fixed rate overtime for seafarers with consolidated wages shall apply to overtime hours of up to 109 hours per month (inclusive of overtime hours performed on Sundays and holidays) taking into account the rest hour requirements under MLC, 2006 and STCW as amended.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">10.5</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				For ratings, overtime work shall also be based on guaranteed overtime. Any hours worked in excess of the maximum 109 hours of overtime per month shall be compensated at the hourly overtime rate.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">10.6</td>
			<td colspan="7" style="text-align: justify; height: 15px;">
				Officers and Trainees: The wages shall be paid as per Part 1 only.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">10.7</td>
			<td colspan="7" style="text-align: justify; height: 75px;">
				In the case of existence of potential danger as determined solely by the Master and in order to maintain safety of the vessel, the seafarer, the passengers and/or cargo onboard, or the saving of lives, or of other vessels, or the training for using lifeboats, or fire equipment, you shall perform the necessary work under any circumstances as required. In such circumstances, the hours worked shall not count as overtime hours.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">10.8</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				You are required to comply with the International Labor Organization’s / Standards of Training, Certification and Watch keeping’s recommended Rest Hours requirements at all times as per the company’s Management System and procedures.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">10.9</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				On a daily basis, you are required to maintain a record of your Hours of Rest in a prescribed format or on the software provided on the vessel.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">ㅤ10.10ㅤ</td>
			<td colspan="7" style="text-align: justify; height: 15px;">
				This record will be verified periodically by a seafarer appointed by the Master.
			</td>
		</tr>
	</a>

	{{-- 7TH PAGE --}}
	{{ $header(7) }}
	<a>
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">ㅤ10.11ㅤ</td>
			<td colspan="7" style="text-align: justify; height: 180px;">
				Rest period shall be as follows:
				<br style='mso-data-placement:same-cell;' />
				a)	Each seafarer shall have a minimum of 10 hours of rest in any 24-hour period and at least 77 hours in 
				ㅤany 7-day period, and the hours of rest may be divided into no more than two periods, one of which
				ㅤshall be at least 6 hours in length. 
				<br style='mso-data-placement:same-cell;' />
				b)	The company shall post in an accessible place on board a table detailing the schedule of service at sea
				ㅤand in port and the minimum hours of rest for each position on board. 
				<br style='mso-data-placement:same-cell;' />
				c)	The requirements for rest periods need not be maintained in the case of emergency or other
				ㅤoverriding operational conditions but in such cases, you shall have adequate compensatory rest
				ㅤperiod thereafter. 
				<br style='mso-data-placement:same-cell;' />
				d)	Emergency drills will be conducted in such a manner that minimizes the disturbance of rest periods
				ㅤand which does not induce fatigue in you. 
				<br style='mso-data-placement:same-cell;' />
				e)	A short break of less than 30 minutes will not be considered a period of rest. 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 11ㅤㅤSALARY 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">11.1</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				Your salary shall be the amount as set out in the Assignment Letter (Part I of the SEAFARER’S EMPLOYMENT AGREEMENT). The remuneration for Sea service period along with other allowances shall commence from actual sign on date onboard Vessel.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">11.2</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				All accounts onboard will be calculated in US Dollars. However, payment will be subject to availability of the US Dollars and governed by the foreign exchange regulations of the country in which the vessel is located.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">11.3</td>
			<td colspan="7" style="text-align: justify; height: 15px;">
				onthly wage slips will be issued to you on board.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">11.4</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				When you sign off from the vessel, you will be issued with a statement of accounts, which computes your earnings and deductions against advances taken onboard. Upon contract completion full wages shall cease upon sign off from vessel.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">11.5</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				Your final payment will be settled prior to your departure on board, in US Dollars or in local currency depending upon the local foreign exchange regulations. However, you can request the company to pay directly to your nominated bank account, with bank charges if any at your account.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 12ㅤㅤLEAVE AND PUBLIC HOLIDAY PAY 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">12.1</td>
			<td colspan="7" style="text-align: justify; height: 15px;">
				You will be entitled to 8 days of earned leave for every month served on board.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">12.2</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				Payment in lieu of leaves shall be calculated on a pro rata basis for any part of a month and paid monthly or at the end of the engagement as stipulated in the company policy for that particular year.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">12.3</td>
			<td colspan="7" style="text-align: justify; height: 15px;">
				You shall be entitled to public holidays as set out in APPENDIX 1.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 13ㅤㅤALLOTMENT 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">13.1</td>
			<td colspan="7" style="text-align: justify; height: 60px;">
				You are entitled to make one allotment per month from your wages earned on board, which will be arranged by the company. Bank costs of additional allotments shall be borne by you. You have to fill up a standard allotment form of the company giving full details of your designated bank, bank account and beneficiary/beneficiaries.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">13.2</td>
			<td colspan="7" style="text-align: justify; height: 15px;">
				The company shall remit the amount of the allotment at the end of each month.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">13.3</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				Under no circumstances shall the company be responsible for any delay in remittance which may be caused due to transactions between the corresponding banks. Confirmation of the remittance advised by the bank should be sufficient proof that the company has remitted the funds.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 14ㅤㅤOTHER ALLOWANCE 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">14.1</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				Other Allowance applies to the Officer’s ranks at their joining the COMPANY’s vessel based on the length of rank experience. This includes Seniority allowance also.
			</td>
		</tr>
	</a>

	{{-- 8TH PAGE --}}
	{{ $header(8) }}
	<a>
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 15ㅤㅤOWNER'S BONUS 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">15.1</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				Top 4 Ranks may be entitled to Owner’s bonus, payable when rejoining vessel subject to completion of his or her contract onboard, prevailing as per COMPANY policies.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">15.2</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				A seafarer who resigns before completing the duration of his or her employment contract or a seafarer who is dismissed for serious misconduct shall not be entitled to any bonus.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 16ㅤㅤMEDICAL AND HOSPITALIZATION 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">16.1</td>
			<td colspan="7" style="text-align: justify; height: 75px;">
				In case you suffer from illness or injury in the course of your employment on board the vessel, the company will provide medical treatment including essential dental care, and hospitalization, if required, at cost to the company until such time as you are declared fit or the degree of your disability has been established by the doctor appointed by the company and provided the illness and injury is not due to your own willful neglect, fault or misconduct.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">16.2</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				During the course of your employment, you shall be entitled to medical consultation and treatment including hospitalization at the expense of the company.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">16.3</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				The company shall be liable to defray the expense of medical care and maintenance incurred until you have been cured or until the sickness or incapacity has been declared to be of a permanent character.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">16.4</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				You shall be entitled to medical, and hospitalization leave on full basic salary for a period not exceeding a total of 130 days for any single or related injury, disablement or illness for the duration of this contract.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">16.5</td>
			<td colspan="7" style="text-align: justify; height: 15px;">
				Medical leave shall only be granted on the recommendation of the company’s appointed doctor(s).
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">16.6</td>
			<td colspan="7" style="text-align: justify; height: 60px;">
				In cases of emergency, the company shall accept a medical leave certificate from a registered medical practitioner other than the company’s appointed doctor(s), provided that the medical leave certificate is presented to the company’s appointed doctor(s) for endorsement as soon as practicable and provided also that the case is referred as soon as practicable to the company’s appointed doctor(s).
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">16.7</td>
			<td colspan="7" style="text-align: justify; height: 150px;">
				The company shall not bear – 
				<br style='mso-data-placement:same-cell;' />
				a)	The cost of dental or optical appliances except for loss or damage incurred in the course of duty not
				ㅤdue to your own willful neglect, fault or misconduct; 	
				<br style='mso-data-placement:same-cell;' />
				b)	Any expenses in respect of pregnancy, confinement or miscarriage; 
				<br style='mso-data-placement:same-cell;' />
				c)	Any expenses arising out of any illness or disease caused by your own willful neglect, fault or
				ㅤmisconduct; or 	
				<br style='mso-data-placement:same-cell;' />
				d)	Any expenses incurred in respect of illness or disablement arising from the misuse of drugs, excessive
				ㅤconsumption of alcohol, participation in any hazardous activities except when endeavoring to
				ㅤsave human life, and the performance of any unlawful act.
				<br style='mso-data-placement:same-cell;' />
				e)	 Blood test and/or treatment for sexually transmitted diseases;
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">16.8</td>
			<td colspan="7" style="text-align: justify; height: 60px;">
				The benefits under this clause may be denied to a seafarer who refuses to make full disclosure of any information concerning his or her illness, disability or medical condition, or refuses to authorize the company’s appointed doctor(s) to disclose any information concerning his or her illness, disability or medical condition.
			</td>
		</tr>
		
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 17ㅤㅤSERVICE IN WARLIKE OPERATIONS AREAS OR HIGH-RISK AREAS 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">17.1</td>
			<td colspan="7" style="text-align: justify; height: 90px;">
				The company shall provide full information of the Warlike Operations Areas or High-Risk Areas inclusion in the vessel’s trading pattern and you shall have the right not to proceed to a Warlike Operations Area or High-Risk Area in which event you shall be repatriated to your country of origin at the company’s expense. Seafarers serving in a Warlike Operations Area shall be paid Bonus equal to 100% of the daily basic wage for the duration of the ship’s stay in a war like operation area – subject to a minimum of 5 days’ pay.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">17.2</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				A seafarer serving in a Warlike Operations Area or High-Risk Area shall be entitled to compensation for injury or death arising from an accident or war like operation as stated in ARTICLE 30 of this Agreement and, for this purpose the company shall affect an accident and war risk insurance cover.
			</td>
		</tr>
	</a>

	{{-- 9TH PAGE --}}
	{{ $header(9) }}
	<a>
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">17.3</td>
			<td colspan="7" style="text-align: justify; height: 150px;">
				In case a seafarer may become captive or otherwise prevented from sailing as a result of an act of piracy or hijacking, irrespective of whether such act takes place within a Warlike Operations Area or High-Risk Area referred to in this clause, the seafarer’s employment status and entitlements under this Agreement shall continue until the seafarer’s release and thereafter until the seafarer is safely repatriated to his/her home or place of engagement. The company’s contractual liabilities to a seafarer in captivity shall not be deemed to end until after the seafarer is safely repatriated to his/her country of origin or port of engagement, notwithstanding the date of expiry of the employment contract. These continued entitlements shall, in particular, include the payment of full wages and other contractual benefits. The company shall also make every practicable effort to provide captured seafarers with extra protection, food, welfare, medical and other assistance as necessary.
			</td>
		</tr>
		
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 18ㅤㅤTAXATION
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">18.1</td>
			<td colspan="7" style="text-align: justify; height: 120px;">
				You will be responsible for all personal taxes whether of an income or capital nature which may be, from time to time, levied upon you. In the event that the company is to pay / has paid such taxes on your behalf, you agree to indemnify the company against all such payments. If any portion of your earnings is to be paid to the state/authority in question as taxes, it will be your own responsibility to make such payments. You are required to disclose to the company at the time of signing your contract, any tax and other legal / bank liability that you are required to comply with. You shall be responsible for any payments levied by the relevant state/authority in the event of late payment of your personal taxes.
			</td>
		</tr>
		
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 19ㅤㅤDISCIPLINE
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">19.1</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				It is agreed that as a condition of employment, the seafarer will be treated in accordance with the working regulations and discipline as stipulated in Appendix 2.
			</td>
		</tr>
		
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 20ㅤㅤNOTICE OF RESIGNATION OR TERMINATION OF CONTRACT
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">20.1</td>
			<td colspan="7" style="text-align: justify; height: 60px;">
				In cases, other than cases of dismissal for serious misconduct, where a seafarer wishes to resign or the company wishes to terminate the contract period of service of a seafarer for just cause, one month’s notice in writing of such resignation or termination or payment of one month’s basic salary in lieu thereof, shall be obligatory for both the seafarer and the company.
			</td>
		</tr>
		
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 21ㅤㅤCOMPENSATION FOR LOSS OF EMPLOYMENT
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">21.1</td>
			<td colspan="7" style="text-align: justify; height: 75px;">
				Where a seafarer’s employment is terminated due to the sale of a vessel or change of the registry or flag or management of the vessel, he or she shall be given one month Notice for repatriation at Company’s expense. In case no notice is served, then the Seafarers will be compensated with one (1) month’s basic salary for such loss of employment if similar continuous employment in the same position in the company is not available.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">21.2</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				A seafarer terminated in accordance with ARTICLE 21.1 above if has been given one (1) month’s written termination notice by the company, and then no such compensation stated in ARTICLE 21.1 will be applicable.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">21.3</td>
			<td colspan="7" style="text-align: justify; height: 75px;">
				Where a ship is wrecked or lost and a seafarer’s employment is terminated due to such wreckage or loss, he or she shall be compensated with one (1) month basic salary for such loss of employment, if similar continuous employment in the same position in the company is not available. Incase Seafarer wishes to proceed on leave and declines transfer to another vessel, no compensation of salary will be applicable.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">21.4</td>
			<td colspan="7" style="text-align: justify; height: 60px;">
				Compensation referred to under ARTICLE 21.1, ARTICLE 21.2 and ARTICLE 21.3 shall not be applicable to a seafarer who has completed the agreed contract period, or when alternative employment is provided for such a seafarer to continue his contract onboard another vessel under the terms of this or other similar agreement.
			</td>
		</tr>
	</a>

	{{-- 10TH PAGE --}}
	{{ $header(10) }}
	<a>
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 22ㅤㅤFAMILY ON BOARD
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">22.1</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				The company may permit the four senior seafarers, i.e. Master, Chief Officer, Chief Engineer and Second Engineer to carry their families on board the vessel.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">22.2</td>
			<td colspan="7" style="text-align: justify; height: 105px;">
				Approval for this privilege will be granted at the discretion of the company and subject to the following: 
				<br style='mso-data-placement:same-cell;' />
				a)	On satisfactory completion of at probation period with the COMPANY. 
				<br style='mso-data-placement:same-cell;' />
				b)	The total number of wives on board for the four senior seafarers referred to in ARTICLE 22.1 does not
				ㅤexceed two at any time. 
				<br style='mso-data-placement:same-cell;' />
				c)	The total number of children on board for the four senior seafarers referred to in the ARTICLE does
				ㅤnot exceed two at any time. The minimum age of the child should be One Year and the maximum
				ㅤage eighteen years.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">22.3</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				In case of a newly acquired vessel by the company, i.e. not less than six (6) months after taking over the vessel, carrying of family members on board the vessel is subject to approval of the COMPANY base on the availability of life boats and lifesaving equipment’s.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">22.4</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				The period, for which wives and children of seafarers are permitted to sail onboard, will be limited within 6 months in total per year.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">22.5</td>
			<td colspan="7" style="text-align: justify; height: 75px;">
				If the company is satisfied after checking that you qualify for this privilege, you will be required to sign a letter of indemnity, after your family joins the vessel, as required by the insurance company. Expenses incurred by your family members, if any, will be on your account. It shall be the responsibility of your family members to take up personal insurance for the entire voyage, including the transit period to and from ship and also while waiting to board vessel whilst ashore.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">22.6</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				You will be responsible for all expenses of your wife and children while they are on board the vessel and also expenses for their passages to and from the vessel, excluding victual expenses for your family, during their tenure on board the vessel.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">22.7</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				Family members joining the vessel must obtain related visas prior to joining the vessel, failing which you shall be responsible for all consequential costs and fines, if any, that may be imposed on the vessel by local immigration authorities.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">22.8</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				In order to avoid increase in work-load on catering staff, family members on board the vessel will have to clear their respective cabins.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">22.9</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				Whenever any family member signs off from the vessel together with the seafarer, the final settlement of wages of the seafarer will be settled at the port of engagement after necessary deductions have been made.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 23ㅤㅤCOMPASSIONATE LEAVE/RELEASE
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">23.1</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				Compassionate leave shall be granted to a seafarer under the following circumstances: 
				a)	Serious illness of the members of the seafarer’s immediate family; 
				b)	Demise of the members of the seafarer’s immediate family; 
				c)	Any natural disaster affecting the seafarer’s immediate family. 
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">23.2</td>
			<td colspan="7" style="text-align: justify; height: 15px;">
				The repatriation expenses of a seafarer who is granted compassionate leave shall be borne by the company.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">23.3</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				Definition of immediate family: 
				a)	If the seafarer is a bachelor, his father and mother shall constitute the members of his immediate family. 
				b)	If the seafarer is married, the members of his immediate family shall consist of his wife and children. 
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">23.4</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				The company shall make every effort to release a seafarer for compassionate leave and the seafarer shall carry on his duties as usual until his replacement takes over from him.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">23.5</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				The company shall have the discretion to grant compassionate leave subject to a replacement seafarer being available.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">23.6</td>
			<td colspan="7" style="text-align: justify; height: 60px;">
				The company reserves the right to release a seafarer from further obligation to complete the contract, with all outstanding payments made to the seafarer, if there is no available position after the seafarer returns from compassionate leave. The seafarer accepts that in such case, the company is not in breach of contract and will not pursue the company for any claims arising thereof.
			</td>
		</tr>
	</a>

	{{-- 11TH PAGE --}}
	{{ $header(11) }}
	<a>
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 24ㅤㅤOVERSEAS TRAVEL
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">24.1</td>
			<td colspan="7" style="text-align: justify; height: 75px;">
				Where a seafarer travels overseas for company business, the company shall pay – 
				<br style='mso-data-placement:same-cell;' />
				a)	All hotel charges, except international phone call and mini bar which supplied in the hotel, meals expenses and valid transportation expenses incurred by the seafarer. 
				<br style='mso-data-placement:same-cell;' />
				b)	Any additional justifiable expenses as may be necessary in carrying out the company business. 
				The company will only reimburse for expenses submitted with appropriate supporting documentation. 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 25ㅤㅤTERMINATION OF EMPLOYMENT
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">25.1</td>
			<td colspan="7" style="text-align: justify; height: 75px;">
				If due to circumstances beyond the control of the company and not through any fault of yours it becomes necessary to terminate your employment before the expiry of your engagement, you will be given one month’s notice in writing or one month’s basic wage in lieu of notice. The company will repatriate you at their cost to the port of engagement. Alternatively, the company reserves the right to ask you to proceed on unpaid leave and repatriate you to the port of engagement at the company’s cost.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">25.2</td>
			<td colspan="7" style="text-align: justify; height: 75px;">
				You may terminate your engagement at any time by giving one month’s notice in writing. The company will endeavor to relieve you of your duties at the end of one month after receiving such notice or if the company requires your service beyond the one month, you will be informed and if you agree, paid for such service. You will be responsible for your repatriation expenses if you elect to terminate your employment. This will be regarded as you leaving the company.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">25.3</td>
			<td colspan="7" style="text-align: justify; height: 150px;">
				You shall be subject to immediate dismissal in the following circumstances: 
				<br style='mso-data-placement:same-cell;' />
				a)	if as a result of drunkenness, you fail to behave in a proper manner, 
				<br style='mso-data-placement:same-cell;' />
				b)	fraud or negligence or incompetence or acting in a way responsible for any losses to owners and/or
				ㅤthe company or 
				<br style='mso-data-placement:same-cell;' />
				c)	if you are found to have accepted unaccounted commission / gratuities / cash compensations from
				ㅤany vessel’s chandlers/ship repairers/ship yard/charterers or 
				<br style='mso-data-placement:same-cell;' />
				d)	if you are involved in the sale of bonded stores, fuel or the vessel’s property to external parties at any
				ㅤtime during your engagement. The company reserves the right to take legal action and recover from
				ㅤyou any outstanding amounts which may be due from you. The decision of the company in this
				ㅤrespect shall be final and binding on you.
				<br style='mso-data-placement:same-cell;' />
				e)	If declaration made by you as per ARTICLE 4.3 and 34.4 is false or misrepresented.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">25.4</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				If at any time during the tenure of this contract the company finds out that your Certificate of Competency is not authentic, the company reserves the right to dismiss you immediately and recover from you all costs and/or losses incurred by the company arising thereof.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">25.5</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				Violations of regulations of the company, local laws, disobedience and insubordination will also result in immediate dismissal without any compensation to you. In such circumstances, you shall pay your own repatriation expenses as well as all joining expenses and relief air fare.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">25.6</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				The repatriation expenses referred to in the ARTICLEs 25.2 to 25.5 above shall be as follows:
				<br style='mso-data-placement:same-cell;' /> 
				a)	For service period exceed 75% of contracted duration and above – seafarer to pay own repatriation
				ㅤexpenses related.
			</td>
		</tr>
		
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 26ㅤㅤREPATRIATION
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">26.1</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				In the event of a seafarer being discharged at a port other than his port of engagement, the company shall bear the cost of repatriation to the port of engagement.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">26.2</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				The company shall also be responsible for his maintenance including hotel expenses while awaiting passage to return to the seafarer’s port of engagement.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">26.3</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				If a seafarer resigns prematurely from the vessel or is dismissed for serious offences while abroad, he or she shall bear the repatriation expenses.
			</td>
		</tr>
	</a>

	{{-- 12TH PAGE --}}
	{{ $header(12) }}
	<a>
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 27ㅤㅤCOMPENSATION FOR LOSS OF PERSONAL EFFECTS 
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">27.1</td>
			<td colspan="7" style="text-align: justify; height: 105px;">
				Subject to ARTICLE 27.2, when a seafarer suffers loss or damage of his or her personal effects as a result of wreck, loss, stranding or abandonment of the vessel, or as a result of fire, flooding, collision or piracy or other maritime accident or peril or occurring while he or she is being transported by air or sea or land (excluding losses occasioned through the seafarer’s fault or negligence), he or she shall be entitled to recover from the company, compensation of up to a maximum of US three thousand five hundred (3500). In the event of a seafarer being discharged at a port other than his port of engagement, the company shall bear the cost of repatriation to the port of engagement.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">27.2</td>
			<td colspan="7" style="text-align: justify; height: 60px;">
				Compensation for loss or damage to a seafarer’s personal effects of high value such as, including but not limited to, money, negotiable securities, gold, silverware, jewelry, ornaments, works of arts or electronic equipment (e.g. cameras) are not recoverable from the company and the seafarer is expected to procure his or her own insurance for such personal effects.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">27.3</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				The seafarer concerned shall certify that any information provided regarding the lost property is true to the best of his or her knowledge.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 28ㅤㅤSHORT MANNING
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">28.1</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				In the event of short manning of the vessel due to any reason whatsoever, the company shall divide all monies (by way of basic salaries) which the company may save by reason of such short manning equally among the seafarers of the department concerned.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">28.2</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				No shorthand money shall be paid in cases where the vessel is laid up in dry dock or at a yard for repairs or in ports where full manning is not required.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 29ㅤㅤSOCIAL SECURITY
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">29.1</td>
			<td colspan="7" style="text-align: justify; height: 90px;">
				The seafarer recognizes and accepts that all payments towards his social security contributions as required under the laws of the country of origin will be deposited by the crew manning agent on his behalf with the relevant authorities. Proof of same is available at the Manning Agent and the seafarer can verify same from his social security account. Social security payments would entitle him to claim for (medical care, sickness, injury, pension…), after his repatriation. Owners will provide such funding to the Crew Manning Agent monthly.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 30ㅤㅤPERSONAL ACCIDENT BENEFITS
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">30.1</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				In case of death in the course of duty onboard the vessel, the company will pay to your next of kin compensation USD 114,018 (USD one hundred fourteen thousand &#38; eighteen only) for Senior Seafarers, Junior Seafarers, Petty Seafarers and Ratings.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">30.2</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				In addition, the company will also pay USD 22,805 only (USD twenty-two thousand eight hundred and five only) to each of your children under the age of eighteen up to a maximum of Four (4) children.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">30.3</td>
			<td colspan="7" style="text-align: justify; height: 75px;">
				If you suffer an accident whilst in the employment of the company through no fault of your own such that your ability to work is reduced as a result thereof, you shall receive from the company a Disability Compensation at a percentage prescribed by the medical practitioner appointed by the company based on the degree of your disability set out at the tables in ARTICLE 30.6 (for Senior Seafarers and Junior Seafarers) and ARTICLE 30.8 (for Cadets, Petty seafarers and ratings).
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">30.4</td>
			<td colspan="7" style="text-align: justify; height: 60px;">
				The total disability compensation, however, is not to exceed: 
				<br style='mso-data-placement:same-cell;' />
				a)	USD 190,027 (USD one hundred ninety thousand &#38; twenty-seven only) for Senior Seafarers
				<br style='mso-data-placement:same-cell;' />
				b)	USD 152,022 (USD one hundred fifty-two thousand &#38; twenty-two only) for Junior Seafarers and
				<br style='mso-data-placement:same-cell;' />
				c)	USD 114,018 (USD one hundred fourteen thousand &#38; eighteen only) for Petty Seafarers/Ratings.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">30.5</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				In case of death of a seafarer during his engagement on board the vessel or ashore, the company shall arrange to pay for the immediate cost of burial or repatriation of last remaining mortals to the domicile country of the seafarer as per wishes of next of kin.
			</td>
		</tr>
	</a>

	{{-- 13TH PAGE --}}
	{{ $header(13) }}
	<a>
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">30.6</td>
			<td colspan="7" style="text-align: justify; height: 310px;">
				In accordance with ARTICLE 30.4 above, the rate of compensation for Senior Seafarers and Junior Seafarers shall be based on the figures set out in the table herein depending on the degree of disability. 
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				Definitions: 
				<br style='mso-data-placement:same-cell;' />
				a)	“Senior Seafarers” for the purpose of this ARTICLE means Master, chief Officer, Chief Engineer and
				ㅤSecond Engineer. 
				<br style='mso-data-placement:same-cell;' />
				b)	“Junior Seafarers” for the purpose of this ARTICLE means Second officer, third officer, Third engineer
				ㅤ&#38; fourth Engineer
				<br style='mso-data-placement:same-cell;' />
				Degree of Disability &#38; Rate of Compensation
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">30.7</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				The rate of compensation for Junior Seafarers and Senior Seafarers for disability shall be based on the figures set out above (ARTICLE 30.6) depending on the degree of disability.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">30.8</td>
			<td colspan="7" style="text-align: justify; height: 250px;">
				In accordance with ARTICLE 30.4 above, the rate of compensation for Cadets, Petty seafarers and ratings shall be based on the figures set out in the table herein depending on the degree of disability. The compensation however shall not exceed a maximum of USD 114,018 only.
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				<br style='mso-data-placement:same-cell;' />
				The company shall provide disability compensation to the seafarer in accordance with the above tables, with any differences, including less than 10% disability, to be pro rata.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">30.9</td>
			<td colspan="7" style="text-align: justify; height: 75px;">
				Compensation shall be paid as stipulated in ARTICLE 30.6 and ARTICLE 30.8 above for all injuries caused by accidents and/or injuries arising during the course of his or her employment and excludes accidents and/or injuries sustained outside the working hours of the injured seafarer. Such compensation shall be extended for injuries arising from other occupational hazards such as war risk, strikes, riot, civil commotion, piracy, kidnap, abduction, and terrorism.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">ㅤ30.10ㅤ</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				A seafarer who suffers temporary incapacity shall be entitled to medical benefits including paid medical and hospitalization leave as stipulated in this contract.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">ㅤ30.11ㅤ</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				Subject to ARTICLE 30.13 if a seafarer dies during service onboard vessel due to any cause including death occurring whilst travelling to and from the vessel, or as a result of marine or other similar peril, the company shall pay the maximum compensation to the affected seafarer.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">ㅤ30.12ㅤ</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				Where the death of a seafarer is due to any willful act, he or she will not receive compensation from the company.
			</td>
		</tr>
	</a>

	{{-- 14TH PAGE --}}
	{{ $header(14) }}
	<a>
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">30.13</td>
			<td colspan="7" style="text-align: justify; height: 105px;">
				You shall be responsible for any cost and benefits arising from any chronic disease(s) contracted before your employment on the present vessel and not disclosed at the time of your engagement. All payments due on account of sickness shall be subjected to the following conditions: 
				<br style='mso-data-placement:same-cell;' />
				a)	You shall comply with the instructions of the company’s agent at the port at which you landed at and
				ㅤbe subject to the recommendations/approval of the attending medical practitioner. 
				<br style='mso-data-placement:same-cell;' />
				b)	You shall report your arrival to the company’s agent as soon as you return to your port of engagement
				ㅤwithin a maximum of 72 hours.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 31ㅤㅤSTRANDED SEAFARER
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">31.1</td>
			<td colspan="7" style="text-align: justify; height: 45px;">
				The company undertakes to repatriate the seafarer if he is stranded at any place as well as to look after or to reasonably maintain, or in the case of death, to transport the mortal remains of the seafarer, as permitted under the local laws where the seafarer met with death.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 32ㅤㅤDESERTION
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">32.1</td>
			<td colspan="7" style="text-align: justify; height: 90px;">
				In the case of desertion, the company can claim from you the losses which you had caused to the vessel. Repatriation expenses and fines or cautions imposed by the immigration office to the deserting employee shall be deducted from your earnings. If you do not present yourself in any office of the company or its agent’s office or on board the vessel, prior to the departure of the vessel, you will be considered a deserter. Your contract will be considered as terminated by the company at no costs / expenses to the company.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 33ㅤㅤTRAINING
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">33.1</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				The company promotes education, training and upgrading of the seafarers serving on or planning to serve on board its managed vessels.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">33.2</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				You may be provided with a training records book, and it is your responsibility to ensure that the training tasks identified therein are completed as scheduled.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">33.3</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				You may also be required to complete a computer-based training modules as per the training matrix provided on board the vessels.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 34ㅤㅤDECLARATION
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">34.1</td>
			<td colspan="7" style="text-align: justify; height: 60px;">
				I, the under signed employee declare that I have read and fully understood the contents of this contract. I also confirm that no verbal promises other than the terms and conditions in this contract have been made to me. I will not claim any additional benefits or wages of any kind what so ever except those which have been stipulated in this contract.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">34.2</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				I further hereby confirm that I will not, at any time, while employed under the forgoing terms, enter into any contract or agreement, written or oral, which may be in conflict with or which may contradict the forgoing terms in any way.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">34.3</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				All the terms and conditions under this contract are subject to the national laws/regulations of the jurisdiction wherein the seafarer is a national of.
			</td>
		</tr>

		<tr>
			<td style="{{ $c }}">34.4</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				I, undersigned employee hereby declare that I have never been deported from any country and never been prosecuted.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 35ㅤㅤSEVERABILITY
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">35.1</td>
			<td colspan="7" style="text-align: justify; height: 60px;">
				If any provision of this AGREEMENT or part thereof is rendered void, illegal or unenforceable by any legislation to which it is subject, it shall be rendered void, illegal or unenforceable to that extent and it shall in no way affect or prejudice the enforceability of the remainder of such provision or the other provisions of this AGREEMENT.
			</td>
		</tr>
	</a>

	{{-- 15TH PAGE --}}
	{{ $header(15) }}
	<a>
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $b }}">
				ARTICLE 36ㅤㅤSIGNATURE
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $c }}">36.1</td>
			<td colspan="7" style="text-align: justify; height: 30px;">
				IN WITNESS WHERE OF the parties hereto have hereunto set their hands the date and year hereinbefore mentioned.
			</td>
		</tr>

		<tr>
			<td colspan="8" style="height: 30px;"></td>
		</tr>

		<tr>
			<td colspan="4" style="{{ $bc }}">The Seafarer</td>
			<td colspan="4" style="{{ $bc }}">As agents for and on behalf of:</td>
		</tr>

		<tr>
			<td colspan="2">ㅤName</td>
			<td colspan="2" style="{{ $c }}">{{ $data->user->fullName2 }}</td>
			<td colspan="2">ㅤName</td>
			<td colspan="2" style="{{ $c }}">SHIRLEY ERASQUIN</td>
		</tr>

		<tr>
			<td colspan="2">ㅤRank</td>
			<td colspan="2" style="{{ $c }}">{{ $data->pro_app->rank->name }}</td>
			<td colspan="2">ㅤPosition</td>
			<td colspan="2" style="{{ $c }}">CREWING MANAGER</td>
		</tr>

		<tr>
			<td colspan="2">ㅤPlace</td>
			<td colspan="2" style="{{ $c }}">MANILA, PHILIPPINES</td>
			<td colspan="2">ㅤPlace</td>
			<td colspan="2" style="{{ $c }}">MANILA, PHILIPPINES</td>
		</tr>

		<tr>
			<td colspan="2">ㅤDate</td>
			<td colspan="2" style="{{ $c }}">{{ $data->req['date_processed'] }}</td>
			<td colspan="2">ㅤDate</td>
			<td colspan="2" style="{{ $c }}">{{ $data->req['date_processed'] }}</td>
		</tr>

		<tr>
			<td colspan="2">ㅤShip</td>
			<td colspan="2" style="{{ $c }}">MT BRAVE</td>
			<td colspan="2">ㅤShip</td>
			<td colspan="2" style="{{ $c }}">MT BRAVE</td>
		</tr>

		<tr>
			<td colspan="2">ㅤSign</td>
			<td colspan="2" style="{{ $c }}"></td>
			<td colspan="2">ㅤSign</td>
			<td colspan="2" style="{{ $c }}"></td>
		</tr>
	</a>

	{{-- 16TH PAGE --}}
	{{ $header(16) }}
	<a>
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $bc }} font-size: 11px;">
				APPENDIX 1 LISTS OF PUBLIC HOLIDAYS
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td style="{{ $bc }}">No.</td>
			<td colspan="3" style="{{ $bc }}">Public Holidays</td>
			<td colspan="2" style="{{ $bc }}">Date</td>
			<td colspan="2" style="{{ $bc }}">Days</td>
		</tr>

		<tr>
			<td style="{{ $c }}">1</td>
			<td colspan="3">&#8205; New Year's Day</td>
			<td colspan="2" style="{{ $c }}">Jan 1</td>
			<td colspan="2" style="{{ $c }}">1</td>
		</tr>

		<tr>
			<td style="{{ $c }}">2</td>
			<td colspan="3">&#8205; Republic Day</td>
			<td colspan="2" style="{{ $c }}">Jan 26th</td>
			<td colspan="2" style="{{ $c }}">1</td>
		</tr>

		<tr>
			<td style="{{ $c }}">3</td>
			<td colspan="3">&#8205; Indian National Maritime Day</td>
			<td colspan="2" style="{{ $c }}">Apr 5th</td>
			<td colspan="2" style="{{ $c }}">1</td>
		</tr>

		<tr>
			<td style="{{ $c }}">4</td>
			<td colspan="3">&#8205; International Labor Day</td>
			<td colspan="2" style="{{ $c }}">May 1st</td>
			<td colspan="2" style="{{ $c }}">1</td>
		</tr>

		<tr>
			<td style="{{ $c }}">5</td>
			<td colspan="3">&#8205; Indian Independence Day</td>
			<td colspan="2" style="{{ $c }}">Aug 15th</td>
			<td colspan="2" style="{{ $c }}">1</td>
		</tr>

		<tr>
			<td style="{{ $c }}">6</td>
			<td colspan="3">&#8205; Mahatma Gandhi’s Birthday</td>
			<td colspan="2" style="{{ $c }}">Oct 2nd</td>
			<td colspan="2" style="{{ $c }}">1</td>
		</tr>

		<tr>
			<td style="{{ $c }}">7</td>
			<td colspan="3">&#8205; Ramzan Eid</td>
			<td colspan="2" style="{{ $c }}">Variable date</td>
			<td colspan="2" style="{{ $c }}">1</td>
		</tr>

		<tr>
			<td style="{{ $c }}">8</td>
			<td colspan="3">&#8205; India Diwali Festival</td>
			<td colspan="2" style="{{ $c }}">Falls in Oct/Nov</td>
			<td colspan="2" style="{{ $c }}">1</td>
		</tr>

		<tr>
			<td style="{{ $c }}">9</td>
			<td colspan="3">&#8205; Seafarers Unity Day (Ratings)</td>
			<td colspan="2" style="{{ $c }}">Nov-06</td>
			<td colspan="2" style="{{ $c }}">1</td>
		</tr>

		<tr>
			<td style="{{ $c }}">10</td>
			<td colspan="3">&#8205; MUI Day (Officers)</td>
			<td colspan="2" style="{{ $c }}">Dec-03</td>
			<td colspan="2" style="{{ $c }}">1</td>
		</tr>

		<tr>
			<td style="{{ $c }}">11</td>
			<td colspan="3">&#8205; Christmas Day</td>
			<td colspan="2" style="{{ $c }}">Dec 25th</td>
			<td colspan="2" style="{{ $c }}">1</td>
		</tr>

		<tr>
			<td colspan="7" style="{{ $bc }}">Total Days</td>
			<td style="{{ $c }}">11</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $b }}"> Remarks:</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8">
				ㅤㅤ1.	The PRINCIPAL ensures implement of 10 days as public holidays onboard its fleet vessels.
			</td>
		</tr>

		<tr>
			<td colspan="8">
				ㅤㅤ2.	Specified date(s) of Festivals by Lunar will be notified to the relevant parties; 
			</td>
		</tr>

		<tr>
			<td colspan="8" style="height: 30px;">
				ㅤㅤ3.	The PRINCIPAL reserves the right of nomination of the dates in view of internationals crew-compliments on board
				<br style='mso-data-placement:same-cell;' />
				ㅤㅤㅤships. 
			</td>
		</tr>
	</a>

	{{-- 17TH PAGE --}}
	{{ $header(17) }}
	<a>
		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $bc }} font-size: 11px;">
				APPENDIX 2 CODE OF DISCIPLINE APPLICABLE TO ALL SEAFARERS
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $b }}">INTRODUCTION</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8" style="height: 30px; text-align: justify;">
				This Code of Discipline will apply to all seafarers while onboard and on business for the Company. The code is in two sections: Misconduct and inefficiency.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $b }}">Part 1 MISCONDUCT</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8" style="height: 45px; text-align: justify;">
				The following offences are those for which the Company is entitled to terminate the Agreement with the seafarer either immediately or at the end of the voyage according to the circumstances of the case. This is apart from any legal action which may be called for under the regulations of the Flag of Registry.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8">Assault:</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8">
				1ㅤㅤWillful damage to ship or any property onboard;
			</td>
		</tr>

		<tr>
			<td colspan="8">
				2ㅤㅤTheft or possession of stolen property;
			</td>
		</tr>

		<tr>
			<td colspan="8">
				3ㅤㅤPossession of offensive weapons;
			</td>
		</tr>

		<tr>
			<td colspan="8">
				4ㅤㅤPersistent or willful failure to perform duty;
			</td>
		</tr>

		<tr>
			<td colspan="8">
				5ㅤㅤUnlawfully possess of drug and non-compliance with the anti-drug campaign of the company;
			</td>
		</tr>

		<tr>
			<td colspan="8">
				6ㅤㅤCollision with other at sea to impede the progress of the voyage or navigation of the ship;
			</td>
		</tr>

		<tr>
			<td colspan="8">
				7ㅤㅤDisobedience of order relating to safety of the ship or any person onboard;
			</td>
		</tr>

		<tr>
			<td colspan="8">
				4ㅤㅤPersistent or willful failure to perform duty;
			</td>
		</tr>

		<tr>
			<td colspan="8">
				8ㅤㅤTo be asleep on duty or fall to remain duty if such conduct would prejudice the safety of the ship or of any person onboard;
			</td>
		</tr>

		<tr>
			<td colspan="8">
				9ㅤㅤIncapacity through the influence of drink or drugs to carry out duty to the prejudice of the safety of the ship or to any person onboard;
			</td>
		</tr>

		<tr>
			<td colspan="8">
				10ㅤTo smoke, use a naked light or an unapproved electric torch in any part of the ship carrying dangerous cargo or stores where smoking or the use of naked lights or unapproved torches is prohibited. 
			</td>
		</tr>

		<tr>
			<td colspan="8">
				11ㅤIntimidation, coercion and interference with the work of other seafarers;
			</td>
		</tr>

		<tr>
			<td colspan="8">
				12ㅤBehaviors which seriously detract from the social well-being of another crew onboard.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8">
				Offences of a lesser degree or seriousness may be dealt with by:
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8">
				1ㅤㅤInformal warnings administered by the Master, or
			</td>
		</tr>

		<tr>
			<td colspan="8">
				2ㅤㅤWarnings by the Master recorded in the Ship's official log book and also on the appropriate Company forms; or 
			</td>
		</tr>

		<tr>
			<td colspan="8">
				3ㅤㅤWritten reprimands administered by the Master and recorded in the ship's official log book and on the appropriate Company forms.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $b }}">Part 2 INEFFICIENCY</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8" style="text-align: justify; height: 60px;">
				It must be assumed that inefficiency can either be voluntary or involuntary, in other words, the seafarer's Agreement will be terminated if he is unable by reason of inadequate skills, physical or mental incapacity to carry out the tasks for which he was engaged, or if he is unwilling to exercise his skills or energies to a sufficient degree to carry out his tasks to acceptable standards.
			</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8" style="{{ $b }}">Part 3 EXPENSES</td>
		</tr>

		<tr>
			<td colspan="8"></td>
		</tr>

		<tr>
			<td colspan="8" style="text-align: justify; height: 30px;">
				In cases of dismissal of an employee due to any reasonable expenses for own repatriation shall be borne by the employee. The Company may however, at its sole discretion reduce such expenses for pro-rata service onboard.
			</td>
		</tr>
	</a>
</table>