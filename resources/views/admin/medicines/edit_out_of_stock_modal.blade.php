<!-- Edit Out of Stock Medicine Modal -->
<div class="modal fade" id="editOutOfStockModal{{ $medicine->id }}" tabindex="-1" role="dialog" aria-labelledby="editOutOfStockModalLabel{{ $medicine->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOutOfStockModalLabel{{ $medicine->id }}">Edit Out of Stock Medicine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Edit Out of Stock Medicine Form -->
                <form action="{{ route('out-of-stock.update', $medicine->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="stocks">Stocks:</label>
                        <input type="number" class="form-control" id="stocks" name="stocks" value="{{ $medicine->stocks }}" placeholder="Enter the Stocks"required>
                    </div>
                    <!-- Add other form elements as needed -->

                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
