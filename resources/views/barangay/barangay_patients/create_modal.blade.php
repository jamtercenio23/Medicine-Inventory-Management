<div class="modal fade" id="createBarangayPatientModal" tabindex="-1" role="dialog" aria-labelledby="createBarangayPatientModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBarangayPatientModalLabel">Create Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('barangay-patients.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">First Name:</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter the First Name" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name:</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter the Last Name" required>
                            </div>
                            <div class="form-group">
                                <label for="birthdate">Birthdate:</label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="age">Age:</label>
                                <input type="number" class="form-control" id="age" name="age" placeholder="Enter the Age" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="N/A">N/A</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="barangay_id">Barangay:</label>
                                <select class="form-control" id="barangay_id" name="barangay_id" required>
                                    @if (Auth::user()->isBarangayUser() || Auth::user()->isAdmin())
                                        @foreach ($barangays as $barangay)
                                            <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="{{ Auth::user()->barangay->id }}">{{ Auth::user()->barangay->name }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    body.dark-mode #createBarangayPatientModal .modal-content {
        background-color: #343a40;
        /* Dark mode background color for the modal content */
        color: #fff;
    }

    body.dark-mode #createBarangayPatientModal .modal-header {
        background-color: #343a40;
        /* Dark mode background color for the modal header */
        color: #fff;
        border-bottom: 1px solid #007bff;
        /* Border color for the header */
    }

    body.dark-mode #createBarangayPatientModal .modal-title {
        color: #fff;
        /* Text color for the modal title in dark mode */
    }

    body.dark-mode #createBarangayPatientModal .modal-body {
        background-color: #343a40;
        /* Dark mode background color for the modal body */
    }

    body.dark-mode #createBarangayPatientModal label,
    body.dark-mode #createBarangayPatientModal .form-control {
        color: #fff;
        /* Text color for labels and form controls in dark mode */
    }
</style>
