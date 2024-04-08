<h3>Emploi : CDJ</h3>
        <table id="emploiTable" class="table border border-dark  border-4">
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
                            $modalId_update = $jour.''. $seance_order . '' .$selectedFormateur->id.'_'."update";
                            $modalId_ajouter = $jour.''. $seance_order . '' .$selectedFormateur->id.'_'."ajouter";
                        @endphp
                        @if($seance)
                            <td class="cellule border-end border-dark bg-grey text-black" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_update}}">
                                @foreach($groupes as $formateurGroupe)
                                    @if ($formateurGroupe->groupe->Mode_de_formation === 'CDJ')
                                        @php
                                            $groupe_deja_occupee = $formateurGroupe->groupe->seances
                                                ->where('id_emploi', $id_emploi)
                                                ->where('day', $jour)
                                                ->where('order_seance', $seance_order)
                                                ->where('id_formateur', $selectedFormateur->id);
                                        @endphp
                                        @if ($groupe_deja_occupee->isNotEmpty())
                                            <span>{{ $formateurGroupe->groupe->nom_groupe }}</span>
                                        @endif
                                    @endif
                                @endforeach
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
                            $modalId_update = $jour.''. $seance_order . '' .$selectedFormateur->id.'_'."update";
                            $modalId_ajouter = $jour.''. $seance_order . '' .$selectedFormateur->id.'_'."ajouter";
                        @endphp
                        @if (isset($seance))
                        <td class="cellule border border-dark bg-grey text-black" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_update}}">
                            @if ($seance->module_id)
                                <span class="border border-dark bg-grey text-black">{{ $seance->module->intitule }}</span>
                            @else
                                <span>M</span>
                            @endif
                            {{-- <span>{{$seance->type_seance}}</span> --}}
                        </td>
                    @else
                    <td class="cellule border-end border-start border-top-0 border-bottom-0  border-dark bg-grey text-black border-4" id="#{{$modalId_ajouter}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_ajouter}}">
                    </td>
                        <!-- Handle the case when $seance is null or not set -->
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
                            $modalId_update = $jour.''. $seance_order . '' .$selectedFormateur->id.'_'."update";
                            $modalId_ajouter = $jour.''. $seance_order . '' .$selectedFormateur->id.'_'."ajouter";
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
                                        <form action="{{ route('ajouter_seanceFomFormateur') }}" method="post">
                                            @csrf
                                            <input name="day" type="text" hidden value="{{ $jour }}">
                                            <input name="id_emploi" type="text" hidden value="{{ $id_emploi }}">
                                            <input name="order_seance" type="text" hidden
                                                value="{{ $seance_order }}">
                                            <input name="id_formateur" type="text" hidden
                                                value="{{ $selectedFormateur->id }}">
                                                {{-- <select class="form-select filiereSelect" style="margin-bottom:10px;" aria-label="Default select example">
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
                                                </select> --}}

                                                <!-- HTML code: Add filiere select -->

                                                <!-- Existing select for groupes -->
                                                <p>Groupes</p>
                                                <div style="border: 1px solid grey; border-radius: 5px; margin: 10px; max-height: 200px; overflow-y: auto; padding: 5px;">
                                                    @foreach ($groupes as $formateurGroupe)
                                                        @if ($formateurGroupe->groupe->Mode_de_formation == 'CDJ')
                                                            @php
                                                                $groupe_deja_occupe = $formateurGroupe->groupe->seances
                                                                    ->where('id_emploi', $id_emploi)
                                                                    ->where('day', $jour)
                                                                    ->where('order_seance', $seance_order);
                                                                $groupe_has_no_seance = $formateurGroupe->groupe->seances->isEmpty();
                                                            @endphp
                                                            @if ($groupe_deja_occupe->count() == 0 || $groupe_has_no_seance)
                                                                <div class="form-check" style="margin-bottom: 5px;">
                                                                    <input class="form-check-input" type="checkbox" name="id_groupe[]" id="groupe{{ $formateurGroupe->groupe->id }}" value="{{ $formateurGroupe->groupe->id }}" style="margin-right: 5px;">
                                                                    <label class="form-check-label" for="groupe{{ $formateurGroupe->groupe->id }}">{{ $formateurGroupe->groupe->nom_groupe }}</label>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </div>
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
                        <!--form_qui_update-->
                        @if($seance)
                            <div class="modal fade" id="{{ $modalId_update }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $seance_order }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('modifier_seance') }}" method="post">
                                                @csrf
                                                <input type="text" name="seance_id" value="{{ $seance->id }}"
                                                hidden>
                                                    <input name="day" type="text"  value="{{ $jour }}" hidden>
                                                    <input name="id_emploi" type="text"  value="{{ $id_emploi }}" hidden>
                                                    <input name="order_seance" type="text"
                                                        value="{{ $seance_order }}" hidden>
                                                    <input name="id_formateur" type="text"
                                                        value="{{ $selectedFormateur->id }}" hidden>
                                                <p>Groupes</p>
                                                <div style="border: 1px solid grey; border-radius: 5px; margin: 10px; max-height: 200px; overflow-y: auto; padding: 5px;">
                                                    @foreach ($groupes as $formateurGroupe)
                                                        @if ($formateurGroupe->groupe->Mode_de_formation == 'CDJ')
                                                                @php
                                                                    $groupe_deja_occupe = $formateurGroupe->groupe->seances
                                                                        ->where('id_emploi', $id_emploi)
                                                                        ->where('day', $jour)
                                                                        ->where('order_seance', $seance_order);
                                                                    $groupe_has_no_seance = $formateurGroupe->groupe->seances->isEmpty();
                                                                @endphp
                                                                @if ($groupe_deja_occupe->count() == 0 || $groupe_has_no_seance)
                                                                    <div class="form-check" style="margin-bottom: 5px;">
                                                                        <input class="form-check-input" type="checkbox" name="id_groupe[]" id="groupe{{ $formateurGroupe->groupe->id }}" value="{{ $formateurGroupe->groupe->id }}" style="margin-right: 5px;">
                                                                        <label class="form-check-label" for="groupe{{ $formateurGroupe->groupe->id }}">{{ $formateurGroupe->groupe->nom_groupe }}</label>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                    @endforeach
                                                </div>
                                                <select name="id_salle" class="form-select"
                                                    style="margin-bottom:10px;" aria-label="Default select example">
                                                    <option selected value="{{ $seance->salle->id_salle }}">
                                                        {{ $seance->salle->nom_salle }}</option>
                                                    @foreach ($salles as $salle)
                                                        @php
                                                            $salle_occupe = $salle->seance
                                                                ->where('id_emploi', '==', $id_emploi)
                                                                ->where('day', '==', $jour)
                                                                ->where('order_seance', '==', $seance_order);
                                                            $salle_has_no_seance = $salle->seance->isEmpty();
                                                        @endphp
                                                        @if ($salle_occupe->count() === 0 || $salle_has_no_seance)
                                                            <option value="{{ $salle->id }}">
                                                                {{ $salle->nom_salle }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-success" hidden>update</button>
                                            </form>
                                            <form action="{{ route('supprimer_seance') }}" method="post">
                                                @csrf
                                                <input type="text" name="seance_id" value="{{ $seance->id }}"
                                                    hidden>
                                                    <input type="text" name="seance_id" value="{{ $seance->id }}"
                                                    hidden>
                                                    <input name="day" type="text"  value="{{ $jour }}" hidden>
                                                    <input name="id_emploi" type="text"  value="{{ $id_emploi }}" hidden>
                                                    <input name="order_seance" type="text"
                                                        value="{{ $seance_order }}" hidden>
                                                    <input name="id_formateur" type="text"
                                                        value="{{ $selectedFormateur->id }}" hidden>
                                                <button type="submit" class="btn btn-danger">supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </table>
        <button class="btn btn-success" onclick="ExportToExcel('xlsx')">Export to excel</button>
        <script>
            function ExportToExcel(type, fn, dl) {
            var elt = document.getElementById('emploiTable');
            var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
            return dl ?
                XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
                XLSX.writeFile(wb, fn || ('CDJ(Formateur).' + (type || 'xlsx')));
            }
        </script>
