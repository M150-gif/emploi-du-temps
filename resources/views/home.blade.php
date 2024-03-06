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
                    <td>{{ $formateur->name }}</td>
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