<?php

namespace App\Http\Controllers;

use App\Models\PetForm;
use Illuminate\Http\Request;

class PetFormController extends Controller
{
    public function index()
    {
        $pets = PetForm::all();
        return response()->json($pets);
    }
    /**
     * Создание новой записи.
     */
    public function store(Request $request)
    {
        // Валидация входных данных
        // return "ool";

        $validatedData = $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'chipset' => 'required|string|max:255',
            'check_id' => 'required|integer',
            'pet_name' => 'required|string|max:255',
            'pet_type' => 'required|string|max:255',
            'pet_family_type' => 'required|string|max:255',
            'pet_region' => 'required|string|max:255',
            'pet_country' => 'required|string|max:255',
            'pet_city' => 'required|string|max:255',
            'pet_street' => 'required|boolean',
            'iin' => 'required|string|max:255',
            'reg_date' => 'required|string|max:255',
            'gr' => 'required|integer',
            'mm' => 'required|integer',
            'old_year' => 'required|integer',
            'old_month' => 'required|integer',
            'comment' => 'nullable|string',
            'other_comment' => 'nullable|string',
        ]);

        // Обработка загрузки файла
        if ($request->hasFile('photo')) {
            $fileName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads/pets'), $fileName);
            $validatedData['photo'] = 'uploads/pets/' . $fileName;
        }


        // Создание новой записи
        $petForm = PetForm::create($validatedData);

        return response()->json($petForm, 201);
    }

    /**
     * Обновление существующей записи.
     */
    public function update(Request $request, $id)
    {
        // Валидация входных данных
        $validatedData = $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'chipset' => 'required|string|max:255',
            'check_id' => 'required|integer',
            'pet_name' => 'required|string|max:255',
            'pet_type' => 'required|string|max:255',
            'pet_family_type' => 'required|string|max:255',
            'pet_region' => 'required|string|max:255',
            'pet_country' => 'required|string|max:255',
            'pet_city' => 'required|string|max:255',
            'pet_street' => 'required|boolean',
            'iin' => 'required|string|max:255',
            'reg_date' => 'required|string|max:255',
            'gr' => 'required|integer',
            'mm' => 'required|integer',
            'old_year' => 'required|integer',
            'old_month' => 'required|integer',
            'comment' => 'nullable|string',
            'other_comment' => 'nullable|string',
        ]);

        // Поиск записи по ID
        $petForm = PetForm::findOrFail($id);

        // Обработка загрузки файла
        if ($request->hasFile('photo')) {
            // Удаление старого файла, если нужно
            if ($petForm->photo && file_exists(public_path($petForm->photo))) {
                unlink(public_path($petForm->photo));
            }

            $fileName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('uploads/pets'), $fileName);
            $validatedData['photo'] = 'uploads/pets/' . $fileName;
        }

        // Обновление записи
        $petForm->update($validatedData);

        return response()->json($petForm, 200);
    }

    /**
     * Удаление записи.
     */
    public function destroy($id)
    {
        // Поиск записи по ID
        $petForm = PetForm::findOrFail($id);

        // Удаление записи
        $petForm->delete();

        return response()->json(null, 204);
    }
}
