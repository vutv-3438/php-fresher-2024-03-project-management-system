/* global renderActions */

window.renderDataTable = function renderDataTable(data, editUrl, deleteUrl, csrf, msg)
{
    $(document).ready(function () {
        $('#claims-table').DataTable({
            processing: true,
            serverSide: false,
            data: data,
            columnDefs: [{"className": "text-center", "targets": "_all"},],
            buttons: ['copy', 'excel', 'pdf'],
            columns: [
                {
                    data: null,
                    name: 'order',
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {data: 'claim_type', name: 'type'},
                {data: 'claim_value', name: 'value'},
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

