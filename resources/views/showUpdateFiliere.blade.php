<x-master title="Update Filière">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="99%" widthGroupe="100%" widthSemaine="100%" widthSalle="100%">
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
                                    <td>
                                        @if ($filiere->id == $idFiliere)
                                            <form action="{{route('updateFiliere',$filiere->id)}}" method="POST" id="updateForm{{$filiere->id}}"> {{--{{route('updateSalle', $salle->id)}}--}}
                                            @csrf
                                            @method('PUT')
                                            <input type="text" class="form-control" name="nom_filier" value="{{$filiere->nom_filier}}">
                                        @else
                                            {{$filiere->nom_filier}}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            @if ($filiere->id == $idFiliere)
                                                <button type="submit" class="btn btn-info me-2">Save</button>
                                                </form>
                                            @else
                                                <a href="{{route('showUpdateFiliere', $filiere->id)}}" class="btn btn-info me-2">Update</a>
                                            @endif
                                            <form action="{{route('deleteFiliere',$filiere->id)}}" method="post">{{--{{route('deleteFiliere',$filiere->id)}}--}}
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Add event listener to the document body
        document.body.addEventListener("click", function(event) {
            // Check if the clicked element is not inside any of the update forms
            if (!event.target.closest("form[id^='updateForm']")) {
                // Redirect to the gererFormateur route
                window.location.href = "{{ route('gererFiliere') }}";
            }
        });
    });
</script>
