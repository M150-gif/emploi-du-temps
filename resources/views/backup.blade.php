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

    <div style="overflow-x: auto; overflow-y: auto; max-height: 85vh; border-radius: 10px;">
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
                    <select name="selected_type" id="selected_type" class="form-select border border-dark p-2 cursor-pointer" onchange="this.form.submit()">
                        <option value="emploi_formateur" {{ $selectedType === 'emploi_formateur' ? 'selected' : '' }}>Emploi Formateur</option>
                        <option value="emploi_groupe" {{ $selectedType === 'emploi_groupe' ? 'selected' : '' }}>Emploi Groupe</option>
                    </select>
                    <!-- Pass the selected date as a hidden input -->
                    <input type="hidden" name="selected_date" value="{{ $selectedDate }}">
                </form>
            </div>
        </div>

        @if ($selectedType === 'emploi_formateur')
            {{-- Include the content for emploi formateur --}}
            @include('includes.tableFormateurs')
        @else
            {{-- Include the content for emploi groupes --}}
            @include('includes.tableGroupes')
        @endif
    </div>
</x-master>
