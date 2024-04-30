@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b$c";
@endphp

<table>
	<tr>
		<td colspan="6" style="{{ $b }}">PART 1: TENGDA SHIPPING LIMITED</td>
		<td colspan="3" style="text-align: right;">Top Copy - Seafarer</td>
	</tr>
	<tr>
		<td></td>
		<td colspan="5" style="{{ $b }}">
			‎‎‎‎‎‎‎‎
			‎‎‎‎‎‎‎‎
			‎‎‎‎‎‎‎‎
			‎‎‎‎‎‎‎‎
			‎‎‎‎‎‎‎‎
			SEAFARER'S EMPLOYMENT CONTRACT
		</td>
		<td colspan="3" style="text-align: right;">2nd Copy - Ship's File</td>
	</tr>
	<tr>
		<td colspan="6">第一部分：腾达船务有限公司海员就业合同</td>
		<td colspan="3" style="text-align: right;">3rd Copy - Company</td>
	</tr>
	<tr>
		<td colspan="9" style="height: 30px;"></td>
	</tr>

	<tr>
		<td>Date</td>
		<td></td>
		<td colspan="2">and agreed to be effective from</td>
		<td colspan="2"></td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="9" style="height: 5px;"></td>
	</tr>

	<tr>
		<td colspan="9">
			‎‎
			The Employment Contract is entered into between the Seafarer and the Ship-owner/the Employer on behalf of the Ship-owner.
		</td>
	</tr>

	<tr>
		<td colspan="9">
			‎‎
			就业合同为海员与船东/雇主代表船东签订。
		</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $b }} height: 20px;">THE SEAFARERS(船员)</td>
	</tr>

	<tr>
		<td colspan="5">
			‎‎
			Surname: {{ $data->user->lname }}
		</td>
		<td colspan="4">
			‎‎
			Given Name: {{ $data->user->fname }} {{ $data->user->suffix }}
		</td>
	</tr>

	<tr>
		<td colspan="5">
			‎‎
			姓：
		</td>
		<td colspan="4">
			‎‎
			名：
		</td>
	</tr>

	<tr>
		<td colspan="9">
			‎‎
			Full home address: {{ $data->user->address }}
		</td>
	</tr>

	<tr>
		<td colspan="9">
			‎‎
			家庭住址:  
		</td>
	</tr>

	@php
		$pp = null;
		$sb = null;
		$mc = null;

		foreach($data->document_med_cert as $docu){
			if($docu->type == "MEDICAL CERTIFICATE"){
				$mc = $docu;
			}
		}

		foreach($data->document_id as $docu){
			if($docu->type == "PASSPORT"){
				$pp = $docu;
			}
			elseif($docu->type == "SEAMAN'S BOOK"){
				$sb = $docu;
			}
		}
	@endphp

	<tr>
		<td colspan="5">
			‎‎
			Position 职位： {{ $data->pro_app->rank->abbr }} 
		</td>
		<td colspan="4">
			‎‎
			Medical certificate issued on 健康证签发日期：{{ $mc ? (isset($mc->issue_date) ? $mc->issue_date->format("d/M/Y") : "---") : "---"  }}
		</td>
	</tr>

	<tr>
		<td colspan="5">
			‎‎
			Estimated time of take up position: {{ $data->employment_months }}
		</td>
		<td colspan="4">
			‎‎
			Port where is taken up: {{ $data->port }}
		</td>
	</tr>

	<tr>
		<td colspan="5">
			‎‎
			预计接班时间： 
		</td>
		<td colspan="4">
			‎‎
			接班港口: 
		</td>
	</tr>

	<tr>
		<td colspan="5">
			‎‎
			Nationality 国籍： FILIPINO 
		</td>
		<td colspan="4">
			‎‎
			Passport No. 护照号码: {{ $pp ? $pp->number : '---' }}
		</td>
	</tr>

	<tr>
		<td colspan="5">
			‎‎
			Date of birth 出生日期: {{ isset($data->user->birthday) ? $data->user->birthday->format('d/M/Y') : "---" }}
		</td>
		<td colspan="4">
			‎‎
			Seaman’s book No. 海员证号码: {{ $sb ? $sb->number : '---' }}
		</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 30px; {{ $b }}">THE SHIPOWNER（船东）</td>
	</tr>

	<tr>
		<td colspan="9">Name（名称）：Tengda Shipping Limited </td>
	</tr>

	<tr>
		<td colspan="9" style="height: 30px;">
			Address（地址）：Room 715, Building 1, Kingkey Yujing Times Center, Longcheng Jie, Longgang Qu, Shenzhen, Guangdong,518172 China
		</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 30px; {{ $b }}">THE EMPLOYER（雇主）</td>
	</tr>

	<tr>
		<td colspan="9">Name（名称）：Shenzhen Sinocrew Maritime Services Co., Limited</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 30px;">
			Address（地址）: Room 501A, Building2, KingkeyYujingTimes Center, Longcheng Street, Longgang District, Shenzhen City, Guangdong Province, China
		</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $b }}">THE SHIP（船舶）</td>
	</tr>

	{{-- VESSEL --}}

	<tr>
		<td colspan="5">
			‎‎
			Name船名： {{ $data->pro_app->vessel->name }}
		</td>
		<td colspan="4">
			‎‎
			IMO No. 国际识别号： {{ $data->pro_app->vessel->imo }}
		</td>
	</tr>

	<tr>
		<td colspan="5">
			‎‎
			Flag船旗： {{ $data->pro_app->vessel->flag }}
		</td>
		<td colspan="4">
			‎‎
			Port of registry注册港： {{ $data->pro_app->vessel->flag }}
		</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 30px; {{ $b }}">TERMS OF THE AGREEMENT（协议条款）</td>
	</tr>

	<tr>
		<td colspan="3">
			‎‎
			Period of employment (months)
		</td>
		<td colspan="4">
			‎‎
			Wages from and including: SIGN ON DATE
		</td>
		<td colspan="2">
			‎‎
			Basic hours of work per week: {{ $data->pro_app->vessel->work_hours ?? "-" }} hours
		</td>
	</tr>

	<tr>
		<td colspan="3">
			‎‎
			合同期限 (月): {{ $data->employment_months }} +/-1 MONTHS
		</td>
		<td colspan="4">
			‎‎
			工资起算日(包括当天)： 
			{{-- 工资起算日(包括当天)： {{ $data->pro_app->eld ? $data->pro_app->eld->format('d/M/Y') : "---" }} --}}
		</td>
		<td colspan="2">
			‎‎
			每周正常工作小时: {{ $data->pro_app->vessel->work_hours ?? "-" }} 小时
		</td>
	</tr>

	<tr>
		<td colspan="3">
			‎‎
		</td>
		<td colspan="4">
			‎‎
		</td>
		<td colspan="2">
			‎‎
		</td>
	</tr>

	<tr>
		<td colspan="3">
			‎‎
			Basic monthly wage
		</td>
		<td colspan="4">
			‎‎
			Monthly fixed overtime (officer fixed OT {{ $data->rankType == "OFFICER" ? "86" : "82" }}% basic, rating 
		</td>
		<td colspan="2">
			‎‎
			Overtime rate for the hours worked in excess of 
		</td>
	</tr>

	<tr>
		<td colspan="3">
			‎‎
			基本月工资 USD{{ $data->wage && $data->wage->basic ? $data->wage->basic : 0.00 }}/MONTH
		</td>
		<td colspan="4">
			‎‎
			85hrs guaranteed) 每月固定加班(高级船员82%，普通
		</td>
		<td colspan="2">
			‎‎
			85hrs (rating)工作时间超过85小时的加班费率
		</td>
	</tr>

	<tr>
		<td colspan="3">
			‎‎
		</td>
		<td colspan="4">
			‎‎
			普通船员保证85小时) USD{{ $data->wage ? $data->wage->fot ?? $data->wage->ot : 0.00 }}/MONTH
		</td>
		<td colspan="2">
			‎‎
			(普通船员) {{ $data->wage ? $data->wage->ot_per_hour : 0.00 }}
		</td>
	</tr>

	<tr>
		<td colspan="3">
			‎‎
		</td>
		<td colspan="4">
			‎‎
		</td>
		<td colspan="2">
			‎‎
		</td>
	</tr>

	<tr>
		<td colspan="3">
			‎‎
			Leave: Number of days per month
		</td>
		<td colspan="4">
			‎‎
			Monthly leave pay: USD{{ $data->wage && $data->wage->leave_pay ? $data->wage->leave_pay : 0.00 }}/MONTH
		</td>
		<td colspan="2">
			‎‎
			Bonus/supplement: USD{{ $data->wage && $data->wage->owner_allow ? $data->wage->owner_allow : 0.00 }}/MONTH
		</td>
	</tr>

	<tr>
		<td colspan="3">
			‎‎
			年休假：每月天数 {{ $data->wage && $data->wage->leave_per_month ? $data->wage->leave_per_month : 0 }} DAYS
		</td>
		<td colspan="4">
			‎‎
			月年休假工资：
		</td>
		<td colspan="2">
			‎‎
			奖金：
		</td>
	</tr>

	@php
		$salary = 0;

		$salary += $data->wage->basic ?? 0.00;
		$salary += $data->wage->leave_pay ?? 0.00;
		$salary += $data->wage->fot ?? 0.00;
		$salary += $data->wage->ot ?? 0.00;
		$salary += $data->wage->owner_allow ?? 0.00;
	@endphp

	<tr>
		<td colspan="3">
			‎‎
			社保费
		</td>
		<td colspan="6">
			‎‎
			Total Seafarers’ net cash. USD{{ $salary }}/MONTH
		</td>
	</tr>

	<tr>
		<td colspan="3">
			‎‎
			Social Security Cont.
		</td>
		<td colspan="6">
			‎‎
			海员净现金总额：
		</td>
	</tr>

	<tr>
		<td colspan="9">
			‎‎‎‎‎‎‎‎
			‎‎‎‎‎‎‎‎
			‎‎‎‎‎‎‎‎
			‎‎‎‎‎‎‎‎
			I, the undersigned, have fully understood the terms and conditions of this contract (Standard terms and conditions of agreement hereunder attached).
		</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $b }}">签署人已充分了解本合同的条款和条件（随附协议的标准条款和条件）。</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $b }}">CONFIRMATION OF THE CONTRACT</td>
	</tr>

	<tr>
		<td colspan="6">
			‎‎
			Signature of the shipowner/Employer on behalf of the Shipowner:
		</td>
		<td colspan="3">
			‎‎
			Signature of the Seafarer:
		</td>
	</tr>

	<tr>
		<td colspan="6">
			‎‎
			船东/代表船东的雇主：
		</td>
		<td colspan="3">
			‎‎
			船员签字：
		</td>
	</tr>

	<tr>
		<td colspan="6">
			‎‎
		</td>
		<td colspan="3">
			‎‎
		</td>
	</tr>

	<tr>
		<td colspan="6">
			‎‎
		</td>
		<td colspan="2">
			‎‎
			Place 地点：
		</td>
		<td colspan="1">
			‎‎
			Date日期: 
		</td>
	</tr>
</table>