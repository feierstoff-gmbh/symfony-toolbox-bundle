<?php

namespace Feierstoff\ToolboxBundle\Entity\Interface;

interface AuthEntityInterface {
    public function getId(): ?int;
    public function getPrefix(): ?string;
    public function setPrefix(string $prefix): self;
    public function getKey(): ?string;
    public function setKey(string $key): self;
}