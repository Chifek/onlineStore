<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Product;
use AppBundle\Entity\Category;
use AppBundle\Entity\Brands;
use Symfony\Component\HttpFoundation\Response;

class Products extends Controller
{
    /**
     * @Route("/products", name="products")
     */
    public function allProducts()
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();
        return $this->render('products/products.html.twig', ['products' => $products, 'categories' => $categories]);
    }

    /**
     * @Route("/admin/product-create", name="createProduct")
     */
    public function createProduct()
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository(Brands::class);
        $brands = $repository->findAll();

        return $this->render('products/newProducts.html.twig', ['categories' => $categories, 'brands' => $brands]);
    }

    /**
     * @Route("/product/{id}", name="view-product", requirements={"page": "\d+"} )
     */
    public function viewOneProduct($id)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->find($id);
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();
        return $this->render('products/viewProduct.html.twig', ['product' => $products, 'categories' => $categories]);
    }
}