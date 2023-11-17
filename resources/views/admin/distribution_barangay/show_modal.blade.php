<div class="modal fade" id="showDistributionBarangayModal{{ $distribution->id }}" tabindex="-1" role="dialog" aria-labelledby="showDistributionBarangayModalLabel{{ $distribution->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showDistributionBarangayModalLabel{{ $distribution->id }}">Distribution to Barangay Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Barangay:</strong><br>{{ $distribution_barangay->barangay->name }}</p>
                        <p><strong>Medicine:</strong><br>{{ $distribution_barangay->medicine->generic_name }} - {{ $distribution_barangay->medicine->brand_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Stock:</strong><br>{{ $distribution_barangay->stocks }}</p>
                        <p><strong>Distribution Date:</strong><br>{{ $distribution_barangay->distribution_date }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
<style>
    body.dark-mode #showDistributionBarangayModal{{ $distribution_barangay->id }} .modal-content {
        background-color: #343a40;
        color: #fff;
    }

    body.dark-mode #showDistributionBarangayModal{{ $distribution_barangay->id }} .modal-header {
        background-color: #343a40;
        color: #fff;
        border-bottom: 1px solid #007bff;
    }

    body.dark-mode #showDistributionBarangayModal{{ $distribution_barangay->id }} .modal-title {
        color: #fff;
    }

    body.dark-mode #showDistributionBarangayModal{{ $distribution_barangay->id }} .modal-body {
        background-color: #343a40;
        color: #fff;
    }

    body.dark-mode #showDistributionBarangayModal{{ $distribution_barangay->id }} p {
        color: #fff;
    }

    body.dark-mode #showDistributionBarangayModal{{ $distribution_barangay->id }} ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    body.dark-mode #showDistributionBarangayModal{{ $distribution_barangay->id }} li {
        margin-bottom: 10px;
        color: #fff;
    }

    body.dark-mode #showDistributionBarangayModal{{ $distribution_barangay->id }} .modal-footer {
        background-color: #343a40;
        border-top: 1px solid #007bff;
    }

    body.dark-mode #showDistributionBarangayModal{{ $distribution_barangay->id }} .btn-secondary {
        color: #fff;
    }
</style>
