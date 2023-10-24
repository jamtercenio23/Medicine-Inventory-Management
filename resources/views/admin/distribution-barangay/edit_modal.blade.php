<div class="modal fade" id="editDistributionBarangayModal{{ $distribution->id }}" tabindex="-1" role="dialog" aria-labelledby="editDistributionBarangayModalLabel{{ $distribution->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDistributionBarangayModalLabel{{ $distribution->id }}">Edit Distribution to Barangay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Distribution to Barangay Edit Form -->
                <form action="{{ route('distribution-barangay.update', $distribution->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="barangay_id">Barangay:</label>
                        <select class="form-control" id="barangay_id" name="barangay_id" required>
                            @foreach($barangays as $barangay)
                                <option value="{{ $barangay->id }}" {{ $distribution->barangay_id == $barangay->id ? 'selected' : '' }}>{{ $barangay->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="medicine_id">Medicine:</label>
                        <select class="form-control" id="medicine_id" name="medicine_id" required>
                            @foreach($medicines as $medicine)
                                <option value="{{ $medicine->id }}" {{ $distribution->medicine_id == $medicine->id ? 'selected' : '' }}>{{ $medicine->brand_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stocks">Stock:</label>
                        <input type="number" class="form-control" id="stocks" name="stocks" value="{{ $distribution->stock }}" required>
                    </div>
                    <div class="form-group">
                        <label for="distribution_date">Distribution Date:</label>
                        <input type="date" class="form-control" id="distribution_date" name="distribution_date" value="{{ $distribution->distribution_date }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
