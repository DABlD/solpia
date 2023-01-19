@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b$c";

	$d1 = function($text, $bo = false) use($b){
		if($bo){
			echo "
				<tr>
					<td colspan='10' style='$b'>$text</td>
				</tr>
			";
		}
		else{
			echo "
				<tr>
					<td colspan='10'>$text</td>
				</tr>
			";
		}
	};

	$d2 = function($text, $bo = false) use($b){
		if($bo){
			echo "
				<tr>
					<td colspan='10' style='$b'> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎$text</td>
				</tr>
			";
		}
		else{
			echo "
				<tr>
					<td colspan='10'> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎$text</td>
				</tr>
			";
		}
	};
@endphp

<table>
	
	{{-- PAGE 1 --}}
	<div>
		<tr><td colspan="10" style="height: 100px;"></td></tr>
		<tr><td colspan="10" style="{{ $bc }}">海员就业协议</td></tr>
		<tr><td colspan="10" style="{{ $bc }}">SEAFARER'S EMPLOYMENT AGREEMENT</td></tr>
		<tr><td colspan="10" style="{{ $bc }}">(供巴拿马籍船舶使用)</td></tr>
		<tr><td colspan="10" style="{{ $bc }}">FOR PANAMANIAN REGISTERED VESSELS USE ONLY</td></tr>

		<tr><td colspan="10" style="height: 200px;"></td></tr>
		<tr><td colspan="10" style="{{ $c }}">船名：枫洋</td></tr>
		<tr><td colspan="10" style="{{ $c }}">SHIP'S NAME: {{ $data->pro_app->vessel->name }}</td></tr>
		<tr><td colspan="10" style="height: 430px;"></td></tr>
		<tr><td colspan="10" style="{{ $bc }}">稳航船舶管理（天津）有限公司</td></tr>
		<tr><td colspan="10" style="{{ $bc }}">SAFETY SAILING SHIP MANAGEMENT(TIANJIN) CO.,LTD</td></tr>
	</div>

	<tr>
		<td colspan="10" style="height: 30px;"></td>
	</tr>

	{{-- PAGE2 --}}
	<div>
		<tr><td colspan="10" style="{{ $bc }}">SEAFARER'S EMPLOYMENT AGREEMENT</td></tr>
		<tr><td colspan="10" style="{{ $bc }}">船员就业协议</td></tr>
		<tr>
			<td colspan="10" style="height: 30px;">
				The employment Contract has been agreed by the seafarer and according to the principal of equality and voluntariness, After friendly consulting, This agreement was entered into between the seafarer and ship owner of the ship.
			</td>
		</tr>
		<tr>
			<td colspan="10" style="text-decoration: underline;">{{ $data->pro_app->vessel->name }}.</td>
		</tr>
		<tr>
			<td colspan="10">
				本协议是由船员本人充分理解了其权利和义务，根据平等自愿原则，经友好协商，海员和船东就服务于
			</td>
		</tr>
		<tr>
			<td colspan="1" style="text-decoration: underline;">{{ $data->pro_app->vessel->name }}.</td>
			<td colspan="9">一事签署如下协议。</td>
		</tr>

		{{-- THE SEAFARERS --}}
		<tr><td style="{{ $b }}">THE SEAFARERS(船员)</td></tr>

		<tr>
			<td colspan="4">Surname: {{ $data->user->lname }}</td>
			<td colspan="6">Given Name: {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}</td>
		</tr>

		<tr>
			<td colspan="4">姓：</td>
			<td colspan="6">名：</td>
		</tr>

		<tr>
			<td colspan="2">Date of birth: {{ isset($data->user->birthday) ? $data->user->birthday->format('d/M/Y') : "---" }}</td>
			<td colspan="5">Place of birth: {{ $data->birth_place }}</td>
			<td colspan="3">Nationality: FILIPINO</td>
		</tr>

		<tr>
			<td colspan="2">出生日期：</td>
			<td colspan="5">出生地点：</td>
			<td colspan="3">国籍：</td>
		</tr>

		<tr>
			<td colspan="10">Full home address: {{ $data->user->address }}</td>
		</tr>

		<tr>
			<td colspan="10">家庭住址：</td>
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
			<td colspan="2">Seaman’s book No.: {{ $pp ? $pp->number : '---' }}</td>
			<td colspan="5">Passport No.: {{ $sb ? $sb->number : '---' }}</td>
			<td colspan="3">Medical certificate issued on: {{ $mc ? (isset($mc->issue_date) ? $mc->issue_date->format("d/M/Y") : "---") : "---"  }}</td>
		</tr>

		<tr>
			<td colspan="2">海员证号码：</td>
			<td colspan="5">护照号码：</td>
			<td colspan="3">国籍：</td>
		</tr>

		<tr>
			<td colspan="2">Position of employment: {{ $data->pro_app->rank->abbr }}</td>
			<td colspan="5">Time of employment:</td>
			<td colspan="3">Port of employment: {{ $data->port }}</td>
		</tr>

		<tr>
			<td colspan="2">受雇职务：</td>
			<td colspan="5">任职时间：</td>
			<td colspan="3">任职港口：</td>
		</tr>

		{{-- THE SHIPOWNER --}}
		<tr>
			<td style="{{ $b }}">THE SHIPOWNER（船东)</td>
		</tr>

		<tr>
			<td colspan="10">Name（名称）：稳航船舶管理（天津）有限公司 Safety Sailing Ship Management (Tianjin) Co., LTD </td>
		</tr>

		<tr>
			<td colspan="10" style="height: 65px;">
				Address（地址）：天津自贸试验区（东疆保税港区）重庆道以南，呼伦贝尔路以西铭海中心1号楼-2、7-407
				<br style='mso-data-placement:same-cell;' />
				7-447 NO.2 GATE OF BUILDING1,SOUTH OF CHONGQING ROAD,CHINA(TIANJIN)PILOT FREE TRADE ZONE 
				<br style='mso-data-placement:same-cell;' />
				Operational address:天津市和平区大沽北路65号金融街中心1805室
				<br style='mso-data-placement:same-cell;' />
				1805 Huijin Center, No. 65, Dagu north road, Heping District, Tianjin,China
			</td>
		</tr>

		{{-- THE SHIP --}}
		<tr>
			<td style="{{ $b }}">THE SHIP（船舶)</td>
		</tr>

		<tr>
			<td>Name: {{ $data->pro_app->vessel->name }}</td>
			<td colspan="3">Flag: {{ $data->pro_app->vessel->flag }}</td>
			<td colspan="5">IMO No.: {{ $data->pro_app->vessel->imo }}</td>
			<td>Port of registry: {{ $data->pro_app->vessel->flag }}</td>
		</tr>

		<tr>
			<td>船名:</td>
			<td colspan="3">船旗国：</td>
			<td colspan="5">国际识别号：</td>
			<td>注册港:</td>
		</tr>

		<tr>
			<td colspan="4">Gross Registered Tonnage(GRT): {{ $data->pro_app->vessel->gross_tonnage }}</td>
			<td colspan="5">Year Built: {{ $data->pro_app->vessel->year_build }}</td>
			<td>Vessel Type: {{ $data->pro_app->vessel->type }}</td>
		</tr>

		<tr>
			<td colspan="4">总吨位：</td>
			<td colspan="5">建造时间：</td>
			<td>船舶类型：</td>
		</tr>

		<tr>
			<td>Trade Area: {{ $data->pro_app->vessel->trade }}</td>
			<td colspan="3">Minimum Crew: 14</td>
			<td colspan="6">Classification Society: NK</td>
		</tr>

		<tr>
			<td>服务航区:</td>
			<td colspan="3">最低配员:</td>
			<td colspan="6">船级社名称:</td>
		</tr>

		{{-- GENERAL TERMS OF THE AGREEMENT --}}
		@php
			$wage = $data->wage;
		@endphp
		<tr>
			<td style="{{ $b }}">GENERAL TERMS OF THE AGREEMENT（协议总条款）</td>
		</tr>

		<tr>
			<td colspan="3">Period of employment</td>
			<td colspan="4">Wages from and including:</td>
			<td colspan="3">Normal Hours of work per week:</td>
		</tr>

		<tr>
			<td colspan="3">（合同期限）： {{ $data->pro_app->mob }}+/-1months</td>
			<td colspan="4">工资起算日及包Sign on date:</td>
			<td colspan="3">每周正常工作小时: 44 hours</td>
		</tr>

		<tr>
			<td colspan="10">
				Monthly Consolidated Wage (including Basic wage USD{{ $wage->basic ?? 0 }}, 
				annual Leave pay USD{{ $wage->leave_pay }}, 
				Overtime payment USD{{ $wage->fot ?? $wage->ot ?? 0 }}):</td>
		</tr>

		<tr>
			<td colspan="10">{{ $wage->total }}USD</td>
		</tr>

		<tr>
			<td colspan="10">月合并工资（含基本工资、年休假工资、加班津贴）:          {{ $wage->total }}      美元</td>
		</tr>

		<tr>
			<td colspan="10">
				Extra merit assessing bonus(if any):
			</td>
		</tr>

		<tr>
			<td colspan="10">
				额外的效益考核奖（若有）
			</td>
		</tr>

		{{-- CONFIRMATION OF THE CONTRACT --}}
		<tr><td colspan="10" style="height: 25px;"></td></tr>
		<tr>
			<td style="{{ $b }}">CONFIRMATION OF THE CONTRACT</td>
		</tr>

		<tr>
			<td style="{{ $b }}">I, the seafarer of the below signature, have fully understood the terms and conditions of this contract</td>
		</tr>

		<tr>
			<td style="{{ $b }}">on date {{ now()->format('d/M/Y') }} (Standard terms and conditions of agreement hereunder attached).</td>
		</tr>

		<tr><td colspan="10"></td></tr>

		<tr>
			<td colspan="10">特此证明：各有关方于年月日在签署协议（随附协议的标准条款和条件）。</td>
		</tr>

		<tr><td colspan="10"></td></tr>

		<tr>
			<td colspan="6">Signature of the Ship owner (or master of the captioned vessel):</td>
			<td colspan="4">Signature of the Seafarer:</td>
		</tr>

		<tr>
			<td colspan="6">船东或（标题船船长）签字</td>
			<td colspan="4" style="height: 50px;">船员签字</td>
		</tr>
	</div>

	{{-- 3RD PAGE --}}
	<div>
		<tr>
			<td colspan="10"></td>
		</tr>
	</div>

	<tr>
		<td colspan="10" style="{{ $c }}">
			THE STANDARD TERMS AND CONDITIONS OF THE SEAFARER’S EMPLOYMENT AGREEMENT OF
		</td>
	</tr>

	<tr>
		<td colspan="10" style="{{ $bc }}">Safety Sailing Ship Management (Tianjin) Co., LTD</td>
	</tr>

	<tr>
		<td colspan="10" style="{{ $bc }}">稳航船舶管理（天津）有限公司海员就业协议标准条款和条件</td>
	</tr>

	{{ $d1("1. Definition of Terms 术语定义", true) }}
	{{ $d2("In this agreement, the concerned terms are defined as follows") }}
	{{ $d2("在此协议中，相关术语定义如下：") }}
	{{ $d1("1.1	Point of Hire--refers to the place indication the agreement of employment which shall be the basis for ") }}
	{{ $d2("determining commencement and termination of agreement.") }}
	{{ $d2("雇佣地--指就业协议列明的作为协议开始和终止的地点；") }}
	{{ $d1("1.2	Convenient Port--refers to any port where it is practicable, economical, safe and convenient to repatriate the ") }}
	{{ $d2("seafarer.") }}
	{{ $d2("方便港口--指一些具有可操作性、经济、安全和方便海员遣返的港口；") }}
	{{ $d1("1.3	Basic Wage--refers to the salary of the seafarer exclusive of overtime, leave pay and other bonuses.") }}
	{{ $d2("基本工资--指船员正常工作时间的报酬，不包括加班津贴、休假待金和其他奖金；") }}
	{{ $d1("1.4	Departure--refers to the actual departure from the point of hire of the seafarer through air, sea or land travel ") }}
	{{ $d2("transport to join his vessel.") }}
	{{ $d2("离开--指海员通过飞机、轮船及路上交通工具离开受雇地点前往上船；") }}
	{{ $d1("1.5	Working Hours--refers to Time during which seafarer’s are required to do work on account of the ship.") }}
	{{ $d2("工作时间—系指要求海员在船舶工作的时间；") }}
	{{ $d1("1.6	Shipwreck--refers to the damage or destruction of a vessel at sea caused by collision, storm, grounding or ") }}
	{{ $d2("any other marine peril at sea or in port rendering the vessel absolutely unavailable or unable to pursue her ") }}
	{{ $d2("voyage.") }}
	{{ $d2("船舶灭失--指船舶在海上或港内由于碰撞、恶劣天气、搁浅或其他海事造成损坏导致船舶本身完全不") }}
	{{ $d2("能航行或执行航次任务；") }}
	{{ $d1("1.7	Compassionate Ground--refers to incidence of death of an immediate member of the seafarer’s family which ") }}
	{{ $d2("includes his parents, spouse and children if the seafarer is married or his parents if the seafarer is single.") }}
	{{ $d2("值得同情的情况--指海员家属包括父母、配偶及子女因意外事故死亡的情况；") }}
	{{ $d1("1.8 “The Ship Owner”means the ship management company-Safety Sailing Ship Management (Tianjin) Co., LTD") }}
	{{ $d2("本协议船东指船舶管理公司“稳航船舶管理（天津）有限公司”.") }}

	<tr><td colspan="10"></td></tr>

	{{ $d1("2.	RESPONSIBILITIES 责任", true) }}
	{{ $d1("2.1	Responsibilities of the Ship owner/Master") }}
	{{ $d2("船东/船长的责任") }}
	{{ $d1("2.1.1	To faithfully comply with the stipulated terms and conditions of this agreement, particularly the prompt") }}
	{{ $d2("payment of wages, remittance of allotment and the expeditious settlement of valid claims of the") }}
	{{ $d2("seafarer") }}
	{{ $d2("完全遵守协议的条款和条件的规定，特别是海员工资和薪酬及各项索赔等的及时支付、汇寄；") }}
	{{ $d1("2.1.2	To make operational on board the vessel the grievance machinery provided in this agreement and") }}
	{{ $d2("ensure its free access at all times by the seafarer.") }}
	{{ $d2("确保在船上建立协议规定的船员投诉体系并保证船员在任何时候都能享有投诉权；") }}
	{{ $d1("2.1.3	To provide a seaworthy vessel for the seafarer and take all reasonable precautions to prevent accident ") }}
	{{ $d2("and injury to crew including provision of safety equipment, fire prevention, safe and proper navigation ") }}
	{{ $d2("of the vessel and such other precautions necessary to avoid accident, injury or sickness to seafarer.") }}
	{{ $d2("为海员提供适航船舶并采取合理的预防措施防止事故发生及海员受伤，包括安全设备条款、防") }}
	{{ $d2("火和船舶安全、正常驾驶以及其他必要的避免海员发生事故、受伤和疾病的预防措施；") }}
	{{ $d1("2.1.4	Ensure that a seafarer’s employment agreement shall continue to have effect while a seafarer is held ") }}
	{{ $d2("captive on or off the ship as a result of acts of piracy or armed robbery against ships, regardless of ") }}
	{{ $d2("whether the date fixed for its expiry has passed or either party has given notice to suspend or terminate ") }}
	{{ $d2("it.") }}
	{{ $d2("确保海员就业协议在由于海盗或者针对船舶的武装劫持等行为导致的海员被劫持期间的持续有") }}
	{{ $d2("效，不管这个海员就业协议是否已经到期或者任何一方申明暂停或者终止合同。") }}
	{{ $d1("2.2	Responsibilities of the Seafarer 海员的责任") }}
	{{ $d1("2.2.1	To faithfully comply with and observe the terms and conditions of this agreement") }}
	{{ $d2("诚实遵守该协议的条款和条件；") }}
	{{ $d1("2.2.2	To be obedient to the lawful commands of the Master or any person who shall lawfully succeed him ") }}
	{{ $d2("and to comply with company policy including safety policy and procedures and any instructions given ") }}
	{{ $d2("in connection therewith.") }}
	{{ $d2("服从船长及其接任者的合法指令，遵循公司方针，包括安全方针和程序以及与此相关的各项命") }}
	{{ $d2("令；") }}
	{{ $d1("2.2.3	To abide by the duty in flag state relevant regulations and the Code of Ethics for Seafarer.") }}
	{{ $d2("遵守船旗国相关法规及海员职业道德；") }}
	{{ $d1("2.2.4	To be diligent in his duties relating to the vessel and cargo, whether on board, in boats or shore，and") }}
	{{ $d2("对于本职工作恪尽职守，不论是船舶还是货物，也不论是在船、在艇还是在岸，以及") }}
	{{ $d1("2.2.5	To conduct himself in an orderly and respectful manner towards terminal operator, port authorities and ") }}
	{{ $d2("other persons on official business with the ship.") }}
	{{ $d2("对于船舶相关的岸方、当局和其他官方个人采取正当有礼有节的方式。") }}

	<tr><td colspan="10"></td></tr>

	{{ $d1("3.	BASIS ANDCOMMENCEMENT/DURATION OF AGREEMENT", true) }}
	{{ $d2("协议的依据和开始/期限", true) }}
	{{ $d1("3.1	The Seafarers’ Employment Agreement prepared according to the requirements of MLC2006 and relevant ") }}
	{{ $d2("laws of the Flag State本协议依照《2006海事劳工公约》和国家相关法律法规要求制订。") }}
	{{ $d1("3.2	The employment agreement between the ship owner and the seafarer shall commence upon actual ") }}
	{{ $d2("departure of the seafarer from the airport or seaport in the point of hire. It shall be effective until the ") }}
	{{ $d2("seafarer’s date of arrival at the point of hire upon termination of his employment pursuant to Provision 16 ") }}
	{{ $d2("of this Agreement.") }}
	{{ $d2("船东与海员的就业协议应该从海员实际离开雇佣地点的机场或港口起算，一直持续至海员抵达本协议") }}
	{{ $d2("第16条约定的终止地的日期；") }}
	{{ $d1("3.3	A seafarer shall be engaged for up to 8 months service on board a ship, and such period may be extended or ") }}
	{{ $d2("reduced by 1 months for operational convenience. After accruing 9 months continuous service, the seafarer shall ") }}
	{{ $d2("be entitled to a extra increment in his wage, and such extra increment shall not less than 10% of his basic wage.") }}
	{{ $d2("船员在船连续工作期限一般不超过8个月。因船舶停靠港口或者航行的航线不方便更换船员的，工") }}
	{{ $d2("作期限可适当提前或者延后1个月。船员在船工作满9个月后未能下船的视为逾期。船员在船超期") }}
	{{ $d2("服务的，船东应向船员支付额外的超期补贴。超期补贴额度不应低于船员基本工资的10%。") }}

	{{ $d1("4.	FREE PASSAGE FROM THE POINT OF HIRE TO THE PORT OF EMBARKATION", true) }}
	{{ $d2("从雇佣点登船港口的旅程安排", true) }}
	{{ $d2("The seafarer shall join the vessel or be available for duty at the date time specified by the ship owner. The ") }}
	{{ $d2("seafarer shall travel by air or as otherwise directed at the expense of the ship owner.") }}
	{{ $d2("海员登船或任职的日期时间由船东指定，船东必须负责海员由此乘飞机或其他交通工具的全部费用。") }}

	{{ $d1("5.	BAGGAGE ALLOWANCE", true) }}
	{{ $d2("行李托运费用", true) }}
	{{ $d2("The seafarer traveling by air to join a vessel or on repatriation shall be entitled to transport of the seafarer’s ") }}
	{{ $d2("personnel effects free of charge up to the amount allowed 30KG. The cost of the excess baggage shall be for ") }}
	{{ $d2("account of the seafarer") }}
	{{ $d2("海员在上船或遣返时乘坐飞机有权享受30公斤的个人免费行李托运额度，超出部分则由海员自己负") }}
	{{ $d2("责。") }}

	{{ $d1("6.	HYGIENE AND VACCINATION", true) }}
	{{ $d2("卫生与接种", true) }}
	{{ $d1("6.1	The seafarer shall keep his quarters and other living spaces-such as mess rooms, toilets, bathrooms,") }}
	{{ $d2("alleyways and recreation rooms in clean and tidy condition to the satisfaction of the master. ") }}
	{{ $d2("海员必须保持宿舍和其他生活场所，诸如餐厅、卫生间、浴室、走廊和娱乐室等令船长满意的干净整") }}
	{{ $d2("洁；") }}
	{{ $d1("6.2	The seafarer shall submit to the order of the master or to the laws of any country within the territorial ") }}
	{{ $d2("jurisdiction of which the vessel may enter to have such vaccination or inoculation or to undertake measures ") }}
	{{ $d2("safeguarding his health and of the whole crew.") }}
	{{ $d2("海员必须服从船长的指令或者船舶可能到达的管辖地国家的法律要求进行接种或采取措施保证其本") }}
	{{ $d2("人及全体船员的健康安全。") }}

	{{ $d1("7.	WAGES PAYMENT", true) }}
	{{ $d2("工资支付", true) }}
	{{ $d1("7.1	The seafarer shall be paid his monthly wages from the date of commencement of the agreement including ") }}
	{{ $d2("bank transfer or home allotments until the date of arrival at point of hire upon termination of his employment ") }}
	{{ $d2("pursuant to Provision 16 of this Agreement.") }}
	{{ $d2("海员月薪应在协议开始之日起每月发放，包括银行转账或家汇工资部分，直至根据第十六条规定协议") }}
	{{ $d2("终止。") }}
	{{ $d1("7.2	The monthly payment of wage for seafarer including basic wage，overtime payment, festival payment, annual ") }}
	{{ $d2("leave pay, leave subsistence.In normal condition, it shall be calculated monthly, which is not one whole ") }}
	{{ $d2("month shall be calculated as actual days basic 30 days per month.") }}
	{{ $d2("船员工资收入包括：基本工资、超时津贴、法定节假日津贴、年休假工资、超期补贴。正常情况下，") }}
	{{ $d2("海员工资按月计算，如不足一个月，则按实际天数以每月三十天的基准计算。") }}
	{{ $d1("7.3  Bonus for crew (including outstanding achieve bonus, grade bonus, etc ) shall be paid according to the ship’s ") }}
	{{ $d2("condition and crew working performance onboard and subject to be checked and verified by the company’s ") }}
	{{ $d2("relevant departments (stipulated by other regulation)") }}
	{{ $d2("船员的奖金（含离船考核奖、分等级考核奖等）根据船舶状况和船员在船工作表现，由公司相关部门") }}
	{{ $d2("考核后发放（另有规定）。") }}
	{{ $d1("7.4 The ship owner shall provide the seafarers with list of labor remuneration on a monthly basis, the list shall ") }}
	{{ $d2("include labor remuneration structure and deductions content. The two sides are free to agree the way to sign ") }}
	{{ $d2("the list. ") }}
	{{ $d2("船东应定期向船员提供月劳动报酬清单，该清单应包括劳动报酬结构和扣减内容。双方可自行约定清") }}
	{{ $d2("单签收方式。") }}
	{{ $d1("7.5 For the purpose of calculating wages, a calendar month shall be regarded as actual calendar days or 30 days ") }}
	{{ $d2("per month.") }}
	{{ $d2("每一日历月按30天计算作为计算工资和津贴的标准。") }}
	{{ $d1("7.6  Where a seafarer is held captive on or off the ship as a result of acts of piracy or armed robbery against ships,") }}
	{{ $d2("wages and other entitlements under the seafarers’ employment agreement, relevant collective bargaining ") }}
	{{ $d2("agreement or applicable national laws, including the remittance of any allotments as provided in paragraph ") }}
	{{ $d2("4 of Standard A2.2, shall continue to be paid during the entire period of captivity and until the seafarer is ") }}
	{{ $d2("released and duly repatriated in accordance with Standard A2.5.1 or, where the seafarer dies while in ") }}
	{{ $d2("captivity, until the date of death as determined in accordance with applicable national laws or regulations. ") }}
	{{ $d2("The terms piracy and armed robbery against ships shall have the same meaning as in Standard A2.1, ") }}
	{{ $d2("paragraph 7.") }}
	{{ $d2("一旦海员因海盗或者针对船舶的武装劫持等行为导致海员被俘在船或被劫持离船，其海员就业协议") }}
	{{ $d2("及其相关集体协议或适用的国内法中的工资和其他权利，包括依据标准A2.2第4 段所述的固定所有") }}
	{{ $d2("家庭汇款，在海员整个被劫持期间也应该持续地得到支付，直至海员依据标准A2.5.1 中被释放或者") }}
	{{ $d2("被适当的遣返。一旦海员在劫持期间死亡，该协议有效至适用国内法律法规所确定的死亡日期。该条") }}
	{{ $d2("款中的海盗和武装劫持船舶与规则A2.1第7 段的含义一致。") }}

	{{ $d1("8.	HOURS OF WORK AND REST 工作和休息时间", true) }}
	{{ $d1("8.1 The normal working hours shall be 44 (forty) per week. The normal hours of work shall be 8 (eight) hours ") }}
	{{ $d2("per day from Monday to Friday, Saturday 4 hours.") }}
	{{ $d2("船员在船每天工作8小时，每周工作44小时。正常工作时间星期一至五，每天8小时,周六4小时。") }}
	{{ $d1("8.2 The seafarer shall be allowed reasonable rest period in accordance with international standards as follows:") }}
	{{ $d2("海员应该按照国际标准享有如下合理的休息时间:") }}
	{{ $d1("8.2.1	Minimum hours of rest shall not be less than 10 hours in any 24-hour period, and 77 hours of rest in any ") }}
	{{ $d2("seven-day period.") }}
	{{ $d2("最短休息时间在任何24小时时段内不少于10小时，且在任何7天时间内不得少于77个小时。") }}
	{{ $d1("8.2.2	Such 10-hours of rest may be divided into no more than two periods, one of which shall be at least six ") }}
	{{ $d2("hours in length, and the interval between consecutive periods of rest shall not exceed 14 hours.") }}
	{{ $d2("10小时休息时间最多可分成两段，其中一段不得少于6小时，且相连两段休息时间的间隔不得超") }}
	{{ $d2("过14个小时。") }}
	{{ $d1("8.2.3   Under emergency or in other overriding operational conditions, provision 8.2.1and 8.2.2 can be ") }}
	{{ $d2("exempted. Musters, fire-fighting and lifeboat drills, and drills prescribed by national laws and ") }}
	{{ $d2("regulations and by international instruments shall be conducted in a manner that minimizes the ") }}
	{{ $d2("disturbance of rest periods and does not induce fatigue. ") }}
	{{ $d2("在紧急或其他超常工作情况下，8.2.1和8.2.2条款规定可以豁免，集合、消防和救生演习，以及") }}
	{{ $d2("国家法律与规则和国际文件规定的演习，应以对休息时间的干扰最小且不导致船员疲劳的形式") }}
	{{ $d2("进行。") }}
	{{ $d1("8.2.4	Breaks of less than an hour are not counted as break.") }}
	{{ $d2("小于一小时的休息时间不计入休息时间。") }}
	{{ $d1("8.2.5	The allocation of periods of responsibility on UMS Ships, where a continuous watch-keeping in ") }}
	{{ $d2("the engine room is not carried out, shall also be conducted in a manner that minimizes the disturbance ") }}
	{{ $d2("ofrest periods and does not induce fatigue and an adequate compensatory rest period shall be given if ") }}
	{{ $d2("the normal period of rest is disturbed by call-outs. ") }}
	{{ $d2("在海员处于待命的情况下，例如机舱处于无人看守时，如该海员因被召去工作而打扰了正常的") }}
	{{ $d2("休息时间，则应给予充分的补休。") }}
	{{ $d1("8.2.6	Nothing in this section shall be deemed to impair the right of the master of a ship to require a seafarer ") }}
	{{ $d2("to perform any hour of work necessary for the immediate safety of the ship, persons on board or cargo, ") }}
	{{ $d2("or for the purpose of giving assistance to other ships or persons in distress at sea. In such situation, the ") }}
	{{ $d2("master may suspend the schedule of hours of work or hours of rest and require a seafarer to perform ") }}
	{{ $d2("any hours of work necessary until the normal situation has been restored. As soon as practicable after ") }}
	{{ $d2("the normal situation has been restored, the master shall ensure that any seafarers who have performed ") }}
	{{ $d2("the work in a scheduled rest period are provide with an adequate period of rest. ") }}
	{{ $d2("本标准的任何规定并不妨碍船长因船舶、船上人员或货物出现紧急安全需要，或出于帮助海上遇") }}
	{{ $d2("险的其他船舶或人员的目的，而要求海员从事长时间工作的权利。为此，船长可中止工作时间或") }}
	{{ $d2("休息时间安排，要求一名海员从事任何时间的必要工作，直至情况恢复正常。一旦情况恢复正") }}
	{{ $d2("常，船长应尽快确保所有在计划安排的休息时间内从事工作的海员获得充足的休息时间。") }}
	{{ $d1("8.2.7	Records of seafarers daily hours of rest shall be maintained in a standard format, in the languages of ") }}
	{{ $d2("the ship and in English.") }}
	{{ $d2("船员每天休息时间应要求标准格式使用船上工作语言和英语进行记录。") }}
	
	<tr><td colspan="10"></td></tr>

	{{ $d1("9	OVERTIME AND HOLIDAYS加班和假日", true) }}
	{{ $d1("9.1  Any hours of duty in excess of normal working hours according to clause 8.1,any hours of duty on a holiday ") }}
	{{ $d2("as specified in Annex I, shall be paid for by overtime.") }}
	{{ $d2("第8.1款规定的正常工作时间以外的时间以及法定节假日（见附表I）工作都是加班时间。海员进行") }}
	{{ $d2("上述常规指定的工作时间以外的所有工作应获得补贴。") }}
	{{ $d1("9.2	Overtime work may be compensated at the following rates:") }}
	{{ $d2("超时津贴应按下列方式计费：") }}
	{{ $d1("9.2.1	Overtime payment-not less than 150 percent (150%) of the hourly basic wage.") }}
	{{ $d2("超时津贴-不少于基本时薪的150%") }}
	{{ $d1("9.2.2	Overtime payment for holiday--not less than 300 percent (300%) of the basic wage。") }}
	{{ $d2("节假日加班费-不少于基本工资的300%。") }}
	{{ $d1("9.2.3	Monthly overtime allowance payable for masters and his crew is 103 hours minimum，as well as ") }}
	{{ $d2("guaranteed overtime 103 hours payable for masters and his crew.") }}
	{{ $d2("船长和船员每月加班津贴保证按照不低于103小时的加班时间支付。") }}
	{{ $d1("9.3	Overtime shall be recorded individually and in duplicate either by the master or the head of the ") }}
	{{ $d2("department, such record shall be handed to the seafarer for approval every month or at shorter intervals. ") }}
	{{ $d2("所有加班时间应由船长或部门长进行记录，并至少按照每月的间隔或更短的时间由海员签字。") }}
	{{ $d1("9.4	Emergency duty-No overtime work shall be considered for any work performed in case of emergency ") }}
	{{ $d2("affecting the safety of the vessel, crew or cargo, or which the master shall be the sole judge, or for fire, ") }}
	{{ $d2("boat, or emergency drill or work required to give assistance to other vessels or persons in immediate ") }}
	{{ $d2("peril. As soon as practicable after the normal situation has been restored, the master shall ensure that ") }}
	{{ $d2("any seafarers who have performed the work in a scheduled rest period are provide with an adequate ") }}
	{{ $d2("period of rest. ") }}
	{{ $d2("紧急责任-如果因影响船舶船员、货物安全或船长认为的各种紧急情况，或者是消防、救生、或者是") }}
	{{ $d2("所有加班时间应由船长或部门长进行记录，并至少按照每月的间隔或更短的时间由海员签字。") }}
	{{ $d2("应急演习，或者是因海事为协助他船或个人造成的工作需要，以上各种作业均不列入加班范围。但") }}
	{{ $d2("一旦情况恢复正常，船长应尽快确保所有在计划安排的休息时间内从事工作的海员获得充足的休息") }}
	{{ $d2("时间。") }}
	{{ $d1("9.5	For the purpose of this agreement the days listed in annex I shall be considered as holiday totally twelve ") }}
	{{ $d2("days at sea or at port. If a holiday falls on Saturday or Sunday, the following working day shall be observed ") }}
	{{ $d2("as a holiday.") }}
	{{ $d1("附件I为法定节假日，共计11天，如果法定节假日为周六、周日休息时间，则下一个相应的工作日") }}
	{{ $d2("为节假日时间。") }}
	{{ $d1("10	ANNUAL LEAVE PAY 年休假工资", true) }}
	{{ $d1("10.1 The seafarer’s annual leave pay shall be in accordance with a number of days leave per month as agreed upon. ") }}
	{{ $d2("Days leave shall not be less than 2.5 days for each month of service on board and pro-rated. Annual leave pay ") }}
	{{ $d2("shall be settled monthly.") }}
	{{ $d1("海员的年休假工资应依照协议每服务一个月享有一定的天数，该天数应以不少于每服务一个月2.5天") }}
	{{ $d2("的比率分配。年休假工资应逐月支付。") }}
	{{ $d1("10.2 Calculation of annual leave pay:") }}
	{{ $d2("带薪年休假工资计算方法：") }}
	{{ $d2("Days of annual leave = 5 x (days of continuous working on board ÷ 60)") }}
	{{ $d1("带薪年休假天数 = 5 x (连续在船舶上工作天数 ÷ 60)") }}
	{{ $d2("Annual leave pay =monthly basic wages of the continuous working period on board ÷ 30X days of annual leave pay.") }}
	{{ $d2("年休假工资 = 连续在船工作期间月岗位工资标准 ÷ 30 X 带薪年休假天数。") }}
	
	{{ $d1("11 SOCIAL PROTECTION /MEDICAL CARE ", true) }}
	{{ $d1("社会保障/医疗", true) }}
	{{ $d1("11.1	The ship owner or the employer shall participate in old age insurance, medical care insurance, work injury ") }}
	{{ $d2("insurance, unemployment insurance, housing fund as well as other social insurance in accordance with the ") }}
	{{ $d2("relevant provisions of the State, and shall pay premiums on time and in full.") }}
	{{ $d2("船东或船员用人单位应当按照国家法律法规的规定为其招募的船员办理养老保险、医疗保险、工伤") }}
	{{ $d2("保险、失业保险、和住房公积金等社会保险，以及双方约定的其他商业保险，并按时足额缴纳其应") }}
	{{ $d2("该缴纳的各项费用。") }}
	{{ $d1("11.2	The premiums of the seafarer’s portion in respect of his social insurance shall be paid by the seafarer himself, ") }}
	{{ $d2("or withheld or paid by the ship owner or the employer each month in accordance with the relevant ") }}
	{{ $d2("provisions of the State, the details of premiums pay are varied every year.") }}
	{{ $d2("船员个人应当缴纳的社会保险费，由船东或船员用人单位按照法律法规的规定每月从其本人工资中代") }}
	{{ $d2("扣代缴。具体扣缴比例每年根据国家的政策变化。") }}
	{{ $d1("11.3	Social protection, including the ship owner or the employer contributions and statutory deduction from ") }}
	{{ $d2("seafarer’s wages, shall be timely transferred to the account specified by government department every ") }}
	{{ $d2("month. -") }}
	{{ $d2("船东或船员用人单位每月将为船员缴纳的以及从船员本人工资中扣缴的社会保险费用计算通过银行") }}
	{{ $d2("汇入政府相关部门指定的账户。") }}
	{{ $d1("11.4	Seafarers can log on related government website or visit the government department to consult the ") }}
	{{ $d2("contribution status of the old-age insurance, medical care insurance and housing fund etc.") }}
	{{ $d2("船员本人可登陆政府相关部门网站或持本人有效身份证件到政府相关部门，查看本人养老、医疗和住") }}
	{{ $d2("房公积金等社会保险缴纳情况。") }}
	{{ $d1("11.5	Related social security information from the government shall be timely circulated to the ships via e-mail, so ") }}
	{{ $d2("that the seafarers can obtain the information timely.") }}
	{{ $d2("船东或船员用人单位及时将政府有关部门关于船员缴纳社会保险的有关信息，通过电邮发至船舶，以") }}
	{{ $d2("便船员及时了解。") }}
	{{ $d1("11.6 The employer ensure that seafarers working on board have prompt access to the necessary medicine, medical") }}
	{{ $d2("equipments and facilities for diagnosis and treatment, and to medical and occupational health protection") }}
	{{ $d2("information and expertise which is generally comparable to that provided to workers ashore.") }}
	{{ $d2("公司保证在船上工作的海员能快速获得必要的药品、医疗器材和设备的诊断和治疗，以及岸上提供相") }}
	{{ $d2("关的医疗和职业健康的防护信息和专业知识。") }}

	{{ $d1("12	VICTUALLING, VESSEL STORES AND PROVISIONS", true) }}
	{{ $d2("伙食、备品及供给", true) }}
	{{ $d1("12.1	The seafarer shall be provided by the master/ship owner with subsistence consistence with good maritime ") }}
	{{ $d2("standards Practices while on board the vessel.") }}
	{{ $d2("船长/船东应在船上根据良好的航海标准和惯例为海员提供生活物资。") }}
	{{ $d1("12.2	All stores and provisions issued to the seafarer are only for use and consumption on board the vessel and ") }}
	{{ $d2("any unused or unconsumed stores or provisions shall remain the property of the ship owner. The seafarer ") }}
	{{ $d2("shall not take ashore, sell, destroy or give away such stores and provisions. Seafarer should not allow to ask ") }}
	{{ $d2("for sharing of any balance of the food allowance. ") }}
	{{ $d2("所有为海员准备的备品和伙食，应该只供海员在船使用和消耗，未能使用或消耗的备品和伙食应作为") }}
	{{ $d2("船东财物留船，海员不能带上岸、出售、毁坏或拿走这些物品。海员不能分发伙食费。") }}

	{{ $d1("13	TRANSFER CLAUSE 转船条款", true) }}
	{{ $d2("The seafarer agrees to be transferred at any port to any vessel owned or operated, manned or managed by ") }}
	{{ $d2("the same ship owner, provided it is accredited to the same manning agent and provided further that the") }}
	{{ $d2("position of the seafarer and the rate of his wages and terms of service are in no way inferior and the total ") }}
	{{ $d2("period of employment shall not exceed that originally agreed upon.") }}
	{{ $d2("Any form of transfer shall be documented and made available when necessary.") }}
	{{ $d2("海员应该同意在任何港口转船至同一船东所属、操作、配员或管理的其他船舶，整个转船操作，海员") }}
	{{ $d2("的职务和工资待遇及服务条款均不能比原来更差，累计服务期也不应超过原协议的规定。必要时，转") }}
	{{ $d2("船形式将被记录在案。") }}

	{{ $d1("14	GRIEVANCE MACHINERY 投诉体系", true) }}
	{{ $d1("14.1 If the seafarer considers himself aggrieved, he shall make his complaint in accordance with the following ") }}
	{{ $d2("Procedures:") }}
	{{ $d2("如果海员感觉得自己受了委屈，他可以通过如下程序进行投诉：") }}
	{{ $d1("14.1.1	The seafarer shall first approach the head of the Department in which he is assigned to explain his ") }}
	{{ $d2("grievance.") }}
	{{ $d2("海员首先应该通过部门长进行投诉。") }}
	{{ $d1("14.1.1.1	 In the Deck and Catering Department, the head is the Chief mate.") }}
	{{ $d2("甲板部和业务部通过大副投诉。") }}
	{{ $d1("14.1.1.2	In the Engine Department, the head is Chief Engineer.") }}
	{{ $d2("轮机部通过轮机长投诉。") }}
	{{ $d1("14.1.2	The seafarer shall make his grievance in writing and in an orderly manner and shall choose a time when ") }}
	{{ $d2("his complaint or grievance can be properly heard.") }}
	{{ $d2("海员应该以书面形式通过正当的手段，选择合适时间令其投诉得以受理。") }}
	{{ $d1("14.1.3	The Department head shall deal with the complaint or grievance and where solution is not possible at his ") }}
	{{ $d2("level, refer the complaint or grievance to the Master who shall handle the case personally.") }}
	{{ $d2("部门长必须处理下属提出的投诉，如果这些投诉超出他的职权范围，应当提交到船长处，让船长亲") }}
	{{ $d2("自受理。") }}
	{{ $d1("14.1.4	If no satisfactory result is achieved, the seafarer concerned may appeal to the management of the ") }}
	{{ $d2("company (trade unions) or with lawsuit external authority. The master shall afford such facilities necessary ") }}
	{{ $d2("to enable the seafarer to transmit his appeal.") }}
	{{ $d2("如果海员对船上的处理不满意，可以请求将投诉提交公司相关管理部门(公司工会)或其他外部主管") }}
	{{ $d2("机关，船长应提供必要的方便让海员的请求得以提交。") }}
	{{ $d1("14.2	 The grievance procedure and all actions or decisions agreed upon shall be properly documented for the ") }}
	{{ $d2("protection and interest of both parties.") }}
	{{ $d2("投诉的程序和行为或结果一旦达成一致，双方应当正确记录在案以利彼此。") }}
	{{ $d1("14.3	 The foregoing procedures shall be without prejudice to other modes of voluntary settlement of disputes and ") }}
	{{ $d2("to the    jurisdiction of relevant Law over any unresolved complaints arising out of shipboard employment ") }}
	{{ $d2("that shall be brought before it by the seafarer.") }}
	{{ $d2("对于海员在船服务期间所发生的未解决的投诉事宜，前述程序并不妨碍船员就此事项进行自愿性调解") }}
	{{ $d2("或诉诸相关法律进行解决。") }}

	{{ $d1("15	DISCIPLINARY PROCEDURES 处罚程序", true) }}
	{{ $d1("15.1	The Master shall furnish the seafarer with a written notice containing the following:") }}
	{{ $d2("船长应该提供包括如下内容的书面通知给海员：") }}
	{{ $d1("15.2 The Master or his authorized representative shall conduct the investigation or hearing, giving the seafarer the ") }}
	{{ $d2("and entered to the ship’s logbook.") }}
	{{ $d2("船长应该提供包括如下内容的书面通知给海员：") }}
	{{ $d2("船长或授权代表应进行调查或审理，给海员一个自我辩解的机会，这些程序必须记录在案并填入船舶") }}
	{{ $d2("日志。") }}
	{{ $d1("15.3 If after the investigation or hearing, the master is convinced that imposition of a penalty is justified，the ") }}
	{{ $d2("Master shall issue a written notice of penalty and the reasons for it to the seafarer, with copies furnished to ") }}
	{{ $d2("the manning Agent.") }}
	{{ $d2("经调查或审理，如果需要进行罚款处罚，船长应以书面通知海员罚款和理由，同时抄送海员管理公司。") }}
	{{ $d1("15.4 Dismissal for just cause may be effected by the master without furnishing the seafarer with a notice of ") }}
	{{ $d2("dismissal if there is a clear and existing danger to the safety of the crew or the vessel. The master ") }}
	{{ $d2("shall send a complete report to the manning agency substantiated by witnesses, testimonies and any other ") }}
	{{ $d2("document in support thereof.") }}
	{{ $d2("船长可以以合理理由解雇海员，如果这种做法显然对其他海员和本船存在危险，则无需给当事海员") }}
	{{ $d2("发解雇通知书。但船长必须给海员管理公司发一份有证人证明的完整报告，并随附相关证据和文件") }}
	{{ $d2("说明。") }}

	<tr><td colspan="10"></td></tr>

	{{ $d1("16	TERMINATION OF EMPLOYMENT 协议终止", true) }}
	{{ $d1("16.1 The employment of the seafarer shall be terminated when the seafarer completes his service period of ") }}
	{{ $d2("agreement aboard the vessel, signs-off from vessel and arrives at the place of repatriation (refer to provision ") }}
	{{ $d2("17.1).") }}
	{{ $d2("当船员完成其协议列明的在船服务期时，协议即告终止，海员离船回到遣返地点（参照17.1条款）。") }}
	{{ $d1("16.2	The employment of the seafarer is also terminated when the seafarer arrives at the place of repatriation for ") }}
	{{ $d2("any of the following reasons:") }}
	{{ $d2("当海员由于下列原因回到遣返地时，海员就业协议同样终止；") }}
	{{ $d1("16.2.1 When the seafarer signs-off and is disembarked for medical reasons pursuant to provision 18.2.4 of this ") }}
	{{ $d2("Agreement.") }}
	{{ $d2("海员因健康原因按照该协议第十八条二款4项规定休假离船；") }}
	{{ $d1("16.2.2 When the seafarer signs-off due to shipwreck, ship’s scale, lay-up of vessel, discontinuance of voyage, un-") }}
	{{ $d2("seaworthiness, regulation 1/4, control procedure of the 1978 STCW CONVENTION,AS AMENDMED or ") }}
	{{ $d2("change of vessel principal in accordance with provision 20,21,22,23,24,and 25 of this Agreement.") }}
	{{ $d2("根据协议第二十条、第二十一条、二十二条、二十三条、二十四条和二十五条规定，海员因船舶灭") }}
	{{ $d2("失、改造、不能继续其航次任务、不适航、公约修正案的控制程序1/4规则或改变船舶所有人等休") }}
	{{ $d2("假离船，协议终止；") }}
	{{ $d1("16.2.3 When the seafarer，in writing, voluntarily resigns and signs off prior to expiration of agreement pursuant ") }}
	{{ $d2("to provision 17.7 of this Agreement. ") }}
	{{ $d2("根据协议第十七条七款规定，海员在协议服务期满前书面提出辞职和休假；") }}
	{{ $d1("16.2.4. When the seafareris discharged for just cause as provided for in provision 15.4 of this Agreement.") }}
	{{ $d2("海员因协议第十五条四款被解雇；") }}
	{{ $d1("16.3  Minimum notice period to be given by the seafarers and ship owner for the early termination of agreement ") }}
	{{ $d2("shall not be less than 15 days expect for compassionate or other urgent reasons.") }}
	{{ $d2("海员和船东提前终止协议的最短通知期限为不得少于15天，除非有值得同情的原因或其他紧急原因；") }}

	{{ $d1("17	REPATRIATION 遣返", true) }}
	{{ $d1("17.1 A seafarer may choose the place of repatriation from among the following places:") }}
	{{ $d2("船员可以从下列地点中选择遣返地点:") }}
	{{ $d1("17.1.1	The place where he is recruited or he first assumes his post on board;") }}
	{{ $d2("船员接受招用的地点或者上船任职的地点；") }}
	{{ $d1("17.1.2	The place of residence or registered permanent residence of the seafarer, or the vessel’s registry;") }}
	{{ $d2("船员的居住地、户籍所在地或者船籍登记国；") }}
	{{ $d1("17.1.3 The place agreed upon by the seafarer and the ship owner.") }}
	{{ $d2("船员与船东约定的地点。") }}
	{{ $d1("17.2 If the vessel is outside of China upon the expiration of the agreement, the seafarer shall continue his service ") }}
	{{ $d2("on board until the vessel’s arrival at a convenient port/or after arrival of the replacement crew provided that. ") }}
	{{ $d2("The seafarer shall be entitled to earned wages and benefits as provided in his agreement.") }}
	{{ $d2("如果船舶在中国以外港口协议期满，海员应该继续在船服务直到抵达方便港口/或能提供接班人员的") }}
	{{ $d2("地方，而且海员有权获得协议规定的超期服务奖金；") }}
	{{ $d1("17.3 If the vessel arrives at a convenient port before the expiration of the agreement, the master/ship owner may ") }}
	{{ $d2("repatriate the seafarer from such port, provided the un-served portion of this within mutual agreed option ") }}
	{{ $d2("range, The seafarer shall be entitled only to his earned wages and earned leave pay.") }}
	{{ $d2("如果船舶在协议期满之前抵达方便港口，船长/船东可以通过协商在这些地方遣返海员，海员有权利") }}
	{{ $d2("获得其相应的工资及休假待金。") }}
	{{ $d1("17.4 When the seafarer is discharged to be in serious default of the seafarer’s employment obligations, the ship ") }}
	{{ $d2("owner shall have the right to recover the costs of his replacement and repatriation from the seafarer’s wages ") }}
	{{ $d2("and other earnings.") }}
	{{ $d2("当海员因严重失职被解雇时，船东有权从海员的工资和其他报酬中追回因换员和遣返产生的费用。") }}
	{{ $d1("17.5 The seafarer, when discharged and repatriated as directed by the ship owner/master/agency shall be entitled to ") }}
	{{ $d2("basic wages from date of signing off until arrival at the point of hire except the discharge is in accordance with ") }}
	{{ $d2("the reasons provided for in paragraph 17.4 .") }}
	{{ $d2("海员因船东/船长/管理公司原因被遣返，有权利获得从休假到抵达雇佣地期间的基本工资，除非这种") }}
	{{ $d2("遣返属于17.4款规定的原因；") }}
	{{ $d1("17.6 If the seafarer delays or desires a detour and/or another destination other than the most direct to the point ") }}
	{{ $d2("of hire, all additional expense shall be to the seafarer’s account, The seafarer’s basic wage shall be calculated ") }}
	{{ $d2("based on the date of arrival by the most direct route.") }}
	{{ $d2("如果海员延误或试图绕道回雇佣地，该绕道产生的额外费用由船员自付，旅途薪金也按照最短距离和") }}
	{{ $d2("时间相应扣除。") }}
	{{ $d1("17.7 A seafarer normally shall not be signed off until the service period ended, if a seafarer who requests for early ") }}
	{{ $d2("termination of his agreement in reason and approved by the ship owner, ship owner shall be liable for his ") }}
	{{ $d2("repatriation cost as well as the transportation cost of his replacement. Expect the seafarer is fired in ") }}
	{{ $d2("accordance with provision 15.4 of this agreement.") }}
	{{ $d2("服务期未满，船员不得中途离船。海员如果有充分的理由并经船东批准可以提前终止协议，船东应该") }}
	{{ $d2("负担包括接替者的交通费用在内的相关遣返费用，除非海员依协议第十五条四款规定因违纪被解雇。") }}
	{{ $d1("17.8 The company shall provide a financial security to assistance to seafarers when abandoned as per required by ") }}
	{{ $d2("the regulation 2.5(Repatriation) of the amendments of 2014 to the MLC2006.") }}
	{{ $d2("公司按MLC2006 2014修正案的要求为被遗弃船员遣返提供遣返相关的财务担保。") }}

	{{ $d1("18. COMPENSATION AND BENEFITS 赔偿和保险", true) }}
	{{ $d1("18.1	COMPENSATION AND BENEFITS FOR DEATH") }}
	{{ $d2("死亡赔偿") }}
	{{ $d1("18.1.1.In case of work-related death of the seafarer, during the term of his agreement, the ship owner shall pay ") }}
	{{ $d2("this beneficiaries as per laws of PRC") }}
	{{ $d2("如果海员在协议期内死亡，船东应根据中国法律规定的补偿标准支付赔偿金给他的继承人；") }}
	{{ $d1("18.1.2 It is understood and agree that the benefits mentioned above shall be separated and distinct form, and will ") }}
	{{ $d2("be in addition to whatever benefits which the seafarer is entitled to under People’s Republic of China laws ") }}
	{{ $d2("form, if applicable.") }}
	{{ $d2("该项赔付，与上述补贴相区分的，应该还有根据中国法律规定的其他额外补助；") }}
	{{ $d1("18.1.3 The other liabilities of the ship owner when the seafarer dies as a result of work related injury or illness ") }}
	{{ $d2("during the term of employment are as follows:") }}
	{{ $d2("海员在协议条款之内由于工作因伤、因病发生死亡的，船东还应有如下责任：") }}
	{{ $d1("18.1.3.1 The ship owner shall pay the deceased’s beneficiary all outstanding obligations due to the seafarer under ") }}
	{{ $d2("this agreement.") }}
	{{ $d2("船东应支付协议期内死者的债务余额给其收益人；") }}
	{{ $d1("18.1.3.2 The ship owner shall transport the remains and personal effects of the seafarer to be the China at ship ") }}
	{{ $d2("owner’s expense except if the death in a port where local government laws or regulations do not permit ") }}
	{{ $d2("the transport of such remains. In case death occurs at sea, the disposition of the remains shall be handled ") }}
	{{ $d2("or dealt with in accordance with the master’s best judgment. In all case, the ship owner/master shall ") }}
	{{ $d2("communicate with the manning agency to advise for disposition of seafarer’s remains.") }}
	{{ $d2("船东应负责把死者遗体和遗物寄回国内并支付相关费用，除非海员死亡地国家法律不允许。如果") }}
	{{ $d2("死亡发生在海上，遗体和遗物的处理由船长决定，但无论如何，船东和船长应联系船员管理公司") }}
	{{ $d2("征求处理意见。") }}
	{{ $d1("18.2. COMPENSATION AND BENEFITS FOR INJURY OR ILLNESS") }}
	{{ $d2("伤病赔偿") }}
	{{ $d2("The liabilities of the ship owner when the seafarer suffers work-related injury or illness during the term of ") }}
	{{ $d2("his agreement are as follows:") }}
	{{ $d2("海员在协议期内由于工作发生伤病，船东有如下责任：") }}
	{{ $d1("18.2.1.The ship owner shall continue to pay the seafarer his wages during the time he is on board vessel.") }}
	{{ $d2("海员在船期间，船东应继续支付其全额工资；") }}
	{{ $d1("18.2.2 If the injury or illness requires medical and/or dental treatment in a foreign port, the ship owner shall be ") }}
	{{ $d2("liable for the full cost of such medical, serious dental, surgical and hospital treatment as well as board and ") }}
	{{ $d2("lodging until the seafarer is declared fit to work or to be repatriated.") }}
	{{ $d2("如果需要在国外港口进行伤病治疗，船东要支付全部医疗费用及其他包括食住在内的相关开支，直") }}
	{{ $d2("至伤好病愈还船工作或遣返回家；") }}
	{{ $d2("However, if after repatriation, the seafarer will requires medical attention arising from said injury or illness,") }}
	{{ $d2("he shall be so provided at cost at cost to the ship owner until such time he is declared fit or the degree of ") }}
	{{ $d2("his disability has been established by the company-designated physician/hospital.") }}
	{{ $d2("而且，遣返后的后续跟进治疗费用，船东要给以提供直至伤病愈合或由指定机构进行残疾等级评定") }}
	{{ $d2("为止。") }}
	{{ $d1("18.2.3 Upon sign-off from the vessel for medical treatment, the seafarer is entitled to sickness allowance ") }}
	{{ $d2("equivalent to his basic wage until he is declared fit to work or the degree of permanent disability has been ") }}
	{{ $d2("assessed by a company-designated physician/hospital but in no case shall this exceed one hundred eighty ") }}
	{{ $d2("(180) days. For this purpose, the seafarer shall submit himself t a post-employment medical examination ") }}
	{{ $d2("by a company-designated physician/hospital in time upon his return except when he is physically ") }}
	{{ $d2("incapacitated to do so, in which case, a written notice to the agency within the same period is deemed as ") }}
	{{ $d2("compliance. Failure of the seafarer to comply with the mandatory reporting requirement shall result in his ") }}
	{{ $d2("forfeiture of the right to claim the above benefits.") }}
	{{ $d2("海员休假后回家治疗，有权享受等同于基薪的伤病补贴直至痊愈适合工作或由指定的评残机构评定") }}
	{{ $d2("其残疾等级为止，但这个期限不超过180天。为此，海员必须提供由指定的医疗机构出具的检查证") }}
	{{ $d2("明，除非他由于身体原因无法完成该项工作，在同期限内以书面形式通知船员管理公司也被认为等") }}
	{{ $d2("同证明。如果海员没有按照这一报告要求行事，将丧失享有上述补助的权利。") }}
	{{ $d1("18.2.4 Upon sign-off the seafarer from the vessel for medical treatment, the ship owner shall bear the full cost of ") }}
	{{ $d2("repatriation in the event the seafarer is declared (1) fit for repatriation; or (2) fit to work but the ship owner ") }}
	{{ $d2("is unable to find employment for the seafarer on board his former vessel or the ship owner despite earnest ") }}
	{{ $d2("efforts.") }}
	{{ $d2("海员因病（1）符合遣返条件离船治疗的，（2）虽适合工作，但因船东原因无法提供服务船舶，而离") }}
	{{ $d2("船治疗的，船东均应承担全部遣返费用；") }}
	{{ $d1("18.2.5 In case of permanent total or partial disability of the seafarer caused by either injury or illness the seafarer ") }}
	{{ $d2("shall be compensated in accordance with the schedule of benefits enumerated in the provisions of the ") }}
	{{ $d2("Labor Contract or related laws and regulations . Computation of this benefits arising from an illness shall ") }}
	{{ $d2("be governed by the rates and the rules of compensation applicable at the time the illness or disease was ") }}
	{{ $d2("agreement.") }}
	{{ $d2("如海员因工受伤或得病导致致残，按照相关法律法规的规定和船员劳动合同的约定条款支付赔偿。") }}
	{{ $d2("计算赔偿的额度应该以签署时的规定和条款为依据。") }}
	{{ $d1("18.3	No compensation and benefits shall be payable in respect of any injury, incapacity or death of the seafarer ") }}
	{{ $d2("resulting from his willful or criminal act or intentional breach, of his duties, provided however, that the ship ") }}
	{{ $d2("owner can prove that such injury, incapacity, disability or death is directly attributable to the seafarer.") }}
	{{ $d2("如果船东能够证明海员的伤、病、残、亡是缘于海员本身的故意行为、犯罪行为或违反国际惯例行") }}
	{{ $d2("为所造成的，将不负责所有赔偿；") }} 
	{{ $d1("18.4  A seafarer who knowingly conceals and does not disclose past medical condition, disability and history in ") }}
	{{ $d2("the pre-employment medical examination constitutes fraudulent misrepresentation and shall disqualify ") }}
	{{ $d2("him from any compensation and benefits. This may be a valid ground for termination of employment and ") }}
	{{ $d2("imposition of the appropriate administrative and legal sanctions.") }}
	{{ $d2("海员故意隐瞒过往病史和以前的健康检查证明构成虚报、欺骗，将被终止协议并诉诸法律；") }} 
	{{ $d1("18.5 When requested, the principal shall be furnish the seafarer a copy all pertinent medical reports or any records ") }}
	{{ $d2("at no cost to the seafarer.") }}
	{{ $d2("如有要求，委托人（船东）应为海员免费提供一份中肯恰当的体检报告或相关记录；") }}
	{{ $d1("18.6 The seafarer or his successor in interest acknowledges that payment for injury, illness, incapacity or death of ") }}
	{{ $d2("the seafarer under this agreement shall cover all claims arising from or in relation with or in the course of ") }}
	{{ $d2("the seafarer’s employment, including but not limited to damage arising from the agreement, tort, fault or ") }}
	{{ $d2("negligence under the laws of the People’s Republic of China or any other country.") }}
	{{ $d2("海员或其受益人明了协议上有关海员伤病残亡的赔付应覆盖海员协议的所有条款，包括但不限于在") }}
	{{ $d2("中国或其他国家法律下协议造成的损坏、民事责任、过失或疏忽。") }}

	<tr><td colspan="10"></td></tr>

	{{ $d1("19 TRADING AREA服务航区", true) }}
	{{ $d1("19.1 Seafarer acknowledges that the vessel may trade worldwide at ship owner sole discretion.") }}
	{{ $d2("海员明确船舶可以根据船东意图环球航行；") }}
	{{ $d1("19.2 If the vessel sails to a war prone area, the ship owner shall inform seafarer and manning agent in advance and ") }}
	{{ $d2("ensure seafarer, manning agent agree on that.") }}
	{{ $d2("如果船舶航行至战区或疑是战区，船东应提前通知海员本人和船员管理公司以征得其同意，并且") }}
	{{ $d1("19.3 A war bonus, if any, will be paid to seafarer directly by the ship owner according to international regulations.") }}
	{{ $d2("由船东按国际上相关规定直接支付战争特殊津贴给海员。") }}

	<tr><td colspan="10"></td></tr>

	{{ $d1("20	TERMINATION DUE TO SHIPWRECK 因船舶灭失终止条款", true) }}
	{{ $d2("Where the vessel is wrecked necessitating the termination of employment before the date indicated in the ") }}
	{{ $d2("agreement, the seafarer shall be entitled to earned wages, medical examination at ship owner’s expense to ") }}
	{{ $d2("determine his fitness to work, repatriation at ship owner’s cost and one month basic wage as termination pay.") }}
	{{ $d2("当船舶灭失导致协议提前终止，海员有权利获得一个月基薪的额外遣送费和所赚工资及由船东支付体") }}
	{{ $d2("检及遣返费用。") }}

	{{ $d1("21	TERMINATION DUE TO VESSEL SALE LAY-UP OR DISCONTINUE OF VOYAGE", true) }}
	{{ $d2("因船舶买卖、航次停止或不能继续航行等终止条款", true) }}
	{{ $d2("When the vessel is sold, laid-up, or the voyage is discontinued necessitating the termination of employment ") }}
	{{ $d2("before the date indicated in the Agreement, the seafarer shall be entitled to earned wages, repatriation at ") }}
	{{ $d2("ship owner’s cost and one (1) month basic wage as termination pay, unless arrangements have been made ") }}
	{{ $d2("for the seafarer to join another vessel belonging to the same principal to complete his agreement in which ") }}
	{{ $d2("case the seafarer shall be entitled to basic wage until the date of joining the other vessel.") }}

	<tr><td colspan="10"></td></tr>

	{{ $d1("22	TERMINATION DUE TO UNSEAWORTHINESS 因不适航终止条款服务航区", true) }}
	{{ $d1("22.1 If the vessel is declared un-seaworthy by port state or flag state, the seafarer shall not be forced to sail with ", true) }}
	{{ $d2("the vessel.", true) }}
	{{ $d2("如果船舶被港口国或船旗国宣布为不适航，海员不能被强迫开航。.", true) }}
	{{ $d1("22.2 If the vessel’s un-seaworthy necessitate the termination of employment before the date indicated in the ") }}
	{{ $d2("Agreement, the seafarer shall be entitled to earned wages, repatriation at cost to the ship owner and .") }}
	{{ $d2("如果船舶被港口国或船旗国宣布为不适航，海员不能被强迫开航。.") }}
	{{ $d2("费由船东承担。") }}

	{{ $d1("23 TERMINATION DUETO REGULATION 1/4， CONTROL PROCEDURES OF THE 1978 STCW CONVENTION, AS ", true) }}
	{{ $d2("AMENDED", true) }}
	{{ $d2("因1978STCW公约修正案的控制程序1/4 规则终止条款", true) }}
	{{ $d2("If seafarer terminated repatriated as a result of port state control procedures/actions in compliance with ") }}
	{{ $d2("Regulation 1/4 of the 1978 STCW Convention, As Amended, his termination shall be considered valid, However, ") }}
	{{ $d2("he shall be entitled to repatriation, earned wages and other benefits.") }}
	{{ $d2("如果海员因按照1978STCW公约修正案的控制程序1/4规则而遣返，这种终止应该属于正常有效的，但") }}
	{{ $d2("海员仍有权获得所赚工资和其他待遇以及遣返费用由船东承担。") }}

	<tr><td colspan="10"></td></tr>

	{{ $d1("24	CHANGE OF SHIPOWNER 更换船舶所有人", true) }}
	{{ $d1("24.1 Where there is a change of ship owner of the vessel necessitating the termination of employment of the ") }}
	{{ $d2("seafarer before the date indicated the Agreement, the seafarer shall be entitled to earned wage , repatriation ") }}
	{{ $d2("at ship owner’s expense and one month basic pay as termination pay.") }}
	{{ $d2("当船舶所有人更换导致协议提前终止，海员有权获得所赚工资和一个月基本工资的合同终止补偿费及") }}
	{{ $d2("遣送费由船东承担。") }}
	{{ $d1("24.2 If by mutual agreement, the seafarer continues his service on board the same vessel, such service shall be ") }}
	{{ $d2("treated as a new agreement, The seafarer shall be entitled to earned wage only.") }}
	{{ $d2("如果经协商，海员继续在船服务，将被视为一个新协议的开始，海员也只能获得所赚工资。") }}
	{{ $d1("24.3 In case agreement has been made for the seafarer to join another vessel to complete his agreement, the ") }}
	{{ $d2("seafarer shall be entitled to basic wage until the date of joining the other vessel.") }}
	{{ $d2("如果船东安排船员上另一条船完成协议期，海员在侯船期间内有权获得基薪待遇。") }}

	<tr><td colspan="10"></td></tr>

	{{ $d1("25	LOSS OF OR DAMAGE TO CREW’S EFFECTS BY MARINE RERIL 海员财物因海事丢失或损坏", true) }}
	{{ $d1("25.1 The seafarer shall be reimbursed by the ship owner the full amount of loss or damage to his personal effects ") }}
	{{ $d2("but in no case shall be amount exceed to the amount of Three Thousand US dollars (US$3000) if his personal ") }}
	{{ $d2("effects are lost or damaged as a result of the wreck or loss or stranding or abandonment of the vessel or as ") }}
	{{ $d2("a result of fire, flooding, collision or piracy.") }}
	{{ $d2("如果海员的个人财物因沉没、灭失、搁浅或弃船或者火灾、进水、碰撞或海盗行为造成丢失或损坏，") }}
	{{ $d2("海员有权从船东处获得全额赔偿，但这种赔偿在任何情况下不能超过3000美元。") }}
	{{ $d1("25.2 In case of partial loss, the amount shall be determined by mutual agreement of both parties but in no case to ") }}
	{{ $d2("exceed to the amount of Three Thousand US dollars (US$3000)") }}
	{{ $d2("如果部分丢失，赔偿额可以双方协商但不能超过3000美元额度。") }}
	{{ $d1("25.3 Reimbursement for loss or damage to the seafarer’s personal effects shall not apply if such loss or damage is ") }}
	{{ $d2("due to (a) the seafarer’s own fault, (b) larceny or theft or (c) robbery") }}
	{{ $d2("对于海员个人财物丢失或损坏的赔偿，因下列情况产生的不予受理：1、海员个人失误，2、盗窃，3、") }}
	{{ $d2("抢劫。") }}

	<tr><td colspan="10"></td></tr>

	{{ $d1("26	DISPUTE SETTLEMENT PROCEDURES 争议解决程序", true) }}
	{{ $d2("In case of claims and disputes arising from his employment, the parties covered by agreement shall submit the ") }}
	{{ $d2("claim or dispute to the exclusive jurisdiction of the voluntary arbitrator or panel of arbitrator in The People's ") }}
	{{ $d2("Republic of China .") }}
	{{ $d2("如果协议发生争议或索赔，相关方可以向司法专属管辖地提出诉讼或向中国海事仲裁委员会提出仲裁") }}
	{{ $d2("请求。") }}
	{{ $d1("27. PRESCRIPTION OF ACTION 诉讼时效", true) }}
	{{ $d2("All claims arising from this agreement shall be made within (3) years from the date the cause of action arises, ") }}
	{{ $d2("otherwise the same shall be barred.") }}
	{{ $d2("有关协议发生的所有索赔或争议的诉讼时效是从开始时3年内有效，超过时限不予受理。") }}
	{{ $d1("28	APPLICABLE LAW -适用的法律", true) }}
	{{ $d2("When a labor dispute arises, the parties do not want, or unsuccessfully to negotiate a settlement ") }}
	{{ $d2("agreement, or non-compliance, then they may apply for conciliation or mediation organizations have ") }}
	{{ $d2("jurisdiction over the labor dispute arbitration committee for arbitration, and they may also take legal ") }}
	{{ $d2("proceedings at the maritime court who has direct jurisdiction according to The People's Republic of China ") }}
	{{ $d2("Maritime Law of the special procedures of the proceedings.") }}
	{{ $d2("船员在船期间发生劳动争议，当事人不愿意协商、协商不成或者达成和解协议后不履行的，可以依") }}
	{{ $d2("照中国法律规定的途径解决。") }}
	{{ $d1("29	ORIGINAL COPIES OF AGREEMENT 协议正本数量", true) }}
	{{ $d2("This agreement shall be made out and signed in triplicate, one for seafarer, one for ship owner and one keep ") }}
	{{ $d2("file on ship’s board.") }}
	{{ $d2("此协议一式三份，一份给海员本人，一份给船东，一份船上存档。") }}
	{{ $d1("30	DURATION OF EXAMINATION AND SEEKING ADVICE 审查和寻求意见期", true) }}
	{{ $d2("All terms and conditions of this agreement had been read carefully and reached sufficient understanding by ") }}
	{{ $d2("parties when it was signed and entered into force.") }}
	{{ $d2("该协议的所有条款和条件均在签署生效前经双方仔细阅读并充分理解。") }}

	<tr>
		<td colspan="10" style="height: 40px; {{ $c }}">--Blank below--</td>
	</tr>

	<tr>
		<td colspan="10" style="{{ $c }}">--以下空白—</td>
	</tr>

	<tr>
		<td colspan="l0" style="height: 300px;"></td>
	</tr>

	<tr>
		<td colspan="10" style="{{ $bc }} height: 30px;">ANNEX I</td>
	</tr>

	<tr>
		<td colspan="10" style="{{ $bc }}">Statutory Holidays for Vessels (11 days)</td>
	</tr>
	<tr>
		<td colspan="10" style="{{ $bc }}">船舶每年节假日时间表</td>
	</tr>

	<tr>
		<td colspan="10" style="height: 150px;"></td>
	</tr>

	<tr>
		<td colspan="5"> ‎‏‏‎‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎1、New Year’s Day  (1 day)</td>
		<td colspan="5"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎‎‏‏‎元旦</td>
	</tr>

	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎2、The first day, the second day and the third day of the lunar new year (3 days) </td>
	</tr>

	<tr>
		<td colspan="10"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎（春节）</td>
	</tr>

	<tr>
		<td colspan="5"> ‎‏‏‎ ‎‏‏‎‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎3、Ching Ming Festival  ( 1 day)</td>
		<td colspan="5"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎清明节</td>
	</tr>

	<tr>
		<td colspan="5"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎4、Labor day  (1 day)</td>
		<td colspan="5"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎劳动节</td>
	</tr>

	<tr>
		<td colspan="5"> ‎‏‏‎‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎5、Dragon boat festival  (1 day)</td>
		<td colspan="5"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎端午节</td>
	</tr>

	<tr>
		<td colspan="5"> ‎‏‏‎ ‎‏‏‎‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎6、Mid-autumn festival  ( 1day)</td>
		<td colspan="5"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎中秋节</td>
	</tr>

	<tr>
		<td colspan="5"> ‎‏‏‎ ‎‏‏‎‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎7、National day  (3 days)</td>
		<td colspan="5"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎国庆节</td>
	</tr>

	<tr>
		<td colspan="10" style="height: 300px;"></td>
	</tr>

	<tr>
		<td colspan="10">Remarks:</td>
	</tr>

	<tr>
		<td colspan="10">If the statutory holiday falls on a rest day, a holiday should be granted on the day following the rest </td>
	</tr>

	<tr>
		<td colspan="10">day which is not a statutory holiday or an alternative holiday or a substituted holiday or a rest day.</td>
	</tr>

	<tr>
		<td colspan="10">如果法定节假日为周六、周日休息时间，则下一个相应的工作日为节假日时间。</td>
	</tr>

	<tr>
		<td colspan="10" style="height: 240px;"></td>
	</tr>

	<tr>
		<td colspan="10" style="height: 30px; {{ $bc }}">
			Statutory Holidays for Vessels (FOR PHL CREW)
		</td>
	</tr>
</table>