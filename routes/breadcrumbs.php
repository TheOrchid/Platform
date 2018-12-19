<?php

declare(strict_types=1);

// Platform
Breadcrumbs::for('platform.index', function ($trail) {
    $trail->push(__('Platform'), route('platform.index'));
});

// Platform > System
Breadcrumbs::for('platform.systems.index', function ($trail) {
    $trail->parent('platform.index');
    $trail->push(__('Systems'), route('platform.systems.index'));
});

// Platform > System > Menu
Breadcrumbs::for('platform.systems.menu.index', function ($trail) {
    $trail->parent('platform.systems.index');
    $trail->push(__('Menu'), route('platform.systems.menu.index'));
});

// Platform > System > Menu > Create
Breadcrumbs::for('platform.systems.menu.create ', function ($trail) {
    $trail->parent('platform.systems.menu.index');
    $trail->push(__('Create'), route('platform.systems.menu.create '));
});

// Platform > System > Menu > Editing
Breadcrumbs::for('platform.systems.menu.show', function ($trail, $menu) {
    $trail->parent('platform.systems.menu.index');
    $trail->push(__('Editing'), route('platform.systems.menu.show', $menu));
});

// Platform > System > Media
Breadcrumbs::for('platform.systems.media.index', function ($trail, $params = '') {
    $breadcrumbs = \Orchid\Press\Http\Controllers\MediaController::getBreadcrumb($params);

    $trail->parent('platform.systems.index');
    $trail->push(__('Media'), route('platform.systems.media.index'));

    foreach ($breadcrumbs as $breadcrumb) {
        $trail->push($breadcrumb['name'], route('platform.systems.media.index', [$breadcrumb['path']]));
    }
});

// Platform > System > Backup
Breadcrumbs::for('platform.systems.backups', function ($trail) {
    $trail->parent('platform.systems.index');
    $trail->push(__('Backup'), route('platform.systems.backups'));
});

// Platform > System > Bulldozer
Breadcrumbs::for('platform.bulldozer.index', function ($trail) {
    $trail->parent('platform.systems.index');
    $trail->push(__('Model Builder'), route('platform.bulldozer.index'));
});

// Platform > System > Announcement
Breadcrumbs::for('platform.systems.announcement', function ($trail) {
    $trail->parent('platform.systems.index');
    $trail->push(__('Announcement'), route('platform.systems.announcement'));
});

//Posts

// Platform > Posts
Breadcrumbs::for('platform.posts.type', function ($trail, $type) {
    $trail->parent('platform.index');
    $trail->push(__('Posts'), route('platform.posts.type', $type->slug));
});

// Platform > Posts > Create
Breadcrumbs::for('platform.posts.type.create', function ($trail, $type) {
    $trail->parent('platform.posts.type', $type);
    $trail->push(__('Create'), route('platform.posts.type.create', $type->slug));
});

// Platform > Posts > Edit
Breadcrumbs::for('platform.posts.type.edit', function ($trail, $type, $post) {
    $trail->parent('platform.posts.type', $type);
    $trail->push($post->getContent($type->slugFields) ?? '', route('platform.posts.type.edit', [$type->slug, $post->slug]));
});

// Platform > Pages
Breadcrumbs::for('platform.pages.show', function ($trail, $page) {
    $trail->parent('platform.index');
    $trail->push(__('Pages'), route('platform.pages.show', $page));
});
