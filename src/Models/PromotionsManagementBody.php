<?php
namespace Csupcyber\Pemead\Models;

use Csupcyber\Pemead\Controlers\DataBase;

class PromotionsManagementBody
{
    public function __construct()
    {
      $this->db = new DataBase();
      ?>


<div class="row g-3 align-items-center p-3">
  <div>
    <H3>Créer une promotion:</H3>
  </div>
  <form method="post" action="?view=promotionsManagement&process=createPromotion">
    <div class="row g-3 align-items-center">
      <div class="col-auto">
        <label for="createPromotion" class="col-form-label">Nom de la promotion</label>
        </div>
        <div class="col-auto">
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
          <input type="text" name="createPromotion" id="createPromotion"
          class="form-control" aria-describedby="HelpInline">
        </div>
        <div class="col-auto">
          <select class="form-select" name="CID">
            <option selected>Selectionner un cours pour cette promotion</option>
            <?php foreach ($this->getCourses() as $course) { ?>
            <option value="<?php echo $course['CID'] ?>">
            <?php echo $course['Cours'] ?></option>
            <?php
            } ?>
          </select>
        </div>
        <div class="col-auto">
          <button type="submit"  class="btn btn-secondary btn-block confirmButton">Créer</button>
        </div>
      </div>
    </form>

</div>
<!--  -->
</div>
<div class="px-3">
  <div class="course-table-container tableFixHead px-3">
    <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">CID</th>
        <th scope="col">Nom du cours</th>
        <th scope="col">PID</th>
        <th scope="col">Nom/N° de la Promotion</th>
        <th scope="col">Renommer la promotion</th>
        <th scope="col"></th>
        <th scope="col"></th>
    </thead>
    <tbody>
    <?php foreach ($this->getPromotions() as $promotion) { ?>
        <tr>
          <th scope="row"><?php echo $promotion['CID'] ?></th>
          <td><?php echo $promotion['Cours'] ?></td>
          <td><?php echo $promotion['PID'] ?></td>
          <td><?php echo $promotion['Promotion'] ?></td>
          <td>
          <form method="post" action="?view=promotionsManagement&process=renamePromotion">
            <div class="row g-3 align-items-center">
              <div class="col-auto">
                <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
                <input type="text" name="newPromotionName" id="newPromotionName"
                class="form-control" aria-describedby="HelpInline">
                <input type="hidden" name="PID" value="<?php echo $promotion['PID'] ?>" />
              </div>
            
        </td>
        <td>
            <button type="submit"  class="btn btn-info confirmButton">Renommer</button>
            </form>
          </td>
          <td>
            <form method="post" action="?view=promotionsManagement&process=removePromotion">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
              <input type="hidden" name="removePromotion" value="<?php echo $promotion['PID'] ?>" />
              <button type="submit"  class="btn btn-danger confirmButton">Supprimer</button>
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

      public function getCourses()
      {
        return $this->db->getCourses();
      }

      public function getPromotions()
      {
        return $this->db->getPromotions();
      }
}