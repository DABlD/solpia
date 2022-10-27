<div class="pull-right">
	<a href="{{ route('vessels.index') }}" class="btn btn-info" data-toggle="tooltip" title="View All">
		<span class="fa fa-list"></span>
	</a>
	@if(auth()->user()->role == "Admin")
		<a class="btn btn-warning" data-toggle="tooltip" title="Import Vessels">
			<span class="fa fa-upload"></span>
		</a>
		<a class="btn btn-danger" data-toggle="tooltip" title="Export Vessels">
			<span class="fa fa-download"></span>
		</a>
	@endif
	<a class="btn btn-success" data-toggle="tooltip" title="Export" onclick="exportData()">
		<span class="fa fa-download"></span>
	</a>
	<a class="btn btn-primary" data-toggle="tooltip" title="Add Vessel">
		<span class="fa fa-plus"></span>
	</a>
</div>