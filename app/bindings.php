<?php

// IoC Bindings

App::bind('Ssms\Repositories\User\UserRepositoryInterface', 'Ssms\Repositories\User\EloquentUserRepository');