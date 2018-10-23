<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use App\Entity\ShippingRate;

class ShippingRateController extends FOSRestController
{
    //{
    //"name" : "JP shipping rate",
    //"countryCode": "JP",
    //"fromValue": 0,
    //"toValue" : 50,
    //"weight": 20,
    //"shippingFee": 70
    //}

//    /**
//     * @Route("/shippingrate", name="shipping_rate")
//     */
//    public function index ()
//    {
//        return $this->render('shipping_rate/index.html.twig', [
//            'controller_name' => 'ShippingRateController',
//        ]);
//    }

    /**
     * @Rest\Get("/shipping_rate")
     */
    public function getAction()
    {
        $restresult = $this->getDoctrine()->getRepository('App/ShippingRateRepository')->findAll();
        if ($restresult === null) {
            return new View("No Shipping Rates Found", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /**
     * @Rest\Get("/shipping_rate/{id}")
     */
    public function idAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('ShippingRateRepository')->find($id);
        if ($singleresult === null) {
            return new View("shippingRate not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Post("/shipping_rate/")
     */
    public function postAction(Request $request)
    {
        $data = new PostShippingRate;
        echo $request;
        $name = $request->get('name');
        $role = $request->get('countryCode');
        $role = $request->get('fromValue');
        $role = $request->get('toValue');
        $role = $request->get('weight');
        $role = $request->get('shipping');
        if(empty($name) || empty($role))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $data->setName($name);
        $data->setRole($role);
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return new View("ShippingRate Added Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/shippingRate/{id}")
     */
    public function updateAction($id,Request $request)
    {
        $data = new shippingRate;
        $name = $request->get('name');
        $role = $request->get('role');
        $sn = $this->getDoctrine()->getManager();
        $shippingRate = $this->getDoctrine()->getRepository('ShippingRateRepository')->find($id);
        if (empty($shippingRate)) {
            return new View("shippingRate not found", Response::HTTP_NOT_FOUND);
        }
        elseif(!empty($name) && !empty($role)){
            $shippingRate->setName($name);
            $shippingRate->setRole($role);
            $sn->flush();
            return new View("shippingRate Updated Successfully", Response::HTTP_OK);
        }
        elseif(empty($name) && !empty($role)){
            $shippingRate->setRole($role);
            $sn->flush();
            return new View("role Updated Successfully", Response::HTTP_OK);
        }
        elseif(!empty($name) && empty($role)){
            $shippingRate->setName($name);
            $sn->flush();
            return new View("shippingRate Name Updated Successfully", Response::HTTP_OK);
        }
        else return new View("shippingRate name or role cannot be empty", Response::HTTP_NOT_ACCEPTABLE);
    }


    /**
     * @Rest\Delete("/shippingRate/{id}")
     */
    public function deleteAction($id)
    {
        $data = new shippingRate;
        $sn = $this->getDoctrine()->getManager();
        $shippingRate = $this->getDoctrine()->getRepository('ShippingRateRepository')->find($id);
        if (empty($shippingRate)) {
            return new View("shippingRate not found", Response::HTTP_NOT_FOUND);
        }
        else {
            $sn->remove($shippingRate);
            $sn->flush();
        }
        return new View("deleted successfully", Response::HTTP_OK);
    }


    /**
     * @Rest\POST("/calculate")
     */
    public function calculate($id)
    {
        $data = new shippingRate;
        $sn = $this->getDoctrine()->getManager();
        $shippingRate = $this->getDoctrine()->getRepository('ShippingRateRepository')->find($id);
        if (empty($shippingRate)) {
            return new View("shippingRate not found", Response::HTTP_NOT_FOUND);
        }
        else {
            $sn->remove($shippingRate);
            $sn->flush();
        }
        return new View("deleted successfully", Response::HTTP_OK);
    }
}

