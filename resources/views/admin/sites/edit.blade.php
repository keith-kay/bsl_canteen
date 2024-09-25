@extends('layouts.admin')

@section('title')
Admin | Edit Sites
@stop

@section('report')
<div class="col-lg-12">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">Edit Sites</h5>
                <a href="{{ route('sites.index')}}" class="btn btn-danger">Back</a>
            </div>

            <div class="card-body">
                <form action="{{url('sites/'.$site->bsl_cmn_sites_id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 mt-3">
                        <label for="name">Site Name</label>
                        <input type="text" name="name" value="{{$site->bsl_cmn_sites_name}}" class="form-control">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="name">IP address</label>
                        <input type="text" name="device_ip" value="{{$site->bsl_cmn_sites_device_ip}}" class="form-control">
                    </div>
                    <input type="hidden" id="status" name="status" value="1">
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
@stop

@section('recent-activity')

@stop