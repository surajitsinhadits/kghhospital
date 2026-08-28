@extends('layouts.structure')
@push('title')
    <title>{{$title}}</title>
@endpush
@push('css')

@endpush
@section('main-content')
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header card_hearder_mimi justify-content-between">
                <h4 class="card-title card_hearder_mimi_text">Users List</h4>
                <a class="btn btn-sm btn-warning" href="{{Route('hr.add-user')}}">Add User</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless text-nowrap data-table">
                        <thead></thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('hr.users') }}",
                columns: [
                    {
                        data: null,
                        name: 'sl_no',
                        title: 'Sl. No',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'empId',
                        name: 'empId',
                        title: 'Employee ID'
                    },
                    {
                        data: null,
                        name: 'name',
                        title: 'Name',
                        render: function(data, type, row) {
                            const baseUrl = "{{url('public/assets/images/users')}}/";
                            const profileImg = row.profile_img ? `${baseUrl}${row.profile_img}` : `${baseUrl}users.png`;
                            const imageUrl = `<img src="${profileImg}" width="25" height="25" style="border-radius:50%; margin-right:5px;">`;
                            return `${imageUrl} ${row.salutation || ''} ${row.name}`.trim();
                        },
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'email',
                        name: 'email',
                        title: 'Email'
                    },
                    {
                        data: 'phone_no',
                        name: 'phone_no',
                        title: 'Mobile'
                    },
                    {
                        data: 'role',
                        name: 'roles.role',
                        title: 'Role'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        title: 'Activated',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            let checked = data == 1 ? 'checked' : '';
                            return `
                                <label class="switch">
                                    <input type="checkbox" ${checked} onchange="toggleStatus('${row.id}', 'users', 'is_active', this)">
                                    <span class="slider round"></span>
                                </label>
                            `;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        title: 'Action'
                    },
                ]
            });
        });
        function toggleStatus(id, table, col, element) {
            let url = "{{ route('is-active', ['id' => '__id__', 'table' => '__table__', 'col' => '__col__']) }}"
                        .replace('__id__', id)
                        .replace('__table__', table)
                        .replace('__col__', col);
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
            .then(data => {
                console.log("Status Updated!");
            }).catch(error => {
                console.error('Error:', error);
                element.checked = !element.checked;
            });
        }
    </script>
@endpush
