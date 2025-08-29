$('#province_id').change(function () {
  let province_id = $(this).val();

  if (province_id != '' && !isNaN(province_id)) {
    $.ajax({
      method: 'POST',
      url: baseURL + 'get-district',
      data: {
        province_id,
        _token: csrf,
      },
      success: function (res) {
        if (res.length > 0) {
          options = set_optons(res);
        } else {
          options =
            "<option value='' disabled selected>Details not found</option>";
        }
        $("#district_id").html(options);
      },
    })
  }
})

$('#district_id').change(function () {
  let district_id = $(this).val();

  if (district_id != '' && !isNaN(district_id)) {
    $.ajax({
      method: 'POST',
      url: baseURL + 'get-district-local-level',
      data: {
        district_id,
        _token: csrf,
      },
      success: function (res) {
        if (res.length > 0) {
          options = set_optons(res);
        } else {
          options =
            "<option value='' disabled selected>Details not found</option>";
        }
        $("#local_level_id").html(options);
      },
    })
  }
})
