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
                <form action="{{ route('barangay-distributions.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="barangay_patient_id">Barangay Patient:</label>
                                <select class="form-control" id="barangay_patient_id" name="barangay_patient_id" required>
                                    @foreach ($barangayPatients as $barangayPatient)
                                        @if (auth()->user()->isBHW() && $barangayPatient->barangay_id !== auth()->user()->barangay_id)
                                            @continue
                                        @endif
                                        <option value="{{ $barangayPatient->id }}">{{ $barangayPatient->first_name }} {{ $barangayPatient->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicine_id">Medicine:</label>
                                <select class="form-control" id="medicine_id" name="medicine_id" required>
                                    @foreach ($barangayMedicines as $barangayMedicine)
                                        @if ($barangayMedicine->stocks > 0 && $barangayMedicine->expiration_date > now()->toDateString())
                                            @if (auth()->user()->isBHW() && $barangayMedicine->barangay_id !== auth()->user()->barangay_id)
                                                @continue
                                            @endif
                                            <option value="{{ $barangayMedicine->id }}">{{ $barangayMedicine->generic_name }} - {{ $barangayMedicine->brand_name }} | Stocks: {{ $barangayMedicine->stocks }}</option>
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
                                <input type="date" class="form-control" id="checkup_date" name="checkup_date" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Create Distribution</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
