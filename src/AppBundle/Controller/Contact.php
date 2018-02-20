<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Contacts;
use AppBundle\Entity\Category;

class Contact extends Controller
{
    /**
     * @Route("/contacts", name="contacts")
     */
    public function getContactsInfo()
    {
        $repository = $this->getDoctrine()->getRepository(Contacts::class);
        $address = $repository->findBy(array('id' => 1));
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();

        return $this->render('contacts/contacts.html.twig', ['address' => $address, 'categories' => $categories]);
    }
}