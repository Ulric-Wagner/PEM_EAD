<?php
namespace Csupcyber\Pemead\Models;

use Csupcyber\Pemead\Controlers\DataBase;
use Csupcyber\Pemead\Controlers\IOCleaner;

class MatieresFeedingBody
{
  public function __construct()
  {
    $this->db = new DataBase();
    $this->iocleaner = new IOCleaner();
    ?>

  

<div class="row g-3 align-items-center p-5">
  <div>
    <H3>Selectionner un cours pour visualiser les matières:</H3>
  </div>
  <form method="post">
    <div class="row align-items-center">
      <div class="col-7">
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
          <select class="form-select" name="selectedCID">
            <option selected>Selectionner un cours</option>
            <?php foreach ($this->getCourses() as $course) { ?>
            <option value="<?php echo $course['CID'] ?>">
            <?php echo $course['Cours'] ?></option>
            <?php
            } ?>
          </select>
          </div>
        
      
          <button type="submit" class="btn btn-secondary btn-block col-3">Voir les matières</button>
    </form>
    </div>
<!--  -->
</div>
<div class="matieres-container px-3">
  <div class="p-5">
    <div class="row row-cols-1 row-cols-md-2 g-2">
    <?php
    if (isset($_POST['selectedCID'])
    && isset($_POST['CSRFToken'])
    && $this->verifyCSRF($_POST['CSRFToken'])) {
    foreach ($this->getCourseMatieres($this->iocleaner->inputFilter($_POST['selectedCID'])) as $Matiere) { ?>
    
      <!---->
      <div class="col">
        <div class="card bg-light">
          <div class="text-dark">
            <div class="card-header"><?php echo $Matiere['Cours'] ?> : <?php echo $Matiere['Matiere']?></div>
            <div class="card-body">
              <h5 class="card-title text-start">Titre du document</h5>
                <p class="card-text text-start">
                <div class="px-3">
                  <div class="row g-2 align-items-center p-2">
                    <div>
                      <H6>Ajouter un document:</H6>
                    </div>
                    <form method="post">
                      <div class="row g-2">
                        <div class="col-4">
                          <label for="title" class="col-form-label">Titre du document</label>
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
                            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
                            <input type="text" name="description" id="description"
                            class="form-control" aria-describedby="HelpInline" required>
                          </div>
                          <div class="col-4">
                          <label for="description" class="col-form-label">Description</label>
                        </div>
                          <div class="col-8">
                          <select class="form-select" name="FID">
                            <option value="None" selected>Selectionner un fichier</option>
                            <?php foreach ($this->getFiles($_SESSION['GID']) as $file) { ?>
                            <option value="<?php echo $file['FID'] ?>">
                            <?php echo $file['Fichier'] ?></option>
                            <?php
                            } ?>
                          </select>
                        </div>
                          <div class="col-auto">
                            <button type="submit" class="btn btn-secondary btn-block">Ajouter</button>
                          </div>
                        </div>
                      </form>
                    </div>
                </div>
                </p>
            </div>
          </div>
        </div>
      </div>
        
        <?php
        } 
      }?>

    </div>
  </div>
    
</div>
  

  </div>
</div>
<?php
  }
 

      public function getCourses()
      {
        return $this->db->getCourses();
      }

      public function getCourseMatieres($cid)
      {
        return $this->db->getCourseMatieres($cid);
      }

      public function getDocuments() {
        //pass
      }

      public function getFiles($gid)
      {
        return $this->db->getFiles($gid);
      }

      public function verifyCSRF($token)
      {
          return $token === $_SESSION['CSRFToken'];
      }
}