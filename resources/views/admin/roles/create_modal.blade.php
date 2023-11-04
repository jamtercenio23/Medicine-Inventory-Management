<!-- Create Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1" role="dialog" aria-labelledby="createRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRoleModalLabel">Create Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="roleName">Role Name</label>
                        <input type="text" class="form-control" id="roleName" name="name" placeholder="Enter the Role Name"required>
                    </div>
                    <div class="form-group">
                        <label>Select Permissions</label>
                        <div class="permission-container" style="max-height: 200px; overflow-y: auto;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAllPermissions" onclick="toggleAllPermissions()">
                                <label class="form-check-label" for="selectAllPermissions">Select All</label>
                            </div>
                            @foreach(\Spatie\Permission\Models\Permission::all() as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="permission{{ $permission->id }}" name="permissions[]" value="{{ $permission->name }}">
                                    <label class="form-check-label" for="permission{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Create Role</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleAllPermissions() {
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
        const selectAllCheckbox = document.getElementById('selectAllPermissions');

        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    }
</script>

<style>
    .permission-container {
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 5px;
    }
</style>
