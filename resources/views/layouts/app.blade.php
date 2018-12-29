<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ env('app_name') . ' | ' . $title }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/all-skins.min.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  @stack('after-styles')

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  
  @include('includes.header')
  @include('includes.sidebar')

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        {{ $title }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        @stack('breadcrumbs')
        <li class="active">{{ $title }}</li>
      </ol>
    </section>

    @yield('content')
  </div>

  <footer class="main-footer">
    <strong>Copyright &copy; {{ $cpYear }} <a href="https://github.com/DABlD/" target="_blank">David Mendoza</a>.</strong> All rights
    reserved.
  </footer>
</div>

  {{-- <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GMAP_API_KEY') }}"></script> --}}

  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/adminlte.min.js') }}"></script>
  <script src="{{ asset('js/swal.js') }}"></script>

  <script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })

    @if ($errors->any())
      swal({
        type: 'error',
        html: 
          @foreach ($errors->all() as $error)
              "{!! $error !!}<br/>"
          @endforeach
      });
    @elseif (session('success'))
      swal({
        type: 'success',
        title: '{{ session('success') }}',
      });
    @elseif (session('error'))
      swal({
        type: 'error',
        title: '{{ session('error') }}',
      });
    @endif

  </script>

  @stack('before-scripts')
  @stack('after-scripts')
</body>
</html>
