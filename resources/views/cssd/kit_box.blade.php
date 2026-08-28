@extends('layouts.structure')
@push('title')
    <title>{{ $title }}</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-md-8 py-2 px-3">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <div class="card-title card_hearder_mimi_text">Kit Box</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-borderless text-nowrap datatable" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr role="row">
                                    <th>sl. No.</th>
                                    <th>Box Name</th>
                                    <th>Box ID(Barcode)</th>
                                    <th>Instrumentts</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kitboxes as $index => $kitbox)
                                @php
                                $filteredInstruments = $kitboxInstruments->where('cssd_kitbox_instruments.kitbox_id', $kitbox->id)->get();
                                @endphp
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">{{ $index + 1 }}</td>
                                        <td data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ $kitbox->description }}">{{ $kitbox->name }}</td>
                                        <td>{{ $kitbox->prefix }}{{ $kitbox->counter }}</td>
                                        <td>
                                            <ul class="mb-0">
                                                @foreach ($filteredInstruments as $item)
                                                    <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ $item->description ?? 'No description available' }}">
                                                        {{ $item->name ?? 'Unknown' }} (Qty:
                                                        {{ $item->quantity }})
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <select data="{{ $kitbox->id }}" name="status" class="form-select" id="mySelect">
                                                <option value="">-- Select Status --</option>
                                                <option value="1" {{ old('status', $kitbox->status) == 1 ? 'selected' : '' }}>In Sterilization</option>
                                                <option value="2" {{ old('status', $kitbox->status) == 2 ? 'selected' : '' }}>Sterilized</option>
                                                <option value="3" {{ old('status', $kitbox->status) == 3 ? 'selected' : '' }}>Damaged</option>
                                                <option value="4" {{ old('status', $kitbox->status) == 4 ? 'selected' : '' }}>In Use</option>
                                            </select>
                                        </td>
                                        <td>
                                            <a href="{{ route('cssd.kitboxes-details') }}/{{ $kitbox->id }}"
                                                class="btn btn-primary btn-sm mx-1" title="Click here to show  details"><i
                                                    class="fa fa-eye"></i> </a>

                                            <a href="{{ route('cssd.kitboxes-edit') }}/{{ $kitbox->id }}"
                                                class="btn btn-primary btn-sm mx-1" title="Click here to show  details"><i
                                                    class="fa fa-edit"></i> </a>

                                            @if (!in_array($kitbox->status, ['1']))
                                                <a href="{{ route('cssd.sendToSterilized', $kitbox->id) }}"
                                                    class="btn btn-info btn-sm mx-1" title="Send to Sterilize"
                                                    onclick="return confirm('Are you sure you want to send this kit to sterilization?')">
                                                    <i class="fa fa-forward" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 py-2 px-3">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <h4 class="card-title card_hearder_mimi_text">Create KIT Box</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('cssd.kitboxes-create') }}" id="kit-box-form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $edit->id ?? null }}">

                        <div class="form-group">
                            <label for="name" class="medicinelabel">Kitbox Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" placeholder="Kitbox Name"
                                value="{{ old('name', $edit->name ?? '') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="medicinelabel">Description <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="description" name="description" placeholder="Description"
                                value="{{ old('description', $edit->description ?? '') }}" required>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category" class="medicinelabel">Category <span class="text-danger">*</span></label>
                            <select name="category" class="form-select" style="width:100% !important;" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('category', $edit->category ?? '') == $item->id ? 'selected' : '' }}>
                                        {{ $item->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <div id="instruments-wrapper1">
                                    <div class="instrument-group  row">
                                        <div class="col-lg-12 ">
                                            <select id="instrumentSelect" class="form-select mt-1 instument-ids"
                                                style="width:100% !important;">
                                                <option value="">-- Select Instrument --</option>
                                                @foreach ($instruments as $instrument)
                                                    @if( in_array($instrument->id, $instrumentIds ?? []) )
                                                        @continue
                                                    @endif
                                                    <option value="{{ $instrument->id }}">{{ $instrument->name }}</option>
                                                @endforeach
                                            </select>
                                            <small class="fs-11 text-warning">Must be Different instrument add each row</small>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-secondary w-100" id="addInstrumentBtn">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                        <div id="instruments-wrapper">

                            @php
                            if( !empty($edit->id) ):
                                $kitboxInstruments = $kitboxInstruments->where('cssd_kitbox_instruments.kitbox_id', $edit->id)->get();
                            @endphp
                            @if (isset($edit) && $kitboxInstruments->count() > 0)
                                @foreach ($kitboxInstruments as $item)
                                    <div class="instrument-item instrument-group row mt-3">
                                        <div class="col-md-6">
                                            <select style="width:100% !important;" name="instruments[instrument_id][]"
                                                class="form-select mt-1" required>
                                                <option value="{{ $item->instrument_id }}">{{ $item->name }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="instruments[quantity][]" class="form-control"
                                                placeholder="Quantity" value="{{ $item->quantity }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-secondary remove-instrument w-100"><i
                                                    class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @php endif; @endphp
                        </div>
                        <button type="submit" id="create" class="btn btn-primary mt-4 mb-0" name="submit_action" value="create">CREATE</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:400px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Expiration Date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div style="width:100%">
                        <label>Select Expiration Date</label>
                        <input type="text" class="datePickr flatpickr-input active" name="expiration_date" id="expiration_date" value="" readonly="readonly">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primery" id="kit_status_update">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        $(document).ready(function() {

            let preSelectedValue = $('#mySelect').val();
            let shouldResetSelect = false;

            $('#mySelect').on('change', function() {
                var selectedValue = $(this).val();

                if (selectedValue === '2') {
                    shouldResetSelect = true;
                    $('#myModal').modal('show');
                } else {

                    $('#myModal').modal('hide');
                    let selectedValue = $('#mySelect').val();
                    var kitbox_id = $('#mySelect').attr('data');
                    const currentUrl = window.location.href;
                    const newUrl = currentUrl + '?kitbox_id=' + kitbox_id + '&status=' + selectedValue;
                    window.location.href = newUrl;

                }
            });

            $('#myModal').on('hidden.bs.modal', function () {
            if (shouldResetSelect) {
                $('#mySelect').val(preSelectedValue);
                    shouldResetSelect = false;
                }
            });

        });

        $(document).on('click', '#kit_status_update', function(){

            let selectedValue = $('#mySelect').val();
            var expiration_date = $('#expiration_date').val();
            if( expiration_date === '' ){
                alert('Please select expiration date');
                return false;
            }
            var kitbox_id = $('#mySelect').attr('data');
            const currentUrl = window.location.href;
            const newUrl = currentUrl + '?exp_date=' + expiration_date + '&kitbox_id=' + kitbox_id + '&status=' + selectedValue;
            window.location.href = newUrl;

        });

        $(document).on('submit', '#kit-box-form', function(e) {
            const form = this;

            if ($(form).data('submitting') === true) {
                e.preventDefault();
                return false;
            }

            if ($('#instruments-wrapper').find('.instrument-group').length < 1) {
                e.preventDefault();
                alert('Please add at least one instrument.');
                return false;
            }

            if (!form.checkValidity()) {
                return true;
            }

            const submitter = e.originalEvent && e.originalEvent.submitter
                ? e.originalEvent.submitter
                : document.getElementById('create');

            if (submitter && submitter.name) {
                $('<input>', {
                    type: 'hidden',
                    name: submitter.name,
                    value: submitter.value
                }).appendTo(form);
            }

            $(form).data('submitting', true);

            $(form).find('button[type="submit"], input[type="submit"]').each(function() {
                if (this.tagName === 'BUTTON') {
                    this.dataset.originalText = this.innerHTML;
                    this.innerHTML = 'Processing...';
                } else {
                    this.dataset.originalText = this.value;
                    this.value = 'Processing...';
                }

                this.disabled = true;
            });

            return true;
        });

        let instrumentIndex = 1;
        const instrumentOptions = @json($instruments->map(fn($i) => ['id' => $i->id, 'name' => $i->name]));

        $('#addInstrumentBtn').click(function () {

            var selectedOption = $('#instrumentSelect option:selected');
            var instrumentId = selectedOption.val();
            var instrumentName = selectedOption.text();

            if (!instrumentId) {
                alert('Please select an instrument.');
                return;
            }

            $('#instruments-wrapper').append(`
                <div class="instrument-item instrument-group row mt-3">
                    <div class="col-md-6">
                        <select style="width:100% !important;" name="instruments[instrument_id][]" class="form-select mt-1" required>
                            <option value="${instrumentId}">${instrumentName}</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="instruments[quantity][]" class="form-control" placeholder="Quantity" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-secondary remove-instrument w-100"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `);

            selectedOption.remove();

        });

        $(document).on('click', '.remove-instrument', function () {

            var $row = $(this).closest('.instrument-item');
            var instrumentId = $row.find('select option:selected').val();
            var instrumentName = $row.find('select option:selected').text();
            $('#instrumentSelect').append(
                $('<option>', {
                    value: instrumentId,
                    text: instrumentName
                })
            );
            $row.remove();

        });
    </script>

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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
@endsection
