<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Words;
use App\Models\Topic;
use App\Models\WordLevel;
use App\Models\LOG;

class ImportExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $row;
    protected $user_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($row, $user_id)
    {
      $this->row = $row;
      $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
        $row = $this->row;
        \DB::beginTransaction();
        $topic = $this->getTopic(trim($row[0]));
        if (!$topic) {
            $topic = Topic::create([
            'topic_name_vi' => trim($row[0])
            ]);
        }
        if (($topic) && ($wordLevel = $this->getWordLevel($row[8]))) {
            $topic_id = $topic->id;
            $word_level_id = $wordLevel->id;
            $word = Words::where('word_name_vi', $row[1])->first();
            if (!$word) {
            Words::create([
                'topic_id' => $topic_id,
                'user_id' => $this->user_id,
                'word_name_vi' => $row[1],
                'photo' => $row[2],
                'audio_vi' => $row[3],
                'related_words_vi' => $row[4],
                'antonym_vi' => $row[5],
                'function_vi' => $row[6],
                'material_vi' => $row[7],
                'is_system' => 1,
                'level_id' => $word_level_id
            ]);
            }
        }
        \DB::commit();
        } catch (\Exception $e) {
        \DB::rollback();
        LOG::logRequest($e);
        }
    }

    function getTopic($name)
  {
    $topic = Topic::where('topic_name_vi', $name)->first();
    if ($topic) {
      return $topic;
    }
    return false;
  }

  function getWordLevel($name)
  {
    $wordLevel = WordLevel::where('name_en', 'like', '%Level '.$name.'%')->first();
    if ($wordLevel) {
      return $wordLevel;
    }
    return false;
  }
}
