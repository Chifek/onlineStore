<?php
/**
 * Created by PhpStorm.
 * User: mavix
 * Date: 11/17/17
 * Time: 11:09 AM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class Contacts extends Controller
{
    /**
     * @Route("/contacts", name="contacts")
     */
    public function getContactsInfo()
    {
        $tel = '0709552727';
        $company = 'onlineStore';

        return $this->render('contacts/contacts.html.twig', ['tel' => $tel, 'company' => $company]);
    }
}