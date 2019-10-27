<table>
	<tr>
		<td colspan="15">SEAFARER'S EMPLOYMENT CONTRACT</td>
	</tr>

	<tr>
		<td colspan="15"></td>
	</tr>

	<tr>
		<td>Date</td>
		<td></td>
		<td>{{ now()->parse($data->date_processed)->format('d-M-y') }}</td>
		<td colspan="3">and agreed to be effective from</td>
		<td></td>
		<td colspan="4">{{ now()->parse($data->effective_date)->format("d-M-y") }}</td>
		<td>till</td>
		<td colspan="3">{{ now()->parse($data->valid_till)->format('d-M-y') }}</td>
	</tr>

	<tr>
		<td colspan="6"></td>
		<td>at</td>
		<td colspan="4">MANILA, PHILIPPINES</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="15"></td>
	</tr>

	<tr>
		<td colspan="15">This Employment Contract is entered into between the Seafarer and the Owner/Agent of the Owner of the ship (hereinafter</td>
	</tr>

	<tr>
		<td colspan="15">called the Company)</td>
	</tr>

	<tr>
		<td colspan="15"></td>
	</tr>
	<tr>
		<td colspan="15">THE SEAFARER</td>
	</tr>

	<tr>
		<td colspan="5">Date of Birth and Place:</td>
		<td colspan="10">Given names:</td>
	</tr>
 
	{{-- OUTPUT NAMES --}}
	<tr>
		<td colspan="5">{{ $data->user->lname }}</td>
		<td colspan="10">{{ $data->user->fname }}</td>
	</tr>

	<tr>
		<td colspan="15">Full home address:</td>
	</tr>
	
	{{-- OUTPUT ADDRESS --}}
	<tr>
		<td colspan="15">{{ $data->provincial_address }}</td>
	</tr>

	<tr>
		<td colspan="5">Position:</td>
		<td colspan="10">Medical certificate issued on:</td>
	</tr>
	
	{{-- OUTPUT POSITION AND MED CERT --}}
	<tr>
		<td colspan="5">{{ $data->position }}</td>
		<td colspan="10">{{ now()->parse($data->med_date)->format('d-M-y') }}</td>
	</tr>

	<tr>
		<td colspan="5">Nationality:</td>
		<td colspan="10">Passport no:</td>
	</tr>
	
	{{-- OUTPUT NATIONALITY AND PP NO --}}
	<tr>
		<td colspan="5">FILIPINO</td>
		<td colspan="10">{{ $data->{'PASSPORT'} }}</td>
	</tr>

	<tr>
		<td colspan="5">Date of Birth and Place:</td>
		<td colspan="10">Seaman's book no:</td>
	</tr>
	
	{{-- OUTPUT DOB AND SB NO --}}
	<tr>
		<td colspan="5">{{ $data->user->birthday->format('d/M/Y') . ' - ' . $data->birth_place }}</td>
		<td colspan="10">{{ $data->{"SEAMAN'S BOOK"} }}</td>
	</tr>

	<tr>
		<td colspan="15"></td>
	</tr>

	<tr>
		<td colspan="15">THE EMPLOYER</td>
	</tr>

	<tr>
		<td colspan="15">Name:</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="13">NITTA KISEN KAISHA LTD.</td>
	</tr>

	<tr>
		<td colspan="15">Address:</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="13">SHIN MEIKAI BUILDING, 4, KAIGAN-DORI, CHO-KU, KOBE, 650-0024, HYOGO PREF, JAPAN.</td>
	</tr>

	<tr>
		<td colspan="15"></td>
	</tr>

	<tr>
		<td colspan="15">THE SHIP</td>
	</tr>

	<tr>
		<td colspan="8">Name:</td>
		<td colspan="7">IMO No:</td>
	</tr>
	
	{{-- OUTPUT VESSEL NAME AND IMO --}}
	<tr>
		<td colspan="8">{{ $data->vessel->name }}</td>
		<td>
			{{-- EMPTY --}}
		</td>
		<td colspan="6">9473688</td>
	</tr>

	<tr>
		<td colspan="5">Flag:</td>
		<td colspan="10">Port of registry:</td>
	</tr>
	
	{{-- OUTPUT VESSEL FLAG AND PORT OF REGISTRY--}}
	<tr>
		<td colspan="5">{{ $data->vessel->flag }}</td>
		<td colspan="4">
			{{-- EMPTY --}}
		</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="15"></td>
	</tr>

	<tr>
		<td colspan="15">TERMS OF THE CONTRACT</td>
	</tr>

	<tr>
		<td colspan="4">Period of employment:</td>
		<td colspan="4">Wages from and including:</td>
		<td colspan="7">Basic hours of work and rest per week:</td>
	</tr>
	
	{{-- OUTPUT THINGS --}}
	<tr>
		<td colspan="4">{{ $data->employment_months . ' MONTHS' }}</td>
		<td colspan="4">
			{{-- EMPTY --}}
		</td>
		<td colspan="7">40 HOURS / 77 HOURS IN ANY 7 DAY</td>
	</tr>

	<tr>
		<td colspan="4">Monthly Basic wages:</td>
		<td colspan="4">Monthly Overtime (103 hours guaranteed)</td>
		<td colspan="7">Overtime rate for hours worked in excess 103 hrs:</td>
	</tr>
	
	{{-- OUTPUT THINGS --}}
	<tr>
		<td colspan="4">{{ $data->wage->currency . number_format($data->wage->basic, 2) }}</td>
		<td colspan="4">{{ $data->wage->currency . number_format($data->wage->fot, 2) }}</td>
		<td colspan="2">
			{{-- EMPTY --}}
		</td>
		<td>{{ $data->wage->currency . number_format($data->wage->ot, 2) }}</td>
		<td>
			{{-- EMPTY --}}
		</td>
		<td colspan="3">per hour</td>
	</tr>

	<tr>
		<td colspan="4">Leave: Number of days per month</td>
		<td colspan="4">Monthly leave pay:</td>
		<td colspan="3">Supervisor Allowance:</td>
		<td colspan="3">Subsistence Allow</td>
		<td>Retire Allowance</td>
	</tr>
	
	{{-- OUTPUT THINGS --}}
	<tr>
		<td colspan="2">
			{{-- EMPTy --}}
		</td>
		<td colspan="2">9 DAYS</td>
		<td colspan="4">{{ $data->wage->currency . number_format($data->wage->leave_pay, 2) }}</td>
		<td colspan="3">{{ $data->wage->currency . number_format($data->wage->sup_allow, 2) }}</td>
		<td colspan="3">{{ $data->wage->currency . number_format($data->wage->sub_allow, 2) }}</td>
		<td>{{ $data->wage->currency . number_format($data->wage->retire_allow, 2) }}</td>
	</tr>

	<tr>
		<td colspan="15">1. The current CBA shall be considered to be incorporated into and to form part of the contract.</td>
	</tr>

	<tr>
		<td colspan="15">2. The Ship's Articles shall be deemed for all purposes to include the terms of this contract (including the applicable CBA) and it shall be the duty of</td>
	</tr>

	<tr>
		<td colspan="15">the Company to ensure that the ship's Articles reflect these terms. These terms shall take precedence over all other terms.</td>
	</tr>

	<tr>
		<td colspan="15">3. The Seafarer has received, read, understood and agreed to the terms and conditions of employment as identified in the CBA and enters into this Contract freely.</td>
	</tr>

	<tr>
		<td colspan="15">
			{{-- EMPTY --}}
		</td>
	</tr>

	<tr>
		<td colspan="15">
			{{-- EMPTY --}}
		</td>
	</tr>

	<tr>
		<td colspan="15">CONFIRMATION OF THE CONTRACT</td>
	</tr>

	<tr>
		<td colspan="5">Signature of Employer: Owners / Representative of Owners</td>
		<td colspan="10">Signature of Seafarer:</td>
	</tr>

	<tr>
		<td colspan="5">
			{{-- EMPTY --}}
		</td>
		<td colspan="10">
			{{-- EMPTY --}}
		</td>
	</tr>
	
	{{-- OUTPUT NAME OF CREW --}}
	<tr>
		<td colspan="5">C/E ROMANO A. MARIANO - President</td>
		<td colspan="10">{{ $data->user->lname . ', ' . $data->user->fname }}</td>
	</tr>

	<tr>
		<td colspan="15">On Behalf of Nitta Kisen Kaisha Ltd., Owners</td>
	</tr>
</table>