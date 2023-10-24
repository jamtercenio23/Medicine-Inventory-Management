<!-- Edit Patient Modal -->
<div class="modal fade" id="editPatientModal{{ $patient->id }}" tabindex="-1" role="dialog" aria-labelledby="editPatientModalLabel{{ $patient->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $patient->first_name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $patient->last_name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Birthdate:</label>
                        <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ $patient->birthdate }}" required>
                    </div>
                    <div class="form-group">
                        <label for="age">Age:</label>
                        <input type="number" class="form-control" id="age" name="age" value="{{ $patient->age }}" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="Male" {{ $patient->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $patient->gender == 'Female' ? 'selected' : '' }}>Female</option>
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
                    <div class="form-group">
                        <label for="diagnose">Diagnose:</label>
                        <input type="text" class="form-control" id="diagnose" name="diagnose" value="{{ $patient->diagnose }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
