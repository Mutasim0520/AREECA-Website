function loadGraph(selectedType = "") {
    let valuesArray = Object.keys(layers);
    let selectedDistricts = valuesArray.map(item => item.replace(".geojson", ""));

    // If no districts are selected, populate selectedDistricts with all districts from original_data
    if (selectedDistricts.length === 0) {
        selectedDistricts = [...new Set(original_data.map(row => row['district']))]; // Get unique districts
    }

    // Filter the graph data based on selected district and type
    let graph_data = original_data.filter(row => {
        let hasDistrict = selectedDistricts.includes(row['district']);
        if (selectedType && row['features']) {
            return hasDistrict && row['features']['properties'].some(item => item['properties']['Type'] === selectedType);
        }
        return hasDistrict;
    });

    var element = '#graph-container';
    var caption = "Accumulated HAUnderRes of the following Districts: " + selectedDistricts.join(', ');

    if(selectedDistricts) {
        document.getElementById('graph-container').classList.add('graph-container');
    }

    $(element).empty();
    $(element).append(`
        <canvas id="myChart" class="responsive-canvas"></canvas>
    `);

    var ctx = document.getElementById('myChart').getContext('2d');
    var column_names = selectedDistricts; // Now, labels represent districts

    // Initialize counters for each forestation type and district
    let counters = {
        'River and Stream bank Restoration': new Array(selectedDistricts.length).fill(0),
        'Soil and Water Conservation': new Array(selectedDistricts.length).fill(0),
        'Community Forest and Woodlots': new Array(selectedDistricts.length).fill(0),
        'Forest Management': new Array(selectedDistricts.length).fill(0),
        'Improved Agricultural Technologies': new Array(selectedDistricts.length).fill(0)
    };

    // Populate counters with data from graph_data
    graph_data.forEach(row => {
        const districtIndex = selectedDistricts.indexOf(row['district']); // Find index of the district in selectedDistricts

        row['features']['properties'].forEach(item => {
            let type = item['properties']['Type'];
            if ((!selectedType || type === selectedType) && counters[type]) {
                counters[type][districtIndex] += parseFloat(item['properties']['HaUnderRes']);
            }
        });
    });

    var myChart = new Chart(ctx, {
        type: 'bar',  // Bar chart type (for grouped bars)
        data: {
            labels: column_names,  // District labels
            datasets: [
                {
                    label: 'River and Stream bank Restoration',
                    data: counters['River and Stream bank Restoration'],
                    backgroundColor: 'rgba(2, 205, 255, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Soil and Water Conservation',
                    data: counters['Soil and Water Conservation'],
                    backgroundColor: 'rgba(122, 68, 0, 0.7)',
                    borderColor: 'rgba(82, 45, 0, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Community Forest and Woodlots',
                    data: counters['Community Forest and Woodlots'],
                    backgroundColor: 'rgba(142, 255, 133, 0.7)',
                    borderColor: 'rgba(21, 249, 3, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Forest Management',
                    data: counters['Forest Management'],
                    backgroundColor: 'rgba(2, 87, 42, 0.7)',
                    borderColor: 'rgba(1, 158, 10, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Improved Agricultural Technologies',
                    data: counters['Improved Agricultural Technologies'],
                    backgroundColor: 'rgba(247, 240, 15, 0.7)',
                    borderColor: 'rgba(247, 240, 15, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true, // Make the chart responsive
            maintainAspectRatio: false, // Allow it to break the aspect ratio
            scales: {
                x: {
                    stacked: false  // Disable stacking on x-axis to show grouped bars
                },
                y: {
                    beginAtZero: true  // Keep y-axis starting at zero
                }
            },
            plugins: {
                legend: {
                    position: 'top',  // Align the legend to the top
                    labels: {
                        padding: 20,
                        textAlign: 'left',
                        usePointStyle: true
                    }
                }
            }
        }
    });
}


function updateMap(selectedType = "") {
    // Loop through layers and update based on the selected type
    for (var file_name in layers) {
        var layer = layers[file_name];

        layer.eachLayer(function (layerFeature) {
            let featureType = layerFeature.feature.properties.Type;
            if (selectedType === "" || featureType === selectedType) {
                layerFeature.setStyle({ opacity: 1, fillOpacity: 0.7 });
            } else {
                layerFeature.setStyle({ opacity: 0, fillOpacity: 0 });
            }
        });
    }
}

function applyTypeFilter() {
    // Get the selected type from the dropdown
    var selectedType = document.getElementById("restoration-type-filter").value;

    // Update both the map and graph based on the selected type
    loadGraph(selectedType);  // Pass the selected type to the graph function
    updateMap(selectedType);  // Update the map function based on the type
}
