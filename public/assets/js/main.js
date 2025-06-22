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

        if (!selectBody || !selectHeader) return;

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
     * ULTRA ROBUST Mobile nav toggle
     */
    function initMobileNavigation() {
        let mobileNavToggleBtn = document.querySelector(".mobile-nav-toggle");

        if (!mobileNavToggleBtn) {
            return false;
        }

        const newToggle = mobileNavToggleBtn.cloneNode(true);
        mobileNavToggleBtn.parentNode.replaceChild(
            newToggle,
            mobileNavToggleBtn
        );
        mobileNavToggleBtn = newToggle;

        mobileNavToggleBtn.style.zIndex = "99999";
        mobileNavToggleBtn.style.position = "relative";
        mobileNavToggleBtn.style.pointerEvents = "auto";
        mobileNavToggleBtn.style.cursor = "pointer";

        function mobileNavToogle(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            const body = document.querySelector("body");
            if (!body) return;

            const isActive = body.classList.contains("mobile-nav-active");

            if (isActive) {
                body.classList.remove("mobile-nav-active");
                mobileNavToggleBtn.classList.remove("bi-x");
                mobileNavToggleBtn.classList.add("bi-list");
                body.style.overflow = "";
            } else {
                body.classList.add("mobile-nav-active");
                mobileNavToggleBtn.classList.remove("bi-list");
                mobileNavToggleBtn.classList.add("bi-x");
                body.style.overflow = "hidden";
            }
        }

        mobileNavToggleBtn.addEventListener("click", mobileNavToogle);
        mobileNavToggleBtn.addEventListener("touchstart", mobileNavToogle);

        window.mobileNavToogle = mobileNavToogle;

        /**
         * Hide mobile nav on menu link clicks
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
            .forEach((element) => {
                element.addEventListener("click", function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    this.parentNode.classList.toggle("active");
                    this.parentNode.nextElementSibling.classList.toggle(
                        "dropdown-active"
                    );
                });
            });

        return true;
    }

    /**
     * Try multiple times to initialize mobile nav
     */
    function tryInitMobileNav() {
        let attempts = 0;
        const maxAttempts = 10;

        function attempt() {
            attempts++;

            if (initMobileNavigation()) {
                return;
            }

            if (attempts < maxAttempts) {
                setTimeout(attempt, 100);
            } else {
                console.log(
                    "Failed to initialize mobile nav after",
                    maxAttempts,
                    "attempts"
                );
            }
        }

        attempt();
    }

    /**
     * Preloader with null check
     */
    const preloader = document.querySelector("#preloader");
    if (preloader) {
        window.addEventListener("load", () => {
            preloader.remove();
        });
    }

    /**
     * Scroll top button with null check
     */
    let scrollTop = document.querySelector(".scroll-top");

    function toggleScrollTop() {
        if (scrollTop) {
            window.scrollY > 100
                ? scrollTop.classList.add("active")
                : scrollTop.classList.remove("active");
        }
    }

    if (scrollTop) {
        scrollTop.addEventListener("click", (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        });
    }

    document.addEventListener("scroll", toggleScrollTop);
    window.addEventListener("load", toggleScrollTop);

    /**
     * Initialize everything when DOM is ready
     */
    document.addEventListener("DOMContentLoaded", function () {
        tryInitMobileNav();
    });

    window.addEventListener("load", function () {
        setTimeout(tryInitMobileNav, 100);
    });

    /**
     * AOS Init with safety check
     */
    function aosInit() {
        if (typeof AOS !== "undefined") {
            AOS.init({
                duration: 600,
                easing: "ease-in-out",
                once: true,
                mirror: false,
            });
        }
    }
    window.addEventListener("load", aosInit);

    /**
     * GLightbox with safety check
     */
    if (typeof GLightbox !== "undefined") {
        const glightbox = GLightbox({
            selector: ".glightbox",
        });
    }

    /**
     * PureCounter with safety check
     */
    if (typeof PureCounter !== "undefined") {
        new PureCounter();
    }

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
        console.log("jQuery Ready - Initializing all functionality");

        if (window.location.pathname.includes("/menu")) {
            console.log("Menu page detected - Force mobile nav init");
            setTimeout(function () {
                initMobileNav();
            }, 200);
        }

        initializeCartFunctionality();
        initializeMenuFunctionality();
        initializeCartPageFunctionality();
        initializeCustomMenuFunctionality();
        initializeNavbarCartFunctionality();

        updateCartBadge();
    });

    function initializeCartFunctionality() {
        console.log("Initializing cart functionality");

        $(document)
            .off("click", ".add-to-cart-btn")
            .on("click", ".add-to-cart-btn", function (e) {
                e.preventDefault();
                console.log("Add to cart button clicked");

                if (window.userAuth !== "true") {
                    window.location.href = window.loginUrl;
                    return;
                }

                const menuId = $(this).data("menu-id");
                const qtyElement = $(this)
                    .closest(".menu-item")
                    .find(".quantity-display");
                const qty = parseInt(qtyElement.text()) || 1;

                if (qty <= 0) {
                    showToast("Pilih jumlah item terlebih dahulu!");
                    return;
                }

                addToCart(menuId, qty, $(this));
            });
    }

    function addToCart(menuId, qty, cartIcon) {
        console.log("Adding to cart:", menuId, qty);

        var originalClass = cartIcon.attr("class");

        cartIcon.html('<i class="bi bi-hourglass-split"></i>');
        cartIcon.css({
            color: "#ce1212",
            transform: "scale(1.1)",
            animation: "pulse 1s infinite",
        });

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
                console.log("Add to cart success:", data);
                if (data.success) {
                    showToast("Berhasil ditambahkan ke keranjang!");

                    var countSpan = cartIcon
                        .closest(".menu-item")
                        .find(".quantity-display");
                    if (countSpan.length) {
                        countSpan.text("0");
                    }
                    cartIcon.css({
                        color: "",
                        transform: "",
                    });

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
            error: function (xhr) {
                console.error("Add to cart error:", xhr);
                showToast("Terjadi kesalahan!");
            },
            complete: function () {
                cartIcon.attr("class", originalClass);
                cartIcon.css("animation", "");
            },
        });
    }

    function updateCartBadge() {
        console.log("Updating cart badge");
        $.get("/cart/summary")
            .done(function (data) {
                if (data.success) {
                    $(".cart-badge, .mobile-cart-badge").text(data.cart_count);

                    if (data.cart_total > 0) {
                        $(".mobile-cart-total").text(
                            "Rp " + formatRupiah(data.cart_total)
                        );
                    } else {
                        $(".mobile-cart-total").text("Kosong");
                    }

                    updateNavbarCart(data);
                }
            })
            .fail(function () {
                console.log("Failed to update cart badge");
            });
    }

    function updateNavbarCart(cartData) {
        if (!cartData || !cartData.success) return;

        $(".cart-badge, .mobile-cart-badge").text(cartData.cart_count);
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

                        if (item.type === "custom") {
                            imgSrc = "/admin/img/custom-pancong.jpg";
                        }

                        var itemPrice = item.harga || item.total_price || 0;

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
                                    itemPrice
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

                        if (item.type === "custom") {
                            imgSrc = "/admin/img/custom-pancong.jpg";
                        }

                        var itemPrice = item.harga || item.total_price || 0;

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
                                        itemPrice
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

    function initializeCartPageFunctionality() {
        if ($(".cart-item").length > 0 || $("#cartSubtotal").length > 0) {
            console.log(
                "Cart page detected - Initializing cart page functionality"
            );

            $(document)
                .off("click", ".qty-btn")
                .on("click", ".qty-btn", function (e) {
                    e.preventDefault();

                    var itemId = $(this).data("item");
                    var action = $(this).data("action");
                    var itemType = $(this).data("type");
                    var qtyInput = $(`.qty-input[data-item="${itemId}"]`);
                    var currentQty = parseInt(qtyInput.val()) || 0;
                    var newQty = currentQty;

                    if (action === "increase" && currentQty < 99) {
                        newQty = currentQty + 1;
                    } else if (action === "decrease" && currentQty > 0) {
                        newQty = currentQty - 1;
                    }

                    if (newQty !== currentQty) {
                        console.log(
                            "Updating cart item:",
                            itemId,
                            "to qty:",
                            newQty
                        );
                        updateCartItem(itemId, newQty, itemType);
                    }
                });

            $(document)
                .off("change", ".qty-input")
                .on("change", ".qty-input", function () {
                    var itemId = $(this).data("item");
                    var itemType = $(this).data("type");
                    var newQty = parseInt($(this).val()) || 0;

                    if (newQty < 0) newQty = 0;
                    if (newQty > 99) newQty = 99;

                    $(this).val(newQty);
                    updateCartItem(itemId, newQty, itemType);
                });

            $(document)
                .off("click", ".remove-item")
                .on("click", ".remove-item", function (e) {
                    e.preventDefault();

                    var itemId = $(this).data("item");
                    var itemType = $(this).data("type");
                    var itemName = $(this)
                        .closest(".cart-item")
                        .find("h6")
                        .text();

                    if (confirm(`Hapus ${itemName} dari keranjang?`)) {
                        removeCartItem(itemId, itemType);
                    }
                });

            $(document)
                .off("click", "#clearCartBtn")
                .on("click", "#clearCartBtn", function (e) {
                    e.preventDefault();

                    if (confirm("Yakin ingin mengosongkan keranjang?")) {
                        clearCart();
                    }
                });
        }
    }

    function updateCartItem(itemId, qty, itemType = "regular") {
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var cartItem = $(`.cart-item[data-item="${itemId}"]`);

        cartItem.addClass("loading");

        var url =
            itemType === "custom" ? "/custom-menu/update-cart" : "/cart/update";
        var data =
            itemType === "custom"
                ? { item_id: itemId, qty: qty }
                : { menu_id: itemId, qty: qty };

        $.ajax({
            url: url,
            method: "PUT",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: data,
            success: function (response) {
                if (response.success) {
                    if (qty === 0) {
                        cartItem.fadeOut(300, function () {
                            $(this).remove();
                            checkEmptyCart();
                        });
                    } else {
                        $(`.qty-input[data-item="${itemId}"]`).val(qty);
                        var price = parseFloat(
                            cartItem
                                .find(".fw-bold")
                                .first()
                                .text()
                                .replace(/[^\d]/g, "")
                        );
                        var subtotal = price * qty;
                        cartItem
                            .find(".fw-bold")
                            .last()
                            .text("Rp " + formatRupiah(subtotal));
                    }

                    updateCartTotals(response);
                    showCartToast(response.message);
                    updateCartBadge();
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

    function removeCartItem(itemId, itemType = "regular") {
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var cartItem = $(`.cart-item[data-item="${itemId}"]`);

        cartItem.addClass("loading");

        var url =
            itemType === "custom" ? "/custom-menu/update-cart" : "/cart/remove";
        var method = itemType === "custom" ? "PUT" : "DELETE";
        var data =
            itemType === "custom"
                ? { item_id: itemId, qty: 0 }
                : { menu_id: itemId };

        $.ajax({
            url: url,
            method: method,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            data: data,
            success: function (response) {
                if (response.success) {
                    cartItem.fadeOut(300, function () {
                        $(this).remove();
                        checkEmptyCart();
                    });

                    updateCartTotals(response);
                    showCartToast(response.message);
                    updateCartBadge();
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

    function initializeMenuFunctionality() {
        if ($("#menu-starters").length > 0 || $("#menu-breakfast").length > 0) {
            initializeMenuFilters();
            initializeMenuSearch();
            initializeQuantitySelectors();
        }
    }

    function initializeMenuFilters() {
        $(document)
            .off("click", ".filter-item")
            .on("click", ".filter-item", function () {
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

    function initializeMenuSearch() {
        var searchTimeout;

        $(document)
            .off("input", "#searchInput")
            .on("input", "#searchInput", function () {
                clearTimeout(searchTimeout);
                var query = $(this).val().trim().toLowerCase();

                searchTimeout = setTimeout(function () {
                    searchMenuItems(query);
                }, 300);
            });

        $(document)
            .off("keypress", "#searchInput")
            .on("keypress", "#searchInput", function (e) {
                if (e.which === 13) {
                    var query = $(this).val().trim().toLowerCase();
                    searchMenuItems(query);
                }
            });
    }

    function searchMenuItems(query) {
        var visibleCount = 0;

        if (query === "") {
            $(".menu-item").show();
            visibleCount = $(".menu-item").length;
        } else {
            $(".menu-item").each(function () {
                var menuName = $(this).find("h4").text().toLowerCase();
                var ingredients = $(this)
                    .find(".ingredients")
                    .text()
                    .toLowerCase();

                if (menuName.includes(query) || ingredients.includes(query)) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });
        }

        $(".filter-item").removeClass("active");
        $(".filter-item[data-kategori='']").addClass("active");

        toggleEmptyState(visibleCount === 0);
    }

    function initializeQuantitySelectors() {
        $(document)
            .off("click", ".plus-btn")
            .on("click", ".plus-btn", function () {
                var quantitySpan = $(this).siblings(".quantity-display");
                var currentQty = parseInt(quantitySpan.text());
                if (currentQty < 99) {
                    quantitySpan.text(currentQty + 1);
                    updateCartButtonState($(this).closest(".menu-item"));
                }
            });

        $(document)
            .off("click", ".minus-btn")
            .on("click", ".minus-btn", function () {
                var quantitySpan = $(this).siblings(".quantity-display");
                var currentQty = parseInt(quantitySpan.text());
                if (currentQty > 0) {
                    quantitySpan.text(currentQty - 1);
                    updateCartButtonState($(this).closest(".menu-item"));
                }
            });
    }

    function updateCartButtonState(menuItem) {
        var qty = parseInt(menuItem.find(".quantity-display").text());
        var cartBtn = menuItem.find(".add-to-cart-btn");

        if (qty > 0) {
            cartBtn.removeClass("btn-outline-danger").addClass("btn-danger");
            cartBtn.find("i").css("color", "#fff");
        } else {
            cartBtn.removeClass("btn-danger").addClass("btn-outline-danger");
            cartBtn.find("i").css("color", "");
        }
    }

    function toggleEmptyState(show) {
        if (show) {
            $("#emptyState").show();
        } else {
            $("#emptyState").hide();
        }
    }

    function initializeCustomMenuFunctionality() {
        if ($("#menu-breakfast").length > 0) {
            let selectedBaseMenu = null;
            let selectedAddons = [];
            let maxAddons = 5;

            initializeCustomMenu();

            function initializeCustomMenu() {
                if (
                    typeof window.baseMenus !== "undefined" &&
                    typeof window.addons !== "undefined"
                ) {
                    renderBaseMenus(window.baseMenus);
                    renderAddons(window.addons);
                }
            }

            function renderBaseMenus(baseMenus) {
                const container = $("#baseMenuContainer");
                container.empty();

                if (!baseMenus || baseMenus.length === 0) {
                    container.html(
                        '<div class="col-12"><p class="text-muted text-center">Belum ada pancong polos tersedia</p></div>'
                    );
                    return;
                }

                baseMenus.forEach((menu) => {
                    const menuCard = `
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <div class="card base-menu-card" data-menu-id="${
                            menu.id_item
                        }" style="cursor: pointer;">
                            <img src="${
                                menu.gambar
                                    ? "/gambar-menu/" + menu.gambar
                                    : "/admin/img/nophoto.jpg"
                            }" 
                                 class="card-img-top" alt="${
                                     menu.nama_item
                                 }" style="height: 200px; object-fit: cover;">
                            <div class="card-body text-center">
                                <h5 class="card-title">${menu.nama_item}</h5>
                                <p class="card-text text-muted">Rp ${formatRupiah(
                                    menu.harga
                                )}</p>
                            </div>
                        </div>
                    </div>
                `;
                    container.append(menuCard);
                });

                $(".base-menu-card")
                    .off("click")
                    .on("click", function () {
                        $(".base-menu-card").removeClass("selected");
                        $(this).addClass("selected");

                        const menuId = $(this).data("menu-id");
                        selectedBaseMenu = baseMenus.find(
                            (menu) => menu.id_item == menuId
                        );

                        updateCustomMenuPreview();
                        calculateCustomPrice();
                    });
            }

            function renderAddons(addons) {
                const container = $("#addonsContainer");
                container.empty();

                if (!addons || addons.length === 0) {
                    container.html(
                        '<div class="col-12"><p class="text-muted text-center">Belum ada addon tersedia</p></div>'
                    );
                    return;
                }

                addons.forEach((addon) => {
                    const addonCard = `
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <div class="card addon-card" data-addon-id="${
                            addon.id
                        }" style="cursor: pointer;">
                            <div class="card-body text-center">
                                <h6 class="card-title">${addon.nama_addon}</h6>
                                <p class="card-text text-muted">+Rp ${formatRupiah(
                                    addon.harga_addon
                                )}</p>
                                <div class="addon-quantity" style="display: none;">
                                    <button type="button" class="btn btn-sm btn-outline-secondary minus-addon">-</button>
                                    <span class="addon-qty">1</span>
                                    <button type="button" class="btn btn-sm btn-outline-secondary plus-addon">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                    container.append(addonCard);
                });

                $(".addon-card")
                    .off("click")
                    .on("click", function () {
                        const addonId = $(this).data("addon-id");
                        const addon = addons.find((a) => a.id == addonId);

                        if ($(this).hasClass("selected")) {
                            $(this).removeClass("selected");
                            $(this).find(".addon-quantity").hide();
                            selectedAddons = selectedAddons.filter(
                                (a) => a.id != addonId
                            );
                        } else {
                            if (selectedAddons.length < maxAddons) {
                                $(this).addClass("selected");
                                $(this).find(".addon-quantity").show();
                                selectedAddons.push({
                                    id: addon.id,
                                    nama_addon: addon.nama_addon,
                                    harga_addon: addon.harga_addon,
                                    qty: 1,
                                });
                            } else {
                                showToast(
                                    `Maksimal ${maxAddons} addon yang bisa dipilih`
                                );
                            }
                        }

                        updateCustomMenuPreview();
                        calculateCustomPrice();
                    });

                $(document)
                    .off("click", ".plus-addon")
                    .on("click", ".plus-addon", function (e) {
                        e.stopPropagation();
                        const card = $(this).closest(".addon-card");
                        const addonId = card.data("addon-id");
                        const qtySpan = $(this).siblings(".addon-qty");
                        const currentQty = parseInt(qtySpan.text());

                        if (currentQty < 5) {
                            qtySpan.text(currentQty + 1);

                            const addon = selectedAddons.find(
                                (a) => a.id == addonId
                            );
                            if (addon) {
                                addon.qty = currentQty + 1;
                                updateCustomMenuPreview();
                                calculateCustomPrice();
                            }
                        }
                    });

                $(document)
                    .off("click", ".minus-addon")
                    .on("click", ".minus-addon", function (e) {
                        e.stopPropagation();
                        const card = $(this).closest(".addon-card");
                        const addonId = card.data("addon-id");
                        const qtySpan = $(this).siblings(".addon-qty");
                        const currentQty = parseInt(qtySpan.text());

                        if (currentQty > 1) {
                            qtySpan.text(currentQty - 1);

                            const addon = selectedAddons.find(
                                (a) => a.id == addonId
                            );
                            if (addon) {
                                addon.qty = currentQty - 1;
                                updateCustomMenuPreview();
                                calculateCustomPrice();
                            }
                        }
                    });
            }

            function updateCustomMenuPreview() {
                const preview = $("#customMenuPreview");

                if (!selectedBaseMenu) {
                    preview.html(
                        '<p class="text-muted">Pilih pancong polos terlebih dahulu</p>'
                    );
                    return;
                }

                let previewHtml = `
                <div class="selected-base">
                    <h6>Base: ${selectedBaseMenu.nama_item}</h6>
                    <small>Rp ${formatRupiah(selectedBaseMenu.harga)}</small>
                </div>
            `;

                if (selectedAddons.length > 0) {
                    previewHtml +=
                        '<div class="selected-addons mt-2"><h6>Addons:</h6>';
                    selectedAddons.forEach((addon) => {
                        previewHtml += `
                        <div class="addon-item">
                            ${addon.nama_addon} (${
                            addon.qty
                        }x) - Rp ${formatRupiah(addon.harga_addon * addon.qty)}
                        </div>
                    `;
                    });
                    previewHtml += "</div>";
                }

                preview.html(previewHtml);
            }

            function calculateCustomPrice() {
                if (!selectedBaseMenu) return;

                let totalPrice = parseFloat(selectedBaseMenu.harga);
                let addonsPrice = 0;

                selectedAddons.forEach((addon) => {
                    addonsPrice += addon.harga_addon * addon.qty;
                });

                totalPrice += addonsPrice;

                $("#customTotalPrice").text("Rp " + formatRupiah(totalPrice));
                $("#addCustomToCartBtn").prop("disabled", false);
            }

            $(document)
                .off("click", "#addCustomToCartBtn")
                .on("click", "#addCustomToCartBtn", function () {
                    if (!selectedBaseMenu) {
                        showToast("Pilih pancong polos terlebih dahulu!");
                        return;
                    }

                    const qty = parseInt($("#customQty").val()) || 1;

                    $.ajax({
                        url: "/custom-menu/add-to-cart",
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        data: {
                            base_menu_id: selectedBaseMenu.id_item,
                            selected_addons: selectedAddons,
                            qty: qty,
                        },
                        success: function (response) {
                            if (response.success) {
                                showToast(
                                    "Custom pancong berhasil ditambahkan ke keranjang!"
                                );

                                selectedBaseMenu = null;
                                selectedAddons = [];
                                $(".base-menu-card, .addon-card").removeClass(
                                    "selected"
                                );
                                $(".addon-quantity").hide();
                                $(".addon-qty").text("1");
                                $("#customQty").val(1);
                                $("#customMenuPreview").html(
                                    '<p class="text-muted">Pilih pancong polos terlebih dahulu</p>'
                                );
                                $("#customTotalPrice").text("Rp 0");
                                $("#addCustomToCartBtn").prop("disabled", true);

                                updateNavbarCart(response);

                                $(".cart-badge, .mobile-cart-badge").addClass(
                                    "updated"
                                );
                                setTimeout(function () {
                                    $(
                                        ".cart-badge, .mobile-cart-badge"
                                    ).removeClass("updated");
                                }, 600);
                            } else {
                                showToast(
                                    response.message ||
                                        "Gagal menambahkan ke keranjang"
                                );
                            }
                        },
                        error: function () {
                            showToast("Terjadi kesalahan!");
                        },
                    });
                });
        }
    }

    function initializeNavbarCartFunctionality() {
        $(document)
            .off("click", ".cart-btn")
            .on("click", ".cart-btn", function (e) {
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
    }

    function formatRupiah(angka) {
        return parseInt(angka).toLocaleString("id-ID");
    }

    function showToast(message) {
        var toast = $('<div class="toast-notification">' + message + "</div>");
        $("body").append(toast);

        setTimeout(function () {
            toast.addClass("show");
        }, 100);

        setTimeout(function () {
            toast.removeClass("show");
            setTimeout(function () {
                toast.remove();
            }, 300);
        }, 3000);
    }

    function showCartToast(message, type = "success") {
        var toastElement = $("#cartToast");
        var toastMessage = $("#toastMessage");
        var toastIcon = toastElement.find(".toast-header i");

        if (toastMessage.length) {
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
        } else {
            showToast(message);
        }
    }

    window.updateCartBadge = updateCartBadge;
    window.formatRupiah = formatRupiah;
    window.showToast = showToast;
})();
