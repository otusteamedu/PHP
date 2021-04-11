<?php


namespace App\Controllers;


use App\Repositories\Film\FilmRepository;
use App\Services\ServiceContainer\AppServiceContainer;

class FilmController extends BaseController
{
    private FilmRepository $filmRepository;

    public function __construct()
    {
        $this->filmRepository = AppServiceContainer::getInstance()->resolve(FilmRepository::class);
    }

    public function index(): string
    {
        $this->title = 'Films';

        $this->content = $this->renderView('pages.films.index', [
            'films' => $this->filmRepository->getAll(),
        ]);

        return $this->viewResponse();
    }

    public function show() : string
    {
        $request = $this->getRequest();
        $film = $this->filmRepository->getById($request->get('id'));

        $this->title = 'Film: ' . $film->getName();

        $this->content = $this->renderView('pages.films.show', [
            'film' => $film,
        ]);

        return $this->viewResponse();
    }

    public function create() : string
    {
        $this->content = $this->renderView('pages.films.form');
        $this->title = 'Create Film';

        return $this->viewResponse();
    }

    public function store() : string
    {
        $request = $this->getRequest();

        $this->filmRepository->insert([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'age_restrict' => $request->get('age_restrict'),
            'duration' => $request->get('duration'),
        ]);

        return $this->redirect('films');
    }

    public function edit() : string
    {
        $request = $this->getRequest();
        $film = $this->filmRepository->getById($request->get('id'));

        $this->content = $this->renderView('pages.films.form', [
            'film' => $film
        ]);
        $this->title = 'Update Film ' . $film->getName();

        return $this->viewResponse();
    }

    public function update() : string
    {
        $request = $this->getRequest();

        $film = $this->filmRepository->getById($request->get('id'));
        $film->setName($request->get('name'));
        $film->setDescription($request->get('description'));
        $film->setAgeRestrict($request->get('age_restrict'));
        $film->setDuration($request->get('duration'));

        $this->filmRepository->update($film);

        return $this->redirect('films');
    }

    public function delete() : string
    {
        $request = $this->getRequest();

        $film = $this->filmRepository->getById($request->get('id'));

        $this->filmRepository->delete($film);

        return $this->redirect('films');
    }
}