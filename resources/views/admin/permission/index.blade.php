@extends('layouts.admin')

@section('title')
Admin | Permissions
@stop

@section('report')
<div class="col-lg-8">
    <div class="col-12">
        <div class="card">

            <div class="card-header d-flex justify-content-between">
                <h5 class="m-0">Permissions</h5>
                <a href="{{ route('permissions.create')}}" class="btn btn-primary">Add New</a>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                        <tr>
                            <td>{{$permission -> id}}</td>
                            <td>{{$permission -> name}}</td>
                            <td>
                                <a href="{{url('permissions/'.$permission->id.'/edit') }}"
                                    class="btn btn-success">Edit</a>
                                <a href="{{url('permissions/'.$permission->id.'/delete') }}"
                                    class="btn btn-danger">Delete</a>
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
<div class="card">
    <div class="filter">
        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
                <h6>Filter</h6>
            </li>

            <li><a class="dropdown-item" href="#">Today</a></li>
            <li><a class="dropdown-item" href="#">This Month</a></li>
            <li><a class="dropdown-item" href="#">This Year</a></li>
        </ul>
    </div>

    <div class="card-body">
        <h5 class="card-title">Recent Activity <span>| Today</span></h5>

        <div class="activity">

            <div class="activity-item d-flex">
                <div class="activite-label">32 min</div>
                <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                <div class="activity-content">
                    Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a>
                    beatae
                </div>
            </div><!-- End activity item-->

            <div class="activity-item d-flex">
                <div class="activite-label">56 min</div>
                <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                <div class="activity-content">
                    Voluptatem blanditiis blanditiis eveniet
                </div>
            </div><!-- End activity item-->

            <div class="activity-item d-flex">
                <div class="activite-label">2 hrs</div>
                <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                <div class="activity-content">
                    Voluptates corrupti molestias voluptatem
                </div>
            </div><!-- End activity item-->

            <div class="activity-item d-flex">
                <div class="activite-label">1 day</div>
                <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                <div class="activity-content">
                    Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati
                        voluptatem</a> tempore
                </div>
            </div><!-- End activity item-->

            <div class="activity-item d-flex">
                <div class="activite-label">2 days</div>
                <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                <div class="activity-content">
                    Est sit eum reiciendis exercitationem
                </div>
            </div><!-- End activity item-->

            <div class="activity-item d-flex">
                <div class="activite-label">4 weeks</div>
                <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                <div class="activity-content">
                    Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
                </div>
            </div><!-- End activity item-->

        </div>

    </div>
</div>
@stop