@extends('layouts.admin')

@section('title')
Admin | Create Site
@stop

@section('report')
<div class="col-lg-12">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">Add Site</h5>
                <a href="{{ route('sites.index')}}" class="btn btn-danger">Back</a>
            </div>

            <div class="card-body">
                <form action="{{route('sites.store')}}" method="POST">
                    @csrf
                    <div class="mb-3 mt-3 fw-bold">
                        <label for="name">Site Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="mb-3 mt-3 fw-bold">
                        <label for="name">Device Ip</label>
                        <input type="text" name="device_ip" class="form-control">
                    </div>
                    <input type="hidden" id="status" name="status" value="1">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
@stop

@section('recent-activity')

@stop