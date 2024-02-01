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
</table>