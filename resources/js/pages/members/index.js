/* global renderActions */

window.renderDataTable = function renderDataTable(tableData, editUrl, deleteUrl, csrf, options)
{
    $(document).ready(function () {
        $(`#members-table`).DataTable({
            processing: true,
            serverSide: false,
            data: tableData,
            columnDefs: [
                {"className": "text-center vertical-middle", "targets": "_all"},
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
                {data: 'full_name', name: 'name'},
                {
                    data: 'roles',
                    name: 'roles',
                    render: function (data, type, row, meta) {
                        const EDIT_URL = editUrl?.slice()?.replace(':id', row.id);
                        let html = `
                            <form id="change-role-form-${row.id}" method="POST" action="${EDIT_URL}">
                                <input type="hidden" name="_token" value="${csrf}">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="projectId" value="${options.projectId}">
                                <select data-user-id="${row.id}" class="select-role border-0 bg-gray w-full p-2" name="role_id">
                        `;
                        options.roles.forEach(item => {
                            let selected = '';
                            if (item.id === data[0].id) {
                                selected = 'selected';
                            }
                            html += `<option ${selected} value="${item.id}">${item.name}</option>`;
                        });
                        html += '</select></form>';
                        return html;
                    }
                },
                {
                    data: null,
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        return renderActions(data, null, deleteUrl, csrf, {...options});
                    }
                }
            ]
        });

        $('.select-role').change(function () {
            const USER_ID = $(this).data('user-id');
            $('#change-role-form-' + USER_ID).submit();
        })
    });
}
