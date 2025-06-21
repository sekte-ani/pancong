/**
 * Template Name: Yummy
 * Template URL: https://bootstrapmade.com/yummy-bootstrap-restaurant-website-template/
 * Updated: Aug 07 2024 with Bootstrap v5.3.3
 * Author: BootstrapMade.com
 * License: https://bootstrapmade.com/license/
 */

(function () {
    "use strict";

    /**
     * Apply .scrolled class to the body as the page is scrolled down
     */
    function toggleScrolled() {
        const selectBody = document.querySelector("body");
        const selectHeader = document.querySelector("#header");
        if (
            !selectHeader.classList.contains("scroll-up-sticky") &&
            !selectHeader.classList.contains("sticky-top") &&
            !selectHeader.classList.contains("fixed-top")
        )
            return;
        window.scrollY > 100
            ? selectBody.classList.add("scrolled")
            : selectBody.classList.remove("scrolled");
    }

    document.addEventListener("scroll", toggleScrolled);
    window.addEventListener("load", toggleScrolled);

    /**
     * Mobile nav toggle
     */
    const mobileNavToggleBtn = document.querySelector(".mobile-nav-toggle");

    function mobileNavToogle() {
        document.querySelector("body").classList.toggle("mobile-nav-active");
        mobileNavToggleBtn.classList.toggle("bi-list");
        mobileNavToggleBtn.classList.toggle("bi-x");
    }
    mobileNavToggleBtn.addEventListener("click", mobileNavToogle);

    /**
     * Hide mobile nav on same-page/hash links
     */
    document.querySelectorAll("#navmenu a").forEach((navmenu) => {
        navmenu.addEventListener("click", () => {
            if (document.querySelector(".mobile-nav-active")) {
                mobileNavToogle();
            }
        });
    });

    /**
     * Toggle mobile nav dropdowns
     */
    document
        .querySelectorAll(".navmenu .toggle-dropdown")
        .forEach((navmenu) => {
            navmenu.addEventListener("click", function (e) {
                e.preventDefault();
                this.parentNode.classList.toggle("active");
                this.parentNode.nextElementSibling.classList.toggle(
                    "dropdown-active"
                );
                e.stopImmediatePropagation();
            });
        });

    /**
     * Preloader
     */
    const preloader = document.querySelector("#preloader");
    if (preloader) {
        window.addEventListener("load", () => {
            preloader.remove();
        });
    }

    /**
     * Scroll top button
     */
    let scrollTop = document.querySelector(".scroll-top");

    function toggleScrollTop() {
        if (scrollTop) {
            window.scrollY > 100
                ? scrollTop.classList.add("active")
                : scrollTop.classList.remove("active");
        }
    }
    scrollTop.addEventListener("click", (e) => {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    });

    window.addEventListener("load", toggleScrollTop);
    document.addEventListener("scroll", toggleScrollTop);

    /**
     * Animation on scroll function and init
     */
    function aosInit() {
        AOS.init({
            duration: 600,
            easing: "ease-in-out",
            once: true,
            mirror: false,
        });
    }
    window.addEventListener("load", aosInit);

    /**
     * Initiate glightbox
     */
    const glightbox = GLightbox({
        selector: ".glightbox",
    });

    /**
     * Initiate Pure Counter
     */
    new PureCounter();

    /**
     * Init swiper sliders
     */
    function initSwiper() {
        document
            .querySelectorAll(".init-swiper")
            .forEach(function (swiperElement) {
                let config = JSON.parse(
                    swiperElement
                        .querySelector(".swiper-config")
                        .innerHTML.trim()
                );

                if (swiperElement.classList.contains("swiper-tab")) {
                    initSwiperWithCustomPagination(swiperElement, config);
                } else {
                    new Swiper(swiperElement, config);
                }
            });
    }

    window.addEventListener("load", initSwiper);

    /**
     * Correct scrolling position upon page load for URLs containing hash links.
     */
    window.addEventListener("load", function (e) {
        if (window.location.hash) {
            if (document.querySelector(window.location.hash)) {
                setTimeout(() => {
                    let section = document.querySelector(window.location.hash);
                    let scrollMarginTop =
                        getComputedStyle(section).scrollMarginTop;
                    window.scrollTo({
                        top: section.offsetTop - parseInt(scrollMarginTop),
                        behavior: "smooth",
                    });
                }, 100);
            }
        }
    });

    /**
     * Navmenu Scrollspy
     */
    let navmenulinks = document.querySelectorAll(".navmenu a");

    function navmenuScrollspy() {
        navmenulinks.forEach((navmenulink) => {
            if (!navmenulink.hash) return;
            let section = document.querySelector(navmenulink.hash);
            if (!section) return;
            let position = window.scrollY + 200;
            if (
                position >= section.offsetTop &&
                position <= section.offsetTop + section.offsetHeight
            ) {
                document
                    .querySelectorAll(".navmenu a.active")
                    .forEach((link) => link.classList.remove("active"));
                navmenulink.classList.add("active");
            } else {
                navmenulink.classList.remove("active");
            }
        });
    }
    window.addEventListener("load", navmenuScrollspy);
    document.addEventListener("scroll", navmenuScrollspy);

    $(document).ready(function () {
        console.log("Menu script loaded");

        initializeMenuPage();
        initializeCartPage();

        updateCartBadge();
    });

    function initializeMenuPage() {
        if ($(".menu-item").length > 0) {
            initializeCounters();
            initializeFilter();
            initializeSearch();
            console.log("Menu page initialized");
        }
    }

    function initializeCounters() {
        var cards = document.querySelectorAll(".card[data-menu-id]");

        for (var i = 0; i < cards.length; i++) {
            var card = cards[i];
            var minusBtn = card.querySelector(".btn-minus");
            var plusBtn = card.querySelector(".btn-plus");
            var countSpan = card.querySelector(".count");
            var cartIcon = card.querySelector(".cart-icon");

            (function (card, minusBtn, plusBtn, countSpan, cartIcon) {
                var count = 0;

                if (plusBtn) {
                    plusBtn.addEventListener("click", function (e) {
                        e.preventDefault();
                        count++;
                        countSpan.textContent = count;

                        if (count > 0) {
                            cartIcon.style.color = "#28a745";
                            cartIcon.style.transform = "scale(1.1)";
                        }
                    });
                }

                if (minusBtn) {
                    minusBtn.addEventListener("click", function (e) {
                        e.preventDefault();
                        if (count > 0) {
                            count--;
                            countSpan.textContent = count;

                            if (count === 0) {
                                cartIcon.style.color = "";
                                cartIcon.style.transform = "";
                            }
                        }
                    });
                }

                if (cartIcon) {
                    cartIcon.addEventListener("click", function () {
                        var menuId = cartIcon.getAttribute("data-menu-id");
                        addToCart(menuId, count, cartIcon, countSpan);
                    });
                }
            })(card, minusBtn, plusBtn, countSpan, cartIcon);
        }
    }

    function addToCart(menuId, qty, cartIcon, countSpan) {
        var authCheck = document.querySelector(
            'meta[name="user-authenticated"]'
        );
        var isAuthenticated = authCheck ? authCheck.content === "true" : false;

        if (!isAuthenticated) {
            isAuthenticated = window.userAuth || false;
        }

        if (!isAuthenticated) {
            showToast("Silakan login terlebih dahulu");
            setTimeout(function () {
                window.location.href = "/login";
            }, 2000);
            return;
        }

        if (qty === 0) {
            showToast("Pilih jumlah terlebih dahulu");
            return;
        }

        var originalClass = cartIcon.className;
        cartIcon.className = "bi bi-arrow-repeat cart-icon";
        cartIcon.style.animation = "spin 1s linear infinite";

        var csrfToken = document.querySelector('meta[name="csrf-token"]');
        var token = csrfToken ? csrfToken.content : "";

        $.ajax({
            url: "/cart/add",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": token,
            },
            data: {
                menu_id: menuId,
                qty: qty,
            },
            success: function (data) {
                if (data.success) {
                    showToast("Berhasil ditambahkan ke keranjang!");
                    countSpan.textContent = "0";
                    cartIcon.style.color = "";
                    cartIcon.style.transform = "";

                    updateNavbarCart(data);

                    $(".cart-badge, .mobile-cart-badge").addClass("updated");
                    setTimeout(function () {
                        $(".cart-badge, .mobile-cart-badge").removeClass(
                            "updated"
                        );
                    }, 600);
                } else {
                    showToast(data.message || "Gagal menambahkan ke keranjang");
                }
            },
            error: function () {
                showToast("Terjadi kesalahan!");
            },
            complete: function () {
                cartIcon.className = originalClass;
                cartIcon.style.animation = "";
            },
        });
    }

    function initializeFilter() {
        $(".filter-item").on("click", function () {
            $(".filter-item").removeClass("active");
            $(this).addClass("active");

            var kategoriId = $(this).data("kategori");
            filterMenuItems(kategoriId);
            $("#searchInput").val("");
        });
    }

    function filterMenuItems(kategoriId) {
        var visibleCount = 0;

        $(".menu-item").each(function () {
            var itemKategori = $(this).data("kategori");

            if (
                kategoriId === "" ||
                kategoriId === undefined ||
                itemKategori == kategoriId
            ) {
                $(this).removeClass("hidden").show();
                visibleCount++;
            } else {
                $(this).addClass("hidden").hide();
            }
        });

        toggleEmptyState(visibleCount === 0);
    }

    function initializeSearch() {
        var searchTimeout;

        $("#searchInput").on("input", function () {
            clearTimeout(searchTimeout);
            var query = $(this).val().trim().toLowerCase();

            searchTimeout = setTimeout(function () {
                searchMenuItems(query);
            }, 300);
        });

        $("#searchInput").on("keypress", function (e) {
            if (e.which === 13) {
                var query = $(this).val().trim().toLowerCase();
                searchMenuItems(query);
            }
        });
    }

    function searchMenuItems(query) {
        var visibleCount = 0;

        if (query.length === 0) {
            $(".menu-item").removeClass("hidden").show();
            $(".filter-item").removeClass("active");
            $('.filter-item[data-kategori=""]').addClass("active");
            visibleCount = $(".menu-item").length;
        } else {
            $(".filter-item").removeClass("active");
            $('.filter-item[data-kategori=""]').addClass("active");

            $(".menu-item").each(function () {
                var itemName = $(this).data("name") || "";
                var itemCategory = $(this)
                    .find(".card-text.text-muted")
                    .text()
                    .toLowerCase();

                if (itemName.includes(query) || itemCategory.includes(query)) {
                    $(this).removeClass("hidden").show();
                    visibleCount++;
                } else {
                    $(this).addClass("hidden").hide();
                }
            });
        }

        toggleEmptyState(visibleCount === 0);
    }

    function initializeCartPage() {
        if ($(".cart-item").length > 0 || $("#cartSubtotal").length > 0) {
            console.log("Cart page initialized");

            $(".update-qty")
                .off("click")
                .on("click", function (e) {
                    e.preventDefault();

                    var itemId = $(this).data("item");
                    var action = $(this).data("action");
                    var qtyInput = $(`.qty-input[data-item="${itemId}"]`);
                    var currentQty = parseInt(qtyInput.val()) || 0;
                    var newQty = currentQty;

                    if (action === "increase" && currentQty < 99) {
                        newQty = currentQty + 1;
                    } else if (action === "decrease" && currentQty > 0) {
                        newQty = currentQty - 1;
                    }

                    if (newQty !== currentQty) {
                        updateCartItem(itemId, newQty);
                    }
                });

            $(".qty-input")
                .off("change")
                .on("change", function () {
                    var itemId = $(this).data("item");
                    var newQty = parseInt($(this).val()) || 0;

                    if (newQty < 0) newQty = 0;
                    if (newQty > 99) newQty = 99;

                    $(this).val(newQty);
                    updateCartItem(itemId, newQty);
                });

            $(".remove-item")
                .off("click")
                .on("click", function (e) {
                    e.preventDefault();

                    var itemId = $(this).data("item");
                    var itemName = $(this)
                        .closest(".cart-item")
                        .find("h6")
                        .text();

                    if (confirm(`Hapus ${itemName} dari keranjang?`)) {
                        removeCartItem(itemId);
                    }
                });

            $("#clearCartBtn")
                .off("click")
                .on("click", function (e) {
                    e.preventDefault();

                    if (confirm("Yakin ingin mengosongkan keranjang?")) {
                        clearCart();
                    }
                });
        }
    }

    function updateCartItem(itemId, qty) {
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var cartItem = $(`.cart-item[data-item="${itemId}"]`);

        cartItem.addClass("loading");

        $.ajax({
            url: "/cart/update",
            method: "PUT",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                menu_id: itemId,
                qty: qty,
            },
            success: function (response) {
                if (response.success) {
                    if (qty === 0) {
                        cartItem.fadeOut(300, function () {
                            $(this).remove();
                            checkEmptyCart();
                        });
                    } else {
                        $(`.qty-input[data-item="${itemId}"]`).val(qty);
                    }

                    updateCartTotals(response);
                    showCartToast(response.message);
                } else {
                    showCartToast(response.message, "error");
                }
            },
            error: function (xhr) {
                var message =
                    xhr.responseJSON?.message || "Gagal mengupdate keranjang";
                showCartToast(message, "error");
            },
            complete: function () {
                cartItem.removeClass("loading");
            },
        });
    }

    function removeCartItem(itemId) {
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var cartItem = $(`.cart-item[data-item="${itemId}"]`);

        cartItem.addClass("loading");

        $.ajax({
            url: "/cart/remove",
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: {
                menu_id: itemId,
            },
            success: function (response) {
                if (response.success) {
                    cartItem.fadeOut(300, function () {
                        $(this).remove();
                        checkEmptyCart();
                    });

                    updateCartTotals(response);
                    showCartToast(response.message);
                } else {
                    showCartToast(response.message, "error");
                }
            },
            error: function (xhr) {
                var message =
                    xhr.responseJSON?.message || "Gagal menghapus item";
                showCartToast(message, "error");
            },
            complete: function () {
                cartItem.removeClass("loading");
            },
        });
    }

    function clearCart() {
        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        $("#clearCartBtn")
            .prop("disabled", true)
            .html('<i class="bi bi-arrow-repeat"></i> Mengosongkan...');

        $.ajax({
            url: "/cart/clear",
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (response) {
                if (response.success) {
                    showCartToast(response.message);
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else {
                    showCartToast(response.message, "error");
                }
            },
            error: function (xhr) {
                var message =
                    xhr.responseJSON?.message || "Gagal mengosongkan keranjang";
                showCartToast(message, "error");
            },
            complete: function () {
                $("#clearCartBtn")
                    .prop("disabled", false)
                    .html('<i class="bi bi-trash"></i> Kosongkan Keranjang');
            },
        });
    }

    function updateCartTotals(response) {
        if (response.cart_total !== undefined) {
            $("#cartSubtotal").text("Rp " + formatRupiah(response.cart_total));
            $("#cartTotal").text("Rp " + formatRupiah(response.cart_total));
        }

        if (response.cart_count !== undefined) {
            $("#cartItemCount").text(response.cart_count);
            $(".cart-badge").text(response.cart_count);
        }
    }

    function checkEmptyCart() {
        if ($(".cart-item").length === 0) {
            setTimeout(function () {
                window.location.reload();
            }, 500);
        }
    }

    function toggleEmptyState(show) {
        if (show) {
            $("#emptyState").show();
        } else {
            $("#emptyState").hide();
        }
    }

    function updateCartBadge() {
        $.get("/cart/summary")
            .done(function (data) {
                if (data.success) {
                    $(".cart-badge").text(data.cart_count);
                    $(".mobile-cart-badge").text(data.cart_count);

                    updateNavbarCart(data);
                }
            })
            .fail(function () {
                console.log("Failed to update cart badge");
            });
    }

    function updateNavbarCart(cartData) {
        if (!cartData || !cartData.success) return;

        $(".cart-badge").text(cartData.cart_count);
        $(".mobile-cart-badge").text(cartData.cart_count);

        updateDesktopCartDropdown(cartData);

        updateMobileCartDropdown(cartData);

        console.log("Navbar cart updated:", cartData.cart_count);
    }

    function updateDesktopCartDropdown(cartData) {
        var cartContent = $(".cart-dropdown .cart-content");

        if (cartData.cart_count === 0) {
            cartContent.html(`
            <div class="empty-cart">
                <i class="bi bi-cart-x"></i>
                <p>Keranjang belanja kosong</p>
                <a href="/menu" class="btn-cart-view">Mulai Belanja</a>
            </div>
        `);
        } else {
            updateCartDropdownContent(cartContent, cartData);
        }

        $(".cart-dropdown .cart-header .badge").text(
            cartData.cart_count + " item"
        );
    }

    function updateMobileCartDropdown(cartData) {
        var mobileCartList = $(".mobile-cart-dropdown");

        if (cartData.cart_count === 0) {
            $(".mobile-cart-total").text("Kosong");

            var emptyHtml = `
            <li>
                <div class="cart-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Keranjang Belanja</span>
                        <span class="badge bg-danger">0 item</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="empty-cart">
                    <i class="bi bi-cart-x"></i>
                    <p>Keranjang belanja kosong</p>
                    <a href="/menu" class="btn-cart-view">Mulai Belanja</a>
                </div>
            </li>
        `;
            mobileCartList.html(emptyHtml);
        } else {
            $(".mobile-cart-total").text(
                "Rp " + formatRupiah(cartData.cart_total)
            );

            updateMobileCartDropdownContent(mobileCartList, cartData);
        }
    }

    function updateCartDropdownContent(container, cartData) {
        $.get("/cart/summary")
            .done(function (response) {
                if (response.success && response.cart_preview) {
                    var itemsHtml = "";

                    response.cart_preview.forEach(function (item) {
                        var imgSrc = item.gambar
                            ? "/gambar-menu/" + item.gambar
                            : "/admin/img/nophoto.jpg";

                        itemsHtml += `
                        <div class="cart-item">
                            <img src="${imgSrc}" alt="${
                            item.nama_item
                        }" class="cart-item-img">
                            <div class="cart-item-info">
                                <div class="cart-item-name">${
                                    item.nama_item
                                }</div>
                                <div class="cart-item-price">Rp ${formatRupiah(
                                    item.harga
                                )}</div>
                                <div class="cart-item-quantity">Qty: ${
                                    item.qty
                                }</div>
                            </div>
                        </div>
                    `;
                    });

                    itemsHtml += `
                    <div class="cart-total">
                        <div class="cart-total-price">
                            Total: Rp ${formatRupiah(response.cart_total)}
                        </div>
                        <a href="/cart" class="btn-cart-view">Lihat Keranjang</a>
                    </div>
                `;

                    container.html(itemsHtml);
                }
            })
            .fail(function () {
                console.error("Failed to update cart dropdown content");
            });
    }

    function updateMobileCartDropdownContent(container, cartData) {
        $.get("/cart/summary")
            .done(function (response) {
                if (response.success && response.cart_preview) {
                    var mobileHtml = `
                    <li>
                        <div class="cart-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Keranjang Belanja</span>
                                <span class="badge bg-danger">${response.cart_count} item</span>
                            </div>
                        </div>
                    </li>
                `;

                    response.cart_preview.forEach(function (item) {
                        var imgSrc = item.gambar
                            ? "/gambar-menu/" + item.gambar
                            : "/admin/img/nophoto.jpg";

                        mobileHtml += `
                        <li>
                            <div class="cart-item">
                                <img src="${imgSrc}" alt="${
                            item.nama_item
                        }" class="cart-item-img">
                                <div class="cart-item-info">
                                    <div class="cart-item-name">${
                                        item.nama_item
                                    }</div>
                                    <div class="cart-item-price">Rp ${formatRupiah(
                                        item.harga
                                    )}</div>
                                    <div class="cart-item-quantity">Qty: ${
                                        item.qty
                                    }</div>
                                </div>
                            </div>
                        </li>
                    `;
                    });

                    mobileHtml += `
                    <li>
                        <div class="cart-total">
                            <div class="cart-total-price">
                                Total: Rp ${formatRupiah(response.cart_total)}
                            </div>
                            <a href="/cart" class="btn-cart-view">Lihat Keranjang</a>
                        </div>
                    </li>
                `;

                    container.html(mobileHtml);
                }
            })
            .fail(function () {
                console.error("Failed to update mobile cart dropdown");
            });
    }

    $(document).ready(function () {
        $(".cart-btn").on("click", function (e) {
            e.preventDefault();
            $(".cart-dropdown").toggleClass("show");
        });

        $(document).on("click", function (e) {
            if (!$(e.target).closest(".header-cart").length) {
                $(".cart-dropdown").removeClass("show");
            }
        });

        $(".cart-dropdown").on("click", function (e) {
            e.stopPropagation();
        });

        console.log("Navbar cart functionality loaded");
    });

    function showToast(message) {
        var toastElement = document.getElementById("cartToast");
        var toastMessage = document.getElementById("toastMessage");

        if (toastElement && toastMessage) {
            toastMessage.textContent = message;

            if (typeof bootstrap !== "undefined") {
                var toast = new bootstrap.Toast(toastElement);
                toast.show();
            } else {
                toastElement.style.display = "block";
                setTimeout(function () {
                    toastElement.style.display = "none";
                }, 3000);
            }
        } else {
            alert(message);
        }
    }

    function showCartToast(message, type = "success") {
        var toastElement = $("#cartToast");
        var toastMessage = $("#toastMessage");
        var toastIcon = toastElement.find(".toast-header i");

        toastMessage.text(message);

        if (type === "error") {
            toastIcon
                .removeClass("bi-cart text-primary")
                .addClass("bi-exclamation-triangle text-danger");
        } else {
            toastIcon
                .removeClass("bi-exclamation-triangle text-danger")
                .addClass("bi-cart text-primary");
        }

        if (typeof bootstrap !== "undefined") {
            var toast = new bootstrap.Toast(toastElement[0]);
            toast.show();
        } else {
            toastElement.fadeIn().delay(3000).fadeOut();
        }
    }

    function formatRupiah(number) {
        return new Intl.NumberFormat("id-ID").format(number);
    }

    window.resetAll = function () {
        $("#searchInput").val("");
        $(".filter-item").removeClass("active");
        $('.filter-item[data-kategori=""]').addClass("active");
        $(".menu-item").removeClass("hidden").show();
        toggleEmptyState(false);
    };

    var styles = `
<style>
@keyframes spin { 
    from { transform: rotate(0deg); } 
    to { transform: rotate(360deg); } 
}

.cart-item.loading {
    opacity: 0.6;
    pointer-events: none;
}

.cart-item.loading::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}

.cart-item {
    position: relative;
    transition: opacity 0.3s ease;
}

.qty-input {
    max-width: 70px;
}

.update-qty {
    min-width: 35px;
}

@media (max-width: 768px) {
    .cart-item .row > div {
        margin-bottom: 0.5rem;
    }
    
    .cart-item .col-md-1,
    .cart-item .col-md-2,
    .cart-item .col-md-3,
    .cart-item .col-md-4 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    .cart-item .input-group {
        max-width: 150px;
    }
}
</style>
`;

    $("head").append(styles);

    console.log("All functionality initialized successfully");
})();
