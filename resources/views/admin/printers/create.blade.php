@extends('layouts.admin')

@section('title')
Admin | Create Printers
@stop

@section('report')
<div class="col-lg-12">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">Printers</h5>
                <a href="{{ route('printers.index')}}" class="btn btn-danger">Back</a>
            </div>

            <div class="card-body">
                <form action="{{route('printers.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-3 mt-3 col-lg-6">
                            <label for="name" class="fw-bold">Printer Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="mb-3 mt-3 col-lg-6">
                            <label for="name" class="fw-bold">Site</label>
                            <select name="site_id" class="form-control">
                                @foreach($sites as $site)
                                <option value="{{ $site->bsl_cmn_sites_id }}">{{ $site->bsl_cmn_sites_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 mt-3 col-lg-6">
                            <label for="name" class="fw-bold">Address</label>
                            <input type="text" name="address" class="form-control">
                        </div>
                        <div class="mb-3 mt-3 col-lg-6">
                            <label for="name" class="fw-bold">Port</label>
                            <input type="text" name="port" class="form-control">
                        </div>
                        <input type="hidden" id="status" name="status" value="1">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
@stop

@section('recent-activity')

@stop