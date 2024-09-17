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

        // Loop through the list of data indexes or keys you want to add as <td> element
        let counter = 1;
        data_indexes.forEach(index => {
            if(index != 'id'){
                if (index && typeof index === 'object') {
                for (let key in index) {
                    if (index.hasOwnProperty(key)) {
                        let associated_array_indexes = index[key];
                        
                        associated_array_indexes.forEach(asc_index =>{
                            tdElements += `<td>${row[key][asc_index]}</td>`;
                        });
                        console.log(`Key: ${key}, Value: ${index[key]}`);
                    }
                }
                }else{
                    tdElements += `<td>${row[index]}</td>`;
                }
            }else{
                tdElements += `<td>${counter}</td>`;
                counter = counter + 1;
            }
            
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

var page_dom_element_ids = [
    {
      page: "index_page",
      dom_ids: ["index-page-main-slider", "index-page-content", "index-page-partners-section"]
    },
    {
        page: "event_page",
        dom_ids: ["event-page-content"]
    },
    {
      page: "map_viewer_page",
      dom_ids: ["map-viewer-page-top-text-section"]
    },
    {
        page: "documents_page",
        dom_ids: ["documents-page-document-text-section", "documents-page-document-link-text-section"]
    },
    {
        page: "contacts_page",
        dom_ids: ["contacts-page-main-text-section"]
    }
  ];

    

  function populatePageSelect() {
    const pageSelect = document.getElementById('pageSelect');
    page_dom_element_ids.forEach(item => {
      let option = document.createElement('option');
      option.value = item.page;
      option.textContent = item.page.replace(/_/g, ' ');
      pageSelect.appendChild(option);
    });
  }     
      
// Function to populate the DOM ID select field based on the selected page
function updateDomSelect(selectedPage) {
    const domSelect = document.getElementById('dom_id_select');
    domSelect.innerHTML = '<option value="">-- Select a DOM ID --</option>'; // Reset DOM IDs select field
  
    if (selectedPage) {
      // Find the selected page object from the array
      let pageObj = page_dom_element_ids.find(page => page.page === selectedPage);
  
      // Populate the DOM IDs select field with the corresponding DOM IDs
      if (pageObj) {
        pageObj.dom_ids.forEach(dom_id => {
          let option = document.createElement('option');
          option.value = dom_id;
          option.textContent = dom_id;
          domSelect.appendChild(option);
        });
      }
    }
  }      
      
      // Event listener for the page select field
    //   document.getElementById('pageSelect').addEventListener('change', function() {
    //     const selectedPage = this.value;
    //     updateDomSelect(selectedPage);
    //   });
    

