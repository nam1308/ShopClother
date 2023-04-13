$(document).ready(function () {
    $(".pagination-container > .pagination").addClass("justify-content-center");
    $(".pagination-container > .pagination > li").addClass("page-item");
    $(".pagination-container > .pagination > li > a").addClass("page-link");
});
$(document).ready(function () {
    const val = $("#Maphanloai").val();
    console.log(val);
    var innerProductCategory = ''
    let urlGetPhanloai = "https://localhost:44365/api/ProductAPI/GetSanPhambyCategory?maphanloai=" + val
    console.log("url",urlGetPhanloai)
    $.ajax({
        url: urlGetPhanloai,
        method: 'GET',
        success: function (response) {
            console.log("phan loai", response)

            response.forEach((product) => {
                innerProductCategory += ` <div class="col-lg-4 col-md-6 col-sm-6 pb-1 sanphamcategory">
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

            $("#Maphanloai").after(innerProductCategory);
        },
        error: function (response) {
        }
    });

 
    var innerColor = ''
    let urlGetColor = "https://localhost:44365/api/ProductAPI/GetColor"
    console.log("url", urlGetPhanloai)
    $.ajax({
        url: urlGetColor,
        method: 'GET',
        success: function (response) {
            console.log("phan loai", response)

            response.forEach((product, index) => {
                console.log("index",index)
                innerColor += ` <div class="custom-checkbox mb-3">
                        <input type="radio" name="radiocolor" class="custom-checkbox__input" id="price-color-${index+2}" data-color="${product.MaMau}">
                        <label for="price-color-${index+2}" class="custom-checkbox__label">${product.TenMau}</label>
                    </div>`

            });

            $("#totalColor").after(innerColor);
            $(".custom-checkbox__input").change(function () {
                
                var size = document.getElementsByName('radiosize');
                var sizesp;
                var colorsp;
                for (var i = 0, length = size.length; i < length; i++) {
                    if (size[i].checked) {
                        sizesp=size[i].getAttribute("data-size");
                        break;
                    }

                }
                var color = document.getElementsByName('radiocolor');

                for (var i = 0, length = color.length; i < length; i++) {
                    if (color[i].checked) {
                        colorsp=color[i].getAttribute("data-color");
                        
                        break;
                    }

                }
                const val = $("#Maphanloai").val();
                console.log(val);
    var innerProductCategory = ''
    let urlGetcolorsize = "https://localhost:44365/api/ProductAPI/GetSanPhambyCategory?maphanloai=" + val + "&Size=" + sizesp+"&color="+colorsp
    console.log("url", urlGetcolorsize)
                $.ajax({
                    url: urlGetcolorsize,
                    method: 'GET',
                    success: function (response) {
                        console.log("phan loai", response)

                        response.forEach((product) => {
                            innerProductCategory += ` <div class="col-lg-4 col-md-6 col-sm-6 pb-1 sanphamcategory">
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
                        $('.sanphamcategory').remove();
                        $("#Maphanloai").after(innerProductCategory);
                    },
                    error: function (response) {
                    }
                });

            });
        },
        error: function (response) {
        }
    });
    function Setcheckedcategory() {

    }
})
