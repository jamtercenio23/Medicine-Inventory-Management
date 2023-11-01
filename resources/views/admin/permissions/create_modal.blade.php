<div class="modal fade" id="createPermissionModal" tabindex="-1" role="dialog" aria-labelledby="createPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPermissionModalLabel">Create Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Permission Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    /* Add custom CSS styles here */
    .modal-content {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Add a subtle shadow */
    }

    .modal-title {
        font-weight: bold;
        color: #007bff; /* Change title color */
        margin-bottom: 20px;
    }

    .modal-body {
        background-color: #f7f7f7; /* Change modal body background color */
        padding: 20px;
    }

    .modal-body label {
        font-weight: bold;
    }

    .modal-body input, .modal-body select {
        border: 1px solid #ccc; /* Add a border to input fields */
        border-radius: 5px;
    }

    .modal-footer {
        background-color: #f7f7f7; /* Change modal footer background color */
        border-top: 1px solid #ccc;
        padding: 15px;
    }

    /* Add transitions or animations as needed */
</style>
