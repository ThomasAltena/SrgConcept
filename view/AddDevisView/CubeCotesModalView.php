<div class="modal fade bd-example-modal-lg" id="CubeDevisModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ajouterOptionsModal">Options</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 0">
        <div class="row" style="width: 100%; margin: 0;">
          <div class="col-sm-6 formbox" style="padding: 5px; margin: 0">
            <div class="row col-lg-12" style="margin:0; padding:0">
              <div class="input-group mb-2 col-sm-5" style="padding: 0 5px 0 0">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="CodeCubeModalTitre">Code :</span>
                </div>
                <input type="text" class="form-control" disabled aria-describedby="CodeCubeModalTitre" id="CodeCubeModal" value="">
              </div>
              <div class="input-group mb-2 col-sm-7" style="padding: 0 5px 0 0">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="LibelleCubeModalTitre">Libelle :</span>
                </div>
                <input type="text" class="form-control" onchange="UpdateCubeModal()" aria-describedby="LibelleCubeModalTitre" id="LibelleCubeModal" value="">
              </div>
            </div>

            <div class="row col-lg-12" style="margin:0; padding:0">
              <div class="input-group mb-2 col-sm-6" style="padding: 0 5px 0 0">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="LargeurCubeModalTitre">Largeur :</span>
                </div>
                <input type="number" class="form-control" onchange="UpdateCubeModal()" aria-describedby="LargeurCubeModalTitre" id="LargeurCubeModal" value="">
              </div>
              <div class="input-group mb-2 col-sm-6" style="padding: 0 5px 0 0">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="HauteurCubeModalTitre">Hauteur :</span>
                </div>
                <input type="number" class="form-control" onchange="UpdateCubeModal()" aria-describedby="HauteurCubeModalTitre" id="HauteurCubeModal" value="">
              </div>
            </div>

            <div class="row col-lg-12" style="margin:0; padding:0">
              <div class="input-group mb-2 col-sm-6" style="padding: 0 5px 0 0">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="ProfondeurCubeModalTitre">Profondeur :</span>
                </div>
                <input type="number" class="form-control" onchange="UpdateCubeModal()" aria-describedby="ProfondeurCubeModalTitre" id="ProfondeurCubeModal" value="">
              </div>
              <div class="input-group mb-2 col-sm-6" style="padding: 0 5px 0 0">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="QuantiteCubeModalTitre">Quantité :</span>
                </div>
                <input type="number" class="form-control" onchange="UpdateCubeModal()" aria-describedby="QuantiteCubeModalTitre" id="QuantiteCubeModal" value="">
              </div>
            </div>
          </div>
          <div class="col-sm-6 formbox" style="padding: 5px; margin: 0">
            <div class="row col-lg-12" style="margin:0; padding:0">
              <div class="input-group mb-2 col-sm-6" style="padding: 0 5px 0 0"  id="SelectMatiereCubeModalContainer">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="MatiereCubeModalTitre">Matiere :</span>
                </div>
                <select id="MatiereCubeModal" class="form-control" name="Id_matiere" onchange="UpdateMatiereAll(value)" aria-describedby="MatiereCubeModalTitre">
                  //MATIERES
                </select>
              </div>
              <div class="input-group mb-2 col-sm-6" style="padding: 0 5px 0 0">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="SurfaceCubeModalTitre">Surface :</span>
                </div>
                <input type="text" class="form-control" disabled aria-describedby="SurfaceCubeModalTitre" id="SurfaceCubeModal" value="">
              </div>
            </div>

            <div class="row col-lg-12" style="margin:0; padding:0">
              <div class="input-group mb-2 col-sm-6" style="padding: 0 5px 0 0">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="VolumeCubeModalTitre">Volume :</span>
                </div>
                <input type="text" class="form-control" disabled aria-describedby="VolumeCubeModalTitre" id="VolumeCubeModal" value="">
              </div>
              <div class="input-group mb-2 col-sm-6" style="padding: 0 5px 0 0">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="PoidsCubeModalTitre">Poids :</span>
                </div>
                <input type="text" class="form-control" disabled aria-describedby="PoidsCubeModalTitre" id="PoidsCubeModal" value="">
              </div>
            </div>

            <div class="row col-lg-12" style="margin:0; padding:0">
              <div class="input-group mb-2 col-sm-6" style="padding: 0 5px 0 0">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="PrixMatiereCubeModalTitre">Prix Mat :</span>
                </div>
                <input type="text" class="form-control" disabled aria-describedby="PrixMatiereCubeModalTitre" id="PrixMatiereCubeModal" value="">
              </div>
              <div class="input-group mb-2 col-sm-6" style="padding: 0 5px 0 0">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="PrixFaconnadeCubeModalTitre">Prix Fac :</span>
                </div>
                <input type="text" class="form-control" disabled aria-describedby="PrixFaconnadeCubeModalTitre" id="PrixFaconnadeCubeModal" value="">
              </div>
            </div>
          </div>
        </div>
        <div class="row" style="width: 100%; margin: 5px 0 0 0;">
          <div class="col-sm-3" style="padding:0">
            <div class="formbox" style="padding:5px; margin:0 0 15px 0">
              <div class="input-group mb-2" style="padding: 0">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="SurfaceDessusCubeModalTitre">Surface 5 :</span>
                </div>
                <input type="text" class="form-control" disabled aria-describedby="SurfaceDessusCubeModalTitre" id="SurfaceDessusCubeModal" value="">
              </div>

              <div class="row" style="width: 100%; margin: 0;">
                <div class="input-group mb-2 col-sm-6" style="padding: 0; margin:0">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="padding:6px"id="SurfaceDessusScieeCubeModalTitre">Sciée</span>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <input type="checkbox" onchange="UpdateCubeModal()" id="SurfaceDessusScieeCubeModal">
                    </span>
                  </div>
                </div>
                <div class="input-group mb-2 col-sm-6" style="padding: 0; margin:0">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="padding:6px" id="SurfaceDessusPolieCubeModalTitre">Polie</span>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <input type="checkbox" onchange="UpdateCubeModal()" id="SurfaceDessusPolieCubeModal">
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="formbox" style="padding:5px; margin:0 0 14px 0">
              <div class="input-group mb-2" style="padding: 0">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="SurfaceAvantCubeModalTitre">Surface 1 :</span>
                </div>
                <input type="text" class="form-control" disabled aria-describedby="SurfaceAvantCubeModalTitre" id="SurfaceAvantCubeModal" value="">
              </div>

              <div class="row" style="width: 100%; margin: 0;">
                <div class="input-group mb-2 col-sm-6" style="padding: 0; margin:0">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="padding:6px"id="SurfaceAvantScieeCubeModalTitre">Sciée</span>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <input type="checkbox" onchange="UpdateCubeModal()" id="SurfaceAvantScieeCubeModal">
                    </span>
                  </div>
                </div>
                <div class="input-group mb-2 col-sm-6" style="padding: 0; margin:0">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="padding:6px" id="SurfaceAvantPolieCubeModalTitre">Polie</span>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <input type="checkbox" onchange="UpdateCubeModal()" id="SurfaceAvantPolieCubeModal">
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="formbox" style="padding:5px; margin:0">
              <div class="input-group mb-2" style="padding: 0">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="SurfaceGaucheCubeModalTitre">Surface 4 :</span>
                </div>
                <input type="text" class="form-control" disabled aria-describedby="SurfaceGaucheCubeModalTitre" id="SurfaceGaucheCubeModal" value="">
              </div>

              <div class="row" style="width: 100%; margin: 0;">
                <div class="input-group mb-2 col-sm-6" style="padding: 0; margin:0">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="padding:6px"id="SurfaceGaucheScieeCubeModalTitre">Sciée</span>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <input type="checkbox" onchange="UpdateCubeModal()" id="SurfaceGaucheScieeCubeModal">
                    </span>
                  </div>
                </div>
                <div class="input-group mb-2 col-sm-6" style="padding: 0; margin:0">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="padding:6px" id="SurfaceGauchePolieCubeModalTitre">Polie</span>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <input type="checkbox" onchange="UpdateCubeModal()" id="SurfaceGauchePolieCubeModal">
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 formbox" style="padding:0; margin:0">
            <img style="width: 100%" src="/SrgConcept/public/images/CubeDiagramSurfaces.jpg">
          </div>
          <div class="col-sm-3" style="padding:0">
            <div class="formbox" style="padding:5px; margin:0 0 15px 0">
              <div class="input-group mb-2" style="padding: 0">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="SurfaceArriereCubeModalTitre">Surface 3 :</span>
                </div>
                <input type="text" class="form-control" disabled aria-describedby="SurfaceArriereCubeModalTitre" id="SurfaceArriereCubeModal" value="">
              </div>

              <div class="row" style="width: 100%; margin: 0;">
                <div class="input-group mb-2 col-sm-6" style="padding: 0; margin:0">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="padding:6px"id="SurfaceArriereScieeCubeModalTitre">Sciée</span>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <input type="checkbox" onchange="UpdateCubeModal()" id="SurfaceArriereScieeCubeModal">
                    </span>
                  </div>
                </div>
                <div class="input-group mb-2 col-sm-6" style="padding: 0; margin:0">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="padding:6px" id="SurfaceArrierePolieCubeModalTitre">Polie</span>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <input type="checkbox" onchange="UpdateCubeModal()" id="SurfaceArrierePolieCubeModal">
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="formbox" style="padding:5px; margin:0 0 14px 0">
              <div class="input-group mb-2" style="padding: 0">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="SurfaceDroiteCubeModalTitre">Surface 2 :</span>
                </div>
                <input type="text" class="form-control" disabled aria-describedby="SurfaceDroiteCubeModalTitre" id="SurfaceDroiteCubeModal" value="">
              </div>

              <div class="row" style="width: 100%; margin: 0;">
                <div class="input-group mb-2 col-sm-6" style="padding: 0; margin:0">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="padding:6px"id="SurfaceDroiteScieeCubeModalTitre">Sciée</span>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <input type="checkbox" onchange="UpdateCubeModal()" id="SurfaceDroiteScieeCubeModal">
                    </span>
                  </div>
                </div>
                <div class="input-group mb-2 col-sm-6" style="padding: 0; margin:0">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="padding:6px" id="SurfaceDroitePolieCubeModalTitre">Polie</span>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <input type="checkbox" onchange="UpdateCubeModal()" id="SurfaceDroitePolieCubeModal">
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="formbox" style="padding:5px; margin:0">
              <div class="input-group mb-2" style="padding: 0">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="SurfaceDessousCubeModalTitre">Surface 6 :</span>
                </div>
                <input type="text" class="form-control" disabled aria-describedby="SurfaceDessousCubeModalTitre" id="SurfaceDessousCubeModal" value="">
              </div>

              <div class="row" style="width: 100%; margin: 0;">
                <div class="input-group mb-2 col-sm-6" style="padding: 0; margin:0">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="padding:6px"id="SurfaceDessousScieeCubeModalTitre">Sciée</span>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <input type="checkbox" onchange="UpdateCubeModal()" id="SurfaceDessousScieeCubeModal">
                    </span>
                  </div>
                </div>
                <div class="input-group mb-2 col-sm-6" style="padding: 0; margin:0">
                  <div class="input-group-prepend">
                    <span class="input-group-text" style="padding:6px" id="SurfaceDessousPolieCubeModalTitre">Polie</span>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <input type="checkbox" onchange="UpdateCubeModal()" id="SurfaceDessousPolieCubeModal">
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
