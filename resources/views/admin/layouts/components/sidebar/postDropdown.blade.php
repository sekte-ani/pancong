{{-- Post --}}
{{-- <li class="sidebar-item {{ Request::is('admin/article*') || Request::is('admin/createArticle*') || Request::is('admin/editArticle*') || Request::is('admin/showArticle*') || Request::is('admin/announcement*') || Request::is('admin/createAnnouncement*') || Request::is('admin/editAnnouncement*') || Request::is('admin/showAnnouncement*') ? 'active' : '' }}">
    <a class="sidebar-link" href="#" data-bs-toggle="collapse" data-bs-target="#postData" aria-expanded="false" aria-controls="postData">
        <i class="bi bi-database-fill-check"></i>
        <span>Post</span>
        <i class="bi bi-caret-down-fill" style="margin-left: 10px"></i>
    </a>
</li>
<ul id="postData" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
    <li class="sidebar-item {{ Request::is('admin/article*') || Request::is('admin/createArticle*') || Request::is('admin/editArticle*') || Request::is('admin/showArticle*') ? 'active' : '' }}">
        <a href="{{ route('admin.article') }}" class='sidebar-link'>
            <i class="bi bi-postcard-fill"></i>
            <span>Article</span>
        </a>
    </li>
    <li class="sidebar-item {{ Request::is('admin/bursa*') || Request::is('admin/createBursa*') || Request::is('admin/editBursa*') || Request::is('admin/showBursa*') ? 'active' : '' }}">
        <a href="{{ route('admin.bursa') }}" class='sidebar-link'>
            <i class="bi bi-postcard-fill"></i>
            <span>Bursa Kerja</span>
        </a>
    </li>
    <li class="sidebar-item {{ Request::is('admin/announcement*') || Request::is('admin/createAnnouncement*') || Request::is('admin/editAnnouncement*') || Request::is('admin/showAnnouncement*') ? 'active' : '' }}">
        <a href="{{ route('admin.announce') }}" class='sidebar-link'>
            <i class="bi bi-megaphone-fill"></i>
            <span>Announcement</span>
        </a>
    </li>
</ul> --}}