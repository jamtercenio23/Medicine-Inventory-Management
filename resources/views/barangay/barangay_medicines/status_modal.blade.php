<!-- Status Modal -->
<div class="modal fade" id="statusModal{{ $barangayMedicine->id }}" tabindex="-1" role="dialog"
    aria-labelledby="statusModalLabel{{ $barangayMedicine->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel{{ $barangayMedicine->id }}">Request Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Status:</strong> {{ $barangayMedicine->status }}</p>
                @if ($barangayMedicine->status == 'approved')
                    <p><strong>Expected Stocks:</strong> {{ $barangayMedicine->expected_stocks }}</p>
                    <p><strong>Distribution Schedule:</strong> {{ $barangayMedicine->distribution_schedule }}</p>
                @elseif ($barangayMedicine->status == 'rejected')
                    <p><strong>Admin's Comment:</strong> {{ $barangayMedicine->admin_comment }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
<style>
    body.dark-mode #statusModal{{ $barangayMedicine->id }} .modal-content {
        background-color: #343a40;
        color: #fff;
    }

    body.dark-mode #statusModal{{ $barangayMedicine->id }} .modal-header {
        background-color: #343a40;
        color: #fff;
        border-bottom: 1px solid #007bff;
    }

    body.dark-mode #statusModal{{ $barangayMedicine->id }} .modal-title {
        color: #fff;
    }

    body.dark-mode #statusModal{{ $barangayMedicine->id }} .modal-body {
        background-color: #343a40;
        color: #fff;
    }

    body.dark-mode #statusModal{{ $barangayMedicine->id }} p {
        color: #fff;
    }

    body.dark-mode #showbarangayMedicineModal{{ $barangayMedicine->id }} ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    body.dark-mode #showbarangayMedicineModal{{ $barangayMedicine->id }} li {
        margin-bottom: 10px;
        color: #fff;
    }

    body.dark-mode #showbarangayMedicineModal{{ $barangayMedicine->id }} .modal-footer {
        background-color: #343a40;
        border-top: 1px solid #007bff;
    }

    body.dark-mode #showbarangayMedicineModal{{ $barangayMedicine->id }} .btn-secondary {
        color: #fff;
    }
</style>
