<?php

if (!function_exists('adminSidebarItems')) {
    function adminSidebarItems(): array
    {
        return [
            'main' => [
                ['label' => 'dashboard', 'icon' => 'ti ti-dashboard', 'route' => 'dashboard.admin.index', 'active_pattern' => 'dashboard.admin.index'],
            ]
        ];
    }
}

if (!function_exists('studentSidebarItems')) {
    function studentSidebarItems(): array
    {
        return [
            'main' => [
                ['label' => 'dashboard', 'icon' => 'ti ti-dashboard', 'route' => 'dashboard.student.index', 'active_pattern' => 'dashboard.student.index'],
            ]
        ];
    }
}
