<x-master title="emplois_groupes">
    @php
        $seances_order = ['s1','s2','s3','s4'];
        $jours = ['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
    @endphp

    <div style="overflow-x: auto; overflow-y: auto; max-height: 85vh;border-radius:10px">
        <form id="filiereForm" action="{{ route('emploi_filiere') }}" method="get">
            <select id="selectFiliere" name="filiere_id" class="form-select" style="margin-bottom: 10px;" onchange="this.form.submit()">
                <option value="">Choose a filiere</option>
                @foreach($filieres as $filiere)
                    <option value="{{$filiere->id}}" {{$filiere->id == $selectedFiliereId ? 'selected' : ''}}>{{$filiere->nom_filier}}</option>
                @endforeach
            </select>

            <select id="selectNiveau" name="niveau" class="form-select" style="margin-bottom: 10px;" onchange="this.form.submit()">
                <option value="">Choose a niveau</option>
                @foreach($niveaux as $niveau)
                    <option value="{{$niveau}}" {{$niveau == $selectedNiveauId ? 'selected' : ''}}>{{$niveau}}</option>
                @endforeach
            </select>
        </form>
    </div>
    <table id="emploiTable" class="table table-dark table-striped-columns">
        <tr>
            <th colspan="2">HEURE</th>
            @foreach ($seances_order as $time)
                <th rowspan="2">{{$time}}</th>
            @endforeach
        </tr>
        <tr>
            <th>JOUR</th>
            <th>GROUPE</th>
        </tr>
        @foreach ($jours as $jour)
            <tr>
                <th rowspan="{{ count($groupes) + 1 }}">{{$jour}}</th>
                @foreach ($groupes as $groupe)
                    <tr>
                        <td>{{$groupe->nom_groupe}}</td>
                        @foreach ($seances_order as $seance_order)
                            @php
                                $seance = $seances->first(function($item) use ($jour, $seance_order, $groupe) {
                                    return $item->day === $jour  && $item->order_seance === $seance_order && $item->id_groupe == $groupe->id;
                                });
                            @endphp
                            @php
                                $modalId_update = $jour.'_'. $seance_order . '_' .$groupe->id.'_'."update";
                                $modalId_ajouter = $jour.'_'. $seance_order . '_' .$groupe->id.'_'."ajouter";
                            @endphp
                            @if($seance)
                                <td class="cellule" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'gray' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_update}}">
                                    <span>{{ $seance->formateur->name }} {{ $seance->formateur->prenom }}</span> /
                                    {{-- <span>{{ $seance->type_seance }}</span> <br> --}}
                                    <span>{{ $seance->salle->nom_salle }}</span>
                                </td>
                            @else
                                <td class="cellule" id="#{{$modalId_ajouter}}" style="background-color: {{ $seance ? 'gray' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_ajouter}}">
                                </td>
                            @endif
                            <!-- form_qui_ajouter_un_seance -->
                            <!-- form qui update un seance-->
                            @include('includes.modalGroupeSeance')
                        @endforeach
                    </tr>
                @endforeach
            </tr>
        @endforeach
    </table>
</x-master>

