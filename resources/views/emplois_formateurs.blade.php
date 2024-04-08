    @php
        $jours=['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
        $part_of_day=['Matin','A.Midi'];
        $seances_order=['s1','s2','s3','s4'];
    @endphp
<x-master title="emplois_formateurs">
    <div style="max-height: 85vh;">
        @include('includes.tableFormateurs')
    </div>
</x-master>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const filiereSelects = document.querySelectorAll('.filiereSelect');
    const schoolYearSelects = document.querySelectorAll('.schoolYearSelect');

    var groupSelects = document.querySelectorAll('.groupSelect');
    
    filiereSelects.forEach(function(select){
        select.addEventListener('change', function(){
            var selectedFilere = this.value;
            var selectedYear = this.parentNode.parentNode.querySelector('.schoolYearSelect').value;
            var jour = this.parentNode.parentNode.querySelector('.day').value;
            var order_seance = this.parentNode.parentNode.querySelector('.order_seance').value;
            var groupSelect = this.parentNode.parentNode.querySelector('.groupSelect');
            var fetchUrl = '{{route("afficher_seance_par_formateur") }}?filiere_id=' + encodeURIComponent(selectedFilere) + '&niveau=' + encodeURIComponent(selectedYear)+'&jour=' + encodeURIComponent(jour) + '&order_seance=' + encodeURIComponent(order_seance);
            fetchGroups(fetchUrl,groupSelect);
        });
    });
    schoolYearSelects.forEach(function(select) {
        select.addEventListener('change', function() {
            var selectedYear = this.value;
            var selectedFilere = this.parentNode.parentNode.querySelector('.filiereSelect').value;
            var jour = this.parentNode.parentNode.querySelector('.jour').value;
            var order_seance = this.parentNode.parentNode.querySelector('.order_seance').value;
            var groupSelect = this.parentNode.parentNode.querySelector('.groupSelect');
            var fetchUrl = '{{ route("afficher_seance_par_formateur") }}?filiere_id=' + encodeURIComponent(selectedFilere) + '&niveau=' + encodeURIComponent(selectedYear)+'&jour=' + encodeURIComponent(jour) + '&order_seance=' + encodeURIComponent(order_seance);
            fetchGroups(fetchUrl,groupSelect);
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
            console.log(data.groupes);
            groupSelect.innerHTML = '';
            var defaultOption = document.createElement('option');
            defaultOption.setAttribute('value', '');
            defaultOption.textContent = 'Choose a group';
            groupSelect.appendChild(defaultOption);
            data.groupes.forEach(function(group) {
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
