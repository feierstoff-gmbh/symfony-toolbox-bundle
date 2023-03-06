<?php

namespace Feierstoff\ToolboxBundle\Auth;

use Doctrine\ORM\EntityManagerInterface;
use Feierstoff\ToolboxBundle\Exception\UnauthorizedException;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class AccessControlListener {
    public function __construct(
        private EntityManagerInterface $em,
        private string $env
    ) {

    }

    public function __invoke(ControllerEvent $event) {
        if (!is_array($event->getController())) {
            return;
        }

        $method = new \ReflectionMethod($event->getController()[0], $event->getController()[1]);

        if ($this->env !== "dev") {
            $key = $event->getRequest()->headers->get("Authorization");

            if (!$key || !str_contains($key, "Bearer ")) {
                throw new UnauthorizedException();
            }

            // strip "Bearer" from header value
            $key = substr($key, 7);

            $conn = $this->em->getConnection();
            $sql = "
                SELECT `key`
                FROM `auth`
                WHERE `prefix` = :prefix
            ";
            $stmt = $conn->prepare($sql);
            $result = $stmt->executeQuery([
                "prefix" => substr($key, 0, 7)
            ]);
            $auth = $result->fetchAllAssociative();

            if (!$auth || count($auth) === 0 || !password_verify($key, $auth[0]["key"])) {
                throw new UnauthorizedException();
            }
        }
    }
}