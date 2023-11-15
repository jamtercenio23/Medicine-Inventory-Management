<!-- Edit Out of Stock Medicine Modal -->
<div class="modal fade" id="editBarangayOutOfStockModal{{ $barangayMedicine->id }}" tabindex="-1" role="dialog" aria-labelledby="editBarangayOutOfStockModalLabel{{ $barangayMedicine->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBarangayOutOfStockModalLabel{{ $barangayMedicine->id }}">Edit Out of Stock Medicine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Edit Out of Stock Medicine Form -->
                <form action="{{ route('barangay-medicines.out-of-stock.update', $barangayMedicine->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <!-- Include the expected stocks and schedule for distributions -->
                    <div class="form-group">
                        <label for="expected_stocks">Expected Stocks:</label>
                        <input type="number" class="form-control" id="expected_stocks" name="expected_stocks" value="{{ $barangayMedicine->expected_stocks }}" placeholder="Enter the Expected Stocks" required>
                    </div>

                    <div class="form-group">
                        <label for="distribution_schedule">Distribution Schedule:</label>
                        <input type="date" class="form-control" id="distribution_schedule" name="distribution_schedule" value="{{ $barangayMedicine->distribution_schedule }}" placeholder="Enter the Distribution Schedule" required>
                    </div>
                    <!-- Add other form elements as needed -->

                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
