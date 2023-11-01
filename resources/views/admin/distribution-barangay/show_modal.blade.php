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
                        <p><strong>ID:</strong><br>{{ $distribution->id }}</p>
                        <p><strong>Barangay:</strong><br>{{ $distribution->barangay->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Medicine:</strong><br>{{ $distribution->medicine->generic_name }} - {{ $distribution->medicine->brand_name }}</p>
                        <p><strong>Stock:</strong><br>{{ $distribution->stocks }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Distribution Date:</strong><br>{{ $distribution->distribution_date }}</p>
                    </div>
                    <!-- Add other details as needed -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Add custom CSS styles here */
    .modal-content {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Add a subtle shadow */
    }

    .modal-title {
        font-weight: bold;
        color: #007bff; /* Change title color */
        margin-bottom: 20px;
    }

    .modal-body {
        background-color: #f7f7f7; /* Change modal body background color */
        padding: 20px;
    }

    .modal-body label {
        font-weight: bold;
        display: block;
    }

    .modal-body input {
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .modal-footer {
        background-color: #f7f7f7;
        border-top: 1px solid #ccc;
        padding: 15px;
    }
</style>
