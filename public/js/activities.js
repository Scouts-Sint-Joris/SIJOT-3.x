/**
 * Get the data and output the id in the modal form.
 *
 * @param {string} hyperlink - The data hyperlink
 * @param {string} modalName - The name for the modal that should be triggered
 */
function update(hyperlink, modalName) {
    $('#form')[0].reset(); // Reset forms on modals.

    // AJAX load data from the url.
    $.ajax({
        url  : hyperlink,
        type : 'GET',
        dataType : "JSON",
        success : function (data) {
            $('[name="id"]').val(data.id);
            $('[name="status"]').val(data.status);
            $('[name="title"]').val(data.title);
            $('[name="description"]').val(data.description);
            $('[name="group_id"]').val(data.group_id);
            $('[name="activiteit_datum"]').val($.format.date(data.activiteit_datum, 'dd-MM-yyyy'));
            $('[name="end_hour"]').val($.format.date(data.end_hour, 'hh:mm') + 'u');
            $('[name="start_hour"]').val($.format.date(data.start_hour, 'hh:mm') + 'u');

            // Trigger modal.
            $(modalName).modal('show'); // Show bootstrap modal when complete loaded
        },

        error : function (jqXHR, textStatus, errorThrown) {
            console.log('Error getting data from ajax.');
        }
    });
}

/**
 * Get the data and output the id in the modal form.
 *
 * @param {string} hyperlink - The data hyperlink
 * @param {string} modalName - The name for the modal that should be triggered
 */
function show(hyperlink, modelName) {
    // AJAX load data form the url
    $.ajax({
        url: hyperlink,
        type: 'GET',
        dataType : "JSON",
        success : function (data) {
            $('.modal-title').text($.format.date(data.activiteit_datum, 'dd-MM-yyyy') + ' ' + data.title);
        },

        error : function (jqXHR, textStatus, errorThrown) {
            console.log('Error getting data from ajax.');
        }
    });
}