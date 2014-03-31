<?php
class LinkController extends BaseController {

    public function __construct(Link $link) {
        $this->link = $link;
    }

    public function add() {
        $input = Input::all();

        $result = $this->link->addLink($input);

        return Response::json($result);
    }

    public function report() {
        $id = Input::get('id');

        $result = $this->link->reportLink($id);

        return Response::json($result);
    }

    public function getDetail($id) {
        $result = $this->link->getDetail($id);

        return Response::json($result);
    }
}