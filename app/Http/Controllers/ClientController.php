<?php

namespace App\Http\Controllers;

use App\Actions\Authenticate\GetAuthenticatedUserAction;
use App\Actions\Paginate\GetPaginatePropsFromRequestAction;
use App\Dto\Client\Factories\CreateCreateDtoFactory;
use App\Http\Requests\Client\StoreRequest;
use App\Models\Passport\Client;
use App\Repositories\ClientRepository;
use App\Services\Client\ClientService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(
        private readonly ClientService              $service,
        private readonly ClientRepository           $repository,
        private readonly GetAuthenticatedUserAction $getAuthenticatedUserAction,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, GetPaginatePropsFromRequestAction $getPaginateProps): View
    {
        $paginateProps = $getPaginateProps($request);

        return view('pages.client.index', [
            'clients' => $this->repository->getWithPaginate(
                page: $paginateProps->page,
                perPage: $paginateProps->perPage,
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.client.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $client = $this->service->store(
            ($this->getAuthenticatedUserAction)(),
            CreateCreateDtoFactory::fromRequest($request),
        );

        return redirect()
            ->route('clients.show', ['client' => $client->id])
            ->with('success', __('clients.messages.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view('pages.client.show', [
            'client' => $client,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('pages.client.edit', [
            'client' => $client,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Client $client)
    {
        $client = $this->service->update(
            $client,
            CreateCreateDtoFactory::fromRequest($request),
        );

        return redirect()
            ->route('clients.show', ['client' => $client->id])
            ->with('success', __('clients.messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client): RedirectResponse
    {
        $this->service->destroy($client);

        return back()->with('success', __('clients.messages.deleted'));
    }
}
