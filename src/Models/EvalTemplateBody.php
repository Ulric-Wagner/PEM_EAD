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

    //traitement de la création de question
    $this->db->createQuestion();

    //traitement des nouvelle reponse
    $this->db->createReponse();

    //traitement suppression de reponse
    $this->db->removeReponse();

    //traitement suppression de question
    $this->db->removeQuestion();

    //traitement suppression des eval
    $this->db->removeEvalTemplate();
    ?>

<div class="row g-2 text-center p-2">
  <div>
    <H6>Créer un template d'évaluation:</H6>
  </div>
   <form method="post">
     <div class="row g-2 pb-2">
       <div class="col-4">
         <label for="title" class="col-form-label">Nom du template</label>
       </div>
       <div class="col-5">
         <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
         <input type="text" name="title" id="title"
         class="form-control" aria-describedby="HelpInline" required>
       </div>
       <div class="col-4">
         <label for="description" class="col-form-label">Description</label>
       </div>
       <div class="col-5">
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
         <button type="submit"  class="btn btn-secondary btn-block confirmButton">Ajouter</button>
       </div>
     </div>
   </form>
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
      foreach ($this->db->getEvalTemplates() as $eval) { ?>
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
                  <input type="hidden" name="RemoveETID"
                  value="<?php echo  $this->iocleaner->outputFilter($eval['ETID'])?>">
                  
                  <div class="col-auto">
                    <button type="submit" 
                    class="btn btn-danger btn-block confirmButton">Suprimer le template d'évaluation</button>
                  </div>
                </form>

            </div>
            <div class="card-body collapse" id="eval<?php echo  $this->iocleaner->outputFilter($eval['ETID'])?>">
              Description: <?php echo  $this->iocleaner->outputFilter($eval['Description']);
              $this->addQuestionForm($eval);
              $this->showQuestions($eval);
              ?>
            
      </div>
      <?php
      }
      ?>

  </div>
