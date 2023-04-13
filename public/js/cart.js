let productCartItem = document.querySelectorAll('.table-cart-body tr');
let percentDecrease = 0;

$(document).ready(function () {
    let urlGetPercent = "https://localhost:44365/Cart/GetCoupon"
    $.ajax({
        url: urlGetPercent,
        method: 'GET',
        contentType: 'json',
        dataType: 'json',
        success: function (response) {
            if (response == null)
                percentDecrease = 0;
            else
                percentDecrease = response.percentDecrease;
        },
        error: function (response) {
        }
    });
})

function removeProductCart(index, maSanPham, maMau, kichCo) {
    productCartItem[index].remove();
    productCartItem = document.querySelectorAll('.table-cart-body tr');
    let url = "https://localhost:44365/Cart/RemoveProductCartQuantity?masanpham=" + maSanPham + "&mamau=" + maMau + "&kichco=" + kichCo;
    $.ajax({
        url: url,
        method: 'GET',
        success: function (response) {
        },
        error: function (response) {
        }
    });
    console.log(productCartItem.length)
    if (productCartItem.length == 0) {
        document.getElementById("sum-total-product").innerText = 0;
        document.getElementById("coupon-price").innerText = 0;
        document.getElementById("sum-total").innerText = 0;
    } else {
        caculateSumTotalProduct();
        caculateCoupon();
        caculateSumTotal();
    }
}

function updateProductCartInSession(maSanPham, maMau, kichCo, soLuong) {
    let url = "https://localhost:44365/Cart/UpdateProductCartQuantity?masanpham=" + maSanPham + "&mamau=" + maMau + "&kichco=" + kichCo + "&soluong=" + soLuong;
    $.ajax({
        url: url,
        method: 'GET',
        success: function (response) {
        },
        error: function (response) {
        }
    });
}

function caculateCoupon() {
    console.log(percentDecrease);
    let sumTotalProduct = document.getElementById("sum-total-product").innerText;
    document.getElementById("coupon-price").innerText = parseFloat(sumTotalProduct) / 100 * percentDecrease;
}

function caculateSumTotal() {
    let sumTotalProduct = document.getElementById("sum-total-product").innerText;
    let couponPrice = document.getElementById("coupon-price").innerText;
    let sumTotal = document.getElementById("sum-total");
    if (parseFloat(sumTotalProduct) != 0) {
        sumTotal.innerText = parseFloat(sumTotalProduct) + 30000 - parseFloat(couponPrice);
    }
}

function caculateSumTotalProduct() {
    let sumTotalProduct = 0;
    productCartItem.forEach(function (element) {
        let totalPriceProduct = element.querySelector('td:nth-child(4)').innerText;
        sumTotalProduct += parseFloat(totalPriceProduct);
    });
    document.getElementById("sum-total-product").innerText = sumTotalProduct;
}

function applyCoupon() {
    let coupon = document.querySelector(".coupon-input").value;
    var urlGetCoupon = 'https://localhost:44365/api/ProductAPI/GetCoupon?makm=' + coupon;
    $.ajax({
        url: urlGetCoupon,
        method: 'GET',
        contentType: 'json',
        dataType: 'json',
        success: function (response) {
            if (response == null) {
                alert("Không có mã khuyến mại này!");
                percentDecrease = 0;
            }
            else {
                percentDecrease = response.percentDecrease;
            }
            caculateCoupon();
            caculateSumTotal();
        },
        error: function (response) {
        }
    });
    var urlSaveCoupon = 'https://localhost:44365/Cart/SaveCoupon?makm=' + coupon;
    $.ajax({
        url: urlSaveCoupon,
        method: 'GET',
        success: function (response) {
        },
        error: function (response) {
        }
    });
}

function updateTotalPriceProduct(index, quantiy) {
    let priceProduct = productCartItem[index].querySelector('td:nth-child(2)').innerText;
    let totalPriceProduct = productCartItem[index].querySelector('td:nth-child(4)');
    totalPriceProduct.innerText = parseFloat(priceProduct) * quantiy;
}

function onChangeProductCartQuantity(index, maSanPham, maMau, kichCo) {
    let quantityProductCartItem = productCartItem[index].querySelector('.form-control');
    if (parseInt(quantityProductCartItem.value) <= 0 || isNaN(parseInt(quantityProductCartItem.value))) {
        quantityProductCartItem.value = 1;
    }
    updateTotalPriceProduct(index, quantityProductCartItem.value);
    updateProductCartInSession(maSanPham, maMau, kichCo, quantityProductCartItem.value);
    caculateSumTotalProduct();
    caculateCoupon();
    caculateSumTotal();
}

function decreaseProductCartQuantity(index, maSanPham, maMau, kichCo) {
    let quantityProductCartItem = productCartItem[index].querySelector('.form-control');
    let quantityProductCart = parseInt(quantityProductCartItem.value);
    if (quantityProductCart >= 1) {
        quantityProductCart -= 1;
        quantityProductCartItem.value = quantityProductCart;
    }
    if (quantityProductCartItem.value == 0)
        removeProductCart(index, maSanPham, maMau, kichCo);
    updateTotalPriceProduct(index, quantityProductCartItem.value);
    updateProductCartInSession(maSanPham, maMau, kichCo, quantityProductCartItem.value);
    caculateSumTotalProduct();
    caculateCoupon();
    caculateSumTotal();
}

function increaseProductCartQuantity(index, maSanPham, maMau, kichCo) {
    let quantityProductCartItem = productCartItem[index].querySelector('.form-control');
    let quantityProductCart = parseInt(quantityProductCartItem.value);
    quantityProductCart += 1;
    quantityProductCartItem.value = quantityProductCart;
    updateTotalPriceProduct(index, quantityProductCartItem.value);
    updateProductCartInSession(maSanPham, maMau, kichCo, quantityProductCartItem.value);
    caculateSumTotalProduct();
    caculateCoupon();
    caculateSumTotal();
}