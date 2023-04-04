<?php
namespace Csupcyber\Pemead\Models;

use Csupcyber\Pemead\Controlers\DataBase;
use Csupcyber\Pemead\Controlers\IOCleaner;
use Csupcyber\Pemead\Controlers\FIlesManagement;

class LearningBody
{
  public function __construct()
  {
    $this->db = new DataBase();
    $this->iocleaner = new IOCleaner();
    $this->files = new FilesManagement();
    ?>

<!--  -->
</div>
<div class="matieres-container px-3">
  <div class="p-5">
    <div class="row row-cols-1 row-cols-md-1 g-1">
    <?php
    if ($_SESSION['StudentCID']) {
    foreach ($this->db->getCourseMatieres($_SESSION['StudentCID']) as $Matiere) { ?>
    
      <!---->
      <div class="col">
        <div class="card bg-light">
          <div class="text-dark">
            <div class="card-header">
            <a href="#matiere<?php echo $Matiere['MID']?>"
            class="card-link btn btn-success" data-bs-toggle="collapse">+</a>
              <?php echo $Matiere['Cours'] ?> : <?php echo $Matiere['Matiere']?>
              </div>
            <div class="card-body collapse" id="matiere<?php echo $Matiere['MID']?>">
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
          <td><?php echo $File['Document'] ?></td>
          <td><?php echo $File['Description'] ?></td>
          <td><?php echo $File['Poster'] ?></td>
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