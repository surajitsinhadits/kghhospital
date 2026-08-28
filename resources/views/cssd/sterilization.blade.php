@extends('layouts.structure')
@push('title')
    <title>{{ $title }}</title>
@endpush
@push('css')
@endpush
@section('main-content')
    <div class="row">
        <div class="col-md-12 py-2 px-3">
            <div class="card">
                <div class="card-header card_hearder_mimi">
                    <div class="card-title card_hearder_mimi_text">Sterilization</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-borderless text-nowrap datatable" role="grid"
                            aria-describedby="example1_info">
                            <thead>
                                <tr role="row">
                                    <th>sl. No.</th>
                                    <th>Box Name</th>
                                    <th>Box ID</th>
                                    <th>Instrumentts</th>
                                    <th>Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kitboxes as $index => $kitbox)
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">{{ $index + 1 }}</td>
                                        <td data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ $kitbox->description }}">{{ $kitbox->name }}</td>
                                        <td>{{ $kitbox->box_id }}</td>
                                        <td>
                                            @if ($kitbox->kitboxInstruments->isEmpty())
                                                <em>No instruments</em>
                                            @else
                                                <ul class="mb-0">
                                                    @foreach ($kitbox->kitboxInstruments as $item)
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="{{ $item->instrument->description ?? 'No description available' }}">
                                                            {{ $item->instrument->name ?? 'Unknown' }} (Qty:
                                                            {{ $item->quantity }})
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </td>

                                        <td>
                                            <span
                                                class="badge bg-{{ $kitbox->status === 'sterilized' ? 'success' : ($kitbox->status === 'in_use' ? 'warning' : 'danger') }}">
                                                {{ ucfirst(str_replace('_', ' ', $kitbox->status)) }}
                                                -{{ $kitbox->updated_at->format('d-m-Y H:i') }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('cssd.kitboxes-details') }}/{{ $kitbox->id }}"
                                                class="btn btn-primary btn-sm mx-1" title="Click here to show  details"><i
                                                    class="fa fa-eye"></i> </a>

                                            <a href="{{ route('cssd.markSterilized', $kitbox->id) }}"
                                                class="btn btn-success btn-sm mx-1" title="Sterilized"
                                                onclick="return confirm('Are you sure you want to mark this as Sterilized?')">
                                                <i class="fa fa-recycle" aria-hidden="true"></i>
                                            </a>


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
    <script>
        let instrumentIndex = 1;
        const instrumentOptions = @json($instruments->map(fn($i) => ['id' => $i->id, 'name' => $i->name]));

        function addInstrument() {
            const wrapper = document.getElementById('instruments-wrapper');
            const div = document.createElement('div');
            div.className = 'instrument-group  row';

            let optionsHtml = '<option value="">-- Select Instrument --</option>';
            instrumentOptions.forEach(inst => {
                optionsHtml += `<option value="${inst.id}">${inst.name}</option>`;
            });

            div.innerHTML = `
        <div class="col-md-6 ">
            <select style="width:100% !important;" name="instruments[${instrumentIndex}][instrument_id]" class="form-select" required>
                ${optionsHtml}
            </select>
        </div>
        <div class="col-md-4">
            <input type="number" name="instruments[${instrumentIndex}][quantity]" class="form-control" placeholder="Quantity" required>
        </div>
    `;

            wrapper.appendChild(div);
            instrumentIndex++;
        }
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
