  <?php
  session_start();

  if(empty($_SESSION)){
    header('location:/SrgConcept/view/index.php');

  } else {
    include('header.php');
  }
  ?>

  <link rel="stylesheet" href="../public/css/table.css" type="text/css">
  <link rel="stylesheet" href="../public/css/form.css" type="text/css">

  <?php
  /* Mise en place de la base de donnée */
  $db = new PDO('mysql:host=localhost;dbname=srg', 'root', '');
  $ManagerClient = new ClientManager($db); //Connexion a la BDD

  if(!empty($_SESSION)){
    if($_SESSION['Role_user'] != 1){
      /** Get tout les utlisateurs **/
      $clients = $ManagerClient->GetAllClientUser($_SESSION['Id_user']);
    }else {
      $clients = $ManagerClient->GetAllClient();
    }
  }
  ?>

  <body>
    <div class='container'>
      <table class='table table-striped' style='margin:10px 0;'>
        <thead>
          <tr>
            <th style='border-top: 0px;' class="text-left" scope='col'>Adresse</th>
            <th style='border-top: 0px;' class="text-left" scope='col'>Nom</th>
            <th style='border-top: 0px;' class="text-left" scope='col'>Prenom</th>
            <th style='border-top: 0px;' class="text-left" scope='col'>Code postal</th>
            <th style='border-top: 0px;' class="text-left" scope='col'>Ville</th>
            <th style='border-top: 0px;' class="text-left" scope='col'>Téléphone</th>
            <th style='border-top: 0px;' class="text-left" scope='col'>Mail</th>
            <th style='border-top: 0px;' class="text-left" scope='col'>Date de création</th>
            <th style='border-top: 0px;' class="text-left" scope='col'></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($clients as $client) { ?>
          <tr>
            <td class="text-left"><?php echo $client->GetNomClient(); ?>"</td>
            <td class="text-left"><?php echo $client->GetPrenomClient(); ?>"</td>
            <td class="text-left"><?php echo $client->GetAdresseClient(); ?>"</td>
            <td class="text-left"><?php echo $client->GetCodePostalClient(); ?>"</td>
            <td class="text-left"><?php echo $client->GetVilleClient(); ?>"</td>
            <td class="text-left"><?php echo $client->GetTelClient(); ?>"</td>
            <td class="text-left"><?php echo $client->GetMailClient(); ?>"</td>
            <td class="text-left"><?php echo $client->GetDateCreationClient(); ?>"</td>
            <td class="text-left">
              <button  onclick='edit("<?php echo $client->GetIdClient(); ?>")' class='btn btn-primary'>
                <span class='fas fa-edit'>
                </span>
              </button>
              <button onclick='supp("<?php echo $client->GetIdClient(); ?>")' class='btn btn-danger'>
                <span class='fas fa-times'></span>
              </button>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </body>

  <script>

  function supp(id)
  {
    if(window.confirm('Etes vous sur ?')){
      document.location.href="DeleteClientView.php?id="+id}else{return false;}
    }

    function edit(id)
    {
      document.location.href="EditClientView.php?id="+id
    }

    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>
