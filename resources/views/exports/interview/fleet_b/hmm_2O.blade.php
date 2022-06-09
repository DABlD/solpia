@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	$criterias = 0;
	$sections = 0;

	$criteria = function($text, $height = 13) use($center, $bold, &$criterias){
		$height = "height: $height" . 'px';
		$text = str_replace("&", "&#38;", $text);
		$criterias++;

		echo "
			<tr>
				<td colspan='5' style='$height'>
					$text
				</td>
				<td style='$center $bold $height'></td>
				<td style='$center $bold $height'></td>
				<td style='$center $bold $height'></td>
				<td style='$center $bold $height'></td>
			</tr>
		";
	};

	$section = function($text) use($center, $bold, &$sections){
		// $text = str_replace("&", "&#38;", $text);
		$sections++;

		echo "
			<tr>
				<td colspan='9' style='$bold'> ‎‏‏‎ ‎‏‏‎$text</td>
			</tr>
		";
	};

	$remarks = function($text) use($center){
		$text = str_replace("&", "&#38;", $text);

		echo "
			<tr>
				<td colspan='3' style='font-size: 10px;'>$text</td>
				<td colspan='6' style='$center font-size: 10px;'></td>
			</tr>
		";
	};
@endphp

<tr>
	<td></td>
	<td colspan="6" style="{{ $bold }} {{ $center }} font-size: 30px; height: 30px;">
		INTERVIEW SHEET FOR 2ND OFFICER
	</td>
	<td colspan="2"></td>
</tr>

<tr>
	<td colspan="9"></td>
</tr>

<tr>
	<td style="height: 14px;">SERIAL NO.</td>
	<td colspan="2" style="{{ $center }}"></td>
	<td></td>
	<td colspan="5" rowspan="4">
		LEGEND E - EXCELLENT (5) ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
		G - GOOD (4) ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
		F - FAIR (3) ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
		P - POOR (2)
	</td>
</tr>

