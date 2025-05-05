<style>
	.page_break { page-break-before: always; }
</style>

<table>
	<tr>
		<td colspan="9">
			<img src='{{ public_path('images/letter_head.jpg') }}' width='710px' height='70px'>
		</td>
	</tr>

	<tr>
		<td colspan="9" style="text-align: center;">
			MEDICAL REFERRAL FORM
		</td>
	</tr>

	<tr style="vertical-align: middle;">
		<td colspan="6">
			Date: {{ now()->format('d-M-Y') }}
		</td>
		<td style="font-family: 'DejaVu Sans, sans-serif; font-size: 20px; text-align: right;';">
			&#9744;
		</td>
		<td colspan="2" style="vertical-align: middle;">First time at MCIS</td>
	</tr>

	<tr style="vertical-align: middle;">
		<td colspan="6">
		</td>
		<td style="font-family: 'DejaVu Sans, sans-serif; font-size: 20px; text-align: right;';">
			&#9744;
		</td>
		<td colspan="2" style="vertical-align: middle;">Returnee to MCIS</td>
	</tr>

	<tr>
		<td>I.</td>
		<td>
			Worker:
		</td>
		<td colspan="7"></td>
	</tr>

	<tr style="font-family: 'DejaVu Sans, sans-serif; font-size: 12px;';">
		<td></td>
		<td colspan="2">
			ㅤㅤㅤㅤLAST NAME
		</td>
		<td colspan="6">{{ $data->user->lname }}</td>
	</tr>

	<tr style="font-family: 'DejaVu Sans, sans-serif; font-size: 12px;';">
		<td></td>
		<td colspan="2">
			ㅤㅤㅤㅤFIRST NAME
		</td>
		<td colspan="6">{{ $data->user->fname }} {{ $data->user->suffix }}</td>
	</tr>

	<tr style="font-family: 'DejaVu Sans, sans-serif; font-size: 12px;';">
		<td></td>
		<td colspan="2">
			ㅤㅤㅤㅤMIDDLE NAME
		</td>
		<td colspan="6">{{ $data->user->mname }}</td>
	</tr>

	<tr>
		<td></td>
		<td>Address:</td>
		<td colspan="5" style="border-bottom: 1px solid black; font-size: 10px;">{{ $data->address ?? $data->provincial_address }}</td>
		<td>Age:</td>
		<td style="border-bottom: 1px solid black; text-align: center;">{{ $data->user->birthday ? $data->user->birthday->age : "-" }}</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2">Position Applied for:</td>
		<td style="border-bottom: 1px solid black; text-align: center;">{{ isset($data->pro_app->rank) ? $data->pro_app->rank->abbr : "-" }}</td>
		<td style="text-align: right;">Sex:</td>
		<td style="border-bottom: 1px solid black; text-align: center;">Male</td>
		<td colspan="2" style="text-align: right;">Civil Status:</td>
		<td style="border-bottom: 1px solid black; text-align: center;">{{ $data->civil_status }}</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2">Contact Number(s):</td>
		<td colspan="6" style="border-bottom: 1px solid black; text-align: center;">
			{{ $data->user->contact ?? $data->provincial_contact }}
		</td>
	</tr>

	{{-- II --}}
	{{-- II --}}
	{{-- II --}}

	<tr>
		<td colspan="9" style="height: 30px;"></td>
	</tr>

	<tr>
		<td>II.</td>
		<td colspan="8">INSTRUCTIONS TO WORKERS</td>
	</tr>

	<tr>
		<td></td>
		<td style="text-align: center;">1.</td>
		<td colspan="7">
			You are scheduled for Medical Examination on _____________, 20 ________ at
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="7" style="text-align: center; font-weight: bold;">
			MARITIME CLINIC FOR INTERNATIONAL SEAFARERS, INC.
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="7" style="font-size: 12px; text-align: center;">
			7/F Intramuros Corporate Plaza, Recoletos Street, Intramuros, Manila, 1002 Philippines.
		</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td></td>
		<td style="text-align: center">2.</td>
		<td colspan="7">Bring the following:</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="7">
			2.1 One (1) sterile bottle - LABEL THE BOTTLE WITH YOUR COMPLETE NAME
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="7" style="font-family: DejaVu Sans; sans-serif; font-size: 13px;">
			ㅤㅤㅤㅤ- Place a pea-size sample of your stool.
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="7">
			2.2 Valid I.D. (i.e. Passport, NBI Clearance or Seaman's Book) with Photo.
		</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td></td>
		<td style="text-align: center;">3.</td>
		<td colspan="7">Patient instructions for accurate lab results:</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="7">
			3.1 Do not eat nor drink anything except water for 12 HOURS prior to the exam
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="7" style="font-family: DejaVu Sans; sans-serif; font-size: 13px;">
			ㅤㅤㅤㅤ(including any medications you may be taking at the time)
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="7" style="font-family: DejaVu Sans; sans-serif; font-size: 13px;">
			ㅤㅤㅤㅤ- Drink at least 500 ml of water prior to exam
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="7">
			3.2 Do not partake in any strenuous activity at least 2 HOURS prior to the exam.
		</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td></td>
		<td style="text-align: center;">4.</td>
		<td colspan="7">If you are for liver function testing, it is advised that you refrain from alcohol intake for at least 5 days prior to testing.</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td></td>
		<td style="text-align: center;">5.</td>
		<td colspan="7">Non-compliance with the above instructions may cause a delay in the processing of your application.</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 20px;"></td>
	</tr>

	<tr>
		<td colspan="9" style="font-weight: bold; white-space: nowrap;">
			I HAVE READ, UNDERSTOOD AND AGREE TO COMPLY WITH THE ABOVE REQUIREMENTS.
		</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 30px;"></td>
	</tr>

	<tr>
		<td colspan="3" style="border-bottom: 1px solid black; text-align: center;">{{ now()->format('d-M-Y') }}</td>
		<td colspan="2"></td>
		<td colspan="4" style="border-bottom: 1px solid black; text-align: center; white-space: nowrap;">
			{{ $data->pro_app->rank->abbr }} {{ $data->user->namefull }}
		</td>
	</tr>

	<tr>
		<td colspan="3" style="text-align: center;">Date</td>
		<td colspan="2"></td>
		<td colspan="4" style="text-align: center;">Signature</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 30px;"></td>
	</tr>

	<tr>
		<td colspan="2" style="white-space: nowrap;">Spell out other Tests:</td>
		<td colspan="7" style="border-bottom: 1px solid black; text-align: center;">
			HMM PACKAGE WITH {{ $data->req['flag'] ?? "(FLAG)" }}
		</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 30px;"></td>
	</tr>

	<tr>
		<td colspan="4" style="border-bottom: 1px solid black; white-space: nowrap; text-align: center;">
			{{ auth()->user()->fullname }}
		</td>
		<td colspan="2"></td>
		<td colspan="3" style="border-bottom: 1px solid black; text-align: center;">
			{{ auth()->user()->role }}
		</td>
	</tr>

	<tr>
		<td colspan="4" style="text-align: center; font-size: 13px;">
			Signature Over Printed Name of Authorized Official
		</td>
		<td colspan="2"></td>
		<td colspan="3" style="text-align: center;">
			Designation
		</td>
	</tr>
</table>

<div class="page_break"></div>

<img src="{{ public_path('images/MAPS/mcis.png') }}" width="700px" height="1000px">

<div class="page_break"></div>

@php
	$pp = null;
	$sb = null;

	foreach($data->document_id as $doc){
		if($doc->type == "PASSPORT" && $doc->file){
			$pp = json_decode($doc->file) ? json_decode($doc->file)[0] : $doc->file;
		}
		elseif($doc->type == "SEAMAN'S BOOK" && $doc->file){
			$sb = json_decode($doc->file) ? json_decode($doc->file)[0] : $doc->file;
		}
	}
@endphp

<img src="{{ public_path("files/$data->id/$pp") }}" width="700px" height="500px">

<br>

<img src="{{ public_path("files/$data->id/$sb") }}" width="700px" height="500px">