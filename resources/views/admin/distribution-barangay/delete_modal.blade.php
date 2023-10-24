<div class="modal fade" id="deleteDistributionBarangayModal{{ $distribution->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteDistributionBarangayModalLabel{{ $distribution->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDistributionBarangayModalLabel{{ $distribution->id }}">Delete Distribution to Barangay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the Distribution to Barangay ID {{ $distribution->id }}?</p>
                <!-- Distribution to Barangay Delete Form -->
                <form action="{{ route('distribution-barangay.destroy', $distribution->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
