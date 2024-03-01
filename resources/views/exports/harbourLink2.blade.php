@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$i = "font-style: italic;";
	$bc = "$b $c";

	$checkDate2 = function($date, $type){
		if($date == "UNLIMITED"){
			return $date;
		}
		elseif($date == "" || $date == null){
			if($type == "E"){
				return 'UNLIMITED';
			}
			else{
				return '-----';
			}
		}
		else{
			return $date->format('d M Y');
		}
	};

	$cleanText = function($text){
		return str_replace('&', '&#38;', $text);
	};

	// CHECK IF WATCHKEEPING AND HAS RANK AND IS DECK OR ENGINE RATING
	if(isset($applicant->rank_id)){
		$rank = $applicant->rank_id;
	}
	else{
		if(isset($applicant->rank)){
			$rank = $applicant->rank->id;
		}
		else{
			$rank = 0;
		}
	}
@endphp

<table>

	{{-- HEADER --}}

	<tr>
		<td colspan="12"></td>
		<td>Form No</td>
		<td>: HRD/F-04 (R2)</td>
	</tr>
	<tr>
		<td colspan="12"></td>
		<td>Date</td>
		<td>: 08/09/2018</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="3"></td>
		<td rowspan="3"></td>
		<td colspan="9"></td>
		<td rowspan="3" style="{{ $c }}">
			Affix Photo Here
			<br style='mso-data-placement:same-cell;' />
			Lekat foto di sini
		</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $b }} font-size: 20px;">APPLICATION FOR EMPLOYMENT</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $b }} {{ $i }} font-size: 16px;">Borang Permohonan Kerja</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $b }}">POSITION APPLIED FOR</td>
		<td colspan="6" rowspan="2" style="{{ $b }}">1. {{ $data->rank->name }}</td>
		<td colspan="4" rowspan="2" style="{{ $b }}">2.</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $b }} {{ $i }}">JAWATAN DIPOHON</td>
	</tr>

	{{-- SECTION A --}}

	<tr>
		<td rowspan="3" style="{{ $bc }}">A</td>
		<td colspan="3" style="{{ $b }}">PERSONAL</td>
		<td colspan="6">Full Name/Nama Penuh</td>
		<td colspan="4">Chinese/Other Name, if any</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $b }}">PARTICULARS</td>
		<td colspan="6">(As given in IC / Mengikut KP)</td>
		<td colspan="4" style="{{ $i }}">Nama Cina/Lain, jika ada</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $b }} {{ $i }}">BUTIR-BUTIR PERIBADI</td>
		<td colspan="6" style="{{ $b }}">{{ $data->user->fullname2 }}</td>
		<td colspan="4" style="{{ $b }}">N/A</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $b }}">Present Address</td>
		<td colspan="5" style="{{ $i }}"> / Alamat Kediaman Sekarang (Bintulu)</td>
		<td colspan="3" style="{{ $b }}">Identity Card No</td>
		<td colspan="4" style="{{ $i }}"> / No Kad Pengenalan</td>
	</tr>

	<tr>
		<td colspan="7" rowspan="4" style="{{ $b }}">{{ $data->user->address ?? $data->provincial_address }}</td>
		<td colspan="7"></td>
	</tr>

	<tr>
		<td style="{{ $b }}">Old</td>
		<td style="{{ $i }}"> / Lama:</td>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td style="{{ $b }}">New</td>
		<td style="{{ $i }}"> / Baru:</td>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td colspan="7" style="{{ $b }}">Applicable to foreigner(s) only</td>
	</tr>

	<tr>
		<td style="{{ $b }}">Tel No</td>
		<td colspan="2" style="{{ $i }}"> / No Telefon:</td>
		<td colspan="4" style="{{ $b }}"> {{ $data->user->contact ?? $data->provincial_contact }}</td>
		<td colspan="2" style="{{ $b }}">Passport No</td>
		<td colspan="2" style="{{ $i }}"> / No Passport</td>
		<td colspan="2" style="text-align: right; {{ $b }}">Expiry Date</td>
		<td style="{{ $i }}">Tarikh Tamat</td>
	</tr>
	
	@php 
		$name = "PASSPORT";
		$docu = isset($data->document_id->{$name}) ? $data->document_id->{$name} : false;
	@endphp

	<tr>
		<td style="{{ $b }}">Fax No</td>
		<td colspan="2" style="{{ $i }}"> / No Fax:</td>
		<td colspan="4"></td>
		<td colspan="4" style="{{ $b }}">{{ $docu ? strtoupper($docu->number) : "---"}}</td>
		<td colspan="3" style="{{ $b }}"> {{ $docu ? $checkDate2($docu->expiry_date, "E") : "---" }}</td>
	</tr>

	<tr>
		<td colspan="7" style="{{ $b }}">Permanent Address, if different from the above</td>
		<td colspan="5" style="{{ $b }}">Date of Birth</td>
		<td colspan="2" style="{{ $b }}">Place of Birth</td>
	</tr>

	<tr>
		<td colspan="7" style="{{ $i }}">Alamat Tetap, jika berlainan dari di atas</td>
		<td colspan="5" style="{{ $i }}">/Tarikh Lahir</td>
		<td colspan="2" style="{{ $i }}">/Tempat Lahir</td>
	</tr>

	<tr>
		<td colspan="7" rowspan="3"></td>
		<td colspan="5" style="{{ $bc }}">{{ $data->user->birthday ? $data->user->birthday->format('F j, Y') : "" }}</td>
		<td colspan="2" style="{{ $bc }}">{{ $data->birth_place }}</td>
	</tr>

	<tr>
		<td style="{{ $b }}">Age</td>
		<td colspan="4" style="{{ $i }}">/Umur</td>
		<td style="{{ $b }}">Gender</td>
		<td style="{{ $i }}">/Jantina</td>
	</tr>

	<tr>
		<td colspan="5" rowspan="2" style="{{ $b }}">{{ $data->user->birthday ? $data->user->birthday->diffInYears(now()) : "" }}</td>
		<td colspan="2" rowspan="2" style="{{ $b }}">MALE</td>
	</tr>

	<tr>
		<td style="{{ $b }}">Tel No</td>
		<td colspan="6" style="{{ $i }}">/No Telefon:</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $b }}">Mailing Address</td>
		<td colspan="5" style="{{ $i }}">/Alamat Pos</td>
		<td colspan="5" style="{{ $b }}">Citizenship</td>
		<td colspan="2" style="{{ $b }}">Ethnic</td>
	</tr>

	<tr>
		<td colspan="7" rowspan="3"></td>
		<td colspan="5" style="{{ $i }}">/Kewarganega raan</td>
		<td colspan="2" style="{{ $i }}">/Bangsa</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }}">FILIPINO</td>
		<td colspan="2" style="{{ $bc }}">N/A</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $b }}">Religion</td>
		<td colspan="5" style="{{ $i }}">/Agama</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $b }}">E-mail Address</td>
		<td colspan="5" style="{{ $i }}">/Alamat E-mail:</td>
		<td colspan="7" rowspan="2" style="{{ $bc }}">{{ $data->religion ?? "---" }}</td>
	</tr>

	<tr>
		<td colspan="7" style="{{ $bc }}">{{ $data->user->email ?? "---" }}</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $b }}">Marital Status</td>
		<td colspan="8" style="{{ $i }}">/Status Perkahwinan</td>
		<td colspan="3" style="{{ $b }}">No of Children</td>
		<td style="{{ $i }}">/Bil. Anak</td>
	</tr>

	@php
		$childrens = 0;
		foreach($data->family_data as $fd){
			if($fd->type == "Son" || $fd->type == "Daughter"){
				$childrens++;
			}
		}
	@endphp

	<tr>
		<td colspan="10">
			@if($data->civil_status == "Single")
				⁣&#128505; Single/Bujang &#x2610; Married/Kahwin &#x2610; Divorcee/Bercerai
			@elseif($data->civil_status == "Married")
				&#x2610; Single/Bujang ⁣&#128505; Married/Kahwin &#x2610; Divorcee/Bercerai
			@elseif($data->civil_status == "Divorced")
				&#x2610; Single/Bujang &#x2610; Married/Kahwin ⁣&#128505; Divorcee/Bercerai
			@else
				&#x2610; Single/Bujang &#x2610; Married/Kahwin &#x2610; Divorcee/Bercerai
			@endif
		</td>
		<td colspan="4" rowspan="2" style="{{ $bc }}">{{ $childrens }}</td>
	</tr>

	<tr>
		<td colspan="10">
			@if($data->civil_status == "Widow")
				&#128505; Widow/Janda &#x2610; Widower/Duda
			@elseif($data->civil_status == "Widowed")
				&#x2610; Widow/Janda &#128505;; Widower/Duda
			@else
				&#x2610; Widow/Janda &#x2610; Widower/Duda
			@endif
		</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $b }}">Driving License Class</td>
		<td colspan="4" style="{{ $i }}">/Kelas Lesen Memandu Mengendali</td>
		<td colspan="5" style="{{ $b }}">Year Obtained</td>
		<td colspan="2" style="{{ $b }}">License No.</td>
	</tr>

	<tr>
		<td colspan="7" rowspan="2" style="{{ $bc }}">N/A</td>
		<td colspan="5" style="{{ $i }}">/Tahun diperolehi</td>
		<td colspan="2" style="{{ $i }}">/No. Lesen</td>
	</tr>

	<tr>
		<td colspan="5"></td>
		<td colspan="2"></td>
	</tr>

	{{-- SECTION B --}}
	<tr>
		<td rowspan="2" style="{{ $bc }}">B</td>
		<td colspan="4" style="{{ $b }}">PARTICULARS OF IMMEDIATE FAMILY</td>
		<td colspan="9" style="{{ $i }}">(Spouse, Children or Parent, Brother &#38; Sister)</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $b }}">BUTIR-BUTIR KELUARYGA TERDEKAT</td>
		<td colspan="9" style="{{ $i }}">(Suami / Isteri, Anak atau Ibubapa, Abang &#38; Kakak)</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $bc }}">Name</td>
		<td colspan="2" style="{{ $bc }}">Relationship</td>
		<td colspan="2" style="{{ $bc }}">Sex</td>
		<td style="{{ $bc }}">Age</td>
		<td colspan="4" style="{{ $bc }}">Occupation</td>
		<td style="{{ $bc }}">Name of</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $c }} {{ $i }}">Nama</td>
		<td colspan="2" style="{{ $c }} {{ $i }}">Hubungan</td>
		<td colspan="2" style="{{ $c }} {{ $i }}">Jantina</td>
		<td style="{{ $c }} {{ $i }}">Umur</td>
		<td colspan="4" style="{{ $c }} {{ $i }}">Pekerjaan</td>
		<td style="{{ $bc }}">Employer</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $c }} {{ $i }}"></td>
		<td colspan="2" style="{{ $c }} {{ $i }}"></td>
		<td colspan="2" style="{{ $c }} {{ $i }}"></td>
		<td style="{{ $c }} {{ $i }}"></td>
		<td colspan="4" style="{{ $c }} {{ $i }}"></td>
		<td style="{{ $c }} {{ $i }}">Nama Majikan</td>
	</tr>

	@foreach($data->family_data as $fd)
		<tr>
			<td colspan="4" style="{{ $bc }}">{{ $fd->fullname2 }}</td>
			<td colspan="2" style="{{ $bc }}">{{ $fd->type }}</td>
			<td colspan="2" style="{{ $bc }}">
				@if(in_array($fd->type, ["Mother", "Spouse", "Daughter", "Partner"]))
					Female
				@elseif(in_array($fd->type, ["Father", "Son"]))
					Male
				@else

				@endif
			</td>
			<td style="{{ $bc }}">{{ $fd->birthday && $fd->type ? $fd->birthday->diffInYears(now()) : "" }}</td>
			<td colspan="4" style="{{ $bc }}">{{ $fd->occupation }}</td>
			<td style="{{ $bc }}"></td>
		</tr>
	@endforeach

	{{-- BREAK PAGE --}}
	<div style="page-break-after:always;"></div>

	{{-- SECTION C --}}

	<tr>
		<td rowspan="2" style="{{ $bc }}">C</td>
		<td colspan="13" style="{{ $b }}">ACADEMIC RECORD</td>
	</tr>

	<tr>
		<td colspan="13" style="{{ $b }} {{ $i }}">REKOD AKADEMIK</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $bc }}">Education Level</td>
		<td colspan="2" style="{{ $bc }}">From Year</td>
		<td style="{{ $bc }}">To Year</td>
		<td colspan="4" style="{{ $bc }}">School / Institute / University</td>
		<td colspan="3" style="{{ $bc }}">Certificate &#38; Grade Attained</td>
		<td style="{{ $bc }}">Majored Subject</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $c }} {{ $i }}">Tahap Pendidikan</td>
		<td colspan="2" style="{{ $c }} {{ $i }}">Dari Tahun</td>
		<td style="{{ $c }} {{ $i }}">Ke Tahun</td>
		<td colspan="4" style="{{ $c }} {{ $i }}">Sekolah / Institut / Universiti</td>
		<td colspan="3" style="{{ $c }} {{ $i }}">Sijil &#38; Gred Diperolehi</td>
		<td style="{{ $c }} {{ $i }}">Mata Pelajaran</td>
	</tr>

	{{-- SCHOOL --}}
	@php

		$eb = function($type) use($data){
			$from = "";
			$to = "";
			$school = "";
			$course = "";

			$temp = $data->educational_background->filter(function($value) use($type){
				return $value->type == $type;
			});

			if(count($temp)){
				$temp = $temp->first();

				$range = explode('-', $temp->year);

				$from = is_numeric($range[0]) ? $range[0] : "-";
				$to = is_numeric($range[1]) ? $range[1] : "-";
				$school = $temp->school;
				$course = $temp->course;
			}
			else{
				$from = "";
				$to = "";
				$school = "";
				$course = "";
			}

			return [
				"from" 		=> $from, 
				"to" 		=> $to,
				"school"	=> $school, 
				"course"	=> $course
			];
		}
	@endphp

	@php
		$temp = $eb('Elementary');
	@endphp

	<tr>
		<td colspan="3" style="{{ $b }}">Primary</td>
		<td colspan="2" rowspan="2" style="{{ $bc }}">{{ $temp['from'] }}</td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['to'] }}</td>
		<td colspan="4" rowspan="2" style="{{ $bc }}">{{ $temp['school'] }}</td>
		<td colspan="3" rowspan="2" style="{{ $bc }}"></td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['course'] }}</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $i }}">Sekolah Rendah</td>
	</tr>

	@php
		$temp = $eb('High School');
	@endphp

	<tr>
		<td colspan="3" style="{{ $b }}">Lower Secondary</td>
		<td colspan="2" rowspan="2" style="{{ $bc }}">{{ $temp['from'] }}</td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['to'] }}</td>
		<td colspan="4" rowspan="2" style="{{ $bc }}">{{ $temp['school'] }}</td>
		<td colspan="3" rowspan="2" style="{{ $bc }}"></td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['course'] }}</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $i }}">Tingkatan 3</td>
	</tr>

	@php
		$temp = $eb('Senior High School');
	@endphp

	<tr>
		<td colspan="3" style="{{ $b }}">Higher Secondary</td>
		<td colspan="2" rowspan="2" style="{{ $bc }}">{{ $temp['from'] }}</td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['to'] }}</td>
		<td colspan="4" rowspan="2" style="{{ $bc }}">{{ $temp['school'] }}</td>
		<td colspan="3" rowspan="2" style="{{ $bc }}"></td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['course'] }}</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $i }}">Tingkatan 5</td>
	</tr>

	@php
		$temp = $eb('Senior High School');
	@endphp

	<tr>
		<td colspan="3" style="{{ $b }}">Pre-University</td>
		<td colspan="2" rowspan="2" style="{{ $bc }}">{{ $temp['from'] }}</td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['to'] }}</td>
		<td colspan="4" rowspan="2" style="{{ $bc }}">{{ $temp['school'] }}</td>
		<td colspan="3" rowspan="2" style="{{ $bc }}"></td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['course'] }}</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $i }}">Tingkatan 6</td>
	</tr>

	@php
		$temp = $eb('Certificate');
	@endphp

	<tr>
		<td colspan="3" style="{{ $b }}">Certificate</td>
		<td colspan="2" rowspan="2" style="{{ $bc }}">{{ $temp['from'] }}</td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['to'] }}</td>
		<td colspan="4" rowspan="2" style="{{ $bc }}">{{ $temp['school'] }}</td>
		<td colspan="3" rowspan="2" style="{{ $bc }}"></td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['course'] }}</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $i }}">Sijil</td>
	</tr>

	@php
		$temp = $eb('Vocational');
	@endphp

	<tr>
		<td colspan="3" style="{{ $b }}">Diploma</td>
		<td colspan="2" rowspan="2" style="{{ $bc }}">{{ $temp['from'] }}</td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['to'] }}</td>
		<td colspan="4" rowspan="2" style="{{ $bc }}">{{ $temp['school'] }}</td>
		<td colspan="3" rowspan="2" style="{{ $bc }}"></td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['course'] }}</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $i }}">Diploma</td>
	</tr>

	@php
		$temp = $eb('College');
	@endphp

	<tr>
		<td colspan="3" style="{{ $b }}">Bachelor Degree</td>
		<td colspan="2" rowspan="2" style="{{ $bc }}">{{ $temp['from'] }}</td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['to'] }}</td>
		<td colspan="4" rowspan="2" style="{{ $bc }}">{{ $temp['school'] }}</td>
		<td colspan="3" rowspan="2" style="{{ $bc }}"></td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['course'] }}</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $i }}">Sarjana Muda</td>
	</tr>

	@php
		$temp = $eb('Masteral');
	@endphp

	<tr>
		<td colspan="3" style="{{ $b }}">Master Degree</td>
		<td colspan="2" rowspan="2" style="{{ $bc }}">{{ $temp['from'] }}</td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['to'] }}</td>
		<td colspan="4" rowspan="2" style="{{ $bc }}">{{ $temp['school'] }}</td>
		<td colspan="3" rowspan="2" style="{{ $bc }}"></td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['course'] }}</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $i }}">Sarjana</td>
	</tr>

	@php
		$temp = $eb('Doctoral');
	@endphp

	<tr>
		<td colspan="3" style="{{ $b }}">PHd.</td>
		<td colspan="2" rowspan="2" style="{{ $bc }}">{{ $temp['from'] }}</td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['to'] }}</td>
		<td colspan="4" rowspan="2" style="{{ $bc }}">{{ $temp['school'] }}</td>
		<td colspan="3" rowspan="2" style="{{ $bc }}"></td>
		<td rowspan="2" style="{{ $bc }}">{{ $temp['course'] }}</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $i }}">Doktor Falsafah</td>
	</tr>

	{{-- SECTION D --}}

	<tr>
		<td rowspan="2" style="{{ $bc }}">D</td>
		<td colspan="4" style="{{ $b }}">PROFESSIONAL QUALIFICATION</td>
		<td colspan="9" style="{{ $i }}">(Eg. CPA License, Certified Trainer, Registered Safety Officer &#38; Etc)</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $b }} {{ $i }}">KELAYAKAN PROFESYENAL</td>
		<td colspan="9" style="{{ $i }}">(Cth. Lesen CPA, Pelatih Berdaftar, Pengawai HSE Berdaftar &#38; Etc)</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }}">Year Attained</td>
		<td colspan="4" style="{{ $bc }}">Institute</td>
		<td colspan="5" style="{{ $bc }}">Certification</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $c }} {{ $i }}">Tahun Diperolehi</td>
		<td colspan="4" style="{{ $c }} {{ $i }}">Institut</td>
		<td colspan="5" style="{{ $c }} {{ $i }}">Sijil</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }} {{ $i }}">N/A</td>
		<td colspan="4" style="{{ $bc }} {{ $i }}"></td>
		<td colspan="5" style="{{ $bc }} {{ $i }}"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }} {{ $i }}"></td>
		<td colspan="4" style="{{ $bc }} {{ $i }}"></td>
		<td colspan="5" style="{{ $bc }} {{ $i }}"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }} {{ $i }}"></td>
		<td colspan="4" style="{{ $bc }} {{ $i }}"></td>
		<td colspan="5" style="{{ $bc }} {{ $i }}"></td>
	</tr>

	{{-- SECTION E --}}

	<tr>
		<td rowspan="2" style="{{ $bc }}">E</td>
		<td colspan="8" style="{{ $b }}">EMPLOYMENT HISTORY BEFORE JOINING PRESENT EMPLOYER</td>
		<td colspan="5" style="{{ $i }}">(List Down In Chronological Order)</td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $b }} {{ $i }}">REKOD PENGAJIAN SEBELUM MENYERTAI MAJIKAN SEKARANG</td>
		<td colspan="5" style="{{ $i }}">(Senaraikan Mengikut Turutan Kronologi)</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $bc }}">From Year</td>
		<td style="{{ $bc }}">To Year</td>
		<td colspan="3" style="{{ $bc }}">Name of Previous</td>
		<td colspan="3" style="{{ $bc }}">Position Hold</td>
		<td colspan="3" style="{{ $b }} text-align: right;">Salary</td>
		<td style="{{ $i }}">/Gaji</td>
		<td style="{{ $bc }}">Reason for</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $c }} {{ $i }}">Dari Tahun</td>
		<td style="{{ $c }} {{ $i }}">Ke Tahun</td>
		<td colspan="3" style="{{ $bc }}">Employer(s)</td>
		<td colspan="3" style="{{ $c }} {{ $i }}">Jawatan</td>
		<td colspan="3" style="{{ $bc }}">Basic</td>
		<td style="{{ $bc }}">Allow</td>
		<td style="{{ $bc }}">Leaving</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $c }} {{ $i }}"></td>
		<td style="{{ $c }} {{ $i }}"></td>
		<td colspan="3" style="{{ $c }} {{ $i }}">Nama Majikan Dahulu</td>
		<td colspan="3" style="{{ $c }} {{ $i }}">Dipegang</td>
		<td colspan="3" style="{{ $c }} {{ $i }}">Pokok</td>
		<td style="{{ $c }} {{ $i }}">Elaun</td>
		<td style="{{ $c }} {{ $i }}">Sebab Berhenti</td>
	</tr>

	@foreach($data->sea_service as $ss)
		@php
			$vessel = $cleanText($ss->vessel_name);
			$manning = $cleanText($ss->manning_agent);
			$type = $cleanText($ss->vessel_type);
			$rfl = $cleanText($ss->remarks);

			$temp = $vessel != "" ? $vessel . ' / ' . $manning . ' / ' . $type : "";
		@endphp

		<tr>
			<td colspan="2" style="{{ $bc }}">{{ $ss->sign_on != "" ? $ss->sign_on->format('d-M-y') : ""  }}</td>
			<td style="{{ $bc }}">{{ $ss->sign_on != "" ? $ss->sign_on->format('d-M-y') : ""  }}</td>
			<td colspan="3" style="{{ $bc }}">
				{{ $temp }}
			</td>
			<td colspan="3" style="{{ $bc }}">{{ $ss->rank }}</td>
			<td colspan="3" style="{{ $bc }}"></td>
			<td style="{{ $bc }}"></td>
			<td style="{{ $bc }}">{{ $ss->remarks }}</td>
		</tr>
	@endforeach

	{{-- SECTION F --}}
	<tr>
		<td rowspan="2" style="{{ $bc }}">F</td>
		<td colspan="13" style="{{ $b }}">DETAILS OF PRESENT / PREVIOUS EMPLOYER</td>
	</tr>

	<tr>
		<td colspan="13" style="{{ $i }}">BUTIR-BUTIR LANJUT TENTANG MAJIKAN SEKARANG / SEBELUM</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $b }}">Company:</td>
		<td colspan="5" style="{{ $bc }}">SOLPIA MARINE &#38; SHIP MANAGEMENT</td>
		<td colspan="3" style="{{ $b }}">Core Business:</td>
		<td colspan="4" style="{{ $bc }}">MANNING AGENCY</td>
	</tr>

	<tr>
		<td colspan="7" style="{{ $i }}">Syarikat</td>
		<td colspan="7" style="{{ $i }}">Perniagaan Utama</td>
	</tr>

	@php
		$mob = $data->pro_app->mob;
		$eld = $data->pro_app->eld;

		$dept = "GALLEY";
		if(str_contains($data->rank->category, "DECK")){
			$dept = "DECK";
		}
		elseif(str_contains($data->rank->category, "ENGINE")){
			$dept = "ENGINE";
		}

		$pp = null;

		if(sizeof($data->sea_service)){
			$pp = $data->sea_service->first()->rank;
		}
	@endphp

	<tr>
		<td colspan="4" style="{{ $b }}">From (Month/Year) To (Month/Year):</td>
		<td colspan="3" style="{{ $bc }}">
			{{ isset($eld) && isset($mob) ? $eld->format("M/Y") . ' - ' . $eld->addMonth($mob)->format("M/Y") : now()->year }}
		</td>
		<td colspan="3" style="{{ $b }}">Department:</td>
		<td colspan="4" style="{{ $bc }}">{{ $dept }} DEPARTMENT</td>
	</tr>

	<tr>
		<td colspan="7" style="{{ $i }}">Dari (Bulan/Tahun) Ke (Bulan/Tahun)</td>
		<td colspan="7" style="{{ $i }}">Jabatan</td>
	</tr>

	<tr>
		<td colspan="7" style="{{ $b }}">Position Offered: {{ $data->rank->name }}</td>
		<td colspan="7" style="{{ $b }}">Present Position: {{ $pp }}</td>
	</tr>

	<tr>
		<td colspan="7" style="{{ $i }}">Jawatan ditawarkan</td>
		<td colspan="7" style="{{ $i }}">Jawatan Sekarang</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $b }}">Reporting To:</td>
		<td colspan="5" style="{{ $bc }}">MS. THEA MAE D. GUERRA</td>
		<td colspan="3" style="{{ $b }}">No. of Subordinates:</td>
		<td colspan="4" style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td colspan="7" style="{{ $i }}">Melapor Kepada</td>
		<td colspan="7" style="{{ $i }}">Bil. Staf Bawahan</td>
	</tr>

	<tr>
		<td colspan="14" style="{{ $b }}">
			Brief description of duties &#38; responsibilities:Assist the Chief Engineer in analyzing needs and plan preventive maintenance programs and upgrades for systems, and successfully implement and administer the ship's planned maintenance system.
		</td>
	</tr>

	<tr>
		<td colspan="14" style="{{ $i }}">Senaraikan Tugas &#38; Tanggungjawab sekarang</td>
	</tr>

	{{-- SECTION G --}}
	<tr>
		<td rowspan="2" style="{{ $bc }}">G</td>
		<td colspan="7" style="{{ $b }}">PROGRAM/TRAINING / COMPETENCY COURSE ATTENDED</td>
		<td colspan="5" style="{{ $i }}">(Shorthand, Typewriting, Book Keeping, Computer Course, &#38; etc)</td>
	</tr>

	<tr>
		<td colspan="7" style="{{ $b }}">PROGROM/LATIHAN / KURSUS KECEKAPAN YANG PERNAH DIIKUTI</td>
		<td colspan="5" style="{{ $i }}">(Trengkas, Typewriting, Computer course, Simpan Kira-kira &#38; etc)</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }}">Course Attended</td>
		<td colspan="4" style="{{ $bc }}">Institute</td>
		<td colspan="3" style="{{ $bc }}">Year Attended</td>
		<td colspan="2" style="{{ $bc }}">License/Certificate Attained</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $c }} {{ $i }}">Kursus yang Dihadiri</td>
		<td colspan="4" style="{{ $c }} {{ $i }}">Institut</td>
		<td colspan="3" style="{{ $c }} {{ $i }}">Tahun Hadir</td>
		<td colspan="2" style="{{ $c }} {{ $i }}">Lesen / Sijil Diperolehi</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $c }}">N/A</td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="3" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="3" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $c }}"></td>
		<td colspan="4" style="{{ $c }}"></td>
		<td colspan="3" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	{{-- SECTION H --}}
	<tr>
		<td rowspan="2" style="{{ $bc }}">H</td>
		<td colspan="12" style="{{ $b }}">INSTITUTIONAL / COMMUNAL / ASSOCIATION / CLUB MEMBERSHIP</td>
	</tr>

	<tr>
		<td colspan="12" style="{{ $i }}">KAHLIAN INSTITUSI / KEMASYARAKATAN / PERSATUAN / KELAB</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $bc }}">From</td>
		<td colspan="2" style="{{ $bc }}">To</td>
		<td colspan="7" style="{{ $bc }}">Organization's Name</td>
		<td colspan="3" style="{{ $bc }}">Official Hold</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $b }} {{ $i }}">Dari</td>
		<td colspan="2" style="{{ $b }} {{ $i }}">Hingga</td>
		<td colspan="7" style="{{ $b }} {{ $i }}">Nama Organisasi</td>
		<td colspan="3" style="{{ $b }} {{ $i }}">Jawatan Dipegang</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $c }}">N/A</td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="7" style="{{ $c }}"></td>
		<td colspan="3" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="7" style="{{ $c }}"></td>
		<td colspan="3" style="{{ $c }}"></td>
	</tr>

	{{-- SECTION I --}}
	<tr>
		<td rowspan="2" style="{{ $bc }}">H</td>
		<td colspan="12" style="{{ $b }}">HOBBIES / SPORT / INTEREST</td>
	</tr>

	<tr>
		<td colspan="12" style="{{ $i }}">KEGEMARAN / SUKAN / MINAT</td>
	</tr>

	<tr>
		<td colspan="14" style="{{ $bc }}"></td>
	</tr>

	{{-- SECTION J --}}
	<tr>
		<td rowspan="2" style="{{ $bc }}">J</td>
		<td colspan="3" style="{{ $b }}">LANGUAGE PROFICIENCY</td>
		<td colspan="9" style="{{ $i }}">(Please specify: Excellent / Fair / Poor)</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $b }}">PENGUASAAN BAHASA</td>
		<td colspan="9" style="{{ $i }}">(Sila nyatakan seperti berikut: Mahir / Baik / Lemah)</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $bc }}">Language / Dialects</td>
		<td colspan="3" style="{{ $bc }}">Written</td>
		<td colspan="3" style="{{ $bc }}">Reading</td>
		<td colspan="2" style="{{ $bc }}">Speaking</td>
		<td style="{{ $bc }}">Understanding</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $c }} {{ $i }}">Bahasa / Dialeks</td>
		<td colspan="3" style="{{ $c }} {{ $i }}">Penulisan</td>
		<td colspan="3" style="{{ $c }} {{ $i }}">Bacaan</td>
		<td colspan="2" style="{{ $c }} {{ $i }}">Lisan</td>
		<td style="{{ $c }} {{ $i }}">Kefahaman</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $b }}">English (Inggeris)</td>
		<td colspan="3" style="{{ $bc }}">GOOD</td>
		<td colspan="3" style="{{ $bc }}">GOOD</td>
		<td colspan="2" style="{{ $bc }}">GOOD</td>
		<td style="{{ $bc }}">GOOD</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $b }}">Bahasa Malaysia (Bahasa Melayu)</td>
		<td colspan="3" style="{{ $bc }}"></td>
		<td colspan="3" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
		<td style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $b }}">Chinese (Cina)</td>
		<td colspan="3" style="{{ $bc }}"></td>
		<td colspan="3" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
		<td style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $b }}">
			Other Languages / Dialects. Please specify:-(Lain-lain Bahasa / Dialek. Sila nyatakan: 
			<br style='mso-data-placement:same-cell;' />
			1.)
			<br style='mso-data-placement:same-cell;' />
			2.)
		</td>
		<td colspan="3" style="{{ $bc }}"></td>
		<td colspan="3" style="{{ $bc }}"></td>
		<td colspan="2" style="{{ $bc }}"></td>
		<td style="{{ $bc }}"></td>
	</tr>
</table>