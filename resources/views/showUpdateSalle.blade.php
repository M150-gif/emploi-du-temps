<x-master title="Update Salle">
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
                                    <td>
                                        @if ($salle->id == $idSalle)
                                            <form action="{{route('updateSalle',$salle->id)}}" method="POST" id="updateForm{{$salle->id}}"> {{--{{route('updateSalle', $salle->id)}}--}}
                                            @csrf
                                            @method('PUT')
                                            <input type="text" class="form-control" name="nom_salle" value="{{$salle->nom_salle}}">
                                        @else
                                            {{$salle->nom_salle}}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            @if ($salle->id == $idSalle)
                                                <button type="submit" class="btn btn-info me-2">Save</button>
                                                </form>
                                            @else
                                                <a href="{{route('showUpdateSalle', $salle->id)}}" class="btn btn-info me-2">Update</a>
                                            @endif
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Add event listener to the document body
        document.body.addEventListener("click", function(event) {
            // Check if the clicked element is not inside any of the update forms
            if (!event.target.closest("form[id^='updateForm']")) {
                // Redirect to the gererFormateur route
                window.location.href = "{{ route('gererSalle') }}";
            }
        });
    });
</script>
