<div style="text-align: center;">
	<h1>
		{{ $data['data']['vname'] }}
		<br>
		Acknowledgement of Crew Reminders
		<br>
		and Disembarkation Notice
	</h1>

	<br>
	<br>

	I hereby acknowledge that I have received the attachments provided to me and have been
	<br>
	properly reminded by SOLPIA MARINE & SHIP MANAGEMENT, INC., as well as our ship
	<br>
	master, regarding the rules and regulations that must be followed during my disembarkation.
	<br>
	These reminders clearly outlined the items and actions that are prohibited and restricted while
	<br>
	leaving the vessel during my repatriation.
	<br>
	<br>
	I fully understand and accept that I will be held responsible for any issues or violations that
	<br>
	may arise in connection with these reminders during my disembarkation process.

	<br>
	<br>

	<table style="width: 100%;">
		<tr>
			<td style="width: 45%;">RANK/NAME</td>
			<td style="width: 5%;"></td>
			<td style="width: 15%;">DATE:</td>
			<td style="width: 5%;"></td>
			<td style="width: 30%;">SIGNATURE</td>
		</tr>

		@foreach($data['applicants'] as $crew)
			<tr>
				<td style="font-size: 14px;">{{ $loop->index+1 }}. {{ $crew->pro_app->rank->abbr }} {{ $crew->user->namefull }}</td>
				<td></td>
				<td style="border-bottom: 1px solid;"></td>
				<td></td>
				<td style="border-bottom: 1px solid;"></td>
			</tr>
		@endforeach
	</table>
</div>