<div class="modal fade" id="deleteScheduleModal{{ $schedule->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteScheduleModalLabel{{ $schedule->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteScheduleModalLabel{{ $schedule->id }}">Delete Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the Schedule ID {{ $schedule->id }}?</p>
                <!-- Schedule Delete Form -->
                <form action="{{ route('schedules.destroy', $schedule->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
