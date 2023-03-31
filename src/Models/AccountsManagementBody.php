<?php
namespace Csupcyber\Pemead\Models;

use Csupcyber\Pemead\Controlers\DataBase;
use \DateTime;

class AccountsManagementBody
{
    public function __construct()
    {
      $this->db = new DataBase();
      ?>

<div class="row g-3 align-items-center p-3">
    <H4>Comptes en attente de validation:</H4>
</div>
<div class="px-3">
  <div class="account-table-container tableFixHead px-3">
    <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Grade / Civilité</th>
        <th scope="col">Nom</th>
        <th scope="col">Prénom</th>
        <th scope="col">Matricule</th>
        <th scope="col">Date de naissance</th>
        <th scope="col">E-mail</th>
        <th scope="col">Privilèges</th>
        <th scope="col">Rôle</th>
        <th scope="col">Groupement</th>
        <th scope="col">Cours</th>
        <th scope="col">Promotion</th>
        <th scope="col"></th>
        <th scope="col"></th>
        <th scope="col"></th>
    </thead>
    <tbody>
      <?php foreach ($this->getNewUsers() as $user) { ?>
        <tr>
        <td><?php echo $user['Grade'] ?></td>
        <td><?php echo $this->db->iocleaner->outputFilter($user['Nom']) ?></td>
        <td><?php echo $user['Prenom'] ?></td>
        <td><?php echo $user['Matricule'] ?></td>
        <td><?php
        $dateOfBirth = explode(" ", $user['DateOfBirth'])[0];
        echo date("d / m / Y", strtotime($dateOfBirth));
         ?></td>
        <td><?php echo $user['Mail'] ?></td>
        <form id="EnabledRoleForm" method="post" action="?view=accountsManagement&process=setUser">
        <?php
        if ($this->userIsStudent($user['UID'])
        && !$this->userIsInstructor($user['UID'])
        && !$this->userIsPilote($user['UID'])) {?>
        <td>
        <?php if ($this->userIsAdmin($user['UID'])) {?>
          <input type="radio" name="Admin" value="on" checked> Administrateur</input><br/>
          <input type="radio" name="Admin" value="off"> Utilisateur</input>
        <?php } else { ?>
          <input type="radio" name="Admin" value="on" > Administrateur</input><br/>
          <input type="radio" name="Admin" value="off" checked> Utilisateur</input>
        <?php }
        ?>
        </td>
        <td>
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Role" id="EnabledRoleSelect<?php echo $user['UID'] ?>">
              <option value="Student" selected>Elève</option>
              <option value="Instructeur">Instructeur</option>
              <option value="Pilote">Pilote de cours</option>
            </select>
        </td>
        <td>

            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select hidden="true" class="form-select" name="Groupement"
            id="EnabledGroupementSelect<?php echo $user['UID'] ?>">
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
            <select hidden="true" class="form-select" name="Course" id="EnabledCourseSelect<?php echo $user['UID'] ?>">
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
            <select class="form-select" name="Promotion" id="EnabledPromoSelect<?php echo $user['UID'] ?>">
            <?php
            $promotion = $this->getStudentPromotion($user['UID']);
            ?>
            <option selected class="text-center" value="<?php echo $promotion['PID'] ?>" selected>
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
        <td>
        <?php if ($this->userIsAdmin($user['UID'])) {?>
          <input type="radio" name="Admin" value="on" checked> Administrateur</input><br/>
          <input type="radio" name="Admin" value="off"> Utilisateur</input>
        <?php } else { ?>
          <input type="radio" name="Admin" value="on" > Administrateur</input><br/>
          <input type="radio" name="Admin" value="off" checked> Utilisateur</input>
        <?php }
        ?>
        </td>
        <td>
            <select class="form-select" name="Role" id="EnabledRoleSelect<?php echo $user['UID'] ?>">
              <option value="Student">Elève</option>
              <option value="Instructeur" selected>Instructeur</option>
              <option value="Pilote">Pilote de cours</option>
            </select>
        </td>
        <td>

            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Groupement" id="EnabledGroupementSelect<?php echo $user['UID'] ?>" >
            <?php
            $groupement = $this->getInstructorGroupement($user['UID']);
            if ($groupement) {
            ?>
            <option class="text-center" value="<?php echo $groupement['GID'] ?>" selected>
            <?php echo $groupement['Groupement'];?></option>
            <?php
            } else { ?>
              <option selected class="text-center" value="None">Selectionner un groupement d'instruction</option>
            <?php
            } foreach ($this->getGroupements() as $groupement) { ?>
            <option class="text-center" value="<?php echo $groupement['GID'] ?>">
            <?php echo $groupement['Groupement'] ?></option>
            <?php
            }?>
            </select>

        </td>
        <td>
        <div id="EnabledCourseForm">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select hidden="true" class="form-select" name="Course" id="EnabledCourseSelect<?php echo $user['UID'] ?>" >
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
            <select hidden="true" class="form-select" name="Promotion"
            id="EnabledPromoSelect<?php echo $user['UID'] ?>">
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

      if ($this->userIsPilote($user['UID'])
      && !$this->userIsStudent($user['UID'])
      && $this->userIsInstructor($user['UID'])) {?>
        <td>
        <?php if ($this->userIsAdmin($user['UID'])) {?>
          <input type="radio" name="Admin" value="on" checked> Administrateur</input><br/>
          <input type="radio" name="Admin" value="off"> Utilisateur</input>
        <?php } else { ?>
          <input type="radio" name="Admin" value="on" > Administrateur</input><br/>
          <input type="radio" name="Admin" value="off" checked> Utilisateur</input>
        <?php }
        ?>
        </td>
        <td>
            <select class="form-select" name="Role" id="EnabledRoleSelect<?php echo $user['UID'] ?>">
              <option value="Student">Elève</option>
              <option value="Instructeur">Instructeur</option>
              <option value="Pilote" selected>Pilote de cours</option>
            </select>
        </td>
        <td>

            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select hidden="true" class="form-select" name="Groupement"
            id="EnabledGroupementSelect<?php echo $user['UID'] ?>">
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
            <select class="form-select" name="Course" id="EnabledCourseSelect<?php echo $user['UID'] ?>">
            <?php
            $cours = $this->getPiloteCourse($user['UID']);
            if ($cours) {
            ?>
            <option class="text-center" value="<?php echo $cours['CID'] ?>" selected>
            <?php echo $cours['Cours'];?></option>
            <?php
            } else { ?>
              <option selected class="text-center" value="None">Selectionner le cours à piloter</option>
            <?php
            } foreach ($this->getCourses() as $course) { ?>
            <option class="text-center" value="<?php echo $course['CID'] ?>">
            <?php echo $course['Cours'] ?></option>
            <?php
            }?>
            </select>
        </td>
        <td>
        <div id="EnabledPromoForm">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select hidden="true" class="form-select" name="Promotion"
            id="EnabledPromoSelect<?php echo $user['UID'] ?>">
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

      if (!$this->userIsPilote($user['UID'])
      && !$this->userIsStudent($user['UID'])
      && !$this->userIsInstructor($user['UID'])) {?>
      <td>
        <?php if ($this->userIsAdmin($user['UID'])) {?>
          <input type="radio" name="Admin" value="on" checked> Administrateur</input><br/>
          <input type="radio" name="Admin" value="off"> Utilisateur</input>
        <?php } else { ?>
          <input type="radio" name="Admin" value="on" > Administrateur</input><br/>
          <input type="radio" name="Admin" value="off" checked> Utilisateur</input>
        <?php }
        ?>
        </td>
        <td>
            <select class="form-select" name="Role" id="EnabledRoleSelect<?php echo $user['UID'] ?>">
              <option value="None" selected>Non définit</option>
              <option value="Student">Elève</option>
              <option value="Instructeur">Instructeur</option>
              <option value="Pilote">Pilote de cours</option>
            </select>
        </td>
        <td>

            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select hidden="true" class="form-select" name="Groupement"
            id="EnabledGroupementSelect<?php echo $user['UID'] ?>">
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
            <select hidden="true" class="form-select" name="Course" id="EnabledCourseSelect<?php echo $user['UID'] ?>" >
            <?php
            $cours = $this->getPiloteCourse($user['UID']);
            if ($cours) {
            ?>
            <option class="text-center" value="<?php echo $cours['CID'] ?>" selected>
            <?php echo $cours['Cours'];?></option>
            <?php
            } else { ?>
              <option selected class="text-center" value="None">Selectionner le cours à piloter</option>
            <?php
            }
            foreach ($this->getCourses() as $course) { ?>
            <option class="text-center" value="<?php echo $course['CID'] ?>">
            <?php echo $course['Cours'] ?></option>
            <?php
            }?>
            </select>
        </td>
        <td>
        <div id="EnabledPromoForm">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select hidden="true" class="form-select" name="Promotion"
            id="EnabledPromoSelect<?php echo $user['UID'] ?>">
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
            <button type="submit" class="btn btn-info">Modifier</button>
          </form>
        </td>
        <td>
          <form class="col-5" method="post" action="?view=accountsManagement&process=validUser">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <input type="hidden" name="ValidatedUser" value="<?php echo $user['UID'] ?>" />
            <button type="submit" class="btn btn-success">Valider</button>
          </form>
        </td>
        <td>
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
    </div>

<!---->
<div class="row g-3 align-items-center p-3">
    <H4>Comptes actifs:</H4>
</div>
<div class="px-3">
  <div class="account-table-container tableFixHead px-3">
    <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Grade / Civilité</th>
        <th scope="col">Nom</th>
        <th scope="col">Prénom</th>
        <th scope="col">Matricule</th>
        <th scope="col">Date de naissance</th>
        <th scope="col">E-mail</th>
        <th scope="col">Privilèges</th>
        <th scope="col">Rôle</th>
        <th scope="col">Groupement</th>
        <th scope="col">Cours</th>
        <th scope="col">Promotion</th>
        <th scope="col"></th>
        <th scope="col"></th>
        <th scope="col"></th>
    </thead>
    <tbody>
      <?php foreach ($this->getEnabledUsers() as $user) { ?>
      <tr>
        <td><?php echo $user['Grade'] ?></td>
        <td><?php echo $this->db->iocleaner->outputFilter($user['Nom']) ?></td>
        <td><?php echo $user['Prenom'] ?></td>
        <td><?php echo $user['Matricule'] ?></td>
        <td>
        <?php
        $dateOfBirth = explode(" ", $user['DateOfBirth'])[0];
        echo date("d / m / Y", strtotime($dateOfBirth));
        ?></td>
        <td><?php echo $user['Mail'] ?></td>
        <form id="EnabledRoleForm" method="post" action="?view=accountsManagement&process=setUser">
        <?php
        if ($this->userIsStudent($user['UID'])
        && !$this->userIsInstructor($user['UID'])
        && !$this->userIsPilote($user['UID'])) {?>
        <td>
        <?php if ($this->userIsAdmin($user['UID'])) {?>
          <input type="radio" name="Admin" value="on" checked> Administrateur</input><br/>
          <input type="radio" name="Admin" value="off"> Utilisateur</input>
        <?php } else { ?>
          <input type="radio" name="Admin" value="on" > Administrateur</input><br/>
          <input type="radio" name="Admin" value="off" checked> Utilisateur</input>
        <?php }
        ?>
        </td>
        <td>
            <select class="form-select" name="Role" id="EnabledRoleSelect<?php echo $user['UID'] ?>">
              <option value="Student" selected>Elève</option>
              <option value="Instructeur">Instructeur</option>
              <option value="Pilote">Pilote de cours</option>
            </select>
        </td>
        <td>

            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select hidden="true" class="form-select" name="Groupement"
            id="EnabledGroupementSelect<?php echo $user['UID'] ?>" >
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
            <select hidden="true" class="form-select" name="Course" id="EnabledCourseSelect<?php echo $user['UID'] ?>" >
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
            <select class="form-select" name="Promotion" id="EnabledPromoSelect<?php echo $user['UID'] ?>" >
            <?php
            $promotion = $this->getStudentPromotion($user['UID']);
            ?>
            <option selected class="text-center" value="<?php echo $promotion['PID'] ?>" selected>
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
        <td>
        <?php if ($this->userIsAdmin($user['UID'])) {?>
          <input type="radio" name="Admin" value="on" checked> Administrateur</input><br/>
          <input type="radio" name="Admin" value="off"> Utilisateur</input>
        <?php } else { ?>
          <input type="radio" name="Admin" value="on" > Administrateur</input><br/>
          <input type="radio" name="Admin" value="off" checked> Utilisateur</input>
        <?php }
        ?>
        </td>
        <td>
            <select class="form-select" name="Role" id="EnabledRoleSelect<?php echo $user['UID'] ?>">
              <option value="Student">Elève</option>
              <option value="Instructeur" selected>Instructeur</option>
              <option value="Pilote">Pilote de cours</option>
            </select>
        </td>
        <td>

            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Groupement" id="EnabledGroupementSelect<?php echo $user['UID'] ?>" >
            <?php
            $groupement = $this->getInstructorGroupement($user['UID']);
            if ($groupement) {
            ?>
            <option class="text-center" value="<?php echo $groupement['GID'] ?>" selected>
            <?php echo $groupement['Groupement'];?></option>
            <?php
            } else { ?>
              <option selected class="text-center" value="None">Selectionner un groupement d'instruction</option>
            <?php
            } foreach ($this->getGroupements() as $groupement) { ?>
            <option class="text-center" value="<?php echo $groupement['GID'] ?>">
            <?php echo $groupement['Groupement'] ?></option>
            <?php
            }?>
            </select>

        </td>
        <td>
        <div id="EnabledCourseForm">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select hidden="true" class="form-select" name="Course" id="EnabledCourseSelect<?php echo $user['UID'] ?>">
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
            <select hidden="true" class="form-select" name="Promotion"
            id="EnabledPromoSelect<?php echo $user['UID'] ?>">
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

      if ($this->userIsPilote($user['UID'])
      && !$this->userIsStudent($user['UID'])
      && $this->userIsInstructor($user['UID'])) {?>
        <td>
        <?php if ($this->userIsAdmin($user['UID'])) {?>
          <input type="radio" name="Admin" value="on" checked> Administrateur</input><br/>
          <input type="radio" name="Admin" value="off"> Utilisateur</input>
        <?php } else { ?>
          <input type="radio" name="Admin" value="on" > Administrateur</input><br/>
          <input type="radio" name="Admin" value="off" checked> Utilisateur</input>
        <?php }
        ?>
        </td>
        <td>
            <select class="form-select" name="Role" id="EnabledRoleSelect<?php echo $user['UID'] ?>">
              <option value="Student">Elève</option>
              <option value="Instructeur">Instructeur</option>
              <option value="Pilote" selected>Pilote de cours</option>
            </select>
        </td>
        <td>

            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select hidden="true" class="form-select" name="Groupement"
            id="EnabledGroupementSelect<?php echo $user['UID'] ?>">
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
            <?php
            $cours = $this->getPiloteCourse($user['UID']);
            if ($cours) {
            ?>
            <option class="text-center" value="<?php echo $cours['CID'] ?>" selected>
            <?php echo $cours['Cours'];?></option>
            <?php
            } else { ?>
              <option selected class="text-center" value="None">Selectionner le cours à piloter</option>
            <?php
            } foreach ($this->getCourses() as $course) { ?>
            <option class="text-center" value="<?php echo $course['CID'] ?>">
            <?php echo $course['Cours'] ?></option>
            <?php
            }?>
            </select>
        </td>
        <td>
        <div id="EnabledPromoForm">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select hidden="true" class="form-select" name="Promotion"
            id="EnabledPromoSelect<?php echo $user['UID'] ?>">
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

      if (!$this->userIsPilote($user['UID'])
      && !$this->userIsStudent($user['UID'])
      && !$this->userIsInstructor($user['UID'])) {?>
        <td>
        <?php if ($this->userIsAdmin($user['UID'])) {?>
          <input type="radio" name="Admin" value="on" checked> Administrateur</input><br/>
          <input type="radio" name="Admin" value="off"> Utilisateur</input>
        <?php } else { ?>
          <input type="radio" name="Admin" value="on" > Administrateur</input><br/>
          <input type="radio" name="Admin" value="off" checked> Utilisateur</input>
        <?php }
        ?>
        </td>
        <td>
            <select class="form-select" name="Role" id="EnabledRoleSelect<?php echo $user['UID'] ?>">
              <option value="None" selected>Non définit</option>
              <option value="Student">Elève</option>
              <option value="Instructeur">Instructeur</option>
              <option value="Pilote">Pilote de cours</option>
            </select>
        </td>
        <td>

            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select hidden="true" class="form-select" name="Groupement"
            id="EnabledGroupementSelect<?php echo $user['UID'] ?>">
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
            <select hidden="true" class="form-select" name="Course" id="EnabledCourseSelect<?php echo $user['UID'] ?>" >
            <?php
            $cours = $this->getPiloteCourse($user['UID']);
            if ($cours) {
            ?>
            <option class="text-center" value="<?php echo $cours['CID'] ?>" selected>
            <?php echo $cours['Cours'];?></option>
            <?php
            } else { ?>
              <option selected class="text-center" value="None">Selectionner le cours à piloter</option>
            <?php
            }
            foreach ($this->getCourses() as $course) { ?>
            <option class="text-center" value="<?php echo $course['CID'] ?>">
            <?php echo $course['Cours'] ?></option>
            <?php
            }?>
            </select>
        </td>
        <td>
        <div id="EnabledPromoForm">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select hidden="true" class="form-select" name="Promotion"
            id="EnabledPromoSelect<?php echo $user['UID'] ?>">
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
      </td>
      <td>
          <form method="post" action="?view=accountsManagement&process=disableUser">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <input type="hidden" name="DisabledUser" value="<?php echo $user['UID'] ?>" />
            <button type="submit" class="col-12 btn btn-warning">Désactiver</button>
          </form>
      </td>
      <td>
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

    public function getInstructorGroupement($uid)
    {
        //retourne le cours suivi par l'eleve.
        return $this->db->getInstructorGroupement($uid);
    }

    public function getPiloteCourse($uid)
    {
        //retourne le cours suivi par l'eleve.
        return $this->db->getPiloteCourse($uid);
    }

}