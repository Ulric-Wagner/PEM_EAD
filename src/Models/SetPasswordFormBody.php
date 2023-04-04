<?php
namespace Csupcyber\Pemead\Models;

class SetPasswordFormBody
{
    public function __construct()
    { ?>

<div class="d-flex justify-content-center mt-4">
  <div class="col-7 text-center">
    <H1>Changement de mot de passe:</H1>
  </div>
</div>
<div class="d-flex justify-content-center mt-2">
  <div class="col-8 text-center">
    <H3>Pour plus de sécurité, changez votre mot de passe tout les 90 jours
      et utilisez des mots de passe différents pour chaque applications.</H3>
  </div>
</div>
<div class="d-flex justify-content-center mt-4">
<div class="form-outline mb-4 col-4">
      <form method="post" action="?process=setPassword">
      <!-- CurrentPassword input -->
      <div class="form-outline mb-4">
        <input type="password" id="CurrentPassword" class="form-control d-flex justify-content-center"
        name="CurrentPassword" required/>
        <label class="form-label d-flex justify-content-center" for="CurentPassword">Mot de passe actuel</label>
      </div>

      <!-- NewPassword1 input -->
      <div class="form-outline mb-4">
        <input type="password" id="NewPassword" class="form-control d-flex justify-content-center"
        name="NewPassword" required/>
        <label class="form-label d-flex justify-content-center" for="NewPassword">Nouveau mot de passe</label>
      </div>

      <!-- NewPassword2 input -->
      <div class="form-outline mb-4">
        <input type="password" id="ConfirmPassword" class="form-control d-flex justify-content-center"
        name="ConfirmPassword" required/>
        <label class="form-label d-flex justify-content-center" for="ConfirmPassword">
          confirmation du nouveau mot de passe</label>
      </div>

      <!-- Token CSRF -->
      <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
      <!-- Submit button -->
      <div class="d-flex justify-content-center">
      <button type="submit" class="btn btn-secondary btn-block mb-3 confirmButton">Modifier le mot de passe</button>
    </div>
    </form>
  </div>
</div>
<!-- Pills content -->
</div>
<?php }
}