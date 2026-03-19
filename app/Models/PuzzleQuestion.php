<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuzzleQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'puzzle_id',
        'question',
        'question_html',
        'options',
        'correct_answer',
        'incorrect_answers',
        'distractors',
        'explanation',
        'educational_note',
        'fun_fact',
        'image',
        'video_url',
        'metadata',
        'points',
        'order',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'incorrect_answers' => 'array',
        'distractors' => 'array',
        'metadata' => 'array',
        'is_active' => 'boolean',
        'points' => 'integer',
        'order' => 'integer',
    ];

    public function puzzle()
    {
        return $this->belongsTo(Puzzle::class);
    }

    public function getOptionsArrayAttribute()
    {
     
        $options = $this->options;
        
        if (is_string($options)) {
            $decoded = json_decode($options, true);
            $options = is_array($decoded) ? $decoded : [];
        }
      
        if (!is_array($options) || empty($options)) {
            $distractors = $this->distractors;
 
            if (is_string($distractors)) {
                $decoded = json_decode($distractors, true);
                $distractors = is_array($decoded) ? $decoded : [];
            }
            
            $options = array_merge(
                [$this->correct_answer],
                is_array($distractors) ? array_slice($distractors, 0, 3) : []
            );
        }
        
        if (!is_array($options)) {
            $options = [$this->correct_answer];
        }
        
        $options = array_filter($options, function($value) {
            return !is_null($value) && $value !== '';
        });
        
        $options = array_values($options);
        
        shuffle($options);
        return $options;
    }

    public function getFormattedQuestionAttribute()
    {
        return $this->question_html ?? $this->question;
    }

    public function checkAnswer($answer)
    {
        $normalizedAnswer = $this->normalizeAnswer($answer);
        $normalizedCorrect = $this->normalizeAnswer($this->correct_answer);
        
        return $normalizedAnswer === $normalizedCorrect;
    }

    protected function normalizeAnswer($answer)
    {
        if (!is_string($answer)) {
            return '';
        }
        return trim(strtolower(preg_replace('/[^a-z0-9]/i', '', $answer)));
    }

    public function getHintAttribute()
    {
        if (isset($this->metadata['hint']) && is_string($this->metadata['hint'])) {
            return $this->metadata['hint'];
        }
        
        $correctAnswer = is_string($this->correct_answer) ? $this->correct_answer : '';
        
        $words = explode(' ', $correctAnswer);
        foreach ($words as &$word) {
            $length = strlen($word);
            if ($length > 3) {
                $revealCount = floor($length / 3);
                $newWord = '';
                for ($i = 0; $i < $length; $i++) {
                    if ($i < $revealCount || $i >= $length - $revealCount) {
                        $newWord .= $word[$i];
                    } else {
                        $newWord .= '_';
                    }
                }
                $word = $newWord;
            }
        }
        
        return implode(' ', $words);
    }
}