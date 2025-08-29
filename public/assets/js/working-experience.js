$(document).ready(function () {
  $('#save-work-experience-data').submit(function (event) {
    event.preventDefault();

    var formData = new FormData(this);

    $('.validated-msg').remove();

    $.ajax({
      url: baseURL + 'specialist/experience/save',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Assuming you have a tbody with id "experience-table-body"
        $('#experience-table-body').append('<tr><td>' + response.working_org_name + '</td><td>' + response.working_position + '</td><td>' + response.experience_title + '</td><td>' + response.duration_from + '<br/>' + response.duration_to + '</td><td><a href="' + response.experience_file + '">View File</a></td></tr>');

        // Reset the form
        $('#save-work-experience-data')[0].reset();
        $('#save-work-experience-data').closest('#openWorkExperience').modal('hide');
      },
      error: function (xhr) {
        // Display validation errors
        if (xhr.status === 422) {
          var errors = xhr.responseJSON.errors;
          for (var field in errors) {
            // Append error messages next to the respective form fields
            $('#' + field).after('<div class="validated-msg text-danger mt-2">' + errors[field][0] + '</div>');
          }
        } else {
          console.log('Error:', xhr);
        }
      }
    });
  });

  $('#save-publication-detail-data').submit(function (event) {
    event.preventDefault();

    var formData = new FormData(this);

    $('.pub-validated-msg').remove();

    $.ajax({
      url: baseURL + 'specialist/publication-detail/save',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $('#publication-detail-table-body').append('<tr><td>' + response.publication_title + '</td><td>' + response.publish_date + '</td><td>' + response.refrence_materials + '</td><td><a href="' + response.publication_file + '">View File</a></td></tr>');

        // Reset the form
        $('#save-publication-detail-data')[0].reset();
        $('#save-publication-detail-data').closest('#openPublicationDetail').modal('hide');
      },
      error: function (xhr) {
        console.log(xhr)
        // Display validation errors
        if (xhr.status === 422) {
          var errors = xhr.responseJSON.errors;
          for (var field in errors) {
            // Append error messages next to the respective form fields
            $('#' + field).after('<div class="pub-validated-msg text-danger mt-2">' + errors[field][0] + '</div>');
          }
        } else {
          console.log('Error:', xhr);
        }
      }
    });
  });
});