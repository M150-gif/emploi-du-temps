<x-master title="emplois_formateurs">


    <div style="overflow-x: auto; overflow-y: auto; max-height: 85vh;border-radius:10px">
        @include('includes.tableFormateurs')
    </div>

</x-master>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var schoolYearSelects = document.querySelectorAll('.schoolYearSelect');

        schoolYearSelects.forEach(function(select) {
            select.addEventListener('change', function() {
                var selectedSchoolYear = this.value;
                var groupSelect = this.parentNode.parentNode.querySelector('.groupSelect'); // Get the group select element

                // Construct the URL for fetching groups based on the selected school year
                var fetchUrl = '{{ route("filter.groups") }}?school_year=' + encodeURIComponent(selectedSchoolYear);

                // Make an AJAX request to fetch groups based on the selected school year
                fetch(fetchUrl, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    // Handle the JSON response data
                    console.log(data);

                    // Populate the group select element with the fetched groups
                    groupSelect.innerHTML = ''; // Clear previous options

                    // Append the default option
                    var defaultOption = document.createElement('option');
                    defaultOption.setAttribute('value', '');
                    defaultOption.textContent = 'Choose a group';
                    groupSelect.appendChild(defaultOption);

                    data.forEach(function(group) {
                        var option = document.createElement('option');
                        option.value = group.id;
                        option.textContent = group.nom_groupe;
                        groupSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
            });
        });
    });
</script>
