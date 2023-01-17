@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b$c";
@endphp

<table>
	<tr>
		<td colspan="12" style="{{ $c }}">Republic of the Philippines</td>
	</tr>

	<tr>
		<td colspan="12" style="{{ $c }}">Department of Labor and Employment</td>
	</tr>

	<tr>
		<td colspan="12" style="{{ $bc }}">PHILIPPINE OVERSEAS EMPLOYMENT ADMINISTRATION</td>
	</tr>

	<tr><td colspan="l2"></td></tr>

	<tr>
		<td colspan="12" style="{{ $bc }}">SEAFARER'S EMPLOYMENT AGREEMENT</td>
	</tr>

	<tr><td colspan="l2"></td></tr>

	<tr>
		<td colspan="12">KNOW ALL MEN BY THESE PRESENTS:</td>
	</tr>

	<tr><td colspan="l2"></td></tr>

	<tr>
		<td colspan="12">This Contract, entered into volutarily by and between:</td>
	</tr>

	<tr><td colspan="l2"></td></tr>

	<tr>
		<td colspan="3">Name of Seafarer:</td>
		<td colspan="9" style="{{ $c }}">{{ $data->user->namefull }}</td>
	</tr>

	<tr>
		<td colspan="2">Date of Birth:</td>
		<td colspan="3" style="{{ $c }}">{{ $data->user->birthday ? $data->user->birthday->format('d-F-Y') : "---" }}</td>
		<td colspan="2" style="{{ $c }}">Place of Birth:</td>
		<td colspan="5" style="{{ $c }}">{{ $data->birth_place }}</td>
	</tr>

	<tr>
		<td>Address:</td>
		<td colspan="11" style="{{ $c }}">{{ $data->user->address }}</td>
	</tr>

	<tr>
		<td colspan="2">SIRB:</td>
		<td colspan="2" style="{{ $c }}">{{ isset($data->document_id->{"SEAMAN'S BOOK"}) ? $data->document_id->{"SEAMAN'S BOOK"}->number : "---" }}</td>
		<td style="{{ $c }}">E-Reg. No.</td>
		<td colspan="2" style="{{ $c }}">{{ isset($data->document_lc->{"POEA EREGISTRATION"}) ? $data->document_lc->{"POEA EREGISTRATION"}->number : "---" }}</td>
		<td colspan="2" style="{{ $c }}">License No.</td>
		@php
			$license = null;
			foreach ($data->document_lc as $doc) {
  				$regulations = json_decode($document->regulation);

  				if(in_array("II/1", $regulations) || in_array("III/1", $regulations)){
  					$license = $doc;
  				}

  				if(in_array("II/2", $regulations) || in_array("III/2", $regulations)){
  					$license = $doc;
  					break;
  				}
			}
		@endphp
		<td colspan="3" style="{{ $c }}">{{ $license ? $license->no : "NOT APPLICABLE" }}</td>
	</tr>

	<tr>
		<td colspan="12">Hereinafter referred to as the Seafarer</td>
	</tr>

	<tr>
		<td colspan="12" style="{{ $c }}">And</td>
	</tr>

	<tr>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td colspan="4">Name of Agent:</td>
		<td colspan="8" style="{{ $bc }}">SOLPIA MARINE AND SHIP MANAGEMENT INC.</td>
	</tr>

	<tr>
		<td colspan="4">Name of Principal/Shipowner:</td>
		<td colspan="8" style="{{ $bc }}">TOEI KOREA LTD.</td>
	</tr>

	<tr>
		<td colspan="4">Address of Principal/Shipowner:</td>
		<td colspan="8" style="{{ $bc }}">RM. 701, 7FL, BUSAN SUNGUI-SHINHYEOP BLDG., 162, BEOMIL-RO, BUSANJIN-GU, BUSAN, KOREA</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="8" style="{{ $c }}">(Principal/Country)</td>
	</tr>

	<tr>
		<td colspan="12">For the following vessel:</td>
	</tr>

	<tr>
		<td colspan="3">Name of Vessel:</td>
		<td colspan="9" style="{{ $bc }}">{{ $data->pro_app->vessel->name }}</td>
	</tr>

	<tr>
		<td colspan="2">IMO Number:</td>
		<td colspan="2" style="{{ $bc }}">{{ $data->pro_app->vessel->imo }}</td>
		<td colspan="3" style="{{ $c }}">Gross Registerd Tonnage (GRT):</td>
		<td colspan="2" style="{{ $bc }}">{{ $data->pro_app->vessel->gross_tonnage }}</td>
		<td colspan="2" style="{{ $c }}">Year Built:</td>
		<td style="{{ $bc }}">{{ $data->pro_app->vessel->year_build }}</td>
	</tr>

	<tr>
		<td colspan="2">Flag:</td>
		<td colspan="2" style="{{ $bc }}">{{ $data->pro_app->vessel->flag }}</td>
		<td colspan="2" style="{{ $c }}">Type of Vessel:</td>
		<td style="{{ $bc }}">{{ $data->pro_app->vessel->type }}</td>
		<td colspan="3" style="{{ $c }}">Classification Society:</td>
		<td colspan="2" style="{{ $bc }}">N.K.</td>
	</tr>

	<tr>
		<td colspan="12">Hereinafter referred to as the Employer</td>
	</tr>

	<tr>
		<td colspan="12" style="height: 30px;"></td>
	</tr>

	<tr>
		<td colspan="12">1. That the seafarer shall be employed on board under the following terms and conditions:</td>
	</tr>

	{{ dd($data) }}

	<tr>
		<td></td>
		<td>1.1</td>
		<td colspan="3">Duration of Contract:</td>
		<td colspan="7"></td>
	</tr>

</table>