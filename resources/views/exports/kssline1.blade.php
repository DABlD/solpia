@php
	// dd($data->pro_app);
@endphp

<table>
	<tr>
		<td colspan="9">외국 항해사관 승무자격 점검표(LPG)</td>
	</tr>

	<tr>
		<td colspan="9">CHECKLIST FOR FOREIGN DECK OFFICER QUALIFICATION(LPG)</td>
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
		$name = "COC";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>5</td>
		<td colspan="3">Cert' of competency deck officer</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>Class :</td>
	</tr>

	@php 
		$name = "COE";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>6</td>
		<td colspan="3">Cert' of endorsement</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>Limitation :</td>
	</tr>

	@php 
		$name = "COEKOR";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>7</td>
		<td colspan="3">Cert' of endorsement by KOR</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>
			Ship name:
			<br style='mso-data-placement:same-cell;' />
			See remarks 'A'
		</td>
	</tr>

	@php 
		$docu = false;
		$temp = false;

		foreach($data->document_lc as $doc){
			if(str_contains($doc->type, "GMDSS")){
				$temp = $doc;
			}

			if(str_contains($doc->type, "GMDSS") && !str_contains($doc->type, "GOC")){
				$docu = $doc;
			}
		}

		$docu = $docu ? $docu : $temp;
	@endphp
	<tr>
		<td>8</td>
		<td colspan="3">Proficiency in GMDSS</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
	</tr>

	@php 
		$docu = false;
		$temp = false;

		foreach($data->document_lc as $doc){
			if(str_contains($doc->type, "GOC")){
				$temp = $doc;
			}

			if(str_contains($doc->type, "GOC") && !str_contains($doc->type, "GMDSS")){
				$docu = $doc;
			}
		}

		$docu = $docu ? $docu : $temp;
	@endphp
	<tr>
		<td>9</td>
		<td colspan="3">Proficiency in GMDSS</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
	</tr>

	@php 
		$docu = false;

		foreach($data->document_lc as $doc){
			if(str_contains($doc->type, "RADAR") && str_contains($doc->type, "SIMULAT")){
				$docu = $doc;
			}
		}
	@endphp
	<tr>
		<td>10</td>
		<td colspan="3">RADAR simulator</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
	</tr>

	@php 
		$docu = false;

		foreach($data->document_lc as $doc){
			if(str_contains($doc->type, "ARPA")){
				$docu = $doc;
			}
		}
	@endphp
	<tr>
		<td>11</td>
		<td colspan="3">ARPA simulator</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
	</tr>

	@php 
		$name = "ECDIS";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td rowspan="2">12</td>
		<td rowspan="2">ECDIS training course</td>
		<td colspan="2">(GENERIC)</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td rowspan="2">
			Officer
			<br style='mso-data-placement:same-cell;' />
			If necessary
		</td>
	</tr>

	@php 
		$name = false;
		if(isset($data->vessel) && $data->vessel->ecdis){
			$name = $data->vessel->ecdis;
		}

		if($name){
			$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
		}
	@endphp
	<tr>
		<td colspan="2">(TYPE SPECIFIC)</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
	</tr>

	@php 
		$name = "GENERAL TANKER FAMILIARIZATION";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>13</td>
		<td colspan="3">Tanker familiarization</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
	</tr>

	@php 
		$name = "BASIC TRAINING FOR LIQUIFIED GAS TANKER CARGO OPERATIONS - BTLGT";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>14</td>
		<td colspan="3">Liquefied gas tanker special' training</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
	</tr>

	@php 
		$name = "BASIC TRAINING FOR OIL AND CHEMICAL TANKER - BTOCT";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>15</td>
		<td colspan="3">Chemical tanker special' training</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>
			Except
			<br style='mso-data-placement:same-cell;' />
			MT.GAS HARMONY
		</td>
	</tr>

	@php 
		$name = "BASIC TRAINING - BT";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>16</td>
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
		<td>17</td>
		<td colspan="3">Advanced fire fighting</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
	</tr>

	@php 
		$name = "PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>18</td>
		<td colspan="3">Proficiency in survival craft &#38; rescue boats</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
	</tr>

	@php 
		$name = "MEDICAL FIRST AID - MEFA";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>19</td>
		<td colspan="3">Medical first aid</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
	</tr>

	@php 
		$name = "MEDICAL CARE - MECA";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>20</td>
		<td colspan="3">Medical care on board</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
	</tr>

	@php 
		$name = "SHIP SECURITY OFFICER - SSO";
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td>21</td>
		<td colspan="3">Cert' of ship security officer</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td></td>
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
		<td>22</td>
		<td colspan="3">Cert' of competency deck officer by Panama</td>
		<td>{{ $docu ? $docu->number : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>
			Panama flag only
			<br style='mso-data-placement:same-cell;' />
			Limitation :
		</td>
	</tr>

	@php 
		$docu = false;

		foreach($data->document_flag as $doc){
			if($doc->flag == "PANAMA" && $doc->type == "GMDSS/GOC"){
				$docu = $doc;
			}
		}
	@endphp
	<tr>
		<td>23</td>
		<td colspan="3">GMDSS operator general by Panama</td>
		<td>{{ $docu ? $docu->number : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>Panama flag only</td>
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
		<td>24</td>
		<td colspan="3">Advanced liquefied gas tanker operation by Panama</td>
		<td>{{ $docu ? $docu->number : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>Panama flag only</td>
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
		<td>25</td>
		<td colspan="3">Advanced chemical tanker operation by Panama</td>
		<td>{{ $docu ? $docu->number : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>
			Except
			<br style='mso-data-placement:same-cell;' />
			MT.GAS HARMONY
		</td>
	</tr>

	@php 
		$docu = false;

		foreach($data->document_flag as $doc){
			if($doc->flag == "PANAMA" && $doc->type == "SSO"){
				$docu = $doc;
			}
		}
	@endphp
	<tr>
		<td>26</td>
		<td colspan="3">Cert' of ship security officer by Panama</td>
		<td>{{ $docu ? $docu->number : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>
			Panama flag only
			<br style='mso-data-placement:same-cell;' />
			C/O only
		</td>
	</tr>

	<tr>
		<td colspan="9">** For improvement of job</td>
	</tr>

	@php 
		$docu = false;

		foreach($data->document_lc as $doc){
			if($doc->type == "BRM" || $doc->type == "SSBT WITH BRM"){
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
		<td>27</td>
		<td colspan="3">BRM training course</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>
			Officer
			<br style='mso-data-placement:same-cell;' />
			compulsory
		</td>
	</tr>

	@php 
		$docu = false;

		foreach($data->document_lc as $doc){
			if(str_contains($doc->type, "SHS")){
			}
		}
	@endphp
	<tr>
		<td>28</td>
		<td colspan="3">SHS training course</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>C/O compulsory</td>
	</tr>

	@php 
		$docu = false;

		foreach($data->document_lc as $doc){
			if(str_contains($doc->type, "SAFETY OFFICER") && str_contains($doc->type, "TRAINING")){
				$docu = $doc;
			}
		}
	@endphp
	<tr>
		<td>29</td>
		<td colspan="3">Safety officer training course</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>
			C/O compulsory
			<br style='mso-data-placement:same-cell;' />
			2/O,3/O voluntary
		</td>
	</tr>

	<tr>
		<td colspan="9">
			** For health
		</td>
	</tr>

	@php 
		$docu = false;

		foreach($data->document_lc as $doc){
			if(str_contains($doc->type, "RISK ASSESSMENT")){
				$docu = $doc;
			}
		}
	@endphp
	<tr>
		<td>30</td>
		<td colspan="3">Risk assessment training course</td>
		<td>{{ $docu ? $docu->no : "N/A" }}</td>
		<td>{{ $docu ? ($docu->issue_date ? $docu->issue_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? ($docu->expiry_date ? $docu->expiry_date->format("m/d/Y") : "-") : "N/A" }}</td>
		<td>{{ $docu ? "Y" : "" }}</td>
		<td>
			C/O compulsory
			<br style='mso-data-placement:same-cell;' />
			2/O,3/O voluntary
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
		<td>31</td>
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
		<td>32</td>
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
		<td>33</td>
		<td colspan="3">DRUG AND ALCOHOL TEST</td>
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
		<td>34</td>
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
		<td>35</td>
		<td colspan="3">KSS ID card (MADE BY KSS LINE)</td>
		<td></td>
		<td></td>
		<td>UNLIMITED</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="9">** Additional certificate</td>
	</tr>

	<tr>
		<td>36</td>
		<td colspan="3"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td>37</td>
		<td colspan="3"></td>
		<td></td>
		<td></td>
		<td></td>
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
			ㅤA : If not possession, please send us
			<br style='mso-data-placement:same-cell;' />
			ㅤㅤthe "Cert' of maritime law course"
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