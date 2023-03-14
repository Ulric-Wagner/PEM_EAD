<?php
namespace Csupcyber\Pemead\Models;

use Csupcyber\Pemead\Controlers\DataBase;

class CoursesManagementBody
{
    public function __construct()
    {
      $this->db = new DataBase();
      ?>


<div class="d-flex justify-content-center p-2">
  <div class="col-8 text-center">
    <H3>Gestion des cours:</H3>
  </div>
</div>

<div class="row g-3 align-items-center p-5">
  <div>
    <H3>Créer un cours:</H3>
  </div>
  <form method="post" action="?view=coursesManagement&process=createCourse">
    <div class="row g-3 align-items-center">
      <div class="col-auto">
        <label for="createCourse" class="col-form-label">Nom du cours</label>
        </div>
        <div class="col-auto">
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
          <input type="text" name="createCourse" id="createCourse" class="form-control" aria-describedby="HelpInline">
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-secondary btn-block">Créer</button>
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
        <th scope="col">CID</th>
        <th scope="col">Nom du cours</th>
        <th scope="col">Nouveau nom</th>
        <th scope="col"></th>
    </thead>
    <tbody>
      <?php foreach ($this->getCourses() as $course) { ?>
      <tr>
        <th scope="row"><?php echo $course['CID'] ?></th>
        <td><?php echo $course['Cours'] ?></td>
        <td>
        <form method="post" action="?view=coursesManagement&process=renameCourse">
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
          <input type=text name="newCourseName"/>
        
            <input type="hidden" name="CID" value="<?php echo $course['CID'] ?>" />
            <button type="submit" class="btn btn-info">Renommer</button>
          </form>
       </td>
       <td>
          <form method="post" action="?view=coursesManagement&process=removeCourse">
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <input type="hidden" name="removeCourse" value="<?php echo $course['CID'] ?>" />
            <button type="submit" class="btn btn-danger">Supprimer</button>
          </form>
        </td>
        
      </tr>
      <?php
      } ?>
    </tbody>
  </table>
</div>
<?php }

      public function getCourses()
      {
        return $this->db->getCourses();
      }
}