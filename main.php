
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>NAT SETTING</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom fonts for this template -->
        <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet">
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/resume.min.css" rel="stylesheet">

    </head>

    <body id="page-top">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">
                <span class="d-block d-lg-none">NAT Setting</span>
                <span class="d-none d-lg-block">
              <img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="img/profile.jpg" alt="">
            </span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        </nav>

        <div class="container-fluid p-0">
            <section class="resume-section p-3 p-lg-5 d-flex d-column" id="about">
                <h1 class="mb-0"> NAT LOGIN SUCCESS.</h1>
                <p> <a class="btn btn-primary btn-lg" href="logout.php" role="button"> Logout </a></p>
            </section>

            <section class="resume-section p-3 p-lg-5 d-flex d-column" id="about">
                <?php
                /**
                 * Created by PhpStorm.
                 * User: big94
                 * Date: 2018-07-20
                 * Time: 오전 2:17
                 */


                session_start();

                if (!isset($_SESSION['userid'])) {
                    header('Location : ./login.php');
                }
                echo "홈(로그인) 성공</br>";
                echo "<a href=logout.php>logout</a> </br>";

                $ip_print = $_SERVER['REMOTE_ADDR'];
                echo "<p>"."현재 접속한 장치의 아이피 : "."</p>" . $ip_print . "</br>";

                ?>
            </section>
        </div>
    </body>
</html>
