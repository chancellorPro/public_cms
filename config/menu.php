<?php
return [
    [
        'name'  => 'Admin',
        'child' => [
            ['left' => true, 'name' => 'Cms Users', 'route' => 'cms-users.index', 'icon' => 'fa-users'],
            ['left' => true, 'name' => 'Actions Log', 'route' => 'cms-user-actions.index', 'icon' => 'fa-history'],
            ['left' => true, 'name' => 'Cms Roles', 'route' => 'cms-roles.index', 'icon' => 'fa-universal-access'],
            ['left' => true, 'name' => 'Trophy Cup Users', 'route' => 'trophy-cup-users.index', 'icon' => 'fa-child'],
            ['left' => true, 'name' => 'Certificate Users', 'route' => 'cert-users.index', 'icon' => 'fa-child'],
            ['left' => true, 'name' => 'Certificate Setup', 'route' => 'cert-setup.index', 'icon' => 'fa-certificate'],
            ['left' => true, 'name' => 'Group Admins', 'route' => 'group.index', 'icon' => 'fa-globe'],
            ['left' => true, 'name' => 'Group Events', 'route' => 'group-event.index', 'icon' => 'fa-slideshare'],
            ['left' => true, 'name' => 'Nla Assets', 'route' => 'nla-asset.index', 'icon' => 'fa-archive'],
            ['left' => true, 'name' => 'Nla Sections', 'route' => 'nla-section.index', 'icon' => 'fa-folder'],
            ['left' => true, 'name' => 'Nla Categories', 'route' => 'nla-category.index', 'icon' => 'fa-folder-open'],
        ],
    ],
    [
        'name'  => 'Group admin',
        'child' => [
            ['top' => true, 'name' => 'All Group Admins', 'route' => 'group.edit', 'icon' => 'fa-globe'],
            ['top' => true, 'name' => 'Send Trophies', 'route' => 'trophies.index', 'icon' => 'fa-trophy'],
            ['top' => true, 'name' => 'Trophies History', 'route' => 'trophy-history.index', 'icon' => 'fa-history'],
            ['top' => true, 'name' => 'Send Certificate', 'route' => 'cert.index', 'icon' => 'fa-trophy'],
            ['top' => true, 'name' => 'Certificate History', 'route' => 'cert-history.index', 'icon' => 'fa-history'],
            ['top' => true, 'name' => 'Send Special Prizes', 'route' => 'special-prizes.index', 'icon' => 'fa-birthday-cake'],
            ['top' => true, 'name' => 'Special Prizes History', 'route' => 'special-prizes-history.index', 'icon' => 'fa-history'],
        ],
    ],
];
