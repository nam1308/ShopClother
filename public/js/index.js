// Banner Slide


setInterval(function () {
    let currentIndexSlide = $(".carousel-indicators a.active").index();
    currentIndexSlide = (currentIndexSlide + 1) % 3;
    $(".carousel-indicators").children().removeClass("active");
    $(".carousel-indicators a").eq(currentIndexSlide).addClass("active");
    $(".banner-left").children().removeClass("active");
    $(".banner-left-item").eq(currentIndexSlide).addClass("active");
}, 10000);

// Trademark slide
$('.owl-carousel').owlCarousel({
    loop: true,
    margin: 30,
    dots: false,
    responsive: {
        0: {
            items: 2
        },
        576: {
            items: 3
        },
        768: {
            items: 4
        },
        992: {
            items: 5
        },
        1200: {
            items: 6
        }
    }
})
console.log("chay nha indexjs")
$(document).ready(function () {
    var innerProductCategory = ''
    let urlGetPhanloai = "https://localhost:44365/api/ProductAPI/GetPhanLoai"
    $.ajax({
        url: urlGetPhanloai,
        method: 'GET',
        success: function (response) {
            console.log("phan loai11", response)

            response.forEach((product) => {
                innerProductCategory += `<div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <a href="/Product/Category?maphanloai=${product.MaPhanLoai}">
                    <div class="category-item mb-4">
                        <div class="category-item__img">
                            <img class="img-fluid" src="../../Content/assets/img/category-1.jpg">
                        </div>
                        <div class="category-item__info">
                            <h6>${product.PhanLoaiPhu}</h6>
                            <small>100 Products</small>
                        </div>
                    </div>
                </a>
            </div>`

            });
            document.getElementById("category_index").innerHTML = innerProductCategory;


        },
        error: function (response) {
        }
    });
    let urlGetNoiBat = "https://localhost:44365/api/ProductAPI/GetSanPhamNoiBat"
    var innerSanPhamNoiBat = ''
    $.ajax({
        url: urlGetNoiBat,
        method: 'GET',
        success: function (response) {
            console.log("noi bat", response)
            response.forEach((product) => {
                innerSanPhamNoiBat += `
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img">
                        <img class="w-100" src="../../Content/assets/img/test-sp-img/${product.AnhDaiDien}">
                        <div class="product-action">
                            <a class="btn btn-outline-dark btn-square rounded-0" href="#"><i class="fa fa-shopping-cart"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4 product-info">
                        <a class="product-info__name" href="/Product/Detail?masanpham=${product.MaSanPham}">${product.TenSanPham}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>${product.GiaBan}</h5>
                        </div>
                    </div>
                </div>
            </div>`

            });
            document.getElementById("SPnoibat").innerHTML = innerSanPhamNoiBat;
        },
        error: function (response) {
        }
    });

})
