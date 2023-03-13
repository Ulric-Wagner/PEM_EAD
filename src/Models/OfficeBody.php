<?php
namespace Csupcyber\Pemead\Models;

class OfficeBody
{
    public function __construct()
    { ?>

<div class="d-flex justify-content-center mt-4">
  <div class="col-7 text-center">
    <H1>Bienvenue dans votre bureau.</H1>
  </div>
</div>

<div class="p-5">
  <div class="row row-cols-1 row-cols-md-4 g-4">
    <!---->
    <div class="col">
      <div class="card text-white bg-secondary">
        <a href="?view=accountsManagement" class="btn stretched-link">
          <div class="card-header">Administration</div>
          <div class="card-body">
            <h5 class="card-title text-start">Gestion des comptes</h5>
              <p class="card-text text-start">
                Cette interface vous permet de valider/rejeter/modifier les accèss des utilisateurs.
              </p>
          </div>
        </a>
      </div>
    </div>
    <!---->

    <!---->
    <div class="col">
      <div class="card text-white bg-secondary">
        <a href="?view=CourseCreation" class="btn stretched-link">
          <div class="card-header">Administration</div>
          <div class="card-body">
            <h5 class="card-title text-start">Créer un cours</h5>
              <p class="card-text text-start">
                Cette interface vous permet de créer un nouveau cours.
                (ex: "CSUP CYBER", "BAT SYNUM")
              </p>
          </div>
        </a>
      </div>
    </div>
    <!---->

    <!---->
    <div class="col">
      <div class="card text-white bg-secondary">
        <a href="?view=CourseEdition" class="btn stretched-link">
          <div class="card-header">Administration</div>
          <div class="card-body">
            <h5 class="card-title text-start">Modifier un cours</h5>
              <p class="card-text text-start">
                Cette interface vous permet de suprimer un cours.
                (ex: "BS SITEL", "BAT SITEL")
              </p>
          </div>
        </a>
      </div>
    </div>
    <!---->

    <!---->
    <div class="col">
      <div class="card text-white bg-secondary">
        <a href="?view=CourseRemove" class="btn stretched-link">
          <div class="card-header">Administration</div>
          <div class="card-body">
            <h5 class="card-title text-start">Supprimer un cours</h5>
              <p class="card-text text-start">
                Cette interface vous permet de suprimer un cours.
                (ex: "BS SITEL", "BAT SITEL")
              </p>
          </div>
        </a>
      </div>
    </div>
    <!---->
  </div>
</div>
<?php }
}