<?php
namespace Csupcyber\Pemead\Models;

use Csupcyber\Pemead\Controlers\DataBase;
use Csupcyber\Pemead\Controlers\IOCleaner;

class EvalsManagementBody
{
    public function __construct()
    {
      $this->db = new DataBase();
      $this->iocleaner = new IOCleaner();

      //création d'une éval, activation, desactivation et suppression
      $this->db->createEval();
      $this->db->enableEval();
      $this->db->disableEval();
      $this->db->removeEval();

      ?>

<div class="px-3">
  <div class="row g-3 align-items-center p-5">
    <div>
      <H3>Préparer une évaluation:</H3>
    </div>
    <form method="post">
      <div class="row g-3 align-items-center">
      <div class="col-auto">
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
          <select class="form-select" name="ETID">
            <option selected>Selectionner un template</option>
            <?php foreach ($this->db->getEvalTemplates() as $Eval) { ?>
            <option value="<?php echo $Eval['ETID'] ?>">
            <?php echo $Eval['Cours'] ?> <?php echo $Eval['Eval'] ?></option>
            <?php
            } ?>
          </select>
        </div>
          <div class="col-auto">
          <select class="form-select" name="PID">
            <option selected>Selectionner une promotion</option>
            <?php foreach ($this->db->getPromotions() as $Promotion) { ?>
            <option value="<?php echo $Promotion['PID'] ?>">
            <?php echo $Promotion['Cours'] ?> <?php echo $Promotion['Promotion'] ?></option>
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
</div>
<?php
 $this->showEval();

  }

  public function showEval()
  {
    ?>
<div class="matieres-container px-3">
  <div class="px-2">
    <div class="row row-cols-1 row-cols-md-1 g-1">
      <?php
      foreach ($this->db->getEvals() as $eval) { ?>
      <div class="col">
        <div class="card bg-light">
          <div class="text-dark">
            <div class="d-flex card-header">
              <a href="#eval<?php echo  $this->iocleaner->outputFilter($eval['ETID'])?>"
              class="card-link btn btn-info" data-bs-toggle="collapse">+</a>
              <div class="p-2 col-6">
                <?php echo  $this->iocleaner->outputFilter($eval['Cours']) ?> ->
                <?php echo  $this->iocleaner->outputFilter($eval['Matiere'])?> ->
                <?php echo  $this->iocleaner->outputFilter($eval['Eval'])?>
              </div>
              <form method="post">
                  <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
                  <input type="hidden" name="EnableEAID"
                  value="<?php echo  $this->iocleaner->outputFilter($eval['EAID'])?>">
                  
                  <div class="col-auto">
                    <button type="submit" 
                    class="btn btn-info btn-block confirmButton"
                    <?php if ($eval['Statut'] === 1) {echo "disabled";}?>>Démarrer l'évaluation</button>
                  </div>
                </form>
              <form method="post">
                  <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
                  <input type="hidden" name="DisableEAID"
                  value="<?php echo  $this->iocleaner->outputFilter($eval['EAID'])?>">
                  
                  <div class="col-auto">
                    <button type="submit" 
                    class="btn btn-warning btn-block confirmButton"
                    <?php if ($eval['Statut'] === 0) {echo "disabled";}?>>Terminer l'évaluation</button>
                  </div>
                </form>
                <form method="post">
                  <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
                  <input type="hidden" name="RemoveEAID"
                  value="<?php echo  $this->iocleaner->outputFilter($eval['EAID'])?>">
                  
                  <div class="col-auto">
                    <button type="submit" 
                    class="btn btn-danger btn-block confirmButton"
                    <?php if ($eval['Statut'] === 1) {echo "disabled";}?>>Suprimer l'évaluation</button>
                  </div>
                </form>

            </div>
            <div class="card-body collapse" id="eval<?php echo  $this->iocleaner->outputFilter($eval['ETID'])?>">
              ...
              
            
      </div>
      <?php
      }
      ?>

  </div>
</div>
      <?php
  }
}