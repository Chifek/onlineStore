<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Category;
use AppBundle\Entity\Brands;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Contacts;

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

    /**
     * @Route("/admin/edit-contact", name="editContact")
     */
    public function editContact()
    {
        $repository = $this->getDoctrine()->getRepository(Contacts::class);
        $address = $repository->findBy(array('id' => 1));

        return $this->render('administrator/contacts_edit.html.twig', ['address' => $address]);

    }

    /**
     * @Route("/admin/saveContacts", name="saveContacts")
     */
    public function saveContacts(Request $request)
    {
        $requestAll = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        $contacts = $em->getRepository(Contacts::class)->find($requestAll['id']);
        $contacts->setPhone($requestAll['phone']);
        $contacts->setAddress($requestAll['address']);
        $em->persist($contacts);
        $em->flush();

        return $this->redirectToRoute('adminMainPage');
    }

    /**
     * @Route("/admin/deleteProduct/{id}", name="deleteProduct")
     */
    public function deleteProduct($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($id);
        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('productsLists');
    }

    /**
     * @Route("/admin/productList", name="productsLists")
     */
    public function productsList()
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();

        return $this->render('administrator/products_list.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/admin/brandsList", name="brandsLists")
     */
    public function brandsList()
    {
        $repository = $this->getDoctrine()->getRepository(Brands::class);
        $brands = $repository->findAll();

        return $this->render('administrator/brands_list.html.twig', ['brands' => $brands]);
    }

    /**
     * @Route("/admin/deleteBrand/{id}", name="deleteBrand")
     */
    public function deleteBrand($id)
    {
        $em = $this->getDoctrine()->getManager();
        $brand = $em->getRepository(Brands::class)->find($id);
        $em->remove($brand);
        $em->flush();

        return $this->redirectToRoute('brandsLists');
    }

    /**
     * @Route("/admin/categoriesList", name="categoriesList")
     */
    public function categoriesList()
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();

        return $this->render('administrator/categories_list.html.twig', ['categories' => $categories]);
    }

    /**
     * @Route("/admin/deleteCategory/{id}", name="deleteCategory")
     */
    public function deleteCategory($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->find($id);
        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute('categoriesList');
    }

    /**
     * @Route("/admin/editBrand/{id}", name="editBrand")
     */
    public function editBrand(Request $request, $id)
    {
        $requestAll = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        $brand = $em->getRepository(Brands::class)->find($id);
        $brand->setName($requestAll['brand']);
        $em->persist($brand);
        $em->flush();

        return $this->redirectToRoute('brandsLists');
    }
}