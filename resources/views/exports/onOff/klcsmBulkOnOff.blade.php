<table>
	<tr>
		<td colspan="10"></td>
	</tr>

	<tr>
		<td>문 서 :</td>
		<td colspan="9">CM1-25-</td>
	</tr>

	<tr>
		<td>수 신 : </td>
		<td colspan="9">CH BELLA호</td>
	</tr>

	<tr>
		<td>발 신 :</td>
		<td colspan="9">KLCSM㈜ / 해상인사1팀</td>
	</tr>

	<tr>
		<td>제 목 :</td>
		<td colspan="9">CH BELLA호 승조원 교대 계획 (Manila, Philippines항)</td>
	</tr>

	<tr><td colspan="10"></td></tr>

	<tr>
		<td colspan="10">
			1. 표제의 건 관련, 하기와 같이 선원교대 예정입니다.
		</td>
	</tr>

	<tr>
		<td colspan="10">
			2. 승/하선자 상세 및 교대 일정은 하기 참조하시기 바라오며, 일정 변경 시 내용 재송부 예정입니다.
		</td>
	</tr>

	<tr><td colspan="10"></td></tr>

	<tr>
		<td colspan="10">
			--- 아   래 ---
		</td>
	</tr>

	<tr>
		<td colspan="10">A. On-signer's detail</td>
	</tr>

	<tr>
		<td rowspan="2">RANK</td>
		<td rowspan="2">NAME</td>
		<td rowspan="2">NATIONALITY</td>
		<td rowspan="2">D.O.B</td>
		<td rowspan="2">PASSPORT</td>
		<td>ISSUED</td>
		<td rowspan="2">C.D.C</td>
		<td>ISSUED</td>
		<td rowspan="2">EMBARK DATE</td>
		<td rowspan="2">REMARK</td>
	</tr>

	<tr>
		<td>EXPIRE</td>
		<td>EXPIRE</td>
	</tr>

	@foreach($linedUps as $key => $onSigner)
		<tr>
			<td rowspan="2">{{ $onSigner->abbr }}</td>
			<td rowspan="2">{{ $onSigner->lname . ', ' . $onSigner->fname . ' ' . $onSigner->suffix . ' ' . $onSigner->mname }}</td>
			<td rowspan="2">FILIPINO</td>
			<td rowspan="2">{{ $onSigner->birthday ? now()->parse($onSigner->birthday)->format('d-M-y') : "-" }}</td>
			<td rowspan="2">{{ $onSigner->{'PASSPORTn'} ? strtoupper($onSigner->{'PASSPORTn'}) : '-' }}</td>
			<td>{{ $onSigner->{'PASSPORTi'} ? $onSigner->{'PASSPORTi'}->format('d-M-y') : '-' }}</td>
			<td rowspan="2">{{ $onSigner->{"SEAMAN'S BOOKn"} ? strtoupper($onSigner->{"SEAMAN'S BOOKn"}) : '-' }}</td>
			<td>{{ $onSigner->{"SEAMAN'S BOOKi"} ? $onSigner->{"SEAMAN'S BOOKi"}->format('d-M-y') : '-' }}</td>
			<td rowspan="2">{{ $onSigner->eld ? $onSigner->eld->format('d-M-y') : "" }}</td>
			<td rowspan="2"></td>
		</tr>

		<tr>
			<td>{{ $onSigner->{'PASSPORT'} ? $onSigner->{'PASSPORT'}->format('d-M-y') : '-' }}</td>
			<td>{{ $onSigner->{"SEAMAN'S BOOK"} ? $onSigner->{"SEAMAN'S BOOK"}->format('d-M-y') : '-' }}</td>
		</tr>
	@endforeach

	<tr><td colspan="10"></td></tr>

	<tr>
		<td colspan="10">B. Off-signer's detail</td>
	</tr>

	<tr>
		<td rowspan="2">RANK</td>
		<td rowspan="2">NAME</td>
		<td rowspan="2">NATIONALITY</td>
		<td rowspan="2">D.O.B</td>
		<td rowspan="2">PASSPORT</td>
		<td>ISSUED</td>
		<td rowspan="2">C.D.C</td>
		<td>ISSUED</td>
		<td rowspan="2">DISEMBARK DATE</td>
		<td rowspan="2">REMARK</td>
	</tr>

	<tr>
		<td>EXPIRE</td>
		<td>EXPIRE</td>
	</tr>

	@foreach($onBoards as $key => $offSigner)
		<tr>
			<td rowspan="2">{{ $offSigner->abbr }}</td>
			<td rowspan="2">{{ $offSigner->lname . ', ' . $offSigner->fname . ' ' . $offSigner->suffix . ' ' . $offSigner->mname }}</td>
			<td rowspan="2">FILIPINO</td>
			<td rowspan="2">{{ $offSigner->birthday ? now()->parse($offSigner->birthday)->format('d-M-y') : "-" }}</td>
			<td rowspan="2">{{ $offSigner->{'PASSPORTn'} ? strtoupper($offSigner->{'PASSPORTn'}) : '-' }}</td>
			<td>{{ $offSigner->{'PASSPORTi'} ? $offSigner->{'PASSPORTi'}->format('d-M-y') : '-' }}</td>
			<td rowspan="2">{{ $offSigner->{"SEAMAN'S BOOKn"} ? strtoupper($offSigner->{"SEAMAN'S BOOKn"}) : '-' }}</td>
			<td>{{ $offSigner->{"SEAMAN'S BOOKi"} ? $offSigner->{"SEAMAN'S BOOKi"}->format('d-M-y') : '-' }}</td>
			<td rowspan="2"></td>
			<td rowspan="2"></td>
		</tr>

		<tr>
			<td>{{ $offSigner->{'PASSPORT'} ? $offSigner->{'PASSPORT'}->format('d-M-y') : '-' }}</td>
			<td>{{ $offSigner->{"SEAMAN'S BOOK"} ? $offSigner->{"SEAMAN'S BOOK"}->format('d-M-y') : '-' }}</td>
		</tr>
	@endforeach

	<tr><td colspan="10"></td></tr>

	<tr>
		<td colspan="10">D. Remark</td>
	</tr>

	<tr>
		<td colspan="10">  -. 교대인원 HRIS FILE 송부 드렸으니 참조 및 고과평가 진행 바랍니다.</td>
	</tr>

	<tr>
		<td colspan="10">  -. 본선 접안일정 미확정으로, 승/하선일정 변동 가능성 많습니다.</td>
	</tr>

	<tr><td colspan="10"></td></tr>

	<tr>
		<td colspan="10">해상인사1팀장 김강현 ( 서명생략 )</td>
	</tr>

	<tr><td colspan="10"></td></tr>

	<tr>
		<td colspan="10">ISM code, ISO 9001/14001, OHSAS 18001</td>
	</tr>
</table>