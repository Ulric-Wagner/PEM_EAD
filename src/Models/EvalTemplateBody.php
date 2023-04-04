<?php
namespace Csupcyber\Pemead\Models;

use Csupcyber\Pemead\Controlers\DataBase;
use Csupcyber\Pemead\Controlers\IOCleaner;
use Csupcyber\Pemead\Controlers\FIlesManagement;

class EvalTemplateBody
{
  public function __construct()
  {
    $this->db = new DataBase();
    $this->iocleaner = new IOCleaner();
    $this->files = new FilesManagement();

    //traitement de la création de template
    $this->db->createEvalTemplate();
    ?>

<div class="row g-2 align-items-center p-2">
                    <div>
                      <H6>Créer un template d'évaluation:</H6>
                    </div>
                    <form method="post">
                      <div class="row g-2">
                        <div class="col-4">
                          <label for="title" class="col-form-label">Nom du template</label>
                          </div>
                          <div class="col-8">
                            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
                            <input type="text" name="title" id="title"
                            class="form-control" aria-describedby="HelpInline" required>
                          </div>
                        <div class="col-4">
                          <label for="description" class="col-form-label">Description</label>
                        </div>
                          <div class="col-8">
                            <input type="text" name="description" id="description"
                            class="form-control" aria-describedby="HelpInline" required>
                          </div>
                          <div class="col-4">
                          <label for="matiere" class="col-form-label">Matière</label>
                        </div>
                          <div class="col-5">
                          <select class="form-select" name="MID">
                            <option value="None" selected>Selectionner une matière</option>
                            <?php foreach ($this->db->getMatieres() as $matiere) { ?>
                            <option value="<?php echo  $this->iocleaner->outputFilter($matiere['MID']) ?>">
                            <?php echo $this->iocleaner->outputFilter($matiere['Cours'])?>
                            <?php echo $this->iocleaner->outputFilter($matiere['Matiere'])?>
                          </option>
                            <?php
                            } ?>
                          </select>
                        </div>
                          <div class="col-auto">
                            <button type="submit" class="btn btn-secondary btn-block confirmButton">Ajouter</button>
                          </div>
                        </div>
                      </form>
                    </div>


<!-- -->
</div>
<div class="matieres-container px-3">
  <div class="p-5">
    <div class="row row-cols-1 row-cols-md-1 g-1">
    <?php
    foreach ($this->db->getEvalTemplates() as $eval) { ?>
    
      <!---->
      <div class="col">
        <div class="card bg-light">
          <div class="text-dark">
            <div class="card-header">
            <a href="#eval<?php echo  $this->iocleaner->outputFilter($eval['ETID'])?>"
            class="card-link btn btn-info" data-bs-toggle="collapse">+</a>

              <?php echo  $this->iocleaner->outputFilter($eval['Cours']) ?> ->
              <?php echo  $this->iocleaner->outputFilter($eval['Matiere'])?> ->
              <?php echo  $this->iocleaner->outputFilter($eval['Eval'])?>

              </div>
            <div class="card-body collapse" id="eval<?php echo  $this->iocleaner->outputFilter($eval['ETID'])?>">
            <?php echo  $this->iocleaner->outputFilter($eval['Description'])?>
            <!-- -->

            <div class="row g-2 align-items-center p-2">
                    <div>
                      <H6>Ajouter une question:</H6>
                    </div>
                    <form method="post" action="#eval<?php echo  $this->iocleaner->outputFilter($eval['ETID'])?>">
                      <div class="row g-2">
                        <div class="col-4">
                          <label for="title" class="col-form-label">Question</label>
                          </div>
                          <div class="col-8">
                            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
                            <input type="text" name="title" id="title"
                            class="form-control" aria-describedby="HelpInline" required>
                          </div>
                        </div>
                          <div class="col-auto">
                            <button type="submit" class="btn btn-secondary btn-block confirmButton">Ajouter</button>
                          </div>
                        </div>
                      </form>
                    </div>

    </div>
                  <!-- -->
                 
        <?php
        
      }?>

    </div>
  </div>
    
</div>
  

  </div>
</div>
        

<?php
  }
  
 

}