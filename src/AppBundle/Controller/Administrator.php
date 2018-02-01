<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Category;
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
        $address = $repository->findAll();

        return $this->render('administrator/contacts_edit.html.twig', ['address' => $address]);

    }

    /**
     * @Route("/admin/saveContacts", name="saveContacts")
     */
    public function saveContacts(Request $request)
    {
        $requestAll = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        $contacts = new Contacts();
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

        return $this->redirectToRoute('adminMainPage');
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
}