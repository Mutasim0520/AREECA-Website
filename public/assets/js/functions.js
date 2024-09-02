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
        let counter = 1;
        data_indexes.forEach(index => {
            tdElements += `<td>${row[index]}</td>`;
        });
        
        //Prepare the action elements for each row of the table
        actionElements = renderActionUrlForTableRow(row_actions,row.id,row.name);
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

function renderActionUrlForTableRow(row_actions,id,file=null){
    let action_icon = '';
    let temptdElementsActions = '';

    row_actions.forEach(action => {
        switch(action.type){
            case "view":
                action_icon = '<i class="fas fa-eye" title="View DataFile"></i>';
                data_target = action.popup_element_id;
                break;
            case "update":
                action_icon = '<i class="fas fa-sync" title="Update DataFile"></i>';
                data_target = action.popup_element_id;
                break;
            case "delete":
                action_icon = '<i class="fas fa-trash" title="Delete DataFile"></i>';
                data_target = action.popup_element_id;
                break;
        }
        if(file) temptdElementsActions += `<a style="padding:8px 12px; margin-right:2px;" onclick="renderMap('${file}')" href="#" data-toggle="modal" data-target="${data_target}" data-id="${id}">${action_icon}</a>`;
        else temptdElementsActions += `<a style="padding:8px 12px; margin-right:2px;" href="#" data-toggle="modal" data-target="${data_target}" data-id="${id}">${action_icon}</a>`;
        
    });

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

function renderMap(file_name) {
    var base_url = 'http://localhost/AREECA/';
    var data_file_path = base_url + 'app/storage/map_data_files/' + file_name;

    fetch(data_file_path)  // Fetch the GeoJSON file
        .then(response => response.json())
        .then(geojsonData => {

            // Remove the current layer if it exists
            if (currentLayer) {
                map.removeLayer(currentLayer);
            }

            // Add the new GeoJSON layer to the map and store it in currentLayer
            currentLayer = L.geoJSON(geojsonData, {
                onEachFeature: function (feature, layer) {
                    // Define a function to create the popup content
                    function createPopupContent() {
                        var name = feature.properties.name;
                        var coordinates = feature.geometry.coordinates;
                        return `
                            <table class="popup-table">
                                <tr><th>Name</th><td>${name}</td></tr>
                                <tr><th>Latitude</th><td>${coordinates[1]}</td></tr>
                                <tr><th>Longitude</th><td>${coordinates[0]}</td></tr>
                            </table>
                        `;
                    }

                    // Bind a popup to the marker, set it to open when the marker is clicked
                    layer.bindPopup(createPopupContent());

                    // Ensure the popup opens on click every time
                    layer.on('click', function() {
                        layer.openPopup();
                    });
                }
            }).addTo(map);
            
            //Dynamically focus map based on data
            var bounds = currentLayer.getBounds();
            map.fitBounds(bounds);

            var contentDiv = document.getElementById("loaded_file_name");
            contentDiv.innerHTML = `<span style="font-weight:bold;">  Current File: ${file_name}</span>`

        })
        .catch(error => console.error('Error loading GeoJSON:', error));
}
