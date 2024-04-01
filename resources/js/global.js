import './datatable/render-actions';

window.deleteRecord = function deleteRecord(id)
{
    if (confirm('Are you sure you want to delete this item?')) {
        let deleteFormId = 'delete-form-' + id;
        $('#' + deleteFormId).submit();
    }
}
