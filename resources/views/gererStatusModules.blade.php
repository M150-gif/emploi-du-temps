<x-master title="gerer Modules">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="100%" widthGroupe="100%" widthSemaine="100%" widthSalle="100%" widthModule="99%">
        <div class="container">
            <div class="row">
                <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">nom module</th>
                                    <th scope="col">formateur</th>
                                    {{-- <th scope="col">Masse horaire</th> --}}
                                    {{-- <th scope="col">Formateur</th> --}}
                                    <th scope="col">Status</th>
                                    {{-- <th scope="col">Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($FormateurModules as $formateurModule)
                                    <tr>
                                        <td><strong>{{ $formateurModule->module->nom_module }}</strong></td>
                                        <td>{{ $formateurModule->formateur->name }}</td>
                                        <td>
                                            @if ($formateurModule->status === 'oui')
                                                <form action="{{ route('formateurModule.changeStatus', $formateurModule->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Deactivate</button>
                                                </form>
                                            @else
                                                <form action="{{ route('formateurModule.changeStatus', $formateurModule->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Activate</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>

                </div>

            </div>
        </div>
    </x-settings>
</x-master>
