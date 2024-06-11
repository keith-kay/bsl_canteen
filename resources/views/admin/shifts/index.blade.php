@extends('layouts.admin')

@section('title')
Admin | Shifts
@stop

@section('report')
<div class="col-lg-12">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">Shifts</h5>
                <a href="{{ route('shifts.create')}}" class="btn btn-primary">Add New</a>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>

                            <th>Id</th>
                            <th>Name</th>
                            <th>Start-time</th>
                            <th>End-time</th>
                            <th>No of Meals</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shifts as $shift)
                        <tr>
                            <td>{{ $shift->bsl_cmn_shifts_id }} </td>
                            <td>{{$shift -> bsl_cmn_shifts_name}}</td>
                            <td>{{$shift -> bsl_cmn_shifts_starttime}}</td>
                            <td>{{$shift -> bsl_cmn_shifts_endtime}}</td>
                            <td>{{$shift -> bsl_cmn_shifts_mealsnumber}}</td>

                            <td>
                                <div class="d-inline">
                                    <a href="{{ url('shifts/'.$shift->bsl_cmn_shifts_id.'/edit') }}" class="btn btn-success">Edit</a>
                                </div>
                                <div class="d-inline">
                                    <a href="{{ url('shifts/'.$shift->bsl_cmn_shifts_id.'/delete') }}" class="btn btn-danger">Delete</a>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@stop