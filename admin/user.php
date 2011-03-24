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
        switch ($action){
            case 'form_add_user':
                     form_add_user();
                break;
            case 'add_new_user':
                 add_new_user();
                break;
            case 'form_edit_user':
                form_edit_user();
                break;
            case 'save_change_user':
                save_change_user();
                break;
            case 'delete_user':
                $user_id = $_GET['user_id'];
                delete_user($user_id);
                break;
            case 'manage':
            default :
                magage_user();
                break;


        }
    ?>
</div>
<?php require_once 'admin_footer.php'; ?>
<?php
/**
 * User functions
 *
 */
function magage_user(){
?>
<div id="content">
    <h2>Manage User</h2>

    <span class="add-link">+<a href="<?php echo BASE_URL ?>/admin/user.php?action=form_add_user">New User</a></span>
    <div class="table-list">
        <?php
             generat_user_list();
        ?>
       
    </div>
</div>
<?php
}
/**
 * Generat user list
 *
 */
function generat_user_list(){
    global $dbgh, $pages;

    //init paginator
    $pages->items_total = count_users(); //set total items
    $pages->mid_range = 5; // Number of pages to display. Must be odd and > 3
    $pages->items_per_page = LIMIT_USERS; //set items display per page
    $pages->paginate(); //generat paginator
    $query = "SELECT * FROM users WHERE deleted = 0 $pages->limit";

    $users = $dbgh->get_results($query);

    ?>
         <table class="tbl-list">
            <thead>
                <tr>
                 <th class="id">#</th>
                 <th class="username">Username</th>
                 <th class="email">Email</th>
                 <th class="last-login">Last Login</th>
                 <th class="action">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 1;
                    foreach($users as $user)
                    {
                        $delete = sprintf('<a href="%s" onClick="return confirm(\'Do you want to delete this user?\')" >Delete</a>', BASE_URL. '/admin/user.php?action=delete_user&user_id='.$user->user_id );
                        $edit = sprintf('<a href="%s">Edit</a>', BASE_URL. '/admin/user.php?action=form_edit_user&user_id='.$user->user_id );

                        echo '<tr id="tr_user_'. $user->user_id .'">';
                        printf('<td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>', $i, $user->username, $user->email, $user->last_login, $edit. ' ' . $delete);
                        echo '</tr>';
                        $i++;
                    }
                ?>
            </tbody>
         </table>
    <?php

}
function form_add_user(){
?>
<div id="content">
    <h2>Form Add New User</h2>
    <form id="form_add_user" name="form_add_user" action="<?php echo BASE_URL ?>/admin/user.php?action=add_new_user" method="post">
    <div>
        <label for="username">Username</label>
        <input type="text" id="username" name="username"/>

    </div>
    <div>
        <label for="email">Email</label>
        <input type="text" id="email" name="email"/>

    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" id="passowrd" name="password"/>

    </div>
    
        <input type="submit" value="Add User"/>
    
</form>
</div>
<?php
}
/**
 * Add new user
 *
 * @global ezSQL_mysql $dbgh
 */
function add_new_user(){
    global $dbgh;
   $username = mysql_escape_string($_POST['username']);
   $email = $_POST['email'];
   $password = md5($_POST['password']);
   $date_register = date('Y-m-d h:i:s');
   if( ( $username != '') && ( $email != '' ) && ( $password != '')){
       $query = "INSERT INTO users(username, email, password, user_register) VALUES('$username', '$email', '$password', '$date_register')";
       if($dbgh->query($query)){
           redirect(BASE_URL. '/admin/user.php');
       }else{
           echo 'fail to add new user.';
       }
   }
   
}
function form_edit_user()
{
    global $dbgh;
    $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
    if($user_id){
        $user = $dbgh->get_row("SELECT * FROM users WHERE user_id = $user_id ");
    ?>
<div id="content">
    <h2>Edit User</h2>
    <form id="form_add_user" name="form_add_user" action="<?php echo BASE_URL ?>/admin/user.php?action=save_change_user" method="post">
        <input type="hidden" name="user_id" value="<?php echo $user->user_id?>"
    <div>
        <label for="email">Email</label>
        <input type="text" id="email" name="email" value="<?php echo $user->email ?>"/>

    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" id="password" name="password"/>

    </div>

        <input type="submit" value="Save Change"/>

</form>
</div>
<?php
    }else{
        echo 'Invalid user id!';
    }
}

/**
 * Save change user
 *
 * @uses $dbgh;
 */
function save_change_user(){
    global $dbgh;
    $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $set = "email = '$email'";
    if($password != ''){
        $password =  md5($password);      
            $set .= ", password =  '$password'";
    }
    if($user_id){
        $query = "UPDATE users SET $set WHERE user_id = $user_id";
        echo $query;
        if($dbgh->query($query)){
            redirect(BASE_URL. '/admin/user.php');
        }else{
            echo 'Fail to update user.';
        }
    }else{
        echo 'Fail to update user.';
    }
}

function delete_user($user_id)
{
    global $dbgh;
    $query = "UPDATE users SET deleted = 1 WHERE user_id = $user_id";
    if($dbgh->query($query)){
        redirect(BASE_URL. '/admin/user.php');
    }else{
        echo 'Fail to update user.';
    }
}

/**
 * Count record of users
 *
 */
function count_users(){
    global $dbgh;
    // if (!isset($_SESSION['record_count1']))
    //{
        $num_rows = $dbgh->get_var("SELECT count(user_id) FROM users"); //count all records
        return $num_rows;
       // $_SESSION['record_count1'] = $num_rows;
    //}
    //return $_SESSION['record_count1'];
}
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#manage_users').addClass('active');
    });
</script>