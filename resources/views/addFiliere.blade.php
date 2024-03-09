<x-master title="Ajouter Salle">
    <x-settings>
                <div class="container">
                    <div class="row">
                        <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;" class="col-md-12 mt-3">
                            <div class="table-responsive">
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
                                                        <a href="{{route('showUpdateFiliere',$filiere->id)}}" class="btn btn-info me-2">Update</a>{{--{{route('showUpdateSalle',$filiere->id)}}--}}
                                                        <form action="{{route('deleteFiliere',$filiere->id)}}" method="post">{{--{{route('deleteSalle',$filiere->id)}}--}}
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



                        </div>
                        <div class="col-md-12 text-center mt-3"> <!-- Added Bootstrap classes for centering -->
                            <form action="{{route('addFiliere')}}" method="POST" class="d-inline">
                                @csrf <!-- Include CSRF token for Laravel forms -->
                                <div class="input-group mb-3">
                                    <input style="border: 1px solid #ccc; border-radius: 5px; height: 40px;" type="text" class="form-control" placeholder="Enter nom de filière" aria-label="Enter nom de filière" aria-describedby="button-addon2" name="nom_filier">
                                    <button class="btn btn-success" style="border-top-left-radius: 8px;border-bottom-left-radius:8px;margin-left:5px" type="submit" id="button-addon2">Ajouter</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
    </x-settings>
</x-master>
