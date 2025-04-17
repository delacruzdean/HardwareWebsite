<?php
session_start();

include ("connection.php");

if (!isset($_SESSION['username'])) {
    header("location:login.php");
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- navbar section   -->

    <header class="navbar-section">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><i class="bi bi-chat"></i> BMC Hardware</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#services">services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">about us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#projects">projects</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">contact</a>
                        </li>
                        <li class="nav-item">
                            <div class="dropdown">
                                <a class='nav-link dropdown-toggle' href='edit.php?id=$res_id' id='dropdownMenuLink'
                                    data-bs-toggle='dropdown' aria-expanded='false'>
                                    <i class='bi bi-person'></i>
                                </a>


                                <ul class="dropdown-menu mt-2 mr-0" aria-labelledby="dropdownMenuLink">

                                    <li>
                                        <?php

                                        $id = $_SESSION['id'];
                                        $query = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");

                                        while ($result = mysqli_fetch_assoc($query)) {
                                            $res_username = $result['username'];
                                            $res_email = $result['email'];
                                            $res_id = $result['id'];
                                        }


                                        echo "<a class='dropdown-item' href='edit.php?id=$res_id'>Change Profile</a>";


                                        ?>

                                    </li>
                                    <li><a class="dropdown-item" href="login.php">Logout</a></li>
                                </ul>
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <div class="name">
        <center>Welcome,
            <?php
            // echo $_SESSION['valid'];
            
            echo $_SESSION['username'];

            ?>
            !
        </center>
    </div>

   <!-- hero section  -->

   <section id="home" class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12 text-content">
                    <h1>Your Trusted Hardware Partner</h1>
                    <p>Providing quality tools and materials for all your building and renovation needs.
                    </p>
                    <button class="btn"><a href="#">Estimate Project</a></button>
                </div>
                <div class="col-lg-7 col-md-12 col-sm-12">
                    <img src="images/hero-image.png" alt="" class="img-fluid">
                </div>

            </div>
        </div>
    </section>

<!-- services section  -->

<section class="services-section" id="services">
    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-md-12 col-sm-12 services">

                <div class="row row1">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card">
                            <img src="images/consultation.png" class="card-img-top" alt="Consultation">
                            <div class="card-body">
                                <h4 class="card-title">Consultation</h4>
                                <p class="card-text">Our experts provide tailored advice and solutions to help you choose the right materials and tools for your projects.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card">
                            <img src="images/tool-rental.png" class="card-img-top" alt="Tool Rental">
                            <div class="card-body">
                                <h4 class="card-title">Tool Rental</h4>
                                <p class="card-text">Rent top-quality tools and equipment to complete your projects efficiently and cost-effectively.</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row row2">

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card">
                            <img src="images/delivery.png" class="card-img-top" alt="Delivery">
                            <div class="card-body">
                                <h4 class="card-title">Delivery</h4>
                                <p class="card-text">Fast and reliable delivery services to ensure your materials arrive when and where you need them.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card">
                            <img src="images/custom-orders.png" class="card-img-top" alt="Custom Orders">
                            <div class="card-body">
                                <h4 class="card-title">Custom Orders</h4>
                                <p class="card-text">Special orders for unique materials and tools to meet the specific needs of your projects.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 text-content">
                <h3>Services</h3>
                <h1>We help you achieve your goals with our exceptional services.</h1>
                <p>With over ten years of experience, we are dedicated to providing high-quality materials, tools, and services to support your building and renovation projects.</p>
                <button class="btn">Explore Services</button>
            </div>

        </div>
    </div>
</section>

    <!-- about section  -->

    <section class="about-section" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <img src="images/about.jpg" alt="" class="img-fluid">
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 text-content">
                    <h3>About us</h3>
                    <h1>Where your construction goals are our mission.</h1>

                    <p>Our journey began with a simple belief: quality construction starts with quality materials and exceptional service. 
                        BMC Hardware started as a small family business with a passion for construction and a commitment to excellence. Over the years,
                         we have grown into a trusted partner for countless builders and renovators, 
                        thanks to our unwavering dedication to quality and customer service.</p>
                    <button>learn more</button>
                </div>
            </div>
        </div>
    </section>

    <!-- project section  -->

    <section class="project-section" id="projects">
        <div class="container">
            <div class="row text">
                <div class="col-lg-6 col-md-12">
                    <h1>Our latest project</h1>
                    <hr>
                </div>
                <div class="col-lg-6 col-md-12">
                    <p>Discover our latest achievement: beautifully crafted homes built with precision and quality using our top-notch materials and expert services. 
                        Proud to support every step from foundation to finish!</p>
                </div>
            </div>
            <div class="row project">

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card">
                        <img src="images/project-1.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="text">
                                <h4 class="card-title">Lebron James Mansion</h4>
                                <p class="card-text">Development. Jan 19,2022</p>
                                <button>see project</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card">
                        <img src="images/project-2.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="text">
                                <h4 class="card-title">Lebron James 2nd Mansion</h4>
                                <p class="card-text">Developed Jun 29, 2023</p>
                                <button>see project</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card">
                        <img src="images/project-3.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="text">
                                <h4 class="card-title">AMP Mansion</h4>
                                <p class="card-text">Developed Aug 9, 2021</p>
                                <button>see project</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card">
                        <img src="images/project-4.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="text">
                                <h4 class="card-title">Golden Gate Bridge</h4>
                                <p class="card-text">Development. May 27, 1937</p>
                                <button>see project</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- contact section  -->

    <section class="contact-section" id="contact">
        <div class="container">

            <div class="row gy-4">

                <h1>contact us</h1>
                <div class="col-lg-6">

                    <div class="row gy-4">
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-geo-alt"></i>
                                <h3>Address</h3>
                                <p>420 Salazar Street,<br>Taytay rizal, Barangay Dolores</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-telephone"></i>
                                <h3>Call Us</h3>
                                <p>+91 9876545672<br>+91 8763456243</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-envelope"></i>
                                <h3>Email Us</h3>
                                <p>BMCHard@gmail.com<br>BMCHard_Admin@gmail.com</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <i class="bi bi-clock"></i>
                                <h3>Open Hours</h3>
                                <p>Monday - Friday<br>9:00AM - 05:00PM</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6 form">
                    <form action="contact.php" method="POST" class="php-email-form">
                        <div class="row gy-4">

                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                            </div>

                            <div class="col-md-6 ">
                                <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                            </div>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                            </div>

                            <div class="col-md-12">
                                <textarea class="form-control" name="message" rows="5" placeholder="Message"
                                    required></textarea>
                            </div>

                            <div class="col-md-12 text-center">
                                <button type="submit" name="submit">Send Message</button>
                            </div>

                        </div>
                    </form>

                </div>

            </div>

        </div>
    </section>

    <!-- footer section  -->

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-sm-12">
                    <p class="logo"><i class="bi bi-chat"></i> BMC HARDWARE</p>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <ul class="d-flex">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">services</a></li>
                        <li><a href="#">projects</a></li>
                        <li><a href="#">about us</a></li>
                        <li><a href="#">contact</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-12 col-sm-12">
                    <p>&copy;BMC HARDWARE</p>
                </div>

                <div class="col-lg-1 col-md-12 col-sm-12">
                    <!-- back to top  -->

                    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                            class="bi bi-arrow-up-short"></i></a>
                </div>

            </div>

        </div>

    </footer>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>