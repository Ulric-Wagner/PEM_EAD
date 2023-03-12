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
<div class="d-flex justify-content-center mt-2">
  <div class="col-8 text-center">
    <H3>Veuillez vous identifier pour accéder au service:</H3>
  </div>
</div>
<div class="d-flex justify-content-center mt-4">
<div class="form-outline mb-4 col-4">
      <form method="post" action="?process=login">
      <!-- Email input -->
      <div class="form-outline mb-4">
        <input type="email" id="registerEmail" class="form-control d-flex justify-content-center"
        name="LoginEmail" required/>
        <label class="form-label d-flex justify-content-center" for="registerEmail">Email</label>
      </div>

      <!-- Password input -->
      <div class="form-outline mb-4">
        <input type="password" id="registerPassword" class="form-control d-flex justify-content-center"
        name="LoginPassword" required/>
        <label class="form-label d-flex justify-content-center" for="registerPassword">Mot de passe</label>
      </div>

      <!-- Checkbox -->
      <div class="form-check d-flex justify-content-center mb-4">
        <input class="me-2" type="checkbox" value="" id="registerCheck" checked
          aria-describedby="registerCheckHelpText" required/>
        <label class="form-check-label" for="registerCheck">
          J'ai lu et accepte les conditions d'utilisation.
        </label>
      </div>

      <!-- Token CSRF -->
      <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
      <!-- Submit button -->
      <div class="d-flex justify-content-center">
      <button type="submit" class="btn btn-secondary btn-block mb-3">Se connecter</button>
      <a class="btn btn-dark btn-block mb-3" href="?view=register" role="button">S'enregistrer</a>
    </div>
    </form>
  </div>
</div>
<!-- Pills content -->
</div>
<?php }
}