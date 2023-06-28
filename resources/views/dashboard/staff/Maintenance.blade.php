@extends('layout')

@section('content')
<div class="container">
    <h1>Maintenance Report</h1>

    <form action="{{ route('staff.maintenanceRecord') }}" method="POST" id="maintenanceForm">
        @csrf
        <div class="form-group">
            <label for="reg_no">Bus Registration No:</label>
            <input type="number" name="reg_no" id="reg_no" class="form-control">
        </div>
        <div class="form-group">
            <label for="maintenance_type">Maintenance Type:</label>
            <select name="maintenance_type" id="maintenance_type" class="form-control">
                <option value="Engine">Engine</option>
                <option value="Brakes">Brakes</option>
                <option value="Electrical">Electrical</option>
                <option value="Suspension">Suspension</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="problem">Problem:</label>
            <textarea name="problem" id="problem" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="maintenance_cost">Maintenance Cost:</label>
            <input type="number" name="maintenance_cost" id="maintenance_cost" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
    </form>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="confirmationMessage"></p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                <button type="button" class="btn btn-primary" id="confirmBtn">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Confirmation pop-up
    document.getElementById('maintenanceForm').addEventListener('submit', function(e) {
        e.preventDefault();

        var maintenanceType = document.getElementById('maintenance_type').value;
        var confirmationMessage = 'Maintenance Type: ' + maintenanceType;

        // Set the confirmation message in the modal
        document.getElementById('confirmationMessage').textContent = confirmationMessage;

        // Show the confirmation modal
        $('#confirmationModal').modal('show');
    });

    // Handle confirmation button click
    document.getElementById('confirmBtn').addEventListener('click', function() {
        // Submit the form
        document.getElementById('maintenanceForm').submit();
    });
</script>
@endsection
