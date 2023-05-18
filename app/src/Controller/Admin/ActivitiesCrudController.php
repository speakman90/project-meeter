<?php

namespace App\Controller\Admin;

use App\Entity\Activities;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ActivitiesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Activities::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')
        ];
    }
}
