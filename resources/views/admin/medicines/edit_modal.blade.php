<div class="modal fade" id="editMedicineModal{{ $medicine->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editMedicineModalLabel{{ $medicine->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMedicineModalLabel{{ $medicine->id }}">Edit Medicine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('medicines.update', $medicine->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="generic_name">Generic Name:</label>
                                <input type="text" class="form-control" id="generic_name" name="generic_name"
                                    value="{{ $medicine->generic_name }}" placeholder="Enter the Generic Name" required>
                            </div>
                            <div class="form-group">
                                <label for="brand_name">Brand Name:</label>
                                <input type="text" class="form-control" id="brand_name" name="brand_name"
                                    value="{{ $medicine->brand_name }}" placeholder="Enter the Brand Name" required>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category:</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $medicine->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stocks">Stocks:</label>
                                <input type="number" class="form-control" id="stocks" name="stocks"
                                    value="{{ $medicine->stocks }}" placeholder="Enter the Stocks" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Price:</label>
                                <input type="number" class="form-control" id="price" name="price"
                                    value="{{ $medicine->price }}" placeholder="Enter the Price" required>
                            </div>
                            <div class="form-group">
                                <label for="expiration_date">Expiration Date:</label>
                                <input type="date" class="form-control" id="expiration_date" name="expiration_date"
                                    value="{{ $medicine->expiration_date }}" min="{{ now()->addDay()->toDateString() }}" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    body.dark-mode #editMedicineModal{{ $medicine->id }} .modal-content {
        background-color: #343a40;
        /* Dark mode background color for the modal content */
        color: #fff;
    }

    body.dark-mode #editMedicineModal{{ $medicine->id }} .modal-header {
        background-color: #343a40;
        /* Dark mode background color for the modal header */
        color: #fff;
        border-bottom: 1px solid #007bff;
        /* Border color for the header */
    }

    body.dark-mode #editMedicineModal{{ $medicine->id }} .modal-title {
        color: #fff;
        /* Text color for the modal title in dark mode */
    }

    body.dark-mode #editMedicineModal{{ $medicine->id }} .modal-body {
        background-color: #343a40;
        /* Dark mode background color for the modal body */
    }

    body.dark-mode #editMedicineModal{{ $medicine->id }} label,
    body.dark-mode #editMedicineModal{{ $medicine->id }} .form-control {
        color: #fff;
        /* Text color for labels and form controls in dark mode */
    }
</style>
