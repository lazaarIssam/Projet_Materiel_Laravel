@extends('layouts.app')

@section('content')
<div class="container">
@include('partials._messages')
{{-- Form de recherche --}}
  <form action="{{ route('materiel.recherche') }}" id="frmrecherche" method="post" enctype="multipart/form-data">
    @csrf
    <div class="input-group mb-3">
      <input type="text" name="recherche" id="recherche" class="form-control" placeholder="Zone de recherche">
    <div class="input-group-append">
    <button class="btn btn-outline-secondary" form="frmrecherche" type="submit">Recherche</button>
    </div>
  </div>
</form>
{{-- Modèle de modification des données --}}
{{-- Ce modèle s'ouvre qaund on clique sur le button modifier qui fait appel à la fonction java script qui par son tour fait appel à ce modèle et remplisles données de la ligne en question --}}
{{-- Une fois les données charger sur le modèle, on insere nos modification puis ce dernier fait appel à la méthode update ans notre controlleur MaterialController --}}
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Modifier Materiel</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('materiel.update') }}" method="post" id="frm1" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="idm" name="id">
            <div class="form-group">
              <label for="identification" class="col-form-label">identification :</label>
              <input type="text" class="form-control" name="identification" id="identification" required>
            </div>
            <div class="form-group">
              <label for="serial_number" class="col-form-label">Serial Number :</label>
              <input type="text" class="form-control" name="serial_number" id="serial_number" required>
            </div>
            <div class="form-group">
                <label for="region" class="col-form-label">Region :</label>
                <textarea type="text" class="form-control" name="region" id="region"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"> Fermer</button>
          <button type="submit" form="frm1" class="btn btn-primary"> Modifier</button>
        </div>
      </div>
    </div>
  </div>
{{-- Table d'affichage des Données --}}
<table class="table table-striped" >
    <thead>
    <tr>
        <th scope="col">identification</th>
        <th scope="col">Serial Number</th>
        <th scope="col">Region</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
       @php $cnt=1; @endphp
        @foreach($list as $item)
            <tr style="white-space: wrap;overflow: hidden;">
                {{-- On insere des Input de type hidden afin de recuperer les informations de la ligne concerne en utilisant une fonction javascript --}}
                {{-- Notre fonction javascript va utiliser les id des inputs caché afin de récupérer les données --}}
                <input type="hidden" id="idtr{{$cnt}}" value="{{ $item->id }}">
                <input type="hidden" id="identificationtr{{$cnt}}" value="{{ $item->identification }}">
                <input type="hidden" id="serial_numbertr{{$cnt}}" value="{{ $item->serial_number }}">
                <input type="hidden" id="regiontr{{$cnt}}" value="{{ $item->region }}">
                <td scope="row text-center">{{ $item->identification }}</td>
                @if($item->serial_number == NULL)
                    <td scope="row text-center">---</td>
                @else
                <td scope="row text-center">{{ $item->serial_number }}</td>
                @endif
                @if($item->region == NULL)
                    <td scope="row text-center">---</td>
                @else
                <td scope="row text-center" style="max-width: 300px;max-height: 10px">{{ $item->region}}</td>
                @endif
                <td>
                <div class="row">
                <div class="col-md-4">
                <button type="button" id="modifier{{$cnt}}" onclick="modifier({{$cnt}})" class="btn btn-outline-primary btn-sm"> Modifier</button>
                </div>
                <div class="col-md-4">
                <form method="post" action="{{ route('materiel.destroy', ['id' => $item->id]) }}">
                    @csrf
                      <button onclick="return suppressionAffirmation();" class="btn btn-outline-danger btn-sm"> Supprimer</button>
                </form>
                </div>
                </div>
                </td>
            </tr>
            @php $cnt++; @endphp
        @endforeach
    </tbody>
</table>
{{-- La fonction links() nous permet d'afficher la pagination --}}
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
      <span>{{$list->links()}}</span>
  </ul>
</nav>
</div>
<script>
  // Fonction qui récupere les données et les insere dans notre Modèle de modification
function modifier(params) {
  //alert(params);
  $('#idm').val($('#idtr'+params).val());
  $('#identification').val($('#identificationtr'+params).val());
  $('#serial_number').val($('#serial_numbertr'+params).val());
  $('#region').val($('#regiontr'+params).val());
  $('#exampleModal1').modal();
}
// Fonction de confirmation de suppression
function suppressionAffirmation() {
      if(!confirm("Etes-vous sur de vouloir supprimer ce materiel ?"))
      event.preventDefault();
  }
</script>
@endsection
