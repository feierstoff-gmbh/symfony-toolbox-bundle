<?php

namespace Feierstoff\ToolboxBundle\Route;

use Feierstoff\ToolboxBundle\ApiGenerator\ApiDocGenerator;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ApiDocRoute {
    public function __construct(
        private Environment $twig,
        private ApiDocGenerator $apiDocGenerator
    ) {}

    public function index(): Response {
        $routes = $this->apiDocGenerator->generate();
        return new Response($this->twig->render("@Toolbox/api-doc.html.twig", [
            "endpoints" => $routes
        ]));
    }
}