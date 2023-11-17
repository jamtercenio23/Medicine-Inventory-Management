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

                <!-- Medicines Distributed to this barangay -->
                <div class="medicines-distributed">
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

                <!-- Schedule for Distribution to this barangay -->
                <div class="distribution-schedule">
                    <h5><strong>Schedule for Distribution:</strong></h5>
                    @if ($barangay->schedules->isEmpty())
                        <p>No Schedule for Distribution to this barangay.</p>
                    @else
                        <ul>
                            @foreach ($barangay->schedules as $schedule)
                                <li>
                                    <p><strong>Medicine Name: </strong>{{ $schedule->medicine->generic_name }} - {{ $schedule->medicine->brand_name }}</p>
                                    <p><strong>Stocks: </strong>{{ $schedule->stock }}</p>
                                    <p><strong>Schedule Date and Time: </strong>{{ $schedule->schedule_date_time }}</p>
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
<style>
    .medicines-distributed {
        background-color: #f7f7f7;
        padding: 10px;
        margin-top: 20px;
    }
    .distribution-schedule{
        background-color: #f7f7f7;
        padding: 10px;
        margin-top: 20px;
    }
    body.dark-mode #showBarangayModal{{ $barangay->id }} .modal-content {
        background-color: #343a40;
        /* Dark mode background color for the modal content */
        color: #fff;
    }

    body.dark-mode #showBarangayModal{{ $barangay->id }} .modal-header {
        background-color: #343a40;
        /* Dark mode background color for the modal header */
        color: #fff;
        border-bottom: 1px solid #007bff;
        /* Border color for the header */
    }

    body.dark-mode #showBarangayModal{{ $barangay->id }} .modal-title {
        color: #fff;
        /* Text color for the modal title in dark mode */
    }

    body.dark-mode #showBarangayModal{{ $barangay->id }} .modal-body {
        background-color: #343a40;
        /* Dark mode background color for the modal body */
        color: #fff;
    }

    body.dark-mode #showBarangayModal{{ $barangay->id }} p {
        color: #fff;
        /* Text color for paragraphs in dark mode */
    }

    body.dark-mode #showBarangayModal{{ $barangay->id }} ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    body.dark-mode #showBarangayModal{{ $barangay->id }} li {
        margin-bottom: 10px;
        color: #fff;
        /* Text color for list items in dark mode */
    }

    body.dark-mode #showBarangayModal{{ $barangay->id }} .modal-footer {
        background-color: #343a40;
        /* Dark mode background color for the modal footer */
        border-top: 1px solid #007bff;
        /* Border color for the footer */
    }

    body.dark-mode #showBarangayModal{{ $barangay->id }} .btn-secondary {
        color: #fff;
        /* Text color for the secondary button in dark mode */
    }

    body.dark-mode #showBarangayModal{{ $barangay->id }} .modal-body > div {
        background-color: #2d2d2d;
        /* Dark mode background color for sections within modal body */
        padding: 10px;
        margin-top: 20px;
    }

    body.dark-mode #showBarangayModal{{ $barangay->id }} .modal-body h5 {
        color: #fff;
        /* Text color for section headings in dark mode */
    }

    body.dark-mode #showBarangayModal{{ $barangay->id }} .modal-body ul {
        padding-left: 20px;
        /* Add left padding to nested ul elements */
    }
</style>
