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
                <p>ID: {{ $barangay->id }}</p>
                <p>Name: {{ $barangay->name }}</p>

                <!-- Medicines distributed to this barangay -->
                <h5>Medicines Distributed:</h5>
                @if ($barangay->distributions->isEmpty())
                    <p>No medicines distributed to this barangay.</p>
                @else
                    <ul>
                        @foreach ($barangay->distributions as $distribution)
                        <li>
                            {{ $distribution->medicine->generic_name }} - {{ $distribution->medicine->brand_name }} (Stocks: {{ $distribution->stocks }})
                        </li>
                        @endforeach
                    </ul>
                @endif
                <!-- Add other details as needed -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
