<?php
namespace App\Http\Controllers\Utils;
use App\Models\WordLevel;
use App\Models\Words;
use App\Models\StudentWordMap;
use App\Models\GameHistory;
use Carbon\Carbon;
use Config;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Topic;
use App\Models\Transaction;

class WordsUtil
{

    static function getUrlForWords($words)
    {
        foreach ($words as $key => $value) {
            $value->photo = FileManage::getPhotoURL($value->photo);
            $value->audio_vi = FileManage::getAudioURL($value->audio_vi);
            $value->audio_en = FileManage::getAudioURL($value->audio_en);
        }
    }

    static function getWordPropertiesByLanguage($words, $language)
    {
        foreach ($words as $value) {
            $value->word_name = $value['word_name_'.$language];
            $value->audio = $value['audio_'.$language];
            $value->related_words = $value['related_words_'.$language];
            $value->antonym = $value['antonym_'.$language];
            $value->function = $value['function_'.$language];
            $value->material = $value['material_'.$language];
            $value->topic_name = Topic::find($value->topic_id)['topic_name_'.$language];
        }
    }

    static function getLevelInfor($student_id)
    {
        $output = array();
        $studentWord = GameHistory::where('student_id', $student_id)->get();
        $pointConfig = DB::table('point_configuration')->first();
        $point = 0;
        foreach ($studentWord as $value) {
            $point += $value->point;
        }
        $level = 1;
        if($point < $pointConfig->point_to_pass_level_one)
        {
            $level = 1;
        }
        else if($point >= $pointConfig->point_to_pass_level_one && $point <= $pointConfig->point_to_pass_level_two)
        {
            $level = 2;
        } 
        else $level = 3;
        $output['point'] = $point;
        $output['level'] = $level;     
        $output['number_of_questions'] = count($studentWord);        
        return $output;
    }

    static function getWordStores($request, $language)
    {
        $wordStore = WordLevel::get();
        foreach ($wordStore as $value) {
            $value->word_level_photo = FileManage::getPhotoURL($value->word_level_photo);
            $value->quantity = Words::where('level_id', $value->id)
                                    ->when($value->id == 4, function($q) use ($request){
                                        $q->where('user_id', $request->UserID);
                                    })
                                    ->get()->count();
            $value->descriptions = $value['description_'.$language];
            $value->name = $value['name_'.$language];
        }
        return $wordStore;
    }

    static function getAllStudentsByUser($UserID)
    {
        $students = Student::where('user_id', $UserID)->orderBy('id', 'DESC')->get();           
        foreach ($students as $value) {
            $value->quantity = WordsUtil::getNumberOfWordsForStudent($value->id);
            $value->photo = FileManage::getPhotoURL($value->photo);
            $value->level = WordsUtil::getLevelInfor($value->id)['level'];
            $value->isUpdate = 0;
        }
        return $students;
    }

    static function getNumberOfWordsForStudent($student_id)
    {
        return StudentWordMap::where('student_id', $student_id)->get()->count();
    }

    static function getNumberOfWordsForUser($user_id)
    {
        return Words::where('user_id', $user_id)->get()->count();
    }

    static function isMyWord($user_id, $word_id)
    {
        $word = Words::find($word_id);
        if(isset($word) && $word->user_id == $user_id)
        {
            return true;
        }
        return Words::where('user_id', $user_id)
                        ->where('word_system_id', $word_id)                  
                        ->first() != null;
    }

    static function isVip($user_id)
    {
        return Transaction::where('user_id', $user_id)
                        ->where('is_active', 1)                  
                        ->first() != null;
    }

}
