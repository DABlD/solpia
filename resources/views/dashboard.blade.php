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
        <section class="col-lg-12 connectedSortable">
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-file"></i>

              <h3 class="box-title">Crew With Expiring Documents</h3>
            </div>
            <div class="box-body" id="cwed">

              <ul class="nav nav-pills" role="tablist">
                @foreach($fleets as $key => $fleet)
                  @php
                    $fleet_ = str_replace(" ", "_", $fleet);
                  @endphp
                  <li role="presentation" class="{{ $key == 0 ? 'active' : "" }}">
                      <a href=".{{ $fleet_ }}" role="tab" data-toggle="pill">{{ $fleet }}</a>
                  </li>
                @endforeach
              </ul>

              <br>
              <!-- Tab panes -->
              <div class="tab-content">
                @foreach($fleets as $key => $fleet)
                  @php
                    $fleet_ = str_replace(" ", "_", $fleet);
                  @endphp
                    <div role="tabpanel" class="cwed tab-pane fade {{ $fleet_ }} {{ $key == 0 ? 'in active' : "" }}">
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <td><b>ID</b></td>
                            <td><b>First Name</b></td>
                            <td><b>Last Name</b></td>
                            <td><b>Contact</b></td>
                            <td><b>No. of docs</b></td>
                            <td><b>Actions</b></td>
                          </tr>
                        </thead>
                        <tbody id="{{ $fleet_ }}" class="tbody">
                          <div class="preloader"></div>
                          <tr><td colspan="6"></td></tr>
                          <tr><td colspan="6"></td></tr>
                          <tr><td colspan="6" class="ncwed">
                            No Crew With Expiring Document
                          </td></tr>
                          <tr><td colspan="6"></td></tr>
                          <tr><td colspan="6"></td></tr>
                        </tbody>
                      </table>
                    </div>
                  @endforeach
              </div>
            </div>
            {{-- BODY --}}
          </div>
        </section>
      </div>

      <div class="row">
        <section class="col-lg-12 connectedSortable">
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-line-chart"></i>

              <h3 class="box-title">On Board And Disembark Reports</h3>
            </div>
            <div class="box-body">
              <div class="preloader report1"></div>
              <canvas id="report1" width="100%" height="100%"></canvas>
            </div>
          </div>
        </section>
      </div>

      <div class="row">
        <section class="col-lg-4 connectedSortable">
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-pie-chart"></i>

              <h3 class="box-title">Crew Category</h3>
            </div>
            <div class="box-body">
              <div class="preloader crewCategory"></div>
              <canvas id="crewCategory" width="100%" height="100%"></canvas>
            </div>
          </div>
        </section>
      </div>

    </section>
@endsection

@push('after-styles')
  <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
  <style>
    .nav-pills>li>a {
      border-top: 3px solid !important;
    }

    .tbody{
      position: relative;
    }

    table{
      width: 100% !important;
    }

    .tbody td, thead td{
      height: 25px !important;
      vertical-align: middle;
      text-align: center;
      vertical-align: middle;
      text-align: center;
    }

    .ncwed{
      font-size: 18px;
      font-weight: bold;
    }

    tr td:nth-child(1n+1) {
      width: 10%;
    }

    tr td:nth-child(2n+2) {
      width: 30%;
    }

    tr td:nth-child(3n+3) {
      width: 30%;
    }

    tr td:nth-child(4n+4) {
      width: 15%;
    }

    tr td:nth-child(5n+5) {
      width: 15%;
    }

    .badge{
      background-color: #f76c6b;
    }
  </style>
@endpush

@push('before-scripts')
  <script src="{{ asset('js/datatables.js') }}"></script>
  <script src="{{ asset('js/charts.min.js') }}"></script>
  <script src="{{ asset('js/moment.js') }}"></script>
@endpush

