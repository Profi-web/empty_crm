<?php

/*Get core*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/core/init.php';
/**/

/*Variables*/
$pagination = 1;
if (isset($_GET['page'])) {
    $pagination = $_GET['page'];
}
/**/

/*Classes*/
$table = new Table($pagination, 'users', 'bedrijven');
$users = new Users('', $table->limit);
$logged = new User();

$loginValidate = new validateLogin();
$loginValidate->securityCheck();

/**/

/*Variables*/
/**/

foreach ($users->findAll($table->startfrom, $table->limit) as $user) {
    if ($user['picture']) {
        $image = $user['picture'];
    } else {
        $image = 'noUserProfilePicture.png';
    }
    if ($user['id'] == $_SESSION['userid']) {
        $class = 'current';
    } else {
        $class = '';
    }
        ?>
        <tr id="<?php echo $user['id'] ?>" class="user_tablee <?php echo $class; ?>">
        <td valign="middle">
            <?php echo $user['name'] ?>
        </td>
        <td>
            <img src="/uploads/picture/<?php echo $image; ?>" class="rounded-circle" width="35px" height="35px"
                 style="object-fit: cover"/>
        </td>
        <td valign="middle">
            <?php echo $user['email'] ?>
        </td>
        <td valign="middle">
            <?php echo $users->getRole($user['role']) ?>
        </td>
        <th scope="row" valign="middle">
            <?php echo $user['id'] ?>
        </th>
    </tr>
    <?php
}
?>
<script>
    $('tbody tr').on('click', function () {
        window.location.href = '/profiel?id=' + $(this).attr('id');
    });
</script>
