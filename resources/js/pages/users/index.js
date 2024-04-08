/* global renderActions */

window.restoreUser = function restoreUser(id) {
    if (confirm('Are you sure you want to restore this item?')) {
        let restoreForm = 'restore-form-' + id;
        $('#' + restoreForm).submit();
    }
}

window.renderActions = function (data, editUrl, deleteUrl, csrf, options) {
    const EDIT_URL = editUrl.slice().replace(':id', data.id)?.replace(':projectId', data.project_id);
    const RESTORE_URL = options.restoreUrl.slice().replace(':id', data.id)?.replace(':projectId', data.project_id);
    const DELETE_URL = deleteUrl.slice().replace(':id', data.id).replace(':projectId', data.project_id);
    const CSRF_INPUT = `<input type="hidden" name="_token" value="${csrf}">`;
    const EDIT_LINK = editUrl
        ? `<a href="${EDIT_URL}" className="d-inline-block mr-2 text-blue underline">${options.msg.edit}</a>`
        : '';
    const DELETE_LINK = `<a class="btn btn-reset text-danger text-decoration-underline delete-record" onclick="deleteRecord(${data.id})">
                ${options.msg.delete}
            </a>`;
    const RESTORE_LINK = `<a class="btn btn-reset text-danger text-decoration-underline delete-record" onclick="restoreUser(${data.id})">
                ${options.msg.restore}
            </a>`;
    const DELETE_FORM = `<form id="delete-form-${data.id}" method="POST" action="${DELETE_URL}">
                ${CSRF_INPUT}
                <input type="hidden" name="_method" value="DELETE">
            </form>`;
    const RESTORE_FORM = `<form id="restore-form-${data.id}" method="POST" action="${RESTORE_URL}">
                ${CSRF_INPUT}
                <input type="hidden" name="_method" value="PATCH">
            </form>`;

    return `${EDIT_LINK}
            ${data.is_deleted ? RESTORE_LINK : DELETE_LINK}
            ${data.is_deleted ? RESTORE_FORM : DELETE_FORM}
            `;
}

window.renderDataTable = function renderDataTable(data, editUrl, deleteUrl, csrf, options) {
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
            }
        });
    });
}
