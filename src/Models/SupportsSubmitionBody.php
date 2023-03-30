<?php
namespace Csupcyber\Pemead\Models;

use Csupcyber\Pemead\Controlers\DataBase;

class SupportsSubmitionBody
{
    public function __construct()
    {
      $this->db = new DataBase();
      ?>


<div class="d-flex justify-content-center p-2">
  <div class="col-8 text-center">
    <H3>:</H3>
  </div>
</div>

<div class="row g-3 align-items-center p-5">
  <div>
    <H3>Soumission des supports:</H3>
  </div>
  <form method="post" action="?view=supportSubmition&process=sendFile">
    <div class="row g-3 align-items-center">
      <div class="col-auto">
        <label for="sendFile" class="col-form-label">Selectionner un fichier</label>
        </div>
        <div class="col-auto">
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
          <input
                      name="fileToUpload"
                      type="file"
                      accept=".pdf, .ppt, .pptx"
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
<div class="course-table-container tableFixHead px-5">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Nom du fichier</th>
        <th scope="col">Type du fichier</th>
        <th scope="col"></th>
    </thead>
    <tbody>
    <?php foreach ($this->getFiles($_SESSION['GID']) as $File) { ?>
        <tr>
          <td><?php echo $File['Fichier'] ?></td>
          <td><?php echo $File['Type'] ?></td>
          <td><div class="col-auto">
          <button type="submit" class="btn btn-secondary btn-block">Téléchargement</button>
        </div></td>
        </tr>
        <?php
        } ?>
    </tbody>
  </table>
</div>
<?php }

      public function getFiles($gid)
      {
        return $this->db->getFiles($gid);
      }
}