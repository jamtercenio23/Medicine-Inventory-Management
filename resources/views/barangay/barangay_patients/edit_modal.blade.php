<div class="modal fade" id="editPatientModal{{ $barangayPatient->id }}" tabindex="-1" role="dialog" aria-labelledby="editPatientModalLabel{{ $patient->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPatientModalLabel{{ $barangayPatient->id }}">Edit Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Patient Edit Form -->
                <form action="{{ route('barangay-patients.update', $barangayPatient->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">First Name:</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $barangayPatient->first_name }}" placeholder="Enter the First Name" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name:</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $barangayPatient->last_name }}" placeholder="Enter the Last Name"required>
                            </div>
                            <div class="form-group">
                                <label for="birthdate">Birthdate:</label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ $barangayPatient->birthdate }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="age">Age:</label>
                                <input type="number" class="form-control" id="age" name="age" value="{{ $barangayPatient->age }}" placeholder="Enter the Age"required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="Male" {{ $barangayPatient->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $barangayPatient->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="N/A" {{ $barangayPatient->gender == 'N/A' ? 'selected' : '' }}>N/A</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="barangay_id">Barangay:</label>
                                <select class="form-control" id="barangay_id" name="barangay_id" required>
                                    @foreach($barangays as $barangay)
                                        <option value="{{ $barangay->id }}" {{ $patient->barangay_id == $barangay->id ? 'selected' : '' }}>{{ $barangay->name }}</option>
                                    @endforeach
                                </select>
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
