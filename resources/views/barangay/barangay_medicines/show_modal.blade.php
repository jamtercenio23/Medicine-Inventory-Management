<div class="modal fade" id="showbarangayMedicineModal{{ $barangayMedicine->id }}" tabindex="-1" role="dialog" aria-labelledby="showbarangayMedicineModalLable{{ $barangayMedicine->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showbarangayMedicineModalLable{{ $barangayMedicine->id }}">Medicine Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="medicine-details">
                            <p><strong>Generic Name:</strong><br>{{ $barangayMedicine->medicine->generic_name }}</p>
                            <p><strong>Brand Name:</strong><br>{{ $barangayMedicine->medicine->brand_name }}</p>
                            <p><strong>Category:</strong><br>{{ $barangayMedicine->medicine->category->name }}</p>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="medicine-details">
                            <p><strong>Stocks:</strong><br>{{ $barangayMedicine->stocks }}</p>
                            <p><strong>Price:</strong><br>₱{{ $barangayMedicine->medicine->price }}</p>
                            <p><strong>Expiration Date:</strong><br>{{ $barangayMedicine->medicine->expiration_date }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
