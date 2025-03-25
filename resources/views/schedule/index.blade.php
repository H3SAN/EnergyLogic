@extends('layouts.main')

@section('title', 'Energy Schedule')

@section('content')
<div class="row">
  <div class="col-xl-12 col-lg-12">
    {{-- DataTable --}}
  <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Current Scheduled Devices</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Appliance</th>
                        <th>Schedule Time</th>
                        <th>Duration</th>
                        <th>Power Consumed (kWh)</th>
                        <th>Cost</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Appliance</th>
                    <th>Schedule Time</th>
                    <th>Duration</th>
                    <th>Power Consumed (kWh)</th>
                    <th>Cost</th>
                    <th>Actions</th>
                </tr>
                </tfoot>
                {{-- <tbody>
                  @foreach($data as $data)
                  <tr>
                      <td>{{$data->name}}</td>
                      <td>{{$data->power_rating_watts}}</td>
                      <td>{{$data->status}}</td>
                      <td>{{$data->schedule_time}}</td>
                      </tr>
                      @endforeach
                </tbody> --}}
            </table>
        </div>
    </div>
</div>
  </div>
</div>
<div class="row">
  
  <!-- Area Chart -->
  <div class="col-xl-8 col-lg-7">
      <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div
              class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Energy Consumption Summary</h6>
              
          </div>
          <!-- Card Body -->
          <div class="card-body">
              <div class="chart-area">
                  <canvas id="myAreaChart"></canvas>
              </div>
          </div>
      </div>
  </div>
  <div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Create New schedule</h6>
          <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                aria-labelledby="dropdownMenuLink">
                <div class="dropdown-header">Action:</div>
                <a class="dropdown-item" href="#">Create new</a>
            </div>
        </div>
      </div>
      <div class="card-body">
        <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th>Schedule</th>
                        <th>Appliances</th>
                        <th>Actions</th>
                      </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Schedule</th>
                      <th>Appliances</th>
                      <th>Actions</th>
                  </tr>
                  </tfoot>
                  {{-- <tbody>
                    @foreach($data as $data)
                    <tr>
                        <td>{{$data->name}}</td>
                        <td>{{$data->power_rating_watts}}</td>
                        <td>{{$data->status}}</td>
                        <td>{{$data->schedule_time}}</td>
                        </tr>
                        @endforeach
                  </tbody> --}}
              </table>
          </div>
      </div>
      </div>
  </div>
  </div>

</div>
@endsection
