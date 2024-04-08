<x-master title="emplois_groupes">
    @php
        $seances_order = ['s1','s2','s3','s4'];
        $seanceorder = 's5';
        $jours = ['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
        if ($selectTypeEmploi) {
            # code...
            $filiere = $filieres->where('id', $selectTypeEmploi)->pluck('nom_filier')->first();

        } else {
            # code...
            $filiere = 'myEmploi';
        }

    @endphp

    <div style="overflow-x: auto; overflow-y: auto; max-height: 85vh;border-radius:10px">
        <form id="filiereForm" action="{{ route('emploi_filiere') }}" method="get">

            <select id="selectTypeEmploi" name="TypeEmploi" class="form-select" style="margin-bottom: 10px;" onchange="this.form.submit()">
                <option value="">Choose a Type</option>
                    <option value="CDJ" {{'CDJ' == $selectTypeEmploi ? 'selected' : ''}}>CDJ</option>
                    <option value="CDS" {{'CDS' == $selectTypeEmploi ? 'selected' : ''}}>CDS</option>
            </select>

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
        <style>
            .s{
                border-bottom: 1px solid black !important;
            }
            .d{
                border-bottom:  4px solid #344767 !important;

            }
        </style>
    </div>


        @if ($selectTypeEmploi == 'CDJ')
            @include('includes.emploiCDJ_Filiere')
        @elseif ($selectTypeEmploi == 'CDS')
            @include('includes.emploiCDS_Filiere')
        @else
        <h3>Emploi : CDJ</h3>
        <table id="emploiTable" class="table border border-dark  border-4">
            <tr>
                <th class="text-black  border-4" style="text-align:center" colspan="2" >HEURE</th>
                @foreach ($seances_order as $time)
                    <th rowspan="2" class="border border-dark bg-grey text-black border-4">{{$time}}</th>
                @endforeach
            </tr>
            <tr>
                <th class="border border-dark bg-grey text-black border-4">JOUR</th>
                <th class="border border-dark bg-grey text-black border-4">GROUPE</th>
            </tr>
            @foreach ($jours as $jour)
                <tr>
                    <th rowspan="{{ count($groupes->where('Mode_de_formation','CDJ')) + 1 }}" class="border border-dark bg-grey text-black border-4">{{$jour}}</th>
                    @foreach ($groupes->where('Mode_de_formation','CDJ') as $groupe)
                        <tr>
                            <td class="s border-end border-start border-top-0 border-dark bg-grey text-black border-4 {{ $loop->last ? 'd' : '' }}">{{$groupe->nom_groupe}}</td>
                            @if ($groupe->stage == 'stage')
                                <td colspan="4" style="text-align: center"><strong>STAGE</strong></td>
                            @else
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
                                        <td class="cellule text-black border border-dark" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_update}}">
                                            <span>{{ $seance->formateur->name }} </span> /
                                            {{-- <span>{{ $seance->type_seance }}</span> <br> --}}
                                            <span>{{ $seance->salle->nom_salle }}</span>
                                            @if ($seance->type_seance == 'team')
                                            / <span>CAD</span>
                                            @endif
                                        </td>
                                    @else
                                        <td class="cellule text-black border border-dark {{  $loop->parent->last? 'd' : '' }}" id="#{{$modalId_ajouter}}" style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_ajouter}}">

                                        </td>
                                    @endif
                                    <!-- form_qui_ajouter_un_seance -->
                                    <div class="modal fade" id="{{$modalId_ajouter}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{$seance_order}} {{$jour}} {{$groupe->nom_groupe}}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('ajouter_seance')}}" method="post">
                                                        @csrf
                                                        <input name="day" type="text" hidden value="{{$jour}}">
                                                        <input name="id_emploi" type="text" hidden value="{{$id_emploi}}">
                                                        <input name="order_seance" type="text" hidden value="{{$seance_order}}">
                                                        <input name="id_groupe" type="text" hidden value="{{$groupe->id}}">
                                                        <select name="id_formateur" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                            <option value="">Choose a formateur</option>
                                                                @foreach ($formateurs as $formateur)
                                                                    @php
                                                                        // Check if the formateur is related to the selected groupe
                                                                        $formateur_related_to_groupe = $formateur->groupes->contains($groupe->id);
                                                                        // Check if the formateur is available for the selected jour and seance_order
                                                                        $formateur_deja_occupe = $formateur->seance->where('id_emploi', $id_emploi)
                                                                                                                ->where('day', $jour)
                                                                                                                ->where('order_seance', $seance_order)
                                                                                                                ->isNotEmpty();
                                                                    @endphp
                                                                    @if ($formateur_related_to_groupe && !$formateur_deja_occupe)
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
                                            <!-- form qui update un seance-->

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
                                                                        // Check if the formateur is related to the selected groupe
                                                                        $formateur_related_to_groupe = $formateur->groupes->contains($groupe->id);
                                                                        // Check if the formateur is available for the selected jour and seance_order
                                                                        $formateur_deja_occupe = $formateur->seance->where('id_emploi', $id_emploi)
                                                                                                                ->where('day', $jour)
                                                                                                                ->where('order_seance', $seance_order)
                                                                                                                ->isNotEmpty();
                                                                    @endphp
                                                                    @if ($formateur_related_to_groupe && !$formateur_deja_occupe)
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
                                                        <form action="{{route('supprimer_seanceFiliere')}}" method="post">
                                                            @csrf

                                                            <input name="day" type="text"  value="{{ $jour }}" hidden>
                                                            <input name="groupe" type="text"  value="{{ $groupe->id }}" hidden>
                                                            <input name="id_emploi" type="text"  value="{{ $id_emploi }}" hidden>
                                                            <input name="order_seance" type="text"
                                                                value="{{ $seance_order }}" hidden>
                                                            <input type="text" name="seance_id" value="{{$seance->id}}" hidden>
                                                            <button type="submit" class="btn btn-danger">supprimer</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </tr>
                    @endforeach
                </tr>
            @endforeach
        </table>

        <h3>Emploi : CDS</h3>
        <table id="emploiTable1" class="table border border-dark border-4">
            <tr>
                <th class="text-black border-4" style="text-align:center" colspan="2">HEURE</th>
                <th rowspan="2" class="border border-dark bg-grey text-black border-4">{{$seanceorder}}</th>
            </tr>
            <tr>
                <th class="border border-dark bg-grey text-black border-4">JOUR</th>
                <th class="border border-dark bg-grey text-black border-4">GROUPE</th>
            </tr>
            @foreach ($jours as $jour)
                @php
                    $groupesForDay = $groupes->where('Mode_de_formation','CDS');
                    $rowspan = count($groupesForDay);
                @endphp
                <tr>
                    <th rowspan="{{ $rowspan + 1 }}" class="border border-dark bg-grey text-black border-4">{{$jour}}</th>
                    @if ($rowspan > 0)
                        @foreach ($groupesForDay as $index => $groupe)
                            <tr>
                                <td class="s border-end border-start border-top-0 border-dark bg-grey text-black border-4">{{ $groupe->nom_groupe }}</td>
                                @if ($groupe->stage == 'stage')
                                    <td style="text-align: center"><strong>STAGE</strong></td>
                                @else
                                        @php
                                            $seance = $seances->first(function($item) use ($jour, $seanceorder, $groupe) {
                                                return $item->day === $jour && $item->order_seance === $seanceorder && $item->id_groupe == $groupe->id;
                                            });
                                            $modalId_update = $jour.''. $seanceorder . '' .$groupe->id.'_'."update";
                                            $modalId_ajouter = $jour.''. $seanceorder . '' .$groupe->id.'_'."ajouter";
                                        @endphp
                                        @if($seance)
                                            <td class="cellule text-black border border-dark" id="#{{$modalId_update}}" style="background-color: white; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_update}}">
                                                <span>{{ $seance->formateur->name }} {{ $seance->formateur->prenom }}</span> /
                                                {{-- <span>{{ $seance->type_seance }}</span> <br> --}}
                                                <span>{{ $seance->salle->nom_salle }}</span>
                                            </td>
                                        @else
                                            <td class="cellule text-black border border-dark {{ $loop->last && $index === $rowspan - 1 ? 'd' : '' }}" id="#{{$modalId_ajouter}}" style="background-color: white; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_ajouter}}">
                                                <!-- Add content here for adding a new session -->
                                            </td>
                                        @endif
                                    </tr>
                                    <!-- form_qui_ajouter_un_seance -->
                                        <div class="modal fade" id="{{$modalId_ajouter}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{$seanceorder}} {{$jour}} {{$groupe->nom_groupe}}</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('ajouter_seance')}}" method="post">
                                                            @csrf
                                                            <input name="day" type="text" hidden value="{{$jour}}">
                                                            <input name="id_emploi" type="text" hidden value="{{$id_emploi}}">
                                                            <input name="order_seance" type="text" hidden value="{{$seanceorder}}">
                                                            <input name="id_groupe" type="text" hidden value="{{$groupe->id}}">
                                                            <select name="id_formateur" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                                <option value="">Choose a formateur</option>
                                                                    @foreach ($formateurs->where('CDS','oui') as $formateur)
                                                                        @php
                                                                            // Check if the formateur is related to the selected groupe
                                                                            $formateur_related_to_groupe = $formateur->groupes->contains($groupe->id);
                                                                            // Check if the formateur is available for the selected jour and seanceorder
                                                                            $formateur_deja_occupe = $formateur->seance->where('id_emploi', $id_emploi)
                                                                                                                    ->where('day', $jour)
                                                                                                                    ->where('order_seance', $seanceorder)
                                                                                                                    ->isNotEmpty();
                                                                        @endphp
                                                                        @if ($formateur_related_to_groupe && !$formateur_deja_occupe)
                                                                            <option value="{{ $formateur->id }}">{{ $formateur->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                            </select>
                                                            <select name="id_salle" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                                <option selected value="">choisissez la salle</option>
                                                                @foreach($salles as $salle)
                                                                        @php
                                                                            $salle_occupe=$salle->seance->where('id_emploi','==',$id_emploi)->where('day','==',$jour)->where('order_seance','==',$seanceorder);
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
                                                <!-- form qui update un seance-->
                                        @if($seance)
                                            <div class="modal fade" id="{{$modalId_update}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{$seanceorder}}</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{route('modifier_seance_groupe')}}" method="post">
                                                                @csrf
                                                                <input type="text" name="seance_id" value="{{$seance->id}}" hidden>
                                                                <select name="id_formateur" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                                    <option selected value="{{$seance->formateur->id }}">{{$seance->formateur->name}} </option>
                                                                    @foreach ($formateurs->where('CDS','oui') as $formateur)
                                                                        @php
                                                                            // Check if the formateur is related to the selected groupe
                                                                            $formateur_related_to_groupe = $formateur->groupes->contains($groupe->id);
                                                                            // Check if the formateur is available for the selected jour and seanceorder
                                                                            $formateur_deja_occupe = $formateur->seance->where('id_emploi', $id_emploi)
                                                                                                                    ->where('day', $jour)
                                                                                                                    ->where('order_seance', $seanceorder)
                                                                                                                    ->isNotEmpty();
                                                                        @endphp
                                                                        @if ($formateur_related_to_groupe && !$formateur_deja_occupe)
                                                                            <option value="{{ $formateur->id }}">{{ $formateur->name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                                <select name="id_salle" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                                                    <option selected value="{{$seance->salle->id }}">{{ $seance->salle->nom_salle }}</option>
                                                                    @foreach($salles as $salle)
                                                                        @php
                                                                            $salle_occupe=$salle->seance->where('id_emploi','==',$id_emploi)->where('day','==',$jour)->where('order_seance','==',$seanceorder);
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
                                                            <form action="{{route('supprimer_seanceFiliere')}}" method="post">
                                                                @csrf

                                                                <input name="day" type="text"  value="{{ $jour }}" hidden>
                                                                <input name="groupe" type="text"  value="{{ $groupe->id }}" hidden>
                                                                <input name="id_emploi" type="text"  value="{{ $id_emploi }}" hidden>
                                                                <input name="order_seance" type="text"
                                                                    value="{{ $seanceorder }}" hidden>
                                                                <input type="text" name="seance_id" value="{{$seance->id}}" hidden>
                                                                <button type="submit" class="btn btn-danger">supprimer</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                @endif

                        @endforeach
                    @else
                        <td></td>
                    @endif
                </tr>
            @endforeach
        </table>
        <button class="btn btn-success" onclick="ExportToExcel('xlsx')">Export to excel</button>
        @endif
</x-master>

<script>
    function ExportToExcel(type) {
        var elt = document.getElementById('emploiTable');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        XLSX.writeFile(wb, 'CDJ(Filiere).xlsx');

        var elt1 = document.getElementById('emploiTable1');
        var wb1 = XLSX.utils.table_to_book(elt1, { sheet: "sheet1" });
        XLSX.writeFile(wb1, 'CDS(Filiere).xlsx');
    }
</script>
