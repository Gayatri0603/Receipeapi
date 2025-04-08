<?php
namespace Src\Controller;

use Src\Model\RecipeModel;

class RecipeController {
    private $model;

    public function __construct() {
        $this->model = new RecipeModel();
    }

    public function list() {
        echo json_encode($this->model->getAll());
    }

    public function create() {
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($this->model->create($data));
    }

    public function get($id) {
        echo json_encode($this->model->find($id));
    }

    public function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($this->model->update($id, $data));
    }

    public function delete($id) {
        echo json_encode($this->model->delete($id));
    }

    public function rate($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        echo json_encode($this->model->rate($id, $data['score']));
    }

    public function search($query) {
        echo json_encode($this->model->search($query));
    }
}
