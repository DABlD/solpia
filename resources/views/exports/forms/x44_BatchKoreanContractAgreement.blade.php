@php
	// dd($data);
	// dd(url(public_path('fonts/NotoSansKR-Regular.ttf')));
	$s = "<span></span>";
	$bday = $data->user->birthday;
	$start = now()->parse($data->data['ed']);
	$months = $data->data['months'];
	$end = $start->copy()->add($months, 'months');
	$wage = $data->pro_app->wage;
@endphp

<table style="table-layout: fixed; width: 100%;">
	<tr>
		<td colspan="19">
			고 용 계 약 서
		</td>
	</tr>

	<tr>
		<td colspan="19">
			EMPLOYMENT CONTRACT
		</td>
	</tr>

	<tr><td colspan="19"></td></tr>

	<tr>
		<td colspan="19">
			1. 고용당사자
			{!! $s !!}{!! $s !!}{!! $s !!}
			PARTIES OF EMPLOYMENT
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="6">선주</td>
		<td colspan="2">주 소:</td>
		<td colspan="10">HMM CO., LTD</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="6">SHIPOWNER</td>
		<td colspan="2">ADDRESS</td>
		<td colspan="10">108, Yeoui-daero, Yeongdeungpo-gu, Seoul, Republic of Korea</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="6"></td>
		<td colspan="2">성 명:</td>
		<td colspan="10">WONHYOK CHOI</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="6"></td>
		<td colspan="2">NAME</td>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td colspan="19"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="6">선원(피고용자)</td>
		<td colspan="2">주 소:</td>
		<td colspan="3" rowspan="2">{{ $data->user->address ?? $data->provincial_address }}</td>
		<td>서기</td>
		<td>{{ $bday->format("Y") }}</td>
		<td>년</td>
		<td>{{ $bday->format("m") }}</td>
		<td>월</td>
		<td>{{ $bday->format('d') }}</td>
		<td>일생</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="6">SEAMAN(EMPLOYEE)</td>
		<td colspan="2">ADDRESS</td>
		<td>BORN IN A.D.</td>
		<td>YEAR</td>
		<td colspan="3">MONTH</td>
		<td>DAY</td>
		<td></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="6"></td>
		<td colspan="2">성 명:</td>
		<td colspan="3" rowspan="2">{{ $data->user->namefull }}</td>
		<td colspan="2">선원수첩번호 :</td>
		<td colspan="5">{{ $data->document_id->{"SEAMAN'S BOOK"}->number }}</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="6"></td>
		<td colspan="2">NAME</td>
		<td colspan="2">SEAMAN'S BOOK No.</td>
		<td colspan="5"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="6"></td>
		<td colspan="2"></td>
		<td colspan="3"></td>
		<td>직책 :</td>
		<td colspan="6" rowspan="2">{{ $data->pro_app->rank->name }}</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="6"></td>
		<td colspan="2"></td>
		<td colspan="3"></td>
		<td>POSITION</td>
	</tr>

	<tr>
		<td colspan="19">
			2. 계약내용
			{!! $s !!}{!! $s !!}{!! $s !!}
			CONTENTS OF THE CONTRACT
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="3">가. 승선선박 :</td>
		<td colspan="6">{{ $data->pro_app->vessel->name }}</td>
		<td></td>
		<td>소 속 :</td>
		<td colspan="7">HMM CO., LTD</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="8">VESSEL TO SERVE ON BOARD</td>
		<td></td>
		<td colspan="8">COMPANY</td>
	</tr>

	<tr>
		<td colspan="19"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="18">
			나. 계약기간
			{!! $s !!}{!! $s !!}{!! $s !!}
			TERM OF THE CONTRACT
		</td>
	</tr>

	   
	<tr>
		<td colspan="2"></td>
		<td>서기</td>
		<td>{{ $start->format("Y") }}</td>
		<td>년</td>
		<td>{{ $start->format('m') }}</td>
		<td>월</td>
		<td>{{ $start->format('d') }}</td>
		<td colspan="2">일부터</td>
		<td>서기</td>
		<td>{{ $end->format("Y") }}{!! $s !!}{!! $s !!} 년</td>
		<td>{{ $end->format("m") }}{!! $s !!}{!! $s !!} 월 {!! $s !!}{!! $s !!} {{ $end->format("d") }}</td>
		<td>일까지({{ $months }} 개월간)</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="8">
			FROM A.D.
			{!! $s !!}{!! $s !!}
			YEAR
			{!! $s !!}{!! $s !!}
			MONTH
			{!! $s !!}{!! $s !!}{!! $s !!}{!! $s !!}{!! $s !!}
			DAY
		</td>
		<td colspan="9">
			TILL A.D.
			{!! $s !!}{!! $s !!}
			YEAR
			{!! $s !!}{!! $s !!}
			MONTH
			{!! $s !!}{!! $s !!}{!! $s !!}
			DAY
			{!! $s !!}{!! $s !!}
			(MONTH(S))
		</td>
	</tr>

	<tr>
		<td colspan="19"></td>
	</tr>

	<tr>
		<td colspan="19">
			3. 고용조건{!! $s !!}{!! $s !!}{!! $s !!}TERMS AND CONDITONS OF EMPLOYMENT
		</td>
	</tr>

	<tr>
		<td></td>
		<td>1)</td>
		<td colspan="2">
			봉급
			{!! $s !!}{!! $s !!}{!! $s !!}{!! $s !!}
			월
		</td>
		<td colspan="3">{{ $wage->basic ?? 0 }} USD</td>
		<td colspan="4"></td>
		<td>시간외수당</td>
		<td>월</td>
		<td>{{ ($wage->ot ?? 0) + ($wage->fot ?? 0) + ($wage->owner_allow ?? 0) }}</td>
		<td>USD</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="9">MONTHLY BASIC WAGES</td>
		<td colspan="8">MONTHLY OVERTIME</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td colspan="2">
			제수당 월
			{!! $s !!}{!! $s !!}{!! $s !!}{!! $s !!}
			월
		</td>
		<td colspan="3">{{ ($wage->leave_pay ?? 0) + ($wage->sub_allow ?? 0) + ($wage->retire_allow ?? 0) }} USD</td>
		<td colspan="4"></td>
		<td>시간외수당</td>
		<td>월</td>
		<td>{{ $wage->total ?? 0 }}</td>
		<td>USD</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="9">SEVERAL ALLOWANCE</td>
		<td colspan="8">MONTHLY GROSS WAGES</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="4">2) 취업규칙의 준수</td>
		<td></td>
		<td colspan="13">TO OBSERVE THE RULES OF EMPLOYMENT</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="4">3) 선원법령의 준수</td>
		<td></td>
		<td colspan="13">TO OBSERVE THE SEAMEN ACT</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="18">
			4) 재해보상 : 기본급여를 기준으로 하여 필리핀 선원법에서 정하는 재해보상일수를 준용한 별도의 선원
		</td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="15">
			사용 계약서에 따름.
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="17">
			WORKMEN'S COMPENSATION : SHALL BE IN ACCORDANCE WITH ANOTHER SEAMAN EMPLOYMENT CONTRACT
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="17">
			WHERE IT IS BASED ON BASIC WAGES AND THE DAYS FOR COMPENSATION AS PROVIDED BY PHILIPPINES
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="17">
			SEAMAN ACT.
		</td>
	</tr>

	<tr>
		<td colspan="19"></td>
	</tr>

	<tr>
		<td colspan="19">
			ㅤ{!! $s !!}{!! $s !!}{!! $s !!}{!! $s !!}위 계약당사자는상기와 같은 계약내용으로 선주 소요선박에 근무하기 위한 계약을 체결하였음을 확인
			하며 아울러 선주는 선원의 신원을 책임지고 선원의 보수, 재해보상을 선주책임하에 지불함을 상호 확인함.
			또한 선원의 위법행위로 생기는 일체의 책임을 선주가 질것을 확인함.
		</td>
	</tr>

	<tr>
		<td colspan="19">
			ㅤ{!! $s !!}{!! $s !!}{!! $s !!}{!! $s !!}BOTH PARTIED DESIGATED HEREIN CERTIFY THAT THEY HAVE ENTERED INTO CONTRACT FOR THE SERVICE
			OF THE SEAMAN ON BOARD THE VESSEL OF THE SHIPOWNER IN ACCORDANCE WITH ABOVE CONTENTS OF THE
			CONTRACT, THAT THE SHIPOWNER SHALL STAND GUARANTEE FOR THE SEAMAN, THAT THE SHIPOWNER SHALL
			UNDERTAKE TO PAY TO THE SEAMAN HIS WAGES AND WORKMEN'S COMPENSATION AND THAT THE SHIPOWNER
			SHALL ANSWER FOR ANY ILLEGAL ACT OF THE SEAMAN.
		</td>
	</tr>

	<tr>
		<td colspan="19"></td>
	</tr>

	<tr>
		<td colspan="11"></td>
		<td>서기</td>
		<td>{{ now()->format("Y") }}</td>
		<td>년</td>
		<td>{{ now()->format('m') }}</td>
		<td>월</td>
		<td>{{ now()->format('d') }}</td>
		<td>일</td>
	</tr>

	<tr>
		<td colspan="11"></td>
		<td></td>
		<td>YEAR</td>
		<td></td>
		<td>MONTH</td>
		<td></td>
		<td>DAY</td>
		<td></td>
	</tr>

	<tr>
		<td colspan="14" rowspan="2"></td>
	</tr>

	<tr>
		<td></td>
	</tr>

	<tr>
		<td colspan="14"></td>
		<td colspan="5">선 원 SEAMAN</td>
	</tr>
</table>