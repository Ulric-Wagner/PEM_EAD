<?php
namespace Csupcyber\Pemead\Models;

use Csupcyber\Pemead\Controlers\DataBase;
use Csupcyber\Pemead\Controlers\MessageToUser;

class RegisterFormBody
{
    public function __construct()
    {
      $this->bdd = new DataBase();
      ?>

<div class="d-flex justify-content-center mt-4">
  <div class="col-7 text-center">
    <H1>Vous êtes nouveau? Bienvenue parmis nous!</H1>
  </div>
</div>
<div class="d-flex justify-content-center mt-2">
  <div class="col-8 text-center">
    <H3>Veuillez vous enregistrer pour accéder au service:</H3>
  </div>
</div>
<form method="post" action="?process=register">
<div class="d-flex justify-content-center mt-4">
<div class="form-outline mb-4 col-4">
      <!-- Rank input -->
      <div class="form-outline mb-4">
        <input
        type="text"
        id="registerRank"
        class="form-control d-flex justify-content-center"
        name="RegisterGrade"
        required/>
        <label class="form-label d-flex justify-content-center" for="registerRank">Grade / Civilité</label>
      </div>

      <!-- Name input -->
      <div class="form-outline mb-4">
        <input
        type="text"
        id="registerName"
        class="form-control d-flex justify-content-center"
        name="RegisterNom"
        required/>
        <label class="form-label d-flex justify-content-center" for="registerName">Nom</label>
      </div>

      <!-- Firstname input -->
      <div class="form-outline mb-4">
        <input
        type="text"
        id="registerFirstname"
        class="form-control d-flex justify-content-center"
        name="RegisterPrenom"
        required/>
        <label class="form-label d-flex justify-content-center" for="registerFirstname">Prénom</label>
      </div>

      <!-- RegistrationNumber input -->
      <div class="form-outline mb-4">
        <input
        type="text"
        id="registerRegistrationNumber"
        class="form-control d-flex justify-content-center"
        name="RegisterMatricule"
        required/>
        <label class="form-label d-flex justify-content-center" for="registerRegistrationNumber">Matricule</label>
      </div>

      <!-- Email input -->
      <div class="form-outline mb-4">
        <input
        type="email"
        id="registerEmail"
        class="form-control d-flex justify-content-center"
        name="RegisterMail"
        required/>
        <label class="form-label d-flex justify-content-center" for="registerEmail">Email</label>
      </div>

      <!-- Password input -->
      <div class="form-outline mb-4">
        <input
        type="password"
        id="registerPassword"
        class="form-control d-flex justify-content-center"
        name="RegisterPassword"
        required/>
        <label class="form-label d-flex justify-content-center" for="registerPassword">Mot de passe</label>
      </div>

      <!-- Password confirmation input -->
      <div class="form-outline mb-4">
        <input
        type="password"
        id="ConfirmPassword"
        class="form-control d-flex justify-content-center"
        name="ConfirmPassword"
        required/>
        <label class="form-label d-flex justify-content-center" for="ConfirmPassword">
        Confirmation du mot de passe</label>
      </div>

      <!-- Checkbox -->
      <div class="form-check d-flex justify-content-center mb-4">
        <input class="me-2" type="checkbox" value="" id="registerCheck" checked
          aria-describedby="registerCheckHelpText" required />
        <label class="form-check-label" for="registerCheck">
          J'ai lu et accepte les conditions d'utilisation.
        </label>
      </div>

      <!-- Token CSRF -->
      <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
      <!-- Submit button -->
      <div class="d-flex justify-content-center">
      <button type="submit" class="btn btn-dark btn-block mb-3">S'enregistrer</button>
    </div>
    </form>
  </div>
</div>
<!-- Pills content -->
</div>
<?php }

      public function promotionList()
      {
//
      }
}