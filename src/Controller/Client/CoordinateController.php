<?php

namespace App\Controller\Client;

use App\Entity\Coordinate;
use App\Form\CoordinateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CoordinateController extends AbstractController
{

    #[Route('/addCoordinate', name:'add_coordinate')]
    public function addCoordinate(Request $request, EntityManagerInterface $manager): Response
    {

        $userid = $this->getUser();
        $coordinate = new Coordinate();
        $coordinate->setUserId($userid);
        $form = $this->createForm(CoordinateType::class, $coordinate);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $coordinate= $form->getData();
            $manager->persist($coordinate);
            $manager->flush();
        }

        return $this->render('checkout/index.html.twig', [
            'CoordinateType'=>$form->createView()
        ]);
    }

}
