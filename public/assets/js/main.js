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
            console.warn("Mobile nav toggle button not found");
            return false;
        }

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

        document.querySelectorAll("#navmenu a").forEach((navmenu) => {
            navmenu.addEventListener("click", () => {
                if (document.querySelector(".mobile-nav-active")) {
                    mobileNavToogle();
                }
            });
        });

        return true;
    }

    initMobileNavigation();

    function initMobileDropdowns() {
        console.log("Initializing mobile dropdowns");

        document
            .querySelectorAll(".navmenu .toggle-dropdown")
            .forEach((element) => {
                element.removeEventListener("click", handleDropdownClick);
            });

        document
            .querySelectorAll(".navmenu .toggle-dropdown")
            .forEach((element) => {
                element.addEventListener("click", handleDropdownClick);
            });

        console.log(
            "Found dropdown toggles:",
            document.querySelectorAll(".navmenu .toggle-dropdown").length
        );
    }

    function handleDropdownClick(e) {
        e.preventDefault();
        e.stopPropagation();

        console.log("Dropdown toggle clicked!");

        const dropdownItem = this.parentNode;
        const dropdownMenu = this.parentNode.nextElementSibling;

        if (dropdownItem && dropdownMenu) {
            dropdownItem.classList.toggle("active");
            dropdownMenu.classList.toggle("dropdown-active");

            console.log("Dropdown toggled:", {
                hasActive: dropdownItem.classList.contains("active"),
                hasDropdownActive:
                    dropdownMenu.classList.contains("dropdown-active"),
            });
        } else {
            console.warn("Dropdown elements not found:", {
                dropdownItem,
                dropdownMenu,
            });
        }
    }

    initMobileDropdowns();

    setTimeout(initMobileDropdowns, 1000);

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
        initializeAllFunctionality();
    });

    function initializeAllFunctionality() {
        if (window.location.pathname.includes("/menu")) {
            setTimeout(function () {
                initMobileNavigation();
            }, 200);
        }

        initializeCartFunctionality();
        initializeMenuFunctionality();
        initializeCartPageFunctionality();
        initializeCustomMenuFunctionality();
        initializeNavbarCartFunctionality();
        initializeCheckoutFunctionality();
        initializeOrderTracking();
        initializeMyOrdersFunctionality();

        updateCartBadge();
    }

    function initializeCartFunctionality() {
        $(document).off("click.cart", ".cart-icon");
        $(document).on("click.cart", ".cart-icon", function (e) {
            e.preventDefault();

            if (!isUserLoggedIn()) {
                if (typeof window.loginUrl !== "undefined" && window.loginUrl) {
                    window.location.href = window.loginUrl;
                } else {
                    window.location.href = "/login";
                }
                return;
            }

            const menuId = $(this).data("menu-id");
            const qtyElement = $(`.count[data-menu-id="${menuId}"]`);
            const qty = parseInt(qtyElement.text()) || 0;

            if (qty <= 0) {
                showToast("Pilih jumlah item terlebih dahulu!");
                return;
            }

            addToCart(menuId, qty, $(this));
        });
    }

    function isUserLoggedIn() {
        if (typeof window.userAuth !== "undefined") {
            return window.userAuth === "true" || window.userAuth === true;
        }

        const authMeta = document.querySelector('meta[name="user-auth"]');
        if (authMeta) {
            return authMeta.content === "true";
        }

        const bodyAuth = document.body.getAttribute("data-auth");
        if (bodyAuth) {
            return bodyAuth === "true";
        }

        return true;
    }

    function addToCart(menuId, qty, cartIcon) {
        console.log("Adding to cart:", menuId, qty);

        var originalClass = cartIcon.attr("class");

        cartIcon.removeClass().addClass("bi bi-hourglass-split");

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

                    $(`.count[data-menu-id="${menuId}"]`).text("0");

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
                if (xhr.status === 401 || xhr.status === 403) {
                    showToast("Silakan login terlebih dahulu!");
                    setTimeout(() => {
                        window.location.href = "/login";
                    }, 1500);
                } else {
                    showToast("Terjadi kesalahan!");
                }
            },
            complete: function () {
                cartIcon.attr("class", originalClass);
            },
        });
    }

    function initializeMenuFunctionality() {
        if ($("#menu-starters").length > 0 || $("#menu-breakfast").length > 0) {
            initializeMenuFilters();
            initializeMenuSearch();
            initializeQuantitySelectors();
        }
    }

    function initializeQuantitySelectors() {
        $(document).off("click.quantity", ".btn-plus, .btn-minus");

        $(document).on("click.quantity", ".btn-plus", function (e) {
            e.preventDefault();
            e.stopPropagation();

            console.log("Plus button clicked (CORRECTED)");

            const menuId = $(this).data("menu-id");
            var quantitySpan = $(`.count[data-menu-id="${menuId}"]`);
            var currentQty = parseInt(quantitySpan.text()) || 0;

            if (currentQty < 99) {
                quantitySpan.text(currentQty + 1);
                console.log("Quantity increased to:", currentQty + 1);
            }
        });

        $(document).on("click.quantity", ".btn-minus", function (e) {
            e.preventDefault();
            e.stopPropagation();

            console.log("Minus button clicked (CORRECTED)");

            const menuId = $(this).data("menu-id");
            var quantitySpan = $(`.count[data-menu-id="${menuId}"]`);
            var currentQty = parseInt(quantitySpan.text()) || 0;

            if (currentQty > 0) {
                quantitySpan.text(currentQty - 1);
                console.log("Quantity decreased to:", currentQty - 1);
            }
        });

        console.log(
            "Quantity selectors initialized successfully with CORRECT class names"
        );
    }

    function initializeMenuFilters() {
        $(document).off("click.filter", ".filter-item");
        $(document).on("click.filter", ".filter-item", function () {
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

        $(document).off("input.search", "#searchInput");
        $(document).on("input.search", "#searchInput", function () {
            clearTimeout(searchTimeout);
            var query = $(this).val().trim().toLowerCase();

            searchTimeout = setTimeout(function () {
                searchMenuItems(query);
            }, 300);
        });

        $(document).off("keypress.search", "#searchInput");
        $(document).on("keypress.search", "#searchInput", function (e) {
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

    function toggleEmptyState(show) {
        if (show) {
            $("#emptyState").show();
        } else {
            $("#emptyState").hide();
        }
    }

    $(document).ready(function () {
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
                } else {
                    loadCustomMenuDataAjax();
                }
            }

            function loadCustomMenuDataAjax() {
                $.ajax({
                    url: "/api/custom-menu/data",
                    type: "GET",
                    success: function (response) {
                        console.log("AJAX data loaded successfully:", response);
                        renderBaseMenus(response.baseMenus || []);
                        renderAddons(response.addons || []);
                    },
                    error: function (xhr) {
                        console.error("Failed to load custom menu data:", xhr);
                        $("#baseMenuContainer").html(
                            '<div class="col-12"><p class="text-danger text-center">Gagal memuat data. Refresh halaman.</p></div>'
                        );
                        $("#addonsContainer").html(
                            '<div class="col-12"><p class="text-danger text-center">Gagal memuat data. Refresh halaman.</p></div>'
                        );
                    },
                });
            }

            function renderBaseMenus(baseMenus) {
                const container = $("#baseMenuContainer");
                container.empty();

                console.log("Rendering base menus:", baseMenus);

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
                                : "/assets/img/menu/menu-item-2.png"
                        }" 
                             class="card-img-top" alt="${menu.nama_item}">
                        <div class="card-body p-3">
                            <h6 class="card-title mb-1">${menu.nama_item}</h6>
                            <p class="card-text text-muted small mb-1">${
                                menu.category.nama_kategori
                            }</p>
                            <p class="card-text fw-bold small mb-0">Rp ${formatNumber(
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
                        $(".base-menu-card").removeClass(
                            "border-primary bg-light"
                        );
                        $(this).addClass("border-primary bg-light");

                        const menuId = $(this).data("menu-id");
                        selectedBaseMenu = baseMenus.find(
                            (menu) => menu.id_item == menuId
                        );

                        if (selectedBaseMenu) {
                            selectedBaseMenu.harga =
                                parseFloat(selectedBaseMenu.harga) || 0;
                        }

                        console.log("Selected base menu:", selectedBaseMenu);
                        updateSummary();
                    });
            }

            function renderAddons(addons) {
                const container = $("#addonsContainer");
                container.empty();

                console.log("Rendering addons:", addons);

                if (!addons || addons.length === 0) {
                    container.html(
                        '<div class="col-12"><p class="text-muted text-center">Belum ada add-ons tersedia</p></div>'
                    );
                    return;
                }

                addons.forEach((addon) => {
                    const addonCard = `
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <div class="card addon-card" data-addon-id="${addon.id}">
                        <div class="card-body p-3">
                            <h6 class="card-title mb-1">${addon.nama_addon}</h6>
                            <p class="card-text fw-bold small mb-2">Rp ${formatNumber(
                                addon.harga_addon
                            )}</p>
                            ${
                                addon.deskripsi
                                    ? `<p class="card-text text-muted small mb-2">${addon.deskripsi}</p>`
                                    : ""
                            }
                            <div class="addon-controls">
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary addon-minus" type="button">-</button>
                                    <input type="number" class="form-control text-center addon-qty" value="0" min="0" max="5" readonly>
                                    <button class="btn btn-outline-secondary addon-plus" type="button">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `;
                    container.append(addonCard);
                });

                $(".addon-plus")
                    .off("click")
                    .on("click", function () {
                        const card = $(this).closest(".addon-card");
                        const qtyInput = card.find(".addon-qty");
                        const currentQty = parseInt(qtyInput.val());
                        const addonId = card.data("addon-id");

                        if (
                            selectedAddons.length >= maxAddons &&
                            currentQty === 0
                        ) {
                            showToast(
                                `Maksimal ${maxAddons} add-ons`,
                                "warning"
                            );
                            return;
                        }

                        if (currentQty < 5) {
                            qtyInput.val(currentQty + 1);
                            updateSelectedAddons(
                                addonId,
                                currentQty + 1,
                                addons
                            );
                        }
                    });

                $(".addon-minus")
                    .off("click")
                    .on("click", function () {
                        const card = $(this).closest(".addon-card");
                        const qtyInput = card.find(".addon-qty");
                        const currentQty = parseInt(qtyInput.val());
                        const addonId = card.data("addon-id");

                        if (currentQty > 0) {
                            qtyInput.val(currentQty - 1);
                            updateSelectedAddons(
                                addonId,
                                currentQty - 1,
                                addons
                            );
                        }
                    });
            }

            function updateSelectedAddons(addonId, qty, addons) {
                const addon = addons.find((a) => a.id == addonId);
                const existingIndex = selectedAddons.findIndex(
                    (a) => a.id == addonId
                );

                if (qty === 0) {
                    if (existingIndex > -1) {
                        selectedAddons.splice(existingIndex, 1);
                    }
                } else {
                    if (existingIndex > -1) {
                        selectedAddons[existingIndex].qty = qty;
                    } else {
                        selectedAddons.push({
                            id: addon.id,
                            nama_addon: addon.nama_addon,
                            harga_addon: parseFloat(addon.harga_addon) || 0,
                            qty: qty,
                        });
                    }
                }

                $("#selectedAddonsCount").text(selectedAddons.length);
                updateSummary();
            }

            function updateSummary() {
                const summaryContent = $("#summaryContent");

                if (!selectedBaseMenu) {
                    summaryContent.html(
                        '<p class="text-muted">Pilih base menu terlebih dahulu</p>'
                    );
                    $("#totalPrice").text("Rp 0");
                    $("#addToCartBtn").prop("disabled", true);
                    return;
                }

                const basePrice = parseFloat(selectedBaseMenu.harga) || 0;

                let html = `<p><strong>Base:</strong> ${
                    selectedBaseMenu.nama_item
                } - Rp ${formatNumber(basePrice)}</p>`;

                let addonsPrice = 0;
                if (selectedAddons.length > 0) {
                    html +=
                        '<p><strong>Add-ons:</strong></p><ul class="list-unstyled ms-3">';
                    selectedAddons.forEach((addon) => {
                        const addonPrice = parseFloat(addon.harga_addon) || 0;
                        const addonQty = parseInt(addon.qty) || 0;
                        const subtotal = addonPrice * addonQty;
                        addonsPrice += subtotal;
                        html += `<li>• ${
                            addon.nama_addon
                        } (${addonQty}x) - Rp ${formatNumber(subtotal)}</li>`;
                    });
                    html += "</ul>";
                }

                const qty = parseInt($("#customQty").val()) || 1;

                const totalPerItem = basePrice + addonsPrice;
                const grandTotal = totalPerItem * qty;

                console.log("Calculation debug:", {
                    basePrice: basePrice,
                    addonsPrice: addonsPrice,
                    totalPerItem: totalPerItem,
                    qty: qty,
                    grandTotal: grandTotal,
                });

                summaryContent.html(html);
                $("#totalPrice").text("Rp " + formatNumber(grandTotal));
                $("#addToCartBtn").prop("disabled", false);
            }

            $("#qtyMinus")
                .off("click")
                .on("click", function () {
                    const qtyInput = $("#customQty");
                    const currentQty = parseInt(qtyInput.val());
                    if (currentQty > 1) {
                        qtyInput.val(currentQty - 1);
                        updateSummary();
                    }
                });

            $("#qtyPlus")
                .off("click")
                .on("click", function () {
                    const qtyInput = $("#customQty");
                    const currentQty = parseInt(qtyInput.val());
                    if (currentQty < 99) {
                        qtyInput.val(currentQty + 1);
                        updateSummary();
                    }
                });

            $("#customQty").on("input", function () {
                updateSummary();
            });

            $("#customMenuForm")
                .off("submit")
                .on("submit", function (e) {
                    e.preventDefault();

                    if (!selectedBaseMenu) {
                        showToast("Pilih base menu terlebih dahulu", "warning");
                        return;
                    }

                    if (!window.userAuth || window.userAuth === "false") {
                        window.location.href = window.loginUrl;
                        return;
                    }

                    const formData = {
                        base_menu_id: selectedBaseMenu.id_item,
                        selected_addons: selectedAddons,
                        qty: parseInt($("#customQty").val()),
                    };

                    $.ajax({
                        url: "/custom-menu/add-to-cart",
                        type: "POST",
                        data: formData,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: function (response) {
                            console.log("Add to cart success:", response);
                            showToast(response.message, "success");
                            resetCustomForm();

                            if (typeof updateCartBadge === "function") {
                                updateCartBadge();
                            } else {
                                console.log(
                                    "updateCartBadge not available, reloading..."
                                );
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            }
                        },
                        error: function (xhr) {
                            console.error("Add to cart error:", xhr);
                            const response = xhr.responseJSON;
                            showToast(
                                response?.message || "Terjadi kesalahan",
                                "error"
                            );
                        },
                    });
                });

            function resetCustomForm() {
                selectedBaseMenu = null;
                selectedAddons = [];
                $(".base-menu-card").removeClass("border-primary bg-light");
                $(".addon-qty").val(0);
                $("#customQty").val(1);
                $("#selectedAddonsCount").text("0");
                updateSummary();
            }

            function formatNumber(num) {
                return new Intl.NumberFormat("id-ID", {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0,
                }).format(num);
            }

            function showToast(message, type = "success") {
                $("#toastMessage").text(message);
                const toast = new bootstrap.Toast($("#cartToast")[0]);
                toast.show();
            }
        }
    });

    function initializeCartPageFunctionality() {
        if ($(".cart-item").length > 0 || $("#cartSubtotal").length > 0) {
            console.log(
                "Cart page detected - Initializing cart page functionality"
            );

            $(document).off("click.cartpage", ".qty-btn");
            $(document).on("click.cartpage", ".qty-btn", function (e) {
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

            $(document).off("change.cartpage", ".qty-input");
            $(document).on("change.cartpage", ".qty-input", function () {
                var itemId = $(this).data("item");
                var itemType = $(this).data("type");
                var newQty = parseInt($(this).val()) || 0;

                if (newQty < 0) newQty = 0;
                if (newQty > 99) newQty = 99;

                $(this).val(newQty);
                updateCartItem(itemId, newQty, itemType);
            });

            $(document).off("click.cartpage", ".remove-item");
            $(document).on("click.cartpage", ".remove-item", function (e) {
                e.preventDefault();

                var itemId = $(this).data("item");
                var itemType = $(this).data("type");
                var itemName = $(this).closest(".cart-item").find("h6").text();

                if (confirm(`Hapus ${itemName} dari keranjang?`)) {
                    removeCartItem(itemId, itemType);
                }
            });

            $(document).off("click.cartpage", "#clearCartBtn");
            $(document).on("click.cartpage", "#clearCartBtn", function (e) {
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

    function initializeNavbarCartFunctionality() {
        $(document).off("click.navbar", ".cart-btn");
        $(document).on("click.navbar", ".cart-btn", function (e) {
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

    function initializeCheckoutFunctionality() {
        console.log("Checkout functionality initialized");
    }

    function initializeOrderTracking() {
        console.log("Order tracking initialized");
    }

    function initializeMyOrdersFunctionality() {
        console.log("My orders functionality initialized");
    }

    function formatRupiah(angka) {
        return parseInt(angka).toLocaleString("id-ID");
    }

    function showToast(message) {
        $(".toast-notification").remove();

        var toast = $(`
            <div class="toast-notification" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: #333;
                color: white;
                padding: 15px 20px;
                border-radius: 5px;
                z-index: 10000;
                opacity: 0;
                transform: translateX(100%);
                transition: all 0.3s ease;
            ">
                ${message}
            </div>
        `);

        $("body").append(toast);

        setTimeout(function () {
            toast.css({
                opacity: 1,
                transform: "translateX(0)",
            });
        }, 100);

        setTimeout(function () {
            toast.css({
                opacity: 0,
                transform: "translateX(100%)",
            });

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
