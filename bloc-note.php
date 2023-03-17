<form id="EnabledRoleForm" method="post" action="?view=accountsManagement&process=setUser">
          <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledRoleSelect">
              <option value="Student">Elève</option>
              <option value="Instructeur">Instructeur</option>
              <option value="Pilote">Pilote de cours</option>
            </select>
          </form>
        </td>
        <td>

            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledCourseSelect" >
            <option value="Student">Test</option>
            </select>
          </form>
        </td>
        <td>
        <form id="EnabledCourseForm" method="post" action="?view=accountsManagement&process=setCourse">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledCourseSelect" >
            <option value="Student">Test</option>
            </select>
          </form>
        </td>
        <td>
        <form id="EnabledPromoForm" method="post" action="?view=accountsManagement&process=setPromo">
            <input type="hidden" name="CSRFToken" value="<?php echo $_SESSION['CSRFToken']; ?>">
            <select class="form-select" name="Course" id="EnabledPromoSelect" >
            <option value="Student">Test</option>
            </select>
          </form>
        </td>