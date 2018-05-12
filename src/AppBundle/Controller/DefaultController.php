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
        else
        {
            return $this->render('default/index.html.twig');
        }
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('this should not be reached!');
    }

}