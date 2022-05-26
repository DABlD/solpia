@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";

	$name = $data->user->lname . ', ' . $data->user->fname . ' ' . $data->user->suffix . ' ' . $data->user->mname;
	$rank = $data->rank;

	$f = function($l = 1){
		for($i = 0; $i < $l; $i++){
			echo "<tr><td></td></tr>";
		}
	};

	$r = function($t, $h = 15, $b = false, $c = false, $f = 10) use($center){
		$h = $h . "px";
		$f = $f . "px";
		if($b){
			$b = "font-weight: bold;";
		}
		if($c){
			$c = $center;
		}
		echo "
			<tr>
				<td style='height: $h; font-size: $f; $b $c'>
					$t
				</td>
			</tr>
		";
	};
@endphp

<table>

	{{ $r("서  약  서", 15, true, true) }}
	{{ $f(3) }}
	{{ $r("본인은 금번 UNICO LOGISTIC 소속선에 승선 취업함에 따라 다음 사항을 준수할 것을 서약합니다.") }}
	{{ $f() }}
	{{ $r("------- 아   래 (Followings) -------", 15, false, true) }}
	{{ $f(2) }}
	{{ $r("Ⅰ 일반", 15, true) }}
	{{ $f() }}
	{{ $r("1.     본인은 귀사의 해상직원 인사관리 절차서 및 선원 취업규칙과 고용계약서를 숙지하고 전적으로 동의하며 이에 따라 근면 성실히 맡은 바 직무에 임한다.", 25) }}
	{{ $f() }}
	{{ $r("2.     본인은 승선 취업 중 상사의 정당한 지시와 명령에 절대 복종하고 인화와 단결로써 건전한 선내 분위기를 조성할 것이며, 음주, 소란, 폭행 등 문란행위와 불법 행위가 있을 때에는 상륙금지, 귀국조치 등 본선의 어떤 처벌도 감수하며, 자의하선 및 징계하선의 경우 모든 제반 비용은 본인이 부담한다.", 40) }}
	{{ $f() }}
	{{ $r("3.     본인은 승선 중 특히 관세법을 엄수하고 사소한 물품이라도 불법반입, 반출치 않을 것은 물론이고, 동료선원들의 불법행위 방지에도 최대한 노력한다.", 25) }}
	{{ $f() }}
	{{ $r("4.     귀사의 기밀에 속하는 사항은 비록 퇴사 후 일지라도 이를 누설치 않을 것이며, 본인 보관의 문서기록은 이를 결코 타인에게 공개치 않는다.", 25) }}
	{{ $f() }}
	{{ $r("5.     재직 중 불적절한 행위 혹은 불법 행위로 인해 귀사에 끼친 일체의 손해에 대하여는 귀사에 보상한다.") }}
	{{ $f(2) }}
	{{ $r("Ⅱ 건강관리", 15, true) }}
	{{ $f() }}
	{{ $r("1.      승선 전 건강상태에 대해 귀사에 숨김없이 알려야 하며, 승선 전 신체검사상의 의심소견, 승선 전 앓고 있던 지병 그리고 암은 승선 전 치료 유무를 막론하고 승선 중 악화 또는 재발 시 귀사에 어떠한 보상도 요구하지 않는다.", 40) }}
	{{ $r("", 40) }}
	{{ $f(2) }}‎‎‎‎
	{{ $r("Ⅲ 선박 항로 특성에 따른 승선 의무 준수", 25, true) }}
	{{ $f() }}
	{{ $r("1.      계약 전, 나는 승선하는 선박의 항로(World Wide)에 대해 충분히 인지했으며, 적절한 회사의 조치를 바탕으로 호전지역 또는 고위험지역을 항해하는데 있어서 송환을 요구하지 않는다.", 25) }}
	{{ $f() }}
	{{ $r(now()->format('F d, Y')) }}
	{{ $f() }}
	{{ $r("서약자(Recognizer):  $name  직위(Rank): $rank   서명 (sign) :") }}
	{{ $f(3) }}
	{{ $r("", 66) }}
	{{ $r("SMS 08-09(1/1)/0/15.11.01 ‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎ ‎‏‏‎ ‎‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎ UNICO LOGISTICS CO., LTD.") }}
	{{ $r("Written Oath", 20, true, true, 16) }}
	{{ $f(2) }}
	{{ $r("I hereby pledge to observe the followings as I work on board a ship which is under the control of UNICO LOGISTIC", 15) }}
	{{ $r("------- Followings -------", 20, false, true) }}
	{{ $f() }}
	{{ $r("Ⅰ General", 15, true) }}
	{{ $f() }}
	{{ $r('1.      I am fully aware of the company’s "Shipboard Personnel Management Regulation" and “Rule of Seafarer’s Employment” and agree with the whole contents and I will make every effort diligently and faithfully to the duties in accordance with the regulation and the rule.', 40) }}
	{{ $f() }}
	{{ $r('2.      During working onboard ship, I will absolutely obey to proper instructions and orders from my superiors and create sound atmosphere of the shipboard by harmony among crew and unity of crew. And I will also abide by any punishments of master such as withholding shore leave or repatriation etc. when I commit unlawful actions or disordered behaviors such as drinking, disturbance or violence etc. And I will bear all and any expenses if I leave a ship midway of contract without just reason.', 70) }}
	{{ $f() }}
	{{ $r('3.      During onboard ship, especially, I will observe the Customs Law and I will endeavor my best not only to carry in and out of onboard ship even a trivial goods which is defined as unlawful but also to prevent unlawful actions of fellow crew members.', 40) }}
	{{ $f() }}
	{{ $r('4.      I will neither leak office secret even after resignation nor open any documents which I keep to anyone.', 15) }}
	{{ $f() }}
	{{ $r('5.      I will compensate for the company’s any loss and damages which are caused by my improper and/or unlawful actions during the period of contract.', 25) }}
	{{ $f() }}
	{{ $r('Ⅱ Health Care and Drug/Alcohol Policy', 15, true) }}
	{{ $f() }}
	{{ $r('1.     I shall inform the company of my health condition without hiding anything, and will not claim any compensation from the company for any worseness and/or relapse of any suspicious sickness in pre employment medical examination and any chronic disease and any cancer which I had before on boarding ship regardless of complete cure of those before embarkation.', 55) }}
	{{ $r('', 70) }}
	{{ $f() }}
	{{ $r('1.      I am fully aware of the ship’s route(World Wide) before contract and based on Company’s adequate support I waive the right of repatriation while sail the WARLIKE AREA and/or HIGH RISK AREA.', 40) }}
	{{ $r('DATE: ' . now()->format('F d, Y'), 15) }}
	{{ $f() }}
	{{ $r("서약자(Recognizer):  $name  직위(Rank): $rank   서명 (sign) :") }}
	{{ $f(4) }}
	{{ $r("SMS 08-09(1/1)/0/15.11.01 ‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎ ‎‏‏‎ ‎‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎ UNICO LOGISTICS CO., LTD.") }}
</table>