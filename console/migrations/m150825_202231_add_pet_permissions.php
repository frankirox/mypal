<?php

use common\db\PermissionsMigration;

class m150825_202231_add_pet_permissions extends PermissionsMigration
{

    public function beforeUp()
    {
        $this->addPermissionsGroup('petManagement', 'Pet Management');
    }

    public function afterDown()
    {
        $this->deletePermissionsGroup('petManagement');
    }

    public function getPermissions()
    {
        return [
            'petManagement' => [
                'links' => [
                    '/admin/pet/*',
                    '/admin/pet/default/*',
                ],
                'viewPets' => [
                    'title' => 'View Pets',
                    'links' => [
                        '/admin/pet/default/index',
                        '/admin/pet/default/view',
                        '/admin/pet/default/grid-sort',
                        '/admin/pet/default/grid-page-size',
                    ],
                    'roles' => [
                        self::ROLE_USER,
                    ],
                ],
                'editPets' => [
                    'title' => 'Edit Pets',
                    'links' => [
                        '/admin/pet/default/update',
                    ],
                    'roles' => [
                        self::ROLE_MODERATOR,
                    ],
                    'childs' => [
                        'viewPets',
                    ],
                ],
                'createPets' => [
                    'title' => 'Create Pets',
                    'links' => [
                        '/admin/pet/default/create',
                    ],
                    'roles' => [
                        self::ROLE_MODERATOR,
                    ],
                    'childs' => [
                        'viewPets',
                    ],
                ],
                'deletePets' => [
                    'title' => 'Delete Pets',
                    'links' => [
                        '/admin/pet/default/delete',
                        '/admin/pet/default/bulk-delete',
                    ],
                    'roles' => [
                        self::ROLE_ADMIN,
                    ],
                    'childs' => [
                        'viewPets',
                    ],
                ],
            ],
        ];
    }

}
