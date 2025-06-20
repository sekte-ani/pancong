<li class="sidebar-title">Menu</li>
{{-- Dashboard --}}
<li class="sidebar-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
    <a href="{{ route('admin.index') }}"  class='sidebar-link'>
        <i class="bi bi-grid-fill"></i>
        <span>Home</span>
    </a>
</li>

@include('admin.layouts.components.sidebar.postDropdown')
@include('admin.layouts.components.sidebar.galleryDropdown')
@include('admin.layouts.components.sidebar.masterDropdown')


{{-- teacher --}}
<li class="sidebar-item {{ Request::is('admin/menu*') || Request::is('admin/createMenu*') || Request::is('admin/editMenu*') || Request::is('admin/showMenu*') ? 'active' : '' }}">
    <a href="{{ route('admin.menu') }}" class='sidebar-link'>
        <i class="bi bi-journal"></i>
        <span>Menu</span>
    </a>
</li>
{{-- ebook --}}
{{-- <li class="sidebar-item {{ Request::is('admin/ebook*') || Request::is('admin/createEbook*') || Request::is('admin/editEbook*') || Request::is('admin/showEbook*') ? 'active' : '' }}">
    <a href="{{ route('admin.ebook') }}" class='sidebar-link'>
        <i class="bi bi-journal-album"></i>
        <span>Ebook</span>
    </a>
</li> --}}

{{-- Student --}}
{{-- <li class="sidebar-item {{ Request::is('admin/employee*') || Request::is('admin/createEmployee*') || Request::is('admin/editEmployee*') || Request::is('admin/showEmployee*') ? 'active' : '' }}">
    <a href="{{ route('admin.employee') }}" class='sidebar-link'>
        <i class="bi bi-person-rolodex"></i>
        <span>Student</span>
    </a>
</li> --}}

{{-- announce --}}


{{-- message --}}
{{-- <li class="sidebar-item {{ Request::is('admin/message*') || Request::is('admin/createMessage*') || Request::is('admin/editMessage*') || Request::is('admin/showMessage*') ? 'active' : '' }}">
    <a href="{{ route('admin.message') }}" class='sidebar-link'>
        <i class="bi bi-chat-square-text-fill"></i>
        <span>Message</span>
    </a>
</li> --}}



<li class="sidebar-item">
    <form method="POST" action="/logout" id="logout">
        @csrf
        <a href="" class='sidebar-link'>
            <i class="bi bi-box-arrow-left text-danger"></i>
            <span>Logout</span>
        </a>
    </form>
</li>