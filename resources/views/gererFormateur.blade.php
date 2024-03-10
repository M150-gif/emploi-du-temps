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
                <div class="col-md-12 text-center mt-3 "> <!-- Added Bootstrap classes for centering -->
                    <a class="btn btn-success col-md-12 ajouter">Ajouter Formateur</a>
                </div>
            </div>
        </div>
    </x-settings>
</x-master>

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
        document.getElementById("cancelButton").addEventListener("click", function() {
            // Show the "Ajouter Formateur" button
            document.querySelector("a.ajouter").style.display = "block";
            // Remove the form
            this.parentNode.parentNode.remove(); // Remove the parent element of the cancel button (i.e., the form)
        });
    });
});

</script>
