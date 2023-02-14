@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = $b . ' ' . $c;
	$und = 'text-decoration: underline;';
	$blue = 'color: #0000FF;';
	$red = 'color: #FF0000;';

	$fill = function($height = 15){
		echo "<tr><td colspan='8' style='height: $height;'></td></tr>";
	};

	$d1 = function($text, $bo = false) use($b){
		if($bo){
			echo "
				<tr>
					<td colspan='8' style='$b'>$text</td>
				</tr>
			";
		}
		else{
			echo "
				<tr>
					<td colspan='8'>$text</td>
				</tr>
			";
		}
	};

	$d2 = function($text, $bo = false) use($b){
		if($bo){
			echo "
				<tr>
					<td colspan='8' style='$b'> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎$text</td>
				</tr>
			";
		}
		else{
			echo "
				<tr>
					<td colspan='8'> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎$text</td>
				</tr>
			";
		}
	};

	$start = now()->parse($data->effective_date);
@endphp

<table>
	<tr>
		<td colspan="8" style="{{ $bc }} font-size: 20px; height: 80px;">
			Contract of Employment for Seafarer
		</td>
	</tr>

	<tr>
		<td colspan="8">The following parties to the contract agree to fully comply with the terms stated hereinafter:</td>
	</tr>

	<tr>
		<td colspan="2" rowspan="3" style="{{ $c }} height: 40px;">
			Shipowner
		</td>
		<td>
			Name of the company
		</td>
		<td colspan="3" style="{{ $c }}">
			{{-- FILL --}}
			CHANG MYUNG SHIPPING
		</td>
		<td>Phone number</td>
		<td style="{{ $c }}">
			{{-- FILL --}}
			+82-2-2175-7000
		</td>
	</tr>

	<tr>
		<td style="height: 40px;">
			Location of the company
		</td>
		<td colspan="5">
			{{-- FILL --}}
			9F, 92, SAEMUNAN-RO, JONGNO-GU, SEOUL, KOREA
		</td>
	</tr>

	<tr>
		<td style="height: 40px;">
			Name of the employee
		</td>
		<td colspan="3" style="{{ $c }}">
			{{-- FILL --}}
			KUK JONG JIN
		</td>
		<td>
			Identification number
		</td>
		<td style="{{ $c }}">
			{{-- FILL --}}
			110-81-36497
		</td>
	</tr>

	<tr>
		<td rowspan="5" colspan="2" style="{{ $c }}">
			Seafarer
		</td>
		<td rowspan="2">
			Name of seafarer
		</td>
		<td rowspan="2" colspan="3" style="{{ $c }} height: 20px;">
			{{ $data->user->namefull }}
		</td>
		<td>Date of birth</td>
		<td>{{ $data->user->birthday ? $data->user->birthday->format("d-M-y") : "---" }}</td>
	</tr>

	<tr>
		<td style="height: 20px;">Age</td>
		<td>{{ $data->user->birthday ? $data->user->birthday->age : "---" }}</td>
	</tr>

	<tr>
		<td rowspan="2">Sex</td>
		<td rowspan="2" colspan="3">Male</td>
		<td style="height: 20px;">Birth Place</td>
		<td style="{{ $c }} height: 20px;">{{ $data->birth_place }}</td>
	</tr>

	<tr>
		<td style="height: 20px;">Nationality</td>
		<td>Filipino</td>
	</tr>

	<tr>
		<td colspan="2" style="height: 40px;">
			Address of seafarer
			<br style='mso-data-placement:same-cell;' />
			(in home country)
		</td>
		<td colspan="4" style="{{ $c }}">
			{{ $data->user->address }}
		</td>
	</tr>

	{{ $fill() }}

	{{ $d1("1. Contract Period", true) }}

	{{ $fill() }}

	{{ $d1("1.1 from (" . $start->format('d-M-y') . ") to " . "(" . $start->add($data->employment_months, 'months')->format('d-M-y') . ")") }}
	{{ $d1("1.2 the port of sailing ($data->port) to the port of destination ( NOT FIXED )") }}

	{{ $fill() }}

	{{ $d1("2. Advanced Notice of Rescission of the Seafarer's Employment Contract", true) }}

	{{ $fill() }}
	{{ $d2("If the shipowner of the seafarer wishes to make a rescission of the seafarer's employment contract, to the") }}
	{{ $d2("extent that the seafarer must make an advance notice of rescission to the shipowner before 15 days and to ") }}
	{{ $d2("the extent that the shipowner must make a written advance notice of rescission to the more than 30 days, prior ") }}
	{{ $d2("to the rescission of the contract.") }}

	{{ $fill() }}

	{{ $d1("3. Vessel of Employment and Rank", true) }}

	{{ $fill() }}

	<tr>
		<td colspan="7">3.1 Vessel of Employment</td>
		<td style="{{ $blue }}">{{ $data->vessel->name }}</td>
	</tr>

	{{ $fill() }}

	<tr>
		<td></td>
		<td colspan="2">Official No.</td>
		<td colspan="2" style="{{ $c }}">{{ $data->vessel->imo }}</td>
		<td colspan="2">Flag</td>
		<td style="{{ $c }} {{ $blue }}">{{ $data->vessel->flag }}</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2">Gross Tonnage</td>
		<td colspan="2" style="{{ $c }}">{{ $data->vessel->gross_tonnage }}</td>
		<td colspan="2">Year built (Keel Laying)</td>
		<td style="{{ $c }} {{ $blue }}">{{ $data->vessel->year_build }}</td>
	</tr>

	{{ $fill() }}

	{{ $d1("3.2 Rank: " . $data->pro_app->rank->abbr) }}

	{{ $fill() }}

	{{ $d1("4. Hours of Work and Overtime", true) }}

	{{ $fill() }}

	{{ $d1("4.1. The hours of work on board shall be eight hours in a day and forty hours in a week. ") }}
	{{ $d1("4.2. Overtime ") }}

	{{ $fill() }}

	{{ $d2("1) The hours of work may be extended for sixteen hours as a maximum in a week by the agreement of the") }}
	{{ $d2(" ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎persons concerned.") }}

	{{ $d2("2) Notwithstanding the provision of paragraph 4.2.1), the shipowner may give an order of overtime work") }}
	{{ $d2(" ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎within sixteen hours in a week to the crew who is performing the") }}
	{{ $d2(" ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎duty of navigational watch and within 4 hours in a week to other crew.") }}

	{{ $d2("3) When there is an unavoidable circumstance such as securing the safety of ship operation etc., the") }}
	{{ $d2(" ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎shipowner may give an order of overtime work to the crew even though it exceeds the hours of work") }}
	{{ $d2(" ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎prescribed in paragraphs 1) and 2)") }}

	{{ $fill() }}

	{{ $d1("4.3. Overtime allowance:") }}

	<tr>
		<td colspan="3"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎The shipowner shall pay a (</td>
		<td colspan="2" style="{{ $blue }} {{ $c }}">FIXED / GUARANTEED</td>
		<td colspan="3">) overtime allowance equivalent to the amount to seafarer</td>
	</tr>

	{{ $d2("for the work as provision of paragraph 4.2.") }}

	{{ $fill() }}

	{{ $d1("5. Hours of Rest and Holiday", true) }}

	{{ $fill() }}

	{{ $d1("5.1. The shipowner shall give the crew ten hours of rest or more in any 24 hour period and seventy seven hours") }}
	{{ $d2("of rest or more in any seven-day period.") }}

	{{ $fill() }}

	{{ $d1("5.2. Hours of rest may be divided into no more than two periods, one of which shall be at least six hours in") }}
	{{ $d2("length, and the interval between consecutive periods of rest shall not exceed 14 hours.") }}

	{{ $fill() }}

	{{ $d1("5.3. Holiday of seafarers is Saturday and Sunday and Korean legal holiday, worker’s day.") }}

	{{ $fill() }}

	{{ $d1("6. Daily victualling expenses : USD12.00 / DAY", true) }}

	{{ $fill() }}

	{{ $d1("7. Payment", true) }}

	{{ $fill() }}

	{{ $d1('7.1 Consolidated pay and benefits') }}

	{{ $fill() }}

	@php
		$wage = $data->wage;
		$basic = ceil($wage->basic);
		// if(!in_array($data->id, [1243, 1422, 1657, 1703, 1730, 1773, 2013, 2672, 2767])){
		// 	dd($data->id, $basic, $wage);
		// }
		$ot = number_format(ceil($basic / 173 * 103 * 1.25), 2);
		$lp = number_format(ceil($basic * 9 / 30), 2);
		$sa = number_format(ceil($wage->sup_allow ?? 0), 2);
		$ccb = number_format(ceil(0), 2);

		$total = number_format($basic + $ot + $lp + $sa + $ccb, 2);
	@endphp

	{{ $d2("1) Basic wage : " . $basic . " (USD)") }}
	{{ $d2("2) Guaranteed Overtime Allowance") }}
	{{ $d2(" ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎O/T : " . $ot . "(USD) * Calculation method : Basic wage / 173HRS X 103hrs x 1.25") }}
	{{ $d2("3) Leave pay : " . $lp . "(USD) * Calculation method : Basic wage x 9days / 30days") }}
	{{ $d2("4) F/S/A (Fixed Supervision Allowance) if applicable : " . $sa . " (USD)") }}
	{{ $d2("5) C/B(Contract completion Bonus) : " . $ccb . " (USD)") }}
	{{ $d2("6) Monthly total : " . $total . " (USD) * Calculation Method : 1)+2)+3)+4)+5)") }}
	{{ $d2("7) GOVT. Tax deduction : AS REGULATIONS") }}
	{{ $d2("8) Health and social security protection benefits") }}
	{{ $d2(" ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎- Shipowner provides medical care, sickness benefit, employment injury benefit, invalidity benefit, family") }}
	{{ $d2(" ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎benefit and survivors benefit to the seafarer.") }}

	{{ $fill() }}

	{{ $d1("7.2. Payment date:") }}
	{{ $d2("(   ) of every following month. If the payment date falls on a holiday, payment will be made on the day") }}
	{{ $d2("before the holiday.") }}

	{{ $fill() }}

	{{ $d1("7.3. Payment methods: ") }}
	{{ $d2("Payment will be paid to seafarer or credited to the bank account of seafarer.") }}

	{{ $fill() }}

	{{ $d1("8. Paid Leave", 2) }}

	{{ $fill() }}

	{{ $d1("8.1. The shipowner shall provide paid leave to the seafarer who has completed ( 8 ) months of continuous service") }}
	{{ $d2("on board(services on the vessel in repair or laid up shall be included) within ( 4 ) months from the time of") }}
	{{ $d2("However, the commencement of paid leave may be extended until the vessel's entry into port when the") }}
	{{ $d2("vessel is under way.") }}

	{{ $fill() }}

	{{ $d1("8.2. The leave pay should be given to seafarers even though the seafarers could not complete the contract.") }}

	{{ $fill() }}

	{{ $d1("8.3. The number of days of paid leave pursuant to 7.1 and 7.2 shall be ( 9 ) days per one month of continuous") }}
	{{ $d2("service on board.") }}

	{{ $fill() }}

	{{ $d1("8.4. In the calculation of the number of days of paid leave, the service period on board of less than one month") }}
	{{ $d2("shall be calculated at a rate of days, but a fraction of less than one day shall be one day.") }}

	{{ $fill() }}

	{{ $d1("8.5. The time and place of port granting paid leave shall be decided on the negotiation between the shipowner") }}
	{{ $d2("and the seafarer.") }}

	{{ $fill() }}

	{{ $d1("8.6. The shipowner shall pay basic wages to the seafarer during the seafarer's vacation as an allowance for paid") }}
	{{ $d2("leave.") }}

	{{ $fill() }}

	{{ $d1("9. Repatriation", true) }}
	{{ $d1("9.1. Shipowner shall ensure that seafarers are entitled to repatriation in the following circumstances.") }}

	{{ $fill() }}

	{{ $d2("1) If the seafarers’ employment agreement expires while they are aboard") }}
	{{ $d2("2) When the seafarers’ employment agreement in terminated by the shipowner or by the seafarer for") }}
	{{ $d2(" ‎‏‏‎ ‎‏‏‎ ‎‏‏‎justified reasons") }}
	{{ $d2("3) When the seafarers are no longer able to carry out their duties under their employment agreement or ") }}
	{{ $d2(" ‎‏‏‎ ‎‏‏‎ ‎‏‏‎cannot be excepted to carry them out in the specific circumstance") }}

	{{ $fill() }}
	{{ $d1("9.2. If the repatriation is serious default of the seafarer’s employment obligations notwithstanding the provision") }}
	{{ $d2("of paragraph 8.1,the seafarer shall be liable a subset of the cost of repatriation in accordance with collective") }}
	{{ $d2("agreement.") }}

	{{ $fill() }}
	{{ $d1("9.3. Shipowner shall promptly repatriate the seafarer to the country of residence of the seafarer(seafarer’s address") }}
	{{ $d2("in first page of this contract) or the place at which the seafarer was hired as shipowner’s expenses when") }}
	{{ $d2("leaves a ship at the place of which is not the seafarer's country of residence or the place at which the.") }}
	{{ $d2("seafarer agreed to enter into the engagement. However, in case where shipowner paid the expense of") }}
	{{ $d2("repatriation according shipowner to the request of seafarer, does not have any responsibility for the") }}
	{{ $d2("repatriation.") }}

	{{ $fill() }}
	<tr>
		<td style="{{ $b }}">10.</td>
		<td colspan="7">
			Seafarer’s employment agreement shall continue to have effect while a seafarer is held captive on or off
		</td>
	</tr>
	{{ $d2("the ship as a result of acts of piracy or armed robbery against ships, regardless of whether the date fixed") }}
	{{ $d2("for its expiry has passed or either party has given notice to suspend or terminate it.") }}

	{{ $fill() }}
	<tr>
		<td style="{{ $b }}">11.</td>
		<td colspan="7">
			Shipowner shall cover the health and social security protection benefits to be provided to the seafarer by 
		</td>
	</tr>
	{{ $d2("due process of low. And the terms not regulated in this contract will follow the provisions of the Collective") }}
	{{ $d2("Bargaining Agreement (CBA) on the International ship.") }}

	{{ $fill() }}
	<tr>
		<td style="{{ $b }}">12.</td>
		<td colspan="7">
			Before autographing to this contract, the seafarer confirmed that no fees or other charges for recruitment or
		</td>
	</tr>
	{{ $d2("placement or for providing employment to seafarers are borne directly or indirectly, in whole or in part, to") }}
	{{ $d2("the agent of seafarer recruitment and placement. (other than the cost of the seafarer obtaining the seafarer’s") }}
	{{ $d2("book and a passport or other similar personal travel documents.)") }}
	{{ $d2("If the seafarer found that, the fact should be noticed to the shipowner immediately.") }}

	{{ $fill() }}
	{{ $d1("13. The place of conclude contract:", true) }}

	{{ $fill() }}
	{{ $d1("14. The time of conclude contract (dd/mm/yy): DD / MMM / YYYY", true) }}

	{{ $fill() }}
	<tr>
		<td style="{{ $b }}">15.</td>
		<td colspan="7">
			Before autographing to this contract, the seafarer confirmed that no fees or other charges for recruitment or
		</td>
	</tr>
	{{ $d2("Seafarers signing a seafarers' employment agreement be given an opportunity to examine and seek advice ") }}
	{{ $d2("on the agreement before signing, as well as such other facilities as are necessary to ensure that they have ") }}
	{{ $d2("freely entered into an agreement with a sufficient understanding of their rights and responsibilities.") }}

	{{ $fill() }}
	<tr>
		<td colspan="5" style="text-align: right;">Shipowner  ‎‏‏‎ ‎‏‏‎ ‎‏‏‎:  ‎‏‏‎ ‎‏‏‎ ‎‏‏‎</td>
		<td colspan="3">CHANG MYUNG SHIPPING</td>
	</tr>

	{{ $fill() }}
	<tr>
		<td colspan="5" style="text-align: right;">or Agent on behalf of shipowner ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ :  ‎‏‏‎ ‎‏‏‎ ‎‏‏‎</td>
		<td colspan="3" style="text-align: right;">(signature or seal)</td>
	</tr>

	{{ $fill() }}
	<tr>
		<td colspan="5" style="text-align: right;">Seafarer  ‎‏‏‎ ‎‏‏‎ ‎‏‏‎:  ‎‏‏‎ ‎‏‏‎ ‎‏‏‎</td>
		<td colspan="3" style="text-align: right;">(signature or seal)</td>
	</tr>

	{{ $fill() }}
	<tr>
		<td colspan="4">Distribution of Employment Contract</td>
		<td colspan="4"></td>
	</tr>
	<tr>
		<td colspan="3">1. Master (Vessel)</td>
		<td style="text-align: right;">-</td>
		<td colspan="4"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎Copy</td>
	</tr>
	<tr>
		<td colspan="3">Seafarer</td>
		<td style="text-align: right;">-</td>
		<td colspan="4"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ Original</td>
	</tr>
	<tr>
		<td colspan="3">Agency</td>
		<td style="text-align: right;">-</td>
		<td colspan="4"> ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ Original</td>
	</tr>
</table>