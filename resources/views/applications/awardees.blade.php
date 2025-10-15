@extends('layouts.app')
@section('content')

<section class="content">

	<div class="row">
		<section class="col-lg-12">
			<div class="box box-info">

				<div class="box-header">
					@include('applications.includes.toolbar')
				</div>

                <div class="table-responsive">
    				<div class="box-body">
                        <ul class="nav nav-pills" role="tablist">
                            <li role="presentation" class="active">
                                <a href=".5y" role="tab" data-toggle="pill">5 Years</a>
                            </li>
                            <li role="presentation">
                                <a href=".10y" role="tab" data-toggle="pill">10 Years</a>
                            </li>
                            <li role="presentation">
                                <a href=".15y" role="tab" data-toggle="pill">15 Years</a>
                            </li>

                            <br><br><br>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade 5y active in">
                                    <ul class="nav nav-pills" role="tablist">
                                      @foreach($FYfleets as $fleet => $awardees)
                                        @php
                                            if($fleet == ""){
                                                $fleet = "No Fleet";
                                            }
                                            $fleet_ = str_replace(" ", "_", $fleet);
                                        @endphp
                                        @if($loop->first)
                                            <li role="presentation" class="active">
                                                <a href=".{{ $fleet_ }}" role="tab" data-toggle="pill">
                                                    {{ $fleet }} <span class="badge">{{ sizeof($awardees) }}</span>
                                                </a>
                                            </li>
                                        @else
                                            <li role="presentation">
                                                <a href=".{{ $fleet_ }}" role="tab" data-toggle="pill">
                                                    {{ $fleet }} <span class="badge">{{ sizeof($awardees) }}</span>
                                                </a>
                                            </li>
                                        @endif
                                      @endforeach
                                    </ul>

                                    <br>
                                    <div class="tab-content">
                                        @foreach($FYfleets as $fleet => $awardees)
                                            @php
                                                if($fleet == ""){
                                                    $fleet = "No Fleet";
                                                }
                                                $fleet_ = str_replace(" ", "_", $fleet);
                                            @endphp

                                            @if($loop->first)
                                                <div role="tabpanel" class="tab-pane fade active in {{ $fleet_ }}">
                                                    <table class="table table-hover table-bordered" id="table" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Rank</th>
                                                                <th>Years</th>
                                                                <th>Last Vessel</th>
                                                                <th>Address</th>
                                                                <th>Status</th>
                                                                <th>Last Sign Off</th>
                                                            </tr>
                                                        </thead>

                                                        @php
                                                            $ctr = 0;
                                                        @endphp
                                                        <tbody class="tbody">
                                                            {{-- <div class="preloader"></div> --}}
                                                            @foreach($awardees as $awardee)
                                                                @php
                                                                    $ctr++;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $ctr }}</td>
                                                                    <td>{{ $awardee['lname'] }}, {{ $awardee['fname'] }} {{ $awardee['suffix'] }} {{ $awardee['mname'] }}</td>
                                                                    <td>{{ $awardee['rname'] }}</td>
                                                                    <td>{{ round($awardee['total'] / 12, 2) }}</td>
                                                                    <td>{{ $awardee['last_vessel']->vessel_name ?? $awardee['last_vessel']->name }}</td>
                                                                    <td>{{ $awardee['address'] }}</td>
                                                                    <td>{{ $awardee['pa_s'] }}</td>
                                                                    <td>{{ $awardee['last_vessel']->sign_off }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div role="tabpanel" class="tab-pane fade {{ $fleet_ }}">
                                                    <table class="table table-hover table-bordered" id="table" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Rank</th>
                                                                <th>Years</th>
                                                                <th>Last Vessel</th>
                                                                <th>Address</th>
                                                                <th>Disembarked On</th>
                                                                <th>Last Sign Off</th>
                                                            </tr>
                                                        </thead>

                                                        @php
                                                            $ctr = 0;
                                                        @endphp
                                                        <tbody class="tbody">
                                                            {{-- <div class="preloader"></div> --}}
                                                            @foreach($awardees as $awardee)
                                                                @php
                                                                    $ctr++;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $ctr }}</td>
                                                                    <td>{{ $awardee['lname'] }}, {{ $awardee['fname'] }} {{ $awardee['suffix'] }} {{ $awardee['mname'] }}</td>
                                                                    <td>{{ $awardee['rname'] }}</td>
                                                                    <td>{{ round($awardee['total'] / 12, 2) }}</td>
                                                                    <td>{{ $awardee['last_vessel']->vessel_name ?? $awardee['last_vessel']->name }}</td>
                                                                    <td>{{ $awardee['address'] }}</td>
                                                                    <td>{{ $awardee['pa_s'] }}</td>
                                                                    <td>{{ $awardee['last_vessel']->sign_off }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade 10y">
                                    <ul class="nav nav-pills" role="tablist">
                                      @foreach($TYfleets as $fleet => $awardees)
                                        @php
                                            if($fleet == ""){
                                                $fleet = "No Fleet";
                                            }
                                            $fleet_ = str_replace(" ", "_", $fleet);
                                        @endphp
                                        @if($loop->first)
                                            <li role="presentation" class="active">
                                                <a href=".{{ $fleet_ }}" role="tab" data-toggle="pill">
                                                    {{ $fleet }} <span class="badge">{{ sizeof($awardees) }}</span>
                                                </a>
                                            </li>
                                        @else
                                            <li role="presentation">
                                                <a href=".{{ $fleet_ }}" role="tab" data-toggle="pill">
                                                    {{ $fleet }} <span class="badge">{{ sizeof($awardees) }}</span>
                                                </a>
                                            </li>
                                        @endif
                                      @endforeach
                                    </ul>

                                    <br>
                                    <div class="tab-content">
                                        @foreach($TYfleets as $fleet => $awardees)
                                            @php
                                                if($fleet == ""){
                                                    $fleet = "No Fleet";
                                                }
                                                $fleet_ = str_replace(" ", "_", $fleet);
                                            @endphp

                                            @if($loop->first)
                                                <div role="tabpanel" class="tab-pane fade active in {{ $fleet_ }}">
                                                    <table class="table table-hover table-bordered" id="table" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Rank</th>
                                                                <th>Years</th>
                                                                <th>Last Vessel</th>
                                                                <th>Address</th>
                                                                <th>Status</th>
                                                                <th>Last Sign Off</th>
                                                            </tr>
                                                        </thead>

                                                        @php
                                                            $ctr = 0;
                                                        @endphp
                                                        <tbody class="tbody">
                                                            {{-- <div class="preloader"></div> --}}
                                                            @foreach($awardees as $awardee)
                                                                @php
                                                                    $ctr++;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $ctr }}</td>
                                                                    <td>{{ $awardee['lname'] }}, {{ $awardee['fname'] }} {{ $awardee['suffix'] }} {{ $awardee['mname'] }}</td>
                                                                    <td>{{ $awardee['rname'] }}</td>
                                                                    <td>{{ round($awardee['total'] / 12, 2) }}</td>
                                                                    <td>{{ $awardee['last_vessel']->vessel_name ?? $awardee['last_vessel']->name }}</td>
                                                                    <td>{{ $awardee['address'] }}</td>
                                                                    <td>{{ $awardee['pa_s'] }}</td>
                                                                    <td>{{ $awardee['last_vessel']->sign_off }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div role="tabpanel" class="tab-pane fade {{ $fleet_ }}">
                                                    <table class="table table-hover table-bordered" id="table" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Rank</th>
                                                                <th>Years</th>
                                                                <th>Last Vessel</th>
                                                                <th>Address</th>
                                                                <th>Status</th>
                                                                <th>Last Sign Off</th>
                                                            </tr>
                                                        </thead>

                                                        @php
                                                            $ctr = 0;
                                                        @endphp
                                                        <tbody class="tbody">
                                                            {{-- <div class="preloader"></div> --}}
                                                            @foreach($awardees as $awardee)
                                                                @php
                                                                    $ctr++;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $ctr }}</td>
                                                                    <td>{{ $awardee['lname'] }}, {{ $awardee['fname'] }} {{ $awardee['suffix'] }} {{ $awardee['mname'] }}</td>
                                                                    <td>{{ $awardee['rname'] }}</td>
                                                                    <td>{{ round($awardee['total'] / 12, 2) }}</td>
                                                                    <td>{{ $awardee['last_vessel']->vessel_name ?? $awardee['last_vessel']->name }}</td>
                                                                    <td>{{ $awardee['address'] }}</td>
                                                                    <td>{{ $awardee['pa_s'] }}</td>
                                                                    <td>{{ $awardee['last_vessel']->sign_off }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade 15y">
                                    <ul class="nav nav-pills" role="tablist">
                                      @foreach($FTYfleets as $fleet => $awardees)
                                        @php
                                            if($fleet == ""){
                                                $fleet = "No Fleet";
                                            }
                                            $fleet_ = str_replace(" ", "_", $fleet);
                                        @endphp
                                        @if($loop->first)
                                            <li role="presentation" class="active">
                                                <a href=".{{ $fleet_ }}" role="tab" data-toggle="pill">
                                                    {{ $fleet }} <span class="badge">{{ sizeof($awardees) }}</span>
                                                </a>
                                            </li>
                                        @else
                                            <li role="presentation">
                                                <a href=".{{ $fleet_ }}" role="tab" data-toggle="pill">
                                                    {{ $fleet }} <span class="badge">{{ sizeof($awardees) }}</span>
                                                </a>
                                            </li>
                                        @endif
                                      @endforeach
                                    </ul>

                                    <br>
                                    <div class="tab-content">
                                        @foreach($FTYfleets as $fleet => $awardees)
                                            @php
                                                if($fleet == ""){
                                                    $fleet = "No Fleet";
                                                }
                                                $fleet_ = str_replace(" ", "_", $fleet);
                                            @endphp

                                            @if($loop->first)
                                                <div role="tabpanel" class="tab-pane fade active in {{ $fleet_ }}">
                                                    <table class="table table-hover table-bordered" id="table" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Rank</th>
                                                                <th>Years</th>
                                                                <th>Last Vessel</th>
                                                                <th>Address</th>
                                                                <th>Status</th>
                                                                <th>Last Sign Off</th>
                                                            </tr>
                                                        </thead>

                                                        @php
                                                            $ctr = 0;
                                                        @endphp
                                                        <tbody class="tbody">
                                                            {{-- <div class="preloader"></div> --}}
                                                            @foreach($awardees as $awardee)
                                                                @php
                                                                    $ctr++;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $ctr }}</td>
                                                                    <td>{{ $awardee['lname'] }}, {{ $awardee['fname'] }} {{ $awardee['suffix'] }} {{ $awardee['mname'] }}</td>
                                                                    <td>{{ $awardee['rname'] }}</td>
                                                                    <td>{{ round($awardee['total'] / 12, 2) }}</td>
                                                                    <td>{{ $awardee['last_vessel']->vessel_name ?? $awardee['last_vessel']->name }}</td>
                                                                    <td>{{ $awardee['address'] }}</td>
                                                                    <td>{{ $awardee['pa_s'] }}</td>
                                                                    <td>{{ $awardee['last_vessel']->sign_off }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div role="tabpanel" class="tab-pane fade {{ $fleet_ }}">
                                                    <table class="table table-hover table-bordered" id="table" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Rank</th>
                                                                <th>Years</th>
                                                                <th>Last Vessel</th>
                                                                <th>Address</th>
                                                                <th>Status</th>
                                                                <th>Last Sign Off</th>
                                                            </tr>
                                                        </thead>

                                                        @php
                                                            $ctr = 0;
                                                        @endphp
                                                        <tbody class="tbody">
                                                            {{-- <div class="preloader"></div> --}}
                                                            @foreach($awardees as $awardee)
                                                                @php
                                                                    $ctr++;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $ctr }}</td>
                                                                    <td>{{ $awardee['lname'] }}, {{ $awardee['fname'] }} {{ $awardee['suffix'] }} {{ $awardee['mname'] }}</td>
                                                                    <td>{{ $awardee['rname'] }}</td>
                                                                    <td>{{ round($awardee['total'] / 12, 2) }}</td>
                                                                    <td>{{ $awardee['last_vessel']->vessel_name ?? $awardee['last_vessel']->name }}</td>
                                                                    <td>{{ $awardee['address'] }}</td>
                                                                    <td>{{ $awardee['pa_s'] }}</td>
                                                                    <td>{{ $awardee['last_vessel']->sign_off }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </ul>
    				</div>
                </div>

				<div class="box-footer clearfix">
				</div>

			</div>
		</section>
	</div>
</section>
@endsection

@push('after-styles')
	<link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

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

        .reportBtn{
          width: 200px;
          text-align: center;
          position: absolute;
          top: 50%;
          left: 0;
          right: 0;
          margin: auto;
          transform: translateY(-50%);
        }

        th{
            text-align: center;
        }

        .report1{
          display: none;
        }
      </style>
@endpush

@push('before-scripts')
	<script src="{{ asset('js/datatables.js') }}"></script>
	<script src="{{ asset('js/moment.js') }}"></script>
	<script src="{{ asset('js/custom.js') }}"></script>
@endpush

@push('after-scripts')
    <script>
        $(document).ready(() => {
            $('.table').DataTable({
                lengthMenu: [10, 25, 50, 100, 200],
                pageLength: 200,
                // columnDefs: [
                //     {
                //         targets: 5,
                //         render: date => {
                //             return toDate(date);
                //         }
                //     }
                // ]
            });
        });
    </script>
@endpush