@push('after-scripts')
  <script>
    $('.cwed').css({
      'position': 'relative'
    });
    var crewDocs = [];

    {{-- CREW CATEGORY --}}

    $(document).ready(() => {
      initCrewWithExpiredDocs();
      initReport1();
      setTimeout(() => {
        initCrewCategory();
      }, 4000);
    });

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

      $('.preloader.crewCategory').fadeOut();
    }

    function initCrewWithExpiredDocs(){
      $.ajax({
        url: '{{ route('dashboard.getCrewWithExpiredDocs') }}',
        success: cwed => {
          // CREW WITH EXPIRING DOCUMENT
          cwed = JSON.parse(cwed);
          let fleets = [];

          Object.keys(cwed).forEach((fleet,key) => {
            let table = "";
            let cwedpf = Object.keys(cwed[fleet]);
            let nof = fleet.replace(" ", "_");
            $(`[href=".${nof}"]`).append(`
              <span class="badge">${cwedpf.length}</span>
            `);

            cwedpf.forEach((id, i) => {
              let crew = cwed[fleet][id];
              crewDocs[id] = crew.docs;

              table += `
                <tr>
                  <td>${id}</td>
                  <td>${crew.fname}</td>
                  <td>${crew.lname}</td>
                  <td>${crew.contact}</td>
                  <td>${crew.docs.length}</td>
                  <td>
                    <a class="btn btn-success" data-toggle="tooltip" title="View Expiring Documents" data-id="${id}"><span class="fa fa-search" data-id="${id}"></span></a>
                  </td>
                </tr>
              `;

              fleets[nof] = table;
            });
          });

          Object.keys(fleets).forEach(fleet => {
            $(`#${fleet}`).html(fleets[fleet]);
            $(`#${fleet}`).parent('table').DataTable({
              height: '100%',
              drawCallback: function(){
                  initViewButtons();
              },
            });
          })

          $('.tbody td').css({
            'vertical-align': 'middle',
            'text-align': 'center'
          });

          $('.cwed .preloader').fadeOut();
          initViewButtons();
        }
      })
    }

    function initViewButtons(){
      $('[title="View Expiring Documents"]').on('click', crew => {
        let id = $(crew.target).data('id');
        let docs = crewDocs[id];
        let list = "";

        docs.forEach(doc => {
          let days = moment(doc.expiry).diff(moment(), 'days');
          list += `
            <tr>
              <td>
                ${doc.type}
              </td>
              <td>
                ${moment(doc.expiry).format('MMM DD, YYYY')}
              </td>
              <td>
                ${days} day/s
              </td>
            </tr>
          `;
        });

        swal({
          title: 'Expiring Docs',
          html: `
            <table class="table">
              <thead>
                <tr>
                  <td>Document</td>
                  <td>Expiry</td>
                  <td>Remaining Days</td>
                </tr>
              </thead>

              <tbody>
                ${list}
              </tbody>
            </table>
          `,
          width: '400px'
        });
      });
    }

    function initReport1(){
      const ctx = document.getElementById('report1').getContext('2d');

      // LINED UP, ON BOARD, DISEMBARKED
      const color = [[],[],[]];
      // color[0].bc1 = 'rgb(85,182,221)';
      // color[0].bc2 = 'rgba(85,182,221,0.1)';
      color[0].bc1 = 'rgb(0,166,90)';
      color[0].bc2 = 'rgba(0,166,90,0.1)';
      color[1].bc1 = 'rgb(247,108,107)';
      color[1].bc2 = 'rgba(247,108,107,0.1)';

      let data = {type: 'Weekly'};

      $.ajax({
        url: '{{ route('dashboard.report1') }}',
        data: data,
        success: data => {
          data = JSON.parse(data);
          let datasets = [];

          Object.keys(data.data).forEach((label, i) => {
            datasets.push({
              label: label,
              data: data.data[label],
              borderColor: color[i]['bc1'],
              backgroundColor: color[i]['bc2'],
              fill: true,
              lineTension: 0.1,
              hoverRadius: 10
            });
          });
          
          var myChart = new Chart(ctx, {
              type: 'line',
              data: {
                  labels: data.names,
                  datasets: datasets
              },
              options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                  title: {
                    display: true,
                    text: 'Weekly Reports'
                  }
                }
              }
          });

          myChart.canvas.parentNode.style.height = '500px';
          $('.report1.preloader').fadeOut();
        }
      });
    }
  </script>
@endpush