<x-master title="Formateur">
    <x-settings widthUser="100%" widthFormateur="100%" widthFiliere="100%" widthGroupe="99%" widthSemaine="100%" widthSalle="100%">
        <style>
            /* Modal Styles */
            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 9999;
            }

            .modal-dialog {
                position: relative;
                top: 50%;
                transform: translateY(-50%);
                max-width: 600px;
                margin: 0 auto;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                height: 70.5vh; /* Set modal height to 60vh */
                overflow-y: auto; /* Add overflow-y to enable scrolling if content exceeds height */
            }

            .modal-header {
                padding: 15px;
                border-bottom: 1px solid #ccc;
                background-color: #f8f9fa;
                border-radius: 8px 8px 0 0;
            }

            .modal-body {
                padding: 20px;
            }

            .modal-title {
                margin: 0;
            }

            .modal-content button {
                width: 100%;
                text-align: center;
            }
        </style>

        <div class="container">
            <div class="row">
                <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Mode formation</th>
                                <th scope="col">Niveau</th>
                                <th scope="col">Filière</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groupes as $groupe)
                                <tr>
                                    <th scope="row">{{ $groupe->id }}</th>
                                    <td>{{ $groupe->nom_groupe }}</td>
                                    <td>{{ $groupe->Mode_de_formation }}</td>
                                    <td>{{ $groupe->Niveau }}</td>
                                    <td>{{ $groupe->filiere->nom_filier }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <button onclick="openUpdateModal({{ $groupe->id }}, '{{ $groupe->nom_groupe }}', '{{ $groupe->Mode_de_formation }}', '{{ $groupe->Niveau }}', {{ $groupe->filiere->id }})" type="button" class="btn btn-info me-2">Update</button>
                                            <form action="{{ route('deleteGroupe') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $groupe->id }}">
                                                <button onclick="return confirm('Voulez Vous vraiment Supprimer ce groupe?')" type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 text-center mt-3">
                    <!-- Button to open modal -->
                    <button id="openModalButton" type="button" class="btn btn-success">
                        Ajouter Groupe
                    </button>
                </div>

                <!-- Modal -->
                <div id="staticBackdrop" class="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Modifier un groupe</h1>
                                <button id="closeModalButton" class="btn-close" aria-label="Close"></button>
                            </div>
                            <form id="modalForm" class="modal-body" action="{{ route('updateGroupe', ['groupe' => $groupe->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" id="updateGroupId" name="id">
                                <div class="mb-3">
                                    <label for="updateNomGroupe" class="form-label">Nom Groupe</label>
                                    <input type="text" name="nom_groupe" class="form-control border" id="updateNomGroupe" aria-describedby="emailHelp" placeholder="Enter le nom du groupe">
                                </div>
                                <div class="mb-3">
                                    <label for="updateModeFormation" class="form-label">Mode de Formation</label>
                                    <input type="text" name="Mode_de_formation" class="form-control border" id="updateModeFormation" aria-describedby="emailHelp" placeholder="Enter le mode de formation">
                                </div>
                                <div class="mb-3">
                                    <label for="updateNiveau" class="form-label">Niveau</label>
                                    <input type="text" name="Niveau" class="form-control border" id="updateNiveau" aria-describedby="emailHelp" placeholder="Enter le niveau">
                                </div>
                                <div class="mb-3">
                                    <label for="updateFiliere" class="form-label">Filière</label>
                                    <select name="filiere_id" class="form-select border" id="updateFiliere" aria-label="Default select example">
                                        <option selected>Choisissez la filière</option>
                                        @foreach($filieres as $filiere)
                                            <option value="{{ $filiere->id }}">{{ $filiere->nom_filier }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-info">Save</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const openModalButton = document.getElementById("openModalButton");
                const closeModalButton = document.getElementById("closeModalButton");
                const modal = document.getElementById("staticBackdrop");

                openModalButton.addEventListener("click", function() {
                    modal.style.display = "block";
                });

                closeModalButton.addEventListener("click", function() {
                    modal.style.display = "none";
                });

                window.addEventListener("click", function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                });
            });

            function openUpdateModal(id, nom_groupe, Mode_de_formation, Niveau, filiere_id) {
                document.getElementById('updateGroupId').value = id;
                document.getElementById('updateNomGroupe').value = nom_groupe;
                document.getElementById('updateModeFormation').value = Mode_de_formation;
                document.getElementById('updateNiveau').value = Niveau;
                document.getElementById('updateFiliere').value = filiere_id;
                document.getElementById('staticBackdrop').style.display = "block";
            }
        </script>
    </x-settings>
</x-master>
