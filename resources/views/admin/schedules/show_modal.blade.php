<div class="modal fade" id="showScheduleModal{{ $schedule->id }}" tabindex="-1" role="dialog"
    aria-labelledby="showScheduleModalLabel{{ $schedule->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showScheduleModalLabel{{ $schedule->id }}">Schedule Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Barangay:</strong><br>{{ $schedule->barangay->name }}</p>
                        <p><strong>Medicine:</strong><br>{{ $schedule->medicine->generic_name }} -
                            {{ $schedule->medicine->brand_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Stock:</strong><br>{{ $schedule->stock }}</p>
                        <p><strong>Date/Time:</strong><br>{{ $schedule->schedule_date_time }}</p>
                        <!-- Add other details as needed -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>
                    Close</button>
            </div>
        </div>
    </div>
</div>
<style>
    body.dark-mode #showScheduleModal{{ $schedule->id }} .modal-content {
        background-color: #343a40;
        color: #fff;
    }

    body.dark-mode #showScheduleModal{{ $schedule->id }} .modal-header {
        background-color: #343a40;
        color: #fff;
        border-bottom: 1px solid #007bff;
    }

    body.dark-mode #showScheduleModal{{ $schedule->id }} .modal-title {
        color: #fff;
    }

    body.dark-mode #showScheduleModal{{ $schedule->id }} .modal-body {
        background-color: #343a40;
        color: #fff;
    }

    body.dark-mode #showScheduleModal{{ $schedule->id }} p {
        color: #fff;
    }

    body.dark-mode #showScheduleModal{{ $schedule->id }} ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    body.dark-mode #showScheduleModal{{ $schedule->id }} li {
        margin-bottom: 10px;
        color: #fff;
    }

    body.dark-mode #showScheduleModal{{ $schedule->id }} .modal-footer {
        background-color: #343a40;
        border-top: 1px solid #007bff;
    }

    body.dark-mode #showScheduleModal{{ $schedule->id }} .btn-secondary {
        color: #fff;
    }
</style>
