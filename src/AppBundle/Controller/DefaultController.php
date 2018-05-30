<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class DefaultController extends Controller
{

    //Functie om naar de homepagina te gaan met een redirect naar de homepagina van de gebruiker.

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, AuthorizationCheckerInterface $authorizationChecker)
    {
        if ($authorizationChecker->isGranted(new Expression('"ROLE_INKOPER" in roles')))
        {
            return $this->redirectToRoute('inkoper');
        }
        else if ($authorizationChecker->isGranted(new Expression('"ROLE_MAGAZIJNMEESTER" in roles')))
        {
            return $this->redirectToRoute('magazijnmeester');
        }
        else if ($authorizationChecker->isGranted(new Expression('"ROLE_VERKOPER" in roles')))
        {
            return $this->redirectToRoute('verkoper');
        }
        else
        {
            return $this->render('default/index.html.twig');
        }
    }

    //Functie om uit te loggen.

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction(Request $request)
    {
        return new Response($this->renderView('logout.html.twig'), 401);
    }

}