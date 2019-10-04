<table>
	<tr></tr>

	<tr>
		<td rowspan="2" colspan="5"></td>
		<td></td>
		<td rowspan="2" colspan="9">
			FORM SP08-06(1/1) / 0 15.12.21
		</td>
	</tr>

	<tr></tr>

	<tr>
		<td rowspan="2">1st (Manning Company)</td>
		<td>Rank/Name</td>
		<td colspan="2">
			CREWING MANANGER<br>
			THEA GUERRA
		</td>
		<td rowspan="2" colspan="2">2nd (Interges)</td>
		<td colspan="5">Rank/Name</td>
		<td colspan="4">
			{{ isset($applicant->rank) ? '(' . $applicant->rank->abbr . ') / ' : '-----' }} {{ $applicant->user->lname . ', ' . $applicant->user->fname . ' ' . $applicant->user->suffix . ' ' . $applicant->user->mname[0] }}
		</td>
	</tr>

	<tr>
		<td>Sign</td>
		<td colspan="2"></td>
		<td colspan="5">Sign</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="2">Recruitment Status</td>
		<td colspan="3">Employable/Unemployable</td>
		<td colspan="5">Confirm by D.P.</td>
		<td colspan="5"></td>
	</tr>

	<tr></tr>
	<tr>
		<td colspan="15"></td>
	</tr>
	<tr></tr>

	<tr>
		<td colspan="15">(Table) Standard for Onboard Career</td>
	</tr>
	<tr>
		<td colspan="2">Type of Vessel</td>
		<td colspan="2">Rank</td>
		<td colspan="6">Career</td>
		<td colspan="5">Score</td>
	</tr>

	{{-- 1st ROW --}}
	<tr>
		<td rowspan="6" colspan="2">
			Same type of vessel on Interges Fleets in the past five years
		</td>
		<td rowspan="2" colspan="2">Same Rank</td>
		<td colspan="6">More than 1 year</td>
		<td colspan="5">35</td>
	</tr>

	<tr>
		<td colspan="6">Under 1 year</td>
		<td colspan="5">32</td>
	</tr>

	<tr>
		<td rowspan="4" colspan="2">Lower Rank</td>
		<td colspan="6">More than 3 years</td>
		<td colspan="5">30</td>
	</tr>

	<tr>
		<td colspan="6">More than 2 years</td>
		<td colspan="5">25</td>
	</tr>

	<tr>
		<td colspan="6">More than 1 year</td>
		<td colspan="5">20</td>
	</tr>

	<tr>
		<td colspan="6">Under 1 year</td>
		<td colspan="5">10</td>
	</tr>

	{{-- 2nd ROW --}}
	<tr>
		<td rowspan="6" colspan="2">
			Same type of vessel on Other Company in the past five  years
		</td>
		<td rowspan="2" colspan="2">Same Rank</td>
		<td colspan="6">More than 1 year</td>
		<td colspan="5">30</td>
	</tr>

	<tr>
		<td colspan="6">Under 1 year</td>
		<td colspan="5">27</td>
	</tr>

	<tr>
		<td rowspan="4" colspan="2">Lower Rank</td>
		<td colspan="6">More than 3 years</td>
		<td colspan="5">25</td>
	</tr>

	<tr>
		<td colspan="6">More than 2 years</td>
		<td colspan="5">20</td>
	</tr>

	<tr>
		<td colspan="6">More than 1 year</td>
		<td colspan="5">15</td>
	</tr>

	<tr>
		<td colspan="6">Under 1 year</td>
		<td colspan="5">10</td>
	</tr>

	{{-- 3rd ROW --}}
	<tr>
		<td rowspan="6" colspan="2">
			Different type of vessel on Other Company in the past five years
		</td>
		<td rowspan="2" colspan="2">Same Rank</td>
		<td colspan="6">More than 1 year</td>
		<td colspan="5">25</td>
	</tr>

	<tr>
		<td colspan="6">Under 1 year</td>
		<td colspan="5">22</td>
	</tr>

	<tr>
		<td rowspan="4" colspan="2">Lower Rank</td>
		<td colspan="6">More than 3 years</td>
		<td colspan="5">20</td>
	</tr>

	<tr>
		<td colspan="6">More than 2 years</td>
		<td colspan="5">15</td>
	</tr>

	<tr>
		<td colspan="6">More than 1 year</td>
		<td colspan="5">10</td>
	</tr>

	<tr>
		<td colspan="6">Under 1 year</td>
		<td colspan="5">5</td>
	</tr>
</table>