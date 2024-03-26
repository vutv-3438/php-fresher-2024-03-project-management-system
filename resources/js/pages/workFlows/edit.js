if (!!DATA || !!editUrl || !!deleteUrl || !!CSRF) {
    $(document).ready(function () {
        $('#steps-table').DataTable({
            processing: true,
            serverSide: false,
            data: DATA,
            columnDefs: [{"className": "text-center", "targets": "_all"},],
            buttons: ['copy', 'excel', 'pdf'],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: null,
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, full, meta) {
                        editUrl = editUrl.replace(':id', data.id);
                        deleteUrl = deleteUrl.replace(':id', data.id);

                        return `<a href = "${editUrl}" class="d-inline-block mr-2 text-blue underline">Edit</a>
                                <a class="btn btn-reset text-danger text-decoration-underline delete-record" onclick="deleteRecord(${data.id})">Delete</button>
                                <form id="delete-form-${data.id}" method="POST" action="${deleteUrl}">
                                </form>`;
                    }
                }]
        })
    })
} else {
    console.error('Something went wrong');
}

