<?php

namespace Antidote\LaravelForm\Http\Livewire;

use Antidote\LaravelForm\Events\EnquirySentEvent;
use Antidote\LaravelForm\Models\Enquiry;
use Antidote\LaravelForm\Notifications\EnquiryEmailNotification;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Livewire\Component;

class Form extends Component implements HasForms
{
    use InteractsWithForms;

    public $form_id;

    public $submitted_data = [];

    public function mount(int $form_id)
    {
        if($form = \Antidote\LaravelForm\Models\Form::find($form_id)) {
            $this->form_id = $form_id;
            $this->fields = $form->fields;

            //set keys of values array
            foreach($this->fields as $field) {
               $this->submitted_data[$field->name] = null;
            }
        } else {
            throw new \Exception('form does not exist');
        }
    }

    protected function getFormSchema(): array
    {
        $fields = [];

        foreach($this->fields as $field) {
            $fields[] = $field->field_type::getFilamentField($field);
        }

        return $fields;
    }

    public function submit()
    {
//        $enquiry = Enquiry::create([
//            'form_id' => $this->form_id,
//            'data' => $this->submitted_data
//        ]);

        \Antidote\LaravelForm\Models\Form::find($this->form_id)->send($this->submitted_data);

        \Filament\Notifications\Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();

//        Event::dispatch(new EnquirySentEvent(\Antidote\LaravelForm\Models\Form::find($this->form_id), $enquiry));

//        Notification::route('mail', 'info@titan21.co.uk')
//            ->notify(new EnquiryEmailNotification(\Antidote\LaravelForm\Models\Form::find($this->form_id), $enquiry));
    }

    public function render() : View
    {
        return view('laravel-form::livewire.form');
    }
}