</div>
      <?php
  }
      
      


  public function addQuestionForm($eval)
  {
    ?>
<div class="row g-2 align-items-center p-2">
  <div>
    <H6>Ajouter une question:</H6>
  </div>
  <form method="post" action="#eval<?php echo  $this->iocleaner->outputFilter($eval['ETID'])?>">
    <div class="row g-2">
      <div class="col-4">
        <label for="question" class="col-form-label"><h6>Question:</h6></label>
      </div>
      <div class="col-8">
        <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
        <input type="hidden" name="ETID"
        value="<?php echo  $this->iocleaner->outputFilter($eval['ETID'])?>">
        <input type="text" name="question" id="question"
        class="form-control" aria-describedby="HelpInline" required>
       </div>
    </div>
    <div class="col-auto">
      <button type="submit"  class="btn btn-secondary btn-block confirmButton">Ajouter</button>
    </div>
  </form>
</div>
                            
    <?php
  }

  public function showQuestions($eval)
  {
    $i = 1;
    ?>

    <div class="row row-cols-1 row-cols-md-1 g-1">
      <?php
      foreach ($this->db->getQuestions($eval['ETID']) as $question) { ?>
      <div class="col">
        <div class="card bg-light">
          <div class="text-dark">
            <div class="d-flex card-header">
              <a href="#questiondisplay<?php echo  $this->iocleaner->outputFilter($question['QID'])?>"
              class="card-link btn btn-secondary" data-bs-toggle="collapse">+</a>

              <div class="p-2 col-7">QUESTION <?php echo $i ?>:
              <?php echo $this->iocleaner->outputFilter($question['Question']) ?></div>
              <form method="post"
              action="#eval<?php echo  $this->iocleaner->outputFilter($eval['ETID'])?>">
                <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
                <input type="hidden" name="RemoveQID"
                value="<?php echo  $this->iocleaner->outputFilter($question['QID'])?>">
                  
                  <div class="col-auto">
                    <button type="submit"  class="btn btn-danger btn-block confirmButton">Suprimer la question</button>
                  </div>
              </form>

            </div>
            <div class="card-body collapse"
            id="questiondisplay<?php echo  $this->iocleaner->outputFilter($question['QID'])?>">
              <?php
              $this->addResponseForm($eval, $question);
              ?>
            </div>
          </div>
        </div>
      </div>
      <?php
      $i++;
      }
      ?>
    </div>
  </div>
</div>
    <?php

  }

  public function addResponseForm($eval, $question)
  {
    ?>
<div class="row g-2 align-items-center p-2">
  <div>
    <H6>Ajouter une reponse:</H6>
  </div>
  <?php
  $evalHash = $this->iocleaner->outputFilter($eval['ETID']);
  $questionHash = $this->iocleaner->outputFilter($question['QID']);
  ?>
    <form method="post"
    action="#eval<?php echo $evalHash?>&#questiondisplay<?php echo $questionHash?>">
      <div class="row g-2">
        <div class="col-4">
          <label for="question" class="col-form-label"><h6>Reponse:</h6></label>
        </div>
        <div class="col-8">
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
          <input type="hidden" name="QID"
          value="<?php echo  $this->iocleaner->outputFilter($question['QID'])?>">
          <input type="text" name="reponse" id="reponse"
          class="form-control" aria-describedby="HelpInline" required>
        </div>
        <div class="col-4">
          <label for="points" class="col-form-label"><h6>Points: </h6></label>
        </div>
        <div class="col-8">
        <input type="number" id="points" name="points"
        min="-10" max="10" step="0.25" required>
        </div>
      </div>
      </div>
      <div class="col-auto">
        <button type="submit"  class="btn btn-secondary btn-block confirmButton">Ajouter</button>
      </div>
    </form>
    <?php $this->showReponses($eval, $question); ?>
</div>
                            
    <?php
  }

  public function showReponses($eval, $question)
  {
    $j = 1;
    ?>

    <div class="row row-cols-1 row-cols-md-1 g-1 p-2">
      <?php
      foreach ($this->db->getReponses($question['QID']) as $reponse) {
        if ($reponse['Points'] > 0) {
          $color = "btn-success";
        } elseif ($reponse['Points'] < 0) {
          $color = "btn-danger";
        } else {
          $color = "btn-dark";
        }
        ?>
      <div class="col">
        <div class="card bg-light">
          <div class="text-dark">
            <div class="card-header">
              <a href="#reponsedisplay<?php echo  $this->iocleaner->outputFilter($reponse['RID'])?>"
              class="card-link btn <?php echo $color ?>" data-bs-toggle="collapse">+</a>

                Reponse <?php echo $j ?>: <?php echo $this->iocleaner->outputFilter($reponse['Reponse']) ?>

            </div>
            <div class="card-body collapse"
            id="reponsedisplay<?php echo  $this->iocleaner->outputFilter($reponse['RID'])?>">
              <?php $this->responseForm($eval, $question['QID'], $reponse); ?>
            </div>
          </div>
        </div>
      </div>
      <?php
      $j++;
      }
      ?>
    </div>

    <?php
    
  }

  public function responseForm($eval, $qid, $reponse)
  {
    ?>
<div class="row g-2 align-items-center p-2">
  <?php
  $evalHash = $this->iocleaner->outputFilter($eval['ETID']);
  $questionHash = $this->iocleaner->outputFilter($qid);
  ?>
  <h6>Points (Positifs ou négatifs): <?php echo $reponse['Points'] ?></h6>
    <form method="post"
    action="#eval<?php echo $evalHash?>&#questiondisplay<?php echo $questionHash?>">
    <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
    <input type="hidden" name="RemoveRID" value="<?php echo  $this->iocleaner->outputFilter($reponse['RID'])?>">
      
      <div class="col-auto">
        <button type="submit"  class="btn btn-danger btn-block confirmButton">Suprimer la reponse</button>
      </div>
    </form>
</div>
                            
    <?php
  }

}