<div class="modal fade" id="showDistributionBarangayModal{{ $distribution->id }}" tabindex="-1" role="dialog" aria-labelledby="showDistributionBarangayModalLabel{{ $distribution->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showDistributionBarangayModalLabel{{ $distribution->id }}">Distribution to Barangay Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>ID: {{ $distribution->id }}</p>
                <p>Barangay: {{ $distribution->barangay->name }}</p>
                <p>Medicine: {{ $distribution->medicine->generic_name }} - {{ $distribution->medicine->brand_name }}</p>
                <p>Stock: {{ $distribution->stocks }}</p>
                <p>Distribution Date: {{ $distribution->distribution_date }}</p>
                <!-- Add other details as needed -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
