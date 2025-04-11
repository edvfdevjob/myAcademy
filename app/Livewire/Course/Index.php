<?php

namespace App\Livewire\Course;

use Livewire\Component;
use App\Models\Course;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';

    public $showModal = false;
    public $courseId = null;
    protected $updatesQueryString = ['search'];
    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $courses = Course::query()
            ->when($this->search, fn($query) =>
                $query->where('name', 'like', '%'.$this->search.'%')
            )
            ->paginate(6);

        return view('livewire.course.index', compact('courses'));
    }

    public function delete($id)
    {
        if($id){
            $course = Course::findOrFail($id);
            $course->delete();
            toastr()->success('Has eliminado un curso con exito', ' ');
        }
    }

    public function openModal($courseId)
    {
        $this->courseId = $courseId;
        $this->showModal = true;
    }
}
