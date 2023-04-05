<?php foreach ($this->db->getQuestions($eval['ETID']) as $question) { ?>
          <div class="col">
              <div class="card bg-light">
                <div class="text-dark">
                  <div class="card-header">
                    <a href="#questiondisplay<?php echo  $this->iocleaner->outputFilter($question['QID'])?>"
                    class="card-link btn btn-secondary" data-bs-toggle="collapse">+</a>

                      <?php echo  $this->iocleaner->outputFilter($question['Question']) ?>

                  </div>
                  <div class="card-body collapse"
                  id="questiondisplay<?php echo  $this->iocleaner->outputFilter($eval['QID'])?>">
                  Responses...
                  </div>
                </div>
               </div>
              </div>
          </div>
                      <!-- -->       
        <?php
          }










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
                          <label for="question" class="col-form-label">Question</label>
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
                            <button type="submit" class="btn btn-secondary btn-block confirmButton">Ajouter</button>
                          </div>
                            <!-- -->
                            <?php foreach ($this->db->getQuestions($eval['ETID']) as $question) { ?>
                            <div class="col">
                                <div class="card bg-light">
                                  <div class="text-dark">
                                    <div class="card-header">
                                      <a href="#questiondisplay<?php echo  $this->iocleaner->outputFilter($question['QID'])?>"
                                      class="card-link btn btn-secondary" data-bs-toggle="collapse">+</a>

                                        <?php echo  $this->iocleaner->outputFilter($question['Question']) ?>

                                    </div>
                                    <div class="card-body collapse"
                                    id="questiondisplay<?php echo  $this->iocleaner->outputFilter($eval['QID'])?>">
                                    Responses...
                                    </div>
                                  </div>
                                </div>
                                </div>
                            </div>
                                        <!-- -->
                          <?php
                             } ?>

                        </div>
                      </form>
                    </div>
          <!-- -->
          
      <?php }?>

    </div>
  </div>
    
</div>
  

  </div>
</div>