<div class="modal fade" id="showPatientModal{{ $patient->id }}" tabindex="-1" role="dialog" aria-labelledby="showPatientModalLabel{{ $patient->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showPatientModalLabel{{ $patient->id }}">Patient Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>ID: {{ $patient->id }}</p>
                <p>First Name: {{ $patient->first_name }}</p>
                <p>Last Name: {{ $patient->last_name }}</p>
                <p>Birthdate: {{ $patient->birthdate }}</p>
                <p>Age: {{ $patient->age }}</p>
                <p>Gender: {{ $patient->gender }}</p>
                <p>Barangay: {{ $patient->barangay->name }}</p>
                <p>Diagnose: {{ $patient->diagnose }}</p>
                <h5>Medicines Distributed:</h5>
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
