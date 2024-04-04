@php
$jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
$seances_order = ['s1', 's2', 's3', 's4'];
@endphp
<x-master title="emplois_formateurs">
    <div style=" max-height: 85vh;border-radius:10px">
        <select id="formateurSelect" class="form-select mb-3" aria-label="Default select example">
            <option value="">Choisissez un formateur</option>
            @foreach($formateurs as $formateur)
                <option value="{{$formateur->id}}" {{ $selectedFormateur && $selectedFormateur->id == $formateur->id ? 'selected' : '' }}>
                    {{$formateur->name}} {{$formateur->prenom}}
                </option>
            @endforeach
        </select>
<style>
    .s{
        border-bottom: 1px solid black !important;
    }
</style>

        <!-- Display the selected formateur's row -->
        @if($selectedFormateur)
        <table class="table border border-dark  border-4">
            <tr>
                <th class="text-black border-4" style="text-align:center" colspan="2" >Heure</th>
                @foreach ($seances_order as $seance_order)
                    <th rowspan="2" class="border border-dark bg-grey text-black border-4">{{ $seance_order }}</th>
                @endforeach
            </tr>
            <tr class="border-4">
                <th style="text-align:center"  class="border border-dark bg-grey text-black border-4">Jour</th>
            </tr>
            @foreach ($jours as $jour)
                <tr >
                    <th rowspan="3" class="border border-dark bg-grey text-black border-4">{{ $jour }}</th>
                    <th class="s border-end boredr-start border-bottom-0 border-dark bg-grey text-black border-4">Groupe</th>
                    @foreach ($seances_order as $seance_order)
                        @php
                            $seance = $seances->first(function($item) use ($jour, $seance_order, $selectedFormateur) {
                                return $item->day === $jour && $item->order_seance === $seance_order && $item->id_formateur == $selectedFormateur->id;
                            });
                            $modalId_update = $jour.'_'. $seance_order . '_' .$selectedFormateur->id.'_'."update";
                            $modalId_ajouter = $jour.'_'. $seance_order . '_' .$selectedFormateur->id.'_'."ajouter";
                        @endphp
                        @if($seance)
                            <td class="cellule border-end border-dark bg-grey text-black" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_update}}">
                                <span>{{ $seance->groupe->nom_groupe }}</span>
                            </td>
                        @else
                            <td class="cellule border-end border-start border-bottom-0 border-dark bg-grey text-black border-4" id="#{{$modalId_ajouter}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_ajouter}}">
                            </td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <th class="s border border-top-0 border-bottom-0 border-dark bg-grey text-black border-4">Module</th>
                    @foreach ($seances_order as $seance_order)
                        @php
                            $seance = $seances->first(function($item) use ($jour, $seance_order, $selectedFormateur) {
                                return $item->day === $jour && $item->order_seance === $seance_order && $item->id_formateur == $selectedFormateur->id;
                            });
                            $modalId_update = $jour.'_'. $seance_order . '_' .$selectedFormateur->id.'_'."update";
                            $modalId_ajouter = $jour.'_'. $seance_order . '_' .$selectedFormateur->id.'_'."ajouter";
                        @endphp
                        @if($seance)
                            <td class="cellule border border-dark bg-grey text-black" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_update}}">
                                @if ($seance->module_id)
                                    <span class="border border-dark bg-grey text-black">{{$seance->module->intitule}}</span>
                                @else
                                    <span>M</span>
                                @endif
                                {{-- <span>{{$seance->type_seance}}</span> --}}
                            </td>
                        @else
                            <td class="cellule border-end border-start border-top-0 border-bottom-0  border-dark bg-grey text-black border-4" id="#{{$modalId_ajouter}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_ajouter}}">
                            </td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <th class="border-end border-start border-top-0 border-bottom-0 border-dark bg-grey text-black border-4">Salle</th>
                    @foreach ($seances_order as $seance_order)
                        @php
                            $seance = $seances->first(function($item) use ($jour, $seance_order, $selectedFormateur) {
                                return $item->day === $jour && $item->order_seance === $seance_order && $item->id_formateur == $selectedFormateur->id;
                            });
                            $modalId_update = $jour.'_'. $seance_order . '_' .$selectedFormateur->id.'_'."update";
                            $modalId_ajouter = $jour.'_'. $seance_order . '_' .$selectedFormateur->id.'_'."ajouter";
                        @endphp
                        @if($seance)
                            <td class="cellule border border-dark bg-grey text-black" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_update}}">
                                <span>{{ $seance->salle->nom_salle }}</span>
                            </td>
                        @else
                            <td class="cellule border-end boredr-start border-top-0 border-dark bg-grey text-black border-4" id="#{{$modalId_ajouter}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_ajouter}}">
                            </td>
                        @endif

                        {{-- @include('includes.modalFormateurSeance') --}}
                        <!-- Ajouter Modal -->
                        <!-- form_qui_ajouter_un_seance -->
                        <div class="modal fade" id="{{ $modalId_ajouter }}" tabindex="-1"aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $seance_order }} {{$jour}}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('ajouter_seance') }}" method="post">
                                            @csrf
                                            <input name="day" type="text" hidden value="{{ $jour }}">
                                            <input name="id_emploi" type="text" hidden value="{{ $id_emploi }}">
                                            <input name="order_seance" type="text" hidden
                                                value="{{ $seance_order }}">
                                            <input name="id_formateur" type="text" hidden
                                                value="{{ $selectedFormateur->id }}">
                                                <select class="form-select filiereSelect" style="margin-bottom:10px;" aria-label="Default select example">
                                                    <option selected value="">Choose a filiere</option>
                                                    @foreach ($filieres as $filiere)
                                                        <option value="{{ $filiere->id }}">{{ $filiere->nom_filier }}</option>
                                                    @endforeach
                                                </select>
                                                <select class="form-select schoolYearSelect" style="margin-bottom:10px;" aria-label="Default select example">
                                                    <option selected value="">choisissez une année</option>
                                                    <option value="1">Premier cycle</option>
                                                    <option value="2">Deuxième cycle</option>
                                                    <option value="3">Troisième cycle</option>
                                                </select>

                                                <!-- HTML code: Add filiere select -->

                                                <!-- Existing select for groupes -->
                                                <select name="id_groupe" class="form-select groupSelect" style="margin-bottom:10px;" aria-label="Default select example">
                                                    <option selected value="">choisissez un groupe</option>
                                                    @foreach ($groupes as $formateurGroupe)
                                                        @php
                                                            $groupe_deja_occupe = $formateurGroupe->groupe->seances
                                                                ->where('id_emploi', $id_emploi)
                                                                ->where('day', $jour)
                                                                ->where('order_seance', $seance_order);
                                                            $groupe_has_no_seance = $formateurGroupe->groupe->seances->isEmpty();
                                                        @endphp
                                                        @if ($groupe_deja_occupe->count() == 0 || $groupe_has_no_seance)
                                                            <option value="{{ $formateurGroupe->groupe->id }}">{{ $formateurGroupe->groupe->nom_groupe }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>


                                            <select name="id_salle" class="form-select" style="margin-bottom:10px;"
                                                aria-label="Default select example">
                                                <option selected value="">choisissez la salle</option>
                                                @foreach ($salles as $salle)
                                                    @php
                                                        $salle_occupe = $salle->seance
                                                            ->where('id_emploi', '==', $id_emploi)
                                                            ->where('day', '==', $jour)
                                                            ->where('order_seance', '==', $seance_order);
                                                        $salle_has_no_seance = $salle->seance->isEmpty();
                                                    @endphp
                                                    @if ($salle_occupe->count() === 0 || $salle_has_no_seance)
                                                        <option value="{{ $salle->id }}">{{ $salle->nom_salle }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <select class="form-control" id="module_id" name="module_id">
                                                <option selected value="">choisissez le module</option>
                                                <!-- Populate options dynamically based on available modules -->
                                                @foreach ($modules as $module)
                                                    <option value="{{ $module->module_id }}">{{ $module->module->nom_module }}</option>
                                                @endforeach
                                            </select>
                                            <select name="type_seance" class="form-select" style="margin-bottom:10px;"
                                                aria-label="Default select example">
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
                    @endforeach
                </tr>
            @endforeach
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
