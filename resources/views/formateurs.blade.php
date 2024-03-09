<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
    <title>Formateur</title>
</head>
<body>

@error('name')
<div class="alert alert-danger" role="alert">
 {{$message}}
</div>
@enderror
<table class="table">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">nom</th>
      <th scope="col" >action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($formateurs as $formateur)
    <tr>
      <th scope="row">{{$formateur->id}}</th>
      <td>{{$formateur->name}}</td>
      <td><button type="button" class="btn btn-danger">supprimer</button></br></td>  
    </tr>
    @endforeach
  </tbody>
</table>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  ajouter formateur
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="modal-body" action="{{route('ajouter_formateur')}}" method="post">
        @csrf
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">nom formateur</label>
    <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text"></div>
    <label for="exampleInputEmail1" class="form-label">prenom formateur</label>
    <input type="text" name="prenom" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text"></div>
  </div>
  <div class="modal-footer">
        <button type="submit" class="btn btn-primary">ajouter</button>
  </div>
</form>
    </div>
  </div>
</div>
<script src="{{ asset('assets/css/app.js') }}"></script>
</body>
</html>