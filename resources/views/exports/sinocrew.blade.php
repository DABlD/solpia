@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
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
			return $date->format('d-M-Y');
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

	$doc = function($docu, $type, $issuer = null, $name = null, $regulation = null) use ($data, $checkDate2, $rank, $cleanText) {
		$name   = !$name ? $docu : $name;

		if(in_array($type, ['id', 'lc', 'med_cert'])){

			if($type == "lc" && ($docu == "COC" || $docu == "COE") && $name == "NATIONAL LICENSE - RATINGS"){
				if($rank > 0 && $regulation){
					$tempDocu = $docu;
					$docu = false;
					$temp = "";

					if($rank >= 9 && $rank <= 23){
						foreach($data->document_lc as $document){
							$regulation = json_decode($document->regulation);
							
							if($rank >= 9 && $rank <= 14){
								$tempName = "COC";
								$temp = $tempDocu == $tempName ? 'II/4' : 'II/5';
							}
							elseif($rank >= 15 && $rank <= 23){
								$tempName = "COE";
								$temp = $tempDocu == $tempName ? 'III/4' : 'III/5';
							}

						    if($document->type == $tempName && in_array($temp, $regulation)){
						        $docu = $document;
						        break; 
						    }
						}

						$name .= " ($temp)";
					}
					else{
						$docu = false;
					}
				}
				else{
					return;
				}
			}
			elseif ($docu == 'ECDIS SPECIFIC') {
				$array = [
					'ECDIS FURUNO 2107',
					'ECDIS FURUNO 3200',
					'ECDIS FURUNO 3300',
					'ECDIS JRC 701B',
					'ECDIS JRC 7201',
					'ECDIS JRC 901B',
					'ECDIS JRC 9201',
					'ECDIS MARTEK',
					'ECDIS MECYS',
					'ECDIS TRANSAS',
				];

				$string = "";
				foreach($array as $ecdis){
					$docu = isset($data->{"document_$type"}->$ecdis) ? $data->{"document_$type"}->$ecdis : false;

					$number = $docu ? $docu->no : '-----';
					$issue  = $docu ? $checkDate2($docu->issue_date, 'I') : '-----';
					$expiry = $docu ? $checkDate2($docu->expiry_date, 'E') : '-----';

					if($docu){
						$string .= "
							<tr>
								<td colspan='2'>
									<span></span><span></span>$ecdis
								</td>

								<td colspan='1'>$number</td>
								<td colspan='2'>$issue</td>
								<td colspan='3'>$expiry</td>
								<td colspan='1'></td>
							</tr>
						";
					}

				}

				if($string != ""){
					echo $string;
					return;
				}
			}
			elseif ($docu == 'SSBT WITH BRM') {
				$temp = $docu;
				$docu = isset($data->{"document_$type"}->$docu) ? $data->{"document_$type"}->$docu : false;

				if(!$docu){
					$name = 'SSBT';
					$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;

					if(!$docu){
						$name = 'BRM';
						$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
					}

					if(!$docu){
						$name = 'BTM';
						$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
					}
				}
			}
			else{
				$temp = $docu;
				$docu = isset($data->{"document_$type"}->$docu) ? $data->{"document_$type"}->$docu : false;

				if(!$docu && $temp == "RADAR"){
					$name = 'RADAR TRAINING COURSE';
					$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;

					if(!$docu){
						$name = 'RADAR SIMULATOR COURSE';
						$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
					}

					if(!$docu){
						$name = 'RADAR OPERATOR PLOTTING AID';
						$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
					}
				}
				elseif($temp == "POLLUTION"){
					foreach(get_object_vars($data->document_lc) as $document){
					    if(str_contains($document->type, $temp)){
					        $docu = $document;
					    }
					}
				}
			}

		}
		elseif($type == 'flag'){

			$temp = $docu;
			$docu = false;

			if($rank >= 24 && $rank <= 26){
				if($temp == 'LICENSE'){
					$temp = "SHIP'S COOK ENDORSEMENT";
				}
			}

			foreach($data->document_flag as $document){
			    if($document->type == $temp){
			        $docu = $document;
			    }
			}
		}

		$noNum  = $type == 'lc' ? 'no' : 'number';

		$number = $docu ? $docu->$noNum : '-----';
		$issue  = $docu ? $checkDate2($docu->issue_date, 'I') : '-----';
		$expiry = $docu ? $checkDate2($docu->expiry_date, 'E') : '-----';

		$issuer = $issuer ?? 'NOT APPLICABLE';
		
		echo "
			<tr>
				<td colspan='3'>$name</td>
				<td colspan='2' style='text-align: center;'>$number</td>
				<td style='text-align: center;'>$issue</td>
				<td colspan='2' style='text-align: center;'>$expiry</td>
				<td colspan='3' style='text-align: center;'>$issuer</td>
			</tr>
		";
	};
