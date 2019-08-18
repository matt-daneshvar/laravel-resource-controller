<?php

namespace MattDaneshvar\ResourceController;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class ResourceController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * The resource model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model = null;

    /**
     * The resource class name.
     *
     * @var string
     */
    protected $resource = '';

    /**
     * The resource name in lower case.
     *
     * @var string
     */
    protected $resourceName = null;

    /**
     * The number of models to return for pagination.
     *
     * @var int|null
     */
    protected $perPage = 20;

    /**
     * Path to all views for this controller (dot-separated path from views directory).
     *
     * @var string
     */
    protected $viewsPath = null;

    /**
     * Views for different resource actions.
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
     * Validation rules for store action.
     *
     * @var array
     */
    protected $storeRules = null;

    /**
     * Validation rules for update action.
     *
     * @var array
     */
    protected $updateRules = null;

    /**
     * Get view for the specified action.
     *
     * @param $action
     *
     * @return \Illuminate\Contracts\View\View
     */
    protected function getViewByAction($action)
    {
        return view(isset($this->views[$action]) ? $this->views[$action] : $this->viewsPath.'.'.$action);
    }

    /**
     * ResourceController constructor.
     */
    public function __construct()
    {
        //Set model.
        $this->model = new $this->resource();

        //Set resource name.
        $this->resourceName = $this->resourceName ?? strtolower(class_basename($this->resource));

        //Set views default path.
        if ($this->viewsPath === null) {
            $this->viewsPath = str_plural($this->resourceName);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        if ($this->perPage) {
            $items = $this->model->paginate($this->perPage);
        } else {
            $items = $this->model->all();
        }

        return $this->getViewByAction('index')->with([str_plural($this->resourceName) => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return $this->getViewByAction('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
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
     * @param  int|string $key
     * @return \Illuminate\Contracts\View\View
     */
    public function show($key)
    {
        $item = $this->findOrFail($key);

        return $this->getViewByAction('show')->with([$this->resourceName => $item]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int|string $key
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($key)
    {
        $item = $this->findOrFail($key);

        return $this->getViewByAction('edit')->with([$this->resourceName => $item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int|string $key
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($key, Request $request)
    {
        $rules = isset($this->updateRules) ? $this->updateRules : $this->rules;

        $this->validate($request, $rules);

        $item = $this->findOrFail($key);

        $item->update($request->all());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int|string $key
     * @return \Illuminate\Http\Response
     */
    public function destroy($key)
    {
        $item = $this->findOrFail($key);

        $item->delete();

        return back();
    }

    /**
     * Find model based on the specified route key name.
     *
     * @param string $key
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function findOrFail($key)
    {
        return $this->model->where($this->model->getRouteKeyName(), $key)->firstOrFail();
    }
}
