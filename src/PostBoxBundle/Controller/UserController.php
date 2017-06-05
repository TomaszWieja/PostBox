<?php

namespace PostBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PostBoxBundle\Entity\User;
use PostBoxBundle\Entity\Address;
use PostBoxBundle\Entity\Phone;
use PostBoxBundle\Entity\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class UserController extends Controller
{
    /**
     * @Route("/new")
     */
    public function newAction(Request $request)
    {
        $newUser = new User();
        $form = $this->createFormBuilder($newUser)
                ->add('name', 'text')
                ->add('surname', 'text')
                ->add('description', 'text')
                ->add('Save', 'submit')
                ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $newUser = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($newUser);
            $em->flush();
            return $this->redirect("/");
        }
        
        return $this->render('PostBoxBundle:User:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("{id}/modify")
     */
    public function modifyAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository('PostBoxBundle:User');
        $user = $repository->find($id);
        $form = $this->createFormBuilder($user)
                ->add('name', 'text')
                ->add('surname', 'text')
                ->add('description', 'text')
                ->add('Change', 'submit')
                ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $newUser = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($newUser);
            $em->flush();
            
        }
        
        $newAddress = new Address();
        $formAddress = $this->createFormBuilder($newAddress)
                ->setAction("/$id/addAddress")
                ->add('city', 'text')
                ->add('street', 'text')
                ->add('blockNo', 'text')
                ->add('apartmentsNo', 'text')
                ->add('Add Address', 'submit')
                ->getForm();
        
        $newPhone = new Phone();
        $formPhone = $this->createFormBuilder($newPhone)
                ->setAction("/$id/addPhone")
                ->add('number', 'number')
                ->add('type', 'text')
                ->add('Add phone', 'submit')
                ->getForm();
        
        $newEmail = new Email();
        $formEmail = $this->createFormBuilder($newEmail)
                ->setAction("/$id/addEmail")
                ->add('email', 'text')
                ->add('type', 'text')
                ->add('Add email', 'submit')
                ->getForm();
        
        
        return $this->render('PostBoxBundle:User:modify.html.twig', array(
            'form' => $form->createView(),
            'formAddress' => $formAddress->createView(),
            'formPhone' => $formPhone->createView(),
            'formEmail' => $formEmail->createView()
        ));
    }

    /**
     * @Route("{id}/delete")
     */
    public function deleteAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('PostBoxBundle:User');
        $user = $repository->find($id);
        
        if (!$user) {
            return new Response("Błąd usunięcia");
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirect("/");
        
    }

    /**
     * @Route("/{id}")
     */
    public function getAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('PostBoxBundle:User');
        $user = $repository->find($id);

        if (!$user) {
            return new Response("Użytkownik nie istnieje");
        }
        $repository = $this->getDoctrine()->getRepository('PostBoxBundle:Address');
        $addresses = $repository->findByUserId($id);
        
        $repository = $this->getDoctrine()->getRepository('PostBoxBundle:Email');
        $emails = $repository->findByUserId($id);
        
        $repository = $this->getDoctrine()->getRepository('PostBoxBundle:Phone');
        $phones = $repository->findByUserId($id);

        return $this->render('PostBoxBundle:User:get.html.twig', array(
            'user' => $user,
            'addresses' => $addresses,
            'emails' => $emails,
            'phones' => $phones
        ));
    }

    /**
     * @Route("/")
     */
    public function getAllAction()
    {        
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT u FROM PostBoxBundle:User u ORDER BY u.surname');        
        $allUsers = $query->getResult();

        return $this->render('PostBoxBundle:User:get_all.html.twig', array(
            'allUsers' => $allUsers
        ));
    }
    

}
