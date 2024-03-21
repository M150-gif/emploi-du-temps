    @php
        $jours=['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
        $part_of_day=['Matin','A.Midi'];
        $seances_order=['s1','s2','s3','s4'];
    @endphp
<x-master title="emplois_formateurs">


    <div style="overflow-x: auto; overflow-y: auto; max-height: 85vh;border-radius:10px">
        @include('includes.tableFormateurs')
    </div>


</x-master>


<script>
    document.addEventListener("DOMContentLoaded", function() {
    var filiereSelects = document.querySelectorAll('.filiereSelect');
    var schoolYearSelects = document.querySelectorAll('.schoolYearSelect');
    var groupSelects = document.querySelectorAll('.groupSelect');

    filiereSelects.forEach(function(select) {
        select.addEventListener('change', function() {
            var selectedFilere = this.value;
            var selectedYear = this.parentNode.parentNode.querySelector('.schoolYearSelect').value;
            var groupSelect = this.parentNode.parentNode.querySelector('.groupSelect');
            var fetchUrl = '{{ route("filter.groups") }}?filiere=' + encodeURIComponent(selectedFilere) + '&school_year=' + encodeURIComponent(selectedYear);

            fetchGroups(fetchUrl, groupSelect);
        });
    });

    schoolYearSelects.forEach(function(select) {
        select.addEventListener('change', function() {
            var selectedYear = this.value;
            var selectedFilere = this.parentNode.parentNode.querySelector('.filiereSelect').value;
            var groupSelect = this.parentNode.parentNode.querySelector('.groupSelect');
            var fetchUrl = '{{ route("filter.groups") }}?filiere=' + encodeURIComponent(selectedFilere) + '&school_year=' + encodeURIComponent(selectedYear);

            fetchGroups(fetchUrl, groupSelect);
        });
    });

    function fetchGroups(fetchUrl, groupSelect) {
        fetch(fetchUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            groupSelect.innerHTML = '';
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
    }
});

</script>
