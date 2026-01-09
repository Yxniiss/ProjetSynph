<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AsCommand(name: 'app:send-test-mail', description: 'Envoie un email de test via le service Mailer')]
class SendTestMailCommand extends Command
{

    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        parent::__construct();
        $this->mailer = $mailer;
    }

    protected function configure(): void
    {
        $this->setDescription('Envoie un email de test via le service Mailer');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = (new Email())
            ->from('test@example.com')
            ->to('drif8907@gmail.com')
            ->subject('Test mail depuis Symfony')
            ->text('Ceci est un email de test envoyé depuis la commande app:send-test-mail.');

        try {
            $this->mailer->send($email);
            $io->success('Email envoyé (ou transmis au transport).');
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $io->error('Échec envoi : ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
