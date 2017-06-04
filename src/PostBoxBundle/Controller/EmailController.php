<?php

namespace PostBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PostBoxBundle\Entity\Email;
use PostBoxBundle\Entity\User;

class EmailController extends Controller
{
    /**
     * @Route("/{id}/addEmail")
     */
    public function addEmailAction()
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
        
        return $this->render('PostBoxBundle:Email:add_email.html.twig', array(
            // ...
        ));
    }

}
