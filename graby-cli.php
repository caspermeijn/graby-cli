#!/usr/bin/env php
<?php
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;
use Symfony\Component\Console\Command\Command;

use Symfony\Component\Console\Application;

$application = new Application('graby-cli', '1.0.0');

$application->register('download-as-html-page')
    ->addArgument('url', InputArgument::REQUIRED)
    ->setCode(function (InputInterface $input, OutputInterface $output): int {
      $url = $input->getArgument('url');

      $graby = new \Graby\Graby();
      $result = $graby->fetchContent($url);

      $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
      $twig = new \Twig\Environment($loader);

      echo $twig->render('html-page.html', $result);

      return Command::SUCCESS;
  });

$application->run();
