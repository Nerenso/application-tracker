<?php

namespace App\Traits;

use App\Models\JobListing;
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

    $this->waitForRunToFinish($thread, $run);

    $this->processRunFunctions($thread, $run);

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


  public function getStructuredJobListing($listing_text)
  {
    // $assistant_id = "asst_tPXjvRShRHdu9AU3l9ytupNU";
    $assistant_id = "asst_aoAQKkoY9jr38ArRSrwRccLD";

    $thread =  OpenAI::threads()->create([]);

    $message = OpenAI::threads()->messages()->create(threadId: $thread->id, parameters: [
      "role" => "user",
      "content" => $listing_text,
    ]);

    $run = OpenAI::threads()->runs()->create(threadId: $thread->id, parameters: [
      "assistant_id" => $assistant_id
    ]);

    $run = $this->waitForRunToFinish($thread, $run);

    $run = $this->processRunFunctions($thread, $run);

    $messages = OpenAI::threads()->messages()->list(threadId: $thread->id, parameters: [
      "order" => 'desc',
      "limit" => 10,
    ]);

    $messagesData = $messages->data;

    // dd(json_decode($messagesData[0]->content[0]->text->value));
    // dd($messagesData[0]->content[0]->text->value);

    return $messagesData[0]->content[0]->text->value;
  }

  public function getCoverLetter(string $content, string $listing_language)
  {
    $nl_assistant_id = "asst_Dxd2z3bYO0TNRrjBXZ9nPBAx";
    $eng_assistant_id = "asst_n5ho45uUH2lclngcTuqFOaeT";

    $assistant_id = ($listing_language == "nl") ? $nl_assistant_id : $eng_assistant_id;

    $thread =  OpenAI::threads()->create([]);

    $message = OpenAI::threads()->messages()->create(threadId: $thread->id, parameters: [
      "role" => "user",
      "content" => $content,
    ]);

    $run = OpenAI::threads()->runs()->create(threadId: $thread->id, parameters: [
      "assistant_id" => $assistant_id
    ]);

    $run = $this->waitForRunToFinish($thread, $run);

    $run = $this->processRunFunctions($thread, $run);

    $messages = OpenAI::threads()->messages()->list(threadId: $thread->id, parameters: [
      "order" => 'desc',
      "limit" => 10,
    ]);

    $messagesData = $messages->data;

    return $messagesData[0]->content[0]->text->value;
  }


  private function waitForRunToFinish($thread, $run)
  {
    while ($run->status == "queued" || $run->status == "in_progress") {
      $run = OpenAI::threads()->runs()->retrieve(threadId: $thread->id, runId: $run->id);
      sleep(2);
    }

    return $run;
  }

  private function processRunFunctions($thread, $run)
  {
    while ($run->status == "requires_action" && $run->requiredAction->type == "submit_tool_outputs") {
      $toolCalls = $run->requiredAction->submitToolOutputs->toolCalls;
      $toolOutputs = [];

      // dd($run);

      //dd($toolCalls[0]->function->arguments);

      $run = OpenAI::threads()->runs()->submitToolOutputs(threadId: $run->threadId, runId: $run->id, parameters: [
        'tool_outputs' => [
          [
            "tool_call_id" => $toolCalls[0]->id,
            "output" => $toolCalls[0]->function->arguments
          ]
        ]
      ]);

      $run = $this->waitForRunToFinish($thread, $run);
    }

    return $run;
  }
}
