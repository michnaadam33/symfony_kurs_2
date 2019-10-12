<?php

namespace App\Command;

use App\Entity\Visit;
use App\Repository\VisitRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Twig\Template;
use Twig\TemplateWrapper;

class NewVisitCommand extends Command
{
    protected static $defaultName = 'app:next-visit';

    private $visitRepository;

    private $mailer;

    private $twig;

    public function __construct(VisitRepository $visitRepository, \Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        parent::__construct();
        $this->visitRepository = $visitRepository;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }
    protected function configure()
    {
        $this
            ->setDescription('Next visit notification');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $visits = $this->visitRepository->findForNextVisit(new \DateTime());

        /** @var Visit $visit */
        foreach ($visits as $visit){
            $message = (new \Swift_Message('Hello Email'))
                ->setTo($visit->getPatient()->getEmail())
                ->setBody(
                    $this->twig->render('email/next-visit.html.twig', ['visit' => $visit])
                )
            ;
            $this->mailer->send($message);
        }

        $io->success(sprintf('Success send %d emails', count($visits)));
    }
}
