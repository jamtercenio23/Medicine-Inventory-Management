<div class="modal fade" id="deleteBarangayModal{{ $barangay->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteBarangayModalLabel{{ $barangay->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBarangayModalLabel{{ $barangay->id }}">Delete Barangay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the Barangay <strong>"{{ $barangay->name }}"</strong>?</p>
                <!-- Barangay Delete Form -->
                <form action="{{ route('barangays.destroy', $barangay->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
