<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Contacts;
use AppBundle\Entity\Category;
use Symfony\Bundle\MonologBundle\SwiftMailer;


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

    /**
     * @Route("/sendFeedback", name="sendFeedback")
     */
    public function sendFeedback(Request $request)
    {
        $requestAll = $request->request->all();
        $name = $requestAll['name'];
        $phone = $requestAll['phone'];
        $description = $requestAll['description'];

        $message = \Swift_Message::newInstance()
            ->setSubject('Отзыв со страницы "Наши контакты"')
            ->setFrom('alenatenn@yandex.ru', 'Site BOT')
            ->setTo('alenatenn@yandex.ru')
            ->setBody("<strong>" . 'Пользователь: ' . "</strong>" . $name . "<br>" .
                "<strong>" . 'с телефонным номером: ' . "</strong>" . '+996' . $phone . "<br>" .
                "<strong>" . 'отправил Вам следующее сообщение: ' . "</strong>" . $description);
        $message->setContentType("text/html");
        $this->get('mailer')->send($message);

        return $this->redirectToRoute('contacts');
    }
}