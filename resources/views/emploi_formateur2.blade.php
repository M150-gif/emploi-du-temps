@php
$jours=['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
$part_of_day=['Matin','A.Midi'];
$seances_order=['s1','s2','s3','s4'];
@endphp
<style>
    td{
        cursor: pointer;
    }
</style>
<x-master title="emplois_formateurs">
    <select id="formateurSelect" class="form-select mb-3 fs-6 text-black font-weight-bold" aria-label="Default select example">
        <option value="">Choisissez un formateur</option>
        @foreach($formateurs as $formateur)
        <option value="{{$formateur->id}}" {{ $selectedFormateur && $selectedFormateur->id == $formateur->id ? 'selected' : '' }}>
            {{$formateur->name}}
        </option>
        @endforeach
    </select>
    <div style="overflow-x: auto; overflow-y: auto; max-height: 85vh">
        <!-- Display the selected formateur's row -->
        <table class="table border border-info">
            <thead>
                <tr>
                    <th colspan="24" class=" border-info text-black text-center"><span class="fs-6 text-black" style="--bs-text-opacity: .5;">Le Nom : </span></th>
                </tr>
                <tr>
                    {{-- <th rowspan="3" class="border border-info bg-grey text-black">Formateur</th> --}}
                    @foreach($jours as $jour)
                    <th colspan="4" class="border border-info text-black">{{$jour}}</th>
                    @endforeach
                </tr>
                <tr>
                    @foreach ($jours as $jour)
                        @foreach($part_of_day as $part)
                        <th colspan="2" class="border border-info text-black">{{$part}}</th>
                        @endforeach
                    @endforeach
                </tr>
                <tr>
                    @foreach ($jours as $jour)
                        <th class="border border-info text-black">s1</th>
                        <th class="border border-info text-black">s2</th>
                        <th class="border border-info text-black">s3</th>
                        <th class="border border-info text-black">s4</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            <tr class="formateur_data">
                <td class="sppiner">
                </td>
                </tr>
            </tbody>
        </table>
    </div>
</x-master>
<script>
  function afficher_seances(data) {
  const jours = ['lundi', 'mardi', 'mercredi', 'jeudi','vendredi','samedi'];
  const seances_order = ['s1', 's2', 's3', 's4'];
  let tr = `<td class="border border-info">${data.selectedFormateur.name} ${data.selectedFormateur.prenom}</td>`;
  jours.forEach(jour => {
      seances_order.forEach(seance_order => {
          let seance = data.seances.find(item => item.day == jour && item.order_seance == seance_order);
          const modalId_update = `update_${jour}_${seance_order}`;
          const modalId_ajouter = `ajouter_${jour}_${seance_order}`;
          if (seance) {
              tr +=`<td class="border border-info" data-toggle="modal" data-target="#${modalId_update}" >
             <span>${seance.type_seance}</span><br>
             <span>${seance.groupe.nom_groupe}</span><br>
             <span>${seance.salle.nom_salle}</span><br></td>
<!-- Modal -->
<div class="modal fade" id="${modalId_update}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h1>${seance_order}</h1>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>`
} else {
    tr +=`<td class="border border-info" data-toggle="modal" data-target="#${modalId_ajouter}" >
    <span></span><br>
</td>
<!-- Modal -->
<div class="modal fade" id="${modalId_ajouter}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h1>no seance</h1>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>`
}
});
  });
return tr;
}
</script>
<script>
    const formateur_data=document.querySelector('.formateur_data')
    const loading=`<div class="spinner-border text-info" role="status">
                </div>`;
    const sppiner=document.querySelector('.sppiner');
    // JavaScript to handle formateur selection
    document.getElementById('formateurSelect').addEventListener('change', function() {
        sppiner.innerHTML=loading;
        const formateurId = this.value;
      const url = "{{ route('api_get_emplois_formateur') }}";
      const apiurl=`${url}?formateurId=${formateurId}`
        if (formateurId !== ''){
            new Promise((resolve, reject) => {
           fetch(`${apiurl}`,{
            headers:{
            'Content-Type': 'application/json',
            }
           })
           .then((response)=>{
            if (!response.ok) {
              throw new Error('Network response was not ok');
                }
              return response.json();
           })
           .then((data)=>{
                resolve(data)
                console.log(data)
           }).catch((error)=>{
             alert(error)
            })
        }).then((data)=>{
            // formateur_data.innerHTML=afficher_seances(data);
            // afficher_seances(data)
        })}

    });
</script>
