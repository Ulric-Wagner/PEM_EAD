<?php
namespace Csupcyber\Pemead\Models;

class LoginFormBody
{
    public function __construct()
    { ?>

<div class="d-flex justify-content-center mt-4">
<div class="form-outline mb-4 col-4">
      <!-- Email input -->
      <div class="form-outline mb-4">
        <input type="email" id="registerEmail" class="form-control d-flex justify-content-center" />
        <label class="form-label d-flex justify-content-center" for="registerEmail">Email</label>
      </div>

      <!-- Password input -->
      <div class="form-outline mb-4">
        <input type="password" id="registerPassword" class="form-control d-flex justify-content-center" />
        <label class="form-label d-flex justify-content-center" for="registerPassword">Mot de passe</label>
      </div>

      <!-- Checkbox -->
      <div class="form-check d-flex justify-content-center mb-4">
        <input class="me-2" type="checkbox" value="" id="registerCheck" checked
          aria-describedby="registerCheckHelpText" />
        <label class="form-check-label" for="registerCheck">
          J'ai lu et accepte les conditions d'utilisation.
        </label>
      </div>

      <!-- Submit button -->
      <div class="d-flex justify-content-center">
      <button type="submit" class="btn btn-primary btn-block mb-3">Se connecter</button>
      <a class="btn btn-info btn-block mb-3" href="#" role="button">S'enregistrer</a>
    </div>
    </form>
  </div>
</div>
<!-- Pills content -->
</div>
<?php }
}