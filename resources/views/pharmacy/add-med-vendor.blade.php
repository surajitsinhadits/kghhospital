@extends('layouts.structure')

@push('title')
    <title>{{ $title }} - {{ hospital('title') }}</title>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-md-8 py-2 px-3">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <div class="card-title card_hearder_mimi_text">Medicine Vendor List</div>
                </div>
                <div class="card-body">
                    <div class="">
                        <div class="table-responsive">
                            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="example1" class="table table-borderless text-nowrap datatable"
                                                role="grid" aria-describedby="example1_info">
                                                <thead class="bg-primary text-white">
                                                    <tr role="row">
                                                        <th class="text-white sorting_asc" tabindex="0"
                                                            aria-controls="example1" rowspan="1" colspan="1"
                                                            aria-sort="ascending"
                                                            aria-label="Sl. No: activate to sort column descending"
                                                            style="width: 59.875px;">Sl. No</th>
                                                        <th class="text-white sorting" tabindex="0"
                                                            aria-controls="example1" rowspan="1" colspan="1"
                                                            aria-label="Package Name: activate to sort column ascending"
                                                            style="width: 242.708px;">Vendor Name</th>
                                                        <th class="text-white sorting" tabindex="0"
                                                            aria-controls="example1" rowspan="1" colspan="1"
                                                            aria-label="Charges Name: activate to sort column ascending"
                                                            style="width: 353.778px;">Address</th>
                                                        <th class="text-white sorting" tabindex="0"
                                                            aria-controls="example1" rowspan="1" colspan="1"
                                                            aria-label="Total: activate to sort column ascending"
                                                            style="width: 52.0694px;">Phone</th>
                                                        <th class="text-white sorting" tabindex="0"
                                                            aria-controls="example1" rowspan="1" colspan="1"
                                                            aria-label="Total: activate to sort column ascending"
                                                            style="width: 52.0694px;">GST</th>
                                                        <th class="text-white sorting" tabindex="0"
                                                            aria-controls="example1" rowspan="1" colspan="1"
                                                            aria-label="Action: activate to sort column ascending"
                                                            style="width: 64.1944px;">Action</th>
                                                        <th class="text-white sorting" tabindex="0"
                                                            aria-controls="example1" rowspan="1" colspan="1"
                                                            aria-label="Total: activate to sort column ascending"
                                                            style="width: 52.0694px;">Inactivate</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($vendors as $value)
                                                        <tr role="row" class="odd">
                                                            <td class="sorting_1">{{ $loop->iteration }}</td>
                                                            <td>{{ @$value->vendor_name }}</td>
                                                            <td>{{ @$value->vendor_address }}</td>
                                                            <td>{{ @$value->vendor_ph_no }}</td>
                                                            <td>{{ @$value->vendor_gst }}</td>

                                                            <td>
                                                                <a class="btn btn-sm btn-outline-primary"
                                                                    href="{{ route('pharmacy.medicine-vendor', $value->id) }}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            </td>

                                                            <td>
                                                                <label class="switch">
                                                                    <input type="checkbox"
                                                                        @if ($value->status == 1) checked @endif
                                                                        onchange="toggleStatus('{{ $value->id }}', '{{ $table }}','status')">
                                                                    <span class="slider round"></span>
                                                                </label>
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
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 py-2 px-3">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <div class="card-title card_hearder_mimi_text">{{ $t }}</div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" enctype="multipart/form-data" method="POST"
                        action="{{ $vendor ? route('pharmacy.update-medicine-vendor', $vendor->id) : route('pharmacy.update-medicine-vendor') }}">
                        @csrf

                        <div class="col-md-12">
                            <div class="row border px-4">
                                <div class="col-md-6 generaldesignadd">
                                    <label for="vendor_name">Vendor Name <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('vendor_name', $vendor->vendor_name ?? '') }}"
                                        id="vendor_name" name="vendor_name">
                                    @error('vendor_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 generaldesignadd">
                                    <label for="email">Email<span class="text-danger">*</span></label>
                                    <input type="email" value="{{ old('email', $vendor->email ?? '') }}"
                                        id="email" name="email">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 generaldesignadd">
                                    <label for="vendor_address">Address<span class="text-danger">*</span></label>
                                    <input type="text"
                                        value="{{ old('vendor_address', $vendor->vendor_address ?? '') }}"
                                        id="vendor_address" name="vendor_address">
                                    @error('vendor_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 generaldesignadd">
                                    <label for="vendor_ph_no">Vendor Phone No <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('vendor_ph_no', $vendor->vendor_ph_no ?? '') }}"
                                        id="vendor_ph_no" name="vendor_ph_no">
                                    @error('vendor_ph_no')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 generaldesignadd">
                                    <label for="vendor_gst">GSTIN</label>
                                    <input type="text" value="{{ old('vendor_gst', $vendor->vendor_gst ?? '') }}"
                                        id="vendor_gst" name="vendor_gst">
                                    @error('vendor_gst')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 generaldesignadd">
                                    <label for="contact_name">Contact Person Name</label>
                                    <input type="text" value="{{ old('contact_name', $vendor->contact_name ?? '') }}"
                                        id="contact_name" name="contact_name">
                                    @error('contact_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 generaldesignadd">
                                    <label for="pin">Pin Code</label>
                                    <input type="text" value="{{ old('pin', $vendor->pin ?? '') }}" id="pin"
                                        name="pin">
                                    @error('pin')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 mt-5">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check-circle"></i> {{ $vendor ? 'Update' : 'Save' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush

<script>
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
