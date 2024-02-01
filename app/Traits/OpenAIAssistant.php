<?php

namespace App\Traits;

use OpenAI\Laravel\Facades\OpenAI;

trait OpenAIAssistant
{

  public function getAssistantResponse(String $detected_language, String $listing_text,)
  {
    $assistant_id_NL = "asst_cbceKaTq8qhBeWuWpuDb8B5i";
    $assistant_id_ENG = "asst_lAhxuxqaMkPzwcwY6PTHKM8l";

    $thread = OpenAI::threads()->create([]);

    $message = OpenAI::threads()->messages()->create(threadId: $thread->id, parameters: [
      "role" => "user",
      "content" => $listing_text
    ]);

    $run = null;

    if ($detected_language == "nl") {
      $run = OpenAI::threads()->runs()->create(threadId: $thread->id, parameters: [
        "assistant_id" => $assistant_id_NL
      ]);
    } else {
      $run = OpenAI::threads()->runs()->create(threadId: $thread->id, parameters: [
        "assistant_id" => $assistant_id_ENG
      ]);
    }

    while ($run->status == "queued" || $run->status == "in_progress") {
      $run = OpenAI::threads()->runs()->retrieve(threadId: $thread->id, runId: $run->id);
      sleep(2);
    }

    $messages = OpenAI::threads()->messages()->list(threadId: $thread->id, parameters: [
      "order" => 'desc',
      "limit" => 10,
    ]);

    $messagesData = $messages->data;

    return $messagesData[0]->content[0]->text->value;
  }


  public function getJobTitle($listing_text)
  {
    $assistant_job_title_extractor = "asst_6b4BdzXc9uOgHEM7IaBf33Df";

    $thread = OpenAI::threads()->create([]);

    $message = OpenAI::threads()->messages()->create(threadId: $thread->id, parameters: [
      "role" => "user",
      "content" => $listing_text
    ]);

    $run = OpenAI::threads()->runs()->create(threadId: $thread->id, parameters: [
      "assistant_id" => $assistant_job_title_extractor
    ]);

    $run = $this->waitForRunToFinish($thread, $run);

    $messages = OpenAI::threads()->messages()->list(threadId: $thread->id, parameters: [
      "order" => 'desc',
      "limit" => 10,
    ]);

    $messagesData = $messages->data;

    return $messagesData[0]->content[0]->text->value;
  }

  // public function getAssistantResponse(String $detected_language, String $listing_text,)
  // {
  //   $assistant_id_NL = "asst_cbceKaTq8qhBeWuWpuDb8B5i";
  //   $assistant_id_ENG = "asst_lAhxuxqaMkPzwcwY6PTHKM8l";
  //   $assistant_cover_letter_writer_NL = "asst_Dxd2z3bYO0TNRrjBXZ9nPBAx";

