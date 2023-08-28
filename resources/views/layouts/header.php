<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>
        <?= $title ?? "Partial Project" ?>
    </title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="<?= asset('/assets/img/logo.jpg') ?>" alt="image not found" height="50" width="auto">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active ms-5" aria-current="page" href="/">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <?php
                            $isAuthenticated = false;
                            if (isset($_SESSION['is_auth'])) {
                                $isAuthenticated = $_SESSION['is_auth'];
                            }
                        ?>
                        <?php if($isAuthenticated){ ?>
                            <form action="logout" method="post">
                                <button type="submit" class="nav-link active me-5 btn btn-sm btn-danger text-white" aria-current="page">Logout</button>
                            </form>
                        <?php }else { ?> 
                            <a class="nav-link active me-5 btn btn-sm btn-danger text-white" aria-current="page" href="login">Login</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <?php if(isset($_SESSION['success'])) { ?>
        <div class="bg-success text-dark">
            <p><?php echo $_SESSION['success']; unset($_SESSION['success']) ?></p>
        </div>
        <?php }?>

        <?php if(isset($_SESSION['error'])) { ?>
        <div class="bg-danger text-white">
            <p><?php echo $_SESSION['error']; unset($_SESSION['error']) ?></p>
        </div>
        <?php }?>
    </div>