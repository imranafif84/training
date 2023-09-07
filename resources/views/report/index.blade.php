@extends('layouts.template.app')

@section('title')
    Laporan
@endsection


@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Laporan Senarai Alat</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="myTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">Bil.</th>
                                        <th>Nama Alat</th>
                                        <th>Keterangan</th>
                                        <th>Diurus Oleh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($items as $key => $item)
                                        <tr>
                                            {{-- <td>{{ $users->firstItem()+$key }}</td> --}}
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->details }}</td>
                                            <td>{{ $item->user->name }} ({{ $item->user->email }})</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">-- Data tidak wujud --</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{-- {{$users->links('vendor.pagination.pagination')}} --}}
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $("#myTable").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#myTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush

{{-- @push('js')
    <script>
        $(document).ready( function () {

            $("#myTable").DataTable();
        });
    </script>
@endpush --}}


