<div class="modal fade" id="createDistributionBarangayModal" tabindex="-1" role="dialog"
    aria-labelledby="createDistributionBarangayModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDistributionBarangayModalLabel">Create Distribution to Barangay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Distribution to Barangay Create Form -->
                <form action="{{ route('distribution_barangay.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="barangay_id">Barangay:</label>
                                <select class="form-control select2" id="barangay_id" name="barangay_id" required>
                                    @foreach ($barangays as $barangay)
                                        <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="medicine_id">Medicine:</label>
                                <select class="form-control select2" id="medicine_id" name="medicine_id" required>
                                    @foreach ($medicines as $medicine)
                                        @if ($medicine->stocks > 0 && $medicine->expiration_date >= now()->toDateString())
                                            <option value="{{ $medicine->id }}">{{ $medicine->generic_name }} -
                                                {{ $medicine->brand_name }} | Stocks: {{ $medicine->stocks }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stocks">Stocks:</label>
                                <input type="number" class="form-control" id="stocks" name="stocks" placeholder="Enter the Stocks" required>
                            </div>
                            <div class="form-group">
                                <label for="distribution_date">Distribution Date:</label>
                                <input type="date" class="form-control" id="distribution_date"
                                    name="distribution_date" required>
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
        // Initialize Select2 for barangay and medicine selects
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
@endpush
<style>
    body.dark-mode #createDistributionBarangayModal .modal-content {
        background-color: #343a40;
        /* Dark mode background color for the modal content */
        color: #fff;
    }

    body.dark-mode #createDistributionBarangayModal .modal-header {
        background-color: #343a40;
        /* Dark mode background color for the modal header */
        color: #fff;
        border-bottom: 1px solid #007bff;
        /* Border color for the header */
    }

    body.dark-mode #createDistributionBarangayModal .modal-title {
        color: #fff;
        /* Text color for the modal title in dark mode */
    }

    body.dark-mode #createDistributionBarangayModal .modal-body {
        background-color: #343a40;
        /* Dark mode background color for the modal body */
    }

    body.dark-mode #createDistributionBarangayModal label,
    body.dark-mode #createDistributionBarangayModal .form-control {
        color: #fff;
        /* Text color for labels and form controls in dark mode */
    }
</style>
