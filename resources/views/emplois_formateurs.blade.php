    @php
        $jours=['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
        $part_of_day=['Matin','A.Midi'];
        $seances_order=['s1','s2','s3','s4'];
    @endphp
<x-master title="emplois_formateurs">

    <table class="table table-dark table-striped-columns">
        <thead>
            <tr>
                <th rowspan="3">Formateur</th>
                @foreach($jours as $jour)
                    <th colspan="4">{{$jour}}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($jours as $jour)
                    @foreach($part_of_day as $part)
                        <th colspan="2">{{$part}}</th>
                    @endforeach
                @endforeach
            </tr>
            <tr>
                @foreach ($jours as $jour)
                    <th>s1</th>
                    <th>s2</th>
                    <th>s3</th>
                    <th>s4</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($formateurs as $formateur)
                <tr>
                    <td>{{ $formateur->name }} {{ $formateur->prenom }}</td>
                    @foreach ($jours as $jour)
                        @foreach ($seances_order as $seance_order)
                            @php
                                $seance = $seances->first(function($item) use ($jour, $part, $seance_order, $formateur) {
                                    return $item->day === $jour && $item->partie_jour === $part && $item->order_seance === $seance_order && $item->id_formateur == $formateur->id;
                                });
                            @endphp
                            @php
                                $modalId_update = $jour.'_'. $seance_order . '_' .$formateur->id.'_'."update";
                                $modalId_ajouter = $jour.'_'. $seance_order . '_' .$formateur->id.'_'."ajouter";
                            @endphp
                            @if($seance)
                                <td class="cellule" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'gray' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_update}}">
                                    <span>{{ $seance->groupe->nom_groupe }}</span> <br>
                                    <span>{{ $seance->type_seance }}</span> <br>
                                    <span>{{ $seance->salle->nom_salle }}</span>
                                </td>
                            @else
                                <td class="cellule" id="#{{$modalId_ajouter}}" style="background-color: {{ $seance ? 'gray' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_ajouter}}">
                                </td>
                            @endif
                            <!-- form_qui_ajouter_un_seance -->
                            <div class="modal fade" id="{{$modalId_ajouter}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{$seance_order}}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('ajouter_seance')}}" method="post">
                                                @csrf
                                                <input name="day" type="text" hidden value="{{$jour}}">
                                                <input name="partie_jour" type="text" hidden value="{{$part}}">
                                                <input name="id_emploi" type="text" hidden value="{{$id_emploi}}">
                                                <input name="order_seance" type="text" hidden value="{{$seance_order}}">
                                                <input name="id_formateur" type="text" hidden value="{{$formateur->id}}">
                                                <select name="id_groupe" id="groupSelect" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                    <option selected  value="">choisissez un groupe</option>
                                                    @foreach($groupes as $groupe)
                                                        @php
                                                            $groupe_deja_occupe= $groupe->seance->where('id_emploi','==',$id_emploi)->where('day', '==',$jour)->where('order_seance','==',$seance_order);
                                                            $groupe_has_no_seance = $groupe->seance->isEmpty();
                                                        @endphp
                                                        @if($groupe_deja_occupe->count()==0 || $groupe_has_no_seance)
                                                            <option value="{{$groupe->id}}">{{$groupe->nom_groupe}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <select name="id_salle" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                    <option selected value="">choisissez la salle</option>
                                                    @foreach($salles as $salle)
                                                        @php
                                                            $salle_occupe=$salle->seance->where('id_emploi','==',$id_emploi)->where('day','==',$jour)->where('order_seance','==',$seance_order);
                                                            $salle_has_no_seance=$salle->seance->isEmpty();
                                                        @endphp
                                                        @if($salle_occupe->count()===0 || $salle_has_no_seance)
                                                            <option value="{{$salle->id}}">{{$salle->nom_salle}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <select name="type_seance" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                    <option selected value="">choisissez le type de la seance</option>
                                                    <option value="presentielle">presentielle</option>
                                                    <option value="team">team</option>
                                                    <option value="efm">efm</option>
                                                </select>
                                                {{-- la selection par l'annee scolaire --}}
                                                <select id="schoolYearSelect" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                    <option selected>Choose the school year</option>
                                                    <option value="Premier cycle">Premier cycle</option>
                                                    <option value="Deuxième cycle">Deuxième cycle</option>
                                                    <option value="Troisième cycle">Troisième cycle</option>
                                                </select>
                                                {{-- la selection par l'annee scolaire --}}
                                                <button type="submit" class="btn btn-primary">ajouter seance</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--form_qui_update-->
                            @if($seance)
                                <div class="modal fade" id="{{$modalId_update}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">{{$seance_order}}</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('modifier_seance')}}" method="post">
                                                    @csrf
                                                    <input type="text" name="seance_id" value="{{$seance->id}}" hidden>
                                                    <select id="groupSelectUpdate" name="id_groupe" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                        <option selected value="{{$seance->groupe->id }}">{{$seance->groupe->nom_groupe}}</option>
                                                        @foreach($groupes as $groupe)
                                                            @php
                                                                $groupe_deja_occupe= $groupe->seance->where('id_emploi','==',$id_emploi)->where('day', '==',$jour)->where('order_seance','==',$seance_order);
                                                                $groupe_has_no_seance = $groupe->seance->isEmpty();
                                                            @endphp
                                                            @if($groupe_deja_occupe->count()==0 || $groupe_has_no_seance)
                                                                <option value="{{$groupe->id}}">{{$groupe->nom_groupe}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <select name="id_salle" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                        <option selected value="{{$seance->salle->id }}">{{ $seance->salle->nom_salle }}</option>
                                                        @foreach($salles as $salle)
                                                            @php
                                                                $salle_occupe=$salle->seance->where('id_emploi','==',$id_emploi)->where('day','==',$jour)->where('order_seance','==',$seance_order);
                                                                $salle_has_no_seance=$salle->seance->isEmpty();
                                                            @endphp
                                                            @if($salle_occupe->count()===0 || $salle_has_no_seance)
                                                                <option value="{{$salle->id}}">{{$salle->nom_salle}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <select name="type_seance" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                        <option value="presentielle">presentielle</option>
                                                        <option value="team">team</option>
                                                        <option value="efm">efm</option>
                                                    </select>
                                                            <select id="schoolYearSelectUpdate" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                                    <option selected>Choose the school year</option>
                                                                    <option value="Premier cycle">Premier cycle</option>
                                                                    <option value="Deuxième cycle">Deuxième cycle</option>
                                                                    <option value="Troisième cycle">Troisième cycle</option>
                                                                </select>
                                                    <button type="submit" class="btn btn-success">update</button>
                                                </form>
                                                <form action="{{route('supprimer_seance')}}" method="post">
                                                    @csrf
                                                    <input type="text" name="seance_id" value="{{$seance->id}}" hidden>
                                                    <button type="submit" class="btn btn-danger">supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</x-master>




{{-- //////////////////////////// --}}
<!-- HTML -->
<select id="groupSelect" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
    <option selected value="">Choose a group</option>
</select>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('schoolYearSelect').addEventListener('change', function() {
        var selectedSchoolYear = this.value;

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
            var groupSelect = document.getElementById('groupSelect');
            groupSelect.innerHTML = ''; // Clear previous options

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






       document.getElementById('schoolYearSelectUpdate').addEventListener('change', function() {
        var selectedSchoolYear = this.value;

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
            var groupSelect = document.getElementById('groupSelectUpdate');
            groupSelect.innerHTML = ''; // Clear previous options

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
</script>

