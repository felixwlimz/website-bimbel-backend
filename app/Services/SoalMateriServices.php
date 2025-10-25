<?php

namespace App\Services;

use App\Repositories\QuestionRepository;
use App\Repositories\MaterialRepository;
use Illuminate\Http\Request;

class SoalMateriServices
{


    protected QuestionRepository $questionRepository;
    protected MaterialRepository $materialRepository;

    public function __construct(QuestionRepository $questionRepository, MaterialRepository $materialRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->materialRepository = $materialRepository;
    }

    public function getAllQuestions()
    {
        return $this->questionRepository->findAll();
    }

    public function getQuestionById($id)
    {
        return $this->questionRepository->find($id);
    }

    public function addNewQuestion(Request $request)
    {
        $validated = $request->validate([
            'judulSoal'     => 'required|string|min:3',
            'jenisSoal'     => 'required|in:teks,gambar,audio',
            'isiSoal'       => 'required|string|min:10',
            'pembahasan'    => 'required|string|min:10',
            'subMateri'     => 'required|string|min:3',
            'jawabanBenar'  => 'required|string',
            'package_id'    => 'required|exists:packages,id',
            'bobot'         => 'required|integer|min:1',
            'mediaSoal'     => 'nullable|string',
        ]);

        return $this->questionRepository->create($validated);
    }


    public function addNewMaterial(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3',
            'drive_link'   => 'required|string|min:10',
            'harga'  => 'required|numeric|min:10',   
            'package_id'    => 'required|exists:packages,id',
        ]);

        return $this->materialRepository->create([
            'title' => $validated['title'],
            'drive_link'   => $validated['drive_link'],
            'harga'  => $validated['harga'],
            'preview'  => false,
            'package_id'    => $validated['package_id'],
        ]);
    }

    public function getAllMaterials()
    {
        return $this->materialRepository->findAll();
    }

    public function deleteQuestion($id)
    {
        return $this->questionRepository->delete($id);
    }
}
