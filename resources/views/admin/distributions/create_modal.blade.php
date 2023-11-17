<div class="modal fade" id="createDistributionModal" tabindex="-1" role="dialog"
    aria-labelledby="createDistributionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDistributionModalLabel">Create Distribution</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Distribution Create Form -->
                <form action="{{ route('distributions.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="patient_id">Patient:</label>
                                <select class="form-control select2" id="patient_id" name="patient_id" required>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->first_name }}
                                            {{ $patient->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicine_id">Medicine:</label>
                                <select class="form-control select2" id="medicine_id" name="medicine_id" required>
                                    @foreach ($medicines as $medicine)
                                        @if ($medicine->stocks > 0 && $medicine->expiration_date > now()->toDateString())
                                            <option value="{{ $medicine->id }}">{{ $medicine->generic_name }} -
                                                {{ $medicine->brand_name }} | Stocks: {{ $medicine->stocks }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="stocks">Stock:</label>
                                <input type="number" class="form-control" id="stocks" name="stocks" placeholder="Enter the Stocks" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="diagnose">Diagnose:</label>
                                <input type="text" class="form-control" id="diagnose" name="diagnose" placeholder="Enter the Diagnose" required>
                            </div>
                            <div class="form-group">
                                <label for="checkup_date">Checkup Date:</label>
                                <input type="date" class="form-control" id="checkup_date" name="checkup_date"
                                    required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Create</button>
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
    body.dark-mode #createDistributionModal .modal-content {
        background-color: #343a40;
        /* Dark mode background color for the modal content */
        color: #fff;
    }

    body.dark-mode #createDistributionModal .modal-header {
        background-color: #343a40;
        /* Dark mode background color for the modal header */
        color: #fff;
        border-bottom: 1px solid #007bff;
        /* Border color for the header */
    }

    body.dark-mode #createDistributionModal .modal-title {
        color: #fff;
        /* Text color for the modal title in dark mode */
    }

    body.dark-mode #createDistributionModal .modal-body {
        background-color: #343a40;
        /* Dark mode background color for the modal body */
    }

    body.dark-mode #createDistributionModal label,
    body.dark-mode #createDistributionModal .form-control {
        color: #fff;
        /* Text color for labels and form controls in dark mode */
    }
</style>
