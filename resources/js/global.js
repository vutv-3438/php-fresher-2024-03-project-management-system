/* global $ */
// Global actions

window.deleteRecord = function deleteRecord(id)
{
    if (confirm('Are you sure you want to delete this item?')) {
        var deleteFormId = 'delete-form-' + id;
        $('#' + deleteFormId).submit();
    }
}
