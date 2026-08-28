@extends('layouts.structure')
@push('title')
    <title>Asign Permission</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card my-2">
                <div class="card-header">
                    <div class="card-title">Asign Permission To : {{ $role->role }} </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered datatable-all">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Permission</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permission as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $item->permissions }}
                                        {!! $item->parent_id == 1 ? '<span class="badge badge-gradient-secondary">Header</span>' : ($item->parent_id == 2 ? '<span class="badge badge-gradient-primary">Sub-Header</span>' : '<span class="badge badge-gradient-warning">Default</span>') !!}
                                    </td>
                                    <td class="text-center">
                                        <div class="custom-control custom-switch">
                                            <label class="switch">
                                                <input
                                                    class="permission"
                                                    type="checkbox"
                                                    name="perm"
                                                    data-id="{{ $item->id }}"
                                                    data-role="{{ $role->id }}"
                                                    id="customSwitch1_{{ $item->id }}"
                                                    @if ($PermissionOfRole->contains($item->id)) checked @endif
                                                >
                                                <span class="slider round"></span>
                                            </label>
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
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $(".permission").click(function(e) {
                let role = $(this).data('role');
                let permission = $(this).data('id');

                if (role && permission) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('hr.asign-permissionn') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'role': role,
                            'permission': permission,
                        },
                        success: function(response) {
                            if (response === "1") {
                                toastr.success("Permission Asigned");
                                // window.location.reload(2000);
                            } else {
                                toastr.success("Permission Revoked");
                                // window.location.reload(2000);
                            }
                        }
                    });
                } else {
                    toastr.error("Something Went Wrong");
                }
            });
        });
    </script>
@endpush
