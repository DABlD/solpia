<aside class="main-sidebar">

	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<div class="user-panel">
			<div class="pull-left image" id="user-avatar">
				<canvas id="confettiCanvas"></canvas>
				@if(in_array(auth()->user()->id, [23,5963]))
					<img src="{{ asset('images/g2.png')}}" class="img-circle" alt="User Image" id="avatar">
				@else
					<img src="{{ asset(auth()->user()->avatar)}}" class="img-circle" alt="User Image">
				@endif
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
	<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

	<script>
		@if(Auth::user()->role == "")
			swal({
				type: 'warning',
				title: 'Access limited',
				text: 'No system role has been set for this account'
			});
		@endif

		@if(in_array(Auth::user()->id, [23,5963]))
			const img = document.getElementById('avatar');

	        img.addEventListener('click', () => {
	            if (img.requestFullscreen) {
	                document.getElementById("user-avatar").requestFullscreen();

	                let confettiCanvas = document.getElementById("confettiCanvas");
	                let myConfetti = confetti.create(confettiCanvas, { resize: true, useWorker: true });



	                for (let i = 1; i < 10; i++) {
	                    setTimeout(() => {
	                    	myConfetti({
	                    		particleCount: 500,
	                    		spread: 360,
	                    		origin: { x:Math.random(), y: Math.random() }
	                    	});
	                    }, i * 500);
	                }

					for (let i = 1; i < 12; i++) {
					    setTimeout(() => {
					    	launchBalloons();
					    }, i * 700);
					}
	            }
	        });
        @endif

		function launchBalloons() {
			for (let i = 0; i < 10; i++) {
				let balloon = document.createElement("div");
				balloon.innerHTML = "🎈";
				balloon.classList.add("balloon");
				balloon.style.left = Math.random() * 100 + "vw";
				balloon.style.fontSize = Math.random() * 30 + 30 + "px";
				{{-- document.body.appendChild(balloon); --}}
				{{-- img.appendChild(balloon); --}}
				$('#user-avatar').append(balloon);

				setTimeout(() => balloon.remove(), 10000);
			}
		}
	</script>
@endpush