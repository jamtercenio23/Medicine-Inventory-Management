<div class="modal fade" id="editMedicineModal{{ $medicine->id }}" tabindex="-1" role="dialog" aria-labelledby="editMedicineModalLabel{{ $medicine->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMedicineModalLabel{{ $medicine->id }}">Edit Medicine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Medicine Edit Form -->
                <form action="{{ route('medicines.update', $medicine->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="generic_name">Generic Name:</label>
                        <input type="text" class="form-control" id="generic_name" name="generic_name" value="{{ $medicine->generic_name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="brand_name">Brand Name:</label>
                        <input type="text" class="form-control" id="brand_name" name="brand_name" value="{{ $medicine->brand_name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category:</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $medicine->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" class="form-control" id="price" name="price" value="{{ $medicine->price }}" required>
                    </div>
                    <div class="form-group">
                        <label for="stocks">Stocks:</label>
                        <input type="number" class="form-control" id="stocks" name="stocks" value="{{ $medicine->stock }}" required>
                    </div>
                    <div class="form-group">
                        <label for="expiration_date">Expiration Date:</label>
                        <input type="date" class="form-control" id="expiration_date" name="expiration_date" value="{{ $medicine->expiration_date }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
