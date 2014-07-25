<?php

App::bind('Ssms\Repositories\User\UserRepository', 'Ssms\Repositories\User\EloquentUserRepository');

App::bind('Ssms\Repositories\Role\RoleRepository', 'Ssms\Repositories\Role\EloquentRoleRepository');

App::bind('Ssms\Repositories\Permission\PermissionRepository', 'Ssms\Repositories\Permission\EloquentPermissionRepository');

App::bind('Ssms\Repositories\Option\OptionRepository', 'Ssms\Repositories\Option\EloquentOptionRepository');

App::bind('Ssms\Repositories\QuickLink\QuickLinkRepository', 'Ssms\Repositories\QuickLink\EloquentQuickLinkRepository');