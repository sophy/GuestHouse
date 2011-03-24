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

     }
     function add_new_user()
     {
         global $dbgh;
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
?>
</div>
<?php require_once 'admin_footer.php'; ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#manage_rooms').addClass('active');
    });
</script>