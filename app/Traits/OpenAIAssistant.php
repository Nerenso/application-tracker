<?php

namespace App\Traits;

use OpenAI\Laravel\Facades\OpenAI;


trait OpenAIAssistant
{

  public function testResponse(String $assistantId, String $listing_text)
  {
    $thread = OpenAI::threads()->create([]);

    $message = OpenAI::threads()->messages()->create(threadId: $thread->id, parameters: [
      "role" => "user",
      "content" => $listing_text
    ]);

    $run = OpenAI::threads()->runs()->create(threadId: $thread->id, parameters: [
      "assistant_id" => $assistantId
    ]);

    while ($run->status == "queued" || $run->status == "in_progress") {
      $run = OpenAI::threads()->runs()->retrieve(threadId: $thread->id, runId: $run->id);
      sleep(2);
    }

    $messages = OpenAI::threads()->messages()->list(threadId: $thread->id, parameters: [
      "order" => 'desc',
      "limit" => 10,
    ]);

    $messagesData = $messages->data;

    dd($messagesData[0]->content[0]->text->value);
  }
}
