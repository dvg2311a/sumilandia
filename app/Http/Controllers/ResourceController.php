<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Resource;
use App\Http\Requests\ResourceRequest;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ResourceController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Resource::class);
        $resources = Resource::with('unit')->paginate(10);
        return Inertia::render('Resources/Index', [
            'resources' => $resources
        ]);
    }

    public function show(Resource $resource)
    {
        $this->authorize('view', $resource);
        $resource->load('unit');
        return Inertia::render('Resources/Show', [
            'resource' => $resource
        ]);
    }

    public function store(ResourceRequest $request)
    {
        $this->authorize('create', Resource::class);
        $data = $request->validated();
        if ($request->hasFile('file_path')) {
            $data['file_path'] = $request->file('file_path')->store('resources', 'public');
        }
        Resource::create($data);
        return redirect()->route('resources.index')->with('success', 'Recurso creado correctamente');
    }

    public function update(ResourceRequest $request, Resource $resource)
    {
        $this->authorize('update', $resource);
        $data = $request->validated();
        if ($request->hasFile('file_path')) {
            $data['file_path'] = $request->file('file_path')->store('resources', 'public');
        }
        $resource->update($data);
        return redirect()->route('resources.index')->with('success', 'Recurso actualizado correctamente');
    }

    public function destroy(Resource $resource)
    {
        $this->authorize('destroy', $resource);
        $resource->delete();
        return redirect()->route('resources.index')->with('success', 'Recurso eliminado correctamente');
    }

    public function download(Resource $resource)
    {
        $this->authorize('download', $resource);
        return response()->download(storage_path('app/public/' . $resource->file_path));
    }
}
