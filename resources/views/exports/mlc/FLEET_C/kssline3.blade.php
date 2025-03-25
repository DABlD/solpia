<table>
	<tr>
		<td>Code</td>
		<td>1</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<td>5</td>
		<td>6</td>
		<td>7</td>
		<td>8</td>
		<td>9</td>
		<td>10</td>
	</tr>

	<tr>
		<td>No.</td>
		<td>Rank</td>
		<td>Basic wage</td>
		<td>Fixed guaranteed</td>
		<td>Leave pay</td>
		<td>Fixed supervisor</td>
		<td>Subsistence allowance</td>
		<td>Contract completion</td>
		<td>Special allowance</td>
		<td>Monthly wage</td>
		<td>FKSU Member fee</td>
	</tr>

	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	@php
		$vessels = [
			["MASTER",null,null,null,null,null,null,null,null,null],
			["C/O",1895,1411,569,525,68,80,4352,8900,40],
			["2/O",1219,908,366,110,68,80,1749,4500,40],
			["3/O",1067,795,321,0,68,80,1069,3400,40],
			["C/E",null,null,null,null,null,null,null,null,null],
			["1/E",1895,1411,569,525,68,80,4352,8900,40],
			["2/E",1219,908,366,110,68,80,1749,4500,40],
			["3/E",1067,795,321,0,68,80,1069,3400,40],
			["G/E",1219,908,366,110,68,80,1749,4500,40],
			["BSN",771,574,232,0,68,50,255,1950,40],
			["P/M",771,574,232,0,68,50,155,1850,40],
			["AB",702,523,211,0,68,50,0,1554,40],
			["OS",528,393,159,0,68,50,0,1198,40],
			["OL1",771,574,232,0,68,50,255,1950,40],
			["OLR",702,523,211,0,68,50,0,1554,40],
			["WPR",528,393,159,0,68,50,0,1198,40],
			["CST",771,574,232,0,68,50,255,1950,40],
			["2CK",702,523,211,0,68,50,0,1554,40],
			["MM",528,393,159,0,68,50,0,1198,40],
			["A/O",0,0,0,0,0,0,350,350,0],
			["A/E",0,0,0,0,0,0,350,350,0],
			["DB",255,0,77,0,68,50,0,450,40]
		];
	@endphp

	@foreach($vessels as $vessel)
		<tr>
			<td>{{ $loop->index+1 }}</td>
			<td>{{ $vessel[0] }}</td>
			<td>{{ $vessel[1] }}</td>
			<td>{{ $vessel[2] }}</td>
			<td>{{ $vessel[3] }}</td>
			<td>{{ $vessel[4] }}</td>
			<td>{{ $vessel[5] }}</td>
			<td>{{ $vessel[6] }}</td>
			<td>{{ $vessel[7] }}</td>
			<td>{{ $vessel[8] }}</td>
			<td>{{ $vessel[9] }}</td>
		</tr>
	@endforeach
</table>