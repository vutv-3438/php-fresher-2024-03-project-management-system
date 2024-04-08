window.renderActions = function renderActions(data, editUrl, deleteUrl, csrf, options)
{
    const EDIT_URL = editUrl?.slice()?.replace(':id', data.id)?.replace(':projectId', data.project_id);
    const DELETE_URL = deleteUrl.slice().replace(':id', data.id).replace(':projectId', data.project_id);
    const editLink = editUrl
        ? `<a href="${EDIT_URL}" className="d-inline-block mr-2 text-blue underline">${options.msg.edit}</a>`
        : '';
    const deleteLink = !data.is_manager
        ? `<a class="btn btn-reset text-danger text-decoration-underline delete-record" onclick="deleteRecord(${data.id})">
                ${options.msg.delete}
            </a>`
        : '';

    return `${editLink}
            ${deleteLink}
            <form id="delete-form-${data.id}" method="POST" action="${DELETE_URL}">
                <input type="hidden" name="_token" value="${csrf}">
                <input type="hidden" name="_method" value="DELETE">
                ${options.renderDeleteFormSection ? options.renderDeleteFormSection(data): ''}
            </form>`;
}
