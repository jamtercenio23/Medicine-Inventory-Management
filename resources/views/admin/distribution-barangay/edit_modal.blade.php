<div class="modal fade" id="editDistributionBarangayModal{{ $distribution->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editDistributionBarangayModalLabel{{ $distribution->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDistributionBarangayModalLabel{{ $distribution->id }}">Edit Distribution
                    to Barangay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Distribution to Barangay Edit Form -->
                <form action="{{ route('distribution-barangay.update', $distribution->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="barangay_id">Barangay:</label>
                                <select class="form-control" id="barangay_id" name="barangay_id" required>
                                    @foreach ($barangays as $barangay)
                                        <option value="{{ $barangay->id }}"
                                            {{ $distribution->barangay_id == $barangay->id ? 'selected' : '' }}>
                                            {{ $barangay->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicine_id">Medicine:</label>
                                <select class="form-control" id="medicine_id" name="medicine_id" required>
                                    @foreach ($medicines as $medicine)
                                        <option value="{{ $medicine->id }}"
                                            {{ $distribution->medicine_id == $medicine->id ? 'selected' : '' }}>
                                            {{ $medicine->brand_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stocks">Stocks:</label>
                                <input type="number" name="stocks" id="stocks" class="form-control"
                                    value="{{ old('stocks', $distribution->stocks) }}">
                            </div>
                            <div class="form-group">
                                <label for="distribution_date">Distribution Date:</label>
                                <input type="date" class="form-control" id="distribution_date"
                                    name="distribution_date" value="{{ $distribution->distribution_date }}" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Add custom CSS styles here */
    .modal-content {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        /* Add a subtle shadow */
    }

    .modal-title {
        font-weight: bold;
        color: #007bff;
        /* Change title color */
        margin-bottom: 20px;
    }

    .modal-body {
        background-color: #f7f7f7;
        /* Change modal body background color */
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
