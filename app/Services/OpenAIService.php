<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Events\AiStreamEvent;

class OpenAIService
{

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com',
            'timeout' => 0,
            'read_timeout' => 0,
        ]);
    }

    public function stream($conversationId, $message)
    {
        set_time_limit(0);

        $payload = [
            "model" => "gpt-4.1",

            "stream" => true,

            "input" => [
                 [
                    "role" => "system",
                    "content" => [[
                        "type" => "input_text",
                        "text" => "Jawab HANYA berdasarkan dokumen pada Vector Store. Jangan menggunakan pengetahuan umum atau berasumsi. Jika informasi tidak ditemukan atau pertanyaan di luar materi, jawab: 'Maaf, informasi tersebut tidak tersedia dalam materi yang diunggah.'"
                    ]]
                ],
                [
                    "role" => "user",
                    "content" => [[
                        "type" => "input_text",
                        "text" => $message
                    ]]
                ]
            ],

            "tools" => [[
                "type" => "file_search",
                "vector_store_ids" => [
                    env("OPENAI_VS_ID")
                ]
            ]]
        ];

        $response = $this->client->request(
            'POST',
            '/v1/responses',
            [
                'headers' => [
                    'Authorization' => 'Bearer '.env('OPENAI_API_KEY'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'text/event-stream'
                ],
                'stream' => true,
                'json' => $payload
            ]
        );

        $body = $response->getBody();

        $buffer = '';

        $answer = '';

        while (!$body->eof()) {

            $buffer .= $body->read(1);

            while (($pos = strpos($buffer, "\n\n")) !== false) {

                $event = substr($buffer, 0, $pos);

                $buffer = substr($buffer, $pos + 2);

                $type = '';
                $json = [];

                foreach (explode("\n", $event) as $line) {

                    if (strpos($line, 'event:') === 0) {
                        $type = trim(substr($line, 6));
                    }

                    if (strpos($line, 'data:') === 0) {

                        $data = trim(substr($line, 5));

                        if ($data == '[DONE]') {
                            continue;
                        }

                        $json = json_decode($data, true);
                    }
                }

                if (!$json) {
                    continue;
                }

                switch ($type) {

                    case 'response.output_text.delta':

                        $delta = $json['delta'] ?? '';

                        if ($delta == '') {
                            break;
                        }

                        $answer .= $delta;

                        broadcast(new AiStreamEvent(
                            $conversationId,
                            $delta
                        ));

                        break;

                    case 'response.output_text.done':

                        // if (isset($json['text'])) {

                        //     $answer .= $json['text'];

                        //     broadcast(new AiStreamEvent(
                        //         $conversationId,
                        //         $json['text']
                        //     ));

                        // }

                        break;

                    case 'response.completed':

                        broadcast(new AiStreamEvent(
                            $conversationId,
                            '__COMPLETE__'
                        ));

                        break;
                }

            }

        }

        return $answer;
    }
}