<x-master title="Update Formateur">
    <x-settings>
        <div class="container">
            <div class="row">
                <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">prenom</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formateurs as $formateur)
                            <tr>
                                <th scope="row">{{$formateur->id}}</th>
                                <td>
                                    @if ($formateur->id == $idFormateur)
                                    <form action="{{route('updateFormateur', $formateur->id)}}" method="POST" id="updateForm{{$formateur->id}}">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" class="form-control" name="name" value="{{$formateur->name}}">
                                    @else
                                    {{$formateur->name}}
                                    @endif
                                </td>
                                <td>
                                    @if ($formateur->id == $idFormateur)
                                        <input type="text" class="form-control" name="prenom" value="{{$formateur->prenom}}" onclick="event.stopPropagation()">
                                    @else
                                    {{$formateur->prenom}}
                                    @endif
                                </td>
                                <td><button type="button" class="btn btn-success">Active</button></td>
                                <td>
                                    <div class="d-flex">
                                        @if ($formateur->id == $idFormateur)
                                            <button type="submit" class="btn btn-info me-2">Save</button>
                                            </form>
                                        @else
                                            <a href="{{route('showUpdateFormateur', $formateur->id)}}" class="btn btn-info me-2">Update</a>
                                        @endif
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
                window.location.href = "{{ route('showGereFormateur') }}";
            }
        });
    });
    
</script>
