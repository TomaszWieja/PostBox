<?php

namespace PostBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PostBoxBundle\Entity\User;
use PostBoxBundle\Entity\Address;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

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
        
        return $this->render('PostBoxBundle:User:modify.html.twig', array(
            'form' => $form->createView(),
            'formAddress' => $formAddress->createView()
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
        
        return $this->render('PostBoxBundle:User:delete.html.twig', array(
            // ...
        ));
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
        
        return $this->render('PostBoxBundle:User:get.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * @Route("/")
     */
    public function getAllAction()
    {
        $repository = $this->getDoctrine()->getRepository('PostBoxBundle:User');
        $allUsers = $repository->findAll();

        return $this->render('PostBoxBundle:User:get_all.html.twig', array(
            'allUsers' => $allUsers
        ));
    }
    

}