  //   $template_resume = "VICI KAHN
  //   PHP DEVELOPER
  //   I N F O R M A T I E
  //   ADRES
  //   Stationsstraat 53, Utrecht, 2434
  //   AB
  //   TELEFOON
  //   06-81159877
  //   E-MAIL
  //   email@voorbeeld.com
  //   GEBOORTEPLAATS
  //   Haarlem
  //   NATIONALITEIT
  //   Nederlandse
  //   V A A R D I G H E D E N
  //   Analytisch
  //   Kritisch
  //   Nauwkeurig
  //   Resultaatgericht
  //   Unit tests
  //   PHP (OOP) en MySQL
  //   (ORM)
  //   OTAP
  //   Symfony3
  //   H O B B Y ' S
  //   Voetbal, darten, goede
  //   gesprekken en lezen
  //   S O C I A L
  //   Linkedin
  //   P R O F I E L
  //   Wij noemen Hans niet voor niets Code quality - Tom, IT for You
  //   W E R K E R V A R I N G
  //   PHP Developer, IT for You Amersfoort
  //   Feb 2017 — Heden
  //   Als PHP dveloper programmeer en implementeer ik programma’s, applicaties,
  //   websites en andere webtoepassingen.
  //   • Nieuwe functionaliteiten bedenken en ontwikkelen
  //   • Technologie die gebruikt wordt door de applicaties perfectioneren
  //   • Meedenken over commerciële verbeteringen
  //   • Meewerken aan de ontwikkeling en verbetering van de online omgeving voor
  //   klanten
  //   • Samenwerken met back-enders, front-enders, scrum-masters en testers
  //   • Werken volgens Scrum en de Scrum-methodieken
  //   • Ervaring met Laravel
  //   • Kennis van HTML(5), CSS(3) en JS
  //   • Kennis van Vue.js
  //   • Verantwoordelijk voor het technisch support en bug-x es'
  //   • Code optimalisatie en performance verbeteringen van bestaande
  //   functionaliteiten
  //   • Advies geven voor verbetering
  //   • Best practices implementeren
  //   Meedenken over het hele project, van de uitwerking tot het uitrollen, vind ik het
  //   leukste om te doen
  //   PHP Developer, IT Strategie Utrecht
  //   Sep 2013 — Feb 2017
  //   • Uitwerken van functionele wensen naar technische oplossingen
  //   • Schrijven van unit en integratietesten
  //   • Technische ontwikkelingen in de gaten houden
  //   • E perimenteren met nieuwe mogelijkheden
  //   • Collega&s op de hoogte brengen van nieuwe do&s G don&ts
  //   • Collega’s coachen
  //   • Klanten advies geven
  //   O P L E I D I N G
  //   Technische Informatica, Erasmus Universiteit
  //   Sep 2007 — Jul 2013
  //   VWO diploma, De Hoekse Berg Woerden
  //   Sep 2007 — Jun 2012
  //   C U R S U S S E N
  //   Continuous Integration, Strategic IT
  //   Sep 2018 — Okt 2018
  //   Microservice Architectures, IT & IT
  //   Mei 2017 — Mei 2017";

  //   $thread = OpenAI::threads()->create([]);

  //   $message = OpenAI::threads()->messages()->create(threadId: $thread->id, parameters: [
  //     "role" => "user",
  //     "content" => $listing_text
  //   ]);

  //   $run = null;

  //   if ($detected_language == "nl") {
  //     $run = OpenAI::threads()->runs()->create(threadId: $thread->id, parameters: [
  //       "assistant_id" => $assistant_id_NL
  //     ]);
  //   } else {
  //     $run = OpenAI::threads()->runs()->create(threadId: $thread->id, parameters: [
  //       "assistant_id" => $assistant_id_ENG
  //     ]);
  //   }

  //   $run = $this->waitForRunToFinish($thread, $run);

  //   $messages = OpenAI::threads()->messages()->list(threadId: $thread->id, parameters: [
  //     "order" => 'desc',
  //     "limit" => 10,
  //   ]);

  //   $messagesData = $messages->data;

  //   $listing_summary = $messagesData[0]->content[0]->text->value;

  //   $cover_letter_request_prompt = OpenAI::threads()->messages()->create(threadId: $thread->id, parameters: [
  //     "role" => "user",
  //     "content" => "vacature samenvatting: {$listing_summary}
  //     notities: - Award winning website gebouwd voor een internationaal bedrijf met behulp van Laravel, PHP, VueJS, GSAP, Pinia en TailwindCss.
  //     - Werk graag aan projecten die de wereld beter maken, zoals het tegen gaan van klimaatverandering.
  //     CV: {$template_resume}
  //     "
  //   ]);

  //   $run = OpenAI::threads()->runs()->create(threadId: $thread->id, parameters: [
  //     "assistant_id" => $assistant_cover_letter_writer_NL
  //   ]);

  //   $run = $this->waitForRunToFinish($thread, $run);

  //   $messages = OpenAI::threads()->messages()->list(threadId: $thread->id, parameters: [
  //     "order" => 'desc',
  //     "limit" => 10,
  //   ]);

  //   $messagesData = $messages->data;

  //   dd($messagesData);
  // }


  private function waitForRunToFinish($thread, $run)
  {
    while ($run->status == "queued" || $run->status == "in_progress") {
      $run = OpenAI::threads()->runs()->retrieve(threadId: $thread->id, runId: $run->id);
      sleep(2);
    }

    return $run;
  }
}
