@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b$c";

	$excrew = false;
	foreach($data->sea_service as $ss){
		if(str_contains($ss->manning_agent, 'SOLPIA')){
			$excrew = true;
		}
	}
@endphp

<table>
	<tr>
		<td colspan="13" style="height: 40px;"></td>
	</tr>

	<tr>
		<td colspan="13" style="{{ $bc }} font-size: 14px; height: 20px;">
			LINE-UP/DISPATCH CHECKLIST
		</td>
	</tr>

	<tr>
		<td colspan="8"></td>
		<td style="{{ $bc }}">{{ $excrew ? "✓" : "" }}</td>
		<td colspan="2" style="{{ $b }}">‎Ex-Crew</td>
		<td style="{{ $bc }}">{{ $excrew ? "" : "✓" }}</td>
		<td style="{{ $b }}">‎New Hire</td>
	</tr>

	<tr>
		<td colspan="13"></td>
	</tr>

	<tr>
		<td style="{{ $b }}">NAME:</td>
		<td colspan="5" style="{{ $c }}">{{ $data->user->namefull }}</td>
		<td style="{{ $b }} text-align: right;">RANK:</td>
		<td colspan="6" style="{{ $c }}">{{ $data->rank }}</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $b }}">VESSEL/FLAG:</td>
		<td colspan="4" style="{{ $c }}">{{ $data->vessel ? $data->vessel->name . " / " . $data->vessel->flag : "-" }}</td>
		<td colspan="4" style="{{ $b }} text-align: right;">CONTRACT DURATION:</td>
		<td colspan="3" style="{{ $c }}">{{ $data->employment_months }}</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $b }}">TENTATIVE JOINING DATE:</td>
		<td colspan="3" style="{{ $c }}">{{ $data->eld ? now()->parse($data->eld)->format('d-M-Y') : "-" }}</td>
		<td colspan="3" style="{{ $b }} text-align: right;">JOINING PORT:</td>
		<td colspan="4" style="{{ $c }}">{{ $data->port }}</td>
	</tr>

	<tr>
		<td colspan="13" style="height: 10px;"></td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $bc }}">CONCERNED DEPARTMENT</td>
		<td style="{{ $bc }}">DATE CHECKED</td>
		<td colspan="2" style="{{ $bc }}">DATE COMPLIED</td>
		<td colspan="4" style="{{ $bc }}">PIC WITH SIGNATURE</td>
		<td colspan="2" style="{{ $bc }}">REMARKS</td>
	</tr>

	<tr>
		<td colspan="13" style="{{ $b }}">A. CREWING</td>
	</tr>

	<tr>
		<td colspan="4">1. Approval of Principal</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">2. Data Privacy Consent</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">3. Seafarer's Health Assessment Questionnaire</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">4. PEME Referral</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">5. Crew Review POEA/MLC Contract</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">6. Crew Sign POEA/MLC Contract</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">7. Type Specific ECDIS</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">8. Uniform (Coverall &#38; Safety Shoes)</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">9. Onboard Complaint Procedure</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="13" style="{{ $b }}">B. DOCUMENTATION / PROCESSING</td>
	</tr>

	<tr>
		<td colspan="4">1. SEA Processing</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">2. Flag State Documents</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">3. SRN / E-Reg</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">4. SID</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">5. COC / COP / GOC</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">6. US Visa</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">7. Entry/Transit Visa</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">8. MCV</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="13" style="{{ $b }}">C. TRAINING</td>
	</tr>

	<tr>
		<td colspan="4">1. In-House (PDOS/AP/ISM/MCRA)</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">2. KML Training</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">3. Special Training</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="13" style="{{ $b }}">D. ACCOUNTING</td>
	</tr>

	<tr>
		<td colspan="4">1. Allotment Form</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">2. ATM/Passbook (Photocopy)</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">3. SSS ID / E1 (Photocopy)</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">4. Philhealth ID (Photocopy)</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">5. ID Picture</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">6. Cash Advance Form</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="13" style="{{ $b }}">E. OTHER REQUIREMENTS (Owner/Vessel Required Trainings, Publication/Briefing Materials, etc.)</td>
	</tr>

	<tr>
		<td colspan="4">1. ‎</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">2. ‎</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">3. ‎</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">4. ‎</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">5. ‎</td>
		<td style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="13" style="height: 10px;"></td>
	</tr>

	<tr>
		<td style="font-style: italic;">NOTE:</td>
		<td colspan="12" style="font-style: italic;">
			1. PIC responsible for the process must affix initial signature as a sign of actual confirmation.
		</td>
	</tr>

	<tr>
		<td style="font-style: italic;"></td>
		<td colspan="12" style="font-style: italic;">
			2. Fleet In-Charge must counter check to ensure compliance to the required process for smooth crew embarkation.
		</td>
	</tr>

	<tr>
		<td style="font-style: italic;"></td>
		<td colspan="12" style="font-style: italic;">
			3. This form must be returned to SMI and shall be filed in crew 201 File for future reference.
		</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $b }}">RECEIVED BY:</td>
		<td></td>
		<td colspan="7" style="{{ $b }}">ISSUED BY:</td>
	</tr>

	<tr>
		<td colspan="5" style="height: 30px;">{{ $data->user->fullname2 }} / {{ now()->format('d-M-Y') }}</td>
		<td></td>
		<td colspan="7" style="height: 30px;">
			@if(auth()->user()->gender == "Male")
				MR. {{ auth()->user()->fullname2 }} / {{ now()->format('d-M-Y') }}
			@else
				MS. {{ auth()->user()->fullname2 }} / {{ now()->format('d-M-Y') }}
			@endif
		</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $b }}">CREW's SIGNATURE OVER PRINTED NAME / DATE</td>
		<td></td>
		<td colspan="7" style="{{ $b }}">CREWING OFFICER'S NAME &#38; SIGNATURE / DATE</td>
	</tr>

	<tr>
		<td colspan="13" style="height: 20px;"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $b }}">REVIEWED BY:</td>
		<td></td>
		<td colspan="7"></td>
	</tr>

	<tr>
		<td colspan="5" style="height: 30px;">
			@if(auth()->user()->fleet == "FLEET A")
				Ms. Precian Cervantes
			@elseif(auth()->user()->fleet == "FLEET B")
				Mr. Adulf Kit Jumawan
			@elseif(auth()->user()->fleet == "FLEET c")
				Ms. Jeanette Solidum
			@elseif(auth()->user()->fleet == "FLEET D")
				Ms. Thea Mae Guerra
			@elseif(auth()->user()->fleet == "FLEET E")
				Mr. Dennis Quiño
			@endif
		</td>
		<td></td>
		<td colspan="7"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $b }}">FLEET IN-CHARGE'S NAME &#38; SIGNATURE / DATE</td>
		<td></td>
		<td colspan="7"></td>
	</tr>
</table>