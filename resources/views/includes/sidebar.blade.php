<aside class="main-sidebar">

	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<div class="user-panel">
			<div class="pull-left image">
				<img src="{{ asset('uploads/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p>Alexander Pierce</p>
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
			<li class="header">MAIN NAVIGATION</li>
	
			@php 
				$routes = Route::getRoutes();
			@endphp

			@foreach($routes as $route)
				{{-- Check if route is a sidebar --}}
				@if(isset($route->defaults['sidebar']))
					{{-- Check if route is for current role --}}
					@if(in_array(Auth::user()->role, $route->defaults['roles']))
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