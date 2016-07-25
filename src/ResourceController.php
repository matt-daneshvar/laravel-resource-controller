<?php

namespace Four13\ResourceController;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

abstract class ResourceController extends Controller
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * The Eloquent model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model = null;

    /**
     * The model class name.
     *
     * @var string
     */
    protected $className = '';

    /**
     * The number of models to return for pagination.
     *
     * @var int|null
     */
    protected $perPage = 15;

    /**
     * Path to all views for this controller (dot-separated path from views directory).
     *
     * @var string
     */
    protected $viewsPath = '';

    /**
     * Views for different RESTful verbs.
     *
     * @var array
     */
    protected $views = [];

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Validation rules for store verb.
     *
     * @var array
     */
    protected $storeRules = null;

    /**
     * Validation rules for update verb.
     *
     * @var array
     */
    protected $updateRules = null;

    /**
     * Get a new instance of an Eloquent Model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    abstract protected function newModel();

    /**
     * Get view for the specified verb.
     *
     * @param $verb
     *
     * @return \Illuminate\Contracts\View\View
     */
    protected function getViewByVerb($verb)
    {
        return view(isset($this->views[$verb]) ? $this->views[$verb] : $this->viewsPath . '.' . $verb);
    }

    /**
     * ResourceController constructor.
     */
    public function __construct()
    {
        //Set model
        $this->model = $this->newModel();

        //Set class name
        $this->className = class_basename(get_class($this->model));

        //Set views default path
        if ($this->viewsPath == '') {
            $this->viewsPath = str_plural(strtolower($this->className));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->perPage) {
            $items = $this->model->paginate($this->perPage);
        } else {
            $items = $this->all();
        }

        return $this->getViewByVerb('index')->with([str_plural(strtolower($this->className)) => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->getViewByVerb('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = isset($this->storeRules) ? $this->storeRules : $this->rules;

        $this->validate($request, $rules);

        $this->model->create($request->all());

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = $this->model->findOrFail($id);

        return $this->getViewByVerb('show')->with([strtolower($this->className) => $item]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->model->findOrFail($id);

        return $this->getViewByVerb('edit')->with([strtolower($this->className) => $item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = isset($this->updateRules) ? $this->updateRules : $this->rules;

        $this->validate($request, $rules);

        $item = $this->model->findOrFail($id);

        $item->update($request->all());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = $this->model->findOrFail($id);

        $item->delete();

        return back();
    }
}
