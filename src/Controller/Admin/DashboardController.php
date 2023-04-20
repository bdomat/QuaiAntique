<?php

namespace App\Controller\Admin;

use App\Entity\Dishes;
use App\Entity\Formulas;
use App\Entity\Images;
use App\Entity\Menus;
use App\Entity\Reservations;
use App\Entity\Restaurants;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(ReservationsCrudController::class)
            ->generateUrl();

        return $this->redirect($url);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

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
            ->setTitle('QuaiAntique');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home', Dashboard::class);
        yield MenuItem::section('Informations', 'fa fa-circle-info');
        yield MenuItem::subMenu('Restaurant', 'fa fa-building')->setSubItems([
            MenuItem::linkToCrud('Horaires', 'fa fa-clock', Restaurants::class),
            MenuItem::linkToCrud('Seuil de convives', 'fa fa-users-rays', Restaurants::class),
        ]);
        yield MenuItem::subMenu('Réservations', 'fa fa-table-list')->setSubItems([
            MenuItem::linkToCrud('Registre des réservations', 'fa fa-eye', Reservations::class),
            MenuItem::linkToCrud('Ajouter une réservation', 'fa fa-plus', Reservations::class)->setAction(Crud::PAGE_NEW),
        ]);
        yield MenuItem::linkToCrud('Gallerie photos', 'fa fa-image', Images::class);
        yield MenuItem::section('Carte', 'fa fa-book-open');
        yield MenuItem::subMenu('Plats', 'fa fa-fish-fins')->setSubItems([
            MenuItem::linkToCrud('Ajouter un plat', 'fa fa-plus', Dishes::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des plats', 'fa fa-list', Dishes::class),
        ]);

        yield MenuItem::subMenu('Menus', 'fa fa-receipt')->setSubItems([
            MenuItem::linkToCrud('Ajouter un menu', 'fa fa-plus', Menus::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des menus', 'fa fa-list', Menus::class),
            MenuItem::linkToCrud('Ajouter une formule', 'fa fa-plus', Formulas::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des formules', 'fa fa-list', Formulas::class)
        ]);

        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
