<div class="modal fade" id="showPatientModal{{ $patient->id }}" tabindex="-1" role="dialog" aria-labelledby="showPatientModalLabel{{ $patient->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showPatientModalLabel{{ $patient->id }}">Patient Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong><br>{{ $patient->id }}</p>
                        <p><strong>First Name:</strong><br>{{ $patient->first_name }}</p>
                        <p><strong>Last Name:</strong><br>{{ $patient->last_name }}</p>
                        <p><strong>Birthdate:</strong><br>{{ $patient->birthdate }}</p>
                        <p><strong>Age:</strong><br>{{ $patient->age }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Gender:</strong><br>{{ $patient->gender }}</p>
                        <p><strong>Barangay:</strong><br>{{ $patient->barangay->name }}</p>
                        <p><strong>Diagnose:</strong><br>{{ $patient->diagnose }}</p>
                    </div>
                </div>
                <h5><strong>Medicines Distributed:</strong><br></h5>
                @if ($patient->distributions->isEmpty())
                    <p>No medicines distributed to this patient.</p>
                @else
                    <ul>
                        @foreach ($patient->distributions as $distribution)
                            <li>
                                {{ $distribution->medicine->generic_name }} - {{ $distribution->medicine->brand_name }} (Stock: {{ $distribution->stocks }})
                                <p>Checkup Date: {{ $distribution->checkup_date }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
