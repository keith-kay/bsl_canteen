@extends('layouts.admin')

@section('title')
Admin | Edit Shifts
@stop

@section('report')
<div class="col-lg-12">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">Shifts</h5>
                <a href="{{ route('shifts.index')}}" class="btn btn-danger">Back</a>
            </div>

            <div class="card-body">
                <form action="{{url('shifts/'.$shift->bsl_cmn_shifts_id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 mt-3 col-lg-6">
                            <label for="name" class="fw-bold">Shift Name</label>
                            <input type="text" name="name" value="{{$shift->bsl_cmn_shifts_name}}" class="form-control">
                        </div>
                        <div class="mb-3 mt-3 col-lg-6">
                            <label for="name" class="fw-bold">Start Time</label>
                            <input type="time" name="starttime" value="{{$shift->bsl_cmn_shifts_starttime}}" class="form-control">
                        </div>
                        <div class="mb-3 mt-3 col-lg-6">
                            <label for="name" class="fw-bold">End Time</label>
                            <input type="time" name="endtime" value="{{$shift->bsl_cmn_shifts_endtime}}" class="form-control">
                        </div>
                        <div class="mb-3 mt-3 col-lg-6">
                            <label for="name" class="fw-bold">No of Meals</label>
                            <input type="number" name="noofmeals" value="{{$shift->bsl_cmn_shifts_mealsnumber}}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        <input type="hidden" id="status" name="status" value="1">
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

@stop

@section('recent-activity')

@stop