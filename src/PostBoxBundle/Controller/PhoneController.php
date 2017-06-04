<?php

namespace PostBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PostBoxBundle\Entity\Phone;
use Symfony\Component\HttpFoundation\Request;
use PostBoxBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PhoneController extends Controller
{
    /**
     * @Route("/{id}/addPhone")
     */
    public function addPhoneAction(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository('PostBoxBundle:User')
                ->find($id);
        $form = $request->request->get('form');
        $newPhone = new Phone();
        $newPhone->setNumber($form['number']);
        $newPhone->setType($form['type']);
        $newPhone->setUserId($user);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($newPhone);
        $em->flush();
        
        return $this->render('PostBoxBundle:Phone:add_phone.html.twig', array(
            // ...
        ));
    }

}
