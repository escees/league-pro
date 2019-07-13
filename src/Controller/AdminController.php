<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin2", name="app.admin")
     */
    public function index(Request $request)
    {
        return $this->render('admin/dashboard/index.html.twig');
    }

    /**
     * @Route("/matches", name="app.matches")
     */
    public function matches(Request $request)
    {
        return $this->render('admin/matches/dashboard.html.twig');
    }

    /**
     * @Route("/css-color", name="app.css_color")
     */
    public function cssColor(Request $request)
    {
        return $this->render('admin/dashboard/css-color.html.twig');
    }

    /**
     * @Route("/typography", name="app.typography")
     */
    public function typography(Request $request)
    {
        return $this->render('admin/dashboard/css-typography.html.twig');
    }

    /**
     * @Route("/form-layouts", name="app.form_layouts")
     */
    public function formLayouts(Request $request)
    {
        return $this->render('admin/dashboard/form-layouts.html.twig');
    }

    /**
     * @Route("/table-basic", name="app.table_basic")
     */
    public function tableBasic(Request $request)
    {
        return $this->render('admin/dashboard/table-basic.html.twig');
    }

    /**
     * @Route("/butons", name="app.buttons")
     */
    public function buttons(Request $request)
    {
        return $this->render('admin/dashboard/ui-basic-buttons.html.twig');
    }

    /**
     * @Route("/icons", name="app.icons")
     */
    public function icons(Request $request)
    {
        return $this->render('admin/dashboard/ui-icons.html.twig');
    }
}
