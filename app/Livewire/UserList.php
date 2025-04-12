<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    #[Url]
    public int $limit = 5;

    public array $limitList = [5, 8, 10, 25, 50, 100];

    #[Url]
    public string $search = '';

    public function mount()
    {
        if(!in_array($this->limit, $this->limitList)) {
            $this->redirectRoute('users');
        }
    }
    public function updating($property, $value)
    {
        if($property == 'search') {
            $this->resetPage();
        }
//        dump($property, $value);
    }
    public function changeLimit(int $limit)
    {
        $this->limit = in_array($limit, $this->limitList) ? $limit : $this->limitList[0];
        $this->resetPage();
    }

    public function deleteUser(int $id)
    {
        User::query()->findOrFail($id)->delete();
    }
    public function render()
    {
        return view('livewire.user-list', [
            'users' => User::query()->with('country')
                ->where('name', 'LIKE', "%{$this->search}%")
                ->orWhere('email', 'LIKE', "%{$this->search}%")
                ->orWhere('id', 'LIKE', "%{$this->search}%")
                ->orWhereHas('country', function ($query) {
                    $query->where('name', 'LIKE', "%{$this->search}%");
                })->paginate($this->limit)
        ]);
    }
}
