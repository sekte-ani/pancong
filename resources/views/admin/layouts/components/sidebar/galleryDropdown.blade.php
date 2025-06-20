{{-- Gellery --}}
<li class="sidebar-item {{ Request::is('admin/activity*') || Request::is('admin/createActivity*') || Request::is('admin/editActivity*') || Request::is('admin/showActivity*') || Request::is('admin/gallery*') || Request::is('admin/createGallery*') || Request::is('admin/editGallery*') || Request::is('admin/showGallery*') ? 'active' : '' }}">
    <a class="sidebar-link" href="#" data-bs-toggle="collapse" data-bs-target="#galleryData" aria-expanded="false" aria-controls="galleryData">
        <i class="bi bi-images"></i>
        <span>Gallery Data</span>
        <i class="bi bi-caret-down-fill" style="margin-left: 10px"></i>
    </a>
</li>
<ul id="galleryData" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
    <li class="sidebar-item {{ Request::is('admin/gallery*') || Request::is('admin/createGallery*') || Request::is('admin/editGallery*') || Request::is('admin/showGallery*') ? 'active' : '' }}">
        <a href="{{ route('admin.gallery') }}" class='sidebar-link'>
            <i class="bi bi-file-earmark-image"></i>
            <span>Album</span>
        </a>
    </li>
</ul>