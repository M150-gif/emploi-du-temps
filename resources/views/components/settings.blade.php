<div class="container" style="background-color: white; border-radius: 13px">
    <div class="row p-3">
        <!-- Sidebar -->
        <div class="col-md-4">
            <div class="sidebar d-flex justify-content-center align-items-center">
                <!-- Sidebar content on the left -->
                <ul class="list-group border-0">
                    <li class="list-group-item border-0">
                        <a href="{{route('gererUser')}}"  type="button" class="btn btn-dark" name="changerPass"  style="width: 100%;">Changer le mot de passe</a>
                    </li>
                    <li class="list-group-item border-0">
                        <a href="{{route('showGereFormateur')}}" type="button" class="btn btn-dark" name="GererFormarteurs"  style="width: 100%;">Gérer les formateurs</a>
                    </li>
                    <li class="list-group-item border-0">
                        <a href="{{route('gererFiliere')}}" type="button" class="btn btn-dark" name="GererFormarteurs"  style="width: 100%;">Gérer les filères</a>
                    </li>
                    <li class="list-group-item border-0">
                        <a  type="button" class="btn btn-dark" name="GererGroupes" style="width: 100%;">Gérer les groupes</a>
                    </li>
                    <li class="list-group-item border-0">
                        <button type="button" class="btn btn-dark" name="GererSemaines" style="width: 100%;">Gérer les semaines</button>
                    </li>
                    <li class="list-group-item border-0">
                        <a href="{{route('gererSalle')}}" type="button" class="btn btn-dark" name="GererSalles"  style="width: 100%;">Gérer les salles</a>
                    </li>
                    <li class="list-group-item border-0">
                        <button type="button" class="btn btn-dark" name="Autre"  style="width: 100%;">Autre</button>
                    </li>
                    <li class="list-group-item border-0">
                        <button type="button" class="btn btn-danger" name="Reinistialiser" style="width: 100%;">Réinitialiser</button>
                    </li>
                    <!-- Add more buttons or content as needed -->
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-8">
            <!-- Main content on the right -->
            <div class="d-flex" style="height: 70vh;">
                {{$slot}}
            </div>
        </div>
    </div>
</div>

