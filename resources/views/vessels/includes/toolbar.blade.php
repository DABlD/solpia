<div class="pull-right">
	<a class="btn btn-info" data-toggle="tooltip" title="Filter" onclick="filter()">
		<span class="fa fa-filter"></span>
	</a>
	@if(auth()->user()->role == "Admin")
		<a class="btn btn-warning" data-toggle="tooltip" title="Import Vessels">
			<span class="fa fa-upload"></span>
		</a>
		<a class="btn btn-danger" data-toggle="tooltip" title="Export Vessels">
			<span class="fa fa-download"></span>
		</a>
	@endif
	{{-- <a class="btn btn-success" data-toggle="tooltip" title="Export" onclick="exportData()">
		<span class="fa fa-download"></span>
	</a> --}}
	<a class="btn btn-primary" data-toggle="tooltip" title="Add Vessel">
		<span class="fa fa-plus"></span>
	</a>
	<a class="btn btn-success" data-toggle="tooltip" title="Export Crew Change Plan" onclick="exportCrewChangePlan()">
		<span class="fa fa-users"></span>
		<span class="fa fa-exchange"></span>
		<span class="fa fa-users"></span>
	</a>
	<a class="btn btn-default" data-toggle="tooltip" title="Export" onclick="exportDocs()">
		<span class="fa fa-file"></span>
	</a>
</div>