/**
 * Get the data and output the id in the modal form.
 *
 * @param {string} hyperlink - The data hyperlink
 * @param {string} modalName - The name for the modal that should be triggered
 */
function getUser(hyperlink, modalName) {
    $('#form')[0].reset(); // Reset forms on modals.

    // AJAX load data from the url.
    $.ajax({
        url 		: hyperlink,
        type		: 'GET',
        dataType	: "JSON",
        success 	: function (data) {
            // Console.log(data);
            $('[name="id"]').val(data.id);
            $('[name="name"]').val(data.name);

            // Trigger modal.
            $(modalName).modal('show'); // Show bootstrap modal when complete loaded
        },

        error : function (jqXHR, textStatus, errorThrown) {
            console.log('Error getting data from ajax.');
        }
    });
}