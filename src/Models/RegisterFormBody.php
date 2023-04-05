<?php
namespace Csupcyber\Pemead\Models;

use Csupcyber\Pemead\Controlers\DataBase;
use Csupcyber\Pemead\Controlers\MessageToUser;

class RegisterFormBody
{
    public function __construct()
    {
      $this->db = new DataBase();
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
<form method="post" action="?view=signup&process=register">
<div class="d-flex justify-content-center mt-4">
<div class="form-outline mb-4 col-4">
      <!-- Rank input -->
      <div class="form-outline mb-4">
        <input
        type="text"
        id="registerRank"
        class="form-control d-flex justify-content-center text-center"
        name="RegisterGrade"
        required/>
        <label class="form-label d-flex justify-content-center" for="registerRank">Grade / Civilité</label>
      </div>

      <!-- Name input -->
      <div class="form-outline mb-4">
        <input
        type="text"
        id="registerName"
        class="form-control d-flex justify-content-center text-center"
        name="RegisterNom"
        required/>
        <label class="form-label d-flex justify-content-center" for="registerName">Nom</label>
      </div>

      <!-- Firstname input -->
      <div class="form-outline mb-4">
        <input
        type="text"
        id="registerFirstname"
        class="form-control d-flex justify-content-center text-center"
        name="RegisterPrenom"
        required/>
        <label class="form-label d-flex justify-content-center" for="registerFirstname">Prénom</label>
      </div>

      <!-- RegistrationNumber input -->
      <div class="form-outline mb-4">
        <input
        type="text"
        id="registerRegistrationNumber"
        class="form-control d-flex justify-content-center text-center"
        name="RegisterMatricule"
        required/>
        <label class="form-label d-flex justify-content-center" for="registerRegistrationNumber">Matricule</label>
      </div>

      <!-- RegisterDateOfBirth input -->
      <div class="form-outline mb-4">
        <input
        type="date"
        id="registerDateOfBirth"
        class="form-control d-flex justify-content-center text-center"
        name="RegisterDateOfBirth"
        required/>
        <label class="form-label d-flex justify-content-center" for="registerDateOfBirth">Date de naissance</label>
      </div>

      <!---->
      <?php
      if ($this->isThereUsers()) {
      ?>
      <div class="form-outline mb-4" id="role">
          <select class="form-select text-center" name="RegisterRole" id="selectRole">
            <option selected class="text-center" value="None">Selectionner votre type de profil</option>
            <option class="text-center" value="Student">Elève</option>
            <option class="text-center" value="Instructeur">Instructeur</option>
            <option class="text-center" value="Pilote">Pilote de cours ou adjoint</option>
          </select>
          <label class="form-label d-flex justify-content-center">Profil</label>
        </div>

      <!---->
        <div class="form-outline mb-4" id="groupement">
          <select class="form-select text-center" name="RegisterGroupement" id="selectGroupement">
            <option selected class="text-center" value="None">Selectionner votre groupement d'instruction</option>
            <?php foreach ($this->getGroupements() as $groupement) { ?>
            <option class="text-center" value="<?php echo $groupement['GID'] ?>">
            <?php echo $groupement['Groupement'] ?></option>
            <?php
            }?>
          </select>
          <label class="form-label d-flex justify-content-center">Groupements</label>
        </div>

        <!---->
        <div class="form-outline mb-4" id="course">
          <select class="form-select text-center" name="RegisterCourse" id="selectCourse">
            <option selected class="text-center" value="None">Selectionner le cours que vous allez piloter</option>
            <?php foreach ($this->getCourses() as $course) { ?>
            <option class="text-center" value="<?php echo $course['CID'] ?>">
            <?php echo $course['Cours'] ?></option>
            <?php
            }?>
          </select>
          <label class="form-label d-flex justify-content-center">Cours</label>
        </div>

      <!---->
      <div class="form-outline mb-4" id="promotion">
          <select class="form-select text-center" name="RegisterPromotion" id="selectPromotion">
            <option class="text-center" value="None" selected>Selectionner votre promotion</option>
            <?php foreach ($this->getPromotions() as $promotion) { ?>
            <option class="text-center" value="<?php echo $promotion['PID'] ?>">
            <?php echo $promotion['Cours'].' '.$promotion['Promotion'] ?></option>
            <?php
            }?>
          </select>
          <label class="form-label d-flex justify-content-center">Promotion</label>
        </div>

      <?php } ?>
      <!-- Email input -->
      <div class="form-outline mb-4">
        <input
        type="email"
        id="registerEmail"
        class="form-control d-flex justify-content-center text-center"
        name="RegisterMail"
        required/>
        <label class="form-label d-flex justify-content-center" for="registerEmail">Email</label>
      </div>

      <!-- Password input -->
      <div class="form-outline mb-4">
        <input
        type="password"
        id="registerPassword"
        class="form-control d-flex justify-content-center text-center"
        name="RegisterPassword"
        required/>
        <label class="form-label d-flex justify-content-center" for="registerPassword">Mot de passe</label>
      </div>

      <!-- Password confirmation input -->
      <div class="form-outline mb-4">
        <input
        type="password"
        id="ConfirmPassword"
        class="form-control d-flex justify-content-center text-center"
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
      <button type="submit"  class="btn btn-dark btn-block mb-3">S'enregistrer</button>
    </div>
    </form>
  </div>
</div>
<!-- Pills content -->
</div>
<?php
    }


    public function getGroupements()
    {
      return $this->db->getGroupements();
    }

    public function getCourses()
    {
      return $this->db->getCourses();
    }

    public function getPromotions()
    {
      return $this->db->getPromotions();
    }

    public function userIsAdmin($uid)
    {
        //return true si l'utilisateur est administrateur
        return $this->db->userIsAdmin($uid);
    }

    public function userIsInstructor($uid)
    {
        //return true si l'utilisateur est administrateur
        return $this->db->userIsInstructor($uid);
    }

    public function userIsPilote($uid)
    {
        //return true si l'utilisateur est administrateur
        return $this->db->userIsPilote($uid);
    }

    public function userIsStudent($uid)
    {
        //return true si l'utilisateur est administrateur
        return $this->db->userIsStudent($uid);
    }

    public function getStudentCourse($uid)
    {
        //retourne le cours suivi par l'eleve.
        return $this->db->getStudentCourse($uid);
    }

    public function isThereUsers() {
      //verifie la presence d'utilisateur dans la base de donnée
      return $this->db->countUsers();
    }
}
