<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SaveTemplate;
use Illuminate\Http\Request;

class SavedTemplateController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST SAVED TEMPLATES
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $templates = SaveTemplate::where('user_id', auth()->id())
            ->where('status', '!=', 'deleted')
            ->latest()
            ->paginate(10);

        return view(
            'frontend.user.templates.saved',
            compact('templates')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view(
            'frontend.user.templates.create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_title' => [
                'required',
                'string',
                'max:255',
            ],

            'template_content' => [
                'nullable',
                'string',
            ],
        ]);


        SaveTemplate::create([
            'user_id' => auth()->id(),

            'template_title' =>
                $validated['template_title'],

            'template_content' =>
                $validated['template_content'] ?? null,

            'session_id' =>
                session()->getId(),

            'status' => 'Active',
        ]);


        return redirect()
            ->route('user.saved-templates.index')
            ->with(
                'success',
                'Template saved successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function show(SaveTemplate $template)
    {
        $this->authorizeTemplate($template);

        return view(
            'frontend.user.templates.show',
            compact('template')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function edit(SaveTemplate $template)
    {
        $this->authorizeTemplate($template);

        return view(
            'frontend.user.templates.edit',
            compact('template')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        SaveTemplate $template
    ) {
        $this->authorizeTemplate($template);


        $validated = $request->validate([
            'template_title' => [
                'required',
                'string',
                'max:255',
            ],

            'template_content' => [
                'nullable',
                'string',
            ],
        ]);


        $template->update([
            'template_title' =>
                $validated['template_title'],

            'template_content' =>
                $validated['template_content'] ?? null,

            'status' => 'Active',
        ]);


        return redirect()
            ->route('user.saved-templates.index')
            ->with(
                'success',
                'Template updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE SINGLE TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function destroy(Request $request)
    {
        $request->validate([
            'template_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'template_ids.*' => [
                'integer',
            ],
        ]);


        $templates = SaveTemplate::where(
                'user_id',
                auth()->id()
            )
            ->whereIn(
                'id',
                $request->template_ids
            )
            ->get();


        foreach ($templates as $template) {

            /*
            |--------------------------------------------------------------------------
            | Soft delete using existing status column
            |--------------------------------------------------------------------------
            */

            $template->update([
                'status' => 'deleted',
            ]);
        }


        return redirect()
            ->route('user.saved-templates.index')
            ->with(
                'success',
                'Selected template(s) deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTIVATE TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function activate(SaveTemplate $template)
    {
        $this->authorizeTemplate($template);

        $template->update([
            'status' => 'Active',
        ]);


        return back()->with(
            'success',
            'Template activated successfully.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DEACTIVATE TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function deactivate(SaveTemplate $template)
    {
        $this->authorizeTemplate($template);

        $template->update([
            'status' => 'Deactive',
        ]);


        return back()->with(
            'success',
            'Template deactivated successfully.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DUPLICATE TEMPLATE
    |--------------------------------------------------------------------------
    */

    public function duplicate(SaveTemplate $template)
    {
        $this->authorizeTemplate($template);


        $copy = $template->replicate();

        $copy->user_id = auth()->id();

        $copy->template_title =
            $template->template_title . ' (Copy)';

        $copy->session_id =
            session()->getId();

        $copy->status = 'Active';

        $copy->save();


        return redirect()
            ->route(
                'user.saved-templates.edit',
                $copy
            )
            ->with(
                'success',
                'Template copied successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | AUTHORIZE TEMPLATE
    |--------------------------------------------------------------------------
    */

    private function authorizeTemplate(
        SaveTemplate $template
    ): void {

        abort_if(
            $template->user_id !== auth()->id(),
            403
        );


        abort_if(
            $template->status === 'deleted',
            404
        );
    }
}