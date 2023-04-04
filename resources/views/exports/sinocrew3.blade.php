@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b$c";
@endphp

<table>
	<tr>
		<td colspan="2" style="color: gray;">TENGDA SHIPPING LIMITED.</td>
		<td colspan="5"></td>
		<td colspan="2" style="color: gray;">TENGDGA-COD-017-01</td>
	</tr>

	<tr>
		<td colspan="3" style="color: gray;">公司操作性文件Company Operation Document</td>
		<td colspan="5"></td>
		<td style="color: gray;">REV:1.0</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 10px;"></td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $b }}">编号File No.：TENGDA-COD-017-01</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $b }}">Seafarer’s Application for Employment 船员雇佣申请表</td>
	</tr>

	<tr>
		<td colspan="2">Name (中/英文姓名)</td>
		<td colspan="2" style="{{ $c }}">{{ $data->user->namefull }}</td>
		<td>Rank (职务)</td>
		<td colspan="2" style="{{ $c }}">{{ $data->rank->abbr }}</td>
		<td colspan="2" rowspan="7" style="{{ $c }}">Photo</td>
	</tr>

	<tr>
		<td colspan="2">D O B (出生日期)</td>
		<td colspan="2" style="{{ $c }}">{{ $data->user->birthday ? $data->user->birthday->format('d-M-Y') : "---" }}</td>
		<td>P.O.B (出生地)</td>
		<td colspan="2" style="{{ $c }}">{{ $data->birth_place }}</td>
	</tr>

	<tr>
		<td colspan="2">ID No (身份证号码)</td>
		<td colspan="2" style="{{ $c }}"></td>
		<td>TEL （电话）</td>
		<td colspan="2" style="{{ $c }}">{{ $data->user->contact }}</td>
	</tr>

	<tr>
		<td colspan="2">Address (家庭地址)</td>
		<td colspan="5" style="{{ $c }}">{{ $data->user->address }}</td>
	</tr>

	@php
		$kin = null;

		foreach($data->family_data as $fd){
			if($fd->type == "Spouse"){
				$kin = $fd;
				break;
			}
		}

		if($kin == null){
			foreach($data->family_data as $fd){
				if($fd->type == "Father"){
					$kin = $fd;
					break;
				}
			}			
		}

		if($kin == null){
			foreach($data->family_data as $fd){
				if($fd->type == "Mother"){
					$kin = $fd;
					break;
				}
			}			
		}

		if($kin == null){
			foreach($data->family_data as $fd){
				if($fd->type == "Son"){
					$kin = $fd;
					break;
				}
			}			
		}

		if($kin == null){
			foreach($data->family_data as $fd){
				if($fd->type == "Daughter"){
					$kin = $fd;
					break;
				}
			}			
		}
	@endphp

	<tr>
		<td colspan="2">Kin/Name (亲属姓名)</td>
		<td colspan="2" style="{{ $c }}">{{ $kin ? $kin->namefull : "-" }}</td>
		<td>Relationship (关系)</td>
		<td colspan="2" style="{{ $c }}">{{ $fd ? $fd->type : "-" }}</td>
	</tr>

	<tr>
		<td>Weight 体重 （kg）</td>
		<td style="{{ $c }}">{{ $data->weight ?? "-" }}</td>
		<td>身高（cm）</td>
		<td style="{{ $c }}">{{ $data->height ?? "-" }}</td>
		<td>鞋、工作服： {{ $data->shoe_size ?? "-" }}, {{ $data->clothes_size ?? "-" }}</td>
		<td>Blood type血型</td>
		<td style="{{ $c }}">{{ $data->blood_type ?? "-" }}</td>
	</tr>

	@php
		$educ = null;

		foreach($data->educational_background as $eb){
			if($eb->type == "College"){
				$educ = $eb;
				break;
			}
		}

		if(!$educ){
			foreach($data->educational_background as $eb){
				if($eb->type == "Vocational"){
					$educ = $eb;
					break;
				}
			}
		}

		if(!$educ){
			foreach($data->educational_background as $eb){
				if($eb->type == "Undergraduate"){
					$educ = $eb;
					break;
				}
			}
		}
	@endphp

	<tr>
		<td colspan="2" style="height: 35px;">Education (毕业学校/时间/专业)</td>
		<td colspan="2" style="{{ $c }}">{{ $educ ? $educ->school : "-" }}</td>
		<td style="{{ $c }}">{{ $educ ? $educ->year : "-" }}</td>
		<td>Degree(学历)</td>
		<td style="{{ $c }}">{{ $educ ? $educ->course : "-" }}</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $bc }}">CERTIFICATES 证 书 情 况</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $c }} height: 40px;">
			Certificates Type
			<br style='mso-data-placement:same-cell;' />
			(证书名称)
		</td>
		<td colspan="2" style="{{ $c }} height: 40px;">
			Number
			<br style='mso-data-placement:same-cell;' />
			(证书号码)
		</td>
		<td colspan="2" style="{{ $c }} height: 40px;">
			Date/place of issue
			<br style='mso-data-placement:same-cell;' />
			(签发日期/地点)
		</td>
		<td colspan="2" style="{{ $c }} height: 40px;">
			Expired Date
			<br style='mso-data-placement:same-cell;' />
			(期满日期)
		</td>
	</tr>

	@php
		$docu = isset($data->document_id->{"SEAMAN'S BOOK"}) ? $data->document_id->{"SEAMAN'S BOOK"} : null;
	@endphp

	<tr>
		<td colspan="3">Seaman`s Book (海员证)</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->number : "-" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->issue_date ? $docu->issue_date->format("d-M-Y") : "-" : "-" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->expiry_date ? $docu->expiry_date->format("d-M-Y") : "-" : "-" }}</td>
	</tr>

	<tr>
		<td colspan="3">Seaman`s Record Book(服务簿)</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->number : "-" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->issue_date ? $docu->issue_date->format("d-M-Y") : "-" : "-" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->expiry_date ? $docu->expiry_date->format("d-M-Y") : "-" : "-" }}</td>
	</tr>

	@php
		$docu = isset($data->document_id->{"PASSPORT"}) ? $data->document_id->{"PASSPORT"} : null;
	@endphp

	<tr>
		<td colspan="3">Passport (护照)</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->number : "-" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->issue_date ? $docu->issue_date->format("d-M-Y") : "-" : "-" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->expiry_date ? $docu->expiry_date->format("d-M-Y") : "-" : "-" }}</td>
	</tr>

	@php
		$docu = isset($data->document_lc->{"COC"}) ? $data->document_lc->{"COC"} : null;
	@endphp

	<tr>
		<td colspan="3">Competency Certificate (适任证书)</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->no : "-" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->issue_date ? $docu->issue_date->format("d-M-Y") : "-" : "-" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->expiry_date ? $docu->expiry_date->format("d-M-Y") : "-" : "-" }}</td>
	</tr>

	@php
		$docu = isset($data->document_lc->{"GMDSS/GOC"}) ? $data->document_lc->{"GMDSS/GOC"} : null;
	@endphp

	<tr>
		<td colspan="3">GMDSS Certificate (GMDSS证书)</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->no : "-" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->issue_date ? $docu->issue_date->format("d-M-Y") : "-" : "-" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->expiry_date ? $docu->expiry_date->format("d-M-Y") : "-" : "-" }}</td>
	</tr>

	@php
		$docu = isset($data->document_flag->{"LICENSE"}) ? $data->document_flag->{"LICENSE"} : isset($data->document_flag->{"BOOKLET"}) ? $data->document_flag->{"BOOKLET"} : null;
	@endphp

	<tr>
		<td colspan="3">PNM/LIB Certificate (巴/利 证)</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->number : "-" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->issue_date ? $docu->issue_date->format("d-M-Y") : "-" : "-" }}</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->expiry_date ? $docu->expiry_date->format("d-M-Y") : "-" : "-" }}</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $bc }}">DETAILS OF COURSE/CERTIFICATES  专业培训班</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $c }}">Item (项目)</td>
		<td colspan="2" style="{{ $c }}">Number (号码)</td>
		<td colspan="3" style="{{ $c }}">Issue Date (签发日期)</td>
	</tr>

	<tr>
		<td colspan="4">Certificate of professional Training (专业培训合格证)</td>
		<td colspan="2" style="{{ $c }}">-</td>
		<td colspan="3" style="{{ $c }}">-</td>
	</tr>

	@php
		$docu = isset($data->document_lc->{"BASIC TRAINING - BT"}) ? $data->document_lc->{"BASIC TRAINING - BT"} : null;
	@endphp

	<tr>
		<td colspan="4">Basic Safely Training (基本安全)</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->no : "-" }}</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $docu->issue_date ? $docu->issue_date->format("d-M-Y") : "-" : "-" }}</td>
	</tr>

	@php
		$docu = isset($data->document_lc->{"PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB"}) ? $data->document_lc->{"PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB"} : null;
	@endphp

	<tr>
		<td colspan="4">Survival Craft and Rescue Boats (救生艇、筏)</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->no : "-" }}</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $docu->issue_date ? $docu->issue_date->format("d-M-Y") : "-" : "-" }}</td>
	</tr>

	@php
		$docu = isset($data->document_lc->{"MEDICAL FIRST AID - MEFA"}) ? $data->document_lc->{"MEDICAL FIRST AID - MEFA"} : null;
	@endphp

	<tr>
		<td colspan="4">Advanced First Aid (高级消防)</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->no : "-" }}</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $docu->issue_date ? $docu->issue_date->format("d-M-Y") : "-" : "-" }}</td>
	</tr>

	@php
		$docu = isset($data->document_lc->{"ADVANCE FIRE FIGHTING - AFF"}) ? $data->document_lc->{"ADVANCE FIRE FIGHTING - AFF"} : null;
	@endphp

	<tr>
		<td colspan="4">Medical Fire Fighting (精通急救)</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->no : "-" }}</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $docu->issue_date ? $docu->issue_date->format("d-M-Y") : "-" : "-" }}</td>
	</tr>

	@php
		$docu = isset($data->document_lc->{"RADAR OPERATOR PLOTTING"}) ? $data->document_lc->{"RADAR OPERATOR PLOTTING"} : null;

		if($docu == null){
			$docu = isset($data->document_lc->{"RADAR TRAINING COURSE"}) ? $data->document_lc->{"RADAR TRAINING COURSE"} : null;
		}
		if($docu == null){
			$docu = isset($data->document_lc->{"RADAR SIMULATOR COURSE"}) ? $data->document_lc->{"RADAR SIMULATOR COURSE"} : null;
		}
		if($docu == null){
			$docu = isset($data->document_lc->{"RADAR OBSERVER COURSE"}) ? $data->document_lc->{"RADAR OBSERVER COURSE"} : null;
		}
	@endphp

	<tr>
		<td colspan="4">Radar Observer Automatic Radar Piloting (雷达两小证)</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->no : "-" }}</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $docu->issue_date ? $docu->issue_date->format("d-M-Y") : "-" : "-" }}</td>
	</tr>

	@php
		$docu = isset($data->document_lc->{"MEDICAL CARE - MECA"}) ? $data->document_lc->{"MEDICAL CARE - MECA"} : null;
	@endphp

	<tr>
		<td colspan="4">Ship Captain Medicare (船上医护)</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->no : "-" }}</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $docu->issue_date ? $docu->issue_date->format("d-M-Y") : "-" : "-" }}</td>
	</tr>

	@php
		$docu = isset($data->document_lc->{"SHIP SECURITY OFFICER - SSO"}) ? $data->document_lc->{"SHIP SECURITY OFFICER - SSO"} : null;
	@endphp

	<tr>
		<td colspan="4">Certificate For Ship Security Officer Training（保安员证）</td>
		<td colspan="2" style="{{ $c }}">{{ $docu ? $docu->no : "-" }}</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $docu->issue_date ? $docu->issue_date->format("d-M-Y") : "-" : "-" }}</td>
	</tr>

	<tr>
		<td colspan="4">Special Training Certificate (特殊专业培训合格证)</td>
		<td colspan="2" style="{{ $c }}">-</td>
		<td colspan="3" style="{{ $c }}">-</td>
	</tr>

	<tr>
		<td colspan="4">Oil Tanker Familiarization/operations (油安/油操)</td>
		<td colspan="2" style="{{ $c }}">-</td>
		<td colspan="3" style="{{ $c }}">-</td>
	</tr>

	<tr>
		<td colspan="4">LGT Familiarization/operations (液安/液操)</td>
		<td colspan="2" style="{{ $c }}">-</td>
		<td colspan="3" style="{{ $c }}">-</td>
	</tr>

	<tr>
		<td colspan="4">Chemical Tanker Familiarizations/operations (化安/化操)</td>
		<td colspan="2" style="{{ $c }}">-</td>
		<td colspan="3" style="{{ $c }}">-</td>
	</tr>

	<tr>
		<td colspan="4">Ro-ro passenger ships (客滚船证书)</td>
		<td colspan="2" style="{{ $c }}">-</td>
		<td colspan="3" style="{{ $c }}">-</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $bc }}">Previous Sea Experience (Last vessel first)  海上资历 （从最后一条船开始）</td>
	</tr>

	<tr>
		<td style="{{ $c }} height: 35px;">
			Ship's Name
			<br style='mso-data-placement:same-cell;' />
			船名
		</td>
		<td style="{{ $c }} height: 35px;">
			Rank
			<br style='mso-data-placement:same-cell;' />
			职务
		</td>
		<td style="{{ $c }} height: 35px;">
			Sign-on Date
			<br style='mso-data-placement:same-cell;' />
			上船日期
		</td>
		<td style="{{ $c }} height: 35px;">
			Sign-off Date
			<br style='mso-data-placement:same-cell;' />
			下船日期
		</td>
		<td style="{{ $c }} height: 35px;">
			VSL Type/GRT
			<br style='mso-data-placement:same-cell;' />
			船舶类型/总吨
		</td>
		<td style="{{ $c }} height: 35px;">
			M/E Type/BHP
			<br style='mso-data-placement:same-cell;' />
			主机型号/马力
		</td>
		<td style="{{ $c }} height: 35px;">
			Areas
			<br style='mso-data-placement:same-cell;' />
			航区
		</td>
		<td colspan="2" style="{{ $c }} height: 35px;">
			Company Name
			<br style='mso-data-placement:same-cell;' />
			 公司名称
		</td>
	</tr>

	@foreach($data->sea_service as $ss)
		@php
			$cleanText = function($text){
				return str_replace('&', '&#38;', $text);
			};

			$vessel_name = $ss->vessel_name ? $cleanText($ss->vessel_name) : "";
			$rank = $ss->rank ? $cleanText($ss->rank) : "";
			$sign_on = $ss->sign_on ? $ss->sign_on->format("d-M-Y") : "";
			$sign_off = $ss->sign_off ? $ss->sign_off->format("d-M-Y") : "";
			$vessel_type = $ss->vessel_type ? $cleanText($ss->vessel_type) : "";
			$grt = $ss->gross_tonnage ?? "-";
			$engine_type = $ss->engine_type ? $cleanText($ss->engine_type) : "";
			$bhp_kw = $ss->bhp_kw ?? "";
			$trade = $ss->trade ? $cleanText($ss->trade) : "";
			$manning_agent = $ss->manning_agent ? $cleanText($ss->manning_agent) : "";
		@endphp

		<tr>
			@if($vessel_name != "")
				<td style="{{ $c }} height: 35px;">{{ $vessel_name }}</td>
			@else
				<td style="{{ $c }}">{{ $vessel_name }}</td>
			@endif
			<td style="{{ $c }}">{{ $rank }}</td>
			<td style="{{ $c }}">{{ $sign_on }}</td>
			<td style="{{ $c }}">{{ $sign_off }}</td>
			<td style="{{ $c }}">{{ $vessel_type }} / {{ $grt }}</td>
			<td style="{{ $c }}">{{ $engine_type }} / {{ $bhp_kw }}</td>
			<td style="{{ $c }}">{{ $trade }}</td>
			<td colspan="2" style="{{ $c }}">{{ $manning_agent }}</td>
		</tr>
	@endforeach

	<tr>
		<td colspan="9">备注：</td>
	</tr>

	<tr>
		<td colspan="2">拟上船舶</td>
		<td colspan="2" style="{{ $c }}"></td>
		<td>实际上船日期</td>
		<td colspan="4" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="2">审核意见（签名，日期）</td>
		<td colspan="7" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $b }}">
			‎‎‎‎注：本记录一式一份，长久保存在船管部。
		</td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $b }}">
			Remark: this 1 form is the only copy, kept by the Ship Management department for a long term.
		</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 10px;"></td>
	</tr>

	<tr>
		<td colspan="2" style="color: gray;">TENGDA SHIPPING LIMITED.</td>
		<td colspan="5"></td>
		<td colspan="2" style="color: gray;">TENGDGA-COD-017-01</td>
	</tr>

	<tr>
		<td colspan="3" style="color: gray;">公司操作性文件Company Operation Document</td>
		<td colspan="5"></td>
		<td style="color: gray;">REV:1.0</td>
	</tr>
</table>