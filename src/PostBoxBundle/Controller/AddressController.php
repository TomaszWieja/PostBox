<?php

namespace PostBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PostBoxBundle\Entity\Address;
use Symfony\Component\HttpFoundation\Request;
use PostBoxBundle\Entity\User;



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
        return $this->redirect("/".$user->getId());
        
        
    }
    
    /**
     * @Route("/{id}/modifyAddress")
     */
    public function modifyAddressAction(Request $request, $id) {
        
        $repository = $this->getDoctrine()->getRepository('PostBoxBundle:Address');
        $address = $repository->find($id);
        
        $form = $this->createFormBuilder($address)
                ->add('city', 'text')
                ->add('street', 'text')
                ->add('blockNo', 'text')
                ->add('apartmentsNo', 'text')
                ->add('Update', 'submit')
                ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $newAddress = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($newAddress);
            $em->flush();
            return $this->redirect("/".$address->getUserId()->getId());
        }
        
        return $this->render('PostBoxBundle:Address:modify_address.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
     * @Route("/{id}/deleteAddress")
     */
    public function deleteAddressAction($id) {
        
        $repository = $this->getDoctrine()->getRepository('PostBoxBundle:Address');
        $address = $repository->find($id);
        $userId = $address->getUserId()->getId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($address);
        $em->flush();
        return $this->redirect("/".$userId);
    }
}
