
@php
	$applicants = $data['applicants'];
	$data = $data['data'];
@endphp

<table style="width: 100%; font-family: Arial;">
	@foreach($applicants as $applicant)

		<tr>
			<td colspan="7" style="text-align: center; font-weight: bold; font-size: 25px;">
				PASSPORT AND SEAMAN'S BOOK
			</td>
		</tr>

		<tr>
			<td colspan="7" style="text-align: center; font-weight: bold; font-size: 25px;">
				ACKNOWLEDGEMENT
			</td>
		</tr>

		<br>

		<tr>
			<td colspan="7">
				<hr style="color: #00CCFF;">
			</td>
		</tr>

		<br>

		<tr>
			<td colspan="7" style="font-weight: bold;">
				Acknowledgement
			</td>
		</tr>

		<br>

		<tr>
			<td colspan="7" style="text-align: justify;">
				I, <span style="text-decoration: underline;">{{ $applicant->user->namefull }}</span>, acknowledge that before embarking on my assigned vessel, <span style="text-decoration: underline;">{{ $applicant->pro_app->vessel->name }}</span>, I received my Passport and Seaman's Book from the crewing officers during the final deployment/dispatch process. I confirm that, at the time these documents were handed over to me, they were free from damage, cuts, or visible defects.
			</td>
		</tr>

		<br>

		<tr>
			<td colspan="7" style="font-weight: bold;">
				Declaration and Responsibility
			</td>
		</tr>

		<br>

		<tr>
			<td style="width: 5%;"></td>
			<td style="width: 5%;">&#8226;</td>
			<td colspan="5" style="text-align: justify;">
				I fully acknowledge receipt of my Passport and Seaman's Book before vessel deployment.
			</td>
		</tr>

		<tr>
			<td></td>
			<td>&#8226;</td>
			<td colspan="5" style="text-align: justify;">
				I confirm that I personally inspected the documents and found them complete, valid, and in good physical condition att the time of release.
			</td>
		</tr>

		<tr>
			<td></td>
			<td>&#8226;</td>
			<td colspan="5" style="text-align: justify;">
				I accept full responsibility for the safekeeping, proper handling, and return of these documents when required by the company.
			</td>
		</tr>

		<tr>
			<td></td>
			<td>&#8226;</td>
			<td colspan="5" style="text-align: justify;">
				I shall immediately report any loss, damage, discrepancy, or concern regarding these documents to the crewing department or authorized company representative.
			</td>
		</tr>

		<tr>
			<td></td>
			<td>&#8226;</td>
			<td colspan="5" style="text-align: justify;">
				I shall not lend, transfer, surrender, alter, tamper my passport.
			</td>
		</tr>

		<tr>
			<td></td>
			<td>&#8226;</td>
			<td colspan="5" style="text-align: justify;">
				I shall ensure that these documents remain available, valid, and ready for inspection by the company, port authorities, immigration officials, vessel representatives, or other authorized parties when required.
			</td>
		</tr>

		<tr>
			<td></td>
			<td>&#8226;</td>
			<td colspan="5" style="text-align: justify;">
				I shall promptly inform the crewing department of any change in the status, validity, location, or condition of these documents, including expiration, missing pages, stains, tears, or any other irregularity.
			</td>
		</tr>

		<tr>
			<td></td>
			<td>&#8226;</td>
			<td colspan="5" style="text-align: justify;">
				I shall cooperate with any company investigation, documentation process, replacement procedure, or written explanation required in connection with the loss, damage, misuse, or delayed return of these documents.
			</td>
		</tr>

		<tr>
			<td></td>
			<td>&#8226;</td>
			<td colspan="5" style="text-align: justify;">
				Failure to comply with these responsibilities may result in, disciplinary action in accordance with company policy, recovery of costs related to replacement or processing, and/or reporting to the appropriate authorities when required by law or regulation.
			</td>
		</tr>

		<br>

		<tr>
			<td colspan="7" style="text-align: center;">
				Signed on the <span style="text-decoration: underline;">      {{ now()->parse($data['signed_date'])->format("jS") }}      </span> day of  <span style="text-decoration: underline;">{{ now()->parse($data['signed_date'])->format("F") }}</span> {{ now()->format('Y') }}.
			</td>
		</tr>

		<br>

		<tr>
			<td colspan="7" style="text-align: center;">
				<span style="font-weight: bold;">Date of Dispatch: </span> <span style="text-decoration: underline;">{{ now()->parse($data['dispatch_date'])->format('F j, Y') }}</span>
			</td>
		</tr>

		<br>
		<br>

		{{-- 
		6109 MIRANDA
		8377 SALVACION.J
		9080 cuestas

		5716 AGUILAR
		7595 Berma
		9018 MARCO

		5007 Onate
		8122 Achurra
		9086 VANGUARDIA

		9306 PINEDA
		8968 SALVACION.B
		9310 JUNIO
		--}}

		<tr>
			<td colspan="4" style="text-decoration: underline; text-align: center;">
				<span style="color: white;">---</span>
				{{ $applicant->user->namefull }}
				<span style="color: white;">---</span>
			</td>
			<td></td>
			<td colspan="2" style="text-decoration: underline; text-align: center;">
				@if(in_array(auth()->user()->id, [6109, 8377, 9080, 5716, 7595, 9018, 5007, 8122, 9086, 9306, 8968, 9310]))
					<span style="color: white;">---</span>
					@if(in_array(auth()->user()->id, [6109, 8377, 9080]))
						MR. SALVACION, JAYSON
					@elseif(in_array(auth()->user()->id, [5716, 7595, 9018]))
						MS. BERMA, KIMBERLY
					@elseif(in_array(auth()->user()->id, [5007, 8122, 9086]))
						MS. ACHURRA, MARY ANGELA
					@elseif(in_array(auth()->user()->id, [9306, 8968, 9310]))
						MR. SALVACION, BRIAN
					@endif
					<span style="color: white;">---</span>
				@else
					<span style="color: white;">--------------------------------------</span>
				@endif
			</td>
		</tr>

		<tr>
			<td colspan="4" style="text-align: center;">
				Crew Name and Signature
			</td>
			<td></td>
			<td colspan="2" style="text-align: center;">
				@if(in_array(auth()->user()->id, [9306, 8968, 9310]))
					Documentation Assistant
				@else
					Crewing Officer
				@endif         
			</td>
		</tr>


		<br><br>

		<tr>
			<td colspan="4" style="text-decoration: underline; text-align: center;">
				@if(in_array(auth()->user()->id, [6109, 8377, 9080, 5716, 7595, 9018, 5007, 8122, 9086, 9306, 8968, 9310]))
					<span style="color: white;">---</span>
					@if(in_array(auth()->user()->id, [6109, 8377, 9080]))
						MS. MIRANDA, ROXAN
					@elseif(in_array(auth()->user()->id, [5716, 7595, 9018]))
						MS. AGUILAR, ABBYGAIL
					@elseif(in_array(auth()->user()->id, [5007, 8122, 9086]))
						MS. OÑATE, LURIN JOY
					@elseif(in_array(auth()->user()->id, [9306, 8968, 9310]))
						MS. MELAUR, CHRISTINE JOY
					@endif
					<span style="color: white;">---</span>
				@else
					<span style="color: white;">--------------------------------------</span>
				@endif
			</td>
		</tr>

		<tr>
			<td colspan="4" style="text-align: center;">
				@if(in_array(auth()->user()->id, [9306, 8968, 9310]))
					Crewing Officer
				@else
					Assistant Crewing Manager
				@endif         
			</td>
		</tr>

		@if($loop->index < sizeof($applicants) - 1)
			<div class="page-break"></div>
		@endif

	@endforeach

</table>