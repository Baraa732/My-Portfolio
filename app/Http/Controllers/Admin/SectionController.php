<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SectionController extends Controller
{
    /**
     * Get all sections for the admin dashboard
     */
    public function index(): JsonResponse
    {
        try {
            $sections = Section::orderBy('order', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($sections);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch sections',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific section
     */
    public function show($id): JsonResponse
    {
        try {
            $section = Section::findOrFail($id);
            return response()->json($section);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Section not found',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Create a new section
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'type' => 'required|string|in:hero,about,skills,projects,contact,custom',
                'order' => 'integer|min:0',
                'background_color' => 'nullable|string|max:7',
                'text_color' => 'nullable|string|max:7',
                'is_active' => 'boolean',
                'show_in_nav' => 'boolean',
            ]);

            $section = Section::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Section created successfully',
                'data' => $section
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create section',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a section
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $section = Section::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'title' => 'sometimes|required|string|max:255',
                'content' => 'nullable|string',
                'type' => 'sometimes|required|string|in:hero,about,skills,projects,contact,custom',
                'order' => 'sometimes|integer|min:0',
                'background_color' => 'nullable|string|max:7',
                'text_color' => 'nullable|string|max:7',
                'is_active' => 'sometimes|boolean',
                'show_in_nav' => 'sometimes|boolean',
            ]);

            $section->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Section updated successfully',
                'data' => $section
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update section',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a section
     */
    public function destroy($id): JsonResponse
    {
        try {
            $section = Section::findOrFail($id);
            $section->delete();

            return response()->json([
                'success' => true,
                'message' => 'Section deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete section',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get dashboard statistics
     */
    public function dashboardData(): JsonResponse
    {
        try {
            $stats = [
                'total_projects' => \App\Models\Project::count(),
                'active_skills' => \App\Models\Skill::where('is_active', true)->count(),
                'unread_messages' => \App\Models\Message::where('is_read', false)->count(),
                'total_sections' => Section::count(),
                'active_sections' => Section::where('is_active', true)->count(),
            ];

            return response()->json(['stats' => $stats]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch dashboard data',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
