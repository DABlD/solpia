@php
	$rank = null;

	if(isset($data->pro_app->rank)){
		$rank = $data->pro_app->rank->abbr;
	}
	else{
		$temp = $data->document_flag->first();

		if($temp){
			$rank = $temp->rankz->abbr;
		}
		else{
			if($data->id == 6149){
				$rank = "WPR";
			}
		}
	}
@endphp

<style>
	.page_break { page-break-before: always; }

	.ballot-box{
	    display:inline-block;
	    width:10px;
	    height:10px;
	    border:1px solid #000;
	    vertical-align: -1px;
	    text-align:center;
	    line-height:9px;
	}

	@page {
        margin-top: 5px;
        {{-- margin-right: 20px; --}}
        margin-bottom: 5px;
        {{-- margin-left: 20px; --}}
    }
</style>

<center>
	<img src='{{ public_path('images/clinics/windsor_logo_lowered.png') }}' width='300px' height='70px'>
</center>

<br>

<center>
	Unit 2110-2117 Trium Square Bldg. Sen. Gil Puyat Ave. Cor Leveriza St. Pasay City 1300
	<br>
	Telephone Number: (02) 8 8243302
</center>

<br>

<table style="width: 100%;">
	<tr>
		<td></td>
		<td>
			<center>
				<b>
					REFERRAL FORM
				</b>
			</center>
		</td>
		<td rowspan="2" style="text-align: center;">
			<img src="{{ $data->user->avatar }}" alt="Attach 1 x 1 ID Picture" width="120" height="120" style="border: 2px solid black;">
		</td>
	</tr>

	<tr>
		<td colspan="2">
			Date: {{ now()->format('d-M-Y') }}
			<br>
			Name of Company/Employer: Solpia Marine &#38; Ship Management, Inc.
			<br>
			Country of Destination:
		</td>
	</tr>
</table>

<br>

<table style="width: 100%;">
	<tr>
		<td colspan="8">
			<b>APPLICANT</b>
		</td>
	</tr>

	<tr>
		<td style="width: 8%;">Name:</td>
		<td style="width: 26%; border-bottom: 1px solid black; text-align: center; font-size: 11px;">{{ $data->user->lname }}</td>
		<td style="width: 20%; border-bottom: 1px solid black; text-align: center; font-size: 11px;">{{ $data->user->fname }}</td>
		<td style="width: 26%; border-bottom: 1px solid black; text-align: center; font-size: 11px;">{{ $data->user->mname }}</td>
		<td style="width: 5%;">Age:</td>
		<td style="width: 5%; border-bottom: 1px solid black; text-align: center; font-size: 11px;">
			{{ isset($data->user->birthday) ? $data->user->birthday->age : "-" }}
		</td>
		<td style="width: 5%;">Sex:</td>
		<td style="width: 5%; border-bottom: 1px solid black; text-align: center; font-size: 11px;">M</td>
	</tr>

	<tr>
		<td></td>
		<td style="text-align: center; font-style: italic; font-size: 8px;">SURNAME</td>
		<td style="text-align: center; font-style: italic; font-size: 8px;">FIRST NAME</td>
		<td style="text-align: center; font-style: italic; font-size: 8px;">MIDDLE NAME</td>
	</tr>
</table>

<br>

<table style="width: 100%">
	<tr>
		<td style="width: 13%">Date of Birth:</td>
		<td style="width: 13%; font-size: 12px; border-bottom: 1px solid black; text-align: center;">
			{{ $data->user->birthday ? $data->user->birthday->format('d-M-Y') : "-" }}
		</td>
		<td style="width: 13%">Place of Birth:</td>
		<td style="width: 37%; font-size: 12px; border-bottom: 1px solid black; text-align: center;">
			{{ $data->birth_place }}
		</td>
		<td style="width: 11%">Civil Status:</td>
		<td style="width: 3%; font-size: 12px; border-bottom: 1px solid black; text-align: center;">
			{{ $data->civil_status ? $data->civil_status[0] : "-" }}
		</td>
	</tr>
</table>

<table style="width: 100%">
	<tr>
		<td style="width: 10%">Nationality:</td>
		<td style="width: 9%; font-size: 12px; border-bottom: 1px solid black; text-align: center;">
			FILIPINO
		</td>
		<td style="width: 10%">Religion:</td>
		<td style="width: 20%; font-size: 12px; border-bottom: 1px solid black; text-align: center;">
			{{ $data->religion }}
		</td>
		<td style="width: 15%">Contact No./s:</td>
		<td style="width: 36%; font-size: 12px; border-bottom: 1px solid black; text-align: center;">
			{{ $data->user->contact }}
		</td>
	</tr>
