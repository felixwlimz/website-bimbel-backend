<?php

namespace App\Services;

use App\Models\Package;
use App\Models\Question;
use App\Models\SubTopic;
use Illuminate\Support\Facades\DB;

/**
 * Service untuk manage multiple question sets dalam 1 package
 * Contoh: 1 Package "Matematika" bisa punya 3 question sets:
 * - Set A: Aljabar (10 soal)
 * - Set B: Geometri (10 soal)
 * - Set C: Statistik (10 soal)
 */
class PackageSetService
{
    /**
     * Get all question sets dalam package
     * Dikelompokkan berdasarkan sub_topic_id
     */
    public function getQuestionSets(string $packageId)
    {
        $package = Package::findOrFail($packageId);

        $subTopics = SubTopic::where('package_id', $packageId)
            ->with([
                'questions' => fn ($q) => $q->with('options:id,question_id,key,order')
                    ->orderBy('order')
            ])
            ->get();

        return $subTopics->map(fn ($subTopic) => [
            'id' => $subTopic->id,
            'name' => $subTopic->name,
            'question_count' => $subTopic->questions->count(),
            'total_weight' => $subTopic->questions->sum('weight'),
            'questions' => $subTopic->questions,
        ]);
    }

    /**
     * Create new question set (sub-topic) dalam package
     */
    public function createQuestionSet(string $packageId, string $name): SubTopic
    {
        return DB::transaction(function () use ($packageId, $name) {
            return SubTopic::create([
                'package_id' => $packageId,
                'name' => $name,
            ]);
        });
    }

    /**
     * Add questions ke specific set
     */
    public function addQuestionsToSet(
        string $subTopicId,
        array $questions
    ): void {
        DB::transaction(function () use ($subTopicId, $questions) {
            $subTopic = SubTopic::findOrFail($subTopicId);

            foreach ($questions as $index => $questionData) {
                $question = Question::create([
                    'package_id' => $subTopic->package_id,
                    'sub_topic_id' => $subTopicId,
                    'title' => $questionData['title'],
                    'content' => $questionData['content'],
                    'media_type' => $questionData['media_type'] ?? 'text',
                    'media_path' => $questionData['media_path'] ?? null,
                    'weight' => $questionData['weight'] ?? 1,
                    'explanation' => $questionData['explanation'] ?? null,
                    'order' => $index,
                ]);

                // Add options
                if (isset($questionData['options'])) {
                    foreach ($questionData['options'] as $optionIndex => $option) {
                        $question->options()->create([
                            'key' => $option['key'],
                            'score' => $option['score'] ?? 0,
                            'is_correct' => $option['is_correct'] ?? false,
                            'order' => $optionIndex,
                        ]);
                    }
                }
            }
        });
    }

    /**
     * Get summary: berapa banyak question sets dan total soal
     */
    public function getPackageSummary(string $packageId): array
    {
        $subTopics = SubTopic::where('package_id', $packageId)
            ->withCount('questions')
            ->get();

        return [
            'total_sets' => $subTopics->count(),
            'total_questions' => $subTopics->sum('questions_count'),
            'sets' => $subTopics->map(fn ($st) => [
                'id' => $st->id,
                'name' => $st->name,
                'question_count' => $st->questions_count,
            ]),
        ];
    }
}
