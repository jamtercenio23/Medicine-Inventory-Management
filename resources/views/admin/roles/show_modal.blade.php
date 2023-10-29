<!-- Show Role Modal -->
<div class="modal fade" id="showRoleModal{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="showRoleModalLabel{{ $role->id }}"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showRoleModalLabel{{ $role->id }}">Show Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Display role details here -->
                <p><strong>ID:</strong> {{ $role->id }}</p>
                <p><strong>Role Name:</strong> {{ $role->name }}</p>
                <!-- Add more details as needed -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
