<?php

namespace PostBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PostBoxBundle\Entity\Address;
use Symfony\Component\HttpFoundation\Request;
use PostBoxBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AddressController extends Controller
{
    /**
     * @Route("/{id}/addAddress")
     * 
     */
    public function addAddressAction(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository('PostBoxBundle:User')
                ->find($id);
        $form = $request->request->get('form');
        $newAddress = new Address();
        $newAddress->setCity($form['city']);
        $newAddress->setStreet($form['street']);
        $newAddress->setBlockNo($form['blockNo']);
        $newAddress->setApartmentsNo($form['apartmentsNo']);
        $newAddress->setUserId($user);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($newAddress);
        $em->flush();
        
        
        return $this->render('PostBoxBundle:Address:add_address.html.twig', array(
            // ...
        ));
    }

}
