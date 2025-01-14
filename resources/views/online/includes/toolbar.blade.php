<div class="pull-left" id="cFilters">
</div>

<div class="pull-right">
	<a href="{{ route('applications.index') }}" class="btn btn-info" data-toggle="tooltip" title="View All">
		<span class="fa fa-list"></span>
	</a>
	<a href="{{ route('applications.create') }}" class="btn btn-primary" data-toggle="tooltip" title="Add New Crew">
		<span class="fa fa-plus"></span>
	</a>
	<a class="btn btn-warning" data-toggle="tooltip" title="Filter" onclick="filter()">
		<span class="fa fa-filter"></span>
	</a>
	<a class="btn btn-success" data-toggle="tooltip" title="Awardees" href="{{ route('applications.awardees') }}">
		<span class="fa fa-trophy"></span>
	</a>
</div>