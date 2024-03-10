<x-master title="emplois_formateurs">
   <div class="container">
  <button class="btn btn-primary dropdown-toggle w-50 mx-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    choisir une emploi 
  </button>
  <ul class="dropdown-menu w-100 h-50">
    @foreach($emplois as $emploi)
        <li><a class="dropdown-item" href="{{ route('afficher_emploi_par_id',['id_emploi' => $emploi->id])}}">date_debu:{{$emploi->date_debu}} | date_fin:{{$emploi->date_fin}}</a></li>
    @endforeach
  </ul>
   </div>
</x-master>
