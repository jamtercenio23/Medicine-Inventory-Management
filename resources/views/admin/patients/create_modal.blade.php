<div class="modal fade" id="createPatientModal" tabindex="-1" role="dialog" aria-labelledby="createPatientModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPatientModalLabel">Create Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('patients.store') }}" method="post">
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
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="barangay_id">Barangay:</label>
                                <select class="form-control" id="barangay_id" name="barangay_id" required>
                                    @foreach ($barangays as $barangay)
                                        <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="blood_pressure">Blood Pressure:</label>
                                <input type="text" class="form-control" id="blood_pressure" name="blood_pressure" placeholder="Enter Blood Pressure">
                            </div>
                            <div class="form-group">
                                <label for="heart_rate">Heart Rate:</label>
                                <input type="number" class="form-control" id="heart_rate" name="heart_rate" placeholder="Enter Heart Rate">
                            </div>
                            <div class="form-group">
                                <label for="weight">Weight:</label>
                                <input type="number" class="form-control" id="weight" name="weight" placeholder="Enter Weight">
                            </div>
                            <div class="form-group">
                                <label for="height">Height:</label>
                                <input type="number" class="form-control" id="height" name="height" placeholder="Enter Height">
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
    body.dark-mode #createPatientModal .modal-content {
        background-color: #343a40;
        /* Dark mode background color for the modal content */
        color: #fff;
    }

    body.dark-mode #createPatientModal .modal-header {
        background-color: #343a40;
        /* Dark mode background color for the modal header */
        color: #fff;
        border-bottom: 1px solid #007bff;
        /* Border color for the header */
    }

    body.dark-mode #createPatientModal .modal-title {
        color: #fff;
        /* Text color for the modal title in dark mode */
    }

    body.dark-mode #createPatientModal .modal-body {
        background-color: #343a40;
        /* Dark mode background color for the modal body */
    }

    body.dark-mode #createPatientModal label,
    body.dark-mode #createPatientModal .form-control {
        color: #fff;
        /* Text color for labels and form controls in dark mode */
    }
</style>
