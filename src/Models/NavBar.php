<?php
namespace Csupcyber\Pemead\Models;

class NavBar
{
    public function __construct()
    { ?>
       

        <nav class="navbar navbar-dark navbar-expand-md bg-dark align-middle" aria-label="NavBar">
          <div class="container">
              <a href="#" class="navbar-brand d-flex w-50 me-auto justify-content-center">
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
        if ($_SESSION['authentication'] != 'authenticated') {?>
          <li class="nav-item active">
          <a class="nav-link" href="#">Se connecter</a>
          <!--</li>
          <li class="nav-item">
          <a class="nav-link" href="#">Codeply</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>-->
        <?php
        }
   }

    public function rightLinks()
      {?>
        <!--<li class="nav-item">
          <a class="nav-link" href="#">Right</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Right</a>
        </li>-->
 <?php }

    public function menu()
    {
      if ($_SESSION['authentication'] != 'authenticated') {?>
      <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarScrollingDropdown">
        <!--<li><a class="dropdown-item" href="#">Item</a></li>
        <li><a class="dropdown-item" href="#">Item</a></li>
        <li>-->
        <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item" href="#">Connexion</a></li>
        </ul>
      <?php
      }
    }

}