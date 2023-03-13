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

<div class="d-flex justify-content-center mt-2">
  <div>
    <H3>Créer un cours:</H3>
  </div>
</div>
<div class="d-flex justify-content-center mt-2">
<div class="form-outline mb-4 col-4">
      <form method="post" action="?process=createCourse">
      <!-- Course input -->
      <div class="form-outline mb-4">
        <input type="text" id="createCourse" class="form-control d-flex justify-content-center"
        name="createCourse" required/>
        <label class="form-label d-flex justify-content-center" for="createCourse">Nom du cours</label>
      </div>

      <!-- Token CSRF -->
      <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
      <!-- Submit button -->
      <div class="d-flex justify-content-center">
      <button type="submit" class="btn btn-secondary btn-block mb-3">Créer</button>
    </div>
    </form>
  </div>
</div>
<!--  -->
</div>

<div class="p-5 m-5 mt-2">
  <table class="table">
  <figcaption><H5>Cours actifs:</H5></figcaption>
    <thead>
      <tr>
        <th scope="col">CID</th>
        <th scope="col">Nom du cours</th>
        <th scope="col">Nouveau nom</th>
        <th scope="col"></th>
        <th scope="col"></th>
    </thead>
    <tbody>
      <?php foreach ($this->getCourses() as $course) { ?>
      <tr>
        <th scope="row"><?php echo $course['CID'] ?></th>
        <td><?php echo $course['Cours'] ?></td>
        <td>
        <form method="post" action="?process=removeCourse">
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
          <input type=text name="newCourseName"/>
        
            <input type="hidden" name="CID" value="<?php echo $course['CID'] ?>" />
            <button type="submit" class="btn btn-info">Renommer</button>
          </form>
       </td>
       <td>
          <form method="post" action="?process=removeCourse">
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