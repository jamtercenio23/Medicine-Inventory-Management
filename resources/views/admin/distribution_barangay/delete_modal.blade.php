<div class="modal fade" id="deleteDistributionBarangayModal{{ $distribution_barangay->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteDistributionBarangayModalLabel{{ $distribution->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDistributionBarangayModalLabel{{ $distribution_barangay->id }}">Delete Distribution to Barangay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the Distribution to Barangay <strong>"{{ $distribution_barangay->barangay->name }}"</strong>?</p>
                <form action="{{ route('distribution_barangay.destroy', $distribution_barangay->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    body.dark-mode #deleteDistributionBarangayModal{{ $distribution_barangay->id }} .modal-content {
        background-color: #343a40;
        /* Dark mode background color for the modal content */
        color: #fff;
    }

    body.dark-mode #deleteDistributionBarangayModal{{ $distribution_barangay->id }} .modal-header {
        background-color: #343a40;
        /* Dark mode background color for the modal header */
        color: #fff;
        border-bottom: 1px solid #dc3545;
        /* Border color for the header */
    }

    body.dark-mode #deleteDistributionBarangayModal{{ $distribution_barangay->id }} .modal-title {
        color: #fff;
        /* Text color for the modal title in dark mode */
    }

    body.dark-mode #deleteDistributionBarangayModal{{ $distribution_barangay->id }} .modal-body {
        background-color: #343a40;
        /* Dark mode background color for the modal body */
    }

    body.dark-mode #deleteDistributionBarangayModal{{ $distribution_barangay->id }} p {
        color: #fff;
        /* Text color for paragraph in dark mode */
    }
</style>
