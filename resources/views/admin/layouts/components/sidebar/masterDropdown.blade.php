{{-- Data Master --}}
{{-- <li class="sidebar-item {{ Request::is('admin/category*') || Request::is('admin/createCategory*') || Request::is('admin/editCategory*') || Request::is('admin/position*') || Request::is('admin/createPosition*') || Request::is('admin/editPosition*') ? 'active' : '' }}">
    <a class="sidebar-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        <i class="bi bi-database-fill-check"></i>
        <span>Data Master</span>
        <i class="bi bi-caret-down-fill" style="margin-left: 10px"></i>
    </a>
</li>
<ul id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
    <li class="sidebar-item {{ Request::is('admin/category*') || Request::is('admin/createCategory*') || Request::is('admin/editCategory*') ? 'active' : '' }}">
        <a href="{{ route('admin.category') }}" class='sidebar-link'>
            <i class="bi bi-tags-fill"></i>
            <span>Category</span>
        </a>
    </li>
    <li class="sidebar-item {{ Request::is('admin/category-bursa*') || Request::is('admin/createCategoryBursa*') || Request::is('admin/editCategoryBursa*') ? 'active' : '' }}">
        <a href="{{ route('admin.categoryBursa') }}" class='sidebar-link'>
            <i class="bi bi-tags-fill"></i>
            <span>Category Bursa</span>
        </a>
    </li>
    <li class="sidebar-item {{ Request::is('admin/position*') || Request::is('admin/createPosition*') || Request::is('admin/editPosition*') ? 'active' : '' }}">
        <a href="{{ route('admin.position') }}" class='sidebar-link'>
            <i class="bi bi-person-badge-fill"></i>
            <span>Position</span>
        </a>
    </li>
</ul> --}}