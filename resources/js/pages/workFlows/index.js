if (!!DATA || !!editUrl || !!deleteUrl || !!CSRF)
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
                        editUrl = editUrl.replace(':id', data.id).replace(':projectId', data.project_id);
                        deleteUrl = deleteUrl.replace(':id', data.id).replace(':projectId', data.project_id);

                        return `<a href = "${editUrl}" class="d-inline-block mr-2 text-blue underline" >Edit</a>
                                <form id="delete-form-${data.id}" method="POST" action="${deleteUrl}">
                                    <input type="hidden" name="_token" value="${CSRF}">
                                    <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-reset text-danger text-decoration-underline delete-record" onclick="deleteRecord(${data.id})">Delete</button>
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
