const rowsPerPage = 10;
let currentPage = 1;
var BASE_URL = '<?php echo BASE_URL; ?>';
const USER_ROLE = getCookie('role');

// Function set the table contents
function renderTable(table, data, data_indexes, row_actions) {
    var element = '#' + table + '-data-table' + ' tbody';
    const startIndex = (currentPage - 1) * rowsPerPage;
    const endIndex = startIndex + rowsPerPage;
    const paginatedData = data.slice(startIndex, endIndex);

    $(element).empty();
    paginatedData.forEach(row => {
        // Create an empty string to hold all the dynamic <td> elements
        let tdElements = '';
        let tdElementsActions = '';

        // Loop through the list of data indexes or keys you want to add as <td>
        let counter = 0;
        data_indexes.forEach(index => {
            tdElements += `<td>${row[index]}</td>`;
        });
        
        //Prepare the action elements for each row of the table
        actionElements = renderActionUrlForTableRow(row_actions,row.id);
        tdElementsActions += `<td><div class="main-button">${actionElements}</div></td>`;

        $(element).append(`
            <tr>
                ${tdElements}
                ${tdElementsActions}
            </tr>
        `);
    });

    renderTablePagination(table,data);
}

function renderActionUrlForTableRow(row_actions,id){
    var num_actions = row_actions.length;
    let action_icon = '';
    let url = '';
    let temptdElementsActions = '';

    for (let i = 0; i < num_actions; i++) {
        url = BASE_URL + row_actions[i] + '?id=' + id;

        if(i == 0){
            action_icon = '<i class="fas fa-eye" title="View DataFile"></i>';
            temptdElementsActions += `<a style="padding:8px 12px; margin-right:2px;" href="${url}">${action_icon}</a>`;

        }else if(i == 1){
            action_icon = '<i class="fas fa-sync" title="Update DataFile"></i>';
            temptdElementsActions += `<a style="padding:8px 12px; margin-right:2px;" href="${url}">${action_icon}</a>`;
        }else{
            action_icon = '<i class="fas fa-trash" title="Delete DataFile"></i>';
            temptdElementsActions += `<a style="padding:8px 12px; margin-right:2px;" href="#" data-toggle="modal" data-target="#deleteModalMap" data-id="${id}">${action_icon}</a>`;
        }
    }

    return temptdElementsActions;
}

function renderTablePagination(table,data) {
    let element = table +'-table-pagination';
    const pageCount = Math.ceil(data.length / rowsPerPage);
    $(element).empty();

    for (let i = 1; i <= pageCount; i++) {
        $(element).append(`
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
        `);
    }
}

function getCookie(name) {
    let value = "; " + document.cookie;
    let parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}

