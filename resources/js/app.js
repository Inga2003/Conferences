
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
            }
        });
    });
});
