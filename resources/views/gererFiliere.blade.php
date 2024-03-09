<x-master title="Filière">
    <x-settings>
        <div class="container">
            <div class="row">
                <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filieres as $filiere)
                                <tr>
                                    <th scope="row">{{$filiere->id}}</th>
                                    <td>{{$filiere->nom_filier}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{route('showUpdateFiliere',$filiere->id)}}" class="btn btn-info me-2">Update</a>{{--{{route('showUpdateFiliere',$filliere->id)}}--}}
                                            <form action="{{route('deleteFiliere',$filiere->id)}}" method="post">{{--{{route('deleteFiliere',$filliere->id)}}--}}
                                                @method('DELETE')
                                                @csrf
                                                <button onclick="return confirm('Voulez-vous vraiment supprimer cette filière?')" type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="col-md-12 text-center mt-3"> <!-- Added Bootstrap classes for centering -->
                    <a href="{{route('showAddFiliere')}}" class="btn btn-success">Ajouter Filière</a> {{--{{route('showAddSalle')}}--}}
                </div>
            </div>
        </div>
    </x-settings>
</x-master>
