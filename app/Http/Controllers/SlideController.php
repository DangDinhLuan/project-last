<?php

namespace App\Http\Controllers;

use App\Slide;
use App\Http\Requests\SlideRequest;
use App\Repositories\Repository;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Images;
use Illuminate\Support\Facades\Response;

class SlideController extends Controller
{
    protected $SlideModel;

    public function __construct(Slide $SlideModel)
    {
        $this->SlideModel = new Repository($SlideModel);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slides = $this->SlideModel->all();

        return view('admin.slide_list', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlideRequest $request)
    {

        $image = $request->file('image');

        $filename = $request->name . '_' . $image->getClientOriginalName();

        $path = public_path(config('asset.image_path.slide') . $filename);

        $slide = $this->SlideModel->create([
            'name' => $request->name,
            'image' => $filename,

        ]);
        Images::make($image->getRealPath())->resize(1349, 759)->save($path);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $slide = Slide::findOrFail($id);

        return response($slide, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SlideRequest $request, $id)
    {
        if (Auth::user()->role_id == 2) {
            return Response::json(__('You are not admin'), 403);
        }
        $this->SlideModel->update([
            'name' => $request->name,

        ], $id);

        $slide = Slide::findOrFail($id);
        $image = $request->file('image');

        if ($image != null) {

            $filename = $request->name . '_' . $image->getClientOriginalName();

            $path = public_path('images/Slides/' . $filename);

            Images::make($image->getRealPath())->resize(1349, 759)->save($path);
            $slide->image = $filename;
            $slide->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->role_id == 2) {
            return Response::json(__('You are not admin'), 403);
        }

       $this->SlideModel->delete($id);
    }

    public function getAllData()
    {
        $Slides = Slide::with(['images' => function ($query) {
            $query->where('active', 1)->get();
        }])->with('category')->get();

        return Datatables::of($Slides)->make(true);
    }

    public function getCategorySelect()
    {
        $slide = Slide::get();

        return datatables($slide)->make(true);
    }
}
