<div class="modal fade" id="editScheduleModal{{ $schedule->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editScheduleModalLabel{{ $schedule->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editScheduleModalLabel{{ $schedule->id }}">Edit Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('schedules.update', $schedule->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="barangay_id">Barangay:</label>
                                <select class="form-control" id="barangay_id" name="barangay_id" required>
                                    @foreach ($barangays as $barangay)
                                        <option value="{{ $barangay->id }}"
                                            {{ $schedule->barangay_id == $barangay->id ? 'selected' : '' }}>
                                            {{ $barangay->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicine_id">Medicine:</label>
                                <select class="form-control" id="medicine_id" name="medicine_id" required>
                                    @foreach ($medicines as $medicine)
                                        <option value="{{ $medicine->id }}"
                                            {{ $schedule->medicine_id == $medicine->id ? 'selected' : '' }}>
                                            {{ $medicine->generic_name }} - {{ $medicine->brand_name }} | Stocks: {{ $medicine->stocks }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stock">Stock:</label>
                                <input type="number" class="form-control" id="stock" name="stock"
                                    value="{{ $schedule->stock }}" placeholder="Enter the Stocks" required>
                            </div>
                            <div class="form-group">
                                <label for="schedule_date_time">Date/Time:</label>
                                <input type="datetime-local" class="form-control" id="schedule_date_time"
                                    name="schedule_date_time"
                                    value="{{ \Carbon\Carbon::parse($schedule->schedule_date_time)->format('Y-m-d\TH:i') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    body.dark-mode #editScheduleModal{{ $schedule->id }} .modal-content {
        background-color: #343a40;
        /* Dark mode background color for the modal content */
        color: #fff;
    }

    body.dark-mode #editScheduleModal{{ $schedule->id }} .modal-header {
        background-color: #343a40;
        /* Dark mode background color for the modal header */
        color: #fff;
        border-bottom: 1px solid #007bff;
        /* Border color for the header */
    }

    body.dark-mode #editScheduleModal{{ $schedule->id }} .modal-title {
        color: #fff;
        /* Text color for the modal title in dark mode */
    }

    body.dark-mode #editScheduleModal{{ $schedule->id }} .modal-body {
        background-color: #343a40;
        /* Dark mode background color for the modal body */
    }

    body.dark-mode #editScheduleModal{{ $schedule->id }} label,
    body.dark-mode #editScheduleModal{{ $schedule->id }} .form-control {
        color: #fff;
        /* Text color for labels and form controls in dark mode */
    }
</style>
