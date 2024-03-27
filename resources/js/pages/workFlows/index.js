window.renderDataTable = function renderDataTable(data, editUrl, deleteUrl, csrf, msg)
{
    $(document).ready(function () {
        $(`#workflow-table`).DataTable({
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
                {data: 'id', name: 'id'},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description'},
                {
                    data: null,
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        const EDIT_URL = editUrl.slice().replace(':id', data.id).replace(':projectId', data.project_id);
                        const DELETE_URL = deleteUrl.slice().replace(':id', data.id).replace(':projectId', data.project_id);

                        return `<a href = "${EDIT_URL}" class="d-inline-block mr-2 text-blue underline" >${msg.edit}</a>
                                <a class="btn btn-reset text-danger text-decoration-underline delete-record" onclick="deleteRecord(${data.id})">${msg.delete}</button>
                                <form id="delete-form-${data.id}" method="POST" action="${DELETE_URL}">
                                    <input type="hidden" name="_token" value="${csrf}">
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>`;
                    }
                }
            ]
        });
    });
}
