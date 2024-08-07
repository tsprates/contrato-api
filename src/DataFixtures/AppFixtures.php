<?php

namespace App\DataFixtures;

use App\Entity\Clausula;
use App\Entity\Contratado;
use App\Entity\Contratante;
use App\Entity\Contrato;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Faker\Core\DateTime as CoreDateTime;
use IntlDateFormatter;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create("pt_BR");

        for ($i = 0; $i < 3; $i += 1) {
            $this->loadFixture($manager, $faker);
        }
    }

    private function loadFixture(ObjectManager $manager, $faker)
    {
        $contrato = new Contrato();
        $contrato->setData($this->randomDate($faker));
        $contrato->setImagem("http://localhost/uploads/exemplo.jpg");

        $contratado = new Contratado();
        $contratado->setNome($faker->name());
        $contratado->setRg($faker->rg());
        $contratado->setCpfCnpj($faker->cpf());
        $contratado->setCep($faker->postcode());
        $contratado->setRua($faker->streetAddress());
        $contratado->setBairro($faker->name());
        $contratado->setCidade($faker->city());
        $contratado->setEstado($faker->state());
        $manager->persist($contratado);
        $contrato->setContratado($contratado);

        $contratante = new Contratante();
        $contratante->setNome($faker->name());
        $contratante->setRg($faker->rg());
        $contratante->setCpfCnpj($faker->cpf());
        $contratante->setCep($faker->postcode());
        $contratante->setRua($faker->streetAddress());
        $contratante->setBairro($faker->name());
        $contratante->setCidade($faker->city());
        $contratante->setEstado($faker->state());
        $manager->persist($contratante);
        $contrato->setContratante($contratante);


        for ($i = 0; $i < 3; $i += 1) {
            $clausula = new Clausula();
            $clausula->setTexto($faker->paragraph());
            $manager->persist($clausula);
            $contrato->addClausula($clausula);
        }

        $manager->persist($contrato);
        $manager->flush();
    }

    private function randomDate($faker)
    {
        $formatter = new IntlDateFormatter(
            'pt_BR',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'America/Sao_Paulo',
            IntlDateFormatter::GREGORIAN
        );
        return $formatter->format($faker->dateTime());
    }
}
