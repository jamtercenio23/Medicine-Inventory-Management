<div class="modal fade" id="createMedicineModal" tabindex="-1" role="dialog" aria-labelledby="createMedicineModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createMedicineModalLabel">Create Medicine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Medicine Create Form -->
                <form action="{{ route('medicines.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="generic_name">Generic Name:</label>
                                <input type="text" class="form-control" id="generic_name" name="generic_name" placeholder="Enter the Generic Name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="brand_name">Brand Name:</label>
                                <input type="text" class="form-control" id="brand_name" name="brand_name" placeholder="Enter the Brand Name" required>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category:</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stocks">Stocks:</label>
                                <input type="number" class="form-control" id="stocks" name="stocks" placeholder="Enter the Stocks" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Price:</label>
                                <input type="number" class="form-control" id="price" name="price" placeholder="Enter the Price"required>
                            </div>
                            <div class="form-group">
                                <label for="expiration_date">Expiration Date:</label>
                                <input type="date" class="form-control" id="expiration_date" name="expiration_date"
                                    min="{{ now()->addDay()->toDateString() }}" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Create</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    body.dark-mode #createMedicineModal .modal-content {
        background-color: #343a40;
        color: #fff;
    }

    body.dark-mode #createMedicineModal .modal-header {
        background-color: #343a40;
        color: #fff;
        border-bottom: 1px solid #007bff;
    }

    body.dark-mode #createMedicineModal .modal-title {
        color: #fff;
    }

    body.dark-mode #createMedicineModal .modal-body {
        background-color: #343a40;
        color: #fff;
    }

    body.dark-mode #createMedicineModal label {
        color: #fff;
    }

    body.dark-mode #createMedicineModal .form-control {
        color: #fff;
        background-color: #2d2d2d; /* Dark mode background color for input elements */
        border: 1px solid #6c757d; /* White border for input elements */
    }

    body.dark-mode #createMedicineModal .btn-secondary {
        color: #fff;
    }
</style>
