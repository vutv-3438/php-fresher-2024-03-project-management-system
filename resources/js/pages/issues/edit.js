/* global renderActions */

window.renderDataTable = function renderDataTable(data, editUrl, deleteUrl, csrf, msg)
{
    $(document).ready(function () {
        $(`#child-issues-table`).DataTable({
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
                {data: 'issue_type.name', name: 'type', defaultContent: '---'},
                {data: 'status.name', name: 'status', defaultContent: '---'},
                {data: 'priority', name: 'priority', defaultContent: '---'},
                {data: 'title', name: 'title', defaultContent: '---'},
                {data: 'assignee.full_name', name: 'assignee', defaultContent: '---'},
                {data: 'due_date', name: 'due_date', defaultContent: '---'},
                {
                    data: 'estimated_time',
                    name: 'estimated_time',
                    render: function (data) {
                        return `<span>${data}h</span>`;
                    }
                },
                {
                    data: 'progress',

                    name: 'progress',
                    render: function (data) {
                        return `
                              <div class="progress" style="height: 15px; width: 100%">
                                <div class="progress-bar" role="progressbar" style="width: ${data}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">${data}%</div>
                              </div>`;
                    }
                },
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
