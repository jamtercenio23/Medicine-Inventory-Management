<div class="modal fade" id="showBarangayModal{{ $barangay->id }}" tabindex="-1" role="dialog" aria-labelledby="showBarangayModalLabel{{ $barangay->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showBarangayModalLabel{{ $barangay->id }}">Barangay Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong><br>{{ $barangay->name }}</p>

                <!-- Medicines distributed to this barangay -->
                <div style="background-color: #f7f7f7; padding: 10px; margin-top: 20px;">
                    <h5><strong>Medicines Distributed:</strong></h5>
                    @if ($barangay->distributions->isEmpty())
                        <p>No medicines distributed to this barangay.</p>
                    @else
                        <ul>
                            @foreach ($barangay->distributions as $distribution)
                                <li>
                                    <p><strong>Medicine Name: </strong> {{ $distribution->medicine->generic_name }} - {{ $distribution->medicine->brand_name }}</p>
                                    <p><strong>Stocks: </strong>{{ $distribution->stocks }}</p>
                                    <p><strong>Distribution Date: </strong>{{ $distribution->distribution_date }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <!-- Add other details as needed -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>
