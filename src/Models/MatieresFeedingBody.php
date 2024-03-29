<?php
namespace Csupcyber\Pemead\Models;

use Csupcyber\Pemead\Controlers\DataBase;
use Csupcyber\Pemead\Controlers\IOCleaner;
use Csupcyber\Pemead\Controlers\FIlesManagement;

class MatieresFeedingBody
{
  public function __construct()
  {
    $this->db = new DataBase();
    $this->iocleaner = new IOCleaner();
    $this->files = new FilesManagement();

    $this->files->createDocument();
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
        
      
          <button type="submit"  class="btn btn-secondary btn-block col-3">Voir les matières</button>
    </form>
    </div>
<!--  -->
</div>
<div class="matieres-container px-3">
  <div class="p-5">
    <div class="row row-cols-1 row-cols-md-1 g-1">
    <?php
    if (isset($_POST['selectedCID'])
    && isset($_POST['CSRFToken'])
    && $this->verifyCSRF($_POST['CSRFToken'])) {
    foreach ($this->getCourseMatieres($this->iocleaner->inputFilter($_POST['selectedCID'])) as $Matiere) { ?>
    
      <!---->
      <div class="col">
        <div class="card bg-light">
          <div class="text-dark">
            <div class="card-header">
            <a href="#matiere<?php echo $this->iocleaner->outputFilter($Matiere['MID'])?>"
            class="card-link btn btn-info" data-bs-toggle="collapse">+</a>

              <?php echo $this->iocleaner->inputFilter($Matiere['Cours']) ?> : <?php echo $this->iocleaner->inputFilter($Matiere['Matiere'])?>
              </div>
            <div class="card-body collapse" id="matiere<?php echo $this->iocleaner->inputFilter($Matiere['MID'])?>">
              <h5 class="card-title text-start">Documents disponible:</h5>
                <p class="card-text text-start">
                <div class="px-3">
                  <!-- -->
                  <div class="file-table-container tableFixHead px-3">
    <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Nom du document</th>
        <th scope="col">Description</th>
        <th scope="col">Auteur</th>
        <th scope="col">Téléchargement</th>
    </thead>
    <tbody>
    <?php foreach ($this->files->getValidatedDocuments($Matiere['MID']) as $File) { ?>
        <tr>
          <td><?php echo $this->iocleaner->outputFilter($File['Document']) ?></td>
          <td><?php echo $this->iocleaner->outputFilter($File['Description']) ?></td>
          <td><?php echo $this->iocleaner->outputFilter($File['Poster']) ?></td>
          <td><div class="col-auto">
          <?php
          if ($File['Type'] === 'pdf') { ?>
                                                    
            <form method="post" action="?view=supportSubmition&process=download">
            <input
              type="image" src="./img/pdf.png"
              alt="Submit"
              data-toggle="tooltip"
              title="<?php echo $this->db->iocleaner->outputFilter($File['Fichier']) ?>"
              data-placement="bottom">
            <input
              type="hidden"
              name="FileToRead"
              value="<?php echo $this->db->iocleaner->outputFilter($File['Fichier']) ?>">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken'] ?>">
            <label><?php echo $this->db->iocleaner->outputFilter($File['Fichier']) ?></label>
            </form>
          <?php
          } elseif ($File['Type'] === 'ppt'
          || $File['Type'] === 'pptx'
          || $File['Type'] === 'odp') { ?>
            <form method="post" action="?view=supportSubmition&process=download">
            <input
              type="image" src="./img/ppt.png"
              alt="Submit"
              data-toggle="tooltip"
              title="<?php echo $this->db->iocleaner->outputFilter($File['Fichier']) ?>"
              data-placement="bottom">
            <input
              type="hidden"
              name="FileToRead"
              value="<?php echo $this->db->iocleaner->outputFilter($File['Fichier']) ?>">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken'] ?>">
            <label><?php echo $this->db->iocleaner->outputFilter($File['Fichier']) ?></label>
            </form>
          <?php
          }
          ?>
        </div></td>
        </tr>
        <?php
        } ?>
    </tbody>
  </table>
</div>
      </div>
<h5 class="card-title text-start">Documents en attente de validaton:</h5>
                <p class="card-text text-start">
                <div class="px-3">
                  <!-- -->
                  <div class="file-table-container tableFixHead px-3">
    <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Nom du document</th>
        <th scope="col">Description</th>
        <th scope="col">Auteur</th>
        <th scope="col">Téléchargement</th>
    </thead>
    <tbody>
    <?php foreach ($this->files->getUnvalidatedDocuments($Matiere['MID']) as $File) { ?>
        <tr>
          <td><?php echo  $this->iocleaner->outputFilter($File['Document']) ?></td>
          <td><?php echo  $this->iocleaner->outputFilter($File['Description']) ?></td>
          <td><?php echo  $this->iocleaner->outputFilter($File['Poster']) ?></td>
          <td><div class="col-auto">
          <?php
          if ($File['Type'] === 'pdf') { ?>
                                                    
            <form method="post" action="?view=supportSubmition&process=download">
            <input
              type="image" src="./img/pdf.png"
              alt="Submit"
              data-toggle="tooltip"
              title="<?php echo $this->db->iocleaner->outputFilter($File['Fichier']) ?>"
              data-placement="bottom">
            <input
              type="hidden"
              name="FileToRead"
              value="<?php echo $this->db->iocleaner->outputFilter($File['Fichier']) ?>">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken'] ?>">
            <label><?php echo $this->db->iocleaner->outputFilter($File['Fichier']) ?></label>
            </form>
          <?php
          } elseif ($File['Type'] === 'ppt'
          || $File['Type'] === 'pptx'
          || $File['Type'] === 'odp') { ?>
            <form method="post" action="?view=supportSubmition&process=download">
            <input
              type="image" src="./img/ppt.png"
              alt="Submit"
              data-toggle="tooltip"
              title="<?php echo $this->db->iocleaner->outputFilter($File['Fichier']) ?>"
              data-placement="bottom">
            <input
              type="hidden"
              name="FileToRead"
              value="<?php echo $this->db->iocleaner->outputFilter($File['Fichier']) ?>">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken'] ?>">
            <label><?php echo $this->db->iocleaner->outputFilter($File['Fichier']) ?></label>
            </form>
          <?php
          }
          ?>
        </div></td>
        </tr>
        <?php
        } ?>
    </tbody>
  </table>
</div>
                  <!-- -->
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
                            <input type="hidden" name="MID" value="<?php echo $Matiere['MID']; ?>">
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
                            <button type="submit"  class="btn btn-secondary btn-block confirmButton">Ajouter</button>
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

      public function getFiles($gid)
      {
        return $this->files->getFiles($gid);
      }

      public function verifyCSRF($token)
      {
          return $token === $_SESSION['CSRFToken'];
      }
}