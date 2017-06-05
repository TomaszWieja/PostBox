<?php

namespace PostBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PostBoxBundle\Entity\Email;
use Symfony\Component\HttpFoundation\Request;

class EmailController extends Controller
{
    /**
     * @Route("/{id}/addEmail")
     */
    public function addEmailAction(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository('PostBoxBundle:User')
                ->find($id);
        $form = $request->request->get('form');
        $newEmail = new Email();
        $newEmail->setEmail($form['email']);
        $newEmail->setType($form['type']);
        $newEmail->setUserId($user);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($newEmail);
        $em->flush();
        return $this->redirect("/".$user->getId());
        
    }
    
    /**
     * @Route("/{id}/modifyEmail")
     */
    public function modifyEmailAction(Request $request, $id) {
        
        $repository = $this->getDoctrine()->getRepository('PostBoxBundle:Email');
        $email = $repository->find($id);
        
        $form = $this->createFormBuilder($email)
                ->add('email', 'text')
                ->add('type', 'text')
                ->add('Update', 'submit')
                ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $newEmail = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($newEmail);
            $em->flush();
            return $this->redirect("/".$email->getUserId()->getId());
        }
        return $this->render('PostBoxBundle:Email:modify_email.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
     * @Route("/{id}/deleteEmail")
     */
    public function deleteEmailAction($id) {
        
        $repository = $this->getDoctrine()->getRepository('PostBoxBundle:Email');
        $email = $repository->find($id);
        $userId = $email->getUserId()->getId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($email);
        $em->flush();
        return $this->redirect("/".$userId);
    }
}
