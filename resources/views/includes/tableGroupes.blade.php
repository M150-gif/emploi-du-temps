@php
$jours=['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
$part_of_day=['Matin','A.Midi'];
$seances_order=['s1','s2','s3','s4'];
@endphp
<style>
    td{
        cursor: pointer;
    }
</style>
<table class="table border border-info">
    <thead>
        <tr >
            <th rowspan="3" class="border border-info text-black">Groupe</th>
            @foreach($jours as $jour)
                <th colspan="4" class="border border-info text-black">{{$jour}}</th>
            @endforeach
        </tr>
        <tr>
            @foreach ($jours as $jour)
                @foreach($part_of_day as $part)
                    <th colspan="2" class="border border-info text-black">{{$part}}</th>
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
        @foreach ($groupes as $groupe)
            <tr>
                <td class="border border-info fs-5 text-black font-weight-bold">{{ $groupe->nom_groupe }}</td>
                @foreach ($jours as $jour)
                    @foreach ($seances_order as $seance_order)
                        @php
                            $seance = $seances->first(function($item) use ($jour, $seance_order, $groupe) {
                                return $item->day === $jour && $item->order_seance === $seance_order && $item->id_groupe == $groupe->id;
                            });
                        @endphp
                        @php
                            $modalId_update = $jour.'_'. $seance_order . '_' .$groupe->id.'_'."update";
                            $modalId_ajouter = $jour.'_'. $seance_order . '_' .$groupe->id.'_'."ajouter";
                        @endphp
                        @if($seance)
                            <td class="cellule text-info border border-info" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_update}}">
                                <span>{{ $seance->formateur->name }} {{ $seance->formateur->prenom }}</span> <br>
                                <span>{{ $seance->type_seance }}</span> <br>
                                <span>{{ $seance->salle->nom_salle }}</span>
                            </td>
                        @else
                            <td class="cellule text-info border border-info" id="#{{$modalId_ajouter}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_ajouter}}">
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
                                            <input name="id_groupe" type="text" hidden value="{{$groupe->id}}">
                                            <select name="id_formateur" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                <option value="">Choose a formateur</option>
                                                @foreach ($formateurs as $formateur)
                                                    @php
                                                        // $formateur_deja_occupe = $formateur->seance->where('id_emploi', $id_emploi)->where('day', $jour)->where('order_seance', $seance_order);
                                                        // Change 'formateur_id' to 'id_formateur' in your query
                                                        $formateur_deja_occupe = $formateur->seance->where('id_emploi', $id_emploi)
                                                                                                ->where('day', $jour)
                                                                                                ->where('order_seance', $seance_order);
                                                        $formateur_has_no_seance = $formateur->seance->isEmpty();
                                                    @endphp
                                                    @if ($formateur_deja_occupe->count() == 0 || $formateur_has_no_seance)
                                                        <option value="{{ $formateur->id }}">{{ $formateur->name }}</option>
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
                                            <form action="{{route('modifier_seance_groupe')}}" method="post">
                                                @csrf
                                                <input type="text" name="seance_id" value="{{$seance->id}}" hidden>
                                                <select name="id_formateur" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                    <option selected value="{{$seance->formateur->id }}">{{$seance->formateur->name}} {{$seance->formateur->prenom}}</option>
                                                    @foreach ($formateurs as $formateur)
                                                        @php
                                                            // $formateur_deja_occupe = $formateur->seance->where('id_emploi', $id_emploi)->where('day', $jour)->where('order_seance', $seance_order);
                                                            // Change 'formateur_id' to 'id_formateur' in your query
                                                            $formateur_deja_occupe = $formateur->seance->where('id_emploi', $id_emploi)
                                                                                                    ->where('day', $jour)
                                                                                                    ->where('order_seance', $seance_order);
                                                            $formateur_has_no_seance = $formateur->seance->isEmpty();
                                                        @endphp
                                                        @if ($formateur_deja_occupe->count() == 0 || $formateur_has_no_seance)
                                                            <option value="{{ $formateur->id }}">{{ $formateur->name }}</option>
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
        @endforeach
    </tbody>
</table>
