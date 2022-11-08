@php
    $bold = "font-weight: bold;";
    $center = "text-align: center;";
    $red = "color: #FF0000;";
    $blue = "color: #0000FF;";
    $bc = $bold . " " . $center;

    // MAX AGE
    $age = [
        'MSTR' => 55,
        'C/E' => 55,
        'C/O' => 48,
        '1AE' => 48,
        '2/O' => 40,
        '2AE' => 40,
        'ELECT' => 40,
        '3/O' => 35,
        '3AE' => 35,
        'BSN' => 50,
        'OLR1' => 50,
        'CCK' => 50,
        'PMN' => 50,
        'AB' => 45,
        'OLR' => 45,
        '2CK' => 45,
        'OS' => 40,
        'WPR' => 40,
        'MSM' => 40
    ];

    $mAge = $age[$data->rank2->abbr];

    // LESS THAN SIX MONTHS
    $ltsm = 0;
    $ww = 0;
    $mc = false;

    $one = 0;
    $two = 0;
    $three = 0;
    $short = 0;

    $kor = 0;

    $data->sea_service = $data->sea_service->sortByDesc('sign_on');
    $curOn = null;

    // REPUTATION OF PREVIOUS COMPANY
    $ropc = 0;
    $curCom = null;

    // SAME AGENT WITHIN 5 YEARS
    $curMan = $data->sea_service->first()->manning_agent;
    $sawfy = true;
    $sawfyCtr = 0;

    $so = true;
    $soCtr = 0;

    // Last Rank
    $lr = $data->sea_service->first()->rank;

    // Short OnBoard
    $so = 0;

    foreach($data->sea_service as $ss){
        // LESS THAN SIX MONTHS
        if(isset($ss->sign_on) && isset($ss->sign_off)){
            if($ss->sign_off->diffInMonths($ss->sign_on) < 6 && now()->diffInYears($ss->sign_on) <= 5){
                $ltsm++;
            }
        }

        // MOXED CREW
        if((!str_contains($ss->crew_nationality, "FULL") || $ss->crew_nationality != "FILIPINO") && $ss->crew_nationality != ""){
            $mc = true;
        }

        // WOLRDWIDE EXP
        if(str_contains($ss->trade, "WO") || str_contains($ss->trade, "WI") || str_contains($ss->trade, "WW" || str_contains($ss->trade, "W."))){
            $ww++;
        }

        // LEAVE OF ABSENSE
        if($curOn == null){
            if(isset($ss->sign_on)){
                $curOn = $ss->sign_on;
            }
        }
        else{
            if(isset($ss->sign_off)){
                $diff = $ss->sign_off->diffInMonths($curOn);
            }

            if(isset($ss->sign_on)){
                $curOn = $ss->sign_on;
            }
            else{
                $curOn = null;
            }

            // CALCULATE DIFF
            if($diff >= 12 && $diff <= 24){
                $one++;
            }
            elseif($diff >= 24 && $diff <= 36 ){
                $two++;
            }
            elseif($diff > 36 ){
                $three++;
            }
            else{
                $short += $diff;
            }
        }

        // KOR EXP
        if(str_contains($ss->crew_nationality, "KOR")){
            $kor++;
        }
    }

    // REVERSE ITERATION
    $data->sea_service = $data->sea_service->sortBy('sign_on');
    foreach($data->sea_service as $ss){
        // REPUTATION OF PREVIOUS COMPANY
        if($curCom == null){
            if($ss->manning_agent != ""){
                $curCom = trim($ss->manning_agent);
            }
        }
        else{
            if($curCom == trim($ss->manning_agent) && $ss->sign_on->diffInYears(now()) <= 5){
                $ropc++;
            }

            if($ss->manning_agent != ""){
                $curCom = trim($ss->manning_agent);
            }
        }
        // SOLPIA ONLY
        if(!str_contains($ss->manning_agent, 'SOLPIA') && $ss->sign_on->diffInYears(now()) <= 5){
            $so = false;
        }
        elseif(str_contains($ss->manning_agent, 'SOLPIA') && $ss->sign_on->diffInYears(now()) <= 5){
            $soCtr++;
        }

        // SAME AGENT WITHIN 5 YEARS
        if($curMan != trim($ss->manning_agent) && $ss->sign_on->diffInYears(now()) <= 5){
            $sawfy = false;
        }
        elseif($curMan == trim($ss->manning_agent) && $ss->sign_on->diffInYears(now()) <= 5){
            $sawfyCtr++;
        }
    }

    // TOTAL SAME RANK
    $tsr = $data->sea_service->filter(function($value, $key) use($data){
    	return $value->rank == $data->rank2->name;
    });

    // TOTAL SAME TYPE - ALL - GREATER THAN 6M
    $tsta = $data->sea_service->filter(function($value, $key) use($data){
        $diff = 0;
        if(isset($value->sign_on) && isset($value->sign_off)){
            $diff = $value->sign_off->diffInMonths($value->sign_on);
        }

        return str_contains($value->vessel_type, "BUL") && $diff >= 6;
    });

    // TOTAL SAME TYPE WITHIN LAST 5 YEARS
    $tst = $data->sea_service->filter(function($value, $key) use($data){
        return str_contains($value->vessel_type, "BUL") && now()->diffInYears($value->sign_on) <= 5;
    });


    // TOTAL SAME TYPE SAME RANK
    $tstsr = $data->sea_service->filter(function($value, $key) use($data){
        $diff = 0;
        if(isset($value->sign_on) && isset($value->sign_off)){
            $diff = $value->sign_off->diffInMonths($value->sign_on);
        }

        return str_contains($value->vessel_type, "BUL") && $value->rank == $data->rank2->name && $diff >= 6;
    });

    // FAMILY DATA
    $spouse = 0;
    $children = 0;
    foreach($data->family_data as $fd){
        if($fd->type == "Spouse" && $fd->fname != ""){
            $spouse++;
        }
        elseif(in_array($fd->type, ['Son', 'Daughter']) && $fd->fname != ""){
            $children++;
        }
    }

    if($children){
        $spouse = 0;
    }
