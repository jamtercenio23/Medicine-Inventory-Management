<div class="modal fade" id="editDistributionModal{{ $distribution->id }}" tabindex="-1" role="dialog" aria-labelledby="editDistributionModalLabel{{ $distribution->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                    <div class="form-group">
                        <label for="patient_id">Patient:</label>
                        <select class="form-control" id="patient_id" name="patient_id" required>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ $distribution->patient->id == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->first_name }} {{ $patient->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="medicine_id">Medicine:</label>
                        <select class="form-control" id="medicine_id" name="medicine_id" required>
                            @foreach($medicines as $medicine)
                                <option value="{{ $medicine->id }}" {{ $distribution->medicine->id == $medicine->id ? 'selected' : '' }}>
                                    {{ $medicine->brand_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stocks">Stock:</label>
                        <input type="number" class="form-control" id="stocks" name="stocks" value="{{ $distribution->stocks }}" required>
                    </div>
                    <div class="form-group">
                        <label for="checkup_date">Checkup Date:</label>
                        <input type="date" class="form-control" id="checkup_date" name="checkup_date" value="{{ $distribution->checkup_date }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
