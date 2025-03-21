@extends('layouts.main')

@section('title', 'Cost Analysis')

@section('content')
<div class="row">
  <div class="col-xl-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter search</h6>
      </div>
      <div class="card-body d-flex gap-3">
                <!-- Date Range Selection -->
                <div class="mr-3 w-1/5">
                  <label class="block text-sm font-medium">Date Range:</label>
                  <div class="flex space-x-2">
                      <input type="date" class="border p-2 rounded w-1/2" id="start_date">
                      <input type="date" class="border p-2 rounded w-1/2" id="end_date">
                  </div>
              </div>
              <!-- Date Range Selection -->
              <div class="mr-3 w-1/5">
                <label class="block text-sm font-medium">Appliance Category:</label>
                <div class="flex space-x-2">
                  <select class="border p-2 rounded w-full" id="appliance_category">
                    <option value="">All Categories</option>
                    <option value="kitchen">Kitchen</option>
                    <option value="entertainment">Entertainment</option>
                    <option value="heating">Heating & Cooling</option>
                    <option value="lighting">Lighting</option>
                </select>
                </div>
            </div>

           <!-- Date Range Selection -->
           <div class="mr-3 w-1/5">
            <label class="block text-sm font-medium">Sort By:</label>
            <div class="flex space-x-2">
              <select class="border p-2 rounded w-full" id="sort_by">
                <option value="power_high">Highest Power Usage</option>
                <option value="power_low">Lowest Power Usage</option>
                <option value="name_asc">Name (A-Z)</option>
                <option value="name_desc">Name (Z-A)</option>
            </select>
            </div>
        </div>
        <!-- Date Range Selection -->
        <div class="mr-3 w-1/5">
          <label class="block text-sm font-medium">Search Appliance:</label>
          <div class="flex space-x-2">
            <input type="text" placeholder="Enter appliance name" class="border p-2 rounded w-full" id="search_appliance">
          </div>
      </div>
      <div class="mt-4 mr-3">
        <a href="#" class="btn btn-primary btn-icon-split">
          <span class="icon text-white-50">
              <i class="fas fa-filter"></i>
          </span>
          <span class="text">Filter</span>
      </a>
    </div>
      </div>
    </div>
  </div>
</div>

<div class="row">

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total Power Consumption (kWh)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">8500kwh</div>
                  </div>
                  <div class="col-auto">
                      <i class="fas fa-bolt fa-2x text-gray-300"></i>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!-- Earnings (Annual) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Total Operating Cost</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">$5,134</div>
                  </div>
                  <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!-- Tasks Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Least Efficient Appliance
                      </div>
                      <div class="row no-gutters align-items-center">
                          <div class="col-auto">
                              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Vacuum cleaner</div>
                          </div>
                      </div>
                  </div>
                  <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!-- Pending Requests Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Most Power-Hungry Appliance</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">Washing machine</div>
                  </div>
                  <div class="col-auto">
                      <i class="fas fa-plug fa-2x text-gray-300"></i>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

{{-- Graphs and charts --}}
<div class="row">
  
  <!-- Area Chart -->
  <div class="col-xl-8 col-lg-7">
      <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div
              class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
              <div class="dropdown no-arrow">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                      aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                  </div>
              </div>
          </div>
          <!-- Card Body -->
          <div class="card-body">
              <div class="chart-area">
                  <canvas id="myAreaChart"></canvas>
              </div>
          </div>
      </div>
  </div>

  <!-- Pie Chart -->
  <div class="col-xl-4 col-lg-5">
      <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div
              class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
              <div class="dropdown no-arrow">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                      aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                  </div>
              </div>
          </div>
          <!-- Card Body -->
          <div class="card-body">
              <div class="chart-pie pt-4 pb-2">
                  <canvas id="myPieChart"></canvas>
              </div>
              <div class="mt-4 text-center small">
                  <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Direct
                  </span>
                  <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Social
                  </span>
                  <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Referral
                  </span>
              </div>
          </div>
      </div>
  </div>
  <div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Bar Chart</h6>
      </div>
      <div class="card-body">
          <div class="chart-bar">
              <canvas id="myBarChart"></canvas>
          </div>
      </div>
  </div>
</div>
</div>
<div class="row">
  <div class="col-xl-12 col-lg-12">
    {{-- DataTable --}}
  <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Last Updated - 20th Nov, 2025</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Appliance name</th>
                        <th>Total Usage (kWh)</th>
                        <th>Cost ($)</th>
                        <th>Avg. Daily Usage</th>
                    </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Appliance name</th>
                    <th>Total Usage (kWh)</th>
                    <th>Cost ($)</th>
                    <th>Avg. Daily Usage</th>
                </tr>
                </tfoot>
                {{-- <tbody>
                  @foreach($data as $data)
                  <tr>
                      <td>{{$data->name}}</td>
                      <td>{{$data->power_rating_watts}}</td>
                      <td>{{$data->status}}</td>
                      <td>{{$data->schedule_time}}</td>
                      <td>{{$data->daily_usage_hours}}</td>
                      <td>{{$data->energy_efficiency_rating}}</td>
                      <td>
                          <a href="{{ route('appliances.show')}}" class="btn btn-primary btn-circle btn-sm">
                              <i class="fas fa-eye"></i>
                          </a>
                          <a href="{{ route('appliances.delete', ['id' => $data->id])}}"  onclick="confirmation(event)" class="btn btn-danger btn-circle btn-sm">
                              <i class="fas fa-trash"></i>
                          </a>
                      </td>
                      </tr>
                      @endforeach
                </tbody> --}}
            </table>
        </div>
    </div>
</div>
  </div>
</div>
@endsection
