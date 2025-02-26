<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bearry Laundry</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="{{ asset('companyprofile/assets/css/style.css') }}">
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('companyprofile/assets/images/bear.gif') }}" alt="Bearry Laundry Logo" width="70">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#hero">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#reviews">Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#team">Team</a>
                    </li>
                </ul>
                <a href="{{ route('filament.staff.auth.login') }}" class="btn btn-brand ms-lg-3">Staff</a>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section id="hero" class="min-vh-100 d-flex align-items-center text-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 data-aos="fade-left" class="text-uppercase text-white fw-semibold display-1">Bearry Laundry</h1>
                    <h5 class="text-white mt-3 mb-4" data-aos="fade-right">Your Trusted Partner for Premium Laundry Services</h5>
                    <div data-aos="fade-up" data-aos-delay="50">
                        <a href="#" class="btn btn-brand me-2">Call Us</a>
                        <a href="{{ route('trackinvoice') }}" class="btn btn-light ms-2">Track Your Order</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section id="about" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="50">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">About Us</h1>
                        <div class="line"></div>
                        <p>At Bearry Laundry, we are committed to providing top-notch laundry services with a focus on quality, convenience, and customer satisfaction.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6" data-aos="fade-down" data-aos-delay="50">
                    <img src="{{ asset('companyprofile/assets/images/about.png') }}" alt="About Bearry Laundry">
                </div>
                <div data-aos="fade-down" data-aos-delay="150" class="col-lg-5">
                    <h2>Why Choose Bearry Laundry?</h2>
                    <p class="mt-3 mb-4">We understand the importance of clean and well-maintained clothing. That's why we offer a range of services tailored to meet your needs.</p>
                    <div class="d-flex pt-4 mb-3">
                        <div class="iconbox me-4">
                            <i class="ri-hq-fill"></i>
                        </div>
                        <div>
                            <h5>Premium Quality, Affordable Prices</h5>
                            <p>We use only the best products and techniques to ensure your clothes are treated with care.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="iconbox me-4">
                            <i class="ri-user-5-fill"></i>
                        </div>
                        <div>
                            <h5>Customer Convenience</h5>
                            <p>With our easy-to-use app and pickup/delivery services, we make laundry day hassle-free.</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="iconbox me-4">
                            <i class="ri-rocket-2-fill"></i>
                        </div>
                        <div>
                            <h5>Fast and Efficient Service</h5>
                            <p>We pride ourselves on quick turnaround times without compromising on quality.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES -->
    <section id="services" class="section-padding border-top">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">Our Services</h1>
                        <div class="line"></div>
                        <p>Explore our wide range of laundry services designed to meet your every need.</p>
                    </div>
                </div>
            </div>
            <div class="row g-4 text-center">
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="150">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-t-shirt-fill"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Dry Cleaning</h5>
                        <p>Professional dry cleaning services for delicate fabrics and special garments.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="250">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-t-shirt-air-fill"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Wet Cleaning</h5>
                        <p>Eco-friendly wet cleaning for sensitive fabrics that require special care.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="350">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-time-fill"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Express Laundry</h5>
                        <p>Fast and efficient laundry services for those in a hurry.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="450">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-temp-hot-2-fill"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Ironing Services</h5>
                        <p>Professional ironing to keep your clothes looking crisp and neat.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="550">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-user-star-line"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Premium Laundry</h5>
                        <p>Luxury laundry service with high-quality detergents and exclusive fragrances.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="650">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="ri-inbox-fill"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Pickup & Delivery</h5>
                        <p>Convenient pickup and delivery services to save you time.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- COUNTER -->
    <section id="counter" class="section-padding">
        <div class="container text-center">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6" data-aos="fade-down" data-aos-delay="150">
                    <h1 class="text-white display-4">30+</h1>
                    <h6 class="text-uppercase mb-0 text-white mt-3">Employees</h6>
                </div>
                <div class="col-lg-3 col-sm-6" data-aos="fade-down" data-aos-delay="250">
                    <h1 class="text-white display-4">8K+</h1>
                    <h6 class="text-uppercase mb-0 text-white mt-3">Happy Customers</h6>
                </div>
                <div class="col-lg-3 col-sm-6" data-aos="fade-down" data-aos-delay="350">
                    <h1 class="text-white display-4">100+</h1>
                    <h6 class="text-uppercase mb-0 text-white mt-3">Daily Orders</h6>
                </div>
                <div class="col-lg-3 col-sm-6" data-aos="fade-down" data-aos-delay="450">
                    <h1 class="text-white display-4">45+</h1>
                    <h6 class="text-uppercase mb-0 text-white mt-3">Washing Machines</h6>
                </div>
            </div>
        </div>
    </section>

    <!-- REVIEW -->
    <section id="reviews" class="section-padding bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">Customer Reviews</h1>
                        <div class="line"></div>
                        <p>Hear what our satisfied customers have to say about our services.</p>
                    </div>
                </div>
            </div>
            <div class="row gy-5 gx-4">
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="150">
                    <div class="review">
                        <div class="review-head p-4 bg-white theme-shadow">
                            <div class="text-warning">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                            </div>
                            <p>Amazing service! My clothes have never looked better. Highly recommend Bearry Laundry!</p>
                        </div>
                        <div class="review-person mt-4 d-flex align-items-center">
                            <img class="rounded-circle" src="{{ asset('companyprofile/assets/images/avatar-1.jpg') }}" alt="Customer Avatar">
                            <div class="ms-3">
                                <h5>Dianne Russell</h5>
                                <small>Frequent Customer</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="250">
                    <div class="review">
                        <div class="review-head p-4 bg-white theme-shadow">
                            <div class="text-warning">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                            </div>
                            <p>Fast and reliable. The pickup and delivery service is a game-changer. Thank you, Bearry Laundry!</p>
                        </div>
                        <div class="review-person mt-4 d-flex align-items-center">
                            <img class="rounded-circle" src="{{ asset('companyprofile/assets/images/avatar-2.jpg') }}" alt="Customer Avatar">
                            <div class="ms-3">
                                <h5>John Doe</h5>
                                <small>Busy Professional</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="350">
                    <div class="review">
                        <div class="review-head p-4 bg-white theme-shadow">
                            <div class="text-warning">
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                                <i class="ri-star-fill"></i>
                            </div>
                            <p>Excellent quality and customer service. My clothes always come back looking brand new.</p>
                        </div>
                        <div class="review-person mt-4 d-flex align-items-center">
                            <img class="rounded-circle" src="{{ asset('companyprofile/assets/images/avatar-3.jpg') }}" alt="Customer Avatar">
                            <div class="ms-3">
                                <h5>Jane Smith</h5>
                                <small>Happy Customer</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TEAM -->
    <section id="team" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">Our Team</h1>
                        <div class="line"></div>
                        <p>Meet the dedicated team behind Bearry Laundry.</p>
                    </div>
                </div>
            </div>
            <div class="row g-4 text-center mx-auto ">
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="150">
                    <div class="team-member image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="{{ asset('companyprofile/assets/images/founder.png') }}" alt="Fatir Zaidan">
                        </div>
                        <div class="team-member-content">
                            <h4 class="text-white">Fatir Zaidan</h4>
                            <p class="mb-0 text-white">Founder</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="250">
                    <div class="team-member image-zoom">
                        <div class="image-zoom-wrapper">
                            <!-- <img src="./assets/images/ceo.png" alt="Hana Aurora"> -->
                        </div>
                        <div class="team-member-content">
                            <h4 class="text-white">Hana Aurora</h4>
                            <p class="mb-0 text-white">CEO</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT -->
    <!-- <section class="section-padding bg-light" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 text-white fw-semibold">Gete in touch</h1>
                        <div class="line bg-white"></div>
                        <p class="text-white">We love to craft digital experiances for brands rather than crap and more lorem ipsums and do crazy skills</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" data-aos="fade-down" data-aos-delay="250">
                <div class="col-lg-8">
                    <form action="#" class="row g-3 p-lg-5 p-4 bg-white theme-shadow">
                        <div class="form-group col-lg-6">
                            <input type="text" class="form-control" placeholder="Enter first name">
                        </div>
                        <div class="form-group col-lg-6">
                            <input type="text" class="form-control" placeholder="Enter last name">
                        </div>
                        <div class="form-group col-lg-12">
                            <input type="email" class="form-control" placeholder="Enter Email address">
                        </div>
                        <div class="form-group col-lg-12">
                            <input type="text" class="form-control" placeholder="Enter subject">
                        </div>
                        <div class="form-group col-lg-12">
                            <textarea name="message" rows="5" class="form-control" placeholder="Enter Message"></textarea>
                        </div>
                        <div class="form-group col-lg-12 d-grid">
                            <button class="btn btn-brand">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section> -->

    <!-- BLOG -->
    <!-- <section id="blog" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">Recent News & Articles</h1>
                        <div class="line"></div>
                        <p>We love to craft digital experiances for brands rather than crap and more lorem ipsums and do crazy skills</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="150">
                    <div class="team-member image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="./assets/images/blog-post-1.jpg" alt="">
                        </div>
                        <h5 class="mt-4">Web Design 2022</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit sequi quos magni!</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="250">
                    <div class="team-member image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="./assets/images/blog-post-2.jpg" alt="">
                        </div>
                        <h5 class="mt-4">Web Design 2022</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit sequi quos magni!</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="350">
                    <div class="team-member image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="./assets/images/blog-post-3.jpg" alt="">
                        </div>
                        <h5 class="mt-4">Web Design 2022</h5>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit sequi quos magni!</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <!-- FOOTER -->
    <footer class="bg-dark">
        <div class="footer-top">
            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-3 col-sm-6">
                        <a href="#"><img src="{{ asset('companyprofile/assets/images/bear.gif') }}" alt=""></a>
                        <div class="line"></div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem, hic!</p>
                        <div class="social-icons">
                            <a href="#"><i class="ri-twitter-fill"></i></a>
                            <a href="#"><i class="ri-instagram-fill"></i></a>
                            <a href="#"><i class="ri-github-fill"></i></a>
                            <a href="#"><i class="ri-dribbble-fill"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">LAYANAN</h5>
                        <div class="line"></div>
                        <ul>
                            <li><a href="#">DRY CLEANING</a></li>
                            <li><a href="#">WET CLEANING</a></li>
                            <li><a href="#">LAUNDRY EXPRESS</a></li>
                            <li><a href="#">LAUNDRY PREMIUM</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">ABOUT</h5>
                        <div class="line"></div>
                        <ul>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Tracking Invoice</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <h5 class="mb-0 text-white">CONTACT</h5>
                        <div class="line"></div>
                        <ul>
                            <li>Ruko Golden Vienna 3</li>
                            <li>+62 812-2112-293</li>
                            <li>www.bearrylaundry.com</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row g-4 justify-content-between">
                    <div class="col-auto">
                        <p class="mb-0">© Copyright Bearry. All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="{{ asset('companyprofile/assets/js/main.js') }}"></script>
</body>

</html>