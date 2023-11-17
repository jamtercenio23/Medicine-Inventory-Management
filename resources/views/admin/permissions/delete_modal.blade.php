<div class="modal fade" id="deletePermissionModal{{ $permission->id }}" tabindex="-1" role="dialog"
    aria-labelledby="deletePermissionModalLabel{{ $permission->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePermissionModalLabel{{ $permission->id }}">Delete Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the permission <strong>"{{ $permission->name }}"</strong>?</p>
                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>
                        Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    body.dark-mode #deletePermissionModal{{ $permission->id }} .modal-content {
        background-color: #343a40;
        /* Dark mode background color for the modal content */
        color: #fff;
    }

    body.dark-mode #deletePermissionModal{{ $permission->id }} .modal-header {
        background-color: #343a40;
        /* Dark mode background color for the modal header */
        color: #fff;
        border-bottom: 1px solid #dc3545;
        /* Border color for the header */
    }

    body.dark-mode #deletePermissionModal{{ $permission->id }} .modal-title {
        color: #fff;
        /* Text color for the modal title in dark mode */
    }

    body.dark-mode #deletePermissionModal{{ $permission->id }} .modal-body {
        background-color: #343a40;
        /* Dark mode background color for the modal body */
    }

    body.dark-mode #deletePermissionModal{{ $permission->id }} p {
        color: #fff;
        /* Text color for paragraph in dark mode */
    }
</style>
