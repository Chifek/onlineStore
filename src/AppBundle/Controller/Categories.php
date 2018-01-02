<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;

class Categories extends Controller
{
    /**
     * @Route("/categories", name="categories")
     */
    public function allCategories()
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();

        return $this->render('categories/categories.html.twig', ['categories' => $categories]);
    }

    /**
     * @Route("/admin/category-create", name="createCategory")
     */
    public function createCategory()
    {

        return $this->render('categories/newCategory.html.twig', []);
    }

    /**
     * @Route("/saveCategory", name="saveCategory")
     */
    public function sendData(Request $request)
    {
        $requestAll = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        $product = new Category();
        $product->setName($requestAll['title']);
        $product->setDescription($requestAll['description']);

        $em->persist($product);
        $em->flush();

        return $this->redirectToRoute('adminMainPage');
    }
}