</table>

<table style="width: 100%">
	<tr>
		<td style="width: 27%">Permanent Home Address:</td>
		<td style="width: 73%; font-size: 12px; border-bottom: 1px solid black; text-align: center;">
			{{ $data->provincial_address }}
		</td>
	</tr>
</table>

@php
	$pp = null;
	$sb = null;
	$ppImg = null;
	$sbImg = null;

	foreach($data->document_id as $doc){
		if($doc->type == "PASSPORT"){
			$pp = $doc;
			if($doc->file){
				$ppImg = json_decode($doc->file) ? json_decode($doc->file)[0] : $doc->file;
			}
		}
		elseif($doc->type == "SEAMAN'S BOOK"){
			$sb = $doc;
			if($doc->file){
				$sbImg = json_decode($doc->file) ? json_decode($doc->file)[0] : $doc->file;
			}
		}
	}
@endphp

<table style="width: 100%">
	<tr>
		<td style="width: 20%">Position Applied for:</td>
		<td style="width: 30%; font-size: 12px; border-bottom: 1px solid black; text-align: center;">
			{{ $rank }}
		</td>
		<td style="width: 20%">Passport Number:</td>
		<td style="width: 30%; font-size: 12px; border-bottom: 1px solid black; text-align: center;">
			{{ $pp->number }}
		</td>
	</tr>
</table>

<table style="width: 50%;">
	<tr>
		<td style="width: 50%;">Seaman's Book Number:</td>
		<td style="width: 50%; font-size: 12px; border-bottom: 1px solid black; text-align: center;">
			{{ $sb->number }}
		</td>
	</tr>
</table>

<table style="width: 60%;">
	<tr>
		<td style="width: 60%">Schedule of Medical Examination on:</td>
		<td style="width: 25%; font-size: 12px; border-bottom: 1px solid black; text-align: center;">
			{{--  --}}
		</td>
		<td style="width: 8%;">, 20</td>
		<td style="width: 7%; font-size: 12px; border-bottom: 1px solid black; text-align: center;">
			{{--  --}}
		</td>
	</tr>
</table>

<br>

<div style="width: 100%; text-align: left;">
	<b>Please conduct the following:</b>
	<br>
	<span class="ballot-box"></span>
	 DOH Basic Pre-Employment Medical Examination
	<br>
	<span class="ballot-box"></span>
	 PEME A for New Candidates (Modified)
	<br>
	<span class="ballot-box"></span>
	 PEME B for Serving Seafarers below 40 Years Old (Modified)
	<br>
	<span class="ballot-box"></span>
	 PEME C for Serving Seafarers 40 Years Old and Above (Modified)
	<br>
	<span class="ballot-box"></span>
	 PEME D for Food Handlers (Modified)
	<br>
	<span class="ballot-box"></span>
	 Windsor Medical Package
	<br>
	<span class="ballot-box"></span>
	 Customized Company Package
	<br>
</div>

<br>
<div style="width: 100%; text-align: left;">
	<b>Additional Test/s:</b>
</div>

<table style="width: 100%;">
	<tr>
		<td style="width: 33%;">
			<span class="ballot-box"></span>
			 HIV Test
		</td>
		<td style="width: 33%;">
			<span class="ballot-box"></span>
			 Hepa B Screening
		</td>
		<td style="width: 33%;">
			<span class="ballot-box"></span>
			 Drug and Alcohol Testing
		</td>
	</tr>

	<tr>
		<td style="width: 33%;">
			<span class="ballot-box"></span>
			 Serum Pregnancy Test
		</td>
		<td style="width: 33%;">
			<span class="ballot-box"></span>
			 Stool Culture
		</td>
	</tr>
</table>

<table style="width: 100%;">
	<tr>
		<td style="width: 25%;">
			<span class="ballot-box">X</span>
			 Others (please specify):
		</td>
		<td style="width: 75%; border-bottom: 1px solid black;">
			HMM PACKAGE WITH DAAT AND PANAMA(FLAG)
		</td>
	</tr>
</table>

<br>
<div style="width: 100%; text-align: left;">
	<b>Billed to:</b>
</div>

<table width="70%;">
	<tr>
		<td style="width: 33%;">
			<span class="ballot-box"></span>
			 Manning Agency
		</td>
		<td style="width: 33%;">
			<span class="ballot-box"></span>
			 Principal
		</td>
		<td style="width: 33%;">
			<span class="ballot-box"></span>
			 Crew Account
		</td>
	</tr>
