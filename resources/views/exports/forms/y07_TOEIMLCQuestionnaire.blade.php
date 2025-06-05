<style>
	.center{
		text-align: center;
	}

	.und{
		text-decoration: underline;
	}

	.bold{
		font-weight: bold;
	}

	span{
		color: white;
	}

	body{
		font-size: 14px;
		font-family: DejaVu Sans;
	}
</style>

<table>
	<tr>
		<td class="center und" colspan="10" style="font-size: 16px;">
			Questionnaires to Seafarers on Employment Contract
		</td>
	</tr>

	<tr>
		<td class="center und" colspan="10" style="font-size: 16px;">
			& condition of SRPS per MLC-2006
		</td>
	</tr>

	<tr>
		<td class="center und" colspan="10" style="font-size: 16px;">
			(Entries in below questions shall be made by hand writing. Make round
		</td>
	</tr>

	<tr>
		<td class="center und" colspan="10" style="font-size: 16px;">
			mark at corresponding 'Yes' or 'No')
		</td>
	</tr>

	<tr><td style="height: 60px;"></td></tr>

	<tr>
		<td colspan="2">Name of Seafarer:</td>
		<td colspan="3" class="und">{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }}</td>
		<td colspan="2">Seaman Book (CDC) No:</td>
		<td colspan="3" class="und">{{ isset($data->document_id->{"SEAMAN'S BOOK"}) ? $data->document_id->{"SEAMAN'S BOOK"}->number : "---"  }}</td>
	</tr>

	<tr><td style="height: 30px;"></td></tr>

	<tr>
		<td colspan="10" class="bold">
			[1] Employment Contract (per Regulation 1.4, Standard A1.4 - 5 (e) :
		</td>
	</tr>

	<tr><td style="height: 25px;"></td></tr>

	<tr>
		<td colspan="10"><span>----</span>1. Name of assigned vessel & its flag: M/V "{{ $data->vessel->name }}" / {{ $data->vessel->flag }}</td>
	</tr>

	<tr>
		<td colspan="10"><span>----</span>2. Rank to work on board:</td>
	</tr>

	<tr>
		<td colspan="10"><span>----</span>3. Name of employer (Nitta Kisen Japan):</td>
	</tr>

	<tr>
		<td colspan="10"><span>----</span>4. Period of employment ({{ $data->pro_app->mob ?? " " }}) months</td>
	</tr>

	<tr>
		<td colspan="10"><span>----</span>5. Basic hours of work per week: (40) hours</td>
	</tr>

	<tr>
		<td colspan="10"><span>----</span>6. Monthly wage: Basic wage (US${{ $data->wage['basic'] }}),</td>
	</tr>

	<tr>
		<td colspan="10"><span>----</span><span>---</span>Fixed Over Time(FOT) allowance (US${{ $data->wage['fot'] ?? 0 }}), OT Rate: US${{ $data->wage['ot'] ?? 0 }} /hours</td>
	</tr>

	<tr>
		<td colspan="10"><span>----</span>7. Monthly Guaranteed OT hours: (<span>---</span>)Hours</td>
	</tr>

	<tr><td style="height: 30px;"></td></tr>

	<tr>
		<td colspan="10" class="bold">
			[2] Awareness of SRPS of MLC-2006:
		</td>
	</tr>

	<tr><td style="height: 30px;"></td></tr>

	<tr>
		<td colspan="10"><span>----</span>1. (Regulation 1.4, Standard A1.4 - 5) (m): Explain below to seafarers prior to</td>
	</tr>

	<tr>
		<td colspan="10"><span>-------</span>joining and confirm his awareness</td>
	</tr>

	<tr><td style="height: 25px;"></td></tr>

	<tr>
		<td colspan="10"><span>--------</span>1.) Posted Company motto (Clean, honest fair & others) in office</td>
	</tr>

	<tr>
		<td colspan="10"><span>--------</span>2.) Posted MLC-2006 Seafarer Protection Spirits (5) which are incorporated into</td>
	</tr>

	<tr>
		<td colspan="10"><span>------------</span>Crewing Manager's Company / Manning Company Manual:</td>
	</tr>

	<tr>
		<td colspan="10"><span>------------</span>&#9312; Equal opportunities policy</td>
	</tr>

	<tr>
		<td colspan="10"><span>------------</span>&#9313; Health and safety policy</td>
	</tr>

	<tr>
		<td colspan="10"><span>------------</span>&#9314; Data protection policy</td>
	</tr>

	<tr>
		<td colspan="10"><span>------------</span>&#9315; Complaints Policy</td>
	</tr>

	<tr>
		<td colspan="10"><span>------------</span>&#9316; No exploitation in connection with seafarer employment, placement,</td>
	</tr>

	<tr>
		<td colspan="10"><span>---------------</span>promotion and financial transaction</td>
	</tr>

	<tr>
		<td colspan="10"><span>--------</span>3.) Company has been maintaining over 15 years to dismiss any staffs who are</td>
	</tr>

	<tr>
		<td colspan="10"><span>------------</span>involved in exploitation from seafarers</td>
	</tr>

	<tr><td style="height: 60px;"></td></tr>

	<tr>
		<td colspan="10"><span>--------</span>4.) Monitoring through vessel's other nationalities senior officers if any crew</td>
	</tr>

	<tr>
		<td colspan="10"><span>------------</span>paid money to company / staff:</td>
	</tr>

	<tr>
		<td colspan="10"><span>--------</span>5.) Have you oriented with above company policies? (Yes / No). Fully</td>
	</tr>

	<tr>
		<td colspan="10"><span>------------</span>acknowledged? (Yes / No)</td>
	</tr>

	<tr><td style="height: 30px;"></td></tr>

	<tr>
		<td colspan="10"><span>----</span>2. (Regulation 1.4, Standard A1.4 - 5) (d):</td>
	</tr>

	<tr>
		<td colspan="10"><span>--------</span>1) Did you attend MLC-2006 (Seafarer's right) orientation? (Yes / No)</td>
	</tr>

	<tr>
		<td colspan="10"><span>--------</span>2) Did you understand the contents of collective bargaining agreement*?</td>
	</tr>

	<tr>
		<td colspan="10"><span>------------</span>(Yes / No)</td>
	</tr>

	<tr><td style="height: 15px;"></td></tr>

	<tr>
		<td colspan="10"><span>------------</span>*collective bargaining agreement means;</td>
	</tr>

	<tr>
		<td colspan="10"><span>------------</span>a) For Korean Crew : KSSU General Agreement (Annex I of Crewing Agreement)</td>
	</tr>

	<tr>
		<td colspan="10"><span>------------</span>b) For Filipino Crew :  IBF JSU/AMOSUP-IMMAJ CBA</td>
	</tr>

	<tr>
		<td colspan="10"><span>------------</span>c) For Myanmar Crew : SECD General Agreement</td>
	</tr>

	<tr><td style="height: 20px;"></td></tr>

	<tr>
		<td colspan="10"><span>--------</span>3) When and who was the Lecturer at that time?</td>
	</tr>

	<tr>
		<td colspan="10"><span>------------</span>(Date:_______________________, Name of lecturer: Capt. Manfred August U. Ramos)</td>
	</tr>

	<tr><td style="height: 30px;"></td></tr>

	<tr>
		<td colspan="10"><span>----</span>3. Guideline B1.4 - 2 Organizational and operational guidelines (p):</td>
	</tr>

	<tr>
		<td colspan="10"><span>--------</span>1) Were you advised for any particular job assignment other than routine job?</td>
	</tr>

	<tr>
		<td colspan="10"><span>------------</span>(Yes / No)</td>
	</tr>

	<tr>
		<td colspan="10"><span>--------</span>2) If advised, what kinds of job?</td>
	</tr>

	<tr>
		<td colspan="10"><span>------------</span>(__________________________________________________________)</td>
	</tr>

	<tr><td style="height: 20px;"></td></tr>

	<tr>
		<td colspan="10"><span>----</span>4. Regulation 5.1.5 Complaints Procedures</td>
	</tr>

	<tr><td style="height: 30px;"></td></tr>

	<tr>
		<td colspan="10" class="bold"><span>--------</span>a) Prior joining, are you informed and given familiarization regarding on</td>
	</tr>

	<tr>
		<td colspan="10" class="bold"><span>------------</span>board complaint procedure? (Yes / No)</td>
	</tr>

	<tr><td style="height: 40px;"></td></tr>

	<tr>
		<td colspan="5">
			<span>--------</span>
			<span class="und" style="color: black;">
				(sig)
				<span>___________________________________</span>
			</span>
		</td>
		<td colspan="5">
			<span>------</span>
			<span class="und" style="color: black;">
				(sig)
				<span>___________________________________</span>
			</span>
		</td>
	</tr>

	<tr>
		<td colspan="5">
			<span>--------</span>
			Seafarer name: {{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }}
		</td>
		<td colspan="5">
			<span>------</span>
			Received by Master of
		</td>
	</tr>

	<tr>
		<td colspan="5">
			<span>--------</span>
			Date: {{ now()->format("d-M-Y") }}
		</td>
		<td colspan="5">
			<span>------</span>
			M/V "{{ $data->vessel->name }}"
		</td>
	</tr>

	<tr>
		<td colspan="5"></td>
		<td colspan="5">
			<span>------</span>
			Date: 
		</td>
	</tr>

	<tr><td style="height: 20px;"></td></tr>

	<tr>
		<td colspan="10">
			NOTE:
		</td>
	</tr>

	<tr>
		<td colspan="10">
			<span>--</span>
			ENGINE OFFICERS (DECK INC.) VALID NATL LICENSE - ALL YES
		</td>
	</tr>

	<tr>
		<td colspan="10">
			GMDSS - DECK OFFICERS - YES
		</td>
	</tr>

	<tr>
		<td colspan="10">
			<span>-----------</span>
			ENGINE - NO
		</td>
	</tr>

	<tr>
		<td colspan="10">
			CORRECT SPELLING OF LICENSE
		</td>
	</tr>
</table>