@extends('layouts.main')

@section('title', 'Energy Schedule')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            {{-- DataTable --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Current Scheduled Devices -
                        {{ $ActiveSchedule->name ?? 'N/A' }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Appliance</th>
                                    <th>Schedule Time</th>
                                    <th>Duration</th>
                                    <th>Estimated Cost (Daily)</th>
                                    {{-- <th>Cost</th>
                        <th>Actions</th>
                    </tr> --}}
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Appliance</th>
                                    <th>Schedule Time</th>
                                    <th>Duration</th>
                                    <th>Estimated Cost (Daily)</th>
                                    {{-- <th>Cost</th>
                    <th>Actions</th> --}}
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($appliances as $data)
                                    @if ($data->schedule && $data->schedule->is_active)
                                        <tr>
                                            <td>{{ $data->appliance->name ?? 'N/A' }}</td>
                                            <td>{{ $data->timeslot->name }}</td>
                                            <td>{{ $data->duration_minutes ?? 'N/A' }} Minutes</td>
                                            <td>{{ $data->estimated_cost ?? 'N/A' }}</td>
                                            {{-- <td>{{ \Carbon\Carbon::parse($data->appliance->schedule_time)->format('h:i A') ?? 'N/A' }}</td> --}}
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
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
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
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
                            <a class="dropdown-item" data-toggle="modal" data-target="#addModal">Create new</a>
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
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Schedule</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($schedule as $data)
                                        <tr>
                                            <td>{{ $data->name }}</td>
                                            <td><a href="{{ route('schedule.setActive', ['id' => $data->id]) }}"
                                                    class="btn btn-circle btn-sm {{ $data->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <a href="{{ route('schedule.delete', ['id' => $data->id]) }}"
                                                    onclick="confirmation(event)" class="btn btn-danger btn-circle btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addApplianceLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addApplianceLabel">Create new Schedule</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addScheduleForm" method="POST" action="{{ route('schedule.add') }}">
                            @csrf

                            <div class="form-group">
                                <label for="scheduleName">Name</label>
                                <input type="text" class="form-control" id="scheduleName" name="name"
                                    placeholder="Enter Schedule name" required>
                            </div>
                            <!-- Start Time -->
                            <div class="form-group">
                                <label for="startTime">Start Time</label>
                                <input type="time" class="form-control" id="startTime" name="start_time" required>
                            </div>

                            <!-- End Time -->
                            <div class="form-group">
                                <label for="endTime">End Time</label>
                                <input type="time" class="form-control" id="endTime" name="end_time" required>
                            </div>
                            <!-- Select Multiple Appliances -->
                            <div class="form-group">
                                <label for="appliances">Select Appliances</label>
                                <select class="form-control" id="appliances" name="appliances[]" multiple required>
                                    @foreach ($AllAppliances as $allappliance)
                                        <option value="{{ $allappliance->id }}">{{ $allappliance->name }}
                                            ({{ $allappliance->power_consumption }} W)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="applianceScheduleOptions"></div>

                            <!-- Set Active Checkbox -->
                            <div class="form-group">
                                <label>Set Active</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="setActive" name="is_active"
                                        value="1">
                                    <label class="form-check-label" for="setActive">Enable Schedule</label>
                                </div>
                            </div>
                            </ </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" form="addScheduleForm">Add</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('appliances').addEventListener('change', function() {
                let selectedAppliances = Array.from(this.selectedOptions).map(option => {
                    return {
                        id: option.value,
                        name: option.text
                    };
                });

                let container = document.getElementById('applianceScheduleOptions');
                container.innerHTML = ''; // Clear previous content

                selectedAppliances.forEach(appliance => {
                    container.innerHTML += `
                        <div class="card mb-2 p-2">
                        <h5>${appliance.name}</h5>

                        <div class="form-group">
                            <label for="duration_${appliance.id}">Duration (in minutes)</label>
                            <input 
                            type="number" 
                            class="form-control" 
                            id="duration_${appliance.id}" 
                            name="timeslots[${appliance.id}][duration]" 
                            min="1" 
                            placeholder="How long should it run for">
                        </div>

                        </div>

                            `;
                });
            });
        </script>
        <script src="js/charts/chart-area.js"></script>
        <style>
            #applianceScheduleOptions {
              max-height: 270px; 
              overflow-y: auto;
              padding-right: 10px;
            }
          </style>
    @endsection
