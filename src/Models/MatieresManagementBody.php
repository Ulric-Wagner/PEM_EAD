<?php
namespace Csupcyber\Pemead\Models;

use Csupcyber\Pemead\Controlers\DataBase;
use Csupcyber\Pemead\Controlers\FilesManagement;

class MatieresManagementBody
{
    public function __construct()
    {
      $this->db = new DataBase();
      $this->files = new FilesManagement();

      //traitement de la supresion
      $this->files->removeMatiere();
      ?>

<div class="d-flex justify-content-center p-2">
  <div class="col-8 text-center">
    <H3>Gestion des matières:</H3>
  </div>
</div>

<div class="row g-3 align-items-center p-5">
  <div>
    <H3>Créer une matière:</H3>
  </div>
  <form method="post" action="?view=matieresCreation&process=createMatiere">
    <div class="row g-3 align-items-center">
      <div class="col-auto">
        <label for="createMatiere" class="col-form-label">Nom de la matiere</label>
        </div>
        <div class="col-auto">
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
          <input type="text" name="createMatiere" id="createMatiere"
          class="form-control" aria-describedby="HelpInline">
        </div>
        <div class="col-auto">
          <select class="form-select" name="CID">
            <?php foreach ($this->db->getCourseByCID($_SESSION['PiloteCID']) as $course) { ?>
            <option value="<?php echo $course['CID'] ?>">
            <?php echo $course['Cours'] ?></option>
            <?php
            } ?>
          </select>
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-secondary btn-block confirmButton">Créer</button>
        </div>
      </div>
    </form>

</div>
<!--  -->
</div>
<div class="course-table-container tableFixHead px-5">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Nom de la matière</th>
        <th scope="col">Nom du cours</th>
        <th scope="col"></th>
    </thead>
    <tbody>
    <?php foreach ($this->db->getCourseMatieres($_SESSION['PiloteCID']) as $Matiere) { ?>
        <tr>
          <td><?php echo $Matiere['Matiere'] ?></td>
          <td><?php echo $Matiere['Cours'] ?></td>
          <td>
        <form method="post">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <input type="hidden" name="Remove" value="<?php echo $Matiere['MID'] ?>" />
            <button type="submit" class="col-12 btn btn-danger confirmButton">
            Supprimer</button>
          </form>
        </td>
        </tr>
        <?php
        } ?>
    </tbody>
  </table>
</div>
<?php }

      public function getCourses()
      {
        return $this->db->getCourses();
      }

      public function getMatieres()
      {
        return $this->db->getMatieres();
      }
}