<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Product;
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

        return $this->render('products/products.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/product-create", name="createProduct")
     */
    public function createProduct()
    {

        return $this->render('products/newProducts.html.twig', []);
    }

    /**
     * @Route("/product/{id}", name="view-product", requirements={"page": "\d+"} )
     */
    public function viewOneProduct($id)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->find($id);
//        echo '<pre>';
//        var_dump($products);die;
        return $this->render('products/viewProduct.html.twig', ['product' => $products]);
    }
}