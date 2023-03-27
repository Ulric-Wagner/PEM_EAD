<?php
namespace Csupcyber\Pemead\Models;

use Csupcyber\Pemead\Controlers\DataBase;

class AccountsManagementBody
{
    public function __construct()
    {
      $this->db = new DataBase();
      ?>

<div class="d-flex justify-content-center p-2">
  <div class="col-8 text-center">
    <H3>Gestion des comptes:</H3>
  </div>
</div>
<div class="account-table-container tableFixHead p-5">
  <table class="table table-hover">
  <figcaption><H5>Utilisateurs en attente de validation:</H5></figcaption>
    <thead>
      <tr>
        <th scope="col">UID</th>
        <th scope="col">Grade / Civilité</th>
        <th scope="col">Nom</th>
        <th scope="col">Prénom</th>
        <th scope="col">Matricule</th>
        <th scope="col">E-mail</th>
        <th scope="col">Cours</th>
        <th scope="col">Promotion</th>
        <th scope="col">Rôle</th>
        <th scope="col"></th>
    </thead>
    <tbody>
      <?php foreach ($this->getNewUsers() as $user) { ?>
      <tr>
        <th scope="row"><?php echo $user['UID'] ?></th>
        <td><?php echo $user['Grade'] ?></td>
        <td><?php echo $user['Nom'] ?></td>
        <td><?php echo $user['Prenom'] ?></td>
        <td><?php echo $user['Matricule'] ?></td>
        <td><?php echo $user['Mail'] ?></td>
        <td>
          <form id="DisabledCourseForm" method="post" action="?view=accountsManagement&process=setCourse">
            <input type="hidden" name="UID" value="<?php echo $_SESSION['UID']; ?>">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="DisabledCourseSelect" >
              <option value="Student">Test</option>
            </select>
          </form>
        </td>
        <td>
          <form id="DisabledPromoForm" method="post" action="?view=accountsManagement&process=setPromo">
            <input type="hidden" name="UID" value="<?php echo $_SESSION['UID']; ?>">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="DisabledPromoSelect" >
            <option value="Student">Test</option>
            
            </select>
          </form>
        </td>
        <td>
          <form id="DisabledRoleForm" method="post" action="?view=accountsManagement&process=setRole">
            <input type="hidden" name="UID" value="<?php echo $_SESSION['UID']; ?>">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="DisabledRoleSelect" >
              <option value="Student">Elève</option>
              <option value="Instructeur">Instructeur</option>
              <option value="Administrateur">Administrateur</option>
            </select>
          </form>
        </td>
        <td class="row">
          <form class="col-5" method="post" action="?view=accountsManagement&process=validUser">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <input type="hidden" name="ValidatedUser" value="<?php echo $user['UID'] ?>" />
            <button type="submit" class="btn btn-success">Valider</button>
          </form>
          <form class="col-5" method="post" action="?view=accountsManagement&process=rejectUser">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <input type="hidden" name="RejectedUser" value="<?php echo $user['UID'] ?>" />
            <button type="submit" class="btn btn-danger">Rejeter</button>
          </form>

        </td>
        
      </tr>
      <?php
      } ?>
    </tbody>
  </table>
</div>

<!---->

<div class="account-table-container tableFixHead p-5">
  <table class="table table-hover">
  <figcaption><H5>Utilisateurs actifs:</H5></figcaption>
    <thead>
      <tr>
        <th scope="col">UID</th>
        <th scope="col">Grade / Civilité</th>
        <th scope="col">Nom</th>
        <th scope="col">Prénom</th>
        <th scope="col">Matricule</th>
        <th scope="col">E-mail</th>
        <th scope="col">Rôle</th>
        <th scope="col">Groupement</th>
        <th scope="col">Cours</th>
        <th scope="col">Promotion</th>
        <th scope="col"></th>
    </thead>
    <tbody>
      <?php foreach ($this->getEnabledUsers() as $user) { ?>
      <tr>
        <th scope="row"><?php echo $user['UID'] ?></th>
        <td><?php echo $user['Grade'] ?></td>
        <td><?php echo $user['Nom'] ?></td>
        <td><?php echo $user['Prenom'] ?></td>
        <td><?php echo $user['Matricule'] ?></td>
        <td><?php echo $user['Mail'] ?></td>
        <td>
        <?php
        if ($this->userIsStudent($user['UID'])
        && !$this->userIsInstructor($user['UID'])
        && !$this->userIsPilote($user['UID'])) {?>
        <div id="EnabledRoleForm" method="post" action="?view=accountsManagement&process=setUser">
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledRoleSelect<?php echo $user['UID'] ?>">
              <option value="Student" selected>Elève</option>
              <option value="Instructeur">Instructeur</option>
              <option value="Pilote">Pilote de cours</option>
            </select>
        </td>
        <td>

            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Groupement" id="EnabledGroupementSelect<?php echo $user['UID'] ?>" >
            <option selected class="text-center">Selectionner votre groupement d'instruction</option>
            <?php foreach ($this->getGroupements() as $groupement) { ?>
            <option class="text-center" value="<?php echo $groupement['GID'] ?>">
            <?php echo $groupement['Groupement'] ?></option>
            <?php
            }?>
            </select>

        </td>
        <td>
        <div id="EnabledCourseForm">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledCourseSelect<?php echo $user['UID'] ?>" >
            <option selected class="text-center">Selectionner le cours que vous allez piloter</option>
            <?php foreach ($this->getCourses() as $course) { ?>
            <option class="text-center" value="<?php echo $course['CID'] ?>">
            <?php echo $course['Cours'] ?></option>
            <?php
            }?>
            </select>
        </td>
        <td>
        <div id="EnabledPromoForm">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledPromoSelect<?php echo $user['UID'] ?>" >
            <?php
            $promotion = $this->getStudentPromotion($user['UID']);
            ?>
            <option class="text-center" value="<?php echo $promotion['PID'] ?>" selected>
            <?php echo $promotion['Cours'].' '.$promotion['Promotion'];?></option>
            <?php foreach ($this->getPromotions() as $promotion) { ?>
            <option class="text-center" value="<?php echo $promotion['PID'] ?>">
            <?php echo $promotion['Cours'].' '.$promotion['Promotion'] ?></option>
            <?php
            }?>
            </select>
        </td>
        <?php
      }
      
      if ($this->userIsInstructor($user['UID'])
      && !$this->userIsStudent($user['UID'])
      && !$this->userIsPilote($user['UID'])) {?>
        <div id="EnabledRoleForm" method="post" action="?view=accountsManagement&process=setUser">
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledRoleSelect<?php echo $user['UID'] ?>">
              <option value="Student">Elève</option>
              <option value="Instructeur" selected>Instructeur</option>
              <option value="Pilote">Pilote de cours</option>
            </select>
        </td>
        <td>

            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Groupement" id="EnabledGroupementSelect<?php echo $user['UID'] ?>" >
            <option selected class="text-center">Selectionner votre groupement d'instruction</option>
            <?php foreach ($this->getGroupements() as $groupement) { ?>
            <option class="text-center" value="<?php echo $groupement['GID'] ?>">
            <?php echo $groupement['Groupement'] ?></option>
            <?php
            }?>
            </select>

        </td>
        <td>
        <div id="EnabledCourseForm">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledCourseSelect<?php echo $user['UID'] ?>" >
            <option selected class="text-center">Selectionner le cours que vous allez piloter</option>
            <?php foreach ($this->getCourses() as $course) { ?>
            <option class="text-center" value="<?php echo $course['CID'] ?>">
            <?php echo $course['Cours'] ?></option>
            <?php
            }?>
            </select>
        </td>
        <td>
        <div id="EnabledPromoForm">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledPromoSelect<?php echo $user['UID'] ?>" >
            <?php
            $promotion = $this->getStudentPromotion($user['UID']);
            if ($promotion) {
            ?>
            <option class="text-center" value="<?php echo $promotion['PID'] ?>" selected>
            <?php echo $promotion['Cours'].' '.$promotion['Promotion'];?></option>
            <?php
            }
            if ($this->getPromotions()) {
              foreach ($this->getPromotions() as $promotion) { ?>
            <option class="text-center" value="<?php echo $promotion['PID'] ?>">
            <?php echo $promotion['Cours'].' '.$promotion['Promotion'] ?></option>
            <?php
            }
          }?>
            </select>
        </td>
        <?php
      }

      if ($this->userIsPilote($user['UID'])
      && !$this->userIsStudent($user['UID'])
      && $this->userIsInstructor($user['UID'])) {?>
        <div id="EnabledRoleForm" method="post" action="?view=accountsManagement&process=setUser">
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledRoleSelect<?php echo $user['UID'] ?>">
              <option value="Student">Elève</option>
              <option value="Instructeur"Instructeur</option>
              <option value="Pilote" selected>Pilote de cours</option>
            </select>
        </td>
        <td>

            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Groupement" id="EnabledGroupementSelect<?php echo $user['UID'] ?>" >
            <option selected class="text-center">Selectionner votre groupement d'instruction</option>
            <?php foreach ($this->getGroupements() as $groupement) { ?>
            <option class="text-center" value="<?php echo $groupement['GID'] ?>">
            <?php echo $groupement['Groupement'] ?></option>
            <?php
            }?>
            </select>

        </td>
        <td>
        <div id="EnabledCourseForm">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledCourseSelect<?php echo $user['UID'] ?>" >
            <option selected class="text-center">Selectionner le cours que vous allez piloter</option>
            <?php foreach ($this->getCourses() as $course) { ?>
            <option class="text-center" value="<?php echo $course['CID'] ?>">
            <?php echo $course['Cours'] ?></option>
            <?php
            }?>
            </select>
        </td>
        <td>
        <div id="EnabledPromoForm">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledPromoSelect<?php echo $user['UID'] ?>" >
            <?php
            $promotion = $this->getStudentPromotion($user['UID']);
            if ($promotion) {
            ?>
            <option class="text-center" value="<?php echo $promotion['PID'] ?>" selected>
            <?php echo $promotion['Cours'].' '.$promotion['Promotion'];?></option>
            <?php
            }
            if ($this->getPromotions()) {
              foreach ($this->getPromotions() as $promotion) { ?>
            <option class="text-center" value="<?php echo $promotion['PID'] ?>">
            <?php echo $promotion['Cours'].' '.$promotion['Promotion'] ?></option>
            <?php
            }
          }?>
            </select>
        </td>
        <?php
      }

      if (!$this->userIsPilote($user['UID'])
      && !$this->userIsStudent($user['UID'])
      && !$this->userIsInstructor($user['UID'])) {?>
        <div id="EnabledRoleForm" method="post" action="?view=accountsManagement&process=setUser">
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledRoleSelect<?php echo $user['UID'] ?>">
              <option value="None" selected>Non définit</option>
              <option value="Student">Elève</option>
              <option value="Instructeur">Instructeur</option>
              <option value="Pilote">Pilote de cours</option>
            </select>
        </td>
        <td>

            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Groupement" id="EnabledGroupementSelect<?php echo $user['UID'] ?>" >
            <option selected class="text-center" value="None">Selectionner un groupement d'instruction</option>
            <?php foreach ($this->getGroupements() as $groupement) { ?>
            <option class="text-center" value="<?php echo $groupement['GID'] ?>">
            <?php echo $groupement['Groupement'] ?></option>
            <?php
            }?>
            </select>

        </td>
        <td>
        <div id="EnabledCourseForm">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledCourseSelect<?php echo $user['UID'] ?>" >
            <option selected class="text-center" value="None">Selectionner le cours à piloter</option>
            <?php foreach ($this->getCourses() as $course) { ?>
            <option class="text-center" value="<?php echo $course['CID'] ?>">
            <?php echo $course['Cours'] ?></option>
            <?php
            }?>
            </select>
        </td>
        <td>
        <div id="EnabledPromoForm">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledPromoSelect<?php echo $user['UID'] ?>" >
            <option selected class="text-center" value="None">Selectionner une promotion</option>
            <?php
            $promotion = $this->getStudentPromotion($user['UID']);
            if ($promotion) {
            ?>
            <option class="text-center" value="<?php echo $promotion['PID'] ?>" selected>
            <?php echo $promotion['Cours'].' '.$promotion['Promotion'];?></option>
            <?php
            }
            if ($this->getPromotions()) {
              foreach ($this->getPromotions() as $promotion) { ?>
            <option class="text-center" value="<?php echo $promotion['PID'] ?>">
            <?php echo $promotion['Cours'].' '.$promotion['Promotion'] ?></option>
            <?php
            }
          }?>
            </select>
        </td>
        <?php
      }
        ?>

        
        <td>
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <input type="hidden" name="EditedUser" value="<?php echo $user['UID'] ?>" />
            <button type="submit" class="col-12 btn btn-success">Modifier</button>
          </form>
          <form method="post" action="?view=accountsManagement&process=disableUser">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <input type="hidden" name="DisabledUser" value="<?php echo $user['UID'] ?>" />
            <button type="submit" class="col-12 btn btn-warning">Désactiver</button>
          </form>
          <form method="post" action="?view=accountsManagement&process=rejectUser">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <input type="hidden" name="RejectedUser" value="<?php echo $user['UID'] ?>" />
            <button type="submit" class="col-12 btn btn-danger">Supprimer</button>
          </form>
        </td>
      </tr>
      <?php
      } ?>
    </tbody>
  </table>
</div>
<?php }

