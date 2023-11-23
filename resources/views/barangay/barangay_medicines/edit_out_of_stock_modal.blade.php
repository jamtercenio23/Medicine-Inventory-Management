<!-- Edit Out of Stock Medicine Modal -->
<div class="modal fade" id="editBarangayOutOfStockModal{{ $barangayMedicine->id }}" tabindex="-1" role="dialog" aria-labelledby="editBarangayOutOfStockModalLabel{{ $barangayMedicine->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBarangayOutOfStockModalLabel{{ $barangayMedicine->id }}">Request for Restock of Medicine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Request Restock Form -->
                <form action="{{ route('barangay-medicines.out-of-stock.request', $barangayMedicine->id) }}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="expected_stocks">Expected Stocks:</label>
                        <input type="number" class="form-control" id="expected_stocks" name="expected_stocks" placeholder="Enter the Expected Stocks" required>
                    </div>

                    <div class="form-group">
                        <label for="distribution_schedule">Distribution Schedule:</label>
                        <input type="date" class="form-control" id="distribution_schedule" name="distribution_schedule" placeholder="Enter the Distribution Schedule" required>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Request</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    body.dark-mode #editBarangayOutOfStockModal{{ $barangayMedicine->id }} .modal-content {
        background-color: #343a40;
        /* Dark mode background color for the modal content */
        color: #fff;
    }

    body.dark-mode #editBarangayOutOfStockModal{{ $barangayMedicine->id }} .modal-header {
        background-color: #343a40;
        /* Dark mode background color for the modal header */
        color: #fff;
        border-bottom: 1px solid #007bff;
        /* Border color for the header */
    }

    body.dark-mode #editBarangayOutOfStockModal{{ $barangayMedicine->id }} .modal-title {
        color: #fff;
        /* Text color for the modal title in dark mode */
    }

    body.dark-mode #editBarangayOutOfStockModal{{ $barangayMedicine->id }} .modal-body {
        background-color: #343a40;
        /* Dark mode background color for the modal body */
    }

    body.dark-mode #editBarangayOutOfStockModal{{ $barangayMedicine->id }} label,
    body.dark-mode #editBarangayOutOfStockModal{{ $barangayMedicine->id }} .form-control {
        color: #fff;
        /* Text color for labels and form controls in dark mode */
    }
</style>
