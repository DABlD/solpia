@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	$und = "text-decoration: underline;";
	$bc = "$bold $center";
	$blue = "color: #0000FF;";
@endphp

<table>
	<tr>
		<td colspan="14" style="{{ $bc }} height: 20px;">
			선원 근로 계약서
		</td>
	</tr>

	<tr>
		<td colspan="14" style="{{ $bc }} {{ $und }} height: 25px;">
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
			{{ $data->user->birthday->format('m/d/Y') }}
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
			{{ now()->parse($data->date_processed)->format('d/m/Y') }}
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
			{{ now()->parse($data->effective_date)->format('Y/m/d') }}
		</td>
		<td colspan="2" style="{{ $bold }}">TO</td>
		<td colspan="2" style="{{ $blue }} {{ $bold }}">
			{{ now()->parse($data->effective_date)->add($data->employment_months, 'months')->format('Y/m/d') }}
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

	{{-- SALARY 1 --}}
	{{-- SALARY 1 --}}
	{{-- SALARY 1 --}}
	<tr>
		<td></td>
		<td colspan="7">1.) 기본급 (B.W) : Basic Wage / Ordinary</td>
		<td colspan="3" style="{{ $blue }} text-align: right;">
			{{ $data->wage->basic ? ($data->wage->basic) : 0 }} ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
		</td>
		<td colspan="2" style="{{ $bc }}">USD / Months</td>
		<td></td>
	</tr>


	{{-- SALARY 2 --}}
	{{-- SALARY 2 --}}
	{{-- SALARY 2 --}}
	<tr>
		<td></td>
		<td colspan="7">
			@php
				$temp = "Guaranteed";
				if($data->rankType == "OFFICER"){
					$temp = "Fixed";
				}
			@endphp
			2.) 고정급 시간외 수당 (F.O.T.) : {{ $temp }} Overtime Allowances
		</td>
		<td colspan="3" style="{{ $blue }} text-align: right;">
			{{ $data->wage->fot ?? $data->wage->ot }} ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
		</td>
		<td colspan="2" style="{{ $bc }}">USD / Months</td>
		<td></td>
	</tr>

	{{-- SALARY 3 --}}
	{{-- SALARY 3 --}}
	{{-- SALARY 3 --}}
	<tr>
		<td></td>
		<td colspan="7">3.) SVP (Supervisor Allowance) :</td>
		<td colspan="3" style="{{ $blue }} text-align: right;">
			{{ $data->wage->sup_allow ? ($data->wage->sup_allow) : 0 }} ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
		</td>
		<td colspan="2" style="{{ $bc }}">USD / Months</td>
		<td></td>
	</tr>

	{{-- SALARY 4 --}}
	{{-- SALARY 4 --}}
	{{-- SALARY 4 --}}
	<tr>
		<td></td>
		<td colspan="7">4.) SUB.A (Subsistence Allowance) :</td>
		<td colspan="3" style="{{ $blue }} text-align: right;">
			{{ $data->wage->sub_allow ? ($data->wage->sub_allow) : 0 }} ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
		</td>
		<td colspan="2" style="{{ $bc }}">USD / Months</td>
		<td></td>
	</tr>

	{{-- SALARY 5 --}}
	{{-- SALARY 5 --}}
	{{-- SALARY 5 --}}
	<tr>
		<td></td>
		<td colspan="7">5.)  O.W (Owner's Allowance) :</td>
		<td colspan="3" style="{{ $blue }} text-align: right;">
			{{ $data->wage->owner_allow ? ($data->wage->owner_allow) : 0 }} ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
		</td>
		<td colspan="2" style="{{ $bc }}">USD / Months</td>
		<td></td>
	</tr>

	{{-- SALARY 6 --}}
	{{-- SALARY 6 --}}
	{{-- SALARY 6 --}}
	<tr>
		<td></td>
		<td colspan="7">6.)  R.A. (Retirement Allowance) :</td>
		<td colspan="3" style="{{ $blue }} text-align: right;">
			{{ $data->wage->retire_allow ? ($data->wage->retire_allow) : 0 }} ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
		</td>
		<td colspan="2" style="{{ $bc }}">USD / Months</td>
		<td></td>
	</tr>

	{{-- SALARY 7 --}}
	{{-- SALARY 7 --}}
	{{-- SALARY 7 --}}
	<tr>
		<td></td>
		<td colspan="7">7.) 월 임금 (M.W) : Monthly Wage</td>
		<td colspan="3" style="{{ $blue }} text-align: right;">
			@php
				$total = ($data->wage->basic ?? 0) + ($data->wage->fot ?? 0) + ($data->wage->ot ?? 0) + ($data->wage->sup_allow ?? 0) + ($data->wage->sub_allow ?? 0) + ($data->wage->owner_allow ?? 0) + ($data->wage->retire_allow ?? 0);
			@endphp
			{{ $total }} ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
		</td>
		<td colspan="2" style="{{ $bc }}">USD / Months</td>
		<td></td>
	</tr>

	{{-- SALARY 8 --}}
	{{-- SALARY 8 --}}
	{{-- SALARY 8 --}}
	<tr>
		<td></td>
		<td colspan="7">8.) 유급 휴가비 : Leave pay (7 day/month)</td>
		<td colspan="3" style="{{ $blue }} text-align: right;">
			{{ $data->wage->leave_pay ? ($data->wage->leave_pay) : 0 }} ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
		</td>
		<td colspan="2" style="{{ $bc }}">USD / Months</td>
		<td></td>
	</tr>

	<tr><td colspan="14"></td></tr>

	<tr>
		<td colspan="14">
			4.2 유급 휴가, 퇴직금, 복리후생비, 호봉수당 및 기타 수당 상세는 단체협약 또는 취업규칙에 따른다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(The details of Paid Leave, Retirement Allowance, Welfare Allowance, Pay step incentive and Other Allowances are
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎applied according to the Collective Bargaining Agreement and/or Rules of Employment.)
		</td>
	</tr>
	
	<tr><td colspan="14"></td></tr>

	<tr>
		<td colspan="6"></td>
		<td colspan="2" style="{{ $center }}">페이지 1</td>
		<td colspan="4"></td>
		<td colspan="2" style="{{ $center }}">CK LINE Co., Ltd</td>
	</tr>

	<tr><td colspan="14"></td></tr>

	<tr>
		<td colspan="14">
			4.3 임금지급일(Payment date)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎임금은 매월 05일에 정기적으로 지급한다. 다만 지급일이 휴일일 경우에는 그 전일에 지급하는 것으로한다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(Payment date is 5th of every month. If the payment date falls on a holiday, payment will be made on the day before
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎the holiday.)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			4.4 임금지급방법(Payment methods)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎임금은 선원에게 직접 지급하거나 또는 선원의 명의로 된 예금통장에 입금한다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎다만, 선원이 희망하는 경우, 선원이 지목한 자에게 일정액을 지급한다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(Payment will be paid to seafarer or credited to the bank account of seafarer. Some allotments should be remitted
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎directly to persons nominated by the seafarers.)
		</td>
	</tr>

	<tr><td colspan="14"></td></tr>

	<tr>
		<td colspan="14" style="{{ $bold }}">
			5. 유급휴가비 (Paid Leave)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			5.1 4.1의 규정에 의한 유급휴가일수는 계속하여 승무한 기간 1월에 대하여 7일로 한다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(The number of days of paid leave pursuant to 4.1 shall be 7 days per 1 month of continuous service on board)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			5.2 유급휴가비의 산정방법은 다음과 같다. (The method which is calculating of paid leave as follows)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎- 유급휴가비 = (통상임금 / 30) X 7 days
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎- Paid leave = (Monthly Ordinary Wage / 30) X 7 days
		</td>
	</tr>

	<tr>
		<td colspan="14">
			5.3 유급 휴가비는 하선 후 지급한다. (After disembarkation, leave pay will be paid.)
		</td>
	</tr>

	<tr><td colspan="14"></td></tr>

	<tr>
		<td colspan="14" style="{{ $bold }}">
			6. 주부식비 (Daily Provision Fee)  : ₩12,000/Day
		</td>
	</tr>

	<tr><td colspan="14"></td></tr>

	<tr>
		<td colspan="14" style="{{ $bold }}">
			7. 근로시간 및 휴식시간 기준 (Standard of Hours of Work and Hours of Rest)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			7.1 근로시간(Working Hours)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎1) 통상 근로(Hours of Ordinary Work) : 1일 8시간, 주 40시간 (8 Hours in a day and 40 Hours in a week)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎2) 시간외 근로(Over Time Work) : 고정급 시간외 근로 (Fixed Over Time)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			7.2 휴식 시간 (Hours of rest)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎1) 임의의 24시간중 최소 10시간 이상, 임의의 7일중 77시간 이상의 휴식시간을 제공한다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(Minimum of 10 hours rest in a 24 hour period and 77 hours in any seven-day period)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎2) 휴식시간은 2회를 초과하지 않도록 분할할 수 있으며 그 중 한번은 최소 6시간이어야 하며 연속적인
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎휴식시간의 사이의 간격은 14시간을 초과하여서는 아니 된다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(Horus of rest may be divided into no more than two periods, one of which shall be at least six hours in length,
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎and the interval between consecutive periods of rest shall not exceed 14 hours.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎3) 연속적인 휴식시간 사이의 간격은 14시간을 초과하여서는 아니된다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(The interval between consecutive periods of rest shall not exceed 14 hours)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎4) 훈련은 휴식시간에 대한 방해를 최소화하고 피로를 유발하지 아니하는 방식으로 시행한다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(Musters and drills and drills shall be conducted in a manner that minimizes the disturbance of rest periods and
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎does not induce fatigue)
		</td>
	</tr>

	<tr><td colspan="14"></td></tr>

	<tr>
		<td colspan="14" style="{{ $bold }}">
			8. 건강 및 사회보장보호 급여 (Health and social security protection benefits)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			8.1 선박소유자는 선원법 / 단체협약 / 취업규칙에 따라 의료관리, 질병급여, 실업급여, 업무상 부상급여,
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎장애 급여, 가족급여 및 유족급여를 선원에게 제공한다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(Shipowner provides medical care, sickness benefit, unemployment benefit, employment injury benefit, invalidity
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎benefit, family benefit and survivors' benefit to the seafarer in accordance with Korean seafarers act or the Collective
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎Bargaining Agreement or Rules of employment.)
		</td>
	</tr>

	<tr><td colspan="14"></td></tr>

	<tr>
		<td colspan="14" style="{{ $bold }}">
			9. 선원의 송환 수급권 (Seafarer's entitlement to repatriation)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			9.1 선박소유자는 선원이 거주지 또는 선원근로계약의 체결지가 아닌 항구에서 하선하는 경우에는 선박
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎소유자의 비용으로 선원의 거주지 또는 선원근로계약의 체결지 중 선원이 원하는 곳까지 지체없이
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎송환해야 한다. 다만, 선원의 요청에 의하여 송환에 필요한 비용을 선원에게 지급할 경우에는 그러하지
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎아니하다.
		</td>
	</tr>

	<tr><td colspan="14"></td></tr>
	<tr><td colspan="14"></td></tr>
	<tr><td colspan="14"></td></tr>

	<tr>
		<td colspan="6"></td>
		<td colspan="2" style="{{ $center }}">페이지 2</td>
		<td colspan="4"></td>
		<td colspan="2" style="{{ $center }}">CK LINE Co., Ltd</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(Shipowner shall promptly repatriate the seafarer who leaves a ship at the place of which is not the seafarer's country
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎of residence or the place at which the seafarer agreed to enter into the engagement as shipowner's expenses.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎however, in case where shipowner paid the expense of repatriation according shipowner to the request of seafarer,
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎does not have any responsibility for the repatriation)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			9.2 선박소유자는 제9.1항에도 불구하고 다음 각 호의 어느 하나에 해당하는 경우에는 송환에 든 비용을
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎선원에게 청구할 수 있다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(Despite above 9.1, in case of the following particulars, shipowner can recover the cost of repatriation from seafarer)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎1) 선원이 정당한 사유 없이 임의로 하선한 경우
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(When the seafarer leaves a ship without just reason)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎2) 선원이 국내법에서 정한 하선 징계를 받고 하선한 경우
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(When the seafarer leaves a ship according to disciplinary punishment which regulated in national laws)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎3) 기타 단체협약, 취업규칙 또는 기국법에서 정하는 사유에 해당하는 경우
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(When the reason is conformed to the collective bargaining agreement or rules of employment or the law of flag state)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			9.3 선박소유자는 해적 및 무장강도의 결과로 선원이 선박 또는 선박 밖에서 납치된 경우, 선원 근로 계약이 
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎경과하였거나, 계약의 중지 또는 해지를 통보한 경우에 관계없이 선원근로계약이 유지되도록 하여야 한다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(Seafarer's employment agrement shall continue to have effect while a seafarer is held captive on or off the ship as a result
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎of acts of piracy, or armed robbery against ships, regardless of whether the date fixed for its expiry has passed or either
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎party has given notice to suspend or terminate it.)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			9.4 선원이 해적 및 무장강도의 결과로 선박 또는 선박 밖에서 납치된 경우 MLC STANDARD A 2.2.4항에
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎규정된 바에 따라 어떠한 범위의 일정액을 송금하는 것을 포함하여 선원 근로계약, 관련 단체협약 또는
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎기국의 적용가능한 국내법령에 따른 선원의 임금과 권리는 선원이 인질로 잡혀있는 모든 기간과 선원이
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎풀려나고 선원이 송환될 때까지 또는 인질로 잡혀있는 동안 사망할 때 까지 유지되어야 한다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(Where a seafarer is held captive on or off the ship as a result of acts of piracy or armed robbery against ships, wages and
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎other entitlements under the seafarers’ employment agreement, relevant collective bargaining agreement or applicable 
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎national laws, including the remittance of any allotments as provided in MLC STANDARD A 2.2.4, shall continue to
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎be paid during the entire period of captivity and until the seafarer is released and duly repatriated in accordance or,
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎where the seafarer dies while in captivity, until the date of death as determined in accordance with applicable national
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎laws or regulations.)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			9.5 선원이 국내법령 또는 단체협약에 규정된 적정 기간 내에 송환권을 청구하지 아니하면 송환에 대한
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎권리가 소멸할 수 있다. 다만, 선원이 해적 및 무장강도에 의해서 납치된 경우에는 제외된다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(The entitlement to repatriation may lapse if the seafarers concerned do not claim it within a reasonable period of time
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎to be defined by national laws or regulations or collective agreements, except where they are held captive on or off the
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ship as a result of acts of piracy or armed robbery against ships.)
		</td>
	</tr>

	<tr><td colspan="14"></td></tr>

	<tr>
		<td colspan="14" style="{{ $bold }}">
			10. 이 계약에서 정함이 없는 사항은 선박의 기국법 또는 단체협약 또는 취업규칙이 정하는 바에 의한다.
		</td>
	</tr>

	<tr>
		<td colspan="14" style="{{ $bold }}">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(Any facts which are not defined in this contract, these are complied with the law of flag state or the collective
		</td>
	</tr>

	<tr>
		<td colspan="14" style="{{ $bold }}">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎bargaining agreement or rules of employment)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎위 사항의 증거로써, 본 고용 계약서 2통에 각각 서명하고 각자 1부씩 보관하도록 한다.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(In witness whereof, 2 copies of this Contract have been made and mutually signed by either parties thence each one
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎of them are retained by the each party.)
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎선원은 고용계약서를 충분히 검토하고 자문 받을 기회를 제공받았고 자유의사에 의해 서명함.
		</td>
	</tr>

	<tr>
		<td colspan="14">
			 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎(Seafarer has opportunity to review and seek advice on the terms and condition and freely accept them.)
		</td>
	</tr>

	<tr><td colspan="14"></td></tr>

	<tr>
		<td colspan="9"></td>
		<td colspan="5" style="{{ $center }}">본 선박의 선주(들) 혹은</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2" style="{{ $center }}">선원 성명 : </td>
		<td colspan="6">{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}</td>
		<td colspan="5" style="{{ $center }}">선주(들)의 책임 및 권한을 대신하여</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2" style="{{ $center }}">(Name of Seafarer)</td>
		<td colspan="6"></td>
		<td colspan="5" style="{{ $center }}">(Shipowner(s) or for and on behalf</td>
	</tr>

	<tr>
		<td colspan="9"></td>
		<td colspan="5" style="{{ $center }}">of the shipowner(s) of the vessel)</td>
	</tr>

	<tr><td colspan="14"></td></tr>

	<tr>
		<td style="height: 40px; {{ $blue }} {{ $center }}" colspan="5">{{ $data->vessel->name }}</td>
		<td colspan="4" style="height: 45px;"></td>
		<td colspan="5" style="height: 45px;"></td>
	</tr>

	<tr><td colspan="14"></td></tr>
	<tr><td colspan="14"></td></tr>

	<tr>
		<td colspan="6"></td>
		<td colspan="2" style="{{ $center }}">페이지 3</td>
		<td colspan="4"></td>
		<td colspan="2" style="{{ $center }}">CK LINE Co., Ltd</td>
	</tr>
</table>