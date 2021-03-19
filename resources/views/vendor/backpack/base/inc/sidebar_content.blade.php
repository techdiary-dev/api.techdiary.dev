<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->


<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i>
        {{ trans('backpack::base.dashboard') }}
    </a>
</li>

<li class='nav-item'>
    <a class='nav-link' href='{{ backpack_url('article') }}'>
        <i class='nav-icon la la-book'></i>
        Articles
    </a>
</li>

<li class='nav-item'>
    <a class='nav-link' href='{{ backpack_url('tag') }}'>
        <i class='nav-icon la la-tags'></i>
        Tags
    </a>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-group"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item">
            <a class="nav-link" href="{{ backpack_url('user') }}">
                <i class="nav-icon la la-user"></i>
                <span>Users</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ backpack_url('usersocial') }}">
                <i class="nav-icon la la-group"></i>
                <span>Social Providers</span>
            </a>
        </li>
    </ul>
</li>
