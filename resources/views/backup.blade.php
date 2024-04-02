<x-master title="emplois_formateurs">
    <style>
        /* Custom styles for the table */
        .custom-table {
            color: black;
        }

        .custom-table th,
        .custom-table td {
            border: 1px solid black;
            color: black;
        }
    </style>

        <div class="row">
            <div class="col-md-6">
                <form id="dateForm" action="{{ route('backup') }}" method="get" class="mb-3">
                    <label for="selected_date" class="form-label">Select Date:</label>
                    <select name="selected_date" id="selected_date" class="form-select border border-dark p-2 cursor-pointer" onchange="this.form.submit()" >
                        @foreach ($emplois as $emploi)
                            <option  value="{{ $emploi->date_debu }}" {{ $selectedDate === $emploi->date_debu ? 'selected' : '' }}>
                                {{ $emploi->date_debu }}
                            </option>
                        @endforeach
                    </select>
                    <!-- Add hidden input to hold the selectedType value -->
                    <input type="hidden" name="selected_type" value="{{ $selectedType }}">
                </form>
            </div>

            <div class="col-md-6">
                <form id="typeForm" action="{{ route('backup') }}" method="GET">
                    <label for="selected_type" class="form-label">Select Type:</label>
                    <select name="selected_type" id="selected_type" class="form-select border border-dark p-2 cursor-pointer pr-1" onchange="this.form.submit()">
                        <option value="emploi_formateur" {{ $selectedType === 'emploi_formateur' ? 'selected' : '' }}>Emploi Formateur</option>
                        <option value="emploi_groupe" {{ $selectedType === 'emploi_groupe' ? 'selected' : '' }}>Emploi Groupe</option>
                    </select>
                    <!-- Pass the selected date as a hidden input -->
                    <input type="hidden" name="selected_date" value="{{ $selectedDate }}">
                </form>
            </div>
        </div>
        <div style="overflow-x: auto; overflow-y: auto; max-height: 85vh;">

            @if ($selectedType === 'emploi_formateur')
            {{-- Include the content for emploi formateur --}}
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
        <table class="table border border-info ">
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
                            @endforeach
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

            @else
            {{-- Include the content for emploi groupes --}}
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
                                @endforeach
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @endif
        </div>
</x-master>
