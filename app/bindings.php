<?php

App::bind('Ssms\Repositories\User\UserRepositoryInterface', 'Ssms\Repositories\User\EloquentUserRepository');

App::bind('Ssms\Repositories\Role\RoleRepositoryInterface', 'Ssms\Repositories\Role\EloquentRoleRepository');

App::bind('Ssms\Repositories\Permission\PermissionRepositoryInterface', 'Ssms\Repositories\Permission\EloquentPermissionRepository');

App::bind('Ssms\Repositories\Option\OptionRepositoryInterface', 'Ssms\Repositories\Option\EloquentOptionRepository');