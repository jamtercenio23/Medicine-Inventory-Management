<div class="modal fade" id="editPermissionModal{{ $permission->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editPermissionModalLabel{{ $permission->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPermissionModalLabel{{ $permission->id }}">Edit Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Permission Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ $permission->name }}" placeholder="Enter the Permission Name" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    body.dark-mode #editPermissionModal{{ $permission->id }} .modal-content {
        background-color: #343a40;
        /* Dark mode background color for the modal content */
        color: #fff;
    }

    body.dark-mode #editPermissionModal{{ $permission->id }} .modal-header {
        background-color: #343a40;
        /* Dark mode background color for the modal header */
        color: #fff;
        border-bottom: 1px solid #007bff;
        /* Border color for the header */
    }

    body.dark-mode #editPermissionModal{{ $permission->id }} .modal-title {
        color: #fff;
        /* Text color for the modal title in dark mode */
    }

    body.dark-mode #editPermissionModal{{ $permission->id }} .modal-body {
        background-color: #343a40;
        /* Dark mode background color for the modal body */
    }

    body.dark-mode #editPermissionModal{{ $permission->id }} label,
    body.dark-mode #editPermissionModal{{ $permission->id }} .form-control {
        color: #fff;
        /* Text color for labels and form controls in dark mode */
    }
</style>
