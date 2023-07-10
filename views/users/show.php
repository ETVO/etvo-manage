<div class="show-users">
    <div class="heading">
        <h1 class="title"><?php echo $model['title'] ?></h1>
        <p class="desc"><?php echo $model['desc']; ?></p>
    </div>

    <a href="?add_new" class="btn btn-primary add-new">
        Add New User
    </a>

    <?php if ($stored_users) : ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Access Level</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Updated at</th>
                    <th scope="col">Active</th>
                    <th scope="col"></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($stored_users as $user) :
                    $name = $user['name'];
                    $username = $user['username'];
                    $created_at = date('d/m/Y \à\s H:i', strtotime($user['created_at']));
                    $updated_at = date('d/m/Y \à\s H:i', strtotime($user['updated_at']));
                    $access_level = $user['access_level'];
                    $active = $user['active'];
                    $row_class = $active ? 'user-active' : 'user-inactive';
                    $row_label = $active
                        ? 'Active ' . (($access_level == 'admin') ? 'Admin' : 'User')
                        : 'Inactive User';
                    $disable_label = $active ? 'Active. Click to Disable' : 'Inactive. Click to Enable';
                    $disable_icon = $active ? 'bi-toggle-on' : 'bi-toggle-off';
                ?>
                    <tr class="<?= $row_class; ?>" title="<?= $row_label; ?>">
                        <td><?= $name; ?></td>
                        <td><?= $username; ?></td>
                        <td><?= $access_level; ?></td>
                        <td><?= $created_at; ?></td>
                        <td><?= $updated_at; ?></td>
                        <td class="active">
                            <a href="?toggle&username=<?= $username; ?>" title="<?= $disable_label; ?>">
                                <span class="<?= $disable_icon; ?>"></span>
                            </a>
                        </td>
                        <td class="actions">
                            <a href="?edit&username=<?= $username; ?>" title="Edit">
                                <span class="bi-pencil-square"></span>
                            </a>
                            <a href="?remove&username=<?= $username; ?>" title="Remove">
                                <span class="bi-trash3"></span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <h2 class="fs-5 pt-3 fw-normal">No users were found.</h2>
    <?php endif; ?>

</div>