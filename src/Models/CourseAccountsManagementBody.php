<?php
namespace Csupcyber\Pemead\Models;

use Csupcyber\Pemead\Controlers\DataBase;

class CourseAccountsManagementBody
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
            <select class="form-select"  name="Course" id="DisabledPromoSelect" >
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
        <th scope="col">Cours</th>
        <th scope="col">Promotion</th>
        <th scope="col">Rôle</th>
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
        <form id="EnabledCourseForm" method="post" action="?view=accountsManagement&process=setCourse">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledCourseSelect" >
            <option value="Student">Test</option>
            </select>
          </form>
        </td>
        <td>
        <form id="EnabledPromoForm" method="post" action="?view=accountsManagement&process=setPromo">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledPromoSelect" >
            <option value="Student">Test</option>
            </select>
          </form>
        </td>
        <td>
        <form id="EnabledRoleForm" method="post" action="?view=accountsManagement&process=setRole">
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledRoleSelect">
              <option value="Student">Elève</option>
              <option value="Instructeur">Instructeur</option>
              <option value="Administrateur">Administrateur</option>
            </select>
          </form>
        </td>
        <td class="row">
          <form class="col-5" method="post" action="?view=accountsManagement&process=disableUser">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <input type="hidden" name="DisabledUser" value="<?php echo $user['UID'] ?>" />
            <button type="submit" class="btn btn-warning">Désactiver</button>
          </form>
          <form class="col-5" method="post" action="?view=accountsManagement&process=rejectUser">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <input type="hidden" name="RejectedUser" value="<?php echo $user['UID'] ?>" />
            <button type="submit" class="btn btn-danger">Supprimer</button>
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
}