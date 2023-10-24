<div class="modal fade" id="createDistributionModal" tabindex="-1" role="dialog" aria-labelledby="createDistributionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                    <div class="form-group">
                        <label for="patient_id">Patient:</label>
                        <select class="form-control" id="patient_id" name="patient_id" required>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="medicine_id">Medicine:</label>
                        <select class="form-control" id="medicine_id" name="medicine_id" required>
                            @foreach($medicines as $medicine)
                                @if ($medicine->stocks > 0 && $medicine->expiration_date > now()->toDateString())
                                    <option value="{{ $medicine->id }}">{{ $medicine->generic_name }} - {{ $medicine->brand_name }} | {{ $medicine->stocks }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stocks">Stock:</label>
                        <input type="number" class="form-control" id="stocks" name="stocks" required>
                    </div>
                    <div class="form-group">
                        <label for="checkup_date">Checkup Date:</label>
                        <input type="date" class="form-control" id="checkup_date" name="checkup_date" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
