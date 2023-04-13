<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi Shop</title>
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="~/Content/assets/fonts/fontawesome-free-5.15.3-web/css/all.min.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Animate -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="~/Content/assets/css/base.css">
    <link rel="stylesheet" href="~/Content/assets/css/main.css">
    <link rel="stylesheet" href="~/Content/assets/css/index.css">
    <link rel="stylesheet" href="~/Content/assets/css/detail.css">
    <link rel="stylesheet" href="~/Content/assets/css/cart.css">
    <link rel="stylesheet" href="~/Content/assets/css/user.css">
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Jquery -->
    <!-- Owl Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Script -->
    <!-- Data Table -->


    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <style>
        .custom-checkbox__input {
            margin-right: 20px;
        }
    </style>
</head>
<body>
    <!-- Header top -->
    <div class="header__top container-fluid">
        <div class="row bg-secondary py-1 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="header-top-left__item d-flex align-items-center h-100">
                    <a href="#" class="header-top-left__link">Giới thiệu</a>
                    <a href="#" class="header-top-left__link">Liên hệ</a>
                    <a href="#" class="header-top-left__link">Trợ giúp</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-end">
                @Html.Action("UserPartial", "Home")
                <div class="d-inline-flex d-lg-none">
                    <a href="#" class="ms-2 d-flex align-items-center">
                        <i class="fas fa-shopping-cart text-dark me-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Header mid -->
    <div class="header__mid container-fluid">
        <div class="row bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-4">
                <a href="/Home" class="logo">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">Multi</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2">Shop</span>
                </a>
            </div>
            <div class="col-4">
                @using (Html.BeginForm("Searching", "Product", FormMethod.Post, new { @class = "input-group" }))
                {
                    @Html.TextBox("txtKeyWord", "", htmlAttributes: new { @class = "form-control shadow-none rounded-0", @placeholder = "Tìm kiếm sản phẩm" })
                    <button type="submit" class="header-search__btn btn shadow-none rounded-0">
                        <i class="fas fa-search"></i>
                    </button>
                }
            </div>
            <div class="col-4">
                <div class="header-mid__contact text-end">
                    <p>Dịch Vụ Khách Hàng</p>
                    <h5>+84 96 783 1727</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Header bottom -->
    <div class="header__bottom container-fluid bg-dark mb-30">
        <div class="row px-xl-5">
            <div class="col-3 position-relative d-none d-lg-block">
                <a class="navbar-category-wrap btn d-flex justify-content-between align-items-center bg-primary"
                   data-bs-toggle="collapse" data-bs-target="#collapseNavbar" aria-expanded="false" aria-controls="collapseNavbar">
                    <h6>
                        <i class="fas fa-bars me-2"></i>
                        Danh mục
                    </h6>
                    <i class="fas fa-angle-down"></i>
                </a>
                <nav class="navbar-category navbar-light bg-light position-absolute collapse" id="collapseNavbar">
                    <div class="navbar-nav w-100">
                        @Html.Action("CategoryPartial", "Home")
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 py-lg-0 h-100">
                    <a href="#" class="logo d-md-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">Multi</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2">Shop</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="navbar-list collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav">
                            <a href="#" class="nav-list_link py-1 nav-link active">Trang chủ</a>
                            <a href="#" class="nav-list_link py-1 nav-link">Bài viết</a>
                            <a href="#" class="nav-list_link py-1 nav-link">Liên hệ</a>
                        </div>
                        <div class="navbar-action navbar-nav d-none d-lg-flex">
                            <a href="/Cart/Detail" class="navbar-action__item d-flex align-items-center">
                                <i class="fas fa-shopping-cart text-primary me-1"></i>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    @RenderBody()
    <!-- Footer -->
    <div class="container-fluid bg-dark text-light mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5">
                <h5 class="text-uppercase mb-4">Thông tin liên lạc</h5>
                <p class="mb-4">
                    Chúng tôi luôn trân trọng và mong đợi nhận được mọi ý kiến đóng góp từ khách hàng để có thể nâng cấp trải nghiệm dịch vụ và sản phẩm tốt hơn nữa.
                </p>
                <p class="mb-2">
                    <i class="fas fa-map-marker-alt me-3 text-primary"></i>
                    Hà Nội, Việt Nam
                </p>
                <p class="mb-2">
                    <i class="fas fa-envelope me-3 text-primary"></i>
                    Nguyenvietminhkhanh@gamil.com
                </p>
                <p class="mb-0">
                    <i class="fas fa-phone-alt me-3 text-primary"></i>
                    +84 96 783 1727
                </p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="text-uppercase mb-4">Cửa hàng</h5>
                        <div class="footer-action d-flex flex-column">
                            <a href="/Home" class="footer-action__link text-light mb-2">
                                <i class="fas fa-angle-right"></i>
                                Trang chủ
                            </a>
                            <a href="/Product/Category" class="footer-action__link text-light mb-2">
                                <i class="fas fa-angle-right"></i>
                                Cửa hàng của chúng tôi
                            </a>
                            <a href="/Cart/Detail" class="footer-action__link text-light mb-2">
                                <i class="fas fa-angle-right"></i>
                                Giỏ hàng
                            </a>
                            <a href="/Cart/Checkout" class="footer-action__link text-light mb-2">
                                <i class="fas fa-angle-right"></i>
                                Thanh toán
                            </a>
                            <a href="#" class="footer-action__link text-light mb-2">
                                <i class="fas fa-angle-right"></i>
                                Liên hệ với chúng tôi
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-uppercase mb-4">Tài khoản của tôi</h5>
                        <div class="footer-action d-flex flex-column">
                            <a href="/User/Info" class="footer-action__link text-light mb-2">
                                <i class="fas fa-angle-right"></i>
                                Thông tin tài khoản
                            </a>
                            <a href="/User/Order" class="footer-action__link text-light mb-2">
                                <i class="fas fa-angle-right"></i>
                                Đơn hàng
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-uppercase mb-4">Hòm thư</h5>
                        <p>Chúng tôi luôn trân trọng và mong đợi nhận được mọi ý kiến đóng góp từ khách hàng.</p>
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control shadow-none rounded-0" placeholder="Email của bạn">
                                <button class="btn btn-primary shadow-none rounded-0">Đăng ký</button>
                            </div>
                        </form>
                        <h6 class="text-uppercase mt-4 mb-3">Follow us</h6>
                        <div class="d-flex">
                            <a href="#" class="btn btn-primary rounded-0 me-2">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-primary rounded-0 me-2">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-primary rounded-0 me-2">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-primary rounded-0 me-2">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright row mx-xl-5 py-4 border-top">
            <div class="col-12">
                <p>
                    © <a href="#" class="text-primary">Multi Shop</a>. Bản quyền và thiết kế bởi
                    <a href="#" class="text-primary">Nhóm 7 - CNTT 2 K60 UTC</a>
                </p>
            </div>
        </div>
    </div>
    <script src="~/Content/assets/js/index.js"></script>
    <script src="~/Content/assets/js/category.js"></script>
    <script src="~/Content/assets/js/cart.js"></script>
    <script src="~/Content/assets/js/user.js"></script>

</body>
</html>