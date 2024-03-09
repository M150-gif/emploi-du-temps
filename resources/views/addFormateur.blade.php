<x-master title="Ajouter Formateur">
    <x-settings>
                <div class="container">
                    <div class="row">
                        <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;" class="col-md-12 mt-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Update</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($formateurs as $formateur)
                                    <tr>
                                        <th scope="row">{{$formateur->id}}</th>
                                        <td>{{$formateur->name}}</td>
                                        <td><button type="button" class="btn btn-success">Active</button></td>
                                        <td><a href="{{route('showUpdateFormateur',$formateur->id)}}" type="button" class="btn btn-info">Update</a></td>
                                        <td>
                                            <form action="{{route('deleteFormateur',$formateur->id)}}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button onclick="return confirm('Voulez Vous vraiment Supprimer ce formateur?')" type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 text-center mt-3"> <!-- Added Bootstrap classes for centering -->
                            <form action="{{route('addFormateur')}}" method="POST" class="d-inline">
                                @csrf <!-- Include CSRF token for Laravel forms -->
                                <div class="input-group mb-3">
                                    <input style="border: 1px solid #ccc; border-radius: 5px; height: 40px;" type="text" class="form-control" placeholder="Enter name" aria-label="Enter name" aria-describedby="button-addon2" name="name">
                                    <button class="btn btn-success" style="border-top-left-radius: 8px;border-bottom-left-radius:8px;margin-left:5px" type="submit" id="button-addon2">Ajouter</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
    </x-settings>
</x-master>
