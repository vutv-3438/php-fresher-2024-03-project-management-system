if (DATA && EDIT_URL && DELETE_URL && CSRF)
{
    $(document).ready(function () {
        $(`#workflow-table`).DataTable({
            processing: true,
            serverSide: false,
            data: DATA,
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
                    render: function (data, type, full, meta) {
                        const COPY_EDIT_URL = EDIT_URL.slice().replace(':id', data.id).replace(':projectId', data.project_id);
                        const COPY_DELETE_URL = DELETE_URL.slice().replace(':id', data.id).replace(':projectId', data.project_id);

                        return `<a href = "${COPY_EDIT_URL}" class="d-inline-block mr-2 text-blue underline" >Edit</a>
                                <a class="btn btn-reset text-danger text-decoration-underline delete-record" onclick="deleteRecord(${data.id})">Delete</button>
                                <form id="delete-form-${data.id}" method="POST" action="${COPY_DELETE_URL}">
                                    <input type="hidden" name="_token" value="${CSRF}">
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>`;
                    }
                }
            ]
        });
    });
}
else
{
    console.error('Something went wrong');
}
