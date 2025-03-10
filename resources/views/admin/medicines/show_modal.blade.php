<div class="modal fade" id="showMedicineModal{{ $medicine->id }}" tabindex="-1" role="dialog"
    aria-labelledby="showMedicineModalLabel{{ $medicine->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showMedicineModalLabel{{ $medicine->id }}">Medicine Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="medicine-details">
                            <p><strong>Generic Name:</strong><br>{{ $medicine->generic_name }}</p>
                            <p><strong>Brand Name:</strong><br>{{ $medicine->brand_name }}</p>
                            <p><strong>Category:</strong><br>{{ $medicine->category->name }}</p>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="medicine-details">
                            <p><strong>Stocks:</strong><br>{{ $medicine->stocks }}</p>
                            <p><strong>Price:</strong><br>₱{{ $medicine->price }}</p>
                            <p><strong>Expiration Date:</strong><br>{{ $medicine->expiration_date }}</p>
                        </div>
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
    body.dark-mode #showMedicineModal{{ $medicine->id }} .modal-content {
        background-color: #343a40;
        color: #fff;
    }

    body.dark-mode #showMedicineModal{{ $medicine->id }} .modal-header {
        background-color: #343a40;
        color: #fff;
        border-bottom: 1px solid #007bff;
    }

    body.dark-mode #showMedicineModal{{ $medicine->id }} .modal-title {
        color: #fff;
    }

    body.dark-mode #showMedicineModal{{ $medicine->id }} .modal-body {
        background-color: #343a40;
        color: #fff;
    }

    body.dark-mode #showMedicineModal{{ $medicine->id }} p {
        color: #fff;
    }

    body.dark-mode #showMedicineModal{{ $medicine->id }} .modal-footer {
        background-color: #343a40;
        border-top: 1px solid #007bff;
    }

    body.dark-mode #showMedicineModal{{ $medicine->id }} .btn-secondary {
        color: #fff;
    }

    body.dark-mode #showMedicineModal{{ $medicine->id }} .medicine-details p {
        color: #fff;
    }
</style>
