/* global renderActions */

window.renderDataTable = function renderDataTable(data, editUrl, deleteUrl, csrf, msg)
{
    $(document).ready(function () {
        $(`#users-table`).DataTable({
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
                {data: 'full_name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone_number', name: 'phone'},
                {
                    data: null,
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        return renderActions(data, editUrl, deleteUrl, csrf, msg);
                    }
                }
            ]
        });
    });
}
