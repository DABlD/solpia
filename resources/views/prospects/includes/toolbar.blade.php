<div class="pull-right">
	<a class="btn btn-success" data-toggle="tooltip" title="Add Applicant" onclick="create()">
		<span class="fa fa-plus"></span>
	</a>
	@if(auth()->user()->role == "Admin")
		<a class="btn btn-primary" data-toggle="tooltip" title="Import" onclick="imp()">
			<span class="fa fa-download"></span>
		</a>
		<a class="btn btn-info" data-toggle="tooltip" title="Import 2" onclick="imp2()">
			<span class="fa fa-download"></span>
		</a>
		<a class="btn btn-success" data-toggle="tooltip" title="Import 3" onclick="imp3()">
			<span class="fa fa-download"></span>
		</a>
	@endif
</div>