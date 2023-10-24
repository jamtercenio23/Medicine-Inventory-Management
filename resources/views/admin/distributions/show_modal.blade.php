<div class="modal fade" id="showDistributionModal{{ $distribution->id }}" tabindex="-1" role="dialog" aria-labelledby="showDistributionModalLabel{{ $distribution->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showDistributionModalLabel{{ $distribution->id }}">Distribution Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>ID: {{ $distribution->id }}</p>
                <p>Patient: {{ $distribution->patient->first_name }} {{ $distribution->patient->last_name }}</p>
                <p>Medicine: {{ $distribution->medicine->brand_name }}</p>
                <p>Stock: {{ $distribution->stocks }}</p>
                <p>Checkup Date: {{ $distribution->checkup_date }}</p>
                <!-- Add other details as needed -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
