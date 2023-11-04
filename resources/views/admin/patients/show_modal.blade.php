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
                <div style="background-color: #f7f7f7; padding: 10px; margin-top: 20px;">
                    <h5><strong>Medicines Distributed:</strong></h5>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