</table>

<br>
<br>

<table width="100%;">
	<tr>
		<td style="width: 45%; text-align: center; font-size: 14px; border-bottom: 1px solid black;">
			{{ auth()->user()->fullname }}
		</td>
		<td style="width: 20%;"></td>
		<td style="width: 35%; text-align: center; font-size: 14px; border-bottom: 1px solid black;">
			{{-- ROXAN, ABBY, LJ --}}
			@if(in_array(auth()->user()->id, [6109, 5716, 5007]))
				Asst. Crewing Manager
			@else
				{{ auth()->user()->role }}
			@endif
		</td>
	</tr>

	<tr>
		<td style="width: 45%; text-align: center;">
			Signature over Printed Name
			<br>
			of Authorized Official Representative
		</td>
		<td style="width: 20%;"></td>
		<td style="width: 35%; text-align: center; vertical-align: text-top;">Position</td>
	</tr>
</table>

<br>
<center>(Please see Instructions to Applicant and Location Map at the back.)</center>

<br>
<div style="width: 100%; text-align: left;">
	FORM CREATED: MAY 7, 2014
</div>
<div style="width: 100%;">
	<span style="float: left;">
		FORM REVISION: 01
	</span>

	<span style="float: right;">
		WIMC F 59
	</span>
</div>

<div class="page_break"></div>
{{-- PAGE 2 --}}
{{-- PAGE 2 --}}
{{-- PAGE 2 --}}

<br>
<br>
<br>
INSTRUCTIONS TO APPLICANT
<br>
<br>

<div>

    <strong>A. Bring the following:</strong>

    <ol style="padding-left: 40px; margin-top: 0; margin-bottom: 5px;">
        <li>
            One (1) sterile bottle. LABEL THE BOTTLE WITH YOUR COMPLETE NAME.
            Place a pea-sized sample of your stool.
        </li>
        <li>
            One (1) valid ID with photo (e.g., Passport) NBI Clearance or Seaman's Book).
        </li>
    </ol>


    <strong>B. Preparation for laboratory examination.</strong>

    <ol style="padding-left: 40px; margin-top: 0; margin-bottom: 5px;">
        <li>
            Do not eat or drink anything for 10 to 12 HOURS prior to the examination
            (NO solid or liquid food, coffee, tea, milk, juice, water, candy, chewing gum, medications).
        </li>
        <li>
            Smoking is also not allowed during fasting.
        </li>
        <li>
            Do not engage in any strenuous activity prior to examination (including sexual activity)
        </li>
        <li>
            If you are for liver function testing, refrain from alcohol intake for at least five (5) days prior
            to the test.
        </li>
    </ol>


    <strong>C. Non-compliance with the instruction above may cause a delay in the processing of</strong>
    <br>
    <span style="padding-left: 23px;">your application.</span>
</div>

<br>
<br>
<span style="font-size: 13px;">
	I HAVE READ, FULLY UNDERSTOOD AND I AGREE TO COMPLY WITH THE ABOVE-MENTIONED REQUIREMENTS.
</span>
<br>
<br>

<table width="100%;">
	<tr>
		<td style="width: 45%; text-align: center; font-size: 14px; border-bottom: 1px solid black;">
			{{ $data->user->fullname }}
		</td>
		<td style="width: 20%;"></td>
		<td style="width: 35%; text-align: center; font-size: 14px; border-bottom: 1px solid black;">
			{{ now()->format('d-M-Y') }}
		</td>
	</tr>

	<tr>
		<td style="width: 45%; text-align: center;">
			Signature over Printed Name
		</td>
		<td style="width: 20%;"></td>
		<td style="width: 35%; text-align: center; vertical-align: text-top;">
			Date Signed
		</td>
	</tr>
</table>

<br>
<center style="font-size: 20px;">
	LOCATION: TRIUM SQUARE, PASAY CITY
</center>

<br>
<center>
	<img src='{{ public_path('images/maps/windsor.png') }}' width='100%' height='500px' style="border: 3px solid black;">
</center>

<br>

<center>
	<b style="font-size: 20px;">
		MONDAY TO FRIDAY 7AM - 6PM
	</b>
</center>


@if($ppImg)
<img src="{{ public_path("files/$data->id/$pp") }}" width="700px" height="500px">
<br>
@endif

@if($sbImg)
<img src="{{ public_path("files/$data->id/$sb") }}" width="700px" height="500px">
@endif