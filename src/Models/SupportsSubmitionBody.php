<?php
namespace Csupcyber\Pemead\Models;

use Csupcyber\Pemead\Controlers\DataBase;

class SupportsSubmitionBody
{
    public function __construct()
    {
      $this->db = new DataBase();
      ?>

<div class="row g-3 align-items-center p-5">
  <div>
    <H3>Télversement des supports:</H3>
  </div>
  <form method="post" enctype="multipart/form-data" action="?view=supportsSubmition&process=sendFile">
    <div class="row g-3 align-items-center">
      <div class="col-auto">
        <label for="sendFile" class="col-form-label">Selectionner un fichier</label>
        </div>
        <div class="col-auto">
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
          <input
                      name="fileToUpload"
                      type="file"
                      accept=".pdf, .ppt, .pptx, .odp"
                      id="fileToUpload"
                      value=""
                      class="form-control d-flex justify-content-center"
                      required
                    />
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-secondary btn-block">Soumettre</button>
        </div>
      </div>
    </form>

</div>
<!--  -->
</div>
<div class="px-3">
  <div class="file-table-container tableFixHead px-3">
    <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Nom du fichier</th>
        <th scope="col">Auteur</th>
        <th scope="col">Téléchargement</th>
    </thead>
    <tbody>
    <?php foreach ($this->getFiles($_SESSION['GID']) as $File) { ?>
        <tr>
          <td><?php echo $File['Fichier'] ?></td>
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
      </div>

<?php }


      public function getFiles($gid)
      {
        return $this->db->getFiles($gid);
      }
}