<?php

namespace Four13\ResourceController;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

abstract class ResourceController extends Controller
{
    protected $model,
        $name,
        $viewsPath,
        $itemsPerPage = 20;

    abstract protected function newModel();

    protected function rules()
    {
        return [];
    }

    public function __construct()
    {
        $this->model = $this->newModel();
        $this->name = strtolower(class_basename(get_class($this->model)));
        $this->plural = str_plural(strtolower($this->name));
        $this->viewsPath = $this->plural;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->model->paginate($this->itemsPerPage);

        return view($this->viewsPath . '.' . 'index', [$this->plural => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->viewsPath . '.' . 'create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules());

        $this->model->create($request->all());

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = $this->model->findOrFail($id);

        return view($this->viewsPath . '.' . 'show', [$this->name => $item]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->model->findOrFail($id);

        return view($this->viewsPath . '.' . 'edit', [$this->name => $item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules());

        $item = $this->model->findOrFail($id);

        $item->update($request->all());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = $this->model->findOrFail($id);

        $item->delete();
    }
}
