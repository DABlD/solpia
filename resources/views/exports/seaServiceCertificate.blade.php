<table>
	<tr>
		<td colspan="10" style="height: 100px;"></td>
	</tr>

	<tr>
		<td colspan="10" style="text-align: center; font-weight: bold; background-color: #f4f7fc">C E R T I F I C A T E  ‎‏‏‎ ‎‏‏‎O F  ‎‏‏‎ ‎‏‏‎S E A S E R V I C E</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="10" style="text-align: right;">{{ now()->format('F j, Y') }}</td>
	</tr>

	<tr>
		<td colspan="10">CERT NO: SC-{{ now()->format('Y') }}-</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="10" style="font-weight: bold;">MARITIME INDUSTRY AUTHORITY</td>
	</tr>

	<tr>
		<td colspan="10">MARINA BUILDING, BONIFACIO DRIVE COR. 20TH STREET, PORT AREA</td>
	</tr>

	<tr>
		<td colspan="10">Manila</td>
	</tr>

	<tr>
		<td colspan="10"></td>
	</tr>

	@php
		$smb = "";
		foreach ($data->document_id as $id) {
			if($id->type == "SEAMAN'S BOOK"){
				$smb = $id->number;
			}
		}
	@endphp

	<tr>
		<td colspan="10" style="height: 45px;">This it to attest that Mr. {{ $data->user->fname }} {{ isset($data->user->mname) && $data->user->mname != "" ? $data->user->mname[0] . "." : "" }} {{ $data->user->lname }} {{ $data->user->suffix }} holder of SIRB No. {{ $smb }} has been employed by this Company with the following seagoing service:</td>
	</tr>

	<tr>
		<td rowspan="2" style="font-weight: bold; background-color: #C0DCC0;">NAME OF VESSEL</td>
		<td rowspan="2" style="font-weight: bold; background-color: #C0DCC0;">TYPE OF VESSEL</td>
		<td rowspan="2" style="font-weight: bold; background-color: #C0DCC0;">GROSS TONNAGE</td>
		<td rowspan="2" style="font-weight: bold; background-color: #C0DCC0;">BHP / KW</td>
		<td rowspan="2" style="font-weight: bold; background-color: #C0DCC0;">FLAG OF REGISTRY</td>
		<td rowspan="2" style="font-weight: bold; background-color: #C0DCC0;">TRADE ROUTE</td>
		<td colspan="2" style="font-weight: bold; background-color: #C0DCC0;">PERIOD COVERED</td>
		<td rowspan="2" style="font-weight: bold; background-color: #C0DCC0;">POSITION / RANK</td>
		<td rowspan="2" style="font-weight: bold; background-color: #C0DCC0;">NO. OF MONTHS DAYS</td>
	</tr>

	<tr>
		<td style="font-weight: bold; border: 1px solid black; text-align: center; vertical-align: middle;">FROM {{ PHP_EOL }} (d/m/y)</td>
		<td style="font-weight: bold; border: 1px solid black; text-align: center; vertical-align: middle;">TO {{ PHP_EOL }} (d/m/y)</td>
	</tr>

	@php
		$start = 13;
		$ob = $data->line_up_contracts->first();

		$ct = function($text){
			return str_replace('&', '&#38;', $text);
		};
	@endphp

	@if(isset($ob) && $ob->status == "On Board")
		@php
   			$start = $start+1;
   			$ss = $ob->vessel;
		@endphp

		<tr>
			<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ $ct($ss->name) }}</td>
			<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ $ct($ss->type) }}</td>
			<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ $ct($ss->gross_tonnage) }}</td>
			<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ $ct($ss->BHP) }}</td>
			<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ $ct($ss->flag) }}</td>
			<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ $ct($ss->trade) }}</td>
			<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ $ob->joining_date ? $ob->joining_date->format('d-M-y') : "-" }}</td>
			<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ now()->format('d-M-y') }}</td>
			<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ $ob->rank->abbr }}</td>
			<td style="border: 1px solid black; font-size: 9px; height: 17px;">
				{{ '=IF(DATEDIF(G' . $start . ',H' . $start . ',"y")=0,"",DATEDIF(G' . $start . ',H' . $start . ',"y")&" yr ")&IF(DATEDIF(G' . $start . ',H' . $start . ',"ym")=0,"",DATEDIF(G' . $start . ',H' . $start . ',"ym")&" mos ")&IF(DATEDIF(G' . $start . ',H' . $start . ',"md")=0,"",DATEDIF(G' . $start . ',H' . $start . ',"md")&" days")' }}
			</td>
		</tr>
	@endif

	@foreach($data->sea_service as $ss)
		@php
			if($ss->sign_on && $ss->sign_off){
				$diff = $ss->sign_on->diff($ss->sign_off);
			}

   			$bypass = [5119];

   			if(str_contains($ss->manning_agent, "SOLPIA") || in_array($ss->applicant_id, $bypass)){
   				$start = $start+1;
   			}
		@endphp
		@if(str_contains($ss->manning_agent, "SOLPIA") || in_array($ss->applicant_id, $bypass))
			<tr>
				<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ $ct($ss->vessel_name) }}</td>
				<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ $ct($ss->vessel_type) }}</td>
				<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ $ct($ss->gross_tonnage) }}</td>
				<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ $ct($ss->bhp_kw) }}</td>
				<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ $ct($ss->flag) }}</td>
				<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ $ct($ss->trade) }}</td>
				<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ $ss->sign_on ? $ss->sign_on->format('d-M-y') : "-" }}</td>
				<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ $ss->sign_off ? $ss->sign_off->format('d-M-y') : "-" }}</td>
				<td style="border: 1px solid black; font-size: 9px; height: 17px;">{{ $ss->rank }}</td>
				<td style="border: 1px solid black; font-size: 9px; height: 17px;">
					{{ '=IF(DATEDIF(G' . $start . ',H' . $start . ',"y")=0,"",DATEDIF(G' . $start . ',H' . $start . ',"y")&" yr ")&IF(DATEDIF(G' . $start . ',H' . $start . ',"ym")=0,"",DATEDIF(G' . $start . ',H' . $start . ',"ym")&" mos ")&IF(DATEDIF(G' . $start . ',H' . $start . ',"md")=0,"",DATEDIF(G' . $start . ',H' . $start . ',"md")&" days")' }}
				</td>
			</tr>
		@endif
	@endforeach

	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="10">This certification is issued upon the request of Mr. {{ $data->user->fname }} {{ isset($data->user->mname) && $data->user->mname != "" ? $data->user->mname[0] . "." : "" }} {{ $data->user->lname }} {{ $data->user->suffix }} for {{ $data->data['reason'] }}</td>
	</tr>

	<tr style="vertical-align: middle;">
		<td colspan="10" style="height: 40px;">Certified True and Correct</td>
	</tr>

	<tr>
		<td colspan="10" style="font-weight: bold;">SOLPIA MARINE &#38; SHIP MANAGEMENT INC.</td>
	</tr>

	<tr>
		<td colspan="10" style="font-size: ">As Agent Only; acting for and in behalf of the Owners</td>
	</tr>

	<tr>
		<td colspan="10" style="height: 40px;"></td>
	</tr>

	<tr>
		<td colspan="10" style="font-weight: bold;">
			@if($data->user->fleet == "TOEI")
				MR. LEONIL LUIS F. ROMANO
			@elseif($data->user->fleet == "FLEET B")
				MR. ADULF KIT JAIME M. JUMAWAN
			@else
				C/E ROMANO A. MARIANO
			@endif
		</td>
	</tr>

	<tr>
		<td colspan="10">
			@if($data->user->fleet == "TOEI")
				Crewing Manager - TOEI Fleet
			@elseif($data->user->fleet == "FLEET B")
				Crewing Manager
			@else
				President
			@endif
		</td>
	</tr>

	<tr>
		<td colspan="10" style="height: 20px;"></td>
	</tr>

	<tr>
		<td colspan="10" style="font-style: italic; font-size: 8px;">Not valid without company seal or with any erasures and alterations.</td>
	</tr>

	<tr>
		<td colspan="10" style="font-style: italic; font-size: 8px;">
			@if($data->user->fleet == "TOEI")
				MR. LEONIL LUIS F. ROMANO
			@elseif($data->user->fleet == "FLEET B")
				MR. ADULF KIT JAIME M. JUMAWAN
			@else
				C/E ROMANO A. MARIANO
			@endif
		</td>
	</tr>

	<tr>
		<td colspan="10" style="font-weight: bold;">SMOP-CS5-31</td>
	</tr>
</table>