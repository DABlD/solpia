@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$u = "text-decoration: underline;";
	$bc = "$b$c";
	$blue = "color: #0000FF;";
	$cblue = "$c$blue";

	$fill = function(){
		echo "<tr><td colspan='22'></td></tr>";
	}
@endphp

<table>
	<tr>
		<td colspan="5" style="{{ $c }}">PAYMENT DATE</td>
		<td colspan="12"></td>
		<td colspan="5">(For POEA, OWWA, PHILHEALTH ONLY)</td>
	</tr>

	<tr>
		<td colspan="2">OWWA</td>
		<td colspan="3">DELFIN</td>
		<td colspan="12"></td>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td colspan="2">1. Membership</td>
		<td colspan="2" style="{{ $c }}">VERLO CARL</td>
		<td></td>
		<td colspan="12"></td>
		<td colspan="2">CG No.</td>
		<td colspan="2" style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="5"></td>
		<td colspan="12" style="{{ $c }}">PHILIPPINE OVERSEAS EMPLOYMENT ADMINISTRATION</td>
		<td colspan="2">RFP No.</td>
		<td colspan="2" style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">Philhealth/Medicare</td>
		<td style="{{ $c }}"></td>
		<td></td>
		<td colspan="12" style="{{ $c }}">OVERSEAS WORKERS WELFARE ADMINISTRATION</td>
		<td colspan="3">Assessment No.</td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="5"></td>
		<td colspan="12" style="{{ $c }}">PHILIPPINE HEALTH INSURANCE CORPORATION</td>
		<td colspan="3">Assessed Amount.</td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">OFW e-Card / ID no:</td>
		<td colspan="2" style="{{ $cblue }}"></td>
		<td colspan="12"></td>
		<td></td>
		<td colspan="2">POEA:</td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td>SSS No.</td>
		<td colspan="4" style="{{ $cblue }}">{{ $data->sss }}</td>
		<td colspan="12" rowspan="2" style="{{ $c }} font-size: 14px;">INFORMATION SHEET</td>
		<td></td>
		<td colspan="2">OWWA:</td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td>SID No.</td>
		<td colspan="4" style="{{ $cblue }}"></td>
		<td></td>
		<td colspan="2">PHILHEALTH:</td>
		<td style="{{ $c }}"></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="2">PhilHealth No.</td>
		<td colspan="3" style="{{ $cblue }}">{{ $data->philhealth }}</td>
		<td colspan="12" style="{{ $c }}"></td>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $u }}">I. PERSONAL DATA</td>
		<td colspan="12"></td>
		<td colspan="5" style="{{ $c }}">Change/s (if any)</td>
	</tr>

	<tr>
		<td colspan="5"></td>
		<td colspan="12"></td>
		<td colspan="5" style="{{ $c }}">(for balik-mangagawa only)</td>
	</tr>

	<tr>
		<td>Name:</td>
		<td colspan="5" style="{{ $cblue }}">{{ $data->user->lname }}</td>
		<td colspan="6" style="{{ $cblue }}">{{ $data->user->fname }} {{ $data->user->suffix }}</td>
		<td colspan="6" style="{{ $cblue }}">{{ $data->user->mname }}</td>
		<td></td>
		<td colspan="3" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="5" style="{{ $c }}">Family Name(Apelyido)</td>
		<td colspan="6" style="{{ $c }}">First Name(Pangalan)</td>
		<td colspan="6" style="{{ $c }}">Middle Name(Gitnang Apelyido)</td>
		<td></td>
		<td colspan="3" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="6">Address in the Philippines: (Tirahan)</td>
		<td colspan="16" style="{{ $c }} {{ $blue }}">{{ $data->user->address }}</td>
	</tr>

	<tr>
		<td colspan="2">Telephone No.:</td>
		<td colspan="5" style="{{ $c }} {{ $blue }}">#N/A</td>
		<td colspan="4">Cellphone No.:</td>
		<td colspan="4" style="{{ $cblue }}">{{ $data->user->contact }}</td>
		<td colspan="3">Email Address:</td>
		<td colspan="4" style="{{ $cblue }}">{{ $data->user->email }}</td>
	</tr>

	{{ $fill() }}

	<tr>
		<td colspan="2">Date of Birth:</td>
		<td style="{{ $cblue }}">{{ $data->user->birthday ? $data->user->birthday->format("M") : "" }}</td>
		<td style="{{ $cblue }}">{{ $data->user->birthday ? $data->user->birthday->format("d") : "" }}</td>
		<td colspan="2" style="{{ $cblue }}">{{ $data->user->birthday ? $data->user->birthday->format("Y") : "" }}</td>
		<td style="{{ $c }}">Sex:</td>
		<td style="{{ $cblue }}">✓</td>
		<td style="{{ $c }}">M</td>
		<td style="{{ $cblue }}"></td>
		<td style="{{ $c }}">F</td>
		<td colspan="2" style="text-align: right;">Civil Status:</td>
		<td style="{{ $c }}">{{ $data->civil_status == "Single" ? "✓" : "" }}</td>
		<td>Single</td>
		<td style="{{ $c }}">{{ $data->civil_status == "Widowed" ? "✓" : "" }}</td>
		<td colspan="2">Widowed</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="2">Place of Birth:</td>
		<td colspan="10" style="{{ $cblue }}">{{ $data->birth_place }}</td>
		<td></td>
		<td style="{{ $c }}">{{ $data->civil_status == "Married" ? "✓" : "" }}</td>
		<td>Married</td>
		<td style="{{ $c }}">{{ $data->civil_status == "Divorced" ? "✓" : "" }}</td>
		<td colspan="2">Separated</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="2">Passport No.:</td>
		<td colspan="5" style="{{ $cblue }}">
			{{ isset($data->document_id->PASSPORT) ? $data->document_id->PASSPORT->number : "-" }}
		</td>
		<td colspan="7">Highest Educational Attainment:</td>
		<td colspan="8" style="{{ $cblue }}">
			@php
				$educ = "-";

				foreach($data->educational_background as $eb){
					if($eb->type == "College"){
						$educ = "College";
					}
				}

				if($educ == "-"){
					foreach($data->educational_background as $eb){
						if($eb->type == "Vocational"){
							$educ = "Vocational";
						}
					}
				}

				if($educ == "-"){
					foreach($data->educational_background as $eb){
						if($eb->type == "Undergraduate"){
							$educ = "Undergraduate";
						}
					}
				}

				if($educ == "-"){
					foreach($data->educational_background as $eb){
						if($eb->type == "High School"){
							$educ = "High School";
						}
					}
				}
			@endphp

			{{ $educ }}
		</td>
	</tr>

	<tr>
		<td colspan="4">Name of Spouse (if married):</td>
		<td colspan="8" style="{{ $cblue }}">
			@foreach($data->family_data as $fd)
				@if($fd->type == "Spouse")
					{{ $fd->namefull }}
				@endif
			@endforeach
		</td>
		<td colspan="6">Mother's Full Maiden Name:</td>
		<td colspan="4" style="{{ $cblue }}">
			@foreach($data->family_data as $fd)
				@if($fd->type == "Mother")
					{{ $fd->namefull }}
				@endif
			@endforeach
		</td>
	</tr>

	<tr>
		<td colspan="12">
			Legal Beneficiaries (Mga tatanggap ng benepisyo mula sa OWWA)
		</td>
		<td colspan="3">Father's Name:</td>
		<td colspan="6" style="{{ $cblue }}">
			@foreach($data->family_data as $fd)
				@if($fd->type == "Father")
					{{ $fd->namefull }}
				@endif
			@endforeach
		</td>
	</tr>

	<tr>
		<td colspan="7" style="{{ $c }}">Name</td>
		<td colspan="6" style="{{ $c }}">Relationship to Worker</td>
		<td colspan="9" style="{{ $c }}">Address</td>
	</tr>

	@php
		$fd = $data->family_data;
		$fd = $fd->filter(function($f){
			return $f->type == "Beneficiary";
		});
	@endphp

	@foreach($fd as $f)
		<tr>
			<td colspan="7" style="{{ $c }}">{{ $f->namefull }}</td>
			<td colspan="6" style="{{ $c }}">{{ $f->type }}</td>
			<td colspan="9" style="{{ $c }}">{{ $f->address }}</td>
		</tr>
	@endforeach

	@for($i = 0; $i < (5 - sizeof($fd)); $i++)
		<tr>
			<td colspan="7" style="{{ $c }}"></td>
			<td colspan="6" style="{{ $c }}"></td>
			<td colspan="9" style="{{ $c }}"></td>
		</tr>
	@endfor

	<tr>
		<td colspan="22" style="{{ $u }}">Allottee (Itinaga na padadalhan ng bahagi ng sahod nf OFW/Seafarer)</td>
	</tr>

	{{ $fill() }}

	<tr>
		<td colspan="22">
			Legal Dependents (Mga tatanggap ng benepisyo mula sa PhilHealth)
		</td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $c }}">Name of Spouse/Children/Parent</td>
		<td colspan="3" style="{{ $c }}">Sex</td>
		<td colspan="6" style="{{ $c }}">Relationship of Dependent to Worker</td>
		<td colspan="5" style="{{ $c }}">Date of Birth</td>
	</tr>

	@php
		$fd = $data->family_data;
		$fd = $fd->filter(function($f){
			return $f->type == "Allottee";
		});
	@endphp

	@foreach($fd as $f)
		<tr>
			<td colspan="8" style="{{ $c }}">{{ $f->namefull }}</td>
			<td colspan="3" style="{{ $c }}">
				@if(in_array($f->type, ["Father", "Son"]))
					Male
				@elseif(in_array($f->type, ["Mother", "Spouse", "Daugther"]))
					Female
				@endif
			</td>
			<td colspan="6" style="{{ $c }}">{{ $f->type }}</td>
			<td colspan="5" style="{{ $c }}">{{ $f->birthday ? $f->birthday->format("d-M-Y") : "" }}</td>
		</tr>
	@endforeach

	@for($i = 0; $i < (5 - sizeof($fd)); $i++)
		<tr>
			<td colspan="8" style="{{ $c }}"></td>
			<td colspan="3" style="{{ $c }}"></td>
			<td colspan="6" style="{{ $c }}"></td>
			<td colspan="5" style="{{ $c }}"></td>
		</tr>
	@endfor

	<tr>
		<td colspan="17" style="{{ $u }}">II. CONTRACT PARTICULARS</td>
		<td colspan="5" style="{{ $c }}">Change/s (if any)</td>
	</tr>

	<tr>
		<td colspan="17"></td>
		<td colspan="5" style="{{ $c }}">(for balik-mangagawa only)</td>
	</tr>

	<tr>
		<td colspan="4">Name of Principal / Company / Employer</td>
		<td colspan="14" style="{{ $blue }} font-size: 20px;">
			{{ $data->pro_app->principal->full_name }}
		</td>
		<td></td>
		<td colspan="3" style="{{ $cblue }}"></td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="11" style="{{ $blue }}">
			{{ $data->pro_app->principal->address }}
		</td>
		<td colspan="6">
			E-mail Address
			<br style='mso-data-placement:same-cell;' />
			{{ $data->pro_app->principal->email }}
		</td>
		<td></td>
		<td colspan="3" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="4">Vessel Name:</td>
		<td colspan="8" style="{{ $cblue }}">{{ $data->pro_app->vessel->name }}</td>
		<td>Tel. No.</td>
		<td colspan="5" style="{{ $cblue }}">
			{{ $data->pro_app->principal->contact }}
		</td>
		<td></td>
		<td colspan="3" style="{{ $cblue }}"></td>
	</tr>

	<tr>
		<td colspan="3">Position of OFW/Seafarer</td>
		<td colspan="8" style="{{ $cblue }}">{{ $data->pro_app->rank->name }}</td>
		<td colspan="2">Contract Duration:</td>
		<td colspan="9">{{ $data->req['employment_months'] }} MONTHS</td>
	</tr>

	<tr>
		<td colspan="2">Basic Salary:</td>
		<td colspan="4" style="{{ $cblue }}">US ${{ number_format($data->wage->basic ?? 0, 2) }}</td>
		<td colspan="2">Currency</td>
		<td colspan="4" style="{{ $cblue }}">US DOLLAR</td>
		<td></td>
		<td colspan="5" style="{{ $cblue }}"></td>
		<td></td>
		<td colspan="3" style="{{ $cblue }}"></td>
	</tr>

	<tr>
		<td colspan="11">
			Last date of arrival in the Phils of the OFW Balik-
			<br style='mso-data-placement:same-cell;' />
			manggagawa/seafarer
		</td>
		<td colspan="7" style="{{ $cblue }}"></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="11">
			Date of scheduled departure / return of balik-manggagawa to the
			<br style='mso-data-placement:same-cell;' />
			jobsite
		</td>
		<td colspan="7" style="{{ $cblue }}"></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="11">
			Name of Philippine Recruitment/Manning Agency
			<br style='mso-data-placement:same-cell;' />
			(if applicable)
		</td>
		<td colspan="11" style="{{ $blue }}">SOLPIA MARINE &#38; SHIP MANAGEMENT INC.</td>
	</tr>

	<tr>
		<td colspan="22">
			I hereby certify that the above statements are true and correct and further declare that the above-named dependents have not been
		</td>
	</tr>

	<tr>
		<td colspan="22">
			declared by my spouse/brother/sister. (Ako ay nagpapatunay na ang nasa itaas na pahayag ay totoo at tama at dagdag kong inihahayag
		</td>
	</tr>

	<tr>
		<td colspan="22">
			na ang nasabing makikinabang sa itaas ay hindi inihayag ng aking asawa o kapatid.)
		</td>
	</tr>

	{{ $fill() }}

	<tr>
		<td colspan="12"></td>
		<td colspan="9" style="{{ $cblue }}">
			{{ $data->user->fullname2 }}
		</td>
	</tr>

	<tr>
		<td colspan="12"></td>
		<td colspan="9" style="{{ $c }}">
			Signature / Thumbmark of OFW / Seafarer
		</td>
	</tr>

	<tr>
		<td colspan="21" style="text-align: right;">
			@php
				$ss = $data->sea_service->filter(function($s){
					return str_contains($s->manning_agent, "SOLPIA");
				});

				echo $ss->count() > 0 ? "REENGAGED" : "ENGAGED";
			@endphp
		</td>
	</tr>

	<tr>
		<td colspan="21" style="text-align: right;">
			{{ isset($data->document_lc->{"POEA EREGISTRATION"}) ? $data->document_lc->{"POEA EREGISTRATION"}->no : "-" }}
		</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $c }}">EMBARKED DATE: </td>
		<td colspan="16" style="text-align: right;">
			{{ isset($data->document_id->{"SEAMAN'S BOOK"}) ? $data->document_id->{"SEAMAN'S BOOK"}->number : "-" }}
		</td>
	</tr>
</table>