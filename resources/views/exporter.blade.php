<x-master title="expoter">
    <style>
        /* .box{
            width: 400px;
        } */
    </style>
<div class="container">
<div class="header text-center">
    <h3 class=" text-info">Sélectionnez l'emploi souhaité</h3>
    <input class="w-25" type="date" name="date">
</div>
<hr class="my-4 bg-black">
<div class="row mb-3">


  <div class="p-2 col-6">
    <p class="m-0 p-0 text-info fw-bold">type d'emploi :</p>
    <div class="box checkboxes row  border p-3 h-75">
        <div class="formateurs col-6 p-0 m-0">
        <input type="checkbox" name="formateurs" id="formateurs">
        <label for="formateurs"  class="text-black fs-6 fw-bold">formateurs</label>
        </div>
        <div class="Groupes col-6 p-0 m-0">
        <input type="checkbox" name="Groupes" id="Groupes">
        <label for="Groupes" class="text-black fs-6 fw-bold">Groupes</label>
        </div>
        <div class="par-Groupe col p-0 m-0">
        <input type="checkbox" name="par-Groupe" id="par-Groupe">
        <label for="par-Groupe"  class="text-black fs-6 fw-bold">par Groupe</label>
        </div>
        <div class="par-formateur col p-0 m-0">
        <input type="checkbox" name="par-formateur" id="par-formateur">
        <label for="par-formateur"  class="text-black fs-6 fw-bold">par-formateur</label>
        </div>
    </div>
  </div>



  <div class="p-2 col-6">
    <p class="m-0 p-0 text-info fw-bold">Formateurs :</p>
    <div class="box border h-75 text-center">
        <select name="formateur" class="mt-4 p-2" >
            <option value="">choisir un formateur</option>
        </select>
    </div>
  </div>

  <div class="p-2 col-6">
    <p class="m-0 p-0 text-info fw-bold">Groupes :</p>
    <div class="box border h-75 text-center p-3">
        <select name="groupe" class="mt-2 p-2" >
            <option value="">choisir un groupe</option>
        </select>
    </div>
  </div>

    <div class="p-2 col-6">
    <p class="m-0 p-0 text-info fw-bold invisible">Groupes :</p>
    <div class="box  h-75 text-center p-3 ">
        <button class="btn border border-dark text-black me-3">confirmer</button>
            <button class="btn btn-success">Expoter</button>
    </div>
  </div>
  {{-- <div class="p-2 col-6 border mt-5 ">
    <div class="row h-100">
        <div>
            <button class="btn">confirmer</button>
            <button class="btn">Expoter</button>
        </div>
    </div>
  </div> --}}


</div>
</div>

</x-master>
