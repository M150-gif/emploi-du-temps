<x-master title="Salle">
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
                                @foreach ($salles as $salle)
                                <tr>
                                    <th scope="row">{{$salle->id}}</th>
                                    <td>{{$salle->nom_salle}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{route('showUpdateSalle',$salle->id)}}" class="btn btn-info me-2">Update</a>
                                            <form action="{{route('deleteSalle',$salle->id)}}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button onclick="return confirm('Voulez-vous vraiment supprimer cette salle?')" type="submit" class="btn btn-danger">Delete</button>
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
                    <a href="{{route('showAddSalle')}}" class="btn btn-success">Ajouter Salle</a> {{--{{route('showAddSalle')}}--}}
                </div>
            </div>
        </div>
    </x-settings>
</x-master>
