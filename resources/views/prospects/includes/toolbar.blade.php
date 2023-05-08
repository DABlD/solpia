<div class="pull-right">
	<a class="btn btn-success" data-toggle="tooltip" title="Add Applicant" onclick="create()">
		<span class="fa fa-plus"></span>
	</a>
	{{-- @if(auth()->user()->role == "Admin") --}}
		<a class="btn btn-primary" data-toggle="tooltip" title="Import" onclick="imp()">
			<span class="fa fa-download"></span>
		</a>
	{{-- @endif --}}
	<a class="btn btn-warning" data-toggle="tooltip" title="Report" onclick="report()">
		<span class="fa fa-file"></span>
	</a>
	<a class="btn btn-info" data-toggle="tooltip" title="Filter" onclick="filter()">
		<span class="fa fa-filter"></span>
	</a>
</div>