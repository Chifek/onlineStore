<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Contacts;

class Contact extends Controller
{
    /**
     * @Route("/contacts", name="contacts")
     */
    public function getContactsInfo()
    {
        $repository = $this->getDoctrine()->getRepository(Contacts::class);
        $address = $repository->findBy(array('id' => 1));

        return $this->render('contacts/contacts.html.twig', ['address' => $address]);
    }
}