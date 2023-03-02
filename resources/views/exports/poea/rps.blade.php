@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b$c";
	$blue = 'color: #265C9E;';
	$u = 'text-decoration: underline;';
	$i = 'font-style: italic;';
@endphp

<table>
	<tr>
		<td colspan="16" style="height: 35px;">
			FM-POEA-04-EF-06-B
			<br style='mso-data-placement:same-cell;' />
			Effectivity Date: 23 AUG 2018
		</td>
	</tr>

	<tr>
		<td colspan="16" style="{{ $bc }}">
			PHILIPPINES OVERSEAS EMPLOYMENT ADMINISTRATION
		</td>
	</tr>

	<tr>
		<td colspan="16" style="{{ $c }}">
			Department of Labor and Employment. Republic of the Philippines
		</td>
	</tr>

	<tr>
		<td colspan="16" style="height: 80px;"></td>
	</tr>

	<tr>
		<td colspan="6" style="{{ $b }}">
			REQUEST TO PROCESS SEAFERERS/S (RPS)
		</td>
		<td colspan="4"></td>
		<td colspan="2">* RFP No.</td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="10"></td>
		<td colspan="3">* Date Received:</td>
		<td style="{{ $c }}"></td>
		<td colspan="2"></td>
	</tr>

	@php
		$ss = $data->sea_service->filter(function($s){
			return str_contains($s->manning_agent, "SOLPIA");
		});
	@endphp

	<tr>
		<td colspan="3"></td>
		<td style="{{ $c }}">{{ $ss->count() ? "✓" : "" }}</td>
		<td colspan="5" style="{{ $b }}">ENGAGED SEAFARER/S</td>
		<td style="{{ $c }}">{{ $ss->count() ? "" : "✓" }}</td>
		<td colspan="3" style="{{ $b }}">RE-ENGAGED</td>
		<td colspan="3" style="{{ $b }}">/PRV/CADET</td>
	</tr>

	<tr>
		<td colspan="16"></td>
	</tr>

	<tr>
		<td colspan="3">Name of Agency:</td>
		<td colspan="13" style="{{ $blue }} {{ $u }} {{ $i }} {{ $b }}">
			SOLPIA MARINE AND SHIP MANAGEMENT INC
		</td>
	</tr>

	<tr>
		<td colspan="5">Name of Accredited Principal:</td>
		<td colspan="11" style="{{ $blue }} {{ $u }} {{ $i }} {{ $b }}">
			{{ $data->pro_app->principal->full_name ?? "N/A" }}
		</td>
	</tr>

	<tr>
		<td colspan="3">Name of Vessel:</td>
		<td colspan="8" style="{{ $blue }} {{ $u }} {{ $i }} {{ $b }}">
			{{ $data->pro_app->vessel->name ?? "N/A" }}
		</td>
		<td colspan="3">Crew Order Approved on:</td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="16"></td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $c }} {{ $i }} height: 30px;">E-REG No.</td>
		<td colspan="4" style="{{ $c }} {{ $i }}">NAME OF SEAFERER</td>
		<td style="{{ $c }} {{ $i }}">SIRB #</td>
		<td colspan="2" style="{{ $c }} {{ $i }}">GENDER</td>
		<td colspan="2" style="{{ $c }} {{ $i }}">POSITION</td>
		<td colspan="2" style="{{ $c }} {{ $i }}">SALARY</td>
		<td colspan="2" style="{{ $c }} {{ $i }}">
			CONTRACT DURATION
			<br style='mso-data-placement:same-cell;' />
			(Mo./Day)
		</td>
		<td style="{{ $c }} {{ $i }}">*Action Taken</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $bc }} {{ $i }} height: 30px;">
			@if(isset($data->document_lc->{"POEA EREGISTRATION"}))
				{{ number_format($data->document_lc->{"POEA EREGISTRATION"}->no, '0', '', '') }}
			@endif
		</td>
		<td colspan="4" style="{{ $bc }} {{ $i }} {{ $blue }}">
			{{ $data->user->namefull }}
		</td>
		<td style="{{ $bc }} {{ $i }} {{ $blue }}">
			@if(isset($data->document_id->{"SEAMAN'S BOOK"}))
				{{ $data->document_id->{"SEAMAN'S BOOK"}->number }}
			@endif
		</td>

		<td colspan="2" style="{{ $bc }} {{ $i }} {{ $blue }}">MALE</td>
		<td colspan="2" style="{{ $bc }} {{ $i }} {{ $blue }}">
			{{ $data->pro_app->rank->name }}
		</td>
		<td style="{{ $c }}">
			US
		</td>
		<td style="{{ $b }} {{ $i }} {{ $blue }} text-align: left;">
			{{ $data->wage->total ? number_format($data->wage->total, 2) : 0.00 }}
		</td>
		<td colspan="2" style="{{ $bc }} {{ $i }} {{ $blue }}">
			{{ $data->req['employment_months'] ?? 0 }} months
		</td>
		<td style="{{ $bc }} {{ $i }}"></td>
	</tr>

	<tr>
		<td colspan="10">Submitted by:</td>
		<td colspan="6">Requesting Party:</td>
	</tr>

	<tr>
		<td colspan="16"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }} {{ $blue }}">
			MR. RANDY J. ANDAYA
		</td>
		<td colspan="5"></td>
		<td colspan="4" style="{{ $bc }} {{ $blue }}">
			C/E ROMANO A. MARIANO
		</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $c }}">
			Signature
		</td>
		<td colspan="5"></td>
		<td colspan="4" style="{{ $c }}">
			Authorized Signatories
		</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $c }}">
			Liaison Officer
		</td>
		<td colspan="5"></td>
		<td colspan="4" style="{{ $c }}">
			President
		</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="14" style="{{ $bc }}">FOR POEA USE ONLY</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $b }} {{ $u }}">ORDER OF PAYMENT</td>
		<td colspan="8">( ) On hold prior to completion of requirements</td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $b }} {{ $u }}"></td>
		<td colspan="8">( ) Documents verified and found to be complete &#38; in order</td>
	</tr>

	<tr>
		<td colspan="16">Please accept from the above-named Agency the payment</td>
	</tr>

	<tr>
		<td colspan="16">For the Processing Fee of __________________ Seaferers(s)</td>
	</tr>

	<tr>
		<td>( ) POEA</td>
		<td colspan="4"></td>
		<td colspan="4"></td>
		<td colspan="6"></td>
		<td></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="4" style="{{ $c }}">Evaluator</td>
		<td colspan="4"></td>
		<td colspan="6" style="{{ $c }}">SEAPC Official Signatory</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="16" style="height: 5px;"></td>
	</tr>

	<tr>
		<td colspan="16" style="{{ $b }}">PAYMENT OF FEES</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $c }}">Processing Fee O.R. No.</td>
		<td style="{{ $c }}"></td>
		<td></td>
		<td colspan="4" style="{{ $c }}">OWWA Contribution O.R. No.</td>
		<td></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="5" style="{{ $c }}"></td>
		<td colspan="3"></td>
		<td colspan="5" style="{{ $c }}"></td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="5" style="{{ $c }}">POEA Cashier/Collecting Officer</td>
		<td colspan="3"></td>
		<td colspan="5" style="{{ $c }}">OWWA Cashier/Collecting Officer</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="16"></td>
	</tr>

	<tr>
		<td colspan="16">
			‎ ‎ ‎ 
			• *To be filled-up by POEA
		</td>
	</tr>

	<tr>
		<td colspan="16">
			‎ ‎ ‎ 
			• **Please reflect SALARY MODE Day/Month)
		</td>
	</tr>
</table>