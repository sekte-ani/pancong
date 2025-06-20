<li class="sidebar-title">Menu</li>

<li class="sidebar-item {{ Route::currentRouteName() == 'admin.index' ? 'active' : '' }}">
    <a href="{{ route('admin.index') }}" class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Dashboard</span>
    </a>
</li>

<li class="sidebar-item {{ 
    in_array(Route::currentRouteName(), [
        'admin.category', 'admin.createCategory', 'admin.editCategory'
    ]) ? 'active' : '' 
}}">
    <a href="{{ route('admin.category') }}" class='sidebar-link'>
        <i class="bi bi-collection-fill"></i>
        <span>Kategori</span>
    </a>
</li>

<li class="sidebar-item {{ 
    in_array(Route::currentRouteName(), [
        'admin.menu', 'admin.createMenu', 'admin.editMenu', 'admin.showMenu'
    ]) ? 'active' : '' 
}}">
    <a href="{{ route('admin.menu') }}" class='sidebar-link'>
        <i class="bi bi-basket-fill"></i>
        <span>Menu</span>
    </a>
</li>

<li class="sidebar-item {{ 
    in_array(Route::currentRouteName(), [
        'admin.order', 'admin.showOrder'
    ]) ? 'active' : '' 
}}">
    <a href="{{ route('admin.order') }}" class='sidebar-link'>
        <i class="bi bi-receipt"></i>
        <span>Pesanan</span>
    </a>
</li>

<li class="sidebar-item {{ 
    in_array(Route::currentRouteName(), [
        'admin.gallery', 'admin.createGallery', 'admin.editGallery'
    ]) ? 'active' : '' 
}}">
    <a href="{{ route('admin.gallery') }}" class='sidebar-link'>
        <i class="bi bi-image-fill"></i>
        <span>Gallery</span>
    </a>
</li>

<li class="sidebar-title">Settings</li>

<li class="sidebar-item">
    <a href="{{ url('/logout') }}" class='sidebar-link text-danger' onclick="return confirm('Yakin ingin logout?')">
        <i class="bi bi-box-arrow-right"></i>
        <span>Logout</span>
    </a>
</li>