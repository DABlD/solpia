@extends('layouts.app')
@section('content')
    <section class="content">

      {{-- Boxes --}}
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $applicants }}</h3>

              <p>Total Crew</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              {{-- <h3>53<sup style="font-size: 20px">%</sup></h3> --}}
              <h3>{{ $onBoard }}</h3>

              <p>On Board Crew</p>
            </div>
            <div class="icon">
              <i class="fa fa-anchor"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ $linedUp }}</h3>

              <p>Lined-Up Crew</p>
            </div>
            <div class="icon">
              <i class="fa fa-level-up"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $vessels }}</h3>

              <p>Active Vessels</p>
            </div>
            <div class="icon">
              <i class="fa fa-ship"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
          </div>
        </div>
      </div>

      {{-- ROW --}}
      <div class="row">
        <section class="col-lg-8 connectedSortable">
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-file"></i>

              <h3 class="box-title">Expiring Documents</h3>
            </div>
            <div class="box-body">
              
            </div>
            <div class="box-footer clearfix">
              <button type="button" class="pull-right btn btn-default" id="sendEmail">Send
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
          </div>
        </section>

        <section class="col-lg-4 connectedSortable">
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-pie-chart"></i>

              <h3 class="box-title">Crew Category</h3>
            </div>
            <div class="box-body">
              <canvas id="crewCategory" width="100%" height="100%"></canvas>
            </div>
          </div>
        </section>
      </div>

    </section>
@endsection

@push('before-scripts')
  <script src="{{ asset('js/charts.min.js') }}"></script>
@endpush

@push('after-scripts')
  <script>
    {{-- CREW CATEGORY --}}
    initCrewCategory();

    function initCrewCategory(){
      const ctx = document.getElementById('crewCategory').getContext('2d');

      const color = [
        '#5588d3',
        '#ffe74c',
        '#ff5964'
      ];

      const myChart = new Chart(ctx, {
          type: 'pie',
          data: {
              labels: ['Vacation', 'On-Board', 'Lined-Up'],
              datasets: [{
                  label: 'Crew Category',
                  data: [{{ $vacation }}, {{ $onBoard }}, {{ $linedUp }}],
                  backgroundColor: color,
                  borderColor: ['white','white','white'],
                  borderWidth: 3,
                  hoverOffset: 30,
              }]
          },
          options: {
            layout: {
                padding: 20
            }
          }
      });
    }
  </script>
@endpush