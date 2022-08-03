@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	$und = "text-decoration: underline;";
	$bc = "$bold $center";
	$blue = "color: #0000FF;";
@endphp

<table>
	<tr>
		<td colspan="14" style="{{ $bc }}">
			선원 근로 계약서
		</td>
	</tr>

	<tr>
		<td colspan="14" style="{{ $bc }} {{ $und }}">
			Contract of Employment for Seafarer
		</td>
	</tr>

	<tr><td colspan="14"></td></tr>

	<tr>
		<td colspan="14">
			아래의 당사자는 다음과 같이 선원근로계약을 체결하고 이를 성실히 이행할 것을 약정한다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			The following parties to the contract agree to fully comply with the terms stated hereinafter.
		</td>
	</tr>

	{{-- 1ST ROW --}}
	<tr>
		<td colspan="2" rowspan="2" style="{{ $center }}">
			선박소유자
			<br style='mso-data-placement:same-cell;' />
			Ship Owner
		</td>
		<td colspan="2" style="{{ $center }}">
			회사명
			<br style='mso-data-placement:same-cell;' />
			Company Name
		</td>
		<td colspan="10" style="{{ $center }}">
			CK MARITIME KOREA CO., LTD.
		</td>
	</tr>
	{{-- END 1ST ROW --}}

	{{-- 2ND ROW --}}
	<tr>
		<td colspan="2" style="{{ $center }}">
			주소
			<br style='mso-data-placement:same-cell;' />
			Address
		</td>
		<td colspan="10" style="{{ $center }}">
			17thFL., KwanJeong Bldg, 46, 9beon-gil, ChungJang-Daero, Jung-gu, Busan, Korea.
		</td>
	</tr>
	{{-- END 2ND ROW --}}

	{{-- 3RD ROW --}}
	<tr>
		<td colspan="2" rowspan="2" style="{{ $center }}">
			선박
			<br style='mso-data-placement:same-cell;' />
			Ship
		</td>
		<td colspan="2" style="{{ $center }}">
			선 명
			<br style='mso-data-placement:same-cell;' />
			(Name)
		</td>
		<td colspan="4" style="{{ $center }}">
			{{ $data->vessel->name }}
		</td>
		<td colspan="2" style="{{ $center }}">
			선 종
			<br style='mso-data-placement:same-cell;' />
			(Kind)
		</td>
		<td colspan="4" style="{{ $center }}">
			{{ $data->vessel->type }}
		</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $center }}">
			건조 년도
			<br style='mso-data-placement:same-cell;' />
			(Built Year)
		</td>
		<td colspan="4" style="{{ $center }}">
			{{ $data->vessel->year_build }}
		</td>
		<td colspan="2" style="{{ $center }}">
			총톤수
			<br style='mso-data-placement:same-cell;' />
			(GRT)
		</td>
		<td colspan="4" style="{{ $center }}">
			{{ $data->vessel->gross_tonnage }}
		</td>
	</tr>
	{{-- END 3RD ROW --}}

	{{-- 4TH ROW --}}
	<tr>
		<td colspan="2" rowspan="3" style="{{ $center }}">
			선 원
			<br style='mso-data-placement:same-cell;' />
			(Seafarer)
		</td>
		<td colspan="2" style="{{ $center }}">
			선 명
			<br style='mso-data-placement:same-cell;' />
			(Name)
		</td>
		<td colspan="4" style="{{ $center }}">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td colspan="2" style="{{ $center }}">
			생년월일
			<br style='mso-data-placement:same-cell;' />
			(Birthdate)
		</td>
		<td colspan="4" style="{{ $blue }} {{ $center }}">
			{{ $data->user->birthday }}
		</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $center }}">
			성 별
			<br style='mso-data-placement:same-cell;' />
			(Sex)
		</td>
		<td colspan="4" style="{{ $center }}">
			{{ $data->user->gender }}
		</td>
		<td colspan="2" style="{{ $center }}">
			국적
			<br style='mso-data-placement:same-cell;' />
			(Nationality)
		</td>
		<td colspan="4" style="{{ $center }}">
			FILIPINO
		</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $center }}">
			주 소
			<br style='mso-data-placement:same-cell;' />
			(Address)
		</td>
		<td colspan="6" style="{{ $blue }} {{ $center }}">
			{{ $data->user->address }}
		</td>
		<td colspan="2" style="{{ $center }}">
			출생지
			<br style='mso-data-placement:same-cell;' />
			(Birthplace)
		</td>
		<td colspan="2" style="{{ $blue }} {{ $center }}">
			{{ $data->birth_place }}
		</td>
	</tr>
	{{-- END 4TH ROW --}}

	<tr><td colspan="14"></td></tr>

	<tr>
		<td colspan="14" style="{{ $bold }}">
			1. 선원근로계약 체결장소 및 일자
		</td>
	</tr>

	<tr>
		<td colspan="14" style="{{ $bold }}">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(The place where and date when seafarer’s employment agreement is entered into)
		</td>
	</tr>

	<tr>
		<td colspan="3">
			1.1 체결장소(Place)   :
		</td>
		<td colspan="11" style="{{ $blue }}">
			{{ $data->pro_app->status == "On Board" ? "ONBOARD" : "MANILA" }}
		</td>
	</tr>

	<tr>
		<td colspan="3">
			2.1 체결일자(Date)    :
		</td>
		<td colspan="11" style="{{ $blue }}">
			{{ $data->date_processed }}
		</td>
	</tr>

	<tr>
		<td colspan="14">
		 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎*동 계약은 승선을 위한 출국일 혹은 승선일로부터 효력이 발생한다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
		 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎*This contract will be effective from embarkation date or date of departure for embarkation.
		</td>
	</tr>

	<tr><td colspan="14"></td></tr>

	<tr>
		<td colspan="3" style="{{ $bold }}">
			2. 선원이 고용될 직무:
		</td>
		<td></td>
		<td colspan="10" style="{{ $blue }}">
			{{ $data->position }}
		</td>
	</tr>

	<tr>
		<td colspan="14" style="{{ $bold }}">
		 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎(The duty in which the seafarer is to be employed)
		</td>
	</tr>

	<tr><td colspan="14"></td></tr>

	<tr>
		<td colspan="14" style="{{ $bold }}">
			3. 선원근로계약기간 (Period of employment)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			3.1 계약직 (Short-term contract)
		</td>
	</tr>

	<tr>
		<td colspan="3">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎*Duration of Contract
		</td>
		<td colspan="2" style="{{ $blue }} {{ $bold }}">
			{{ $data->effective_date }}
		</td>
		<td colspan="2"></td>
		<td colspan="2" style="{{ $blue }} {{ $bold }}">
			{{ now()->parse($data->effective_date)->add($data->employment_months, 'months') }}
		</td>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td colspan="14">
			3.2 선박소유자는 선원과의 선원근로계약을 해지하는 경우에는 30일 이상, 선원이 선박소유자와 근로계약을
		</td>
	</tr>

	<tr>
		<td colspan="14">
		 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎해지하는 경우에는 30일의 범위에서 예고기간을 서면으로 통보해야 한다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
		 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(When shipowner terminates the contract early, the required minimum notice period shall be over 30 days and when
		</td>
	</tr>

	<tr>
		<td colspan="14">
		 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎seafarer terminates the contract early, need to notice within 30 days in advance.)
		</td>
	</tr>

	<tr><td colspan="14"></td></tr>

	<tr>
		<td colspan="14" style="{{ $bold }}">
			4. 임금 (Payment)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			4.1 기본임금 및 수당(Basic wage and allowance)
		</td>
	</tr>

	<tr><td colspan="14"></td></tr>

	<tr>
		<td></td>
		<td colspan="7">1.) 기본급 (B.W) : Basic Wage / Ordinary</td>
		<td colspan="3" style="{{ $blue }} text-align: right;">
			
		</td>
	</tr>

</table>