<div class="modal fade" id="editBarangayPatientModal{{ $barangayPatient->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editBarangayPatientModalLabel{{ $barangayPatient->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBarangayPatientModalLabel{{ $barangayPatient->id }}">Edit Patient</h5>
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
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                    value="{{ $barangayPatient->first_name }}" placeholder="Enter the First Name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name:</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    value="{{ $barangayPatient->last_name }}" placeholder="Enter the Last Name"required>
                            </div>
                            <div class="form-group">
                                <label for="birthdate">Birthdate:</label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate"
                                    value="{{ $barangayPatient->birthdate }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="age">Age:</label>
                                <input type="number" class="form-control" id="age" name="age"
                                    value="{{ $barangayPatient->age }}" placeholder="Enter the Age"required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="Male" {{ $barangayPatient->gender == 'Male' ? 'selected' : '' }}>
                                        Male</option>
                                    <option value="Female" {{ $barangayPatient->gender == 'Female' ? 'selected' : '' }}>
                                        Female</option>
                                    <option value="N/A" {{ $barangayPatient->gender == 'N/A' ? 'selected' : '' }}>
                                        N/A</option>
                                </select>
                            </div>
                            <div class="form-group"> <label for="barangay_id">Barangay:</label> <select
                                    class="form-control" id="barangay_id" name="barangay_id" required>
                                    @if (Auth::user()->isAdmin())
                                        @foreach ($barangays as $barangay)
                                            <option value="{{ $barangay->id }}"
                                                {{ $barangayPatient->barangay_id == $barangay->id ? 'selected' : '' }}>
                                                {{ $barangay->name }}</option>
                                        @endforeach
                                    @elseif (Auth::user()->isBHW())
                                        <option value="{{ Auth::user()->barangay->id }}"
                                            {{ $barangayPatient->barangay_id == Auth::user()->barangay->id ? 'selected' : '' }}>
                                            {{ Auth::user()->barangay->name }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>
                        Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    body.dark-mode #editBarangayPatientModal{{ $barangayPatient->id }} .modal-content {
        background-color: #343a40;
        /* Dark mode background color for the modal content */
        color: #fff;
    }

    body.dark-mode #editBarangayPatientModal{{ $barangayPatient->id }} .modal-header {
        background-color: #343a40;
        /* Dark mode background color for the modal header */
        color: #fff;
        border-bottom: 1px solid #007bff;
        /* Border color for the header */
    }

    body.dark-mode #editBarangayPatientModal{{ $barangayPatient->id }} .modal-title {
        color: #fff;
        /* Text color for the modal title in dark mode */
    }

    body.dark-mode #editBarangayPatientModal{{ $barangayPatient->id }} .modal-body {
        background-color: #343a40;
        /* Dark mode background color for the modal body */
    }

    body.dark-mode #editBarangayPatientModal{{ $barangayPatient->id }} label,
    body.dark-mode #editBarangayPatientModal{{ $barangayPatient->id }} .form-control {
        color: #fff;
        /* Text color for labels and form controls in dark mode */
    }
</style>
