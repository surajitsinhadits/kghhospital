@extends('layouts.structure')

@push('title')
    <title>{{ $title }} - {{ hospital('title') }}</title>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header d-block card_hearder_mimi">
                    <div class="row">
                        <div class="col-md-6 card-title card_hearder_mimi_text">
                            Medicine Billing List
                        </div>

                        {{-- <div class="col-md-6 text-right">
                            <div class="d-block">

                                <a href="{{ route('pharmacy.add-medicene-billing') }}" class="btn btn-primary btn-sm"><i
                                        class="fa fa-tablets"></i>Create Bill</a>

                            </div>
                        </div> --}}
                    </div>
                </div>


                <div class="card-bodyp hospital_allcardbodydesign border" style="display:none" id="search_result">
                    <div class="table-responsive">
                        <table class="table table-hover card-table table-vcenter text-nowrap border"
                            style="background-color:#d9d9d9;border:1px solid black !important;    width: 50%;">
                            <thead class="text-white" style="background-color:#5e6545">
                                <tr class="border-left">
                                    <th class="text-white">Medicine Name</th>
                                </tr>
                            </thead>
                            <tbody id="search_result_row">

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-body">
                    <div class="">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered data-table w-100">
                                <thead>

                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>

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
                ajax: "{{ route('pharmacy.medicine-billing-lists') }}",
                columns: [{
                        data: null,
                        name: 'sl_no',
                        title: 'Sl. No',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'med_id',
                        name: 'med_id',
                        title: 'Med Bill No',
                    },
                    {
                        data: 'patient_display_name',
                        name: 'patient_display_name',
                        title: 'Patient Details'
                    },
                    {
                        data: 'doctor_name',
                        name: 'med_billings.doctor_id',
                        title: 'Doctor Name'
                    },
                    {
                        data: 'bill_date',
                        name: 'bill_date',
                        title: 'Bill Date',
                        render: function(data, type, row) {
                            return `${formatDateTime(row.bill_date)}`;
                        },
                        orderable: false,
                        searchable: true
                    },

                    {
                        data: 'grand_total',
                        name: 'grand_total',
                        title: 'Total Amount(₹)'
                    },

                    {
                        data: 'total_payment',
                        name: 'total_payment',
                        title: 'Paid Amount(₹)'
                    },
                    {
                        data: 'paymnent_status',
                        name: 'paymnent_status',
                        title: 'Amount Status(₹)'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        title: 'Action'
                    },
                ],
                rowCallback: function(row, data) {
                    if (data.due_amount != '0' || data.bill_status == 3) {
                        $(row).css('background-color', '#FFD6D6');
                    }
                    else if(data.bill_status == 1) {
                        $(row).css('background-color', '#FFFF9B');
                    } else {
                        $(row).css('background-color', '#d3fdf7');
                    }
                }
            });
        });

        $(document).on('click', '.refund-btn', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to refund this amount?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Refund!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('pharmacy.refund-money') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(res) {
                            if (res.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: res.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                $('.data-table').DataTable().ajax.reload(null, false);
                            } else {
                                Swal.fire('Error', res.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Refund failed. Please try again.', 'error');
                        }
                    });
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
