// Listen for changes in the "province" select box
$('#province').on('change', function () {
  var province_id = $(this).val();
  if (province_id) {
    // If a province is selected, fetch the districts for that province using AJAX
    $.ajax({
      url: 'pages/ajax_get_district.php',
      method: 'GET',
      dataType: "json",
      data: {
        province_id: province_id
      },
      success: function (data) {
        // Clear the current options in the "district" select box
        $('#district').empty();

        // Add the new options for the districts for the selected province
        $.each(data, function (i, district) {
          $('#district').append($('<option>', {
            value: district.id,
            text: district.name
          }));
        });

        // Set the province name hidden input value
        var province_name = $('#province option:selected').text();
        $('#province_name').val(province_name);

        // Clear the options in the "wards" select box
        $('#wards').empty();
      },
      error: function (xhr, textStatus, errorThrown) {
        console.log('Error: ' + errorThrown);
      }
    });
    $('#wards').empty();
  } else {
    // If no province is selected, clear the options in the "district" and "wards" select boxes
    $('#district').empty();    
  }
});

// Listen for changes in the "district" select box
$('#district').on('change', function () {
  var district_id = $(this).val();
  if (district_id) {
    // If a district is selected, fetch the awards for that district using AJAX
    $.ajax({
      url: 'pages/ajax_get_wards.php',
      method: 'GET',
      dataType: "json",
      data: {
        district_id: district_id
      },
      success: function (data) {
        // Clear the current options in the "wards" select box
        $('#wards').empty();
        // Add the new options for the awards for the selected district
        $.each(data, function (i, wards) {
          $('#wards').append($('<option>', {
            value: wards.name,
            text: wards.name
          }));
        });

        // Set the district name hidden input value
        var district_name = $('#district option:selected').text();
        $('#district_name').val(district_name);
      },
      error: function (xhr, textStatus, errorThrown) {
        console.log('Error: ' + errorThrown);
      }
    });
  } else {
    // If no district is selected, clear the options in the "award" select box
    $('#wards').empty();
  }
});



// ----- gio hang------

// Listen for changes in the "province" select box
$('#tinh').on('change', function () {


  var province_id = $(this).val();
  if (province_id) {
    // If a province is selected, fetch the districts for that province using AJAX
    $.ajax({
      url: 'pages/ajax_get_district.php',
      method: 'GET',
      dataType: "json",
      data: {
        province_id: province_id
      },
      success: function (data) {
        // Clear the current options in the "district" select box
        $('#huyen').empty();

        // Add the new options for the districts for the selected province
        $.each(data, function (i, district) {
          $('#huyen').append($('<option>', {
            value: district.id,
            text: district.name
          }));
        });

        // Set the province name hidden input value
        var province_name = $('#tinh option:selected').text();
        $('#tinh_name').val(province_name);

        // Clear the options in the "wards" select box
        $('#xa').empty();
      },
      error: function (xhr, textStatus, errorThrown) {
        console.log('Error: ' + errorThrown);
      }
    });
    $('#xa').empty();
  } else {
    // If no province is selected, clear the options in the "district" and "wards" select boxes
    $('#huyen').empty();

  }
});

// Listen for changes in the "district" select box
$('#huyen').on('change', function () {
  var district_id = $(this).val();
  if (district_id) {
    // If a district is selected, fetch the awards for that district using AJAX
    $.ajax({
      url: 'pages/ajax_get_wards.php',
      method: 'GET',
      dataType: "json",
      data: {
        district_id: district_id
      },
      success: function (data) {
        // Clear the current options in the "wards" select box
        $('#xa').empty();
        // Add the new options for the awards for the selected district
        $.each(data, function (i, wards) {
          $('#xa').append($('<option>', {
            value: wards.name,
            text: wards.name
          }));
        });

        // Set the district name hidden input value
        var district_name = $('#huyen option:selected').text();
        $('#huyen_name').val(district_name);
      },
      error: function (xhr, textStatus, errorThrown) {
        console.log('Error: ' + errorThrown);
      }
    });
  } else {
    // If no district is selected, clear the options in the "award" select box
    $('#xa').empty();
  }
});
