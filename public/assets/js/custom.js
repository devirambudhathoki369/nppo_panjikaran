// flatpickr(".date-min-max", { minDate: "today", defaultDate: new Date(), maxDate: new Date().fp_incr(14) });
flatpickr(".date-min-max", { minDate: "2000-01-01", defaultDate: new Date(), maxDate: "today" }),
  flatpickr(".datepicker", {});

$(document).ready(function () {
  $(".datatable").DataTable();
  $('.select2').select2({
    width: "100%",
    placeholder: "Choose Option"
  });
  if ($('.nepcal').length) {
    $('.nepcal').nepaliDatePicker({
      dateFormat: "YYYY-MM-DD",
      ndpYear: true,
      ndpMonth: true,
      onChange: function (e) {
        if ($('#dob_in_ad').length) {
          $('#dob_in_ad').val(e.ad)
        }
        if ($('#dob_ad').length) {
          $('#dob_ad').val(e.ad)
        }
      }
    });

    // showing nlev verification form

  }

  $('#sales_to_div').hide();
  $('#collector_type_div').hide();

  $('#category').change(function () {
    var category = $('#category').val();

    if (category == '1') {
      $('#sales_to_div').show();
      $('#collector_type_div').hide();
      $('#sales_to_div').attr('required', '');
    } else if (category == '2') {
      $('#sales_to_div').hide();
      $('#collector_type_div').show();

    } else if (category == '2' || category == '3') {
      $('#sales_to_div').show();
      $('#collector_type_div').show();

    }
  });

})

jQuery(function ($) {
  $.mask.definitions['~'] = '[+-]';
  $('.date').mask('9999-99-99');
  $('.dayMask').mask('99');
  $('.time').mask('99:99 aa');
  $('.fy-mask').mask('9999-99');
  $('.mobile').mask('9999999999');
});

function set_optons(responses) {
  let option = `<option value='' disabled selected>Select Details</option>`;
  responses = $.makeArray(responses);

  $.map(responses, function (response, i) {
    option += `<option value="${response.id}">${response.show_name}</option>`;
  });

  return option;
}

$(document).on('select2:open', () => {
  document.querySelector('.select2-search__field').focus();
});


$('#firm_type').on('change', function () {
  let selectedFirmType = $(this).val()
  let categoryOptions = `<option value="" disabled selected>Select one option</option>`;
  if (selectedFirmType == 1) {
    categoryOptions += `<option value="1">Producer</option>`
  }
  else if (selectedFirmType == 2) {
    categoryOptions += `<option value="2">Collector</option>
    <option value="3">Producer & Collector</option>`
  }
  $('#category').html(categoryOptions);
});



// document.addEventListener('DOMContentLoaded', function () {
//   var firmTypeSelect = document.getElementById('firm_type');
//   var categorySelect = document.getElementById('category');

//   // Function to show or hide options based on selected firm type
//   function updateCategoryOptions() {
//     var firmTypeValue = firmTypeSelect.value;

//     // Hide all options first
//     var options = categorySelect.querySelectorAll('option');
//     options.forEach(function (option) {
//       option.style.display = 'none';
//     });

//     // Show options based on selected firm type
//     if (firmTypeValue === '1') {
//       document.querySelector('option[value="1"]').style.display = 'block'; // Producer
//       // Reset category selection to "Producer" when Private Firm is selected
//       categorySelect.value = "1";
//     } else if (firmTypeValue === '2') {
//       document.querySelector('option[value="2"]').style.display = 'block'; // Collector
//       document.querySelector('option[value="3"]').style.display = 'block'; // Producer & Collector
//       // Reset category selection to "Collector" when Cooperative is selected
//       categorySelect.value = "2";
//     }
//   }

//   // Initial call to update options on page load
//   // updateCategoryOptions();

//   // Event listener for firm type select change
//   firmTypeSelect.addEventListener('change', updateCategoryOptions);
// });

