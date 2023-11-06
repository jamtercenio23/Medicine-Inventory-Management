<div class="modal fade" id="showDistributionModal{{ $distribution->id }}" tabindex="-1" role="dialog" aria-labelledby="showDistributionModalLabel{{ $distribution->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showDistributionModalLabel{{ $distribution->id }}">Distribution Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Distribution Details -->
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Patient:</strong><br>{{ $distribution->patient->first_name }} {{ $distribution->patient->last_name }}</p>
                        <p><strong>Medicine:</strong><br>{{ $distribution->medicine->brand_name }}</p>
                        <p><strong>Stock:</strong><br>{{ $distribution->stocks }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Diagnose:</strong><br>{{ $distribution->diagnose }}</p>
                        <p><strong>Checkup Date:</strong><br>{{ $distribution->checkup_date }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
