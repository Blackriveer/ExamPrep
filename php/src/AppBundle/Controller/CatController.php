<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cat;
use AppBundle\Form\CatType;
use AppBundle\Repository\CatRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CatController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request)
    {
        $getCats = $this->getDoctrine()->getRepository("AppBundle:Cat")->findAll();

        return $this->render("cat/index.html.twig", array(
            "cats" => $getCats
        ));
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $cat = new Cat();
        $form = $this->createForm(CatType::class, $cat);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $cat->setName($cat->getName());
            $cat->setNickname($cat->getNickname());
            $cat->setPrice($cat->getPrice());

            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($cat);
            // actually executes the queries (i.e. the INSERT query)
            $em->flush();

            return $this->redirectToRoute("homepage");
        }

        return $this->render("cat/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */

    public function edit($id, Request $request)
    {
        $cat = $this->getDoctrine()->getRepository("AppBundle:Cat")->find($id);
        $form = $this->createForm(CatType::class, $cat);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $cat->setName($cat->getName());
            $cat->setNickname($cat->getNickname());
            $cat->setPrice($cat->getPrice());

            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($cat);
            // actually executes the queries (i.e. the INSERT query)
            $em->flush();

            return $this->redirectToRoute("homepage");
        }

        return $this->render("cat/edit.html.twig", [
            "form" => $form->createView(),
            "cat" => $cat
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function delete($id, Request $request)
    {
        $cat = $this->getDoctrine()->getRepository("AppBundle:Cat")->find($id);
        $form = $this->createForm(CatType::class, $cat);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->remove($cat);
            $em->flush();

            return $this->redirectToRoute("homepage");
        }


        return $this->render("cat/delete.html.twig", [
            "form" => $form->createView(),
            "cat" => $cat
        ]);
    }
}