<tr>
	<td>NAME:</td>
	<td colspan="2" style="{{ $center }}">
		{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
	</td>
</tr>

<tr>
	<td>RANK:</td>
	<td colspan="2" style="{{ $center }}">
		{{ $data->rank ? $data->rank->abbr : '---' }}
	</td>
</tr>

<tr>
	<td>DATE:</td>
	<td colspan="2" style="{{ $center }}">
		{{ now()->format('d-F-Y') }}
	</td>
</tr>

<tr>
	<td colspan="3"></td>
	<td></td>
	<td colspan="5"></td>
</tr>

<tr>
	<td colspan="9"></td>
</tr>

<tr>
	<td colspan="5" rowspan="2" style="{{ $center }} {{ $bold }}">QUESTIONNAIRE</td>
	<td colspan="4" style="{{ $center }}">GRADE</td>
</tr>

<tr>
	<td style="{{ $center }}">E</td>
	<td style="{{ $center }}">G</td>
	<td style="{{ $center }}">F</td>
	<td style="{{ $center }}">P</td>
</tr>

{{ $section('DUTIES &#38; RESPONSIBILITIES AT SEA') }}

{{ $criteria('1. Proper " Look-out" in rule 5 of 72 COLREG') }}
{{ $criteria('2. Factors should be taken for passage plan') }}
{{ $criteria('3. "Crash stop" & maneuvering charactristic of ship') }}
{{ $criteria('4. The cases duty officer should report to master') }}
{{ $criteria('5. Definition of various words, shapes, and signals in rule of 72 COLREG', 25) }}
{{ $criteria('6. Steering procedure when auto-pilot not under command') }}
{{ $criteria('7. Procedure & check points of changing over watch on bridge') }}
{{ $criteria('8. Responsibility of safe navigation when pilot/master on bridge') }}
{{ $criteria('9. What should you do when you encounter abnormal circumstance') }}
{{ $criteria('10. Maneuvering method and check points in seperation scheme') }}

{{ $section('DUTIES &#38; RESPONSIBILITIES AT PORT') }}

{{ $criteria('11. Preparing voyage plan') }}
{{ $criteria('12. Small correction for chart and pub') }}
{{ $criteria('13. Explanation of abstract log & noon report') }}
{{ $criteria('14. Maintenance of navigational equipments') }}
{{ $criteria('15. Reporting items to master during mooring/anchoring') }}
{{ $criteria('16. The cases duty officer should report to C/O or Capt.') }}
{{ $criteria('17. Monitoring of stevedores during cargo operation') }}

{{ $section('OTHERS') }}

{{ $criteria('18. Compliance with safety regulation & prevention from environment pollution in accordance with ISM', 25) }}
{{ $criteria('19. Drill & operation of life saving appliance') }}
{{ $criteria('20. Prevention from marine casualties and personnel accident inclusive smuggling', 25) }}

<tr>
	<td colspan="5" style="{{ $bold }} text-align: right; font-size: 10px;">SUBTOTAL</td>
	<td style="{{ $center }}">=COUNTA(F16:F{{ $criterias + $sections + 10 }}) * 5</td>
	<td style="{{ $center }}">=COUNTA(G16:G{{ $criterias + $sections + 10 }}) * 4</td>
	<td style="{{ $center }}">=COUNTA(H16:H{{ $criterias + $sections + 10 }}) * 3</td>
	<td style="{{ $center }}">=COUNTA(I16:I{{ $criterias + $sections + 10 }}) * 2</td>
</tr>

<tr>
	<td colspan="4" style="height: 25px;"></td>
	<td style="{{ $bold }} height: 25px; font-size: 10px;">TOTAL</td>
	<td colspan="3" style="{{ $bold }} {{ $center }} height: 25px; text-decoration: underline;">
		=CONCATENATE(SUM(F{{ $criterias + $sections + 11 }}:I{{ $criterias + $sections + 11 }}), " / 100")
	</td>
</tr>

<tr>
	<td colspan="3" style="{{ $bold }} {{ $center }} font-size: 11px;">PERSONAL LEVEL</td>
	<td colspan="6" style="{{ $bold }} {{ $center }} font-size: 11px;">REMARKS</td>
</tr>

{{ $remarks('Family Background') }}
{{ $remarks('Ambition / Goals') }}
{{ $remarks('Hobbies and interests') }}
{{ $remarks('Personal belief / values') }}
{{ $remarks('Disposition on Alcohol') }}
{{ $remarks('Good Experience onboard') }}
{{ $remarks('Bad Experience onboard') }}
{{ $remarks('Illness / Injury') }}
{{ $remarks('Motive of application') }}

<tr>
	<td colspan="9"></td>
</tr>

<tr>
	<td></td>
	<td>Remarks</td>
	<td colspan="5" style="{{ $center }}"></td>
	<td colspan="2"></td>
</tr>

<tr>
	<td colspan="2"></td>
	<td colspan="5" style="{{ $center }}"></td>
	<td colspan="2"></td>
</tr>

<tr>
	<td colspan="2"></td>
	<td colspan="5" style="{{ $center }}"></td>
	<td colspan="2"></td>
</tr>

<tr>
	<td colspan="2"></td>
	<td colspan="5" style="{{ $center }}"></td>
	<td colspan="2"></td>
</tr>

<tr>
	<td colspan="2"></td>
	<td colspan="5" style="{{ $center }}"></td>
	<td colspan="2"></td>
</tr>

<tr>
	<td colspan="2"></td>
	<td colspan="5" style="{{ $center }}"></td>
	<td colspan="2"></td>
</tr>

<tr>
	<td colspan="9"></td>
</tr>

<tr>
	<td colspan="4"></td>
	<td colspan="5">EVALUATOR:</td>
</tr>

<tr>
	<td colspan="4"></td>
	<td colspan="4" style="{{ $center }} {{ $bold }}"></td>
	<td></td>
</tr>