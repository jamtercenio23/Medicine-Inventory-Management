<div class="modal fade" id="createDistributionBarangayModal" tabindex="-1" role="dialog" aria-labelledby="createDistributionBarangayModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDistributionBarangayModalLabel">Create Distribution to Barangay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Distribution to Barangay Create Form -->
                <form action="{{ route('distribution-barangay.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="barangay_id">Barangay:</label>
                        <select class="form-control" id="barangay_id" name="barangay_id" required>
                            @foreach($barangays as $barangay)
                                <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="medicine_id">Medicine:</label>
                        <select class="form-control" id="medicine_id" name="medicine_id" required>
                            @foreach($medicines as $medicine)
                                @if ($medicine->stocks > 0 && $medicine->expiration_date >= now()->toDateString())
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
                        <label for="distribution_date">Distribution Date:</label>
                        <input type="date" class="form-control" id="distribution_date" name="distribution_date" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
