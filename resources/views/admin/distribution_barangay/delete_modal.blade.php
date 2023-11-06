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
