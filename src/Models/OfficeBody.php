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
      <div class="card bg-warning">
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
      <div class="card bg-warning">
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
      <div class="card bg-warning">
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

    <!---->
    <div class="col">
      <div class="card text-white bg-info">
        <a href="?view=promotionsManagement" class="btn stretched-link">
          <div class="card-header">Pilote de cours</div>
          <div class="card-body">
            <h5 class="card-title text-start">Valider les supports de cours</h5>
              <p class="card-text text-start">
                Cette interface vous permet de valider ou rejeter les support de cours.
                (ex: powerpoint, pdf)
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
            <h5 class="card-title text-start">Gerer les matières</h5>
              <p class="card-text text-start">
                Cette interface vous permet de modifier ou supprimer une matière.
              </p>
          </div>
        </a>
      </div>
    </div>
    <!---->

    <!---->
    <div class="col">
      <div class="card text-white bg-dark">
        <a href="?view=promotionsManagement" class="text-info btn stretched-link">
          <div class="card-header">Instructeur</div>
          <div class="card-body">
            <h5 class="card-title text-start">Créer une matière</h5>
              <p class="card-text text-start">
                Cette interface vous permet de créer une nouvelle matière.
                (ex: LIAFAN, PENTEST, ANGLAIS, ect..)
              </p>
          </div>
        </a>
      </div>
    </div>
    <!---->

    <!---->
    <div class="col">
      <div class="card text-white bg-dark">
        <a href="?view=promotionsManagement" class="text-info btn stretched-link">
          <div class="card-header">Instructeur</div>
          <div class="card-body">
            <h5 class="card-title text-start">Soumettre un support</h5>
              <p class="card-text text-start">
                Cette interface vous permet de joindre un support à une matière,
                il sera soumit à la validation du pilote de cours.
                (ex: pdf, powerpoint)
              </p>
          </div>
        </a>
      </div>
    </div>
    <!---->

    <!---->
    <div class="col">
      <div class="card text-white bg-dark">
        <a href="?view=promotionsManagement" class="text-info btn stretched-link">
          <div class="card-header">Instructeur</div>
          <div class="card-body">
            <h5 class="card-title text-start">Créer un template d'évaluation</h5>
              <p class="card-text text-start">
                Cette interface vous permet de créer un template d'évaluation pour un cours,
                il sera soumit à la validation du pilote de cours.
              </p>
          </div>
        </a>
      </div>
    </div>
    <!---->

    <!---->
    <div class="col">
      <div class="card text-white bg-dark">
        <a href="?view=promotionsManagement" class="text-info btn stretched-link">
          <div class="card-header">Instructeur</div>
          <div class="card-body">
            <h5 class="card-title text-start">Démarrer une évaluation</h5>
              <p class="card-text text-start">
                Cette interface vous permet de créer une évaluation qui sera accessible au élèves.
              </p>
          </div>
        </a>
      </div>
    </div>
    <!---->

    <!---->
    <div class="col">
      <div class="card bg-success">
        <a href="?view=coursesManagement" class="btn stretched-link">
          <div class="card-header">Élèves</div>
          <div class="card-body">
            <h5 class="card-title text-start">Consulter mes cours</h5>
              <p class="card-text text-start">
                Cette interface vous permet de visualiser les cours de votre cursus.
              </p>
          </div>
        </a>
      </div>
    </div>
    <!---->

    <!---->
    <div class="col">
      <div class="card bg-success">
        <a href="?view=coursesManagement" class="btn stretched-link">
          <div class="card-header">Élèves</div>
          <div class="card-body">
            <h5 class="card-title text-start">Entrer dans une évaluation</h5>
              <p class="card-text text-start">
                En bonus peut-être...
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