@extends('layouts.admin')

@section('title')
Admin | Printers
@stop

@section('report')
<div class="col-lg-12">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">Printers</h5>
                <a href="{{ route('printers.create')}}" class="btn btn-primary">Add New</a>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Site</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Port</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($printers as $printer)
                        <tr>
                            <td>{{$printer -> id}}</td>
                            <td>{{ $printer->site->bsl_cmn_sites_name }}</td>
                            <td>{{$printer -> name}}</td>
                            <td>{{$printer -> address}}</td>
                            <td>{{$printer -> port}}</td>
                            <td>
                                <a href="{{ url('printers/'.$printer->id.'/edit') }}" class="btn btn-success">Edit</a>
                                <a href="{{url('printers/'.$printer->id.'/delete') }}" class="btn btn-danger">Delete</a>
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

@section('recent-activity')

@stop