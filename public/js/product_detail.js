//product image slider
$(document).ready(function() {
    $('.product-detail-img__slider').owlCarousel({
        loop: true,
        margin: 16,
        dots: false
    });

    $(".product-detail-img-slide__item").click(function() {
        let pathImg = $(this).children().attr("src");
        $('.product-detail-img__represent').attr("src", pathImg);
    });
});

document.querySelectorAll(".product-rb-color__input")[0].checked = true;
document.querySelectorAll(".product-rb-size__input")[0].checked = true;

let quantityProductBuyItem = document.querySelector('.product-quantity .form-control');
let quantityProductButton = document.querySelectorAll('.product-quantity button');

quantityProductBuyItem.oninput = () => {
    if (parseInt(quantityProductBuyItem.value) <= 0 || isNaN(parseInt(quantityProductBuyItem.value))) {
        quantityProductBuyItem.value = 1;
    }
}

quantityProductButton[0].onclick = (event) => {
    event.preventDefault();
    let quantityProductBuy = parseInt(quantityProductBuyItem.value);
    if (quantityProductBuy > 1) {
        quantityProductBuy -= 1;
        quantityProductBuyItem.value = quantityProductBuy;
    }
}

quantityProductButton[1].onclick = (event) => {
    event.preventDefault();
    let quantityProductBuy = parseInt(quantityProductBuyItem.value);
    quantityProductBuy += 1;
    quantityProductBuyItem.value = quantityProductBuy;
}

$(".form-add-to-cart").submit(function (event) {
    event.preventDefault();
    var productNow = document.querySelector(".product-detail__title").getAttribute("data-code");
    var colorProductList = document.querySelectorAll("#product-rb-color-container > .radio-button");
    for (let i = 0; i < colorProductList.length; i++) {
        if (colorProductList[i].querySelector(".product-rb-color__input").checked) {
            var colorNow = colorProductList[i].querySelector(".radio-button__label").htmlFor;
            break;
        }
    }
    var sizeProductList = document.querySelectorAll("#product-rb-size-container > .radio-button");
    for (let i = 0; i < sizeProductList.length; i++) {
        if (sizeProductList[i].querySelector(".product-rb-size__input").checked) {
            var sizeNow = sizeProductList[i].querySelector(".radio-button__label").innerText;
            break;
        }
    }
    document.querySelector(".form-add-to-cart").setAttribute("action", "/Cart/AddCart?masanpham=" + productNow + "&mamau=" + colorNow + "&kichco=" + sizeNow + "&soluong=" + quantityProductBuyItem.value);
    this.submit();
});

function getImageColorProduct(productCode, colorCode) {
    var urlGetImage = 'https://localhost:44365/api/ProductAPI/GetImageColorProduct?masanpham=' + productCode + '&mamau=' + colorCode;
    $.ajax({
        url: urlGetImage,
        method: 'GET',
        contentType: 'json',
        dataType: 'json',
        success: function (response) {
            var imageList = document.querySelectorAll(".product-detail-img-slide__item img");
            for (let i = 0; i < imageList.length; i++) {
                imageList[i].setAttribute("src", "/Content/assets/img/test-sp-img/" + response[i % response.length].TenFileAnh)
            }
            document.querySelector(".product-detail-img__represent").setAttribute("src", "/Content/assets/img/test-sp-img/" + response[0].TenFileAnh);
        },
        error: function (response) {

        }
    });
    var urlGetSize = 'https://localhost:44365/api/ProductAPI/GetSizeProduct?masanpham=' + productCode + '&mamau=' + colorCode;
    $.ajax({
        url: urlGetSize,
        method: 'GET',
        contentType: 'json',
        dataType: 'json',
        success: function (response) {
            document.getElementById("product-rb-size-container");
            var sizeContainer = '';
            for (var i = 0; i < response.length; i++) {
                if (response[i].SoLuong == 0) {
                    sizeContainer += '<div class="radio-button me-3">';
                    sizeContainer += '<input type="radio" class="radio-button__input product-rb-size__input" id="' + response[i].KichCo + '" name="size" hidden disabled>';
                    sizeContainer += '<label for="' + response[i].KichCo + '" class="radio-button__checkmark"></label>';
                    sizeContainer += '<label for="' + response[i].KichCo + '" class="radio-button__label">' + response[i].KichCo + '</label>';
                    sizeContainer += '</div>'
                }
                else {
                    sizeContainer += '<div class="radio-button me-3">';
                    sizeContainer += '<input type="radio" class="radio-button__input product-rb-size__input" id="' + response[i].KichCo + '" name="size" hidden>';
                    sizeContainer += '<label for="' + response[i].KichCo + '" class="radio-button__checkmark"></label>';
                    sizeContainer += '<label for="' + response[i].KichCo + '" class="radio-button__label">' + response[i].KichCo + '</label>';
                    sizeContainer += '</div>'
                }

            }
            document.getElementById("product-rb-size-container").innerHTML = sizeContainer;
            /*document.querySelectorAll(".product-rb-size__input")[0].checked = true;*/
            //setColorFormAddToCart(productCode, colorCode);
            //$("#product-rb-size-container > .radio-button > .radio-button__checkmark").click(function () {
            //    let size = $(this).next().text();
            //    setSizeFormAddToCart(productCode, size);
            //});
            //$("#product-rb-size-container > .radio-button > .radio-button__label").click(function () {
            //    let size = $(this).text();
            //    setSizeFormAddToCart(productCode, size);
            //});
        },
        error: function (response) {

        }
    });
}

// Tab
$(".tab-navbar__item").eq(0).click(function() {
    $(".tab-navbar__item").eq(1).removeClass("active");
    $(".tab-content-item").eq(1).removeClass("active");
    $(this).addClass("active");
    $(".tab-content-item").eq(0).addClass("active");
});
$(".tab-navbar__item").eq(1).click(function() {
    $(".tab-navbar__item").eq(0).removeClass("active");
    $(".tab-content-item").eq(0).removeClass("active");
    $(this).addClass("active");
    $(".tab-content-item").eq(1).addClass("active");
});

// Slider
$('.product-slider').owlCarousel({
    loop: true,
    margin: 30,
    dots: false,
    responsive:{
        0:{
            items: 1
        },
        576:{
            items: 2
        },
        768:{
            items:3
        },
        992:{
            items:4
        }
    }
});