@php
    $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
    $part_of_day = ['Matin', 'A.Midi'];
    $seances_order = ['s1', 's2', 's3', 's4'];
@endphp
<style>
    td{
        cursor: pointer;
    }
</style>
<x-master title="emplois_formateurs">
    <select id="groupeSelect" class="form-select mb-3 fs-6 text-black font-weight-bold" aria-label="Default select example">
        <option value="">Choisissez un groupe</option>
        @foreach($groupes as $groupe)
        <option value="{{ $groupe->id }}" {{ $selectedGroupe && $selectedGroupe->id == $groupe->id ? 'selected' : '' }}>
            {{ $groupe->nom_groupe }}
        </option>
        @endforeach
    </select>
    <div style="overflow-x: auto; overflow-y: auto; max-height: 85vh">

        <!-- Display the selected groupe's row -->
        @if($selectedGroupe)
            <table class="table border border-info">
                <thead>
                    <tr>
                        <th class="border-info text-black"><span class="fs-6 text-black" style="--bs-text-opacity: .5;">Groupe : </span>{{ $selectedGroupe->nom_groupe }}</th>
                    </tr>
                    <tr>
                        {{-- <th rowspan="3" class="border border-info bg-grey text-black">Groupe</th> --}}
                        @foreach($jours as $jour)
                            <th colspan="4" class="border border-info text-black">{{ $jour }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($jours as $jour)
                            @foreach($part_of_day as $part)
                                <th colspan="2" class="border border-info text-black">{{ $part }}</th>
                            @endforeach
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($jours as $jour)
                            <th class="border border-info text-black">s1</th>
                            <th class="border border-info text-black">s2</th>
                            <th class="border border-info text-black">s3</th>
                            <th class="border border-info text-black">s4</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        {{-- <td class="border border-info fs-5 text-black font-weight-bold">{{ $selectedGroupe->nom_groupe }}</td> --}}
                        @foreach ($jours as $jour)
                            @foreach($seances_order as $seance_order)
                                @php
                                    $seance = $seances->first(function($item) use ($jour, $seance_order, $selectedGroupe) {
                                        return $item->day === $jour && $item->order_seance === $seance_order && $item->id_groupe == $selectedGroupe->id;
                                    });
                                    $modalId_update = $jour.'_'. $seance_order . '_' .$selectedGroupe->id.'_'."update";
                                    $modalId_ajouter = $jour.'_'. $seance_order . '_' .$selectedGroupe->id.'_'."ajouter";
                                @endphp
                                @if($seance)
                                    <td class="cellule text-info border border-info" id="{{ $modalId_update }}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{ $modalId_update }}">
                                        <span>{{ $seance->formateur->name }} {{ $seance->formateur->prenom }}</span> <br>
                                        <span>{{ $seance->type_seance }}</span> <br>
                                        <span>{{ $seance->salle->nom_salle }}</span>
                                    </td>
                                @else
                                    <td class="cellule text-info border border-info" id="{{ $modalId_ajouter }}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{ $modalId_ajouter }}"></td>
                                @endif
                                <!-- form_qui_ajouter_un_seance -->
                                <!-- form_qui_update and other modals -->
                                <!--form_qui_update-->
                                @include('includes.modalGroupeSeance')

                            @endforeach
                        @endforeach
                    </tr>
                </tbody>
            </table>
        @endif
    </div>
</x-master>

<script>
    // JavaScript to handle groupe selection
    document.getElementById('groupeSelect').addEventListener('change', function() {
        var groupeId = this.value;
        if (groupeId !== '') {
            window.location.href = "{{ route('emploi_groupe') }}" + "?groupe_id=" + groupeId;
        }
    });
</script>
