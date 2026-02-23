<table>

	<tr>
		<td colspan="9">Seafarer's Employment Agreement</td>
	</tr>
	<tr>
		<td colspan="9">(선원 근로 계약서)</td>
	</tr>

	<tr>
		<td colspan="9">
			According to Maritime Labour Convention 2006, International Ship Registration Act, concerned collective bargaining agreement and the agency contract, the following parties agree to fully comply with the terms stated hereinafter.
		</td>
	</tr>

	<tr>
		<td colspan="9">1.	Seafarer and Capacity / Ship Owner / Agency / Ship (선원과 직무 / 선박소유자 / 대리점 / 선박)</td>
	</tr>

	<tr>
		<td rowspan="12"></td>
		<td rowspan="5" colspan="2">
			Seafarer
			<br style='mso-data-placement:same-cell;' />
			(선원)
		</td>
		<td>Name (성명)</td>
		<td colspan="3">
			{{ $data->user->namefull }}
		</td>
		<td>Date of birth (생일)</td>
		<td>{{ isset($data->user->birthday) ? $data->user->birthday->format('d-M-Y') : "-" }}</td>
	</tr>

	<tr>
		<td>Nationality (국적)</td>
		<td colspan="3">Filipino</td>
		<td>Birth place (출생지)</td>
		<td>{{ $data->birth_place }}</td>
	</tr>

	<tr>
		<td colspan="4">Seafarer’s booklet (선원수첩 번호)</td>
		<td colspan="2">{{ $data->{"SEAMAN'S BOOK"} }}</td>
	</tr>

	<tr>
		<td>Address (주소)</td>
		<td colspan="5">{{ $data->user->address ?? $data->user->provincial_address }}</td>
	</tr>

	<tr>
		<td>Capacity (직무)</td>
		<td colspan="5">{{ $data->position }}</td>
	</tr>

	<tr>
		<td rowspan="2" colspan="2">
			Ship owner
			<br style='mso-data-placement:same-cell;' />
			(선박소유자)
		</td>
		<td>Name (상호/대표자)</td>
		<td colspan="5">
			KOREA MARINE TRANSPORT CO., LTD. (고려해운㈜) 
			<br style='mso-data-placement:same-cell;' />
			/ 박정석(J.S. PARK), 신용화(Y.H. SHIN)
		</td>
	</tr>

	<tr>
		<td>Address (주소)</td>
		<td colspan="5">
			63, NAMDAEMUN-RO, JUNG-GU, SEOUL, R.O.KOREA 
			<br style='mso-data-placement:same-cell;' />
			(서울특별시, 중구 남대문로 63)
		</td>
	</tr>

	<tr>
		<td rowspan="2" colspan="2">
			Agency
			<br style='mso-data-placement:same-cell;' />
			(대 리 점)
		</td>
		<td>Name (상호)</td>
		<td colspan="5">SOLPIA MARINE &#38; SHIP MANAGEMENT, INC. </td>
	</tr>

	<tr>
		<td>Address (주소)</td>
		<td colspan="5">2019 San Marcelino St., Malate Manila, Philippines 1004</td>
	</tr>

	<tr>
		<td rowspan="3" colspan="2">
			Ship
			<br style='mso-data-placement:same-cell;' />
			(선박)
		</td>
		<td>Name (선명)</td>
		<td colspan="3">{{ $data->vessel->name }}</td>
		<td>G.R.T. (총톤수)</td>
		<td>{{ $data->vessel->gross_tonnage }}</td>
	</tr>

	<tr>
		<td>Year Built (건조년도)</td>
		<td colspan="3">{{ $data->vessel->year_build }}</td>
		<td>Flag (선적)</td>
		<td>{{ $data->vessel->flag }}</td>
	</tr>

	<tr>
		<td>IMO No. (IMO 번호)</td>
		<td colspan="3">{{ $data->vessel->imo }}</td>
		<td>TYPE(선종)</td>
		<td>{{ $data->vessel->type }}</td>
	</tr>

	<tr>
		<td colspan="9">2.	Period &#38; Termination of the agreement (계약기간 및 종료조건)</td>
	</tr>

	<tr>
		<td rowspan="6"></td>
		<td rowspan="2" colspan="2">
			Period
			<br style='mso-data-placement:same-cell;' />
			(계약기간)
		</td>
		<td colspan="3">Date of commencement (시작일)</td>
		<td colspan="3">{{ now()->parse($data->effective_date)->format('d-M-Y') }}</td>
	</tr>

	<tr>
		<td colspan="3">Date of termination (종료일)</td>
		<td colspan="3">{{ now()->parse($data->effective_date)->addMonths($data->employment_months)->format('d-M-Y') }}</td>
	</tr>

	<tr>
		<td>1)</td>
		<td colspan="7">
			The ship owner shall give the seafarer minimum 30 days’ notice by written for the early termination. (선박소유자는 선원근로계약 해지하려면 30일 이상의 예고기간을 두고 서면으로 선원에게 알려야 한다.)
		</td>
	</tr>

	<tr>
		<td>2)</td>
		<td colspan="7">
			The seafarer shall give the ship owner within more than 7 days’ and 30 days’ notice for the early termination. (선원은 조기 계약 종료 전 7일 이상 30일이내에 선박 소유자에게 예고 하여야 한다.)
		</td>
	</tr>

	<tr>
		<td>3)</td>
		<td colspan="7">
			Seafarer shall be supplied an opportunity to review and seek advice on contents in the agreement before signing freely. (해상직원은 근로계약에 대하여 자유의사로 선원 서명 전에 계약서를 검토하고 자문을 구할 기회를 제공받아야 한다.)
		</td>
	</tr>

	<tr>
		<td>4)</td>
		<td colspan="7">
			Seafarer’s employment agreement, including those in MLC Standard A2.1.7, A2.2.7 and MLC Guideline B2.5.1.8, shall continue to effect when seafarer are held captive on or off the ship as a result of acts of piracy or armed robbery against ships, regardless of whether the date fixed for its expiry has passed or either party has given notice to suspend or terminate it. (MLC Standard A2.1.7, A2.2.7 및 MLC Guideline B2.5.1.8의 내용을 포함하여 선박소유자의 의무로 선원 피랍 시 임금, 계약유지, 송환청구권이 유지된다)
		</td>
	</tr>

	@php
		$wage = $data->wage ?? null;

		$seniority = $data->pro_app->seniority;

		$spay = 0;
		if($data->wage){
			$srpay = json_decode($data->wage->sr_pay);
			
			if($seniority > 1){
				$spay = $srpay[$seniority - 2];
			}
		}

		$count = $data->sea_service->filter(function ($item) {
			return preg_match('/kmtc|korea marine transport/i', $item->principal);
		})->count();

		$count = $count > 5 ? 5 : $count;
		$rjpay = [0,20,40,60,80,100];

		$basic = $wage ? $data->wage->basic : 0;
		$fot = $data->wage ? ($data->wage->fot ?? $data->wage->ot ?? 0) : 0;
		$oa = $data->wage ? ($data->wage->owner_allow ?? 0) : 0;
		$lp = $data->wage ? $data->wage->leave_pay : 0;
		$rj = $rjpay[$count];

		$total = $basic + $fot + $oa + $lp + $spay + $rj;
	@endphp

	<tr>
		<td colspan="9">3.	Wages (급여)</td>
	</tr>

	<tr>
		<td rowspan="10"></td>
		<td rowspan="4" colspan="2">
			Monthly Wages
			<br style='mso-data-placement:same-cell;' />
			(월 급)
		</td>
		<td>
			Basic wage
			<br style='mso-data-placement:same-cell;' />
			(기본급)
		</td>
		<td colspan="3">
			Fixed Overtime Allowance
			<br style='mso-data-placement:same-cell;' />
			(고정시간외수당)
		</td>
		<td>
			Leave Pay
			<br style='mso-data-placement:same-cell;' />
			(휴가비)
		</td>
		<td>
			Open Overtime Allowance
			<br style='mso-data-placement:same-cell;' />
			(시간급시간외수당)
		</td>
	</tr>

	<tr>
		<td>${{ $basic }}</td>
		<td colspan="3">${{ $fot }}</td>
		<td>${{ $lp }}</td>
		<td>${{ $oa }}</td>
	</tr>

	<tr>
		<td>
			Seniority 
			<br style='mso-data-placement:same-cell;' />
			(호봉급)
		</td>
		<td colspan="3">
			Re-joining Bonus
			<br style='mso-data-placement:same-cell;' />
			(재고용수당)
		</td>
		<td>
		</td>
		<td>
			Total
			<br style='mso-data-placement:same-cell;' />
			(합계)
		</td>
	</tr>

	<tr>
		<td>${{ $spay }}</td>
		<td colspan="3">${{ $rj }}</td>
		<td></td>
		<td>${{ $total }}</td>
	</tr>

	<tr>
		<td colspan="2">
			Fixed Overtime allowance 
			<br style='mso-data-placement:same-cell;' />
			(시간외 근로수당)
		</td>
		<td colspan="6">(Basic wage / 191h) X 1.25 x 104h</td>
	</tr>

	<tr>
		<td colspan="2">
			Payment date
			<br style='mso-data-placement:same-cell;' />
			(지급일)
		</td>
		<td colspan="6">
			The seafarer receives his onboard pay every last day of that month. If his family allotment is needed, it can be paid to his family until the last day of the following month. (선원은 매월 말일 선상지급금을 수령한다. 단 가족불 지급이 필요할 경우 익월 말일까지 지급한다.)
		</td>
	</tr>

	<tr>
		<td colspan="2">
			Payment methods
		</td>
		<td colspan="6">
			Master pays seafarer’s onboard pay by each rank (Officer and Engineer $500, BSN/OL1/CS $400, AB/OLR/CK $300, Others $200). And balanced wage shall be remitted to his family through designated agency.
		</td>
	</tr>

	{{-- PAGE 2 --}}
	{{-- PAGE 2 --}}
	{{-- PAGE 2 --}}
	<tr>
		<td colspan="2">
			(지급방법)
		</td>
		<td colspan="6">
			(선장은 직책별 선상급여를 지급한다. (사관급 $500, 직장급 $400, 수직급 $300, 기타 $200) 그리고 나머지 월급은 지정된 대리점으로 통하여 가족에게 송금되도록 한다.)
		</td>
	</tr>

	<tr>
		<td colspan="2">
			Leave Pay
			<br style='mso-data-placement:same-cell;' />
			(휴가비)
		</td>
		<td colspan="6">
			ㅤ= Basic Wage ÷ 30 days × 4 .5 days 
			<br style='mso-data-placement:same-cell;' />
			The number of days of Leave Pay shall be 4.5 days per 1 month of continuous service. 
			<br style='mso-data-placement:same-cell;' />
			Master shall pay the Leave pay onboard before termination of engagement (휴가일수는 계속되는 근로에 대하여 1개월에 4.5 일로 정한다. 휴가비는 선상에서 선상지급금을 통해 계약종료 전 지급한다.)
		</td>
	</tr>

	<tr>
		<td colspan="2">
			Provision Fee
			<br style='mso-data-placement:same-cell;' />
			(주부식비)
		</td>
		<td colspan="6">
			{{-- ₩15,000 / day / person (1인당 1일 15,000원) --}}
			Follow the employment regulation. (취업규칙에 따른다.)
		</td>
	</tr>

	<tr>
		<td colspan="9">4.	Health and social security protection benefits (건강 및 사회 보장 급여)</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="8">
			The ship owner provides medical care and social security protection benefits according to the article of collective agreement and agency contract. (선박 소유자는 단체협약 및 대리점 계약에 따라 의료관리 및 사회보장 급여를 제공한다.)
		</td>
	</tr>

	<tr>
		<td colspan="9">5.	Seafarer's entitlement to repatriation (선원 송환 수급권)</td>
	</tr>

	<tr>
		<td rowspan="3"></td>
		<td>1)</td>
		<td colspan="7">
			The ship owner shall promptly repatriate the seafarer who leaves the ship at the place of which is not the seafarer's country of residence or the place at which the seafarer agreed to enter into the engagement as the ship owner's expenses. However, in case where the ship owner pays the expense of repatriation according to the request of the seafarer, ship owner does not have any responsibility for the repatriation. (선박소유자는 선원이 거주지 또는 선원근로계약의 체결지가 아닌 항구에서 하선하는 경우에는 선박 소유자의 비용으로 선원의 거주지 또는 선원근로계약 체결지 중 선원이 원하는 곳까지 지체 없이 송환해야 한다. 다만, 선원의 요청에 의하여 송환에 필요한 비용을 선원에게 지급할 경우에는 그러하지 아니한다.)
		</td>
	</tr>

	<tr>
		<td>2)</td>
		<td colspan="7">
			Despite above 1), in case of the following particulars, the ship owner can recover the cost of repatriation from the seafarer. However, ship owner has not to request over than 50% of repatriation expense to the seafarer boarded over than 6 months. (상기 1)항에 불구하고 선박 소유자는 각 호의 어느 하나에 해당되는 경우에는 송환에 소요된 비용을 선원에게 청구할 수 있다. 다만 6개월 이상 승무하고 송환된 선원에게는 송환 비용의 50%를 초과하여 청구할 수 없다.)
			<br style='mso-data-placement:same-cell;' />
			(1) When the seafarer leaves the ship without just reason. (선원이 정당한 사유 없이 임의 하선한 경우)
			<br style='mso-data-placement:same-cell;' />
			(2) When the seafarer leaves a ship according to disciplinary punishment which regulated in company’s procedure. (선원이 절차서 상 징계에 의해 하선한 경우)
		</td>
	</tr>

	<tr>
		<td colspan="2">
			Repatriation Airport
			<br style='mso-data-placement:same-cell;' />
			(귀국 공항)
		</td>
		<td colspan="6">MANILA, PHILIPPINES</td>
	</tr>

	<tr>
		<td colspan="9">6.	Standard of Hours of Work and Hours of Rest (근로 및 휴식시간)</td>
	</tr>

	<tr>
		<td rowspan="2"></td>
		<td>1)</td>
		<td colspan="7">
			Hours of work (근로시간)
			<br style='mso-data-placement:same-cell;' />
			(1) Hours of Ordinary Work(통상근로) : 8 Hours in a day and 44 Hours in a week(1일 8시간, 1주 44시간)
			<br style='mso-data-placement:same-cell;' />
			(2) Over Time Work(시간외근로) : Ship owner guaranteed 104 hours per month(선주는 월시간외근로 104시간 보장)
		</td>
	</tr>

	<tr>
		<td>2)</td>
		<td colspan="7">
			Hours of rest (휴식시간)
			<br style='mso-data-placement:same-cell;' />
			(1) Minimum of 10 hours rest in any 24 hour period and 77 hours in any seven-day period (일체의 24시간의 기간 중 10시간 그리고 일체의 7일의 기간 중 77시간)
			<br style='mso-data-placement:same-cell;' />
			(2) Minimum of 10 hours rest may be divided into no more than 2 periods, one of which shall be at least 6 hours in length. (휴식시간은 2회를 초과하지 않도록 분할할 수 있으며 그 중 한 번은 최소 6시간 이어야 한다.)
			<br style='mso-data-placement:same-cell;' />
			(3) The interval between consecutive periods of rest shall not exceed 14 hours. (연속적인 휴식시간 사이의 간격은 14시간을 초과하여서는 안 된다.)
			<br style='mso-data-placement:same-cell;' />
			(4) Musters and drills shall be conducted in a manner that minimizes the disturbance of rest periods and does not induce fatigue. (훈련은 휴식시간에 방해를 최소화하고 피로를 유발하지 아니하는 방식으로 시행한다.)
			<br style='mso-data-placement:same-cell;' />
			(5) When a seafarer is on call, the seafarer shall have an adequate compensatory rest period if the normal period of rest is disturbed by call-outs to work. (작업에 호출되어 정상적인 휴식기간을 방해 받았을 때에는 적절한 보상 휴식 시간을 제공한다.)
		</td>
	</tr>

	<tr>
		<td colspan="9">7.	Any facts which are not defined in this agreement (이 계약서에 정의되지 않은 사항)</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="8">
			Any facts which are not defined in this agreement, these are complied with the concerned collective agreement and agency contract. (이 계약서에 정의되지 않는 사항은 관련된 단체협약 및 대리점 계약 사항을 적용한다.)
		</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="8">
			In witness whereof, 2 copies of this agreement have been made and mutually signed by either parties thence each one of them are retained by the each party. (위 사항의 증거로써 본 근로 계약서를 2부에 상호 서명하고 각 각 1부씩 보관하도록 한다.)
		</td>
	</tr>

	<tr>
		<td colspan="4">(signature)</td>
		<td colspan="5">(signature)</td>
	</tr>

	<tr>
		<td colspan="4">
			{{ $data->user->namefull }}
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			(Seafarer)
		</td>
		<td colspan="5">
			Ms. Shirley Erasquin
			<br style='mso-data-placement:same-cell;' />
			<br style='mso-data-placement:same-cell;' />
			(Ship owner or
			<br style='mso-data-placement:same-cell;' />
			for and on behalf of the ship owner of the vessel
		</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td rowspan="2"></td>
		<td rowspan="2" colspan="4">
			Place where and date when a seafarer’s employment agreement is entered into.
			(선원 근로 계약서가 작성된 장소와 일자)
		</td>
		<td colspan="2">Place (장소)</td>
		<td colspan="2">Manila, Philippines</td>
	</tr>

	<tr>
		<td colspan="2">Date (일자)</td>
		<td colspan="2">{{ now()->format('d-M-Y') }}</td>
	</tr>
</table>