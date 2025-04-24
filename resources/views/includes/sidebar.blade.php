<aside class="main-sidebar" style="margin-top: 20px;">

	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<div class="user-panel">
			<div class="pull-left image">
				{{-- @if(in_array(auth()->user()->id, [23,5963]))
					<img src="{{ asset('images/g1.png')}}" class="img-circle" alt="User Image">
				@else --}}
					<img src="{{ asset(auth()->user()->avatar)}}" class="img-circle" alt="User Image">
				{{-- @endif --}}
			</div>
			<div class="pull-left info">
				<p>{{ auth()->user()->fullname }}</p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>

		<form action="#" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
					<button type="submit" name="search" id="search-btn" class="btn btn-flat">
						<i class="fa fa-search"></i>
					</button>
				</span>
			</div>
		</form>

		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu" data-widget="tree">
			{{-- <li class="header">MAIN NAVIGATION</li> --}}
	
			@php 
				$routes = Route::getRoutes();1
			@endphp

			@foreach($routes as $route)
				{{-- Check if route is a sidebar --}}
				@if(isset($route->defaults['sidebar']))
					{{-- Check if route is for current role --}}
					@if(in_array(Auth::user()->role, $route->defaults['roles']) || (isset($route->defaults['sped']) && in_array(auth()->user()->id, $route->defaults['sped'])))
						<li class="{{ str_contains(request()->path(), $route->uri) ? 'active' : '' }}">
							<a href="{{ url($route->defaults['href']) }}">
								<i class="fa {{ $route->defaults['icon'] }}"></i> 
								<span>{{ $route->defaults['name'] }}</span>
								{{-- <span class="pull-right-container">
									<small class="label pull-right bg-red">3</small>
								</span> --}}
							</a>
						</li>
					@endif
				@endif
			@endforeach
		</ul>
	</section>
</aside>

@push('after-scripts')
	<script>
		@if(Auth::user()->role == "")
			swal({
				type: 'warning',
				title: 'Access limited',
				text: 'No system role has been set for this account'
			});
		@endif
	</script>
@endpush