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
                <p><strong>ID:</strong><br>{{ $barangay->id }}</p>
                <p><strong>Name:</strong><br>{{ $barangay->name }}</p>

                <!-- Medicines distributed to this barangay -->
                <h5><strong>Medicines Distributed:</strong><br></h5>
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
<style>
    /* Add custom CSS styles here */
    .modal-content {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Add a subtle shadow */
    }

    .modal-title {
        font-weight: bold;
        color: #007bff; /* Change title color */
        margin-bottom: 20px;
    }

    .modal-body {
        background-color: #f7f7f7; /* Change modal body background color */
        padding: 20px;
    }

    .modal-body label {
        font-weight: bold;
    }

    .modal-body input {
        border: 1px solid #ccc; /* Add a border to input fields */
        border-radius: 5px;
    }

    .modal-footer {
        background-color: #f7f7f7; /* Change modal footer background color */
        border-top: 1px solid #ccc;
        padding: 15px;
    }

    /* Add transitions or animations as needed */
</style>
