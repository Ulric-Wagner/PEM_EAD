<!---->
<div class="form-outline mb-4">
          <select class="form-select" name="RegisterCourse">
            <option selected class="text-center">Selectionner un cours</option>
            <?php foreach ($this->getCourses() as $course) { ?>
            <option class="text-center" value="<?php echo $course['CID'] ?>">
            <?php echo $course['Cours'] ?></option>
            <?php
            }?>
          </select>
          <label class="form-label d-flex justify-content-center">Cours</label>
        </div>

      <!---->