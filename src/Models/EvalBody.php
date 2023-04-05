<?php
namespace Csupcyber\Pemead\Models;

use Csupcyber\Pemead\Controlers\DataBase;
use Csupcyber\Pemead\Controlers\IOCleaner;

class EvalBody
{
    public function __construct()
    {
      $this->db = new DataBase();
      $this->iocleaner = new IOCleaner();

      ?>
<?php
if (!isset($_SESSION['onEval'])) {
  $_SESSION['onEval'] = false;
}
//demarage eval
 $this->db->startEval();
 $this->stopEval();
//affichage eval
 $this->showEval();



  }

  public function showEval()
  {
    ?>
<div class="matieres-container px-3 p-5">
  <div class="px-2">
    <div class="row row-cols-1 row-cols-md-1 g-1">
      <?php
      if($evaluations = $this->db->getEvals()) {
      foreach ($evaluations as $eval) { ?>
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
                  <input type="hidden" name="start"
                  value="<?php echo  $this->iocleaner->outputFilter($eval['EAID'])?>">
                  
                  <div class="col-auto">
                    <button type="submit"
                    class="btn btn-info btn-block confirmButton"
                    <?php if ($_SESSION['onEval']) {echo "disabled";}?>>Démarrer l'évaluation</button>
                  </div>
                </form>
              <form method="post">
                  <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
                  <input type="hidden" name="stop"
                  value="<?php echo  $this->iocleaner->outputFilter($eval['EAID'])?>">
                  
                  <div class="col-auto">
                    <button type="submit"
                    class="btn btn-warning btn-block confirmButton"
                    <?php if (!$_SESSION['onEval']) {echo "disabled";}?>>Terminer l'évaluation</button>
                  </div>
                </form>

            </div>
            <div class="card-body collapse" id="eval<?php echo  $this->iocleaner->outputFilter($eval['ETID'])?>">
              ...
              
            
      </div>
      <?php
      }}
      ?>

  </div>
</div>
      <?php
  }

  public function stopEval()
  {
    //Debuter évaluation
    if (isset($_POST['stop'])
    && isset($_POST['CSRFToken'])
    && $this->db->verifyCSRF($_POST['CSRFToken'])) {
      $_SESSION['onEval'] = false;
    }
  }
}