@php
    $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
    $part_of_day = ['Matin', 'A.Midi'];
    $seances_order = ['s1', 's2', 's3', 's4'];
@endphp
<style>
    td {
        cursor: pointer;
    }
</style>
<table class="table border border-dark ">
    <thead>
        <tr>
            <th rowspan="3" class="border border-info bg-grey text-black">Formateur</th>
            @foreach ($jours as $jour)
                <th colspan="4" class="border border-info text-black">{{ $jour }}</th>
            @endforeach
        </tr>
        <tr>
            @foreach ($jours as $jour)
                @foreach ($part_of_day as $part)
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
    <tbody class="border border-info">
        @foreach ($formateurs as $formateur)
            <tr>
                <td class="border border-info fs-5 text-black font-weight-bold">{{ $formateur->name }}</td>
                @foreach ($jours as $jour)
                    @foreach ($seances_order as $seance_order)
                        @php
                            $seance = $seances->first(function ($item) use ($jour, $seance_order, $formateur) {
                                return $item->day === $jour &&
                                    $item->order_seance === $seance_order &&
                                    $item->id_formateur == $formateur->id;
                            });
                        @endphp
                        @php
                            $modalId_update = $jour . '' . $seance_order . '' . $formateur->id . '_' . 'update';
                            $modalId_ajouter = $jour . '' . $seance_order . '' . $formateur->id . '_' . 'ajouter';
                        @endphp
                        @if ($seance)
                            <td class="cellule text-info border border-info" id="#{{ $modalId_update }}"
                                style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;"
                                data-bs-toggle="modal" data-bs-target="#{{ $modalId_update }}">
                                <span>{{ $seance->groupe->nom_groupe }}</span> <br>
                                <span>{{ $seance->type_seance }}</span> <br>
                                <span>{{ $seance->salle->nom_salle }}</span>
                            </td>
                        @else
                            <td class="cellule border border-info" id="#{{ $modalId_ajouter }}"
                                style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;"
                                data-bs-toggle="modal" data-bs-target="#{{ $modalId_ajouter }}">
                            </td>
                        @endif
                        <!-- form_qui_ajouter_un_seance -->
                        <!--form_qui_update-->
                        @include('includes.modalFormateurSeance')
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
