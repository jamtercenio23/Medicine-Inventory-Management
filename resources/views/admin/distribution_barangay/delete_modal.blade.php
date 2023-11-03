<div class="modal fade" id="deleteDistributionBarangayModal{{ $distribution_barangay->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteDistributionBarangayModalLabel{{ $distribution->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDistributionBarangayModalLabel{{ $distribution_barangay->id }}">Delete Distribution to Barangay</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the Distribution to Barangay {{ $distribution_barangay->barangay->name }}?</p>
                <form action="{{ route('distribution_barangay.destroy', $distribution_barangay->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
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
        display: block;
    }

    .modal-body input {
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .modal-footer {
        background-color: #f7f7f7;
        border-top: 1px solid #ccc;
        padding: 15px;
    }
</style>
