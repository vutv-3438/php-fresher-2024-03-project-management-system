/* global renderActions */

window.restoreUser = function (id) {
    if (confirm('Are you sure you want to restore this item?')) {
        let restoreForm = 'restore-form-' + id;
        $('#' + restoreForm).submit();
    }
}

window.toggleLockUser = function (id, is_locked) {
    if (confirm(`Are you sure you want to ${is_locked ? 'un' : ''}lock this user?`)) {
        let toggleLockForm = 'toggle-lock-form-' + id;
        $('#' + toggleLockForm).submit();
    }
}

function renderActions(data, editUrl, deleteUrl, csrf, options)
{
    const EDIT_URL = editUrl.slice().replace(':id', data.id)?.replace(':projectId', data.project_id);
    const RESTORE_URL = options.url.restore.slice().replace(':id', data.id);
    const TOGGLE_LOCK_URL = options.url.toggleLock.slice().replace(':id', data.id);
    const DELETE_URL = deleteUrl.slice().replace(':id', data.id).replace(':projectId', data.project_id);
    const CSRF_INPUT = `<input type="hidden" name="_token" value="${csrf}">`;
    const PATCH_INPUT = '<input type="hidden" name="_method" value="PATCH">';
    const EDIT_LINK = editUrl
        ? `<a href="${EDIT_URL}" class="btn btn-reset d-inline-block mr-2 text-primary text-decoration-underline">${options.msg.edit}</a>`
        : '';
    const DELETE_LINK = `<a class="btn btn-reset text-danger text-decoration-underline" onclick="deleteRecord(${data.id})">
                ${options.msg.delete}
            </a>`;
    const TOGGLE_LOCK_LINK = `<a class="btn btn-reset text-danger text-decoration-underline" onclick="toggleLockUser(${data.id}, ${data.is_locked})">
                ${options.msg.toggleLock}
            </a>`;
    const RESTORE_LINK = `<a class="btn btn-reset text-success text-decoration-underline" onclick="restoreUser(${data.id})">
                ${options.msg.restore}
            </a>`;
    const DELETE_FORM = `<form id="delete-form-${data.id}" method="POST" action="${DELETE_URL}">
                ${CSRF_INPUT}
                <input type="hidden" name="_method" value="DELETE">
            </form>`;
    const RESTORE_FORM = `<form id="restore-form-${data.id}" method="POST" action="${RESTORE_URL}">
                ${CSRF_INPUT}
                ${PATCH_INPUT}
            </form>`;
    const TOGGLE_LOCK_FORM = `<form id="toggle-lock-form-${data.id}" method="POST" action="${TOGGLE_LOCK_URL}">
                ${CSRF_INPUT}
                ${PATCH_INPUT}
            </form>`;

    return `<div class="d-flex justify-content-center">
                ${EDIT_LINK}
                ${TOGGLE_LOCK_LINK + TOGGLE_LOCK_FORM}
                ${data.is_deleted ? RESTORE_LINK + RESTORE_FORM : DELETE_LINK + DELETE_FORM}
            </div>`;
}

window.renderDataTable = function renderDataTable(data, editUrl, deleteUrl, csrf, options)
{
    $(document).ready(function () {
        $(`#users-table`).DataTable({
            processing: true,
            serverSide: false,
            data: data,
            columnDefs: [
                {"className": "text-center bg-", "targets": "_all"},
            ],
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'full_name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone_number', name: 'phone'},
                {
                    data: null,
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        return renderActions(data, editUrl, deleteUrl, csrf, {...options});
                    }
                }
            ],
            "rowCallback": function (row, data) {
                if (data.is_deleted) {
                    $(row).addClass('bg-secondary-subtle');
                }
                if (data.is_locked) {
                    $(row).addClass('bg-danger-subtle');
                }
            }
        });
    });
}
