<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('categories') }}"><i class="la la-home nav-icon"></i> {{ trans('custom.categories_side_bar') }}</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('about') }}"><i class="la la-home nav-icon"></i> {{ trans('custom.menu_about') }}</a></li>

<li class="nav-title">{{ trans('custom.blog') }}</li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('blog') }}'><i class='nav-icon la la-newspaper'></i> {{ trans('custom.articles') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('tags') }}'><i class='nav-icon la la-tags'></i> {{ trans('custom.tags') }}</a></li>

<li class="nav-title">{{ trans('custom.other') }}</li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('cities') }}'><i class='nav-icon la la-city'></i> {{ trans('custom.cities') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('groups') }}'><i class='nav-icon la la-object-group'></i> {{ trans('custom.groups') }}</a></li>

<li class="nav-title">{{ trans('custom.users') }}</li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('users') }}'><i class='nav-icon la la-user'></i> {{ trans('custom.users') }}</a></li>