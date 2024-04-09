<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Conferences</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for conference table */
        .conference-table {
            width: 80%; /* Adjust the width as needed */
            margin: 50px auto; /* Center the table */
        }
        /* Custom styles for clickable conference names */
        .conference-name {
            cursor: pointer;
            color: blue; /* Change color as needed */
            text-decoration: underline; /* Add underline */
        }
        .conference-name:hover {
            color: darkblue; /* Change hover color as needed */
        }

        /* Additional styling for table */
        .conference-table th, .conference-table td {
            text-align: center;
            vertical-align: middle;
            font-size: 18px;
        }

        .conference-table th {
            background-color: #f2f2f2;
        }

        /* Additional styling for top right buttons */
        .top-right-buttons {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Top right buttons -->
    <div class="top-right-buttons">
        @if (Auth::check() && Auth::user()->role === 'admin')
            <!-- Display log out button for admin -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-primary">Log Out</button>
            </form>
        @else
            <!-- Display register and login buttons for non-admin users -->
            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
        @endif
    </div>


    <!-- Conference Table -->
    <div class="conference-table">
        <h1 class="text-center mb-4">Welcome to Conferences</h1>
        <h2 class="text-center mb-3">Conferences List</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Address</th>
                @if (Auth::check() && Auth::user()->role === 'admin')
                    <th>Actions</th> <!-- New column for edit and delete buttons -->
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($conferences as $conference)
                <tr>
                    <td class="conference-name" data-id="{{ $conference->id }}" data-toggle="modal" data-target="#conferenceModal">{{ $conference->name }}</td>
                    <td>{{ $conference->date }}</td>
                    <td>{{ $conference->address }}</td>
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <td>
                            <!-- Edit button -->
                            <button class="btn btn-sm btn-primary mr-1 edit-conference" data-toggle="modal" data-target="#editConferenceModal" data-id="{{ $conference->id }}">Edit</button>
                            <!-- Delete button -->
                            <form method="POST" action="{{ route('conference.delete', $conference->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this conference?')">Delete</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- Create conference button -->
        @if (Auth::check() && Auth::user()->role === 'admin')
            <div class="text-right mt-3">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createConferenceModal">Create Conference</button>
            </div>
        @endif
    </div>


    <!-- Conference Description Modal -->
    <div class="modal fade" id="conferenceModal" tabindex="-1" role="dialog" aria-labelledby="conferenceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="conferenceModalLabel">Conference Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h4 id="conferenceName" class="modal-title mb-3"></h4>
                    <p id="conferenceDateAddress" class="conference-details mb-3"></p>
                    <p id="conferenceDescription" class="description-font"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Conference Modal -->
    <div class="modal fade" id="createConferenceModal" tabindex="-1" role="dialog" aria-labelledby="createConferenceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="createConferenceModalLabel">Create New Conference</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('conference.create') }}" id="createConferenceForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Title</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" name="address" id="address" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Conference</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Conference Modal -->
    <div class="modal fade" id="editConferenceModal" tabindex="-1" role="dialog" aria-labelledby="editConferenceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="editConferenceModalLabel">Edit Conference</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editConferenceForm" action="{{ route('conference.update', ['id' => $conference->id]) }}" method="POST">
                    @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="editTitle">Title</label>
                            <input type="text" name="name" id="editTitle" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editDate">Date</label>
                            <input type="date" name="date" id="editDate" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editAddress">Address</label>
                            <input type="text" name="address" id="editAddress" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editDescription">Description</label>
                            <textarea name="description" id="editDescription" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="button" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- JavaScript/jQuery libraries -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Custom JavaScript -->
<script>
    $(document).ready(function() {
        $('.conference-name').click(function() {
            var id = $(this).data('id');
            $.get('/conference/description/' + id, function(data) {
                $('#conferenceName').text(data.name);
                $('#conferenceDateAddress').html('<i>' + data.date + ' | ' + data.address + '</i>');
                $('#conferenceDescription').text(data.description);
            });
        });

        $('.edit-conference').click(function() {
            var id = $(this).data('id');
            $.get('/conference/' + id + '/edit', function(data) {
                $('#editTitle').val(data.name);
                $('#editDate').val(data.date);
                $('#editAddress').val(data.address);
                $('#editDescription').val(data.description);
                $('#editConferenceForm').attr('action', '/conference/' + id); // Set the form action dynamically
            });
        });
    });

    $(document).ready(function() {
        $('#saveChangesBtn').click(function() {
            var id = $('#editConferenceForm').attr('action').split('/').pop(); // Extract conference ID from form action
            var formData = $('#editConferenceForm').serialize(); // Serialize form data

            $.ajax({
                url: '/conference/' + id,
                type: 'PUT',
                data: formData,
                success: function(response) {
                    // Handle success response, e.g., close modal, refresh page, etc.
                    $('#editConferenceModal').modal('hide');
                    location.reload(); // Refresh page after successful update
                },
                error: function(xhr) {
                    // Handle error response
                    console.error(xhr.responseText);
                    // You can show an error message or perform other actions here
                }
            });
        });
    });

</script>
</body>
</html>
