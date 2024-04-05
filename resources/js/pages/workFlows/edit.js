/* global renderActions */

window.renderDataTable = function renderDataTable(data, editUrl, deleteUrl, csrf, msg)
{
    $(document).ready(function () {
        $('#steps-table').DataTable({
            processing: true,
            serverSide: false,
            data: data,
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
                    render: function (data) {
                        return renderActions(data, editUrl, deleteUrl, csrf, {msg});
                    }
                }]
        });
    });
}

