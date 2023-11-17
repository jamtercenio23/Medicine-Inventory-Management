<div class="modal fade" id="editPatientModal{{ $patient->id }}" tabindex="-1" role="dialog" aria-labelledby="editPatientModalLabel{{ $patient->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPatientModalLabel{{ $patient->id }}">Edit Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Patient Edit Form -->
                <form action="{{ route('patients.update', $patient->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">First Name:</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $patient->first_name }}" placeholder="Enter the First Name" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name:</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $patient->last_name }}" placeholder="Enter the Last Name" required>
                            </div>
                            <div class="form-group">
                                <label for="birthdate">Birthdate:</label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ $patient->birthdate }}" required>
                            </div>
                            <div class="form-group">
                                <label for="age">Age:</label>
                                <input type="number" class="form-control" id="age" name="age" value="{{ $patient->age }}" placeholder="Enter the Age" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="Male" {{ $patient->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $patient->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="N/A" {{ $patient->gender == 'N/A' ? 'selected' : '' }}>N/A</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="barangay_id">Barangay:</label>
                                <select class="form-control" id="barangay_id" name="barangay_id" required>
                                    @foreach($barangays as $barangay)
                                        <option value="{{ $barangay->id }}" {{ $patient->barangay_id == $barangay->id ? 'selected' : '' }}>{{ $barangay->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="blood_pressure">Blood Pressure:</label>
                                <input type="text" class="form-control" id="blood_pressure" name="blood_pressure" value="{{ $patient->blood_pressure }}" placeholder="Enter Blood Pressure">
                            </div>
                            <div class="form-group">
                                <label for="heart_rate">Heart Rate:</label>
                                <input type="number" class="form-control" id="heart_rate" name="heart_rate" value="{{ $patient->heart_rate }}" placeholder="Enter Heart Rate">
                            </div>
                            <div class="form-group">
                                <label for="weight">Weight:</label>
                                <input type="number" class="form-control" id="weight" name="weight" value="{{ $patient->weight }}" placeholder="Enter Weight">
                            </div>
                            <div class="form-group">
                                <label for="height">Height:</label>
                                <input type="number" class="form-control" id="height" name="height" value="{{ $patient->height }}" placeholder="Enter Height">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    body.dark-mode #editPatientModal{{ $patient->id }} .modal-content {
        background-color: #343a40;
        /* Dark mode background color for the modal content */
        color: #fff;
    }

    body.dark-mode #editPatientModal{{ $patient->id }} .modal-header {
        background-color: #343a40;
        /* Dark mode background color for the modal header */
        color: #fff;
        border-bottom: 1px solid #007bff;
        /* Border color for the header */
    }

    body.dark-mode #editPatientModal{{ $patient->id }} .modal-title {
        color: #fff;
        /* Text color for the modal title in dark mode */
    }

    body.dark-mode #editPatientModal{{ $patient->id }} .modal-body {
        background-color: #343a40;
        /* Dark mode background color for the modal body */
    }

    body.dark-mode #editPatientModal{{ $patient->id }} label,
    body.dark-mode #editPatientModal{{ $patient->id }} .form-control {
        color: #fff;
        /* Text color for labels and form controls in dark mode */
    }
</style>
