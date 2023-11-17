<div class="modal fade" id="showBarangayPatientModal{{ $barangayPatient->id }}" tabindex="-1" role="dialog"
    aria-labelledby="showBarangayPatientModalLabel{{ $barangayPatient->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showBarangayPatientModalLabel{{ $barangayPatient->id }}">Patient Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>First Name:</strong><br>{{ $barangayPatient->first_name }}</p>
                        <p><strong>Last Name:</strong><br>{{ $barangayPatient->last_name }}</p>
                        <p><strong>Birthdate:</strong><br>{{ $barangayPatient->birthdate }}</p>

                    </div>
                    <div class="col-md-6">
                        <p><strong>Age:</strong><br>{{ $barangayPatient->age }}</p>
                        <p><strong>Gender:</strong><br>{{ $barangayPatient->gender }}</p>
                        <p><strong>Barangay:</strong><br>{{ $barangayPatient->barangay->name }}</p>
                    </div>
                </div>
                <div class="medicines-distributed">
                    <h5><strong>Medicines Distributed:</strong></h5>
                    @if ($barangayPatient->barangayDistributions->isEmpty())
                        <p>No medicines distributed to this patient.</p>
                    @else
                        <ul>
                            @foreach ($barangayPatient->barangayDistributions as $barangayDistribution)
                                <li>
                                    <p><strong>Medicine Name:
                                        </strong>{{ $barangayDistribution->barangayMedicine->generic_name }} -
                                        {{ $barangayDistribution->barangayMedicine->brand_name }}</p>
                                    <p><strong>Stocks: </strong>{{ $barangayDistribution->stocks }}</p>
                                    <p><strong>Diagnose: </strong>{{ $barangayDistribution->diagnose }}</p>
                                    <p><strong>Checkup Date: </strong>{{ $barangayDistribution->checkup_date }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>
                    Close</button>
            </div>
        </div>
    </div>
</div>
<style>
    .medicines-distributed {
        background-color: #f7f7f7;
        padding: 10px;
        margin-top: 20px;
    }

    body.dark-mode #showBarangayPatientModal{{ $barangayPatient->id }} .modal-content {
        background-color: #343a40;
        color: #fff;
    }

    body.dark-mode #showBarangayPatientModal{{ $barangayPatient->id }} .modal-header {
        background-color: #343a40;
        color: #fff;
        border-bottom: 1px solid #007bff;
    }

    body.dark-mode #showBarangayPatientModal{{ $barangayPatient->id }} .modal-title {
        color: #fff;
    }

    body.dark-mode #showBarangayPatientModal{{ $barangayPatient->id }} .modal-body {
        background-color: #343a40;
        color: #fff;
    }

    body.dark-mode #showBarangayPatientModal{{ $barangayPatient->id }} p {
        color: #fff;
    }

    body.dark-mode #showBarangayPatientModal{{ $barangayPatient->id }} ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    body.dark-mode #showBarangayPatientModal{{ $barangayPatient->id }} li {
        margin-bottom: 10px;
        color: #fff;
    }

    body.dark-mode #showBarangayPatientModal{{ $barangayPatient->id }} .modal-footer {
        background-color: #343a40;
        border-top: 1px solid #007bff;
    }

    body.dark-mode #showBarangayPatientModal{{ $barangayPatient->id }} .btn-secondary {
        color: #fff;
    }

    body.dark-mode #showBarangayPatientModal{{ $barangayPatient->id }} .medicines-distributed {
        background-color: #2d2d2d;
        padding: 10px;
        margin-top: 20px;
    }

    body.dark-mode #showBarangayPatientModal{{ $barangayPatient->id }} .medicines-distributed h5 {
        color: #fff;
    }

    body.dark-mode #showBarangayPatientModal{{ $barangayPatient->id }} .medicines-distributed ul {
        padding-left: 20px;
    }
</style>
