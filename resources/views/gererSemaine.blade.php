<x-master title="Formateur">
    <x-settings>
        <div class="container">
            <div class="row">
                <div style="width: 100%; height: 60vh; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date Debut</th>
                                <th scope="col">Date Fin</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($emplois as $emploi)
                            <tr>
                                <td>{{$emploi->id}}</td>
                                <td>{{$emploi->date_debu}}</td>
                                <td>{{$emploi->date_fin}}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="#" type="button" class="btn btn-info me-2">Confirmer</a>{{--{{route('showUpdateFormateur',$emploi->id)}}--}}
                                        <a href="{{route('deleteSemaine',$emploi->id)}}" class="btn btn-danger">Delete</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-settings>
</x-master>
