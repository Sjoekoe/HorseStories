<?php
namespace EQM\Http\Controllers\Statuses;

use EQM\Http\Controllers\Controller;
use EQM\Models\Statuses\Requests\PostStatus;
use EQM\Models\Statuses\Status;
use EQM\Models\Statuses\StatusCreator;
use EQM\Models\Statuses\StatusRepository;

class StatusController extends Controller
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    public function __construct(StatusRepository $statuses)
    {
        $this->statuses = $statuses;
    }

    public function store(PostStatus $request, StatusCreator $creator)
    {
        $creator->create($request->all());

        session()->put('success', 'Status has been posted');

        return redirect()->refresh();
    }

    public function show(Status $status)
    {
        return view('statuses.show', compact('status'));
    }

    public function edit(Status $status)
    {
        $this->authorize('edit-status', $status);

        return view('statuses.edit', compact('status'));
    }

    public function update(PostStatus $request, Status $status)
    {
        $this->authorize('edit-status', $status);

        $this->statuses->update($status, $request->all());

        return redirect()->route('home');
    }

    public function delete(Status $status)
    {
        $this->authorize('delete-status', $status);

        $status->delete();

        return redirect()->back();
    }
}