@endphp

<table>
	<tr>
		<td colspan="11" style="{{ $bc }} height: 15px;">
			船员任职资格审核表
		</td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $bc }} height: 15px;">
			Seafarers' Qualification Audit Table
		</td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $bc }}">
			Seafarers' Information/船员基本信息
		</td>
	</tr>

	<tr>
		<td>Name/姓名</td>
		<td colspan="2" style="{{ $c }}">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td>D.O.B/出生日期</td>
		<td style="{{ $c }}">
			{{ $data->user->birthday != "" ? now()->parse($data->user->birthday)->format('d-M-Y') : "---" }}
		</td>
		<td>Position /职务</td>
		<td colspan="2" style="{{ $c }}">
			{{ $data->rank->abbr }}
		</td>
		<td colspan="2">M.A/海龄-M</td>
		<td style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="2">Nationality/国籍</td>
		<td style="{{ $c }}">FILIPINO</td>
		<td>P.O.B/出生地</td>
		<td style="{{ $c }}">{{ $data->birth_place }}</td>
		<td>Nation /民族</td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="2">政治面貌</td>
		<td style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="2">Labor Contract/劳动合同</td>
		<td style="{{ $c }}"></td>
		<td colspan="4">Employment Agreement（If Authorized)/上船协议(若授权）</td>
		<td colspan="2" style="{{ $c }}"></td>
		<td colspan="2" rowspan="6" style="{{ $bc }}">Photo</td>
	</tr>

	<tr>
		<td colspan="2">Proposed Ship/拟派船舶</td>
		<td style="{{ $c }}">
			{{ isset($data->vessel) ? $data->vessel->name : "" }}
		</td>
		<td colspan="4">Dispatch training and assessment/通过派遣培训考核</td>
		<td colspan="2" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="2">Embarkation port/上船港</td>
		<td style="{{ $c }}"></td>
		<td>M.P/本人电话</td>
		<td style="{{ $c }}"></td>
		<td>Family M.P/家属电话</td>
		<td colspan="3" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="2">Address/家庭住址</td>
		<td colspan="7" style="{{ $c }}">
			{{ $data->user->address }}
		</td>
	</tr>

	@php
		$temp = null;

		foreach($data->family_data as $fd){
			if($fd->type == "Father" && $fd->fname != ""){
				$temp = $fd;
			}
		}

		foreach($data->family_data as $fd){
			if($fd->type == "Mother" && $fd->fname != ""){
				$temp = $fd;
			}
		}

		foreach($data->family_data as $fd){
			if($fd->type == "Daughter" && $fd->fname != ""){
				$temp = $fd;
			}
		}

		foreach($data->family_data as $fd){
			if($fd->type == "Son" && $fd->fname != ""){
				$temp = $fd;
			}
		}

		foreach($data->family_data as $fd){
			if($fd->type == "Spouse" && $fd->fname != ""){
				$temp = $fd;
			}
		}

		foreach($data->family_data as $fd){
			if($fd->type == "Beneficiary" && $fd->fname != ""){
				$temp = $fd;
			}
		}
	@endphp

	<tr>
		<td colspan="2">Kin/Name/亲属姓名</td>
		<td style="{{ $c }}">
			@if(isset($temp))
				{{ $temp->lname }}, {{ $temp->fname }} {{ $temp->suffix }} {{ $temp->mname }}
			@endif
		</td>
		<td>Relation/关系</td>
		<td style="{{ $c }}">
			@if(isset($temp))
				{{ $temp->type }}
			@endif
		</td>
		<td>Z.Code/邮编</td>
		<td colspan="3" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $bc }}">Education /教育情况</td>
	</tr>

	@php
		$temp = null;

		foreach($data->educational_background as $eb){
			if($eb->type == "Undergraduate" && $eb->school != ""){
				$temp = $eb;
			}
		}

		foreach($data->educational_background as $eb){
			if($eb->type == "Vocational" && $eb->school != ""){
				$temp = $eb;
			}
		}

		foreach($data->educational_background as $eb){
			if($eb->type == "College" && $eb->school != ""){
				$temp = $eb;
			}
		}

	@endphp

	<tr>
		<td colspan="3" style="{{ $c }}">Graduate From/毕业院校</td>
		<td style="{{ $c }}">
			@if($temp)
				{{ $temp->school }}
			@endif
		</td>
		<td>Degree/学历</td>
		<td style="{{ $c }}">
			@if($temp)
				{{ $temp->course }}
			@endif
		</td>
		<td colspan="3">Date Graduated/毕业时间</td>
		<td colspan="2" style="{{ $c }}">
			@if($temp)
				{{ strlen($temp->year) >= 4 ? substr($temp->year, -4) : "---" }}
			@endif
		</td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $bc }}">Certificates /证书情况</td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $c }}">Certificates Type/证书名称</td>
		<td colspan="2" style="{{ $c }}">Number/证书号码</td>
		<td style="{{ $c }}">Iss.D./发证日期</td>
		<td colspan="2" style="{{ $c }}">Expiry/期满日期</td>
		<td colspan="3" style="{{ $c }}">Iss.Place/发证地点</td>
	</tr>

	{{ $doc("IDN",				'id', 		'MARINA', 		"ID. Number/身份证"							)}}
	{{ $doc("SEAMAN'S BOOK",	'id', 		'MARINA', 		"Seaman's Book/海员证"						)}}
	{{ $doc('PASSPORT', 		'id', 		'DFA',			'Passport/护照'								)}}
	{{ $doc("SRB",				'id', 		'MARINA', 		"Seaman's Record Book /服务薄"				)}}
	{{ $doc('COC', 				'lc',		'MARINA', 		'Competency Certificate/适任证书 '			)}}
	{{ $doc('LICENSE', 			'flag', 	'PANAMA', 		'Foreign Certificate/外籍证书'				)}}
	{{ $doc('NCII', 			'lc', 		'TESDA', 		'Certificate of Cook/Stew/厨师/服务员证'		)}}
	{{ $doc('OLC',	 			'lc', 		'',		 		'Other License/Certificate/其它证书'			)}}

	<tr>
		<td colspan="6" rowspan="2" style="{{ $bc }}">
			Certificate of Proficiency for seafarers of the P.R.China /海船船员培训合格证书
		</td>
		<td colspan="2" style="{{ $c }}">No./证书号码</td>
		<td colspan="3" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $c }}">Issue Date/签发</td>
		<td colspan="3" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $c }}">Item /项目</td>
		<td colspan="3" style="{{ $c }}">Clause/适用公约条款</td>
		<td colspan="3" style="{{ $c }}">Expire Date/有效期至 </td>
	</tr>

	@php
		$name = 'BASIC TRAINING - BT';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td colspan="5">Basic Training/基本安全培训</td>
		<td colspan="3" style="{{ $c }}">V1/1,A-V1/1</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$name = 'PROFICIENCY IN SURVIVAL CRAFT AND RESCUE BOAT - PSCRB';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td colspan="5">Survival Craft and Rescue/fast rescue Boats /精通艇筏和救助艇培训</td>
		<td colspan="3" style="{{ $c }}">V1/2,A-V1/2</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$name = 'ADVANCE FIRE FIGHTING - AFF';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td colspan="5">Training in advanced Fire-Fighting/高级消防培训</td>
		<td colspan="3" style="{{ $c }}">V1/3,A-V1/3</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$name = 'MEDICAL FIRST AID - MEFA';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td colspan="5">Training in medical first aid/精通急救培训</td>
		<td colspan="3" style="{{ $c }}">V1/4,A-V1/4</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$name = 'MEDICAL CARE - MECA';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td colspan="5">Training in Medical care/船上医护培训</td>
		<td colspan="3" style="{{ $c }}">V1/4,A-V1/4</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$name = 'SHIP SECURITY AWARENESS TRAINING & SEAFARERS WITH DESIGNATED SECURITY DUTIES - SDSD';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td colspan="5">Security awareness training/保安意识培训 </td>
		<td colspan="3" style="{{ $c }}">V1/6,A-V1/6</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	<tr>
		<td colspan="5">Seafarers with designated security duties/指定保安职责船员培训  </td>
		<td colspan="3" style="{{ $c }}">V1/6,A-V1/6</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$name = 'SHIP SECURITY OFFICER - SSO';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td colspan="5">Proficiency for ship security officer /船舶保安员培训</td>
		<td colspan="3" style="{{ $c }}">V1/5,A-V1/5</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$name = 'STC';
		$docu = isset($data->document_lc->{$name}) ? $data->document_lc->{$name} : false;
	@endphp
	<tr>
		<td colspan="5">Special Training Certificate /特殊专业培训合格证</td>
		<td colspan="3" style="{{ $c }}"></td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	@php
		$name = 'MEDICAL CERTIFICATE';
		$docu = isset($data->med_cert->{$name}) ? $data->med_cert->{$name} : false;
	@endphp
	<tr>
		<td colspan="5">Medical certificate for Seafarers/海船船员健康证书</td>
		<td colspan="3" style="{{ $c }}">StcwI /9-Mlc1.2</td>
		<td colspan="3" style="{{ $c }}">{{ $docu ? $checkDate2($docu->expiry_date, 'E') : 'N/A' }}</td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $bc }}">
			Previous Sea Experience (Last vessel first) and Safety Records 海上资历(从最后一条船开始)与安全记录
		</td>
	</tr>

	<tr>
		<td style="{{ $c }} height: 25px;">
			Ship's Name/
			<br style='mso-data-placement:same-cell;' />
			船名
		</td>
		<td style="{{ $c }} height: 25px;">
			Rank/
			<br style='mso-data-placement:same-cell;' />
			职务
		</td>
		<td style="{{ $c }} height: 25px;">
			Type/GRT/
			<br style='mso-data-placement:same-cell;' />
			船型/总吨
		</td>
		<td style="{{ $c }} height: 25px;">
			M/E Type/BHP/
			<br style='mso-data-placement:same-cell;' />
			主机型号/马力
		</td>
		<td style="{{ $c }} height: 25px;">
			Sign-on/
			<br style='mso-data-placement:same-cell;' />
			上船日期
		</td>
		<td style="{{ $c }} height: 25px;">
			Sign-off/
			<br style='mso-data-placement:same-cell;' />
			下船日期
		</td>
		<td style="{{ $c }} height: 25px;">
			Areas/
			<br style='mso-data-placement:same-cell;' />
			航区
		</td>
		<td style="{{ $c }} height: 25px;">
			Reason/
			<br style='mso-data-placement:same-cell;' />
			休假原因
		</td>
		<td style="{{ $c }}" colspan="2">
			Company/
			<br style='mso-data-placement:same-cell;' />
			船公司
		</td>
		<td style="{{ $c }} height: 25px;">
			IMP Note/
			<br style='mso-data-placement:same-cell;' />
			重要说明
		</td>
	</tr>

	@php
		$ss = array_values($data->sea_service->sortByDesc('sign_off')->toArray());

		for($i = 0; $i < 5; $i++){
			if(isset($ss[$i])){
				$name = $cleanText($ss[$i]['vessel_name']);
				$rank = $data->ranks[$ss[$i]['rank']];
				$tg = $cleanText($ss[$i]['vessel_type'] . "/" . $ss[$i]['gross_tonnage']);
				$tb = $cleanText($ss[$i]['engine_type'] . "/" . $ss[$i]['bhp_kw']);
				$son = $ss[$i]['sign_on'] != "" ? now()->parse($ss[$i]['sign_on'])->format('d-M-Y') : "---";
				$soff = $ss[$i]['sign_off'] != "" ? now()->parse($ss[$i]['sign_off'])->format('d-M-Y') : "---";
				$trade = $cleanText($ss[$i]['trade']);
				$reason = $cleanText($ss[$i]['remarks']);
				$manning = $cleanText($ss[$i]['manning_agent']);

				$h = 'height: 20px;';

				echo "
					<tr>
						<td style='$c $h'>$name</td>
						<td style='$c $h'>$rank</td>
						<td style='$c $h'>$tg</td>
						<td style='$c $h'>$tb</td>
						<td style='$c $h'>$son</td>
						<td style='$c $h'>$soff</td>
						<td style='$c $h'>$trade</td>
						<td style='$c $h'>$reason</td>
						<td colspan='2' style='$c $h'>$manning</td>
						<td style='$c $h'></td>
					</tr>
				";
			}
			else{
				echo "
					<tr>
						<td style='$c $h'></td>
						<td style='$c $h'></td>
						<td style='$c $h'></td>
						<td style='$c $h'></td>
						<td style='$c $h'></td>
						<td style='$c $h'></td>
						<td style='$c $h'></td>
						<td style='$c $h'></td>
						<td colspan='2' style='$c $h'></td>
						<td style='$c $h'></td>
					</tr>
				";
			}
		}
	@endphp

	<tr>
		<td rowspan="2" style="{{ $bc }}">
			Safety Records/
			<br style='mso-data-placement:same-cell;' />
			安全记录描述
		</td>
		<td colspan="10" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="10" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="7" style="{{ $bc }}">
			Professional Ability and Responsibility Evaluation /业务能力与工作责任心评价
		</td>
		<td colspan="3" rowspan="3" style="{{ $bc }}">
			Supervisor Signed by Crew Dep.
			<br style='mso-data-placement:same-cell;' />
			/派员公司
			<br style='mso-data-placement:same-cell;' />
			船员部主管签名
		</td>
		<td rowspan="3" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="7" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="7" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td colspan="11" style="{{ $bc }}">
			Verification Confirmed by the Company Functional Departments In Charge /船舶管理公司职能部门主管审核确认
		</td>
	</tr>

	<tr>
		<td style="{{ $c }}">Dep./部门</td>
		<td colspan="5" style="{{ $c }}">
			&#x2610; ‎‏‏‎ ‎‏‏‎ ‎‏‏‎Marine Dep. / 海务部 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎or/或 ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎&#x2610; ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎Technical Dep./ 机务部
		</td>
		<td colspan="5" style="{{ $c }}">
			Personal Dep./人事部
		</td>
	</tr>

	<tr>
		<td style="{{ $c }} height: 40px;">
			Review and 
			<br style='mso-data-placement:same-cell;' />
			signature/
			<br style='mso-data-placement:same-cell;' />
			审核签字
		</td>
		<td colspan="3" style="{{ $c }}">
			Suggestion /意见
		</td>
		<td colspan="2" style="{{ $c }}">
			Signed by /签字
		</td>
		<td colspan="3" style="{{ $c }}">
			Suggestion/意见
		</td>
		<td colspan="2" style="{{ $c }}">
			Signed by/签字
		</td>
	</tr>

	<tr>
		<td style="{{ $c }}">
			Date/审核日期
		</td>
		<td colspan="10" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td style="{{ $c }}">
			Instruction/说明
		</td>
		<td colspan="10" style="{{ $c }}"></td>
	</tr>

	<tr>
		<td style="{{ $c }} height: 40px;">Remark/备注</td>
		<td colspan="10" style="height: 40px;">
			1. The demand information listed in this form should be filled in detail and accurately / 本表所列需求信息应详尽、准确填写；
			<br style='mso-data-placement:same-cell;' />
			2. For the Master shall indicate in the column of "Important note" whether he has piloted and/or berthed by himself. / 对于船长，应在“重要说明”栏标明是否有自引自靠离经历。
			<br style='mso-data-placement:same-cell;' />
			3. COVID-19 vaccination status is noted in the instruction column. /新冠肺炎疫苗接种情况在说明栏备注。  
		</td>
	</tr>
</table>