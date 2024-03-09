<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
@if(session('success'))
<div class="alert alert-success" style="transition:easy-in-out;" role="alert">
{{ session('success') }}
</div>
@endif
@error('nom_groupe')
<div class="alert alert-danger" role="alert">
 {{$message}}
</div>
@enderror
@error('Mode_de_formation')
<div class="alert alert-danger" role="alert">
 {{$message}}
</div>
@enderror
@error('Niveau')
<div class="alert alert-danger" role="alert">
 {{$message}}
</div>
@enderror
@error('filiere_id')
<div class="alert alert-danger" role="alert">
 {{$message}}
</div>
@enderror
  <h1>hello</h1>
<table class="table">
  <thead>
    <tr>
      <th scope="col">nom_groupe</th>
      <th scope="col">Mode_de_formation</th>
      <th scope="col" >Niveau</th>
      <th scope="col" >filiere</th>
      <th scope="col" >action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($groupes as $groupe)
    <tr>
      <th scope="row">{{$groupe->nom_groupe}}</th>
      <td>{{$groupe->Mode_de_formation}}</td>
      <td>{{$groupe->Niveau}}</td>
      <td>{{$groupe->filiere->nom_filier}}</td>
      <td><button type="button" class="btn btn-danger">supprimer</button></br></td>  
    </tr>
    @endforeach
  </tbody>
</table>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  ajouter groupe
</button>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
<form class="modal-body" action="{{route('ajouter_groupe')}}" method="post">
        @csrf
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">nom groupe</label>
    <input type="text" name="nom_groupe" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text"></div>
    <label for="exampleInputEmail1" class="form-label">Mode_de_formation</label>
    <input type="text" name="Mode_de_formation" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text"></div>
    <label for="exampleInputEmail1" class="form-label">Niveau</label>
    <input type="text" name="Niveau" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text"></div>
    <select name="filiere_id" class="form-select" style="margin-bottom:10px;" aria-label="Default select example">
        <option selected>choisissez la filiere</option>
        @foreach($filieres as $filiere)
        <option value="{{$filiere->id}}">{{$filiere->nom_filier}}</option>
        @endforeach
    </select>
  </div>
  <button type="submit" class="btn btn-primary">ajouter</button>
</form>
    </div>
  </div>
</div>
<script src="{{ asset('assets/css/app.js') }}"></script>

</body>
</html>