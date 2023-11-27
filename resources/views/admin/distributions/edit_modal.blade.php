<div class="modal fade" id="editDistributionModal{{ $distribution->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editDistributionModalLabel{{ $distribution->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDistributionModalLabel{{ $distribution->id }}">Edit Distribution</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Distribution Edit Form -->
                <form action="{{ route('distributions.update', $distribution->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="patient_id">Patient:</label>
                                <input list="patients" class="form-control" id="patient_id" name="patient_id" placeholder="Enter the Patient Name/ID" required
                                       value="{{ $distribution->patient->first_name }} {{ $distribution->patient->last_name }}"> <!-- Assuming $distribution->patient is the related patient model -->
                                <datalist id="patients">
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                                    @endforeach
                                </datalist>
                            </div>

                            <div class="form-group">
                                <label for="medicine_id">Medicine:</label>
                                <input list="medicines" class="form-control" id="medicine_id" name="medicine_id" placeholder="Enter the Medicine Name/ID" required
                                       value="{{ $distribution->medicine->brand_name }}"> <!-- Assuming $distribution->medicine is the related medicine model -->
                                <datalist id="medicines">
                                    @foreach ($medicines as $medicine)
                                        @if ($medicine->stocks > 0 && $medicine->expiration_date > now()->toDateString())
                                            <option value="{{ $medicine->id }}">{{ $medicine->generic_name }} -
                                                {{ $medicine->brand_name }} | Stocks: {{ $medicine->stocks }}</option>
                                        @endif
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="form-group">
                                <label for="stocks">Stocks:</label>
                                <input type="number" name="stocks" id="stocks" class="form-control"
                                    value="{{ old('stocks', $distribution->stocks) }}" placeholder="Enter the Stocks" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="diagnose">Diagnose:</label>
                                <input type="text" class="form-control" id="diagnose" name="diagnose" value="{{ $distribution->diagnose }}" placeholder="Enter the Diagnose" required>
                            </div>
                            <div class="form-group">
                                <label for="checkup_date">Checkup Date:</label>
                                <input type="date" class="form-control" id="checkup_date" name="checkup_date"
                                    value="{{ $distribution->checkup_date }}" required>
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

@push('scripts')
    <script>
        // Initialize Select2 for patient and medicine selects
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
@endpush
<style>
    body.dark-mode #editDistributionModal{{ $distribution->id }} .modal-content {
        background-color: #343a40;
        /* Dark mode background color for the modal content */
        color: #fff;
    }

    body.dark-mode #editDistributionModal{{ $distribution->id }} .modal-header {
        background-color: #343a40;
        /* Dark mode background color for the modal header */
        color: #fff;
        border-bottom: 1px solid #007bff;
        /* Border color for the header */
    }

    body.dark-mode #editDistributionModal{{ $distribution->id }} .modal-title {
        color: #fff;
        /* Text color for the modal title in dark mode */
    }

    body.dark-mode #editDistributionModal{{ $distribution->id }} .modal-body {
        background-color: #343a40;
        /* Dark mode background color for the modal body */
    }

    body.dark-mode #editDistributionModal{{ $distribution->id }} label,
    body.dark-mode #editDistributionModal{{ $distribution->id }} .form-control {
        color: #fff;
        /* Text color for labels and form controls in dark mode */
    }
</style>
