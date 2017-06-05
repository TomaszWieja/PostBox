<?php

namespace PostBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PostBoxBundle\Entity\Phone;
use Symfony\Component\HttpFoundation\Request;


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
        return $this->redirect("/".$user->getId());
        
    }
    
    /**
     * @Route("/{id}/modifyPhone")
     */
    public function modifyPhoneAction(Request $request, $id) {
        
        $repository = $this->getDoctrine()->getRepository('PostBoxBundle:Phone');
        $phone = $repository->find($id);
        
        $form = $this->createFormBuilder($phone)
                ->add('number', 'number')
                ->add('type', 'text')
                ->add('Update', 'submit')
                ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $newPhone = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($newPhone);
            $em->flush();
            return $this->redirect("/".$phone->getUserId()->getId());
        }
        
        return $this->render('PostBoxBundle:Phone:modify_phone.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
     * @Route("/{id}/deletePhone")
     */
    public function deletePhoneAction($id) {
        
        $repository = $this->getDoctrine()->getRepository('PostBoxBundle:Phone');
        $phone = $repository->find($id);
        $userId = $phone->getUserId()->getId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($phone);
        $em->flush();
        return $this->redirect("/".$userId);
        
    }
}
