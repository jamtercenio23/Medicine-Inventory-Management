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
                                <select class="form-control" id="patient_id" name="patient_id" required>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}"
                                            {{ $distribution->patient->id == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->first_name }} {{ $patient->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicine_id">Medicine:</label>
                                <select class="form-control" id="medicine_id" name="medicine_id" required>
                                    @foreach ($medicines as $medicine)
                                        <option value="{{ $medicine->id }}"
                                            {{ $distribution->medicine->id == $medicine->id ? 'selected' : '' }}>
                                            {{ $medicine->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stocks">Stocks:</label>
                                <input type="number" name="stocks" id="stocks" class="form-control"
                                    value="{{ old('stocks', $distribution->stocks) }}" placeholder="Enter the Stocks" required>
                            </div>
                            <div class="form-group">
                                <label for="checkup_date">Checkup Date:</label>
                                <input type="date" class="form-control" id="checkup_date" name="checkup_date"
                                    value="{{ $distribution->checkup_date }}" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

