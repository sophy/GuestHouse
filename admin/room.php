<?php
require_once 'admin.php';
define('LIMIT_USERS', 10);
?>
<?php require_once 'admin_header.php'; ?>
<!-- admin side bar -->
<?php get_sidebar() ?>
<div id="main">
<?php
     $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : false;
     switch ($action)
     {
         case 'form_add_room':
             form_add_room();
             break;
         case 'add_new_room':
             add_new_room();
             break;
         case 'form_edit_room':
             form_edit_room();
             break;
         case 'save_change_room':
             save_change_room();
             break;
         case 'delete_room':
             delete_room();
             break;
         case 'manage':
         default:
             manage_room();
             break;
     }
     function form_add_room()
     {
        ?>
        <div id="content">
            <h2>Add New Room</h2>
            <form id="form_add_room" name="form_add_room" action="<?php echo BASE_URL ?>/admin/room.php?action=add_new_room" method="post" enctype="multipart/form-data">
                <div>
                    <label for="room_name">Room Name</label>
                    <input type="text" id="room_name" name="roomname"/>

                </div>
                <div>
                    <label for="bed">Bed</label>
                    <input type="text" id="bed" name="bed"/>

                </div>
                <div>
                    <label for="price">Price</label>
                    <input type="text" id="price" name="price"/>

                </div>
                <div>
                    <label for="picture">Room Photo</label>
                    <input type="file" name="picture"/>
                </div>
                <div>
                    <label for="description">Description</label>
                    <textarea cols="30" rows="4" id="description" name="description"></textarea>
                </div>

                <input type="submit" value="New Room"/>

        </form>
        </div>
        <?php
     }
     function add_new_room()
     {
         global $dbgh;
         $room_name = $_REQUEST['roomname'];
         $image = $_FILES['picture'];

        if($image['error'] != 4 && $image['size'] > 10){
           $image_name = upload_image($image, ROOM_PHOTO_PHAT, $room_name );
        }
     }
     function form_edit_room()
     {
         global $dbgh;
     }
     function save_change_room()
     {
         global $dbgh;
     }
     function delete_room($room_id)
     {
         
     }
     function manage_room()
     {
         ?>
            <div id="content">
                <h2>Manage Rooms</h2>
                <span class="add-link">+<a href="<?php echo BASE_URL ?>/admin/room.php?action=form_add_room">New Room</a></span>
            </div>
         <?php
     }
?>
</div>
<?php require_once 'admin_footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#manage_rooms').addClass('active');
    });
</script>