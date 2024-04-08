/* global renderActions */

window.submitChangeDefaultRoleForm = function submitChangeDefaultRoleForm(event, id) {
    $('#change-default-role-form-' + id).submit();
}

window.renderDataTable = function renderDataTable(data, editUrl, deleteUrl, csrf, options) {
    $(document).ready(function () {
        $(`#roles-table`).DataTable({
            processing: true,
            serverSide: false,
            data: data,
            columnDefs: [
                {"className": "text-center", "targets": "_all"},
            ],
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            columns: [
                {
                    data: null,
                    name: 'order',
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {
                    data: null,
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        return renderActions(data, editUrl, deleteUrl, csrf, {msg: options.msg})
                            + `
                                <label class="me-2" for="is_default">Default</label>
                                <input
                                    class="change-default-role"
                                    type="radio"
                                    name="is_default"
                                    onchange="submitChangeDefaultRoleForm(event, ${data.id})"
                                    ${data.is_default ? 'checked' : ''}
                                >
                                <form
                                    id="change-default-role-form-${data.id}"
                                    class="d-flex justify-content-center"
                                    action="${options.changeRoleDefaultLink.replace(':id', data.id)}"
                                    method="POST"
                               >
                                    <input type="hidden" name="_token" value="${csrf}">
                                    <input type="hidden" name="_method" value="PATCH">
                               </form>`;
                    }
                }
            ]
        });
    });
}
