<x-master title="Assign Modules to Formateur">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="100%" widthGroupe="100%" widthSemaine="100%" widthSalle="100%" widthFM="99%">

        <div class="container">
            <div>
                <button onclick="showModulesGroupesForm()">Modules to Groupe</button>
                <button onclick="showFormateurGroupesForm()">Groupes to Formateur</button>
                <button onclick="showFormateurModulesForm()">Modules Formateur</button>
            </div>


            <div id="formateurGroupesForm" style="display: none;">
                <!-- Your Formateur Groupes Form Here -->
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="card mt-5">
                            <div class="card-body">
                                <h5 class="card-title">Groupes to Formateur</h5>
                                <form action="{{route('assignGroupes')}}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="formateur" class="form-label">Select Formateur</label>
                                        <select class="form-select" id="formateur" name="formateur_id">
                                            <option value="">Select a Formateur</option>
                                            @foreach($formateurs as $formateur)
                                                <option value="{{ $formateur->id }}">{{ $formateur->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="d-flex">
                                        <div class="mb-3 mx-auto" style="width: 150px;">
                                            <label for="filiere" class="form-label">Select Filière</label>
                                            <select class="form-select" name="filiere" id="filiere">
                                                <option value="">Select a Filiere</option>
                                                @foreach ($filieres as $filiere)
                                                    <option value="{{$filiere->id}}">{{$filiere->nom_filier}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 mx-auto" style="width: 150px;">
                                            <label for="niveau" class="form-label">Select Niveau</label>
                                            <select class="form-select" name="niveau" id="niveau">
                                                <option value="">Select a Niveau</option>
                                                @foreach ($niveaux as $niveau)
                                                    <option value="{{$niveau}}">{{$niveau}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Select Groupes</label><br>
                                        <div id="groupes-checkboxes">
                                            <!-- Checkboxes will be dynamically populated based on the selected filiere -->
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    var groupesData = @json($groupes);

                    // Function to update groupes based on filiere and niveau
                    function updateGroupes() {
                        var filiereId = document.getElementById('filiere').value;
                        var niveau = document.getElementById('niveau').value;
                        var groupesCheckboxes = document.getElementById('groupes-checkboxes');
                        groupesCheckboxes.innerHTML = ''; // Clear existing checkboxes

                        // Filter groupes based on the selected filiere and/or niveau
                        var filteredGroupes;
                        if (filiereId && niveau) {
                            // If both filiere and niveau are selected
                            filteredGroupes = groupesData.filter(function(groupe) {
                                return groupe.filiere_id == filiereId && groupe.Niveau == niveau;
                            });
                        } else if (filiereId) {
                            // If only filiere is selected
                            filteredGroupes = groupesData.filter(function(groupe) {
                                return groupe.filiere_id == filiereId;
                            });
                        } else if (niveau) {
                            // If only niveau is selected
                            filteredGroupes = groupesData.filter(function(groupe) {
                                return groupe.Niveau == niveau;
                            });
                        } else {
                            // If neither filiere nor niveau is selected
                            filteredGroupes = [];
                        }

                        // Populate the groupes checkboxes
                        filteredGroupes.forEach(function(groupe) {
                            var checkboxDiv = document.createElement('div');
                            checkboxDiv.classList.add('form-check', 'form-check-inline');

                            var checkbox = document.createElement('input');
                            checkbox.classList.add('form-check-input');
                            checkbox.type = 'checkbox';
                            checkbox.name = 'groupes[]';
                            checkbox.value = groupe.id;
                            checkbox.id = 'groupe' + groupe.id;

                            var label = document.createElement('label');
                            label.classList.add('form-check-label');
                            label.setAttribute('for', 'groupe' + groupe.id);
                            label.textContent = groupe.nom_groupe;

                            checkboxDiv.appendChild(checkbox);
                            checkboxDiv.appendChild(label);
                            groupesCheckboxes.appendChild(checkboxDiv);
                        });
                    }

                    // Add event listeners to both filiere and niveau dropdowns
                    document.getElementById('filiere').addEventListener('change', updateGroupes);
                    document.getElementById('niveau').addEventListener('change', updateGroupes);

                    // Initial population of groupes based on filiere and niveau
                    updateGroupes();
                </script>
            </div>

            <div id="modulesGroupesForm" style="display: none;">
                <!-- Your Modules Groupes Form Here -->
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="card mt-5">
                            <div class="card-body text-center"> <!-- Added text-center class -->
                                <h5 class="card-title">Modules to Groupe</h5>
                                <form action="{{route('assignGroupesModules')}}" method="POST">
                                    @csrf
                                    <div class="d-flex justify-content-center"> <!-- Added justify-content-center class -->
                                        <div class="mb-3 mx-auto" style="width: 150px;">
                                            <label for="filiereGroupe" class="form-label">Select Filière</label>
                                            <select class="form-select" name="filiereGroupe" id="filiereGroupe">
                                                <option value="">Select a Filiere</option>
                                                @foreach ($filieres as $filiere)
                                                    <option value="{{$filiere->id}}">{{$filiere->nom_filier}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 mx-auto" style="width: 150px;">
                                            <label for="NiveauGroupe" class="form-label">Select Niveau</label>
                                            <select class="form-select" name="NiveauGroupe" id="NiveauGroupe">
                                                <option value="">Select a Niveau</option>
                                                @foreach ($niveaux as $niveau)
                                                    <option value="{{$niveau}}">{{$niveau}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 mx-auto" style="width: 150px;">
                                            <label for="groupeModule" class="form-label">Select Groupe</label>
                                            <select class="form-select" name="groupeModule" id="groupeModule">
                                                <option value="">Select a Groupe</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-check form-check-inline mb-3" style="width: 500px;">
                                        @foreach ($modules as $module)
                                            <input name="moduleGroupe[]" class="form-check-input" type="checkbox" id="inlineCheckbox{{$module->id}}" value="{{$module->id}}">
                                            <label class="form-check-label" for="inlineCheckbox{{$module->id}}">{{$module->nom_module}}</label>
                                        @endforeach

                                    </div>
                                    <br>

                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    var groupesData = {!! json_encode($groupes) !!};

                    function updateGroupes() {
                        var filiereId = document.getElementById('filiereGroupe').value;
                        var niveau = document.getElementById('NiveauGroupe').value;
                        var groupeSelect = document.getElementById('groupeModule');

                        // Clear existing options
                        groupeSelect.innerHTML = '<option value="">Select a Groupe</option>';

                        // Filter groupes based on filiere and/or niveau
                        var filteredGroupes = groupesData.filter(function(groupe) {
                            return (!filiereId || groupe.filiere_id == filiereId) && (!niveau || groupe.Niveau == niveau);
                        });

                        // Populate the groupe select options
                        filteredGroupes.forEach(function(groupe) {
                            var option = document.createElement('option');
                            option.value = groupe.id;
                            option.textContent = groupe.nom_groupe;
                            groupeSelect.appendChild(option);
                        });
                    }

                    document.getElementById('filiereGroupe').addEventListener('change', updateGroupes);
                    document.getElementById('NiveauGroupe').addEventListener('change', updateGroupes);

                    // Initial population of groupes based on filiere and niveau
                    updateGroupes();
                </script>
            </div>

            <div id="formateurModulesForm" style="display: none">


                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 offset-md-1">
                                    <div class="card ">
                                        <div class="card-body">
                                            <h5 class="card-title">Modules to Formateur</h5>
                                            <form action="{{route('assignModules')}}" method="POST">

                                                @csrf
                                                <div class="mb-3">
                                                    <label for="formateur" class="form-label">Select Formateur</label>
                                                    <select class="form-select" id="formateur" name="formateur_id">
                                                        @foreach($formateurs as $formateur)
                                                            <option value="{{ $formateur->id }}">{{ $formateur->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="filiereA" class="form-label">Select Filiere</label>
                                                    <select class="form-select" id="filiereA" name="filiere">
                                                        <option value="">Select a filiere</option>
                                                        @foreach($filieres as $filiere)
                                                            <option value="{{ $filiere->id }}">{{ $filiere->nom_filier }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="niveauA" class="form-label">Select Niveau</label>
                                                    <select class="form-select" id="niveauA" name="niveau">
                                                        <option value="">Select a Niveau</option>
                                                        @foreach($niveaux as $niveau)
                                                            <option value="{{ $niveau }}">{{ $niveau }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="groupeA" class="form-label">Select Groupe</label>
                                                    <select class="form-select" id="groupeA" name="groupe">
                                                    </select>
                                                </div>
                                                <div class="mb-3" id="modules-container">
                                                    <label class="form-label">Select Modules</label><br>
                                                    @foreach($modules as $module)
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="moduleA{{ $module->id }}" name="modules[]" value="{{ $module->id }}">
                                                            <label class="form-check-label" for="module{{ $module->id }}">{{ $module->nom_module }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button type="submit" class="btn btn-success">Enregistrer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>


                <script>
                    var groupesData = {!! json_encode($groupes) !!};

                    function updateGroupes() {
                        var filiereId = document.getElementById('filiereA').value;
                        var niveau = document.getElementById('niveauA').value;
                        var groupeSelect = document.getElementById('groupeA');

                        // Clear existing options
                        groupeSelect.innerHTML = '<option value="">Select a Groupe</option>';

                        // Filter groupes based on filiere and/or niveau
                        var filteredGroupes = groupesData.filter(function(groupe) {
                            return (!filiereId || groupe.filiere_id == filiereId) && (!niveau || groupe.Niveau == niveau);
                        });

                        // Populate the groupe select options
                        filteredGroupes.forEach(function(groupe) {
                            var option = document.createElement('option');
                            option.value = groupe.id;
                            option.textContent = groupe.nom_groupe;
                            groupeSelect.appendChild(option);
                        });
                    }

                    document.getElementById('filiereA').addEventListener('change', updateGroupes);
                    document.getElementById('niveauA').addEventListener('change', updateGroupes);

                    // Initial population of groupes based on filiere and niveau
                    updateGroupes();
                    document.getElementById('groupeA').addEventListener('change', function() {
                    var groupeId = this.value;
                    var modulesContainer = document.getElementById('modules-container');

                    // Clear existing modules
                    modulesContainer.innerHTML = '';

                    if (groupeId) {
                        // Fetch modules for the selected groupe using AJAX
                        fetch('/get-modules/' + groupeId)
                            .then(response => response.json())
                            .then(data => {
                                data.forEach(function(module) {
                                    var moduleLabel = document.createElement('label');
                                    moduleLabel.textContent = module.module.nom_module; // Set the module name

                                    var moduleInput = document.createElement('input');
                                    moduleInput.type = 'checkbox';
                                    moduleInput.name = 'modules[]';
                                    moduleInput.value = module.module.id;

                                    var moduleDiv = document.createElement('div');
                                    moduleDiv.classList.add('form-check', 'form-check-inline');
                                    moduleDiv.appendChild(moduleInput);
                                    moduleDiv.appendChild(moduleLabel);

                                    modulesContainer.appendChild(moduleDiv);
                                });
                            });
                    } else {
                        // Fetch all modules if no groupe is selected
                        fetch('/get-all-modules')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                            .then(data => {
                                data.forEach(function(module) {
                                    var moduleLabel = document.createElement('label');
                                    moduleLabel.textContent = module.nom_module; // Set the module name

                                    var moduleInput = document.createElement('input');
                                    moduleInput.type = 'checkbox';
                                    moduleInput.name = 'modules[]';
                                    moduleInput.value = module.id;

                                    var moduleDiv = document.createElement('div');
                                    moduleDiv.classList.add('form-check', 'form-check-inline');
                                    moduleDiv.appendChild(moduleInput);
                                    moduleDiv.appendChild(moduleLabel);

                                    modulesContainer.appendChild(moduleDiv);
                                });
                            });
                    }
                });
                </script>
            </div>
        </div>
    </x-settings>
</x-master>

<script>
    var modulesGroupesFormVisible = false;
    var formateurGroupesFormVisible = false;
    var formateurModulesFormVisible = false;

    function showModulesGroupesForm() {
        if (!modulesGroupesFormVisible) {
            document.getElementById("modulesGroupesForm").style.display = "block";
            document.getElementById("formateurGroupesForm").style.display = "none";
            document.getElementById("formateurModulesForm").style.display = "none";
            modulesGroupesFormVisible = true;
            formateurGroupesFormVisible = false;
            formateurModulesFormVisible = false;
        }
    }

    function showFormateurGroupesForm() {
        if (!formateurGroupesFormVisible) {
            document.getElementById("modulesGroupesForm").style.display = "none";
            document.getElementById("formateurGroupesForm").style.display = "block";
            document.getElementById("formateurModulesForm").style.display = "none";
            modulesGroupesFormVisible = false;
            formateurGroupesFormVisible = true;
            formateurModulesFormVisible = false;
        }
    }

    function showFormateurModulesForm() {
        if (!formateurModulesFormVisible) {
            document.getElementById("modulesGroupesForm").style.display = "none";
            document.getElementById("formateurGroupesForm").style.display = "none";
            document.getElementById("formateurModulesForm").style.display = "block";
            modulesGroupesFormVisible = false;
            formateurGroupesFormVisible = false;
            formateurModulesFormVisible = true;
        }
    }
</script>