@endphp

<table>
    <tr>
        <td rowspan="49"></td>
        <td colspan="7" style="{{ $bc }} font-size: 20px;">
        	EVALUATION SHEET
        </td>
    </tr>

    <tr>
        <td colspan="7"></td>
    </tr>

    <tr>
    	<td colspan="2" style="{{ $bc }}">SHIP NAME (Scheduled)</td>
    	<td colspan="5" style="{{ $bc }}">{{ $data->vessel->name }}</td>
    </tr>

    <tr>
    	<td colspan="2" style="{{ $bc }}">RANK</td>
    	<td colspan="5" style="{{ $bc }}">{{ $data->rank2->abbr }}</td>
    </tr>

    <tr>
    	<td colspan="2" style="{{ $bc }}">NAME</td>
    	<td colspan="5" style="{{ $bc }}">{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}</td>
    </tr>

    <tr>
    	<td colspan="2" style="{{ $bc }}">NATIONALITY</td>
    	<td colspan="5" style="{{ $bc }}">FILIPINO</td>
    </tr>

    <tr>
    	<td colspan="7"></td>
    </tr>

    <tr>
    	<td style="{{ $bc }}">AGE</td>
    	<td style="{{ $bc }}">Total Services</td>
    	<td style="{{ $bc }}">
    		Min. Period of
    		<br style='mso-data-placement:same-cell;' />
    		Same Type / Same Rank
    	</td>
    	<td style="{{ $bc }}">
    		Short
    		<br style='mso-data-placement:same-cell;' />
    		OnBoard
    		<br style='mso-data-placement:same-cell;' />
    		(Less than 6M)
    	</td>
    	<td style="{{ $bc }}">
    		Mixed
    		<br style='mso-data-placement:same-cell;' />
    		Crew
    	</td>
    	<td style="{{ $bc }}">BMI</td>
    	<td style="{{ $bc }}">Interview</td>
    </tr>

    <tr>
    	<td style="{{ $center }}">18-{{ $mAge }}</td>
    	<td style="{{ $center }}">2 Years</td>
    	<td style="{{ $center }}">
    		Over 12M/Time
    		<br style='mso-data-placement:same-cell;' />
    		&#38; Over 0.5Y
    	</td>
    	<td style="{{ $center }}">
    		Less than 2 Times
    		<br style='mso-data-placement:same-cell;' />
    		Within 5 Years
    	</td>
    	<td style="{{ $center }}">
    		Experienced
    		<br style='mso-data-placement:same-cell;' />
    		(Y/N)
    	</td>
    	<td style="{{ $center }}">19-25</td>
    	<td style="{{ $center }}">
    		FITNESS
    		<br style='mso-data-placement:same-cell;' />
    		(Fit / Unfit)
    	</td>
    </tr>


	{{-- {{ $data->sign_on->diff($data->sign_off)->format('%yyr, %mmos, %ddays') }} --}}

    @php
        $convert = $tstsr->sum('total_months') * 30.5;

        $years = ($convert / 365) ;
        $years = floor($years);

        $month = ($convert % 365) / 30.5;
        $month = floor($month);

        $days = ($convert % 365) % 30.5;

        $stsr = $years . "Y " . $month . "M " . $days . "D";


        $weight = $data->weight;
        $height = $data->height / 100;
        $bmi = round($weight / ($height * $height));
    @endphp

    <tr>
    	<td style="{{ $bc }}">{{ $data->user->birthday ? now()->parse($data->user->birthday)->age : "---" }}</td>
    	<td style="{{ $bc }}">{{ round($data->sea_service->sum('total_months') / 12, 2) }}</td>
        <td style="{{ $bc }}">{{ $stsr }}</td>
    	<td style="{{ $bc }}">
    		{{ $ltsm }} Times
    	</td>
    	<td style="{{ $bc }}">
    		{{ $mc ? "Y" : "N" }}
    	</td>
    	<td style="{{ $bc }}">{{ $bmi }}</td>
    	<td style="{{ $bc }}">{{ $bmi <= 25 ? "FIT" : "UNFIT" }}</td>
    </tr>

    <tr><td colspan="7"></td></tr>

    <tr>
        <td></td>
        <td style="{{ $bc }}">Item</td>
        <td style="{{ $bc }}">Standard</td>
        <td style="{{ $bc }}">Additional Point</td>
        <td style="{{ $bc }}">Subtract Point</td>
        <td style="{{ $bc }}">Details</td>
        <td style="{{ $bc }}">Score</td>
    </tr>

    <tr>
        <td rowspan="15" style="{{ $bc }}">Working Experience</td>
        <td style="{{ $bc }}">Same Rank</td>
        <td style="{{ $bc }}">More than 1.5 Years</td>
        <td style="{{ $center }} {{ $blue }}">+2/Year</td>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }}">{{ round(($tsr->sum('total_months') / 12) - 1.5, 0) }} Years</td>
        <td style="{{ $bc }}">{{ round(($tsr->sum('total_months') / 12) - 1.5, 0) * 2 }}</td>
    </tr>

    {{-- DECK ONLY --}}
    <tr>
        <td rowspan="2" style="{{ $bc }}">
            Same Type of Ship
            <br style='mso-data-placement:same-cell;' />
            (Deck Officers &#38; Ratings)
        </td>
        <td rowspan="2" style="{{ $bc }}">
            Within 5 Years
            <br style='mso-data-placement:same-cell;' />
            (Recently)
        </td>
        <td style="{{ $center }} {{ $blue }}">+2/Time</td>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }}">
            @if(str_starts_with($data->rank2->category, "DECK"))
                {{ sizeof($tst) }} Times
            @else
                -
            @endif
        </td>
        <td style="{{ $bc }}">{{ sizeof($tst) * 2 }}</td>
    </tr>

    <tr>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }} {{ $red }}">Nothing: -5</td>
        <td style="{{ $center }}">
            @if(str_starts_with($data->rank2->category, "DECK"))
                @if(sizeof($tst) == 0)
                    0 Times
                @else
                    -
                @endif
            @else
                -
            @endif
        </td>
        <td style="{{ $bc }}">
            @if(str_starts_with($data->rank2->category, "DECK"))
                @if(sizeof($tst) == 0)
                    -5
                @else
                    0
                @endif
            @else
                -
            @endif
        </td>
    </tr>

    {{-- ENGINE ONLY --}}
    <tr>
        <td rowspan="2" style="{{ $bc }}">
            Same kind of Engine
            <br style='mso-data-placement:same-cell;' />
            (Engineers &#38; Ratings)
        </td>
        <td rowspan="2" style="{{ $bc }}">
            Within 5 Years
            <br style='mso-data-placement:same-cell;' />
            (Recently)
        </td>
        <td style="{{ $center }} {{ $blue }}">+2/Time</td>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }}">
            @if(str_starts_with($data->rank2->category, "ENGINE"))
                0 Times
            @else
                0
            @endif
        </td>
        <td style="{{ $bc }}">0</td>
    </tr>

    <tr>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }} {{ $red }}">Nothing: -5</td>
        <td style="{{ $center }}">
            -
        </td>
        <td style="{{ $bc }}">
            @if(str_starts_with($data->rank2->category, "ENGINE"))
                -
            @else
                -
            @endif
        </td>
    </tr>

    {{-- WOLRDWIDE ROUTE --}}
    <tr>
        <td rowspan="2" style="{{ $bc }}">
            Experience of Route
            <br style='mso-data-placement:same-cell;' />
            (World Wide)
        </td>
        <td rowspan="2" style="{{ $bc }}">
            Within 5 Years
            <br style='mso-data-placement:same-cell;' />
            (Recently)
        </td>
        <td style="{{ $center }} {{ $blue }}">+2/Time</td>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }}">
            {{ $ww }} Times
        </td>
        <td style="{{ $bc }}">{{ $ww * 2 }}</td>
    </tr>

    <tr>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }} {{ $red }}">Nothing: -5</td>
        <td style="{{ $center }}">
            @if(sizeof($ww) == 0)
                0 Times
            @else
                -
            @endif
        </td>
        <td style="{{ $bc }}">
            @if(sizeof($ww) == 0)
                -5
            @else
                -
            @endif
        </td>
    </tr>

    {{-- LEAVE OF ABSCENCE --}}
    <tr>
        <td rowspan="4" style="{{ $bc }}">Leave of Abscence</td>
        <td style="{{ $bc }} height: 40px;">
            Over 1 Year
            <br style='mso-data-placement:same-cell;' />
            Less than 2 Years
        </td>
        <td style="{{ $bc }} {{ $blue }}">-</td>
        <td style="{{ $center }} {{ $red }}">-5</td>
        <td style="{{ $center }}">{{ $one }}</td>
        <td style="{{ $bc }}">{{ $one > 0 ? -5 : 0 }}</td>
    </tr>

    <tr>
        <td style="{{ $bc }} height: 40px;">
            Over 2 Year
            <br style='mso-data-placement:same-cell;' />
            Less than 3 Years
        </td>
        <td style="{{ $bc }} {{ $blue }}">-</td>
        <td style="{{ $center }} {{ $red }}">-7</td>
        <td style="{{ $center }}">{{ $two }}</td>
        <td style="{{ $bc }}">{{ $two > 0 ? -7 : 0 }}</td>
    </tr>

    <tr>
        <td style="{{ $bc }} height: 40px;">
            Over 3 Years
        </td>
        <td style="{{ $bc }} {{ $blue }}">-</td>
        <td style="{{ $center }} {{ $red }}">-10</td>
        <td style="{{ $center }}">{{ $three }}</td>
        <td style="{{ $bc }}">{{ $three > 0 ? -10 : 0 }}</td>
    </tr>

    <tr>
        <td style="{{ $bc }} height: 40px;">
            Shortly Before
            <br style='mso-data-placement:same-cell;' />
            Within 5 Year
        </td>
        <td style="{{ $bc }} {{ $blue }}">-</td>
        <td style="{{ $center }} {{ $red }}">-1/Year</td>
        <td style="{{ $center }}">{{ round($short / 12, 2) }} Years</td>
        <td style="{{ $bc }}">{{ round($short / 12, 0, 1) * -1 }}</td>
    </tr>

    {{-- KOR EXP --}}
    <tr>
        <td rowspan="3" style="{{ $bc }}">
            Experience with
            <br style='mso-data-placement:same-cell;' />
            Korean Crews
            <br style='mso-data-placement:same-cell;' />
            (Total Experience)
        </td>
        <td style="{{ $bc }}">3 Times</td>
        <td style="{{ $center }} {{ $blue }}">+2</td>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }}">{{ $kor == 3 ? 3 : 0 }} Times</td>
        <td style="{{ $bc }}">{{ $kor == 3 ? 2 : 0 }}</td>
    </tr>

    <tr>
        <td style="{{ $bc }}">4 Times or More</td>
        <td style="{{ $center }} {{ $blue }}">+5</td>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }}">{{ $kor }} Times</td>
        <td style="{{ $bc }}">{{ $kor >= 4 ? 5 : 0 }}</td>
    </tr>

    <tr>
        <td style="{{ $bc }}">Nothing</td>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }} {{ $red }}">-5</td>
        <td style="{{ $center }}">{{ $kor }} Times</td>
        <td style="{{ $bc }}">{{ $kor == 0 ? -5 : 0 }}</td>
    </tr>

    <tr>
        <td style="{{ $bc }}">
            Reputation of
            <br style='mso-data-placement:same-cell;' />
            Previous Company
        </td>
        <td style="{{ $bc }}">
            Within 5 Years
            <br style='mso-data-placement:same-cell;' />
            (Recently)
        </td>
        <td style="{{ $center }} {{ $blue }}">+1/Time</td>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }}">{{ $ropc }} Times</td>
        <td style="{{ $bc }}">{{ $ropc }}</td>
    </tr>

    {{-- SEPARATOR --}}
    <tr><td colspan="7" style="height: 5px;"></td></tr>

    <tr>
        <td rowspan="7" style="{{ $bc }}">Loyalty</td>
        <td style="{{ $bc }}">Re-Hire</td>
        <td style="{{ $bc }}">
            Same Agent 
            <br style='mso-data-placement:same-cell;' />
            Within 5 Years</td>
        <td style="{{ $center }} {{ $blue }}">+10</td>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }}">{{ $soCtr }} Times</td>
        <td style="{{ $bc }}">{{ $so ? 10 : 0 }}</td>
    </tr>

    <tr>
        <td rowspan="2" style="{{ $bc }}">Family Relation</td>
        <td style="{{ $bc }}">Married</td>
        <td style="{{ $center }} {{ $blue }}">+3</td>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }}">{{ $children ? "-" : $spouse ? "Married" : "-" }}</td>
        <td style="{{ $bc }}">{{ $children ? "-" : $spouse ? 3 : 0 }}</td>
    </tr>

    <tr>
        <td style="{{ $bc }}">Married with Children</td>
        <td style="{{ $center }} {{ $blue }}">+5</td>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }}">{{ $children ? $children : "-" }}</td>
        <td style="{{ $bc }}">{{ $children ? 5 : 0 }}</td>
    </tr>

    <tr>
        <td rowspan="3" style="{{ $bc }}">Changing Company</td>
        <td rowspan="2" style="{{ $bc }}">
            Within 5 Years
            <br style='mso-data-placement:same-cell;' />
            ( Recently )
        </td>
        <td style="{{ $center }} {{ $blue }}">Nothing: + 10</td>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }}">-</td>
        <td style="{{ $bc }}">{{ $sawfy ? 10 : 0 }}</td>
    </tr>

    <tr>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }} {{ $red }}">-5/Time</td>
        <td style="{{ $center }}">{{ $sawfyCtr }} Times</td>
        <td style="{{ $bc }}">{{ $sawfyCtr * 5 * -1 }}</td>
    </tr>

    <tr>
        <td style="{{ $bc }}">For Promotion</td>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }} {{ $red }}">-10</td>
        <td style="{{ $center }}">
            @if($lr != $data->rank2->name)
                Yes
            @else
                -
            @endif
        </td>
        <td style="{{ $bc }}">
            @if($lr != $data->rank2->name)
                -10
            @else
                0
            @endif
        </td>
    </tr>

    <tr>
        <td style="{{ $bc }}">
            Short OnBoard
            <br style='mso-data-placement:same-cell;' />
            ( Less than 6M )
        </td>
        <td style="{{ $bc }}">
            Within 5 Years
            <br style='mso-data-placement:same-cell;' />
            ( Recently )
        </td>
        <td style="{{ $bc }}">-</td>
        <td style="{{ $center }} {{ $red }}">-5/Time</td>
        <td style="{{ $center }}">{{ $ltsm }} Times</td>
        <td style="{{ $bc }}">{{ $ltsm * 5 * -1 }}</td>
    </tr>

    <tr>
        <td rowspan="2" style="{{ $bc }}">Health</td>
        <td rowspan="2" style="{{ $bc }}">Age</td>
        <td rowspan="2" style="{{ $bc }}">{{ $mAge }}</td>
        <td style="{{ $center }} {{ $blue }}">+1/-1 Year</td>
        <td style="{{ $center }}">-</td>
        <td rowspan="2" style="{{ $center }}">{{ isset($data->user->birthday) ? $data->user->birthday->age : "N/A" }}</td>
        @php
            $plus = 0;
            $minus = 0;
            $temp = $mAge - $data->user->birthday->age;
            if($temp > 0){
                $plus = $temp;
            }
            elseif($temp < 0){
                $minus = $temp * 2;
            }
        @endphp
        <td style="{{ $bc }}">{{ $plus }}</td>
    </tr>

    <tr>
        <td style="{{ $center }}">-</td>
        <td style="{{ $center }} {{ $red }}">-2/+1 Year</td>
        <td style="{{ $bc }}">{{ $minus }}</td>
    </tr>

    {{-- SEPARATOR --}}
    <tr><td colspan="7" style="height: 5px;"></td></tr>

    {{-- SCORE --}}
    <tr>
        <td colspan="2" rowspan="2" style="{{ $bc }}">SCORE</td>
        <td rowspan="2" style="{{ $bc }}">
            PASS: More than 25 SCORE
            <br style='mso-data-placement:same-cell;' />
            REJECT: Less than -15 SCORE
        </td>
        <td colspan="2" style="{{ $bc }}">Additional Point</td>
        <td style="{{ $bc }} {{ $red }}"></td>
        <td style="{{ $bc }}"></td>
    </tr>

    <tr>
        <td colspan="2" style="{{ $bc }}">Subtract Point</td>
        <td style="{{ $bc }} {{ $red }}"></td>
        <td style="{{ $bc }} {{ $red }}"></td>
    </tr>

    {{-- SEPARATOR --}}
    <tr><td colspan="7" style="height: 10px;"></td></tr>

    {{-- LAST PART --}}
    <tr>
        <td colspan="2" style="{{ $bc }}">Aticles</td>
        <td style="{{ $bc }}">Standard</td>
        <td colspan="2" style="{{ $bc }}">Candidate</td>
        <td style="{{ $bc }}">Y/N</td>
        <td style="{{ $bc }}">Remark</td>
    </tr>

    <tr>
        <td colspan="2" style="{{ $center }}">Interview(General / Technical)</td>
        <td style="{{ $center }}">75 / 75</td>
        <td colspan="2" style="{{ $center }}">/</td>
        <td style="{{ $center }}">N</td>
        <td style="{{ $center }}"></td>
    </tr>

    <tr>
        <td colspan="2" style="{{ $center }}">Interview(Rank / Total)</td>
        <td style="{{ $center }}">0.5 / 2</td>
        <td colspan="2" style="{{ $center }} {{ $red }}">{{ round($data->sea_service->sum('total_months') / 12, 1) }} / {{ round($tstsr->sum('total_months') / 12, 2) }}</td>
        <td style="{{ $center }}">
            @if(round($data->sea_service->sum('total_months') / 12, 1) > 0.5 && round($tstsr->sum('total_months') / 12, 1) > 2)
                Y
            @else
                N
            @endif
        </td>
    </tr>

    <tr>
        <td colspan="2" style="{{ $center }}">Same Type of vessel</td>
        <td style="{{ $center }}">1 Time (>6M)</td>
        <td colspan="2" style="{{ $center }}">{{ sizeof($tsta) }} Time(s)</td>
        <td style="{{ $center }}">{{ sizeof($tsta) >= 1 ? "Y" : "N" }}</td>
        <td style="{{ $center }}"></td>
    </tr>

    <tr>
        <td colspan="2" style="{{ $center }}">Score (Addition / Deduction)</td>
        <td style="{{ $center }}">25 / -15</td>
        <td colspan="2" style="{{ $center }} {{ $red }}"></td>
        <td style="{{ $center }}"></td>
        <td style="{{ $center }}"></td>
    </tr>

    <tr>
        <td colspan="2" style="{{ $center }}">Age</td>
        <td style="{{ $center }}">{{ $mAge }} (Less than)</td>
        <td colspan="2" style="{{ $center }}">{{ $data->user->birthday ? $data->user->birthday->age : "N/A" }}</td>
        <td style="{{ $center }}">{{ $data->user->birthday ? $data->user->birthday->age <= $mAge ? "Y" : "N" : "N/A" }}</td>
        <td style="{{ $center }}"></td>
    </tr>

    <tr>
        <td colspan="2" style="{{ $center }}">BMI</td>
        <td style="{{ $center }}">19~25</td>
        <td colspan="2" style="{{ $center }} {{ $red }}">{{ $bmi }}</td>
        <td style="{{ $center }}">{{ $bmi <= 25 ? "Y" : "N" }}</td>
        <td style="{{ $center }}"></td>
    </tr>

    <tr>
        <td colspan="5" style="{{ $bc }}">Result</td>
        <td colspan="2" style="{{ $bc }} {{ $red }}"></td>
    </tr>
</table>