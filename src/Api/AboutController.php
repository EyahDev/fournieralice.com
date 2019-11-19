<?php

namespace App\Api;

use App\Entity\About;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AboutController extends AbstractFOSRestController  {

    /**
     * Get about section data
     * @Rest\Get("/about", name="api_about_index", methods={"GET"})
     * @param Request $request
     * @return View
     */
    public function getAboutContent(Request $request): View {
        $doctrineManager = $this->getDoctrine()->getManager();
        $aboutData = $doctrineManager->getRepository(About::class)->getContent();

        return View::create($aboutData, Response::HTTP_OK);
    }

    /**
     * Update about section data
     * @Rest\Post("/about", name="api_about_update", methods={"POST"})
     * @Rest\RequestParam(name="content", allowBlank=false, description="The content of about section to update")
     * @param Request $request
     * @return View
     */
    public function updateAboutContent(Request $request): View
    {
        $data = json_decode($request->getContent(), true);
        if(empty($data) || !isset($data['content']) || is_null($data['content'])){
            throw new \InvalidArgumentException("Invalid argument or argument content doesn't exist");
        }

        $doctrineManager = $this->getDoctrine()->getManager();
        $doctrineManager->getRepository(About::class)->updateAboutSection($data['content']);

        return View::create('About section updated successfully', Response::HTTP_OK);
    }
}
