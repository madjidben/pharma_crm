<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\UserCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\User;
use App\Entity\Position;
use App\Entity\BusinessUnit;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Entity\ProductForm;
use App\Entity\Team;
use App\Entity\Wilaya;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('PHARMA CRM');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToCrud('User', 'fa fa-users', User::class),
            MenuItem::linkToCrud('Position', 'fa fa-address-card-o', Position::class),
            MenuItem::linkToCrud('Business Unit', 'fa fa-briefcase', BusinessUnit::class),
            MenuItem::linkToCrud('Representatives Team', 'fa fa-handshake-o', Team::class),
            MenuItem::linkToCrud('Prod Category', 'fa fa-copyright', ProductCategory::class),
            MenuItem::linkToCrud('Product', 'fa fa-cube', Product::class),
            MenuItem::linkToCrud('Product Form', 'fa fa-cubes', ProductForm::class),
            MenuItem::linkToCrud('Wilaya', 'fa fa-map-o', Wilaya::class),
        ];
    }
}
