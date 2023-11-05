<div class="modal fade" id="editDistributionBarangayModal{{ $distribution_barangay->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editDistributionBarangayModalLabel{{ $distribution_barangay->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDistributionBarangayModalLabel{{ $distribution_barangay->id }}">Edit Distribution
                    to Barangay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Distribution to Barangay Edit Form -->
                <form action="{{ route('distribution_barangay.update', $distribution_barangay->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="barangay_id">Barangay:</label>
                                <input type="text" class="form-control" id="barangay_id" name="barangay_id" value="{{ $distribution_barangay->barangay->name }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="medicine_id">Medicine:</label>
                                <input type="text" class="form-control" id="medicine_id" name="medicine_id" value="{{ $distribution_barangay->medicine->brand_name }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stocks">Stocks:</label>
                                <input type="number" name="stocks" id="stocks" class="form-control"
                                    value="{{ old('stocks', $distribution_barangay->stocks) }}" placeholder="Enter the Stocks" required>
                            </div>
                            <div class="form-group">
                                <label for="distribution_date">Distribution Date:</label>
                                <input type="date" class="form-control" id="distribution_date"
                                    name="distribution_date" value="{{ $distribution_barangay->distribution_date }}" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
