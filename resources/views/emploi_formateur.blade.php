@php
$jours=['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
$part_of_day=['Matin','A.Midi'];
$seances_order=['s1','s2','s3','s4'];
@endphp
<x-master title="emplois_formateurs">
    <div style="overflow-x: auto; overflow-y: auto; max-height: 85vh;border-radius:10px">
        <select id="formateurSelect" class="form-select mb-3" aria-label="Default select example">
            <option value="">Choisissez un formateur</option>
            @foreach($formateurs as $formateur)
                <option value="{{$formateur->id}}" {{ $selectedFormateur && $selectedFormateur->id == $formateur->id ? 'selected' : '' }}>
                    {{$formateur->name}} {{$formateur->prenom}}
                </option>
            @endforeach
        </select>


        <!-- Display the selected formateur's row -->
        @if($selectedFormateur)
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
                <tr>
                    <td>{{ $selectedFormateur->name }} {{ $selectedFormateur->prenom }}</td>
                    @foreach ($jours as $jour)
                        @foreach($seances_order as $seance_order)
                        @php
                            $seance = $seances->first(function($item) use ($jour, $part_of_day, $seance_order, $selectedFormateur) {
                                return $item->day === $jour && in_array($item->partie_jour, $part_of_day) && $item->order_seance === $seance_order && $item->id_formateur == $selectedFormateur->id;
                            });
                            $modalId_update = $jour.'_'. $seance_order . '_' .$selectedFormateur->id.'_'."update";
                            $modalId_ajouter = $jour.'_'. $seance_order . '_' .$selectedFormateur->id.'_'."ajouter";
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
                            <input name="id_formateur" type="text" hidden value="{{$selectedFormateur->id}}">
                            <select name="id_groupe" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
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
                            <select name="id_groupe" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
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
            </tbody>
        </table>
        @endif
    </div>
</x-master>

<script>
    // JavaScript to handle formateur selection
    document.getElementById('formateurSelect').addEventListener('change', function() {
        var formateurId = this.value;
        if (formateurId !== '') {
            window.location.href = "{{route('emploi_formateur')}}" + "?formateur_id=" + formateurId;
        }
    });
</script>
