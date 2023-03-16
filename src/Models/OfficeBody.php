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
        <a href="?view=groupementsManagement" class="btn stretched-link">
          <div class="card-header">Administration</div>
          <div class="card-body">
            <h5 class="card-title text-start">Gestion des groupements (Pools)</h5>
              <p class="card-text text-start">
                Cette interface vous permet de créer/modifier/supprimer un groupement.
                (ex: "CYBER", "ASM")
              </p>
          </div>
        </a>
      </div>
    </div>
    <!---->

    <!---->
    <div class="col">
      <div class="card text-white bg-secondary">
        <a href="?view=coursesManagement" class="btn stretched-link">
          <div class="card-header">Administration</div>
          <div class="card-body">
            <h5 class="card-title text-start">Gestion des cours</h5>
              <p class="card-text text-start">
                Cette interface vous permet de créer/modifier/supprimer un cours.
                (ex: "CSUP CYBER", "BAT SYNUM")
              </p>
          </div>
        </a>
      </div>
    </div>
    <!---->

    <!---->
    <div class="col">
      <div class="card text-white bg-info">
        <a href="?view=courseAccountsManagement" class="btn stretched-link">
          <div class="card-header">Pilote de cours</div>
          <div class="card-body">
            <h5 class="card-title text-start">Gestion des comptes</h5>
              <p class="card-text text-start">
              Cette interface vous permet de valider/rejeter les accèss des élèves et instructeurs pour votre cours.
              </p>
          </div>
        </a>
      </div>
    </div>
    <!---->

    <!---->
    <div class="col">
      <div class="card text-white bg-info">
        <a href="?view=promotionsManagement" class="btn stretched-link">
          <div class="card-header">Pilote de cours</div>
          <div class="card-body">
            <h5 class="card-title text-start">Gérer les promotions</h5>
              <p class="card-text text-start">
                Cette interface vous permet de créer/modifier/supprimer une promotion pour un cours.
                (ex: BS SITEL: Promotion "18.2")
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