      public function getNewUsers()
      {
        return $this->db->getNewUsers();
      }

      public function getEnabledUsers()
      {
        return $this->db->getEnabledUsers();
      }

      public function userIsAdmin($uid)
    {
        return $this->db->userIsAdmin($uid);
    }

    public function userIsPilote($uid)
    {
        return $this->db->userIsPilote($uid);
    }

    public function userIsInstructor($uid)
    {
        return $this->db->userIsInstructor($uid);
    }

    public function userIsStudent($uid)
    {
        return $this->db->userIsStudent($uid);
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

    public function deleteFromAdmins($uid)
    {
        //supprime l'utilisateur de la table administrateurs
        return $this->db->deleteFromAdmins($uid);
    }

    public function deleteFromPilotes($uid)
    {
        //supprime l'utilisateur de la table pilotes
        return $this->db->deleteFromPilotes($uid);
    }

    public function deleteFromInstructeurs($uid)
    {
        //supprime l'utilisateur de la table instructeurs
        return $this->db->deleteFromInstructeurs($uid);
    }

    public function deleteFromStudents($uid)
    {
        //supprime l'utilisateur de la table students
        return $this->db->deleteFromStudents($uid);
    }

    public function getStudentPromotion($uid)
    {
        //retourne le cours suivi par l'eleve.
        return $this->db->getStudentPromotion($uid);
    }

}