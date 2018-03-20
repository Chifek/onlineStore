<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Brands;
use AppBundle\Entity\Product;
use AppBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;

class Brand extends Controller
{
    /**
     * @Route("/brands", name="brands")
     */
    public function allBrands()
    {
        $repository = $this->getDoctrine()->getRepository(Brands::class);
        $brands = $repository->findAll();
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();
        return $this->render('brands/brands.html.twig', ['brands' => $brands, 'categories' => $categories]);
    }

    /**
     * @Route("/admin/brand-create", name="createBrand")
     */
    public function createBrand()
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();
        return $this->render('brands/newBrand.html.twig', ['categories' => $categories]);
    }

    /**
     * @Route("/saveBrand", name="saveBrand")
     */
    public function sendData(Request $request)
    {
        $requestAll = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        $brand = new Brands();
        $brand->setName($requestAll['title']);
        $brand->setDescription($requestAll['description']);

        $em->persist($brand);
        $em->flush();

        return $this->redirectToRoute('adminMainPage');
    }

    /**
     * @Route("/brands/{id}", name="view-brand", requirements={"page": "\d+"} )
     */
    public function viewOneBrand($id)
    {
        $products = $this->getDoctrine()->getRepository(Product::class);
        $getProduct = $products->findBy(array('brandId' => $id));
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();
        $brands = $this->getDoctrine()->getRepository(Brands::class);
        $getBrand = $brands->findBy(array('id' => $id));

        return $this->render('brands/viewBrand.html.twig',
            ['products' => $getProduct,
                'categories' => $categories,
                'brand' => $getBrand]);
    }
}