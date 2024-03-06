<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
    <link href="{{asset('css/emploi.css')}}" rel="stylesheet">
    <title>Document</title>
    <?php 
        $jours=['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
        $part_of_day=['matin','apres midi'];
        $seances=['s1','s2','s3','s4'];
    ?>
</head>
<body>
<form  id="form1" class="container-sm w-50 mb-2">
    @csrf
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">date debu</label>
    <input id="date_debu" type="date" name="date_debu" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off">
    <div id="emailHelp" class="form-text"></div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">date fin</label>
    <input id="date_fin" style="pointer-events: none;" type="date" name="date_fin" class="form-control" id="exampleInputPassword1"autocomplete="off">
  </div>
  <button type="submit"  class="btn btn-primary d-block mx-auto">creer emploi</button>
</form>
       <table class="table table-bordered table-bordered-dark t-center">
        <thead>
            <tr>
                <th rowspan="3">Formateur</th>
                 @foreach($jours as $jour)
                 <th colspan="4">{{$jour}}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($jours as $jour)
                    <th colspan="2">Matin </th>
                    <th colspan="2">soire</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($jours as $jour)
                    <th>s1 </th>
                    <th>s2</th>
                    <th>s3</th>
                    <th>s4</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($formateurs as $formateur)
                <tr>
                    <td>{{ $formateur->name }} {{ $formateur->prenom }}</td>
                    @foreach ($jours as $jour)
                            @foreach ($seances as $seance)
                            @php
                                $modalId = $jour.'_'. $seance . '_' .$formateur->id   ;
                            @endphp
                                <td  class="cellule" id="#{{$modalId}}" data-bs-toggle="modal" data-bs-target="#{{$modalId}}">
                         </td>
                         <div class="modal fade" id="{{$modalId}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">seance 1</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                             {{$modalId}}
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-primary">Save</button>
                            </div>
                          </div>
                        </div>
                     </div>    
                        @endforeach
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
     const cellules=document.querySelectorAll('.cellule')
     const btn_closes=document.querySelectorAll('.btn-close')
     const modals = document.querySelectorAll('.modal');
     const date_debu_form=document.getElementById('date_debu')
     const date_fin_form=document.getElementById('date_fin')
     const form1=document.getElementById('form1')
     const emailHelp=document.getElementById('emailHelp')
     date_debu_form.addEventListener("input",()=>{
        const dateDebu = new Date(date_debu_form.value);
            const day=dateDebu.getDay();
            if(day!==1){
                emailHelp.innerText="le jour doit etre lundi"
            }else{
                emailHelp.innerText=""
                const date_fin=new Date(date_debu_form.value);
                date_fin.setDate(date_fin.getDate() + 6)
                const date_fin_pre=date_fin.toISOString().slice(0,10);
                const date_debu_pre=dateDebu.toISOString().slice(0,10);
                date_fin_form.value=date_fin_pre;
                console.log(date_fin_pre,date_debu_pre)}
     })
     form1.onsubmit=(e)=>{
        e.preventDefault()
        if(date_debu.value==""){
            emailHelp.innerText="la date debu est oblige!"
        }else{
            const dateDebu = new Date(date_debu_form.value);
            const day=dateDebu.getDay();
            if(day!==1){
                emailHelp.innerText="le jour doit etre lundi"
            }else{
                emailHelp.innerText=""
                   fetch(`{{route('ajouter_emploi')}}`,{method:"POST"
                           ,headers:{
                               'content-Type':'application/json',
                               'X-CSRF-TOKEN':document.querySelector('[name="_token"]').value
                           }
                       ,body:JSON.stringify({date_debu:date_debu_form.value,date_fin:date_fin_form.value})}).then((response)=>{
                       if(response.ok){
                           return response.json()
                       }else{
                           throw new Error("something is wrong");
                       }
                   }).then((data)=>{
                       console.log(data)
                   }).catch((Error)=>{
                       console.log(Error)
                   })
            }
            }
        }
      cellules.forEach(cellule => {
        cellule.addEventListener('click',()=> {
            cellule.classList.add('active_cellule')
        });
    });
    modals.forEach(modal => {
        modal.addEventListener('hidden.bs.modal', () => {
            const cellules = document.querySelectorAll('.cellule');
            cellules.forEach(cellule => {
                cellule.classList.remove('active_cellule');
            });
        });
    });
   
</script>
<script src="{{ asset('assets/css/app.js') }}"></script>
</body>
</html>