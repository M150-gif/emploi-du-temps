<x-master title="Formateur">
    <x-settings>
        <div class="container">
            <div class="row">
                <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formateurs as $formateur)
                            <tr>
                                <th scope="row">{{$formateur->id}}</th>
                                <td>{{$formateur->name}}</td>
                                <td><button type="button" class="btn btn-success">Active</button></td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{route('showUpdateFormateur',$formateur->id)}}" type="button" class="btn btn-info me-2">Update</a>
                                        <form action="{{route('deleteFormateur',$formateur->id)}}" method="post">
                                        @method('DELETE')
                                        @csrf
                                            <button onclick="return confirm('Voulez Vous vraiment Supprimer ce formateur?')" type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 text-center mt-3"> <!-- Added Bootstrap classes for centering -->
                    <a href="{{route('showAddFormateur')}}" class="btn btn-success">Ajouter Formateur</a>
                </div>
            </div>
        </div>
    </x-settings>
</x-master>
