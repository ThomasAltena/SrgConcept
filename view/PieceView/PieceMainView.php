<div class="formbox" style="padding:5px; height: 850px;">
  <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" onclick="FillContainer('PieceView/PieceListView.php')" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Pieces</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" onclick="FillContainer('FamilleView/FamilleListView.php')" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Familles</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" onclick="FillContainer('RegroupementFamilleView/RegroupementFamilleListView.php')" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Regroupement Familles</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" onclick="FillContainer('SousFamilleView/SousFamilleListView.php')" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Sous-familles</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" onclick="FillContainer('RegroupementSousFamilleView/RegroupementSousFamilleListView.php')" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Regroupement Sous-familles</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" onclick="FillContainer('CubeView/CubeListView.php')" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Cubes</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" onclick="FillContainer('GroupeCubeView/GroupeCubeListView.php')" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Groupe Cubes</a>
  </li>
</ul>

  <div id="dataContainer">
  </div>
</div>
<script>
FillContainer('PieceView/PieceListView.php');
function FillContainer(url){
  ViewRequest(url).then(function (result){
    $('#dataContainer').html(result.responseText);
  }).catch(function(error){

  });
}
</script>
