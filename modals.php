<!-- Delete record modal -->
<div class="modal fade" id="modalDeleteRecord" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <h3 class="modal-title" id="myModalLabel">Delete record ID <span id="recordIDdelete"></span></h3>
     </div>
     <div class="modal-body">
         Do you really want to delete this record?
     </div>
     <div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
       <form action="index.php" method="get" style="display: inline;">
         <input type="text" id="inputDeleteID" name="delete" value="" style="display: none;">
         <button type="submit" class="btn btn-danger">Delete</button>
       </form>
     </div>
   </div>
 </div>
</div>

<!-- Add car profile modal -->
<div class="modal fade" id="addProfileModal" tabindex="-1" role="dialog" aria-labelledby="addProfileModalLabel">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h3 class="modal-title" id="editProfileModalLabel">Add new car profiles</h3>
    </div>
    <div class="modal-body">
      <br>
      <div class="addCarProfileDiv">
        <form ation="index.php" method="get">
         <div class="form-group">
          Model: <input type="text" class='form-control' name="modelAdd"><br>
          Registration number: <input type="text" class='form-control' name="regNumberAdd"><br>
         </div>
      </div>
    </div>
    <div class="modal-footer">
     <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
     <button type="submit" class="btn btn-primary">Add profile</button>
   </form>
    </div>
  </div>
</div>
</div>

<!-- Edit car profile modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h3 class="modal-title" id="editProfileModalLabel">Edit current car profile</h3>
    </div>
    <div class="modal-body">
      <div class="editCarProfileDiv">
       <form ation="index.php" method="get">
         <input type="text" name="deleteCarProfile" value="<?php echo $_SESSION['carID']; ?>" style="display: none;">
         <button type="submit" class="btn btn-danger">Delete profile</button>
       </form><br>
       <form action="index.php" method="get">
        <div class="form-group">
         <?php
           $result = $profilesDB->query("SELECT * FROM car WHERE id='$carID'");
           while($row = $result->fetchArray()) {
             echo "Model: <input type='text' class='form-control' name='modelEdit' value='" . $row['model'] . "'><br>";
             echo "Registration number: <input type='text' class='form-control' name='regNumberEdit' value='" . $row['regNumber'] . "'><br>";
           }
         ?>
       </div>
     </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
    </div>
  </div>
</div>
</div>
