<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/senddata", name="senddata")
     */
    public function sendData(Request $request)
    {
        $requestAll = $request->request->all();

        $em = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setName($requestAll['title']);
        $product->setPrice($requestAll['price']);
        $product->setDescription($requestAll['description']);

        $em->persist($product);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }
}
