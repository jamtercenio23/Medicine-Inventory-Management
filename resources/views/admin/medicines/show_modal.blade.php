<div class="modal fade" id="showMedicineModal{{ $medicine->id }}" tabindex="-1" role="dialog" aria-labelledby="showMedicineModalLabel{{ $medicine->id }}" aria-hidden="true">
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
    }

    .modal-body input {
        border: 1px solid #ccc; /* Add a border to input fields */
        border-radius: 5px;
    }

    .modal-footer {
        background-color: #f7f7f7; /* Change modal footer background color */
        border-top: 1px solid #ccc;
        padding: 15px;
    }

    /* Add transitions or animations as needed */
</style>
