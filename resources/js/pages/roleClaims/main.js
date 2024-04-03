$(document).ready(function () {
    $('#type').change(function () {
        if ($(this).val() === 'project') {
            $('#value').find('option[value="create"]').hide();
        } else {
            $('#value').find('option[value="create"]').show();
        }
    });
});
