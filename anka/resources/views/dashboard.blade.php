@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i class="material-icons">people_icon</i>
              </div>
              <p class="card-category">Total Participants</p>
              <h3 class="card-title">{{$totalParticipants}}
              </h3>
            </div>
            <div class="card-footer">
              {{-- <div class="stats">
                <i class="material-icons">date_range</i> Last 24 Hours
              </div> --}}
              <div class="stats">
                <i class="material-icons">update</i> Just Updated
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <i class="material-icons">store</i>
              </div>
              <p class="card-category">Products</p>
              <h3 class="card-title">{{$totalProducts}}</h3>
            </div> 
            <div class="card-footer">
              {{-- <div class="stats">
                <i class="material-icons">date_range</i> Last 24 Hours
              </div> --}}
              <div class="stats">
                <i class="material-icons">update</i> Just Updated
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">paid_icon</i>
              </div>
              <p class="card-category">Bookings</p> 
              <h3 class="card-title">{{$totalBookings}}</h3> 
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">local_offer</i> Tracked bookings made
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="material-icons">military_tech_icon</i>
              </div>
              <p class="card-category">Top participant</p>
              <p class="card-title">
                @if ($topParticipant)
                    {{$topParticipant->name}} <br>
                    {{$topParticipant->points}} points
                @else
                    
                @endif
              </hp>
            </div> 
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">update</i> Just Updated
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="card card-chart">
            <div class="card-header">
              {!! $productQuantityChart->container()!!}
              {!! $productQuantityChart->script()!!}
            </div>
            
          </div>
        </div>
        <div class="col-md-6">
          <div class="card card-chart">
            <div class="card-header">
              {!! $participantPointsChart->container()!!}
              {!! $participantPointsChart->script()!!}
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        
        <div class="col-lg-12 col-md-12">
          <div class="card">
            <div class="card-header card-header-warning">
              <h4 class="card-title">Participant Statistics</h4>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-hover">
                <thead class="text-warning">
                  <th>ID</th>
                  <th>Name</th>
                  <th>Product</th>
                  <th>Points</th>
                </thead>
                <tbody>

                  @foreach ($participants as $participant) 
                  <tr>
                    <td>{{$participant->id}}</td> 
                    <td>{{$participant->name}}</td>
                    <td>{{$participant->product}}</td>
                    <td>{{$participant->points}}</td>                    
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

@endsection

{{-- @push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
@endpush --}}