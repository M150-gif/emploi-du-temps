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
        $part_of_day=['Matin','A.Midi'];
        $seances_order=['s1','s2','s3','s4'];
    ?>
</head>
<body>
@if(session('success'))
<div class="alert alert-success" style="transition:easy-in-out;" role="alert">
{{ session('success') }}
</div>
@endif
@if($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form  id="form1" class="container-sm w-50 mb-2" action="{{route('ajouter_emploi')}}" method="post">
    @csrf
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">date debu</label>
    <input id="date_debu" type="date" name="date_debu" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off">
    <div id="emailHelp" class="form-text"></div>
    @error('date_debu')
   <div id="emailHelp" class="form-text">{{$message}}</div>
   @enderror
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">date fin</label>
    <input id="date_fin" style="pointer-events: none;" type="date" name="date_fin" class="form-control" id="exampleInputPassword1"autocomplete="off">
  </div>
  <button type="submit"  class="btn btn-primary d-block mx-auto">creer emploi</button>
</form>
<div class="container-sm w-50 mb-2">
<select class="form-select" aria-label="Default select example" autocomplete="off">
    @foreach($emplois as $emploi)
        @if($loop->first)
        <a href=""><option value="{{$emploi->id}}" selected>date_debu:{{$emploi->date_debu}} | date_fin:{{$emploi->date_fin}}</option></a>
        @else
        <option value="{{$emploi->id}}"><a href="{{route('afficher_emploi')}}">date_debu:{{$emploi->date_debu}} | date_fin:{{$emploi->date_fin}}</a></option>
        @endif
    @endforeach
</select>
</div>
       <table class="table table-bordered table-bordered-dark text-center w-100vw">
        <thead>
            <tr>
                <th rowspan="3">Formateur</th>
                 @foreach($jours as $jour)
                  <th colspan="4">{{$jour}}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($jours as $jour)
                    @foreach($part_of_day as $part)
                    <th colspan="2">{{$part}}</th>
                    @endforeach
                @endforeach
            </tr>
            <tr>
                @foreach ($jours as $jour)
                    <th>s1</th>
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
                            @foreach ($seances_order as $seance_order)
                            @php
                                $seance = $seances->first(function($item) use ($jour, $part, $seance_order, $formateur) {
                                    return $item->day === $jour && $item->partie_jour === $part && $item->order_seance === $seance_order && $item->id_formateur == $formateur->id;
                                });
                            @endphp
                            @php
                                $modalId_update = $jour.'_'. $seance_order . '_' .$formateur->id.'_'."update";
                                $modalId_ajouter = $jour.'_'. $seance_order . '_' .$formateur->id.'_'."ajouter";
                            @endphp
                            @if($seance)
                              <td class="cellule" id="#{{$modalId_update}}" style="background-color: {{ $seance ? 'gray' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_update}}">
                                <span>{{ $seance->groupe->nom_groupe }}</span> <br>
                                <span>{{ $seance->type_seance }}</span> <br>
                                <span>{{ $seance->salle->nom_salle }}</span>
                              </td>
                            @else
                            
                            <td class="cellule" id="#{{$modalId_ajouter}}" style="background-color: {{ $seance ? 'gray' : '' }}; text-align:center;" data-bs-toggle="modal" data-bs-target="#{{$modalId_ajouter}}">
                            </td>
                            @endif
                            <!-- form_qui_ajouter_un_seance -->
                         <div class="modal fade" id="{{$modalId_ajouter}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                         <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">{{$seance_order}}</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form action="{{route('ajouter_seance')}}" method="post">
                                @csrf 
                                <input name="day" type="text" hidden value="{{$jour}}">
                                <input name="partie_jour" type="text" hidden value="{{$part}}">
                                <input name="id_emploi" type="text" hidden value="12">
                                <input name="order_seance" type="text" hidden value="{{$seance_order}}">
                                <input name="id_formateur" type="text" hidden value="{{$formateur->id}}">
                                <select name="id_groupe" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                    <option selected  value="">choisissez un groupe</option>
                                    @foreach($groupes as $groupe)
                                    @php
                                    $groupe_deja_occupe= $groupe->seance->where('day', '==',$jour)->where('order_seance','==',$seance_order); 
                                    $groupe_has_no_seance = $groupe->seance->isEmpty();                                    
                                    @endphp
                                    @if($groupe_deja_occupe->count()==0 || $groupe_has_no_seance)
                                    <option value="{{$groupe->id}}">{{$groupe->nom_groupe}}</option>
                                    @endif
                                     @endforeach
                                   </select>
                                   <select name="id_salle" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                      <option selected value="">choisissez la salle</option>
                                     @foreach($salles as $salle)
                                     @php
                                        $salle_occupe=$salle->seance->where('day','==',$jour)->where('order_seance','==',$seance_order);
                                        $salle_has_no_seance=$salle->seance->isEmpty();
                                     @endphp
                                     @if($salle_occupe->count()===0 || $salle_has_no_seance)
                                      <option value="{{$salle->id}}">{{$salle->nom_salle}}</option>
                                     @endif
                                     @endforeach
                                   </select>
                                <select name="type_seance" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                     <option selected value="">choisissez le type de la seance</option>
                                     <option value="presentielle">presentielle</option>
                                     <option value="team">team</option>
                                     <option value="efm">efm</option>
                                   </select>
                                <button type="submit" class="btn btn-primary">ajouter seance</button>
                            </form>
                            </div>
                          </div>
                        </div>
                     </div>
                     <!--form_qui_update-->
                     @if($seance)
                     <div class="modal fade" id="{{$modalId_update}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                         <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">{{$seance_order}}</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <form action="{{route('modifier_seance')}}" method="post">
                                @csrf
                                <input type="text" name="seance_id" value="{{$seance->id}}" hidden>
                                <select name="id_groupe" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                    <option selected value="{{$seance->groupe->id }}">{{$seance->groupe->nom_groupe}}</option>
                                    @foreach($groupes as $groupe)
                                    @php
                                    $groupe_deja_occupe= $groupe->seance->where('day', '==',$jour)->where('order_seance','==',$seance_order); 
                                    $groupe_has_no_seance = $groupe->seance->isEmpty();                                    
                                    @endphp
                                    @if($groupe_deja_occupe->count()==0 || $groupe_has_no_seance)
                                    <option value="{{$groupe->id}}">{{$groupe->nom_groupe}}</option>
                                    @endif
                                     @endforeach
                                   </select>
                                   <select name="id_salle" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                      <option selected value="{{$seance->salle->id }}">{{ $seance->salle->nom_salle }}</option>
                                     @foreach($salles as $salle)
                                     @php
                                        $salle_occupe=$salle->seance->where('day','==',$jour)->where('order_seance','==',$seance_order);
                                        $salle_has_no_seance=$salle->seance->isEmpty();
                                     @endphp
                                     @if($salle_occupe->count()===0 || $salle_has_no_seance)
                                      <option value="{{$salle->id}}">{{$salle->nom_salle}}</option>
                                     @endif
                                     @endforeach
                                   </select>
                                <select name="type_seance" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
                                     <option value="presentielle">presentielle</option>
                                     <option value="team">team</option>
                                     <option value="efm">efm</option>
                                </select>
                                <button type="submit" class="btn btn-success">update</button>
                            </form>
                            <form action="{{route('supprimer_seance')}}" method="post">
                                @csrf
                            <input type="text" name="seance_id" value="{{$seance->id}}" hidden>
                              <button type="submit" class="btn btn-danger">supprimer</button>
                            </form>
                            </div>
                          </div>
                        </div>
                     </div>
                     @endif
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
     const alert=document.querySelector('.alert');
     setTimeout(() => {
        alert.style.display = 'none';
    }, 2000);
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
                date_debu_form.value=date_debu_pre
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
                form1.submit()
                // emailHelp.innerText=""
                //  fetch(`{{route('ajouter_emploi')}}`,{method:"POST"
                //            ,headers:{
                //                'content-Type':'application/json',
                //                'X-CSRF-TOKEN':document.querySelector('[name="_token"]').value
                //            }
                //        ,body:JSON.stringify({date_debu:date_debu_form.value,date_fin:date_fin_form.value})}).then((response)=>{
                //        if(response.ok){
                //            return response.json()
                //        }else{
                //         return response.text().then((text) => {
                //             throw new Error(text);
                //         });
                //        }
                //    }).then((data)=>{
                //        console.log(data)
                //       
                //    }).catch((Error)=>{
                //     emailHelp.innerText=Error.message
                //   
                //    })
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