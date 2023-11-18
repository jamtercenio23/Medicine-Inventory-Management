<div class="modal fade" id="createBarangayModal" tabindex="-1" role="dialog" aria-labelledby="createBarangayModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBarangayModalLabel">Create Barangay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Barangay Create Form -->
                <form action="{{ route('barangays.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter the Barangay Name" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    body.dark-mode #createBarangayModal .modal-content {
        background-color: #343a40;
        /* Dark mode background color for the modal content */
        color: #fff;
    }

    body.dark-mode #createBarangayModal .modal-header {
        background-color: #343a40;
        /* Dark mode background color for the modal header */
        color: #fff;
        border-bottom: 1px solid #007bff;
        /* Border color for the header */
    }

    body.dark-mode #createBarangayModal .modal-title {
        color: #fff;
        /* Text color for the modal title in dark mode */
    }

    body.dark-mode #createBarangayModal .modal-body {
        background-color: #343a40;
        /* Dark mode background color for the modal body */
    }

    body.dark-mode #createBarangayModal label {
        color: #fff;
        /* Text color for labels in dark mode */
    }

    body.dark-mode #createBarangayModal .form-control {
        background-color: #2d2d2d; /* Background color for form controls */
        color: #fff; /* Text color for form controls in dark mode */
        border: 1px solid #fff; /* White border for form controls */
        border-radius: 5px; /* Optional: Add border-radius for a rounded look */
    }
</style>
