<x-master title="Assign Modules to Formateur">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="100%" widthGroupe="100%" widthSemaine="100%" widthSalle="100%" widthFM="99%">

        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card mt-5">
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
                                    <label class="form-label">Select Modules</label><br>
                                    @foreach($modules as $module)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="module{{ $module->id }}" name="modules[]" value="{{ $module->id }}">
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

    </x-settings>
</x-master>
