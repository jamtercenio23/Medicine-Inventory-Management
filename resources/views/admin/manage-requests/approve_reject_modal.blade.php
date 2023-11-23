<div class="modal fade" id="approveRejectModal{{ $request->id }}" tabindex="-1" role="dialog"
    aria-labelledby="approveRejectModalLabel{{ $request->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveRejectModalLabel{{ $request->id }}">Approve/Reject
                    Restock Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Approve/Reject Form -->
                <form action="{{ route('barangay-medicines.approve-reject', $request->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="admin_comment">Admin Comment (optional) :</label>
                        <textarea class="form-control" id="admin_comment" name="admin_comment" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    body.dark-mode #approveRejectModal{{ $request->id }} .modal-content {
            background-color: #343a40;
            color: #fff;
        }

        body.dark-mode #approveRejectModal{{ $request->id }} .modal-header {
            background-color: #343a40;
            color: #fff;
            border-bottom: 1px solid #007bff;
        }

        body.dark-mode #approveRejectModal{{ $request->id }} .modal-title {
            color: #fff;
        }

        body.dark-mode #approveRejectModal{{ $request->id }} .modal-body {
            background-color: #343a40;
            color: #fff;
        }

        body.dark-mode #approveRejectModal{{ $request->id }} p {
            color: #fff;
        }

        body.dark-mode #approveRejectModal{{ $request->id }} ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        body.dark-mode #approveRejectModal{{ $request->id }} li {
            margin-bottom: 10px;
            color: #fff;
        }

        body.dark-mode #approveRejectModal{{ $request->id }} .modal-footer {
            background-color: #343a40;
            border-top: 1px solid #007bff;
        }

        body.dark-mode #approveRejectModal{{ $request->id }} .btn-secondary {
            color: #fff;
        }
</style>
