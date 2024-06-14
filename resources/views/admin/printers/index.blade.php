@extends('layouts.admin')

@section('title')
Admin | Printers
@stop

@section('report')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="container my-3">
    <style>
        .ajs-success {
            background-color: #4CAF50;
            color: #ffffff;
        }

        .colored-toast.swal2-icon-success {
            background-color: #28a745 !important;
        }

        .colored-toast.swal2-icon-error {
            background-color: #f27474 !important;
        }

        .colored-toast.swal2-icon-warning {
            background-color: #f8bb86 !important;
        }

        .colored-toast.swal2-icon-info {
            background-color: #3fc3ee !important;
        }

        .colored-toast.swal2-icon-question {
            background-color: #87adbd !important;
        }

        .colored-toast .swal2-title {
            color: white;
        }

        .colored-toast .swal2-close {
            color: white;
        }

        .colored-toast .swal2-html-container {
            color: white;
        }
    </style>
    @if(session('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        (async () => {
            await Toast.fire({
                icon: 'success',
                title: "{{session('success')}}",
            })
        })()
    </script>
    @elseif(session('error'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        (async () => {
            await Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}",
            })
        })();
    </script>
    @endif
</div>
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
                            <th>Id</th>
                            <th>Site</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Port</th>
                            <th>Test</th>
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
                            <td style="text-align: center; vertical-align: middle;">
                                <form id="printerTestForm{{$printer->id}}" method="POST" action="{{ route('printers.test', ['printer' => $printer->id]) }}">
                                    @csrf
                                    <input type="hidden" name="printer_address" value="{{$printer->address}}">
                                    <input type="hidden" name="printer_port" value="{{$printer->port}}">
                                    <a href="javascript:void(0);" class="btn btn-success" onclick="event.preventDefault(); document.getElementById('printerTestForm{{$printer->id}}').submit();">
                                        Print-Test
                                    </a>
                                </form>
                            </td>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.run-test').forEach(function(button) {
            button.addEventListener('click', function() {
                const printerId = this.getAttribute('data-printer-id');
                const printerAddress = this.getAttribute('data-printer-address');
                const printerPort = this.getAttribute('data-printer-port');

                // Log the printer address and port to the console
                console.log('Printer ID:', printerId);
                console.log('Printer Address:', printerAddress);
                console.log('Printer Port:', printerPort);

                fetch(`/printers/${printerId}/test`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            printer_id: printerId,
                            printer_address: printerAddress,
                            printer_port: printerPort
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (response.ok) {
                            alert(data.message);
                        } else {
                            throw new Error(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error.message);
                        alert('An error occurred while sending the test print job: ' + error
                            .message);
                    });
            });
        });
    });
</script>

@stop

@section('recent-activity')

@stop