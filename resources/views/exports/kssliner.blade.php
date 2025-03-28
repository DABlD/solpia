@php
	// dd($data->pro_app);
@endphp

<table>
	<tr>
		<td colspan="9">외국 부원 승무자격 점검표(LPG)</td>
	</tr>

	<tr>
		<td colspan="9">CHECKLIST FOR FOREIGN RATINGS QUALIFICATION(LPG)</td>
	</tr>

	<tr>
		<td colspan="3">ㅤName of ship: {{ isset($data->vessel) ? $data->vessel->name : "-" }}</td>
		<td>Type of ship :</td>
		<td>{{ isset($data->vessel) ? $data->vessel->type : "-" }}</td>
		<td>GRT :</td>
		<td>{{ isset($data->vessel) ? $data->vessel->gross_tonnage : "-" }}</td>
		<td>Eng' power :</td>
		<td>{{ isset($data->vessel) ? $data->vessel->bhp : "-" }}</td>
	</tr>

	<tr>
		<td colspan="3">ㅤName of crew: {{ $data->fullname }}</td>
		<td>Nationality :</td>
		<td>FILIPINO</td>
		<td>Rank :</td>
		<td>{{ isset($data->rank) ? $data->rank->abbr : "-" }}</td>
		<td>Ship's flag :</td>
		<td>{{ isset($data->vessel) ? $data->vessel->flag : "-" }}</td>
	</tr>

	<tr>
		<td colspan="3"></td>
		<td colspan="2">Intended date of embarkation :</td>
		<td>{{ $data->pro_app->eld ? $data->pro_app->eld->format('m/d/Y') : "" }}</td>
		<td colspan="2">Place of embarkation : </td>
		<td></td>
	</tr>

	<tr>
		<td>No.</td>
		<td colspan="3">Name of cert'</td>
		<td>Cert' No.</td>
		<td>Issued date</td>
		<td>Expired date</td>
		<td>Check (Y/N)</td>
		<td>Remarks</td>
	</tr>

	<tr>
		<td>No.</td>
		<td colspan="3">Name of cert'</td>
		<td>Cert' No.</td>
		<td>Issued date</td>
		<td>Expired date</td>
		<td>Check (Y/N)</td>
		<td>Remarks</td>
	</tr>

	<tr>
		<td colspan="9">** For travel (compulsory)</td>
	</tr>

	@php 
		$name = "PASSPORT";
		$docu = isset($data->document_id->{$name}) ? $data->document_id->{$name} : false;
	@endphp
	<tr>
		<td>1</td>
		<td colspan="3">Passport</td>
		<td>{{ $docu ? $docu->number : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
	</tr>

	@php 
		$name = "SEAMAN'S BOOK";
		$docu = isset($data->document_id->{$name}) ? $data->document_id->{$name} : false;
	@endphp
	<tr>
		<td>2</td>
		<td colspan="3">Seaman's book</td>
		<td>{{ $docu ? $docu->number : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
	</tr>

	@php 
		$name = "MCV";
		$docu = isset($data->document_id->{$name}) ? $data->document_id->{$name} : false;
	@endphp
	<tr>
		<td>3</td>
		<td colspan="3">Australia Maritime Crew Visa(MCV)</td>
		<td>{{ $docu ? $docu->number : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>If necessary</td>
	</tr>

	@php 
		$name = "US-VISA";
		$docu = isset($data->document_id->{$name}) ? $data->document_id->{$name} : false;
	@endphp
	<tr>
		<td>4</td>
		<td colspan="3">Visa for embarkation</td>
		{{-- <td>{{ $docu ? $docu->number : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>If necessary</td> --}}
		<td>N/A</td>
		<td>N/A</td>
		<td>N/A</td>
		<td></td>
		<td>If necessary</td>
	</tr>

	<tr>
		<td colspan="9">** FOR STCW (compulsory)</td>
	</tr>

	@php 
		$name = "GENERAL TANKER FAMILIARIZATION";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>5</td>
		<td colspan="3">Tanker familiarization</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
	</tr>

	@php 
		$name = "BASIC TRAINING - BT";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>6</td>
		<td colspan="3">Basic safety training</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
	</tr>

	@php 
		$name = "ADVANCE FIRE FIGHTING - AFF";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>7</td>
		<td colspan="3">Advanced fire fighting</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>Not compulsory</td>
	</tr>

	@php 
		$name = "PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>8</td>
		<td colspan="3">Proficiency in survival craft &#38; rescue boats</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>Not compulsory</td>
	</tr>

	@php 
		$docu = false;

		foreach($data->document_lc as $doc){
			$condition1 = str_contains($doc->type, "NAV") || str_contains($doc->type, "DECK") || str_contains($doc->type, "ENGINE");
			if($condition1 && str_contains($doc->type, "WATCH")){
				if($docu){
					if($doc->issue_date > $docu->issue_date){
						$docu = $doc;
					}
				}
				else{
					$docu = $doc;
				}
			}
		}
	@endphp
	<tr>
		<td>9</td>
		<td colspan="3">Navigational watchkeeping cert</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>See remarks 'A'</td>
	</tr>

	@php 
		$docu = false;

		foreach($data->document_flag as $doc){
			if($doc->flag == "PANAMA" && $doc->type == "LICENSE"){
				$docu = $doc;
			}
		}
	@endphp
	<tr>
		<td>10</td>
		<td colspan="3">Cert' of competency by Panama</td>
		<td>{{ $docu ? $docu->number : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>
			Rank:
			<br style='mso-data-placement:same-cell;' />
			Panama flag only
		</td>
	</tr>

	@php 
		$docu = false;

		foreach($data->document_flag as $doc){
			if($doc->flag == "PANAMA" && $doc->type == "ATLGT"){
				$docu = $doc;
			}
		}
	@endphp
	<tr>
		<td rowspan="2">11</td>
		<td colspan="3">Liquefied gas tanker operation by Panama</td>
		<td>{{ $docu ? $docu->number : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td rowspan="2">
			Panama flag only
			<br style='mso-data-placement:same-cell;' />
			Should hold 11-①  or 11-②
		</td>
	</tr>

	@php 
		$docu = false;

		foreach($data->document_flag as $doc){
			if($doc->flag == "PANAMA" && $doc->type == "ATCT"){
				$docu = $doc;
			}
		}
	@endphp
	<tr>
		<td colspan="3">Advanced liquified gas tanker operation by Panama</td>
		<td>{{ $docu ? $docu->number : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
	</tr>

	@php 
		$docu = false;

		// foreach($data->document_flag as $doc){
		// 	if($doc->flag == "PANAMA" && $doc->type == "ATCT"){
		// 		$docu = $doc;
		// 	}
		// }
	@endphp
	<tr>
		<td>12</td>
		<td colspan="3">Endorse' navigational watchkeeping by Panama</td>
		<td>{{ $docu ? $docu->number : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>
			Panama flag only
			<br style='mso-data-placement:same-cell;' />
			See remarks 'A'
		</td>
	</tr>

	<tr>
		<td colspan="9">
			** For health
		</td>
	</tr>

	@php 
		$docu = false;

		foreach($data->document_med_cert as $doc){
			if(str_contains($doc->type, "MEDICAL CERTIFICATE")){
				$docu = $doc;
			}
		}
	@endphp
	<tr>
		<td>13</td>
		<td colspan="3">Medical examination - English ver.</td>
		<td>{{ $docu ? $docu->number : "TO TAKE" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "TO TAKE" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "TO TAKE" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
	</tr>

	@php 
		$docu = false;

		foreach($data->document_med_cert as $doc){
			if(str_contains($doc->type, "PANAMA") || str_contains($doc->type, "FLAG")){
				if($docu){
					if($doc->issue_date > $docu->issue_date){
						$docu = $doc;
					}
				}
				else{
					$docu = $doc;
				}
			}
		}
	@endphp
	<tr>
		<td>14</td>
		<td colspan="3">Medical examination - Panama ver.</td>
		<td>{{ $docu ? $docu->number : "TO TAKE" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "TO TAKE" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "TO TAKE" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>Panama flag only</td>
	</tr>

	@php 
		$docu = false;

		foreach($data->document_med_cert as $doc){
			if(str_contains($doc->type, "DRUG AND ALCOHOL TEST")){
				if($docu){
					if($doc->issue_date > $docu->issue_date){
						$docu = $doc;
					}
				}
				else{
					$docu = $doc;
				}
			}
		}
	@endphp
	<tr>
		<td>15</td>
		<td colspan="3">Drug/alcohol test</td>
		<td>{{ $docu ? $docu->number : "TO TAKE" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "TO TAKE" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "TO TAKE" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
	</tr>

	@php 
		$docu = false;

		foreach($data->document_med_cert as $doc){
			if(str_contains($doc->type, "YELLOW FEVER")){
				if($docu){
					if($doc->issue_date > $docu->issue_date){
						$docu = $doc;
					}
				}
				else{
					$docu = $doc;
				}
			}
		}
	@endphp
	<tr>
		<td>16</td>
		<td colspan="3">Yellow fever vaccine</td>
		<td>{{ $docu ? $docu->number : "TO TAKE" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "TO TAKE" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "TO TAKE" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="9">** KSS regulation</td>
	</tr>

	<tr>
		<td>17</td>
		<td colspan="3">KSS ID card (MADE BY KSS LINE)</td>
		<td></td>
		<td></td>
		<td>UNLIMITED</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="4">Remarks</td>
		<td colspan="3">Judgement</td>
		<td>Checked date</td>
		<td>Signature</td>
	</tr>

	<tr>
		<td colspan="4" rowspan="2">
			A : Not applied OS, WP and cooking crew.
		</td>
		<td>Agent / Owner</td>
		<td>ㅁ Accepted</td>
		<td>ㅁ Rejected</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td>SHIP</td>
		<td>ㅁ Accepted</td>
		<td>ㅁ Rejected</td>
		<td></td>
		<td></td>
	</tr>
</table>