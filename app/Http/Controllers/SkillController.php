<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ActivityLogger;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('order')->get();
        return response()->json($skills);
    }

    public function show($id)
    {
        try {
            $skill = Skill::find($id);

            if (!$skill) {
                return response()->json([
                    'success' => false,
                    'message' => 'Skill not found'
                ], 404);
            }

            return response()->json($skill);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching skill: ' . $e->getMessage()
            ], 500);
        }
    }

    // Add to SkillController.php
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'percentage' => 'required|integer|min:0|max:100',
            'icon' => 'required|string|max:255',
            'is_active' => 'sometimes|boolean',
            'order' => 'sometimes|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();
            $data['is_active'] = $request->has('is_active') ? 1 : 0;
            $data['order'] = $request->get('order', 0);

            $skill = Skill::create($data);
            ActivityLogger::logCreate($skill);

            return response()->json([
                'success' => true,
                'message' => 'Skill added successfully!',
                'skill' => $skill
            ]);
        } catch (\Exception $e) {
            \Log::error('Skill creation error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create skill: ' . $e->getMessage()
            ], 500);
        }
    }



    public function update(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'percentage' => 'required|integer|min:0|max:100',
            'icon' => 'required|string|max:255',
            'is_active' => 'sometimes|in:0,1,on,off', // Accept multiple formats
            'order' => 'sometimes|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->all();

            // Handle checkbox conversion
            if ($request->has('is_active')) {
                $data['is_active'] = $request->is_active === '1' || $request->is_active === 'on' || $request->is_active === true ? 1 : 0;
            } else {
                $data['is_active'] = 0; // Default to inactive if not provided
            }

            $data['order'] = $request->get('order', $skill->order);

            $skill->update($data);
            ActivityLogger::logUpdate($skill);

            return response()->json([
                'success' => true,
                'message' => 'Skill updated successfully!',
                'skill' => $skill
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update skill: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $skill = Skill::find($id);

            if (!$skill) {
                return response()->json([
                    'success' => true,
                    'message' => 'Skill deleted successfully!'
                ]);
            }

            $skillName = $skill->name;
            $skill->delete();
            ActivityLogger::log('delete', "Deleted skill: {$skillName}");

            return response()->json([
                'success' => true,
                'message' => 'Skill deleted successfully!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Skill deletion error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete skill'
            ], 500);
        }
    }
}
