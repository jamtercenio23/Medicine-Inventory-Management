<div class="modal fade" id="editDistributionModal{{ $barangayDistribution->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editDistributionModalLabel{{ $barangayDistribution->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDistributionModalLabel{{ $barangayDistribution->id }}">Edit Distribution
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Distribution Edit Form -->
                <form action="{{ route('barangay-distributions.update', $barangayDistribution->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="patient_id">Patient:</label>
                                <input list="barangayPatients" class="form-control" id="patient_id" name="patient_id"
                                    placeholder="Enter the Barangay Patient Name/ID" required
                                    value="{{ $barangayDistribution->barangayPatient->first_name }} {{ $barangayDistribution->barangayPatient->last_name }}">
                                <datalist id="barangayPatients">
                                    @foreach ($barangayPatients as $barangayPatient)
                                        @if (auth()->user()->isBHW() && $barangayPatient->barangay_id !== auth()->user()->barangay_id)
                                            @continue
                                        @endif
                                        <option value="{{ $barangayPatient->id }}">{{ $barangayPatient->first_name }}
                                            {{ $barangayPatient->last_name }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="form-group">
                                <label for="medicine_id">Medicine:</label>
                                <input list="medicines" class="form-control" id="medicine_id" name="medicine_id"
                                    placeholder="Enter the Medicine Name/ID" required
                                    value="{{ $barangayDistribution->barangayMedicine->brand_name }}">
                                <datalist id="medicines">
                                    @foreach ($barangayMedicines as $barangayMedicine)
                                        @if ($barangayMedicine->stocks > 0 && $barangayMedicine->expiration_date > now()->toDateString())
                                            @if (auth()->user()->isBHW() && $barangayMedicine->barangay_id !== auth()->user()->barangay_id)
                                                @continue
                                            @endif
                                            <option value="{{ $barangayMedicine->id }}"
                                                {{ $barangayDistribution->barangayMedicine->id == $barangayMedicine->id ? 'selected' : '' }}>
                                                {{ $barangayMedicine->brand_name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="form-group">
                                <label for="stocks">Stocks:</label>
                                <input type="number" name="stocks" id="stocks" class="form-control"
                                    value="{{ old('stocks', $barangayDistribution->stocks) }}"
                                    placeholder="Enter the Stocks" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="diagnose">Diagnose:</label>
                                <input type="text" class="form-control" id="diagnose" name="diagnose"
                                    value="{{ $barangayDistribution->diagnose }}" placeholder="Enter the Diagnose"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="checkup_date">Checkup Date:</label>
                                <input type="date" class="form-control" id="checkup_date" name="checkup_date"
                                    value="{{ $barangayDistribution->checkup_date }}" required>
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
    body.dark-mode #editDistributionModal{{ $barangayDistribution->id }} .modal-content {
        background-color: #343a40;
        /* Dark mode background color for the modal content */
        color: #fff;
    }

    body.dark-mode #editDistributionModal{{ $barangayDistribution->id }} .modal-header {
        background-color: #343a40;
        /* Dark mode background color for the modal header */
        color: #fff;
        border-bottom: 1px solid #007bff;
        /* Border color for the header */
    }

    body.dark-mode #editDistributionModal{{ $barangayDistribution->id }} .modal-title {
        color: #fff;
        /* Text color for the modal title in dark mode */
    }

    body.dark-mode #editDistributionModal{{ $barangayDistribution->id }} .modal-body {
        background-color: #343a40;
        /* Dark mode background color for the modal body */
    }

    body.dark-mode #editDistributionModal{{ $barangayDistribution->id }} label,
    body.dark-mode #editDistributionModal{{ $barangayDistribution->id }} .form-control {
        color: #fff;
        /* Text color for labels and form controls in dark mode */
    }
</style>
