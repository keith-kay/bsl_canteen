@extends('layouts.admin')

@section('title')
Admin | Create Company
@stop

@section('report')
<div class="col-lg-12">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">Add Company</h5>
                <a href="{{ route('companies.index')}}" class="btn btn-danger">Back</a>
            </div>

            <div class="card-body">
                <form action="{{route('companies.store')}}" method="POST">
                    @csrf
                    <div class="mb-3 mt-3">
                        <label for="name">Company Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
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