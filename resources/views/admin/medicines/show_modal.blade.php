<div class="modal fade" id="showMedicineModal{{ $medicine->id }}" tabindex="-1" role="dialog" aria-labelledby="showMedicineModalLabel{{ $medicine->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showMedicineModalLabel{{ $medicine->id }}">Medicine Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>ID: {{ $medicine->id }}</p>
                <p>Generic Name: {{ $medicine->generic_name }}</p>
                <p>Brand Name: {{ $medicine->brand_name }}</p>
                <p>Category: {{ $medicine->category->name }}</p>
                <p>Price: {{ $medicine->price }}</p>
                <p>Stock: {{ $medicine->stocks }}</p>
                <p>Expiration Date: {{ $medicine->expiration_date }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
