<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;

class Administrator extends Controller
{
    /**
     * @Route("/admin/main", name="adminMainPage")
     */
    public function allCategories()
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();

        return $this->render('administrator/admin_main.html.twig', ['categories' => $categories]);
    }
}