
<div class="modal fade" id="ModalSettings" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> <!-- Adjust modal size as needed -->
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Settings</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <!-- Left Sidebar -->
            <div class="col-md-4">
              <div class="sidebar d-flex justify-content-center align-items-center">
                <!-- Sidebar content on the left -->
                <ul class="list-group">
                  <li class="list-group-item">
                    <button type="button" class="btn btn-dark" name="changerPass"  onclick="showContente('changerPass')">Changer le mot de passe </button>
                  </li>
                  <li class="list-group-item">
                    <button type="button" class="btn btn-dark" name="GererFormarteurs"  onclick="showContente('GererFormarteurs')">Gérer les formateurs</button>
                  </li>
                  <li class="list-group-item">
                    <button type="button" class="btn btn-dark" name="GererGroupes"  onclick="showContente('GererGroupes')">Gérer les groupes</button>
                  </li>
                  <li class="list-group-item">
                    <button type="button" class="btn btn-dark" name="GererSemaines"  onclick="showContente('GererSemaines')">Gérer les semaines</button>
                  </li>

                  <li class="list-group-item">
                    <button type="button" class="btn btn-dark" name="GererSalles"  onclick="showContente('GererSalles')">Gérer les salles</button>
                  </li>
                  <li class="list-group-item">
                    <button type="button" class="btn btn-dark" name="Autre"  onclick="showContente('Autre')">Autre</button>
                  </li>
                  <li class="list-group-item">
                    <button type="button" class="btn btn-danger" name="Reinistialiser"  onclick="showContente('Reinistialiser')">Réinitialiser</button>
                  </li>
                  <!-- Add more buttons or content as needed -->
                </ul>
              </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-8">
                <!-- Main content on the right -->
                {{-- DIVS FOR BUTTONS ON THE SIDEBAR --}}
                 <div id="changerPass-content" class="button-content" style="display: none;">
                    <!-- Content for "Changer le mot de passe" button -->
                    <p>Content for Changer le mot de passe goes here</p>
                </div>
                <div id="GererFormarteurs-content" class="button-content" style="display: none;">
                    <!-- Content for "Changer le mot de passe" button -->
                    <h4>GererFormarteurs</h4>
                    <footer class="footer">
                        <div class="container">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-md-12">
                                    <div class="alert alert-danger text-center" role="alert">
                                        There are 0 formateurs!
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-dark" name="AddFormateur"  onclick="showContente('AddFormateur')">Ajouter formateur</button>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
                <div id="GererGroupes-content" class="button-content" style="display: none;">
                    <!-- Content for "Changer le mot de passe" button -->
                    <p>Content for GererGroupes</p>
                </div>
                <div id="GererSemaines-content" class="button-content" style="display: none;">
                    <!-- Content for "Changer le mot de passe" button -->
                    <p>Content for GererSemaines</p>
                </div>
                <div id="GererSalles-content" class="button-content" style="display: none;">
                    <!-- Content for "Changer le mot de passe" button -->
                    <p>Content for GererSalles</p>
                </div>
                <div id="Autre-content" class="button-content" style="display: none;">
                    <!-- Content for "Gérer les formateurs" button -->
                    <p>Content for Autre</p>
                </div>
                <div id="Reinistialiser-content" class="button-content" style="display: none;">
                    <!-- Content for "Gérer les formateurs" button -->
                    <p>Content for Reinistialiser</p>
                </div>
                <!-- Add more content divs for other buttons -->

                <p id="default-content">Content for Changer le mot de passe goes here</p>
                {{--###### DIVS FOR BUTTONS ON THE SIDEBAR ####### --}}

                {{-- DIVS FOR BUTTONS ON THE CONTENT --}}
                <div id="AddFormateur-content" class="button-content" style="display: none;">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Add Formateur</h5>
                            <form method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control border" id="name" placeholder="Enter name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control border" id="email" placeholder="name@example.com">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control border" id="password" placeholder="Password">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>


                {{--############ DIVS FOR BUTTONS ON THE CONTENT ##########"--}}


            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success">Save changes</button>
        </div>
      </div>
    </div>
  </div>

<script>
    function showContente(buttonName) {
        var content = document.getElementById(buttonName + '-content');
        var allContents = document.querySelectorAll('.button-content');

        allContents.forEach(function(element) {
            element.style.display = 'none';
        });

        content.style.display = 'block';

        // Hide default content
        document.getElementById('default-content').style.display = 'none';
    }
</script>

