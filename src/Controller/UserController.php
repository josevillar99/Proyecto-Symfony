<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Form\RegisterType;
use DateTime;
use Symfony\Component\Validator\Constraints\Date;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        //Crear Form
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        //Rellerar el objecto usuario con los datos del form
        $form->handleRequest($request);
        //Check submit
        if ($form->isSubmitted() && $form->isValid()) {
            //Añadir nuevos datos
            $user->setRol('ROLE_USER');
            // $date_now = date('d-m-Y H:i:s');
            $user->setCreatedAt(new DateTime('now'));
            //Cifrar pwd
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            //Guardar el usuario en la bd
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('tasks');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', array(
            'error' => $error,
            'last_username' => $lastUsername
        ));
    }
}
