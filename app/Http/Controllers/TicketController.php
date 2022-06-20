<?php

namespace App\Http\Controllers;

use App\Classes\TicketManagement;
use App\Classes\UserManagement;
use App\Models\Todo;
use Illuminate\Http\Request;

class TicketController extends Controller {
    private $ticketManagement;

    public function __construct(TicketManagement $ticketManagement) {
        $this->ticketManagement = $ticketManagement;
    }

    public function createCategories(Request $request) {
        return $this->ticketManagement->createCategory($request->all());
    }

    public function categories() {
        return $this->ticketManagement->categories();
    }

    public function createUser(Request $request) {
        return $this->ticketManagement->createUser($request->all());
    }


    public function all() {
        return $this->ticketManagement->allUser();
    }

    public function todoCreate(Request $request) {
        return Todo::create([
           "todo" => $request->todo
        ]);
    }

    public function todoAll() {
        return Todo::all();
    }

    public function deleteTo($todoId) {
        return Todo::where('id', $todoId)->delete();
    }

    public function starTod($todoId) {
        $todo = Todo::where('id', $todoId)->first();
        return Todo::where('id', $todoId)->update([
            "starred" => !$todo->starred
        ]);
    }
}
