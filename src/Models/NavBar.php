<?php
namespace Csupcyber\Pemead\Models;

class NavBar
{
    public function __construct()
    { ?>
       

        <nav class="navbar navbar-dark navbar-expand-md bg-dark align-middle" aria-label="NavBar">
          <div class="container">
              <a href="?view=signup" class="navbar-brand d-flex w-50 me-auto justify-content-center">
               PEM EAD</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#collapsingNavbar3">
                  <span class="navbar-toggler-icon"></span>
              </button>
              <div class="navbar-collapse collapse w-100" id="collapsingNavbar3">
                  <ul class="navbar-nav w-100 justify-content-center">
                      <?php $this->centerLinks();?>
                  </ul>
                  <ul class="nav navbar-nav ms-auto w-100 justify-content-end">
                      <?php $this->rightLinks();?>
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button"
                          data-bs-toggle="dropdown" aria-expanded="false"> Menu </a>
                          <?php $this->menu();?>
                      </li>
                  </ul>
              </div>
          </div>
      </nav>
<?php
    }

    public function centerLinks()
    {
        if (isset($_SESSION['authentication'])
        && ($_SESSION['authentication'] != 'authenticated')
        && (empty($_GET['view']) || $_GET['view'] === 'signup')) {?>
          <li class="nav-item active">
          <a class="nav-link" href="?view=signup">Se connecter</a>
          <?php
        }

        if (isset($_SESSION['authentication'])
        &&($_SESSION['authentication'] != 'authenticated')
        && isset($_GET['view'])
        && ($_GET['view'] === 'register')) {?>
          <li class="nav-item active">
          <a class="nav-link" href="?view=register">S'enregister</a>
          <?php
        }
        
        if (isset($_SESSION['authentication'])
        &&($_SESSION['authentication'] === 'authenticated')
        && isset($_GET['view'])
        && ($_GET['view'] === 'setPassword')) {?>
          <li class="nav-item active">
          <a class="nav-link" href="?view=setPassword">Mot de passe</a>
          <?php
        }
        
        if (isset($_SESSION['authentication'])
        &&($_SESSION['authentication'] === 'authenticated')
        && isset($_GET['view'])
        && ($_GET['view'] === 'office')) {?>
          <li class="nav-item active">
          <a class="nav-link" href="?view=office">Mon Bureau</a>
          <?php
        }
        
        if (isset($_SESSION['authentication'])
        &&($_SESSION['authentication'] === 'authenticated')
        && isset($_GET['view'])
        && ($_GET['view'] === 'accountsManagement')) {?>
          <li class="nav-item active">
          <a class="nav-link" href="?view=accountsManagement">Gestion des comptes (Administration)</a>
          <?php
        }

        if (isset($_SESSION['authentication'])
        &&($_SESSION['authentication'] === 'authenticated')
        && isset($_GET['view'])
        && ($_GET['view'] === 'courseAccountsManagement')) {?>
          <li class="nav-item active">
          <a class="nav-link" href="?view=courseAccountsManagement">Gestion des comptes (Pilote de cours)</a>
          <?php
        }

        if (isset($_SESSION['authentication'])
        &&($_SESSION['authentication'] === 'authenticated')
        && isset($_GET['view'])
        && ($_GET['view'] === 'groupementsManagement')) {?>
          <li class="nav-item active">
          <a class="nav-link" href="?view=groupementsManagement">Gestion des groupements</a>
          <?php
        }

        if (isset($_SESSION['authentication'])
        &&($_SESSION['authentication'] === 'authenticated')
        && isset($_GET['view'])
        && ($_GET['view'] === 'coursesManagement')) {?>
          <li class="nav-item active">
          <a class="nav-link" href="?view=coursesManagement">Gestion des cours</a>
          <?php
        }

        if (isset($_SESSION['authentication'])
        &&($_SESSION['authentication'] === 'authenticated')
        && isset($_GET['view'])
        && ($_GET['view'] === 'promotionsManagement')) {?>
          <li class="nav-item active">
          <a class="nav-link" href="?view=promotionsManagement">Gestion des promotions</a>
          <?php
        }
        ?>
        <?php
        
   }

    public function rightLinks()
      {
        if (isset($_SESSION['authentication'])
        && $_SESSION['authentication'] === 'authenticated') {?>?>
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo $_SESSION['Grade']?> <?php echo $_SESSION['Nom']?>
          <?php echo $_SESSION['Prenom']?></a>
        </li>
 <?php }
      }

    public function menu()
    {
      //affichage du menu pour utilisateurs non connectés
      if (isset($_SESSION['authentication'])
      && $_SESSION['authentication'] != 'authenticated') {?>
      <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarScrollingDropdown">
        <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item" href="?view=signup">Connexion</a></li>
        </ul>
      <?php
      }

      //affichage du menu pour utilisateurs connectés
      if (isset($_SESSION['authentication'])
      && $_SESSION['authentication'] === 'authenticated') {?>
      <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarScrollingDropdown">
        <li><a class="dropdown-item" href="?view=office">Mon bureau</a></li>
        <li>
        <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item" href="?view=setPassword">Modifier le mot de passe</a></li>
        <li><a class="dropdown-item" href="?process=logout">Se deconnecter</a></li>
        </ul>
      <?php
      }
    }

}
