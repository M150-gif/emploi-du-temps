<x-master title="emplois_groupes">
    @php
        $seances_order = ['s1', 's2', 's3', 's4'];
        $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
    @endphp

    <div style="overflow-x: auto; overflow-y: auto; max-height: 85vh;border-radius:10px">
        <form id="filiereForm" action="{{ route('emploi_filiere') }}" method="get">
            <select id="selectFiliere" name="filiere_id" class="form-select" style="margin-bottom: 10px;"
                onchange="this.form.submit()">
                <option value="">Choose a filiere</option>
                @foreach ($filieres as $filiere)
                    <option value="{{ $filiere->id }}" {{ $filiere->id == $selectedFiliereId ? 'selected' : '' }}>
                        {{ $filiere->nom_filier }}</option>
                @endforeach
            </select>

            <select id="selectNiveau" name="niveau" class="form-select" style="margin-bottom: 10px;"
                onchange="this.form.submit()">
                <option value="">Choose a niveau</option>
                @foreach ($niveaux as $niveau)
                    <option value="{{ $niveau }}" {{ $niveau == $selectedNiveauId ? 'selected' : '' }}>
                        {{ $niveau }}</option>
                @endforeach
            </select>
        </form>
        <style>
            .s {
                border-bottom: 1px solid black !important;
            }

            .d {
                border-bottom: 4px solid #344767 !important;

            }

            tr.cc td:nth-last-child(-n+4) {
                border-left: none !important;
                border-right: none !important;
            }

            .v {
                border-right: 4px solid #344767 !important;
            }

            .no-left-right-border {
                border-left: none !important;
                border-right: none !important;
            }
        </style>
    </div>
    <table id="emploiTable" class="table border border-dark  border-4">
        <tr>
            <th class="text-black  border-4" style="text-align:center" colspan="2">HEURE</th>
            @foreach ($seances_order as $time)
                <th rowspan="2" class="border border-dark bg-grey text-black border-4">{{ $time }}</th>
            @endforeach
        </tr>
        <tr>
            <th class="border border-dark bg-grey text-black border-4">JOUR</th>
            <th class="border border-dark bg-grey text-black border-4">GROUPE</th>
        </tr>
        @foreach ($jours as $jour)
            <tr>
                <th rowspan="{{ count($groupes) + 1 }}" class="border border-dark bg-grey text-black border-4">
                    {{ $jour }}</th>
                @foreach ($groupes as $groupe)
            <tr>
                <td
                    class="s border-end border-start border-top-0 border-dark bg-grey text-black border-4 {{ $loop->last ? 'd' : '' }} groupe-cell">
                    {{ $groupe->nom_groupe }}</td>
                @foreach ($seances_order as $seance_order)
                    @php
                        $seance = $seances->first(function ($item) use ($jour, $seance_order, $groupe) {
                            return $item->day === $jour &&
                                $item->order_seance === $seance_order &&
                                $item->id_groupe == $groupe->id;
                        });
                    @endphp
                    @php
                        $modalId_update = $jour . '_' . $seance_order . '_' . $groupe->id . '_' . 'update';
                        $modalId_ajouter = $jour . '_' . $seance_order . '_' . $groupe->id . '_' . 'ajouter';
                    @endphp
                    @if ($seance)
                        <td class="cellule v text-black border border-dark" id="#{{ $modalId_update }}"
                            style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;"
                            data-bs-toggle="modal" data-bs-target="#{{ $modalId_update }}">
                            <span>{{ $seance->formateur->name }} {{ $seance->formateur->prenom }}</span> /
                            {{-- <span>{{ $seance->type_seance }}</span> <br> --}}
                            <span>{{ $seance->salle->nom_salle }}</span>
                        </td>
                    @else
                        <td class=" v cellule text-black border border-dark   {{ $loop->parent->last ? 'd' : '' }}"
                            id="#{{ $modalId_ajouter }}"
                            style="background-color: {{ $seance ? 'white' : '' }}; text-align:center;"
                            data-bs-toggle="modal" data-bs-target="#{{ $modalId_ajouter }}">
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const main = document.querySelector('.main-content');

        // Check if scroll position is stored in localStorage
        const storedScrollPosition = JSON.parse(localStorage.getItem('scrollPosition'));

        // Scroll to the stored position
        if (storedScrollPosition) {
            main.scrollTo(storedScrollPosition.x, storedScrollPosition.y);
        }

        // Store scroll position when the scroll event occurs
        main.addEventListener('scroll', function() {
            const scrollPosition = {
                x: main.scrollLeft,
                y: main.scrollTop
            };
            localStorage.setItem('scrollPosition', JSON.stringify(scrollPosition));
        });

        // Change group name to "Stage" on hover
        const groupeCells = document.querySelectorAll('.groupe-cell');

        groupeCells.forEach(cell => {
            cell.addEventListener('mouseenter', function() {
                cell.textContent = 'Stage';
                cell.style.backgroundColor = '#007bff'; // Blue background color
                cell.style.color = '#ffffff'; // White text color
                cell.style.fontWeight = 'bold'; // Increased font weight
                cell.classList.add('text-white'); // Add text-info class
            });

            cell.addEventListener('mouseleave', function() {
                cell.textContent = '{{ $groupe->nom_groupe }}';
                cell.style.backgroundColor = ''; // Remove background color
                cell.style.color = ''; // Remove text color
                cell.style.fontWeight = ''; // Remove font weight
                cell.classList.remove('text-white'); // Remove text-info class
            });

            cell.addEventListener('click', function() {
                const prevCell = cell.previousElementSibling; // Get the previous TD
                if (prevCell) {
                    // Create a new span element with the text "Stage"
                    const stageText = document.createElement('span');
                    stageText.textContent = 'Stage';
                    stageText.style.display = 'block';
                    stageText.style.textAlign = 'center';
                    // Clear any existing content in the previous cell
                    prevCell.textContent = '';
                    // Append the new span element to the previous cell
                    prevCell.appendChild(stageText);
                }
                const seanceCells = cell.parentElement.querySelectorAll('.cellule');
                seanceCells.forEach(seanceCell => {
                    seanceCell.classList.toggle('no-left-right-border');
                });
            });
        });
    });
</script>

</x-master>
