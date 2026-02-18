@php
	$data = $data['applicants'][0];
	// dd($data);
	// dd(url(public_path('fonts/NotoSansKR-Regular.ttf')));
@endphp

<style>
    @font-face {
        font-family: 'NotoSansKR';
        src: url("file://{{ public_path('fonts/NotoSansKR-Regular.ttf') }}") format("truetype");
        font-weight: normal;
        font-style: normal;
    }

    body {
        font-family: 'NotoSansKR', sans-serif;
        font-size: 12px;
        width: 100%;
    }

    td{
    	border: 1px solid red;
    }

    table th:nth-child(1),
    table td:nth-child(1) { width: 25%; };
    table th:nth-child(2),
    table td:nth-child(2) { width: 15%; };
    table th:nth-child(3),
    table td:nth-child(3) { width: 5%; };
    table th:nth-child(4),
    table td:nth-child(4) { width: 5%; };
    table th:nth-child(5),
    table td:nth-child(5) { width: 10%; };
    table th:nth-child(6),
    table td:nth-child(6) { width: 40%; };
</style>

<table style="table-layout: fixed; width: 100%;">

	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="6" style="text-align: center;">고 용 계 약 서</td>
	</tr>

	<tr>
		<td colspan="6" style="text-decoration: underline; text-align: center;">EMPLOYMENT CONTRACT</td>
	</tr>

	<tr>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="6">1. 고용당사자 PARTIES OF EMPLOYMENT</td>
	</tr>

	<tr>
		<td>&nbsp;&nbsp;선주</td>
		<td>주 소:</td>
		<td colspan="4">HMM CO., LTD</td>
	</tr>

	<tr>
		<td>&nbsp;&nbsp;SHIPOWNER</td>
		<td>ADDRESS</td>
		<td colspan="4">108, Yeoui-daero, Yeongdeungpo-gu, Seoul, Republic of Korea</td>
	</tr>

	<tr>
		<td></td>
		<td>성 명:</td>
		<td colspan="4">WONHYOK CHOI</td>
	</tr>

	<tr>
		<td></td>
		<td>NAME</td>
		<td colspan="4"></td>
	</tr>

	<tr><td colspan="6"></td></tr>

	@php
		$bday = $data->user->birthday;
	@endphp

	<tr>
		<td>&nbsp;&nbsp;선원(피고용자)</td>
		<td>주 소:</td>
		<td colspan="3" rowspan="2" style="text-align: center;">{{ $data->user->address ?? $data->provincial_address }}</td>
		<td style="text-align: center;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;서기
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			{{ $bday->format('Y') }} &nbsp;&nbsp;년&nbsp;&nbsp;&nbsp;&nbsp; {{ $bday->format('m') }} &nbsp;&nbsp;월&nbsp;&nbsp;&nbsp;&nbsp; {{ $bday->format('d') }} &nbsp;&nbsp;일생</td>
	</tr>

	<tr>
		<td style="text-align: center;">&nbsp;&nbsp;SEAMAN(EMPLOYEE)</td>
		<td style="text-align: center;">ADDRESS:</td>
		{{-- <td colspan="3"></td> --}}
		<td style="text-align: center;">BORN IN A.D&nbsp;&nbsp;&nbsp;&nbsp; YEAR&nbsp;&nbsp;&nbsp;&nbsp; MONTH&nbsp;&nbsp;&nbsp;&nbsp; DAY</td>
	</tr>

	<tr>
		<td style="text-align: center;">&nbsp;&nbsp;</td>
		<td style="text-align: center;">성 명:</td>
		<td colspan="3" rowspan="2" style="text-align: center;">{{ $data->user->namefull }}</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			선원수첩번호 :
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $data->document_id->{"SEAMAN'S BOOK"}->number }}</td>
	</tr>

	<tr>
		<td style="text-align: center;">&nbsp;&nbsp;</td>
		<td style="text-align: center;">NAME</td>
		<td>SEAMAN'S BOOK No.</td>
	</tr>

	<tr>
		<td style="text-align: center;">&nbsp;&nbsp;</td>
		<td style="text-align: center;"></td>
		<td colspan="3" rowspan="2" style="text-align: center;"></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			직책 :
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			{{ $data->pro_app->rank->name }}</td>
	</tr>

	<tr>
		<td style="text-align: center;">&nbsp;&nbsp;</td>
		<td style="text-align: center;"></td>
		<td>POSITION</td>
	</tr>

	<tr>
		<td colspan="6" style="height: 10px;"></td>
	</tr>

	<tr>
		<td colspan="6">2. 계약내용 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CONTENTS OF THE CONTRACT</td>
	</tr>

	<tr>
		<td colspan="3">
			&nbsp;&nbsp;&nbsp;&nbsp;가. 승선선박 :
			<span>
				&nbsp;&nbsp;
				<span style="text-decoration: underline;">
					{{ str_pad($data->pro_app->vessel->name, 20, "ㅤ") }}
				</span>
			</span>
		</td>
		<td style="width: 10px;"></td>
		<td>소 속 :</td>
		<td>
			&nbsp;
			<span style="text-decoration: underline;">
				{{ str_pad("HMM CO., LTD", 30, "ㅤ") }}
			</span>
		</td>
	</tr>

	<tr>
		<td colspan="3">VESSEL TO SERVE ON BOARD</td>
		<td colspan="3">COMPANY</td>
	</tr>

	<tr>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td>
			<td colspan="6">
				&nbsp;&nbsp;&nbsp;
				나. 계약기간
				&nbsp;&nbsp;&nbsp;
				TERM OF THE CONTRACT
			</td>
		</td>
	</tr>

	<tr>
		<td colspan="3">
			&nbsp;&nbsp;&nbsp;
			서기 년 월 일부터
		</td>
	</tr>
</table>