<?php

namespace Feierstoff\ToolboxBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand("toolbox:generate-key")]
class GenerateKeyCommand extends Command {
    public function __construct(
        private EntityManagerInterface $em
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $conn = $this->em->getConnection();

        $unique = false;
        $key = "";
        $prefix = "";
        while (!$unique) {
            // generate a random key and convert it to a base64 string
            $key = urlencode(base64_encode(random_bytes(32)));
            $prefix = substr($key, 0, 7);

            // check if the key already exists
            $sql = "SELECT `id` FROM `auth` WHERE `prefix` = :prefix";
            $stmt = $conn->prepare($sql);
            $result = $stmt->executeQuery([
                "prefix" => $prefix
            ]);
            $auth = $result->fetchAllAssociative();

            // if the key does not exist, we can use it
            if (count($auth) === 0) {
                $unique = true;
            }
        }

        $sql = "
            INSERT INTO `auth` (`prefix`, `key`)
            VALUES (:prefix, :key)
        ";

        $stmt = $conn->prepare($sql);
        $stmt->executeQuery([
            "prefix" => $prefix,
            "key" => password_hash($key, PASSWORD_BCRYPT)
        ]);

        // output the key
        $output->writeln($key);

        return Command::SUCCESS;
    }
}