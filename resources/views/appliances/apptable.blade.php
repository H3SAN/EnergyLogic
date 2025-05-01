@extends('layouts.main')

@section('title', 'Appliances')

@section('content')
{{-- Main content goes here --}}

  <!-- DataTales Example -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"></h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addModal"><i
            class="fas fa-plus fa-sm text-white-50"></i> Add Appliance</a>
</div>
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
                          <th>Name</th>
                          <th>Power Rating</th>
                          <th>Status</th>
                          <th>Efficiency Rating</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Power Rating</th>
                        <th>Status</th>
                        <th>Efficiency Rating</th>
                        <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach($data as $data)
                    <tr>
                        <td>{{$data->name}}</td>
                        <td>{{$data->power_consumption}}</td>
                        <td>{{$data->status}}</td>
                        <td>{{$data->energy_efficiency_rating}}</td>
                        <td>
                            <a href="{{ route('appliances.view', ['id' => $data->id])}}" class="btn btn-primary btn-circle btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('appliances.delete', ['id' => $data->id])}}"  onclick="confirmation(event)" class="btn btn-danger btn-circle btn-sm">
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

  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addApplianceLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addApplianceLabel">Add Appliance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addApplianceForm" method="POST" action="{{ route('appliances.add') }}">
                    @csrf
                    <div class="form-group">
                        <label for="applianceName">Name</label>
                        <input type="text" class="form-control" id="applianceName" name="name" placeholder="Enter appliance name" required>
                    </div>

                    <div class="form-group">
                        <label for="powerRating">Power Rating (Watts)</label>
                        <input type="number" class="form-control" id="powerRating" name="power_consumption" placeholder="Enter power rating in watts" min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="off">Off</option>
                            <option value="on">On</option>
                            <option value="standby">Standby</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="efficiencyRating">Energy Efficiency Rating</label>
                        <select class="form-control" id="efficiencyRating" name="energy_efficiency_rating" required>
                            <option value="A++">A++</option>
                            <option value="A+">A+</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" form="addApplianceForm">Add</button>
            </div>
        </div>
    </div>
</div>
@endsection