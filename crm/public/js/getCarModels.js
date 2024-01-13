$(document).ready(function () {
    $('#car_make').change(function () {
        var carMake = $(this).val();

        $.ajax({
            url: '/get-car-models',
            type: 'GET',
            data: { car_make: carMake },
            dataType: 'json',
            success: function (data) {
                $('#car_model').empty().append('<option value="" disabled selected>Выберите модель</option>');
                $.each(data, function (index, model) {
                    $('#car_model').append('<option value="' + model.car_model_id + '">' + model.car_name + '</option>');
                });
                $('#car_model').prop('disabled', false);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});
