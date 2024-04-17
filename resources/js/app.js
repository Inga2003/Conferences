$(document).ready(function() {
    // Fetching conference data
    $('.conference-name').click(function() {
        var id = $(this).data('id');
        $.get('/conference/description/' + id, function(data) {
            $('#conferenceName').text(data.name);
            $('#conferenceDateAddress').html('<i>' + data.date + ' | ' + data.address + '</i>');
            $('#conferenceDescription').text(data.description);
        });
    });

    // Function to handle editing conference
    $('.edit-conference').click(function() {
        var id = $(this).data('id');
        $.get('/conference/' + id + '/edit', function(data) {
            $('#editTitle').val(data.name);
            $('#editDate').val(data.date);
            $('#editAddress').val(data.address);
            $('#editDescription').val(data.description);
            $('#editConferenceForm').attr('action', '/conference/' + id);
        });
    });

    // Function to handle saving changes to edited conference
    $('#saveChangesBtn').click(function() {
        var id = $('#editConferenceForm').attr('action').split('/').pop(); // Extract conference ID from form action
        var formData = $('#editConferenceForm').serialize();

        $.ajax({
            url: '/conference/' + id,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#editConferenceModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });
});
