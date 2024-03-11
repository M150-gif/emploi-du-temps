<x-master title="Formateur">
    <x-settings widthUser="100%" widthFormateur="99%" widthFiliere="100%" widthGroupe="100%" widthSemaine="100%" widthSalle="100%">
        <div class="container">
            <div class="row">
                <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Prenom</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formateurs as $formateur)
                            <tr>
                                <th scope="row">{{$formateur->id}}</th>
                                <td>{{$formateur->name}}</td>
                                <td>{{$formateur->prenom}}</td>
                                <td><button type="button" class="btn btn-success">Active</button></td>
                                <td>
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#updateModal{{$formateur->id}}">Update</button>
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
                <div class="col-md-12 text-center mt-3 "> <!-- Added Bootstrap classes for centering -->
                    <a class="btn btn-success col-md-12 ajouter">Ajouter Formateur</a>
                </div>
            </div>
        </div>
    </x-settings>
</x-master>

<!-- Modal for updating a formateur -->
@foreach ($formateurs as $formateur)
<div class="modal fade" id="updateModal{{$formateur->id}}" tabindex="-1" aria-labelledby="updateModalLabel{{$formateur->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel{{$formateur->id}}">Update Formateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('updateFormateur', $formateur->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name{{$formateur->id}}" class="form-label">Name</label>
                        <input type="text" class="form-control border" style="padding: 5px;" id="name{{$formateur->id}}" name="name" value="{{$formateur->name}}">
                    </div>
                    <div class="mb-3">
                        <label for="prenom{{$formateur->id}}" class="form-label">Prenom</label>
                        <input type="text" class="form-control border" style="padding: 5px;" id="prenom{{$formateur->id}}" name="prenom" value="{{$formateur->prenom}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("a.ajouter").addEventListener("click", function (event) {
            event.preventDefault(); // Prevent the default action of the link
            // Hide the "Ajouter Formateur" button
            this.style.display = "none";

            // Get the parent container
            var container = document.querySelector(".col-md-12.text-center.mt-3");

            // Append the provided HTML code to the parent container
            container.insertAdjacentHTML("afterend", `
                <form action="{{route('addFormateur')}}" method="POST" class="d-inline">
                    @csrf <!-- Include CSRF token for Laravel forms -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control border me-2" style="height: 40px; width: 200px; padding: 5px;" placeholder="Enter name" aria-label="Enter name" aria-describedby="name-addon" name="name">
                        <input type="text" class="form-control border me-2" style="height: 40px; width: 200px; padding: 5px;border-top-left-radius:5px;border-bottom-left-radius:5px" placeholder="Enter prenom" aria-label="Enter prenom" aria-describedby="prenom-addon" name="prenom">
                        <button class="btn btn-success me-2" style="border-top-left-radius:5px;border-bottom-left-radius:5px;" type="submit" id="button-addon2">Ajouter</button>
                        <button class="btn btn-danger" style="border-top-left-radius:5px;border-bottom-left-radius:5px;" type="button" id="cancelButton">Cancel</button>
                    </div>
                </form>
            `);

            // Add event listener to the cancel button
            document.getElementById("cancelButton").addEventListener("click", function () {
                // Show the "Ajouter Formateur" button
                document.querySelector("a.ajouter").style.display = "block";
                // Remove the form
                this.parentNode.parentNode.remove(); // Remove the parent element of the cancel button (i.e., the form)
            });
        });
    });

</script>
