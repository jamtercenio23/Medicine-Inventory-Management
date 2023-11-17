<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">Notification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Notification content goes here -->
                <p id="notificationContent"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<style>
    /* ... Your existing styles ... */

    body.dark-mode #notificationModal .modal-content {
        background-color: #343a40;
        color: #fff;
    }

    body.dark-mode #notificationModal .modal-header {
        background-color: #343a40;
        color: #fff;
        border-bottom: 1px solid #007bff;
    }

    body.dark-mode #notificationModal .modal-title {
        color: #fff;
    }

    body.dark-mode #notificationModal .modal-body {
        background-color: #343a40;
        color: #fff;
    }

    body.dark-mode #notificationModal .modal-footer {
        background-color: #343a40;
        border-top: 1px solid #007bff;
    }

    body.dark-mode #notificationModal .btn-secondary {
        color: #fff;
    }
</style>
