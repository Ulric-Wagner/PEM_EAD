<?php
namespace Csupcyber\Pemead\Models;

use Csupcyber\Pemead\Controlers\DataBase;

class GroupementsManagementBody
{
    public function __construct()
    {
      $this->db = new DataBase();
      ?>


<div class="d-flex justify-content-center p-2">
  <div class="col-8 text-center">
    <H3>Gestion des groupements:</H3>
  </div>
</div>
<div class="px-5">
  <div class="row g-3 align-items-center p-5">
    <div>
      <H3>Créer un groupement:</H3>
    </div>
    <form method="post" action="?view=groupementsManagement&process=createGroupement">
      <div class="row g-3 align-items-center">
        <div class="col-auto">
          <label for="createGroupement" class="col-form-label">Nom du groupement</label>
          </div>
          <div class="col-auto">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <input type="text" name="createGroupement" id="createGroupement"
            class="form-control" aria-describedby="HelpInline">
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-secondary btn-block">Créer</button>
          </div>
        </div>
      </form>
    </div>
</div>
<!--  -->
</div>
<div class="px-5">
  <div class="course-table-container tableFixHead px-5">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">GID</th>
          <th scope="col">Nom du groupement</th>
          <th scope="col">Nouveau nom</th>
          <th scope="col"></th>
          <th scope="col"></th>
      </thead>
      <tbody>
        <?php foreach ($this->getGroupements() as $groupement) { ?>
        <tr>
          <th scope="row"><?php echo $groupement['GID'] ?></th>
          <td><?php echo $groupement['Groupement'] ?></td>
          <td>
          <form method="post" action="?view=groupementsManagement&process=renameGroupement">
            <div class="row g-3 align-items-center">
              <div class="col-auto">
                <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
                <input type="text" name="newGroupementName" id="newGroupementName"
                class="form-control" aria-describedby="HelpInline">
                <input type="hidden" name="GID" value="<?php echo $groupement['GID'] ?>" />
              </div>
            
        </td>
        <td>
            <button type="submit" class="btn btn-info">Renommer</button>
            </form>
          </td>
          <td>
            <form method="post" action="?view=groupementsManagement&process=removeGroupement">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
              <input type="hidden" name="removeGroupement" value="<?php echo $groupement['GID'] ?>" />
              <button type="submit" class="btn btn-danger">Supprimer</button>
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

      public function getGroupements()
      {
        return $this->db->getGroupements();
      }
}