<?php include(__DIR__ . '/../../resources/views/layouts/header.php') ?>
<div class="container">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h1 class="card-title">Dashboard</h1>
                        <p class="card-text">Welcome <?= $name ?>.</p>
                        <p class="card-text">You Have Loged in.</p>

                        <h6>User Info</h6>
                        <ul class="list-group">
                            <li class="list-group-item">
                                Name : <?= $name ?>
                            </li>
                            <li class="list-group-item">
                                Email : <?= $email ?>
                            </li>
                            <li class="list-group-item">
                                Address : <?= $address ?>
                            </li>
                        </ul>
                        <form action="logout" method="post" class="mt-2">
                            <button type="submit" class="btn btn-primary">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include(__DIR__ . '/../../resources/views/layouts/footer.php') ?>