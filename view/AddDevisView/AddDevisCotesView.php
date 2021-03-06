
<!DOCTYPE html>
<div id="content-wrapper">
  <div class='container' style="max-width: 1800px; min-width: 1850px">
    <div class="form">
      <div class="row">
        <div class="col-sm row" id="donneesDevisContainer">

          <div class="col-sm" id="donneesColonneGaucheContainer">
            <div class="formbox" style="margin-bottom: 1vw; height:100%; padding: 5px">
              <div class="row">
                <div class="input-group mb-2 col-sm-6" style="padding-right:5px">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="NumeroDevisTitre">N˚ Devis</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-describedby="NumeroDevisTitre" id="NumeroDevis" value="">
                </div>
                <div class="input-group mb-2 col-sm-6" style="padding-left:5px">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="DateDevisTitre">Date :</span>
                  </div>
                  <input type="text" class="form-control" disabled aria-describedby="DateDevisTitre" id="DateDevis" value="">
                </div>
              </div>

              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="LibelleDevisTitre">Libellé :</span>
                </div>
                <input type="text" class="form-control" onchange="UpdateDevis()" aria-describedby="LibelleDevisTitre" id="LibelleDevis" value="" >
              </div>

              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="ClientDevisTitre">Client :</span>
                </div>
                <input type="text" class="form-control" disabled aria-describedby="ClientDevisTitre" id="ClientDevis" value="" >
              </div>

              <hr>

              <div class="row">
                <div class="input-group mb-2 col-sm-6" style="padding-right:5px" hidden>
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="AquisDevisTitre">Aquis :</span>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <input type="checkbox" onchange="UpdateDevis()" id="AquisDevis">
                    </span>
                  </div>
                </div>
                <div class="input-group mb-2 col-sm-6" style="padding-left:5px" hidden>
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="ArrondiDevisTitre">Arrondi :</span>
                  </div>
                  <select class="form-control" onchange="UpdateDevis()" id="ArrondiDevis">
                    <option selected disabled></option>
                    <option value='HT Net'>HT Net</option>
                    <option value='HT Net'>HT Arrondi</option>
                    <option value='HT Net'>TTC Net</option>
                    <option value='HT Net'>TTC Net</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="input-group mb-2 col-sm-6" style="padding-right:5px">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="TypeDevisTitre">Type :</span>
                  </div>
                  <select class="form-control" onchange="UpdateDevis()" id="TypeDevis" aria-describedby="TypeDevisTitre">
                    <option selected disabled></option>
                    <option value='Marbrier'>Marbrier</option>
                    <option value='PF'>Pompes funèbres</option>
                  </select>
                </div>
                <div class="input-group mb-2 col-sm-6" style="padding-left:5px">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="MatiereDevisTitre">Matiere :</span>
                  </div>
                  <select id="MatiereDevis" class="form-control" name="Id_matiere" onchange="UpdateMatiereAll(value)" aria-describedby="MatiereDevisTitre">
                    //MATIERES
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="input-group mb-2 col-sm-6" style="padding-right:5px">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="PrixDevisTitre">Prix :</span>
                  </div>
                  <select class="form-control" onchange="UpdateDevis()" id="PrixDevis">
                    <option selected disabled></option>
                    <option value='Prix Depart'>Prix Départ</option>
                    <option value='Prix Franco'>Prix Franco</option>
                    <option value='Prix Pose'>Prix Posé</option>
                  </select>
                </div>
                <div class="input-group mb-2 col-sm-6" style="padding-left:5px">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="DosPolisDevisTitre">Dos Poli :</span>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <input type="checkbox" onchange="UpdateDevis()" id="DosPolisDevis">
                    </span>
                  </div>
                </div>
              </div>

              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="TvaDevisTitre">TVA (Monu.) :</span>
                </div>
                <input type="number" step='0.01' value='0.00'  placeholder='0.00' max="100" min="0" onchange="UpdatePrixTTC()" class="form-control" id="TvaDevis">
                <div class="input-group-append">
                  <span class="input-group-text">%</span>
                </div>
              </div>

              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="RemiseDevisTitre">Remise :</span>
                </div>
                <input type="number" step='0.01' value='0.00'  placeholder='0.00' max="100" min="0" onchange="UpdateNets()" class="form-control" id="RemiseDevis">
                <div class="input-group-append">
                  <span class="input-group-text">%</span>
                </div>
              </div>

              <hr>

              <div class="input-group" hidden>
                <div class="input-group-prepend">
                  <span class="input-group-text" id="PUTransportDevisTitre">PU Transport :</span>
                </div>
                <input type="number" step='0.01' value='0.00' placeholder='0.00' min="0" onchange="UpdatePrix()" class="form-control" id="PUTransportDevis">
                <div class="input-group-append">
                  <span class="input-group-text">€</span>
                </div>
              </div>
              <span class="input-group-text mb-2">(la tonne) - Soit &nbsp <span id="FraisDePortDevis"></span>€ frais de port.</span>

              <hr hidden>

              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="SurfaceDevisTitre">Surface Totale :</span>
                </div>
                <input value='0.00'  placeholder='0.00' class="form-control" id="SurfaceDevis" disabled>
                <div class="input-group-append">
                  <span class="input-group-text" >m2</span>
                </div>
              </div>

              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="VolumeDevisTitre">Volume Total :</span>
                </div>
                <input type="number" step='0.01' value='0.00'  placeholder='0.00' id="VolumeDevis" class="form-control" disabled>
                <div class="input-group-append">
                  <span class="input-group-text" >m3</span>
                </div>
              </div>

              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="PoidsDevisTitre">Poids Total :</span>
                </div>
                <input type="number" step='0.01' value='0.00'  placeholder='0.00' class="form-control" disabled  id="PoidsDevis">
                <div class="input-group-append">
                  <span class="input-group-text">tonne</span>
                </div>
              </div>

              <hr>

              <div class="row">
                <div class="input-group mb-2 col-sm-6" style="padding-right:5px">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="NombrePiecesDevisTitre">Nb pieces :</span>
                  </div>
                  <input type="text" class="form-control" id="NombrePiecesDevis" disabled>
                </div>
                <div class="input-group mb-2 col-sm-6" style="padding-left:5px">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="NombreCubesDevisTitre">Nb cubes :</span>
                  </div>
                  <input type="text" class="form-control" id="NombreCubesDevis" disabled>
                </div>
              </div>

              <hr>

              <button class='btn btn-primary form-control mb-2' hidden>Affinage calculs
              </button>
            </div>

          </div>
          <div class="col-sm" id="listeCubesDevisContainer" style="margin-top:10px">
            <div style="margin-bottom: 1vw; overflow-y: scroll; max-height: 810px;">
              <table class='table table-striped'>
                <thead>
                  <tr>
                    <th style='padding: 2px; border-top: 0px; font-size: 18px;' class="text-left" scope='col'></th>
                    <th style='padding: 2px; border-top: 0px; font-size: 18px;' class="text-left" scope='col'>Cubes Monument</th>
                    <th style='padding: 2px; border-top: 0px; font-size: 18px;' class="text-left" scope='col'>Matiere</th>
                    <th style='padding: 2px; border-top: 0px; font-size: 18px;' class="text-left" scope='col'>Larg.</th>
                    <th style='padding: 2px; border-top: 0px; font-size: 18px; font-style: italic;' class="text-left" scope='col'>Larg.</th>
                    <th style='padding: 2px; border-top: 0px; font-size: 18px;' class="text-left" scope='col'>Prof.</th>
                    <th style='padding: 2px; border-top: 0px; font-size: 18px;font-style: italic;' class="text-left" scope='col'>Prof.</th>
                    <th style='padding: 2px; border-top: 0px; font-size: 18px;' class="text-left" scope='col'>Haut.</th>
                    <th style='padding: 2px; border-top: 0px; font-size: 18px;font-style: italic;' class="text-left" scope='col'>Haut.</th>
                    <th style='padding: 2px; border-top: 0px; font-size: 18px;' class="text-left" scope='col'>Qté</th>
                    <th style='padding: 2px; border-top: 0px; font-size: 18px;' class="text-left" scope='col'>Coût Cube</th>
                  </tr>
                </thead>
                <tbody style="" id="CubesDevisTable">
                </tbody>
              </table>
            </div>
          </div>

          <div class="col-sm" id="donneesColonneDroiteContainer">
            <div class="formbox" style="margin-bottom: 1vw; height:100%; padding: 5px">
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="PrixMatiereDevisTitre">Prix Matiere :</span>
                </div>
                <input value='0.00'  placeholder='0.00' class="form-control" id="PrixMatiereDevis" disabled>
                <div class="input-group-append">
                  <span class="input-group-text" >€</span>
                </div>
              </div>

              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="PrixFaconnageDevisTitre">Prix Faconnage :</span>
                </div>
                <input value='0.00'  placeholder='0.00' id="PrixFaconnageDevis" class="form-control" disabled>
                <div class="input-group-append">
                  <span class="input-group-text">€</span>
                </div>
              </div>

              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="PrixOptionsDevisTitre">Prix Options :</span>
                </div>
                <input value='0.00'  placeholder='0.00' id="PrixOptionsDevis" class="form-control" disabled>
                <div class="input-group-append">
                  <span class="input-group-text">€</span>
                </div>
              </div>

              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="MonumentHTDevisTitre">Monument HT :</span>
                </div>
                <input value='0.00'  placeholder='0.00' class="form-control" id="MonumentHTDevis" disabled>
                <div class="input-group-append">
                  <span class="input-group-text">€</span>
                </div>
              </div>

              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="MonumentTTCDevisTitre">Monument TTC :</span>
                </div>
                <input value='0.00'  placeholder='0.00' class="form-control" id="MonumentTTCDevis" disabled>
                <div class="input-group-append">
                  <span class="input-group-text">€</span>
                </div>
              </div>

              <hr>

              <div class="input-group mb-2" hidden>
                <div class="input-group-prepend">
                  <span class="input-group-text" id="ArticlesHTDevisTitre">Articles HT :</span>
                </div>
                <input value='0.00'  placeholder='0.00' class="form-control" id="ArticlesHTDevis" disabled>
                <div class="input-group-append">
                  <span class="input-group-text">€</span>
                </div>
              </div>

              <div class="input-group mb-2" hidden>
                <div class="input-group-prepend">
                  <span class="input-group-text" id="ArticlesTTCDevisTitre">Articles TTC :</span>
                </div>
                <input value='0.00'  placeholder='0.00' class="form-control" id="ArticlesTTCDevis" disabled>
                <div class="input-group-append">
                  <span class="input-group-text">€</span>
                </div>
              </div>

              <hr hidden>

              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="NetsHTDevisTitre">Nets HT :</span>
                </div>
                <input value='0.00'  placeholder='0.00' class="form-control" id="NetsHTDevis" disabled>
                <div class="input-group-append">
                  <span class="input-group-text">€</span>
                </div>
              </div>

              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="NetsTTCDevisTitre">Nets TTC :</span>
                </div>
                <input value='0.00'  placeholder='0.00' class="form-control" id="NetsTTCDevis" disabled>
                <div class="input-group-append">
                  <span class="input-group-text">€</span>
                </div>
              </div>
              <hr>

              <button class='btn btn-primary form-control mb-2' onclick="OpenModalAjouterCubes()">Ajout cubes
              </button>
              <button class='btn btn-primary form-control mb-2' onclick="RedirectDevisDessinView()">Modifier Dessin
              </button>
              <button class='btn btn-primary form-control mb-2' onclick="OpenModalCommentaires()">Commentaires
              </button>

              <button hidden class='btn btn-success form-control mb-2' onclick="OpenModalSuite()">Suite
              </button>
              <button class='btn btn-success form-control mb-2' onclick="SaveChanges()">Sauvegarder
              </button>
              <button class='btn btn-danger form-control mb-2' onclick="RedirectDevisListView()">Quitter
              </button>

              <!--VUE PIECE-->
              <!-- <div class="formbox row" id="pieceVueEtControlContainer">
                <span id="pieceVueContainerCount"></span>
                <div class="col-sm"><img alt="" id="imagePieceSelectionnee" src="" style="max-width: inherit; max-height: inherit">
                </div>
              </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="CubeModalContainer">
</div>
