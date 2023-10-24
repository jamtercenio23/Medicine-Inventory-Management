<div class="modal fade" id="showScheduleModal{{ $schedule->id }}" tabindex="-1" role="dialog" aria-labelledby="showScheduleModalLabel{{ $schedule->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showScheduleModalLabel{{ $schedule->id }}">Schedule Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>ID: {{ $schedule->id }}</p>
                <p>Barangay: {{ $schedule->barangay->name }}</p>
                <p>Medicine: {{ $schedule->medicine->brand_name }}</p>
                <p>Stock: {{ $schedule->stock }}</p>
                <p>Date/Time: {{ $schedule->schedule_date_time }}</p>
                <!-- Add other details as needed -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
