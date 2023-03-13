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
    <H3>Gestions des comptes:</H3>
  </div>
</div>
<div class="p-5">
  <table class="table">
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
        <td><?php echo $user['Mail'] ?></td>
        <td><?php echo $user['Mail'] ?></td>
        <td><?php echo $user['Mail'] ?></td>
        <td class="row">
          <form class="col-6" method="post" action="?process=validUser">
            <input type="hidden" name="ValidatedUser" value="<?php echo $user['UID'] ?>" />
            <button type="submit" class="btn btn-success">Valider</button>
          </form>
          <form class="col-6" method="post" action="?process=rejectUser">
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
<?php }

      public function getNewUsers()
      {
        return $this->db->getNewUsers();
      }
}